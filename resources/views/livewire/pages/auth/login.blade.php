<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>



<div class="min-h-screen bg-[#f4f6ff] flex flex-col lg:flex-row font-['Inter',sans-serif]">

    <div class="lg:hidden w-full p-8 flex justify-center">
        <h1 class="text-[#203044] text-[24px] font-bold tracking-[-1.2px]">SimplyBook</h1>
    </div>

    <div class="hidden lg:flex w-full lg:w-5/12 bg-[#4a40e0] relative overflow-hidden flex-col p-12 justify-between">
        <div class="absolute bg-[#9795ff] blur-[40px] w-[384px] h-[384px] -top-[96px] -right-[96px] opacity-30 rounded-full pointer-events-none"></div>
        <div class="absolute bg-[#983772] blur-[40px] w-[256px] h-[256px] bottom-[200px] -left-[96px] opacity-20 rounded-full pointer-events-none"></div>

        <div class="relative z-10">
            <h2 class="text-white text-[24px] font-black tracking-[-1.2px] mb-24">SimplyBook</h2>
            <h1 class="text-[#f4f1ff] text-[50px] xl:text-[60px] font-extrabold leading-[1.1] tracking-[-1.5px] mb-12">
                Book your next <br> appointment in <br> seconds.
            </h1>

            <div class="backdrop-blur-md bg-white/10 border border-white/10 rounded-xl p-6 shadow-2xl max-w-[340px]">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/10 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <div class="text-white text-sm font-semibold">March 2024</div>
                            <div class="text-white/60 text-xs">Available slots found</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-7 gap-1 mb-4 text-center">
                    <div class="text-white/40 text-[10px] font-bold uppercase">M</div>
                    <div class="text-white/40 text-[10px] font-bold uppercase">T</div>
                    <div class="text-white/40 text-[10px] font-bold uppercase">W</div>
                    <div class="text-white/40 text-[10px] font-bold uppercase">T</div>
                    <div class="text-white/40 text-[10px] font-bold uppercase">F</div>
                    <div class="text-white/40 text-[10px] font-bold uppercase">S</div>
                    <div class="text-white/40 text-[10px] font-bold uppercase">S</div>

                    <div class="text-white/30 text-xs py-2">12</div>
                    <div class="text-white/30 text-xs py-2">13</div>
                    <div class="bg-white/20 border border-white/30 rounded-lg text-white font-bold text-xs py-2">14</div>
                    <div class="bg-[#9795ff] rounded-lg text-[#14007e] font-bold text-xs py-2 shadow-lg relative transform scale-110 z-10">15</div>
                    <div class="text-white/60 text-xs py-2">16</div>
                    <div class="text-white/60 text-xs py-2">17</div>
                    <div class="text-white/60 text-xs py-2">18</div>
                </div>

                <div class="space-y-2">
                    <div class="bg-white/5 rounded-lg p-3 flex justify-between items-center">
                        <span class="text-white/80 text-xs font-medium">09:00 AM</span>
                        <div class="w-3 h-3 rounded-full bg-[#9795ff]"></div>
                    </div>
                    <div class="bg-white/5 opacity-50 rounded-lg p-3 flex justify-between items-center">
                        <span class="text-white/80 text-xs font-medium">10:30 AM</span>
                        <div class="w-2 h-2 rounded-full bg-white/40"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative z-10 flex items-center gap-4 mt-12">
            <div class="flex -space-x-3">
                <div class="w-10 h-10 rounded-full border-2 border-[#4a40e0] bg-indigo-200 overflow-hidden"><img src="https://i.pravatar.cc/100?img=1" alt="User"></div>
                <div class="w-10 h-10 rounded-full border-2 border-[#4a40e0] bg-indigo-300 overflow-hidden"><img src="https://i.pravatar.cc/100?img=2" alt="User"></div>
                <div class="w-10 h-10 rounded-full border-2 border-[#4a40e0] bg-indigo-400 overflow-hidden"><img src="https://i.pravatar.cc/100?img=3" alt="User"></div>
            </div>
            <span class="text-white/80 text-sm font-medium">Joined by 10k+ professionals</span>
        </div>
    </div>

    <div class="w-full lg:w-7/12 flex flex-col justify-between p-6 lg:p-12 relative z-10">

        <div class="flex-grow flex items-center justify-center">
            <div class="bg-white rounded-2xl lg:shadow-[0px_20px_40px_-12px_rgba(32,48,68,0.08)] p-6 sm:p-10 w-full max-w-md">

                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-[#203044] text-[24px] lg:text-[30px] font-extrabold tracking-tight leading-tight mb-2">Welcome back</h2>
                    <p class="text-[#4d5d73] text-[14px] lg:text-[16px]">Please enter your details to sign in.</p>
                </div>

                <form wire:submit="login" class="space-y-6">

                    <div>
                        <label class="block text-[#203044] text-[12px] font-bold tracking-[0.6px] uppercase mb-2">Email Address</label>
                        <input wire:model="form.email" type="email" placeholder="name@company.com" required autofocus autocomplete="username"
                               class="w-full bg-[#eaf1ff] border-none rounded-xl px-4 py-4 text-[#203044] placeholder-[#9eaec7] focus:ring-2 focus:ring-[#4a40e0] transition-shadow">
                        <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-rose-500 text-sm" />
                    </div>

                    <div>
                        <label class="block text-[#203044] text-[12px] font-bold tracking-[0.6px] uppercase mb-2">Password</label>
                        <input wire:model="form.password" type="password" placeholder="••••••••" required autocomplete="current-password"
                               class="w-full bg-[#eaf1ff] border-none rounded-xl px-4 py-4 text-[#203044] placeholder-[#9eaec7] focus:ring-2 focus:ring-[#4a40e0] transition-shadow">
                        <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-rose-500 text-sm" />
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <div class="flex items-center gap-2">
                            <input wire:model="form.remember" id="remember" type="checkbox" class="w-4 h-4 bg-[#eaf1ff] border-transparent rounded text-[#4a40e0] focus:ring-[#4a40e0]">
                            <label for="remember" class="text-[#4d5d73] text-[14px] font-medium cursor-pointer">Remember me</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[#4a40e0] text-[14px] font-semibold hover:underline" wire:navigate>
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-[#4a40e0] to-[#3d30d4] text-white font-bold text-[16px] rounded-xl py-4 shadow-[0px_10px_15px_-3px_rgba(74,64,224,0.2)] hover:opacity-90 transition-opacity mt-2">
                        Sign In
                    </button>
                </form>

                <div class="flex items-center my-8">
                    <div class="flex-grow border-t border-[rgba(158,174,199,0.2)]"></div>
                    <span class="px-4 text-[12px] font-bold text-[rgba(104,120,143,0.6)] tracking-[1.2px] uppercase">Or continue with</span>
                    <div class="flex-grow border-t border-[rgba(158,174,199,0.2)]"></div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button class="flex items-center justify-center gap-2 bg-white border border-[rgba(158,174,199,0.2)] rounded-xl py-3.5 hover:bg-gray-50 transition-colors shadow-sm">
                        <svg class="w-5 h-5" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                        <span class="text-[#203044] text-[14px] font-semibold">Google</span>
                    </button>
                    <button class="flex items-center justify-center gap-2 bg-white border border-[rgba(158,174,199,0.2)] rounded-xl py-3.5 hover:bg-gray-50 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                        <span class="text-[#203044] text-[14px] font-semibold">GitHub</span>
                    </button>
                </div>

                <div class="text-center mt-8">
                    <p class="text-[#4d5d73] text-[14px] font-medium">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-bold text-[#4a40e0] hover:underline" wire:navigate>Sign up</a>
                    </p>
                </div>

            </div>
        </div>

        <div class="lg:hidden mt-8 text-center text-[10px] text-[#9eaec7]">
            © 2024 SimplyBook. All rights reserved.
        </div>
    </div>
</div>
