<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="min-h-screen bg-[#f4f6ff] flex flex-col font-['Inter',sans-serif]">

    <div class="flex-grow flex items-center justify-center p-6 sm:p-12 relative z-10">

        <div class="bg-white rounded-2xl shadow-[0px_20px_40px_-12px_rgba(32,48,68,0.08)] p-8 sm:p-10 w-full max-w-[480px]">

            <div class="flex flex-col items-center text-center mb-8">
                <h1 class="text-[#4a40e0] text-[24px] font-extrabold tracking-[-1.2px] mb-8">SimplyBook</h1>

                <div class="bg-[#eaf1ff] w-16 h-16 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-[#4a40e0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </div>

                <h2 class="text-[#203044] text-[24px] font-bold tracking-[-0.6px] mb-4">Forgot Password?</h2>
                <p class="text-[#4d5d73] text-[14px] leading-relaxed max-w-[320px]">
                    Enter the email address associated with your account and we'll send you a link to reset your password.
                </p>
            </div>

            <x-auth-session-status class="mb-4 text-center font-medium text-sm text-green-600" :status="session('status')" />

            <form wire:submit="sendPasswordResetLink" class="space-y-6">

                <div>
                    <label class="block text-[#4d5d73] text-[12px] font-semibold tracking-[0.6px] uppercase mb-2">Email Address</label>
                    <div class="relative">
                        <input wire:model="email" type="email" placeholder="name@company.com" required autofocus autocomplete="username"
                               class="w-full bg-[#eaf1ff] border-none rounded-xl pl-12 pr-4 py-4 text-[#203044] placeholder-[#9eaec7] focus:ring-2 focus:ring-[#4a40e0] transition-shadow">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#9eaec7]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-500 text-sm" />
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-[#4a40e0] to-[#3d30d4] text-white font-semibold text-[16px] rounded-xl py-4 shadow-[0px_10px_15px_-3px_rgba(74,64,224,0.2)] hover:opacity-90 transition-opacity">
                    Send Reset Link
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-[rgba(158,174,199,0.1)] text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-[#4a40e0] text-[14px] font-medium hover:underline" wire:navigate>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Login
                </a>
            </div>

        </div>
    </div>

    <div class="py-8 flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-8 text-[#4d5d73] text-[12px]">
        <span>© 2024 SimplyBook. All rights reserved.</span>
        <div class="flex items-center gap-4">
            <a href="#" class="hover:text-[#203044] transition-colors">Privacy Policy</a>
            <a href="#" class="hover:text-[#203044] transition-colors">Terms of Service</a>
            <a href="#" class="hover:text-[#203044] transition-colors">Support</a>
        </div>
    </div>
</div>
