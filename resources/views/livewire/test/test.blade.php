<?php

use Livewire\Volt\Component;
use App\Models\Room;

new class extends Component {
    public Room $room;
}; ?>

<div>
    {{ $room->room_number }}
</div>
