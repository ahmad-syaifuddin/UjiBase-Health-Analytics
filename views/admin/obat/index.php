<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Manajemen Data Obat</h1>
    <p class="text-gray-500">Kelola master data obat, stok, dan harga</p>
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

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
    
    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200 lg:col-span-1">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Tambah Obat Baru</h3>
        
        <form action="<?= $basePath ?>/admin/obat/store" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Kategori</label>
                <select name="kategori_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach($kategori as $kat): ?>
                        <option value="<?= $kat['id'] ?>"><?= htmlspecialchars($kat['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Supplier</label>
                <select name="supplier_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
                    <option value="">-- Pilih Supplier --</option>
                    <?php foreach($supplier as $sup): ?>
                        <option value="<?= $sup['id'] ?>"><?= htmlspecialchars($sup['nama_supplier']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kode Obat</label>
                    <div>
                        <input type="text" name="kode_obat" value="<?= $next_kode_obat ?>" readonly 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-gray-100 text-gray-500 cursor-not-allowed outline-none shadow-inner font-mono font-bold">
                </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Satuan</label>
                    <select name="satuan" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                        <option value="Strip">Strip</option>
                        <option value="Botol">Botol</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Kapsul">Kapsul</option>
                        <option value="Tube">Tube</option>
                        <option value="Ampul">Ampul</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Nama Obat</label>
                <input type="text" name="nama_obat" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Stok Awal</label>
                    <input type="number" name="stok" required value="0" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Stok Min.</label>
                    <input type="number" name="stok_minimum" required value="10" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm text-red-600 font-bold">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Harga Beli</label>
                    <input type="number" name="harga_beli" required min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Harga Jual</label>
                    <input type="number" name="harga_jual" required min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Expired</label>
                <input type="date" name="expired_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
            </div>

            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 px-4 rounded-md transition duration-200 mt-2 shadow-sm">
                Simpan Data Obat
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 lg:col-span-3 flex flex-col h-full">
        <div class="p-5 border-b border-gray-100 bg-gray-50 rounded-t-lg">
            <h3 class="text-lg font-bold text-gray-800">Daftar Inventaris Obat</h3>
        </div>
        
        <div class="p-0 overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-gray-500 bg-white border-b">
                        <th class="p-3 font-semibold">Kode</th>
                        <th class="p-3 font-semibold">Nama Obat & Kategori</th>
                        <th class="p-3 font-semibold text-center">Stok</th>
                        <th class="p-3 font-semibold text-right">Harga Jual</th>
                        <th class="p-3 font-semibold text-center">Expired</th>
                        <th class="p-3 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($obat)): ?>
                        <?php foreach($obat as $row): ?>
                        <tr class="hover:bg-gray-50 transition border-b last:border-b-0">
                            <td class="p-3 font-bold text-gray-700"><?= htmlspecialchars($row['kode_obat']) ?></td>
                            <td class="p-3">
                                <div class="font-bold text-teal-800"><?= htmlspecialchars($row['nama_obat']) ?></div>
                                <div class="text-xs text-gray-500 mt-0.5"><?= htmlspecialchars($row['nama_kategori']) ?> &bull; <?= htmlspecialchars($row['satuan']) ?></div>
                            </td>
                            <td class="p-3 text-center">
                                <?php if($row['stok'] <= $row['stok_minimum']): ?>
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded font-bold text-xs"><?= $row['stok'] ?></span>
                                <?php else: ?>
                                    <span class="font-semibold text-gray-700"><?= $row['stok'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="p-3 text-right font-semibold text-gray-800">
                                Rp<?= number_format($row['harga_jual'], 0, ',', '.') ?>
                            </td>
                            <td class="p-3 text-center text-xs <?= (strtotime($row['expired_date']) < time()) ? 'text-red-600 font-bold' : 'text-gray-600' ?>">
                                <?= date('d M Y', strtotime($row['expired_date'])) ?>
                            </td>
                            <td class="p-3 text-center">
                                <a href="<?= $basePath ?>/admin/obat/edit?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 font-semibold mr-2">Edit</a>
                                <a href="<?= $basePath ?>/admin/obat/delete?id=<?= $row['id'] ?>" onclick="return confirm('Hapus obat ini?');" class="text-red-600 hover:text-red-800 font-semibold">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-400 italic">Belum ada data obat.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'views/partials/footer.php'; ?>