<?php
require_once __DIR__ . '/../../../src/config/database.php';
require_once __DIR__ . '/../../../src/helpers/auth.php';

requireAdmin();

$id = $_GET['id'] ?? 0;
$db = getDB();

// Fetch report
$stmt = $db->prepare("SELECT * FROM pengaduan WHERE id = ?");
$stmt->execute([$id]);
$report = $stmt->fetch();

if (!$report) {
    die("Laporan tidak ditemukan");
}

// Fetch lampiran
$stmtLamp = $db->prepare("SELECT * FROM lampiran WHERE pengaduan_id = ?");
$stmtLamp->execute([$id]);
$lampiran = $stmtLamp->fetchAll();

// Fetch riwayat
$stmtRiw = $db->prepare("SELECT * FROM riwayat_status WHERE pengaduan_id = ? ORDER BY created_at DESC");
$stmtRiw->execute([$id]);
$riwayat = $stmtRiw->fetchAll();
?>
<!DOCTYPE html>

<html lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Admin - Detail Laporan</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        "colors": {
                "error-container": "#ffdad6",
                "on-primary-fixed-variant": "#0e4782",
                "tertiary": "#582c00",
                "surface-bright": "#f9f9ff",
                "primary-fixed": "#d4e3ff",
                "surface-container-lowest": "#ffffff",
                "on-tertiary-fixed": "#2f1500",
                "surface-container": "#ededf3",
                "on-tertiary-fixed-variant": "#6e3900",
                "surface-variant": "#e2e2e8",
                "on-secondary-container": "#626567",
                "inverse-on-surface": "#f0f0f6",
                "on-surface": "#1a1c20",
                "tertiary-fixed-dim": "#ffb77e",
                "primary-fixed-dim": "#a6c8ff",
                "secondary": "#5b5f61",
                "on-error-container": "#93000a",
                "on-tertiary": "#ffffff",
                "on-secondary": "#ffffff",
                "tertiary-fixed": "#ffdcc3",
                "primary-container": "#1b4f8a",
                "on-error": "#ffffff",
                "surface-tint": "#305f9b",
                "surface-container-high": "#e8e8ed",
                "primary": "#00386b",
                "on-primary": "#ffffff",
                "error": "#ba1a1a",
                "secondary-container": "#e0e3e6",
                "on-tertiary-container": "#ffae6b",
                "secondary-fixed-dim": "#c4c7ca",
                "surface-container-highest": "#e2e2e8",
                "on-surface-variant": "#424750",
                "on-secondary-fixed-variant": "#44474a",
                "on-secondary-fixed": "#191c1e",
                "surface-container-low": "#f3f3f9",
                "surface": "#f9f9ff",
                "outline-variant": "#c2c6d1",
                "outline": "#737781",
                "on-primary-container": "#9ac2ff",
                "on-primary-fixed": "#001c3a",
                "background": "#f9f9ff",
                "tertiary-container": "#793f00",
                "on-background": "#1a1c20",
                "surface-dim": "#d9d9df",
                "inverse-primary": "#a6c8ff",
                "secondary-fixed": "#e0e3e6",
                "inverse-surface": "#2e3035"
        },
        "borderRadius": {
                "DEFAULT": "0.25rem",
                "lg": "0.5rem",
                "xl": "0.75rem",
                "full": "9999px"
        },
        "spacing": {
                "container-max": "1200px",
                "base": "8px",
                "xl": "64px",
                "md": "24px",
                "sm": "12px",
                "xs": "4px",
                "lg": "40px"
        },
        "fontFamily": {
            "sans": ['"Plus Jakarta Sans"', 'sans-serif']
        },
      }
    }
  }
