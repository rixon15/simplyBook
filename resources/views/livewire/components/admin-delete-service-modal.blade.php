<x-modal wire:model="showModal">
    <div class="bg-white rounded-[24px] p-8 text-center shadow-2xl">
        <div class="size-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="size-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>

        <h3 class="text-xl font-black text-[#203044] mb-2">Delete this service?</h3>
        <p class="text-slate-500 text-sm mb-8">
            You are about to delete <span class="font-bold text-[#203044]">"{{ $serviceName }}"</span>. This action cannot be undone and will affect future reports.
        </p>

        <div class="flex gap-3">
            <button @click="show = false" class="flex-1 py-4 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors">
                Cancel
            </button>
            <button wire:click="delete" class="flex-1 py-4 bg-rose-600 text-white rounded-xl font-bold hover:bg-rose-700 shadow-lg shadow-rose-100 transition-all active:scale-95">
                Delete Service
            </button>
        </div>
    </div>
</x-modal>
