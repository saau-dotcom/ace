<div class="flex flex-col w-full h-full space-y-8" x-data="{ view: 'list', showModal: false }">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-zinc-200">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 tracking-tight">Project Logistics</h2>
            <p class="text-xs font-medium text-zinc-500 mt-1 uppercase tracking-wider">Installation Board & Crew Resource Management</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="inline-flex p-1 bg-zinc-100 rounded-lg border border-zinc-200">
                <button @click="view = 'list'" :class="view === 'list' ? 'bg-white text-zinc-900 shadow-sm' : 'text-zinc-500 hover:text-zinc-900'" class="h-8 px-4 rounded-md text-[10px] font-bold uppercase transition-all flex items-center gap-2">
                    <i class="ph ph-list"></i> List
                </button>
                <button @click="view = 'calendar'" :class="view === 'calendar' ? 'bg-white text-zinc-900 shadow-sm' : 'text-zinc-500 hover:text-zinc-900'" class="h-8 px-4 rounded-md text-[10px] font-bold uppercase transition-all flex items-center gap-2">
                    <i class="ph ph-calendar"></i> Calendar
                </button>
            </div>
            <button @click="showModal = true" class="h-9 px-5 bg-zinc-900 hover:bg-zinc-800 text-white rounded-md text-xs font-bold shadow-sm transition-all flex items-center gap-2">
                <i class="ph ph-plus text-sm"></i>
                Schedule Dispatch
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-md p-6 border border-zinc-200 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between mb-4">
                <div class="h-8 w-8 bg-zinc-100 rounded-md flex items-center justify-center">
                    <i class="ph ph-truck text-zinc-600"></i>
                </div>
                <span class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">Live</span>
            </div>
            <p class="text-[10px] uppercase font-bold tracking-widest text-zinc-400">Active Dispatches</p>
            <h3 class="text-3xl font-bold text-zinc-900 mt-1">4</h3>
            <div class="mt-4 text-[10px] text-zinc-400 font-medium">Daily deployment queue</div>
        </div>
        <div class="bg-white rounded-md p-6 border border-zinc-200 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between mb-4">
                <div class="h-8 w-8 bg-zinc-100 rounded-md flex items-center justify-center">
                    <i class="ph ph-calendar-check text-zinc-600"></i>
                </div>
            </div>
            <p class="text-[10px] uppercase font-bold tracking-widest text-zinc-400">Total Week</p>
            <h3 class="text-3xl font-bold text-zinc-900 mt-1">12</h3>
            <div class="mt-4 text-[10px] text-zinc-400 font-medium">+2 from last week</div>
        </div>
        <div class="bg-white rounded-md p-6 border border-zinc-200 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between mb-4">
                <div class="h-8 w-8 bg-red-50 rounded-md flex items-center justify-center">
                    <i class="ph ph-warning text-red-600"></i>
                </div>
            </div>
            <p class="text-[10px] uppercase font-bold tracking-widest text-zinc-400">Logistical Friction</p>
            <h3 class="text-3xl font-bold text-red-600 mt-1">1</h3>
            <div class="mt-4 text-[10px] text-zinc-400 font-medium">Requires immediate agent review</div>
        </div>
    </div>

    <!-- Active Jobs Table -->
    <div x-show="view === 'list'" class="bg-white rounded-md border border-zinc-200 shadow-sm overflow-hidden flex flex-col">
        <div class="px-6 py-5 border-b border-zinc-200 bg-zinc-50/50 flex items-center justify-between gap-4">
            <h3 class="text-xs font-bold text-zinc-900 uppercase tracking-widest">Deployment Schedule</h3>
            <div class="relative w-72">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400"></i>
                <input type="text" wire:model.live="search" placeholder="Filter site or technician..." class="w-full pl-9 pr-3 py-1.5 text-xs bg-white border border-zinc-200 rounded-md focus:outline-none focus:ring-1 focus:ring-zinc-900 text-zinc-900 font-medium placeholder:font-normal">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50/30 border-b border-zinc-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Entry Date</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Client & Geography</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Spec</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Lead Technician</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-zinc-500 uppercase tracking-widest text-right">MGMT</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($jobs as $job)
                    <tr class="hover:bg-zinc-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="text-xs font-bold text-zinc-900">{{ $job->due_date ? $job->due_date?->format('M d, Y') : 'TBD' }}</div>
                            <div class="text-[10px] font-semibold text-zinc-400 mt-1 uppercase">Standard Window</div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('leads.show', $job->lead->id) }}" class="text-xs font-bold text-zinc-900 hover:underline">{{ $job->lead->first_name }} {{ $job->lead->last_name }}</a>
                            <div class="text-[10px] font-semibold text-zinc-400 mt-1 uppercase tracking-tight">{{ $job->lead->address ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-zinc-100 text-zinc-900 border border-zinc-200">{{ $job->lead->system_size_kw ?? 0 }}kW RIG</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold {{ $job->user ? 'text-zinc-900' : 'text-zinc-400 italic' }}">
                            {{ $job->user->name ?? 'Awaiting Crew' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($job->is_completed)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[9px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-full">
                                    <span class="w-1 h-1 rounded-full bg-emerald-700"></span>
                                    DEPLOYED
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[9px] font-bold text-zinc-600 bg-zinc-50 border border-zinc-200 rounded-full">
                                    <span class="w-1 h-1 rounded-full bg-zinc-400"></span>
                                    SCHEDULED
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button wire:click="deleteJob({{ $job->id }})" wire:confirm="Purge this dispatch record?" class="h-8 w-8 flex items-center justify-center text-zinc-400 hover:text-red-500 hover:bg-red-50 rounded-md transition-all">
                                    <i class="ph ph-trash text-base"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="h-12 w-12 bg-zinc-50 rounded-full flex items-center justify-center mb-4 mx-auto border border-zinc-100">
                                <i class="ph ph-truck text-zinc-200 text-2xl"></i>
                            </div>
                            <h5 class="text-xs font-bold text-zinc-900 uppercase tracking-widest">No Active Logistics</h5>
                            <p class="text-xs text-zinc-400 mt-1">New dispatches will appear here once scheduled in CRM.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Calendar View Placeholder -->
    <div x-show="view === 'calendar'" style="display: none;" class="bg-white rounded-md border border-zinc-200 shadow-sm p-12 text-center flex-1 flex flex-col items-center justify-center">
        <div class="h-16 w-16 bg-zinc-50 rounded-full flex items-center justify-center mb-6 border border-zinc-100">
            <i class="ph ph-calendar-blank text-3xl text-zinc-200"></i>
        </div>
        <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-widest">Dispatcher GANTT</h3>
        <p class="text-xs text-zinc-400 mt-2 max-w-sm">The temporal visualization engine is pending data stream synchronization.</p>
    </div>

    <!-- Schedule Install Modal Placeholder -->
    <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-zinc-900/40 backdrop-blur-sm">
        <div class="bg-white rounded-lg border border-zinc-200 shadow-2xl p-8 max-w-md w-full relative animate-in zoom-in duration-200" @click.away="showModal = false">
            <div class="h-10 w-10 bg-zinc-900 rounded-md flex items-center justify-center mb-6">
                <i class="ph ph-info text-white text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-zinc-900 tracking-tight">System Notification</h3>
            <p class="text-xs text-zinc-500 mt-2 leading-relaxed font-medium">Please select a Lead from the master Deals pipeline to initiate a scheduling workflow. Direct board injection is currently disabled for auditing purposes.</p>
            <div class="mt-8 flex gap-3">
                <button @click="showModal = false" class="flex-1 h-10 bg-zinc-900 hover:bg-zinc-800 text-white rounded-md text-[10px] font-bold uppercase tracking-widest transition-all">
                    System Acknowledgement
                </button>
            </div>
        </div>
    </div>

</div>
