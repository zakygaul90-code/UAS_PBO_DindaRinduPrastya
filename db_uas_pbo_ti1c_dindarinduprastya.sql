-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 22, 2026 at 07:33 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uas_pbo_ti1c_dindarinduprastya`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_karyawan`
--

CREATE TABLE `tabel_karyawan` (
  `id_karyawan` varchar(10) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `departemen` varchar(50) NOT NULL,
  `hari_kerja_masuk` int NOT NULL,
  `gaji_dasar_per_hari` decimal(12,2) NOT NULL,
  `jenis_karyawan` enum('kontrak','tetap','magang') NOT NULL,
  `durasi_kontrak_bulan` int DEFAULT NULL,
  `agensi_penyalur` varchar(100) DEFAULT NULL,
  `tunjangan_kesehatan` decimal(12,2) DEFAULT NULL,
  `opsi_saham_id` varchar(20) DEFAULT NULL,
  `uang_saku_bulanan` decimal(12,2) DEFAULT NULL,
  `sertifikat_kampus_merdeka` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_karyawan`
--

INSERT INTO `tabel_karyawan` (`id_karyawan`, `nama_karyawan`, `departemen`, `hari_kerja_masuk`, `gaji_dasar_per_hari`, `jenis_karyawan`, `durasi_kontrak_bulan`, `agensi_penyalur`, `tunjangan_kesehatan`, `opsi_saham_id`, `uang_saku_bulanan`, `sertifikat_kampus_merdeka`) VALUES
('KAY-001', 'Andi Pratama', 'IT', 22, '250000.00', 'tetap', NULL, NULL, '500000.00', 'ESOP-001', NULL, NULL),
('KAY-002', 'Budi Santoso', 'Finance', 21, '230000.00', 'tetap', NULL, NULL, '500000.00', 'ESOP-002', NULL, NULL),
('KAY-003', 'Citra Dewi', 'HRD', 22, '220000.00', 'tetap', NULL, NULL, '450000.00', 'ESOP-003', NULL, NULL),
('KAY-004', 'Deni Setiawan', 'Marketing', 20, '210000.00', 'tetap', NULL, NULL, '450000.00', 'ESOP-004', NULL, NULL),
('KAY-005', 'Eka Rahmawati', 'Operations', 23, '240000.00', 'tetap', NULL, NULL, '500000.00', 'ESOP-005', NULL, NULL),
('KAY-006', 'Fajar Nugroho', 'IT', 22, '260000.00', 'tetap', NULL, NULL, '600000.00', 'ESOP-006', NULL, NULL),
('KAY-007', 'Gita Permata', 'Legal', 21, '230000.00', 'tetap', NULL, NULL, '500000.00', 'ESOP-007', NULL, NULL),
('KAY-008', 'Hendra Wijaya', 'IT', 22, '180000.00', 'kontrak', 12, 'PT Mitra Solusi', NULL, NULL, NULL, NULL),
('KAY-009', 'Indah Lestari', 'Marketing', 20, '170000.00', 'kontrak', 6, 'PT Bakti Jaya', NULL, NULL, NULL, NULL),
('KAY-010', 'Joko Susilo', 'Operations', 22, '165000.00', 'kontrak', 12, 'PT Mitra Solusi', NULL, NULL, NULL, NULL),
('KAY-011', 'Kurnia Utama', 'Finance', 21, '185000.00', 'kontrak', 24, 'PT Talent Source', NULL, NULL, NULL, NULL),
('KAY-012', 'Larasati Putri', 'HRD', 22, '170000.00', 'kontrak', 6, 'PT Bakti Jaya', NULL, NULL, NULL, NULL),
('KAY-013', 'Muhammad Rizky', 'IT', 19, '190000.00', 'kontrak', 12, 'PT Mitra Solusi', NULL, NULL, NULL, NULL),
('KAY-014', 'Nadia Utami', 'Creative', 21, '175000.00', 'kontrak', 6, 'PT Talent Source', NULL, NULL, NULL, NULL),
('KAY-015', 'Oki Syahputra', 'IT', 20, '90000.00', 'magang', NULL, NULL, NULL, NULL, '1500000.00', 'Sertifikat MSIB - Backend Web'),
('KAY-016', 'Putri Amelia', 'HRD', 22, '85000.00', 'magang', NULL, NULL, NULL, NULL, '1500000.00', 'Sertifikat MSIB - HR Specialist'),
('KAY-017', 'Qori Ramadhan', 'Marketing', 18, '85000.00', 'magang', NULL, NULL, NULL, NULL, '1500000.00', 'Sertifikat MSIB - Digital Marketing'),
('KAY-018', 'Rian Hidayat', 'IT', 21, '95000.00', 'magang', NULL, NULL, NULL, NULL, '1800000.00', 'Sertifikat Mandiri - Data Analyst'),
('KAY-019', 'Siti Aminah', 'Finance', 22, '85000.00', 'magang', NULL, NULL, NULL, NULL, '1500000.00', 'Sertifikat MSIB - Corporate Finance'),
('KAY-020', 'Taufik Hidayat', 'Creative', 20, '90000.00', 'magang', NULL, NULL, NULL, NULL, '1500000.00', 'Sertifikat MSIB - UI/UX Designer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_karyawan`
--
ALTER TABLE `tabel_karyawan`
  ADD PRIMARY KEY (`id_karyawan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
