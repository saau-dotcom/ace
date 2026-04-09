<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Lead;
use Carbon\Carbon;

#[Title('Dashboard - Solar ACE')]
class AdminDashboard extends Component
{
    public $weatherCity = 'Sydney'; // For simple weather widget

    public function render()
    {
        // Simple Real Data Compilation
        $totalLeads = Lead::count();
        $soldLeads = Lead::where('status', 'Sold')->count();
        
        // Sum the kW size from leads that have a given system size
        // Since system_size_kw might be a string like "10kW", we cast it if needed, or if it's int, we just sum
        $soldKwSum = Lead::where('status', 'Sold')->sum('system_size_kw') ?? 0;
        
        // Active install jobs placeholder (leads in 'Job Date Scheduled')
        $activeJobs = Lead::where('status', 'Job Date Scheduled')->count();
        
        // Est Revenue: Rough metric = sold kW * $1000 per kW avg
        $estRevenue = $soldKwSum * 1000;

        // Fetch recent activities across system
        $recentLeads = Lead::orderBy('updated_at', 'desc')->take(4)->get();

        return view('livewire.admin-dashboard', [
            'stats' => [
                'total_leads' => $totalLeads,
                'sold_leads'  => $soldLeads,
                'active_jobs' => $activeJobs,
                'est_revenue' => $estRevenue,
                'sold_kw'     => $soldKwSum
            ],
            'recentLeads' => $recentLeads
        ]);
    }
}
