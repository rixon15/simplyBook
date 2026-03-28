@props(['title', 'value', 'trend', 'trendColor' => 'text-green-600'])

<div class="bg-white h-[128px] justify-self-stretch relative rounded-[12px] shrink-0 shadow-sm">
    <div class="content-stretch flex flex-col items-start justify-between p-[24px] relative size-full">
        <div class="content-stretch flex items-start justify-between relative shrink-0 w-full">
            <div class="font-['Inter:Bold'] font-bold text-[#4d5d73] text-[12px] tracking-[1.2px] uppercase">
                {{ $title }}
            </div>
        </div>

        <div class="h-[36px] relative shrink-0 w-full flex items-center justify-between mt-4">
            <div class="font-['Inter:Bold'] font-bold text-[#203044] text-[30px]">
                {{ $value }}
            </div>
            <div class="font-['Inter:Bold'] font-bold text-[12px] {{ $trendColor }}">
                {{ $trend }}
            </div>
        </div>
    </div>
</div>
