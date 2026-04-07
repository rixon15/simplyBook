<x-modal wire:model="showModal">
    <div class="bg-white rounded-[28px] overflow-hidden shadow-2xl flex flex-col">

        {{-- Header --}}
        <div class="bg-[#f4f6ff] px-8 py-6 flex justify-between items-center shrink-0 border-b border-indigo-50">
            <div>
                <h3 class="text-xl font-black text-[#203044]">Edit Schedule</h3>
                <p class="text-xs text-[#4a40e0] mt-1 uppercase tracking-[1.5px] font-bold">{{ $staffName }}</p>
            </div>
            <button @click="show = false" class="text-[#9eaec7] hover:text-rose-500 transition-colors p-2 bg-white rounded-full shadow-sm">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form wire:submit.prevent="save" class="p-8 space-y-8">

            {{-- Status Selector (Bigger buttons for easy tapping) --}}
            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 block ml-1">Current Availability</label>
                <div class="grid grid-cols-3 gap-3">
                    @foreach(['active' => 'Active', 'leave' => 'Leave', 'off' => 'Off'] as $key => $label)
                        <button type="button" wire:click="$set('status', '{{ $key }}')"
                                class="py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition-all border-2
                                {{ $status === $key
                                    ? 'bg-[#4a40e0] border-[#4a40e0] text-white shadow-lg shadow-indigo-100'
                                    : 'bg-white text-slate-400 border-slate-100 hover:border-indigo-200' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Work Days Selection (Instant Alpine Logic) --}}
            <div x-data="{ selected: @entangle('selectedDays') }">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 block ml-1">Working Days</label>
                <div class="flex justify-between bg-[#f4f6ff] p-2.5 rounded-[20px] border border-indigo-50/50">
                    @foreach([0 => 'M', 1 => 'T', 2 => 'W', 3 => 'T', 4 => 'F', 5 => 'S', 6 => 'S'] as $idx => $day)
                        <button type="button" @click="selected[{{ $idx }}] = !selected[{{ $idx }}]"
                                class="size-11 rounded-xl flex items-center justify-center text-sm font-black transition-all duration-100"
                                :class="selected[{{ $idx }}] ? 'bg-[#4a40e0] text-white shadow-md scale-110' : 'bg-white text-slate-400'">
                            {{ $day }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Shift Times (Snapping logic) --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 block ml-1">Shift Start</label>
                    <input type="time" wire:model="shiftStart" step="300"
                           x-data @blur="let v=$el.value; if(v){let [h,m]=v.split(':'); m=Math.round(m/5)*5; if(m==60){m='00'; h=String(Number(h)+1).padStart(2,'0')}else{m=String(m).padStart(2,'0')} $wire.set('shiftStart', h+':'+m)}"
                           class="w-full bg-[#f4f6ff] border-none rounded-2xl px-5 py-4 text-sm font-bold text-[#203044] focus:ring-2 focus:ring-[#4a40e0]">
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 block ml-1">Shift End</label>
                    <input type="time" wire:model="shiftEnd" step="300"
                           x-data @blur="let v=$el.value; if(v){let [h,m]=v.split(':'); m=Math.round(m/5)*5; if(m==60){m='00'; h=String(Number(h)+1).padStart(2,'0')}else{m=String(m).padStart(2,'0')} $wire.set('shiftEnd', h+':'+m)}"
                           class="w-full bg-[#f4f6ff] border-none rounded-2xl px-5 py-4 text-sm font-bold text-[#203044] focus:ring-2 focus:ring-[#4a40e0]">
                </div>
            </div>

            <button type="submit" class="w-full bg-[#203044] text-white py-5 rounded-2xl font-black uppercase tracking-widest shadow-xl hover:bg-black transition-all active:scale-95 flex items-center justify-center gap-3">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                Update Schedule
            </button>
        </form>
    </div>
</x-modal>
