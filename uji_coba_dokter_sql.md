1. Persiapan Database (Eksekusi di phpMyAdmin)
   Karena kita mengubah teks "Nama Dokter" menjadi relasi data, kita perlu membuat tabel dokter dan merombak tabel resep. Jalankan query SQL ini di database db_ujibase_health kamu:

```sql
-- 0. Buat tabel master dokter
-- 1. Pastikan tabel master dokter terbentuk (IF NOT EXISTS mencegah error jika tabel sudah ada)
CREATE TABLE IF NOT EXISTS dokter (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_dokter VARCHAR(100) NOT NULL,
    spesialisasi VARCHAR(100) NOT NULL,
    telepon VARCHAR(20) NOT NULL
);

-- 2. Masukkan data awal menggunakan IGNORE agar tidak error jika data dr. Budi sudah pernah masuk
INSERT IGNORE INTO dokter (id, nama_dokter, spesialisasi, telepon)
VALUES (1, 'dr. Budi Santoso', 'Dokter Umum', '081234567890');

ALTER TABLE resep ADD COLUMN dokter_id INT NOT NULL DEFAULT 1;

ALTER TABLE resep ALTER COLUMN dokter_id DROP DEFAULT;

-- 4. Pasang Foreign Key untuk mengunci relasi
ALTER TABLE resep ADD CONSTRAINT fk_resep_dokter FOREIGN KEY (dokter_id) REFERENCES dokter(id) ON DELETE RESTRICT ON UPDATE CASCADE;

-- 3. Gunakan MODIFY COLUMN (bukan ADD). Ini akan memastikan kolom dokter_id ada, bertipe INT, dan tidak punya nilai DEFAULT, tanpa memicu error duplikat.
-- ALTER TABLE resep MODIFY COLUMN dokter_id INT NOT NULL;

-- 5. Hapus kolom teks nama_dokter (Abaikan jika muncul error "Can't DROP" karena berarti sudah terhapus)
-- ALTER TABLE resep DROP COLUMN nama_dokter;
```
