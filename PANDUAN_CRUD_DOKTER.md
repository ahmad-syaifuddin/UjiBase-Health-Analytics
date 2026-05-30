# Panduan Pembuatan Modul Master Data Dokter

**Proyek:** UjiBase Health Analytics  
**Misi:** Uji Kompetensi Mandiri (Pembuatan CRUD Relasional Terpisah)

Panduan ini akan menuntun pembuatan modul `Dokter` dari nol hingga terintegrasi dengan menu aplikasi. Pastikan kamu sudah mengeksekusi kueri SQL pembuatan tabel `dokter` di phpMyAdmin sebelum memulai.

---

## Langkah 1: Mendaftarkan Rute (Routing)

Buka file `routes/web.php`. Daftarkan kelima rute standar CRUD ini di kelompok Master Data (sejajar dengan rute Kategori/Supplier atau Pasien).

```php
// Rute Master Data Dokter
elseif ($uri === '/admin/dokter') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/DokterController.php'; indexDokter($pdo, $basePath);
}
elseif ($uri === '/admin/dokter/store') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/DokterController.php'; storeDokter($pdo, $basePath);
}
elseif ($uri === '/admin/dokter/edit') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/DokterController.php'; editDokter($pdo, $basePath);
}
elseif ($uri === '/admin/dokter/update') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/DokterController.php'; updateDokter($pdo, $basePath);
}
elseif ($uri === '/admin/dokter/delete') {
    if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'Kepala Klinik') { header("Location: " . $basePath . "/admin/dashboard"); exit; }
    require_once 'app/controllers/DokterController.php'; deleteDokter($pdo, $basePath);
}
```

---

## Langkah 2: Membuat Controller

Buat file baru bernama `DokterController.php` di dalam folder `app/controllers/`.

```php
<?php
// app/controllers/DokterController.php

function indexDokter($pdo, $basePath) {
    try {
        $stmt = $pdo->query("SELECT * FROM dokter ORDER BY nama_dokter ASC");
        $dokter = $stmt->fetchAll();
    } catch (PDOException $e) {
        $dokter = [];
    }
    require 'views/admin/dokter/index.php';
}

function storeDokter($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $stmt = $pdo->prepare("INSERT INTO dokter (nama_dokter, spesialisasi, telepon) VALUES (:nama_dokter, :spesialisasi, :telepon)");
            $stmt->execute([
                'nama_dokter' => trim($_POST['nama_dokter']),
                'spesialisasi' => trim($_POST['spesialisasi']),
                'telepon' => trim($_POST['telepon'])
            ]);
            $_SESSION['success'] = "Data dokter berhasil ditambahkan.";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal menyimpan data dokter.";
        }
    }
    header("Location: " . $basePath . "/admin/dokter");
    exit;
}

function editDokter($pdo, $basePath) {
    if (!isset($_GET['id'])) { header("Location: " . $basePath . "/admin/dokter"); exit; }

    $stmt = $pdo->prepare("SELECT * FROM dokter WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $dokter_edit = $stmt->fetch();

    if (!$dokter_edit) {
        header("Location: " . $basePath . "/admin/dokter"); exit;
    }
    require 'views/admin/dokter/edit.php';
}

function updateDokter($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $stmt = $pdo->prepare("UPDATE dokter SET nama_dokter = :nama_dokter, spesialisasi = :spesialisasi, telepon = :telepon WHERE id = :id");
            $stmt->execute([
                'nama_dokter' => trim($_POST['nama_dokter']),
                'spesialisasi' => trim($_POST['spesialisasi']),
                'telepon' => trim($_POST['telepon']),
                'id' => $_POST['id']
            ]);
            $_SESSION['success'] = "Data dokter berhasil diperbarui.";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal memperbarui data dokter.";
        }
    }
    header("Location: " . $basePath . "/admin/dokter");
    exit;
}

function deleteDokter($pdo, $basePath) {
    if (isset($_GET['id'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM dokter WHERE id = :id");
            $stmt->execute(['id' => $_GET['id']]);
            $_SESSION['success'] = "Data dokter berhasil dihapus.";
        } catch (PDOException $e) {
            // Relasi ON DELETE RESTRICT akan memicu error ini jika dokter sudah punya resep
            $_SESSION['error'] = "Gagal dihapus! Dokter ini sudah menangani antrean resep medis.";
        }
    }
    header("Location: " . $basePath . "/admin/dokter");
    exit;
}
?>
```

---

## Langkah 3: Membuat View Utama (Index)

Buat folder `dokter` di dalam `views/admin/`, lalu buat file `index.php`. Layout Side-by-Side yang profesional.

