<?php
// Enable error reporting for smooth local testing
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. KASHMIR & NORTHERN PAKISTAN CURATED DESTINATIONS WITH LAT/LON FOR LIVE WEATHER
$default_images = [
    'Srinagar, Kashmir'     => 'https://images.unsplash.com/photo-1595815771614-ade9d652a65d?auto=format&fit=crop&w=1200&q=80',
    'Hunza Valley, PK'      => 'https://images.unsplash.com/photo-1586375300773-8384e3e4916f?auto=format&fit=crop&w=1200&q=80',
    'Gulmarg, Kashmir'      => 'https://images.unsplash.com/photo-1562670652-e5947bddb335?auto=format&fit=crop&w=1200&q=80',
    'Skardu Valley, PK'     => 'https://images.unsplash.com/photo-1609839331899-786d34e90863?auto=format&fit=crop&w=1200&q=80',
    'Pahalgam, Kashmir'     => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80'
];

$packages = [
    [
        'id' => 1,
        'package_name' => 'Dal Lake & Royal Shrines',
        'destination' => 'Srinagar, Jammu & Kashmir',
        'lat' => 34.0837,
        'lon' => 74.7973,
        'description' => 'Glide across tranquil lake waters in luxury houseboats with panoramic views of Hazratbal Shrine, Shankaracharya Hill, and snow-capped peaks.',
        'distance' => '520 km',
        'temp' => '16° C',
        'rating' => '4.95',
        'elevation' => '1,585m',
        'price' => 19999,
        'currency' => '₹',
        'image' => $default_images['Srinagar, Kashmir']
    ],
    [
        'id' => 2,
        'package_name' => 'Hunza Shangrila Expedition',
        'destination' => 'Hunza Valley, Gilgit-Baltistan',
        'lat' => 36.3167,
        'lon' => 74.6500,
        'description' => 'Surround yourself with 7,000m Karakoram peaks, ancient Baltit & Altit forts, turquoise Attabad Lake, and breathtaking apricot blooms.',
        'distance' => '740 km',
        'temp' => '12° C',
        'rating' => '4.98',
        'elevation' => '2,438m',
        'price' => 28500,
        'currency' => '₹',
        'image' => $default_images['Hunza Valley, PK']
    ],
    [
        'id' => 3,
        'package_name' => 'Gulmarg Snow Slopes & Gondola',
        'destination' => 'Gulmarg, Kashmir Valley',
        'lat' => 34.0484,
        'lon' => 74.3805,
        'description' => 'Ride Asia\'s highest cable car to Mount Apharwat. Experience world-class winter skiing, pine forest trails, and untouched snowscapes.',
        'distance' => '890 km',
        'temp' => '-2° C',
        'rating' => '4.89',
        'elevation' => '2,650m',
        'price' => 28999,
        'currency' => '₹',
        'image' => $default_images['Gulmarg, Kashmir']
    ],
    [
        'id' => 4,
        'package_name' => 'Skardu & Deosai Plains',
        'destination' => 'Skardu, Gilgit-Baltistan',
        'lat' => 35.2971,
        'lon' => 75.6333,
        'description' => 'Journey to the Land of Giants. Discover Shangrila Resort, Cold Desert Katpana, Upper Kachura Lake, and high-altitude alpine wildlife.',
        'distance' => '610 km',
        'temp' => '14° C',
        'rating' => '4.92',
        'elevation' => '2,228m',
        'price' => 32000,
        'currency' => '₹',
        'image' => $default_images['Skardu Valley, PK']
    ],
    [
        'id' => 5,
        'package_name' => 'Pahalgam Valley & Betaab Pass',
        'destination' => 'Pahalgam, Kashmir Valley',
        'lat' => 34.0161,
        'lon' => 75.3150,
        'description' => 'Explore the Valley of Shepherds, crystal-clear Lidder River streams, dense pine wilderness, and serene alpine meadows.',
        'distance' => '640 km',
        'temp' => '15° C',
        'rating' => '4.91',
        'elevation' => '2,130m',
        'price' => 24999,
        'currency' => '₹',
        'image' => $default_images['Pahalgam, Kashmir']
    ]
];