</script>
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    .fill-icon { font-variation-settings: 'FILL' 1; }
</style>
</head>
<body class="bg-background text-on-background min-h-screen overflow-x-hidden">
<!-- Shared Component Header Block -->
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-outline-variant px-10 py-3 bg-surface sticky top-0 z-10 shadow-[0_2px_4px_rgba(0,0,0,0.04)]">
<div class="flex items-center gap-4 text-on-surface">
<div class="size-4">
<svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path clip-rule="evenodd" d="M39.475 21.6262C40.358 21.4363 40.6863 21.5589 40.7581 21.5934C40.7876 21.655 40.8547 21.857 40.8082 22.3336C40.7408 23.0255 40.4502 24.0046 39.8572 25.2301C38.6799 27.6631 36.5085 30.6631 33.5858 33.5858C30.6631 36.5085 27.6632 38.6799 25.2301 39.8572C24.0046 40.4502 23.0255 40.7407 22.3336 40.8082C21.8571 40.8547 21.6551 40.7875 21.5934 40.7581C21.5589 40.6863 21.4363 40.358 21.6262 39.475C21.8562 38.4054 22.4689 36.9657 23.5038 35.2817C24.7575 33.2417 26.5497 30.9744 28.7621 28.762C30.9744 26.5497 33.2417 24.7574 35.2817 23.5037C36.9657 22.4689 38.4054 21.8562 39.475 21.6262ZM4.41189 29.2403L18.7597 43.5881C19.8813 44.7097 21.4027 44.9179 22.7217 44.7893C24.0585 44.659 25.5148 44.1631 26.9723 43.4579C29.9052 42.0387 33.2618 39.5667 36.4142 36.4142C39.5667 33.2618 42.0387 29.9052 43.4579 26.9723C44.1631 25.5148 44.659 24.0585 44.7893 22.7217C44.9179 21.4027 44.7097 19.8813 43.5881 18.7597L29.2403 4.41187C27.8527 3.02428 25.8765 3.02573 24.2861 3.36776C22.6081 3.72863 20.7334 4.58419 18.8396 5.74801C16.4978 7.18716 13.9881 9.18353 11.5858 11.5858C9.18354 13.988 7.18717 16.4978 5.74802 18.8396C4.58421 20.7334 3.72865 22.6081 3.36778 24.2861C3.02574 25.8765 3.02429 27.8527 4.41189 29.2403Z" fill="currentColor" fill-rule="evenodd"></path>
</svg>
</div>
<h2 class="text-on-surface text-lg font-bold leading-tight tracking-[-0.015em]">LaporKu Admin</h2>
</div>
<div class="flex flex-1 justify-end gap-8">
<div class="flex items-center gap-9"><a class="text-on-surface text-sm font-medium leading-normal hover:text-primary-container transition-colors" href="?page=admin/dashboard">← Kembali ke Dashboard</a></div>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" data-alt="A generic placeholder image showing an abstract geometric pattern in light gray and white tones, acting as a temporary user avatar for the administration interface." style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDx6yCa_Ibm1dajH8SBflNFDR_wPTTaYPWCj1SUeDxJGgKarZB4xJFkF7sNXrj4UhzlhMBK82uGxS78AggtfuGfneC2d40kMMm1jwpArIbkSGDGvUZBYJ7d7FaVm0jCZwbMpSJPW4iGacr-tiQRa_AmIYHypBeRowN-ikx6obcogPi-pZ-XlFIOW9RTVWwilvf1MKKOr-C0UCva-wAoT8PKJqln31_lcFekKGAQ56AArj7CPwAHHTCJ7IpKcDoKZ0HRT_aU2bDbRg");'></div>
</div>
</header>
<main class="max-w-container-max mx-auto px-4 md:px-md py-md">
<!-- Simulated Success Feedback -->
<?php if(isset($_GET['success'])): ?>
<div class="mb-6 p-4 rounded-lg bg-primary-fixed text-on-primary-fixed border border-primary-fixed-dim flex items-center gap-3">
<span class="material-symbols-outlined fill-icon text-primary">check_circle</span>
<p class="text-sm font-medium">Status laporan berhasil diperbarui.</p>
</div>
<?php endif; ?>
<div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
<!-- Left Column: Report Info (60% Desktop) -->
<div class="md:col-span-7 flex flex-col gap-6">
<div class="bg-surface rounded-xl shadow-[0_4px_12px_rgba(27,79,138,0.05)] p-md flex flex-col gap-4">
<!-- Shared Component Content Integrated -->
<div class="flex flex-wrap justify-between gap-3">
<div class="flex min-w-72 flex-col gap-2">
<h1 class="text-on-surface tracking-[-0.02em] text-[32px] font-bold leading-tight">Laporan #<?php echo htmlspecialchars($report['nomor_tiket']); ?>: <?php echo htmlspecialchars($report['judul']); ?></h1>
<p class="text-on-surface-variant text-sm font-normal leading-normal">Kategori: <?php echo htmlspecialchars($report['kategori']); ?></p>
</div>
</div>
<div class="flex gap-3 flex-wrap">
<div class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-full bg-primary-fixed px-4">
<p class="text-on-primary-fixed text-sm font-medium leading-normal">Status: <?php echo htmlspecialchars($report['status']); ?></p>
</div>
</div>
<div class="grid grid-cols-[20%_1fr] gap-x-6 mt-2">
<div class="col-span-2 grid grid-cols-subgrid border-t border-t-outline-variant py-3">
<p class="text-on-surface-variant text-sm font-normal leading-normal">Tanggal</p>
<p class="text-on-surface text-sm font-normal leading-normal"><?php echo htmlspecialchars($report['created_at']); ?></p>
</div>
<div class="col-span-2 grid grid-cols-subgrid border-t border-t-outline-variant py-3">
<p class="text-on-surface-variant text-sm font-normal leading-normal">Pelapor</p>
<p class="text-on-surface text-sm font-normal leading-normal"><?php echo htmlspecialchars($report['nama_pelapor']); ?></p>
</div>
<div class="col-span-2 grid grid-cols-subgrid border-t border-t-outline-variant py-3">
<p class="text-on-surface-variant text-sm font-normal leading-normal">Email</p>
<p class="text-on-surface text-sm font-normal leading-normal"><?php echo htmlspecialchars($report['email_pelapor']); ?></p>
</div>
<div class="col-span-2 grid grid-cols-subgrid border-t border-t-outline-variant py-3">
<p class="text-on-surface-variant text-sm font-normal leading-normal">Lokasi</p>
<p class="text-on-surface text-sm font-normal leading-normal"><?php echo htmlspecialchars($report['lokasi']); ?></p>
</div>
</div>
<div class="bg-surface-container-low p-4 rounded-lg mt-2 border border-surface-variant">
<h3 class="text-sm font-semibold text-on-surface mb-2">Deskripsi Laporan</h3>
<p class="text-on-surface text-base font-normal leading-relaxed">
    <?php echo nl2br(htmlspecialchars($report['deskripsi'])); ?>
