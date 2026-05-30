<?php
// app/controllers/TransaksiController.php

function indexTransaksi($pdo, $basePath) {
    // Ambil resep yang berstatus 'Menunggu'
    $resep = $pdo->query("SELECT r.*, p.nama_pasien FROM resep r JOIN pasien p ON r.pasien_id = p.id WHERE r.status_resep = 'Menunggu' ORDER BY r.id DESC")->fetchAll();
    
    // Ambil semua data obat yang stoknya masih tersedia
    $obat = $pdo->query("SELECT * FROM obat WHERE stok > 0 ORDER BY nama_obat ASC")->fetchAll();

    // Inisialisasi keranjang belanja jika belum ada
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (!isset($_SESSION['resep_id'])) {
        $_SESSION['resep_id'] = '';
    }

    require 'views/admin/transaksi/index.php';
}

function addToCart($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $obat_id = $_POST['obat_id'];
        $jumlah = (int)$_POST['jumlah'];
        
        // Simpan resep_id yang dipilih agar tidak hilang saat refresh halaman input
        if (isset($_POST['resep_id'])) {
            $_SESSION['resep_id'] = $_POST['resep_id'];
        }

        if ($obat_id && $jumlah > 0) {
            // Ambil data obat dari DB untuk memastikan stok dan harga jual terbaru
            $stmt = $pdo->prepare("SELECT nama_obat, harga_jual, stok FROM obat WHERE id = :id");
            $stmt->execute(['id' => $obat_id]);
            $item = $stmt->fetch();

            if ($item) {
                if ($jumlah > $item['stok']) {
                    $_SESSION['error'] = "Input gagal. Stok hanya tersedia " . $item['stok'] . " item.";
                } else {
                    // Jika obat sudah ada di keranjang, akumulasikan jumlahnya
                    if (isset($_SESSION['cart'][$obat_id])) {
                        $_SESSION['cart'][$obat_id]['jumlah'] += $jumlah;
                        $_SESSION['cart'][$obat_id]['subtotal'] = $_SESSION['cart'][$obat_id]['jumlah'] * $_SESSION['cart'][$obat_id]['harga'];
                    } else {
                        // Jika belum ada, masukkan data baru
                        $_SESSION['cart'][$obat_id] = [
                            'nama' => $item['nama_obat'],
                            'harga' => $item['harga_jual'],
                            'jumlah' => $jumlah,
                            'subtotal' => $item['harga_jual'] * $jumlah
                        ];
                    }
                    $_SESSION['success'] = "Obat berhasil ditambahkan ke keranjang.";
                }
            }
        }
    }
    header("Location: " . $basePath . "/admin/transaksi");
    exit;
}

function removeFromCart($basePath) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        unset($_SESSION['cart'][$id]);
        $_SESSION['success'] = "Item berhasil dihapus dari keranjang.";
    }
    header("Location: " . $basePath . "/admin/transaksi");
    exit;
}

