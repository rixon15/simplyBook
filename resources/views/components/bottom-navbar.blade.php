<div class="fixed bottom-0 left-0 right-0 z-50 md:hidden">
    <div class="absolute inset-x-0 -top-4 h-4 bg-gradient-to-t from-black/5 to-transparent pointer-events-none"></div>

    <div class="backdrop-blur-[20px] bg-white/95 border-t border-slate-100 rounded-t-[24px] shadow-[0px_-10px_40px_-12px_rgba(32,48,68,0.08)]">

        <div class="flex items-center justify-around px-4 pt-3 pb-[calc(env(safe-area-inset-bottom)+12px)]">

            <a href="{{ route('home') }}"
               class="flex flex-col items-center justify-center min-w-[80px] transition-all active:scale-95 py-2.5 px-5 rounded-[20px]
               {{ request()->routeIs('home') ? 'bg-[#eaf1ff]' : 'bg-transparent' }}">
                <svg class="w-6 h-6 {{ request()->routeIs('home') ? 'text-[#4A40E0]' : 'text-[#4D5D73]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ request()->routeIs('home') ? '2.5' : '2' }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-[10px] uppercase tracking-wider mt-1 {{ request()->routeIs('home') ? 'text-[#4A40E0] font-black' : 'text-[#4D5D73] font-bold' }}">Home</span>
            </a>

            <a href="{{ route('bookings') }}"
               class="flex flex-col items-center justify-center min-w-[80px] transition-all active:scale-95 py-2.5 px-5 rounded-[20px]
               {{ request()->routeIs('bookings') ? 'bg-[#eaf1ff]' : 'bg-transparent' }}">
                <svg class="w-6 h-6 {{ request()->routeIs('bookings') ? 'text-[#4A40E0]' : 'text-[#4D5D73]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ request()->routeIs('bookings') ? '2.5' : '2' }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-[10px] uppercase tracking-wider mt-1 {{ request()->routeIs('bookings') ? 'text-[#4A40E0] font-black' : 'text-[#4D5D73] font-bold' }}">Bookings</span>
            </a>

            <a href="{{route('notifications')}}"
               class="flex flex-col items-center justify-center min-w-[80px] transition-all active:scale-95 py-2.5 px-5 rounded-[20px]
               {{ request()->routeIs('alerts') ? 'bg-[#eaf1ff]' : 'bg-transparent' }}">
                <svg class="w-6 h-6 {{ request()->routeIs('alerts') ? 'text-[#4A40E0]' : 'text-[#4D5D73]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ request()->routeIs('alerts') ? '2.5' : '2' }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="text-[10px] uppercase tracking-wider mt-1 {{ request()->routeIs('alerts') ? 'text-[#4A40E0] font-black' : 'text-[#4D5D73] font-bold' }}">Alerts</span>
            </a>

            <a href="{{ route('profile') }}"
               class="flex flex-col items-center justify-center min-w-[80px] transition-all active:scale-95 py-2.5 px-5 rounded-[20px]
               {{ request()->routeIs('profile') ? 'bg-[#eaf1ff]' : 'bg-transparent' }}">
                <svg class="w-6 h-6 {{ request()->routeIs('profile') ? 'text-[#4A40E0]' : 'text-[#4D5D73]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ request()->routeIs('profile') ? '2.5' : '2' }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-[10px] uppercase tracking-wider mt-1 {{ request()->routeIs('profile') ? 'text-[#4A40E0] font-black' : 'text-[#4D5D73] font-bold' }}">Profile</span>
            </a>
        </div>
    </div>
</div>
