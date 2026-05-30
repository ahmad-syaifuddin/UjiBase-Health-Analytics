<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Kasir & Transaksi Pelayanan</h1>
    <p class="text-gray-500">Proses transaksi penebusan obat harian</p>
</div>

<?php if(isset($_SESSION['success'])): ?>
    <div class="bg-green-50 text-green-700 p-3 rounded-md mb-6 text-sm font-semibold border border-green-200">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>
<?php if(isset($_SESSION['error'])): ?>
    <div class="bg-red-50 text-red-700 p-3 rounded-md mb-6 text-sm font-semibold border border-red-200">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    
    <div class="space-y-6 lg:col-span-1">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Pilih Item</h3>
            
            <form action="<?= $basePath ?>/admin/transaksi/add-item" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Rujukan Resep Dokter (Opsional)</label>
                    <select name="resep_id" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm outline-none focus:ring-teal-500">
                        <option value="">-- Pembelian Obat Bebas (Tanpa Resep) --</option>
                        <?php foreach($resep as $r): ?>
                            <option value="<?= $r['id'] ?>" <?= ($_SESSION['resep_id'] == $r['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($r['nama_pasien']) ?> (Antrean Resep #<?= $r['id'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Pilih Obat</label>
                    <select name="obat_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm outline-none focus:ring-teal-500">
                        <option value="">-- Pilih Obat --</option>
                        <?php foreach($obat as $o): ?>
                            <option value="<?= $o['id'] ?>"><?= htmlspecialchars($o['kode_obat']) ?> - <?= htmlspecialchars($o['nama_obat']) ?> (Stok: <?= $o['stok'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Jumlah Batas Pengambilan</label>
                    <input type="number" name="jumlah" required min="1" value="1" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm outline-none focus:ring-teal-500">
                </div>

                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-md shadow-sm transition">
                    Masukkan ke Keranjang
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 flex flex-col h-full">
        <div class="p-5 border-b border-gray-100 bg-gray-50 rounded-t-lg">
            <h3 class="text-lg font-bold text-gray-800">Keranjang Belanja Transaksi</h3>
        </div>

        <div class="p-0 overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-gray-500 bg-white border-b">
                        <th class="p-4 font-semibold">Nama Item Obat</th>
                        <th class="p-4 font-semibold text-right">Harga Satuan</th>
                        <th class="p-4 font-semibold text-center w-24">Kuantitas</th>
                        <th class="p-4 font-semibold text-right">Subtotal</th>
                        <th class="p-4 font-semibold text-center w-16">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grandTotal = 0;
                    if (!empty($_SESSION['cart'])): 
                    ?>
                        <?php foreach($_SESSION['cart'] as $id => $item): 
                            $grandTotal += $item['subtotal'];
                        ?>
                        <tr class="hover:bg-gray-50 border-b last:border-b-0">
                            <td class="p-4 font-medium text-gray-800"><?= htmlspecialchars($item['nama']) ?></td>
                            <td class="p-4 text-right text-gray-600">Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                            <td class="p-4 text-center text-gray-700 font-semibold"><?= $item['jumlah'] ?></td>
                            <td class="p-4 text-right text-gray-900 font-bold">Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                            <td class="p-4 text-center">
                                <a href="<?= $basePath ?>/admin/transaksi/remove-item?id=<?= $id ?>" class="text-red-600 hover:text-red-800 font-bold">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400 italic bg-gray-200/20">Keranjang transaksi masih kosong. Silakan pilih obat di bagian kiri.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($grandTotal > 0): ?>
            <div class="p-6 bg-gray-50 border-t border-gray-100 rounded-b-lg flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pembayaran Akhir</p>
                    <p class="text-2xl font-black text-teal-700">Rp<?= number_format($grandTotal, 0, ',', '.') ?></p>
                </div>
                
                <form action="<?= $basePath ?>/admin/transaksi/checkout" method="POST" class="flex-1 md:flex-none">
                    <input type="hidden" name="resep_id" value="<?= htmlspecialchars($_SESSION['resep_id']) ?>">
                    <button type="submit" onclick="return confirm('Konfirmasi pembayaran Lunas dan simpan transaksi ini?')" 
                        class="w-full md:w-auto bg-teal-600 hover:bg-teal-700 text-white font-extrabold py-3 px-8 rounded-md shadow transition duration-200 uppercase tracking-wide text-sm">
                        Proses Pembayaran & Cetak
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require 'views/partials/footer.php'; ?>