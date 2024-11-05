-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 05:19 AM
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
-- Database: `salford_co`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `NO_Invoice` varchar(10) NOT NULL,
  `Kode_Produk` varchar(4) NOT NULL,
  `Kuantitas_Produk` int(4) DEFAULT NULL,
  `Sub_Total_Kuantitas_Tiap_Produk` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `NO_Invoice` varchar(10) NOT NULL,
  `Tanggal_Invoice` date DEFAULT NULL,
  `ID_Pelanggan` varchar(4) DEFAULT NULL,
  `Sub_Total_Harga` float DEFAULT NULL,
  `Pajak` float DEFAULT NULL,
  `Total_Harga` float DEFAULT NULL,
  `ID_Karyawan` varchar(4) DEFAULT NULL,
  `No_Rekening_Toko` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `ID_Karyawan` varchar(4) NOT NULL,
  `Nama_Karyawan` varchar(50) DEFAULT NULL,
  `No_Tlp_Karyawan` varchar(12) DEFAULT NULL,
  `Email_Karyawan` varchar(35) DEFAULT NULL,
  `Alamat_Karyawan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`ID_Karyawan`, `Nama_Karyawan`, `No_Tlp_Karyawan`, `Email_Karyawan`, `Alamat_Karyawan`) VALUES
('2733', 'Valdo', '8975099', 'santuy0987654@gmail.com', 'Tanjung'),
('3930', 'Nazwa', '8459483', 'jawarimutr@gmail.com', 'Ngunut'),
('4567', 'Silfi', '8459609', 'spotify@gmail.com', 'Ketanon'),
('4741', 'Aldo', '8967896', 'niggahunter505@gmail.com', 'Nganggrek'),
('5055', 'Truis', '8799009', 'KinkTruis@gmail.com', 'Nggalek');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `ID_Pelanggan` varchar(4) NOT NULL,
  `Nama_Pelanggan` varchar(50) DEFAULT NULL,
  `No_Hp_Pelanggan` varchar(16) DEFAULT NULL,
  `Email_Pelanggan` varchar(35) DEFAULT NULL,
  `Alamat_Pelanggan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`ID_Pelanggan`, `Nama_Pelanggan`, `No_Hp_Pelanggan`, `Email_Pelanggan`, `Alamat_Pelanggan`) VALUES
('1', 'Kamim', '8733234', 'kamimkewer@gmail.com', 'Jepun'),
('2', 'Helwyn', '8349299', 'helwyyynnn@gmail.com', 'Ringinpitu'),
('3', 'nurhadi', '8349002', 'nurhadispl@gmail.com', 'Tanon'),
('4', 'Aldi', '874940', 'alsdi@gmail.com', 'RinginPitu'),
('5', 'Nanang', '8459483', 'NanangLovely@gmail.com', 'Rejotangan'),
('6', 'Rossi', '856784', 'rosisoriye02@gmail.com', 'Kedungwaru'),
('7', 'Santi', '891123', 'satisantihome@gmail.com', 'Rejotangan'),
('8', 'Putri', '871145', 'putriariani11@gmail.com', 'Plosokandang');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `Kode_Produk` varchar(4) NOT NULL,
  `Nama_Produk` varchar(40) DEFAULT NULL,
  `Brand_Produk` varchar(35) DEFAULT NULL,
  `Harga_Produk` int(10) DEFAULT NULL,
  `Jumlah_Produk` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`Kode_Produk`, `Nama_Produk`, `Brand_Produk`, `Harga_Produk`, `Jumlah_Produk`) VALUES
('1', 'Kaos', 'Adios', 90000, 30),
('10', 'Sepatu', 'Bata', 230000, 18),
('2', 'Jaket', 'Nike', 150000, 8),
('3', 'Sandal', 'Homiepad', 25000, 20),
('4', 'Kaos Kerah', 'Polo', 80000, 20),
('5', 'Sepatu', 'Aerostreet', 160000, 25),
('6', 'Kaos', 'Cardinal', 100000, 40),
('7', 'Jaket', 'Reebok', 200000, 15),
('8', 'Kaos Polo', 'Uniqlo', 120000, 35),
('9', 'Sepatu', 'Ando', 100000, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD KEY `NO_Invoice` (`NO_Invoice`),
  ADD KEY `NO_Invoice_2` (`NO_Invoice`) USING BTREE,
  ADD KEY `detail_transaksi_ibfk_1` (`Kode_Produk`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`NO_Invoice`),
  ADD KEY `ID_Pelanggan` (`ID_Pelanggan`,`ID_Karyawan`),
  ADD KEY `ID_Karyawan` (`ID_Karyawan`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`ID_Karyawan`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`ID_Pelanggan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`Kode_Produk`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`Kode_Produk`) REFERENCES `produk` (`Kode_Produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`NO_Invoice`) REFERENCES `invoice` (`NO_Invoice`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`ID_Karyawan`) REFERENCES `karyawan` (`ID_Karyawan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`ID_Pelanggan`) REFERENCES `pelanggan` (`ID_Pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
