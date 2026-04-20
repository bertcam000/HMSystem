<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Checkout | La Nuevo Hogar</title>
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
        .field-error{border-color:#ff4747!important;box-shadow:none!important;}
        .booking-textarea{width:100%;padding:1rem;border:1px solid rgba(255,255,255,.1);border-radius:.75rem;background:#202026;color:#fff;}
        .booking-kicker{font-size:.72rem;letter-spacing:.42em;text-transform:uppercase;color:#8f93a8;}
        .booking-page-title{font-size:clamp(2.45rem,4vw,3.8rem);line-height:.96;color:#fff;}
        .booking-copy{font-size:.97rem;line-height:1.75;color:#9fa4b8;}
        .booking-section-title{font-size:clamp(1.95rem,2.8vw,2.6rem);line-height:1.05;color:#fff;}
        .booking-subsection-title{font-size:clamp(1.6rem,2.2vw,2rem);line-height:1.1;color:#fff;}
        .booking-label{display:block;margin-bottom:.9rem;font-size:.74rem;font-weight:700;letter-spacing:.42em;text-transform:uppercase;color:#9ba0bc;}
        .booking-input{min-height:3.5rem;padding:1rem 1.1rem;font-size:.98rem;line-height:1.5;}
        .booking-primary-btn{min-height:3.5rem;padding:.95rem 1.6rem;font-size:.96rem;font-weight:800;}
        .booking-secondary-btn{min-height:3.5rem;padding:.95rem 1.5rem;font-size:.95rem;}
        .booking-summary-title{font-size:clamp(1.9rem,2.2vw,2.35rem);line-height:1.08;color:#fff;}
        .booking-summary-label{font-size:.9rem;color:#a6abc2;}
        .booking-summary-value{font-size:1.12rem;line-height:1.4;}
        .booking-summary-price{font-size:clamp(1.4rem,1.75vw,1.85rem);line-height:1;}
        .booking-summary-room{display:grid;grid-template-columns:auto minmax(0,1fr);gap:.9rem;align-items:start;}
        .booking-summary-room-copy{min-width:0;}
        .booking-summary-rate{display:flex;align-items:baseline;gap:.3rem;flex-wrap:wrap;}
        .booking-summary-rate-suffix{font-size:.85rem;font-weight:700;color:#8f93a8;}
    </style>
</head>
<body class="text-gray-200" x-data="checkoutPage()" x-init="init()">
    <main class="booking-shell mx-auto min-w-0 px-4 sm:px-6 py-10 md:py-14 space-y-8">
        <section class="space-y-3">
            <p class="booking-kicker">Reservation</p>
            <h1 class="booking-page-title" x-text="pageTitle()"></h1>
            <p class="booking-copy max-w-3xl" x-text="pageIntro()"></p>
        </section>

        <div class="shell-grid w-full min-w-0">
            <div class="min-w-0 space-y-6">
                <section class="panel rounded-[28px] p-8" x-show="step === 2">
                    <div class="space-y-8">
                        <div class="card rounded-3xl p-6 bg-gradient-to-br from-[#1a1a1f] to-[#202026] border border-gold/10">
                            <h3 class="text-xl text-white font-semibold mb-4">Reservation Summary</h3>
                            <div class="grid md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <p class="text-[#8f93a8]">Room Type</p>
                                    <p class="text-white font-semibold" x-text="roomType ? roomType.name : '-'"></p>
                                </div>
                                <div>
                                    <p class="text-[#8f93a8]">Dates</p>
                                    <p class="text-white font-semibold" x-text="state.stay.checkin + ' - ' + state.stay.checkout"></p>
                                </div>
                                <div>
                                    <p class="text-[#8f93a8]">Guests</p>
                                    <p class="text-white font-semibold" x-text="guestSummary()"></p>
                                </div>
                                <div class="md:col-span-3 pt-4 border-t border-white/10">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#8f93a8]">Estimated Total</span>
                                        <span class="text-2xl font-bold text-gold" x-text="money(totals.total)"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h2 class="booking-section-title">Guest Information</h2>
                            <p class="booking-copy mt-2">Enter the primary guest details exactly as they should appear on the reservation folio.</p>
                        </div>

                        <div x-show="bookingMode === 'choose'" class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="card rounded-3xl p-6 bg-gradient-to-br from-[#1a1a1f] to-[#202026] border border-gold/10">
                                    <div class="text-center mb-6">
                                        <h3 class="text-xl text-white font-semibold mb-2">Sign In</h3>
                                        <p class="text-sm text-[#8f93a8]">Faster booking with saved details</p>
                                    </div>
                                    <div class="space-y-3">
                                        <button type="button" @click="signInWith('google')" class="w-full rounded-xl border border-white/15 bg-[#202026] px-4 py-3 text-sm font-semibold text-white">Continue with Google</button>
                                        <button type="button" @click="signInWith('facebook')" class="w-full rounded-xl border border-white/15 bg-[#202026] px-4 py-3 text-sm font-semibold text-white">Continue with Facebook</button>
                                        <button type="button" @click="signInWith('email')" class="w-full rounded-xl border border-white/15 bg-[#202026] px-4 py-3 text-sm font-semibold text-white">Sign in with Email</button>
                                    </div>
                                </div>

                                <div class="card rounded-3xl p-6 bg-gradient-to-br from-[#1a1a1f] to-[#202026] border border-gold/10">
                                    <div class="text-center mb-6">
                                        <h3 class="text-xl text-white font-semibold mb-2">Continue as Guest</h3>
                                        <p class="text-sm text-[#8f93a8]">Quick booking without account</p>
                                    </div>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="booking-label">Full Name *</label>
                                            <input x-model="guest.firstName" placeholder="Juan" class="booking-input field w-full rounded-xl" />
                                        </div>
                                        <div>
                                            <label class="booking-label">Email Address *</label>
                                            <input x-model="guest.email" type="email" placeholder="juan@email.com" class="booking-input field w-full rounded-xl" />
                                        </div>
                                        <div>
                                            <label class="booking-label">Phone Number *</label>
                                            <input x-model="guest.phone" placeholder="+63 912 345 6789" class="booking-input field w-full rounded-xl" />
                                        </div>
                                        <button type="button" @click="continueAsGuest()" class="w-full rounded-xl bg-gold px-6 py-3 text-sm font-bold text-black">Continue as Guest</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-show="bookingMode === 'form'" class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label class="booking-label">First Name *</label>
                                    <input x-model="guest.firstName" class="booking-input field w-full rounded-xl" :class="errors.firstName ? 'field-error' : ''" />
                                    <p class="text-xs text-red-400 mt-2" x-show="errors.firstName" x-text="errors.firstName"></p>
                                </div>
                                <div>
                                    <label class="booking-label">Last Name *</label>
                                    <input x-model="guest.lastName" class="booking-input field w-full rounded-xl" :class="errors.lastName ? 'field-error' : ''" />
                                    <p class="text-xs text-red-400 mt-2" x-show="errors.lastName" x-text="errors.lastName"></p>
                                </div>
                                <div>
                                    <label class="booking-label">Nationality *</label>
                                    <input x-model="guest.nationality" class="booking-input field w-full rounded-xl" :class="errors.nationality ? 'field-error' : ''" />
                                    <p class="text-xs text-red-400 mt-2" x-show="errors.nationality" x-text="errors.nationality"></p>
                                </div>
                                <div>
                                    <label class="booking-label">Date of Birth *</label>
                                    <input
                                        type="date"
                                        x-model="guest.dateOfBirth"
                                        class="booking-input field w-full rounded-xl"
                                        :class="errors.dateOfBirth ? 'field-error' : ''"
                                    />
                                    <p class="text-xs text-red-400 mt-2" x-show="errors.dateOfBirth" x-text="errors.dateOfBirth"></p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label class="booking-label">Email Address *</label>
                                    <input x-model="guest.email" class="booking-input field w-full rounded-xl" :class="errors.email ? 'field-error' : ''" />
                                    <p class="text-xs text-red-400 mt-2" x-show="errors.email" x-text="errors.email"></p>
                                </div>
                                <div>
                                    <label class="booking-label">Phone Number *</label>
                                    <input x-model="guest.phone" class="booking-input field w-full rounded-xl" :class="errors.phone ? 'field-error' : ''" />
                                    <p class="text-xs text-red-400 mt-2" x-show="errors.phone" x-text="errors.phone"></p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="booking-label">Address *</label>
                                    <textarea
                                        x-model="guest.address"
                                        placeholder="Complete address"
                                        class="booking-input w-full border rounded booking-textarea"
                                        :class="errors.address ? 'field-error' : ''"
                                    ></textarea>
                                    <p class="text-xs text-red-400 mt-2" x-show="errors.address" x-text="errors.address"></p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label class="booking-label">ID Type</label>
                                    <select x-model="guest.idType" class="booking-input field w-full rounded-xl">
                                        <option value="Passport">Passport</option>
                                        <option value="Driver's License">Driver's License</option>
                                        <option value="National ID">National ID</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="booking-label">ID Number *</label>
                                    <input x-model="guest.idNumber" class="booking-input field w-full rounded-xl" :class="errors.idNumber ? 'field-error' : ''" />
                                    <p class="text-xs text-red-400 mt-2" x-show="errors.idNumber" x-text="errors.idNumber"></p>
                                </div>
                            </div>

                            <div>
                                <label class="booking-label">Special Requests</label>
                                <textarea x-model="guest.requests" class="booking-input w-full border rounded booking-textarea"></textarea>
                            </div>

                            <div class="flex flex-wrap gap-3 pt-2">
                                <button type="button" @click="goBackToAvailability()" class="booking-secondary-btn rounded-xl border border-white/15 bg-[#202026] font-bold text-white">Back</button>
                                <button type="button" @click="validateGuestStep()" class="booking-primary-btn rounded-xl bg-gold text-black">Proceed to Payment & Guarantee</button>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="panel rounded-[28px] p-8" x-show="step === 3">
                    <div class="space-y-8">
                        <div>
                            <h2 class="booking-section-title">Payment &amp; Guarantee</h2>
                            <p class="booking-copy mt-2">Choose a preferred payment option and confirm the reservation guarantee.</p>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-4">
                            <button type="button" @click="payment.method = 'pay_hotel'" class="card rounded-2xl p-5 text-left" :class="payment.method === 'pay_hotel' ? 'ring-1 ring-gold border-gold/70' : ''">
                                <p class="text-white font-semibold">Pay at Hotel</p>
                            </button>
                            <button type="button" @click="payment.method = 'card'" class="card rounded-2xl p-5 text-left" :class="payment.method === 'card' ? 'ring-1 ring-gold border-gold/70' : ''">
                                <p class="text-white font-semibold">Credit / Debit Card</p>
                            </button>
                            <button type="button" @click="payment.method = 'online'" class="card rounded-2xl p-5 text-left" :class="payment.method === 'online' ? 'ring-1 ring-gold border-gold/70' : ''">
                                <p class="text-white font-semibold">Online Payment</p>
                            </button>
                        </div>

                        <div x-show="payment.method === 'card'" class="grid md:grid-cols-2 gap-5">
                            <div><label class="booking-label">Cardholder Name</label><input x-model="payment.cardName" class="booking-input field w-full rounded-xl" /></div>
                            <div><label class="booking-label">Card Number</label><input x-model="payment.cardNumber" class="booking-input field w-full rounded-xl" /></div>
                            <div><label class="booking-label">Expiry</label><input x-model="payment.expiry" class="booking-input field w-full rounded-xl" /></div>
                            <div><label class="booking-label">CVV</label><input x-model="payment.cvv" class="booking-input field w-full rounded-xl" /></div>
                        </div>

                        <div x-show="payment.method === 'online'" class="max-w-md">
                            <label class="booking-label">Online Payment Option</label>
                            <select x-model="payment.onlineProvider" class="booking-input field w-full rounded-xl">
                                <option value="">Select provider</option>
                                <option value="GCash">GCash</option>
                                <option value="Maya">Maya</option>
                            </select>
                        </div>

                        <div class="max-w-md">
                            <label class="booking-label">Promo Code (Optional)</label>
                            <input x-model="payment.promoCode" @input="refreshTotals()" class="booking-input field w-full rounded-xl" />
                        </div>

                        <div class="card rounded-2xl p-5 space-y-4">
                            <label class="flex items-start gap-3 rounded-2xl border border-white/10 bg-[#1a1b21] p-4">
                                <input type="checkbox" x-model="acceptedPolicy" class="mt-1 accent-[#d1a545]">
                                <span class="text-sm text-[#c0c4d3]">I agree to the hotel's payment, cancellation, and reservation conditions.</span>
                            </label>

                            <label class="flex items-start gap-3 rounded-2xl border border-white/10 bg-[#1a1b21] p-4">
                                <input type="checkbox" x-model="authorizeCharge" class="mt-1 accent-[#d1a545]">
                                <span class="text-sm text-[#c0c4d3]">I authorize La Nuevo Hogar to place this guarantee on my selected payment method.</span>
                            </label>
                        </div>

                        <div class="rounded-2xl border border-gold/25 bg-[#14120e] p-5 md:p-6 space-y-4">
                            <p class="text-xs text-[#8f93a8]">Demo verification code: <span class="text-gold font-mono">123456</span></p>
                            <button type="button" @click="sendOtp()" class="rounded-xl border border-gold/40 bg-[#1a1711] px-4 py-2.5 text-sm font-semibold text-gold">
                                <span x-show="!otpSent">Send verification code</span>
                                <span x-show="otpSent" x-cloak>Resend code</span>
                            </button>
                            <p class="text-xs text-[#18c560] font-medium" x-show="otpVerified" x-cloak>Verified — you can confirm your booking.</p>
                        </div>

                        <div class="flex flex-wrap gap-3 pt-2">
                            <button type="button" @click="step = 2" class="booking-secondary-btn rounded-xl border border-white/15 bg-[#202026] font-bold text-white">Back</button>
                            <button type="button" @click="confirmReservation()"
                                :disabled="!canConfirmBooking() || submitting"
                                :class="canConfirmBooking() && !submitting ? 'opacity-100' : 'opacity-40 cursor-not-allowed'"
                                class="booking-primary-btn rounded-xl bg-gold text-black">
                                <span x-show="!submitting">Confirm Reservation</span>
                                <span x-show="submitting" x-cloak>Submitting...</span>
                            </button>
                        </div>
                    </div>
                </section>
            </div>

            <aside class="panel min-w-0 w-full space-y-4 rounded-[28px] p-5 md:p-6 xl:sticky xl:top-24 xl:self-start">
                <div class="min-w-0">
                    <p class="booking-kicker">Live Folio</p>
                    <h2 class="booking-summary-title mt-2 font-semibold text-white font-luxury">Reservation Summary</h2>
                </div>

                <div class="card min-w-0 space-y-3 rounded-2xl p-4">
                    <p class="booking-summary-label">Stay Dates</p>
                    <div class="grid grid-cols-2 gap-3 min-w-0">
                        <div><p class="text-xs text-[#8f93a8]">Check-in</p><p class="mt-1 text-sm font-bold text-white" x-text="state.stay.checkin || '-'"></p></div>
                        <div><p class="text-xs text-[#8f93a8]">Check-out</p><p class="mt-1 text-sm font-bold text-white" x-text="state.stay.checkout || '-'"></p></div>
                    </div>
                    <p class="text-sm text-[#8f93a8]" x-text="totals.nights + ' nights'"></p>
                </div>

                <div class="card min-w-0 rounded-2xl p-4">
                    <p class="booking-summary-label mb-2">Guests</p>
                    <p class="booking-summary-value font-bold text-white" x-text="guestSummary()"></p>
                </div>

                <div class="card min-w-0 overflow-hidden rounded-2xl p-4" x-show="roomType" x-cloak>
                    <p class="booking-summary-label mb-3">Selected Room Type</p>
                    <div class="booking-summary-room min-w-0">
                        <img :src="roomTypeImage()" class="h-14 w-16 shrink-0 rounded-xl object-cover sm:h-16 sm:w-20">
                        <div class="booking-summary-room-copy flex-1 pr-1">
                            <p class="text-base font-semibold text-white break-words sm:text-lg" x-text="roomType.name"></p>
                            <p class="mt-0.5 text-xs text-[#8f93a8] break-words" x-text="roomTypeMeta()"></p>
                        </div>
                    </div>
                    <div class="booking-summary-rate mt-3">
                        <p class="booking-summary-price font-extrabold text-gold" x-text="money(roomType.price)"></p>
                        <span class="booking-summary-rate-suffix">/night</span>
                    </div>
                </div>

                <div class="card min-w-0 space-y-2.5 rounded-2xl p-4" x-show="roomType" x-cloak>
                    <p class="booking-summary-label mb-1">Price Breakdown</p>
                    <div class="space-y-2 text-sm">
                        <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between sm:gap-3">
                            <span class="min-w-0 flex-1 text-[#b5b9c9] break-words"
                                x-text="money(roomType.price) + ' × ' + totals.nights + ' nights × ' + state.stay.rooms + ' room' + (Number(state.stay.rooms) !== 1 ? 's' : '')"></span>
                            <span class="shrink-0 text-right font-bold text-white" x-text="money(totals.subtotal)"></span>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[#b5b9c9]">VAT (12%)</span>
                            <span class="font-bold text-white" x-text="money(totals.vat)"></span>
                        </div>
                        <div x-show="totals.discount > 0" class="flex items-center justify-between gap-2">
                            <span class="text-green-400">Discount</span>
                            <span class="font-bold text-green-400" x-text="'-' + money(totals.discount)"></span>
                        </div>
                        <div class="flex flex-wrap items-baseline justify-between gap-2 border-t border-white/10 pt-3">
                            <span class="text-xl text-white font-luxury">Total</span>
                            <span class="text-lg font-extrabold text-gold sm:text-xl" x-text="money(totals.total)"></span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <div x-show="showOtpModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-md" @click="showOtpModal = false">
        <div class="panel rounded-[32px] p-8 max-w-md w-full mx-4 text-center" @click.stop>
            <h3 class="text-2xl text-white mb-2">Verify Your Identity</h3>
            <p class="text-sm text-[#8f93a8] mb-6">Enter the 6-digit code below.</p>
            <div class="space-y-4">
                <input type="text" inputmode="numeric" maxlength="6" autocomplete="one-time-code" placeholder="Enter 6-digit code"
                    x-model="otpInput"
                    class="w-full text-center booking-input field rounded-xl py-4 font-mono text-2xl tracking-widest text-white" />
                <p class="text-xs text-red-400" x-show="otpError" x-text="otpError"></p>
                <p class="text-xs text-[#8f93a8]">Demo code: <span class="text-gold font-mono">123456</span></p>
            </div>
            <div class="flex gap-3 mt-8">
                <button type="button" @click="showOtpModal = false" class="flex-1 rounded-xl border border-white/15 bg-[#202026] px-6 py-3 text-sm font-bold text-white">Cancel</button>
                <button type="button" @click="verifyOtp()" class="flex-1 rounded-xl bg-gold px-6 py-3 text-sm font-bold text-black">Verify Code</button>
            </div>
        </div>
    </div>

    <script>
        function checkoutPage() {
            return {
                step: 2,
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
                guest: {
                    firstName: '',
                    lastName: '',
                    nationality: '',
                    // purpose: '',
                    address: '',
                    dateOfBirth: '',
                    email: '',
                    phone: '',
                    idType: 'Passport',
                    idNumber: '',
                    requests: '',
                },
                payment: {
                    method: 'pay_hotel',
                    cardName: '',
                    cardNumber: '',
                    expiry: '',
                    cvv: '',
                    onlineProvider: '',
                    promoCode: '',
                },
                acceptedPolicy: false,
                authorizeCharge: false,
                otpSent: false,
                otpInput: "",
                otpVerified: false,
                otpError: "",
                showOtpModal: false,
                errors: {},
                totals: { nights: 1, subtotal: 0, vat: 0, total: 0, discount: 0 },
                bookingMode: 'choose',
                userLoggedIn: false,
                userEmail: '',
                bookingStatus: 'Pending',
                submitting: false,

                init() {
                    const params = new URLSearchParams(window.location.search);

                    if (!this.roomType) {
                        window.location.href = `{{ url('/offers') }}`;
                        return;
                    }

                    this.state.stay.checkin = params.get('checkin') || '';
                    this.state.stay.checkout = params.get('checkout') || '';
                    this.state.stay.adults = Number(params.get('adults')) || 2;
                    this.state.stay.children = Number(params.get('children')) || 0;
                    this.state.stay.rooms = Number(params.get('rooms')) || 1;

                    if (!this.state.stay.checkin || !this.state.stay.checkout) {
                        window.location.href = `{{ url('/availability') }}?room_type=${this.roomType.id}`;
                        return;
                    }

                    this.refreshTotals();
                },

                pageTitle() {
                    return this.step === 2 ? "Guest Information" : "Payment & Guarantee";
                },

                pageIntro() {
                    return this.step === 2
                        ? "Enter the primary guest details exactly as they should appear on the reservation folio."
                        : "Complete the guarantee details to secure your booking. An available room will be assigned automatically after submission.";
                },

                refreshTotals() {
                    const nights = this.computeNights();
                    const subtotal = Number(this.roomType?.price || 0) * nights * Number(this.state.stay.rooms || 1);
                    const discount = this.payment.promoCode === 'DISCOUNT10' ? subtotal * 0.10 : 0;
                    const discountedSubtotal = subtotal - discount;
                    const vat = discountedSubtotal * 0.12;
                    const total = discountedSubtotal + vat;

                    this.totals = { nights, subtotal, discount, vat, total };
                },

                computeNights() {
                    if (!this.state.stay.checkin || !this.state.stay.checkout) return 1;
                    const checkin = new Date(this.state.stay.checkin);
                    const checkout = new Date(this.state.stay.checkout);
                    const diff = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));
                    return diff > 0 ? diff : 1;
                },

                money(value) {
                    return '₱' + Number(value || 0).toLocaleString('en-PH', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },

                guestSummary() {
                    return `${this.state.stay.adults} Adult${this.state.stay.adults > 1 ? 's' : ''}, ${this.state.stay.children} Child${this.state.stay.children !== 1 ? 'ren' : ''}, ${this.state.stay.rooms} Room${this.state.stay.rooms > 1 ? 's' : ''}`;
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

                goBackToAvailability() {
                    const params = new URLSearchParams({
                        room_type: this.roomType.id,
                        checkin: this.state.stay.checkin,
                        checkout: this.state.stay.checkout,
                        adults: this.state.stay.adults,
                        children: this.state.stay.children,
                        rooms: this.state.stay.rooms,
                    });

                    window.location.href = `{{ url('/availability') }}?${params.toString()}`;
                },

                validateGuestStep() {
                    this.errors = {};
                    if (!this.guest.firstName.trim()) this.errors.firstName = "Required";
                    if (!this.guest.lastName.trim()) this.errors.lastName = "Required";
                    if (!this.guest.nationality.trim()) this.errors.nationality = "Required";
                    // if (!this.guest.purpose.trim()) this.errors.purpose = "Required";
                    if (!this.guest.address.trim()) this.errors.address = "Required";
                    if (!this.guest.dateOfBirth) this.errors.dateOfBirth = "Required";
                    if (!this.guest.email.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.guest.email)) this.errors.email = "Valid email required";
                    if (!this.guest.phone.trim()) this.errors.phone = "Required";
                    if (!this.guest.idNumber.trim()) this.errors.idNumber = "Required";
                    if (Object.keys(this.errors).length) return;
                    this.bookingStatus = 'Pending';
                    this.sendOtp();
                },

                signInWith(provider) {
                    this.userLoggedIn = true;
                    this.userEmail = provider === 'google' ? 'user@gmail.com' : provider === 'facebook' ? 'user@facebook.com' : 'user@email.com';
                    this.bookingMode = 'form';
                    this.guest.firstName = 'John';
                    this.guest.lastName = 'Doe';
                    this.guest.email = this.userEmail;
                    this.guest.phone = '+63 912 345 6789';
                    this.guest.nationality = 'Filipino';
                    this.guest.purpose = 'Leisure';
                    this.guest.idType = 'Passport';
                    this.guest.idNumber = 'P1234567A';
                },

                continueAsGuest() {
                    this.userLoggedIn = false;
                    this.bookingMode = 'form';
                },

                sendOtp() {
                    this.otpSent = true;
                    this.otpError = "";
                    this.showOtpModal = true;
                },

                verifyOtp() {
                    const code = String(this.otpInput || "").replace(/\s/g, "");
                    if (code === "123456") {
                        this.otpVerified = true;
                        this.otpError = "";
                        this.showOtpModal = false;
                        this.bookingStatus = 'Verified';
                        this.step = 3;
                    } else {
                        this.otpVerified = false;
                        this.otpError = "Invalid code. Use 123456 for this demo.";
                    }
                },

                canConfirmBooking() {
                    return this.acceptedPolicy && this.authorizeCharge && this.otpVerified;
                },

                async confirmReservation() {
                    if (!this.canConfirmBooking()) return;

                    this.submitting = true;

                    try {
                        const response = await fetch(`{{ url('/checkout/submit') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: JSON.stringify({
                                room_type_id: this.roomType.id,
                                check_in_date: this.state.stay.checkin,
                                check_out_date: this.state.stay.checkout,
                                adults: this.state.stay.adults,
                                children: this.state.stay.children,
                                rooms: this.state.stay.rooms,
                                first_name: this.guest.firstName,
                                last_name: this.guest.lastName,
                                nationality: this.guest.nationality,
                                // purpose: this.guest.purpose,
                                address: this.guest.address,
                                date_of_birth: this.guest.dateOfBirth,
                                email: this.guest.email,
                                phone: this.guest.phone,
                                id_type: this.guest.idType,
                                id_number: this.guest.idNumber,
                                requests: this.guest.requests,
                                payment_method: this.payment.method,
                                promo_code: this.payment.promoCode,
                                estimated_total: this.totals.total,
                            }),
                        });

                        const data = await response.json();
                        console.log('checkout submit response:', data);

                        if (!response.ok) {
                            alert(data.message || data.error || 'Unable to complete reservation.');
                            this.submitting = false;
                            return;
                        }

                        window.location.href = `{{ url('/confirmation') }}?booking=${data.booking_id}`;
                    } catch (error) {
                        console.error('checkout submit error:', error);
                        alert(error.message || 'Something went wrong while submitting the reservation.');
                        this.submitting = false;
                    }
                }
            };
        }
    </script>
</body>
</html>