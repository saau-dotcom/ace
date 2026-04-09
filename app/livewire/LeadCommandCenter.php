<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Lead;

class LeadCommandCenter extends Component
{
    use WithFileUploads;

    // This "holds" the customer data (John Smith)
    public Lead $lead;
    public string $activeTab = 'history';
    public $newStatus;
    
    // File Uploader
    public $newDocument;
    public $documentTitle;

    public function mount(Lead $lead)
    {
        $this->lead = $lead;
        $this->newStatus = $lead->status;
    }

    public function updatedNewStatus()
    {
        $this->lead->update(['status' => $this->newStatus]);
        if ($this->newStatus === 'Job Date Scheduled') {
            // Demo logic to "add to calendar"
            $this->lead->tasks()->create([
                'title' => 'Installation Scheduled',
                'due_date' => now()->addDays(5)
            ]);
        }
    }

    public function setTab($tabName)
    {
        $this->activeTab = $tabName;
    }

    public function completeTask($taskId)
    {
        $task = $this->lead->tasks()->find($taskId);
        if ($task) {
            $task->update(['is_completed' => true]);
            $this->lead->refresh();
        }
    }

    public function uploadDocument()
    {
        $this->validate([
            'newDocument' => 'required|file|max:10240', // 10MB Limit
            'documentTitle' => 'nullable|string|max:255'
        ]);

        $path = $this->newDocument->store('lead_documents', 'public');
        
        $isImage = in_array($this->newDocument->extension(), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'heic']);

        $this->lead->documents()->create([
            'title' => $this->documentTitle ?? 'Uploaded File',
            'type' => $isImage ? 'image' : 'document',
            'file_path' => $path,
            'uploaded_by' => auth()->id() ?? $this->lead->user_id,
        ]);

        $this->reset('newDocument', 'documentTitle');
        $this->lead->refresh();
    }

    // This renders the visual part of the component
    public function render()
    {
        return view('livewire.lead-command-center')
               ->layout('layouts.app');
    }
}