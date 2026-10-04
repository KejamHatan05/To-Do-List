<?php
/**
 * ====================================================
 *   TEMPLATE KREDENSIAL DATABASE (UNTUK HOSTING)
 * ====================================================
 * CARA PAKAI:
 *   1. Copy file ini, rename jadi: database.local.php
 *      (hapus kata ".example" dari nama file)
 *   2. Isi nilai di bawah dengan kredensial ASLI dari
 *      Control Panel hosting kamu (InfinityFree/Byet/dll)
 *   3. Upload file database.local.php (bukan file .example ini)
 *      ke folder config/ di server hosting
 *
 * PENTING: File "database.local.php" TIDAK BOLEH di-commit
 * ke Git / GitHub, karena isinya kredensial asli. File itu
 * sudah otomatis diabaikan lewat .gitignore.
 */

return [
    "host"   => "sql305.infinityfree.com",  // ganti sesuai hostname dari Control Panel
    "dbname" => "if0_42854009_todophp",    // ganti sesuai nama database kamu
    "user"   => "if0_42854009",            // ganti sesuai username database kamu
    "pass"   => "04b8SxqWFYu",
];