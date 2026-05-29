USE db_ujibase_health;

-- Mematikan pengecekan Foreign Key sementara
SET FOREIGN_KEY_CHECKS = 0;

-- Menghapus data dengan DELETE (DML) agar tidak bentrok dengan Foreign Key
DELETE FROM detail_transaksi;
ALTER TABLE detail_transaksi AUTO_INCREMENT = 1;

DELETE FROM transaksi;
ALTER TABLE transaksi AUTO_INCREMENT = 1;

DELETE FROM resep;
ALTER TABLE resep AUTO_INCREMENT = 1;

DELETE FROM obat;
ALTER TABLE obat AUTO_INCREMENT = 1;

DELETE FROM penyakit;
ALTER TABLE penyakit AUTO_INCREMENT = 1;

DELETE FROM pasien;
ALTER TABLE pasien AUTO_INCREMENT = 1;

DELETE FROM supplier;
ALTER TABLE supplier AUTO_INCREMENT = 1;

DELETE FROM kategori;
ALTER TABLE kategori AUTO_INCREMENT = 1;

DELETE FROM users;
ALTER TABLE users AUTO_INCREMENT = 1;

-- Menyalakan kembali pengecekan Foreign Key
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Data Pengguna (Role di-lock ketat sesuai ENUM)
-- Catatan: Password default untuk semua user di bawah ini adalah 'password' (di-hash menggunakan BCRYPT)
INSERT INTO users (nama_lengkap, username, password, role) VALUES
('Dr. Oppenheimer', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Kepala Klinik'),
('Puput', 'kasir1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Petugas');

-- 2. Data Kategori Obat
INSERT INTO kategori (nama_kategori) VALUES
('Analgesik & Antipiretik'), 
('Antibiotik'), 
('Obat Saluran Cerna'), 
('Vitamin & Suplemen'), 
('Obat Kardiovaskuler');

-- 3. Data Supplier
INSERT INTO supplier (nama_supplier, telepon, alamat) VALUES
('PT Sehat Sejahtera', '081234567890', 'Jl. Merdeka No.1, Surabaya'),
('CV Medika Pharma', '081987654321', 'Jl. Pahlawan No.45, Surabaya');

-- 4. Data Pasien (Bahan transaksi resep)
INSERT INTO pasien (no_identitas, nama_pasien, telepon, alamat, tanggal_daftar) VALUES
('3578012345678901', 'Dimas', '085611223344', 'Jl. Kenangan No. 10', '2026-05-01'),
('3578012345678902', 'Budi Santoso', '085622334455', 'Jl. Melati No. 5', '2026-05-15');

-- 5. Data Penyakit (Master Data untuk Laporan Indeks Morbiditas)
INSERT INTO penyakit (kode_icd, nama_penyakit, deskripsi) VALUES
('J10', 'Influenza', 'Infeksi pernapasan akibat virus'),
('I10', 'Hipertensi', 'Tekanan darah tinggi'),
('A09', 'Gastroenteritis (GEA)', 'Peradangan saluran pencernaan'),
('E56', 'Defisiensi Vitamin', 'Kekurangan asupan vitamin esensial');

-- 6. Data Obat (Memicu Peringatan Stok Kritis)
-- Logika Analitis: Stok Amoxicillin sengaja diset 5 (di bawah batas minimum 10) 
-- agar tampil di dashboard 'Peringatan Stok Obat Kritis'
INSERT INTO obat (kategori_id, supplier_id, kode_obat, nama_obat, satuan, stok, stok_minimum, harga_beli, harga_jual, expired_date) VALUES
(1, 1, 'OBT-001', 'Paracetamol 500mg', 'Strip', 50, 20, 3000, 5000, '2027-12-31'),
(2, 2, 'OBT-002', 'Amoxicillin 500mg', 'Strip', 5, 10, 5000, 8000, '2026-10-15'), 
(3, 1, 'OBT-003', 'Antasida Doen', 'Tablet', 100, 15, 2000, 4000, '2028-01-01'),
(5, 2, 'OBT-004', 'Amlodipine 5mg', 'Strip', 30, 10, 4000, 7000, '2027-05-20');

-- 7. Data Resep (Alur Bisnis)
-- Menghubungkan pasien, diagnosis penyakit, dan dokter. Status bersih tanpa emotikon.
INSERT INTO resep (pasien_id, penyakit_id, nama_dokter, tanggal_resep, status_resep) VALUES
(1, 1, 'dr. Andi', '2026-05-28', 'Selesai'),
(2, 2, 'dr. Siti', '2026-05-29', 'Selesai');

-- 8. Data Transaksi Penjualan (Dilakukan oleh Petugas / User ID 2)
INSERT INTO transaksi (kode_transaksi, resep_id, user_id, total_harga, tanggal_transaksi, status_pembayaran) VALUES
('TRX-260528-001', 1, 2, 10000, '2026-05-28 10:00:00', 'Lunas'),
('TRX-260529-002', 2, 2, 14000, '2026-05-29 14:30:00', 'Lunas');

-- 9. Data Detail Transaksi (Kalkulasi Matematis Anti Fiktif)
-- Logika: Jumlah * Harga Jual harus sama dengan Subtotal.
-- TRX 1: 2 Strip Paracetamol (ID Obat: 1) @ 5.000 = 10.000
INSERT INTO detail_transaksi (transaksi_id, obat_id, jumlah, harga_jual, subtotal) VALUES
(1, 1, 2, 5000, 10000);

-- TRX 2: 2 Strip Amlodipine (ID Obat: 4) @ 7.000 = 14.000
INSERT INTO detail_transaksi (transaksi_id, obat_id, jumlah, harga_jual, subtotal) VALUES
(2, 4, 2, 7000, 14000);