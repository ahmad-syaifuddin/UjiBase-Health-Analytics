<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Edit Data Resep</h1>
    <p class="text-gray-500">Perbaiki informasi rujukan medis atau perbarui status</p>
</div>

<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 max-w-2xl">
    <form action="<?= $basePath ?>/admin/resep/update" method="POST" class="space-y-5">
        <input type="hidden" name="id" value="<?= $resep_edit['id'] ?>">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Pasien</label>
                <select name="pasien_id" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none transition">
                    <?php foreach($pasien as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= ($resep_edit['pasien_id'] == $p['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['nama_pasien']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Diagnosis</label>
                <select name="penyakit_id" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none transition">
                    <?php foreach($penyakit as $py): ?>
                        <option value="<?= $py['id'] ?>" <?= ($resep_edit['penyakit_id'] == $py['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($py['nama_penyakit']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Dokter</label>
                <input type="text" name="nama_dokter" required value="<?= htmlspecialchars($resep_edit['nama_dokter']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Resep</label>
                <input type="date" name="tanggal_resep" required value="<?= $resep_edit['tanggal_resep'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none">
            </div>
        </div>

        <div class="border-t pt-4 mt-4">
            <label class="block text-sm font-bold text-gray-700 mb-1">Status Resep</label>
            <select name="status_resep" required class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none transition font-semibold text-gray-800">
                <option value="Menunggu" <?= ($resep_edit['status_resep'] === 'Menunggu') ? 'selected' : '' ?>>Menunggu</option>
                <option value="Diproses" <?= ($resep_edit['status_resep'] === 'Diproses') ? 'selected' : '' ?>>Diproses</option>
                <option value="Selesai" <?= ($resep_edit['status_resep'] === 'Selesai') ? 'selected' : '' ?>>Selesai</option>
            </select>
        </div>
        
        <div class="flex space-x-3 pt-4 border-t">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 px-6 rounded-md transition duration-200 shadow-sm">
                Simpan Perubahan
            </button>
            <a href="<?= $basePath ?>/admin/resep" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-md transition duration-200">
                Batal
            </a>
        </div>
    </form>
</div>

<?php require 'views/partials/footer.php'; ?>