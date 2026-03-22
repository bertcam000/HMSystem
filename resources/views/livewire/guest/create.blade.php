<?php

use App\Models\Guest;
use Livewire\Volt\Component;

new class extends Component {

    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $nationality;
    public $date_of_birth;
    public $address;

    public $id_type;
    public $id_number;

    public $notes;

    public function saveGuest()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|nullable|string|max:50',
            'email' => 'required|nullable|email',
            'nationality' => 'required|nullable|string|max:255',
            'date_of_birth' => 'required|nullable|date',
            'address' => 'required|nullable|string|max:500',
            'id_type' => 'required|nullable|string',
            'id_number' => 'required|nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Example save logic
        $guest =Guest::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'id_type' => $this->id_type,
            'id_number' => $this->id_number,
            'nationality' => $this->nationality,
            'date_of_birth' => $this->date_of_birth,
            'notes' => $this->notes,

        ]);

        // session()->flash('success', 'Guest saved successfully!');
        return redirect('/guests')->with('success', 'User created successfully!');

        $this->reset();
    }
};
?>

<div @click.away="addGuest = false" class="max-h-[95vh] overflow-y-auto w-[650px] mx-auto bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
    <h2 class="text-xl font-semibold text-gray-800 mb-2">New Guest</h2>
    <form class="space-y-4 mt-4" wire:submit.prevent="saveGuest" >

        <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
            <x-input wire:model="first_name" icon="user" label="Firstname" placeholder="John"/>
            <x-input wire:model="last_name" icon="user" label="Lastname" placeholder="Doe"/>
        </div>

        <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
            <x-input wire:model="email" icon="at-symbol" label="Email" placeholder="email@gmail.com"/>
            <x-input wire:model="phone" icon="phone" label="Phone" placeholder="phone number"/>
        </div>

        <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
            <x-input wire:model="nationality" icon="user" label="Nationality" placeholder="e.g. Filipino"/>
            <x-datetime-picker
                wire:model="date_of_birth"
                label="Select Birthdate"
                placeholder="1/2/2026"
                without-time
                :max="now()->addDays(7)->hours(12)->minutes(30)"
            />
        </div>

        <div class="lg:flex lg:items-center lg:gap-3 space-y-4 lg:space-y-0">
            <x-native-select
                wire:model="id_type"
                label="Select ID Type"
                placeholder="Select one id type"
                :options="['Passport', 'National ID', 'Driving License', 'Other']"
            />
            <x-input wire:model="id_number" icon="identification" label="ID Number" placeholder="Enter ID number"/>

        </div>

        <div class="">
            <x-input wire:model="address" icon="home" label="Address" placeholder="Enter address"/>

        </div>
        <x-textarea wire:model="notes" label="Notes" placeholder="write your notes" />
        
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
