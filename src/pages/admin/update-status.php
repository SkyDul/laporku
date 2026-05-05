<?php
require_once __DIR__ . '/../../../src/config/database.php';
require_once __DIR__ . '/../../../src/helpers/auth.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Method not allowed");
}

$id = $_POST['id'] ?? 0;
$status_lama = $_POST['status_lama'] ?? '';
$status_baru = $_POST['status'] ?? '';
$catatan = $_POST['notes'] ?? '';

if (!$id || !$status_baru) {
    die("Invalid data");
}

try {
    $db = getDB();
    $db->beginTransaction();

    // Update pengaduan status
    $stmt = $db->prepare("UPDATE pengaduan SET status = ? WHERE id = ?");
    $stmt->execute([$status_baru, $id]);

    // Insert riwayat
    $stmtRiw = $db->prepare("INSERT INTO riwayat_status (pengaduan_id, status_lama, status_baru, catatan) VALUES (?, ?, ?, ?)");
    $stmtRiw->execute([$id, $status_lama, $status_baru, $catatan]);

    $db->commit();

    header("Location: ?page=admin/detail-laporan&id=" . urlencode($id) . "&success=1");
    exit;
} catch (\Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    die("Error updating status: " . $e->getMessage());
}
