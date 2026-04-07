<x-modal wire:model="showModal">
    <div class="bg-white rounded-[24px] overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">

        {{-- Header --}}
        <div class="bg-[#f4f6ff] px-8 py-6 flex justify-between items-center shrink-0">
            <div>
                <h3 class="text-xl font-extrabold text-[#203044]">New Service</h3>
                <p class="text-xs text-[#4d5d73] mt-1 uppercase tracking-widest font-bold">Menu Offering</p>
            </div>
            <button @click="show = false" class="text-[#9eaec7] hover:text-[#4a40e0] transition-colors p-2 bg-white rounded-full shadow-sm">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form wire:submit.prevent="save" class="p-8 overflow-y-auto custom-scrollbar space-y-6">

            {{-- Name --}}
            <div>
                <label class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Service Name</label>
                <input type="text" wire:model="name" placeholder="e.g. Signature Haircut"
                       class="w-full bg-[#f4f6ff] border-none rounded-xl px-5 py-4 text-sm font-medium focus:ring-2 focus:ring-[#4a40e0] transition-all">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Description --}}
            <div>
                <label class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Description (Optional)</label>
                <textarea wire:model="description" rows="2" placeholder="Briefly describe what this service includes..."
                          class="w-full bg-[#f4f6ff] border-none rounded-xl px-5 py-4 text-sm font-medium focus:ring-2 focus:ring-[#4a40e0] transition-all resize-none"></textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            {{-- Price & Duration Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Price ($)</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 font-bold text-[#9eaec7]">$</span>
                        <input type="number" step="0.01" wire:model="price" placeholder="0.00"
                               class="w-full bg-[#f4f6ff] border-none rounded-xl pl-9 pr-5 py-4 text-sm font-bold text-[#203044] focus:ring-2 focus:ring-[#4a40e0] transition-all">
                    </div>
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>

                <div>
                    <label class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Duration (Minutes)</label>
                    <div class="relative">
                        <input type="number"
                               wire:model="duration"
                               placeholder="e.g. 45"
                               x-data
                               @blur="
                    if ($el.value) {
                        let snapped = Math.round($el.value / 5) * 5;
                        $el.value = snapped;
                        $wire.set('duration', snapped);
                    }
               "
                               class="w-full bg-[#f4f6ff] border-none rounded-xl px-5 py-4 text-sm font-bold text-[#203044] focus:ring-2 focus:ring-[#4a40e0] transition-all">
                        <span class="absolute right-5 top-1/2 -translate-y-1/2 font-bold text-[#9eaec7] text-xs uppercase">Min</span>
                    </div>
                    <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                </div>
            </div>

            {{-- Status Toggle --}}
            <div class="flex items-center justify-between bg-slate-50 border border-slate-100 p-5 rounded-xl">
                <div>
                    <h4 class="text-sm font-bold text-[#203044]">Available for Booking</h4>
                    <p class="text-xs text-[#4d5d73] mt-0.5">Customers can see and book this service.</p>
                </div>
                <button type="button" wire:click="$toggle('isActive')" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $isActive ? 'bg-[#4a40e0]' : 'bg-slate-200' }}">
                    <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $isActive ? 'translate-x-5' : 'translate-x-0' }}"></span>
                </button>
            </div>

            {{-- Submit --}}
            <div class="pt-4">
                <button type="submit" class="w-full bg-[#4a40e0] text-white py-4 rounded-xl font-bold shadow-lg shadow-indigo-100 hover:bg-[#3d30d4] transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round"/></svg>
                    Save Service
                </button>
            </div>
        </form>
    </div>
</x-modal>
