@props(['appointment'])

<x-modal {{ $attributes }}>
    <div x-data="{ timer: null }"
         class="bg-[#f4f6ff] rounded-[32px] p-8 flex flex-col items-center">

        <div class="mb-8 text-center">
            <div class="bg-white w-20 h-20 rounded-full shadow-sm flex items-center justify-center mx-auto mb-6">
                <div class="w-10 h-10 bg-[#10B981] rounded-full flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
            <h2 class="text-3xl font-black text-[#203044] tracking-tight">You're all set!</h2>
            <p class="text-[#4d5d73] mt-2">Your appointment has been successfully scheduled.</p>
        </div>

        <div class="bg-white w-full rounded-2xl shadow-xl overflow-hidden relative">
            <div class="p-8 space-y-6 text-left">
                <div class="flex justify-between items-center">
                    <div class="space-y-1">
                        <p class="text-[11px] font-bold uppercase tracking-[0.55px] text-[#4d5d73]">Confirmation</p>
                        <h4 class="text-xl font-bold text-[#203044]">Booking Summary</h4>
                    </div>
                    <svg class="w-7 h-7 text-[#4a40e0]/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-[11px] font-bold uppercase text-[#4d5d73]">Service</label>
                        <p class="font-semibold text-[#203044]">{{$appointment->service->name}}</p>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold uppercase text-[#4d5d73]">Specialist</label>
                        <p class="font-semibold text-[#203044]">{{$appointment->employee->name}}</p>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold uppercase text-[#4d5d73]">Location</label>
                        <div class="flex items-center gap-2 text-[#203044] font-semibold">
                            <svg class="w-4 h-4 text-[#4a40e0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            123 Barber St, Downtown
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative h-6 bg-white">
                <div class="absolute inset-x-0 top-1/2 border-t-2 border-dashed border-[#f4f6ff]"></div>
                <div class="absolute -left-3 top-0 w-6 h-6 bg-[#f4f6ff] rounded-full shadow-inner"></div>
                <div class="absolute -right-3 top-0 w-6 h-6 bg-[#f4f6ff] rounded-full shadow-inner"></div>
            </div>

            <div class="bg-[#eaf1ff] p-8 flex justify-between items-center">
                <span class="font-bold text-[#4d5d73]">Total Paid</span>
                <span class="text-3xl font-black text-[#203044]">${{number_format($appointment->service->price, 2, '.', ',')}}</span>
            </div>
        </div>

        <div class="w-full mt-8">
            <a href="{{ route('bookings') }}" class="w-full inline-flex items-center justify-center bg-[#4a40e0] text-white py-4 rounded-2xl font-bold shadow-[0_10px_15px_-3px_rgba(74,64,224,0.2)] hover:bg-[#3d30d4] transition-all">
                View My Bookings
            </a>
        </div>
    </div>
</x-modal>
