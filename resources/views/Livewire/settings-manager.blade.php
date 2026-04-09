<div class="flex flex-col w-full max-w-5xl mx-auto py-12 px-4 space-y-8">
    
    <div class="pb-6 border-b border-zinc-200">
        <h2 class="text-3xl font-bold text-zinc-900 tracking-tight">System Core</h2>
        <p class="text-xs font-bold text-zinc-400 uppercase tracking-widest mt-2">Equipment Catalog & Master CRM Configuration</p>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md text-[10px] font-bold uppercase tracking-wider animate-in fade-in slide-in-from-top-2">
            <i class="ph ph-check-circle mr-2"></i> {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Add Product Form -->
        <div class="lg:col-span-4">
            <div class="bg-white border border-zinc-200 rounded-md shadow-sm p-6 sticky top-8">
                <h3 class="text-xs font-bold text-zinc-900 uppercase tracking-widest mb-6 border-b border-zinc-50 pb-3">Provision Asset</h3>
                <form wire:submit.prevent="addProduct" class="space-y-5">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">Asset Classification</label>
                        <select wire:model="type" class="w-full bg-zinc-50/50 border border-zinc-200 rounded-md px-3 py-2.5 text-xs text-zinc-700 focus:outline-none focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all font-medium">
                            <option value="Panel">Solar Panel [PV]</option>
                            <option value="Battery">Storage [BESS]</option>
                            <option value="Inverter">Power Conversion [INV]</option>
                        </select>
                        @error('type') <span class="text-red-500 text-[10px] font-bold mt-1 block uppercase">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">Manufacturer / Brand</label>
                        <input type="text" wire:model="brand" placeholder="e.g. Sungrow, Jinko" class="w-full bg-zinc-50/50 border border-zinc-200 rounded-md px-3 py-2.5 text-xs text-zinc-700 focus:outline-none focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all placeholder:text-zinc-300">
                        @error('brand') <span class="text-red-500 text-[10px] font-bold mt-1 block uppercase">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">Model Specification</label>
                        <input type="text" wire:model="model_name" placeholder="e.g. 440W Tiger Neo" class="w-full bg-zinc-50/50 border border-zinc-200 rounded-md px-3 py-2.5 text-xs text-zinc-700 focus:outline-none focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 transition-all placeholder:text-zinc-300">
                        @error('model_name') <span class="text-red-500 text-[10px] font-bold mt-1 block uppercase">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="w-full h-10 bg-zinc-900 hover:bg-zinc-800 text-white rounded-md text-[10px] font-bold uppercase tracking-widest shadow-sm transition-all mt-4">
                        Register Asset
                    </button>
                </form>
            </div>
        </div>

        <!-- Product Lists -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Panels -->
            <div class="bg-white border border-zinc-200 rounded-md shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-zinc-50/50 border-b border-zinc-100 flex items-center justify-between">
                    <h3 class="text-[10px] font-bold text-zinc-900 uppercase tracking-widest">Active PV Modules</h3>
                    <span class="px-2 py-0.5 bg-zinc-200 text-zinc-600 rounded text-[9px] font-bold uppercase">{{ $panels->count() }} SKUs</span>
                </div>
                <div class="p-6 flex flex-wrap gap-3">
                    @forelse($panels as $item)
                        <div class="group flex items-center gap-3 pl-3 pr-2 py-1.5 bg-white border border-zinc-200 rounded-md hover:border-zinc-900 transition-all">
                            <span class="text-xs font-bold text-zinc-900">{{ $item->brand }} <span class="text-zinc-400 font-medium">{{ $item->model_name }}</span></span>
                            <button wire:click="deleteProduct({{ $item->id }})" class="h-6 w-6 flex items-center justify-center text-zinc-300 hover:text-red-500 hover:bg-red-50 rounded-md transition-all">
                                <i class="ph ph-x text-sm"></i>
                            </button>
                        </div>
                    @empty
                        <div class="w-full py-8 text-center border-2 border-dashed border-zinc-100 rounded-md">
                            <p class="text-[10px] font-bold text-zinc-300 uppercase tracking-widest">No Panels Indexed</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Batteries -->
            <div class="bg-white border border-zinc-200 rounded-md shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-zinc-50/50 border-b border-zinc-100 flex items-center justify-between">
                    <h3 class="text-[10px] font-bold text-zinc-900 uppercase tracking-widest">Storage Solutions</h3>
                    <span class="px-2 py-0.5 bg-zinc-200 text-zinc-600 rounded text-[9px] font-bold uppercase">{{ $batteries->count() }} SKUs</span>
                </div>
                <div class="p-6 flex flex-wrap gap-3">
                    @forelse($batteries as $item)
                        <div class="group flex items-center gap-3 pl-3 pr-2 py-1.5 bg-white border border-zinc-200 rounded-md hover:border-zinc-900 transition-all">
                            <span class="text-xs font-bold text-zinc-900">{{ $item->brand }} <span class="text-zinc-400 font-medium">{{ $item->model_name }}</span></span>
                            <button wire:click="deleteProduct({{ $item->id }})" class="h-6 w-6 flex items-center justify-center text-zinc-300 hover:text-red-500 hover:bg-red-50 rounded-md transition-all">
                                <i class="ph ph-x text-sm"></i>
                            </button>
                        </div>
                    @empty
                        <div class="w-full py-8 text-center border-2 border-dashed border-zinc-100 rounded-md">
                            <p class="text-[10px] font-bold text-zinc-300 uppercase tracking-widest">No Battery Systems Indexed</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Inverters -->
            <div class="bg-white border border-zinc-200 rounded-md shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-zinc-50/50 border-b border-zinc-100 flex items-center justify-between">
                    <h3 class="text-[10px] font-bold text-zinc-900 uppercase tracking-widest">Power Conversion</h3>
                    <span class="px-2 py-0.5 bg-zinc-200 text-zinc-600 rounded text-[9px] font-bold uppercase">{{ $inverters->count() }} SKUs</span>
                </div>
                <div class="p-6 flex flex-wrap gap-3">
                    @forelse($inverters as $item)
                        <div class="group flex items-center gap-3 pl-3 pr-2 py-1.5 bg-white border border-zinc-200 rounded-md hover:border-zinc-900 transition-all">
                            <span class="text-xs font-bold text-zinc-900">{{ $item->brand }} <span class="text-zinc-400 font-medium">{{ $item->model_name }}</span></span>
                            <button wire:click="deleteProduct({{ $item->id }})" class="h-6 w-6 flex items-center justify-center text-zinc-300 hover:text-red-500 hover:bg-red-50 rounded-md transition-all">
                                <i class="ph ph-x text-sm"></i>
                            </button>
                        </div>
                    @empty
                        <div class="w-full py-8 text-center border-2 border-dashed border-zinc-100 rounded-md">
                            <p class="text-[10px] font-bold text-zinc-300 uppercase tracking-widest">No Inverters Indexed</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
