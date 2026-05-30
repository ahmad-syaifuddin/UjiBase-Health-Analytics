<?php require 'views/partials/header.php'; ?>

<style>
    @media print {
        aside, header, .no-print { display: none !important; }
        main { width: 100% !important; margin: 0 !important; padding: 0 !important; overflow: visible !important; }
        body { background-color: white !important; font-size: 12px; }
        .print-area { box-shadow: none !important; border: none !important; padding: 0 !important; }
    }
</style>

<div class="mb-6 border-b pb-4 no-print flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-800">Estimasi Kebutuhan Stok</h1>
        <p class="text-gray-500">Analisis pergerakan inventaris dan rekomendasi pengadaan obat</p>
    </div>
    
    <div class="flex space-x-3">
        <button onclick="window.print()" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded-md shadow transition">
            Print Preview
        </button>
        <a href="<?= $basePath ?>/admin/laporan/stok/pdf?tanggal_mulai=<?= $tgl_mulai ?>&tanggal_selesai=<?= $tgl_selesai ?>" target="_blank" 
           class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-6 rounded-md shadow transition">
            Ekspor PDF Laporan
        </a>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 print-area">
    
    <div class="text-center mb-8 hidden print:block">
        <h2 class="text-2xl font-black text-gray-900 tracking-wide uppercase">Klinik UjiBase Health</h2>
        <p class="text-gray-600 text-sm mt-0.5">Sistem Analisis Tren Penyakit & Manajemen Inventaris Obat</p>
        <p class="text-gray-500 text-xs mt-1">
            Laporan Analitik Estimasi Kebutuhan & Pergerakan Stok Obat<br>
            Periode: <?= (!empty($tgl_mulai) && !empty($tgl_selesai)) ? date('d M Y', strtotime($tgl_mulai)) . ' s/d ' . date('d M Y', strtotime($tgl_selesai)) : 'Semua Riwayat Data Terpilih' ?>
        </p>
        <hr class="mt-4 border-gray-800 border-2">
    </div>

    <div class="mb-6 bg-gray-50 p-4 rounded border border-gray-200 no-print">
        <form action="<?= $basePath ?>/admin/laporan/stok" method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Mulai Tanggal</label>
                <input type="date" name="tanggal_mulai" value="<?= htmlspecialchars($tgl_mulai) ?>" 
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm outline-none focus:ring-teal-500 bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="tanggal_selesai" value="<?= htmlspecialchars($tgl_selesai) ?>" 
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm outline-none focus:ring-teal-500 bg-white">
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-5 rounded-md shadow-sm transition text-sm h-[38px]">
                    Kalkulasi Data
                </button>
                <?php if (!empty($tgl_mulai) || !empty($tgl_selesai)): ?>
                    <a href="<?= $basePath ?>/admin/laporan/stok" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-md transition text-sm h-[38px] flex items-center">
                        Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm whitespace-nowrap">
            <thead>
                <tr class="text-gray-800 bg-gray-100 border-b-2 border-gray-300 print:bg-transparent">
                    <th class="p-3 font-bold w-24">Kode</th>
                    <th class="p-3 font-bold">Nama Obat</th>
                    <th class="p-3 font-bold text-center">Batas Min.</th>
                    <th class="p-3 font-bold text-center">Sisa Stok</th>
                    <th class="p-3 font-bold text-center">Kecepatan Keluar</th>
                    <th class="p-3 font-bold text-center">Status Keamanan</th>
                    <th class="p-3 font-bold text-center border-l-2 border-gray-300 bg-teal-50 print:bg-transparent">Rekomendasi Restock</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($laporan)): ?>
                    <?php foreach($laporan as $row): 
                        // --- ALGORITMA ANALISIS STOK ---
                        $sisa = $row['sisa_stok'];
                        $min = $row['stok_minimum'];
                        $keluar = $row['stok_keluar'];
                        
                        // Menentukan Status
                        if ($sisa <= $min) {
                            $status = 'KRITIS';
                            $bg_status = 'bg-red-100 text-red-800';
                        } elseif ($sisa <= ($min * 1.5)) {
                            $status = 'WASPADA';
                            $bg_status = 'bg-yellow-100 text-yellow-800';
                        } else {
                            $status = 'AMAN';
                            $bg_status = 'bg-green-100 text-green-800';
                        }

                        // Menghitung Rekomendasi Restock Cerdas
                        // Rumus: (Batas Min - Sisa) + (Stok Keluar sebagai prediksi kebutuhan)
                        $rekomendasi = 0;
                        if ($status === 'KRITIS' || $status === 'WASPADA') {
                            $kebutuhan_dasar = max($min - $sisa, 0);
                            // Ambil yang paling tinggi antara batas minimum atau riwayat stok keluar periode ini
                            $buffer = ($keluar > $min) ? $keluar : $min;
                            $rekomendasi = $kebutuhan_dasar + $buffer;
                        }
                    ?>
                    <tr class="border-b last:border-b-0 hover:bg-gray-50/50 transition print:hover:bg-transparent">
                        <td class="p-3 font-bold text-teal-700 font-mono"><?= htmlspecialchars($row['kode_obat']) ?></td>
                        <td class="p-3 font-semibold text-gray-800"><?= htmlspecialchars($row['nama_obat']) ?></td>
                        <td class="p-3 text-center text-gray-500 font-bold"><?= $min ?> <?= $row['satuan'] ?></td>
                        <td class="p-3 text-center font-black text-gray-900"><?= $sisa ?> <?= $row['satuan'] ?></td>
                        <td class="p-3 text-center font-semibold text-blue-700"><?= $keluar ?> Keluar</td>
                        <td class="p-3 text-center">
                            <span class="<?= $bg_status ?> px-2.5 py-1 rounded-sm text-[10px] font-extrabold uppercase tracking-widest print:bg-transparent print:text-gray-900 print:p-0 print:text-sm">
                                <?= $status ?>
                            </span>
                        </td>
                        <td class="p-3 text-center border-l-2 border-gray-100 bg-teal-50/30 print:bg-transparent print:border-gray-400">
                            <?php if ($rekomendasi > 0): ?>
                                <span class="font-black text-teal-800 border-b border-teal-500 pb-0.5">+ <?= $rekomendasi ?> <?= $row['satuan'] ?></span>
                            <?php else: ?>
                                <span class="text-gray-400 font-medium">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-400 italic">Belum ada master data obat di dalam sistem.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'views/partials/footer.php'; ?>