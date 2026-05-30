<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4 flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-800">Indeks Morbiditas Pasien</h1>
        <p class="text-gray-500">Peringkat tren penyakit terbanyak berdasarkan diagnosis resep harian</p>
    </div>
    
    <a href="<?= $basePath ?>/admin/laporan/morbiditas/pdf?tanggal_mulai=<?= $tgl_mulai ?>&tanggal_selesai=<?= $tgl_selesai ?>" target="_blank" 
       class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-6 rounded-md shadow transition">
        Ekspor PDF Laporan
    </a>
</div>

<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
    <div class="mb-6 bg-gray-50 p-4 rounded border border-gray-200">
        <form action="<?= $basePath ?>/admin/laporan/morbiditas" method="GET" class="flex flex-wrap items-end gap-4">
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
                    Filter Rentang
                </button>
                <?php if (!empty($tgl_mulai) || !empty($tgl_selesai)): ?>
                    <a href="<?= $basePath ?>/admin/laporan/morbiditas" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-md transition text-sm h-[38px] flex items-center">
                        Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="text-gray-800 bg-gray-100 border-b-2 border-gray-300">
                    <th class="p-4 font-bold text-center w-16">Rank</th>
                    <th class="p-4 font-bold w-32">Kode ICD</th>
                    <th class="p-4 font-bold">Klasifikasi Penyakit</th>
                    <th class="p-4 font-bold text-center">Total Kasus</th>
                    <th class="p-4 font-bold text-center">Persentase</th>
                    <th class="p-4 font-bold text-center">Status Tren</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($laporan)): ?>
                    <?php $no = 1; foreach($laporan as $row): 
                        // Perhitungan Analitis
                        $persentase = ($row['jumlah_kasus'] / $total_semua_kasus) * 100;
                        $status_tren = ($persentase >= 30) ? 'WASPADA' : (($persentase >= 10) ? 'MENINGKAT' : 'NORMAL');
                        $bg_status = ($status_tren == 'WASPADA') ? 'bg-red-100 text-red-800' : (($status_tren == 'MENINGKAT') ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
                    ?>
                    <tr class="border-b last:border-b-0 hover:bg-gray-50/50 transition">
                        <td class="p-4 text-center font-bold text-gray-500"><?= $no++ ?></td>
                        <td class="p-4 font-bold text-teal-700 font-mono"><?= htmlspecialchars($row['kode_icd']) ?></td>
                        <td class="p-4 font-semibold text-gray-800"><?= htmlspecialchars($row['nama_penyakit']) ?></td>
                        <td class="p-4 text-center font-bold text-gray-900"><?= $row['jumlah_kasus'] ?> Kasus</td>
                        <td class="p-4 text-center text-gray-600 font-medium"><?= number_format($persentase, 1) ?>%</td>
                        <td class="p-4 text-center">
                            <span class="<?= $bg_status ?> px-2.5 py-1 rounded-sm text-xs font-bold uppercase tracking-wide">
                                <?= $status_tren ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="bg-gray-50 border-t-2 border-gray-300">
                        <td colspan="3" class="p-4 text-right font-extrabold text-gray-800">TOTAL SELURUH KASUS:</td>
                        <td class="p-4 text-center font-extrabold text-teal-800"><?= $total_semua_kasus ?> Kasus</td>
                        <td colspan="2"></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400 italic">Tidak ditemukan rekam medis penyakit pada rentang tanggal tersebut.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'views/partials/footer.php'; ?>