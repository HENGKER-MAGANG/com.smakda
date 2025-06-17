-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2025 at 06:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `com_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','izin','sakit','alpa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `username`, `role`, `tanggal`, `status`) VALUES
(1, 'khuznul', 'anggota', '2025-05-30', 'hadir'),
(2, 'syafaat', 'bendahara', '2025-06-21', 'hadir'),
(3, 'admin', 'ketua', '2025-06-14', 'hadir'),
(4, 'airil', 'anggota', '2025-06-14', 'hadir'),
(5, 'ikhsan', 'ketua', '2025-06-14', 'hadir'),
(6, 'imay', 'sekretaris', '2025-06-14', 'hadir'),
(7, 'khuznul', 'anggota', '2025-06-14', 'hadir'),
(8, 'syafaat', 'bendahara', '2025-06-14', ''),
(9, 'admin', 'ketua', '2025-06-15', 'izin'),
(10, 'airil', 'anggota', '2025-06-15', 'izin'),
(11, 'ikhsan', 'ketua', '2025-06-15', 'izin'),
(12, 'imay', 'sekretaris', '2025-06-15', 'izin'),
(13, 'khuznul', 'anggota', '2025-06-15', 'sakit'),
(14, 'syafaat', 'bendahara', '2025-06-15', 'izin'),
(23, 'andini', 'bendahara', '2025-06-16', 'hadir'),
(24, 'Ikhsan Pratama', 'ketua', '2025-06-16', 'hadir'),
(25, 'Lutfiah', 'anggota', '2025-06-16', 'hadir'),
(26, 'Muh Syafaat Al Amin', 'anggota', '2025-06-16', 'hadir'),
(27, 'MUSLIMAH ITMA INQLB', 'sekretaris', '2025-06-16', 'hadir'),
(28, 'Panyamengi', 'anggota', '2025-06-16', 'hadir'),
(29, 'SITI FATIMAH', 'anggota', '2025-06-16', 'hadir');

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal` date NOT NULL,
  `tempat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id`, `judul`, `deskripsi`, `tanggal`, `tempat`) VALUES
(1, 'petir', 'acara untuk memberikan pelatihan pada anak - anak smp mengenai teknologi IOT', '2025-05-03', 'SMK Negeri 2 Pinrang');

-- --------------------------------------------------------

--
-- Table structure for table `dokumentasi`
--

CREATE TABLE `dokumentasi` (
  `id` int(11) NOT NULL,
  `nama_file` varchar(50) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokumentasi`
--

INSERT INTO `dokumentasi` (`id`, `nama_file`, `keterangan`, `tanggal`) VALUES
(1, '1748600161_ice_cream.png', 'ini foto es krim', '2025-05-12'),
(3, '1749786848_andini.jpg', 'Monyet', '2025-06-13');

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE `kas` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `tipe` enum('masuk','keluar','','') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `status` enum('berjalan','selesai','berhenti','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `nama`, `deskripsi`, `tanggal_mulai`, `status`) VALUES
(1, 'Website perpustakaan', 'Ini adalah website perpustakaan', '2025-05-14', 'berjalan'),
(2, 'Panic Bully', 'Website untuk menangani pembulian secara online', '2025-05-04', 'berjalan'),
(5, 'website curhat', 'Ini website untuk memberikan curhatan untuk pihak sekolah.', '2025-05-17', 'berjalan');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `whatsapp_group_link` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `whatsapp_group_link`) VALUES
(1, 'https://chat.whatsapp.com/xxxxxxxxxxx');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('ketua','sekretaris','bendahara','anggota') NOT NULL,
  `status` enum('aktif','menunggu','','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `status`, `created_at`) VALUES
(32, 'SITI FATIMAH', '$2y$10$ArdAEWHknk9uju51Dii.tunQj94wNryMO46BFbEisStCHNulf/GSy', 'anggota', 'aktif', '2025-06-16 02:41:59'),
(33, 'Lutfiah', '$2y$10$Lj4nJxXJmRaKBBQWZkm7H.KduA5WP3wQERF4mmZjR7iKCQsaq09Qu', 'anggota', 'aktif', '2025-06-16 03:07:31'),
(34, 'Muh Syafaat Al Amin', '$2y$10$OUWM32SnXe3/npaJcCIVOu2AJVXgiP8H6uBQZpMBH.hFs8T2jzq6q', 'anggota', 'aktif', '2025-06-16 03:08:27'),
(35, 'st.nurpadilla', '$2y$10$kK3DYjZhNrWNjvRSHTg4RO.U/WvyMDuI3Dp45uqksKZq5IfrlZFre', 'sekretaris', 'aktif', '2025-06-16 03:09:21'),
(36, 'MUSLIMAH ITMA INQLB', '$2y$10$R.rOfm.JnhrfnBkVS2O0Euyd/VsVCziBBTE3zK5l7R2keaz/X/yce', 'sekretaris', 'aktif', '2025-06-16 03:10:53'),
(37, 'Panyamengi', '$2y$10$LNdOw7rZp6O85muTUjss1OjBOEOFU4gzIx7wOCuVnG9V9w035hi9y', 'anggota', 'aktif', '2025-06-16 03:11:05'),
(38, 'andini', '$2y$10$xooidIk7xfTfeWkXg8HoGeTO7PX3SVFY6q52g8cbQ7k.MBAgdncZW', 'bendahara', 'aktif', '2025-06-16 03:11:38'),
(39, 'Ikhsan Pratama', '$2y$10$ajUIUt75/.ix9iB/UR7gLeKMcmmC1ODz5hrGYJxCNH66DQDh/hnCS', 'ketua', 'aktif', '2025-06-16 03:39:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dokumentasi`
--
ALTER TABLE `dokumentasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dokumentasi`
--
ALTER TABLE `dokumentasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kas`
--
ALTER TABLE `kas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