</p>
</div>
</div>
<!-- Attachments Section -->
<div class="bg-surface rounded-xl shadow-[0_4px_12px_rgba(27,79,138,0.05)] p-md flex flex-col gap-4">
<h3 class="text-lg font-bold text-on-surface flex items-center gap-2">
<span class="material-symbols-outlined text-primary-container">attachment</span>
                    Lampiran Foto/Dokumen
                </h3>
<div class="grid grid-cols-2 md:grid-cols-3 gap-4">
<?php foreach($lampiran as $lamp): ?>
<div class="relative group aspect-square rounded-lg overflow-hidden border border-outline-variant bg-surface-container">
<img class="w-full h-full object-cover" src="<?php echo htmlspecialchars($lamp['cloudfront_url'] ? $lamp['cloudfront_url'] : getEnvVar('APP_URL') . '/uploads/' . $lamp['nama_file']); ?>" />
<div class="absolute inset-0 bg-inverse-surface/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
<a class="text-on-primary bg-primary/80 p-2 rounded-full flex items-center" href="<?php echo htmlspecialchars($lamp['cloudfront_url'] ? $lamp['cloudfront_url'] : getEnvVar('APP_URL') . '/uploads/' . $lamp['nama_file']); ?>" target="_blank">
<span class="material-symbols-outlined">visibility</span>
</a>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
<!-- Right Column: Action Panel (40% Desktop) -->
<div class="md:col-span-5 flex flex-col gap-6">
<!-- Update Status Card -->
<div class="bg-surface rounded-xl shadow-[0_4px_12px_rgba(27,79,138,0.05)] p-md flex flex-col gap-4">
<h3 class="text-lg font-bold text-on-surface border-b border-outline-variant pb-3">Update Status Laporan</h3>
<form action="?page=admin/update-status" class="flex flex-col gap-4" method="POST">
<input type="hidden" name="id" value="<?php echo htmlspecialchars($report['id']); ?>">
<input type="hidden" name="status_lama" value="<?php echo htmlspecialchars($report['status']); ?>">
<div class="flex flex-col gap-1">
<label class="text-label text-on-surface-variant uppercase tracking-wider" for="status">Status Baru</label>
<select class="w-full rounded-DEFAULT border border-outline-variant bg-surface px-3 py-2 text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none transition-all" id="status" name="status">
<option value="Diterima" <?php echo $report['status'] == 'Diterima' ? 'selected' : ''; ?>>Diterima</option>
<option value="Diproses" <?php echo $report['status'] == 'Diproses' ? 'selected' : ''; ?>>Diproses</option>
<option value="Selesai" <?php echo $report['status'] == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
</select>
</div>
<div class="flex flex-col gap-1">
<label class="text-label text-on-surface-variant uppercase tracking-wider" for="notes">Catatan Admin (Opsional)</label>
<textarea class="w-full rounded-DEFAULT border border-outline-variant bg-surface px-3 py-2 text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none transition-all resize-y" id="notes" name="notes" placeholder="Tambahkan catatan untuk pelapor atau internal..." rows="4"></textarea>
</div>
<button class="bg-primary-container text-on-primary hover:bg-primary px-4 py-3 rounded-lg text-sm font-semibold transition-colors mt-2 flex justify-center items-center gap-2" type="submit">
<span class="material-symbols-outlined" style="font-size: 18px;">save</span>
                        Simpan Perubahan
                    </button>
