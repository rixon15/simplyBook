<div
    x-data="{ open: false }"
    x-show="open"
    @open-mobile-menu.window="open = true"
    @keydown.escape.window="open = false"
    class="relative z-50 lg:hidden"
    style="display: none;"
>
    <div
        x-show="open"
        x-transition:enter="ease-in-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm"
        @click="open = false"
    ></div>

    <div
        x-show="open"
        x-transition:enter="transform transition ease-in-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 w-[320px] bg-[#f8fafc] rounded-r-[24px] shadow-2xl flex flex-col p-[24px] overflow-y-auto"
    >

        <div class="flex items-center justify-between pb-[32px] shrink-0">
            <div class="flex items-center gap-[8px]">
                <div class="bg-[#4f46e5] flex items-center justify-center rounded-[8px] w-[32px] h-[32px] shrink-0">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 22h20L12 2z"/></svg>
                </div>
                <span class="font-['Inter'] font-black text-[#4338ca] text-[20px] tracking-[-0.5px]">
                    {{ config('app.name', 'SimplyBook') }}
                </span>
            </div>

            <button @click="open = false" class="p-[8px] rounded-full text-[#64748B] hover:bg-gray-200 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="bg-[#f1f5f9] rounded-[24px] p-[16px] mb-[24px] flex items-center justify-between shrink-0">
            <div class="flex items-center gap-[12px]">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'U') }}&background=fff&color=4a40e0" alt="Avatar" class="w-[48px] h-[48px] rounded-full border-2 border-white">
                <div class="flex flex-col">
                    <span class="font-['Nimbus_Sans'] font-bold text-[#0f172a] text-[14px] leading-tight">{{ auth()->user()->name ?? 'User' }}</span>
                    <span class="font-['Nimbus_Sans'] text-[#4f46e5] text-[11px] uppercase tracking-[0.5px] mt-1">{{ auth()->user()->role === 'admin' ? 'Master Admin' : 'Staff' }}</span>
                </div>
            </div>
        </div>

        <nav class="flex flex-col gap-[4px] flex-1">

            @php $isDashboard = request()->routeIs('dashboard', 'admin.dashboard', 'employee.dashboard'); @endphp
            <a href="{{ route('dashboard') }}" wire:navigate @click="open = false" class="relative flex items-center gap-[16px] px-[16px] py-[12px] rounded-[16px] {{ $isDashboard ? 'bg-[#eef2ff]' : 'hover:bg-gray-100' }}">
                @if($isDashboard)
                    <div aria-hidden="true" class="absolute left-0 top-0 bottom-0 border-l-4 border-[#4f46e5] rounded-l-[16px]"></div>
                @endif
                <svg class="w-5 h-5 {{ $isDashboard ? 'text-[#4338ca]' : 'text-[#475569]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-['Nimbus_Sans'] text-[14px] {{ $isDashboard ? 'text-[#4338ca] font-bold' : 'text-[#475569]' }}">Dashboard</span>
            </a>

            @php $isAppts = request()->routeIs('appointments'); @endphp
            <a href="{{ route('appointments') }}" wire:navigate @click="open = false" class="relative flex items-center gap-[16px] px-[16px] py-[12px] rounded-[16px] {{ $isAppts ? 'bg-[#eef2ff]' : 'hover:bg-gray-100' }}">
                @if($isAppts)
                    <div aria-hidden="true" class="absolute left-0 top-0 bottom-0 border-l-4 border-[#4f46e5] rounded-l-[16px]"></div>
                @endif
                <svg class="w-5 h-5 {{ $isAppts ? 'text-[#4338ca]' : 'text-[#475569]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="font-['Nimbus_Sans'] text-[14px] {{ $isAppts ? 'text-[#4338ca] font-bold' : 'text-[#475569]' }}">Appointments</span>
            </a>

            @if(auth()->user()->role === 'admin')

                <a href="{{ route('admin.services') }}" wire:navigate @click="open = false" class="relative flex items-center gap-[16px] px-[16px] py-[12px] rounded-[16px] hover:bg-gray-100">
                    <svg class="w-5 h-5 text-[#475569]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                    <span class="font-['Nimbus_Sans'] text-[14px] text-[#475569]">Services</span>
                </a>

                <a href="{{ route('admin.staff') }}" wire:navigate @click="open = false" class="relative flex items-center gap-[16px] px-[16px] py-[12px] rounded-[16px] hover:bg-gray-100">
                    <svg class="w-5 h-5 text-[#475569]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="font-['Nimbus_Sans'] text-[14px] text-[#475569]">Staff</span>
                </a>

            @endif
        </nav>

        <div class="pt-[24px] shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-[rgba(180,19,64,0.05)] hover:bg-[rgba(180,19,64,0.1)] transition-colors flex gap-[12px] items-center justify-center py-[16px] rounded-[16px]">
                    <svg class="w-5 h-5 text-[#B41340]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="font-['Inter'] font-bold text-[#b41340] text-[14px]">Log Out</span>
                </button>
            </form>
        </div>

    </div>
</div>
