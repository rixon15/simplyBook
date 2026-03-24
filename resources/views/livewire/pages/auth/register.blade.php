<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen w-full bg-[#f4f6ff] flex flex-col lg:flex-row font-['Inter',sans-serif]">

    <div class="lg:hidden w-full p-8 flex justify-center">
        <h1 class="text-[#203044] text-[24px] font-bold tracking-[-1.2px]">SimplyBook</h1>
    </div>

    <div class="hidden lg:flex w-full lg:w-5/12 bg-[#4a40e0] relative overflow-hidden flex-col p-12 justify-between">
        <div class="absolute bg-[#3d30d4] blur-[32px] w-[80%] h-[80%] -top-[10%] -left-[10%] opacity-40 rounded-full pointer-events-none"></div>
        <div class="absolute bg-[#818cf8] blur-[32px] w-[60%] h-[60%] top-[40%] left-[50%] opacity-20 rounded-full pointer-events-none"></div>

        <div class="relative z-10">
            <h2 class="text-white text-[24px] font-extrabold tracking-[-1.2px] mb-24">SimplyBook</h2>
            <h1 class="text-white text-[48px] font-extrabold leading-[48px] tracking-[-1.2px] mb-12">
                Book your next <br> appointment in <br> seconds.
            </h1>

            <div class="backdrop-blur-md bg-white/10 border border-white/10 rounded-xl p-6 shadow-2xl max-w-sm">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-2 text-white/90 font-medium text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Next Availability
                    </div>
                    <span class="text-white/60 text-xs tracking-wider uppercase">Today</span>
                </div>
                <div class="grid grid-cols-3 gap-3 mb-4">
                    <div class="bg-white/20 border border-white/5 rounded-lg py-3 text-center text-white text-xs font-semibold">09:00 AM</div>
                    <div class="bg-white rounded-lg py-3 text-center text-[#4a40e0] text-xs font-bold shadow-lg transform scale-105">10:30 AM</div>
                    <div class="bg-white/20 border border-white/5 rounded-lg py-3 text-center text-white text-xs font-semibold">12:00 PM</div>
                    <div class="bg-white/20 border border-white/5 rounded-lg py-3 text-center text-white text-xs font-semibold">02:30 PM</div>
                    <div class="bg-white/20 border border-white/5 rounded-lg py-3 text-center text-white/50 text-xs font-semibold line-through">04:00 PM</div>
                    <div class="bg-white/20 border border-white/5 rounded-lg py-3 text-center text-white text-xs font-semibold">05:30 PM</div>
                </div>
                <div class="flex items-center gap-3 pt-2 border-t border-white/10">
                    <div class="text-white/80 text-xs">Join 2,000+ others today</div>
                </div>
            </div>
        </div>

        <div class="relative z-10 text-white/60 text-sm mt-12">
            ESTABLISHED 2024 © SIMPLYBOOK INC.
        </div>
    </div>

    <div class="w-full lg:w-7/12 flex items-center justify-center p-6 lg:p-24 relative z-10">

        <div class="bg-white rounded-2xl shadow-[0px_20px_40px_-12px_rgba(32,48,68,0.08)] p-8 sm:p-10 w-full max-w-md">

            <div class="mb-8">
                <h2 class="text-[#203044] text-[24px] lg:text-[30px] font-bold tracking-tight leading-tight mb-2">Create your account</h2>
                <p class="text-[#4d5d73] text-[14px] lg:text-[16px]">Join the most effortless booking platform.</p>
            </div>

            <form wire:submit="register" class="space-y-5">

                <div>
                    <label class="block text-[#4d5d73] text-[11px] font-bold tracking-[0.55px] uppercase mb-1.5">Full Name</label>
                    <input wire:model="name" type="text" placeholder="Enter your full name" required autofocus autocomplete="name"
                           class="w-full bg-[#eaf1ff] border-none rounded-lg px-4 py-3.5 text-[#203044] placeholder-[#68788f] focus:ring-2 focus:ring-[#4a40e0] transition-shadow">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-500 text-sm" />
                </div>

                <div>
                    <label class="block text-[#4d5d73] text-[11px] font-bold tracking-[0.55px] uppercase mb-1.5">Email Address</label>
                    <input wire:model="email" type="email" placeholder="name@company.com" required autocomplete="username"
                           class="w-full bg-[#eaf1ff] border-none rounded-lg px-4 py-3.5 text-[#203044] placeholder-[#68788f] focus:ring-2 focus:ring-[#4a40e0] transition-shadow">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-500 text-sm" />
                </div>

                <div>
                    <label class="block text-[#4d5d73] text-[11px] font-bold tracking-[0.55px] uppercase mb-1.5">Password</label>
                    <input wire:model="password" type="password" placeholder="••••••••" required autocomplete="new-password"
                           class="w-full bg-[#eaf1ff] border-none rounded-lg px-4 py-3.5 text-[#203044] placeholder-[#68788f] focus:ring-2 focus:ring-[#4a40e0] transition-shadow">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-500 text-sm" />
                </div>

                <div>
                    <label class="block text-[#4d5d73] text-[11px] font-bold tracking-[0.55px] uppercase mb-1.5">Confirm Password</label>
                    <input wire:model="password_confirmation" type="password" placeholder="••••••••" required autocomplete="new-password"
                           class="w-full bg-[#eaf1ff] border-none rounded-lg px-4 py-3.5 text-[#203044] placeholder-[#68788f] focus:ring-2 focus:ring-[#4a40e0] transition-shadow">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-rose-500 text-sm" />
                </div>

                <div class="flex items-start gap-3 pt-2">
                    <div class="flex items-center h-5">
                        <input id="terms" type="checkbox" required class="w-4 h-4 bg-[#eaf1ff] border-gray-300 rounded text-[#4a40e0] focus:ring-[#4a40e0]">
                    </div>
                    <label for="terms" class="text-[#4d5d73] text-[13px] leading-relaxed">
                        I agree to the <a href="#" class="font-semibold text-[#4a40e0] hover:underline">Terms of Service</a> and <a href="#" class="font-semibold text-[#4a40e0] hover:underline">Privacy Policy</a>.
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-[#4a40e0] to-[#3d30d4] text-white font-semibold text-[16px] rounded-lg py-4 shadow-[0px_10px_15px_-3px_rgba(74,64,224,0.2)] hover:opacity-90 transition-opacity mt-4">
                    Create Account
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-[#d2e4ff] text-center">
                <p class="text-[#4d5d73] text-[14px] font-medium">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-bold text-[#4a40e0] hover:underline" wire:navigate>Sign in</a>
                </p>
            </div>

        </div>
    </div>
</div>

