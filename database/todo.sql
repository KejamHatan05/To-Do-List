-- ====================================================
--   SKEMA DATABASE: TO-DO LIST
-- ====================================================
-- Cara pakai: buka phpMyAdmin -> Import -> pilih file ini
-- (atau copy-paste isi file ini ke tab SQL di phpMyAdmin)

CREATE DATABASE IF NOT EXISTS todo_php CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE todo_php;

CREATE TABLE IF NOT EXISTS tugas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teks VARCHAR(255) NOT NULL,
    selesai TINYINT(1) NOT NULL DEFAULT 0,
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Data contoh (opsional, boleh dihapus)
INSERT INTO tugas (teks, selesai) VALUES
    ('Belajar PHP dan MySQL', 1),
    ('Selesaikan project To-Do List', 0),
    ('Push ke GitHub', 0);