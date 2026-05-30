<?php 
$pdf_title = 'Laporan Estimasi Stok Obat';
require 'pdf_header.php'; 
?>

    <div class="periode">
        Laporan Analisis Estimasi Kebutuhan & Pergerakan Stok Obat<br>
        Periode Analisis: 
        <?php if (!empty($tgl_mulai) && !empty($tgl_selesai)): ?>
            <?= date('d M Y', strtotime($tgl_mulai)) ?> s/d <?= date('d M Y', strtotime($tgl_selesai)) ?>
        <?php else: ?>
            Keseluruhan Waktu (Semua Riwayat Penjualan)
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 12%;">Kode Obat</th>
                <th style="width: 28%;">Nama Obat</th>
                <th style="width: 10%;">Batas Min.</th>
                <th style="width: 10%;">Sisa Stok</th>
                <th style="width: 15%;">Kecepatan Keluar</th>
                <th style="width: 10%;">Status Keamanan</th>
                <th style="width: 15%;">Rekomendasi Restock</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laporan)): ?>
                <?php foreach($laporan as $row): 
                    $sisa = $row['sisa_stok'];
                    $min = $row['stok_minimum'];
                    $keluar = $row['stok_keluar'];
                    
                    if ($sisa <= $min) {
                        $status = 'KRITIS';
                        $class_status = 'status-kritis';
                    } elseif ($sisa <= ($min * 1.5)) {
                        $status = 'WASPADA';
                        $class_status = 'status-warning';
                    } else {
                        $status = 'AMAN';
                        $class_status = 'status-aman';
                    }

                    $rekomendasi = 0;
                    if ($status === 'KRITIS' || $status === 'WASPADA') {
                        $kebutuhan_dasar = max($min - $sisa, 0);
                        $buffer = ($keluar > $min) ? $keluar : $min;
                        $rekomendasi = $kebutuhan_dasar + $buffer;
                    }
                ?>
                <tr>
                    <td class="font-bold text-center"><?= htmlspecialchars($row['kode_obat']) ?></td>
                    <td><?= htmlspecialchars($row['nama_obat']) ?></td>
                    <td class="text-center"><?= $min ?> <?= $row['satuan'] ?></td>
                    <td class="text-center font-bold"><?= $sisa ?> <?= $row['satuan'] ?></td>
                    <td class="text-center"><?= $keluar ?> Keluar</td>
                    <td class="text-center <?= $class_status ?>"><?= $status ?></td>
                    <td class="text-center font-bold">
                        <?php if ($rekomendasi > 0): ?>
                            + <?= $rekomendasi ?> <?= $row['satuan'] ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data obat dalam sistem.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px; font-size: 11px; color: #555;">
        <strong>Catatan Sistem:</strong><br>
        * Rekomendasi Restock dihitung berdasarkan batas minimum inventaris ditambah parameter buffer kecepatan keluar obat selama periode analisis terpilih.
    </div>

<?php require 'pdf_footer.php'; ?>