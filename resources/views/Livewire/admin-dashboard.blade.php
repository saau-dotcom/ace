<div class="flex flex-col w-full h-full space-y-8">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-zinc-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 tracking-tight">System Performance</h2>
            <p class="text-xs text-zinc-500 mt-1">Real-time solar metrics and operational pipeline control.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="h-9 px-4 bg-zinc-100 hover:bg-zinc-200 text-zinc-900 border border-zinc-200 rounded-md text-xs font-semibold shadow-sm transition-all flex items-center gap-2">
                <i class="ph ph-arrow-clockwise text-sm text-zinc-600"></i>
                Sync Data
            </button>
            <button class="h-9 px-4 bg-zinc-900 hover:bg-zinc-800 text-white rounded-md text-xs font-semibold shadow-sm transition-all flex items-center gap-2">
                <i class="ph ph-plus text-sm"></i>
                New Installation
            </button>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Metric Box -->
        <div class="bg-white p-6 rounded-md border border-zinc-200 shadow-sm relative overflow-hidden group hover:border-zinc-400 transition-all">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">Total Pipeline</p>
                    <i class="ph ph-users text-zinc-400"></i>
                </div>
                <h3 class="text-3xl font-bold text-zinc-900 mb-1">{{ $stats['total_leads'] }}</h3>
                <p class="text-[10px] text-zinc-400 font-medium">+12.5% vs last month</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-md border border-zinc-200 shadow-sm relative overflow-hidden group hover:border-zinc-400 transition-all">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">Deals Closed</p>
                    <i class="ph ph-handshake text-zinc-400"></i>
                </div>
                <h3 class="text-3xl font-bold text-zinc-900 mb-1">{{ $stats['sold_leads'] }}</h3>
                <p class="text-[10px] text-zinc-400 font-medium">84% conversion rate</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-md border border-zinc-200 shadow-sm relative overflow-hidden group hover:border-zinc-400 transition-all">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">Est. Revenue</p>
                    <i class="ph ph-currency-circle-dollar text-zinc-400"></i>
                </div>
                <h3 class="text-3xl font-bold text-zinc-900 mb-1">${{ number_format($stats['est_revenue']) }}</h3>
                <p class="text-[10px] text-zinc-400 font-medium">+5.2% from forecast</p>
            </div>
        </div>

        <div class="bg-zinc-900 p-6 rounded-md border border-zinc-900 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-[11px] font-semibold text-zinc-300 uppercase tracking-wider">Active Installs</p>
                    <i class="ph ph-lightning text-zinc-400"></i>
                </div>
                <h3 class="text-3xl font-bold text-white mb-1">{{ $stats['active_jobs'] }}</h3>
                <p class="text-[10px] text-zinc-400 font-medium">3 jobs starting today</p>
            </div>
        </div>
    </div>

    <!-- Middle Complex Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Live Chart Area -->
        <div class="lg:col-span-2 bg-white rounded-md border border-zinc-200 p-8 flex flex-col" x-data="chartWidget()">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900">Sales Trajectory</h3>
                    <p class="text-xs text-zinc-500 mt-0.5">Total system power (kW) sold this period</p>
                </div>
                <div class="flex gap-2 p-1 bg-zinc-50 border border-zinc-200 rounded-md">
                    <button class="px-3 py-1 text-[11px] font-semibold rounded bg-white text-zinc-900 shadow-sm">Weekly</button>
                    <button class="px-3 py-1 text-[11px] font-semibold rounded text-zinc-500 hover:text-zinc-900">Monthly</button>
                </div>
            </div>
            <div class="flex-1 relative w-full h-[300px]">
                <canvas id="kwSalesChart"></canvas>
            </div>
        </div>

        <!-- STC Calculator (shadcn/ui style) -->
        <div class="bg-white border border-zinc-200 shadow-sm rounded-md p-8 text-zinc-900 flex flex-col" 
             x-data="{ kw: 6.6, zone: 3, zones: { 1: 1.622, 2: 1.536, 3: 1.382, 4: 1.185 }, deeming: 5, get stc() { return Math.floor(this.kw * this.zones[this.zone] * this.deeming) } }">
            
            <h3 class="text-sm font-semibold text-zinc-900 mb-6 flex items-center gap-2">
                <i class="ph ph-calculator text-lg text-zinc-500"></i>
                STC Estimator (2026)
            </h3>
            
            <div class="space-y-8 relative z-10 flex-1">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-xs text-zinc-500 font-semibold uppercase tracking-wider">System Size (kW)</label>
                        <span class="text-zinc-900 text-sm font-bold" x-text="kw + ' kW'"></span>
                    </div>
                    <input type="range" x-model.number="kw" min="1" max="100" step="0.1" class="w-full h-1.5 bg-zinc-100 rounded-lg appearance-none cursor-pointer accent-zinc-900">
                </div>
                
                <div>
                    <label class="block text-xs text-zinc-500 font-semibold uppercase tracking-wider mb-3">Install Zone</label>
                    <div class="grid grid-cols-4 gap-2">
                        <template x-for="z in [1, 2, 3, 4]">
                            <button @click="zone = z" 
                                    :class="zone === z ? 'bg-zinc-900 text-white border-zinc-900' : 'bg-white border-zinc-200 text-zinc-500 hover:bg-zinc-50'"
                                    class="py-2 text-[11px] font-bold border rounded-md transition-all">
                                Z<span x-text="z"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <div class="p-6 bg-zinc-50 border border-zinc-200 rounded-md mt-auto">
                    <p class="text-[11px] text-zinc-500 uppercase tracking-wider font-semibold mb-1">Estimated Claims</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-bold tracking-tighter text-zinc-900" x-text="stc"></span>
                        <span class="text-xs text-zinc-500 font-medium">Certificates</span>
                    </div>
                    <button class="w-full mt-6 bg-zinc-900 text-white h-9 rounded-md text-xs font-semibold shadow-sm hover:bg-zinc-800 transition-all">Apply to Lead</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Widgets Layer -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Last Updated Leads Widget -->
        <div class="lg:col-span-2 bg-white rounded-md border border-zinc-200 p-8 shadow-sm">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-zinc-100">
                <h3 class="text-sm font-semibold text-zinc-900 italic">Recently Updated Pipelines</h3>
                <a href="/leads" class="text-xs text-zinc-500 font-medium hover:text-zinc-900 underline underline-offset-4 decoration-zinc-200">View All</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($recentLeads as $lead)
                    <div class="flex items-center justify-between p-4 border border-zinc-100 rounded-md hover:border-zinc-300 transition-all group cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div class="h-9 w-9 bg-zinc-50 border border-zinc-200 rounded-md flex items-center justify-center font-bold text-xs text-zinc-600 uppercase">
                                {{ substr($lead->first_name, 0, 1) }}{{ substr($lead->last_name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-zinc-900">{{ $lead->first_name }} {{ $lead->last_name }}</h4>
                                <p class="text-[11px] text-zinc-500 font-medium">{{ str_replace('_', ' ', strtoupper($lead->status)) }} • {{ $lead->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <i class="ph ph-arrow-up-right text-zinc-300 group-hover:text-zinc-900 transition-colors"></i>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-6 text-zinc-400">
                        <p class="text-xs font-semibold uppercase tracking-wider">No recent leads found.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Weather / Agenda Widget Combination -->
        <div class="flex flex-col gap-6">
            <!-- Sydney Weather -->
            <div class="bg-white border border-zinc-200 rounded-md p-6 flex items-center justify-between shadow-sm">
                <div>
                    <h4 class="text-[11px] font-semibold text-zinc-500 uppercase tracking-wider mb-2">{{ $weatherCity }} Forecast</h4>
                    <div class="flex items-center gap-3">
                        <span class="text-3xl font-bold tracking-tighter text-zinc-900">22°C</span>
                        <span class="px-2 py-0.5 bg-zinc-100 text-zinc-600 text-[10px] font-semibold rounded border border-zinc-200">HUMIDITY 64%</span>
                    </div>
                </div>
                <i class="ph ph-cloud-sun text-4xl text-zinc-300"></i>
            </div>

            <!-- Daily Agenda -->
            <div class="flex-1 bg-white border border-zinc-200 rounded-md p-8 flex flex-col shadow-sm">
                <h3 class="text-sm font-semibold text-zinc-900 mb-6 border-b border-zinc-100 pb-4">Today's Agenda</h3>
                <div class="flex-1 flex flex-col items-center justify-center py-6 text-center">
                    <div class="h-12 w-12 bg-zinc-50 border border-zinc-100 rounded-full flex items-center justify-center mb-4">
                        <i class="ph ph-coffee text-2xl text-zinc-300"></i>
                    </div>
                    <p class="text-xs font-semibold text-zinc-900">Inbox Zero</p>
                    <p class="text-[11px] text-zinc-500 mt-1">No follow-up tasks scheduled for today.</p>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Chart.js Injection -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('chartWidget', () => ({
                init() {
                    const ctx = document.getElementById('kwSalesChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                            datasets: [{
                                label: 'kW Sold',
                                data: [15, 22, 10, 45, 30, 20, 60], 
                                borderColor: '#18181b', // Zinc-900
                                backgroundColor: 'transparent',
                                borderWidth: 2,
                                tension: 0.1,
                                fill: false,
                                pointBackgroundColor: '#18181b',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: '#f4f4f5', drawBorder: false },
                                    ticks: { font: { family: 'Inter', size: 10, weight: '500' }, color: '#a1a1aa' }
                                },
                                x: {
                                    grid: { display: false, drawBorder: false },
                                    ticks: { font: { family: 'Inter', size: 10, weight: '500' }, color: '#a1a1aa' }
                                }
                            }
                        }
                    });
                }
            }));
        });
    </script>
</div>
