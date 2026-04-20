window.BookingFlow = (() => {
  const STORAGE_KEY = "lnh_booking_flow_v4";
  const LEGACY_STORAGE_KEYS = ["lnh_booking_flow_v1", "lnh_booking_flow_v2", "lnh_booking_flow_v3"];

  const rooms = [
    {
      name: "Deluxe Room",
      description: "Elegant comfort with premium touches and a calming layout.",
      image: "https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1600&auto=format&fit=crop",
      guests: 2,
      guestsLabel: "2 Guests",
      bed: "Queen Bed",
      size: "32 sqm",
      view: "City View",
      price: 4500,
      inventory: 5,
    },
    {
      name: "Superior Room",
      description: "Bright interiors and modern amenities for effortless stays.",
      image: "https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=1600&auto=format&fit=crop",
      guests: 2,
      guestsLabel: "2 Guests",
      bed: "Queen Bed",
      size: "28 sqm",
      view: "Courtyard View",
      price: 3900,
      inventory: 8,
    },
    {
      name: "Premier Room",
      description: "A refined upgrade with extra space and a tranquil feel.",
      image: "https://images.unsplash.com/photo-1507652313519-d4e9174996dd?q=80&w=1600&auto=format&fit=crop",
      guests: 2,
      guestsLabel: "2 Guests",
      bed: "King Bed",
      size: "38 sqm",
      view: "Garden View",
      price: 5200,
      inventory: 3,
    },
    {
      name: "Executive Room",
      description: "Perfect for business travel-quiet, polished, and spacious.",
      image: "https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1600&auto=format&fit=crop",
      guests: 2,
      guestsLabel: "2 Guests",
      bed: "King Bed",
      size: "42 sqm",
      view: "Pool View",
      price: 6200,
      inventory: 4,
    },
    {
      name: "Family Room",
      description: "Comfortable space designed for families and shared moments.",
      image: "https://images.unsplash.com/photo-1617098900591-3f90928e8c54?q=80&w=1600&auto=format&fit=crop",
      guests: 4,
      guestsLabel: "4 Guests",
      bed: "2 Queen Beds",
      size: "55 sqm",
      view: "City View",
      price: 7500,
      inventory: 2,
    },
    {
      name: "Junior Suite",
      description: "Suite-style comfort with lounge details and elevated finishes.",
      image: "https://images.unsplash.com/photo-1591088398332-8a7791972843?q=80&w=1600&auto=format&fit=crop",
      guests: 3,
      guestsLabel: "3 Guests",
      bed: "King Bed",
      size: "80 sqm",
      view: "Panoramic City View",
      price: 8900,
      inventory: 2,
    },
    {
      name: "Executive Suite",
      description: "A premium suite for longer stays and special business trips.",
      image: "https://images.unsplash.com/photo-1582582621959-48d27397dc39?q=80&w=1600&auto=format&fit=crop",
      guests: 3,
      guestsLabel: "3 Guests",
      bed: "King Bed",
      size: "110 sqm",
      view: "Skyline View",
      price: 12500,
      inventory: 1,
    },
    {
      name: "Presidential Suite",
      description: "Grand scale and signature luxury for the most exclusive stays.",
      image: "https://images.unsplash.com/photo-1540518614846-7eded433c457?q=80&w=1600&auto=format&fit=crop",
      guests: 4,
      guestsLabel: "4 Guests",
      bed: "King Bed",
      size: "180 sqm",
      view: "Panoramic Skyline View",
      price: 22000,
      inventory: 1,
    },
  ];

  const clone = (value) => JSON.parse(JSON.stringify(value));
  const getRoomByName = (name) => rooms.find((room) => room.name === name) || rooms[0];
  const mojibakeMap = {
    "\u00E2\u201A\u00B1": "₱",
    "\u00E2\u20AC\u00A2": "•",
    "\u00E2\u20AC\u201D": "—",
    "\u00E2\u20AC\u201C": "–",
    "\u00E2\u20AC\u2011": "‑",
    "\u00E2\u20AC\u2122": "'",
    "\u00E2\u2020\u2019": "→",
    "\u00C2\u00A9": "©",
    "caf\u00C3\u00A9": "café",
    "d\u00C3\u00A9cor": "décor",
  };

  const normalizeText = (value) => {
    if (typeof value !== "string") return value;
    return Object.entries(mojibakeMap).reduce((text, [from, to]) => text.split(from).join(to), value).normalize("NFC");
  };

  const normalizeValue = (value) => {
    if (Array.isArray(value)) return value.map(normalizeValue);
    if (value && typeof value === "object") {
      return Object.fromEntries(Object.entries(value).map(([key, entry]) => [key, normalizeValue(entry)]));
    }
    return normalizeText(value);
  };

  const normalizePrice = (value, fallback) => {
    if (typeof value === "number" && Number.isFinite(value)) return value;
    const numeric = Number(String(value || "").replace(/[^\d.]/g, ""));
    return Number.isFinite(numeric) && numeric > 0 ? numeric : fallback;
  };

  const emptyRoom = () => null;

  const getDefaultState = () => ({
    stay: {
      checkin: "",
      checkout: "",
      adults: 2,
      children: 0,
      rooms: 1,
      requests: "",
    },
    selectedRoom: emptyRoom(),
    selectedRoomLocked: false,
    guest: {
      firstName: "",
      lastName: "",
      nationality: "",
      purpose: "",
      email: "",
      phone: "",
      idType: "Passport",
      idNumber: "",
      requests: "",
    },
    payment: {
      method: "pay_hotel",
      cardName: "",
      cardNumber: "",
      expiry: "",
      cvv: "",
      onlineProvider: "",
      promoCode: "",
    },
    confirmationNumber: "HB-7856-Z",
    userLoggedIn: false,
    userEmail: "",
    bookingReference: "",
    bookingStatus: "Pending",
  });

  const readState = () => {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      return raw ? normalizeValue(JSON.parse(raw)) : {};
    } catch {
      return {};
    }
  };

  const writeState = (nextState) => {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(nextState));
    } catch {
      // no-op
    }
  };

  const clear = () => {
    try {
      localStorage.removeItem(STORAGE_KEY);
      LEGACY_STORAGE_KEYS.forEach((key) => localStorage.removeItem(key));
    } catch {
      // no-op
    }
  };

  const mergeState = (partial) => {
    const base = getDefaultState();
    const current = readState();
    const resolvedSelectedRoom =
      partial && Object.prototype.hasOwnProperty.call(partial, "selectedRoom")
        ? partial.selectedRoom
        : (current.selectedRoom ?? base.selectedRoom);
    const next = {
      ...base,
      ...current,
      ...partial,
      stay: { ...base.stay, ...(current.stay || {}), ...(partial?.stay || {}) },
      selectedRoom: resolvedSelectedRoom ? { ...(resolvedSelectedRoom || {}) } : null,
      guest: { ...base.guest, ...(current.guest || {}), ...(partial?.guest || {}) },
      payment: { ...base.payment, ...(current.payment || {}), ...(partial?.payment || {}) },
    };
    if (next.selectedRoom) {
      next.selectedRoom.price = normalizePrice(next.selectedRoom.price, getRoomByName("Deluxe Room").price);
    }
    next.stay = normalizeValue(next.stay);
    next.guest = normalizeValue(next.guest);
    next.payment = normalizeValue(next.payment);
    next.selectedRoom = next.selectedRoom ? normalizeValue(next.selectedRoom) : null;
    writeState(next);
    return next;
  };

  const money = (value) => "\u20B1" + Number(value || 0).toLocaleString("en-PH");

  const nights = (checkin, checkout) => {
    const start = Date.parse(checkin || "");
    const end = Date.parse(checkout || "");
    if (Number.isNaN(start) || Number.isNaN(end) || end <= start) return 0;
    return Math.round((end - start) / 86400000);
  };

  const totals = (state) => {
    const stayNights = Math.max(1, nights(state.stay.checkin, state.stay.checkout));
    const subtotal = Number(state?.selectedRoom?.price || 0) * stayNights * Math.max(1, Number(state.stay.rooms || 1));
    const discount = state.payment?.promoCode === "DISCOUNT10" ? Math.round(subtotal * 0.1) : 0;
    const discountedSubtotal = subtotal - discount;
    const vat = Math.round(discountedSubtotal * 0.12);
    return { nights: stayNights, subtotal, discount, vat, total: discountedSubtotal + vat };
  };

  const navigationType = () => {
    try {
      const navEntry = performance.getEntriesByType("navigation")[0];
      return navEntry?.type || "";
    } catch {
      return "";
    }
  };

  const boot = () => {
    if (navigationType() === "reload") {
      clear();
    }
    try {
      LEGACY_STORAGE_KEYS.forEach((key) => localStorage.removeItem(key));
    } catch {
      // no-op
    }
    return mergeState({});
  };

  const guestSummary = (stay) => {
    const childChunk = stay.children ? `, ${stay.children} Child${stay.children > 1 ? "ren" : ""}` : "";
    return `${stay.adults} Adults${childChunk} - ${stay.rooms} Room${stay.rooms > 1 ? "s" : ""}`;
  };

  return {
    STORAGE_KEY,
    LEGACY_STORAGE_KEYS,
    rooms,
    clone,
    boot,
    clear,
    money,
    nights,
    totals,
    readState,
    writeState,
    getDefaultState,
    mergeState,
    getRoomByName,
    emptyRoom,
    guestSummary,
  };
})();
