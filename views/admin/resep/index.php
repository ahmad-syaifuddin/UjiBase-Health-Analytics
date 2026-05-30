<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Manajemen Resep Dokter</h1>
    <p class="text-gray-500">Input antrean resep dan kelola diagnosis pasien</p>
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
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Buat Resep Baru</h3>
        
        <form action="<?= $basePath ?>/admin/resep/store" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Pilih Pasien</label>
                <select name="pasien_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
                    <option value="">-- Pilih Pasien --</option>
                    <?php foreach($pasien as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama_pasien']) ?> (<?= $p['no_identitas'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Diagnosis Penyakit</label>
                <select name="penyakit_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
                    <option value="">-- Pilih Diagnosis --</option>
                    <?php foreach($penyakit as $py): ?>
                        <option value="<?= $py['id'] ?>"><?= htmlspecialchars($py['nama_penyakit']) ?> [<?= $py['kode_icd'] ?>]</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Dokter Penanggung Jawab</label>
                <input type="text" name="nama_dokter" required placeholder="Cth: dr. Budi" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Resep</label>
                <input type="date" name="tanggal_resep" required value="<?= date('Y-m-d') ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
            </div>

            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 px-4 rounded-md transition duration-200 mt-2 shadow-sm">
                Masukan ke Antrean
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 lg:col-span-3 flex flex-col h-full">
        <div class="p-5 border-b border-gray-100 bg-gray-50 rounded-t-lg">
            <h3 class="text-lg font-bold text-gray-800">Antrean & Riwayat Resep</h3>
        </div>
        
        <div class="p-0 overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-gray-500 bg-white border-b">
                        <th class="p-3 font-semibold">Tgl. Resep</th>
                        <th class="p-3 font-semibold">Nama Pasien</th>
                        <th class="p-3 font-semibold">Diagnosis & Dokter</th>
                        <th class="p-3 font-semibold text-center">Status</th>
                        <th class="p-3 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($resep)): ?>
                        <?php foreach($resep as $row): ?>
                        <tr class="hover:bg-gray-50 transition border-b last:border-b-0">
                            <td class="p-3 text-gray-600 font-medium"><?= date('d M Y', strtotime($row['tanggal_resep'])) ?></td>
                            <td class="p-3 font-bold text-gray-800"><?= htmlspecialchars($row['nama_pasien']) ?></td>
                            <td class="p-3">
                                <div class="font-bold text-teal-800"><?= htmlspecialchars($row['nama_penyakit']) ?></div>
                                <div class="text-xs text-gray-500 mt-0.5"><?= htmlspecialchars($row['nama_dokter']) ?></div>
                            </td>
                            <td class="p-3 text-center">
                                <?php 
                                    // Pilihan warna badge status
                                    $bg = 'bg-yellow-100 text-yellow-800'; // Menunggu
                                    if ($row['status_resep'] === 'Diproses') $bg = 'bg-blue-100 text-blue-800';
                                    if ($row['status_resep'] === 'Selesai') $bg = 'bg-green-100 text-green-800';
                                ?>
                                <span class="<?= $bg ?> px-2.5 py-1 rounded-sm text-xs font-bold uppercase tracking-wide">
                                    <?= htmlspecialchars($row['status_resep']) ?>
                                </span>
                            </td>
                            <td class="p-3 text-center">
                                <a href="<?= $basePath ?>/admin/resep/edit?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 font-semibold mr-2">Edit</a>
                                <a href="<?= $basePath ?>/admin/resep/delete?id=<?= $row['id'] ?>" onclick="return confirm('Hapus resep ini?');" class="text-red-600 hover:text-red-800 font-semibold">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-400 italic">Belum ada antrean resep.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'views/partials/footer.php'; ?>