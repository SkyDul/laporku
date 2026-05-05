<?php
require_once __DIR__ . '/../../src/config/database.php';

$tiket = $_GET['tiket'] ?? '';
$pengaduan = null;
$lampiran = [];
$riwayat = [];

if ($tiket) {
    $db = getDB();
    
    // Get pengaduan
    $stmt = $db->prepare("SELECT * FROM pengaduan WHERE nomor_tiket = ?");
    $stmt->execute([$tiket]);
    $pengaduan = $stmt->fetch();
    
    if ($pengaduan) {
        // Get lampiran
        $stmtLamp = $db->prepare("SELECT * FROM lampiran WHERE pengaduan_id = ?");
        $stmtLamp->execute([$pengaduan['id']]);
        $lampiran = $stmtLamp->fetchAll();
        
        // Get riwayat
        $stmtRiw = $db->prepare("SELECT * FROM riwayat_status WHERE pengaduan_id = ? ORDER BY created_at DESC");
        $stmtRiw->execute([$pengaduan['id']]);
        $riwayat = $stmtRiw->fetchAll();
    }
}
?>
<!DOCTYPE html>

<html lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Cek Status Laporan - LaporKu</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        .material-symbols-outlined {
          font-variation-settings:
          'FILL' 0,
          'wght' 400,
          'GRAD' 0,
          'opsz' 24
        }
    </style>
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
</head>
<body class="bg-background text-on-background min-h-screen flex flex-col">
<!-- TopNavBar -->
<nav class="bg-surface-container-lowest fixed top-0 left-0 right-0 z-50 border-b border-surface-variant shadow-[0_2px_4px_rgba(0,0,0,0.04)]">
<div class="max-w-[1200px] mx-auto flex justify-between items-center px-6 md:px-12 h-16">
<div class="text-xl font-bold text-primary-container tracking-tight">LaporKu</div>
<div class="hidden md:flex items-center space-x-gutter">
<a class="font-body-sm text-body-sm font-semibold text-on-surface-variant hover:text-primary-container transition-colors duration-300 cursor-pointer" href="?page=home">Beranda</a>
<a class="font-body-sm text-body-sm font-semibold text-on-surface-variant hover:text-primary-container transition-colors duration-300 cursor-pointer" href="?page=form-laporan">Buat Laporan</a>
<a class="font-body-sm text-body-sm font-semibold text-primary-container border-b-2 border-primary-container pb-1 cursor-pointer" href="?page=tracking">Cek Status</a>
</div>
<div class="flex items-center space-x-sm">
<a href="?page=login" class="font-label text-label text-primary-container bg-surface-container-lowest border border-primary-container rounded-lg px-4 py-2 hover:bg-primary-fixed transition-colors duration-300 cursor-pointer active:opacity-80">Masuk Admin</a>
</div>
</div>
</nav>
<main class="flex-grow flex flex-col items-center justify-start pt-[100px] pb-xl px-4 md:px-gutter w-full max-w-container-max mx-auto">
<div class="w-full max-w-2xl text-center mb-10">
<h1 class="font-h1 text-h1 text-on-background mb-4">Lacak Status Pengaduanmu</h1>
<p class="font-body-md text-body-md text-on-surface-variant">Masukkan nomor tiket laporan yang telah Anda dapatkan untuk mengetahui perkembangan proses penanganan.</p>
</div>
<!-- Search Form -->
<div class="w-full max-w-2xl bg-surface-container-lowest rounded-xl p-md shadow-[0px_4px_12px_rgba(27,79,138,0.08)] mb-lg border border-outline-variant">
<form action="index.php" class="flex flex-col md:flex-row gap-4 w-full" method="GET">
<input type="hidden" name="page" value="tracking">
<div class="flex-grow relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline" data-icon="search">search</span>
<input class="w-full pl-12 pr-4 py-3 bg-surface-bright border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors font-body-md text-body-md text-on-surface" name="tiket" placeholder="Masukkan nomor tiket, contoh: TK-XXXXXX" type="text" value="<?php echo htmlspecialchars($tiket); ?>"/>
</div>
<button class="bg-primary text-on-primary font-label-md text-label-md py-3 px-6 rounded-lg hover:bg-primary-container transition-colors whitespace-nowrap" type="submit">
                    Cek Status
                </button>
</form>
</div>
<!-- PHP Logic Simulation: If Ticket Found -->
<?php if ($tiket && !$pengaduan): ?>
<div class="w-full max-w-3xl flex flex-col gap-md text-center">
    <p class="text-error font-bold">Laporan dengan nomor tiket <?php echo htmlspecialchars($tiket); ?> tidak ditemukan.</p>
