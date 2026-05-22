# Dokumentasi Sistem Informasi Klinik - CodeIgniter 4

Sistem Informasi Klinik ini telah dikembangkan dengan mematuhi aturan pembatasan akses pengguna menjadi **hanya 3 role**. Seluruh hak akses, filter/middleware, menu navigasi sidebar, dan alur kerja (workflow) disesuaikan demi kenyamanan pasien (terutama usia di atas 40 tahun), dokter, serta apoteker.

---

## 👥 Hak Akses & Level Pengguna (3 Role)

| Role | `id_level` | Deskripsi Hak Akses & Fitur Utama |
|---|---|---|
| **Apoteker (Admin)** | `1` | Mengelola data master pasien, dokter, obat (stok, kadaluarsa, dsb.), melihat statistik, memproses status resep, dan memantau antrian secara global. |
| **Pasien** | `2` | Portal JKN Pasien: mengambil nomor antrian, mengisi keluhan, memperbarui profil pribadi, mengisi data kepesertaan BPJS, serta melihat riwayat resep & rekam medis secara read-only. |
| **Dokter** | `3` | Memeriksa antrian hari ini yang terdaftar pada kliniknya, mencatat rekam medis (termasuk pemeriksaan fisik, tanda vital, dan tanggal kontrol), membuat resep multi-obat langsung setelah pemeriksaan, serta memantau profil pribadi dokter. |

---

## 🛠️ Modul & Fitur yang Diimplementasikan

### 1. Modul Apoteker (Admin - id_level: 1)
*   **Dashboard Statistik Real**: Menampilkan total pasien terdaftar, total dokter aktif, jumlah obat dengan stok kritis (stok di bawah batas minimum), resep berstatus menunggu hari ini, dan total resep masuk.
*   **Manajemen Pasien**: Registrasi/CRUD pasien dengan kelengkapan data medis (golongan darah, alergi obat, riwayat penyakit, kontak darurat). Tersedia checkbox untuk otomatis membuat akun login pasien (`id_level` 2).
*   **Manajemen Dokter**: CRUD dokter lengkap dengan jadwal praktek (hari & jam) dan opsi otomatis membuat akun login dokter (`id_level` 3).
*   **Manajemen Resep**: Mengelola status resep (Menunggu, Diproses, Selesai/Diambil). Apoteker dapat merubah status resep saat obat diserahkan kepada pasien.
*   **Manajemen Obat**: CRUD stok obat, satuan, kandungan bahan aktif, serta tanggal kadaluarsa. Stok berkurang otomatis secara realtime saat resep dikonfirmasi.

### 2. Modul Dokter (id_level: 3)
*   **Daftar Antrian Praktik**: Dokter dapat melihat antrian pasien yang telah memesan kunjungan pada klinik miliknya (dengan status `menunggu` atau `dipanggil`).
*   **Pencatatan Rekam Medis (RM)**: Memiliki fitur periksa di mana dokter mengisi hasil diagnosa lengkap dengan **vital signs** (Tensi Darah, Nadi, Suhu Tubuh, Berat Badan, Tinggi Badan) dan tanggal kontrol kembali.
*   **Pemberian Resep Langsung**: Setelah menyimpan RM, dokter dapat langsung meresepkan kombinasi multi-obat dengan dosis/aturan pakai yang divalidasi langsung ke database stok obat.
*   **Profil Dokter**: Mengedit informasi kontak dan mengganti password secara mandiri.

### 3. Modul Pasien (id_level: 2)
*   **Dashboard Modern (Inspirasi Mobile JKN)**: Dilengkapi dengan ringkasan status kepesertaan BPJS, kartu tanda vital dari rekam medis terakhir, status nomor antrean mendatang secara langsung, serta ringkasan obat terbaru.
*   **Ambil Antrian Online**: Pasien memilih Poliklinik tujuan dan Dokter yang bertugas, lalu memasukkan keluhan utama. Sistem secara otomatis membatasi **maksimal 1 antrian aktif per hari per dokter per pasien** guna menghindari pemesanan ganda.
*   **Profil & Kepesertaan JKN/BPJS**: Formulir lengkap untuk memperbarui nomor kartu BPJS, status aktif, faskes rujukan, kelas perawatan, serta data medis pendukung.
*   **Rekam Medis & Resep Saya**: Melihat riwayat diagnosa dokter dan status peracikan obat di apotek secara read-only.

---

## 🗄️ Database & Schema (`localhost.sql`)

Struktur tabel database telah disesuaikan dan diekspor ke [localhost.sql](file:///d:/laragon/www/sistem_klinik/localhost.sql):
1.  `tb_user`: Berisi kredensial login.
2.  `tb_level_user`: Berisi pendefinisian level (1: Apoteker, 2: Pasien, 3: Dokter).
3.  `tb_pasien`: Menampung data BPJS dan profil pasien lengkap.
4.  `tb_dokter`: Data dokter beserta STR, jadwal, dan ketersediaan.
5.  `tb_antrean`: Menyimpan keluhan utama, status antrian, dan nomor antrean (format e.g., A01).
6.  `tb_rekam_medis`: Dilengkapi kolom vital signs (`tensi`, `nadi`, `suhu`, `berat_badan`, `tinggi_badan`, `pemeriksaan_fisik`, `tgl_kontrol`).
7.  `tb_resep` & `tb_resepdetail`: Manajemen status resep obat (`menunggu`, `diproses`, `selesai`).

---

## 🔑 Akun Uji Coba (Testing Logins)

Anda dapat masuk ke sistem menggunakan akun-akun pengujian berikut di halaman [Login](http://localhost:8080/login):

1.  **Apoteker (Admin / Level 1)**:
    *   **Username**: `admin`
    *   **Password**: `admin`
2.  **Dokter (Level 3)**:
    *   **Username**: `budi123`
    *   **Password**: `budi123`
3.  **Pasien (Level 2)**:
    *   **Username**: `testpatient`
    *   **Password**: `password123`
