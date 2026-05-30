<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Riwayat Transaksi</h1>
    <p class="text-gray-500">Pantau rekapitulasi penjualan dan histori pembayaran</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
    
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 lg:col-span-1">
        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Pendapatan Hari Ini</h3>
        
        <?php if (!empty($pendapatan_hari_ini)): ?>
            <div class="text-3xl font-black text-teal-700 break-words">
                Rp<?= number_format($pendapatan_hari_ini, 0, ',', '.') ?>
            </div>
            <p class="text-xs text-gray-400 mt-2">Total akumulasi dari seluruh transaksi lunas pada tanggal <?= date('d M Y') ?>.</p>
        <?php else: ?>
            <div class="text-gray-400 italic text-sm mt-2 p-3 bg-gray-50 rounded border border-dashed">
                Belum ada pemasukan yang tercatat pada hari ini.
            </div>
        <?php endif; ?>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 lg:col-span-3 flex flex-col h-full">
        <div class="p-5 border-b border-gray-100 bg-gray-50 rounded-t-lg">
            <h3 class="text-lg font-bold text-gray-800">Daftar Transaksi Selesai</h3>
        </div>

        <div class="p-0 overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-gray-500 bg-white border-b">
                        <th class="p-4 font-semibold">Kode Transaksi</th>
                        <th class="p-4 font-semibold">Waktu Pembayaran</th>
                        <th class="p-4 font-semibold">Kasir / Petugas</th>
                        <th class="p-4 font-semibold text-center">Status</th>
                        <th class="p-4 font-semibold text-right">Total Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($riwayat)): ?>
                        <?php foreach($riwayat as $row): ?>
                        <tr class="hover:bg-gray-50 transition border-b last:border-b-0">
                            <td class="p-4 font-bold text-teal-700"><?= htmlspecialchars($row['kode_transaksi']) ?></td>
                            <td class="p-4 text-gray-600 font-medium">
                                <?= date('d M Y, H:i', strtotime($row['tanggal_transaksi'])) ?>
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-gray-800"><?= htmlspecialchars($row['nama_kasir'] ?? 'Sistem') ?></div>
                                <?php if(!empty($row['resep_id'])): ?>
                                    <div class="text-xs text-blue-600 mt-0.5">Rujukan: <?= htmlspecialchars($row['nama_dokter']) ?></div>
                                <?php else: ?>
                                    <div class="text-xs text-gray-500 mt-0.5">Obat Bebas</div>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 text-center">
                                <span class="bg-green-100 text-green-800 px-2.5 py-1 rounded-sm text-xs font-bold uppercase tracking-wide">
                                    <?= htmlspecialchars($row['status_pembayaran']) ?>
                                </span>
                            </td>
                            <td class="p-4 text-right text-gray-900 font-bold">
                                Rp<?= number_format($row['total_harga'], 0, ',', '.') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400 italic">Belum ada riwayat transaksi yang tersimpan di sistem.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'views/partials/footer.php'; ?>