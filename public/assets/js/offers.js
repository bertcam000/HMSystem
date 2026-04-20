function lnhOffersCatalog() {
  return [
    {
      id: "romantic-city-retreat",
      tag: "Romantic Escape",
      title: "Romantic City Retreat",
      description: "A refined overnight escape with breakfast for two, welcome sparkling wine, and a late check-out designed for slower, more memorable mornings together.",
      longDescription: "Ideal for anniversaries, proposal weekends, or simply taking a pause in the city with premium touches already arranged.",
      discountPercent: 20,
      recommendedRoom: "Junior Suite",
      room: "Junior Suite",
      image: "https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?q=80&w=1600&auto=format&fit=crop",
      inclusions: [
        "Daily breakfast for 2 adults",
        "Sparkling wine on arrival",
        "Late check-out until 2:00 PM",
      ],
      validity: "Available on select weekends through December 2026",
    },
    {
      id: "family-weekend-privileges",
      tag: "Family Time",
      title: "Family Weekend Privileges",
      description: "A family-focused stay with breakfast, pool access, and flexible arrival support for guests traveling with children or multi-generational groups.",
      longDescription: "Designed to make short city breaks feel easier, with more comfort built into the arrival and leisure experience.",
      discountPercent: 15,
      recommendedRoom: "Family Room",
      room: "Family Room",
      image: "https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=1600&auto=format&fit=crop",
      inclusions: [
        "Breakfast for 2 adults and 2 children",
        "Priority family room allocation",
        "Complimentary pool access",
      ],
      validity: "Valid for Friday to Sunday stays",
    },
    {
      id: "business-class-upgrade",
      tag: "Business Travel",
      title: "Business Class Upgrade",
      description: "A polished work-trip package with room upgrade priority, breakfast, and a calmer arrival experience for short executive stays.",
      longDescription: "Built for corporate travelers who want efficiency without giving up comfort, space, or thoughtful hotel service.",
      discountPercent: 18,
      recommendedRoom: "Executive Room",
      room: "Executive Room",
      image: "https://images.unsplash.com/photo-1455587734955-081b22074882?q=80&w=1600&auto=format&fit=crop",
      inclusions: [
        "Upgrade priority upon availability",
        "Daily breakfast",
        "Express check-in support",
      ],
      validity: "Available for weekday arrivals",
    },
    {
      id: "suite-life-advance",
      tag: "Advance Saver",
      title: "Suite Life Advance Saver",
      description: "Book ahead and secure a stronger rate on premium suite stays while keeping the elevated experience of larger layouts and signature amenities.",
      longDescription: "Best suited for guests who already know their travel dates and want to lock in more value on higher-category accommodations.",
      discountPercent: 25,
      recommendedRoom: "Executive Suite",
      room: "Executive Suite",
      image: "https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=1600&auto=format&fit=crop",
      inclusions: [
        "Advance purchase preferred rate",
        "Suite category savings",
        "Welcome amenity on arrival",
      ],
      validity: "Book at least 14 days in advance",
    },
    {
      id: "stay-longer-save-more",
      tag: "Extended Stay",
      title: "Stay Longer, Save More",
      description: "Settle into the city for longer with reduced nightly rates, daily breakfast, and more room to stretch out across multi-night stays.",
      longDescription: "Perfect for blended leisure-business stays, quiet resets, or guests who want more time to enjoy the hotel at a better overall rate.",
      discountPercent: 22,
      recommendedRoom: "Deluxe Room",
      room: "Deluxe Room",
      image: "https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1600&auto=format&fit=crop",
      inclusions: [
        "Reduced rate for 3+ nights",
        "Daily breakfast",
        "Flexible date support subject to policy",
      ],
      validity: "Applies to stays of 3 nights or more",
    },
    {
      id: "celebration-escape",
      tag: "Celebration Stay",
      title: "Celebration Escape Package",
      description: "Turn milestone moments into polished hotel experiences with a decorated room setup, welcome sweets, and premium stay inclusions.",
      longDescription: "Created for birthdays, graduation stays, or small personal celebrations that deserve a little more atmosphere on arrival.",
      discountPercent: 12,
      recommendedRoom: "Premier Room",
      room: "Premier Room",
      image: "https://images.unsplash.com/photo-1522798514-97ceb8c4f1c8?q=80&w=1600&auto=format&fit=crop",
      inclusions: [
        "Celebration room styling",
        "Welcome dessert amenity",
        "Breakfast for 2 adults",
      ],
      validity: "Available for celebration bookings year-round",
    },
  ];
}

function offerCheckoutHref(offer, stay = {}) {
  const params = new URLSearchParams();
  params.set("reset", "1");
  params.set("locked", "1");
  params.set("room", offer.room || offer.recommendedRoom || "Deluxe Room");

  if (stay.checkin) params.set("checkin", stay.checkin);
  if (stay.checkout) params.set("checkout", stay.checkout);
  if (Number.isFinite(Number(stay.adults)) && Number(stay.adults) > 0) params.set("adults", Number(stay.adults));
  if (Number.isFinite(Number(stay.children)) && Number(stay.children) >= 0) params.set("children", Number(stay.children));
  if (Number.isFinite(Number(stay.rooms)) && Number(stay.rooms) > 0) params.set("rooms", Number(stay.rooms));

  return `availability.html?${params.toString()}`;
}
