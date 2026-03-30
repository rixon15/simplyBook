@props(['appointmentId', 'customerName', 'currentStatus'])

@php
    /** * We check against the string 'completed' because your TodaysSchedule
     * component maps the status to 'status_color' => 'completed'
     */
    $isLocked = $currentStatus === 'completed';
@endphp

<div class="hidden md:block relative"
     x-data="{
        menuOpen: false,
        toggle() {
            {{-- Prevent opening if the booking is locked/completed --}}
            if (@js($isLocked)) return;

            if (!this.menuOpen) {
                $dispatch('close-other-menus', { id: {{ $appointmentId }} });
            }
            this.menuOpen = !this.menuOpen;
        }
     }"
     @close-other-menus.window="if ($event.detail.id !== {{ $appointmentId }}) menuOpen = false"
     @click.stop>

    {{-- The Trigger Button --}}
    <button x-ref="trigger"
            @click="toggle()"
            {{--
               If locked: we remove the hover background/color and change cursor
               If active: we keep your original hover styles
            --}}
            class="p-1.5 transition-all
            {{ $isLocked
                ? 'text-[#9eaec7]/50 cursor-default'
                : 'text-[#9eaec7] hover:text-[#4a40e0] hover:bg-white rounded-lg'
            }}">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
        </svg>
    </button>

    {{-- Only render the dropdown menu in the DOM if NOT completed --}}
    @if(!$isLocked)
        <template x-teleport="body">
            <div x-show="menuOpen"
                 x-anchor.bottom-end="$refs.trigger"
                 @click.outside="menuOpen = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-cloak
                 class="absolute mt-2 w-52 bg-white rounded-xl shadow-2xl border border-slate-100 z-[999] py-2">

                @php
                    $options = [
                        ['status' => 'completed', 'label' => 'Mark As Done', 'color' => 'bg-[#10b981]'],
                        ['status' => 'confirmed', 'label' => 'Mark Confirmed', 'color' => 'bg-blue-500'],
                        ['status' => 'pending', 'label' => 'Set Pending', 'color' => 'bg-[#f59e0b]'],
                        ['status' => 'no_show', 'label' => 'Customer No-show', 'color' => 'bg-slate-400'],
                    ];
                @endphp

                @foreach($options as $option)
                    @if($option['status'] === 'completed')
                        <button @click="$dispatch('trigger-done-modal', { id: {{ $appointmentId }} }); menuOpen = false"
                                class="w-full text-left px-4 py-2.5 text-[13px] font-bold text-[#203044] hover:bg-emerald-50 hover:text-emerald-600 transition-colors flex items-center gap-3">
                            <div class="size-2 rounded-full {{ $option['color'] }} shrink-0"></div>
                            {{ $option['label'] }}
                        </button>
                    @else
                        <button wire:click="updateStatus({{ $appointmentId }}, '{{ $option['status'] }}')"
                                @click="menuOpen = false"
                                class="w-full text-left px-4 py-2.5 text-[13px] font-bold text-[#203044] hover:bg-[#f4f6ff] hover:text-[#4a40e0] transition-colors flex items-center gap-3">
                            <div class="size-2 rounded-full {{ $option['color'] }} shrink-0"></div>
                            {{ $option['label'] }}
                        </button>
                    @endif
                @endforeach

                <div class="border-t border-slate-100 my-1"></div>

                <button wire:click="updateStatus({{ $appointmentId }}, 'canceled')"
                        @click="menuOpen = false"
                        class="w-full text-left px-4 py-2.5 text-[13px] font-bold text-rose-600 hover:bg-rose-50 transition-colors flex items-center gap-3">
                    <svg class="size-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel Booking
                </button>
            </div>
        </template>
    @endif
</div>
