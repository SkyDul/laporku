<?php
require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/helpers/auth.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Handle API requests
if (strpos($page, 'api/') === 0) {
    $apiFile = __DIR__ . '/../src/' . $page . '.php';
    if (file_exists($apiFile)) {
        require $apiFile;
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'API endpoint not found']);
    }
    exit;
}

// Allowed pages
$allowed_pages = [
    'home' => '../src/pages/home.php',
    'form-laporan' => '../src/pages/form-laporan.php',
    'tracking' => '../src/pages/tracking.php',
    'login' => '../src/pages/login.php',
    'logout' => '../src/pages/logout.php',
    'admin/dashboard' => '../src/pages/admin/dashboard.php',
    'admin/detail-laporan' => '../src/pages/admin/detail-laporan.php',
    'admin/update-status' => '../src/pages/admin/update-status.php'
];

if (!array_key_exists($page, $allowed_pages)) {
    http_response_code(404);
    echo "404 Page Not Found";
    exit;
}

$file = __DIR__ . '/' . $allowed_pages[$page];
if (file_exists($file)) {
    require $file;
} else {
    echo "Page template not found: " . htmlspecialchars($page);
}
