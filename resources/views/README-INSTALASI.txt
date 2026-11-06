PAKET VIEWS UPA PERAWATAN

1. Ekstrak folder resources/views dari ZIP ini.
2. Salin seluruh isi folder views ke:
   F:\Mirza\laragon\www\sip\resources\views
3. Pastikan file-file berada pada struktur folder yang sama.
4. Bersihkan cache:
   php artisan view:clear
   php artisan route:clear
   php artisan route:list

CATATAN PENTING:
- View ini mengikuti nama route yang diberikan pengguna.
- Route cek status memakai nama cek-status.search dan method CekStatusController::search.
- Controller perlu mengirim data yang dipakai view, misalnya:
  * register: units
  * pelapor laporan create: gedungs, kategoris
  * daftar laporan: laporans
  * UPA detail: teknisis
  * dashboard: variabel statistik sesuai nama yang dipakai di view.
- Admin index mengharapkan variabel users, units, gedungs, atau kategoris sesuai halaman.
- Relasi model yang dipakai: pelapor, unit, gedung, kategori, fotos, riwayat, penugasan.
- Pada tabel foto, path diasumsikan disimpan relatif terhadap disk public.
- Cek status publik sebaiknya memakai nomor tiket + kode verifikasi privat agar informasi laporan tidak terbuka hanya dengan menebak nomor tiket.
- View ini adalah lapisan tampilan. Validasi, otorisasi, query, upload, dan transisi status tetap harus dibuat di controller.
