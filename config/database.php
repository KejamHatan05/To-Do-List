<?php
/**
 * ====================================================
 *   KONEKSI DATABASE (PDO) - VERSI DEPLOY
 * ====================================================
 * File ini AMAN untuk di-push ke GitHub / repo publik,
 * karena TIDAK berisi kredensial database asli.
 *
 * Urutan prioritas pengambilan kredensial:
 *   1. Environment variable (kalau hosting mendukung, mis. Railway/Render)
 *   2. File config/database.local.php (kalau ada di server/komputer kamu)
 *   3. Nilai default untuk development lokal (XAMPP: root, tanpa password)
 *
 * CARA PAKAI DI HOSTING GRATIS (InfinityFree, dll yang tidak
 * mendukung environment variable):
 *   1. Copy file config/database.local.example.php
 *   2. Rename jadi     config/database.local.php
 *   3. Isi dengan kredensial asli dari Control Panel hosting kamu
 *   4. Upload file database.local.php itu ke server
 *   5. JANGAN commit file database.local.php ke Git (sudah otomatis
 *      diabaikan lewat .gitignore)
 */

// --- Nilai default untuk development lokal (XAMPP/Laragon) ---
$konfigurasi_db = [
    "host"   => "localhost",
    "dbname" => "todo_php",
    "user"   => "root",
    "pass"   => "",
];

// --- Prioritas 2: override dari file lokal (tidak masuk Git) ---
$file_konfigurasi_lokal = __DIR__ . "/database.local.php";
if (file_exists($file_konfigurasi_lokal)) {
    $override = require $file_konfigurasi_lokal;
    if (is_array($override)) {
        $konfigurasi_db = array_merge($konfigurasi_db, $override);
    }
}

// --- Prioritas 1 (tertinggi): override dari environment variable ---
$konfigurasi_db["host"]   = getenv("DB_HOST")   ?: $konfigurasi_db["host"];
$konfigurasi_db["dbname"] = getenv("DB_NAME")   ?: $konfigurasi_db["dbname"];
$konfigurasi_db["user"]   = getenv("DB_USER")   ?: $konfigurasi_db["user"];
$konfigurasi_db["pass"]   = getenv("DB_PASS")   ?: $konfigurasi_db["pass"];

// --- Buat koneksi PDO ---
try {
    $koneksi = new PDO(
        "mysql:host={$konfigurasi_db['host']};dbname={$konfigurasi_db['dbname']};charset=utf8mb4",
        $konfigurasi_db["user"],
        $konfigurasi_db["pass"],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // Pesan error TIDAK menampilkan detail kredensial, hanya info umum
    die(
        "Koneksi database gagal. Kemungkinan penyebab:<br>" .
        "1. MySQL belum jalan (kalau di lokal, cek XAMPP Control Panel)<br>" .
        "2. Kredensial di config/database.local.php belum sesuai (kalau di hosting)<br>" .
        "3. Database '{$konfigurasi_db['dbname']}' belum diimport<br><br>" .
        "Detail teknis: " . $e->getMessage()
    );
}