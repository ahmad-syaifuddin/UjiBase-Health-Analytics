<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Edit Data Obat</h1>
    <p class="text-gray-500">Perbarui inventaris, stok, atau penyesuaian harga</p>
</div>

<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 max-w-3xl">
    <form action="<?= $basePath ?>/admin/obat/update" method="POST" class="space-y-5">
        <input type="hidden" name="id" value="<?= $obat_edit['id'] ?>">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                <select name="kategori_id" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none transition">
                    <?php foreach($kategori as $kat): ?>
                        <option value="<?= $kat['id'] ?>" <?= ($obat_edit['kategori_id'] == $kat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($kat['nama_kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Supplier</label>
                <select name="supplier_id" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none transition">
                    <?php foreach($supplier as $sup): ?>
                        <option value="<?= $sup['id'] ?>" <?= ($obat_edit['supplier_id'] == $sup['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sup['nama_supplier']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Kode Obat</label>
                <input type="text" name="kode_obat" required value="<?= htmlspecialchars($obat_edit['kode_obat']) ?>" readonly 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed outline-none font-mono font-bold">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Obat</label>
                <input type="text" name="nama_obat" required value="<?= htmlspecialchars($obat_edit['nama_obat']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Satuan</label>
                    <select name="satuan" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none">
                        <?php 
                        $satuans = ['Strip', 'Botol', 'Tablet', 'Kapsul', 'Tube', 'Ampul'];
                        foreach($satuans as $s): 
                        ?>
                            <option value="<?= $s ?>" <?= ($obat_edit['satuan'] == $s) ? 'selected' : '' ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Expired</label>
                    <input type="date" name="expired_date" required value="<?= $obat_edit['expired_date'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Sisa Stok</label>
                    <input type="number" name="stok" required min="0" value="<?= $obat_edit['stok'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1 text-red-600">Batas Stok Kritis</label>
                    <input type="number" name="stok_minimum" required min="1" value="<?= $obat_edit['stok_minimum'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-red-500 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Harga Beli</label>
                <input type="number" name="harga_beli" required min="0" value="<?= $obat_edit['harga_beli'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Harga Jual</label>
                <input type="number" name="harga_jual" required min="0" value="<?= $obat_edit['harga_jual'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none">
            </div>
        </div>
        
        <div class="flex space-x-3 pt-6 border-t mt-6">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 px-6 rounded-md transition duration-200 shadow-sm">
                Simpan Perubahan
            </button>
            <a href="<?= $basePath ?>/admin/obat" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-md transition duration-200">
                Batal
            </a>
        </div>
    </form>
</div>

<?php require 'views/partials/footer.php'; ?>