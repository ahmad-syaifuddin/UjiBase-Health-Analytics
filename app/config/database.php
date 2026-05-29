<?php
// app/config/database.php

$host = 'localhost';
$db   = 'db_ujibase_health';
$user = 'root';
$pass = '';

try {
    // Membuat koneksi PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    
    // Mode error diubah ke Exception agar error mudah dilacak saat development
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Mengatur fetch data default menjadi Array Asosiatif
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Mematikan eksekusi dan menampilkan pesan jika koneksi gagal
    die("Koneksi Database Gagal: " . $e->getMessage());
}
?>