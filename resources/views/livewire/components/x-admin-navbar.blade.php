<nav class="w-full shrink-0 z-20 sticky top-0">

    <div class="hidden lg:flex items-center justify-between px-[32px] h-[72px] backdrop-blur-md bg-white/80 shadow-sm">

        <div class="flex-1 max-w-[448px]">
            <div class="relative w-full bg-[#eaf1ff] rounded-full overflow-hidden">
                <div class="absolute inset-y-0 left-0 flex items-center pl-[16px] pointer-events-none">
                    <svg class="w-5 h-5 text-[#4D5D73]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" placeholder="Search appointments..."
                       class="w-full bg-transparent border-none focus:ring-0 py-[10px] pl-[44px] pr-[16px] text-[#4d5d73] text-[14px] font-['Inter'] font-medium placeholder-[#6b7280] outline-none">
            </div>
        </div>

        <div class="flex items-center gap-[24px]">

            <div class="flex items-center gap-[16px]">
                <livewire:notification-dropdown/>
                <x-settings-modal/>
            </div>

            <div class="w-px h-[32px] bg-[rgba(158,174,199,0.3)]"></div>

            <div class="flex items-center gap-[12px]">
                <div class="flex flex-col items-end">
                    <span class="font-['Inter'] font-bold text-[#203044] text-[12px] leading-tight">
                        {{ auth()->user()->name ?? 'User' }}
                    </span>
                    <span
                        class="font-['Inter'] font-medium text-[#4d5d73] text-[10px] tracking-[1px] uppercase leading-tight mt-1">
                        {{ auth()->user()->role === 'admin' ? 'Master Admin' : 'Staff' }}
                    </span>
                </div>

                <div class="relative w-[40px] h-[40px] rounded-full p-[2px] border-2 border-[rgba(74,64,224,0.2)]">
                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'U') }}&background=eaf1ff&color=4a40e0"
                        alt="Avatar" class="w-full h-full rounded-full object-cover">
                </div>
            </div>

        </div>
    </div>


    <div class="flex lg:hidden items-center justify-between px-[24px] py-[16px] bg-[#f4f6ff]">

        <div class="flex items-center gap-[16px]">
            <button x-data @click="$dispatch('open-mobile-menu')"
                    class="p-[8px] text-[#4D5D73] hover:bg-gray-200 rounded-full transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <span class="font-['Inter'] font-bold text-[#203044] text-[20px] tracking-[-0.5px]">
                {{ config('app.name', 'SimplyBook') }}
            </span>
        </div>

        <button x-data @click="$dispatch('open-mobile-search')"
                class="p-[8px] text-[#4D5D73] hover:bg-gray-200 rounded-full transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>

    </div>

</nav>
