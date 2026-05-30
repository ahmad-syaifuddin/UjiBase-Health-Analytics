<?php
// app/controllers/PasienPenyakitController.php

// --- VIEW UTAMA ---
function indexPasienPenyakit($pdo, $basePath) {
    try {
        $stmtPasien = $pdo->query("SELECT * FROM pasien ORDER BY id DESC");
        $pasien = $stmtPasien->fetchAll();
    } catch (PDOException $e) { $pasien = []; }

    try {
        $stmtPenyakit = $pdo->query("SELECT * FROM penyakit ORDER BY id DESC");
        $penyakit = $stmtPenyakit->fetchAll();
    } catch (PDOException $e) { $penyakit = []; }

    require 'views/admin/pasien_penyakit/index.php';
}

// --- LOGIKA PASIEN ---
function storePasien($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $stmt = $pdo->prepare("INSERT INTO pasien (no_identitas, nama_pasien, telepon, alamat, tanggal_daftar) VALUES (:no_identitas, :nama_pasien, :telepon, :alamat, :tanggal_daftar)");
            $stmt->execute([
                'no_identitas' => trim($_POST['no_identitas']),
                'nama_pasien' => trim($_POST['nama_pasien']),
                'telepon' => trim($_POST['telepon']),
                'alamat' => trim($_POST['alamat']),
                'tanggal_daftar' => date('Y-m-d') // Terisi otomatis hari ini
            ]);
            $_SESSION['success'] = "Data pasien berhasil ditambahkan.";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal menambah pasien. Pastikan No. Identitas tidak duplikat.";
        }
    }
    header("Location: " . $basePath . "/admin/pasien-penyakit");
    exit;
}

function editPasien($pdo, $basePath) {
    if (!isset($_GET['id'])) { header("Location: " . $basePath . "/admin/pasien-penyakit"); exit; }
    $stmt = $pdo->prepare("SELECT * FROM pasien WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $pasien_edit = $stmt->fetch();
    require 'views/admin/pasien_penyakit/edit_pasien.php';
}

function updatePasien($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $stmt = $pdo->prepare("UPDATE pasien SET no_identitas = :no_identitas, nama_pasien = :nama_pasien, telepon = :telepon, alamat = :alamat WHERE id = :id");
            $stmt->execute([
                'no_identitas' => trim($_POST['no_identitas']),
                'nama_pasien' => trim($_POST['nama_pasien']),
                'telepon' => trim($_POST['telepon']),
                'alamat' => trim($_POST['alamat']),
                'id' => $_POST['id']
            ]);
            $_SESSION['success'] = "Data pasien berhasil diperbarui.";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal memperbarui data pasien.";
        }
    }
    header("Location: " . $basePath . "/admin/pasien-penyakit");
    exit;
}

function deletePasien($pdo, $basePath) {
    if (isset($_GET['id'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM pasien WHERE id = :id");
            $stmt->execute(['id' => $_GET['id']]);
            $_SESSION['success'] = "Data pasien dihapus.";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Pasien tidak bisa dihapus karena sudah memiliki riwayat resep medis.";
        }
    }
    header("Location: " . $basePath . "/admin/pasien-penyakit");
    exit;
}

// --- LOGIKA PENYAKIT (Kamus ICD) ---
function storePenyakit($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $stmt = $pdo->prepare("INSERT INTO penyakit (kode_icd, nama_penyakit, deskripsi) VALUES (:kode_icd, :nama_penyakit, :deskripsi)");
            $stmt->execute([
                'kode_icd' => trim($_POST['kode_icd']),
                'nama_penyakit' => trim($_POST['nama_penyakit']),
                'deskripsi' => trim($_POST['deskripsi'])
            ]);
            $_SESSION['success'] = "Data penyakit berhasil ditambahkan.";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal menyimpan data penyakit.";
        }
    }
    header("Location: " . $basePath . "/admin/pasien-penyakit");
    exit;
}

function editPenyakit($pdo, $basePath) {
    if (!isset($_GET['id'])) { header("Location: " . $basePath . "/admin/pasien-penyakit"); exit; }
    $stmt = $pdo->prepare("SELECT * FROM penyakit WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $penyakit_edit = $stmt->fetch();
    require 'views/admin/pasien_penyakit/edit_penyakit.php';
}

function updatePenyakit($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $stmt = $pdo->prepare("UPDATE penyakit SET kode_icd = :kode_icd, nama_penyakit = :nama_penyakit, deskripsi = :deskripsi WHERE id = :id");
            $stmt->execute([
                'kode_icd' => trim($_POST['kode_icd']),
                'nama_penyakit' => trim($_POST['nama_penyakit']),
                'deskripsi' => trim($_POST['deskripsi']),
                'id' => $_POST['id']
            ]);
            $_SESSION['success'] = "Data penyakit berhasil diperbarui.";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal memperbarui data penyakit.";
        }
    }
    header("Location: " . $basePath . "/admin/pasien-penyakit");
    exit;
}

function deletePenyakit($pdo, $basePath) {
    if (isset($_GET['id'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM penyakit WHERE id = :id");
            $stmt->execute(['id' => $_GET['id']]);
            $_SESSION['success'] = "Data penyakit dihapus.";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Penyakit tidak bisa dihapus karena digunakan pada resep/laporan morbiditas.";
        }
    }
    header("Location: " . $basePath . "/admin/pasien-penyakit");
    exit;
}
?>