</form>
</div>
<!-- History Timeline Card -->
<div class="bg-surface rounded-xl shadow-[0_4px_12px_rgba(27,79,138,0.05)] p-md flex flex-col gap-4">
<h3 class="text-lg font-bold text-on-surface border-b border-outline-variant pb-3">Riwayat Status</h3>
<div class="relative pl-4 mt-2">
<!-- Vertical Line -->
<div class="absolute left-[7px] top-2 bottom-2 w-px bg-outline-variant"></div>
<div class="flex flex-col gap-6">
<?php foreach($riwayat as $riw): ?>
<div class="relative flex gap-4 items-start">
<div class="absolute -left-4 w-3 h-3 rounded-full bg-primary-container ring-4 ring-surface mt-1 z-10"></div>
<div class="flex flex-col">
<span class="text-sm font-semibold text-on-surface"><?php echo htmlspecialchars($riw['status_baru']); ?></span>
<span class="text-xs text-on-surface-variant mt-1"><?php echo htmlspecialchars($riw['created_at']); ?></span>
<?php if ($riw['catatan']): ?>
<p class="text-sm text-on-surface mt-2 bg-surface-container-low p-2 rounded border border-surface-variant">
    <?php echo htmlspecialchars($riw['catatan']); ?>
</p>
<?php endif; ?>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
</div>
</div>
</main>
</body></html>
