-- create_database.sql

-- Buat database
CREATE DATABASE inventory_system;

-- Gunakan database yang baru dibuat
USE inventory_system;

-- Buat tabel untuk menyimpan data barang
CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    image VARCHAR(255) NOT NULL
);