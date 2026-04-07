<x-modal wire:model="showModal">
    <div class="bg-white rounded-[28px] p-8 text-center shadow-2xl overflow-hidden relative">
        {{-- Danger Icon --}}
        <div class="size-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="size-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>

        <h3 class="text-xl font-black text-[#203044] mb-2">Remove Team Member?</h3>
        <p class="text-slate-500 text-sm leading-relaxed mb-8">
            Are you sure you want to remove <span class="font-bold text-[#203044]">"{{ $staffName }}"</span>?
            This will archive their profile. Historical data and past appointments will remain in the system.
        </p>

        <div class="flex gap-3">
            <button @click="show = false" class="flex-1 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all">
                Cancel
            </button>
            <button wire:click="delete" class="flex-1 py-4 bg-rose-600 text-white rounded-2xl font-bold hover:bg-rose-700 shadow-lg shadow-rose-100 transition-all active:scale-95">
                Yes, Remove
            </button>
        </div>
    </div>
</x-modal>
