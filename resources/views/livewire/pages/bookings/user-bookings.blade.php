<div
    class="min-h-screen bg-[#f8faff] font-['Inter',sans-serif] flex flex-col relative overflow-x-hidden pb-[96px] md:pb-0">

    <div
        class="fixed top-0 right-0 w-[600px] h-[600px] bg-gradient-to-bl from-[#4a40e0]/5 to-transparent blur-[100px] rounded-full pointer-events-none z-0"></div>
    <div
        class="fixed bottom-0 left-0 w-[400px] h-[400px] bg-gradient-to-tr from-[#983772]/5 to-transparent blur-[100px] rounded-full pointer-events-none z-0"></div>

    <main class="flex-grow w-full max-w-[1280px] mx-auto relative z-10 flex flex-col items-center px-6">

        @if($this->upcomingAppointments->isEmpty() && $this->appointmentHistory->isEmpty())
            <div class="flex flex-col items-center justify-center w-full py-12 md:py-20">
                <div class="relative w-full max-w-[450px] mb-16">
                    <div
                        class="absolute -right-12 -top-12 w-20 h-20 bg-[#f4eef2]/80 backdrop-blur-md rounded-3xl flex items-center justify-center rotate-12 z-20 hidden md:flex border border-white/50 shadow-sm">
                        <svg class="w-8 h-8 text-[#983772]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 16l2 2 4-4"></path>
                        </svg>
                    </div>
                    <div
                        class="absolute -left-12 -bottom-4 w-16 h-16 bg-[#eef0fc]/80 backdrop-blur-md rounded-full flex items-center justify-center -rotate-12 z-20 hidden md:flex border border-white/50 shadow-sm">
                        <svg class="w-8 h-8 text-[#4a40e0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>

                    <div
                        class="w-full bg-white rounded-[40px] shadow-[0_30px_60px_-12px_rgba(32,48,68,0.08)] p-10 md:p-14 flex flex-col items-center text-center relative z-10 border border-slate-50">
                        <div
                            class="w-[84px] h-[84px] bg-[#eaf1ff] rounded-[24px] flex items-center justify-center mb-8">
                            <svg class="w-10 h-10 text-[#4a40e0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-[32px] md:text-[38px] font-black text-[#203044] leading-[1.1] tracking-tight mb-4">
                            No upcoming<br>appointments
                        </h2>
                        <p class="text-[16px] md:text-[18px] text-[#4d5d73] leading-relaxed mb-10 max-w-[340px]">
                            Your dashboard is waiting for its first entry. Start organizing your time by scheduling your
                            first session.
                        </p>
                        <a href="{{ route('home') }}"
                           class="flex items-center justify-center gap-3 bg-[#4a40e0] text-white px-10 py-4 rounded-2xl font-bold text-lg shadow-[0_15px_30px_-5px_rgba(74,64,224,0.4)] hover:bg-[#3d30d4] transition-all hover:scale-105 active:scale-95">
                            Start Booking
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-[850px] z-10">
                    <div
                        class="bg-[#eaf1ff]/60 rounded-3xl p-8 flex flex-col items-center text-center border border-white">
                        <div class="w-10 h-10 text-[#4a40e0] mb-4">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-[#203044] text-base mb-2">Fast Scheduling</h4>
                        <p class="text-[13px] text-[#4d5d73] leading-relaxed">Book any service in under 30 seconds with
                            one-click presets.</p>
                    </div>
                    <div
                        class="bg-[#eaf1ff]/60 rounded-3xl p-8 flex flex-col items-center text-center border border-white">
                        <div class="w-10 h-10 text-[#4a40e0] mb-4">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-[#203044] text-base mb-2">Live Sync</h4>
                        <p class="text-[13px] text-[#4d5d73] leading-relaxed">Automatically updates across all your
                            connected devices instantly.</p>
                    </div>
                    <div
                        class="bg-[#eaf1ff]/60 rounded-3xl p-8 flex flex-col items-center text-center border border-white">
                        <div class="w-10 h-10 text-[#4a40e0] mb-4">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-[#203044] text-base mb-2">Secure Privacy</h4>
                        <p class="text-[13px] text-[#4d5d73] leading-relaxed">Your schedule is encrypted and visible
                            only to you and your provider.</p>
                    </div>
                </div>
            </div>

        @else
            <div class="w-full flex flex-col gap-10 md:gap-12 py-6 md:py-10">
                <header class="w-full">
                    <h1 class="text-3xl md:text-4xl font-black text-[#203044] tracking-tight mb-2">My Bookings</h1>
                    <p class="text-[#4d5d73] text-base md:text-lg">Manage your upcoming appointments and view your
                        service history.</p>
                </header>

                <div class="flex flex-col gap-6 md:gap-8">
                    <div
                        class="flex items-center justify-between sticky top-0 bg-[#f8faff]/90 backdrop-blur-md py-4 z-20 md:static md:bg-transparent md:py-0">
                        <h2 class="text-[#203044] md:text-[#4d5d73] text-lg md:text-base font-extrabold md:font-bold tracking-tight md:tracking-widest md:uppercase">
                            Upcoming Appointments
                        </h2>
                        <span
                            class="bg-[#9795ff] text-[#14007e] text-xs font-bold px-3 py-1 md:px-4 md:py-1.5 rounded-full uppercase tracking-wider">
                            {{ $this->upcomingAppointments->count() }} Pending
                        </span>
                    </div>

                    <div
                        class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 h-auto lg:max-h-[650px] overflow-visible lg:overflow-y-auto pr-0 lg:pr-4 custom-scrollbar pb-2 lg:pb-6 content-start auto-rows-max">
                        @foreach($this->upcomingAppointments as $booking)
                            <div
                                class="bg-white min-h-fit rounded-3xl shadow-[0_4px_20px_-2px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden relative flex flex-col lg:flex-row p-6 lg:p-8 gap-5 lg:gap-6 group hover:shadow-md transition-shadow">
                                <div
                                    class="absolute left-0 top-0 md:bottom-0 h-1.5 md:h-auto w-full md:w-1.5 bg-[#4a40e0]"></div>

                                <div
                                    class="bg-[#eaf1ff] rounded-2xl flex flex-row md:flex-col items-center justify-between md:justify-center p-4 md:min-w-[110px] mt-2 md:mt-0">
                                    <div class="flex flex-col md:items-center">
                                        <span
                                            class="text-[11px] md:text-sm font-bold text-[#4d5d73] uppercase tracking-widest hidden md:block">{{ $booking->start_time->format('M') }}</span>
                                        <span
                                            class="text-sm font-bold text-[#4d5d73] uppercase tracking-widest md:hidden">{{ $booking->start_time->format('F Y') }}</span>
                                        <span
                                            class="text-2xl md:text-[42px] font-black text-[#4a40e0] leading-none mt-1">{{ $booking->start_time->format('d') }}</span>
                                    </div>
                                    <div
                                        class="md:hidden bg-white border border-[#4a40e0]/10 px-3 py-1.5 rounded-lg flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-[#4a40e0]" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span
                                            class="text-xs font-bold text-[#203044]">{{ $booking->start_time->format('h:i A') }}</span>
                                    </div>
                                </div>

                                <div class="flex flex-col flex-grow justify-between">
                                    <div
                                        class="flex flex-col md:flex-row md:justify-between items-start gap-2 md:gap-0">
                                        <div class="flex flex-col gap-1">
                                            <h3 class="text-xl md:text-2xl font-bold text-[#203044]">{{ $booking->service->name }}</h3>
                                            <div
                                                class="hidden md:flex items-center gap-2 text-sm text-[#4d5d73] font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $booking->start_time->format('h:i A') }}
                                                — {{ $booking->end_time->format('h:i A') }}
                                            </div>
                                        </div>
                                        <span
                                            class="text-xl font-black text-[#983772]">${{ number_format($booking->service->price, 2) }}</span>
                                    </div>

                                    <div
                                        class="bg-slate-50/80 rounded-2xl p-3 flex items-center gap-4 mt-4 md:mt-4 border border-slate-100/50">
                                        <img src="https://i.pravatar.cc/150?u={{ $booking->employee->email }}"
                                             class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover">
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">
                                                Stylist</p>
                                            <p class="text-[14px] font-bold text-[#203044]">{{ $booking->employee->name }}</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 md:flex md:items-center gap-3 md:gap-4 mt-6">


                                        <button wire:click="confirmCancel({{ $booking->id }})"
                                                class="flex-1 md:p-4 border border-slate-200 rounded-xl py-3 text-sm font-bold text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-all">
                                            Cancel
                                        </button>
                                        <button wire:click="confirmReschedule({{ $booking->id }})"
                                                class="w-full md:flex-none md:px-6 flex items-center justify-center bg-[#eaf1ff] md:bg-transparent rounded-xl py-3 md:py-0 text-[#4a40e0] text-sm font-bold hover:underline transition-all">
                                            Reschedule
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col gap-6 md:gap-8 mt-4 md:mt-0">
                    <div class="flex items-center justify-between">
                        <h2 class="text-[#203044] md:text-[#4d5d73] text-lg md:text-base font-extrabold md:font-bold tracking-tight md:tracking-widest md:uppercase">
                            Appointment History
                        </h2>
                        <button
                            class="hidden md:flex text-[#4a40e0] text-sm font-bold items-center gap-2 hover:underline">
                            View All History
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 stroke-width="2.5">
                                <path d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>

                    @if($this->appointmentHistory->isNotEmpty())
                        <div
                            class="hidden md:block bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
                            <table class="w-full text-left">
                                <thead
                                    class="bg-[#eaf1ff]/30 text-[11px] font-bold text-[#4d5d73] uppercase tracking-widest border-b border-slate-50">
                                <tr>
                                    <th class="px-10 py-6">Service</th>
                                    <th class="px-10 py-6">Date</th>
                                    <th class="px-10 py-6">Staff</th>
                                    <th class="px-10 py-6 text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                @foreach($this->appointmentHistory as $history)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-10 py-6">
                                            <p class="font-bold text-[#203044] text-base">{{ $history->service->name }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Completed</p>
                                        </td>
                                        <td class="px-10 py-6 text-slate-500 font-medium">{{ $history->start_time->format('M d, Y') }}</td>
                                        <td class="px-10 py-6">
                                            <div class="flex items-center gap-3">
                                                <img src="https://i.pravatar.cc/100?u={{ $history->employee->email }}"
                                                     class="w-8 h-8 rounded-full shadow-sm">
                                                <span
                                                    class="text-sm font-bold text-[#203044]">{{ explode(' ', $history->employee->name)[0] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-10 py-6 text-right">
                                            <a href="{{ route('home') }}"
                                               class="inline-block bg-[#4a40e0] text-white text-[11px] font-bold px-5 py-2.5 rounded-xl shadow-sm hover:bg-[#3d30d4] transition-all">Book
                                                Again</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div
                            class="flex flex-col md:hidden w-full bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                            @foreach($this->appointmentHistory as $history)
                                <div
                                    class="flex items-center justify-between py-4 border-b border-slate-100/50 last:border-0">
                                    <div class="flex flex-col gap-1">
                                        <span
                                            class="text-base font-bold text-[#203044]">{{ $history->service->name }}</span>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="text-xs text-[#4d5d73]">{{ $history->start_time->format('M d, Y') }}</span>
                                            <div class="w-1 h-1 bg-slate-300 rounded-full"></div>
                                            <span
                                                class="text-xs text-[#4d5d73] font-medium">{{ explode(' ', $history->employee->name)[0] }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('home') }}"
                                       class="bg-[#4a40e0] px-4 py-2.5 rounded-full text-[10px] font-extrabold text-white uppercase tracking-widest shadow-sm">
                                        Book Again
                                    </a>
                                </div>
                            @endforeach
                            <a href="#"
                               class="mt-4 text-center text-xs font-bold text-[#4d5d73] uppercase tracking-widest py-3">
                                View Full History
                            </a>
                        </div>

                </div>
                @endif
            </div>
        @endif
    </main>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    <x-cancel-booking-modal
        wire:model="showCancelModal"
        :appointment="$selectedAppointment"
    />

    <x-reschedule-modal
        wire:model="showRescheduleModal"
        :appointment="$rescheduleAppointment"
        :viewDate="$rescheduleViewDate"
        :selectedDate="$rescheduleDate"
        :selectedTime="$rescheduleTime"
        :slots="$this->rescheduleSlots()"  />
</div>
