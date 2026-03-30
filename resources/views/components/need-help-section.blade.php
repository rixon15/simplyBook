{{-- Flex Container: Column on mobile, Row on desktop. Center aligned. --}}
<section class="flex flex-col md:flex-row gap-[24px] pt-[48px] w-full max-w-[1280px] mx-auto justify-center items-stretch">

    <div class="flex-[2] relative rounded-[16px] overflow-hidden p-[32px] flex flex-col justify-between min-h-[299px] text-white"
         style="background: linear-gradient(159.566deg, rgb(74, 64, 224) 0%, rgb(61, 48, 212) 100%)">

        {{-- Background Decoration --}}
        <div class="absolute bottom-[-40px] right-[-40px] opacity-10 rotate-12 pointer-events-none">
            <svg class="w-[200px] h-[200px]" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z" />
            </svg>
        </div>

        <div class="relative z-10 space-y-[12px] max-w-[448px]">
            <div class="bg-white/20 backdrop-blur-md rounded-full px-[12px] py-[4px] w-fit">
                <span class="text-[12px] font-bold uppercase tracking-[1.2px]">Premium Perk</span>
            </div>

            <h3 class="text-[30px] font-black leading-[37px]">
                Sync with your favorite <br> calendar apps.
            </h3>

            <p class="text-[16px] text-white/80 leading-[24px]">
                Connect Google Calendar, iCal, or Outlook to keep all your professional and personal bookings in one place.
            </p>
        </div>

        <div class="relative z-10 pt-[16px]">
            <button class="bg-white text-[#4a40e0] font-bold px-[24px] py-[12px] rounded-[12px] flex items-center gap-[8px] hover:bg-slate-50 transition-colors shadow-lg active:scale-95">
                Connect Calendar
                <svg class="size-[16px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </button>
        </div>
    </div>

    <div class="flex-1 bg-[#eaf1ff] rounded-[16px] p-[32px] flex flex-col justify-between min-h-[299px]">
        <div class="space-y-[16px]">
            <div class="bg-[#983772]/10 flex items-center justify-center rounded-full size-[48px]">
                <svg class="size-[20px] text-[#983772]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>

            <div class="space-y-[8px]">
                <h3 class="text-[20px] font-bold text-[#203044]">Need Help?</h3>
                <p class="text-[14px] text-[#4d5d73] leading-[20px]">
                    Our support team is available 24/7 to help you with your account settings.
                </p>
            </div>
        </div>

        <a href="#" class="flex items-center gap-[8px] text-[#203044] font-bold text-[16px] hover:underline group">
            Visit Help Center
            <svg class="size-[14px] transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
</section>
