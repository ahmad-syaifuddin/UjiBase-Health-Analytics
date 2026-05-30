<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $pdf_title ?? 'Laporan UjiBase Health' ?></title>
    <style>
        /* CSS Global untuk semua cetakan PDF */
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        .kop-surat { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h2 { margin: 0; font-size: 20px; text-transform: uppercase; letter-spacing: 1px; color: #000;}
        .kop-surat p { margin: 3px 0; font-size: 13px; color: #555; }
        .periode { text-align: left; margin-bottom: 15px; font-weight: bold; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center;}
        
        /* Utility Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .total-row td { font-weight: bold; background-color: #e6e6e6; }
        
        /* Warna Status (Morbiditas & Stok) */
        .status-waspada, .status-kritis { color: #b91c1c; font-weight: bold; }
        .status-meningkat, .status-warning { color: #b45309; font-weight: bold; }
        .status-normal, .status-aman { color: #15803d; font-weight: bold; }
        
        /* Box Tanda Tangan */
        .ttd-box { width: 300px; float: right; margin-top: 40px; text-align: center; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>Klinik UjiBase Health</h2>
        <p>Sistem Analisis Tren Penyakit & Manajemen Inventaris Obat</p>
        <p>Jl. Kesehatan No. 123, Surabaya | Telp: (031) 123456</p>
    </div>