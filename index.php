<?php
/**
 * ====================================================
 *   TO-DO LIST (PHP + MySQL) - HALAMAN UTAMA
 * ====================================================
 */

require_once __DIR__ . "/config/database.php";

$stmt = $koneksi->query("SELECT * FROM tugas ORDER BY dibuat_pada DESC");
$daftar_tugas = $stmt->fetchAll();

$total = count($daftar_tugas);
$selesai_count = count(array_filter($daftar_tugas, fn($t) => (int) $t["selesai"] === 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>To-Do List (PHP + MySQL)</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card">
    <div class="card__header">
        <h1>To-Do List</h1>
        <span class="ringkasan" id="ringkasan"><?= $selesai_count ?>/<?= $total ?> selesai</span>
    </div>

    <form id="formTambah" class="form-tambah">
        <input type="text" id="inputTugas" name="teks" placeholder="Tambah tugas baru..." autocomplete="off" required>
        <button type="submit">+</button>
    </form>

    <div class="filter" id="filterGrup">
        <button class="filter__btn aktif" data-filter="semua">Semua</button>
        <button class="filter__btn" data-filter="aktif">Aktif</button>
        <button class="filter__btn" data-filter="selesai">Selesai</button>
    </div>

    <ul class="daftar-tugas" id="daftarTugas">
        <?php if ($total === 0): ?>
            <li class="kosong" id="pesanKosong">Belum ada tugas. Tambahkan satu di atas!</li>
        <?php else: ?>
            <?php foreach ($daftar_tugas as $tugas): ?>
                <li class="tugas-item <?= $tugas["selesai"] ? "selesai" : "" ?>" data-id="<?= $tugas["id"] ?>" data-selesai="<?= $tugas["selesai"] ?>">
                    <span class="tugas-centang"></span>
                    <span class="tugas-teks"><?= htmlspecialchars($tugas["teks"]) ?></span>
                    <button class="tugas-hapus" title="Hapus">✕</button>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>

<script src="script.js"></script>
</body>
</html>