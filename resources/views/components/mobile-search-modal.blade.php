<div
    x-data="{ searchOpen: false, searchQuery: '' }"
    x-show="searchOpen"
    @open-mobile-search.window="searchOpen = true; $nextTick(() => $refs.searchInput.focus())"
    @keydown.escape.window="searchOpen = false"
    style="display: none;"
    class="fixed inset-0 z-[60] bg-[#f4f6ff] lg:hidden flex flex-col"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-4"
>
    <div class="flex items-center gap-[12px] px-[16px] py-[12px] bg-white shadow-sm shrink-0">

        <button @click="searchOpen = false" class="p-[8px] -ml-[8px] text-[#64748B] hover:bg-gray-100 rounded-full transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </button>

        <div class="flex-1 relative bg-[#eaf1ff] rounded-full overflow-hidden flex items-center">
            <input
                type="text"
                x-ref="searchInput"
                x-model="searchQuery"
                placeholder="Search appointments..."
                class="w-full bg-transparent border-none focus:ring-0 py-[10px] pl-[16px] pr-[40px] text-[#203044] text-[16px] font-['Inter'] font-medium placeholder-[#6b7280] outline-none"
            >

            <button
                x-show="searchQuery.length > 0"
                @click="searchQuery = ''; $refs.searchInput.focus()"
                class="absolute right-[12px] text-[#64748B] hover:text-[#203044] p-[4px] bg-gray-200/50 rounded-full"
                style="display: none;"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-[24px]">

        <div x-show="searchQuery.length === 0" class="flex flex-col gap-[16px]">
            <span class="font-['Inter'] font-bold text-[#4d5d73] text-[12px] tracking-[1px] uppercase">Quick Links</span>
            <div class="flex flex-wrap gap-[8px]">
                <button class="bg-white px-[16px] py-[8px] rounded-full text-[#4d5d73] text-[14px] font-medium shadow-sm border border-gray-100">Today's Schedule</button>
                <button class="bg-white px-[16px] py-[8px] rounded-full text-[#4d5d73] text-[14px] font-medium shadow-sm border border-gray-100">New Customer</button>
            </div>
        </div>

        <div x-show="searchQuery.length > 0" style="display: none;">
            <p class="text-[#64748B] text-center mt-[40px]">
                Searching for "<span x-text="searchQuery" class="font-bold text-[#203044]"></span>"...
            </p>
        </div>

    </div>
</div>
