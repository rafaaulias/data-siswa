-- Database setup for Student Management CRUD System (latweb)
-- Database name: db_siswa

CREATE DATABASE IF NOT EXISTS `db_siswa`;
USE `db_siswa`;

-- Table structure for table `siswa`
CREATE TABLE IF NOT EXISTS `siswa` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(100) NOT NULL,
    `kelas` VARCHAR(50) NOT NULL,
    `alamat` TEXT,
    `no_hp` VARCHAR(20),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed sample data for testing
INSERT INTO `siswa` (`nama`, `kelas`, `alamat`, `no_hp`) VALUES
('Ahmad Rizky', 'XII RPL 1', 'Jl. Merdeka No. 12, Jakarta', '081234567890'),
('Siti Aminah', 'XII RPL 1', 'Jl. Mawar No. 45, Bandung', '082198765432'),
('Budi Santoso', 'XII RPL 2', 'Jl. Pemuda No. 8, Surabaya', '085711223344'),
('Dewi Lestari', 'XII TKJ 1', 'Jl. Diponegoro No. 19, Semarang', '081344556677');
