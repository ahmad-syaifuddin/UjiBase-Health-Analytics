<?php
// app/controllers/ObatController.php

function indexObat($pdo, $basePath) {
    // 1. Ambil data obat beserta nama kategori dan supplier
    try {
        $query = "SELECT o.*, k.nama_kategori, s.nama_supplier 
                  FROM obat o 
                  JOIN kategori k ON o.kategori_id = k.id 
                  JOIN supplier s ON o.supplier_id = s.id 
                  ORDER BY o.id DESC";
        $stmt = $pdo->query($query);
        $obat = $stmt->fetchAll();
    } catch (PDOException $e) {
        $obat = [];
    }

    // 2. Ambil data referensi dropdown
    $kategori = $pdo->query("SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC")->fetchAll();
    $supplier = $pdo->query("SELECT id, nama_supplier FROM supplier ORDER BY nama_supplier ASC")->fetchAll();

    // 3. LOGIKA AUTO-NUMBERING KODE OBAT (OBT-001, OBT-002, dst)
    $stmtKode = $pdo->query("SELECT kode_obat FROM obat ORDER BY id DESC LIMIT 1");
    $lastKode = $stmtKode->fetchColumn();

    if ($lastKode) {
        // Potong string "OBT-" (4 karakter pertama), ambil angkanya, jadikan integer, lalu +1
        $angka_selanjutnya = (int) substr($lastKode, 4) + 1;
    } else {
        // Jika tabel obat masih kosong sama sekali
        $angka_selanjutnya = 1;
    }
    // Gabungkan kembali dengan format OBT- dan tambahkan angka 0 di depan agar selalu 3 digit
    $next_kode_obat = 'OBT-' . str_pad($angka_selanjutnya, 3, '0', STR_PAD_LEFT);

    require 'views/admin/obat/index.php';
}

function storeObat($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $stmt = $pdo->prepare("INSERT INTO obat (kategori_id, supplier_id, kode_obat, nama_obat, satuan, stok, stok_minimum, harga_beli, harga_jual, expired_date) 
                                   VALUES (:kategori_id, :supplier_id, :kode_obat, :nama_obat, :satuan, :stok, :stok_minimum, :harga_beli, :harga_jual, :expired_date)");
            
            $stmt->execute([
                'kategori_id' => $_POST['kategori_id'],
                'supplier_id' => $_POST['supplier_id'],
                'kode_obat' => trim($_POST['kode_obat']),
                'nama_obat' => trim($_POST['nama_obat']),
                'satuan' => $_POST['satuan'],
                'stok' => $_POST['stok'],
                'stok_minimum' => $_POST['stok_minimum'],
                'harga_beli' => $_POST['harga_beli'],
                'harga_jual' => $_POST['harga_jual'],
                'expired_date' => $_POST['expired_date']
            ]);
            $_SESSION['success'] = "Data obat berhasil ditambahkan!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal menyimpan data. Pastikan Kode Obat tidak duplikat.";
        }
    }
    header("Location: " . $basePath . "/admin/obat");
    exit;
}

function editObat($pdo, $basePath) {
    if (!isset($_GET['id'])) {
        header("Location: " . $basePath . "/admin/obat");
        exit;
    }
    
    // Ambil data obat yang mau diedit
    $stmt = $pdo->prepare("SELECT * FROM obat WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $obat_edit = $stmt->fetch();

    if (!$obat_edit) {
        $_SESSION['error'] = "Data tidak ditemukan.";
        header("Location: " . $basePath . "/admin/obat");
        exit;
    }

    // Ambil opsi referensi untuk dropdown
    $kategori = $pdo->query("SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC")->fetchAll();
    $supplier = $pdo->query("SELECT id, nama_supplier FROM supplier ORDER BY nama_supplier ASC")->fetchAll();

    require 'views/admin/obat/edit.php';
}

function updateObat($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $stmt = $pdo->prepare("UPDATE obat SET 
                kategori_id = :kategori_id, supplier_id = :supplier_id, kode_obat = :kode_obat, 
                nama_obat = :nama_obat, satuan = :satuan, stok = :stok, stok_minimum = :stok_minimum, 
                harga_beli = :harga_beli, harga_jual = :harga_jual, expired_date = :expired_date 
                WHERE id = :id");
            
            $stmt->execute([
                'kategori_id' => $_POST['kategori_id'],
                'supplier_id' => $_POST['supplier_id'],
                'kode_obat' => trim($_POST['kode_obat']),
                'nama_obat' => trim($_POST['nama_obat']),
                'satuan' => $_POST['satuan'],
                'stok' => $_POST['stok'],
                'stok_minimum' => $_POST['stok_minimum'],
                'harga_beli' => $_POST['harga_beli'],
                'harga_jual' => $_POST['harga_jual'],
                'expired_date' => $_POST['expired_date'],
                'id' => $_POST['id']
            ]);
            $_SESSION['success'] = "Data obat berhasil diperbarui!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal mengupdate data obat.";
        }
    }
    header("Location: " . $basePath . "/admin/obat");
    exit;
}

function deleteObat($pdo, $basePath) {
    if (isset($_GET['id'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM obat WHERE id = :id");
            $stmt->execute(['id' => $_GET['id']]);
            $_SESSION['success'] = "Data obat berhasil dihapus!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal dihapus! Obat ini mungkin sudah tercatat dalam riwayat transaksi.";
        }
    }
    header("Location: " . $basePath . "/admin/obat");
    exit;
}
?>