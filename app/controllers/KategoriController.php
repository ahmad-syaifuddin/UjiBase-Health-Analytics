<?php
// app/controllers/KategoriController.php

function indexKategori($pdo, $basePath) {
    // Ambil data kategori
    try {
        $stmt = $pdo->query("SELECT * FROM kategori ORDER BY id DESC");
        $kategori = $stmt->fetchAll();
    } catch (PDOException $e) {
        $kategori = [];
    }

    // Ambil data supplier
    try {
        $stmtSup = $pdo->query("SELECT * FROM supplier ORDER BY id DESC");
        $supplier = $stmtSup->fetchAll();
    } catch (PDOException $e) {
        $supplier = [];
    }
    
    require 'views/admin/kategori/index.php';
}

function storeKategori($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama_kategori = trim($_POST['nama_kategori']);

        if (!empty($nama_kategori)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO kategori (nama_kategori) VALUES (:nama)");
                $stmt->execute(['nama' => $nama_kategori]);
                $_SESSION['success'] = "Kategori berhasil ditambahkan!";
            } catch (PDOException $e) {
                $_SESSION['error'] = "Gagal menyimpan data.";
            }
        } else {
            $_SESSION['error'] = "Nama Kategori tidak boleh kosong.";
        }
    }
    
    // Kembalikan ke halaman kategori
    header("Location: " . $basePath . "/admin/kategori-supplier");
    exit;
}

// Menampilkan form edit
function editKategori($pdo, $basePath) {
    if (!isset($_GET['id'])) {
        header("Location: " . $basePath . "/admin/kategori-supplier");
        exit;
    }

    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM kategori WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $kategori_edit = $stmt->fetch();

    if (!$kategori_edit) {
        $_SESSION['error'] = "Data tidak ditemukan.";
        header("Location: " . $basePath . "/admin/kategori-supplier");
        exit;
    }

    require 'views/admin/kategori/edit.php';
}

// Memproses update data ke database
function updateKategori($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $nama_kategori = trim($_POST['nama_kategori']);

        if (!empty($nama_kategori)) {
            try {
                $stmt = $pdo->prepare("UPDATE kategori SET nama_kategori = :nama WHERE id = :id");
                $stmt->execute(['nama' => $nama_kategori, 'id' => $id]);
                $_SESSION['success'] = "Kategori berhasil diperbarui!";
            } catch (PDOException $e) {
                $_SESSION['error'] = "Gagal mengupdate data.";
            }
        } else {
            $_SESSION['error'] = "Nama Kategori tidak boleh kosong.";
        }
    }
    header("Location: " . $basePath . "/admin/kategori-supplier");
    exit;
}

// Memproses hapus data
function deleteKategori($pdo, $basePath) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            // Relasi ON DELETE RESTRICT di database akan otomatis mencegah error 
            // jika kategori ini sudah dipakai di tabel obat
            $stmt = $pdo->prepare("DELETE FROM kategori WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $_SESSION['success'] = "Kategori berhasil dihapus!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal dihapus! Kategori ini mungkin sedang digunakan oleh data Obat.";
        }
    }
    header("Location: " . $basePath . "/admin/kategori-supplier");
    exit;
}


// --- LOGIKA SUPPLIER ---

function storeSupplier($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama = trim($_POST['nama_supplier']);
        $telepon = trim($_POST['telepon']);
        $alamat = trim($_POST['alamat']);

        if (!empty($nama) && !empty($telepon)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO supplier (nama_supplier, telepon, alamat) VALUES (:nama, :telepon, :alamat)");
                $stmt->execute(['nama' => $nama, 'telepon' => $telepon, 'alamat' => $alamat]);
                $_SESSION['success'] = "Supplier berhasil ditambahkan!";
            } catch (PDOException $e) {
                $_SESSION['error'] = "Gagal menyimpan data supplier.";
            }
        } else {
            $_SESSION['error'] = "Nama dan Telepon tidak boleh kosong.";
        }
    }
    header("Location: " . $basePath . "/admin/kategori-supplier");
    exit;
}

function editSupplier($pdo, $basePath) {
    if (!isset($_GET['id'])) {
        header("Location: " . $basePath . "/admin/kategori-supplier");
        exit;
    }
    $stmt = $pdo->prepare("SELECT * FROM supplier WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $supplier_edit = $stmt->fetch();

    if (!$supplier_edit) {
        $_SESSION['error'] = "Data tidak ditemukan.";
        header("Location: " . $basePath . "/admin/kategori-supplier");
        exit;
    }
    require 'views/admin/kategori/edit_supplier.php';
}

function updateSupplier($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $nama = trim($_POST['nama_supplier']);
        $telepon = trim($_POST['telepon']);
        $alamat = trim($_POST['alamat']);

        if (!empty($nama)) {
            try {
                $stmt = $pdo->prepare("UPDATE supplier SET nama_supplier = :nama, telepon = :telepon, alamat = :alamat WHERE id = :id");
                $stmt->execute(['nama' => $nama, 'telepon' => $telepon, 'alamat' => $alamat, 'id' => $id]);
                $_SESSION['success'] = "Supplier berhasil diperbarui!";
            } catch (PDOException $e) {
                $_SESSION['error'] = "Gagal mengupdate data supplier.";
            }
        }
    }
    header("Location: " . $basePath . "/admin/kategori-supplier");
    exit;
}

function deleteSupplier($pdo, $basePath) {
    if (isset($_GET['id'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM supplier WHERE id = :id");
            $stmt->execute(['id' => $_GET['id']]);
            $_SESSION['success'] = "Supplier berhasil dihapus!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal dihapus! Supplier ini mungkin sedang digunakan oleh data Obat.";
        }
    }
    header("Location: " . $basePath . "/admin/kategori-supplier");
    exit;
}
?>