-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 02:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `20_muzaky`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_masuk` time NOT NULL,
  `status_masuk` enum('Hadir','Terlambat') NOT NULL,
  `waktu_pulang` time DEFAULT NULL,
  `status_pulang` enum('Pulang','Terlambat') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `id_siswa`, `tanggal`, `waktu_masuk`, `status_masuk`, `waktu_pulang`, `status_pulang`) VALUES
(4, 9, '2024-11-13', '11:44:05', 'Terlambat', '13:08:55', 'Pulang'),
(5, 10, '2024-11-13', '13:21:41', 'Terlambat', NULL, NULL),
(6, 9, '2024-11-14', '07:26:01', 'Terlambat', '07:39:17', 'Terlambat'),
(7, 11, '2024-11-14', '07:53:15', 'Terlambat', '08:44:05', 'Pulang'),
(8, 13, '2024-11-14', '08:46:06', 'Hadir', '08:47:15', 'Pulang'),
(9, 14, '2024-11-14', '08:48:20', 'Hadir', '08:48:51', 'Pulang'),
(10, 15, '2024-11-14', '08:51:36', 'Terlambat', '08:51:43', 'Pulang'),
(11, 16, '2024-11-14', '08:54:22', 'Terlambat', '08:54:26', 'Pulang');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `waktu_masuk` time NOT NULL,
  `waktu_pulang` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `waktu_masuk`, `waktu_pulang`) VALUES
(1, '08:09:00', '08:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `absen` int(11) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `rfid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nisn`, `nama`, `absen`, `kelas`, `email`, `telepon`, `alamat`, `tanggal_daftar`, `rfid`) VALUES
(9, '0072304677', 'MUZAKY A\'WANUL MUJARRODIN ', 20, 'XII RPL 2', 'zackeyy308@gmail.com', '0859176863450', 'Lengkong ', '2024-11-13', '2024'),
(10, '0072304677', 'MUZAKY A\'WANUL MUJARRODIN ', 20, 'XII RPL 2', 'zackeyy308@gmail.com', '0859176863450', 'Lengkong ', '2024-11-13', '123456'),
(11, '0072304677', 'MUZAKY A\'WANUL MUJARRODIN ', 20, 'XII RPL 2', 'zackeyy308@gmail.com', '0859176863450', 'Lengkong ', '2024-11-14', '2025'),
(12, '0072304677', 'MUZAKY A\'WANUL MUJARRODIN ', 20, 'XII RPL 2', 'zackeyy308@gmail.com', '0859176863450', 'Lengkong ', '2024-11-14', '2025'),
(13, '0072304677', 'MUZAKY A\'WANUL MUJARRODIN ', 20, 'XII RPL 2', 'zackeyy308@gmail.com', '0859176863450', 'Lengkong ', '2024-11-14', '11111'),
(14, '0072304677', 'MUZAKY A\'WANUL MUJARRODIN ', 20, 'XII RPL 2', 'zackeyy308@gmail.com', '0859176863450', 'Lengkong ', '2024-11-14', '2225'),
(15, '0072304677', 'MUZAKY A\'WANUL MUJARRODIN ', 20, 'XII RPL 2', 'zackeyy308@gmail.com', '082228164310', 'Lengkong ', '2024-11-14', '1234'),
(16, '0072304677', 'MUZAKY A\'WANUL MUJARRODIN ', 20, 'XII RPL 2', 'zackeyy308@gmail.com', '085731637000', 'Lengkong ', '2024-11-14', '1922');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_siswa` (`id_siswa`,`tanggal`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
