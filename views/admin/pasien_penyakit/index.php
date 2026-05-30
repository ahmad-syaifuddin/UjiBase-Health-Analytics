<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Manajemen Pasien & Kamus Penyakit</h1>
    <p class="text-gray-500">Kelola pendaftaran pasien dan master data penyakit (ICD)</p>
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

<div class="mb-4"><h2 class="text-xl font-bold text-gray-800">Data Pasien</h2></div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start mb-10">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 lg:col-span-1">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Registrasi Pasien</h3>
        <form action="<?= $basePath ?>/admin/pasien/store" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">No. Identitas (KTP/NIK)</label>
                <input type="text" name="no_identitas" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap Pasien</label>
                <input type="text" name="nama_pasien" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" name="telepon" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Domisili</label>
                <textarea name="alamat" rows="2" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm"></textarea>
            </div>
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-md shadow-sm transition">
                Simpan Pasien
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 lg:col-span-2 flex flex-col h-full">
        <div class="p-5 border-b bg-gray-50 rounded-t-lg"><h3 class="text-lg font-bold text-gray-800">Daftar Pasien Terdaftar</h3></div>
        <div class="p-0 overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-gray-500 bg-white border-b">
                        <th class="p-4 font-semibold">Identitas & Nama</th>
                        <th class="p-4 font-semibold">Kontak</th>
                        <th class="p-4 font-semibold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pasien)): ?>
                        <?php foreach($pasien as $row): ?>
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="p-4">
                                <div class="font-bold text-gray-800"><?= htmlspecialchars($row['nama_pasien']) ?></div>
                                <div class="text-xs text-gray-500">NIK: <?= htmlspecialchars($row['no_identitas']) ?></div>
                            </td>
                            <td class="p-4 text-gray-600">
                                <div><?= htmlspecialchars($row['telepon']) ?></div>
                                <div class="text-xs text-gray-500 mt-1"><?= htmlspecialchars($row['alamat']) ?></div>
                            </td>
                            <td class="p-4 text-center">
                                <a href="<?= $basePath ?>/admin/pasien/edit?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 font-semibold mr-2">Edit</a>
                                <a href="<?= $basePath ?>/admin/pasien/delete?id=<?= $row['id'] ?>" onclick="return confirm('Hapus pasien?');" class="text-red-600 font-semibold">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="p-6 text-center text-gray-400 italic">Data pasien kosong.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<hr class="mb-10 border-gray-300">

<div class="mb-4"><h2 class="text-xl font-bold text-gray-800">Kamus Penyakit (Standar Morbiditas)</h2></div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 lg:col-span-1">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Tambah Kode ICD</h3>
        <form action="<?= $basePath ?>/admin/penyakit/store" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Kode ICD (Opsional)</label>
                <input type="text" name="kode_icd" placeholder="Contoh: J10" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Penyakit</label>
                <input type="text" name="nama_penyakit" required placeholder="Contoh: Influenza" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm"></textarea>
            </div>
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-md shadow-sm transition">
                Simpan Penyakit
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 lg:col-span-2 flex flex-col h-full">
        <div class="p-5 border-b bg-gray-50 rounded-t-lg"><h3 class="text-lg font-bold text-gray-800">Daftar Kamus Penyakit</h3></div>
        <div class="p-0 overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-gray-500 bg-white border-b">
                        <th class="p-4 font-semibold w-24">Kode ICD</th>
                        <th class="p-4 font-semibold">Nama & Deskripsi Diagnosis</th>
                        <th class="p-4 font-semibold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($penyakit)): ?>
                        <?php foreach($penyakit as $row): ?>
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="p-4 font-bold text-teal-700"><?= htmlspecialchars($row['kode_icd']) ?></td>
                            <td class="p-4">
                                <div class="font-bold text-gray-800"><?= htmlspecialchars($row['nama_penyakit']) ?></div>
                                <div class="text-xs text-gray-500 mt-1"><?= htmlspecialchars($row['deskripsi']) ?></div>
                            </td>
                            <td class="p-4 text-center">
                                <a href="<?= $basePath ?>/admin/penyakit/edit?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 font-semibold mr-2">Edit</a>
                                <a href="<?= $basePath ?>/admin/penyakit/delete?id=<?= $row['id'] ?>" onclick="return confirm('Hapus penyakit?');" class="text-red-600 font-semibold">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="p-6 text-center text-gray-400 italic">Data penyakit kosong.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'views/partials/footer.php'; ?>