<div
    class="bg-white rounded-[12px] shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] p-[32px] w-full flex flex-col gap-[32px] max-w-[480px] min-h-full">

    <div class="flex items-center justify-between">
        <h3 class="text-[20px] font-bold text-[#203044]">Recent Activity</h3>
        <button class="text-[#4d5d73] hover:text-[#203044] transition-colors">
        </button>
    </div>

    <div class="relative flex flex-col gap-[32px] pb-[8px]">
        <div class="absolute left-[18px] top-[8px] bottom-[16px] w-px bg-[#9eaec7]/20"></div>

        @foreach($activities as $activity)
            <div class="relative flex gap-[16px] items-start z-10">

                <div
                    class="{{ $activity['icon_bg'] }} {{ $activity['icon_color'] }} size-[36px] rounded-full flex items-center justify-center shrink-0 shadow-[0_0_0_4px_white]">
                    @switch($activity['type'])
                        @case('booking')
                            <svg class="size-[15px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            @break
                        @case('cancellation')
                            <svg class="size-[15px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            @break
                            {{-- ... other cases ... --}}

                        @default
                            {{-- Default "Info" or "Booking" icon if the type doesn't match --}}
                            <svg class="size-[15px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                    @endswitch
                </div>

                <div class="flex flex-col gap-[4px]">
                    <div class="text-[14px] leading-[20px] text-[#203044]">
                        <span class="font-bold">{{ $activity['user'] }}</span>
                        <span class="text-[#4d5d73]">{{ $activity['action'] }}</span>
                        <span class="font-medium text-[#4a40e0]">{{ $activity['subject'] }}</span>
                        @if($activity['extra'])
                            <span class="text-[#4d5d73]">{{ $activity['extra'] }}</span>
                        @endif
                    </div>
                    <span class="text-[12px] text-[#4d5d73]">{{ $activity['time'] }}</span>
                </div>

            </div>
        @endforeach
    </div>

    <a href="{{route('admin.notifications')}}">
        <button
            class="bg-[#eaf1ff] text-[#4d5d73] font-bold text-[14px] py-[12px] rounded-[12px] w-full hover:bg-[#dce9ff] transition-all">
            View All Activity
        </button>
    </a>
</div>
