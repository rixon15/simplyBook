<div class="flex flex-col gap-8 md:gap-12 w-full max-w-[1400px] mx-auto md:p-8 lg:p-10 no-scrollbar">

    <header class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div class="space-y-1">
            <span class="text-[10px] font-bold uppercase tracking-widest text-[#4d5d73] md:hidden">Today's Status</span>
            <h1 class="text-3xl md:text-[36px] font-extrabold text-[#203044] tracking-tight">Dashboard Overview</h1>
            <div class="flex items-center gap-2 text-[#4d5d73] text-sm md:text-base">
                <svg class="w-4 h-4 text-[#4a40e0] md:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                <span>{{ now()->format('M jS, Y') }}</span>
            </div>
        </div>
    </header>

    {{-- 'no-scrollbar' is a custom utility often used, or use 'scrollbar-hide' --}}
    <section class="w-full">
        <div class="flex overflow-x-auto no-scrollbar snap-x snap-mandatory lg:grid lg:grid-cols-5 gap-6 pb-4 md:pb-0 -mx-6 px-6 lg:mx-0 lg:px-0">

            <div class="snap-center shrink-0 w-[260px] lg:w-auto">
                <x-kpi-card title="Today's Revenue" value="${{ $revenue }}"  icon="revenue" />
            </div>

            <div class="snap-center shrink-0 w-[260px] lg:w-auto">
                <x-kpi-card title="Today's Appointments" value="{{ $appointmentsCount }}" icon="calendar" />
            </div>

            <div class="snap-center shrink-0 w-[260px] lg:w-auto">
                <x-kpi-card title="Pending Requests" value="{{ $totalPending }}" icon="pending" />
            </div>

            <div class="snap-center shrink-0 w-[260px] lg:w-auto">
                <x-kpi-card title="New Customers" value="{{ $newCustomers }}" icon="users" />
            </div>

            <div class="snap-center shrink-0 w-[260px] lg:w-auto">
                <x-kpi-card title="Active Staff" value="{{ $staffStats }}" icon="users" />
            </div>

        </div>
    </section>

    <div class="flex flex-col lg:flex-row gap-8 items-stretch w-full">

        <div class="flex-1 order-1 lg:order-1">
            <livewire:components.todays-schedule />
        </div>

        <div class="flex flex-col gap-8 w-full lg:max-w-[400px] shrink-0 order-2">
            <livewire:components.recent-activity-feed />

        </div>


        <x-mark-done-modal
            wire:model="showDoneModal"
            :appointment="$selectedAppointment"
        />
    </div>

</div>
