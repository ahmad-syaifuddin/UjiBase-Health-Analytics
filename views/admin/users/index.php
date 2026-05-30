<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Manajemen Pengguna</h1>
    <p class="text-gray-500">Kelola akun dan hak akses pegawai klinik</p>
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
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Tambah Akun Baru</h3>
        <form action="<?= $basePath ?>/admin/users/store" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Username Login</label>
                <input type="text" name="username" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Role / Hak Akses</label>
                <select name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
                    <option value="Petugas">Petugas (Kasir)</option>
                    <option value="Kepala Klinik">Kepala Klinik (Admin)</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-md shadow-sm transition mt-2">
                Simpan Akun
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 lg:col-span-2 flex flex-col h-full">
        <div class="p-5 border-b bg-gray-50 rounded-t-lg">
            <h3 class="text-lg font-bold text-gray-800">Daftar Pengguna Sistem</h3>
        </div>
        <div class="p-0 overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-gray-500 bg-white border-b">
                        <th class="p-4 font-semibold">Nama Pegawai</th>
                        <th class="p-4 font-semibold text-center">Role / Akses</th>
                        <th class="p-4 font-semibold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach($users as $row): ?>
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="p-4">
                                <div class="font-bold text-gray-800"><?= htmlspecialchars($row['nama_lengkap']) ?></div>
                                <div class="text-xs text-gray-500 mt-0.5">Username: <span class="font-mono"><?= htmlspecialchars($row['username']) ?></span></div>
                            </td>
                            <td class="p-4 text-center">
                                <?php if($row['role'] === 'Kepala Klinik'): ?>
                                    <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-sm text-xs font-bold uppercase">Kepala Klinik</span>
                                <?php else: ?>
                                    <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-sm text-xs font-bold uppercase">Petugas</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 text-center">
                                <a href="<?= $basePath ?>/admin/users/edit?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 font-semibold mr-2">Edit</a>
                                <a href="<?= $basePath ?>/admin/users/delete?id=<?= $row['id'] ?>" onclick="return confirm('Hapus pengguna ini?');" class="text-red-600 font-semibold">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'views/partials/footer.php'; ?>