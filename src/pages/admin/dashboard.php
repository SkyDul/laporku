<?php
require_once __DIR__ . '/../../../src/config/database.php';
require_once __DIR__ . '/../../../src/helpers/auth.php';

requireAdmin();

$db = getDB();

// Fetch stats
$stmt = $db->query("SELECT status, COUNT(*) as count FROM pengaduan GROUP BY status");
$statsRaw = $stmt->fetchAll();
$stats = ['Diterima' => 0, 'Diproses' => 0, 'Selesai' => 0];
$total = 0;
foreach ($statsRaw as $row) {
    $stats[$row['status']] = $row['count'];
    $total += $row['count'];
}

// Fetch recent reports
$stmt = $db->query("SELECT * FROM pengaduan ORDER BY created_at DESC LIMIT 10");
$reports = $stmt->fetchAll();
?>
<!DOCTYPE html>

<html lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Dashboard - LaporKu</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary-fixed-variant": "#3f484f",
                        "outline-variant": "#c2c6d1",
                        "surface-container-low": "#f3f3f9",
                        "primary-fixed-dim": "#a6c8ff",
                        "on-primary-fixed": "#001c3a",
                        "tertiary-container": "#793f00",
                        "surface-container-high": "#e8e8ed",
                        "on-secondary-fixed": "#141d23",
                        "tertiary-fixed-dim": "#ffb77e",
                        "surface": "#f9f9ff",
                        "surface-dim": "#d9d9df",
                        "on-secondary-container": "#5b646b",
                        "outline": "#737781",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#00386b",
                        "on-tertiary-fixed": "#2f1500",
                        "secondary-fixed-dim": "#bfc8d0",
                        "on-secondary": "#ffffff",
                        "inverse-on-surface": "#f0f0f6",
                        "on-background": "#1a1c20",
                        "on-tertiary-fixed-variant": "#6e3900",
                        "secondary-container": "#d8e1ea",
                        "inverse-surface": "#2e3035",
                        "on-tertiary": "#ffffff",
                        "error-container": "#ffdad6",
                        "on-error": "#ffffff",
                        "on-surface-variant": "#424750",
                        "tertiary-fixed": "#ffdcc3",
                        "surface-bright": "#f9f9ff",
                        "secondary-fixed": "#dbe4ed",
                        "surface-container-highest": "#e2e2e8",
                        "error": "#ba1a1a",
                        "on-tertiary-container": "#ffae6b",
                        "on-surface": "#1a1c20",
                        "surface-container": "#ededf3",
                        "tertiary": "#582c00",
                        "primary-container": "#1b4f8a",
                        "on-error-container": "#93000a",
                        "surface-variant": "#e2e2e8",
                        "inverse-primary": "#a6c8ff",
                        "surface-tint": "#305f9b",
                        "on-primary-container": "#9ac2ff",
                        "on-primary": "#ffffff",
                        "background": "#f9f9ff",
                        "primary-fixed": "#d4e3ff",
                        "on-primary-fixed-variant": "#0e4782",
                        "secondary": "#575f67"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "xs": "8px",
                        "sm": "16px",
                        "xl": "48px",
                        "gutter": "24px",
                        "base": "4px",
                        "container-max": "1200px",
                        "lg": "32px",
                        "xxl": "64px",
                        "md": "24px"
                    },
                    "fontFamily": {
                        "h1": ["Plus Jakarta Sans"],
                        "body-sm": ["Plus Jakarta Sans"],
                        "body-lg": ["Plus Jakarta Sans"],
                        "display": ["Plus Jakarta Sans"],
                        "h2": ["Plus Jakarta Sans"],
                        "h3": ["Plus Jakarta Sans"],
                        "body-md": ["Plus Jakarta Sans"],
                        "caption": ["Plus Jakarta Sans"],
                        "label": ["Plus Jakarta Sans"]
                    },
                    "fontSize": {
                        "h1": ["32px", { "lineHeight": "1.3", "fontWeight": "700" }],
                        "body-sm": ["14px", { "lineHeight": "1.5", "fontWeight": "400" }],
                        "body-lg": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }],
                        "display": ["40px", { "lineHeight": "1.2", "fontWeight": "700" }],
                        "h2": ["24px", { "lineHeight": "1.4", "fontWeight": "600" }],
                        "h3": ["20px", { "lineHeight": "1.4", "fontWeight": "600" }],
                        "body-md": ["16px", { "lineHeight": "1.6", "fontWeight": "400" }],
                        "caption": ["12px", { "lineHeight": "1.2", "fontWeight": "500" }],
                        "label": ["14px", { "lineHeight": "1.2", "letterSpacing": "0.02em", "fontWeight": "600" }]
                    }
                }
            }
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md min-h-screen flex flex-col md:flex-row">
<!-- TopNavBar (Mobile Only) -->
<header class="md:hidden bg-surface-container-lowest text-[#1B4F8A] font-label font-semibold fixed top-0 w-full z-50 flex justify-between items-center px-sm h-16 border-b border-surface-variant shadow-[0_2px_4px_rgba(0,0,0,0.04)]">
<div class="text-h3 font-h3 font-bold tracking-tight">LaporKu</div>
<div class="flex gap-sm">
<button class="text-label font-label text-slate-600 hover:text-[#1B4F8A] transition-colors duration-300 cursor-pointer active:opacity-80">Masuk</button>
</div>
</header>
<!-- SideNavBar (Desktop) -->
<nav class="hidden md:flex flex-col fixed left-0 top-0 h-full py-md w-64 border-r border-surface-variant bg-surface-container-lowest text-[#1B4F8A] font-label z-50">
<div class="px-md mb-xl">
<div class="text-h2 font-h2 font-black text-[#1B4F8A] mb-lg">LaporKu</div>
<div class="flex items-center gap-sm">
<img alt="Foto Profil Pengguna" class="w-12 h-12 rounded-full" data-alt="A professional headshot avatar for a user profile in a civic modernism design. The image features a solid, rich deep blue background, reflecting the primary brand color. A clear, crisp white monogram 'W' is centered, conveying trust and clarity in a clean, brightly lit, and structured interface setting." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBoQXyEKBbYB3BbQWbwJygTEonyXMF8tdxtWDSGqZKK923Pwb_AaoKeCPWIj1BFUltSPEl00gqhFERImwwknd-net1sTy33Y4OBjZ3XvV4_6EI13SDDbtcw3uC4nH4kfUkSMcd4jgWlX2pxPNbo1pYcSu_bv8-HYd6OPx6Js-leMOuWNvT5RrqCz01eWQXQ8wY9suUIvjnPHpzahJKa7dcxOa7JczY1hdICBOknbOemGK5rUHO8o7UPH1G0QPUNcTyIK9nTnFL-Fw"/>
<div>
<div class="font-h3 text-h3 text-on-surface">Halo, Admin!</div>
<div class="font-caption text-caption text-on-surface-variant"><a href="?page=logout" class="text-error hover:underline">Keluar</a></div>
</div>
</div>
</div>
<div class="flex flex-col gap-base px-sm">
<!-- Active Tab: Dashboard -->
<a class="flex items-center gap-sm px-sm py-xs bg-blue-50 text-[#1B4F8A] font-bold border-r-4 border-[#1B4F8A] transition-all duration-200 ease-in-out cursor-pointer" href="#">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
<span>Dashboard</span>
</a>
<!-- Inactive Tabs -->
<a class="flex items-center gap-sm px-sm py-xs text-slate-500 hover:bg-slate-50 transition-all duration-200 ease-in-out cursor-pointer" href="#">
<span class="material-symbols-outlined">description</span>
<span>Laporan Saya</span>
</a>
<a class="flex items-center gap-sm px-sm py-xs text-slate-500 hover:bg-slate-50 transition-all duration-200 ease-in-out cursor-pointer" href="#">
<span class="material-symbols-outlined">add_circle</span>
<span>Buat Laporan</span>
</a>
<a class="flex items-center gap-sm px-sm py-xs text-slate-500 hover:bg-slate-50 transition-all duration-200 ease-in-out cursor-pointer" href="#">
<span class="material-symbols-outlined">notifications</span>
<span>Notifikasi</span>
</a>
<a class="flex items-center gap-sm px-sm py-xs text-slate-500 hover:bg-slate-50 transition-all duration-200 ease-in-out cursor-pointer" href="#">
<span class="material-symbols-outlined">person</span>
<span>Profil</span>
</a>
</div>
</nav>
<!-- Main Canvas -->
<main class="flex-1 md:ml-64 pt-16 md:pt-0 p-sm md:p-gutter max-w-container-max mx-auto w-full pb-24 md:pb-gutter">
<!-- Header Section -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-xl gap-sm md:mt-lg">
<div>
<h1 class="font-h1 text-h1 text-on-surface mb-base">Dashboard</h1>
<p class="font-body-md text-body-md text-on-surface-variant">Ringkasan aktivitas dan laporan Anda.</p>
</div>
<a href="?page=home" class="bg-[#1B4F8A] hover:bg-[#143B66] text-white font-label text-label px-sm py-xs rounded-lg transition-colors duration-300 flex items-center gap-xs shadow-sm">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">home</span>
                Ke Beranda
            </a>
