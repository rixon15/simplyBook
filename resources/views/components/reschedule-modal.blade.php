@props(['appointment', 'viewDate', 'selectedDate', 'selectedTime', 'slots'])

<x-modal {{ $attributes }}>
    <div class="bg-white rounded-[32px] overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">

        <div class="bg-[#eaf1ff] px-8 py-6 flex justify-between items-center shrink-0">
            <div>
                <h3 class="text-xl font-black text-[#203044]">Reschedule Appointment</h3>
                @if($appointment)
                    <p class="text-sm text-[#4d5d73] mt-1">
                        {{ $appointment->service->name }} with {{ explode(' ', $appointment->employee->name)[0] }}
                    </p>
                @endif
            </div>
            <button @click="show = false" class="text-[#9EAEC7] hover:text-[#4a40e0] transition-colors p-2 bg-white rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        @if($appointment)
            <div class="p-8 overflow-y-auto custom-scrollbar flex-grow space-y-8">

                <section>
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-base font-bold text-[#203044]">{{ \Carbon\Carbon::parse($viewDate)->format('F Y') }}</h4>
                        <div class="flex gap-2">
                            <button wire:click="previousRescheduleMonth" class="p-1.5 rounded-lg bg-slate-50 text-slate-400 hover:text-[#4a40e0]" {{ \Carbon\Carbon::parse($viewDate)->isSameMonth(\Carbon\Carbon::tomorrow()) ? 'disabled' : '' }}>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <button wire:click="nextRescheduleMonth" class="p-1.5 rounded-lg bg-slate-50 text-slate-400 hover:text-[#4a40e0]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-7 gap-1 text-center">
                        @foreach(['Mo','Tu','We','Th','Fr','Sa','Su'] as $dayName)
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ $dayName }}</div>
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
                                    <div class="aspect-square flex items-center justify-center text-sm text-slate-200">{{ $dateIt->format('j') }}</div>
                                @else
                                    <button wire:click="selectRescheduleDate('{{ $currentItDate }}')"
                                            class="w-full aspect-square flex items-center justify-center rounded-xl transition-all text-sm {{ $selectedDate == $currentItDate ? 'bg-[#4a40e0] text-white font-bold shadow-md' : 'text-slate-700 font-medium hover:bg-[#eaf1ff]' }}">
                                        {{ $dateIt->format('j') }}
                                    </button>
                                @endif
                            </div>
                            @php $dateIt->addDay(); @endphp
                        @endwhile
                    </div>
                </section>

                <section>
                    <h4 class="text-base font-bold text-[#203044] mb-3">Available Times</h4>
                    <div class="grid grid-cols-3 gap-2">
                        @forelse($slots as $slot)
                            <button wire:click="selectRescheduleTime('{{ $slot['raw'] }}')"
                                    {{ !$slot['available'] ? 'disabled' : '' }}
                                    class="py-2.5 rounded-xl text-[11px] font-bold transition-all border
                                    {{ !$slot['available'] ? 'bg-slate-50 border-transparent text-slate-300 line-through cursor-not-allowed' :
                                       ($selectedTime == $slot['raw'] ? 'bg-[#4a40e0] border-[#4a40e0] text-white shadow-md' : 'bg-white border-slate-200 text-[#4a40e0] hover:border-[#4a40e0]') }}">
                                {{ $slot['time'] }}
                            </button>
                        @empty
                            <div class="col-span-3 py-4 text-center text-sm text-slate-400 bg-slate-50 rounded-xl">No availability on this date.</div>
                        @endforelse
                    </div>
                </section>
            </div>

            <div class="p-6 border-t border-slate-100 bg-slate-50/50 shrink-0">
                <button wire:click="processReschedule" {{ !$selectedTime ? 'disabled' : '' }} class="w-full bg-[#4a40e0] text-white py-4 rounded-xl font-bold text-lg shadow-[0_10px_15px_-3px_rgba(74,64,224,0.2)] hover:bg-[#3d30d4] transition-all disabled:opacity-50 disabled:grayscale active:scale-95">
                    Confirm New Time
                </button>
            </div>
        @endif
    </div>
</x-modal>