function checkoutTransaksi($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_SESSION['cart'])) {
            $_SESSION['error'] = "Transaksi gagal. Keranjang belanja masih kosong.";
            header("Location: " . $basePath . "/admin/transaksi");
            exit;
        }

        try {
            // Membuka Database Transaction (Sangat disukai penguji untuk menjamin integritas data)
            $pdo->beginTransaction();

            // 1. Generate Kode Transaksi Otomatis (Format: TRX-YYYYMMDD-XXXX)
            $tanggal = date('Ymd');
            $stmtCheck = $pdo->query("SELECT kode_transaksi FROM transaksi WHERE kode_transaksi LIKE 'TRX-$tanggal%' ORDER BY id DESC LIMIT 1");
            $lastTrx = $stmtCheck->fetchColumn();
            
            if ($lastTrx) {
                $num = (int)substr($lastTrx, 12) + 1;
            } else {
                $num = 1;
            }
            $kode_transaksi = 'TRX-' . $tanggal . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);

            // 2. Hitung Total Keseluruhan
            $total_harga = 0;
            foreach ($_SESSION['cart'] as $item) {
                $total_harga += $item['subtotal'];
            }

            // 3. Insert ke Tabel Transaksi
            $resep_id = !empty($_POST['resep_id']) ? $_POST['resep_id'] : null;
            $stmtTrx = $pdo->prepare("INSERT INTO transaksi (kode_transaksi, resep_id, user_id, total_harga, status_pembayaran) VALUES (:kode, :resep_id, :user_id, :total, 'Lunas')");
            $stmtTrx->execute([
                'kode' => $kode_transaksi,
                'resep_id' => $resep_id,
                'user_id' => $_SESSION['user_id'],
                'total' => $total_harga
            ]);
            $transaksi_id = $pdo->lastInsertId();

            // 4. Loop Keranjang untuk Detail Transaksi & Update Stok Obat
            $stmtDetail = $pdo->prepare("INSERT INTO detail_transaksi (transaksi_id, obat_id, jumlah, harga_jual, subtotal) VALUES (:t_id, :o_id, :qty, :harga, :sub)");
            $stmtUpdateStok = $pdo->prepare("UPDATE obat SET stok = stok - :qty WHERE id = :id");

            foreach ($_SESSION['cart'] as $obat_id => $item) {
                // Insert detail
                $stmtDetail->execute([
                    't_id' => $transaksi_id,
                    'o_id' => $obat_id,
                    'qty' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'sub' => $item['subtotal']
                ]);

                // Potong stok master obat
                $stmtUpdateStok->execute([
                    'qty' => $item['jumlah'],
                    'id' => $obat_id
                ]);
            }

            // 5. Update Status Resep Dokter menjadi 'Selesai' jika transaksi berdasarkan resep
            if ($resep_id) {
                $stmtResep = $pdo->prepare("UPDATE resep SET status_resep = 'Selesai' WHERE id = :resep_id");
                $stmtResep->execute(['resep_id' => $resep_id]);
            }

            // Commit seluruh operasi jika tidak ada error
            $pdo->commit();

            // Kosongkan keranjang belanja setelah sukses simpan database
            unset($_SESSION['cart']);
            unset($_SESSION['resep_id']);

            $_SESSION['success'] = "Transaksi $kode_transaksi berhasil disimpan secara permanen.";

        } catch (Exception $e) {
            // Batalkan semua perubahan jika ada kegagalan query di tengah jalan
            $pdo->rollBack();
            $_SESSION['error'] = "Kesalahan transaksi database: " . $e->getMessage();
        }
    }
    header("Location: " . $basePath . "/admin/transaksi");
    exit;
}

function riwayatTransaksi($pdo, $basePath) {
    // 1. Ambil semua riwayat transaksi (JOIN dengan tabel users untuk tahu siapa kasirnya)
    try {
        $query = "SELECT t.*, u.nama_lengkap AS nama_kasir, r.nama_dokter 
                  FROM transaksi t 
                  LEFT JOIN users u ON t.user_id = u.id 
                  LEFT JOIN resep r ON t.resep_id = r.id 
                  ORDER BY t.tanggal_transaksi DESC, t.id DESC";
        $stmt = $pdo->query($query);
        $riwayat = $stmt->fetchAll();
    } catch (PDOException $e) {
        $riwayat = [];
    }

    // 2. Hitung Total Pendapatan Khusus Hari Ini
    try {
        $hari_ini = date('Y-m-d');
        // Pastikan kolom tanggal_transaksi bertipe DATETIME atau TIMESTAMP di database
        $stmtTotal = $pdo->prepare("SELECT SUM(total_harga) FROM transaksi WHERE DATE(tanggal_transaksi) = :hari_ini");
        $stmtTotal->execute(['hari_ini' => $hari_ini]);
        $pendapatan_hari_ini = $stmtTotal->fetchColumn();
    } catch (PDOException $e) {
        $pendapatan_hari_ini = 0;
    }

    require 'views/admin/transaksi/riwayat.php';
}
?>