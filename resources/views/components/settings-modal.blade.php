<div x-data="{ open: false }" @click.outside="open = false" class="relative z-50">

    <button @click="open = !open" class="p-[8px] text-[#4D5D73] hover:bg-gray-100 rounded-full transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
         style="display: none;"
         class="absolute right-0 mt-4 w-[240px] bg-white rounded-2xl shadow-[0px_20px_40px_-12px_rgba(32,48,68,0.15)] border border-[#9eaec7]/10 pt-2">

        <div class="px-4 py-2">
            <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">Personal</span>
        </div>

        <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-[14px] text-[#203044] hover:bg-[#f4f6ff] transition-colors">
            <svg class="w-4 h-4 text-[#4d5d73]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            My Profile
        </a>

        <a href="{{route('notification-preferences')}}" class="flex items-center gap-3 px-4 py-2.5 text-[14px] text-[#203044] hover:bg-[#f4f6ff] transition-colors">
            <svg class="w-4 h-4 text-[#4d5d73]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            Notification Preferences
        </a>

        @if(auth()->user()->role === 'admin')
            <div class="border-t border-[#eaf1ff] my-2"></div>

            <div class="px-4 py-2">
                <span class="text-[11px] font-bold text-[#4a40e0] uppercase tracking-wider">Workspace</span>
            </div>

            <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[14px] text-[#203044] hover:bg-[#f4f6ff] transition-colors">
                <svg class="w-4 h-4 text-[#4d5d73]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Business Settings
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[14px] text-[#203044] hover:bg-[#f4f6ff] transition-colors">
                <svg class="w-4 h-4 text-[#4d5d73]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                Billing & Subscription
            </a>
        @endif

        <div class="pt-[24px] shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-[rgba(180,19,64,0.05)] hover:bg-[rgba(180,19,64,0.1)] transition-colors flex gap-[12px] items-center justify-center py-[16px] rounded-b-2xl">
                    <svg class="w-5 h-5 text-[#B41340]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="font-['Inter'] font-bold text-[#b41340] text-[14px]">Log Out</span>
                </button>
            </form>
        </div>

    </div>
</div>
