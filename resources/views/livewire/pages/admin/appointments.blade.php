<div class="content-stretch flex flex-col gap-[32px] items-start p-[24px] lg:p-[32px] relative size-full">

    {{-- ========================================== --}}
    {{-- DESKTOP HEADER (Hidden on Mobile)          --}}
    {{-- ========================================== --}}
    <div class="hidden lg:flex items-end justify-between w-full">
        <div class="flex flex-col gap-1">
            <h1 class="font-extrabold text-[#203044] text-[30px] tracking-tight">Schedule</h1>
            <div class="flex items-center gap-2 text-[#4d5d73]">
                <svg class="w-4 h-4 text-[#4a40e0]" fill="currentColor" viewBox="0 0 20 20"><path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"/></svg>
                <span class="font-medium text-sm">
                    @if($viewType === 'week')
                        Week of {{ \Carbon\Carbon::parse($selectedDate)->startOfWeek()->format('F j, Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($selectedDate)->format('l, F j, Y') }}
                    @endif
                </span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            {{-- Navigation Controls --}}
            <div class="bg-[#eaf1ff] flex items-center p-1 rounded-xl">
                <button wire:click="prevDay" class="p-2 hover:bg-white rounded-lg transition-all text-[#4a40e0]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button wire:click="goToToday" class="px-4 py-1 text-[11px] font-black uppercase text-[#203044] tracking-wider">
                    {{ $this->dateLabel }}
                </button>
                <button wire:click="nextDay" class="p-2 hover:bg-white rounded-lg transition-all text-[#4a40e0]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            {{-- View Mode Toggle --}}
            <div class="bg-[#eaf1ff] flex items-center p-1 rounded-xl">
                <button wire:click="setView('day')" class="px-5 py-1.5 rounded-lg text-xs font-bold transition-all {{ $viewType === 'day' ? 'bg-white shadow-sm text-[#4a40e0]' : 'text-[#4d5d73] hover:text-[#203044]' }}">DAY</button>
                <button wire:click="setView('week')" class="px-5 py-1.5 rounded-lg text-xs font-bold transition-all {{ $viewType === 'week' ? 'bg-white shadow-sm text-[#4a40e0]' : 'text-[#4d5d73] hover:text-[#203044]' }}">WEEK</button>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- MOBILE HEADER (Hidden on Desktop)          --}}
    {{-- ========================================== --}}
    <div class="flex lg:hidden top-0 z-30 bg-[#f4f6ff]/95 backdrop-blur-md py-4 w-full justify-between items-center border-b border-slate-100 -mx-6 px-6 -mt-6">
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-[#4a40e0] tracking-[1.2px] uppercase">{{ $this->dateLabel }}</span>
            <h2 class="text-[18px] font-black text-[#203044] tracking-tight">
                {{ \Carbon\Carbon::parse($selectedDate)->format('M jS') }}
            </h2>
        </div>

        <div class="flex gap-2">
            <div class="bg-[#eaf1ff] flex p-0.5 rounded-lg">
                <button wire:click="setView('day')" class="px-3 py-1 rounded-md text-[10px] font-bold {{ $viewType === 'day' ? 'bg-white shadow-sm text-[#4a40e0]' : 'text-[#4d5d73]' }}">DAY</button>
                <button wire:click="setView('week')" class="px-3 py-1 rounded-md text-[10px] font-bold {{ $viewType === 'week' ? 'bg-white shadow-sm text-[#4a40e0]' : 'text-[#4d5d73]' }}">WEEK</button>
            </div>
            <div class="flex gap-1">
                <button wire:click="prevDay" class="p-2 bg-[#eaf1ff] text-[#4a40e0] rounded-lg"><svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg></button>
                <button wire:click="nextDay" class="p-2 bg-[#eaf1ff] text-[#4a40e0] rounded-lg"><svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg></button>
            </div>
        </div>
    </div>


    {{-- ========================================== --}}
    {{-- DESKTOP CALENDAR GRID                      --}}
    {{-- ========================================== --}}
    <div class="hidden lg:flex bg-white rounded-[24px] border border-slate-100 shadow-sm w-full overflow-hidden flex-col">
        @php
            $staffCount = $this->employees->count();
            $gridCols = $viewType === 'week' ? 7 : ($staffCount > 0 ? $staffCount : 1);
        @endphp

        {{-- Dynamic Header: Columns are Staff (Day View) or Weekdays (Week View) --}}
        <div class="grid bg-white border-b border-slate-100" style="grid-template-columns: 100px repeat({{ $gridCols }}, minmax(0, 1fr));">
            <div class="border-r border-slate-100 h-24 flex items-center justify-center bg-white z-20">
                <span class="text-[10px] font-black uppercase text-slate-300 rotate-90 tracking-[2px]">Time</span>
            </div>

            @if($viewType === 'day')
                @foreach($this->employees as $staff)
                    <div class="flex flex-col items-center justify-center p-4 border-r border-slate-100 last:border-r-0">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($staff->name) }}&background=eaf1ff&color=4a40e0" class="w-12 h-12 rounded-full mb-2 border-2 border-slate-50 shadow-sm">
                        <span class="text-sm font-bold text-[#203044]">{{ explode(' ', $staff->name)[0] }}</span>
                    </div>
                @endforeach
            @else
                @for($d = 0; $d < 7; $d++)
                    @php
                        $day = \Carbon\Carbon::parse($selectedDate)->startOfWeek()->addDays($d);
                        $isCurrent = $day->isToday();
                    @endphp
                    <div class="flex flex-col items-center justify-center p-4 border-r border-slate-100 last:border-r-0 {{ $isCurrent ? 'bg-indigo-50/30' : '' }}">
                        <span class="text-[10px] font-bold uppercase mb-1 {{ $isCurrent ? 'text-[#4a40e0]' : 'text-slate-400' }}">{{ $day->format('D') }}</span>
                        <span class="text-xl font-black {{ $isCurrent ? 'text-[#4a40e0]' : 'text-[#203044]' }}">{{ $day->format('j') }}</span>
                    </div>
                @endfor
            @endif
        </div>

        <div class="relative h-[650px] overflow-y-auto custom-scrollbar">
            <div class="grid min-h-full py-4" style="grid-template-columns: 100px repeat({{ $gridCols }}, minmax(0, 1fr));">

                {{-- Time Markers --}}
                <div class="bg-white border-r border-slate-100 left-0 z-20">
                    @for($i = 9; $i <= 17; $i++)
                        <div class="h-16 flex items-start justify-center border-b border-slate-50 last:border-0 relative">
                            <span class="text-[10px] font-bold text-[#4d5d73] uppercase -mt-2 bg-white px-2 tracking-tight">{{ date('h:i A', mktime($i, 0)) }}</span>
                        </div>
                    @endfor
                </div>

                {{-- Day View Body --}}
                @if($viewType === 'day')
                    @foreach($this->employees as $staff)
                        <div class="relative border-r border-slate-100 last:border-r-0">
                            @for($i = 9; $i <= 17; $i++) <div class="h-16 border-b border-slate-50 last:border-0"></div> @endfor

                            @foreach($this->appointments->where('employee_id', $staff->id) as $appt)
                                @php $pos = $this->getPosition($appt); $duration = $appt->start_time->diffInMinutes($appt->end_time); @endphp
                                <div class="absolute left-2 right-2 rounded-lg px-3 py-1.5 bg-[#9795ff] border-l-4 border-[#4a40e0] shadow-sm z-10 overflow-hidden flex flex-col justify-center transition-all hover:brightness-105 cursor-pointer"
                                     style="top: {{ $pos['top'] }}; height: {{ $pos['height'] }}; min-height: 24px;">
                                    <p class="text-[11px] font-bold text-[#14007e] leading-tight truncate">{{ $appt->service->name }}</p>
                                    @if($duration > 30) <p class="text-[9px] font-medium text-[#14007e]/80 truncate mt-0.5">{{ $appt->user->name }}</p> @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                        {{-- Week View Body with Collision Detection --}}
                @elseif($viewType === 'week')
                    @for($d = 0; $d < 7; $d++)
                        @php
                            $curr = \Carbon\Carbon::parse($selectedDate)->startOfWeek()->addDays($d);

                            // Get all appointments for this day
                            $dayAppts = $this->appointments->filter(fn($a) => \Carbon\Carbon::parse($a->start_time)->isSameDay($curr));

                            // Run the collision algorithm
                            $layout = $this->getOverlapLayout($dayAppts);
                        @endphp

                        <div class="relative border-r border-slate-100 last:border-r-0 {{ $curr->isToday() ? 'bg-indigo-50/10' : '' }}">
                            {{-- Background Grid Lines --}}
                            @for($i = 9; $i <= 17; $i++) <div class="h-16 border-b border-slate-50 last:border-0"></div> @endfor

                            {{-- Render Appointments --}}
                            @foreach($dayAppts as $appt)
                                @php
                                    $pos = $this->getPosition($appt);
                                    $colIndex = $layout['positions'][$appt->id] ?? 0;
                                    $width = $layout['width'];

                                    // Add a tiny gap between side-by-side blocks
                                    $leftOffset = $colIndex * $width;
                                @endphp

                                <div class="absolute rounded-md px-2 py-1.5 bg-[#9795ff] border-l-2 border-[#4a40e0] shadow-sm z-10 overflow-hidden flex flex-col justify-center hover:z-50 hover:brightness-110 hover:shadow-lg transition-all cursor-pointer ring-1 ring-white/30"
                                     style="top: {{ $pos['top'] }};
                                            height: {{ $pos['height'] }};
                                            width: calc({{ $width }}% - 2px);
                                            left: {{ $leftOffset }}%;
                                            min-height: 24px;">

                                    <p class="text-[10px] font-bold text-white leading-tight truncate drop-shadow-sm">
                                        {{ explode(' ', $appt->employee->name)[0] }}
                                    </p>
                                    @if($appt->start_time->diffInMinutes($appt->end_time) > 30)
                                        <p class="text-[8px] font-medium text-[#ebe9ff] truncate drop-shadow-sm">
                                            {{ $appt->service->name }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endfor
                @endif
            </div>

            {{-- Lunch Break Overlay --}}
            <div class="absolute left-[100px] right-0 top-[208px] h-16 pointer-events-none flex items-center justify-center z-20">
                <div class="absolute inset-0" style="background: repeating-linear-gradient(45deg, #eaf1ff, #eaf1ff 10px, transparent 10px, transparent 20px); opacity: 0.6;"></div>
                <span class="relative bg-white/95 px-5 py-1.5 rounded-full text-[10px] font-extrabold text-[#4d5d73] tracking-[2px] uppercase shadow-sm border border-slate-200">Lunch Break</span>
            </div>
        </div>
    </div>


    {{-- ========================================== --}}
    {{-- MOBILE VIEWS                               --}}
    {{-- ========================================== --}}
    <div class="flex lg:hidden flex-col w-full relative pb-10 mt-2">
        @if($viewType === 'day')
            {{-- DAY: Staff Slider & Hourly List --}}
            <div class="flex overflow-x-auto gap-6 py-6 px-6 mb-2 hide-scrollbar snap-x scroll-px-6 w-full -mx-6">
                @foreach($this->employees as $staff)
                    @php $isActive = $selectedMobileStaffId === $staff->id; @endphp
                    <div wire:click="selectMobileStaff({{ $staff->id }})" class="flex flex-col items-center gap-2 shrink-0 transition-all snap-start cursor-pointer">
                        <div class="relative p-1 rounded-full transition-all duration-300 {{ $isActive ? 'border-2 border-[#4a40e0] scale-110' : 'border-2 border-transparent opacity-50 grayscale' }}">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($staff->name) }}&background=eaf1ff&color=4a40e0" class="w-14 h-14 rounded-full object-cover shadow-sm">
                            @if($isActive) <div class="absolute bottom-0 right-0 bg-[#10b981] rounded-full w-4 h-4 border-2 border-white shadow-sm"></div> @endif
                        </div>
                        <span class="text-[12px] transition-all {{ $isActive ? 'font-bold text-[#4a40e0]' : 'font-medium text-[#4d5d73]' }}">{{ explode(' ', $staff->name)[0] }}</span>
                    </div>
                @endforeach
                <div class="shrink-0 w-4"></div>
            </div>

            <div class="relative mt-4">
                <div class="absolute left-[56px] top-0 bottom-0 w-px bg-slate-200"></div>
                @for($i = 9; $i <= 17; $i++)
                    @php
                        $hourAppts = $this->appointments->filter(function($appt) use ($i) {
                            return \Carbon\Carbon::parse($appt->start_time)->hour === $i && ($this->selectedMobileStaffId ? $appt->employee_id === $this->selectedMobileStaffId : true);
                        });
                    @endphp
                    <div class="flex gap-4 min-h-[80px] w-full relative mb-4">
                        <div class="w-[48px] shrink-0 flex flex-col items-end pt-1 bg-[#f4f6ff] z-10">
                            <span class="text-[14px] font-bold text-[#203044] leading-tight">{{ date('h:00', mktime($i, 0)) }}</span>
                            <span class="text-[10px] font-medium text-slate-400">{{ date('A', mktime($i, 0)) }}</span>
                        </div>
                        <div class="flex-1 flex flex-col gap-3">
                            @foreach($hourAppts as $appt)
                                <div @click="!@js($appt->status === 'completed') && $dispatch('open-status-modal', { id: {{ $appt->id }} })"
                                     class="bg-white rounded-2xl shadow-sm border-l-4 border-[#4a40e0] p-4 w-full active:scale-[0.98] transition-transform">
                                    <h4 class="text-[14px] font-bold text-[#203044]">{{ $appt->service->name }}</h4>
                                    <div class="flex items-center gap-2 mt-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($appt->employee->name) }}&background=eaf1ff&color=4a40e0" class="w-4 h-4 rounded-full">
                                        <span class="text-xs font-medium text-[#4d5d73]">{{ explode(' ', $appt->employee->name)[0] }}</span>
                                    </div>
                                    <x-todays-schedule-status-change-modal-mobile :appointmentId="$appt->id" :customerName="$appt->user->name" :currentStatus="$appt->status" />
                                </div>
                            @endforeach
                            @if($i === 12)
                                <div class="bg-indigo-50/50 border-2 border-dashed border-indigo-100 rounded-xl p-3 flex items-center gap-3">
                                    <div class="size-2 rounded-full bg-indigo-200"></div>
                                    <span class="text-[11px] font-bold text-indigo-400 uppercase tracking-widest">Lunch Break</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endfor
            </div>

        @else
            {{-- WEEK: List of daily summary cards --}}
            <div class="flex flex-col gap-6">
                @for($d = 0; $d < 7; $d++)
                    @php
                        $cDay = \Carbon\Carbon::parse($selectedDate)->startOfWeek()->addDays($d);
                        $dAppts = $this->appointments->filter(fn($a) => \Carbon\Carbon::parse($a->start_time)->isSameDay($cDay));
                        $isT = $cDay->isToday();
                    @endphp
                    <div class="bg-white rounded-[20px] shadow-sm border {{ $isT ? 'border-[#4a40e0] ring-1 ring-[#4a40e0]/10' : 'border-slate-100' }} overflow-hidden">
                        <div class="px-5 py-3 flex items-center justify-between {{ $isT ? 'bg-indigo-50/50' : 'bg-slate-50/30' }}">
                            <span class="font-bold text-sm {{ $isT ? 'text-[#4a40e0]' : 'text-[#203044]' }}">{{ $cDay->format('l, M j') }}</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $dAppts->count() }} Appts</span>
                        </div>
                        <div class="p-4 space-y-3">
                            @forelse($dAppts as $appt)
                                <div class="flex items-center gap-4 bg-slate-50/50 p-3 rounded-xl border border-slate-100">
                                    <div class="text-center w-12 border-r border-slate-200 pr-4">
                                        <div class="text-xs font-bold text-[#203044]">{{ $appt->start_time->format('h:i') }}</div>
                                        <div class="text-[9px] font-medium text-slate-400">{{ $appt->start_time->format('A') }}</div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-[13px] font-bold text-[#203044] truncate">{{ $appt->service->name }}</div>
                                        <div class="text-[11px] text-slate-500">{{ explode(' ', $appt->employee->name)[0] }}</div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-300 italic text-center py-2">Rest Day</p>
                            @endforelse
                        </div>
                    </div>
                @endfor
            </div>
        @endif
    </div>

    {{-- The Irreversible Done Modal --}}
    <x-mark-done-modal wire:model="showDoneModal" :appointment="$selectedAppointment" />
</div>
