<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Edit Pengguna</h1>
    <p class="text-gray-500">Perbarui identitas atau ubah kata sandi akun</p>
</div>

<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 max-w-lg">
    <form action="<?= $basePath ?>/admin/users/update" method="POST" class="space-y-4">
        <input type="hidden" name="id" value="<?= $user_edit['id'] ?>">
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" required value="<?= htmlspecialchars($user_edit['nama_lengkap']) ?>" class="w-full px-4 py-2 border rounded-md focus:ring-teal-500 outline-none text-sm">
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Username Login</label>
            <input type="text" name="username" required value="<?= htmlspecialchars($user_edit['username']) ?>" class="w-full px-4 py-2 border rounded-md focus:ring-teal-500 outline-none text-sm">
        </div>
        
        <div class="bg-yellow-50 border border-yellow-200 p-3 rounded text-sm text-yellow-800 mb-2">
            <strong>Keamanan Sistem:</strong> Hak Akses (Role) tidak dapat diubah setelah akun dibuat untuk menghindari eskalasi otorisasi.
        </div>
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Role / Hak Akses</label>
            <select name="role" disabled class="w-full px-4 py-2 border bg-gray-100 text-gray-500 cursor-not-allowed rounded-md outline-none text-sm font-bold">
                <option value="Petugas" <?= ($user_edit['role'] === 'Petugas') ? 'selected' : '' ?>>Petugas (Kasir)</option>
                <option value="Kepala Klinik" <?= ($user_edit['role'] === 'Kepala Klinik') ? 'selected' : '' ?>>Kepala Klinik (Admin)</option>
            </select>
        </div>

        <div class="pt-4 border-t mt-4">
            <label class="block text-sm font-bold text-gray-700 mb-1">Password Baru (Opsional)</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah sandi" class="w-full px-4 py-2 border rounded-md focus:ring-teal-500 outline-none text-sm">
        </div>

        <div class="pt-4 flex space-x-3">
            <button type="submit" class="bg-teal-600 text-white font-bold py-2.5 px-6 rounded-md shadow-sm transition">Update Akun</button>
            <a href="<?= $basePath ?>/admin/users" class="bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-md">Batal</a>
        </div>
    </form>
</div>

<?php require 'views/partials/footer.php'; ?>