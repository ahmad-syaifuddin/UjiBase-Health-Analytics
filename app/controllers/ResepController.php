<?php
// app/controllers/ResepController.php

function indexResep($pdo, $basePath) {
    try {
        // MENGGUNAKAN LEFT JOIN: 
        // Agar data resep tetap muncul meskipun (amit-amit) ID dokternya terhapus atau tidak valid
        $query = "SELECT r.*, p.nama_pasien, py.nama_penyakit, py.kode_icd, d.nama_dokter 
                  FROM resep r 
                  LEFT JOIN pasien p ON r.pasien_id = p.id 
                  LEFT JOIN penyakit py ON r.penyakit_id = py.id 
                  LEFT JOIN dokter d ON r.dokter_id = d.id 
                  ORDER BY r.id DESC";
        $stmt = $pdo->query($query);
        $resep = $stmt->fetchAll();
    } catch (PDOException $e) { 
        // Tampilkan pesan error aslinya ke layar agar kita tahu jika ada masalah SQL
        $_SESSION['error'] = "Terjadi kesalahan SQL: " . $e->getMessage();
        $resep = []; 
    }

    // Ambil master data untuk dropdown form
    $pasien = $pdo->query("SELECT id, nama_pasien, no_identitas FROM pasien ORDER BY nama_pasien ASC")->fetchAll();
    $penyakit = $pdo->query("SELECT id, nama_penyakit, kode_icd FROM penyakit ORDER BY nama_penyakit ASC")->fetchAll();
    $dokter = $pdo->query("SELECT id, nama_dokter, spesialisasi FROM dokter ORDER BY nama_dokter ASC")->fetchAll();

    require 'views/admin/resep/index.php';
}

function storeResep($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            // Kolom menggunakan dokter_id, bukan nama_dokter
            $stmt = $pdo->prepare("INSERT INTO resep (pasien_id, penyakit_id, dokter_id, tanggal_resep, status_resep) VALUES (:pasien_id, :penyakit_id, :dokter_id, :tanggal_resep, 'Menunggu')");
            $stmt->execute([
                'pasien_id' => $_POST['pasien_id'],
                'penyakit_id' => $_POST['penyakit_id'],
                'dokter_id' => $_POST['dokter_id'],
                'tanggal_resep' => $_POST['tanggal_resep']
            ]);
            $_SESSION['success'] = "Resep berhasil ditambahkan dan masuk antrean (Menunggu).";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal menyimpan resep medis.";
        }
    }
    header("Location: " . $basePath . "/admin/resep");
    exit;
}

function editResep($pdo, $basePath) {
    if (!isset($_GET['id'])) { 
        header("Location: " . $basePath . "/admin/resep"); 
        exit; 
    }
    
    // Ambil data resep spesifik
    $stmt = $pdo->prepare("SELECT * FROM resep WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $resep_edit = $stmt->fetch();

    if (!$resep_edit) {
        header("Location: " . $basePath . "/admin/resep"); 
        exit; 
    }

    // Ambil opsi referensi untuk form edit
    $pasien = $pdo->query("SELECT id, nama_pasien, no_identitas FROM pasien ORDER BY nama_pasien ASC")->fetchAll();
    $penyakit = $pdo->query("SELECT id, nama_penyakit, kode_icd FROM penyakit ORDER BY nama_penyakit ASC")->fetchAll();
    $dokter = $pdo->query("SELECT id, nama_dokter, spesialisasi FROM dokter ORDER BY nama_dokter ASC")->fetchAll();

    require 'views/admin/resep/edit.php';
}

function updateResep($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            // Kolom menggunakan dokter_id
            $stmt = $pdo->prepare("UPDATE resep SET pasien_id = :pasien_id, penyakit_id = :penyakit_id, dokter_id = :dokter_id, tanggal_resep = :tanggal_resep, status_resep = :status_resep WHERE id = :id");
            $stmt->execute([
                'pasien_id' => $_POST['pasien_id'],
                'penyakit_id' => $_POST['penyakit_id'],
                'dokter_id' => $_POST['dokter_id'],
                'tanggal_resep' => $_POST['tanggal_resep'],
                'status_resep' => $_POST['status_resep'],
                'id' => $_POST['id']
            ]);
            $_SESSION['success'] = "Data resep berhasil diperbarui.";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal memperbarui resep medis.";
        }
    }
    header("Location: " . $basePath . "/admin/resep");
    exit;
}

function deleteResep($pdo, $basePath) {
    if (isset($_GET['id'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM resep WHERE id = :id");
            $stmt->execute(['id' => $_GET['id']]);
            $_SESSION['success'] = "Resep medis berhasil ditarik/dihapus.";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal dihapus! Resep ini mungkin sudah diproses ke dalam riwayat transaksi kasir.";
        }
    }
    header("Location: " . $basePath . "/admin/resep");
    exit;
}
?>