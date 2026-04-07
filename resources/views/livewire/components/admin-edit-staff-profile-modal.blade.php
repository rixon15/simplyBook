<x-modal wire:model="showModal">
    <div class="bg-white rounded-[28px] overflow-hidden shadow-2xl flex flex-col max-h-[95vh]">
        <div class="bg-[#f4f6ff] px-8 py-6 flex justify-between items-center shrink-0 border-b border-indigo-50">
            <h3 class="text-xl font-black text-[#203044]">Edit Profile</h3>
            <button @click="show = false" class="text-[#9eaec7] hover:text-rose-500 p-2 bg-white rounded-full shadow-sm transition-colors">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form wire:submit.prevent="update" class="p-8 overflow-y-auto space-y-6">
            {{-- Avatar Upload Section --}}
            <div class="flex justify-center">
                <div class="relative group">
                    <div class="size-32 rounded-[32px] bg-slate-100 overflow-hidden border-4 border-white shadow-md">
                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" class="size-full object-cover">
                        @else
                            <img src="{{ $existingPhotoUrl }}" class="size-full object-cover">
                        @endif
                    </div>
                    <label class="absolute -bottom-2 -right-2 size-10 bg-[#4a40e0] text-white rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:scale-110 transition-transform border-4 border-white">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <input type="file" wire:model="photo" class="hidden" accept="image/*">
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block ml-1">Full Name</label>
                    <input type="text" wire:model="name" class="w-full bg-[#f4f6ff] border-none rounded-xl px-4 py-3 text-sm font-bold text-[#203044] focus:ring-2 focus:ring-[#4a40e0]">
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block ml-1">Title</label>
                    <input type="text" wire:model="title" class="w-full bg-[#f4f6ff] border-none rounded-xl px-4 py-3 text-sm font-bold text-[#203044] focus:ring-2 focus:ring-[#4a40e0]">
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block ml-1">Email</label>
                <input type="email" wire:model="email" class="w-full bg-[#f4f6ff] border-none rounded-xl px-4 py-3 text-sm font-medium text-[#203044] focus:ring-2 focus:ring-[#4a40e0]">
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block ml-1">Phone</label>
                <input type="text" wire:model="phone" class="w-full bg-[#f4f6ff] border-none rounded-xl px-4 py-3 text-sm font-medium text-[#203044] focus:ring-2 focus:ring-[#4a40e0]">
            </div>

            <button type="submit" class="w-full bg-[#4a40e0] text-white py-5 rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-indigo-100 hover:bg-[#3d30d4] transition-all">
                Save Changes
            </button>
        </form>
    </div>
</x-modal>
