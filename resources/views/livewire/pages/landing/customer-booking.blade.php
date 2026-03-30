<div class="min-h-screen bg-[#f4f6ff] font-['Inter',sans-serif] flex flex-col relative">

    <div id="modal-container">
        @if($lastBooking)
            <x-success-booking-modal wire:model="showSuccess" :appointment="$lastBooking" />
        @endif
    </div>

    <main class="flex-grow w-full max-w-[1536px] mx-auto flex flex-col lg:flex-row relative pb-[160px] lg:pb-12 pt-8">

        <div class="w-full lg:w-[60%] p-6 lg:p-12 space-y-12">
            <section>
                <div class="mb-6">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Select Service</h1>
                    <p class="text-slate-500 text-lg">Choose the treatment you deserve.</p>
                </div>

                <div class="bg-white rounded-xl flex items-center px-4 py-3 shadow-sm border border-slate-100 mb-6">
                    <svg class="w-5 h-5 text-slate-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Search for a service (e.g., Fade, Shave)..." class="bg-transparent border-none focus:ring-0 w-full text-slate-600 placeholder-slate-400 p-0">
                </div>

                <div class="space-y-4">
                    @foreach($services as $service)
                        <button wire:click="selectService({{ $service->id }})"
                                class="w-full text-left relative transition-all duration-200 p-6 rounded-2xl border-2
                             {{ $selectedServiceId == $service->id ? 'bg-indigo-50 border-indigo-600 shadow-sm' : 'bg-white border-transparent shadow-sm hover:border-indigo-100' }}">

                            <div class="flex justify-between items-start">
                                <div class="space-y-3">
                                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider
                                        {{ $selectedServiceId == $service->id ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $service->duration }} MIN
                                    </span>

                                    <h3 class="text-xl font-bold text-slate-900">{{ $service->name }}</h3>
                                    <p class="text-sm text-slate-500 max-w-[85%]">Professional treatment tailored to your styling needs.</p>
                                </div>
                                <span class="text-2xl font-black {{ $selectedServiceId == $service->id ? 'text-indigo-600' : 'text-slate-800' }}">
                                    ${{ number_format($service->price, 2, '.', ',') }}
                                </span>
                            </div>

                            @if($selectedServiceId == $service->id)
                                <div class="absolute -top-3 -right-3 bg-indigo-600 text-white rounded-full p-1.5 shadow-lg border-2 border-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            @endif
                        </button>
                    @endforeach
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Select Professional</h2>
                <div class="flex gap-6 overflow-x-auto pb-4 hide-scrollbar">
                    @foreach($employees as $employee)
                        <button wire:click="selectEmployee({{ $employee->id }})" class="flex flex-col items-center gap-3 min-w-[80px] group">
                            <div class="relative">
                                <div class="w-[84px] h-[84px] rounded-full p-1 transition-all {{ $selectedEmployeeId == $employee->id ? 'border-2 border-indigo-600' : 'border-2 border-transparent group-hover:border-indigo-200' }}">
                                    <img src="https://i.pravatar.cc/150?u={{ $employee->email }}" alt="{{ $employee->name }}" class="w-full h-full object-cover rounded-full {{ $selectedEmployeeId == $employee->id ? '' : 'grayscale-[30%] opacity-80' }}">
                                </div>
                                @if($selectedEmployeeId == $employee->id)
                                    <div class="absolute bottom-0 right-0 bg-indigo-600 text-white rounded-full p-1 border-2 border-white">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <span class="text-base font-bold {{ $selectedEmployeeId == $employee->id ? 'text-slate-900' : 'text-slate-500' }}">
                                {{ explode(' ', $employee->name)[0] }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="w-full lg:w-[40%] flex flex-col px-4 lg:px-8 mt-4 lg:mt-0">
            <div class="bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden lg:sticky lg:top-8 h-fit lg:max-h-[calc(100vh-80px)] flex flex-col">

                <div class="p-8 space-y-8 lg:overflow-y-auto flex-grow hide-scrollbar">

                    <section class="w-full h-auto overflow-visible">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-slate-900">{{ \Carbon\Carbon::parse($viewDate)->format('F Y') }}</h3>

                            <div class="flex gap-2">
                                <button wire:click="goToPreviousMonth"
                                        class="p-2 rounded-lg bg-slate-50 text-slate-400 hover:text-indigo-600 disabled:opacity-20"
                                    {{ \Carbon\Carbon::parse($viewDate)->isSameMonth(\Carbon\Carbon::tomorrow()) ? 'disabled' : '' }}>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </button>

                                <button wire:click="goToNextMonth" class="p-2 rounded-lg bg-slate-50 text-slate-400 hover:text-indigo-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-7 gap-1 text-center">
                            @foreach(['Mo','Tu','We','Th','Fr','Sa','Su'] as $dayName)
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">{{ $dayName }}</div>
                            @endforeach

                            @php
                                $startOfMonth = \Carbon\Carbon::parse($viewDate)->startOfMonth();
                                $endOfMonth = \Carbon\Carbon::parse($viewDate)->endOfMonth();
                                $dateIt = (clone $startOfMonth)->startOfWeek(\Carbon\Carbon::MONDAY);
                                $endGrid = (clone $endOfMonth)->endOfWeek(\Carbon\Carbon::SUNDAY);
                            @endphp

                            @while($dateIt <= $endGrid)
                                @php
                                    $currentItDate = $dateIt->format('Y-m-d');
                                    $isCurrentMonth = $dateIt->isSameMonth($startOfMonth);
                                    $isPast = $dateIt->isBefore(\Carbon\Carbon::tomorrow(), 'day');
                                @endphp

                                <div class="p-0.5">
                                    @if(!$isCurrentMonth)
                                        <div class="aspect-square"></div>
                                    @elseif($isPast)
                                        <div class="aspect-square flex items-center justify-center text-sm text-slate-200">
                                            {{ $dateIt->format('j') }}
                                        </div>
                                    @else
                                        <button wire:click="selectDate('{{ $currentItDate }}')"
                                                class="w-full aspect-square flex items-center justify-center rounded-xl transition-all text-sm
                            {{ $selectedDate == $currentItDate ? 'bg-indigo-600 text-white font-bold shadow-md' : 'text-slate-700 font-medium hover:bg-indigo-50' }}">
                                            {{ $dateIt->format('j') }}
                                        </button>
                                    @endif
                                </div>

                                @php $dateIt->addDay(); @endphp
                            @endwhile
                        </div>
                    </section>

                    <section>
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Available Times</h3>
                        <div class="grid grid-cols-3 gap-2">
                            @forelse($slots as $slot)
                                <button wire:click="selectTime('{{ $slot['raw'] }}')"
                                        {{ !$slot['available'] ? 'disabled' : '' }}
                                        class="py-2.5 rounded-xl text-[11px] font-bold transition-all border
                                        {{ !$slot['available'] ? 'bg-slate-50 border-transparent text-slate-300 line-through cursor-not-allowed' :
                                           ($selectedTime == $slot['raw'] ? 'bg-indigo-600 border-indigo-600 text-white shadow-md' : 'bg-white border-slate-200 text-indigo-600 hover:border-indigo-600') }}">
                                    {{ $slot['time'] }}
                                </button>
                            @empty
                                <div class="col-span-3 py-6 text-center text-sm font-medium text-slate-400 bg-slate-50 rounded-xl">
                                    No availability on this date.
                                </div>
                            @endforelse
                        </div>
                    </section>
                </div>

                <div class="bg-slate-50/80 backdrop-blur-sm p-8 border-t border-slate-100 mt-auto">
                    <div class="flex justify-between items-end mb-6">
                        <div class="space-y-1">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-1">Summary</p>
                            <p class="text-sm font-bold text-slate-900 truncate max-w-[200px]">
                                @if($selectedServiceId && $selectedTime)
                                    {{ $services->find($selectedServiceId)->name }} • {{ explode(' ', $employees->find($selectedEmployeeId)->name)[0] }}
                                @else
                                    Pending Selection...
                                @endif
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($selectedDate)->format('D, M d') }} @if($selectedTime) at {{ \Carbon\Carbon::parse($selectedTime)->format('h:i A') }} @endif
                            </p>
                        </div>
                        <div class="text-3xl font-black text-slate-900">
                            ${{ $selectedServiceId ? number_format($services->find($selectedServiceId)->price, 2, '.', ',') : '0' }}
                        </div>
                    </div>

                    <button wire:click="confirmAppointment"
                            {{ !$selectedTime ? 'disabled' : '' }}
                            class="w-full flex items-center justify-center gap-2 bg-indigo-600 text-white text-base font-bold py-4 rounded-2xl shadow-xl hover:bg-indigo-700 transition-all disabled:opacity-50 disabled:grayscale">
                        Confirm Appointment
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</div>
