(function () {
    const COOKIE_KEY = "lnh_cookie_consent";
    const MOBILE_BOOKING_QUERY = "(max-width: 1023px)";

    function readConsent() {
        try {
            return localStorage.getItem(COOKIE_KEY);
        } catch {
            return null;
        }
    }

    function writeConsent() {
        try {
            localStorage.setItem(COOKIE_KEY, "accepted");
        } catch {
            // Ignore storage failures and just dismiss for the current session.
        }
    }

    function buildBackToTop() {
        if (document.querySelector("[data-back-to-top]")) return;

        const button = document.createElement("button");
        button.type = "button";
        button.className = "back-to-top";
        button.setAttribute("aria-label", "Back to top");
        button.setAttribute("data-back-to-top", "true");
        button.innerHTML = '<span class="back-to-top__arrow" aria-hidden="true">↑</span><span class="back-to-top__label"></span>';
        button.addEventListener("click", () => {
            window.scrollTo({ top: 0, behavior: "smooth" });
        });

        document.body.appendChild(button);

        const toggle = () => {
            const bookingTriggerVisible = document.body.classList.contains("has-booking-trigger-visible");
            button.classList.toggle("is-visible", window.scrollY > 320 && !bookingTriggerVisible);
        };

        window.addEventListener("scroll", toggle, { passive: true });
        document.addEventListener("booking-trigger-visibility-change", toggle);
        toggle();
    }

    function buildCookieBanner() {
        if (document.querySelector("[data-cookie-banner]")) return;
        if (readConsent() === "accepted") return;

        const banner = document.createElement("div");
        banner.className = "cookie-banner";
        banner.setAttribute("data-cookie-banner", "true");
        banner.innerHTML = [
            '<div class="cookie-banner__inner">',
            '<p class="cookie-banner__text">We use cookies to improve your experience. By using our website, you agree to our use of cookies.</p>',
            '<button type="button" class="cookie-banner__button">I Agree</button>',
            "</div>",
        ].join("");

        const accept = banner.querySelector("button");
        accept.addEventListener("click", () => {
            writeConsent();
            banner.classList.remove("is-visible");
            window.setTimeout(() => banner.remove(), 260);
        });

        document.body.appendChild(banner);
        window.requestAnimationFrame(() => banner.classList.add("is-visible"));
    }

    function initResponsiveBookingModals() {
        const modals = Array.from(document.querySelectorAll("[data-mobile-booking-modal]"));
        if (!modals.length) return;

        const mediaQuery = window.matchMedia(MOBILE_BOOKING_QUERY);
        const overlay = document.createElement("div");
        overlay.className = "booking-modal-overlay";
        overlay.setAttribute("data-booking-overlay", "true");
        document.body.appendChild(overlay);

        let activeModal = null;

        function syncFloatingUiState() {
            const triggerVisible = mediaQuery.matches && !document.body.classList.contains("has-booking-modal-open");
            document.body.classList.toggle("has-booking-trigger-visible", triggerVisible);
            document.dispatchEvent(new CustomEvent("booking-trigger-visibility-change"));
        }

        function closeActiveModal() {
            if (!activeModal) return;

            activeModal.classList.remove("is-open");
            const trigger = document.querySelector(`[data-booking-trigger-for="${activeModal.id}"]`);
            if (trigger) {
                trigger.setAttribute("aria-expanded", "false");
                trigger.focus({ preventScroll: true });
            }

            activeModal = null;
            document.body.classList.remove("has-booking-modal-open");
            syncFloatingUiState();
        }

        function openModal(modal) {
            if (!mediaQuery.matches) return;
            if (activeModal && activeModal !== modal) {
                activeModal.classList.remove("is-open");
            }

            activeModal = modal;
            modal.classList.add("is-open");
            document.body.classList.add("has-booking-modal-open");
            syncFloatingUiState();

            const trigger = document.querySelector(`[data-booking-trigger-for="${modal.id}"]`);
            if (trigger) {
                trigger.setAttribute("aria-expanded", "true");
            }

            const focusTarget = modal.querySelector("input, select, textarea, button");
            if (focusTarget) {
                window.setTimeout(() => focusTarget.focus({ preventScroll: true }), 80);
            }
        }

        modals.forEach((modal, index) => {
            if (!modal.id) {
                modal.id = `booking-modal-${index + 1}`;
            }

            let closeButton = modal.querySelector("[data-booking-modal-close]");
            if (!closeButton) {
                closeButton = document.createElement("button");
                closeButton.type = "button";
                closeButton.className = "booking-modal-close";
                closeButton.setAttribute("aria-label", "Close check availability");
                closeButton.setAttribute("data-booking-modal-close", "true");
                closeButton.innerHTML = '<span aria-hidden="true">&times;</span>';
                modal.appendChild(closeButton);
            }

            closeButton.addEventListener("click", closeActiveModal);

            modal.addEventListener("click", (event) => {
                event.stopPropagation();
            });

            const label = modal.getAttribute("data-mobile-booking-label") || "Check Availability";
            const trigger = document.createElement("button");
            trigger.type = "button";
            trigger.className = "booking-modal-trigger";
            trigger.setAttribute("data-booking-trigger-for", modal.id);
            trigger.setAttribute("aria-controls", modal.id);
            trigger.setAttribute("aria-expanded", "false");
            trigger.innerHTML = [
                '<span class="booking-modal-trigger__icon" aria-hidden="true"><i class="fa-solid fa-calendar-check"></i></span>',
                '<span class="booking-modal-trigger__text">',
                '<span class="booking-modal-trigger__eyebrow">Plan Your Stay</span>',
                `<span class="booking-modal-trigger__label">${label}</span>`,
                "</span>",
            ].join("");

            trigger.addEventListener("click", () => openModal(modal));
            document.body.appendChild(trigger);
        });

        overlay.addEventListener("click", closeActiveModal);

        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape") {
                closeActiveModal();
            }
        });

        const syncMode = () => {
            if (mediaQuery.matches) return;

            document.body.classList.remove("has-booking-modal-open", "has-mobile-booking", "has-booking-trigger-visible");
            activeModal = null;

            modals.forEach((modal) => {
                modal.classList.remove("is-open", "is-mobile-modal");
            });

            syncFloatingUiState();
        };

        const enableMode = () => {
            if (!mediaQuery.matches) return;

            document.body.classList.add("has-mobile-booking");
            modals.forEach((modal) => {
                modal.classList.add("is-mobile-modal");
            });

            syncFloatingUiState();
        };

        const handleBreakpointChange = () => {
            if (mediaQuery.matches) {
                enableMode();
            } else {
                closeActiveModal();
                syncMode();
            }
        };

        if (typeof mediaQuery.addEventListener === "function") {
            mediaQuery.addEventListener("change", handleBreakpointChange);
        } else {
            mediaQuery.addListener(handleBreakpointChange);
        }

        handleBreakpointChange();
    }

    document.addEventListener("DOMContentLoaded", () => {
        buildBackToTop();
        buildCookieBanner();
        initResponsiveBookingModals();
    });
})();
