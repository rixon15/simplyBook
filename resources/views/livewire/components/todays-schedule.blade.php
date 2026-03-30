<div class="bg-white rounded-3xl shadow-sm p-4 md:p-8 w-full">
    <div class="flex items-center justify-between mb-6 shrink-0">
        <h3 class="text-lg font-bold text-[#203044]">Today's Schedule</h3>
        <a href="{{ route('appointments') }}" class="text-[#4a40e0] text-xs font-semibold">View All</a>
    </div>

    <div class="space-y-4">
        @foreach($appointments as $appt)
            <div class="relative flex items-center w-full group">
                <div class="w-[45px] md:w-[80px] shrink-0 flex flex-col items-center md:items-start">
                    <span class="text-[13px] md:text-base font-bold text-[#4a40e0] md:text-[#203044]">
                        {{ date('g:i', strtotime($appt['time'])) }}
                    </span>
                    <span class="text-[9px] md:text-xs font-medium text-[#4d5d73] uppercase">
                        {{ date('A', strtotime($appt['time'])) }}
                    </span>
                </div>

                <div class="absolute left-[54px] md:left-[88px] top-0 bottom-0 w-[3px] rounded-full {{ $appt['indicator_color'] }}"></div>

                <div
                    class="flex-1 ml-6 md:ml-10 bg-[#f4f6ff] rounded-2xl p-3 md:p-4 flex items-center gap-3 cursor-pointer md:cursor-default"
                    @click="window.innerWidth < 768 ? $dispatch('open-status-modal', { id: {{ $appt['id'] }} }) : null"
                >
                    <x-todays-schedule-status-change-modal-mobile
                        :appointmentId="$appt['id']"
                        :customerName="$appt['customer']"
                        :currentStatus="$appt['status_color']"
                    />

                    <div class="size-10 rounded-full bg-[#dce9ff] hidden md:flex items-center justify-center border-2 border-white shrink-0 text-[#4a40e0] font-bold text-xs">
                        {{ collect(explode(' ', $appt['customer']))->map(fn($n) => $n[0])->join('') }}
                    </div>

                    <div class="flex-1 min-w-0 flex flex-col justify-center">
                        <h4 class="text-sm font-bold text-[#203044] truncate">{{ $appt['customer'] }}</h4>
                        <div class="mt-1">
                            <span class="inline-block bg-[#d8caff] text-[#4e339c] text-[9px] font-black uppercase px-1.5 py-0.5 rounded-sm whitespace-nowrap truncate max-w-[120px] md:max-w-full">
                                {{ $appt['service'] }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 md:gap-4 shrink-0">
                        <div class="px-2 py-2 rounded-full text-center min-w-[65px] md:min-w-[90px]
                        @switch($appt['status_color'])
                            @case('completed') bg-emerald-100 text-emerald-700 @break
                            @case('confirmed') bg-indigo-100 text-indigo-700 @break
                            @case('pending')   bg-amber-100 text-amber-700 @break
                            @case('canceled')  bg-rose-100 text-rose-700 @break
                            @case('noshow')    bg-slate-100 text-slate-600 @break
                            @default           bg-gray-100 text-gray-600
                        @endswitch">
                        <span class="text-[9px] font-bold uppercase tracking-tight flex items-center justify-center">
                            {{ $appt['status'] }}
                        </span>
                        </div>

                        <x-todays-schedule-status-change-modal
                            :appointmentId="$appt['id']"
                            :customerName="$appt['customer']"
                            :currentStatus="$appt['status_color']"
                        />
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>
