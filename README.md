# 📚 Sistem Informasi Perpustakaan SMKN 1 Ciomas

Aplikasi berbasis web untuk otomasi sirkulasi dan pengelolaan perpustakaan di **SMK Negeri 1 Ciomas**, Kabupaten Bogor. Dibuat menggunakan framework **Laravel 12 (PHP 8.2+)**, database **MySQL**, dan **Tailwind CSS**.

---

## 🚀 Fitur Aplikasi
- **Dashboard Ringkasan**: Statistik judul buku, eksemplar, transaksi aktif, buku jatuh tempo, dan rekap denda.
- **Katalog Buku (CRUD)**: Tambah, lihat, cari, filter kategori, edit, dan hapus data buku & lokasi rak.
- **Sirkulasi Peminjaman (CRUD)**: Pencatatan peminjaman buku oleh siswa (dengan relasi otomatis ke stok buku).
- **Pengembalian & Denda Otomatis**: Pengembalian 1-klik dengan penghitungan denda otomatis (Rp 1.000 / hari jika terlambat).
- **Cetak Slip Peminjaman Siswa**: Kartu bukti pinjam resmi dengan barcode dan kolom tanda tangan.
- **Cetak Laporan Rekapitulasi**: Laporan resmi ber-Kop Surat Dinas Pendidikan Jawa Barat & SMKN 1 Ciomas siap cetak/simpan PDF.

---

## 🛠️ Kebutuhan Sistem (Prerequisites)
Sebelum menjalankan aplikasi, pastikan komputer/laptop sudah terpasang:
1. **XAMPP** (Apache & MySQL berjalan).
2. **PHP** versi 8.2 atau yang lebih baru.
3. **Composer** (Package Manager PHP).
4. **Node.js & npm** (disarankan versi 18+).

---

## 📖 Panduan Instalasi (Step-by-Step)

Ikuti langkah-langkah berikut secara berurutan:

### Langkah 1: Pindahkan / Buka Folder Project
Pastikan folder project diletakkan di dalam folder `htdocs` XAMPP, contoh:
```text
C:\xampp\htdocs\arsyavin
```
Buka terminal (Command Prompt / PowerShell / Git Bash) di folder tersebut.

---

### Langkah 2: Nyalakan Apache & MySQL di XAMPP
1. Buka aplikasi **XAMPP Control Panel**.
2. Klik tombol **Start** pada modul **Apache** dan **MySQL** hingga indikatornya berwarna hijau.

---

### Langkah 3: Install Dependensi PHP (Composer)
Jalankan perintah berikut di terminal:
```bash
composer install
```
*(Tunggu hingga proses download vendor selesai).*

---

### Langkah 4: Install Dependensi Frontend (Node/NPM)
Jalankan perintah berikut:
```bash
npm install
```
Lalu build asset tampilan:
```bash
npm run build
```

---

### Langkah 5: Konfigurasi File Lingkungan (.env)
Jika belum ada file `.env`, buat salinan dari `.env.example`:

**Windows (PowerShell):**
```powershell
Copy-Item .env.example .env
```
**Windows (CMD):**
```cmd
copy .env.example .env
```

Buka file [`.env`](.env) dan pastikan bagian database sudah seperti berikut:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpustakaan_smkn1ciomas
DB_USERNAME=root
DB_PASSWORD=
```

---

### Langkah 6: Generate Application Key
Jalankan perintah ini untuk membuat enkripsi keamanan aplikasi:
```bash
php artisan key:generate
```

---

### Langkah 7: Buat Database di phpMyAdmin
1. Buka browser dan kunjungi: **`http://localhost/phpmyadmin`**
2. Klik menu **Basis Data (Database)** atau tombol **New (Baru)** di sebelah kiri.
3. Masukkan nama database:
   ```text
   perpustakaan_smkn1ciomas
   ```
4. Klik tombol **Buat (Create)**.

---

### Langkah 8: Jalankan Migrasi & Data Contoh (Seeding)
Jalankan perintah ini di terminal untuk membuat tabel dan mengisi data buku & siswa:
```bash
php artisan migrate --seed
```
*Hasilnya akan membuat tabel buku, transaksi peminjaman, serta 8 koleksi buku dan 7 riwayat peminjaman siswa SMKN 1 Ciomas.*

---

### Langkah 9: Menjalankan Aplikasi
Jalankan server lokal Laravel dengan perintah:
```bash
php artisan serve
```

Setelah muncul tulisan `Server running on [http://127.0.0.1:8000]`, buka browser dan akses alamat:
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

*(Atau jika menggunakan Apache XAMPP langsung, bisa diakses melalui `http://localhost/arsyavin/public`)*.

---

## 🎯 Cara Penggunaan Singkat
1. **Melihat Koleksi & Stok**:
   - Buka menu **Katalog Buku** di bagian atas.
   - Gunakan kolom cari atau filter kategori (Pelajaran, Fiksi, Teknologi, dll).
2. **Meminjamkan Buku ke Siswa**:
   - Klik tombol **Pinjam Buku** di kanan atas atau tombol ikon jabat tangan pada kartu buku.
   - Pilih judul buku yang ingin dipinjam (hanya buku dengan stok tersedia yang dapat dipinjam).
   - Masukkan Nama Siswa, NISN, Kelas (contoh: *XI PPLG 1*), dan tanggal jatuh tempo.
   - Klik **Simpan Peminjaman**.
3. **Mengembalikan Buku**:
   - Buka menu **Peminjaman**.
   - Cari nama siswa atau judul buku, lalu klik tombol hijau **Kembali**.
   - Jika pengembalian melewati batas waktu, denda dihitung otomatis (Rp 1.000 / hari).
4. **Mencetak Bukti / Laporan**:
   - Pada halaman peminjaman, klik ikon printer di kolom aksi untuk mencetak **Slip Peminjaman**.
   - Buka menu **Laporan Rekap** untuk melihat dan mencetak dokumen resmi perpustakaan.

---

## 🧪 Menjalankan Automated Test
Aplikasi ini dilengkapi 18 automated test untuk memvalidasi seluruh fungsi CRUD. Untuk menjalankan test:
```bash
php artisan test --compact
```

---

*Dibuat untuk keperluan tugas & praktikum kejuruan di **SMK Negeri 1 Ciomas**.*
