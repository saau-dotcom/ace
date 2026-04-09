<div class="max-w-3xl mx-auto py-12 px-4">
    
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-bold text-zinc-900 tracking-tight">Lead Induction</h2>
        <p class="text-xs font-bold text-zinc-400 uppercase tracking-widest mt-2">Initialize new client record in primary pipeline</p>
    </div>

    <div class="inline-flex p-1 bg-zinc-100 rounded-lg border border-zinc-200 mb-8 w-full md:w-auto">
        <button class="flex-1 md:flex-none px-8 py-2 bg-white text-zinc-900 shadow-sm rounded-md text-[10px] font-bold uppercase transition-all border border-zinc-200">
            Manual Intake
        </button>
        <button class="flex-1 md:flex-none px-8 py-2 text-zinc-500 hover:text-zinc-900 rounded-md text-[10px] font-bold uppercase transition-all">
            Batch CSV
        </button>
    </div>

    <div class="bg-white border border-zinc-200 rounded-md p-8 shadow-sm">
        <form wire:submit.prevent="save" class="space-y-8">
            
            <div class="space-y-4">
                <h3 class="text-[10px] font-bold text-zinc-400 uppercase tracking-[0.2em] border-b border-zinc-50 pb-2">Primary Contact</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">First Name</label>
                        <input wire:model="first_name" type="text" placeholder="John" class="w-full bg-zinc-50/50 border-zinc-200 p-2.5 rounded-md text-sm focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 outline-none transition-all placeholder:text-zinc-300">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">Last Name</label>
                        <input wire:model="last_name" type="text" placeholder="Doe" class="w-full bg-zinc-50/50 border-zinc-200 p-2.5 rounded-md text-sm focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 outline-none transition-all placeholder:text-zinc-300">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">Phone Link</label>
                        <input wire:model="phone" type="text" placeholder="+61 400 000 000" class="w-full bg-zinc-50/50 border-zinc-200 p-2.5 rounded-md text-sm focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 outline-none transition-all placeholder:text-zinc-300">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">Email Address</label>
                        <input wire:model="email" type="email" placeholder="john.doe@example.com" class="w-full bg-zinc-50/50 border-zinc-200 p-2.5 rounded-md text-sm focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 outline-none transition-all placeholder:text-zinc-300">
                    </div>
                </div>
            </div>

            <div class="space-y-4 pt-4">
                <h3 class="text-[10px] font-bold text-zinc-400 uppercase tracking-[0.2em] border-b border-zinc-50 pb-2">Site Geography</h3>
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">Street Address</label>
                    <input wire:model="address" type="text" placeholder="123 Solar Street" class="w-full bg-zinc-50/50 border-zinc-200 p-2.5 rounded-md text-sm focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 outline-none transition-all placeholder:text-zinc-300">
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="col-span-1 md:col-span-2 space-y-1.5">
                        <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">Suburb</label>
                        <input wire:model="suburb" type="text" placeholder="Sydney" class="w-full bg-zinc-50/50 border-zinc-200 p-2.5 rounded-md text-sm focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 outline-none transition-all placeholder:text-zinc-300">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">Postcode</label>
                        <input wire:model="postcode" type="text" placeholder="2000" class="w-full bg-zinc-50/50 border-zinc-200 p-2.5 rounded-md text-sm focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 outline-none transition-all placeholder:text-zinc-300">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">Region</label>
                        <select wire:model="state" class="w-full bg-zinc-50/50 border-zinc-200 p-2.5 rounded-md text-sm focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 outline-none text-zinc-600">
                            <option value="">State</option>
                            <option value="NSW">NSW</option>
                            <option value="VIC">VIC</option>
                            <option value="QLD">QLD</option>
                            <option value="SA">SA</option>
                            <option value="WA">WA</option>
                            <option value="TAS">TAS</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="space-y-4 pt-4">
                <h3 class="text-[10px] font-bold text-zinc-400 uppercase tracking-[0.2em] border-b border-zinc-50 pb-2">Technical Requirements</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">Asset Status (Existing)</label>
                        <input wire:model="existing_system" type="text" placeholder="e.g. 5kW Inverter" class="w-full bg-zinc-50/50 border-zinc-200 p-2.5 rounded-md text-sm focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 outline-none transition-all placeholder:text-zinc-300">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">Required Capacity</label>
                        <input wire:model="system_required" type="text" placeholder="e.g. 10kW Premium" class="w-full bg-zinc-50/50 border-zinc-200 p-2.5 rounded-md text-sm focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 outline-none transition-all placeholder:text-zinc-300">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-zinc-500 uppercase ml-1">Confidential Agent Comments</label>
                    <textarea wire:model="comments" placeholder="Enter critical field intelligence here..." class="w-full bg-zinc-50/50 border-zinc-200 p-3 rounded-md text-sm focus:ring-1 focus:ring-zinc-900 focus:border-zinc-900 outline-none transition-all h-32 placeholder:text-zinc-300"></textarea>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-zinc-900 text-white font-bold py-4 rounded-md text-[10px] uppercase tracking-[0.3em] hover:bg-zinc-800 transition-all shadow-lg active:scale-[0.98]">
                    Authorize & Create Case
                </button>
            </div>
        </form>
    </div>
</div>