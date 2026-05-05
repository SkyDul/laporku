<!DOCTYPE html>

<html lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>LaporKu - Layanan Aspirasi dan Pengaduan Online Rakyat</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
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
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen flex flex-col">
<!-- TopNavBar -->
<nav class="bg-surface-container-lowest fixed top-0 left-0 right-0 z-50 border-b border-surface-variant shadow-[0_2px_4px_rgba(0,0,0,0.04)]">
<div class="max-w-[1200px] mx-auto flex justify-between items-center px-6 md:px-12 h-16">
<div class="text-xl font-bold text-primary-container tracking-tight">LaporKu</div>
<div class="hidden md:flex items-center space-x-gutter">
<a class="font-body-sm text-body-sm font-semibold text-primary-container border-b-2 border-primary-container pb-1 cursor-pointer" href="?page=home">Beranda</a>
<a class="font-body-sm text-body-sm font-semibold text-on-surface-variant hover:text-primary-container transition-colors duration-300 cursor-pointer" href="?page=form-laporan">Buat Laporan</a>
<a class="font-body-sm text-body-sm font-semibold text-on-surface-variant hover:text-primary-container transition-colors duration-300 cursor-pointer" href="?page=tracking">Cek Status</a>
</div>
<div class="flex items-center space-x-sm">
<a href="?page=login" class="font-label text-label text-primary-container bg-surface-container-lowest border border-primary-container rounded-lg px-4 py-2 hover:bg-primary-fixed transition-colors duration-300 cursor-pointer active:opacity-80">Masuk</a>
</div>
</div>
</nav>
<!-- Main Content -->
<main class="flex-grow pt-xxl">
<!-- Hero Section -->
<section class="w-full max-w-container-max mx-auto px-6 md:px-12 py-xxl flex flex-col items-center text-center">
<h1 class="font-display text-display text-on-background max-w-3xl mb-sm">Sampaikan Laporan Anda Langsung kepada Instansi Pemerintah Berwenang</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mb-xl">Layanan Aspirasi dan Pengaduan Online Rakyat. Mudah, Transparan, dan Terpercaya.</p>
<form action="index.php" method="GET" class="w-full max-w-xl bg-surface-container-lowest rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.05)] p-sm mb-lg flex flex-col sm:flex-row items-center gap-sm">
<input type="hidden" name="page" value="tracking">
<div class="relative w-full flex-grow">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
<input name="tiket" class="w-full pl-10 pr-4 py-3 rounded-lg border border-outline-variant bg-surface-container-lowest font-body-sm text-body-sm focus:outline-none focus:ring-2 focus:ring-primary-container/20 focus:border-primary-container transition-all" placeholder="Lacak ID Laporan Anda..." type="text"/>
</div>
<button type="submit" class="w-full sm:w-auto whitespace-nowrap bg-secondary-container text-on-secondary-container font-label text-label px-6 py-3 rounded-lg hover:bg-surface-variant transition-colors duration-300">Lacak</button>
</form>
<a href="?page=form-laporan" class="bg-primary-container text-on-primary font-h3 text-h3 px-8 py-4 rounded-xl shadow-lg hover:bg-on-primary-fixed-variant transition-colors duration-300 flex items-center gap-2">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                Buat Laporan
            </a>
</section>
<!-- How it Works Section -->
<section class="bg-surface-container-low py-xxl">
<div class="w-full max-w-container-max mx-auto px-6 md:px-12">
<div class="text-center mb-xl">
<h2 class="font-h2 text-h2 text-on-background">Cara Kerja LaporKu</h2>
<p class="font-body-md text-body-md text-on-surface-variant mt-xs">Proses mudah dan transparan dari awal hingga akhir penyelesaian.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter relative">
<!-- Step 1 -->
<div class="bg-surface-container-lowest rounded-xl p-lg shadow-[0_4px_12px_rgba(0,0,0,0.05)] relative z-10 flex flex-col items-center text-center">
<div class="w-16 h-16 rounded-full bg-primary-fixed flex items-center justify-center mb-sm">
<span class="material-symbols-outlined text-primary-container text-3xl">edit_document</span>
</div>
<h3 class="font-h3 text-h3 text-on-background mb-xs">Tulis Laporan</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">Laporkan keluhan atau aspirasi Anda dengan jelas dan lengkap, disertai bukti pendukung jika ada.</p>
</div>
<!-- Step 2 -->
<div class="bg-surface-container-lowest rounded-xl p-lg shadow-[0_4px_12px_rgba(0,0,0,0.05)] relative z-10 flex flex-col items-center text-center">
<div class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center mb-sm">
<span class="material-symbols-outlined text-on-secondary-container text-3xl">fact_check</span>
</div>
<h3 class="font-h3 text-h3 text-on-background mb-xs">Proses Verifikasi</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">Laporan Anda akan diverifikasi dan diteruskan kepada instansi yang berwenang dalam waktu 3 hari kerja.</p>
</div>
<!-- Step 3 -->
<div class="bg-surface-container-lowest rounded-xl p-lg shadow-[0_4px_12px_rgba(0,0,0,0.05)] relative z-10 flex flex-col items-center text-center">
<div class="w-16 h-16 rounded-full bg-tertiary-fixed flex items-center justify-center mb-sm">
<span class="material-symbols-outlined text-tertiary-container text-3xl">published_with_changes</span>
</div>
<h3 class="font-h3 text-h3 text-on-background mb-xs">Tindak Lanjut</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">Instansi akan menindaklanjuti dan Anda dapat memantau proses penyelesaiannya secara langsung.</p>
</div>
</div>
</div>
</section>
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
