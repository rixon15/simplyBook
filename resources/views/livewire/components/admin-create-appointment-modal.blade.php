<x-modal wire:model="showModal">
    <div class="bg-white rounded-[24px] overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">

        {{-- Header --}}
        <div class="bg-[#f4f6ff] px-8 py-6 flex justify-between items-center shrink-0">
            <div>
                <h3 class="text-xl font-extrabold text-[#203044]">New Appointment</h3>
                <div class="flex items-center gap-2 mt-1">
                    <span
                        class="text-[10px] font-bold uppercase tracking-widest {{ !$isGuest ? 'text-[#4a40e0]' : 'text-slate-400' }}">Existing</span>

                    {{-- Small Toggle Switch --}}
                    <button type="button" wire:click="$toggle('isGuest')"
                            class="relative inline-flex h-4 w-8 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none bg-slate-200">
                        <span
                            class="pointer-events-none inline-block h-3 w-3 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $isGuest ? 'translate-x-4' : 'translate-x-0' }}"></span>
                    </button>

                    <span
                        class="text-[10px] font-bold uppercase tracking-widest {{ $isGuest ? 'text-[#4a40e0]' : 'text-slate-400' }}">New Customer</span>
                </div>
            </div>
            <button @click="show = false"
                    class="text-[#9eaec7] hover:text-[#4a40e0] transition-colors p-2 bg-white rounded-full">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form wire:submit.prevent="save" class="p-8 overflow-y-auto custom-scrollbar space-y-6">

            @if(!$isGuest)
                {{-- Existing User Search --}}
                <div class="relative">
                    <label class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Search
                        Database</label>
                    <input type="text" wire:model.live.debounce.300ms="userSearch" placeholder="Search by name..."
                           class="w-full bg-[#f4f6ff] border-none rounded-xl px-5 py-4 text-sm font-medium focus:ring-2 focus:ring-[#4a40e0]">

                    @if(!empty($foundUsers))
                        <div
                            class="absolute z-[100] mt-2 w-full bg-white rounded-xl shadow-xl border border-slate-100 py-2">
                            @foreach($foundUsers as $user)
                                <button type="button" wire:click="selectUser({{ $user->id }}, '{{ $user->name }}')"
                                        class="w-full text-left px-5 py-3 hover:bg-[#f4f6ff]">
                                    <span class="font-bold text-[#203044] text-sm">{{ $user->name }}</span>
                                </button>
                            @endforeach
                        </div>
                    @endif
                    <x-input-error :messages="$errors->get('userId')" class="mt-2"/>
                </div>
            @else
                {{-- New Guest Inputs --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Customer
                            Name</label>
                        <input type="text" wire:model="guestName" placeholder="e.g. John Smith"
                               class="w-full bg-[#f4f6ff] border-none rounded-xl px-5 py-4 text-sm font-medium focus:ring-2 focus:ring-[#4a40e0]">
                        <x-input-error :messages="$errors->get('guestName')" class="mt-2"/>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Email
                            Address</label>
                        <input type="email" wire:model="guestEmail" placeholder="john@example.com"
                               class="w-full bg-[#f4f6ff] border-none rounded-xl px-5 py-4 text-sm font-medium focus:ring-2 focus:ring-[#4a40e0]">
                        <x-input-error :messages="$errors->get('guestEmail')" class="mt-2"/>
                    </div>
                </div>
            @endif

            {{-- Service & Staff Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Service</label>
                    <select wire:model="serviceId"
                            class="w-full bg-[#f4f6ff] border-none rounded-xl px-5 py-4 text-sm font-medium focus:ring-2 focus:ring-[#4a40e0]">
                        <option value="">Select Service</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }} ({{ $service->duration }}m)</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('serviceId')" class="mt-2"/>
                </div>
                <div>
                    <label class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Staff
                        Member</label>
                    <select wire:model="employeeId"
                            class="w-full bg-[#f4f6ff] border-none rounded-xl px-5 py-4 text-sm font-medium focus:ring-2 focus:ring-[#4a40e0]">
                        <option value="">Select Staff</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('employeeId')" class="mt-2"/>
                </div>
            </div>

            {{-- Date & Time Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label
                        class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Date</label>
                    <input type="date" wire:model="date"
                           class="w-full bg-[#f4f6ff] border-none rounded-xl px-5 py-4 text-sm font-medium focus:ring-2 focus:ring-[#4a40e0]">
                    <x-input-error :messages="$errors->get('date')" class="mt-2"/>
                </div>
                <div>
                    <label class="text-[11px] font-bold uppercase tracking-widest text-[#4d5d73] ml-1 mb-2 block">Start
                        Time</label>
                    <input type="time" wire:model="time"
                           class="w-full bg-[#f4f6ff] border-none rounded-xl px-5 py-4 text-sm font-medium focus:ring-2 focus:ring-[#4a40e0]">
                    <x-input-error :messages="$errors->get('time')" class="mt-2"/>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="w-full bg-[#4a40e0] text-white py-4 rounded-xl font-bold shadow-lg shadow-indigo-100 hover:bg-[#3d30d4] transition-all flex items-center justify-center gap-2">
                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                    Confirm Appointment
                </button>
            </div>
        </form>
    </div>
</x-modal>
