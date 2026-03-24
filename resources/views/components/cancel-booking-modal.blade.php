@props(['appointment'])

<x-modal {{ $attributes }}>
    <div class="bg-white rounded-[32px] p-8 relative flex flex-col items-center shadow-[0px_32px_64px_-12px_rgba(32,48,68,0.25)]">

        <button @click="show = false" class="absolute right-6 top-6 text-[#9EAEC7] hover:text-[#4d5d73] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="mb-6">
            <div class="w-16 h-16 bg-[#f74b6d]/10 rounded-full flex items-center justify-center">
                <div class="w-12 h-12 bg-[#f74b6d]/30 rounded-full flex items-center justify-center">
                    <svg class="w-1.5 h-6" viewBox="0 0 5 23" fill="none">
                        <path d="M0.5 0.5H4.5V15.5H0.5V0.5ZM0.5 18.5H4.5V22.5H0.5V18.5Z" fill="#B41340"/>
                    </svg>
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-extrabold text-[#203044] tracking-tight mb-4 text-center">
            Cancel Appointment?
        </h2>

        <div class="text-center text-[#4d5d73] text-base leading-relaxed mb-10 max-w-[370px]">
            @if($appointment)
                Are you sure you want to cancel your
                <span class="font-bold text-[#203044]">{{ $appointment->service->name }}</span>
                with <span class="font-bold text-[#203044]">{{ explode(' ', $appointment->employee->name)[0] }}</span> on
                <span class="font-bold text-[#203044]">{{ $appointment->start_time->format('l, M jS @ h:i A') }}</span>?
            @else
                Are you sure you want to cancel this appointment?
            @endif
            <br><span class="mt-2 block">This action cannot be undone.</span>
        </div>

        <div class="w-full space-y-3">
            <button wire:click="cancelAppointment" @click="show = false"
                    class="w-full bg-[#b41340] text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-rose-100 hover:bg-[#9d1038] transition-all active:scale-95">
                Yes, Cancel Appointment
            </button>

            <button @click="show = false"
                    class="w-full bg-white border border-slate-200 text-[#4d5d73] py-4 rounded-xl font-bold text-lg hover:bg-slate-50 transition-all">
                Keep Appointment
            </button>
        </div>
    </div>
</x-modal>
