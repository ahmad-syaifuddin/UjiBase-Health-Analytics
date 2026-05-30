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

elseif ($uri === '/admin/kategori-supplier') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/KategoriController.php';
    indexKategori($pdo, $basePath);
}
elseif ($uri === '/admin/kategori/store') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/KategoriController.php';
    storeKategori($pdo, $basePath);
}
elseif ($uri === '/admin/kategori/edit') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/KategoriController.php';
    editKategori($pdo, $basePath);
}
elseif ($uri === '/admin/kategori/update') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/KategoriController.php';
    updateKategori($pdo, $basePath);
}
elseif ($uri === '/admin/kategori/delete') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/KategoriController.php';
    deleteKategori($pdo, $basePath);
}
// Rute Manajemen Supplier (Di dalam menu Kategori & Supplier)
elseif ($uri === '/admin/supplier/store') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/KategoriController.php';
    storeSupplier($pdo, $basePath);
}
elseif ($uri === '/admin/supplier/edit') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/KategoriController.php';
    editSupplier($pdo, $basePath);
}
elseif ($uri === '/admin/supplier/update') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/KategoriController.php';
    updateSupplier($pdo, $basePath);
}
elseif ($uri === '/admin/supplier/delete') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/KategoriController.php';
    deleteSupplier($pdo, $basePath);
}
// Rute Manajemen Data Obat
elseif ($uri === '/admin/obat') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/ObatController.php';
    indexObat($pdo, $basePath);
}
elseif ($uri === '/admin/obat/store') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/ObatController.php';
    storeObat($pdo, $basePath);
}
elseif ($uri === '/admin/obat/edit') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/ObatController.php';
    editObat($pdo, $basePath);
}
elseif ($uri === '/admin/obat/update') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/ObatController.php';
    updateObat($pdo, $basePath);
}
elseif ($uri === '/admin/obat/delete') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/ObatController.php';
    deleteObat($pdo, $basePath);
}

// Rute Tampilan Utama Pasien & Penyakit
elseif ($uri === '/admin/pasien-penyakit') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') {
        header("Location: " . $basePath . "/admin/dashboard");
        exit;
    }
    require_once 'app/controllers/PasienPenyakitController.php';
    indexPasienPenyakit($pdo, $basePath);
}

// Rute Aksi Pasien
elseif ($uri === '/admin/pasien/store') {
    require_once 'app/controllers/PasienPenyakitController.php'; storePasien($pdo, $basePath);
}
elseif ($uri === '/admin/pasien/edit') {
    require_once 'app/controllers/PasienPenyakitController.php'; editPasien($pdo, $basePath);
}
elseif ($uri === '/admin/pasien/update') {
    require_once 'app/controllers/PasienPenyakitController.php'; updatePasien($pdo, $basePath);
}
elseif ($uri === '/admin/pasien/delete') {
    require_once 'app/controllers/PasienPenyakitController.php'; deletePasien($pdo, $basePath);
}

// Rute Aksi Penyakit (ICD)
elseif ($uri === '/admin/penyakit/store') {
    require_once 'app/controllers/PasienPenyakitController.php'; storePenyakit($pdo, $basePath);
}
elseif ($uri === '/admin/penyakit/edit') {
    require_once 'app/controllers/PasienPenyakitController.php'; editPenyakit($pdo, $basePath);
}
elseif ($uri === '/admin/penyakit/update') {
    require_once 'app/controllers/PasienPenyakitController.php'; updatePenyakit($pdo, $basePath);
}
elseif ($uri === '/admin/penyakit/delete') {
    require_once 'app/controllers/PasienPenyakitController.php'; deletePenyakit($pdo, $basePath);
}
// Rute Manajemen Pengguna (Users)
elseif ($uri === '/admin/users') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/UserController.php'; indexUsers($pdo, $basePath);
}
elseif ($uri === '/admin/users/store') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/UserController.php'; storeUser($pdo, $basePath);
}
elseif ($uri === '/admin/users/edit') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/UserController.php'; editUser($pdo, $basePath);
}
elseif ($uri === '/admin/users/update') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/UserController.php'; updateUser($pdo, $basePath);
}
elseif ($uri === '/admin/users/delete') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/UserController.php'; deleteUser($pdo, $basePath);
}
// Rute Input Resep Dokter (Fase 2)
elseif ($uri === '/admin/resep') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/ResepController.php'; indexResep($pdo, $basePath);
}
elseif ($uri === '/admin/resep/store') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/ResepController.php'; storeResep($pdo, $basePath);
}
elseif ($uri === '/admin/resep/edit') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/ResepController.php'; editResep($pdo, $basePath);
}
elseif ($uri === '/admin/resep/update') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/ResepController.php'; updateResep($pdo, $basePath);
}
elseif ($uri === '/admin/resep/delete') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/ResepController.php'; deleteResep($pdo, $basePath);
}

// Rute Kasir & Transaksi (Fase 2)
elseif ($uri === '/admin/transaksi') {
    require_once 'app/controllers/TransaksiController.php';
    indexTransaksi($pdo, $basePath);
}
elseif ($uri === '/admin/transaksi/add-item') {
    require_once 'app/controllers/TransaksiController.php';
    addToCart($pdo, $basePath);
}
elseif ($uri === '/admin/transaksi/remove-item') {
    require_once 'app/controllers/TransaksiController.php';
    removeFromCart($basePath);
}
elseif ($uri === '/admin/transaksi/checkout') {
    require_once 'app/controllers/TransaksiController.php';
    checkoutTransaksi($pdo, $basePath);
}
elseif ($uri === '/admin/transaksi/riwayat') {
    if (empty($_SESSION['user_id'])) { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/TransaksiController.php';
    riwayatTransaksi($pdo, $basePath);
}

// Rute Laporan Analitik (Fase 3)
elseif ($uri === '/admin/laporan/morbiditas') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { 
        header("Location: " . $basePath . "/admin/dashboard"); 
        exit; 
    }
    require_once 'app/controllers/LaporanController.php';
    indexMorbiditas($pdo, $basePath);
}
elseif ($uri === '/admin/laporan/morbiditas/pdf') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/LaporanController.php';
    exportMorbiditasPDF($pdo, $basePath);
}
// Rute Laporan Analitik Stok Obat
elseif ($uri === '/admin/laporan/stok') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/LaporanController.php';
    indexStok($pdo, $basePath);
}
elseif ($uri === '/admin/laporan/stok/pdf') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/LaporanController.php';
    exportStokPDF($pdo, $basePath);
}
else {
    http_response_code(404);
    echo "<h1 style='text-align:center; margin-top:50px;'>404 - Halaman Tidak Ditemukan</h1>";
}
?>