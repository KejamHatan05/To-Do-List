<?php
/**
 * ====================================================
 *   BACKEND: HAPUS TUGAS
 * ====================================================
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

$stmt = $koneksi->prepare("DELETE FROM tugas WHERE id = :id");
$stmt->execute(["id" => $id]);

if ($stmt->rowCount() === 0) {
    http_response_code(404);
    echo json_encode(["status" => "error", "pesan" => "Tugas tidak ditemukan."]);
    exit;
}

echo json_encode(["status" => "ok"]);