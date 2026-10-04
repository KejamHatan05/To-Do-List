<?php
/**
 * ====================================================
 *   BACKEND: TOGGLE STATUS SELESAI
 * ====================================================
 * Membalik status selesai (0 -> 1 atau 1 -> 0) untuk
 * satu tugas berdasarkan ID.
 */

require_once __DIR__ . "/config/database.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["status" => "error", "pesan" => "Method tidak diizinkan."]);
    exit;
}

$id = filter_var($_POST["id"] ?? "", FILTER_VALIDATE_INT);

if ($id === false || $id === null) {
    http_response_code(400);
    echo json_encode(["status" => "error", "pesan" => "ID tugas tidak valid."]);
    exit;
}

// Balik nilai selesai: kalau 0 jadi 1, kalau 1 jadi 0
$stmt = $koneksi->prepare("UPDATE tugas SET selesai = NOT selesai WHERE id = :id");
$stmt->execute(["id" => $id]);

// Ambil status terbaru untuk dikirim balik ke frontend
$stmt2 = $koneksi->prepare("SELECT selesai FROM tugas WHERE id = :id");
$stmt2->execute(["id" => $id]);
$hasil = $stmt2->fetch();

if (!$hasil) {
    http_response_code(404);
    echo json_encode(["status" => "error", "pesan" => "Tugas tidak ditemukan."]);
    exit;
}

echo json_encode(["status" => "ok", "selesai" => (int) $hasil["selesai"]]);