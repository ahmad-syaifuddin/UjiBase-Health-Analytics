<?php
// index.php
session_start();
require_once 'app/config/database.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

if ($basePath !== '/' && $basePath !== '\\') {
    $uri = str_replace($basePath, '', $uri);
}

if ($uri === '' || $uri === false) {
    $uri = '/';
}

// Routing Aplikasi
if ($uri === '/' || $uri === '/login') {
    require 'views/login.php'; // Arahkan ke file view login
} 
elseif ($uri === '/admin/dashboard') {
    require 'views/admin/dashboard.php';
} 
else {
    http_response_code(404);
    echo "<h1 style='text-align:center; margin-top:50px;'>404 - Halaman Tidak Ditemukan</h1>";
}
?>