</div>
<?php elseif ($pengaduan): ?>
<div class="w-full max-w-3xl flex flex-col gap-md">
<!-- Main Ticket Card -->
<div class="bg-surface-container-lowest rounded-xl p-6 md:p-8 shadow-[0px_4px_12px_rgba(27,79,138,0.08)] border border-outline-variant w-full flex flex-col gap-6">
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-outline-variant pb-6">
<div>
<span class="font-label-sm text-label-sm text-outline uppercase tracking-wider block mb-1">Nomor Tiket</span>
<h2 class="font-h2 text-h2 text-on-background font-bold"><?php echo htmlspecialchars($pengaduan['nomor_tiket']); ?></h2>
</div>
<!-- Status Badge: Processing (Yellow/Amber Theme) -->
<div class="bg-tertiary-fixed text-tertiary font-label-md text-label-md px-4 py-2 rounded-full border border-tertiary/20 flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="pending">pending</span>
                        <?php echo htmlspecialchars($pengaduan['status']); ?>
                    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
<div>
<span class="font-label-sm text-label-sm text-outline block mb-1">Kategori</span>
<p class="font-body-md text-body-md text-on-surface font-medium"><?php echo htmlspecialchars($pengaduan['kategori']); ?></p>
</div>
<div class="md:col-span-2">
<span class="font-label-sm text-label-sm text-outline block mb-1">Judul Laporan</span>
<p class="font-body-md text-body-md text-on-surface font-medium"><?php echo htmlspecialchars($pengaduan['judul']); ?></p>
</div>
<div>
<span class="font-label-sm text-label-sm text-outline block mb-1">Tanggal Dibuat</span>
<p class="font-body-md text-body-md text-on-surface font-medium"><?php echo htmlspecialchars($pengaduan['created_at']); ?></p>
</div>
</div>
<div class="pt-4 border-t border-outline-variant">
<span class="font-label-md text-label-md text-on-background block mb-3">Lampiran Foto</span>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
<?php foreach($lampiran as $lamp): ?>
<div class="aspect-square rounded-lg overflow-hidden border border-outline-variant bg-surface-variant relative">
<img class="w-full h-full object-cover" src="<?php echo htmlspecialchars($lamp['cloudfront_url'] ? $lamp['cloudfront_url'] : getEnvVar('APP_URL') . '/uploads/' . $lamp['nama_file']); ?>" />
</div>
<?php endforeach; ?>
</div>
</div>
</div>
<!-- Timeline Section -->
<div class="bg-surface-container-lowest rounded-xl p-6 md:p-8 shadow-[0px_4px_12px_rgba(27,79,138,0.08)] border border-outline-variant w-full">
<h3 class="font-h3 text-h3 text-on-background mb-6">Riwayat Status</h3>
<div class="relative pl-6 border-l-2 border-outline-variant space-y-8 pb-4">
<?php foreach($riwayat as $riw): ?>
<div class="relative">
<div class="absolute -left-[31px] top-1 w-3 h-3 bg-primary rounded-full ring-4 ring-surface-container-lowest"></div>
<div class="flex flex-col gap-1">
<span class="font-body-sm text-body-sm text-outline"><?php echo htmlspecialchars($riw['created_at']); ?></span>
<div class="flex items-center gap-2 mb-1">
<span class="bg-secondary-fixed text-secondary font-label-sm text-label-sm px-2 py-0.5 rounded border border-secondary/20"><?php echo htmlspecialchars($riw['status_lama']); ?></span>
<span class="material-symbols-outlined text-outline text-sm" data-icon="arrow_forward">arrow_forward</span>
<span class="bg-tertiary-fixed text-tertiary font-label-sm text-label-sm px-2 py-0.5 rounded border border-tertiary/20"><?php echo htmlspecialchars($riw['status_baru']); ?></span>
</div>
<?php if ($riw['catatan']): ?>
<p class="font-body-md text-body-md text-on-surface bg-surface-container-low p-3 rounded-lg border border-outline-variant/50 mt-2">
    <?php echo htmlspecialchars($riw['catatan']); ?>
</p>
<?php endif; ?>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
<div class="flex justify-center mt-6">
<a class="font-body-md text-body-md text-primary hover:text-primary-container transition-colors flex items-center gap-2" href="?page=home">
<span class="material-symbols-outlined text-sm" data-icon="arrow_back">arrow_back</span>
                    Kembali ke Beranda
                </a>
<?php endif; ?>
</div>
</div>
</main>
<!-- Footer -->
<footer class="bg-surface-container-high w-full px-6 md:px-12 flex flex-col md:flex-row justify-between items-center gap-4 py-8 border-t border-surface-variant mt-auto">
<div class="font-body-sm text-body-sm font-bold text-on-background">© 2024 LaporKu. Pemerintah RI.</div>
<div class="flex flex-wrap justify-center gap-sm md:gap-gutter">
<a class="font-body-sm text-caption text-on-surface-variant hover:text-primary-container underline transition-opacity duration-200" href="#">Kebijakan Privasi</a>
<a class="font-body-sm text-caption text-on-surface-variant hover:text-primary-container underline transition-opacity duration-200" href="#">Syarat &amp; Ketentuan</a>
<a class="font-body-sm text-caption text-on-surface-variant hover:text-primary-container underline transition-opacity duration-200" href="#">Pusat Bantuan</a>
</div>
</footer>
</body></html>
