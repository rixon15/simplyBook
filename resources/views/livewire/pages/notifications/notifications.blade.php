<div class="h-full bg-[#f4f6ff] py-20 px-4 sm:px-6 lg:px-8 font-['Inter',sans-serif]">

    <div class="max-w-[800px] mx-auto space-y-10">

        @if($isEmpty)
            <div class="flex flex-col items-center">
                <div class="mb-8 flex flex-col items-center">
                    <h1 class="text-[30px] font-extrabold text-[#203044] tracking-tight">Notifications</h1>
                    <div class="bg-[#4a40e0] h-1 w-12 rounded-full opacity-20 mt-2"></div>
                </div>

                <div class="bg-white w-full rounded-[24px] shadow-sm py-20 px-6 flex flex-col items-center justify-center text-center relative overflow-hidden">

                    <div class="absolute bg-[rgba(74,64,224,0.05)] blur-[32px] rounded-full w-[192px] h-[192px] z-0"></div>

                    <div class="relative z-10 mb-8">
                        <div class="bg-[#eaf1ff] rounded-full w-32 h-32 flex items-center justify-center">
                            <svg class="w-12 h-12 text-[#4a40e0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-white p-1.5 rounded-full shadow-sm border border-slate-50">
                            <div class="bg-[#4a40e0] rounded-full p-1 text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <h2 class="text-[24px] font-bold text-[#203044] mb-3 z-10">All caught up!</h2>
                    <p class="text-[#4d5d73] text-[16px] max-w-sm z-10">You don't have any new notifications at the moment.</p>

                    <div class="flex flex-wrap gap-4 mt-10 z-10">
                        <button wire:click="$refresh" class="bg-[#d2e4ff] text-[#4a40e0] font-semibold px-6 py-3 rounded-xl hover:bg-[#c1d8ff] transition-colors">
                            Refresh
                        </button>
                        <a href="/bookings" class="bg-[#4a40e0] text-white font-semibold px-6 py-3 rounded-xl shadow-[0_10px_15px_-3px_rgba(74,64,224,0.2)] hover:bg-[#3d30d4] transition-colors">
                            Go to Dashboard
                        </a>
                    </div>
                </div>

                <p class="text-[10px] uppercase tracking-widest text-[#4d5d73]/60 mt-8 font-medium">
                    Last synced: Just Now
                </p>
            </div>

        @else
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-[36px] font-extrabold text-[#203044] tracking-tight leading-none mb-2">Notifications</h1>
                    <p class="text-[#4d5d73] text-[16px]">Manage your schedule updates and alerts.</p>
                </div>

                @if($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="border border-[rgba(158,174,199,0.3)] text-[#4a40e0] font-semibold px-5 py-2.5 rounded-xl hover:bg-white transition-colors text-[14px]">
                        Mark all as read
                    </button>
                @endif
            </div>

            <div class="bg-white rounded-[32px] shadow-[0px_20px_40px_-12px_rgba(32,48,68,0.08)] overflow-hidden">

                @foreach(['Today', 'Yesterday', 'Older'] as $groupName)
                    @if(isset($groupedNotifications[$groupName]) && $groupedNotifications[$groupName]->count() > 0)

                        <div class="px-8 pt-8 pb-4">
                            <h3 class="text-[11px] font-bold uppercase tracking-[1.65px] text-[#4d5d73] mb-4">
                                {{ $groupName }}
                            </h3>

                            <div class="space-y-2">
                                @foreach($groupedNotifications[$groupName] as $notification)
                                    @php
                                        $type = $notification->data['type'] ?? 'info';
                                        $isUnread = $notification->unread();

                                        $colors = match($type) {
                                            'success' => ['bg' => 'bg-[#16a34a]/10', 'icon' => 'text-[#16a34a]'],
                                            'error' => ['bg' => 'bg-[#b41340]/10', 'icon' => 'text-[#b41340]'],
                                            default => ['bg' => 'bg-[#4a40e0]/10', 'icon' => 'text-[#4a40e0]'],
                                        };

                                        $wrapperClass = $isUnread ? 'bg-[#f4f6ff]/50 hover:bg-[#f4f6ff]' : 'hover:bg-slate-50';
                                    @endphp

                                    <div x-data="{ unread: '{{ $isUnread }}' }"
                                         @click="if(unread) { unread = false; $wire.markAsRead('{{ $notification->id }}') }"
                                         wire:key="notification-{{ $notification->id }}"
                                         class="relative flex flex-col sm:flex-row gap-4 sm:items-start p-5 rounded-2xl cursor-pointer transition-colors {{ $wrapperClass }}">

                                        <div x-show="unread" class="absolute left-2 top-1/2 -translate-y-1/2 w-1.5 h-1.5 bg-[#4a40e0] rounded-full"></div>

                                        <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 {{ $colors['bg'] }}">
                                            @if($type === 'success')
                                                <svg class="w-5 h-5 {{ $colors['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            @elseif($type === 'error')
                                                <svg class="w-5 h-5 {{ $colors['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            @else
                                                <svg class="w-5 h-5 {{ $colors['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @endif
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-[16px] font-bold text-[#203044] mb-1">
                                                {{ $notification->data['title'] }}
                                            </h4>
                                            <p class="text-[14px] text-[#4d5d73] leading-relaxed">
                                                {{ $notification->data['message'] }}
                                            </p>
                                        </div>

                                        <div class="shrink-0 sm:pt-1">
                                            <span class="text-[11px] font-semibold text-[#4d5d73]/60 whitespace-nowrap">
                                                {{ $notification->created_at->diffForHumans(null, true, true) }} ago
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if(!$loop->last)
                            <hr class="border-slate-100 mx-8">
                        @endif

                    @endif
                @endforeach

                <div class="bg-[#f8fafc] px-8 py-6 text-center border-t border-slate-100 mt-4">
                    <div class="inline-flex items-center gap-2 bg-[#eaf1ff] px-4 py-2 rounded-full">
                        <svg class="w-4 h-4 text-[#4a40e0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-[12px] font-bold text-[#4d5d73] uppercase tracking-[1.2px]">History is synchronized</span>
                    </div>
                </div>

            </div>
        @endif
    </div>
</div>
