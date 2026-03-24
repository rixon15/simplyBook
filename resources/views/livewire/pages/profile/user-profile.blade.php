<div class="min-h-screen bg-[#f4f6ff] font-['Inter',sans-serif] flex flex-col relative pb-[120px] md:pb-12">

    <div class="hidden md:block max-w-[1536px] mx-auto w-full px-8 py-8">
        <h1 class="text-3xl font-extrabold text-[#203044] tracking-tight">Personal Information</h1>
        <p class="text-[#4d5d73] mt-2">Update your personal details and contact information.</p>
    </div>

    <main class="flex-grow w-full max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 space-y-12 md:space-y-16 pt-6 md:pt-0">

        <section class="space-y-6">
            <div class="md:hidden space-y-2">
                <h2 class="text-2xl font-bold text-[#203044] tracking-tight">Personal Information</h2>
                <p class="text-[#4d5d73] text-sm">Update your personal details to ensure smooth booking communications.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] p-6 md:p-8">
                <form wire:submit="saveProfile" class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="flex flex-col gap-2">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#4d5d73] ml-1">Full Name</label>
                        <input type="text" wire:model="name" class="bg-[#eaf1ff] text-[#203044] font-medium rounded-2xl px-5 py-4 border-none focus:ring-2 focus:ring-[#4a40e0] w-full transition-all">
                        @error('name') <span class="text-rose-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#4d5d73] ml-1">Email Address</label>
                        <input type="email" wire:model="email" class="bg-[#eaf1ff] text-[#203044] font-medium rounded-2xl px-5 py-4 border-none focus:ring-2 focus:ring-[#4a40e0] w-full transition-all">
                        @error('email') <span class="text-rose-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2 md:max-w-md">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#4d5d73] ml-1">Phone Number</label>
                        <input type="text" wire:model="phone" placeholder="+1 (555) 000-0000" class="bg-[#eaf1ff] text-[#203044] font-medium rounded-2xl px-5 py-4 border-none focus:ring-2 focus:ring-[#4a40e0] w-full transition-all">
                        @error('phone') <span class="text-rose-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2 pt-2">
                        <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-[#4a40e0] to-[#3d30d4] text-white font-bold rounded-2xl px-8 py-4 shadow-lg shadow-indigo-200 hover:scale-[1.02] transition-all active:scale-95">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <section class="space-y-6">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-[#203044] tracking-tight">Notification Preferences</h2>
                <p class="text-[#4d5d73] text-sm md:text-base max-w-2xl">Decide how and when you want to be notified about your upcoming sessions and schedule changes.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] p-6 md:p-8 space-y-6">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#eaf1ff] flex items-center justify-center shrink-0 text-[#4a40e0]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-[#203044]">Email Reminders</h4>
                            <p class="text-sm text-[#4d5d73]">Receive 24-hour reminders and confirmation emails.</p>
                        </div>
                    </div>
                    <button x-data="{ on: @entangle('emailNotifications') }" @click="on = !on; $wire.savePreferences()"
                            :class="on ? 'bg-[#4a40e0]' : 'bg-slate-200'"
                            class="relative inline-flex h-7 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                        <span :class="on ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                    </button>
                </div>

                <hr class="border-slate-100">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#eaf1ff] flex items-center justify-center shrink-0 text-[#4a40e0]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-[#203044]">SMS Confirmations</h4>
                            <p class="text-sm text-[#4d5d73]">Get instant text alerts for new bookings or cancellations.</p>
                        </div>
                    </div>
                    <button x-data="{ on: @entangle('smsNotifications') }" @click="on = !on; $wire.savePreferences()"
                            :class="on ? 'bg-[#4a40e0]' : 'bg-slate-200'"
                            class="relative inline-flex h-7 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                        <span :class="on ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                    </button>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-[#203044] tracking-tight">Security</h2>
                <p class="text-[#4d5d73] text-sm md:text-base max-w-2xl">Keep your account secure by using a strong password and updating it regularly.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] p-6 md:p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-rose-50 flex items-center justify-center shrink-0 text-rose-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-[#203044]">Password & Authentication</h4>
                        <p class="text-sm text-[#4d5d73] mt-1">Managed securely by Laravel Breeze.</p>
                    </div>
                </div>

                <a href="" class="w-full md:w-auto bg-[#d2e4ff] text-[#4a40e0] font-bold rounded-xl px-6 py-3 text-center hover:bg-[#c1d8ff] transition-colors">
                    Manage Password
                </a>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-[#203044] rounded-3xl p-8 relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-[#9795ff]/20 blur-3xl rounded-full pointer-events-none"></div>
                <div class="relative z-10 space-y-2">
                    <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 text-[#fd8bca]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Need Help?</h3>
                    <p class="text-[#8e9eb7] text-sm">Our support team is here for you 24/7.</p>
                </div>
                <button class="relative z-10 mt-6 bg-[#fd8bca] text-[#610244] text-[11px] font-black uppercase tracking-widest py-3 px-6 rounded-full w-fit hover:bg-pink-300 transition-colors">
                    Contact Us
                </button>
            </div>

            <div class="md:col-span-2 rounded-3xl p-8 relative overflow-hidden flex flex-col justify-between min-h-[220px]" style="background-image: linear-gradient(159.566deg, rgb(74, 64, 224) 0%, rgb(61, 48, 212) 100%)">
                <div class="absolute right-0 bottom-0 opacity-10 pointer-events-none">
                    <svg class="w-64 h-64 -mr-12 -mb-12" fill="currentColor" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"></path></svg>
                </div>

                <div class="relative z-10 space-y-4 max-w-[400px]">
                    <span class="inline-block bg-white/20 text-white text-[10px] font-black uppercase tracking-widest px-4 py-1.5 rounded-full backdrop-blur-sm">Premium Perk</span>
                    <h3 class="text-3xl font-black text-white leading-tight">Sync with your favorite calendar apps.</h3>
                    <p class="text-white/80 text-sm md:text-base">Connect Google Calendar, iCal, or Outlook to keep all your bookings in one place.</p>
                </div>

                <button class="relative z-10 mt-6 bg-white text-[#4a40e0] font-bold py-4 px-8 rounded-2xl w-fit flex items-center gap-3 hover:bg-slate-50 transition-colors">
                    Connect Calendar
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                </button>
            </div>

        </section>
    </main>
</div>
