<div class="flex flex-col w-full h-full space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-zinc-200 gap-4">
        <div class="w-full sm:w-auto">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-1">
                <div class="flex items-center gap-3">
                    <a href="{{ route('leads.index') }}" class="h-8 w-8 flex items-center justify-center rounded-md border border-zinc-200 bg-white text-zinc-500 hover:text-zinc-900 hover:bg-zinc-50 transition-all">
                        <i class="ph ph-arrow-left text-lg"></i>
                    </a>
                    <h2 class="text-2xl font-bold text-zinc-900 tracking-tight">
                        {{ $lead->first_name }} {{ $lead->last_name }}
                    </h2>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest bg-zinc-100 px-2 py-0.5 rounded border border-zinc-200">#{{ $lead->id }}</span>
                    <select wire:model.live="newStatus" class="h-8 pl-3 pr-8 bg-white text-zinc-900 text-[11px] font-bold rounded-md border border-zinc-200 uppercase tracking-tight focus:ring-0 cursor-pointer hover:bg-zinc-50 transition-colors">
                        <option value="New">New</option>
                        <option value="In Queue">In Queue</option>
                        <option value="Waiting for Payments">Waiting for Payments</option>
                        <option value="Job Date Scheduled">Job Date Scheduled</option>
                        <option value="Sold">Sold</option>
                    </select>
                </div>
            </div>
            <p class="text-xs text-zinc-400 font-medium mt-1.5 flex items-center gap-2">
                <i class="ph ph-calendar text-sm"></i> Pipeline Entry: {{ $lead->created_at->format('M d, Y') }}
                <span class="w-1 h-1 rounded-full bg-zinc-200"></span>
                <i class="ph ph-map-pin text-sm"></i> {{ $lead->suburb ?? 'AUS Site' }}
            </p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <button class="h-9 px-4 flex-1 sm:flex-none justify-center bg-white border border-zinc-200 text-zinc-600 rounded-md text-xs font-semibold hover:bg-zinc-50 transition-colors shadow-sm flex items-center gap-2">
                <i class="ph ph-pencil-simple text-sm"></i>
                Edit Case
            </button>
            <button class="h-9 px-5 flex-1 sm:flex-none justify-center bg-zinc-900 hover:bg-zinc-800 text-white rounded-md text-xs font-semibold shadow-sm transition-all flex items-center gap-2">
                <i class="ph ph-plus text-sm"></i>
                New Quote
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Sidebar: Client Info -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white border border-zinc-200 rounded-md shadow-sm p-6">
                <div class="flex items-center gap-2 mb-6 pb-4 border-b border-zinc-50">
                    <i class="ph ph-user text-zinc-400 text-lg"></i>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-900">Prospect Intelligence</h3>
                </div>
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] text-zinc-400 uppercase font-bold tracking-widest mb-1.5">Email Address</label>
                        <p class="text-sm font-semibold text-zinc-900 break-all select-all">{{ $lead->email }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] text-zinc-400 uppercase font-bold tracking-widest mb-1.5">Phone Number</label>
                        <p class="text-sm font-semibold text-zinc-900">{{ $lead->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] text-zinc-400 uppercase font-bold tracking-widest mb-1.5">Site Location</label>
                        <p class="text-sm font-semibold text-zinc-900">{{ $lead->address }}</p>
                        <p class="text-[11px] text-zinc-500 mt-1">{{ $lead->suburb }} {{ $lead->post_code }}</p>
                        
                        <!-- OpenMap Aerial Block -->
                        <div class="mt-6 border border-zinc-200 shadow-sm relative h-52 rounded-md overflow-hidden" 
                             x-data="{ 
                                map: null,
                                init() {
                                    let link = document.createElement('link');
                                    link.rel = 'stylesheet';
                                    link.href = 'https://unpkg.com/leaflet/dist/leaflet.css';
                                    document.head.appendChild(link);
                                    
                                    let script = document.createElement('script');
                                    script.src = 'https://unpkg.com/leaflet/dist/leaflet.js';
                                    script.onload = () => {
                                        let q = `{{ $lead->address }}, {{ $lead->suburb }} {{ $lead->post_code }} AU`;
                                        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(q)}`)
                                            .then(res => res.json())
                                            .then(data => {
                                                if(data.length > 0) {
                                                    let lat = data[0].lat;
                                                    let lon = data[0].lon;
                                                    this.map = L.map($refs.mapNode).setView([lat, lon], 19);
                                                    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                                                        attribution: 'Tiles &copy; Esri'
                                                    }).addTo(this.map);
                                                    L.marker([lat, lon]).addTo(this.map);
                                                } else {
                                                    $refs.mapNode.innerHTML = `<div class='flex items-center justify-center h-full text-xs text-zinc-400 p-4 border-2 border-dashed border-zinc-100 uppercase tracking-widest font-bold'>Geodata Unreachable</div>`;
                                                }
                                            });
                                    };
                                    document.head.appendChild(script);
                                }
                             }">
                             <div x-ref="mapNode" class="w-full h-full bg-zinc-50 flex items-center justify-center z-10">
                                <i class="ph ph-spinner animate-spin text-zinc-300 text-2xl"></i>
                             </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-zinc-900 border border-zinc-900 rounded-md shadow-sm p-6 text-white relative overflow-hidden">
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-6">Equipment Configuration</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center bg-white/5 p-3 rounded border border-white/5 transition-colors hover:bg-white/10">
                        <span class="text-xs text-zinc-400">Panel Class</span>
                        <span class="text-xs font-bold text-white">{{ $lead->panel_model ?? 'TBD' }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-white/5 p-3 rounded border border-white/5 transition-colors hover:bg-white/10">
                        <span class="text-xs text-zinc-400">Inverter Data</span>
                        <span class="text-xs font-bold text-white">{{ $lead->inverter_model ?? 'TBD' }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-white/5 p-3 rounded border border-white/5 transition-colors hover:bg-white/10">
                        <span class="text-xs text-zinc-400">Storage / Battery</span>
                        <span class="text-xs font-bold text-white">{{ $lead->battery_model ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section: History / Files -->
        <div class="lg:col-span-8 flex flex-col bg-white border border-zinc-200 rounded-md shadow-sm overflow-hidden min-h-[700px]">
            
            <div class="flex items-center p-1 bg-zinc-100/50 border-b border-zinc-200 sticky top-0 z-10 backdrop-blur-md">
                <button wire:click="setTab('history')" class="flex-1 px-4 py-3 text-[11px] font-bold uppercase tracking-widest flex items-center justify-center gap-2 transition-all rounded {{ $activeTab === 'history' ? 'bg-white text-zinc-900 shadow-sm border border-zinc-200' : 'text-zinc-500 hover:text-zinc-900' }}">
                    <i class="ph ph-activity text-sm"></i> Activity
                </button>
                <button wire:click="setTab('tasks')" class="flex-1 px-4 py-3 text-[11px] font-bold uppercase tracking-widest flex items-center justify-center gap-2 transition-all rounded {{ $activeTab === 'tasks' ? 'bg-white text-zinc-900 shadow-sm border border-zinc-200' : 'text-zinc-500 hover:text-zinc-900' }}">
                    <i class="ph ph-check-square text-sm"></i> Tasks
                    <span class="bg-zinc-200 px-1.5 py-0.5 rounded text-[9px]">{{ count($lead->tasks ?? []) }}</span>
                </button>
                <button wire:click="setTab('files')" class="flex-1 px-4 py-3 text-[11px] font-bold uppercase tracking-widest flex items-center justify-center gap-2 transition-all rounded {{ $activeTab === 'files' ? 'bg-white text-zinc-900 shadow-sm border border-zinc-200' : 'text-zinc-500 hover:text-zinc-900' }}">
                    <i class="ph ph-folder text-sm"></i> Documentation
                </button>
            </div>

            <div class="p-8 flex-1">
                @if($activeTab === 'history')
                    <div class="space-y-6">
                        @forelse($lead->activities ?? [] as $activity)
                            <div class="flex gap-4 group">
                                <div class="relative shrink-0 flex flex-col items-center">
                                    <div class="h-8 w-8 rounded-full border border-zinc-200 bg-white flex items-center justify-center z-10 shadow-sm">
                                        <i class="ph ph-pulse text-zinc-400"></i>
                                    </div>
                                    <div class="w-[1px] h-full bg-zinc-100 group-last:hidden mt-2"></div>
                                </div>
                                <div class="pb-6">
                                    <div class="flex items-center justify-between mb-1">
                                        <h4 class="text-sm font-bold text-zinc-900">{{ $activity->action_type ?? 'Record Update' }}</h4>
                                        <time class="text-[9px] font-bold text-zinc-400 uppercase">{{ $activity->created_at->format('M d, H:i') }}</time>
                                    </div>
                                    <p class="text-xs text-zinc-500 leading-relaxed">{{ $activity->description ?? 'Record data modified by agent.' }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-20 bg-zinc-50/50 rounded border border-dashed border-zinc-200 text-center">
                                <div class="h-10 w-10 bg-white rounded-full flex items-center justify-center mb-4 border border-zinc-100">
                                    <i class="ph ph-sparkle text-zinc-300 text-xl"></i>
                                </div>
                                <h5 class="text-xs font-bold text-zinc-900 uppercase tracking-widest">Case Created</h5>
                                <p class="text-xs text-zinc-400 mt-1">Lead initialized in pipeline via {{ $lead->lead_source ?? 'WEB' }} gateway.</p>
                                <p class="text-[10px] text-zinc-400 font-bold mt-4">{{ $lead->created_at->format('D, M d, Y • h:i A') }}</p>
                            </div>
                        @endforelse
                    </div>

                @elseif($activeTab === 'tasks')
                    <div class="space-y-3">
                        @forelse($lead->tasks ?? [] as $task)
                            <div class="flex items-center justify-between p-4 border border-zinc-100 rounded-md bg-white hover:border-zinc-300 transition-all {{ $task->is_completed ? 'opacity-40' : '' }}">
                                <div>
                                    <h4 class="text-sm font-bold text-zinc-900 {{ $task->is_completed ? 'line-through' : '' }}">{{ $task->title ?? 'Pipeline Follow-up' }}</h4>
                                    <p class="text-[10px] font-semibold text-zinc-400 uppercase mt-1">{{ $task->due_date ? 'Deadline: ' . $task->due_date?->format('M d, Y') : 'No static deadline' }}</p>
                                </div>
                                @if(!$task->is_completed)
                                    <button wire:click="completeTask({{ $task->id }})" class="h-8 px-4 bg-zinc-100 hover:bg-zinc-900 hover:text-white text-zinc-900 rounded text-[10px] font-bold uppercase tracking-widest transition-all">Complete</button>
                                @else
                                    <div class="text-[10px] font-bold text-emerald-600 uppercase flex items-center gap-1">
                                        <i class="ph ph-check-circle text-base"></i> Done
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-24 text-center">
                                <div class="h-12 w-12 bg-zinc-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="ph ph-list-checks text-2xl text-zinc-300"></i>
                                </div>
                                <h5 class="text-xs font-bold text-zinc-900 uppercase tracking-widest">Nothing Scheduled</h5>
                                <p class="text-xs text-zinc-400 mt-1 max-w-[200px]">No manual tasks have been assigned to this lead yet.</p>
                                <button class="mt-6 h-8 px-4 bg-zinc-900 text-white rounded text-[10px] font-bold uppercase transition-all">New Task</button>
                            </div>
                        @endforelse
                    </div>

                @elseif($activeTab === 'files')
                    <div class="space-y-10">
                        <!-- Uploader Form -->
                        <div class="bg-zinc-50 p-8 rounded-md border border-dashed border-zinc-200">
                            <form wire:submit.prevent="uploadDocument" class="flex flex-col md:flex-row items-end gap-6">
                                <div class="flex-1 w-full">
                                    <label class="block text-[10px] text-zinc-500 uppercase tracking-widest font-bold mb-2">Internal Title</label>
                                    <input type="text" wire:model="documentTitle" placeholder="e.g. Switchboard Photo" class="w-full bg-white border border-zinc-200 rounded-md px-3 py-2 text-xs font-medium focus:ring-1 focus:border-zinc-900 outline-none">
                                </div>
                                <div class="flex-1 w-full">
                                    <label class="block text-[10px] text-zinc-500 uppercase tracking-widest font-bold mb-2">Payload (Image/PDF)</label>
                                    <div class="relative flex items-center">
                                        <input type="file" wire:model="newDocument" class="w-full h-9 bg-white border border-zinc-200 rounded-md text-[10px] cursor-pointer file:hidden px-3 pt-2">
                                        <i class="ph ph-upload-simple absolute right-3 text-zinc-400"></i>
                                    </div>
                                    <div wire:loading wire:target="newDocument" class="text-[9px] text-zinc-900 font-bold mt-2 animate-pulse uppercase">Compressing Stream...</div>
                                    @error('newDocument') <span class="text-[9px] text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                                </div>
                                <button type="submit" class="h-9 px-8 bg-zinc-900 text-white rounded-md text-[10px] font-bold uppercase tracking-widest hover:bg-zinc-800 transition-all shadow-sm">
                                    Commit
                                </button>
                            </form>
                        </div>

                        <!-- Gallery Grid -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                            @forelse($lead->documents ?? [] as $doc)
                                <div class="bg-white border border-zinc-100 rounded-md shadow-sm overflow-hidden flex flex-col group hover:border-zinc-300 transition-all">
                                    <div class="aspect-square bg-zinc-50 flex items-center justify-center relative border-b border-zinc-50 overflow-hidden">
                                        @if($doc->type === 'image')
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="w-full h-full block">
                                                <img src="{{ asset('storage/' . $doc->file_path) }}" class="w-full h-full object-cover grayscale transition-all group-hover:grayscale-0 group-hover:scale-110" alt="Site Photo">
                                            </a>
                                        @else
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="w-full h-full flex flex-col items-center justify-center text-zinc-400 hover:bg-zinc-100 group-hover:text-zinc-900 transition-all">
                                                <i class="ph ph-file-pdf text-4xl mb-2"></i>
                                                <span class="text-[9px] font-bold uppercase tracking-widest">{{ strtoupper(pathinfo($doc->file_path, PATHINFO_EXTENSION)) }}</span>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <h4 class="text-[11px] font-bold text-zinc-900 truncate" title="{{ $doc->title }}">{{ $doc->title }}</h4>
                                        <p class="text-[9px] text-zinc-400 font-semibold uppercase mt-1">{{ $doc->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 lg:col-span-4 flex flex-col items-center justify-center py-24 bg-zinc-50/20 rounded border border-dashed border-zinc-100">
                                    <div class="h-10 w-10 bg-white rounded-full flex items-center justify-center mb-4 border border-zinc-50">
                                        <i class="ph ph-paperclip text-zinc-200 text-xl"></i>
                                    </div>
                                    <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">No assets attached to this case.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>