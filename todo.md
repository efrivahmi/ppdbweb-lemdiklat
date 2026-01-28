# To-Do List Revisi Guru & Sistem Akademik

## 1. Hak Akses Guru

-   [x] **Dashboard Guru**
    -   [x] Guru hanya bisa **upload berkas administrasi** (untuk pengajuan surat kerja guru).
    -   [x] Tidak ada akses untuk melihat data siswa atau statistik pendaftaran.
-   [x] **Akses Mapel**
    -   [x] Setiap guru sudah otomatis memiliki **mapel utama** yang ditetapkan sistem.
    -   [x] Guru hanya bisa membuat dan mengedit soal **untuk mapel yang dia pegang**.
    -   [x] Beri **badge atau label mapel** di profil guru agar mudah dikenali.
-   [x] **Akses Fitur Terbatas**
    -   [x] Guru **tidak bisa membuat custom test** secara bebas.
    -   [x] Hanya guru mapel terkait yang dapat membuat dan mengedit soal.
    -   [x] Guru **tidak bisa menghapus atau mengedit data pengguna/siswa**.
    -   [x] Akses **hapus dan ACC pengguna** hanya dimiliki oleh **admin**.

---

## 2. Fitur Custom Test & Koreksi Jawaban

-   [x] Hanya **guru mapel terkait** (yang memiliki badge akses) yang dapat:
    -   [x] Membuat **Custom Test**.
    -   [x] Melihat dan **mengoreksi jawaban siswa** untuk mapel tersebut.
-   [x] Sistem memastikan hanya guru dengan mapel yang cocok yang dapat mengakses soal dan hasil ujian.
-   [x] Guru **tidak memiliki akses ke informasi siswa secara global** — hanya hasil ujian relevan.

---

## 3. Administrasi Guru

-   [x] Guru dapat **mengunggah berkas administrasi**, seperti:
    -   [x] SK Mengajar
    -   [x] Ijazah
    -   [x] Sertifikat pendukung
-   [ ] Setelah unggah selesai, sistem otomatis **mengirim notifikasi ke admin** untuk verifikasi.
-   [ ] Setelah disetujui admin, sistem menghasilkan **surat kerja guru** otomatis (atau manual oleh admin).

---

## 4. Kuesioner Orang Tua (Akademik)

-   [x] Buat **formulir kuesioner orang tua** untuk aspek akademik siswa.
-   [x] Topik kuesioner bisa diatur di admin mapel.
-   [x] Data hasil kuesioner disimpan untuk analisis nilai dan evaluasi guru.
-   [] Hanya **admin** yang dapat melihat hasil lengkap dan statistik kuesioner.

---

## 5. Hak Akses Admin

-   [ ] Admin dapat:
    -   [ ] Melihat semua data guru & siswa.
    -   [ ] Mengelola akses guru (custom test, koreksi, dsb).
    -   [ ] Menyetujui / menolak berkas administrasi guru.
    -   [ ] Melihat dan menghapus data pengguna.

---

## 6. Catatan Tambahan

-   [ ] Terapkan sistem **Role-Based Access Control (RBAC)** untuk keamanan.
-   [ ] Gunakan **badge visual** (ikon / warna mapel) untuk membedakan hak akses guru.
-   [ ] Tambahkan **log aktivitas** (siapa membuat soal, siapa koreksi, dll) untuk audit sistem.

---

### 7. Revisi Urgent

-   [x] Hapus fitur siswa di guru
