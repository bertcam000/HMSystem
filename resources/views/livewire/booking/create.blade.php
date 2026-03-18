<?php

use Livewire\Volt\Component;

new class extends Component {
    public $user_id;
}; ?>

<div @click.away="addBooking = false" class="max-h-[95vh] overflow-y-auto w-[650px] mx-auto bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
    <h2 class="text-xl font-semibold text-gray-800 mb-2">New Booking</h2>
    <form class="space-y-4 mt-4" wire:submit.prevent="submit" @click.away="addBooking = ''">
        <div>
            <x-select
                label="Select User"
                placeholder="Search user..."
                :async-data="route('users.search')"
                option-label="name"
                option-value="id"
                wire:model.live="user_id"
            />
        </div>

        <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
            <x-input icon="at-symbol" label="Email" placeholder="email@gmail.com"/>
            <x-input icon="phone" label="Phone" placeholder="phone number"/>
        </div>

        <div>
            <x-select
                icon="key"
                label="Select Room"
                placeholder="Search user..."
                :async-data="route('users.search')"
                option-label="name"
                option-value="id"
                wire:model.live="user_id"
            />
        </div>

        <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
            <x-datetime-picker
                label="Select Check In Date"
                placeholder="1/2/2026"
                wire:model="date"
                without-time
                :min="now()->subDays(7)->hours(12)->minutes(30)"
            />
            <x-datetime-picker
                label="Select Check Out Date"
                placeholder="1/2/2026"
                wire:model="date"
                without-time
                :min="now()->subDays(7)->hours(12)->minutes(30)"
            />
        </div>

        <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
            <x-number label="How many Adults?" placeholder="0" />
            <x-number label="How many Children?" placeholder="0" />
        </div>

        <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
            <x-native-select
                label="Select Status"
                placeholder="Select one status"
                :options="['Active', 'Pending', 'Stuck', 'Done']"
            />
            <x-native-select
                label="Select Source"
                placeholder="Select one status"
                :options="['Online', 'Phone', 'Walk-in']"
            />
        </div>

        <div>
            <x-textarea label="Request" placeholder="write your request" />
        </div>
        
        <div class="flex justify-end">
            <button
                type="submit"
                class="px-5 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-gray-800 transition"
            >
                Add Booking {{ $user_id }}
            </button>
        </div>

    </form>

</div>