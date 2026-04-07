<x-modal wire:model="showModal">
    <div class="bg-white rounded-[28px] overflow-hidden shadow-2xl flex flex-col max-h-[95vh]">

        {{-- Header --}}
        <div class="bg-[#f4f6ff] px-8 py-6 flex justify-between items-center shrink-0 border-b border-indigo-50">
            <div>
                <h3 class="text-xl font-black text-[#203044]">Add Team Member</h3>
                <p class="text-xs text-[#4a40e0] mt-1 uppercase tracking-[1.5px] font-bold">Onboarding</p>
            </div>
            <button @click="show = false"
                    class="text-[#9eaec7] hover:text-rose-500 transition-colors p-2 bg-white rounded-full shadow-sm">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form wire:submit.prevent="save" class="p-8 overflow-y-auto custom-scrollbar space-y-6">

            {{-- Photo Upload & Basic Info --}}
            <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">
                <div class="relative group">
                    <div
                        class="size-32 rounded-[32px] bg-slate-100 overflow-hidden border-4 border-white shadow-md relative">
                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" class="size-full object-cover">
                        @else
                            <div class="size-full flex items-center justify-center text-slate-300">
                                <svg class="size-12" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Loading Overlay --}}
                        <div wire:loading wire:target="photo"
                             class="absolute inset-0 bg-white/80 flex items-center justify-center">
                            <svg class="animate-spin size-6 text-[#4a40e0]" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                    <label
                        class="absolute -bottom-2 -right-2 size-10 bg-[#4a40e0] text-white rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:scale-110 transition-transform border-4 border-white">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                                stroke-width="2"/>
                            <path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/>
                        </svg>
                        <input type="file" wire:model="photo" class="hidden" accept="image/*">
                    </label>
                </div>

                <div class="flex-1 w-full space-y-4">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block ml-1">Full
                            Name</label>
                        <input type="text" wire:model="name" placeholder="e.g. Sarah Jenkins"
                               class="w-full bg-[#f4f6ff] border-none rounded-xl px-4 py-3 text-sm font-bold text-[#203044] focus:ring-2 focus:ring-[#4a40e0]">
                        <x-input-error :messages="$errors->get('name')" class="mt-1"/>
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block ml-1">Professional
                            Title</label>
                        <input type="text" wire:model="title" placeholder="e.g. Senior Stylist"
                               class="w-full bg-[#f4f6ff] border-none rounded-xl px-4 py-3 text-sm font-bold text-[#203044] focus:ring-2 focus:ring-[#4a40e0]">
                        <x-input-error :messages="$errors->get('title')" class="mt-1"/>
                    </div>
                </div>
            </div>

            {{-- Contact Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block ml-1">Email
                        Address</label>
                    <input type="email" wire:model="email"
                           class="w-full bg-[#f4f6ff] border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-[#4a40e0]">
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block ml-1">Phone
                        Number</label>
                    <input type="text" wire:model="phone"
                           class="w-full bg-[#f4f6ff] border-none rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-[#4a40e0]">
                </div>
            </div>

            {{-- Work Days Selection --}}
            <div class="col-span-full"
                 x-data="{
        {{-- Initialize local Alpine state from Livewire --}}
        selected: @entangle('selectedDays')
     }">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 block ml-1">Work
                    Days</label>
                <div class="flex justify-between bg-[#f4f6ff] p-2 rounded-2xl border border-indigo-50/50">
                    @foreach([
                        0 => 'M', 1 => 'T', 2 => 'W', 3 => 'T', 4 => 'F', 5 => 'S', 6 => 'S'
                    ] as $value => $label)
                        <button type="button"
                                {{-- Alpine handles the toggle instantly --}}
                                @click="selected[{{ $value }}] = !selected[{{ $value }}]"
                                {{-- Use 'duration-75' or 'duration-100' for a faster animation --}}
                                class="size-10 rounded-xl flex items-center justify-center text-xs font-bold transition-all duration-100
                    "
                                {{-- Bind classes to Alpine 'selected' state instead of Livewire variable --}}
                                :class="selected[{{ $value }}]
                        ? 'bg-[#4a40e0] text-white shadow-md shadow-indigo-200 scale-110'
                        : 'bg-white text-slate-400 hover:text-[#4a40e0]'">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('selectedDays')" class="mt-2"/>
            </div>

            {{-- Standard Shift Selection --}}
            <div class="grid grid-cols-2 gap-4 col-span-full">
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 block ml-1">Shift
                        Start</label>
                    <div class="relative">
                        <input type="time" wire:model="shiftStart" step="300"
                               x-data
                               @blur="let v=$el.value; if(v){let [h,m]=v.split(':'); m=Math.round(m/5)*5; if(m==60){m='00'; h=String(Number(h)+1).padStart(2,'0')}else{m=String(m).padStart(2,'0')} $wire.set('shiftStart', h+':'+m)}"
                               class="w-full bg-[#f4f6ff] border-none rounded-xl px-4 py-4 text-sm font-bold text-[#203044] focus:ring-2 focus:ring-[#4a40e0]">
                    </div>
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 block ml-1">Shift
                        End</label>
                    <div class="relative">
                        <input type="time" wire:model="shiftEnd" step="300"
                               x-data
                               @blur="let v=$el.value; if(v){let [h,m]=v.split(':'); m=Math.round(m/5)*5; if(m==60){m='00'; h=String(Number(h)+1).padStart(2,'0')}else{m=String(m).padStart(2,'0')} $wire.set('shiftEnd', h+':'+m)}"
                               class="w-full bg-[#f4f6ff] border-none rounded-xl px-4 py-4 text-sm font-bold text-[#203044] focus:ring-2 focus:ring-[#4a40e0]">
                    </div>
                </div>
                <x-input-error :messages="$errors->get('shiftEnd')" class="col-span-2"/>
            </div>

            {{-- Status Selector --}}
            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 block ml-1">Initial
                    Status</label>
                <div class="grid grid-cols-3 gap-2">
                    @foreach(['active' => 'Active', 'leave' => 'Leave', 'off' => 'Off'] as $key => $label)
                        <button type="button" wire:click="$set('status', '{{ $key }}')"
                                class="py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $status === $key ? 'bg-[#4a40e0] text-white shadow-lg shadow-indigo-100' : 'bg-slate-50 text-slate-400 border border-slate-100' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-[#4a40e0] text-white py-5 rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-indigo-100 hover:bg-[#3d30d4] transition-all flex items-center justify-center gap-3">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path d="M5 13l4 4L19 7"/>
                </svg>
                Confirm Member
            </button>
        </form>
    </div>
</x-modal>
