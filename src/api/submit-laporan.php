<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/s3.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$nama = $_POST['nama_pelapor'] ?? '';
$email = $_POST['email_pelapor'] ?? '';
$kategori = $_POST['kategori'] ?? '';
$judul = $_POST['judul'] ?? '';
$deskripsi = $_POST['deskripsi'] ?? '';
$lokasi = $_POST['lokasi'] ?? '';

// Generate random ticket number
$nomor_tiket = 'TK-' . strtoupper(substr(uniqid(), -6));

try {
    $db = getDB();
    $db->beginTransaction();

    $stmt = $db->prepare("INSERT INTO pengaduan (nomor_tiket, nama_pelapor, email_pelapor, kategori, judul, deskripsi, lokasi) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nomor_tiket, $nama, $email, $kategori, $judul, $deskripsi, $lokasi]);
    $pengaduan_id = $db->lastInsertId();

    // Upload lampiran if exists
    if (isset($_FILES['lampiran']) && $_FILES['lampiran']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['lampiran']['tmp_name'];
        $fileName = time() . '_' . basename($_FILES['lampiran']['name']);
        
        $uploadResult = uploadToS3($tmpName, $fileName);
        
        if ($uploadResult['success']) {
            $stmtLampiran = $db->prepare("INSERT INTO lampiran (pengaduan_id, nama_file, s3_key, cloudfront_url) VALUES (?, ?, ?, ?)");
            $stmtLampiran->execute([
                $pengaduan_id, 
                $fileName, 
                $uploadResult['s3_key'] ?? '', 
                $uploadResult['cloudfront_url'] ?? ''
            ]);
        }
    }

    $db->commit();

    // Redirect to tracking page with the ticket number
    header('Location: ' . getEnvVar('APP_URL', '') . '/index.php?page=tracking&tiket=' . $nomor_tiket);
    exit;

} catch (\Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Gagal membuat laporan: ' . $e->getMessage()]);
    exit;
}
