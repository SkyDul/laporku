<!DOCTYPE html>

<html lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Buat Laporan - LaporKu</title>
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen flex flex-col">
<!-- TopNavBar -->
<nav class="bg-surface-container-lowest fixed top-0 left-0 right-0 z-50 border-b border-surface-variant shadow-[0_2px_4px_rgba(0,0,0,0.04)]">
<div class="max-w-[1200px] mx-auto flex justify-between items-center px-6 md:px-12 h-16">
<div class="text-xl font-bold text-primary-container tracking-tight">LaporKu</div>
<div class="hidden md:flex items-center space-x-gutter">
<a class="font-body-sm text-body-sm font-semibold text-on-surface-variant hover:text-primary-container transition-colors duration-300 cursor-pointer" href="?page=home">Beranda</a>
<a class="font-body-sm text-body-sm font-semibold text-primary-container border-b-2 border-primary-container pb-1 cursor-pointer" href="?page=form-laporan">Buat Laporan</a>
<a class="font-body-sm text-body-sm font-semibold text-on-surface-variant hover:text-primary-container transition-colors duration-300 cursor-pointer" href="?page=tracking">Cek Status</a>
</div>
<div class="flex items-center space-x-sm">
<a href="?page=login" class="font-label text-label text-primary-container bg-surface-container-lowest border border-primary-container rounded-lg px-4 py-2 hover:bg-primary-fixed transition-colors duration-300 cursor-pointer active:opacity-80">Masuk Admin</a>
</div>
</div>
</nav>
<!-- Main Content -->
<main class="flex-grow flex flex-col pt-[100px] pb-12 px-4 md:px-gutter w-full max-w-3xl mx-auto">
<div class="mb-8">
<h1 class="font-h1 text-h1 text-on-background mb-2">Buat Laporan Baru</h1>
<p class="font-body-md text-body-md text-secondary">Sampaikan keluhan atau masukan Anda kepada instansi terkait.</p>
</div>
<div class="bg-surface-container-lowest rounded-xl p-gutter shadow-[0_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30">
<form action="?page=api/submit-laporan" enctype="multipart/form-data" class="space-y-6" method="POST">
<div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
<div class="space-y-2">
<label class="font-label text-label text-on-surface block" for="nama_pelapor">Nama Pelapor <span class="text-error">*</span></label>
<input class="w-full border border-outline-variant rounded-lg p-2 focus:ring-2 focus:ring-primary-container/20 focus:border-primary-container font-body-md text-body-md text-on-surface bg-surface-container-lowest placeholder:text-outline" id="nama_pelapor" name="nama_pelapor" placeholder="Nama Lengkap" required="" type="text"/>
</div>
<div class="space-y-2">
<label class="font-label text-label text-on-surface block" for="email_pelapor">Email <span class="text-error">*</span></label>
<input class="w-full border border-outline-variant rounded-lg p-2 focus:ring-2 focus:ring-primary-container/20 focus:border-primary-container font-body-md text-body-md text-on-surface bg-surface-container-lowest placeholder:text-outline" id="email_pelapor" name="email_pelapor" placeholder="Email Anda" required="" type="email"/>
</div>
</div>
<!-- Judul Laporan -->
<div class="space-y-2">
<label class="font-label text-label text-on-surface block" for="judul">Judul Laporan <span class="text-error">*</span></label>
<input class="w-full border border-outline-variant rounded-lg p-2 focus:ring-2 focus:ring-primary-container/20 focus:border-primary-container font-body-md text-body-md text-on-surface bg-surface-container-lowest placeholder:text-outline" id="judul" name="judul" placeholder="Ketikkan judul singkat laporan Anda" required="" type="text"/>
</div>
<!-- Kategori & Lokasi (Grid) -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
<!-- Kategori -->
<div class="space-y-2">
<label class="font-label text-label text-on-surface block" for="kategori">Kategori <span class="text-error">*</span></label>
<div class="relative">
<select class="w-full border border-outline-variant rounded-lg p-2 appearance-none focus:ring-2 focus:ring-primary-container/20 focus:border-primary-container font-body-md text-body-md text-on-surface bg-surface-container-lowest" id="kategori" name="kategori" required="">
<option disabled="" selected="" value="">Pilih Kategori</option>
<option value="Infrastruktur">Infrastruktur</option>
<option value="Pelayanan Publik">Pelayanan Publik</option>
<option value="Kebersihan">Kebersihan</option>
<option value="Lainnya">Lainnya</option>
</select>
<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-outline">
<span class="material-symbols-outlined">expand_more</span>
</div>
</div>
</div>
<!-- Lokasi Kejadian -->
<div class="space-y-2">
<label class="font-label text-label text-on-surface block" for="lokasi">Lokasi Kejadian <span class="text-error">*</span></label>
<div class="relative">
<input class="w-full border border-outline-variant rounded-lg p-2 pl-10 focus:ring-2 focus:ring-primary-container/20 focus:border-primary-container font-body-md text-body-md text-on-surface bg-surface-container-lowest placeholder:text-outline" id="lokasi" name="lokasi" placeholder="Nama jalan, gedung, atau patokan" required="" type="text"/>
<div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-outline">
<span class="material-symbols-outlined">location_on</span>
</div>
</div>
</div>
</div>
<!-- Isi Laporan -->
<div class="space-y-2">
<label class="font-label text-label text-on-surface block" for="isi_laporan">Isi Laporan <span class="text-error">*</span></label>
<textarea class="w-full border border-outline-variant rounded-lg p-2 focus:ring-2 focus:ring-primary-container/20 focus:border-primary-container font-body-md text-body-md text-on-surface bg-surface-container-lowest placeholder:text-outline resize-y" id="deskripsi" name="deskripsi" placeholder="Jelaskan detail kejadian atau keluhan Anda secara rinci" required="" rows="5"></textarea>
</div>
<!-- File Lampiran -->
<div class="space-y-2">
<label class="font-label text-label text-on-surface block">File Lampiran (Opsional)</label>
<label for="lampiran" class="border-2 border-dashed border-outline-variant rounded-xl p-8 text-center bg-surface-container-low hover:bg-surface-container-high transition-colors cursor-pointer block">
<span class="material-symbols-outlined text-4xl text-outline mb-2">cloud_upload</span>
<p class="font-body-md text-body-md text-on-surface mb-1">Tarik &amp; lepas file di sini atau klik untuk memilih</p>
<p class="font-caption text-caption text-secondary">Maks. 5MB (JPG, PNG, PDF)</p>
<input accept=".jpg,.jpeg,.png,.pdf" class="hidden" name="lampiran" id="lampiran" type="file" onchange="document.getElementById('file-name').innerText = this.files[0].name" />
<div id="file-name" class="font-body-sm text-primary mt-2"></div>
</div>
</div>
<!-- Action Buttons -->
<div class="pt-6 mt-6 border-t border-outline-variant/30 flex flex-col-reverse md:flex-row justify-end gap-4">
<button class="px-6 py-3 rounded-xl border border-[#1B4F8A] text-[#1B4F8A] font-label text-label hover:bg-blue-50 transition-colors duration-300 flex justify-center items-center" type="button">
                        Batal
                    </button>
<button class="px-6 py-3 rounded-xl bg-[#1B4F8A] text-white font-label text-label hover:bg-blue-800 transition-colors duration-300 flex justify-center items-center shadow-md shadow-primary-container/20" type="submit">
                        Kirim Laporan
                    </button>
</div>
</form>
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
