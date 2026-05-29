 <?php require 'views/partials/header.php'; ?>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
    
    <div class="space-y-8">
        
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Visi Misi & Status Sistem</h3>
            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                Sistem analisis ini dirancang untuk memantau tren penyakit (Morbiditas) dan mengkalkulasi kebutuhan stok efektif obat guna menghindari kekosongan stok di klinik.
            </p>
            <div class="inline-block bg-teal-50 text-teal-700 px-3 py-1.5 rounded border border-teal-200 text-sm font-semibold">
                Status: Berjalan Optimal
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-red-500">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Peringatan Stok Obat Kritis</h3>
            
            <?php if (!empty($stokKritis)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600">
                                <th class="p-3 border-b">Nama Obat</th>
                                <th class="p-3 border-b text-center">Sisa Stok</th>
                                <th class="p-3 border-b text-center">Min. Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($stokKritis as $obat): ?>
                            <tr class="hover:bg-red-50 transition">
                                <td class="p-3 border-b text-red-700 font-medium"><?= htmlspecialchars($obat['nama']) ?></td>
                                <td class="p-3 border-b text-center text-red-600 font-bold"><?= $obat['sisa'] ?></td>
                                <td class="p-3 border-b text-center text-gray-500"><?= $obat['min'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-gray-500 text-sm italic py-4 text-center bg-gray-50 rounded border border-dashed border-gray-300">
                    Stok obat dalam kondisi aman. Tidak ada peringatan.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 flex flex-col h-full">
        <div class="p-6 border-b border-gray-100 bg-gray-50 rounded-t-lg">
            <h3 class="text-lg font-bold text-gray-800">Aktivitas Transaksi Terakhir</h3>
        </div>
        
        <div class="p-0 overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-gray-500 bg-white border-b">
                        <th class="p-4 font-semibold">Kode Transaksi</th>
                        <th class="p-4 font-semibold text-center">Status</th>
                        <th class="p-4 font-semibold text-right">Total Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transaksiTerbaru)): ?>
                        <?php foreach($transaksiTerbaru as $trx): ?>
                        <tr class="hover:bg-gray-50 transition border-b last:border-b-0">
                            <td class="p-4 font-medium text-gray-700"><?= htmlspecialchars($trx['kode']) ?></td>
                            <td class="p-4 text-center">
                                <span class="bg-teal-100 text-teal-800 px-2.5 py-1 rounded-sm text-xs font-bold uppercase tracking-wide">
                                    <?= htmlspecialchars($trx['status']) ?>
                                </span>
                            </td>
                            <td class="p-4 text-right text-gray-900 font-bold">
                                Rp<?= number_format($trx['total'], 0, ',', '.') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="p-6 text-center text-gray-400 italic">Belum ada transaksi tercatat.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php require 'views/partials/footer.php'; ?>