<x-layouts.dashboard>
    <div class="content-stretch flex flex-col gap-[48px] items-start p-[32px] w-full">

        <div class="flex justify-between w-full">
            <h1 class="text-[36px] font-extrabold text-[#203044]">Dashboard Overview</h1>
            <span class="text-[#4d5d73]">Today, {{ now()->format('F jS') }}</span>
        </div>

        <div class="gap-x-[24px] gap-y-[24px] grid grid-cols-4 w-full">
            <x-kpi-card title="Today's Revenue" value="$450.00" trend="+12%" trendColor="text-green-600" />
            <x-kpi-card title="Appointments" value="18" trend="3 Pending" trendColor="text-orange-500" />
            <x-kpi-card title="New Customers" value="4" trend="this week" trendColor="text-gray-500" />
            <x-kpi-card title="Active Staff" value="3/5" trend="on shift" trendColor="text-gray-500" />
        </div>

        <div class="grid grid-cols-3 gap-[32px]">
            <livewire:components.todays-schedule class="col-span-2" />
            <livewire:components.recent-activity-feed class="col-span-1" />
        </div>

    </div>
</x-layouts.dashboard>
