-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 12:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tekom2a`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `file_upload` varchar(200) NOT NULL,
  `isi_berita` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `user_id`, `kategori_id`, `judul`, `file_upload`, `isi_berita`, `created_at`) VALUES
(5, 1, 1, 'Judul 33', '75141953-Screenshot 2023-08-30 151540.png', 'sdsadasd', '2024-10-21 19:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` int(11) NOT NULL,
  `nik` char(18) NOT NULL,
  `nama_dosen` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `prodi_id` int(11) NOT NULL,
  `notelp` varchar(15) NOT NULL,
  `alamat` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `nik`, `nama_dosen`, `email`, `prodi_id`, `notelp`, `alamat`) VALUES
(3, '435345', 'Aceng', 'aceng@gmail.com', 1, '08213123231', 'pdg'),
(4, '4234234', 'Ahmeng', 'ahmeng@gmail.com', 5, '0812767612', 'Rokan Hilir'),
(7, '123871623876', 'aedsq', 'aceng@gmail.com', 4, '0823776324', 'alalala');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `keterangan`) VALUES
(1, 'komputer', 'kategori Komputer'),
(2, 'Games', 'Ini Kategori Games'),
(3, 'Mengaduk Rendang', 'Ini Kategori Mengaduk Rendang\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `nama_level` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `nama_level`, `keterangan`) VALUES
(1, 'admin ', 'admin web'),
(2, 'user', 'pengguna web');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(15) NOT NULL,
  `nama_mhs` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jekel` enum('L','P') NOT NULL,
  `hobi` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `prodi_id` int(11) NOT NULL,
  `notelp` varchar(16) NOT NULL,
  `alamat` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama_mhs`, `tgl_lahir`, `jekel`, `hobi`, `email`, `prodi_id`, `notelp`, `alamat`) VALUES
('23123123', 'Budi', '2010-03-14', 'L', 'Membaca,Travelling', 'aceng@gmail.com', 1, '08213123231', 'Rokan Hilir'),
('2312321', 'Nacht', '1998-09-14', 'L', 'Olahraga,Travelling', 'aceng@gmail.com', 2, '08213123231', 'Rokan Hilir'),
('32423', 'acung', '2024-11-14', 'L', '', 'aceng@yahoo.com', 4, '0812767612', 'Pakandangan');

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `id` int(11) NOT NULL,
  `kode_matakuliah` varchar(100) NOT NULL,
  `nama_matakuliah` varchar(100) NOT NULL,
  `semester` int(15) NOT NULL,
  `jenis_matakuliah` enum('Teori','Praktek','','') NOT NULL,
  `sks` int(20) NOT NULL,
  `jam` int(11) NOT NULL,
  `keterangan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`id`, `kode_matakuliah`, `nama_matakuliah`, `semester`, `jenis_matakuliah`, `sks`, `jam`, `keterangan`) VALUES
(5, 'WEB -230101', 'Web Lanjut 1', 2, 'Praktek', 2, 3, 'ini web lanjut ke dua'),
(7, 'TK-003', 'Matematika Diskrit', 3, 'Praktek', 2, 6, 'asdasd'),
(8, 'TK-003', 'Matematika Diskrit', 3, 'Praktek', 2, 6, 'fdsf'),
(9, 'TK-003', 'Matematika Diskrit', 3, 'Praktek', 2, 6, 'asdasd'),
(10, 'TK-003', 'Matematika Diskrit', 3, 'Praktek', 2, 6, 'asdasd'),
(13, 'WEB -230101', 'aws', 3, 'Teori', 3, 6, 'asdasd');

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id` int(15) NOT NULL,
  `nama_prodi` varchar(100) NOT NULL,
  `jenjang_std` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id`, `nama_prodi`, `jenjang_std`) VALUES
(1, 'mesin', 'D3'),
(2, 'teknik nuklir', 'S1'),
(4, 'perhotelan', 'S1'),
(5, 'management', 'S1'),
(6, 'teknik komputer', 'D3'),
(7, 'management', 'D3');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level_id` varchar(50) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `notelp` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `photo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `level_id`, `nama_lengkap`, `notelp`, `alamat`, `photo`) VALUES
(1, 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 'admin', '', '', '', ''),
(2, 'aceng@yahoo.com', 'aceng123', '2', 'aceng', '087267322', 'padang', 'Picture1.png'),
(3, 'apung@gmail.com', 'apung123', '2', 'INT', '08213123', 'Rokan Hilir', 'alrm.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `prodi_id` (`prodi_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`),
  ADD KEY `prodi_id` (`prodi_id`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`id`);

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
