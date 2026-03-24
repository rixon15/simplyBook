@props(['name', 'show' => false, 'persistent' => false])

<div
    {{-- Pass the PHP $persistent variable into Alpine's JavaScript --}}
    x-data="{
        show: @entangle($attributes->wire('model')).live,
        persistent: @js($persistent)
    }"
    x-show="show"
    {{-- Only close on ESC key if it's NOT persistent --}}
    x-on:keydown.escape.window="if(!persistent) show = false"
    style="display: none;"
    class="fixed inset-0 z-[150] overflow-y-auto"
>
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-xl z-[151] transition-opacity"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 relative z-[152]">

        <div
            x-show="show"
            @click.outside="if(!persistent) show = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            class="relative transform transition-all w-full sm:max-w-lg"
        >
            {{ $slot }}
        </div>

    </div>
</div>
