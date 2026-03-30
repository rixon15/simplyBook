<div class="h-full bg-[#f4f6ff] font-['Inter',sans-serif] flex flex-col relative pb-[120px] md:pb-12 mx-auto">
    <div class="hidden md:block max-w-[1536px] mx-auto w-full px-8 py-8">
        <h1 class="text-3xl font-extrabold text-[#203044] tracking-tight">Personal Information</h1>
        <p class="text-[#4d5d73] mt-2">Update your personal details and contact information.</p>
    </div>

    <main class="flex-grow w-full max-w-[1280px] mx-auto space-y-12 md:space-y-16 pt-6 md:pt-0">

        <section class="space-y-6">
            <div class="bg-white rounded-3xl shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] p-6 md:p-8">

                @if(auth()->user()->role === 'employee')
                    <div class="mb-6 p-4 bg-amber-50 border border-amber-100 rounded-2xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <p class="text-sm text-amber-700 font-medium">Your identity details are managed by the IT department.</p>
                    </div>
                @endif

                <form wire:submit="saveProfile" class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="flex flex-col gap-2">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#4d5d73] ml-1">Full Name</label>
                        <input type="text" wire:model="name"
                               @disabled(auth()->user()->role === 'employee')
                               class="bg-[#eaf1ff] text-[#203044] font-medium rounded-2xl px-5 py-4 border-none focus:ring-2 focus:ring-[#4a40e0] w-full transition-all disabled:opacity-60 disabled:cursor-not-allowed">
                        @error('name') <span class="text-rose-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#4d5d73] ml-1">Email Address</label>
                        <input type="email" wire:model="email"
                               @disabled(auth()->user()->role === 'employee')
                               class="bg-[#eaf1ff] text-[#203044] font-medium rounded-2xl px-5 py-4 border-none focus:ring-2 focus:ring-[#4a40e0] w-full transition-all disabled:opacity-60 disabled:cursor-not-allowed">
                        @error('email') <span class="text-rose-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2 md:max-w-md">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#4d5d73] ml-1">Phone Number</label>
                        <input type="text" wire:model="phone" placeholder="+1 (555) 000-0000"
                               class="bg-[#eaf1ff] text-[#203044] font-medium rounded-2xl px-5 py-4 border-none focus:ring-2 focus:ring-[#4a40e0] w-full transition-all">
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
        </section>

        <section class="space-y-6">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-[#203044] tracking-tight">Security</h2>
                <p class="text-[#4d5d73] text-sm md:text-base max-w-2xl">Manage your account security and authentication methods.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] p-6 md:p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-rose-50 flex items-center justify-center shrink-0 text-rose-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-[#203044]">Password & Authentication</h4>
                        <p class="text-sm text-[#4d5d73] mt-1">Managed securely via SimplyBook Auth services.</p>
                    </div>
                </div>

                <a href="{{ route('password.confirm') }}" class="w-full md:w-auto bg-[#d2e4ff] text-[#4a40e0] font-bold rounded-xl px-6 py-3 text-center hover:bg-[#c1d8ff] transition-colors">
                    Manage Password
                </a>
            </div>
        </section>
    </main>
</div>
