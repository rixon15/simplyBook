<aside class="bg-[#f8fafc] hidden lg:flex flex-col justify-between py-[32px] w-[256px] h-screen shrink-0 border-r border-gray-100 overflow-y-auto">

    <div>
        <div class="px-[32px] pb-[40px]">
            <div class="flex gap-[12px] items-center w-full">
                <div class="bg-[#4a40e0] flex h-[32px] w-[32px] items-center justify-center rounded-[8px] shrink-0">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 22h20L12 2z" />
                    </svg>
                </div>

                <div class="flex flex-col gap-[2px]">
                    <div class="font-['Inter'] font-bold text-[#0f172a] text-[20px] leading-none">
                        <p class="m-0">SimplyBook</p>
                    </div>
                    <div class="font-['Inter'] font-bold text-[#4d5d73] text-[10px] tracking-[1px] uppercase mt-1">
                        {{ auth()->user()->role === 'admin' ? 'Admin Portal' : 'Employee Portal' }}
                    </div>
                </div>
            </div>
        </div>

        <nav class="flex flex-col gap-[8px] px-[16px] w-full">

            @php $isDashboard = request()->routeIs('dashboard', 'admin.dashboard', 'employee.dashboard'); @endphp
            <a href="{{ route('dashboard') }}" wire:navigate class="relative w-full flex items-center py-[12px] {{ $isDashboard ? 'pl-[20px]' : 'pl-[16px]' }}">
                @if($isDashboard)
                    <div aria-hidden="true" class="absolute left-0 top-0 bottom-0 border-l-4 border-[#4f46e5]"></div>
                @endif
                <div class="flex gap-[12px] items-center w-full">
                    <svg class="w-5 h-5 {{ $isDashboard ? 'text-[#4338ca]' : 'text-[#64748b]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="font-['Nimbus_Sans'] text-[14px] {{ $isDashboard ? 'text-[#4338ca] font-medium' : 'text-[#64748b]' }}">Dashboard</span>
                </div>
            </a>

            @php $isAppts = request()->routeIs('appointments'); @endphp
            <a href="{{ route('appointments') }}" wire:navigate class="relative w-full flex items-center py-[12px] {{ $isAppts ? 'pl-[20px]' : 'pl-[16px]' }}">
                @if($isAppts)
                    <div aria-hidden="true" class="absolute left-0 top-0 bottom-0 border-l-4 border-[#4f46e5]"></div>
                @endif
                <div class="flex gap-[12px] items-center w-full">
                    <svg class="w-5 h-5 {{ $isAppts ? 'text-[#4338ca]' : 'text-[#64748b]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="font-['Nimbus_Sans'] text-[14px] {{ $isAppts ? 'text-[#4338ca] font-medium' : 'text-[#64748b]' }}">Appointments</span>
                </div>
            </a>

            @if(auth()->user()->role === 'admin')

                @php $isServices = request()->routeIs('admin.services'); @endphp
                <a href="{{ route('admin.services') }}" wire:navigate class="relative w-full flex items-center py-[12px] {{ $isServices ? 'pl-[20px]' : 'pl-[16px]' }}">
                    @if($isServices)
                        <div aria-hidden="true" class="absolute left-0 top-0 bottom-0 border-l-4 border-[#4f46e5]"></div>
                    @endif
                    <div class="flex gap-[12px] items-center w-full">
                        <svg class="w-5 h-5 {{ $isServices ? 'text-[#4338ca]' : 'text-[#64748b]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                        <span class="font-['Nimbus_Sans'] text-[14px] {{ $isServices ? 'text-[#4338ca] font-medium' : 'text-[#64748b]' }}">Services</span>
                    </div>
                </a>

                @php $isStaff = request()->routeIs('admin.staff'); @endphp
                <a href="{{ route('admin.staff') }}" wire:navigate class="relative w-full flex items-center py-[12px] {{ $isStaff ? 'pl-[20px]' : 'pl-[16px]' }}">
                    @if($isStaff)
                        <div aria-hidden="true" class="absolute left-0 top-0 bottom-0 border-l-4 border-[#4f46e5]"></div>
                    @endif
                    <div class="flex gap-[12px] items-center w-full">
                        <svg class="w-5 h-5 {{ $isStaff ? 'text-[#4338ca]' : 'text-[#64748b]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="font-['Nimbus_Sans'] text-[14px] {{ $isStaff ? 'text-[#4338ca] font-medium' : 'text-[#64748b]' }}">Staff</span>
                    </div>
                </a>

                @php $isPayments = request()->routeIs('admin.payments'); @endphp
                <a href="{{ route('admin.payments') }}" wire:navigate class="relative w-full flex items-center py-[12px] {{ $isPayments ? 'pl-[20px]' : 'pl-[16px]' }}">
                    @if($isPayments)
                        <div aria-hidden="true" class="absolute left-0 top-0 bottom-0 border-l-4 border-[#4f46e5]"></div>
                    @endif
                    <div class="flex gap-[12px] items-center w-full">
                        <svg class="w-5 h-5 {{ $isPayments ? 'text-[#4338ca]' : 'text-[#64748b]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        <span class="font-['Nimbus_Sans'] text-[14px] {{ $isPayments ? 'text-[#4338ca] font-medium' : 'text-[#64748b]' }}">Payments</span>
                    </div>
                </a>
            @endif
        </nav>
    </div>

    <div class="px-[24px] mt-8">
        <button class="bg-gradient-to-r from-[#4a40e0] to-[#3d30d4] relative rounded-[12px] shadow-sm w-full py-[12px] px-[16px] hover:opacity-90 transition-opacity flex items-center justify-center">
            <span class="font-['Inter'] font-semibold text-[14px] text-white">
                + New Appointment
            </span>
        </button>
    </div>

</aside>
