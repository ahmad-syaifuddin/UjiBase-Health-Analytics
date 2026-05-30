<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Edit Kategori</h1>
    <p class="text-gray-500">Perbarui data referensi kategori obat</p>
</div>

<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 max-w-lg">
    <form action="<?= $basePath ?>/admin/kategori/update" method="POST" class="space-y-4">
        <input type="hidden" name="id" value="<?= htmlspecialchars($kategori_edit['id']) ?>">
        
        <div>
            <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori Obat</label>
            <input type="text" id="nama_kategori" name="nama_kategori" required 
                value="<?= htmlspecialchars($kategori_edit['nama_kategori']) ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 outline-none transition">
        </div>
        
        <div class="flex space-x-3 pt-2">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-md transition duration-200 shadow-sm">
                Update Kategori
            </button>
            <a href="<?= $basePath ?>/admin/kategori-supplier" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-md transition duration-200">
                Batal
            </a>
        </div>
    </form>
</div>

<?php require 'views/partials/footer.php'; ?>