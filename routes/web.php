<?php
// routes/web.php

// Proteksi: Pastikan file ini dipanggil dari index.php, bukan diakses langsung
if (!isset($uri) || !isset($basePath) || !isset($pdo)) {
    die("Direct access not permitted.");
}

// Routing Aplikasi
if ($uri === '/' || $uri === '/login') {
    // Mencegah user yang sudah login kembali ke halaman login
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require 'views/login.php';
} 
elseif ($uri === '/login-process') {
    require_once 'app/controllers/AuthController.php';
    loginProcess($pdo, $basePath);
}
elseif ($uri === '/logout') {
    require_once 'app/controllers/AuthController.php';
    logoutProcess($basePath);
}
elseif ($uri === '/admin/dashboard') {
    // Proteksi Halaman Dashboard (Harus Login)
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        $_SESSION['error'] = "Silakan login terlebih dahulu.";
        header("Location: " . $basePath . "/login");
        exit;
    }
    require_once 'app/controllers/DashboardController.php';
    indexDashboard($pdo, $basePath);
} 
else {
    http_response_code(404);
    echo "<h1 style='text-align:center; margin-top:50px;'>404 - Halaman Tidak Ditemukan</h1>";
}
?>