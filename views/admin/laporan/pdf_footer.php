<div class="ttd-box">
        <p>Surabaya, <?= date('d F Y') ?></p>
        <p style="margin-bottom: 70px;">Kepala Klinik UjiBase,</p>
        <p class="font-bold text-center" style="text-decoration: underline; margin: 0;">
            <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Admin Klinik') ?>
        </p>
    </div>

</body>
</html>