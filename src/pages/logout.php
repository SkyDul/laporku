<?php
session_start();
session_destroy();
header('Location: ' . getEnvVar('APP_URL', '') . '/index.php?page=home');
exit;
