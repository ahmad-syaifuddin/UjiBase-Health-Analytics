<?php require 'views/partials/header.php'; ?>
<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Edit Data Pasien</h1>
</div>
<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 max-w-lg">
    <form action="<?= $basePath ?>/admin/pasien/update" method="POST" class="space-y-4">
        <input type="hidden" name="id" value="<?= $pasien_edit['id'] ?>">
        <div><label class="block text-sm font-bold text-gray-700">NIK</label><input type="text" name="no_identitas" required value="<?= htmlspecialchars($pasien_edit['no_identitas']) ?>" class="w-full px-4 py-2 border rounded-md focus:ring-teal-500 outline-none text-sm"></div>
        <div><label class="block text-sm font-bold text-gray-700">Nama</label><input type="text" name="nama_pasien" required value="<?= htmlspecialchars($pasien_edit['nama_pasien']) ?>" class="w-full px-4 py-2 border rounded-md focus:ring-teal-500 outline-none text-sm"></div>
        <div><label class="block text-sm font-bold text-gray-700">Telepon</label><input type="text" name="telepon" required value="<?= htmlspecialchars($pasien_edit['telepon']) ?>" class="w-full px-4 py-2 border rounded-md focus:ring-teal-500 outline-none text-sm"></div>
        <div><label class="block text-sm font-bold text-gray-700">Alamat</label><textarea name="alamat" rows="2" required class="w-full px-4 py-2 border rounded-md focus:ring-teal-500 outline-none text-sm"><?= htmlspecialchars($pasien_edit['alamat']) ?></textarea></div>
        <div class="pt-3">
            <button type="submit" class="bg-teal-600 text-white font-bold py-2 px-6 rounded-md mr-2">Update</button>
            <a href="<?= $basePath ?>/admin/pasien-penyakit" class="bg-gray-200 text-gray-700 font-bold py-2 px-6 rounded-md">Batal</a>
        </div>
    </form>
</div>
<?php require 'views/partials/footer.php'; ?>