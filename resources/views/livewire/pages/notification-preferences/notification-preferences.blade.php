<div class="h-full bg-[#f4f6ff] font-['Inter',sans-serif] flex flex-col relative pb-[120px] md:pb-12 mx-auto">
    {{-- Header: Same as Profile --}}
    <div class="hidden md:block max-w-[1536px] mx-auto w-full px-8 py-8">
        <h1 class="text-3xl font-extrabold text-[#203044] tracking-tight">Notification Preferences</h1>
        <p class="text-[#4d5d73] mt-2">Decide how and when you want to be notified about your upcoming sessions and schedule changes.</p>
    </div>

    {{-- Main Container: max-w-[1280px] to match Profile --}}
    <main class="flex-grow w-full max-w-[1280px] mx-auto space-y-12 md:space-y-16 pt-6 md:pt-0">

        <section class="space-y-6">
            {{-- Mobile Title (Only shows on mobile) --}}
            <div class="md:hidden space-y-2">
                <h2 class="text-2xl font-bold text-[#203044] tracking-tight">Notification Preferences</h2>
                <p class="text-[#4d5d73] text-sm">Manage your alert settings.</p>
            </div>

            {{-- The Card: Using rounded-3xl and p-6 md:p-8 to match Profile --}}
            <div class="bg-white rounded-3xl shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] p-6 md:p-8 space-y-6">

                {{-- Email Reminders Row --}}
                <div class="flex items-center justify-between py-2">
                    <div class="flex items-start gap-4">
                        <div class="bg-[#eaf1ff] flex items-center justify-center rounded-xl size-[48px] shrink-0">
                            <svg class="w-5 h-5 text-[#4a40e0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <h4 class="text-base font-bold text-[#203044]">Email Reminders</h4>
                            <p class="text-sm text-[#4d5d73]">Receive 24-hour reminders and confirmation emails.</p>
                        </div>
                    </div>
                    <button x-data="{ on: @entangle('emailNotifications') }" @click="on = !on; $wire.savePreferences()"
                            :class="on ? 'bg-[#4a40e0]' : 'bg-slate-200'"
                            class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                        <span :class="on ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                    </button>
                </div>

                <hr class="border-slate-50">

                {{-- SMS Confirmations Row --}}
                <div class="flex items-center justify-between py-2">
                    <div class="flex items-start gap-4">
                        <div class="bg-[#eaf1ff] flex items-center justify-center rounded-xl size-[48px] shrink-0">
                            <svg class="w-5 h-5 text-[#4a40e0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <h4 class="text-base font-bold text-[#203044]">SMS Confirmations</h4>
                            <p class="text-sm text-[#4d5d73]">Get instant text alerts for new bookings or cancellations.</p>
                        </div>
                    </div>
                    <button x-data="{ on: @entangle('smsNotifications') }" @click="on = !on; $wire.savePreferences()"
                            :class="on ? 'bg-[#4a40e0]' : 'bg-slate-200'"
                            class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                        <span :class="on ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                    </button>
                </div>
            </div>
        </section>

    </main>
</div>
