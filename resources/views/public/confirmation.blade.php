<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Confirmation | La Nuevo Hogar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ asset('images/cropped_circle_image.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        [x-cloak] { display: none !important; }
        body { font-family: "Manrope", sans-serif; background: #08080b; }
        h1, h2, h3, h4, h5, h6, .font-luxury { font-family: "Playfair Display", serif; }

        .panel {
            background: #141418;
            border: 1px solid rgba(209, 165, 69, 0.18);
            box-shadow: 0 22px 60px rgba(0, 0, 0, 0.35);
        }

        .card {
            background: #17171c;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .receipt-actions,
        .receipt-nav-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .receipt-brand {
            display: none;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid rgba(17, 17, 17, 0.12);
            margin-bottom: 1.75rem;
        }

        .receipt-brand__mark {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
        }

        .receipt-brand__logo {
            width: 4rem;
            height: 4rem;
            object-fit: contain;
        }

        .receipt-brand__eyebrow {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.32em;
            text-transform: uppercase;
            color: #6b7280;
        }

        .receipt-brand__title {
            margin-top: 0.35rem;
            font-size: 1.9rem;
            line-height: 1;
            color: #111;
        }

        .receipt-brand__meta {
            text-align: right;
            font-size: 0.85rem;
            line-height: 1.5;
            color: #4b5563;
        }

        @media print {
            @page {
                size: A4;
                margin: 12mm;
            }

            html, body {
                width: auto;
                overflow: visible !important;
            }

            header,
            .no-print,
            .receipt-actions,
            .receipt-nav-actions {
                display: none !important;
            }

            body {
                background: #fff !important;
                color: #111 !important;
            }

            main {
                max-width: none !important;
                padding: 0 !important;
            }

            .panel, .card {
                background: #fff !important;
                box-shadow: none !important;
                border-color: #ddd !important;
                break-inside: avoid;
                page-break-inside: avoid;
            }

            .receipt-brand {
                display: flex !important;
            }

            * {
                color: #111 !important;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>
</head>

<body class="text-gray-200" x-data="confirmationPage()" x-init="init()">
    <header class="border-b border-white/5 bg-black/80 backdrop-blur sticky top-0 z-40 no-print">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="site-logo-link" aria-label="Go to home page">
                <img src="{{ asset('images/cropped_circle_image.png') }}" alt="La Nuevo Hogar logo" class="site-logo">
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold">
                <a href="{{ url('/rooms') }}" class="hover:text-gold transition">Rooms</a>
                <a href="{{ url('/offers') }}" class="hover:text-gold transition">Offers</a>
                <a href="{{ url('/availability') }}" class="hover:text-gold transition">Book Again</a>
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-10 md:py-14 space-y-8">
        <section class="receipt-brand" aria-hidden="true">
            <div class="receipt-brand__mark">
                <img src="{{ asset('images/cropped_circle_image.png') }}" alt="La Nuevo Hogar logo" class="receipt-brand__logo">
                <div>
                    <p class="receipt-brand__eyebrow">La Nuevo Hogar</p>
                    <p class="receipt-brand__title font-luxury">Reservation Receipt</p>
                </div>
            </div>
            <div class="receipt-brand__meta">
                <p>La Nuevo Hogar Hotel</p>
                <p>Official Booking Confirmation</p>
            </div>
        </section>

        <section class="space-y-3">
            <h1 class="text-5xl text-white">Confirmation</h1>
        </section>

        <section class="flex flex-wrap items-center gap-3 md:gap-4 text-[11px] md:text-xs font-semibold">
            <template x-for="item in steps" :key="item.number">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="flex items-center gap-3 rounded-xl px-3 py-2 min-w-0"
                        :class="item.number === 4 ? 'bg-[#11261a] text-[#7fe3a1]' : 'text-[#7fe3a1]'">
                        <span class="w-6 h-6 rounded-full border inline-flex shrink-0 items-center justify-center text-[10px] font-bold leading-none bg-[#18c560] text-black border-[#18c560] shadow-[0_0_0_3px_rgba(24,197,96,0.16)]">
                            <template x-if="item.number === 4"><span>4</span></template>
                            <template x-if="item.number !== 4"><i class="fa-solid fa-check"></i></template>
                        </span>
                        <span x-text="item.label"></span>
                    </div>
                    <div class="hidden md:block w-12 h-px bg-white/10" x-show="item.number < steps.length"></div>
                </div>
            </template>
        </section>

        <section class="panel rounded-[32px] p-8 md:p-12 text-center border-[#1d8d47] relative overflow-hidden">
            <div class="relative z-10">
                <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-br from-[#18c560] to-[#14361f] flex items-center justify-center text-3xl mb-6 shadow-2xl">
                    <i class="fa-solid fa-circle-check text-white"></i>
                </div>

                <h2 class="text-5xl md:text-6xl text-white font-luxury mb-4">Reservation Submitted</h2>
                <p class="text-[#9fa4b8] mt-4 text-lg max-w-2xl mx-auto">
                    Your booking has been successfully submitted. An available room has been assigned automatically and your reservation is now pending front desk confirmation.
                </p>

                <div class="inline-flex mt-8 rounded-3xl bg-gradient-to-r from-[#202026] to-[#1a1a1f] px-10 py-6 flex-col items-center shadow-xl border border-gold/20">
                    <p class="text-xs uppercase tracking-[0.5em] text-[#8390bf] font-semibold">Booking Reference</p>
                    <p class="text-5xl font-extrabold text-gold mt-3 tracking-wider" x-text="booking.booking_code"></p>
                </div>

                <div class="mt-8 flex justify-center items-center gap-4 text-sm text-[#9fa4b8]">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-gold"></i>
                        <span>Reservation recorded</span>
                    </div>
                    <div class="w-1 h-1 rounded-full bg-[#9fa4b8]"></div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-hotel text-gold"></i>
                        <span x-text="'Status: ' + booking.status"></span>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel rounded-[32px] p-8 md:p-10 space-y-8 bg-gradient-to-br from-[#141418] to-[#0f0f12]">
            <div class="text-center">
                <h2 class="text-4xl text-white font-luxury mb-2">Reservation Details</h2>
                <p class="text-[#9fa4b8] text-lg">Complete information about your booking</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="card rounded-3xl p-6 bg-gradient-to-br from-[#1a1a1f] to-[#202026] border border-gold/10 shadow-xl animate-fade-in-up">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center">
                            <i class="fa-regular fa-calendar text-gold text-lg"></i>
                        </div>
                        <p class="text-lg text-white font-semibold">Stay Information</p>
                    </div>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-white/5">
                            <span class="text-[#8f93a8]">Check-in</span>
                            <span class="font-bold text-white text-lg">
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('F d, Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/5">
                            <span class="text-[#8f93a8]">Check-out</span>
                            <span class="font-bold text-white text-lg">
                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('F d, Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-[#8f93a8]">Duration</span>
                            <span class="font-bold text-gold text-lg" x-text="nights + ' nights'"></span>
                        </div>
                    </div>
                </div>

                <div class="card rounded-3xl p-6 bg-gradient-to-br from-[#1a1a1f] to-[#202026] border border-gold/10 shadow-xl animate-fade-in-up delay-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center">
                            <i class="fa-regular fa-user text-gold text-lg"></i>
                        </div>
                        <p class="text-lg text-white font-semibold">Guest Information</p>
                    </div>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-white/5">
                            <span class="text-[#8f93a8]">Name</span>
                            <span class="font-bold text-white text-right" x-text="guestName()"></span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/5">
                            <span class="text-[#8f93a8]">Email</span>
                            <span class="font-bold text-white text-right break-all" x-text="booking.guest.email"></span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-[#8f93a8]">Phone</span>
                            <span class="font-bold text-gold text-right" x-text="booking.guest.phone"></span>
                        </div>
                    </div>
                </div>

                <div class="card rounded-3xl p-6 bg-gradient-to-br from-[#1a1a1f] to-[#202026] border border-gold/10 shadow-xl animate-fade-in-up delay-200">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center">
                            <i class="fa-solid fa-bed text-gold text-lg"></i>
                        </div>
                        <p class="text-lg text-white font-semibold">Assigned Room</p>
                    </div>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-white/5">
                            <span class="text-[#8f93a8]">Room Type</span>
                            <span class="font-bold text-white text-lg" x-text="roomTypeName()"></span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/5">
                            <span class="text-[#8f93a8]">Assigned Room(s)</span>
                            <span class="font-bold text-white text-right" x-text="assignedRoomsText()"></span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-[#8f93a8]">Guests</span>
                            <span class="font-bold text-gold text-right" x-text="guestCountText()"></span>
                        </div>
                    </div>
                </div>

                <div class="card rounded-3xl p-6 bg-gradient-to-br from-[#1a1a1f] to-[#202026] border border-gold/10 shadow-xl animate-fade-in-up delay-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center">
                            <i class="fa-regular fa-credit-card text-gold text-lg"></i>
                        </div>
                        <p class="text-lg text-white font-semibold">Payment Summary</p>
                    </div>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-white/5">
                            <span class="text-[#8f93a8]">Subtotal</span>
                            <span class="font-bold text-white text-lg" x-text="money(booking.subtotal)"></span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/5">
                            <span class="text-[#8f93a8]">Tax</span>
                            <span class="font-bold text-white text-lg" x-text="money(booking.tax)"></span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/5">
                            <span class="text-[#8f93a8]">Service Charge</span>
                            <span class="font-bold text-white text-lg" x-text="money(booking.service_charge)"></span>
                        </div>
                        <div class="pt-4 border-t border-gold/20 flex justify-between items-center">
                            <span class="text-2xl text-white font-luxury">Total</span>
                            <span class="text-3xl font-extrabold text-gold" x-text="money(booking.total_price)"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="receipt-actions pt-4 border-t border-white/10 no-print">
                <button type="button" onclick="window.print()" class="rounded-xl border border-white/15 bg-[#202026] px-5 py-3 text-sm font-bold text-white">
                    <i class="fa-solid fa-print mr-2"></i>Print Folio
                </button>

                <a href="{{ url('/availability?reset=1') }}" class="rounded-xl bg-gold px-5 py-3 text-sm font-bold text-black">
                    <i class="fa-solid fa-redo mr-2"></i>New Booking
                </a>
            </div>

            <div class="rounded-2xl border border-gold/20 bg-[#1a1711] px-4 py-5">
                <p class="text-[11px] uppercase tracking-[0.45em] text-gold mb-2">Booking Status</p>
                <p class="text-sm text-[#9fa4b8]">
                    Your reservation is currently <span class="text-white font-semibold" x-text="booking.status"></span>.
                    Front desk or admin can review and confirm the booking assignment from the admin side.
                </p>
            </div>

            <div class="receipt-nav-actions no-print">
                <a href="{{ url('/') }}" class="rounded-xl border border-white/15 bg-[#202026] px-6 py-3 text-sm font-bold text-white">Return Home</a>
                <a href="{{ url('/availability?reset=1') }}" class="rounded-xl bg-gold px-6 py-3 text-sm font-extrabold text-black hover:bg-[#e1b454] transition">Book Another Stay</a>
            </div>
        </section>
    </main>

    <script>
        function confirmationPage() {
            return {
                steps: [
                    { number: 1, label: "Dates & Availability" },
                    { number: 2, label: "Guest Information" },
                    { number: 3, label: "Payment & Guarantee" },
                    { number: 4, label: "Confirmation" },
                ],

                booking: @json($booking),
                nights: 1,

                init() {
                    this.nights = this.computeNights();
                },

                computeNights() {
                    if (!this.booking.check_in_date || !this.booking.check_out_date) return 1;

                    const checkin = new Date(this.booking.check_in_date);
                    const checkout = new Date(this.booking.check_out_date);
                    const diff = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));

                    return diff > 0 ? diff : 1;
                },

                money(value) {
                    return '₱' + Number(value || 0).toLocaleString('en-PH', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },

                guestName() {
                    if (!this.booking.guest) return '-';
                    return `${this.booking.guest.first_name} ${this.booking.guest.last_name}`;
                },

                roomTypeName() {
                    if (this.booking.rooms && this.booking.rooms.length > 0 && this.booking.rooms[0].room_type) {
                        return this.booking.rooms[0].room_type.name;
                    }
                    return 'Room type unavailable';
                },

                assignedRoomsText() {
                    if (!this.booking.rooms || this.booking.rooms.length === 0) {
                        return 'No room assigned';
                    }

                    return this.booking.rooms.map(room => room.room_number).join(', ');
                },

                guestCountText() {
                    return `${this.booking.adult} Adults, ${this.booking.childen} Children`;
                }
            };
        }
    </script>
</body>
</html>