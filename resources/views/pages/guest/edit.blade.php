<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Guest</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <wireui:scripts />
    @livewireStyles
</head>
<body>
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-slate-400">HMS Guest Management</p>
                    <h1 class="mt-1 text-3xl font-semibold tracking-tight text-slate-900">Edit Guest Profile</h1>
                    <p class="mt-2 text-sm text-slate-500">
                        Update guest information, identification details, and contact records.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ url('/guests') }}"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-100">
                        Back to Guest List
                    </a>

                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">

                <!-- Left Content -->
                <div class="space-y-6 xl:col-span-8">

                    <form id="guestForm" action="{{ route('guest.update', $guest->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-100 px-6 py-5">
                                <h2 class="text-lg font-semibold text-slate-900">Basic Information</h2>
                                <p class="mt-1 text-sm text-slate-500">
                                    Primary guest details used in registration and reservation records.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">First Name</label>
                                    <input
                                        type="text"
                                        name="first_name"
                                        value="{{ old('first_name', $guest->first_name) }}"
                                        class="@error('first_name') border-red-500 @enderror w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-slate-400"
                                        placeholder="Enter first name"
                                    >
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Last Name</label>
                                    <input
                                        type="text"
                                        name="last_name"
                                        value="{{ old('last_name', $guest->last_name) }}"
                                        class="@error('last_name') border-red-500 @enderror w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-slate-400"
                                        placeholder="Enter last name"
                                    >
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Email Address</label>
                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email', $guest->email) }}"
                                        class="@error('email') border-red-500 @enderror w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-slate-400"
                                        placeholder="Enter email"
                                    >
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Phone Number</label>
                                    <input
                                        type="text"
                                        name="phone"
                                        value="{{ old('phone', $guest->phone) }}"
                                        class="@error('phone') border-red-500 @enderror w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-slate-400"
                                        placeholder="Enter phone number"
                                    >
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Nationality</label>
                                    <input
                                        type="text"
                                        name="nationality"
                                        value="{{ old('nationality', $guest->nationality) }}"
                                        class="@error('nationality') border-red-500 @enderror w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-slate-400"
                                        placeholder="Enter nationality"
                                    >
                                    @error('nationality')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Date of Birth</label>
                                    <input
                                        type="date"
                                        name="date_of_birth"
                                        value="{{ old('date_of_birth', optional($guest->date_of_birth)->format('Y-m-d') ?? $guest->date_of_birth) }}"
                                        class="@error('date_of_birth') border-red-500 @enderror w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-slate-400"
                                    >
                                    @error('date_of_birth')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Identification Details -->
                        <div class="mt-6 overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-100 px-6 py-5">
                                <h2 class="text-lg font-semibold text-slate-900">Identification Details</h2>
                                <p class="mt-1 text-sm text-slate-500">
                                    Official ID information presented during check-in.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">ID Type</label>
                                    <select
                                        name="id_type"
                                        class="@error('id_type') border-red-500 @enderror w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-slate-400"
                                    >
                                        <option value="">Select ID Type</option>
                                        <option value="Passport" {{ old('id_type', $guest->id_type) == 'Passport' ? 'selected' : '' }}>Passport</option>
                                        <option value="National ID" {{ old('id_type', $guest->id_type) == 'National ID' ? 'selected' : '' }}>National ID</option>
                                        <option value="Driving License" {{ old('id_type', $guest->id_type) == 'Driving License' ? 'selected' : '' }}>Driving License</option>
                                        <option value="Other" {{ old('id_type', $guest->id_type) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('id_type')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">ID Number</label>
                                    <input
                                        type="text"
                                        name="id_number"
                                        value="{{ old('id_number', $guest->id_number) }}"
                                        class="@error('id_number') border-red-500 @enderror w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-slate-400"
                                        placeholder="Enter ID number"
                                    >
                                    @error('id_number')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Address & Notes -->
                        <div class="mt-6 overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-100 px-6 py-5">
                                <h2 class="text-lg font-semibold text-slate-900">Address & Notes</h2>
                                <p class="mt-1 text-sm text-slate-500">
                                    Additional contact and internal information.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-5 p-6">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Address</label>
                                    <input
                                        type="text"
                                        name="address"
                                        value="{{ old('address', $guest->address) }}"
                                        class="@error('address') border-red-500 @enderror w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-slate-400"
                                        placeholder="Enter complete address"
                                    >
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Notes</label>
                                    <textarea
                                        rows="5"
                                        name="notes"
                                        class="@error('notes') border-red-500 @enderror w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-slate-400"
                                        placeholder="Write notes here..."
                                    >{{ old('notes', $guest->notes) }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Right Sidebar -->
                <div class="space-y-6 xl:col-span-4">

                    <!-- Guest Summary -->
                    <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-lg font-bold text-slate-700">
                                {{ strtoupper(substr($guest->first_name, 0, 1) . substr($guest->last_name, 0, 1)) }}
                            </div>

                            <div class="min-w-0">
                                <h2 class="truncate text-lg font-semibold text-slate-900">
                                    {{ $guest->first_name . ' ' . $guest->last_name }}
                                </h2>
                                <p class="mt-1 text-sm text-slate-500">{{ $guest->email }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $guest->phone }}</p>
                            </div>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Guest ID</span>
                                <span class="font-semibold text-slate-900">#GST-10024</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Nationality</span>
                                <span class="font-semibold text-slate-900">{{ $guest->nationality }}</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">ID Type</span>
                                <span class="font-semibold text-slate-900">{{ $guest->id_type }}</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Last Stay</span>
                                <span class="font-semibold text-slate-900">{{ $lastBooking }}</span>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Total Bookings</span>
                                <span class="font-semibold text-slate-900">{{ $guest->bookings->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Reservation Snapshot -->
                    <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-slate-900">Reservation Snapshot</h2>
                        <p class="mt-1 text-sm text-slate-500">Recent booking information for quick reference.</p>

                        <div class="mt-5 space-y-4">
                            @forelse ($guest->bookings->take(3) as $latest)
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-slate-900">
                                            Booking #{{ $latest->booking_code ?? 'N/A' }}
                                        </h3>
                                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            {{ ucfirst(str_replace('_', ' ', $latest->status ?? 'confirmed')) }}
                                        </span>
                                    </div>

                                    <p class="mt-2 text-sm text-slate-500">
                                        {{ $latest->rooms->first()->roomType->name ?? 'Room details unavailable' }}
                                        @if(optional($latest->rooms->first())->room_number)
                                            • Room {{ $latest->rooms->first()->room_number }}
                                        @endif
                                    </p>

                                    <p class="mt-1 text-sm text-slate-500">
                                        {{ \Carbon\Carbon::parse($latest->check_in_date)->format('M d, Y') }}
                                        —
                                        {{ \Carbon\Carbon::parse($latest->check_out_date)->format('M d, Y') }}
                                    </p>
                                </div>
                            @empty
                                <div class="text-center text-gray-500">No Bookings</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-slate-900">Actions</h2>
                        <p class="mt-1 text-sm text-slate-500">Save your changes or cancel editing.</p>

                        <div class="mt-5 grid grid-cols-1 gap-3">
                            <button
                                type="submit"
                                form="guestForm"
                                class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                            >
                                Save Changes
                            </button>

                            <a
                                href="{{ url('/guest') }}"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                            >
                                Cancel
                            </a>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>