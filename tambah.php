<?php
/**
 * ====================================================
 *   BACKEND: TAMBAH TUGAS
 * ====================================================
 * Dipanggil lewat fetch() dari script.js.
 * Mengembalikan JSON berisi data tugas yang baru dibuat.
 */

require_once __DIR__ . "/config/database.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["status" => "error", "pesan" => "Method tidak diizinkan."]);
    exit;
}

$teks = trim($_POST["teks"] ?? "");

if ($teks === "") {
    http_response_code(400);
    echo json_encode(["status" => "error", "pesan" => "Teks tugas tidak boleh kosong."]);
    exit;
}

$stmt = $koneksi->prepare("INSERT INTO tugas (teks, selesai) VALUES (:teks, 0)");
$stmt->execute(["teks" => $teks]);

$id_baru = $koneksi->lastInsertId();

echo json_encode([
    "status" => "ok",
    "tugas" => [
        "id" => (int) $id_baru,
        "teks" => htmlspecialchars($teks, ENT_QUOTES, "UTF-8"),
        "selesai" => 0,
    ],
]);