</div>
<!-- Stats Overview Bento Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-xl">
<!-- Total Laporan -->
<div class="bg-surface-container-lowest p-gutter rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.05)] border border-surface-variant flex flex-col justify-between h-32 relative overflow-hidden">
<div class="flex justify-between items-start z-10">
<span class="font-label text-label text-on-surface-variant">Total Laporan</span>
<span class="material-symbols-outlined text-[#1B4F8A]">folder</span>
</div>
<div class="font-display text-display text-on-surface z-10"><?php echo $total; ?></div>
<div class="absolute -bottom-4 -right-4 text-[#1B4F8A] opacity-5">
<span class="material-symbols-outlined" style="font-size: 100px;">folder</span>
</div>
</div>
<!-- Diproses -->
<div class="bg-surface-container-lowest p-gutter rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.05)] border border-surface-variant flex flex-col justify-between h-32 relative overflow-hidden">
<div class="flex justify-between items-start z-10">
<span class="font-label text-label text-on-surface-variant">Diproses</span>
<span class="material-symbols-outlined text-yellow-600">hourglass_empty</span>
</div>
<div class="font-display text-display text-on-surface z-10"><?php echo $stats['Diproses']; ?></div>
<div class="absolute -bottom-4 -right-4 text-yellow-600 opacity-5">
<span class="material-symbols-outlined" style="font-size: 100px;">hourglass_empty</span>
</div>
</div>
<!-- Selesai -->
<div class="bg-surface-container-lowest p-gutter rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.05)] border border-surface-variant flex flex-col justify-between h-32 relative overflow-hidden">
<div class="flex justify-between items-start z-10">
<span class="font-label text-label text-on-surface-variant">Selesai</span>
<span class="material-symbols-outlined text-green-600">check_circle</span>
</div>
<div class="font-display text-display text-on-surface z-10"><?php echo $stats['Selesai']; ?></div>
<div class="absolute -bottom-4 -right-4 text-green-600 opacity-5">
<span class="material-symbols-outlined" style="font-size: 100px;">check_circle</span>
</div>
</div>
</div>
<!-- Recent Reports List -->
<div class="bg-surface-container-lowest rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.05)] border border-surface-variant overflow-hidden">
<div class="p-gutter border-b border-surface-variant bg-surface-container-low">
<h2 class="font-h3 text-h3 text-on-surface">Laporan Terbaru</h2>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="border-b border-surface-variant bg-surface-container-low font-label text-label text-on-surface-variant">
<th class="p-sm">ID Laporan</th>
<th class="p-sm">Judul</th>
<th class="p-sm">Tanggal</th>
<th class="p-sm">Status</th>
<th class="p-sm text-right">Aksi</th>
</tr>
</thead>
<tbody class="font-body-sm text-body-sm text-on-surface">
<?php foreach($reports as $row): ?>
<tr class="border-b border-surface-variant hover:bg-surface-container-low transition-colors duration-200">
<td class="p-sm font-label">#<?php echo htmlspecialchars($row['nomor_tiket']); ?></td>
<td class="p-sm"><?php echo htmlspecialchars($row['judul']); ?></td>
<td class="p-sm text-on-surface-variant"><?php echo htmlspecialchars(date('d M Y', strtotime($row['created_at']))); ?></td>
<td class="p-sm">
<span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold <?php echo $row['status'] === 'Selesai' ? 'bg-green-100 text-green-800' : ($row['status'] === 'Diproses' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800'); ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
</td>
<td class="p-sm text-right">
<a href="?page=admin/detail-laporan&id=<?php echo $row['id']; ?>" class="text-[#1B4F8A] hover:underline font-label text-label">Detail</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<div class="p-sm border-t border-surface-variant bg-surface-container-lowest text-center">
<button class="text-[#1B4F8A] hover:underline font-label text-label">Lihat Semua Laporan</button>
</div>
</div>
</main>
<!-- BottomNavBar (Mobile Only) -->
<nav class="fixed bottom-0 w-full z-50 flex justify-around items-center h-16 md:hidden px-4 pb-safe bg-surface-container-lowest/90 backdrop-blur-md rounded-t-xl border-t border-surface-variant shadow-[0_-4px_12px_rgba(0,0,0,0.05)]">
<!-- Active Tab: Beranda maps to Dashboard intent -->
<a class="flex flex-col items-center justify-center text-[#1B4F8A] font-['Plus_Jakarta_Sans'] text-[10px] font-bold active:bg-slate-100 tap-highlight-transparent active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">home</span>
<span>Beranda</span>
</a>
<a class="flex flex-col items-center justify-center text-slate-400 font-['Plus_Jakarta_Sans'] text-[10px] font-bold active:bg-slate-100 tap-highlight-transparent active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined">history</span>
<span>Laporan</span>
</a>
<a class="flex flex-col items-center justify-center text-slate-400 font-['Plus_Jakarta_Sans'] text-[10px] font-bold active:bg-slate-100 tap-highlight-transparent active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined">notifications</span>
<span>Notif</span>
</a>
<a class="flex flex-col items-center justify-center text-slate-400 font-['Plus_Jakarta_Sans'] text-[10px] font-bold active:bg-slate-100 tap-highlight-transparent active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined">account_circle</span>
<span>Akun</span>
</a>
</nav>
</body></html>
