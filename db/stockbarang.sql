-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2024 at 02:54 PM
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
-- Database: `stockbarang`
--

-- --------------------------------------------------------

--
-- Table structure for table `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `penerima` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL,
  `foto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluar`
--

INSERT INTO `keluar` (`idkeluar`, `idbarang`, `tanggal`, `penerima`, `qty`, `foto`) VALUES
(1, 2, '2024-03-08 09:12:09', 'Komal', 5000, NULL),
(2, 6, '2024-03-12 16:38:44', 'jajang', 2000, NULL),
(4, 8, '2024-03-12 16:42:22', 'kola', 100, NULL),
(5, 8, '2024-03-12 17:46:53', 'Humas', 5000, NULL),
(7, 11, '2024-03-12 17:58:06', 'Agung', 5000, NULL),
(9, 13, '2024-03-12 18:25:19', 'Jamal', 8000, NULL),
(10, 4, '2024-03-13 04:01:02', 'Komal', 500, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`iduser`, `username`, `password`, `role`) VALUES
(2, 'admin', 'admin', 'admin'),
(5, 'user', 'user', 'user'),
(8, 'administrator', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `keterangan` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbarang`, `tanggal`, `keterangan`, `qty`, `foto`) VALUES
(1, 2, '2024-03-08 09:07:20', 'Komal', 10000, ''),
(2, 1, '2024-03-08 09:37:15', 'Komal', 10000, ''),
(3, 3, '2024-03-08 09:50:01', 'Komal', 10000, ''),
(4, 5, '2024-03-12 14:58:22', 'Kokom', 10000, ''),
(9, 6, '2024-03-12 16:37:39', 'jajang', 5000, ''),
(11, 8, '2024-03-12 16:41:12', 'kola', 10000, ''),
(12, 8, '2024-03-12 17:46:38', 'Humas', 500, ''),
(14, 11, '2024-03-12 17:55:56', 'Agung', 10000, ''),
(16, 13, '2024-03-12 18:20:22', 'Agun', 10000, ''),
(17, 13, '2024-03-12 18:24:57', 'Jamal', 2000, ''),
(18, 4, '2024-03-13 04:00:06', 'Staff', 700, ''),
(19, 17, '2024-06-04 18:34:05', 'Ojan', 3000, ''),
(21, 21, '2024-07-03 00:35:18', 'Ujang', 10000, '');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `idbarang` int(11) NOT NULL,
  `namabarang` text NOT NULL,
  `deskripsi` text NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`idbarang`, `namabarang`, `deskripsi`, `stock`, `image`) VALUES
(27, 'SD Gundam', 'asdasd', 123, 'a2f957c5c2325beb142bbac745bf3a77.jpg'),
(28, 'SD Gundam SCXASCASC', 'Test', 123, 'ab85894c8d26c430c36046447a650ad8.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idbarang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
