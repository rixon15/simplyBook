@props(['appointmentId', 'customerName', 'currentStatus'])

<div x-data="{ open: false }"
     @open-status-modal.window="if($event.detail.id == {{ $appointmentId }}) open = true">

    <template x-teleport="body">
        <div x-show="open" class="fixed inset-0 z-[100] flex items-end justify-center" x-cloak>

            <div x-show="open"
                 x-transition.opacity
                 @click="open = false"
                 class="absolute inset-0 bg-[#203044]/40 backdrop-blur-sm"></div>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-y-full"
                 x-transition:enter-end="translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-y-0"
                 x-transition:leave-end="translate-y-full"
                 class="relative w-full max-w-md bg-white rounded-t-[24px] p-6 shadow-2xl pb-10">

                <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6"></div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-[#203044]">Update Status</h3>
                    <p class="text-sm text-[#4d5d73]">For {{ $customerName }}</p>
                </div>

                <div class="flex flex-col gap-3">

                    {{-- Check if finalized to prevent changes on mobile as well --}}
                    @if($currentStatus === 'completed')
                        <div class="p-6 bg-emerald-50 rounded-2xl border border-emerald-100 text-center">
                            <p class="text-emerald-800 font-bold text-sm uppercase tracking-widest">
                                Booking Finalized
                            </p>
                            <p class="text-emerald-600 text-xs mt-1">This record is locked for auditing.</p>
                        </div>
                    @else
                        {{-- Mark As Done: Dispatch event to trigger the main Dashboard modal --}}
                        <button @click="$dispatch('trigger-done-modal', { id: {{ $appointmentId }} }); open = false"
                                class="flex items-center justify-between w-full p-4 bg-[#f4f6ff] rounded-2xl transition-all active:scale-[0.98]">
                            <div class="flex items-center gap-4">
                                <div class="size-10 rounded-full bg-[#d1fae5] flex items-center justify-center text-[#10b981]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="font-bold text-[#203044]">Mark As Done</span>
                            </div>
                        </button>

                        <button wire:click="updateStatus({{ $appointmentId }}, 'confirmed')" @click="open = false"
                                class="flex items-center justify-between w-full p-4 bg-[#f4f6ff] rounded-2xl transition-all active:scale-[0.98]">
                            <div class="flex items-center gap-4">
                                <div class="size-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                </div>
                                <span class="font-bold text-[#203044]">Mark Confirmed</span>
                            </div>
                        </button>

                        <button wire:click="updateStatus({{ $appointmentId }}, 'pending')" @click="open = false"
                                class="flex items-center justify-between w-full p-4 bg-[#f4f6ff] rounded-2xl transition-all active:scale-[0.98]">
                            <div class="flex items-center gap-4">
                                <div class="size-10 rounded-full bg-[#fef3c7] flex items-center justify-center text-[#f59e0b]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <span class="font-bold text-[#203044]">Set as Pending</span>
                            </div>
                        </button>

                        <button wire:click="updateStatus({{ $appointmentId }}, 'no_show')" @click="open = false"
                                class="flex items-center justify-between w-full p-4 bg-[#f4f6ff] rounded-2xl transition-all active:scale-[0.98]">
                            <div class="flex items-center gap-4">
                                <div class="size-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <span class="font-bold text-[#203044]">Customer No-Show</span>
                            </div>
                        </button>

                        <button wire:click="updateStatus({{ $appointmentId }}, 'canceled')" @click="open = false"
                                class="flex items-center justify-between w-full p-4 bg-rose-50 rounded-2xl transition-all active:scale-[0.98] mt-2">
                            <div class="flex items-center gap-4 text-rose-600">
                                <div class="size-10 rounded-full bg-rose-100 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                </div>
                                <span class="font-bold">Cancel Appointment</span>
                            </div>
                        </button>
                    @endif

                    <button @click="open = false" class="w-full py-4 text-[#4d5d73] font-semibold text-sm mt-2">
                        Dismiss
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