// 2. DATABASE FALLBACK HANDLER
$db_host = getenv('POSTGRES_HOST') ?: (getenv('DB_HOST') ?: 'db');
$db_name = getenv('POSTGRES_DB') ?: (getenv('DB_NAME') ?: 'traveldb');
$db_user = getenv('POSTGRES_USER') ?: (getenv('DB_USER') ?: 'traveluser');
$db_pass = getenv('POSTGRES_PASSWORD') ?: (getenv('DB_PASS') ?: 'travelpass');

if (extension_loaded('pdo_pgsql') || extension_loaded('pdo_mysql')) {
    try {
        $dsn = extension_loaded('pdo_pgsql') 
            ? "pgsql:host=$db_host;dbname=$db_name" 
            : "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

        $pdo = new PDO($dsn, $db_user, $db_pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 2
        ]);

        $stmt = $pdo->query("SELECT * FROM travel_packages ORDER BY id ASC");
        $db_raw = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($db_raw)) {
            $packages = [];
            foreach ($db_raw as $row) {
                $dest = $row['destination'] ?? 'Srinagar, Kashmir';
                $packages[] = [
                    'id' => $row['id'],
                    'package_name' => $row['package_name'] ?? 'Paradise Tour',
                    'destination' => $dest,
                    'lat' => $row['lat'] ?? 34.0837,
                    'lon' => $row['lon'] ?? 74.7973,
                    'description' => $row['description'] ?? 'Exclusive luxury mountain escape.',
                    'distance' => $row['distance'] ?? '500 km',
                    'temp' => $row['temp'] ?? '16° C',
                    'rating' => $row['rating'] ?? '4.9',
                    'elevation' => $row['elevation'] ?? '1,800m',
                    'price' => $row['price'] ?? 21000,
                    'currency' => '₹',
                    'image' => $default_images[$dest] ?? $default_images['Srinagar, Kashmir']
                ];
            }
        }
    } catch (Exception $e) {
        // Fallback gracefully
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dar us safar | Official Responsive Paradise Expeditions</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts & FontAwesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        html, body {
            max-width: 100vw;
            overflow-x: hidden;
            background-color: #060911;
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            touch-action: manipulation;
        }

        /* GORGEOUS CINEMATIC MOUNTAIN COVER BACKGROUND */
        .scenic-bg {
            background-image: 
                linear-gradient(180deg, rgba(6, 9, 17, 0.75) 0%, rgba(10, 15, 26, 0.55) 50%, rgba(6, 9, 17, 0.98) 100%),
                url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=2560&q=90');
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
        }

        .font-serif-title {
            font-family: 'Playfair Display', serif;
        }

        /* Glassmorphism Panel */
        .glass-panel {
            background: rgba(15, 23, 42, 0.72);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.14);
        }

        /* 3D Coverflow Container */
        .coverflow-viewport {
            perspective: 1000px;
            perspective-origin: 50% 50%;
            touch-action: pan-y;
        }

        .coverflow-track {
            transform-style: preserve-3d;
            transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);
        }

        /* Fluid 3D Responsive Card Dimensions */
        .card-3d {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 280px;
            transform-style: preserve-3d;
            transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
            user-select: none;
            -webkit-user-select: none;
        }

        @media (min-width: 380px) {
            .card-3d { width: 310px; }
        }

        @media (min-width: 640px) {
            .card-3d { width: 340px; }
        }

        .card-inner {
            background: #ffffff;
            color: #111827;
            border-radius: 1.75rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.85);
            overflow: hidden;
            transition: box-shadow 0.4s ease;
        }

        .card-desc {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Live Indicator Pulse Animation */
        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.2); opacity: 0.4; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }
        .live-pulse {
            animation: pulse-ring 2s infinite ease-in-out;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #060911; }
        ::-webkit-scrollbar-thumb { background: #2563eb; border-radius: 3px; }
    </style>
</head>
<body class="min-h-screen scenic-bg flex flex-col justify-between selection:bg-blue-500 selection:text-white">

    <!-- TOP OFFICIAL CONTACT BAR -->
    <div class="bg-slate-950/90 backdrop-blur-md border-b border-white/10 text-[11px] sm:text-xs py-2 px-4 sm:px-6 text-gray-300 z-50">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2 sm:gap-4">
            <div class="flex items-center gap-4 sm:gap-6">
                <!-- DIRECT PHONE LINK -->
                <a href="tel:+919906898620" class="hover:text-blue-400 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-phone text-blue-400"></i>
                    <span>+91 99068 98620</span>
                </a>
                <!-- DIRECT EMAIL LINK -->
                <a href="mailto:darusafar@gmail.com" class="hover:text-blue-400 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-envelope text-blue-400"></i>
                    <span>darusafar@gmail.com</span>
                </a>
            </div>

            <div class="flex items-center gap-3 sm:gap-5 ml-auto">
                <!-- Internet Live Sync Status Badge -->
                <div id="net-status-badge" class="flex items-center gap-1.5 bg-slate-900/80 px-2.5 py-1 rounded-full border border-white/10 text-[10px]">
                    <span id="net-status-dot" class="w-2 h-2 rounded-full bg-emerald-400 live-pulse"></span>
                    <span id="net-status-text" class="text-emerald-400 font-bold uppercase tracking-wider">Live Weather Active</span>
                </div>

                <div class="flex items-center gap-1.5 border-l border-white/10 pl-3">
                    <i class="fa-solid fa-earth-americas text-gray-400"></i>
                    <select id="currency-select" onchange="convertCurrency()" class="bg-transparent text-gray-300 focus:outline-none cursor-pointer text-xs">
                        <option value="INR" class="bg-slate-900 text-white">INR (₹)</option>
                        <option value="USD" class="bg-slate-900 text-white">USD ($)</option>
                        <option value="EUR" class="bg-slate-900 text-white">EUR (€)</option>
                        <option value="PKR" class="bg-slate-900 text-white">PKR (Rs)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN HEADER NAVIGATION -->
    <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between z-50">
        <a href="#" class="flex items-center gap-2.5 sm:gap-3">
            <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-tr from-blue-700 to-indigo-500 flex items-center justify-center text-white shadow-xl shadow-blue-600/40 shrink-0">
                <i class="fa-solid fa-mountain-sun text-lg sm:text-2xl"></i>
            </div>
            <div>
                <span class="text-xl sm:text-2xl font-extrabold tracking-widest uppercase font-serif-title text-white block leading-none">
                    Dar us safar
                </span>
                <span class="text-[9px] sm:text-[10px] tracking-widest text-blue-400 uppercase font-bold">Paradise Expeditions</span>
            </div>
        </a>

        <!-- Trust Rating Badge -->
        <div class="hidden lg:flex items-center gap-3 glass-panel px-4 py-2 rounded-full border border-white/10">
            <div class="flex text-amber-400 text-xs">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
            </div>
            <span class="text-xs font-bold text-white">4.95 / 5.0</span>
            <span class="text-[11px] text-gray-400 border-l border-white/20 pl-2">1,580+ Expeditions Completed</span>
        </div>

        <div class="flex items-center gap-2 sm:gap-3">
            <a href="#contact" class="bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold px-4 sm:px-6 py-2.5 sm:py-3 rounded-full shadow-lg shadow-blue-600/30 transition transform hover:-translate-y-0.5 whitespace-nowrap">
                Concierge Booking
            </a>
        </div>
    </header>

    <!-- INTERACTIVE EXPEDITION SEARCH & FILTER BAR -->
    <section class="max-w-5xl mx-auto px-4 sm:px-6 my-2 z-40 w-full">
        <div class="glass-panel rounded-2xl p-3 sm:p-4 shadow-2xl">
            <form onsubmit="alert('Searching mountain expeditions...'); return false;" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-2.5 sm:gap-3 items-center">
                <div class="bg-slate-900/80 rounded-xl p-2.5 border border-white/10">
                    <label class="block text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase tracking-wider">Destination</label>
                    <select class="w-full bg-transparent text-xs font-bold text-white focus:outline-none cursor-pointer mt-0.5">
                        <option class="bg-slate-900">All Mountain Regions</option>
                        <option class="bg-slate-900">Srinagar & Dal Lake</option>
                        <option class="bg-slate-900">Hunza & Attabad Lake</option>
                        <option class="bg-slate-900">Gulmarg Ski Slopes</option>
                        <option class="bg-slate-900">Skardu & Deosai</option>
                    </select>
                </div>

                <div class="bg-slate-900/80 rounded-xl p-2.5 border border-white/10">
                    <label class="block text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase tracking-wider">Travel Month</label>
                    <input type="month" value="2026-11" class="w-full bg-transparent text-xs font-bold text-white focus:outline-none mt-0.5">
                </div>

                <div class="bg-slate-900/80 rounded-xl p-2.5 border border-white/10">
                    <label class="block text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase tracking-wider">Expedition Style</label>
                    <select class="w-full bg-transparent text-xs font-bold text-white focus:outline-none cursor-pointer mt-0.5">
                        <option class="bg-slate-900">Luxury Alpine Resort</option>
                        <option class="bg-slate-900">High Peak Trekking</option>
                        <option class="bg-slate-900">Romantic Valley Getaway</option>
                    </select>
                </div>

                <button type="submit" class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold rounded-xl py-3 text-xs tracking-wider uppercase transition flex items-center justify-center gap-2 shadow-lg">
                    <i class="fa-solid fa-compass"></i>
                    <span>Find Expedition</span>
                </button>
            </form>
        </div>
    </section>

    <!-- MAIN 3D COVERFLOW SECTION -->
    <main class="relative w-full my-auto py-4 sm:py-6 flex flex-col items-center justify-center min-h-[500px] sm:min-h-[560px]">
        
        <!-- Live Alpine Satellite Weather Widget -->
        <div class="absolute top-0 right-4 sm:right-8 z-30 hidden lg:flex items-center gap-3 glass-panel px-4 py-2 rounded-2xl text-xs">
            <div id="weather-icon-container" class="w-8 h-8 rounded-full bg-blue-500/20 border border-blue-400/30 flex items-center justify-center text-amber-400 text-base">
                <i class="fa-solid fa-sun animate-spin-slow"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span id="active-weather" class="font-extrabold text-white block">Srinagar: Fetching...</span>
                    <span id="live-weather-badge" class="bg-emerald-500/20 text-emerald-300 text-[9px] font-bold px-1.5 py-0.5 rounded border border-emerald-400/30">ONLINE METEO</span>
                </div>
                <span id="active-elevation" class="text-[10px] text-blue-300">Elevation: 1,585m</span>
            </div>
        </div>

        <!-- 3D Card Slider Viewport -->
        <div class="coverflow-viewport w-full h-[460px] sm:h-[500px] relative flex items-center justify-center" id="touch-viewport">
            <div id="coverflow-track" class="coverflow-track w-full h-full relative">
                <?php foreach ($packages as $index => $pkg): ?>
                    <div class="card-3d cursor-pointer" id="card-<?php echo $index; ?>" onclick="selectCard(<?php echo $index; ?>)">
                        <div class="card-inner p-3.5 sm:p-4 flex flex-col justify-between">
                            
                            <!-- Card Image Banner -->
                            <div class="relative h-44 sm:h-52 w-full rounded-2xl overflow-hidden mb-3">
                                <img src="<?php echo htmlspecialchars($pkg['image']); ?>" alt="<?php echo htmlspecialchars($pkg['package_name']); ?>" class="w-full h-full object-cover">
                                <span class="absolute top-2.5 left-2.5 bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-bold px-2.5 py-1 rounded-full border border-white/20">
                                    <i class="fa-solid fa-mountain text-amber-400 mr-1"></i> <?php echo $pkg['elevation']; ?>
                                </span>
                            </div>

                            <!-- Card Title & Location -->
                            <div class="px-1.5 space-y-1">
                                <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight leading-snug">
                                    <?php echo htmlspecialchars($pkg['package_name']); ?>
                                </h3>
                                <div class="flex items-center gap-1.5 text-xs text-blue-700 font-bold">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span class="truncate"><?php echo htmlspecialchars($pkg['destination']); ?></span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="px-1.5 mt-2">
                                <p class="text-[11px] font-medium text-gray-500 leading-relaxed card-desc">
                                    <?php echo htmlspecialchars($pkg['description']); ?>
                                </p>
                            </div>

                            <!-- Metrics Data Bar -->
                            <div class="grid grid-cols-3 gap-1 my-2.5 px-1 text-center border-t border-b border-gray-100 py-2">
                                <div>
                                    <span class="block text-[9px] uppercase tracking-wider font-bold text-gray-400">Distance</span>
                                    <span class="text-xs font-extrabold text-blue-600"><?php echo htmlspecialchars($pkg['distance']); ?></span>
                                </div>
                                <div>
                                    <span class="block text-[9px] uppercase tracking-wider font-bold text-gray-400">Live Temp</span>
                                    <span id="card-temp-<?php echo $index; ?>" class="text-xs font-extrabold text-emerald-600"><?php echo htmlspecialchars($pkg['temp']); ?></span>
                                </div>
                                <div>
                                    <span class="block text-[9px] uppercase tracking-wider font-bold text-gray-400">Rating</span>
                                    <span class="text-xs font-extrabold text-blue-600">★ <?php echo htmlspecialchars($pkg['rating']); ?></span>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="flex items-center justify-between px-1.5 pt-0.5 pb-0.5">
                                <div>
                                    <span class="block text-[9px] uppercase tracking-wider font-bold text-gray-400">Package Rate</span>
                                    <span id="card-price-<?php echo $index; ?>" class="text-base sm:text-lg font-extrabold text-gray-900">
                                        <?php echo $pkg['currency'] . number_format($pkg['price']); ?>
                                    </span>
                                </div>

                                <button onclick="openBookingModal('<?php echo addslashes($pkg['package_name']); ?>'); event.stopPropagation();" 
                                        class="w-10 h-10 sm:w-11 sm:h-11 bg-slate-950 hover:bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg transition transform hover:scale-110 active:scale-95">
                                    <i class="fa-solid fa-plane-departure text-xs"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Slider Arrow Controls & Dots -->
        <div class="flex items-center gap-4 sm:gap-6 mt-2 sm:mt-4 z-40">
            <button onclick="prevCard()" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full glass-panel hover:bg-white/20 text-white flex items-center justify-center transition active:scale-95 shadow-2xl">
                <i class="fa-solid fa-chevron-left text-xs sm:text-sm"></i>
            </button>
            
            <div id="dots-container" class="flex items-center gap-1.5 sm:gap-2">
                <?php foreach ($packages as $index => $pkg): ?>
                    <span onclick="selectCard(<?php echo $index; ?>)" 
                          id="dot-<?php echo $index; ?>" 
                          class="cursor-pointer h-2 rounded-full transition-all duration-300 bg-white/30 w-2"></span>
                <?php endforeach; ?>
            </div>

            <button onclick="nextCard()" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full glass-panel hover:bg-white/20 text-white flex items-center justify-center transition active:scale-95 shadow-2xl">
                <i class="fa-solid fa-chevron-right text-xs sm:text-sm"></i>
            </button>
        </div>

    </main>

    <!-- FLOATING DIRECT WHATSAPP DM BUTTON (CONNECTED TO YOUR WHATSAPP +919906898620) -->
    <a href="https://wa.me/919906898620?text=Hello%20Dar%20us%20safar,%20I%20would%20like%20to%20inquire%20about%20a%20tour%20package." 
       target="_blank" 
       rel="noopener noreferrer"
       class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50 bg-emerald-500 hover:bg-emerald-600 text-white p-3 sm:px-5 sm:py-3 rounded-full shadow-2xl flex items-center gap-2.5 transition transform hover:scale-105 border border-emerald-400/30">
        <i class="fa-brands fa-whatsapp text-xl sm:text-2xl"></i>
        <span class="text-xs font-bold hidden sm:inline">WhatsApp Concierge</span>
    </a>

    <!-- RESPONSIVE FOOTER -->
    <footer id="contact" class="w-full bg-slate-950/95 border-t border-white/10 pt-10 pb-6 px-4 sm:px-6 text-xs text-gray-400 z-40 mt-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <div class="space-y-3">
                <span class="text-lg font-bold font-serif-title text-white">Dar us safar</span>
                <p class="text-gray-400 leading-relaxed">
                    Bespoke luxury travel management for Kashmir, Hunza Valley, and Northern Himalayan sanctuaries.
                </p>
                <div class="space-y-1">
                    <p class="text-emerald-400 font-semibold"><i class="fa-solid fa-shield-halved mr-1"></i> Licensed Operator #JKT-8842</p>
                    <p class="text-gray-300"><i class="fa-solid fa-envelope text-blue-400 mr-1.5"></i> darusafar@gmail.com</p>
                    <p class="text-gray-300">
                        <a href="https://wa.me/919906898620" target="_blank" class="hover:text-emerald-400 transition">
                            <i class="fa-brands fa-whatsapp text-emerald-400 mr-1.5"></i> +91 99068 98760
                        </a>
                    </p>
                </div>
            </div>

            <div>
                <h4 class="text-white font-bold uppercase tracking-wider mb-3">Popular Expeditions</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-blue-400 transition">Dal Lake Luxury Houseboats</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Gulmarg Gondola Skiing</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Hunza Valley & Attabad Lake</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Skardu Deosai Sanctuary</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold uppercase tracking-wider mb-3">Official Support</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-blue-400 transition">Permits & Mountain Guidelines</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Private Helicopter Charters</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Live Weather Advisory</a></li>
                    <li><a href="tel:+9906898620" class="hover:text-blue-400 transition">24/7 Helpline</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold uppercase tracking-wider mb-3">VIP Expeditions Dispatch</h4>
                <p class="mb-3">Subscribe for exclusive seasonal offers and private villa releases.</p>
                <form onsubmit="alert('Thank you for subscribing to Dar us safar!'); return false;" class="flex">
                    <input type="email" placeholder="darusafar@gmail.com" required class="bg-slate-900 border border-slate-700 rounded-l-lg px-3 py-2 text-white w-full focus:outline-none">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold px-4 rounded-r-lg transition">Join</button>
                </form>
            </div>
        </div>

        <div class="max-w-7xl mx-auto border-t border-white/10 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-[11px] text-gray-500 text-center sm:text-left">
            <p>&copy; <?php echo date('Y'); ?> Dar us safar. All rights reserved.</p>
            <p class="hidden sm:block">Swipe cards or use arrow keys <kbd class="px-1.5 py-0.5 bg-white/10 rounded font-mono text-gray-300">←</kbd> <kbd class="px-1.5 py-0.5 bg-white/10 rounded font-mono text-gray-300">→</kbd> to browse</p>
        </div>
    </footer>

    <!-- RESPONSIVE BOOKING MODAL -->
    <div id="booking-modal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-md flex items-center justify-center p-4">
        <div class="glass-panel w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-2xl p-5 sm:p-8 relative">
            <button onclick="closeBookingModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white text-xl p-2">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <h3 class="text-xl sm:text-2xl font-bold font-serif-title text-white mb-1">Reserve Experience</h3>
            <p class="text-xs text-gray-400 mb-5">Our travel concierge will respond to your WhatsApp or email within 2 hours.</p>

            <form onsubmit="alert('Inquiry registered! Our team will send details to your contact.'); closeBookingModal(); return false;" class="space-y-3.5">
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-300 mb-1">Selected Destination</label>
                    <input type="text" id="modal-pkg-name" readonly class="w-full bg-white/10 border border-white/20 rounded-lg px-3.5 py-2 sm:py-2.5 text-xs sm:text-sm text-blue-300 font-bold">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-300 mb-1">Full Name</label>
                    <input type="text" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3.5 py-2 sm:py-2.5 text-xs sm:text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Rahul Sharma / Ali Khan">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-300 mb-1">Email Address</label>
                    <input type="email" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3.5 py-2 sm:py-2.5 text-xs sm:text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="yourname@gmail.com">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-300 mb-1">WhatsApp Number</label>
                    <input type="tel" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3.5 py-2 sm:py-2.5 text-xs sm:text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="+91 99068 98760">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-300 mb-1">Custom Requests / Guest Count</label>
                    <textarea rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3.5 py-2 sm:py-2.5 text-xs sm:text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Houseboat preferences, helicopter transfers..."></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-2.5 sm:py-3 rounded-lg text-xs sm:text-sm shadow-lg transition">
                    Submit Concierge Request
                </button>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT ENGINE: RESPONSIVE MATH, LIVE SATELLITE WEATHER API, AND TOUCH SWIPES -->
    <script>
        const packages = <?php echo json_encode($packages); ?>;
        const totalCards = packages.length;
        let activeIndex = 0;
        let liveWeatherData = {};

        // WMO WEATHER CODES MAPPING TO ICON & CONDITION DESCRIPTION
        function decodeWmoCode(code) {
            if (code === 0) return { text: 'Clear Sky', icon: 'fa-sun text-amber-400' };
            if (code >= 1 && code <= 3) return { text: 'Partly Cloudy', icon: 'fa-cloud-sun text-amber-300' };
            if (code === 45 || code === 48) return { text: 'Foggy Mist', icon: 'fa-smog text-gray-300' };
            if (code >= 51 && code <= 67) return { text: 'Rain Showers', icon: 'fa-cloud-showers-heavy text-blue-400' };
            if (code >= 71 && code <= 86) return { text: 'Snowfall', icon: 'fa-snowflake text-cyan-200' };
            if (code >= 95) return { text: 'Thunderstorm', icon: 'fa-cloud-bolt text-amber-500' };
            return { text: 'Alpine Breeze', icon: 'fa-wind text-blue-300' };
        }

        // FETCH REAL LIVE WEATHER VIA OPEN-METEO API WHEN INTERNET IS CONNECTED
        async function fetchLiveWeatherForPackage(index) {
            const pkg = packages[index];
            if (!navigator.onLine) {
                updateOnlineStatusUI(false);
                return;
            }

            try {
                const response = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${pkg.lat}&longitude=${pkg.lon}&current_weather=true`);
                if (!response.ok) throw new Error('Network weather response error');

                const data = await response.json();
                if (data && data.current_weather) {
                    const temp = Math.round(data.current_weather.temperature);
                    const code = data.current_weather.weathercode;
                    const condition = decodeWmoCode(code);

                    const formattedTemp = `${temp}° C`;
                    liveWeatherData[index] = { temp: formattedTemp, condition: condition };

                    // Update UI card temp element
                    const cardTempEl = document.getElementById(`card-temp-${index}`);
                    if (cardTempEl) cardTempEl.innerText = formattedTemp;

                    // Update widget if active
                    if (index === activeIndex) {
                        updateWeatherWidget(pkg.destination.split(',')[0], formattedTemp, condition, pkg.elevation);
                    }
                    updateOnlineStatusUI(true);
                }
            } catch (err) {
                console.warn("Weather sync fallback to cached data:", err);
                updateOnlineStatusUI(false);
            }
        }

        function updateWeatherWidget(city, tempStr, condition, elevation) {
            const weatherEl = document.getElementById('active-weather');
            const elevEl = document.getElementById('active-elevation');
            const iconContainer = document.getElementById('weather-icon-container');

            if (weatherEl) weatherEl.innerText = `${city}: ${tempStr} ${condition.text}`;
            if (elevEl) elevEl.innerText = `Elevation: ${elevation}`;
            if (iconContainer) {
                iconContainer.innerHTML = `<i class="fa-solid ${condition.icon}"></i>`;
            }
        }

        function updateOnlineStatusUI(isOnline) {
            const statusDot = document.getElementById('net-status-dot');
            const statusText = document.getElementById('net-status-text');

            if (isOnline) {
                if (statusDot) statusDot.className = "w-2 h-2 rounded-full bg-emerald-400 live-pulse";
                if (statusText) {
                    statusText.innerText = "Live Weather Sync Active";
                    statusText.className = "text-emerald-400 font-bold uppercase tracking-wider";
                }
            } else {
                if (statusDot) statusDot.className = "w-2 h-2 rounded-full bg-amber-400";
                if (statusText) {
                    statusText.innerText = "Offline Mode (Cached)";
                    statusText.className = "text-amber-400 font-bold uppercase tracking-wider";
                }
            }
        }

        function getCardWidth() {
            const screenWidth = window.innerWidth;
            if (screenWidth < 380) return 280;
            if (screenWidth < 640) return 310;
            return 340;
        }

        function update3DPositions() {
            const screenWidth = window.innerWidth;
            const cardWidth = getCardWidth();
            
            let spacingRatio = 0.72;
            if (screenWidth < 640) spacingRatio = 0.52;
            else if (screenWidth < 1024) spacingRatio = 0.62;

            const spacing = cardWidth * spacingRatio;

            for (let i = 0; i < totalCards; i++) {
                const card = document.getElementById(`card-${i}`);
                const dot = document.getElementById(`dot-${i}`);
                const offset = i - activeIndex;

                if (offset === 0) {
                    card.style.transform = `translate3d(-50%, -50%, 0px) rotateY(0deg) scale(1)`;
                    card.style.opacity = '1';
                    card.style.zIndex = '30';
                    card.style.filter = 'blur(0px)';
                    card.style.pointerEvents = 'auto';

                    if (dot) dot.className = "cursor-pointer h-2 rounded-full transition-all duration-300 bg-blue-500 w-8";

                    // Trigger Live Weather update for active card
                    fetchLiveWeatherForPackage(i);

                } else if (offset < 0) {
                    const distance = Math.abs(offset);
                    const translateX = -50 + (offset * (spacing / cardWidth) * 100);
                    const translateZ = -100 * distance;
                    const rotateY = Math.min(22, 10 * distance);

                    card.style.transform = `translate3d(${translateX}%, -50%, ${translateZ}px) rotateY(${rotateY}deg) scale(${Math.max(0.72, 1 - distance * 0.12)})`;
                    card.style.opacity = distance > 2 ? '0' : '0.6';
                    card.style.zIndex = `${30 - distance}`;
                    card.style.filter = 'blur(1px)';

                    if (dot) dot.className = "cursor-pointer h-2 rounded-full transition-all duration-300 bg-white/30 w-2";
                } else {
                    const distance = Math.abs(offset);
                    const translateX = -50 + (offset * (spacing / cardWidth) * 100);
                    const translateZ = -100 * distance;
                    const rotateY = -Math.min(22, 10 * distance);

                    card.style.transform = `translate3d(${translateX}%, -50%, ${translateZ}px) rotateY(${rotateY}deg) scale(${Math.max(0.72, 1 - distance * 0.12)})`;
                    card.style.opacity = distance > 2 ? '0' : '0.6';
                    card.style.zIndex = `${30 - distance}`;
                    card.style.filter = 'blur(1px)';

                    if (dot) dot.className = "cursor-pointer h-2 rounded-full transition-all duration-300 bg-white/30 w-2";
                }
            }
        }

        // CURRENCY CONVERTER CALCULATOR
        function convertCurrency() {
            const selected = document.getElementById('currency-select').value;
            let rates = { 'INR': { symbol: '₹', factor: 1 }, 'USD': { symbol: '$', factor: 0.012 }, 'EUR': { symbol: '€', factor: 0.011 }, 'PKR': { symbol: 'Rs', factor: 3.35 } };
            const curr = rates[selected] || rates['INR'];

            packages.forEach((pkg, idx) => {
                const el = document.getElementById(`card-price-${idx}`);
                if (el) {
                    const converted = Math.round(pkg.price * curr.factor);
                    el.innerText = `${curr.symbol} ${converted.toLocaleString()}`;
                }
            });
        }

        function selectCard(index) {
            activeIndex = index;
            update3DPositions();
        }

        function nextCard() {
            activeIndex = (activeIndex < totalCards - 1) ? activeIndex + 1 : 0;
            update3DPositions();
        }

        function prevCard() {
            activeIndex = (activeIndex > 0) ? activeIndex - 1 : totalCards - 1;
            update3DPositions();
        }

        function openBookingModal(pkgName) {
            document.getElementById('modal-pkg-name').value = pkgName;
            document.getElementById('booking-modal').classList.remove('hidden');
        }

        function closeBookingModal() {
            document.getElementById('booking-modal').classList.add('hidden');
        }

        // SWIPE GESTURE SUPPORT FOR MOBILE SMARTPHONES
        let touchStartX = 0;
        let touchEndX = 0;
        const viewport = document.getElementById('touch-viewport');

        viewport.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        viewport.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });

        function handleSwipe() {
            if (touchEndX < touchStartX - 30) nextCard();
            if (touchEndX > touchStartX + 30) prevCard();
        }

        // KEYBOARD ARROW CONTROLS
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') nextCard();
            if (e.key === 'ArrowLeft') prevCard();
            if (e.key === 'Escape') closeBookingModal();
        });

        // NETWORK ONLINE/OFFLINE EVENT LISTENERS
        window.addEventListener('online', () => {
            updateOnlineStatusUI(true);
            fetchLiveWeatherForPackage(activeIndex);
        });

        window.addEventListener('offline', () => {
            updateOnlineStatusUI(false);
        });

        // INITIALIZE SLIDER
        window.addEventListener('load', () => {
            update3DPositions();
            // Pre-fetch live weather for all destinations in background
            packages.forEach((_, idx) => fetchLiveWeatherForPackage(idx));
        });
        window.addEventListener('resize', update3DPositions);
    </script>
</body>
</html>