```php
<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Master Data Dokter</h1>
    <p class="text-gray-500">Kelola informasi tenaga medis dan dokter penanggung jawab</p>
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
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Tambah Dokter Baru</h3>
        <form action="<?= $basePath ?>/admin/dokter/store" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap & Gelar</label>
                <input type="text" name="nama_dokter" required placeholder="Cth: dr. Budi Santoso" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Spesialisasi / Poli</label>
                <input type="text" name="spesialisasi" required placeholder="Cth: Dokter Umum" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" name="telepon" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 outline-none text-sm">
            </div>
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-md shadow-sm transition mt-2">
                Simpan Data Dokter
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 lg:col-span-2 flex flex-col h-full">
        <div class="p-5 border-b bg-gray-50 rounded-t-lg">
            <h3 class="text-lg font-bold text-gray-800">Daftar Tenaga Medis</h3>
        </div>
        <div class="p-0 overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-gray-500 bg-white border-b">
                        <th class="p-4 font-semibold">Identitas Dokter</th>
                        <th class="p-4 font-semibold">Kontak</th>
                        <th class="p-4 font-semibold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dokter)): ?>
                        <?php foreach($dokter as $row): ?>
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="p-4">
                                <div class="font-bold text-gray-800"><?= htmlspecialchars($row['nama_dokter']) ?></div>
                                <div class="text-xs text-gray-500 mt-0.5">Poli: <?= htmlspecialchars($row['spesialisasi']) ?></div>
                            </td>
                            <td class="p-4 text-gray-600 font-medium">
                                <?= htmlspecialchars($row['telepon']) ?>
                            </td>
                            <td class="p-4 text-center">
                                <a href="<?= $basePath ?>/admin/dokter/edit?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 font-semibold mr-2">Edit</a>
                                <a href="<?= $basePath ?>/admin/dokter/delete?id=<?= $row['id'] ?>" onclick="return confirm('Hapus data dokter ini?');" class="text-red-600 font-semibold">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="p-6 text-center text-gray-400 italic">Belum ada data dokter.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'views/partials/footer.php'; ?>
```

---

## Langkah 4: Membuat View Edit

Buat file `edit.php` di dalam folder `views/admin/dokter/`.

```php
<?php require 'views/partials/header.php'; ?>

<div class="mb-6 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-gray-800">Edit Data Dokter</h1>
</div>

<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 max-w-lg">
    <form action="<?= $basePath ?>/admin/dokter/update" method="POST" class="space-y-4">
        <input type="hidden" name="id" value="<?= $dokter_edit['id'] ?>">

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap & Gelar</label>
            <input type="text" name="nama_dokter" required value="<?= htmlspecialchars($dokter_edit['nama_dokter']) ?>" class="w-full px-4 py-2 border rounded-md focus:ring-teal-500 outline-none text-sm">
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Spesialisasi / Poli</label>
            <input type="text" name="spesialisasi" required value="<?= htmlspecialchars($dokter_edit['spesialisasi']) ?>" class="w-full px-4 py-2 border rounded-md focus:ring-teal-500 outline-none text-sm">
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Telepon</label>
            <input type="text" name="telepon" required value="<?= htmlspecialchars($dokter_edit['telepon']) ?>" class="w-full px-4 py-2 border rounded-md focus:ring-teal-500 outline-none text-sm">
        </div>

        <div class="pt-4 flex space-x-3">
            <button type="submit" class="bg-teal-600 text-white font-bold py-2.5 px-6 rounded-md shadow-sm transition">Update Data</button>
            <a href="<?= $basePath ?>/admin/dokter" class="bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-md">Batal</a>
        </div>
    </form>
</div>

<?php require 'views/partials/footer.php'; ?>
```

---

## Langkah 5: Membuka Gembok Menu (Header)

Buka file `views/partials/header.php`. Cari tautan menu dummy **Data Dokter (Uji Coba)** yang terkunci. Ganti tautan tersebut agar mengarah ke rute sebenarnya dan berfungsi penuh seperti menu lainnya.

### Kode Lama (Terkunci):

```html
<a
  href="#"
  onclick="alert('Fitur ini sedang diuji cobakan. Uji Kompetensi Mandiri!'); return false;"
  class="block px-4 py-2 rounded-md text-sm font-medium text-gray-500 bg-gray-800/30 cursor-not-allowed opacity-75 border border-dashed border-gray-700"
>
  Data Dokter (Uji Coba)
</a>
```

### Kode Baru (Terbuka & Dinamis):

```php
<a href="<?= $basePath ?>/admin/dokter" class="block px-4 py-2 rounded-md text-sm transition <?= getMenuClass('/admin/dokter', $clean_path) ?>">
    Data Dokter
</a>
```

---

## ✅ Misi Selesai!

Ringkasan file yang dibuat/dimodifikasi:

| No  | Aksi    | Path File                              |
| --- | ------- | -------------------------------------- |
| 1   | ✏️ Edit | `routes/web.php`                       |
| 2   | 🆕 Buat | `app/controllers/DokterController.php` |
| 3   | 🆕 Buat | `views/admin/dokter/index.php`         |
| 4   | 🆕 Buat | `views/admin/dokter/edit.php`          |
| 5   | ✏️ Edit | `views/partials/header.php`            |
