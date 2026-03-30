<div x-data="{ open: false }" @click.outside="open = false" class="relative z-50" wire:poll.10s>

    <button @click="open = !open" class="relative p-2 text-[#4d5d73] hover:bg-[#eaf1ff] rounded-xl transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>

        @if($notifications->count() > 0)
            <span class="absolute top-1.5 right-2 block h-2.5 w-2.5 rounded-full bg-[#4a40e0] ring-2 ring-white"></span>
        @endif
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
         style="display: none;"
         class="absolute right-0 mt-4 w-[390px] md:w-[448px] bg-white rounded-2xl shadow-[0px_20px_40px_-12px_rgba(32,48,68,0.15)] border border-[#9eaec7]/10 z-[100] overflow-hidden flex flex-col max-h-[calc(100vh-6rem)] sm:max-h-[80vh]">

        <div class="flex items-center justify-between px-6 py-5 border-b border-[#eaf1ff] shrink-0">
            <h3 class="text-[18px] font-bold text-[#203044]">Notifications</h3>
            @if($notifications->count() > 0)
                <button wire:click="markAllAsRead" class="text-[12px] font-semibold text-[#4a40e0] hover:underline">
                    Mark all as read
                </button>
            @endif
        </div>

        <div class="overflow-y-auto flex-1">
            @forelse($notifications as $notification)
                @php
                    $type = $notification->data['type'] ?? 'info';
                    $bgClass = match($type) {
                        'success' => 'bg-[#4a40e0]/10 text-[#4a40e0]',
                        'error' => 'bg-[#b41340]/10 text-[#b41340]',
                        default => 'bg-[#d2e4ff] text-[#68788f]',
                    };
                @endphp

                <div x-data="{ visible: true }"
                     wire:key="notification-{{ $notification->id }}"
                     x-show="visible"
                     x-transition.opacity.duration.300ms>

                    <div @click="visible = false; $wire.markAsRead('{{$notification->id}}')"
                         class="relative flex gap-4 px-6 py-4 hover:bg-[#f4f6ff] transition-colors cursor-pointer group">

                        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 {{ $bgClass }}">
                            @if($type === 'success')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"></path>
                                </svg>
                            @elseif($type === 'error')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                        </div>

                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                {{-- Handle both 'title' or 'user + action' format --}}
                                <p class="text-[16px] font-semibold text-[#203044]">
                                    {{ $notification->data['title'] ?? ($notification->data['user'] . ' ' . ($notification->data['action'] ?? 'updated')) }}
                                </p>
                                <span class="text-[11px] uppercase tracking-wider text-[#4d5d73]"> {{ $notification->created_at->diffForHumans(null, true, true) }} ago </span>
                            </div>

                            {{-- Handle both 'message' or 'subject' format --}}
                            <p class="text-[16px] text-[#4d5d73] leading-snug mt-0.5">
                                {{ $notification->data['message'] ?? ($notification->data['subject'] ?? 'New activity recorded') }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div wire:key="empty-notifications-state" class="px-6 py-12 text-center">
                    <p class="text-[#4d5d73] text-sm">You're all caught up!</p>
                </div>
            @endforelse
        </div>

        <div class="p-4 border-t border-[#eaf1ff] text-center bg-white shrink-0">
            <a href="{{ $this->decideRoute() }}" class="text-[14px] font-semibold text-[#4a40e0] hover:underline">
                View All Notifications
            </a>
        </div>
    </div>
</div>
