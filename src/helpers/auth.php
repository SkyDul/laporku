<?php

session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . getEnvVar('APP_URL', '/public') . '/index.php?page=login');
        exit;
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        header('Location: ' . getEnvVar('APP_URL', '/public') . '/index.php?page=home');
        exit;
    }
}
