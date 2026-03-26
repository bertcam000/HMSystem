<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

{{-- <div class="max-w-7xl  px-4 sm:px-6 lg:px-8">
    <!-- Settings Dropdown -->
    <div class="">
        <a href="{{ route('profile') }}" wire:navigate>
            {{ __('Profile') }}
        </a>

        <!-- Authentication -->
        <button wire:click="logout" class="w-full text-start">
            Logout
        </button>
    </div>
</div> --}}

<div class="absolute bottom-0">
    <div class=" px-3 py-3    {{ request()->is('task-management') ? 'bg-[#f8fcfc] text-black rounded-l-full' : '' }} rounded-l-full hover:bg-[#f8fcfc] hover:text-black" x-data="{dropdown1:false}">
        <div class="flex gap-7 items-center ">
            <x-icon name="arrow-left-start-on-rectangle"/>
            <button wire:click="logout" class="w-full text-start">
                Logout
            </button>
        </div>
    </div>
    <div class=" px-3 py-3    {{ request()->is('task-management') ? 'bg-[#f8fcfc] text-black rounded-l-full' : '' }} rounded-l-full hover:bg-[#f8fcfc] hover:text-black" x-data="{dropdown1:false}">
        <div class="flex gap-6 items-center ">
            <x-icon name="user"/>
            <a href="{{ route('profile') }}" wire:navigate>
                {{ __('Profile') }}
            </a>
        </div>
    </div>
</div>
