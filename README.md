# To-Do List (PHP + MySQL)

Aplikasi To-Do List dengan backend PHP dan database MySQL, tema dark terminal + hijau.

## Struktur Project

```
Todo list php/
├── index.php            # Halaman utama, ambil & tampilkan data dari database
├── tambah.php           # Backend: tambah tugas baru (dipanggil via fetch)
├── toggle.php           # Backend: ubah status selesai/belum tugas
├── hapus.php            # Backend: hapus tugas dari database
├── style.css            # Semua styling (tema dark terminal + hijau)
├── script.js            # Logika AJAX: tambah, toggle, hapus, filter
├── config/
│   └── database.php     # Koneksi ke MySQL pakai PDO
├── database/
│   └── todo.sql         # Skema database, import lewat phpMyAdmin
└── README.md            # Dokumentasi ini
```

## Cara Menjalankan

1. **Import database**: buka phpMyAdmin (`http://localhost/phpmyadmin`) → tab **Import** → pilih file `database/todo.sql`. Ini otomatis membuat database `todo_php`, tabel `tugas`, dan 3 data contoh.
2. **Cek koneksi**: buka `config/database.php`, pastikan `$user` dan `$pass` sesuai setting MySQL kamu (default XAMPP: `root`, tanpa password).
3. **Jalankan server**: buka terminal di folder `Todo list php`, jalankan:
   ```
   php -S localhost:8000
   ```
4. **Buka browser**: akses `http://localhost:8000`

## Alur Data (Cara Kerja)

```
Browser (script.js)
      │
      │  fetch() kirim request
      ▼
tambah.php / toggle.php / hapus.php
      │
      │  query lewat PDO (prepared statement)
      ▼
config/database.php ──► MySQL (database todo_php)
      │
      │  balas data
      ▼
Browser (update tampilan tanpa reload)
```

## Fitur

- Tambah tugas baru lewat input di atas
- Klik lingkaran di samping tugas untuk tandai selesai/belum
- Filter: Semua / Aktif / Selesai
- Hapus tugas (tombol ✕)
- Ringkasan jumlah tugas selesai (contoh: `2/5 selesai`)
- Semua interaksi pakai AJAX (`fetch`) — halaman tidak reload sama sekali

## Catatan

- `config/database.php` **cuma boleh berisi kode koneksi database**. Kalau file lain (misal `tambah.php`) sampai ke-rename atau kepindah ke folder `config/`, aplikasi bakal error karena path `require_once` jadi salah.
- Setiap ganti isi file PHP, **tidak perlu restart server** — cukup refresh browser. Restart server cuma diperlukan kalau kamu baru pertama kali menjalankan `php -S`, atau server sempat berhenti/crash.
