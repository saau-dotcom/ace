<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use App\Models\Lead;
use App\Models\User;
use App\Models\EquipmentProduct;
use App\Models\LeadDocument;

#[Title('Leads Manager - Solar ACE')]
class AdminLeadsManager extends Component
{
    use WithFileUploads;

    public $leads = [];
    public $agents = [];
    public $showAddLeadModal = false;
    public $filterStatus = '';
    
    // Quick Edit Status Fields
    public $showEditStatusModal = false;
    public $editingLeadId = null;
    public $editingLeadStatus = '';
    public $jobScheduledDate = '';

    // Form fields
    public $first_name, $last_name, $email, $phone, $address, $suburb, $post_code;
    public $service_type, $lead_source, $existing_system_installed = false, $requirements;
    public $battery_model, $inverter_model, $panel_model;
    public $assigned_user_id;
    public $status = 'New';

    // New phase 1 fields
    public $system_size_kw;
    public $battery_capacity_kwh;
    public $stc_claimable = 0;
    
    public $electricity_bill_file;
    public $property_photo_file;

    // Optional follow up scheduling
    public $follow_up_date;

    public function mount()
    {
        $this->loadData();
    }

    public function updatedFilterStatus()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $query = Lead::with(['user', 'documents', 'tasks'])->orderBy('created_at', 'desc');
        
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }
        
        $this->leads = $query->get();
        $this->agents = User::all();
    }

    public function openAddModal()
    {
        $this->resetValidation();
        $this->showAddLeadModal = true;
    }

    public function closeAddModal()
    {
        $this->showAddLeadModal = false;
    }

    // Auto-calculating STCs with 2026 data
    public function updatedSystemSizeKw() { $this->calculateSTC(); }
    public function updatedPostCode() { $this->calculateSTC(); }

    public function calculateSTC()
    {
        if (!$this->system_size_kw || !$this->post_code || strlen($this->post_code) < 3) {
            $this->stc_claimable = 0;
            return;
        }

        $pc = (int)$this->post_code;
        
        // Default Zone 3 for major populace (Sydney, Brisbane, Perth, Adelaide)
        $zone = 3; 
        $multiplier = 1.382;

        if (($pc >= 800 && $pc <= 899) || ($pc >= 4800 && $pc <= 4899)) {
            // Zone 1
            $multiplier = 1.622;
        } elseif (($pc >= 4600 && $pc <= 4799) || ($pc >= 6700 && $pc <= 6799)) {
            // Zone 2
            $multiplier = 1.536;
        } elseif (($pc >= 3000 && $pc <= 3999) || ($pc >= 7000 && $pc <= 7999)) {
            // Zone 4 (VIC, TAS)
            $multiplier = 1.185;
        }

        // 2026 Deeming Period is 5 years
        $deemingPeriod = 5; 

        // Calculation: Size * Multiplier * Deeming Period (floored)
        $this->stc_claimable = floor((float)$this->system_size_kw * $multiplier * $deemingPeriod);
    }

    public function saveLead()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'assigned_user_id' => 'required',
            'electricity_bill_file' => 'nullable|file|max:10240', // 10MB
            'property_photo_file' => 'nullable|image|max:10240',
        ]);

        $lead = Lead::create([
            'user_id' => $this->assigned_user_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'suburb' => $this->suburb,
            'post_code' => $this->post_code,
            'status' => $this->status,
            'service_type' => $this->service_type,
            'lead_source' => $this->lead_source,
            'existing_system_installed' => $this->existing_system_installed ? 1 : 0,
            'requirements' => $this->requirements,
            
            // Equipment references
            'battery_model' => $this->battery_model,
            'inverter_model' => $this->inverter_model,
            'panel_model' => $this->panel_model,
            
            // System properties
            'system_size_kw' => $this->system_size_kw,
            'battery_capacity_kwh' => $this->battery_capacity_kwh,
            'stc_claimable' => $this->stc_claimable,
        ]);

        // Write activity log
        $lead->activities()->create([
            'action' => 'Lead Created',
            'details' => 'Initial upload into CRM.',
            'user_id' => auth()->id() ?? $this->assigned_user_id,
        ]);

        // Create tasks if a follow-up is scheduled
        if ($this->status === 'Follow up' && $this->follow_up_date) {
            $lead->tasks()->create([
                'user_id' => $this->assigned_user_id,
                'title' => 'Scheduled Follow Up',
                'due_date' => $this->follow_up_date,
            ]);
        }

        // Handle Documents
        if ($this->electricity_bill_file) {
            $path = $this->electricity_bill_file->store('lead_documents', 'public');
            $lead->documents()->create([
                'title' => 'Electricity Bill',
                'type' => 'document',
                'file_path' => $path,
                'uploaded_by' => auth()->id() ?? $this->assigned_user_id,
            ]);
        }

        if ($this->property_photo_file) {
            $path = $this->property_photo_file->store('lead_documents', 'public');
            $lead->documents()->create([
                'title' => 'Property Photo',
                'type' => 'image',
                'file_path' => $path,
                'uploaded_by' => auth()->id() ?? $this->assigned_user_id,
            ]);
        }

        $this->closeAddModal();
        $this->loadData();
        $this->resetExcept('leads', 'agents');
    }

    public function openEditStatusModal($id)
    {
        $lead = Lead::findOrFail($id);
        $this->editingLeadId = $id;
        $this->editingLeadStatus = $lead->status;
        $this->jobScheduledDate = '';
        $this->showEditStatusModal = true;
    }

    public function closeEditStatusModal()
    {
        $this->showEditStatusModal = false;
        $this->editingLeadId = null;
    }

    public function saveLeadStatus()
    {
        if ($this->editingLeadId) {
            $lead = Lead::findOrFail($this->editingLeadId);
            $lead->update(['status' => $this->editingLeadStatus]);
            
            if ($this->editingLeadStatus === 'Job Date Scheduled' && $this->jobScheduledDate) {
                // Forward it to Jobs/Calendar flow via a Task / Job stub
                $lead->tasks()->create([
                    'user_id' => auth()->id() ?? $lead->user_id,
                    'title' => 'Installation Scheduled',
                    'due_date' => $this->jobScheduledDate
                ]);
            }
            
            $this->closeEditStatusModal();
            $this->loadData();
        }
    }

    public function deleteLead($id)
    {
        Lead::findOrFail($id)->delete();
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.admin-leads-manager', [
            'panels' => EquipmentProduct::where('type', 'Panel')->get(),
            'batteries' => EquipmentProduct::where('type', 'Battery')->get(),
            'inverters' => EquipmentProduct::where('type', 'Inverter')->get(),
        ]);
    }
}
