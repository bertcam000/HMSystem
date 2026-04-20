<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>La Nuevo Hogar Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="images/cropped_circle_image.png">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Font (Luxury Feel) -->
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

    

    <!-- FLATPICKR -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/rangePlugin.js"></script>

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="assets/js/offers.js"></script>
    <link rel="stylesheet" href="assets/css/site-ui.css">
    <script defer src="assets/js/site-ui.js"></script>
    <script defer src="assets/js/site-content.js"></script>

    <style>
  .text-gold-500 { color: #c5a880; } /* Matches your Experience section title */
  .bg-gold-500 { background-color: #c5a880; }
  .cursor-grab { cursor: grab; }
  .cursor-grab:active { cursor: grabbing; }
</style>
    <style>
        html {
            scroll-behavior: smooth;
        }
        body { font-family: "Manrope", sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-luxury { font-family: "Playfair Display", serif; }
        .booking-guest-trigger {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            border-radius: 0.95rem;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(10, 10, 12, 0.88);
            padding: 0.9rem 1rem;
            color: #fff;
            transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.2s ease;
        }
        .booking-guest-trigger:hover,
        .booking-guest-trigger.is-open {
            border-color: rgba(209, 165, 69, 0.48);
            box-shadow: 0 0 0 3px rgba(209, 165, 69, 0.08);
        }
        .booking-guest-panel {
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(10, 10, 12, 0.98);
            padding: 0.7rem;
            box-shadow: 0 22px 50px rgba(0, 0, 0, 0.4);
        }
        .booking-guest-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.9rem 0.45rem;
        }
        .booking-stepper {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }
        .booking-stepper button {
            width: 2.15rem;
            height: 2.15rem;
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            color: #f3f4f6;
            transition: border-color 0.25s ease, color 0.25s ease, background-color 0.25s ease;
        }
        .booking-stepper button:hover {
            border-color: rgba(209, 165, 69, 0.5);
            color: #d1a545;
            background: rgba(255, 255, 255, 0.03);
        }
        .booking-guest-done {
            width: 100%;
            border-radius: 0.75rem;
            background: #d1a545;
            padding: 0.8rem 1rem;
            font-size: 0.875rem;
            font-weight: 700;
            color: #111;
            transition: background-color 0.25s ease;
        }
        .booking-guest-done:hover {
            background: #dfb65b;
        }

        /* Simple clamp helper (Tailwind line-clamp plugin isn't enabled via CDN config here) */
        .line-clamp-2{
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .hero-orb {
            animation: heroFloat 10s ease-in-out infinite;
            will-change: transform;
        }

        .hero-orb-delay {
            animation-delay: -5s;
        }

        .hero-card-rise {
            animation: heroCardRise 1.1s ease-out both;
        }

        .hero-image-glow {
            box-shadow: 0 30px 120px rgba(0, 0, 0, 0.45);
        }

        @keyframes heroFloat {
            0%, 100% { transform: translate3d(0, 0, 0); }
            50% { transform: translate3d(0, -12px, 0); }
        }

        @keyframes heroCardRise {
            from {
                opacity: 0;
                transform: translateY(32px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scroll reveal (teaser-friendly, less busy than always-on animation) */
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 900ms ease, transform 900ms ease;
            will-change: opacity, transform;
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            .hero-orb,
            .hero-card-rise {
                animation: none;
            }

            .reveal {
                opacity: 1;
                transform: none;
                transition: none;
            }
        }

        /* Optional subtle parallax helper (lightweight) */
        .parallax {
            transform: translateY(0px);
            will-change: transform;
        }

        @media (prefers-reduced-motion: reduce) {
            .parallax {
                transform: none !important;
            }
        }

        @media (min-width: 1024px) and (max-height: 900px) {
            .hero-booking-shell {
                min-height: auto;
                padding-top: 8rem;
                padding-bottom: 2rem;
                align-items: flex-start;
            }

            .hero-booking-card {
                position: relative !important;
                left: auto !important;
                right: auto !important;
                bottom: auto !important;
                width: min(100%, 78rem) !important;
                max-width: 100% !important;
                margin-top: 2rem !important;
                transform: none !important;
            }

            .hero-booking-section {
                min-height: auto;
                height: auto;
                padding-bottom: 4rem;
            }
        }

        /* Flatpickr dark luxury theme */
        .flatpickr-calendar {
            background: #060608;
            border: 1px solid #2d2d32;
            color: #e5e7eb;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.75);
            font-family: "Playfair Display", serif;
        }

        .flatpickr-months .flatpickr-month,
        .flatpickr-weekdays {
            background: #000;
            color: #f9fafb;
        }

        .flatpickr-weekday {
            color: #9ca3af;
        }

        .flatpickr-current-month {
            font-size: 0.9rem;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year {
            color: #f9fafb;
            background: transparent;
        }

        .flatpickr-current-month .numInputWrapper {
            background: transparent;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months {
            padding-right: 0.75rem;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month .numInputWrapper input.cur-year {
            border: none;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months option {
            background: #060608;
            color: #f9fafb;
        }

        @media (max-width: 640px) {
            .flatpickr-calendar {
                width: 100% !important;
            }

            .flatpickr-days {
                width: 100% !important;
            }
        }

        .flatpickr-day {
            color: #e5e7eb;
            border-radius: 9999px;
        }

        .flatpickr-day.disabled,
        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            color: #4b5563;
        }

        .flatpickr-day:hover {
            background: #111827;
            color: #f9fafb;
        }

        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: #C6A75E;
            border-color: #C6A75E;
            color: #000;
        }

        .flatpickr-day.inRange {
            background: rgba(198, 167, 94, 0.18);
            border-color: transparent;
        }

        .flatpickr-day.today {
            border-color: #C6A75E;
        }

        .flatpickr-months .flatpickr-prev-month,
        .flatpickr-months .flatpickr-next-month {
            color: #f9fafb;
        }
    </style>
</head>

<body class="bg-darkbg text-gray-200 font-sans">
    <!-- ================= NAVBAR ================= -->
    <header x-data="{scrolled:false, mobileMenu:false}" @scroll.window="scrolled = (window.pageYOffset > 50)"
    :class="scrolled ? 'py-2 bg-black/90 shadow-lg backdrop-blur-md' : 'py-5 bg-transparent shadow-none backdrop-blur-0'"
    class="fixed w-full z-50 transition-all duration-500">

    <div class="site-header__bar max-w-7xl mx-auto grid grid-cols-3 items-center px-4 sm:px-6">

        <!-- LEFT: LOGO -->
        <div class="flex justify-start">
            <a href="/" class="site-logo-link" aria-label="Go to home page">
                <img src="images/cropped_circle_image.png" alt="La Nuevo Hogar logo" class="site-logo">
            </a>
        </div>

        <!-- CENTER: NAV MENU -->
        <nav class="hidden md:flex justify-center space-x-8 items-center">
            
            <!-- Stay Dropdown -->
            <div x-data="{open:false}" class="relative">
                <button @click="open=!open" class="hover:text-gold transition">
                    Stay
                </button>
                <div x-show="open" @click.away="open=false"
                    class="absolute mt-3 bg-softdark shadow-xl rounded-lg p-4 w-48 z-50">
                    <a href="#" class="block py-2 hover:text-gold">Rooms</a>
                    <a href="/availability" class="block py-2 hover:text-gold">Availability</a>
                </div>
            </div>

            <a href="/dining" class="hover:text-gold transition">Dining</a>
            <a href="/experience" class="hover:text-gold transition">Experience</a>
            <a href="/events" class="hover:text-gold transition">Events</a>
            <a href="/offers" class="hover:text-gold transition">Offers</a>

        </nav>

        <!-- RIGHT: BOOK NOW -->
        <div class="hidden md:flex justify-end">
            <a href="availability.html?reset=1"
                class="bg-primary px-6 py-2 rounded-md text-white hover:bg-gold transition">
                Book Now
            </a>
        </div>

        <!-- MOBILE BUTTON -->
        <div class="site-header__mobile flex justify-end md:hidden">
            <button @click="mobileMenu = !mobileMenu" class="site-mobile-toggle text-white focus:outline-none" aria-label="Toggle navigation menu">
                <svg class="w-6 h-6 transition-transform duration-300" :class="mobileMenu ? 'rotate-90' : ''"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"></path>
                    <path x-show="mobileMenu" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

    </div>

    <!-- MOBILE NAV -->
    <nav x-show="mobileMenu" x-transition x-cloak class="site-mobile-nav md:hidden bg-black/95 backdrop-blur-md border-t border-gold/20">
        <div class="site-mobile-nav__panel px-6 py-4 space-y-4">
            
            <div>
                <div class="py-2 text-white">Stay</div>
                <div class="ml-4 space-y-2">
                    <a href="#" @click="mobileMenu=false" class="block py-2 text-gray-300 hover:text-gold">Rooms</a>
                    <a href="/availability" @click="mobileMenu=false" class="block py-2 text-gray-300 hover:text-gold">Availability</a>
                </div>
            </div>

            <a href="/dining" @click="mobileMenu=false" class="block py-2 text-white hover:text-gold">Dining</a>
            <a href="/experience" @click="mobileMenu=false" class="block py-2 text-white hover:text-gold">Experience</a>
            <a href="/events" @click="mobileMenu=false" class="block py-2 text-white hover:text-gold">Events</a>
            <a href="/offers" @click="mobileMenu=false" class="block py-2 text-white hover:text-gold">Offers</a>

            <a href="availability.html?reset=1"
                @click="mobileMenu=false"
                class="block py-2 bg-primary text-white rounded-md px-4 hover:bg-gold transition">
                Book Now
            </a>

        </div>
    </nav>

</header>

    <!-- ================= HERO SECTION ================= -->
    <section class="hero-booking-section relative min-h-[100svh] overflow-x-clip overflow-y-visible pb-10 sm:pb-12 lg:h-screen lg:pb-24">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?q=80&w=2200&auto=format&fit=crop"
                class="absolute inset-0 w-full h-full object-cover hero-zoom parallax"
                data-parallax="0.06"
                alt="La Nuevo Hogar hotel exterior and guest arrival area" />
            <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(15,15,18,0.98)_0%,rgba(15,15,18,0.94)_34%,rgba(15,15,18,0.62)_55%,rgba(15,15,18,0.22)_78%,rgba(15,15,18,0.08)_100%)]"></div>
        </div>

       <div class="hero-booking-shell relative z-10 min-h-[100svh] max-w-7xl mx-auto flex items-start px-4 pt-1 pb-10 sm:px-6 sm:pt-24 sm:pb-14 lg:h-full lg:items-center lg:px-6 lg:pt-0 lg:pb-0">
    <!-- 🔼 binawasan ko pt (top padding) from pt-28 → pt-24 para umangat konti -->

    <div class="grid w-full items-center gap-6 lg:grid-cols-[0.95fr,1.05fr]">
        <!-- 🔼 gap-8 → gap-6 (less space between columns) -->
        
        <div class="reveal hero-card-rise w-full max-w-2xl pr-10 sm:pr-14 md:pr-0 lg:-ml-10 xl:-ml-20">
            <!-- 🔼 pr-14 → pr-10 (less right padding)
                 🔼 ml adjustments para di masyado malayo -->

            <!-- SMALL LABEL -->
            <p class="mb-4 text-[9px] uppercase tracking-[0.28em] text-gray-400 sm:mb-5 sm:text-[11px] sm:tracking-[0.32em] lg:mb-6">
                <!-- 🔼 text-xs → mas maliit (9px / 11px)
                     🔼 mb-5 → mb-4 (less spacing) -->
                La Nuevo Hogar Hotel
            </p>

            <!-- MAIN TITLE -->
            <h1 class="mb-3 max-w-[12ch] text-2xl font-bold leading-[0.95] text-gold [overflow-wrap:anywhere] sm:mb-4 sm:text-4xl sm:leading-[0.98] lg:text-5xl lg:leading-[1.02] xl:text-6xl">
                <!-- 🔼 text-3xl → text-2xl
                     🔼 sm:text-5xl → sm:text-4xl
                     🔼 lg:text-6xl → lg:text-5xl
                     🔼 xl:text-7xl → xl:text-6xl -->
                Secure Elevated Stays Through Refined Hotel Living
            </h1>

            <!-- SUB TITLE -->
            <p class="mb-4 max-w-[16ch] text-xl italic leading-tight text-gray-100/90 font-luxury sm:mb-5 sm:text-2xl md:text-3xl">
                <!-- 🔼 text-2xl → text-xl
                     🔼 sm:text-3xl → sm:text-2xl
                     🔼 md:text-4xl → md:text-3xl -->
                Dining, Rooms, Experience and Events
            </p>

            <!-- DESCRIPTION -->
            <p class="mb-6 max-w-xl text-sm leading-6 text-gray-300 sm:text-[15px] md:text-base md:leading-7 lg:mb-7">
                <!-- 🔼 leading-7 → leading-6 (mas compact)
                     🔼 md:text-lg → md:text-base -->
                Discover a destination shaped by elegant accommodations, curated dining,
                and guest experiences designed to make every stay feel complete.
            </p>

            <!-- BUTTONS -->
            <div class="flex w-full flex-col items-stretch gap-2 sm:flex-row sm:items-start sm:gap-3">
                <!-- 🔼 gap-3 → gap-2 (less spacing between buttons) -->

                <a href="availability.html?reset=1"
                    class="inline-flex w-full items-center justify-center rounded-md bg-gold px-5 py-2.5 text-sm font-semibold text-black transition hover:bg-gold/90 sm:w-auto sm:min-w-[180px]">
                    <!-- 🔼 px-6 py-3 → px-5 py-2.5 (smaller button) -->
                    Book Now
                </a>

                <a href="#"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-gold/35 bg-black/35 px-5 py-2.5 text-sm font-semibold text-white transition hover:border-gold/60 hover:bg-black/45 sm:w-auto">
                    
                    <!-- 🔼 gap-3 → gap-2
                         🔼 px-6 py-3 → px-5 py-2.5 -->

                    <span class="inline-flex h-4 w-4 items-center justify-center rounded-full border border-gold/30 bg-gold/10 text-gold">
                        <!-- 🔼 h-9 w-9 → h-8 w-8 -->
                        <i class="fa-solid fa-arrow-right text-[8px]"></i>
                    </span>

                    <span>Explore Hotel</span>
                </a>
            </div>
        </div>

        <div class="hidden lg:block"></div>
    </div>
</div>

        <!-- AVAILABILITY CARD OVERLAPPING HERO & NEXT SECTION -->
        <div x-data="booking()" data-mobile-booking-modal data-mobile-booking-label="Check Availability"
            class="hero-booking-card relative z-30 mx-auto mt-8 w-full max-w-full overflow-visible rounded-2xl border border-gold/35 bg-black/80 p-4 text-left shadow-[0_24px_78px_rgba(0,0,0,0.8)] backdrop-blur-md sm:mt-10 sm:p-5 md:rounded-3xl md:p-6 lg:absolute lg:left-1/2 lg:bottom-[-90px] lg:w-[94%] lg:max-w-5xl lg:-translate-x-1/2 lg:translate-y-16 lg:p-7 xl:translate-y-20">

            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3 mb-4">
                <div>
                    <p class="text-[11px] tracking-[0.3em] text-gray-400 uppercase">
                        Plan Your Stay
                    </p>
                    <h3 class="text-lg md:text-xl font-semibold text-white">
                        Check availability & exclusive rates
                    </h3>
                </div>
                <p class="text-[11px] md:text-xs text-gray-400 md:text-right">
                    Best rate guaranteed when you book direct. No booking fees.
                </p>
            </div>

            <form action="{{ route('availability.index') }}" method="GET" class="space-y-4">
                <input type="hidden" name="reset" value="1" />

                <div class="grid gap-4 md:grid-cols-5 items-end">
                    <div class="md:col-span-1">
                        <label for="checkin" class="block text-xs font-semibold tracking-wide text-gray-300 mb-1">
                            Check-In
                        </label>
                        <input id="checkin" name="checkin" type="text" placeholder="Select date"
                            class="w-full rounded-md border border-gray-700 bg-black/60 px-3 py-2.5 text-sm text-gray-100 placeholder-gray-500 focus:border-gold focus:outline-none focus:ring-1 focus:ring-gold" />
                    </div>

                    <div class="md:col-span-1">
                        <label for="checkout" class="block text-xs font-semibold tracking-wide text-gray-300 mb-1">
                            Check-Out
                        </label>
                        <input id="checkout" name="checkout" type="text" placeholder="Select date"
                            class="w-full rounded-md border border-gray-700 bg-black/60 px-3 py-2.5 text-sm text-gray-100 placeholder-gray-500 focus:border-gold focus:outline-none focus:ring-1 focus:ring-gold" />
                    </div>

                    <div class="md:col-span-1 relative" x-data="{open:false}" :class="open ? 'z-[90]' : 'z-10'">
                        <label class="block text-xs font-semibold tracking-wide text-gray-300 mb-1">
                            Guests & Rooms
                        </label>

                        <button type="button" @click="open = !open"
                            class="booking-guest-trigger text-left text-sm"
                            :class="open ? 'is-open' : ''"
                            :aria-expanded="open.toString()">
                            <span x-text="summary()"></span>
                            <i class="fa-solid text-[11px] text-gray-400 ml-2 transition-transform duration-200" :class="open ? 'fa-chevron-up text-gold' : 'fa-chevron-down'"></i>
                        </button>

                        <div x-show="open" x-transition.origin.top @click.away="open=false"
                            class="booking-guest-panel absolute left-0 right-0 md:right-auto z-[100] mt-2 w-full md:w-[20rem] text-sm space-y-0"
                            x-cloak>

                            <div class="booking-guest-row border-b border-white/6">
                                <div>
                                    <p class="text-gray-100 font-medium">Adults</p>
                                    <p class="text-xs text-gray-500">13 years and above</p>
                                </div>
                                <div class="booking-stepper">
                                    <button type="button" @click="decrement('adults')">-</button>
                                    <span class="w-4 text-center font-semibold tabular-nums" x-text="adults"></span>
                                    <button type="button" @click="increment('adults')">+</button>
                                </div>
                            </div>

                            <div class="booking-guest-row border-b border-white/6">
                                <div>
                                    <p class="text-gray-100 font-medium">Children</p>
                                    <p class="text-xs text-gray-500">0 - 12 years</p>
                                </div>
                                <div class="booking-stepper">
                                    <button type="button" @click="decrement('children')">-</button>
                                    <span class="w-4 text-center font-semibold tabular-nums" x-text="children"></span>
                                    <button type="button" @click="increment('children')">+</button>
                                </div>
                            </div>

                            <div class="booking-guest-row">
                                <div>
                                    <p class="text-gray-100 font-medium">Rooms</p>
                                    <p class="text-xs text-gray-500">Number of rooms needed</p>
                                </div>
                                <div class="booking-stepper">
                                    <button type="button" @click="decrement('rooms')">-</button>
                                    <span class="w-4 text-center font-semibold tabular-nums" x-text="rooms"></span>
                                    <button type="button" @click="increment('rooms')">+</button>
                                </div>
                            </div>

                            <button type="button" class="booking-guest-done mt-2" @click="open=false">Done</button>
                        </div>

                        <input type="hidden" name="adults" :value="adults" />
                        <input type="hidden" name="children" :value="children" />
                        <input type="hidden" name="rooms" :value="rooms" />
                    </div>

                    <div class="md:col-span-1">
                        <label for="room_type" class="block text-xs font-semibold tracking-wide text-gray-300 mb-1">
                            Room Type
                        </label>
                        <select id="room_type" name="room_type"
                            class="w-full rounded-md border border-gray-700 bg-black/60 px-3 py-2.5 text-sm text-gray-100 focus:border-gold focus:outline-none focus:ring-1 focus:ring-gold">
                            <option value="">Any room</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-1 flex flex-col items-stretch gap-3">
                        <button type="submit"
                            class="w-full rounded-md bg-gold px-4 py-2.5 text-sm font-semibold text-black hover:bg-gold/90 transition">
                            Check Availability
                        </button>
                    </div>
                </div>

                <div class="rounded-[24px] border border-gold/20 bg-[#111116] px-4 py-4 md:px-5">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-px flex-1 bg-gold/20"></div>
                        <p class="text-[11px] md:text-xs tracking-[0.25em] uppercase text-gold text-center">Book Direct Benefits</p>
                        <div class="h-px flex-1 bg-gold/20"></div>
                    </div>
                    <div class="grid gap-3 md:grid-cols-3 text-xs md:text-[11px] text-gray-300">
                        <div class="flex items-start gap-2.5">
                            <span class="mt-0.5 text-gold"><i class="fa-solid fa-circle-check"></i></span>
                            <p>Best rate guaranteed when you book directly with us.</p>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <span class="mt-0.5 text-gold"><i class="fa-solid fa-circle-check"></i></span>
                            <p>Flexible date changes on most reservations, subject to policy.</p>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <span class="mt-0.5 text-gold"><i class="fa-solid fa-circle-check"></i></span>
                            <p>Priority room allocation and early check-in preference when available.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- ================= SIGNATURE EXPERIENCES STRIP WITH CAROUSEL ================= -->
<section class="relative bg-darkbg pt-24 md:pt-28 pb-20">
<div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid lg:grid-cols-2 gap-10 items-center mt-24">

            <!-- LEFT CONTENT -->
            <div class="reveal">
                <p class="text-xs tracking-[0.3em] text-gray-400 uppercase mb-4">
                    La Nuevo Hogar Experience
                </p>

                <h2 class="text-3xl md:text-4xl lg:text-5xl text-white font-bold mb-5">
                    Stay in the <span class="text-gold">heart of the city</span> with resort-style comfort.
                </h2>

                <p class="text-gray-300 text-sm md:text-base mb-7 max-w-xl">
                    A premium stay designed around quiet comfort, elegant spaces, and service that feels personal.
                </p>

                <div class="grid sm:grid-cols-3 gap-4 text-sm">
                    <div class="bg-darkbg/80 border border-gold/20 rounded-xl p-4">
                        <p class="text-gold text-xs font-semibold uppercase tracking-wider mb-1">Effortless arrival</p>
                        <p class="text-gray-300 text-sm">Smooth check-in, concierge support, 24/7.</p>
                    </div>
                    <div class="bg-darkbg/80 border border-gold/20 rounded-xl p-4">
                        <p class="text-gold text-xs font-semibold uppercase tracking-wider mb-1">Curated comfort</p>
                        <p class="text-gray-300 text-sm">Thoughtful rooms, refined details.</p>
                    </div>
                    <div class="bg-darkbg/80 border border-gold/20 rounded-xl p-4">
                        <p class="text-gold text-xs font-semibold uppercase tracking-wider mb-1">Wellness & space</p>
                        <p class="text-gray-300 text-sm">Pool, gym, and calm corners.</p>
                    </div>
                </div>
            </div>


            <!-- RIGHT CAROUSEL -->
            <div x-data="{
                slide:0,
                slides:[
                    {img:'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=1800&auto=format&fit=crop', title:'Luxury Rooms', desc:'A calm retreat with premium touches and city views.', link:'rooms.html', linkText:'Explore Rooms'},
                    {img:'https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=1200', title:'Dining Experience', desc:'Signature flavors, elegant settings, and crafted moments.', link:'dining.html', linkText:'View Dining'},
                    {img:'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=1200', title:'Spa & Wellness', desc:'Reset, recharge, and unwind—your way.', link:'experience.html', linkText:'Discover More'},
                    {img:'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?q=80&w=1200', title:'Hotel Amenities', desc:'Pool, gym, and spaces designed for ease.', link:'experience.html', linkText:'See Amenities'}
                ]
            }"

            x-init="setInterval(()=> slide = (slide + 1) % slides.length , 4500)"

            class="reveal relative rounded-3xl overflow-hidden shadow-2xl border border-gold/20">


                <!-- SLIDES -->
                <div class="relative w-full h-[350px] md:h-[450px] overflow-hidden">

                    <div class="flex transition-transform duration-700 ease-in-out h-full"
                        :style="`transform: translateX(-${slide * 100}%)`">

                        <template x-for="(s,i) in slides" :key="i">

                            <div class="w-full flex-shrink-0 h-full relative">

                                <img :src="s.img" class="w-full h-full object-cover" alt="" />

                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>

                                <!-- OVERLAY TEXT -->
                                <div class="absolute bottom-5 left-5 right-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                                    <div>
                                        <p class="text-xs text-gold uppercase tracking-[0.25em] mb-1" x-text="s.title"></p>
                                        <p class="text-sm text-gray-100" x-text="s.desc"></p>
                                    </div>

                                    <a :href="s.link" class="inline-flex items-center gap-2 px-3 py-1.5 md:px-4 md:py-2 rounded-lg bg-gold text-black text-xs md:text-sm font-semibold hover:bg-gold/90 transition duration-300">
                                        <span x-text="s.linkText"></span>
                                        <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>

                                </div>

                            </div>

                        </template>

                    </div>

                </div>


                <!-- ARROWS -->
                <button @click="slide = (slide===0 ? slides.length-1 : slide-1)"
                    class="absolute left-3 top-1/2 -translate-y-1/2 text-white text-2xl z-10 bg-black/40 w-9 h-9 rounded-full flex items-center justify-center">

                    ‹

                </button>

                <button @click="slide = (slide===slides.length-1 ? 0 : slide+1)"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-white text-2xl z-10 bg-black/40 w-9 h-9 rounded-full flex items-center justify-center">

                    ›

                </button>


                <!-- DOTS NAVIGATION -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">

                    <template x-for="(s,i) in slides" :key="i">

                        <button
                            @click="slide=i"
                            class="h-2 rounded-full transition-all duration-300"
                            :class="slide===i ? 'bg-gold w-6' : 'bg-white/40 w-2'">
                        </button>

                    </template>

                </div>


            </div>

        </div>
    </div>
</section>

    <!-- ================= FEATURED ROOMS ================= -->
    <section id="stay" class="py-24 bg-softdark">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl text-gold mb-4">
                    Stay
                </h2>

                <h3 class="text-xl md:text-2xl text-white mb-4">
                    Rooms & Suites
                </h3>

                <p class="text-gray-400 max-w-3xl mx-auto">
                    Preview three favorites, then explore the full collection on our Stay page.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-10">
                @forelse($featuredRoomTypes as $roomType)
                    <div class="bg-darkbg rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 group reveal flex flex-col h-full">
                        <div class="relative h-[420px] overflow-hidden">
                            @php
                                $imagePath = $roomType->images->first()?->image_path;
                                $imageUrl = $imagePath
                                    ? (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')
                                        ? $imagePath
                                        : asset('storage/' . ltrim(str_replace('storage/', '', $imagePath), '/')))
                                    : 'https://via.placeholder.com/1200x800?text=Room+Type';
                            @endphp

                            <img src="{{ $imageUrl }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                                alt="{{ $roomType->name }}" />

                            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/5 transition"></div>

                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center rounded-full bg-black/70 border border-gold/30 px-3 py-1 text-xs font-semibold text-gold tracking-[0.2em] uppercase">
                                    {{ $roomType->rooms->count() }} {{ $roomType->rooms->count() === 1 ? 'Room' : 'Rooms' }} Available
                                </span>
                            </div>
                        </div>

                        <div class="p-6 md:p-10 flex flex-col flex-grow text-center">
                            <h3 class="text-2xl font-bold text-white mb-4">
                                {{ $roomType->name }}
                            </h3>

                            <p class="text-gray-300 text-sm leading-relaxed mb-4">
                                {{ \Illuminate\Support\Str::limit($roomType->description, 120) }}
                            </p>

                            <div class="flex flex-wrap justify-center gap-2 mb-6">
                                @if($roomType->bed_type)
                                    <span class="inline-flex items-center rounded-full border border-white/10 bg-black/40 px-3 py-1 text-xs text-gray-200">
                                        {{ $roomType->bed_type }}
                                    </span>
                                @endif

                                @if($roomType->capacity)
                                    <span class="inline-flex items-center rounded-full border border-white/10 bg-black/40 px-3 py-1 text-xs text-gray-200">
                                        Capacity: {{ $roomType->capacity }}
                                    </span>
                                @endif
                            </div>

                            <div class="mt-auto flex flex-col items-center gap-2 pt-6">
                                <p class="text-gold text-lg font-bold">
                                    ₱{{ number_format($roomType->price, 2) }} <span class="text-sm text-gray-400 font-medium">/ night</span>
                                </p>

                                <a href="{{ url('/offers?room_type=' . $roomType->id) }}"
                                    class="inline-flex items-center gap-2 text-gold text-sm font-semibold hover:text-white transition duration-300 group/link">
                                    LEARN MORE
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 group-hover/link:translate-x-1 transition" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>

                                <a href="{{ url('/availability?room_type=' . $roomType->id . '&reset=1') }}"
                                    class="w-full px-6 py-3 rounded-md bg-black text-white text-center text-sm font-bold hover:bg-gray-900 transition duration-300">
                                    BOOK NOW
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-3 text-center py-16 rounded-2xl border border-gold/15 bg-darkbg">
                        <h3 class="text-2xl text-white mb-3">No room types available</h3>
                        <p class="text-gray-400">Please check back later for updated room availability.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- ================= DINING / RESTAURANT SECTION ================= -->
    <section id="dine" class="py-24 bg-darkbg">

        <div class="max-w-7xl mx-auto px-6">

            <!-- SECTION HEADER -->
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl text-gold mb-4">
                    Dining Experience
                </h2>

                <h3 class="text-xl md:text-2xl text-white mb-4">
                    Flavors, ambience, and crafted evenings
                </h3>

                <p class="text-gray-400 max-w-3xl mx-auto">
                    A preview of what awaits—discover our full restaurants and lounge experience on the Dining page.
                </p>
            </div>

            <!-- HIGHLIGHTS (food categories teaser only) -->
            <div class="grid md:grid-cols-3 gap-10">
                <!-- All-day dining -->
                <div class="bg-softdark rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 group reveal flex flex-col h-full text-center">
                    <div class="relative h-[260px] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1543353071-873f17a7a088?q=80&w=1400"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                            alt="All-day dining plates with shared dishes">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/25 to-transparent"></div>
                    </div>
                    <div class="p-6 space-y-2">
                        <p class="text-xs text-gold uppercase tracking-[0.25em]">All-day dining</p>
                        <p class="text-white text-lg font-semibold">Comfort classics & signatures</p>
                        <p class="text-gray-200/90 text-sm">
                            From slow breakfasts to late suppers, enjoy a curated mix of familiar favorites and hotel specialties.
                        </p>
                         <div class="mt-auto flex flex-col items-center gap-2 pt-8">
                            <a href="#"
                                class="inline-flex items-center gap-2 text-gold text-sm font-semibold hover:text-white transition duration-300 group/link">
                                LEARN MORE
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 group-hover/link:translate-x-1 transition" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="/availability/?reset=1"
                            class="w-full px-6 py-3 rounded-md bg-black text-white text-center text-sm font-bold hover:bg-gray-900 transition duration-300">
                            RESERVE NOW
                        </a>
                        </div>
                    </div>
                </div>

                <!-- Breakfast & brunch -->
                <div class="bg-softdark rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 group reveal flex flex-col h-full text-center">
                    <div class="relative h-[260px] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1511690743698-d9d85f2fbf38?q=80&w=1400"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                            alt="Breakfast buffet with pastries and fruits">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/25 to-transparent"></div>
                    </div>
                    <div class="p-6 space-y-2">
                        <p class="text-xs text-gold uppercase tracking-[0.25em]">Breakfast & brunch</p>
                        <p class="text-white text-lg font-semibold">Buffet mornings</p>
                        <p class="text-gray-200/90 text-sm">
                            Fresh pastries, hot stations, and light options for relaxed mornings or pre-meeting starts.
                        </p>
                         <div class="mt-auto flex flex-col items-center gap-2 pt-8">
                            <a href="#"
                                class="inline-flex items-center gap-2 text-gold text-sm font-semibold hover:text-white transition duration-300 group/link">
                                LEARN MORE
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 group-hover/link:translate-x-1 transition" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="/availability/?reset=1"
                            class="w-full px-6 py-3 rounded-md bg-black text-white text-center text-sm font-bold hover:bg-gray-900 transition duration-300">
                            RESERVE NOW
                        </a>
                        </div>
                    </div>
                </div>

                <!-- Desserts & café -->
                <div class="bg-softdark rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 group reveal flex flex-col h-full text-center">
                    <div class="relative h-[260px] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=1400"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                            alt="Desserts and coffee on a table">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/25 to-transparent"></div>
                    </div>
                    <div class="p-6 space-y-2">
                        <p class="text-xs text-gold uppercase tracking-[0.25em]">Desserts & café</p>
                        <p class="text-white text-lg font-semibold">Sweet finishes & coffee</p>
                        <p class="text-gray-200/90 text-sm">
                            House-made desserts and carefully prepared coffee for mid-day breaks or after-dinner moments.
                        </p>
                        <div class="mt-auto flex flex-col items-center gap-2 pt-8">
                            <a href="#"
                                class="inline-flex items-center gap-2 text-gold text-sm font-semibold hover:text-white transition duration-300 group/link">
                                LEARN MORE
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 group-hover/link:translate-x-1 transition" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="/availability/?reset=1"
                            class="w-full px-6 py-3 rounded-md bg-black text-white text-center text-sm font-bold hover:bg-gray-900 transition duration-300">
                            RESERVE NOW
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- ================= EXPERIENCE SECTION ================= -->
<section id="experience" class="py-24 bg-softdark">
    <div class="max-w-7xl mx-auto px-6">

        <!-- SECTION HEADER -->
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl text-gold mb-4">
                Experience
            </h2>

            <h3 class="text-xl md:text-2xl text-white mb-4">
                A glimpse of what's inside
            </h3>

            <p class="text-gray-400 max-w-3xl mx-auto">
                Three highlights—then discover the full Experience page for more.
            </p>
        </div>

        <!-- EXPERIENCE CARDS -->
        <div class="grid md:grid-cols-3 gap-10">

            <!-- GYM -->
            <div class="bg-softdark rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 group reveal flex flex-col h-full">
                <div class="relative h-[360px] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=1200"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                        alt="Modern gym with equipment">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/15 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5">
                        <p class="text-white text-lg font-semibold">Gym</p>
                        <p class="text-gray-200/90 text-sm">Modern equipment, calm atmosphere.</p>
                    </div>
                </div>
            </div>

            <!-- POOL -->
            <div class="bg-softdark rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 group reveal flex flex-col h-full">
                <div class="relative h-[360px] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?q=80&w=1200"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                        alt="Luxury pool with lounge chairs">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/15 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5">
                        <p class="text-white text-lg font-semibold">Pool</p>
                        <p class="text-gray-200/90 text-sm">Unwind with a view, day or night.</p>
                    </div>
                </div>
            </div>

            <!-- SPA & WELLNESS -->
            <div class="bg-softdark rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 group reveal flex flex-col h-full">
                <div class="relative h-[360px] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=1200"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                        alt="Spa room with massage table">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/15 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5">
                        <p class="text-white text-lg font-semibold">Spa</p>
                        <p class="text-gray-200/90 text-sm">A quiet reset for body and mind.</p>
                    </div>
                </div>
            </div>

            <!-- EVENT HALL -->
            <!-- <div class="bg-softdark rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 group fade-up flex flex-col h-full">
                <div class="relative h-[420px] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=1200"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                        alt="Elegant event hall with tables and chairs">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/5 transition"></div>
                </div>
                <div class="p-6 md:p-10 flex flex-col flex-grow">
                    <h3 class="text-xl text-white mb-3">
                        Event Hall
                    </h3>
                    <p class="text-gray-300 text-sm leading-relaxed mb-6 flex-grow">
                        Host memorable events in our versatile event hall,
                        equipped for weddings, conferences, and celebrations.
                    </p>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-gold text-sm hover:underline">
                            Learn More →
                        </a>
                    </div>
                </div>
            </div> -->

        </div>

        <div class="mt-12 text-center reveal">
            <a href="/experience"
                class="inline-flex items-center justify-center rounded-md bg-gold px-7 py-3 text-sm font-semibold text-black hover:bg-gold/90 transition">
                Learn More About Our Experience
            </a>
        </div>

    </div>
</section>

<!-- ================= EVENTS TEASER (HOME) ================= -->
<section id="events" class="py-24 bg-darkbg">
    <div class="max-w-7xl mx-auto px-6">
        <!-- SECTION HEADER -->
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl text-gold mb-4">
                Events at La Nuevo Hogar
            </h2>
            <h3 class="text-xl md:text-2xl text-white mb-4">
                Moments, hosted beautifully
            </h3>
            <p class="text-gray-400 max-w-3xl mx-auto">
                From intimate celebrations to polished corporate gatherings, our dedicated events team
                shapes every detail around your occasion. Explore a glimpse below, then view the full
                Events page for full information.
            </p>
        </div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- WEDDINGS -->
    <article class="group bg-softdark rounded-xl border border-white/10 hover:border-gold/30 shadow-lg hover:shadow-2xl transition duration-500 flex flex-col overflow-hidden text-center">
        <div class="relative h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1522673607200-164d1b6ce486?q=80&w=1000"
                 class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110"
                 alt="Wedding">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
        </div>
        <div class="p-6 space-y-2">
            <h3 class="text-white text-lg font-semibold">Weddings</h3>
            <p class="text-gray-300 text-sm">
                Elegant halls and romantic setups for ceremonies and receptions.
            </p>
        </div>
    </article>

    <!-- BIRTHDAYS -->
    <article class="group bg-softdark rounded-xl border border-white/10 hover:border-gold/30 shadow-lg hover:shadow-2xl transition duration-500 flex flex-col overflow-hidden text-center">
        <div class="relative h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1530103862676-de8c9debad1d?q=80&w=1000"
                 class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110"
                 alt="Birthday">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
        </div>
        <div class="p-6 space-y-2">
            <h3 class="text-white text-lg font-semibold">Birthdays</h3>
            <p class="text-gray-300 text-sm">
                Celebrate milestones with customized and lively party setups.
            </p>
        </div>
    </article>

    <!-- CORPORATE -->
    <article class="group bg-softdark rounded-xl border border-white/10 hover:border-gold/30 shadow-lg hover:shadow-2xl transition duration-500 flex flex-col overflow-hidden text-center">
        <div class="relative h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=1000"
                 class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110"
                 alt="Corporate">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
        </div>
        <div class="p-6 space-y-2">
            <h3 class="text-white text-lg font-semibold">Corporate Meetings</h3>
            <p class="text-gray-300 text-sm">
                Professional spaces with full AV support and premium service.
            </p>
        </div>
    </article>

</div>
</div>

        <div class="mt-12 text-center reveal">
            <a href="/events"
                class="inline-flex items-center justify-center rounded-md bg-gold px-7 py-3 text-sm font-semibold text-black hover:bg-gold/90 transition">
                View All Events
            </a>
        </div>
    </div>
</section>

<!-- ===================== GUEST REVIEWS SECTION ===================== -->
<section id="reviews" class="bg-softdark py-20 text-white ">
  <div class="max-w-7xl mx-auto px-6">
    <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gold-500 reveal">Guest Reviews</h2>

    <div class="relative overflow-hidden rounded-2xl  bg-darkbg/40 p-6 md:p-10 reveal">
      <!-- Carousel Wrapper -->
      <div id="review-carousel" class="flex transition-transform duration-700 ease-in-out cursor-grab select-none">
        <!-- Slide 1 -->
        <div class="min-w-full flex flex-col items-center text-center px-6">
          <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Guest 1" class="w-24 h-24 rounded-full mb-4 border-2 border-gold-500">
          <h3 class="font-semibold text-lg">Anna Smith</h3>
          <div class="flex justify-center text-yellow-400 my-2">★★★★☆</div>
          <p class="text-gray-300 max-w-xl">
            "Absolutely loved our stay! The rooms were spotless and the staff were incredibly friendly."
          </p>
        </div>
        <!-- Slide 2 -->
        <div class="min-w-full flex flex-col items-center text-center px-6">
          <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Guest 2" class="w-24 h-24 rounded-full mb-4 border-2 border-gold-500">
          <h3 class="font-semibold text-lg">John Doe</h3>
          <div class="flex justify-center text-yellow-400 my-2">★★★★★</div>
          <p class="text-gray-300 max-w-xl">
            "A wonderful experience! Perfect location, excellent amenities, and very comfortable rooms."
          </p>
        </div>
        <!-- Slide 3 -->
        <div class="min-w-full flex flex-col items-center text-center px-6">
          <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Guest 3" class="w-24 h-24 rounded-full mb-4 border-2 border-gold-500">
          <h3 class="font-semibold text-lg">Maria Garcia</h3>
          <div class="flex justify-center text-yellow-400 my-2">★★★★☆</div>
          <p class="text-gray-300 max-w-xl">
            "We had a relaxing weekend. The spa and pool were fantastic. Highly recommend!"
          </p>
        </div>
        <!-- Slide 4 -->
        <div class="min-w-full flex flex-col items-center text-center px-6">
          <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Guest 4" class="w-24 h-24 rounded-full mb-4 border-2 border-gold-500">
          <h3 class="font-semibold text-lg">Michael Brown</h3>
          <div class="flex justify-center text-yellow-400 my-2">★★★★★</div>
          <p class="text-gray-300 max-w-xl">
            "Exceptional hospitality and beautiful surroundings. We can't wait to come back!"
          </p>
        </div>
        <!-- Slide 5 -->
        <div class="min-w-full flex flex-col items-center text-center px-6">
          <img src="https://randomuser.me/api/portraits/women/22.jpg" alt="Guest 5" class="w-24 h-24 rounded-full mb-4 border-2 border-gold-500">
          <h3 class="font-semibold text-lg">Sophia Lee</h3>
          <div class="flex justify-center text-yellow-400 my-2">★★★★☆</div>
          <p class="text-gray-300 max-w-xl">
            "From check-in to check-out, everything was flawless. Truly a 5-star experience."
          </p>
        </div>
      </div>

      <!-- Navigation Arrows -->
      <button id="prevBtn" aria-label="Previous review" class="absolute top-1/2 left-3 -translate-y-1/2 bg-black/50 border border-white/10 rounded-full w-10 h-10 shadow hover:bg-black/70 transition">
        ❮
      </button>
      <button id="nextBtn" aria-label="Next review" class="absolute top-1/2 right-3 -translate-y-1/2 bg-black/50 border border-white/10 rounded-full w-10 h-10 shadow hover:bg-black/70 transition">
        ❯
      </button>

      <!-- Dot Indicators -->
      <div id="review-dots" class="flex justify-center mt-6 space-x-2"></div>
    </div>

    <!-- Review submission (demo: stored in localStorage) -->
    <div class="mt-10 md:mt-12 reveal">
        <div class="max-w-3xl mx-auto rounded-2xl border border-white/10 bg-black/25 p-6 md:p-8">
            <div class="text-center mb-6">
                <p class="text-xs tracking-[0.3em] text-gray-400 uppercase mb-2">Share your experience</p>
                <h3 class="text-2xl font-bold text-white">Leave a review</h3>
                <p class="text-gray-400 text-sm mt-2">For demo purposes, reviews are saved on this device.</p>
            </div>

            <form id="review-form" class="grid gap-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold tracking-wide text-gray-300 mb-1">Name</label>
                        <input id="review-name" type="text" required maxlength="40" placeholder="Your name"
                            class="w-full rounded-md border border-white/10 bg-black/35 px-3 py-3 text-sm text-gray-100 placeholder-gray-500 focus:border-gold/60 focus:outline-none focus:ring-1 focus:ring-gold/30" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold tracking-wide text-gray-300 mb-1">Rating</label>
                        <select id="review-rating" required
                            class="w-full rounded-md border border-white/10 bg-black/35 px-3 py-3 text-sm text-gray-100 focus:border-gold/60 focus:outline-none focus:ring-1 focus:ring-gold/30">
                            <option value="" disabled selected>Select rating</option>
                            <option value="5">★★★★★ (5)</option>
                            <option value="4">★★★★☆ (4)</option>
                            <option value="3">★★★☆☆ (3)</option>
                            <option value="2">★★☆☆☆ (2)</option>
                            <option value="1">★☆☆☆☆ (1)</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold tracking-wide text-gray-300 mb-1">Comment</label>
                    <textarea id="review-comment" required maxlength="240" rows="4" placeholder="Early check-in, late check-out, connecting rooms..."
                        class="w-full p-4 border rounded bg-black/35 border-white/10 text-sm text-gray-100 placeholder-gray-500 focus:border-gold/60 focus:outline-none focus:ring-1 focus:ring-gold/30"></textarea>
                    <p class="text-[11px] text-gray-500 mt-2">Max 240 characters.</p>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p id="review-status" class="text-sm text-gray-300"></p>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-md bg-gold px-7 py-3 text-xs font-semibold tracking-[0.25em] uppercase text-black hover:bg-gold/90 transition">
                        Submit review
                    </button>
                </div>
            </form>
        </div>
    </div>
  </div>
</section>

<!-- ================= OFFERS PREVIEW ================= -->
<section id="offers-preview" class="bg-darkbg py-24">
    <div class="max-w-7xl mx-auto px-6" x-data="offersPreview()" x-init="init()">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12 reveal">
            <div>
                <p class="text-xs tracking-[0.3em] text-gray-400 uppercase mb-3">Offers</p>
                <h2 class="text-3xl md:text-4xl font-bold text-white">Top offers, curated for you</h2>
                <p class="text-gray-400 max-w-2xl mt-3">
                    Limited-time packages designed for romantic escapes, family weekends, business travel, and longer premium stays.
                </p>
            </div>
            <a href="/offers"
                class="inline-flex items-center justify-center rounded-md border border-white/15 bg-black/30 px-6 py-3 text-sm font-semibold text-white hover:border-gold/40 hover:bg-black/40 transition">
                View all offers
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <template x-for="offer in topOffers" :key="offer.id">
                <article class="bg-darkbg rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 border border-white/5 hover:border-gold/20 group reveal flex flex-col">
                    <div class="relative h-56 overflow-hidden">
                        <img :src="offer.image" :alt="offer.title" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/15 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <p class="text-xs text-gold uppercase tracking-[0.25em]" x-text="offer.tag"></p>
                            <p class="text-lg font-semibold text-white mt-1" x-text="offer.title"></p>
                            <p class="text-gray-200/90 text-sm mt-1 line-clamp-2" x-text="offer.description"></p>
                        </div>
                    </div>
                    <div class="p-5 mt-auto flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm text-gray-300" x-text="offer.discountPercent ? (offer.discountPercent + '% off') : 'Limited offer'"></p>
                            <p class="text-xs text-gray-500 mt-1" x-text="offer.validity"></p>
                        </div>
                        <a :href="offerCheckoutHref(offer, { adults: 2, children: 0 })"
                            class="inline-flex items-center justify-center rounded-md bg-gold px-4 py-2.5 text-xs font-semibold tracking-[0.2em] uppercase text-black hover:bg-gold/90 transition">
                            Book offer
                        </a>
                    </div>
                </article>
            </template>
        </div>

        <div class="grid gap-4 md:grid-cols-3 mt-10 reveal">
            <div class="rounded-2xl border border-gold/20 bg-black/25 p-5">
                <p class="text-xs tracking-[0.28em] uppercase text-gold mb-2">Book Direct</p>
                <p class="text-white text-lg font-semibold mb-2">More value built in</p>
                <p class="text-sm text-gray-400">Offers are paired with direct-booking perks like better flexibility, preferred allocation, and curated inclusions.</p>
            </div>
            <div class="rounded-2xl border border-gold/20 bg-black/25 p-5">
                <p class="text-xs tracking-[0.28em] uppercase text-gold mb-2">Stay Types</p>
                <p class="text-white text-lg font-semibold mb-2">Packages for different trips</p>
                <p class="text-sm text-gray-400">From quick city resets to longer premium stays, each offer is tuned to a different travel mood and pace.</p>
            </div>
            <div class="rounded-2xl border border-gold/20 bg-black/25 p-5">
                <p class="text-xs tracking-[0.28em] uppercase text-gold mb-2">Limited Windows</p>
                <p class="text-white text-lg font-semibold mb-2">Seasonal availability</p>
                <p class="text-sm text-gray-400">Offer access can change by date, room type, and stay pattern, so the best rates are worth locking in early.</p>
            </div>
        </div>
    </div>
</section>
    
<!-- ================= FINAL CALL TO ACTION ================= -->
<section class="bg-black py-20 border-line border-gold/40">
    <div class="max-w-7xl mx-auto px-6">
        <div class="reveal rounded-3xl border border-gold/20 bg-gradient-to-r from-black via-black/70 to-softdark p-10 md:p-14 text-center shadow-[0_25px_80px_rgba(0,0,0,0.65)]">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">Ready for your stay?</h2>
            <p class="text-gray-300 max-w-2xl mx-auto mb-8">
                Reserve your dates and enjoy premium comfort, exceptional service, and a true city escape.
            </p>
            <a href="/availability/?reset=1"
                class="inline-flex items-center justify-center rounded-md bg-gold px-8 py-3 text-sm font-semibold text-black hover:bg-gold/90 transition">
                Book Now
            </a>
        </div>
    </div>
</section>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-black text-gray-400 pt-20 pb-10">

        <!-- HOTEL LOGO -->
        <div class="text-center mb-10">

            <img src="images/logo-index.png" class="h-48 mx-auto mb-6" alt="La Nuevo Hogar hotel logo">

            <p class="text-sm text-gray-400 max-w-xl mx-auto mb-12">
                Experience refined hospitality at La Nuevo Hogar — where elegant
                accommodations, exceptional service, and luxurious comfort create
                unforgettable moments for every guest.
            </p>

            <!-- SOCIAL MEDIA -->
            <div class="flex justify-center gap-8 text-gray-400 mb-12 ">

                <!-- FACEBOOK -->
                <a href="#" class="hover:text-gold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 12a10 10 0 10-11.5 9.9v-7H7v-3h3.5V9.5c0-3.5 
            2-5.4 5.2-5.4 1.5 0 3 .3 3 .3v3.3h-1.7c-1.7 0-2.2 
            1-2.2 2.1V12H18l-.6 3h-2.6v7A10 10 0 0022 12" />
                    </svg>
                </a>

                <!-- INSTAGRAM -->
                <a href="#" class="hover:text-gold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 
            5 5h10c2.8 0 5-2.2 
            5-5V7c0-2.8-2.2-5-5-5H7zm5 
            5a5 5 0 110 10 5 5 0 010-10zm6.5-1.5a1.5 
            1.5 0 110 3 1.5 1.5 0 010-3z" />
                    </svg>
                </a>

                <!-- TWITTER / X -->
                <a href="#" class="hover:text-gold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 5.8c-.7.3-1.5.5-2.3.6.8-.5 
            1.4-1.2 1.7-2.1-.8.5-1.7.9-2.6 
            1.1A4 4 0 0016 4a4 4 0 00-4 
            4c0 .3 0 .6.1.9-3.3-.2-6.2-1.7-8.2-4.1-.4.7-.6 
            1.4-.6 2.2 0 1.5.8 2.8 
            2 3.6-.7 0-1.3-.2-1.9-.5v.1a4 4 0 003.2 
            3.9c-.3.1-.7.1-1 .1-.2 0-.5 0-.7-.1a4 4 0 003.7 
            2.8A8 8 0 012 19.5 11.3 
            11.3 0 008.1 21c7.3 
            0 11.3-6 11.3-11.3v-.5c.8-.6 
            1.4-1.2 2-2z" />
                    </svg>
                </a>

                <!-- YOUTUBE -->
                <a href="#" class="hover:text-gold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.5 6.2a3 3 0 00-2.1-2.1C19.6 3.5 12 
            3.5 12 3.5s-7.6 0-9.4.6A3 3 0 00.5 
            6.2 31.7 31.7 0 000 12a31.7 31.7 0 00.5 
            5.8 3 3 0 002.1 2.1c1.8.6 9.4.6 
            9.4.6s7.6 0 9.4-.6a3 3 0 002.1-2.1A31.7 
            31.7 0 0024 12a31.7 31.7 0 00-.5-5.8zM9.7 
            15.5V8.5L15.8 12l-6.1 3.5z" />
                    </svg>
                </a>

            </div>


            <!-- PARTNERS -->
            <div class="max-w-6xl mx-auto px-6 mb-16">

                <div class="flex flex-wrap justify-center items-center gap-10 opacity-90">

                    <div class="flex items-center justify-center">
                        <img src="images/BTAC.png" class="h-28 object-contain" alt="BTAC partner logo">
                    </div>

                    <div class="flex items-center justify-center">
                        <img src="images/ITS.png" class="w-28 object-contain" alt="ITS partner logo">
                    </div>

                    <div class="flex items-center justify-center">
                        <img src="images/bcplogo.png" class="w-20 object-contain" alt="BCP partner logo">
                    </div>

                    <div class="flex items-center justify-center">
                        <img src="images/bshmlogo2.png" class="w-24 object-contain" alt="BSHM partner logo">
                    </div>

                </div>

            </div>


            <!-- NEWSLETTER -->
            <div class="text-center mb-16">

                <h3 class="text-white text-xl mb-3">
                    Receive Exclusive Offers
                </h3>

                <p class="text-sm text-gray-400 mb-6">
                    Subscribe to receive special promotions, luxury packages,
                    and seasonal offers from La Nuevo Hogar.
                </p>

                <div class="mx-auto flex w-full max-w-xs flex-col justify-center gap-3 sm:max-w-sm sm:flex-row sm:gap-0">

                    <input type="email" placeholder="Enter your email address"
                        class="w-full px-4 py-2 bg-darkbg border border-gray-700 rounded-md text-sm focus:outline-none sm:max-w-xs sm:rounded-r-none md:w-72">

                    <button class="bg-gold text-black px-5 py-2 rounded-md hover:opacity-90 transition sm:rounded-l-none">
                        Join
                    </button>

                </div>

            </div>


            <!-- LINKS SECTION -->
            <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-14 text-center">

                <!-- QUICK LINKS -->
                <div>

                    <h4 class="text-white text-lg font-semibold mb-6">
                        Quick Links
                    </h4>

                    <ul class="space-y-3 text-sm">

                        <li><a href="/" class="hover:text-gold">Home</a></li>
                        <li><a href="#" class="hover:text-gold">Rooms & Suites</a></li>
                        <li><a href="/availability/?reset=1" class="hover:text-gold">Reservations</a></li>
                        <li><a href="#" class="hover:text-gold">Amenities</a></li>
                        <li><a href="#" class="hover:text-gold">Gallery</a></li>

                    </ul>

                </div>


                <!-- GUEST SERVICES -->
                <div>

                    <h4 class="text-white text-lg font-semibold mb-6">
                        Guest Services
                    </h4>

                    <ul class="space-y-3 text-sm">

                        <li><a href="#" class="hover:text-gold">Concierge</a></li>
                        <li><a href="#" class="hover:text-gold">Spa & Wellness</a></li>
                        <li><a href="#" class="hover:text-gold">Dining & Restaurants</a></li>
                        <li><a href="#" class="hover:text-gold">Event Venues</a></li>
                        <li><a href="#" class="hover:text-gold">Transportation</a></li>

                    </ul>

                </div>


                <!-- CONTACT -->
                <div>

                    <h4 class="text-white text-lg font-semibold mb-6">
                        Contact
                    </h4>

                    <ul class="space-y-3 text-sm">

                        <li>Manila, Philippines</li>
                        <li>+63 912 345 6789</li>
                        <li>reservations@elnuevohogar.com</li>
                        <li>Open 24 Hours</li>

                    </ul>

                </div>

            </div>


            <!-- BOTTOM BAR -->
            <div class="max-w-6xl mx-auto px-6 mt-16 pt-6 border-t border-gray-800 text-sm text-gray-500">

                <div class="flex flex-col md:flex-row justify-between items-center gap-4">

                    <p>
                        © 2026 La Nuevo Hogar Hotel. All rights reserved.
                    </p>

                    <div class="flex gap-6">

                        <a href="#" class="hover:text-gold">Privacy Policy</a>
                        <a href="#" class="hover:text-gold">Terms of Service</a>
                        <a href="#" class="hover:text-gold">Accessibility</a>
                        <a href="#" class="hover:text-gold">Sitemap</a>

                    </div>

                </div>

            </div>

    </footer>
    <script>
        function booking() {
            return {
                adults: 2,
                children: 0,
                rooms: 1,
                guestsOpen: false,

                increment(field) {
                    this[field]++;
                },

                decrement(field) {
                    if (this[field] > 0 &&
                        !(field === 'adults' && this.adults <= 1) &&
                        !(field === 'rooms' && this.rooms <= 1)) {
                        this[field]--;
                    }
                },

                summary() {
                    const roomLabel = this.rooms > 1 ? 'Rooms' : 'Room';
                    const adultLabel = this.adults > 1 ? 'Adults' : 'Adult';
                    const childLabel = this.children > 1 ? 'Children' : 'Child';

                    return `${this.rooms} ${roomLabel}, ${this.adults} ${adultLabel}` +
                        (this.children > 0 ? `, ${this.children} ${childLabel}` : '');
                }
            };
        }

        document.addEventListener("DOMContentLoaded", function () {
            const checkin = document.getElementById("checkin");
            const checkout = document.getElementById("checkout");

            if (checkin && checkout && window.rangePlugin) {
                const isDesktop = window.matchMedia("(min-width: 1024px)").matches;
                const monthsToShow = isDesktop ? 2 : 1;

                flatpickr(checkin, {
                    minDate: "today",
                    dateFormat: "Y-m-d",
                    altInput: true,
                    altFormat: "m/d/y",
                    showMonths: monthsToShow,
                    disableMobile: true,
                    monthSelectorType: "static",
                    plugins: [new rangePlugin({ input: "#checkout" })]
                });
            }
        });
    </script>
    <script>
        // Scroll reveal
        document.addEventListener("DOMContentLoaded", function () {
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
        });
    </script>
    <script>
        // Lightweight parallax for elements marked .parallax (mobile-safe)
        document.addEventListener("DOMContentLoaded", function () {
            const prefersReduced = window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches;
            if (prefersReduced) return;

            const items = Array.from(document.querySelectorAll(".parallax"));
            if (!items.length) return;

            let ticking = false;
            const onScroll = () => {
                if (ticking) return;
                ticking = true;
                requestAnimationFrame(() => {
                    const y = window.scrollY || 0;
                    items.forEach((el) => {
                        const speed = Number(el.getAttribute("data-parallax")) || 0.08;
                        el.style.transform = `translateY(${Math.round(y * speed)}px)`;
                    });
                    ticking = false;
                });
            };

            window.addEventListener("scroll", onScroll, { passive: true });
            onScroll();
        });
    </script>
    <!-- ===================== CAROUSEL SCRIPT ===================== -->
<script>
  const carousel = document.getElementById('review-carousel');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const dotsWrap = document.getElementById('review-dots');
  const form = document.getElementById('review-form');
  const statusEl = document.getElementById('review-status');

  const STORAGE_KEY = 'lnh_reviews';
  const mojibakeMap = {
    "\u00E2\u20AC\u2122": "'",
    "\u00E2\u20AC\u201D": "—",
    "\u00E2\u20AC\u201C": "–",
    "\u00E2\u20AC\u2011": "‑",
    "\u00E2\u2020\u2019": "→",
    "caf\u00C3\u00A9": "café",
    "d\u00C3\u00A9cor": "décor",
  };

  function normalizeText(value) {
    if (typeof value !== 'string') return value;
    return Object.entries(mojibakeMap).reduce((text, [from, to]) => text.split(from).join(to), value).normalize('NFC');
  }

  function normalizeReview(review) {
    return {
      ...review,
      name: normalizeText(review?.name || 'Guest'),
      comment: normalizeText(review?.comment || ''),
      avatar: review?.avatar || 'https://randomuser.me/api/portraits/lego/2.jpg',
      rating: Math.max(1, Math.min(5, Number(review?.rating) || 5)),
    };
  }

  const defaultReviews = [
    { name: "Anna Smith", rating: 4, comment: "Absolutely loved our stay! The rooms were spotless and the staff were incredibly friendly.", avatar: "https://randomuser.me/api/portraits/women/68.jpg" },
    { name: "John Doe", rating: 5, comment: "A wonderful experience! Perfect location, excellent amenities, and very comfortable rooms.", avatar: "https://randomuser.me/api/portraits/men/32.jpg" },
    { name: "Maria Garcia", rating: 4, comment: "We had a relaxing weekend. The spa and pool were fantastic. Highly recommend!", avatar: "https://randomuser.me/api/portraits/women/44.jpg" },
    { name: "Michael Brown", rating: 5, comment: "Exceptional hospitality and beautiful surroundings. We can't wait to come back!", avatar: "https://randomuser.me/api/portraits/men/75.jpg" },
    { name: "Sophia Lee", rating: 4, comment: "From check-in to check-out, everything was flawless. Truly a 5-star experience.", avatar: "https://randomuser.me/api/portraits/women/22.jpg" },
  ];

  function readStoredReviews() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      const parsed = raw ? JSON.parse(raw) : [];
      return Array.isArray(parsed) ? parsed.map(normalizeReview) : [];
    } catch {
      return [];
    }
  }

  function writeStoredReviews(reviews) {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(reviews.map(normalizeReview)));
    } catch {
      // ignore
    }
  }

  function starsText(rating) {
    const r = Math.max(1, Math.min(5, Number(rating) || 5));
    return "★★★★★☆☆☆☆☆".slice(5 - r, 10 - r);
  }

  function renderSlides(reviews) {
    carousel.innerHTML = '';
    dotsWrap.innerHTML = '';

    reviews.map(normalizeReview).forEach((rev, i) => {
      const slide = document.createElement('div');
      slide.className = 'min-w-full flex flex-col items-center text-center px-6';
      slide.innerHTML = `
        <img src="${rev.avatar}" alt="Guest"
          class="w-24 h-24 rounded-full mb-4 border-2 border-gold-500 object-cover">
        <h3 class="font-semibold text-lg">${rev.name || 'Guest'}</h3>
        <div class="flex justify-center text-yellow-400 my-2">${starsText(rev.rating)}</div>
        <p class="text-gray-300 max-w-xl">"${(rev.comment || '').replace(/</g,'&lt;').replace(/>/g,'&gt;')}"</p>
      `;
      carousel.appendChild(slide);

      const dot = document.createElement('span');
      dot.className = 'dot w-3 h-3 rounded-full bg-gray-500 cursor-pointer';
      dot.addEventListener('click', () => {
        index = i;
        updateCarousel();
        resetAutoSlide();
      });
      dotsWrap.appendChild(dot);
    });
  }

  let reviews = [...defaultReviews, ...readStoredReviews()].slice(0, 12);
  let index = 0;
  let isDragging = false;
  let startX = 0;
  let animationID;
  let autoSlideInterval;

  function dots() {
    return dotsWrap ? dotsWrap.querySelectorAll('.dot') : [];
  }

  function slides() {
    return carousel ? carousel.children : [];
  }

  function updateCarousel() {
    carousel.style.transform = `translateX(-${index * 100}%)`;
    dots().forEach((dot, i) => {
      dot.classList.toggle('bg-gold-500', i === index);
      dot.classList.toggle('bg-gray-500', i !== index);
    });
  }

  function autoSlide() {
    const s = slides();
    if (!s.length) return;
    index = (index + 1) % s.length;
    updateCarousel();
  }

  function resetAutoSlide() {
    if (autoSlideInterval) clearInterval(autoSlideInterval);
    autoSlideInterval = setInterval(autoSlide, 5000);
  }

  function dragStart(e) {
    isDragging = true;
    startX = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
    cancelAnimationFrame(animationID);
    carousel.classList.add('grabbing');
  }
  function dragMove(e) {
    if (!isDragging) return;
    const x = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
    const delta = x - startX;
    carousel.style.transform = `translateX(${ -index * 100 + delta / carousel.offsetWidth * 100 }%)`;
  }
  function dragEnd(e) {
    if (!isDragging) return;
    isDragging = false;
    const x = e.type.includes('mouse') ? e.pageX : (e.changedTouches ? e.changedTouches[0].clientX : 0);
    const delta = x - startX;
    const s = slides();
    if (delta > 50) index = (index === 0 ? s.length - 1 : index - 1);
    if (delta < -50) index = (index + 1) % s.length;
    updateCarousel();
    carousel.classList.remove('grabbing');
    resetAutoSlide();
  }

  // Init carousel from dynamic dataset
  renderSlides(reviews);
  updateCarousel();
  resetAutoSlide();

  prevBtn.addEventListener('click', () => {
    const s = slides();
    index = (index === 0 ? s.length - 1 : index - 1);
    updateCarousel();
    resetAutoSlide();
  });
  nextBtn.addEventListener('click', () => {
    const s = slides();
    index = (index + 1) % s.length;
    updateCarousel();
    resetAutoSlide();
  });

  carousel.addEventListener('mousedown', dragStart);
  carousel.addEventListener('touchstart', dragStart);
  carousel.addEventListener('mouseup', dragEnd);
  carousel.addEventListener('touchend', dragEnd);
  carousel.addEventListener('mouseleave', dragEnd);
  carousel.addEventListener('mousemove', dragMove);
  carousel.addEventListener('touchmove', dragMove);

  // Review submission
  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const name = normalizeText((document.getElementById('review-name')?.value || '').trim());
      const rating = Number(document.getElementById('review-rating')?.value || 0);
      const comment = normalizeText((document.getElementById('review-comment')?.value || '').trim());
      if (!name || !rating || !comment) return;

      const stored = readStoredReviews();
      const newReview = normalizeReview({
        name,
        rating: Math.max(1, Math.min(5, rating)),
        comment: comment.slice(0, 240),
        avatar: "https://randomuser.me/api/portraits/lego/2.jpg",
        createdAt: new Date().toISOString(),
      });
      stored.unshift(newReview);
      writeStoredReviews(stored.slice(0, 7));

      reviews = [...defaultReviews, ...stored].slice(0, 12);
      index = 0;
      renderSlides(reviews);
      updateCarousel();
      resetAutoSlide();

      form.reset();
      if (statusEl) statusEl.textContent = "Thank you—your review was added.";
      setTimeout(() => { if (statusEl) statusEl.textContent = ""; }, 4000);
    });
  }
</script>

<script>
function offersPreview() {
    return {
        topOffers: [],
        init() {
            try {
                this.topOffers = lnhOffersCatalog().slice(0, 3);
            } catch {
                this.topOffers = [];
            }
        }
    }
}
</script>
</body>

</html>
