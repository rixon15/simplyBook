@props(['appointment'])

<x-modal {{ $attributes }}>
    <div class="bg-white rounded-[32px] p-8 relative flex flex-col items-center shadow-[0px_32px_64px_-12px_rgba(32,48,68,0.25)]">

        {{-- Close Button --}}
        <button @click="show = false" class="absolute right-6 top-6 text-[#9EAEC7] hover:text-[#4d5d73] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        {{-- Success Icon --}}
        <div class="mb-6">
            <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center">
                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-extrabold text-[#203044] tracking-tight mb-4 text-center">
            Mark as Completed?
        </h2>

        <div class="text-center text-[#4d5d73] text-base leading-relaxed mb-10 max-w-[370px]">
            @if($appointment)
                Confirm that the <span class="font-bold text-[#203044]">{{ $appointment->service->name }}</span>
                for <span class="font-bold text-[#203044]">{{ $appointment->user->name }}</span> is finished.
            @endif

            <div class="mt-4 p-3 bg-amber-50 rounded-xl border border-amber-100 flex gap-3 text-left">
                <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p class="text-xs text-amber-800 font-medium">
                    <span class="font-bold uppercase block mb-0.5">Final Action</span>
                    This status cannot be changed later to prevent financial backdating records.
                </p>
            </div>
        </div>

        <div class="w-full space-y-3">
            <button wire:click="markAsDone" @click="show = false"
                    class="w-full bg-[#4a40e0] text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-indigo-100 hover:bg-[#3d30d4] transition-all active:scale-95">
                Confirm Completion
            </button>

            <button @click="show = false"
                    class="w-full bg-white border border-slate-200 text-[#4d5d73] py-4 rounded-xl font-bold text-lg hover:bg-slate-50 transition-all">
                Not Yet
            </button>
        </div>
    </div>
</x-modal>
