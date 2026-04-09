<div class="flex flex-col w-full h-full bg-[#fafafa] p-8 space-y-8 font-sans">
    <style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-zinc-200 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 tracking-tight">Leads & Deals</h2>
            <p class="text-sm text-zinc-400 mt-1 font-medium">Manage and track your customer pipeline and installation status.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <button class="h-9 px-4 bg-white border border-zinc-200 text-zinc-600 hover:bg-zinc-50 rounded-md text-xs font-semibold transition-colors flex items-center justify-center gap-2 shadow-sm">
                <i class="ph ph-export"></i>
                Export CSV
            </button>
            <button wire:click="openAddModal" class="h-9 px-4 bg-zinc-900 hover:bg-zinc-800 text-white rounded-md text-xs font-semibold shadow-sm transition-all flex items-center justify-center gap-2">
                <i class="ph ph-plus text-base"></i>
                Add Lead
            </button>
        </div>
    </div>

    <!-- Leads Filter & Table Container -->
    <div class="flex flex-col w-full space-y-4">
        
        <!-- Filters Area -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center p-1 bg-zinc-100 border border-zinc-200 rounded-lg w-fit overflow-hidden">
                @php
                    $pipelineStatuses = ['All', 'New', 'In Queue', 'Waiting for Payments', 'Job Date Scheduled', 'Sold'];
                @endphp
                @foreach($pipelineStatuses as $status)
                    @php
                        $isActive = ($filterStatus === $status) || ($filterStatus === '' && $status === 'All');
                    @endphp
                    <button 
                        wire:click="$set('filterStatus', '{{ $status === 'All' ? '' : $status }}')"
                        class="px-4 py-1.5 text-xs font-semibold transition-all rounded-md {{ $isActive ? 'bg-white text-zinc-900 shadow-sm' : 'text-zinc-500 hover:text-zinc-900' }}"
                    >
                        {{ $status }}
                    </button>
                @endforeach
            </div>

            <div class="relative w-full sm:w-[300px]">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 text-base"></i>
                <input type="text" placeholder="Filter by name or email..." class="w-full pl-10 pr-4 py-2 text-xs bg-white border border-zinc-200 rounded-md focus:border-zinc-900 focus:ring-0 transition-all text-zinc-900 font-medium placeholder-zinc-400 shadow-sm">
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-md border border-zinc-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left text-xs whitespace-nowrap">
                    <thead>
                        <tr class="bg-zinc-50/50 border-b border-zinc-200">
                            <th class="px-6 py-4 font-semibold text-zinc-500 uppercase tracking-wider">Lead Details</th>
                            <th class="px-6 py-4 font-semibold text-zinc-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 font-semibold text-zinc-500 uppercase tracking-wider">Pipeline Stage</th>
                            <th class="px-6 py-4 font-semibold text-zinc-500 uppercase tracking-wider">Tags</th>
                            <th class="px-6 py-4 font-semibold text-zinc-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @forelse($leads as $lead)
                            <tr class="hover:bg-zinc-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="h-8 w-8 rounded-md bg-zinc-100 flex items-center justify-center text-[10px] font-bold text-zinc-500 border border-zinc-200 uppercase">
                                            {{ substr($lead->first_name, 0, 1) }}{{ substr($lead->last_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('leads.show', $lead->id) }}" class="text-sm font-semibold text-zinc-900 hover:underline underline-offset-4 decoration-zinc-200">
                                                {{ $lead->first_name }} {{ $lead->last_name }}
                                            </a>
                                            <div class="text-[10px] text-zinc-400 mt-0.5">{{ $lead->suburb ?? 'Generic AU suburb' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-zinc-900 font-medium">{{ $lead->email }}</div>
                                    <div class="text-zinc-400 mt-0.5 text-[11px]">{{ $lead->phone ? '+61 ' . $lead->phone : 'No phone' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'New' => 'bg-zinc-100 text-zinc-800 border-zinc-200',
                                            'Sold' => 'bg-zinc-900 text-white border-zinc-900',
                                            'In Queue' => 'bg-blue-50 text-blue-700 border-blue-100',
                                            'Waiting for Payments' => 'bg-amber-50 text-amber-700 border-amber-100',
                                            'Job Date Scheduled' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                            'Not Interested' => 'bg-red-50 text-red-700 border-red-100',
                                            'Cancelled' => 'bg-red-50 text-red-700 border-red-100',
                                        ];
                                        $colorClass = $statusColors[$lead->status] ?? 'bg-zinc-100 text-zinc-800 border-zinc-200';
                                    @endphp
                                    <button wire:click="openEditStatusModal({{ $lead->id }})" class="inline-flex items-center px-2 py-0.5 rounded border text-[10px] font-bold tracking-tight uppercase transition-all hover:bg-zinc-100 {{ $colorClass }}">
                                        {{ $lead->status }}
                                    </button>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5 overflow-hidden">
                                        <span class="px-2 py-0.5 bg-zinc-50 border border-zinc-100 text-zinc-400 rounded text-[9px] font-bold uppercase tracking-wider">{{ $lead->lead_source ?? 'WEB' }}</span>
                                        @if($lead->existing_system_installed)
                                            <span class="px-2 py-0.5 bg-zinc-50 border border-zinc-100 text-zinc-400 rounded text-[9px] font-bold uppercase tracking-wider">UPGRADE</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button class="h-7 w-7 flex items-center justify-center rounded-md text-zinc-400 hover:text-zinc-900 hover:bg-zinc-100 transition-colors">
                                            <i class="ph ph-phone text-base"></i>
                                        </button>
                                        <button wire:click="deleteLead({{ $lead->id }})" wire:confirm="Are you sure?" class="h-7 w-7 flex items-center justify-center rounded-md text-zinc-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                            <i class="ph ph-trash text-base"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-24 text-center">
                                    <div class="flex flex-col items-center justify-center opacity-40">
                                        <div class="h-12 w-12 bg-zinc-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="ph ph-users-three text-3xl"></i>
                                        </div>
                                        <p class="text-[11px] font-bold uppercase tracking-widest">No active leads in this stage.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50/30 flex items-center justify-between">
                <p class="text-[10px] text-zinc-500 font-medium">Showing {{ $leads->count() }} results in current pipeline</p>
                <div class="flex gap-2">
                    <button class="h-8 px-3 border border-zinc-200 rounded-md text-[11px] font-semibold bg-white text-zinc-400 cursor-not-allowed">Previous</button>
                    <button class="h-8 px-3 border border-zinc-200 rounded-md text-[11px] font-semibold bg-white text-zinc-900 hover:bg-zinc-50 transition-colors shadow-sm">Next Page</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Slides-over Add Lead Panel -->
    @if($showAddLeadModal)
        <div class="fixed inset-0 z-50 overflow-hidden flex justify-end">
            <div class="absolute inset-0 bg-zinc-950/20 backdrop-blur-[2px] transition-opacity" wire:click="closeAddModal"></div>

            <div class="relative w-screen max-w-md flex flex-col h-full bg-white shadow-2xl border-l border-zinc-200 animate-in slide-in-from-right duration-300">
                <!-- Panel Header -->
                <div class="px-6 py-6 border-b border-zinc-100 flex items-center justify-between shrink-0">
                    <div>
                        <h2 class="text-lg font-bold text-zinc-900 tracking-tight">New Lead Entry</h2>
                        <p class="text-[11px] text-zinc-400 font-medium mt-1">Fill out the form below to create a new prospect.</p>
                    </div>
                    <button wire:click="closeAddModal" class="h-8 w-8 rounded-md flex items-center justify-center text-zinc-400 hover:text-zinc-900 hover:bg-zinc-100 transition-colors">
                        <i class="ph ph-x text-lg"></i>
                    </button>
                </div>

                <!-- Scrollable Body -->
                <div class="flex-1 overflow-y-auto p-6 space-y-8">
                    <form wire:submit.prevent="saveLead" id="create-lead-form" class="space-y-8">
                        <div>
                            <h3 class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-4">Pipeline Details</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-xs font-semibold text-zinc-700 mb-2">Assignee</label>
                                    <select wire:model="assigned_user_id" class="w-full bg-white border border-zinc-200 rounded-md px-3 py-2 text-xs font-medium focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all outline-none">
                                        <option value="">Select Agent...</option>
                                        @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-zinc-700 mb-2">Stage</label>
                                    <select wire:model="status" class="w-full bg-white border border-zinc-200 rounded-md px-3 py-2 text-xs font-medium focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all outline-none">
                                        <option value="New">New</option>
                                        <option value="In Queue">In Queue</option>
                                        <option value="Sold">Sold</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-zinc-700 mb-2">Source</label>
                                    <select wire:model="lead_source" class="w-full bg-white border border-zinc-200 rounded-md px-3 py-2 text-xs font-medium focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all outline-none">
                                        <option value="FB">Facebook</option>
                                        <option value="Web">Website</option>
                                        <option value="Referral">Referral</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-4">Contact Information</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-700 mb-2">First Name</label>
                                        <input type="text" wire:model="first_name" class="w-full bg-white border border-zinc-200 rounded-md px-3 py-2 text-xs font-medium focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-700 mb-2">Last Name</label>
                                        <input type="text" wire:model="last_name" class="w-full bg-white border border-zinc-200 rounded-md px-3 py-2 text-xs font-medium focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all outline-none">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-zinc-700 mb-2">Email</label>
                                    <input type="email" wire:model="email" class="w-full bg-white border border-zinc-200 rounded-md px-3 py-2 text-xs font-medium focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-zinc-700 mb-2">Phone</label>
                                    <input type="text" wire:model="phone" class="w-full bg-white border border-zinc-200 rounded-md px-3 py-2 text-xs font-medium focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all outline-none" placeholder="04XX XXX XXX">
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-4">Location</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-zinc-700 mb-2">Address Search</label>
                                    <input type="text" wire:model="address" class="w-full bg-white border border-zinc-200 rounded-md px-3 py-2 text-xs font-medium focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all outline-none" placeholder="Start typing...">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-700 mb-2">Suburb</label>
                                        <input type="text" wire:model="suburb" class="w-full bg-white border border-zinc-200 rounded-md px-3 py-2 text-xs font-medium focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-zinc-700 mb-2">Post Code</label>
                                        <input type="text" wire:model="post_code" class="w-full bg-white border border-zinc-200 rounded-md px-3 py-2 text-xs font-medium focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 border-t border-zinc-100 flex gap-3 justify-end items-center bg-zinc-50/50 shrink-0">
                    <button wire:click="closeAddModal" class="h-9 px-4 rounded-md text-xs font-semibold text-zinc-500 hover:text-zinc-900 hover:bg-white transition-colors">
                        Cancel
                    </button>
                    <button type="submit" form="create-lead-form" class="h-9 px-6 bg-zinc-900 hover:bg-zinc-800 text-white rounded-md text-xs font-bold shadow-sm transition-all">
                        Create Record
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Status Edit Modal -->
    @if($showEditStatusModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-zinc-950/20 backdrop-blur-[2px]" wire:click="closeEditStatusModal"></div>
            <div class="relative bg-white border border-zinc-200 rounded-lg shadow-2xl p-8 max-w-sm w-full animate-in zoom-in duration-200">
                <h3 class="text-sm font-bold text-zinc-900 mb-1">Update Status</h3>
                <p class="text-[11px] text-zinc-500 mb-6">Transition this lead to a new stage in the pipeline.</p>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Stage</label>
                        <select wire:model.live="editingLeadStatus" class="w-full bg-zinc-50 border border-zinc-200 rounded-md px-3 py-2 text-xs font-semibold focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all outline-none">
                            <option value="New">New</option>
                            <option value="In Queue">In Queue</option>
                            <option value="Waiting for Payments">Waiting for Payments</option>
                            <option value="Job Date Scheduled">Job Date Scheduled</option>
                            <option value="Sold">Sold</option>
                        </select>
                    </div>

                    @if($editingLeadStatus === 'Job Date Scheduled')
                    <div class="p-4 bg-zinc-50 border border-zinc-200 rounded-md animate-in slide-in-from-top-2">
                        <label class="block text-[10px] font-bold text-zinc-600 mb-2 uppercase">Scheduled Date</label>
                        <input type="date" wire:model="jobScheduledDate" class="w-full bg-white border border-zinc-200 rounded-md px-3 py-2 text-xs font-medium focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 outline-none">
                    </div>
                    @endif
                </div>

                <div class="mt-8 flex gap-3 justify-end">
                    <button wire:click="closeEditStatusModal" class="h-9 px-4 rounded-md text-xs font-semibold text-zinc-500 hover:text-zinc-900 transition-colors">Cancel</button>
                    <button wire:click="saveLeadStatus" class="h-9 px-6 bg-zinc-900 text-white rounded-md text-xs font-bold shadow-sm hover:bg-zinc-800 transition-all focus:ring-2 focus:ring-zinc-200">Save Changes</button>
                </div>
            </div>
        </div>
    @endif
</div>
