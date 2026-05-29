<?php
// index.php
session_start();
require_once 'app/config/database.php';

// 1. Dapatkan URI yang sedang diakses
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 2. Dapatkan path folder utama aplikasi secara dinamis (Fleksibel untuk Laragon/XAMPP)
$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

// 3. Bersihkan URI dari base path (jika aplikasi berada di dalam subfolder)
if ($basePath !== '/' && $basePath !== '\\') {
    $uri = str_replace($basePath, '', $uri);
}

// 4. Pastikan root selalu terbaca sebagai '/'
if ($uri === '' || $uri === false) {
    $uri = '/';
}

// 5. Panggil file routing utama
require_once 'routes/web.php';
?>