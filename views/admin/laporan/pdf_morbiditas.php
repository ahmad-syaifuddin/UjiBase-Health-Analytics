<?php 
// Set judul dokumen PDF
$pdf_title = 'Laporan Indeks Morbiditas';
require 'pdf_header.php'; 
?>

    <div class="periode">
        Laporan Indeks Morbiditas (Peringkat Tren Penyakit)<br>
        Periode: 
        <?php if (!empty($tgl_mulai) && !empty($tgl_selesai)): ?>
            <?= date('d M Y', strtotime($tgl_mulai)) ?> s/d <?= date('d M Y', strtotime($tgl_selesai)) ?>
        <?php else: ?>
            Keseluruhan Waktu (Semua Data)
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">Rank</th>
                <th style="width: 15%;">Kode ICD</th>
                <th style="width: 35%;">Klasifikasi Penyakit</th>
                <th style="width: 15%;">Total Kasus</th>
                <th style="width: 15%;">Persentase</th>
                <th style="width: 15%;">Status Tren</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laporan)): ?>
                <?php $no = 1; foreach($laporan as $row): 
                    $persentase = ($row['jumlah_kasus'] / $total_semua_kasus) * 100;
                    $status_tren = ($persentase >= 30) ? 'WASPADA' : (($persentase >= 10) ? 'MENINGKAT' : 'NORMAL');
                    $class_status = ($status_tren == 'WASPADA') ? 'status-waspada' : (($status_tren == 'MENINGKAT') ? 'status-meningkat' : 'status-normal');
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center font-bold"><?= htmlspecialchars($row['kode_icd']) ?></td>
                    <td><?= htmlspecialchars($row['nama_penyakit']) ?></td>
                    <td class="text-center"><?= $row['jumlah_kasus'] ?> Kasus</td>
                    <td class="text-center"><?= number_format($persentase, 1) ?>%</td>
                    <td class="text-center <?= $class_status ?>"><?= $status_tren ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="3" class="text-right">TOTAL KESELURUHAN KASUS:</td>
                    <td class="text-center"><?= $total_semua_kasus ?> Kasus</td>
                    <td colspan="2" class="text-center">100%</td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ditemukan rekam medis pada periode ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

<?php require 'pdf_footer.php'; ?>