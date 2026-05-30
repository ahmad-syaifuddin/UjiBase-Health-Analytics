<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Manajemen Kategori & Supplier</h1>
    <p class="text-gray-500">Kelola data referensi apotek</p>
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
    
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 lg:col-span-1">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Tambah Kategori Baru</h3>
        <form action="<?= $basePath ?>/admin/kategori/store" method="POST" class="space-y-4">
            <div>
                <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori Obat</label>
                <input type="text" id="nama_kategori" name="nama_kategori" required placeholder="Cth: Antibiotik"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 outline-none transition">
            </div>
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-md transition duration-200 shadow-sm">
                Simpan Kategori
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 lg:col-span-2 flex flex-col h-full">
        <div class="p-6 border-b border-gray-100 bg-gray-50 rounded-t-lg">
            <h3 class="text-lg font-bold text-gray-800">Daftar Kategori Obat</h3>
        </div>
        
        <div class="p-0 overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-gray-500 bg-white border-b">
                        <th class="p-4 font-semibold w-16 text-center">ID</th>
                        <th class="p-4 font-semibold">Nama Kategori</th>
                        <th class="p-4 font-semibold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kategori)): ?>
                        <?php foreach($kategori as $row): ?>
                        <tr class="hover:bg-gray-50 transition border-b last:border-b-0">
                            <td class="p-4 text-center text-gray-500"><?= $row['id'] ?></td>
                            <td class="p-4 font-medium text-gray-700"><?= htmlspecialchars($row['nama_kategori']) ?></td>
                            <td class="p-4 text-center">
                                <a href="<?= $basePath ?>/admin/kategori/edit?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 font-semibold mr-2">Edit</a>
                                                    
                                <a href="<?= $basePath ?>/admin/kategori/delete?id=<?= $row['id'] ?>" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" 
                                   class="text-red-600 hover:text-red-800 font-semibold">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="p-6 text-center text-gray-400 italic">Belum ada data kategori.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<hr class="my-10 border-gray-200">

<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Manajemen Supplier</h2>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start mb-8">
    
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 lg:col-span-1">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Tambah Supplier Baru</h3>
        <form action="<?= $basePath ?>/admin/supplier/store" method="POST" class="space-y-4">
            <div>
                <label for="nama_supplier" class="block text-sm font-medium text-gray-700 mb-1">Nama Supplier</label>
                <input type="text" id="nama_supplier" name="nama_supplier" required placeholder="Cth: PT Medika Jaya"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 outline-none transition">
            </div>
            <div>
                <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                <input type="text" id="telepon" name="telepon" required placeholder="Cth: 0812..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 outline-none transition">
            </div>
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea id="alamat" name="alamat" rows="3" required placeholder="Alamat supplier..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 outline-none transition"></textarea>
            </div>
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-md transition duration-200 shadow-sm">
                Simpan Supplier
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 lg:col-span-2 flex flex-col h-full">
        <div class="p-6 border-b border-gray-100 bg-gray-50 rounded-t-lg">
            <h3 class="text-lg font-bold text-gray-800">Daftar Supplier Obat</h3>
        </div>
        
        <div class="p-0 overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-gray-500 bg-white border-b">
                        <th class="p-4 font-semibold">Nama Supplier</th>
                        <th class="p-4 font-semibold">Kontak & Alamat</th>
                        <th class="p-4 font-semibold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($supplier)): ?>
                        <?php foreach($supplier as $sup): ?>
                        <tr class="hover:bg-gray-50 transition border-b last:border-b-0">
                            <td class="p-4 font-medium text-gray-700"><?= htmlspecialchars($sup['nama_supplier']) ?></td>
                            <td class="p-4 text-gray-600">
                                <div class="font-semibold"><?= htmlspecialchars($sup['telepon']) ?></div>
                                <div class="text-xs text-gray-500 mt-1"><?= htmlspecialchars($sup['alamat']) ?></div>
                            </td>
                            <td class="p-4 text-center">
                                <a href="<?= $basePath ?>/admin/supplier/edit?id=<?= $sup['id'] ?>" class="text-blue-600 hover:text-blue-800 font-semibold mr-2">Edit</a>
                                <a href="<?= $basePath ?>/admin/supplier/delete?id=<?= $sup['id'] ?>" onclick="return confirm('Hapus supplier ini?');" class="text-red-600 hover:text-red-800 font-semibold">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="p-6 text-center text-gray-400 italic">Belum ada data supplier.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php require 'views/partials/footer.php'; ?>