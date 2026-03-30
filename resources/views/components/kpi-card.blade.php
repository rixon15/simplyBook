@props(['title', 'value', 'trend', 'trendColor' => 'text-gray-500', 'icon' => 'revenue'])

<div class="bg-white rounded-[12px] p-5 shadow-[0px_20px_40px_-12px_rgba(32,48,68,0.06)] flex flex-col justify-between min-h-[160px] relative overflow-hidden group">

    {{-- Decorative Side Border for "Active" feeling --}}
    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#4a40e0] opacity-0 group-hover:opacity-100 transition-opacity"></div>

    <div class="flex items-start justify-between relative z-10">
        {{-- Icon Overlay matching your Figma style --}}
        <div class="size-10 rounded-lg flex items-center justify-center
            @if($icon === 'revenue') bg-[#9795ff]/20 text-[#4a40e0]
            @elseif($icon === 'calendar') bg-[#d8caff]/20 text-[#6249B2]
            @elseif($icon === 'pending') bg-[#fff1f2] text-[#f43f5e]
            @else bg-slate-100 text-slate-500 @endif">

            @if($icon === 'revenue')
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM12 2a10 10 0 100 20 10 10 0 000-20z" /></svg>
            @elseif($icon === 'calendar')
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            @elseif($icon === 'pending')
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            @else
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            @endif
        </div>

    </div>

    <div class="space-y-1 relative z-10">
        <p class="text-[12px] font-medium text-[#4d5d73]">{{ $title }}</p>
        <p class="text-[24px] font-bold text-[#203044] tracking-tight leading-none">{{ $value }}</p>
    </div>
</div>
