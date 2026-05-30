<?php require 'views/partials/header.php'; ?>
<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Edit Kamus Penyakit</h1>
</div>
<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 max-w-lg">
    <form action="<?= $basePath ?>/admin/penyakit/update" method="POST" class="space-y-4">
        <input type="hidden" name="id" value="<?= $penyakit_edit['id'] ?>">
        <div><label class="block text-sm font-bold text-gray-700">Kode ICD</label><input type="text" name="kode_icd" value="<?= htmlspecialchars($penyakit_edit['kode_icd']) ?>" class="w-full px-4 py-2 border rounded-md focus:ring-teal-500 outline-none text-sm"></div>
        <div><label class="block text-sm font-bold text-gray-700">Nama Penyakit</label><input type="text" name="nama_penyakit" required value="<?= htmlspecialchars($penyakit_edit['nama_penyakit']) ?>" class="w-full px-4 py-2 border rounded-md focus:ring-teal-500 outline-none text-sm"></div>
        <div><label class="block text-sm font-bold text-gray-700">Deskripsi</label><textarea name="deskripsi" rows="2" class="w-full px-4 py-2 border rounded-md focus:ring-teal-500 outline-none text-sm"><?= htmlspecialchars($penyakit_edit['deskripsi']) ?></textarea></div>
        <div class="pt-3">
            <button type="submit" class="bg-teal-600 text-white font-bold py-2 px-6 rounded-md mr-2">Update</button>
            <a href="<?= $basePath ?>/admin/pasien-penyakit" class="bg-gray-200 text-gray-700 font-bold py-2 px-6 rounded-md">Batal</a>
        </div>
    </form>
</div>
<?php require 'views/partials/footer.php'; ?>