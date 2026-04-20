window.DiningReservationFlow = (() => {
  const STORAGE_KEY = "lnh_dining_reservation_v1";

  const venues = [
    {
      name: "Finestra",
      category: "Signature Grill",
      description: "Wood-fired classics, skyline views, and a room designed for celebratory dinners.",
      image: "https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=1200",
      serviceStyle: "Chef-led dinner",
      hours: "5:30 PM - 10:30 PM",
      location: "Sky Dining Level",
      averageSpend: 2400,
    },
    {
      name: "Sakura",
      category: "Japanese Dining",
      description: "An intimate sushi and robata concept with quieter lighting and chef-led service.",
      image: "https://images.unsplash.com/photo-1553621042-f6e147245754?q=80&w=1200",
      serviceStyle: "Sushi & robata",
      hours: "12:00 PM - 10:00 PM",
      location: "Garden Wing",
      averageSpend: 1850,
    },
    {
      name: "Golden Dragon",
      category: "Cantonese Table",
      description: "Signature regional specialties served in a richer, more ceremonial setting.",
      image: "https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1200",
      serviceStyle: "Shared dining",
      hours: "11:30 AM - 10:00 PM",
      location: "Grand Atrium",
      averageSpend: 2100,
    },
    {
      name: "Buffet Dining",
      category: "Casual Dining",
      description: "A vibrant all-day room with live stations, rotating specialties, and generous variety.",
      image: "https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=1200",
      serviceStyle: "All-day buffet",
      hours: "6:00 AM - 10:00 PM",
      location: "Lobby Level",
      averageSpend: 1450,
    },
    {
      name: "Family Dining",
      category: "Casual Dining",
      description: "Comfort-led menus and approachable service for longer lunches and multigenerational dinners.",
      image: "https://images.unsplash.com/photo-1514933651103-005eec06c04b?q=80&w=1200",
      serviceStyle: "Family-style dining",
      hours: "10:00 AM - 10:00 PM",
      location: "Garden Court",
      averageSpend: 1250,
    },
    {
      name: "Rooftop Bar",
      category: "Bar & Lounge",
      description: "Skyline cocktails, sunset seating, and a more cinematic after-dark atmosphere.",
      image: "https://images.unsplash.com/photo-1514933651103-005eec06c04b?q=80&w=1200",
      serviceStyle: "Cocktails & light bites",
      hours: "4:00 PM - 1:00 AM",
      location: "Roof Deck",
      averageSpend: 1600,
    },
    {
      name: "Cafe Lounge",
      category: "Cafe Lounge",
      description: "Coffee, pastries, and quieter daytime seating designed for casual meetings or pauses.",
      image: "https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?q=80&w=1200",
      serviceStyle: "Cafe service",
      hours: "7:00 AM - 9:00 PM",
      location: "Lobby Lounge",
      averageSpend: 900,
    },
  ];

  const clone = (value) => JSON.parse(JSON.stringify(value));
  const getVenueByName = (name) => venues.find((venue) => venue.name === name) || venues[0];
  const emptyVenue = () => null;

  const getDefaultState = () => ({
    reservation: {
      date: "",
      time: "",
      guests: 2,
      occasion: "",
      requests: "",
    },
    selectedVenue: emptyVenue(),
    selectedVenueLocked: false,
    guest: {
      firstName: "",
      lastName: "",
      email: "",
      phone: "",
    },
    guarantee: {
      method: "pay_venue",
      cardName: "",
      cardNumber: "",
      expiry: "",
      notes: "",
    },
    confirmationNumber: "DR-5128-A",
  });

  const readState = () => {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      return raw ? JSON.parse(raw) : {};
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
    } catch {
      // no-op
    }
  };

  const mergeState = (partial) => {
    const base = getDefaultState();
    const current = readState();
    const resolvedSelectedVenue =
      partial && Object.prototype.hasOwnProperty.call(partial, "selectedVenue")
        ? partial.selectedVenue
        : (current.selectedVenue ?? base.selectedVenue);

    const next = {
      ...base,
      ...current,
      ...partial,
      reservation: { ...base.reservation, ...(current.reservation || {}), ...(partial?.reservation || {}) },
      selectedVenue: resolvedSelectedVenue ? { ...resolvedSelectedVenue } : null,
      guest: { ...base.guest, ...(current.guest || {}), ...(partial?.guest || {}) },
      guarantee: { ...base.guarantee, ...(current.guarantee || {}), ...(partial?.guarantee || {}) },
    };

    writeState(next);
    return next;
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
    return mergeState({});
  };

  const money = (value) => "\u20B1" + Number(value || 0).toLocaleString("en-PH");

  const partySummary = (reservation) => `${reservation.guests} Guest${reservation.guests > 1 ? "s" : ""}`;

  const estimate = (state) => {
    const spend = Number(state?.selectedVenue?.averageSpend || 0);
    const guests = Math.max(1, Number(state?.reservation?.guests || 1));
    const subtotal = spend * guests;
    const serviceCharge = Math.round(subtotal * 0.1);
    return { subtotal, serviceCharge, total: subtotal + serviceCharge };
  };

  return {
    STORAGE_KEY,
    venues,
    clone,
    boot,
    clear,
    readState,
    mergeState,
    writeState,
    getDefaultState,
    getVenueByName,
    emptyVenue,
    money,
    partySummary,
    estimate,
  };
})();
