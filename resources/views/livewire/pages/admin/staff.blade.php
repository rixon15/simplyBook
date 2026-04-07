<div class="content-stretch flex flex-col gap-8 lg:gap-10 p-6 lg:p-10 relative size-full max-w-[1600px] mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div class="flex flex-col gap-1">
            <h1 class="text-[30px] font-black text-[#203044] tracking-tight">Staff Management</h1>
            <p class="text-[#4d5d73] font-medium">Manage your team members, roles, and working hours.</p>
        </div>
        <button x-data @click="$dispatch('open-create-staff-modal')"
                class="bg-[#4a40e0] flex gap-2 items-center justify-center px-6 py-3 rounded-xl shadow-lg shadow-indigo-100 text-white font-bold transition-all active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Add Staff Member
        </button>
    </div>

    {{-- MOBILE SEARCH & QUICK METRICS --}}
    <div class="flex lg:hidden flex-col gap-6">
        <div class="relative w-full">
            <span class="absolute inset-y-0 left-4 flex items-center text-[#4d5d73]">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"/></svg>
            </span>
            <input type="text" wire:model.live="search" placeholder="Search staff members..."
                   class="w-full pl-12 pr-4 py-4 bg-white border-none rounded-2xl shadow-sm focus:ring-2 focus:ring-[#4a40e0]">
        </div>

        <div class="flex overflow-x-auto gap-4 pb-2 hide-scrollbar -mx-6 px-6 snap-x">
            @foreach([
                ['label' => 'Total', 'val' => $this->stats['total'], 'color' => '#4a40e0'],
                ['label' => 'Active', 'val' => $this->stats['active'], 'color' => '#10b981'],
                ['label' => 'On Leave', 'val' => $this->stats['leave'], 'color' => '#983772'],
                ['label' => 'Off', 'val' => $this->stats['off'], 'color' => '#9eaec7']
            ] as $stat)
                <div class="bg-white min-w-[130px] p-5 rounded-2xl shadow-sm border-l-4 snap-start" style="border-color: {{ $stat['color'] }}">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#4d5d73]">{{ $stat['label'] }}</span>
                    <p class="text-2xl font-black text-[#203044] mt-1">{{ $stat['val'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- TEAM DIRECTORY CARD (Desktop Table / Mobile Cards) --}}
    <div class="bg-white rounded-[24px] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden flex flex-col">

        {{-- DESKTOP TABLE HEADER --}}
        <div class="hidden lg:grid grid-cols-[1.5fr_2fr_1fr_1fr_1fr] bg-slate-50/50 border-b border-slate-100">
            <div class="px-8 py-5 text-[11px] font-bold text-[#4d5d73] uppercase tracking-widest">Profile</div>
            <div class="px-8 py-5 text-[11px] font-bold text-[#4d5d73] uppercase tracking-widest">Contact</div>
            <div class="px-8 py-5 text-[11px] font-bold text-[#4d5d73] uppercase tracking-widest">Status</div>
            <div class="px-8 py-5 text-[11px] font-bold text-[#4d5d73] uppercase tracking-widest">Schedule</div>
            <div class="px-8 py-5 text-[11px] font-bold text-[#4d5d73] uppercase tracking-widest text-right">Actions</div>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($staffMembers as $member)
                {{-- DESKTOP ROW --}}
                <div class="hidden lg:grid grid-cols-[1.5fr_2fr_1fr_1fr_1fr] items-center hover:bg-slate-50/30 transition-colors">
                    <div class="px-8 py-6 flex items-center gap-4">
                        <img src="{{ $member->profile_photo_url }}" class="size-12 rounded-full shadow-sm">
                        <div class="flex flex-col">
                            <span class="font-bold text-[#0f172a]">{{ $member->name }}</span>
                            <span class="text-xs font-medium text-[#64748b]">{{ $member->title ?? 'Team Member' }}</span>
                        </div>
                    </div>
                    <div class="px-8 py-6 flex flex-col gap-1">
                        <div class="flex items-center gap-2 text-sm text-[#475569]">
                            <svg class="size-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2"/></svg>
                            {{ $member->email }}
                        </div>
                        <div class="flex items-center gap-2 text-sm text-[#475569]">
                            <svg class="size-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2"/></svg>
                            {{ $member->phone ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="px-8 py-6">
                        @php
                            $statusMap = [
                                'active' => ['bg' => 'bg-emerald-100', 'dot' => 'bg-emerald-500', 'text' => 'text-emerald-700', 'label' => 'Active'],
                                'leave' => ['bg' => 'bg-rose-100', 'dot' => 'bg-rose-500', 'text' => 'text-rose-700', 'label' => 'On Leave'],
                                'off' => ['bg' => 'bg-slate-100', 'dot' => 'bg-slate-400', 'text' => 'text-slate-700', 'label' => 'Off Duty'],
                            ];
                            $s = $statusMap[$member->status ?? 'active'];
                        @endphp
                        <span class="{{ $s['bg'] }} {{ $s['text'] }} px-3 py-1 rounded-full text-[11px] font-bold flex items-center gap-2 w-fit">
                            <span class="size-1.5 rounded-full {{ $s['dot'] }}"></span>
                            {{ $s['label'] }}
                        </span>
                    </div>
                    <div class="px-8 py-6 flex flex-col">
                        <span class="text-sm font-medium text-[#334155]">{{ $member->working_days ?? 'Mon - Fri' }}</span>
                        <span class="text-xs text-[#64748b]">{{ $member->working_hours ?? '9:00 AM - 5:00 PM' }}</span>
                    </div>
                    <div class="px-8 py-6 flex gap-2 justify-end">
                        <button x-data @click="$dispatch('open-edit-schedule-modal', { id: {{ $member->id }} })"
                                class="flex items-center gap-2 px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-bold text-[#475569] hover:bg-slate-50 transition-all">
                            Schedule
                        </button>

                        {{-- Three Dot Menu --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.outside="open = false" class="p-2 text-slate-400 hover:text-[#4a40e0] transition-colors">
                                <svg class="size-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/></svg>
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 z-[100] py-2">
                                <button @click="open = false; $dispatch('open-edit-profile-modal', { id: {{ $member->id }} })"
                                        class="w-full text-left px-4 py-2 text-sm font-bold text-[#203044] hover:bg-[#f4f6ff] transition-colors flex items-center gap-2">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"/></svg>
                                    Edit Profile
                                </button>
                                <hr class="my-1 border-slate-50">
                                <button @click="open = false; $dispatch('confirm-staff-deletion', { id: {{ $member->id }} })"
                                        class="w-full text-left px-4 py-2 text-sm font-bold text-rose-500 hover:bg-rose-50 transition-colors flex items-center gap-2">
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2"/></svg>
                                    Remove Member
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MOBILE CARD --}}
                <div class="lg:hidden p-5 flex flex-col gap-4">
                    <div class="flex justify-between items-start">
                        <div class="flex gap-4">
                            <img src="{{ $member->profile_photo_url }}" class="size-14 rounded-2xl shadow-sm">
                            <div class="flex flex-col">
                                <h3 class="font-bold text-[#203044] text-lg">{{ $member->name }}</h3>
                                <span class="text-sm text-[#4d5d73]">{{ $member->title ?? 'Team Member' }}</span>
                            </div>
                        </div>
                        <span class="{{ $s['bg'] }} {{ $s['text'] }} px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                            {{ $s['label'] }}
                        </span>
                    </div>
                    <div class="bg-slate-50/80 rounded-xl p-3 flex items-center gap-3">
                        <svg class="size-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2"/></svg>
                        <span class="text-xs font-medium text-[#4d5d73]">{{ $member->working_days ?? 'Mon-Fri' }} | {{ $member->working_hours ?? '9:00-17:00' }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <button @click="open = false; $dispatch('open-edit-profile-modal', { id: {{ $member->id }} })" class="bg-[#d2e4ff] text-[#4a40e0] py-3 rounded-xl font-bold text-sm">Edit Profile</button>
                        <button x-data @click="$dispatch('open-edit-schedule-modal', { id: {{ $member->id }} })"
                                class="bg-[#4a40e0] text-white py-3 rounded-xl font-bold text-sm">
                            Schedule
                        </button>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-slate-400 italic">No staff members found matching your search.</div>
            @endforelse
        </div>

        {{-- PAGINATION FOOTER --}}
        <div class="bg-slate-50/50 border-t border-slate-100 px-8 py-4">
            {{ $staffMembers->links() }}
        </div>
    </div>

    {{-- DESKTOP INSIGHTS (Bento Grid) --}}
    <div class="hidden lg:grid grid-cols-3 gap-6">
        <div class="bg-indigo-50/30 border border-indigo-100/50 p-6 rounded-[20px] flex flex-col gap-4">
            <div class="flex items-center gap-3">
                <div class="size-10 bg-white rounded-xl flex items-center justify-center text-[#4a40e0] shadow-sm"><svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="2"/></svg></div>
                <h4 class="font-bold text-[#203044]">Staff Utilization</h4>
            </div>
            <div class="flex items-end gap-3 mt-1">
                <span class="text-4xl font-black text-[#4a40e0]">84%</span>
                <span class="text-emerald-600 text-xs font-bold mb-1.5">+4% from last week</span>
            </div>
            <div class="w-full bg-indigo-100 rounded-full h-2">
                <div class="bg-[#4a40e0] h-2 rounded-full" style="width: 84%"></div>
            </div>
        </div>

        <div class="bg-pink-50/30 border border-pink-100/50 p-6 rounded-[20px] flex flex-col gap-4">
            <div class="flex items-center gap-3">
                <div class="size-10 bg-white rounded-xl flex items-center justify-center text-[#983772] shadow-sm"><svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" stroke-width="2"/></svg></div>
                <h4 class="font-bold text-[#203044]">Top Rated</h4>
            </div>
            <div class="flex items-center gap-4 mt-2">
                <img src="{{ $staffMembers->first()?->profile_photo_url }}" class="size-12 rounded-full border-2 border-white shadow-md">
                <div class="flex flex-col">
                    <span class="font-bold text-[#0f172a] text-sm">{{ $staffMembers->first()?->name }}</span>
                    <div class="flex text-amber-400 gap-0.5">
                        @for($i=0; $i<5; $i++) <svg class="size-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 border border-slate-100 p-6 rounded-[20px] flex items-center justify-between">
            <div class="flex flex-col gap-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Team</span>
                <span class="text-4xl font-black text-[#203044]">{{ $this->stats['total'] }}</span>
            </div>
            <div class="size-14 bg-white rounded-2xl flex items-center justify-center text-slate-400 shadow-sm">
                <svg class="size-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-width="2"/></svg>
            </div>
        </div>
    </div>

    <livewire:components.admin-create-staff-modal />
    <livewire:components.admin-edit-staff-schedule-modal/>
    <livewire:components.admin-edit-staff-profile-modal/>
    <livewire:components.admin-delete-staff-modal/>
</div>
