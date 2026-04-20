(function () {
    const baseFooter = {
        blurb: "Experience refined hospitality at La Nuevo Hogar, where elegant accommodations, exceptional service, and luxurious comfort create unforgettable moments for every guest.",
        socialLinks: [
            { href: "#", icon: "fa-facebook-f", label: "Facebook" },
            { href: "#", icon: "fa-instagram", label: "Instagram" },
            { href: "#", icon: "fa-x-twitter", label: "X" },
            { href: "#", icon: "fa-youtube", label: "YouTube" },
        ],
        partnerLogos: [
            { src: "images/BTAC.png", alt: "BTAC partner logo", className: "h-28 object-contain" },
            { src: "images/ITSLOGO.png", alt: "ITS partner logo", className: "w-44 object-contain" },
            { src: "images/bcplogo.png", alt: "BCP partner logo", className: "w-20 object-contain" },
            { src: "images/bshmlogo2.png", alt: "BSHM partner logo", className: "w-24 object-contain" },
        ],
        newsletter: {
            title: "Receive Exclusive Offers",
            text: "Subscribe to receive special promotions, luxury packages, and seasonal offers from La Nuevo Hogar.",
            placeholder: "Enter your email address",
            buttonLabel: "Join",
        },
        quickLinks: [
            { label: "Home", href: "index.html" },
            { label: "Rooms & Suites", href: "rooms.html" },
            { label: "Reservations", href: "availability.html?reset=1" },
            { label: "Amenities", href: "#" },
            { label: "Gallery", href: "#" },
        ],
        guestServices: [
            { label: "Concierge", href: "#" },
            { label: "Spa & Wellness", href: "#" },
            { label: "Dining & Restaurants", href: "#" },
            { label: "Event Venues", href: "#" },
            { label: "Transportation", href: "#" },
        ],
        contact: [
            "Manila, Philippines",
            "+63 912 345 6789",
            "reservations@elnuevohogar.com",
            "Open 24 Hours",
        ],
        legalLinks: [
            { label: "Privacy Policy", href: "#" },
            { label: "Terms of Service", href: "#" },
            { label: "Accessibility", href: "#" },
            { label: "Sitemap", href: "#" },
        ],
    };

    window.siteFooterContent = function siteFooterContent(section) {
        return {
            ...baseFooter,
            section: section || "main",
            year: new Date().getFullYear(),
        };
    };
})();
