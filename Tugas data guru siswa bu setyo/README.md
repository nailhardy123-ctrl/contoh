# SIAKAD Pro &bull; Aplikasi Data Guru & Siswa
**Tugas Pemrograman Web & Basis Data — Pembimbing: Dra. Setyo Rahayu, M.Pd.**

Aplikasi sistem informasi akademik modern berbasis **PHP 8 Native, MySQL 8, dan Bootstrap 5.3**, dilengkapi grafik visual interaktif (**Chart.js**), ekspor data ke Excel, cetak kartu tanda pelajar (ID Card), serta format laporan cetak resmi ber-Kop Surat.

---

## 🎨 Pembaruan Desain Modern & Estetik (v2.0)

1. **Desain Visual Modern & Glassmorphism**:
   - Tipografi menggunakan font modern Google Fonts **Plus Jakarta Sans**.
   - Palet warna profesional (Indigo, Cyan, Emerald, Rose) dengan aksen *gradient mesh* dan *subtle ambient glow*.
   - Navigasi atas melayang (*sticky glassmorphic navbar*) dengan efek blur, indikator live status aktif, serta tombol akses cepat.
   - Kartu statistik bergradien dilengkapi gelembung ikon dan indikator proporsi persentase siswa.

2. **Grafik Visual Interaktif (Chart.js)**:
   - **Donut Chart**: Menampilkan visualisasi persentase distribusi siswa berdasarkan kompetensi keahlian/jurusan (RPL, TKJ, DKV, dll.).
   - **Bar Chart**: Menampilkan statistik komposisi tenaga pendidik berdasarkan status kepegawaian (PNS, PPPK, Guru Tetap, Honorer).

3. **Fitur Kartu Tanda Pelajar & Kartu Pendidik (ID Card)**:
   - Generator **Kartu Tanda Siswa** (`siswa/kartu.php`) berstandar ID Card CR80 dengan mockup foto, barcode NISN, dan pengesahan Bu Setyo.
   - Generator **Kartu Tenaga Pendidik** (`guru/kartu.php`) berstandar resmi sekolah.

4. **Ekspor Data ke Microsoft Excel**:
   - Tombol 1-klik untuk mengunduh seluruh data guru (`guru/export_excel.php`) dan siswa (`siswa/export_excel.php`) ke format spreadsheet Excel (.xls) yang rapi.

5. **Format Cetak Laporan Resmi (Paper Sheet Print)**:
   - Halaman cetak ramah printer dengan Kop Surat resmi dinas pendidikan, tabel berbingkai rapi, dan kolom tanda tangan pengesahan Bu Setyo.

---

## 📂 Struktur Direktori Proyek

```text
Tugas data guru siswa bu setyo/
├── config/
│   └── database.php         # Konfigurasi MySQL + Auto Installer database & data awal
├── includes/
│   ├── header.php           # Navbar modern, styling Plus Jakarta Sans, Chart.js & Bootstrap
│   └── footer.php           # Footer, inisialisasi Tooltip & SweetAlert2 modern
├── guru/
│   ├── index.php            # Daftar data guru + pencarian + filter status
│   ├── tambah.php           # Formulir input guru dengan card pilihan gender
│   ├── edit.php             # Formulir edit guru
│   ├── hapus.php            # Proses hapus guru dengan SweetAlert2
│   ├── detail.php           # Profil lengkap guru + tombol kontak WhatsApp
│   ├── kartu.php            # Cetak Kartu Tenaga Pendidik (Staff ID Card)
│   ├── export_excel.php     # Ekspor seluruh data guru ke file Excel (.xls)
│   └── cetak.php            # Cetak laporan resmi data guru (Kop Surat)
├── siswa/
│   ├── index.php            # Daftar data siswa + pencarian + filter jurusan
│   ├── tambah.php           # Formulir input siswa dengan validasi unik NISN/NIS
│   ├── edit.php             # Formulir edit data siswa
│   ├── hapus.php            # Proses hapus data siswa
│   ├── detail.php           # Profil lengkap siswa + kontak WhatsApp
│   ├── kartu.php            # Cetak Kartu Tanda Siswa (Student ID Card)
│   ├── export_excel.php     # Ekspor seluruh data siswa ke file Excel (.xls)
│   └── cetak.php            # Cetak laporan resmi data siswa (Kop Surat)
├── index.php                # Dashboard utama dengan Chart.js & kartu statistik
├── database.sql             # Skema SQL & data sampel awal (siap diimpor)
└── README.md                # Dokumentasi aplikasi
```

---

## 🚀 Cara Menjalankan Aplikasi di Laragon

1. Buka aplikasi **Laragon** di laptop/komputer Anda.
2. Klik tombol **"Start All"** (menyalakan Apache & MySQL).
3. Buka browser dan buka tautan berikut:
   ```
   http://localhost/Tugas data guru siswa bu setyo
   ```
   *atau jika menggunakan Virtual Host Laragon:*
   ```
   http://tugas-data-guru-siswa-bu-setyo.test
   ```
4. **Database Otomatis**: Saat pertama kali dibuka di browser, sistem secara otomatis membuat database `db_sekolah_bu_setyo`, membuat tabel `siswa` & `guru`, serta mengisi data awal guru dan siswa (termasuk data Bu Setyo).
