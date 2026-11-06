PAKET CONTROLLER UPA PERAWATAN

Folder di dalam ZIP mengikuti struktur app/Http/Controllers.
Salin seluruh folder dan file dari folder app/Http/Controllers pada ZIP
ke F:\Mirza\laragon\www\sip\app\Http\Controllers.

File tambahan landing/hasil-status.blade.php:
salin ke resources/views/landing/hasil-status.blade.php.

Setelah menyalin:
1. Pastikan model dan migration yang menjadi dependensi sudah ada.
2. Jalankan:
   composer dump-autoload
   php artisan optimize:clear
   php artisan route:list

CATATAN PENTING:
- Kode ini mengikuti nama tabel, kolom, status, relasi, dan route yang sudah direncanakan pada proyek.
- Pastikan model memiliki relasi yang dipanggil controller:
  Laporan: pelapor, gedung, kategori, fotos, riwayat, penugasan, verifikasi.
  RiwayatStatus: pengguna.
  User: unit, users() dipakai Unit.
  Unit: users().
  Gedung: laporan().
  KategoriKerusakan: laporan().
  Laporan: penugasan().
- Pastikan model mengizinkan mass assignment untuk field yang digunakan.
- Upload foto menggunakan disk public pada folder storage/app/public/laporan.
  Jalankan php artisan storage:link jika belum dibuat.
- Cek status publik pada contoh ini hanya memakai nomor tiket. Untuk produksi,
  sebaiknya tambahkan kode pelacakan rahasia/token agar data laporan tidak bisa
  dilihat orang lain yang mengetahui atau menebak nomor tiket.
- Pastikan enum status migration memuat nilai yang digunakan controller.
- Route resource kategori-kerusakan menggunakan implicit binding parameter
  kategori_kerusakan.
- Form admin user membutuhkan password_confirmation karena validasi confirmed.
- Untuk halaman admin index, variabel yang dikirim controller sudah sesuai
  dengan views: users, units, gedungs, kategoris.
- Controller ini adalah implementasi awal. Sesuaikan bila nama kolom/relasi
  migration/model aktual berbeda.
