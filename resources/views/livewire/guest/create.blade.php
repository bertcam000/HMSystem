<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div @click.away="addGuest = false" class="max-h-[95vh] overflow-y-auto w-[650px] mx-auto bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
    <h2 class="text-xl font-semibold text-gray-800 mb-2">New Guest</h2>
    <form class="space-y-4 mt-4" wire:submit.prevent="submit" @click.away="addGuest = ''">
        <div>
            <x-input icon="user" label="Full Name" placeholder="John Doe"/>
        </div>

        <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
            <x-input icon="at-symbol" label="Email" placeholder="email@gmail.com"/>
            <x-input icon="phone" label="Phone" placeholder="phone number"/>
        </div>

        <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
            <x-input icon="user" label="Nationality" placeholder="e.g. Filipino"/>
            <x-datetime-picker
                label="Select Birthdate"
                placeholder="1/2/2026"
                wire:model="date"
                without-time
                :max="now()->addDays(7)->hours(12)->minutes(30)"
            />
        </div>

        <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
            <x-native-select
                label="Select ID Type"
                placeholder="Select one id type"
                :options="['Passport', 'National ID', 'Driving License', 'Other']"
            />
            <x-input icon="identification" label="ID Number" placeholder="Enter ID number"/>

        </div>

        <div class="">
            <x-input icon="home" label="Address" placeholder="Enter address"/>

        </div>
        
        <div class="flex justify-end">
            <button
                type="submit"
                class="px-5 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-gray-800 transition"
            >
                Add Guest 
            </button>
        </div>

    </form>

</div>
