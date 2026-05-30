1. Persiapan Database (Eksekusi di phpMyAdmin)
   Karena kita mengubah teks "Nama Dokter" menjadi relasi data, kita perlu membuat tabel dokter dan merombak tabel resep. Jalankan query SQL ini di database db_ujibase_health kamu:

```sql
-- 1. Buat tabel master dokter
CREATE TABLE dokter (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_dokter VARCHAR(100) NOT NULL,
    spesialisasi VARCHAR(100) NOT NULL,
    telepon VARCHAR(20) NOT NULL
);

-- 2. Masukkan 1 data awal agar saat tabel resep diubah, data lama tidak error
INSERT INTO dokter (nama_dokter, spesialisasi, telepon) VALUES ('dr. Budi Santoso', 'Dokter Umum', '081234567890');

-- 3. Tambahkan kolom dokter_id pada tabel resep dengan nilai default 1 (dr. Budi)
ALTER TABLE resep ADD dokter_id INT NOT NULL DEFAULT 1;

-- 4. Hapus kolom nama_dokter yang lama (bentuk teks) karena sudah digantikan relasi ID
ALTER TABLE resep DROP COLUMN nama_dokter;

-- 5. Cabut aturan default 1 agar ke depannya input form tetap mewajibkan kita memilih
ALTER TABLE resep ALTER dokter_id DROP DEFAULT;

-- 6. Pasang Foreign Key untuk menjaga integritas relasi antar tabel
ALTER TABLE resep ADD CONSTRAINT fk_resep_dokter FOREIGN KEY (dokter_id) REFERENCES dokter(id) ON DELETE RESTRICT ON UPDATE CASCADE;
```
