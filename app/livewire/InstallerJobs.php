<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\LeadTask;

class InstallerJobs extends Component
{
    public $search = '';

    public function deleteJob($id)
    {
        LeadTask::findOrFail($id)->delete();
    }

    public function render()
    {
        $jobs = LeadTask::where('title', 'Installation Scheduled')
                        ->with(['lead', 'user'])
                        ->when($this->search, function($query) {
                            $query->whereHas('lead', function($q) {
                                $q->where('address', 'like', '%'.$this->search.'%')
                                  ->orWhere('first_name', 'like', '%'.$this->search.'%')
                                  ->orWhere('last_name', 'like', '%'.$this->search.'%');
                            });
                        })
                        ->orderBy('due_date', 'asc')
                        ->get();

        return view('livewire.installer-jobs', [
            'jobs' => $jobs
        ]);
    }
}
