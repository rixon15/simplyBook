<x-modal wire:model="showModal">
    <div class="bg-white rounded-[24px] overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
        <div class="bg-[#f4f6ff] px-8 py-6 flex justify-between items-center shrink-0">
            <div>
                <h3 class="text-xl font-extrabold text-[#203044]">Edit Service</h3>
                <p class="text-xs text-[#4a40e0] mt-1 uppercase tracking-widest font-bold">Modify details</p>
            </div>
            <button @click="show = false" class="text-[#9eaec7] hover:text-[#4a40e0] p-2 bg-white rounded-full transition-colors shadow-sm">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form wire:submit.prevent="update" class="p-8 overflow-y-auto custom-scrollbar space-y-6">
            <div>
                <label class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Service Name</label>
                <input type="text" wire:model="name" class="w-full bg-[#f4f6ff] border-none rounded-xl px-5 py-4 text-sm font-medium focus:ring-2 focus:ring-[#4a40e0] transition-all">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Price ($)</label>
                    <input type="number" step="0.01" wire:model="price" class="w-full bg-[#f4f6ff] border-none rounded-xl px-5 py-4 text-sm font-bold text-[#203044] focus:ring-2 focus:ring-[#4a40e0]">
                </div>
                <div>
                    <label class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Duration (Min)</label>
                    <input type="number" wire:model="duration" x-data @blur="if($el.value) { let s = Math.round($el.value / 5) * 5; $wire.set('duration', s); }"
                           class="w-full bg-[#f4f6ff] border-none rounded-xl px-5 py-4 text-sm font-bold text-[#203044] focus:ring-2 focus:ring-[#4a40e0]">
                </div>
            </div>

            <button type="submit" class="w-full bg-[#4a40e0] text-white py-4 rounded-xl font-bold shadow-lg hover:bg-[#3d30d4] transition-all active:scale-95">
                Update Service
            </button>
        </form>
    </div>
</x-modal>
