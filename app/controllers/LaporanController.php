<?php
// app/controllers/LaporanController.php
require_once 'vendor/autoload.php'; // Panggil DomPDF
use Dompdf\Dompdf;
use Dompdf\Options;

function getDataMorbiditas($pdo, $tgl_mulai, $tgl_selesai) {
    $query = "SELECT py.kode_icd, py.nama_penyakit, py.deskripsi, COUNT(r.id) as jumlah_kasus 
              FROM resep r 
              JOIN penyakit py ON r.penyakit_id = py.id 
              WHERE r.status_resep = 'Selesai'";
    $params = [];

    if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
        $query .= " AND r.tanggal_resep BETWEEN :tgl_mulai AND :tgl_selesai";
        $params['tgl_mulai'] = $tgl_mulai;
        $params['tgl_selesai'] = $tgl_selesai;
    }

    $query .= " GROUP BY py.id, py.kode_icd, py.nama_penyakit, py.deskripsi ORDER BY jumlah_kasus DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $laporan = $stmt->fetchAll();

    // Hitung total seluruh kasus untuk mencari persentase
    $total_semua_kasus = 0;
    foreach ($laporan as $row) {
        $total_semua_kasus += $row['jumlah_kasus'];
    }

    return ['laporan' => $laporan, 'total_semua_kasus' => $total_semua_kasus];
}

function indexMorbiditas($pdo, $basePath) {
    $tgl_mulai = isset($_GET['tanggal_mulai']) ? trim($_GET['tanggal_mulai']) : '';
    $tgl_selesai = isset($_GET['tanggal_selesai']) ? trim($_GET['tanggal_selesai']) : '';

    $data = getDataMorbiditas($pdo, $tgl_mulai, $tgl_selesai);
    $laporan = $data['laporan'];
    $total_semua_kasus = $data['total_semua_kasus'];

    require 'views/admin/laporan/morbiditas.php';
}

function exportMorbiditasPDF($pdo, $basePath) {
    $tgl_mulai = isset($_GET['tanggal_mulai']) ? trim($_GET['tanggal_mulai']) : '';
    $tgl_selesai = isset($_GET['tanggal_selesai']) ? trim($_GET['tanggal_selesai']) : '';

    $data = getDataMorbiditas($pdo, $tgl_mulai, $tgl_selesai);
    $laporan = $data['laporan'];
    $total_semua_kasus = $data['total_semua_kasus'];

    // Tangkap output HTML dari file view khusus PDF
    ob_start();
    require 'views/admin/laporan/pdf_morbiditas.php';
    $html = ob_get_clean();

    // Konfigurasi DomPDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true); // Agar bisa baca CSS eksternal jika ada
    
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Attachment 0 berarti di-preview di browser, Attachment 1 langsung di-download
    $dompdf->stream("Laporan_Morbiditas_" . date('Ymd') . ".pdf", ["Attachment" => 0]);
    exit;
}

// --- LOGIKA LAPORAN ESTIMASI STOK ---

function getDataStok($pdo, $tgl_mulai, $tgl_selesai) {
    $whereClause = "";
    $params = [];

    // Jika difilter, tambahkan kondisi tanggal pada subquery
    if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
        $whereClause = "AND t.tanggal_transaksi BETWEEN :tgl_mulai AND :tgl_selesai";
        $params['tgl_mulai'] = $tgl_mulai . " 00:00:00";
        $params['tgl_selesai'] = $tgl_selesai . " 23:59:59";
    }

    // Query cerdas: Menghitung jumlah terjual melalui subquery agar obat dengan 0 transaksi tetap muncul
    $query = "SELECT o.kode_obat, o.nama_obat, o.stok as sisa_stok, o.stok_minimum, o.satuan,
              (SELECT COALESCE(SUM(dt.jumlah), 0) 
               FROM detail_transaksi dt 
               JOIN transaksi t ON dt.transaksi_id = t.id 
               WHERE dt.obat_id = o.id AND t.status_pembayaran = 'Lunas' $whereClause
              ) as stok_keluar
              FROM obat o
              ORDER BY (o.stok - o.stok_minimum) ASC"; // Urutkan dari yang paling kritis

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function indexStok($pdo, $basePath) {
    $tgl_mulai = isset($_GET['tanggal_mulai']) ? trim($_GET['tanggal_mulai']) : '';
    $tgl_selesai = isset($_GET['tanggal_selesai']) ? trim($_GET['tanggal_selesai']) : '';

    $laporan = getDataStok($pdo, $tgl_mulai, $tgl_selesai);
    require 'views/admin/laporan/stok.php';
}

function exportStokPDF($pdo, $basePath) {
    $tgl_mulai = isset($_GET['tanggal_mulai']) ? trim($_GET['tanggal_mulai']) : '';
    $tgl_selesai = isset($_GET['tanggal_selesai']) ? trim($_GET['tanggal_selesai']) : '';
    $laporan = getDataStok($pdo, $tgl_mulai, $tgl_selesai);

    ob_start();
    require 'views/admin/laporan/pdf_stok.php';
    $html = ob_get_clean();

    $options = new \Dompdf\Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    
    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape'); // Menggunakan orientasi Lanskap agar kolom muat
    $dompdf->render();

    $dompdf->stream("Estimasi_Stok_" . date('Ymd') . ".pdf", ["Attachment" => 0]);
    exit;
}
?>