<?php
// app/controllers/DashboardController.php

function indexDashboard($pdo, $basePath) {
    // 1. Ambil Data Stok Obat Kritis (Stok <= Stok Minimum)
    try {
        $stmtStok = $pdo->query("SELECT nama_obat as nama, stok as sisa, stok_minimum as min FROM obat WHERE stok <= stok_minimum ORDER BY stok ASC");
        $stokKritis = $stmtStok->fetchAll();
    } catch (PDOException $e) {
        $stokKritis = []; // Fallback jika error agar halaman tidak crash
    }

    // 2. Ambil 5 Transaksi Terakhir
    try {
        $stmtTrx = $pdo->query("SELECT kode_transaksi as kode, status_pembayaran as status, total_harga as total FROM transaksi ORDER BY tanggal_transaksi DESC LIMIT 5");
        $transaksiTerbaru = $stmtTrx->fetchAll();
    } catch (PDOException $e) {
        $transaksiTerbaru = [];
    }

    // Panggil View dan kirim datanya
    require 'views/admin/dashboard.php';
}
?>