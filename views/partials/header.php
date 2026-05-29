<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem - UjiBase Health Analytics</title>
    <link rel="stylesheet" href="<?= $basePath === '/' ? '' : $basePath ?>/public/css/output.css">
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800 flex h-screen overflow-hidden">

    <aside class="w-64 bg-gray-900 text-white flex flex-col shadow-lg">
        <div class="p-5 border-b border-gray-800">
            <h2 class="text-xl font-extrabold text-teal-400 tracking-wider">UjiBase Health</h2>
            <p class="text-xs text-gray-400 mt-1">Panel <?= htmlspecialchars($_SESSION['role'] ?? 'Pengguna'); ?></p>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <a href="<?= $basePath ?>/admin/dashboard" class="block px-4 py-2.5 bg-teal-600 rounded-md text-sm font-medium transition shadow-sm hover:bg-teal-500">
                Dashboard Analisis
            </a>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Kepala Klinik'): ?>
                
                <div class="pt-5 pb-2">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Master Data</p>
                </div>
                <a href="<?= $basePath ?>/admin/kategori-supplier" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md text-sm font-medium transition">
                    Kategori & Supplier
                </a>
                <a href="<?= $basePath ?>/admin/obat" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md text-sm font-medium transition">
                    Data Obat
                </a>
                <a href="<?= $basePath ?>/admin/pasien-penyakit" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md text-sm font-medium transition">
                    Pasien & Penyakit (ICD)
                </a>
                <a href="<?= $basePath ?>/admin/users" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md text-sm font-medium transition">
                    Manajemen User
                </a>

            <?php endif; ?>

            <div class="pt-5 pb-2">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Layanan</p>
            </div>
            
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Kepala Klinik'): ?>
                <a href="<?= $basePath ?>/admin/resep" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md text-sm font-medium transition">
                    Input Resep Dokter
                </a>
            <?php endif; ?>
            
            <a href="<?= $basePath ?>/admin/transaksi" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md text-sm font-medium transition">
                Kasir & Transaksi
            </a>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Kepala Klinik'): ?>
                <div class="pt-5 pb-2">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Laporan Analitik</p>
                </div>
                <a href="<?= $basePath ?>/admin/laporan/morbiditas" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md text-sm font-medium transition">
                    Indeks Morbiditas
                </a>
                <a href="<?= $basePath ?>/admin/laporan/stok" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-md text-sm font-medium transition">
                    Estimasi Kebutuhan Stok
                </a>
            <?php endif; ?>

        </nav>

        <div class="p-4 border-t border-gray-800">
            <a href="<?= $basePath ?>/logout" class="block w-full text-center px-4 py-2 bg-red-600 hover:bg-red-700 rounded-md text-sm font-medium transition shadow-sm">
                Logout
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="bg-white shadow-sm border-b px-8 py-4 flex justify-between items-center z-10">
            <h2 class="text-lg font-semibold text-gray-700">Sistem Dasbor</h2>
            
            <div class="text-sm font-medium text-gray-500">
                Selamat datang, 
                <span class="text-teal-600 font-bold">
                    <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Pengguna'); ?>
                </span>
            </div>
        </header>

        <div class="flex-1 overflow-auto p-8 bg-gray-50">