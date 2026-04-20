<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Offers | La Nuevo Hogar Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ asset('images/cropped_circle_image.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/site-ui.css') }}">
    <script defer src="{{ asset('assets/js/site-ui.js') }}"></script>
    <script defer src="{{ asset('assets/js/site-content.js') }}"></script>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#8B6B3E",
                        gold: "#C6A75E",
                        darkbg: "#0f0f12",
                        softdark: "#1a1a1f",
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
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: "Manrope", sans-serif;
        }

        h1, h2, h3, h4, h5, h6, .font-luxury {
            font-family: "Playfair Display", serif;
        }

        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity 850ms ease, transform 850ms ease;
            will-change: opacity, transform;
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        [x-cloak] {
            display: none !important;
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            .reveal {
                opacity: 1;
                transform: none;
                transition: none;
            }
        }
    </style>
</head>

<body class="bg-darkbg text-gray-200 font-sans" x-data="offersPage()" x-init="init()">
    <!-- ================= NAVBAR ================= -->
    <header x-data="{scrolled:false, mobileMenu:false}" @scroll.window="scrolled = (window.pageYOffset > 50)"
        :class="scrolled ? 'py-2 bg-black/90 shadow-lg backdrop-blur-md' : 'py-5 bg-transparent shadow-none backdrop-blur-0'"
        class="fixed w-full z-50 transition-all duration-500">
        <div class="site-header__bar max-w-7xl mx-auto grid grid-cols-3 items-center px-6">
            <div class="flex justify-start">
                <a href="{{ url('/') }}" class="site-logo-link" aria-label="Go to home page">
                    <img src="{{ asset('images/cropped_circle_image.png') }}" alt="La Nuevo Hogar logo" class="site-logo">
                </a>
            </div>

            <nav class="hidden md:flex justify-center space-x-8 items-center">
                <div x-data="{open:false}" class="relative">
                    <button @click="open=!open" class="hover:text-gold transition">
                        Stay
                    </button>
                    <div x-show="open" @click.away="open=false"
                        class="absolute mt-3 bg-softdark shadow-xl rounded-lg p-4 w-48" x-cloak>
                        <a href="#" class="block py-2 hover:text-gold">Rooms</a>
                        <a href="{{ url('/availability') }}" class="block py-2 hover:text-gold">Availability</a>
                    </div>
                </div>

                <a href="{{ url('/dining') }}" class="hover:text-gold transition">Dining</a>
                <a href="{{ url('/experience') }}" class="hover:text-gold transition">Experience</a>
                <a href="{{ url('/events') }}" class="hover:text-gold transition">Events</a>
                <a href="{{ url('/offers') }}" class="text-gold border-b border-gold pb-1">Offers</a>
            </nav>

            <div class="hidden md:flex justify-end">
                <a href="{{ url('/availability?reset=1') }}"
                    class="bg-gold px-6 py-2 rounded-md text-black hover:bg-gold/90 transition">
                    Book Now
                </a>
            </div>

            <div class="site-header__mobile flex justify-end md:hidden">
                <button @click="mobileMenu = !mobileMenu" class="site-mobile-toggle text-white focus:outline-none"
                    aria-label="Toggle navigation menu">
                    <svg class="w-6 h-6 transition-transform duration-300" :class="mobileMenu ? 'rotate-90' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenu" x-cloak stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <nav x-show="mobileMenu" x-transition x-cloak
            class="site-mobile-nav md:hidden bg-black/95 backdrop-blur-md border-t border-gold/20">
            <div class="site-mobile-nav__panel px-6 py-4 space-y-4">
                <div>
                    <div class="py-2 text-white">Stay</div>
                    <div class="ml-4 space-y-2">
                        <a href="#" @click="mobileMenu=false"
                            class="block py-2 text-gray-300 hover:text-gold">Rooms</a>
                        <a href="{{ url('/availability') }}" @click="mobileMenu=false"
                            class="block py-2 text-gray-300 hover:text-gold">Availability</a>
                    </div>
                </div>

                <a href="{{ url('/dining') }}" @click="mobileMenu=false"
                    class="block py-2 text-white hover:text-gold transition">Dining</a>
                <a href="{{ url('/experience') }}" @click="mobileMenu=false"
                    class="block py-2 text-white hover:text-gold transition">Experience</a>
                <a href="{{ url('/events') }}" @click="mobileMenu=false"
                    class="block py-2 text-white hover:text-gold transition">Events</a>
                <a href="{{ url('/offers') }}" @click="mobileMenu=false"
                    class="block py-2 text-white hover:text-gold transition">Offers</a>
                <a href="{{ url('/availability?reset=1') }}" @click="mobileMenu=false"
                    class="block py-2 bg-gold text-black rounded-md px-4 py-2 hover:bg-gold/90 transition">Book Now</a>
            </div>
        </nav>
    </header>

    <!-- ================= HERO ================= -->
    <section class="relative h-[65vh] flex items-center justify-center text-center overflow-hidden pt-24">
        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2000"
            class="absolute inset-0 w-full h-full object-cover" alt="Hotel lobby" />
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-black/85"></div>
        <div class="relative z-10 max-w-3xl px-6">
            <p class="text-xs tracking-[0.3em] text-gray-300 uppercase mb-4">Offers</p>
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">
                Exclusive Packages & Featured Room Types
            </h1>
            <p class="text-gray-300 text-base md:text-lg">
                Explore beautifully prepared room types designed for business stays, family getaways, and relaxing escapes.
            </p>
        </div>
    </section>

    <!-- ================= ROOM TYPES ================= -->
    <section class="py-24 bg-softdark">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl text-gold mb-4">Available Room Types</h2>
                <p class="text-gray-400 max-w-3xl mx-auto">
                    Discover room categories currently available for booking and choose the stay experience that fits you best.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-3 mb-14 reveal">
                <div class="rounded-2xl border border-gold/15 bg-black/25 p-6 text-left">
                    <p class="text-xs tracking-[0.28em] uppercase text-gold mb-2">Comfort</p>
                    <h3 class="text-xl text-white mb-2">Refined room selections</h3>
                    <p class="text-sm leading-7 text-gray-400">Each room type is presented with key stay details, pricing, and curated visuals for a smoother booking experience.</p>
                </div>
                <div class="rounded-2xl border border-gold/15 bg-black/25 p-6 text-left">
                    <p class="text-xs tracking-[0.28em] uppercase text-gold mb-2">Flexibility</p>
                    <h3 class="text-xl text-white mb-2">Designed for every guest</h3>
                    <p class="text-sm leading-7 text-gray-400">Whether you are staying for business, a celebration, or a weekend reset, there is a room type ready for your pace.</p>
                </div>
                <div class="rounded-2xl border border-gold/15 bg-black/25 p-6 text-left">
                    <p class="text-xs tracking-[0.28em] uppercase text-gold mb-2">Availability</p>
                    <h3 class="text-xl text-white mb-2">Book while inventory is open</h3>
                    <p class="text-sm leading-7 text-gray-400">Only room types with currently available rooms are shown here, so what you see is actually bookable.</p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 space-y-10 md:space-y-14">
            <template x-if="roomTypes.length === 0">
                <div class="text-center py-20 rounded-3xl border border-gold/15 bg-darkbg/60 reveal">
                    <h3 class="text-2xl text-white mb-3">No room types available</h3>
                    <p class="text-gray-400">Please check back later for updated room availability.</p>
                </div>
            </template>

            <template x-for="(roomType, idx) in roomTypes" :key="roomType.id">
                <div class="grid md:grid-cols-2 gap-10 items-center bg-darkbg/70 border border-gold/15 rounded-3xl overflow-hidden reveal">
                    <template x-if="idx % 2 === 0">
                        <div class="p-8 md:p-12">
                            <p class="text-xs tracking-[0.3em] uppercase text-gold mb-3">Featured Room Type</p>

                            <h3 class="text-3xl md:text-4xl font-bold text-white mb-3" x-text="roomType.name"></h3>

                            <p class="text-gray-300 text-sm md:text-base leading-relaxed mb-5 max-w-xl"
                                x-text="roomType.description || 'Comfortable accommodations prepared for a refined hotel stay.'"></p>

                            <div class="flex flex-wrap items-center gap-3 mb-7 text-sm">
                                <span class="inline-flex items-center gap-2 rounded-full border border-gold/25 bg-black/40 px-4 py-2 text-gray-200">
                                    <span x-text="roomType.price ? formatPrice(roomType.price) : 'Price unavailable'"></span>
                                </span>

                                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-black/25 px-4 py-2 text-gray-300">
                                    <span x-text="roomType.capacity ? 'Capacity: ' + roomType.capacity : 'Capacity unavailable'"></span>
                                </span>

                                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-black/25 px-4 py-2 text-gray-300">
                                    <span x-text="roomType.bed_type ? roomType.bed_type : 'Bed type unavailable'"></span>
                                </span>

                                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-black/25 px-4 py-2 text-gray-300">
                                    <span x-text="availableRoomsText(roomType)"></span>
                                </span>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-black/25 p-5 mb-7">
                                <p class="text-xs tracking-[0.24em] uppercase text-gold mb-3">Room Type Details</p>

                                <ul class="space-y-2 text-sm text-gray-300">
                                    <li class="flex items-start gap-2">
                                        <span>•</span>
                                        <span x-text="roomType.bed_type ? 'Bed Type: ' + roomType.bed_type : 'Bed type not specified'"></span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span>•</span>
                                        <span x-text="roomType.capacity ? 'Guest Capacity: ' + roomType.capacity : 'Guest capacity unavailable'"></span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span>•</span>
                                        <span x-text="roomType.rooms ? 'Available Rooms: ' + roomType.rooms.length : 'Availability unavailable'"></span>
                                    </li>
                                </ul>

                                <p class="text-sm text-gray-400 mt-4">
                                    This room type currently has available inventory and is ready to be selected for your preferred dates.
                                </p>
                            </div>

                            <a :href="bookRoomTypeHref(roomType)"
                                class="inline-flex items-center justify-center bg-gold hover:bg-gold/90 text-black font-semibold text-xs tracking-[0.25em] uppercase px-7 py-3 rounded-lg transition">
                                Book This Room Type
                            </a>
                        </div>
                    </template>

                    <template x-if="idx % 2 === 1">
                        <div class="relative h-72 md:h-full min-h-[320px] md:order-1">
                            <img :src="roomTypeImage(roomType)" :alt="roomType.name"
                                class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-r from-black/30 via-black/10 to-transparent"></div>
                        </div>
                    </template>

                    <template x-if="idx % 2 === 0">
                        <div class="relative h-72 md:h-full min-h-[320px]">
                            <img :src="roomTypeImage(roomType)" :alt="roomType.name"
                                class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-l from-black/30 via-black/10 to-transparent"></div>
                        </div>
                    </template>

                    <template x-if="idx % 2 === 1">
                        <div class="p-8 md:p-12 md:order-2">
                            <p class="text-xs tracking-[0.3em] uppercase text-gold mb-3">Featured Room Type</p>

                            <h3 class="text-3xl md:text-4xl font-bold text-white mb-3" x-text="roomType.name"></h3>

                            <p class="text-gray-300 text-sm md:text-base leading-relaxed mb-5 max-w-xl"
                                x-text="roomType.description || 'Comfortable accommodations prepared for a refined hotel stay.'"></p>

                            <div class="flex flex-wrap items-center gap-3 mb-7 text-sm">
                                <span class="inline-flex items-center gap-2 rounded-full border border-gold/25 bg-black/40 px-4 py-2 text-gray-200">
                                    <span x-text="roomType.price ? formatPrice(roomType.price) : 'Price unavailable'"></span>
                                </span>

                                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-black/25 px-4 py-2 text-gray-300">
                                    <span x-text="roomType.capacity ? 'Capacity: ' + roomType.capacity : 'Capacity unavailable'"></span>
                                </span>

                                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-black/25 px-4 py-2 text-gray-300">
                                    <span x-text="roomType.bed_type ? roomType.bed_type : 'Bed type unavailable'"></span>
                                </span>

                                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-black/25 px-4 py-2 text-gray-300">
                                    <span x-text="availableRoomsText(roomType)"></span>
                                </span>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-black/25 p-5 mb-7">
                                <p class="text-xs tracking-[0.24em] uppercase text-gold mb-3">Room Type Details</p>

                                <ul class="space-y-2 text-sm text-gray-300">
                                    <li class="flex items-start gap-2">
                                        <span>•</span>
                                        <span x-text="roomType.bed_type ? 'Bed Type: ' + roomType.bed_type : 'Bed type not specified'"></span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span>•</span>
                                        <span x-text="roomType.capacity ? 'Guest Capacity: ' + roomType.capacity : 'Guest capacity unavailable'"></span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span>•</span>
                                        <span x-text="roomType.rooms ? 'Available Rooms: ' + roomType.rooms.length : 'Availability unavailable'"></span>
                                    </li>
                                </ul>

                                <p class="text-sm text-gray-400 mt-4">
                                    This room type currently has available inventory and is ready to be selected for your preferred dates.
                                </p>
                            </div>

                            <a :href="bookRoomTypeHref(roomType)"
                                class="inline-flex items-center justify-center bg-gold hover:bg-gold/90 text-black font-semibold text-xs tracking-[0.25em] uppercase px-7 py-3 rounded-lg transition">
                                Book This Room Type
                            </a>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </section>

    <section class="bg-darkbg py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="reveal rounded-3xl border border-gold/20 bg-gradient-to-r from-black via-black/70 to-softdark p-8 md:p-12">
                <div class="grid gap-8 lg:grid-cols-[1fr,0.9fr] lg:items-center">
                    <div>
                        <p class="text-xs tracking-[0.3em] uppercase text-gold mb-3">Stay Notes</p>
                        <h2 class="text-3xl md:text-4xl text-white mb-4">Luxury starts with the right room type</h2>
                        <p class="text-gray-300 max-w-2xl leading-8">
                            Room rates, inclusions, and current availability may vary depending on dates, occupancy, and booking demand.
                        </p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <p class="text-gold text-xs uppercase tracking-[0.26em] mb-2">Best Fit</p>
                            <p class="text-white text-lg font-semibold">Direct-booking guests</p>
                            <p class="text-sm text-gray-400 mt-2">Browse available room categories first, then continue to your preferred stay dates.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <p class="text-gold text-xs uppercase tracking-[0.26em] mb-2">Planning Tip</p>
                            <p class="text-white text-lg font-semibold">Premium types fill quickly</p>
                            <p class="text-sm text-gray-400 mt-2">Book early if you are eyeing larger or higher-end room categories.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-black text-gray-400 pt-20 pb-10">
        <div class="text-center mb-10">
            <img src="{{ asset('images/logo-index.png') }}" class="h-48 mx-auto mb-6" alt="La Nuevo Hogar hotel logo">

            <p class="text-sm text-gray-400 max-w-xl mx-auto mb-12">
                Experience refined hospitality at La Nuevo Hogar — where elegant
                accommodations, exceptional service, and luxurious comfort create
                unforgettable moments for every guest.
            </p>

            <div class="flex justify-center gap-8 text-gray-400 mb-12 ">
                <a href="#" class="hover:text-gold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 12a10 10 0 10-11.5 9.9v-7H7v-3h3.5V9.5c0-3.5 2-5.4 5.2-5.4 1.5 0 3 .3 3 .3v3.3h-1.7c-1.7 0-2.2 1-2.2 2.1V12H18l-.6 3h-2.6v7A10 10 0 0022 12" />
                    </svg>
                </a>

                <a href="#" class="hover:text-gold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm5 5a5 5 0 110 10 5 5 0 010-10zm6.5-1.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
                    </svg>
                </a>

                <a href="#" class="hover:text-gold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 5.8c-.7.3-1.5.5-2.3.6.8-.5 1.4-1.2 1.7-2.1-.8.5-1.7.9-2.6 1.1A4 4 0 0016 4a4 4 0 00-4 4c0 .3 0 .6.1.9-3.3-.2-6.2-1.7-8.2-4.1-.4.7-.6 1.4-.6 2.2 0 1.5.8 2.8 2 3.6-.7 0-1.3-.2-1.9-.5v.1a4 4 0 003.2 3.9c-.3.1-.7.1-1 .1-.2 0-.5 0-.7-.1a4 4 0 003.7 2.8A8 8 0 012 19.5 11.3 11.3 0 008.1 21c7.3 0 11.3-6 11.3-11.3v-.5c.8-.6 1.4-1.2 2-2z" />
                    </svg>
                </a>

                <a href="#" class="hover:text-gold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.5 6.2a3 3 0 00-2.1-2.1C19.6 3.5 12 3.5 12 3.5s-7.6 0-9.4.6A3 3 0 00.5 6.2 31.7 31.7 0 000 12a31.7 31.7 0 00.5 5.8 3 3 0 002.1 2.1c1.8.6 9.4.6 9.4.6s7.6 0 9.4-.6a3 3 0 002.1-2.1A31.7 31.7 0 0024 12a31.7 31.7 0 00-.5-5.8zM9.7 15.5V8.5L15.8 12l-6.1 3.5z" />
                    </svg>
                </a>
            </div>

            <div class="max-w-6xl mx-auto px-6 mb-16">
                <div class="flex flex-wrap justify-center items-center gap-10 opacity-90">
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('images/BTAC.png') }}" class="h-28 object-contain" alt="BTAC partner logo">
                    </div>
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('images/ITS.png') }}" class="w-28 object-contain" alt="ITS partner logo">
                    </div>
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('images/bcplogo.png') }}" class="w-20 object-contain" alt="BCP partner logo">
                    </div>
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('images/bshmlogo2.png') }}" class="w-24 object-contain" alt="BSHM partner logo">
                    </div>
                </div>
            </div>

            <div class="text-center mb-16">
                <h3 class="text-white text-xl mb-3">Receive Exclusive Offers</h3>

                <p class="text-sm text-gray-400 mb-6">
                    Subscribe to receive special promotions, luxury packages,
                    and seasonal offers from La Nuevo Hogar.
                </p>

                <div class="flex justify-center">
                    <input type="email" placeholder="Enter your email address"
                        class="w-full max-w-xs md:w-72 px-4 py-2 bg-darkbg border border-gray-700 rounded-l-md text-sm focus:outline-none">

                    <button class="bg-gold text-black px-5 py-2 rounded-r-md hover:opacity-90 transition">
                        Join
                    </button>
                </div>
            </div>

            <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-14 text-center">
                <div>
                    <h4 class="text-white text-lg font-semibold mb-6">Quick Links</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ url('/') }}" class="hover:text-gold">Home</a></li>
                        <li><a href="/offers" class="hover:text-gold">Rooms & Suites</a></li>
                        <li><a href="{{ url('/availability?reset=1') }}" class="hover:text-gold">Reservations</a></li>
                        <li><a href="#" class="hover:text-gold">Amenities</a></li>
                        <li><a href="#" class="hover:text-gold">Gallery</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white text-lg font-semibold mb-6">Guest Services</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-gold">Concierge</a></li>
                        <li><a href="#" class="hover:text-gold">Spa & Wellness</a></li>
                        <li><a href="#" class="hover:text-gold">Dining & Restaurants</a></li>
                        <li><a href="#" class="hover:text-gold">Event Venues</a></li>
                        <li><a href="#" class="hover:text-gold">Transportation</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white text-lg font-semibold mb-6">Contact</h4>
                    <ul class="space-y-3 text-sm">
                        <li>Manila, Philippines</li>
                        <li>+63 912 345 6789</li>
                        <li>reservations@elnuevohogar.com</li>
                        <li>Open 24 Hours</li>
                    </ul>
                </div>
            </div>

            <div class="max-w-6xl mx-auto px-6 mt-16 pt-6 border-t border-gray-800 text-sm text-gray-500">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p>© 2026 La Nuevo Hogar Hotel. All rights reserved.</p>

                    <div class="flex gap-6">
                        <a href="#" class="hover:text-gold">Privacy Policy</a>
                        <a href="#" class="hover:text-gold">Terms of Service</a>
                        <a href="#" class="hover:text-gold">Accessibility</a>
                        <a href="#" class="hover:text-gold">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function offersPage() {
            return {
                roomTypes: @json($roomTypes),

                bookRoomTypeHref(roomType) {
                    return `/availability?room_type=${roomType.id}`;
                },

                roomTypeImage(roomType) {
                    let image = null;

                    if (roomType.images && roomType.images.length > 0) {
                        image = roomType.images[0].image_path;
                    }

                    if (!image) {
                        return 'https://via.placeholder.com/1200x800?text=Room+Type';
                    }

                    if (image.startsWith('http://') || image.startsWith('https://')) {
                        return image;
                    }

                    if (image.startsWith('/storage/')) {
                        return image;
                    }

                    if (image.startsWith('storage/')) {
                        return '/' + image;
                    }

                    return '/storage/' + image;
                },

                availableRoomsText(roomType) {
                    if (!roomType.rooms) return 'Availability unavailable';

                    const count = roomType.rooms.length;
                    return count + (count === 1 ? ' room available' : ' rooms available');
                },

                formatPrice(price) {
                    return '₱' + Number(price).toLocaleString('en-PH', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },

                setupReveal() {
                    const targets = document.querySelectorAll(".reveal");
                    if (targets.length === 0) return;

                    if (!("IntersectionObserver" in window)) {
                        targets.forEach((el) => el.classList.add("is-visible"));
                        return;
                    }

                    const observer = new IntersectionObserver(
                        (entries, obs) => {
                            entries.forEach((entry) => {
                                if (entry.isIntersecting) {
                                    entry.target.classList.add("is-visible");
                                    obs.unobserve(entry.target);
                                }
                            });
                        },
                        { threshold: 0.15, rootMargin: "0px 0px -10% 0px" }
                    );

                    targets.forEach((el) => observer.observe(el));
                },

                init() {
                    console.log(this.roomTypes);
                    this.$nextTick(() => this.setupReveal());
                }
            }
        }
    </script>
</body>

</html>