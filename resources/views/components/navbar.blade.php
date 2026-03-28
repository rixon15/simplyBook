<nav class="bg-[#f4f6ff] border-b border-slate-200/60 sticky top-0 z-50">
    <div class="max-w-[1280px] mx-auto px-6 py-4 flex justify-between items-center">

        <div class="flex items-center gap-10">
            <a href="{{ route('home') }}" class="text-[#0f172a] text-[20px] font-black tracking-tight">
                SimplyBook
            </a>

            @auth
                <div class="hidden md:flex items-center gap-6 h-[34px]">
                    <a href="{{ route('bookings') }}"
                       class="h-full flex items-center px-1 relative transition-colors {{ request()->routeIs('admin') ? 'text-[#4a40e0] font-semibold' : 'text-[#4d5d73] font-medium hover:text-[#4a40e0]' }}">
                        Bookings
                        @if(request()->routeIs('bookings'))
                            <div class="absolute bottom-0 left-0 right-0 h-[2px] bg-[#4a40e0]"></div>
                        @endif
                    </a>

                    <a href="{{ route('profile') }}"
                       class="h-full flex items-center px-3 relative transition-colors" {{ request()->routeIs('admin') ? 'text-[#4a40e0] font-semibold' : 'text-[#4d5d73] font-medium hover:text-[#4a40e0]' }}>
                        Profile
                        @if(request()->routeIs('profile'))
                            <div class="absolute bottom-0 left-0 right-0 h-[2px] bg-[#4a40e0]"></div>
                        @endif
                    </a>
                </div>
            @endauth
        </div>

        <div class="flex items-center gap-4">
            @auth
                <livewire:notification-dropdown/>

                <a href="{{ route('home') }}"
                   class="hidden sm:flex bg-[#4a40e0] text-white px-5 py-2 rounded-[12px] font-semibold text-[16px] shadow-sm hover:bg-[#3d30d4] transition-all">
                    Book New
                </a>

                <div class="relative group">
                    <button
                        class="w-10 h-10 rounded-full border-2 border-[#9795ff] p-[2px] overflow-hidden transition-transform active:scale-95">
                        <img src="https://i.pravatar.cc/100?u={{ Auth::user()->email }}" alt="Avatar"
                             class="w-full h-full rounded-full object-cover">
                    </button>

                    <div
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                        <div class="px-4 py-2 border-b border-slate-50">
                            <p class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-rose-600 font-semibold hover:bg-rose-50 transition">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>

            @else
                <a href="{{ route('login') }}"
                   class="text-sm font-semibold text-[#4d5d73] hover:text-[#4a40e0] transition">Log in</a>
                <a href="{{ route('register') }}"
                   class="bg-[#4a40e0] text-white px-5 py-2.5 rounded-[12px] text-sm font-bold shadow-lg shadow-indigo-200/50 hover:bg-[#3d30d4] transition">
                    Get Started
                </a>
            @endauth
        </div>
    </div>
</nav>
