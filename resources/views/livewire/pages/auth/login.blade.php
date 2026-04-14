<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest-layout')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $user = User::where('email', $this->form->email)->first();

        if ($user && strtolower($user->status) !== 'active') {
            throw ValidationException::withMessages([
                'form.email' => 'Account is inactive.',
            ]);
        }

        $this->form->authenticate();

        Session::regenerate();

        $user = Auth::user();

        $redirectRoute = match ($user->role) {
            'admin' => 'dashboard',
            'staff' => 'bookings',
            default => 'dashboard',
        };

        $this->redirect(route($redirectRoute), navigate: false);
    }
}; ?>

{{-- <div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div> --}}

{{--  --}}

<div class="min-h-screen grid lg:grid-cols-2">
    <div class="m-3 rounded-3xl hidden lg:flex flex-col justify-between bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 px-12 py-14 text-white">
      <div class="flex items-center gap-3">
        <div class="flex  items-center justify-center rounded-2xl text-slate-900 text-lg font-bold shadow-sm">
           <img src="{{ asset('images/bcplogo2.png') }}" class="w-36 h-36" alt="">
        </div>
        {{-- <div>
          <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Hotel System</p>
          <h1 class="text-base font-semibold text-white">HMS Portal</h1>
        </div> --}}
      </div>

      <div class="max-w-xl">
        {{-- <p class="text-sm font-medium text-slate-100"></p> --}}
        <h2 class=" text-5xl font-semibold leading-tight tracking-tight text-white">
          Hotel Management System
        </h2>
        <p class="mt-6 max-w-lg text-base leading-7 text-slate-100">
          Manage reservations, rooms, guest records, and payments from one calm and focused dashboard.
        </p>
      </div>

      <div class="grid grid-cols-3 gap-4 text-sm">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
          <p class="font-semibold text-white">Bookings</p>
          <p class="mt-1 text-slate-100">Centralized flow</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
          <p class="font-semibold text-white">Guests</p>
          <p class="mt-1 text-slate-100">Quick lookup</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
          <p class="font-semibold text-white">Payments</p>
          <p class="mt-1 text-slate-100">Clean records</p>
        </div>
      </div>
    </div>

    <div class="flex items-center justify-center px-6 py-10 sm:px-8 lg:px-12">
      <div class="w-full max-w-md">
        <div class="mb-10 flex items-center gap-3 lg:hidden">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-900 text-white text-lg font-bold">
            H
          </div>
          <div>
            <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Hotel System</p>
            <h1 class="text-base font-semibold text-slate-900">HMS Portal</h1>
          </div>
        </div>

        <div class="rounded-[2rem] p-8 sm:p-10">
            <div class="text-center space-y-2">
                <h2 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Sign in</h2>
                <p class="text-sm font-medium text-slate-500">Welcome back, please enter your details</p>
            </div>

            <form class="mt-8 space-y-5" wire:submit="login">
                <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Email or Username</label>
                <input wire:model="form.email" id="email"
                    type="text"
                    placeholder="Enter your email or username"
                    class="@error('form.email') border border-red-500 @enderror w-full rounded-2xl border border-gray-400 bg-white px-4 py-3.5 text-sm text-slate-800 outline-none transition focus:border-slate-400 focus:ring-4 focus:ring-slate-200"
                />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>

                <div>
                <div class="mb-2 flex items-center justify-between gap-3">
                    <label class="block text-sm font-medium text-slate-700">Password</label>
                </div>
                <input wire:model="form.password" id="password"
                    type="password"
                    placeholder="Enter your password"
                    class="@error('form.password') border border-red-500 @enderror w-full rounded-2xl border border-slate-400 bg-white px-4 py-3.5 text-sm text-slate-800 outline-none transition focus:border-slate-400 focus:ring-4 focus:ring-slate-200"
                />
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                </div>


                <div class="mt-5">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
                
                <div class="mt-5">
                    <button
                        type="submit"
                        class=" w-full rounded-2xl bg-slate-900 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300"
                        >
                        Sign In
                    </button>
                </div>
            </form>

          
        </div>
      </div>
    </div>
  </div>