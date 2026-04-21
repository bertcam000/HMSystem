<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Dates & Availability | La Nuevo Hogar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ asset('images/cropped_circle_image.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/site-ui.css') }}">
    <script defer src="{{ asset('assets/js/site-ui.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: "#d1a545",
                        darkbg: "#08080b",
                        softdark: "#151519",
                    },
                    fontFamily: {
                        luxury: ["Playfair Display", "serif"],
                        sans: ["Manrope", "sans-serif"],
                    },
                },
            },
        };
    </script>

    <style>
        [x-cloak]{display:none!important;}
        body{font-family:"Manrope",sans-serif;background:#08080b;}
        h1,h2,h3,h4,h5,h6,.font-luxury{font-family:"Playfair Display",serif;}
        .shell-grid{display:grid;gap:1.5rem;}
        .booking-shell{max-width:84rem;}
        @media (min-width:1280px){.shell-grid{grid-template-columns:minmax(0,1fr) minmax(20.5rem,22rem);align-items:start;}}
        .panel{background:linear-gradient(180deg,rgba(20,20,24,.98),rgba(16,16,20,.98));border:1px solid rgba(209,165,69,.16);box-shadow:0 24px 70px rgba(0,0,0,.36);}
        .card{background:#1b1b20;border:1px solid rgba(255,255,255,.08);}
        .field{background:#212126;border:1px solid rgba(255,255,255,.1);color:#fff;}
        .field:focus{outline:none;border-color:rgba(209,165,69,.55);box-shadow:0 0 0 3px rgba(209,165,69,.12);}
        .booking-label{display:block;margin-bottom:.9rem;font-size:.74rem;font-weight:700;letter-spacing:.42em;text-transform:uppercase;color:#9ba0bc;}
        .booking-input{min-height:3.5rem;padding:1rem 1.1rem;font-size:.98rem;line-height:1.5;}
        .booking-primary-btn{min-height:3.5rem;padding:.95rem 1.6rem;font-size:.96rem;font-weight:800;}
        .booking-secondary-btn{min-height:3.5rem;padding:.95rem 1.5rem;font-size:.95rem;}
        .booking-kicker{font-size:.72rem;letter-spacing:.42em;text-transform:uppercase;color:#8f93a8;}
        .booking-page-title{font-size:clamp(2.5rem,4.2vw,4rem);line-height:.95;color:#fff;}
        .booking-section-title{font-size:clamp(2rem,3vw,2.65rem);line-height:1.04;color:#fff;}
        .booking-copy,.booking-info-copy{font-size:.97rem;line-height:1.75;color:#9fa4b8;}
        .booking-summary-title{font-size:clamp(2rem,2.4vw,2.45rem);line-height:1.08;color:#fff;}
        .availability-box{border-radius:1rem;border:1px solid rgba(255,255,255,.1);padding:1rem 1.1rem;}
        .availability-box.idle{background:rgba(255,255,255,.03);border-color:rgba(255,255,255,.08);color:#9fa4b8;}
        .availability-box.checking{background:rgba(209,165,69,.08);border-color:rgba(209,165,69,.25);color:#f3d18a;}
        .availability-box.available{background:rgba(16,185,129,.10);border-color:rgba(16,185,129,.35);color:#6ee7b7;}
        .availability-box.unavailable{background:rgba(239,68,68,.10);border-color:rgba(239,68,68,.35);color:#fca5a5;}
    </style>
</head>
<body class="text-gray-200" x-data="availabilityPage()" x-init="init()">
    <main class="booking-shell mx-auto px-4 sm:px-6 py-10 md:py-14 space-y-8">
        <section class="space-y-3">
            <p class="booking-kicker">Reservation</p>
            <h1 class="booking-page-title">Dates &amp; Availability</h1>
        </section>

        <div class="shell-grid">
            <div class="space-y-6">
                <section class="panel rounded-[28px] p-8 md:p-9" x-show="roomType" x-cloak>
                    <div class="space-y-2 mb-8">
                        <h2 class="booking-section-title">Select Your Dates</h2>
                        <p class="booking-copy">Choose your check-in and check-out dates to validate room type availability.</p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="booking-label">Check-In Date</label>
                            <input x-ref="checkinInput" type="text" placeholder="dd/mm/yyyy" class="booking-input field w-full rounded-xl text-white" />
                            <p class="text-xs text-red-400 mt-2" x-show="errors.checkin" x-text="errors.checkin"></p>
                        </div>
                        <div>
                            <label class="booking-label">Check-Out Date</label>
                            <input x-ref="checkoutInput" type="text" placeholder="dd/mm/yyyy" class="booking-input field w-full rounded-xl text-white" />
                            <p class="text-xs text-red-400 mt-2" x-show="errors.checkout" x-text="errors.checkout"></p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="booking-label">Adults</label>
                            <input type="number" min="1" x-model="state.stay.adults" class="booking-input field w-full rounded-xl">
                        </div>
                        <div>
                            <label class="booking-label">Children</label>
                            <input type="number" min="0" x-model="state.stay.children" class="booking-input field w-full rounded-xl">
                        </div>
                        <div>
                            <label class="booking-label">Rooms</label>
                            <input type="number" min="1" x-model="state.stay.rooms" class="booking-input field w-full rounded-xl">
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="availability-box" :class="availability.status">
                            <template x-if="availability.status === 'idle'">
                                <p class="text-sm font-medium">Select valid check-in and check-out dates to check room availability.</p>
                            </template>
                            <template x-if="availability.status === 'checking'">
                                <p class="text-sm font-medium">Checking availability for your selected stay...</p>
                            </template>
                            <template x-if="availability.status === 'available'">
                                <p class="text-sm font-semibold" x-text="availability.message"></p>
                            </template>
                            <template x-if="availability.status === 'unavailable'">
                                <p class="text-sm font-semibold" x-text="availability.message"></p>
                            </template>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <button
                            type="button"
                            @click="continueFlow()"
                            class="booking-primary-btn rounded-xl bg-gold text-black hover:bg-[#e1b454] transition disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="availability.status !== 'available'">
                            Proceed to Checkout
                        </button>
                    </div>
                </section>

                @if(request('checkin') && request('checkout'))
                    <section class="panel rounded-[28px] p-8 md:p-9">
                        <div class="space-y-2 mb-8">
                            <h2 class="booking-section-title">Available Rooms</h2>
                            <p class="booking-copy">
                                Showing available room types for {{ request('checkin') }} to {{ request('checkout') }}.
                            </p>
                        </div>

                        @if($availableRoomTypes->count())
                            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                                @foreach($availableRoomTypes as $item)
                                    @php
                                        $type = $item['room_type'];
                                        $imagePath = $type->images->first()?->image_path;
                                        $imageUrl = $imagePath
                                            ? (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')
                                                ? $imagePath
                                                : asset('storage/' . ltrim(str_replace('storage/', '', $imagePath), '/')))
                                            : 'https://via.placeholder.com/1200x800?text=Room+Type';
                                    @endphp

                                    <div class="card rounded-3xl overflow-hidden flex flex-col justify-between">
                                        <div class="relative h-56 overflow-hidden">
                                            <img src="{{ $imageUrl }}" alt="{{ $type->name }}" class="w-full h-full object-cover">
                                            <div class="absolute top-4 left-4">
                                                <span class="inline-flex items-center rounded-full bg-black/70 border border-gold/30 px-3 py-1 text-xs font-semibold text-gold">
                                                    {{ $item['available_count'] }} available
                                                </span>
                                            </div>
                                        </div>

                                        <div class="p-6">
                                            <h3 class="text-2xl font-bold text-white mb-3">{{ $type->name }}</h3>

                                            <p class="text-gray-300 text-sm leading-relaxed mb-4">
                                                {{ \Illuminate\Support\Str::limit($type->description, 120) }}
                                            </p>

                                            <div class="flex flex-wrap gap-2 mb-4">
                                                @if($type->bed_type)
                                                    <span class="inline-flex items-center rounded-full border border-white/10 bg-black/40 px-3 py-1 text-xs text-gray-200">
                                                        {{ $type->bed_type }}
                                                    </span>
                                                @endif

                                                @if($type->capacity)
                                                    <span class="inline-flex items-center rounded-full border border-white/10 bg-black/40 px-3 py-1 text-xs text-gray-200">
                                                        Capacity: {{ $type->capacity }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="flex items-center justify-between mb-5">
                                                <p class="text-gold text-xl font-bold">₱{{ number_format($type->price, 2) }}</p>
                                                <p class="text-xs text-gray-400">per night</p>
                                            </div>

                                            <a href="{{ url('/checkout') . '?' . http_build_query([
                                                'step' => 2,
                                                'room_type' => $type->id,
                                                'checkin' => request('checkin'),
                                                'checkout' => request('checkout'),
                                                'adults' => request('adults', 2),
                                                'children' => request('children', 0),
                                                'rooms' => request('rooms', 1),
                                            ]) }}"
                                            class="inline-flex w-full items-center justify-center rounded-xl bg-gold px-5 py-3 text-sm font-bold text-black hover:bg-[#e1b454] transition">
                                                Book This Room Type
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-3xl border border-red-500/20 bg-red-500/5 p-8 text-center">
                                <h3 class="text-2xl text-white mb-3">No available rooms found</h3>
                                <p class="text-gray-400">
                                    Try different dates or choose a different room type.
                                </p>
                            </div>
                        @endif
                    </section>
                @endif
            </div>

            <aside class="panel rounded-[28px] p-5 md:p-6 space-y-4 xl:sticky xl:top-24 xl:self-start" x-show="roomType" x-cloak>
                <div>
                    <p class="booking-kicker">Live Folio</p>
                    <h2 class="booking-summary-title mt-2">Reservation Summary</h2>
                </div>

                <div class="card rounded-2xl p-4" x-show="roomType" x-cloak>
                    <p class="text-sm text-[#a6abc2] mb-3">Selected Room Type</p>
                    <div class="grid grid-cols-[80px,1fr] gap-3 items-start">
                        <img :src="roomTypeImage()" class="w-20 h-16 rounded-xl object-cover">
                        <div>
                            <p class="text-white font-semibold" x-text="roomType.name"></p>
                            <p class="text-xs text-[#8f93a8]" x-text="roomTypeMeta()"></p>
                            <p class="text-sm text-gold font-bold mt-1" x-text="money(roomType.price) + '/night'"></p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <script>
        function availabilityPage() {
            return {
                roomType: @json($roomType),
                state: {
                    stay: {
                        checkin: '',
                        checkout: '',
                        adults: 2,
                        children: 0,
                        rooms: 1,
                    }
                },
                errors: {},
                availability: {
                    status: 'idle',
                    message: '',
                    available_rooms: 0,
                },

                init() {
                    const params = new URLSearchParams(window.location.search);

                    if (params.get('checkin')) this.state.stay.checkin = params.get('checkin');
                    if (params.get('checkout')) this.state.stay.checkout = params.get('checkout');
                    if (params.get('adults')) this.state.stay.adults = Number(params.get('adults')) || 2;
                    if (params.get('children')) this.state.stay.children = Number(params.get('children')) || 0;
                    if (params.get('rooms')) this.state.stay.rooms = Number(params.get('rooms')) || 1;

                    this.$watch('state.stay.checkin', () => this.checkAvailability());
                    this.$watch('state.stay.checkout', () => this.checkAvailability());
                    this.$watch('state.stay.rooms', () => this.checkAvailability());

                    this.$nextTick(() => {
                        this.initCalendar();
                        this.checkAvailability();
                    });
                },

                money(value) {
                    return '₱' + Number(value || 0).toLocaleString('en-PH', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },

                roomTypeMeta() {
                    if (!this.roomType) return 'No room type selected';
                    let parts = [];
                    if (this.roomType.bed_type) parts.push(this.roomType.bed_type);
                    if (this.roomType.capacity) parts.push(`Capacity: ${this.roomType.capacity}`);
                    return parts.join(' • ');
                },

                roomTypeImage() {
                    if (this.roomType && this.roomType.images && this.roomType.images.length > 0) {
                        let image = this.roomType.images[0].image_path;
                        if (image.startsWith('http://') || image.startsWith('https://')) return image;
                        if (image.startsWith('/storage/')) return image;
                        if (image.startsWith('storage/')) return '/' + image;
                        return '/storage/' + image;
                    }
                    return 'https://via.placeholder.com/1200x800?text=Room+Type';
                },

                initCalendar() {
                    if (!window.flatpickr) return;

                    flatpickr(this.$refs.checkinInput, {
                        minDate: 'today',
                        dateFormat: 'd/m/Y',
                        defaultDate: this.state.stay.checkin || null,
                        onChange: (selectedDates) => {
                            this.state.stay.checkin = selectedDates[0]
                                ? flatpickr.formatDate(selectedDates[0], 'Y-m-d')
                                : '';
                            this.errors.checkin = '';

                            if (this.state.stay.checkout && this.state.stay.checkout <= this.state.stay.checkin) {
                                this.state.stay.checkout = '';
                                this.$refs.checkoutInput.value = '';
                            }
                        },
                    });

                    flatpickr(this.$refs.checkoutInput, {
                        minDate: 'today',
                        dateFormat: 'd/m/Y',
                        defaultDate: this.state.stay.checkout || null,
                        onChange: (selectedDates) => {
                            this.state.stay.checkout = selectedDates[0]
                                ? flatpickr.formatDate(selectedDates[0], 'Y-m-d')
                                : '';
                            this.errors.checkout = '';
                        },
                    });
                },

                async checkAvailability() {
                    if (!this.roomType || !this.roomType.id) {
                        this.availability.status = 'unavailable';
                        this.availability.message = 'No room type selected.';
                        return;
                    }

                    if (!this.state.stay.checkin || !this.state.stay.checkout) {
                        this.availability.status = 'idle';
                        this.availability.message = '';
                        return;
                    }

                    if (this.state.stay.checkout <= this.state.stay.checkin) {
                        this.availability.status = 'unavailable';
                        this.availability.message = 'Check-out date must be after check-in date.';
                        return;
                    }

                    this.availability.status = 'checking';
                    this.availability.message = '';

                    try {
                        const params = new URLSearchParams({
                            room_type: this.roomType.id,
                            checkin: this.state.stay.checkin,
                            checkout: this.state.stay.checkout,
                            rooms: this.state.stay.rooms
                        });

                        const response = await fetch(`{{ url('/availability/check') }}?${params.toString()}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            this.availability.status = 'unavailable';
                            this.availability.message = data.message || 'Unable to check availability.';
                            return;
                        }

                        this.availability.status = data.available ? 'available' : 'unavailable';
                        this.availability.message = data.message || 'Availability updated.';
                        this.availability.available_rooms = data.available_rooms ?? 0;
                    } catch (error) {
                        this.availability.status = 'unavailable';
                        this.availability.message = 'Something went wrong while checking availability.';
                    }
                },

                continueFlow() {
                    this.errors = {};

                    if (!this.state.stay.checkin) this.errors.checkin = 'Required';
                    if (!this.state.stay.checkout) this.errors.checkout = 'Required';
                    if (Object.keys(this.errors).length) return;
                    if (this.availability.status !== 'available') return;

                    const params = new URLSearchParams({
                        step: 2,
                        room_type: this.roomType.id,
                        checkin: this.state.stay.checkin,
                        checkout: this.state.stay.checkout,
                        adults: this.state.stay.adults,
                        children: this.state.stay.children,
                        rooms: this.state.stay.rooms,
                    });

                    window.location.href = `{{ url('/checkout') }}?${params.toString()}`;
                }
            };
        }
    </script>
</body>
</html>