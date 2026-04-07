<div class="content-stretch flex flex-col gap-[32px] lg:gap-[48px] items-start relative size-full max-w-7xl mx-auto">

    {{-- ========================================== --}}
    {{-- RESPONSIVE HEADER                          --}}
    {{-- ========================================== --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between w-full gap-6 lg:gap-0">
        <div class="flex flex-col gap-2">
            <h1 class="font-extrabold text-[#203044] text-[30px] tracking-tight leading-tight">Services & Pricing</h1>
            <p class="font-medium text-[#4d5d73] text-[16px]">Manage the treatments you offer and their costs.</p>
        </div>

        <button x-data @click="$dispatch('open-create-service-modal')"
                class="bg-[#4a40e0] flex gap-2 items-center justify-center px-6 py-3 lg:py-3 rounded-xl shadow-[0px_20px_25px_-5px_rgba(74,64,224,0.1),0px_8px_10px_-6px_rgba(74,64,224,0.1)] hover:bg-[#3d30d4] transition-all active:scale-95 w-full lg:w-auto text-white font-bold text-[16px]">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Service
        </button>
    </div>


    {{-- ========================================== --}}
    {{-- DESKTOP TABLE VIEW                         --}}
    {{-- ========================================== --}}
    <div
        class="hidden lg:flex bg-white rounded-[24px] shadow-[0px_20px_40px_-12px_rgba(32,48,68,0.08)] w-full overflow-hidden flex-col border border-slate-100">

        {{-- Table Header --}}
        <div class="bg-[rgba(234,241,255,0.5)] grid grid-cols-[2fr_1fr_1fr_1fr_1fr] w-full border-b border-slate-100">
            <div class="px-8 py-5 text-[11px] font-bold text-[rgba(77,93,115,0.7)] tracking-[0.55px] uppercase">Service
                Details
            </div>
            <div class="px-8 py-5 text-[11px] font-bold text-[rgba(77,93,115,0.7)] tracking-[0.55px] uppercase">
                Duration
            </div>
            <div class="px-8 py-5 text-[11px] font-bold text-[rgba(77,93,115,0.7)] tracking-[0.55px] uppercase">Price
            </div>
            <div class="px-8 py-5 text-[11px] font-bold text-[rgba(77,93,115,0.7)] tracking-[0.55px] uppercase">Status
            </div>
            <div
                class="px-8 py-5 text-[11px] font-bold text-[rgba(77,93,115,0.7)] tracking-[0.55px] uppercase text-right">
                Actions
            </div>
        </div>

        {{-- Table Body --}}
        <div class="flex flex-col w-full">
            @forelse($services as $service)
                <div
                    class="grid grid-cols-[2fr_1fr_1fr_1fr_1fr] w-full border-b border-slate-100 last:border-0 items-center relative hover:bg-slate-50/50 transition-colors">
                    {{-- Left accent border --}}
                    <div
                        class="absolute left-0 top-0 bottom-0 w-1 {{ $service->is_active ? 'bg-[#4a40e0]' : 'bg-slate-200' }}"></div>

                    {{-- Details --}}
                    <div class="px-8 py-6 pl-10 flex flex-col gap-1">
                        <span class="font-bold text-[#203044] text-[16px]">{{ $service->name }}</span>
                        <span
                            class="text-[#4d5d73] text-[14px] line-clamp-1">{{ $service->description ?? 'No description provided.' }}</span>
                    </div>

                    {{-- Duration --}}
                    <div class="px-8 py-6">
                        <span
                            class="bg-[rgba(151,149,255,0.2)] text-[#14007e] font-bold text-[12px] px-3 py-1.5 rounded-full inline-block">
                            {{ $service->duration }} Min
                        </span>
                    </div>

                    {{-- Price --}}
                    <div class="px-8 py-6 font-extrabold text-[#203044] text-[16px]">
                        ${{ number_format($service->price, 2) }}
                    </div>

                    {{-- Status Toggle --}}
                    <div class="px-8 py-6">
                        <button wire:click="toggleStatus({{ $service->id }})"
                                class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $service->is_active ? 'bg-[#4a40e0]' : 'bg-slate-200' }}">
                            <span
                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $service->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>

                    {{-- Actions --}}
                    <div class="px-8 py-6 flex gap-2 justify-end">
                        <button x-data @click="$dispatch('open-edit-service-modal', { id: {{ $service->id }} })"
                                 class="p-2 text-[#4d5d73] hover:bg-slate-100 rounded-lg transition-colors">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </button>
                        <button x-data @click="$dispatch('confirm-service-deletion', { id: {{ $service->id }} })"
                                class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-[#4d5d73]">No services found. Click "Add New Service" to get started.
                </div>
            @endforelse
        </div>

        {{-- Table Footer / Pagination --}}
        <div class="bg-[rgba(234,241,255,0.2)] border-t border-slate-100 px-8 py-4">
            {{ $services->links(data: ['scrollTo' => false]) }}
        </div>
    </div>


    {{-- ========================================== --}}
    {{-- MOBILE CARDS VIEW                          --}}
    {{-- ========================================== --}}
    <div class="flex lg:hidden flex-col gap-6 w-full pb-8">
        @forelse($services as $service)
            <div
                class="bg-white rounded-[16px] shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden relative">
                {{-- Left accent border --}}
                <div
                    class="absolute left-0 top-0 bottom-0 w-1 {{ $service->is_active ? 'bg-[#4a40e0]' : 'bg-slate-200' }}"></div>

                <div class="p-5 pl-6 flex flex-col gap-4">
                    {{-- Top: Title & Actions --}}
                    <div class="flex justify-between items-start gap-4">
                        <h3 class="font-bold text-[#203044] text-[18px] leading-tight">{{ $service->name }}</h3>
                        <div class="flex gap-2 shrink-0">
                            <button class="p-2 text-[#4d5d73] bg-slate-50 rounded-lg">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </button>
                            <button wire:click="confirmDelete({{ $service->id }})"
                                    class="p-2 text-rose-600 bg-rose-50 rounded-lg">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Middle: Badge & Price --}}
                    <div class="flex items-center gap-3">
                        <span
                            class="bg-[rgba(151,149,255,0.2)] text-[#14007e] font-bold text-[10px] tracking-[0.5px] uppercase px-3 py-1 rounded-md">
                            {{ $service->duration }} Min
                        </span>
                        <span
                            class="font-bold text-[#203044] text-[18px]">${{ number_format($service->price, 2) }}</span>
                    </div>
                </div>

                {{-- Bottom: Status Toggle --}}
                <div
                    class="border-t border-[rgba(158,174,199,0.1)] px-6 py-3 flex items-center justify-between bg-slate-50/30">
                    <span class="font-medium text-[#4d5d73] text-[12px] tracking-[1.2px] uppercase">Active Status</span>
                    <button wire:click="toggleStatus({{ $service->id }})"
                            class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $service->is_active ? 'bg-[#4a40e0]' : 'bg-slate-200' }}">
                        <span
                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $service->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                    </button>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-[#4d5d73] bg-white rounded-2xl shadow-sm border border-slate-100">No
                services found. Click "Add New Service" to get started.
            </div>
        @endforelse

        {{-- Mobile Pagination --}}
        <div class="mt-2">
            {{ $services->links(data: ['scrollTo' => false]) }}
        </div>
    </div>

    <livewire:components.admin-create-service-modal />
    <livewire:components.admin-edit-service-modal />
    <livewire:components.admin-delete-service-modal />
</div>
