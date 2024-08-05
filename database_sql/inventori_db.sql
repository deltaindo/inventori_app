-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2024 at 10:08 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventori_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `id_gudang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id`, `nama`, `tanggal_keluar`, `status`, `id_gudang`) VALUES
(142, 'Fulan', '2024-06-26', 'Sukses', 2);

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id`, `kode_barang`, `jumlah`, `tanggal_masuk`) VALUES
(23, 'BRG-1cf2', 10, '2023-12-07'),
(24, 'BRG-1cf2', 800, '2024-06-26'),
(25, 'BRG-1db6', 700, '2024-06-28');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` varchar(100) NOT NULL,
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detail_barang_keluar`
--

CREATE TABLE `detail_barang_keluar` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kode_barang` varchar(30) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_barang_keluar`
--

INSERT INTO `detail_barang_keluar` (`id`, `id_user`, `kode_barang`, `jumlah`) VALUES
(228, 142, 'BRG-1cf2', 800);

--
-- Triggers `detail_barang_keluar`
--
DELIMITER $$
CREATE TRIGGER `barang_kuar` AFTER INSERT ON `detail_barang_keluar` FOR EACH ROW BEGIN
  UPDATE `pralatan_kantor` SET `jumlah` = `jumlah` - NEW.`jumlah`
  WHERE `pralatan_kantor`.`kode_barang` = NEW.`kode_barang`;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pengurangan` AFTER INSERT ON `detail_barang_keluar` FOR EACH ROW BEGIN
    UPDATE perlengkapan_peserta SET jumlah = jumlah - NEW.jumlah, `jumlah_barang_keluar` = `jumlah_barang_keluar` + NEW.`jumlah`,
    `stok_akhir` = `jumlah` WHERE kode_barang = NEW.kode_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_hapus_barang_atk` AFTER DELETE ON `detail_barang_keluar` FOR EACH ROW BEGIN
  UPDATE `perlengkapan_peserta`
  SET `jumlah` = `jumlah` + OLD.`jumlah`
  WHERE `kode_barang` = OLD.`kode_barang`;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `id` int(11) NOT NULL,
  `id_peminjaman` int(11) NOT NULL,
  `kode_barang` varchar(11) NOT NULL,
  `jumlah` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `detail_peminjaman`
--
DELIMITER $$
CREATE TRIGGER `tr_barang_keluar` AFTER INSERT ON `detail_peminjaman` FOR EACH ROW BEGIN
  UPDATE `pralatan_praktek` SET `jumlah` = `jumlah` - NEW.`jumlah`
  WHERE `pralatan_praktek`.`kode_barang` = NEW.`kode_barang`;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_pengurangan_barang` AFTER INSERT ON `detail_peminjaman` FOR EACH ROW BEGIN
    UPDATE perlengkapan_peserta SET jumlah = jumlah - NEW.jumlah WHERE kode_barang = NEW.kode_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `history_assets`
--

CREATE TABLE `history_assets` (
  `id` int(11) NOT NULL,
  `id_jurnal_inventaris` int(11) NOT NULL,
  `kondisi_awal` text NOT NULL,
  `kondisi_akhir` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history_assets`
--

INSERT INTO `history_assets` (`id`, `id_jurnal_inventaris`, `kondisi_awal`, `kondisi_akhir`, `created_at`, `updated_at`) VALUES
(7, 1, 'Asset dalam kondisi layak digunakan.', 'Asset dalam kondisi layak digunakan.', '2024-07-24 01:24:56', '2024-07-24 03:32:53'),
(11, 2, 'Asset dalam kondisi layak digunakan.', NULL, '2024-07-24 06:18:45', '2024-07-24 06:18:45'),
(12, 3, 'Asset dalam kondisi layak digunakan.', NULL, '2024-07-24 06:22:58', '2024-07-24 06:22:58'),
(13, 4, 'Asset dalam kondisi layak digunakan.', NULL, '2024-07-24 06:25:25', '2024-07-24 06:25:25'),
(14, 5, 'Asset dalam kondisi layak digunakan.', NULL, '2024-07-24 06:26:24', '2024-07-24 06:26:24'),
(15, 6, 'Asset dalam kondisi layak digunakan.', 'Asset dalam kondisi layak digunakan', '2024-07-24 06:32:17', '2024-07-25 03:42:31');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_alat_peraga`
--

CREATE TABLE `jurnal_alat_peraga` (
  `id` int(11) NOT NULL,
  `kode_alat_peraga` varchar(100) NOT NULL,
  `id_jurnal_barang_masuk` int(11) NOT NULL,
  `alokasi_tujuan` varchar(200) NOT NULL,
  `tanggal_beli` date NOT NULL,
  `tanggal_kalibrasi` date NOT NULL,
  `masa_berlaku_kalibrasi` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurnal_alat_peraga`
--

INSERT INTO `jurnal_alat_peraga` (`id`, `kode_alat_peraga`, `id_jurnal_barang_masuk`, `alokasi_tujuan`, `tanggal_beli`, `tanggal_kalibrasi`, `masa_berlaku_kalibrasi`, `jumlah`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'JAP-d5691', 5, 'Ruang DIP Lantai 3', '2024-07-11', '2024-07-18', '2024-07-25', 3, 'Alat Peraga atau Praktik dalam kondisi layak digunakan', '2024-07-26 03:03:16', '2024-07-26 03:03:16'),
(2, 'JAP-3721e', 5, 'Ruang DIP Lantai 2', '2024-07-12', '2024-07-24', '2024-07-25', 2, 'Alat Peraga atau Praktik dalam kondisi layak digunakan.', '2024-07-26 04:15:47', '2024-07-26 04:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_alat_peserta`
--

CREATE TABLE `jurnal_alat_peserta` (
  `id` int(11) NOT NULL,
  `kode_alat_peserta` varchar(100) NOT NULL,
  `id_jurnal_barang_masuk` int(11) NOT NULL,
  `tujuan_barang_keluar` varchar(200) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurnal_alat_peserta`
--

INSERT INTO `jurnal_alat_peserta` (`id`, `kode_alat_peserta`, `id_jurnal_barang_masuk`, `tujuan_barang_keluar`, `tanggal_keluar`, `jumlah`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'JPP-06134', 6, 'Pelatihan K3 dengan Client PT. DEF', '2024-07-22', 8, 'Buku Agenda digunakan untuk keperluan mencatat materi.', '2024-07-29 03:17:04', '2024-07-29 03:17:04'),
(2, 'JPP-4f1b7', 7, 'Pelatihan K3 dengan Clinet Yamaha.', '2024-07-22', 6, 'Buku Agenda digunakan untuk keperluan mencatat materi.', '2024-07-29 03:37:19', '2024-07-29 03:37:19');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_alat_tulis_kantor`
--

CREATE TABLE `jurnal_alat_tulis_kantor` (
  `id` int(11) NOT NULL,
  `kode_alat_tulis_kantor` varchar(100) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `id_jurnal_barang_masuk` int(11) NOT NULL,
  `tanggal_pengambilan` date NOT NULL,
  `jumlah_pengambilan` int(11) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurnal_alat_tulis_kantor`
--

INSERT INTO `jurnal_alat_tulis_kantor` (`id`, `kode_alat_tulis_kantor`, `id_karyawan`, `id_jurnal_barang_masuk`, `tanggal_pengambilan`, `jumlah_pengambilan`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'ATK-3b31b', 5, 9, '2024-07-23', 4, 'Digunakan untuk keperluan kerja.', '2024-07-30 01:29:14', '2024-07-30 01:29:14');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_barang`
--

CREATE TABLE `jurnal_barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(100) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_lokasi` int(11) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_merek` int(11) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurnal_barang`
--

INSERT INTO `jurnal_barang` (`id`, `kode_barang`, `id_barang`, `id_lokasi`, `id_satuan`, `id_kategori`, `id_merek`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'BRG-e9d', 11, 3, 3, 7, 25, 'Type M221 Wireless - Dimensi Mouse: 8.70 x 4.20 x 13.20 cm, Panjang Kabel: 180 cm, Konektivitas: USB', '2024-07-24 02:13:59', '2024-07-24 02:13:59'),
(2, 'BRG-aca', 11, 3, 3, 7, 25, 'Type M170 Wireless - Dimensi Mouse: 8.70 x 4.20 x 13.20 cm, Panjang Kabel: 180 cm, Konektivitas: USB', '2024-07-24 02:14:55', '2024-07-24 02:14:55'),
(3, 'BRG-909', 1, 3, 3, 7, 26, 'Latitude 3420, Intel Core i3-1115G4 Dual Core up to 4.1 GHz, Integrated Intel Iris Xe Graphics, RAM 8 GB, SSD 512.', '2024-07-24 02:15:38', '2024-07-24 02:15:38'),
(4, 'BRG-bdb', 1, 3, 3, 7, 8, 'Ideapad Slim 3, Ryzen 3 6500U, Ram 8GB, SSD 512 GB', '2024-07-24 02:16:33', '2024-07-24 02:16:33'),
(5, 'BRG-e18', 12, 3, 7, 8, 28, 'Tandu 210 X 67,5 cm . Tas 24 X 32 X 13 cm.', '2024-07-25 06:58:09', '2024-07-25 06:58:09'),
(6, 'BRG-e1b', 13, 3, 7, 2, 29, 'Buku berisi 100 lembar.', '2024-07-29 01:03:58', '2024-07-29 01:03:58'),
(7, 'BRG-c4e', 14, 3, 3, 2, 3, 'Pulpen warna hitam.', '2024-07-29 02:25:18', '2024-07-29 02:25:18'),
(8, 'BRG-a5c', 15, 3, 3, 1, 30, 'Model Number: P-88, Size (cm): 17.5x0.8, Variant: 2B', '2024-07-29 07:37:31', '2024-07-29 07:37:31'),
(9, 'BRG-4f7', 16, 3, 3, 1, 3, 'Warna Hitam', '2024-07-29 07:50:36', '2024-07-29 07:50:36'),
(10, 'BRG-408', 1, 3, 3, 9, 8, 'Ideapad Slim 3, Ryzen 3 6500U, Ram 8GB, SSD 512 GB', '2024-07-31 02:53:51', '2024-07-31 02:53:51'),
(11, 'BRG-86e', 1, 3, 3, 9, 26, 'Latitude 3420, Intel Core i3-1115G4 Dual Core up to 4.1 GHz, Integrated Intel Iris Xe Graphics, RAM 8 GB, SSD 512.', '2024-07-31 03:55:47', '2024-07-31 03:55:47');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_barang_masuk`
--

CREATE TABLE `jurnal_barang_masuk` (
  `id` int(11) NOT NULL,
  `kode_barang_masuk` varchar(100) DEFAULT NULL,
  `id_jurnal_barang` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `jenis_pakai` varchar(50) NOT NULL DEFAULT 'Normal',
  `status_barang` varchar(50) NOT NULL DEFAULT 'Baik',
  `jumlah_masuk` int(11) NOT NULL,
  `harga_barang` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `keterangan` varchar(200) NOT NULL DEFAULT '''-''',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurnal_barang_masuk`
--

INSERT INTO `jurnal_barang_masuk` (`id`, `kode_barang_masuk`, `id_jurnal_barang`, `tanggal_masuk`, `jenis_pakai`, `status_barang`, `jumlah_masuk`, `harga_barang`, `total`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'JBM-72947', 4, '2024-07-02', 'Inventaris', 'Baik', 10, 5600000, 56000000, '-', '2024-07-24 02:23:55', '2024-07-24 02:23:55'),
(2, 'JBM-3e362', 3, '2024-07-04', 'Inventaris', 'Baik', 10, 7500000, 75000000, '-', '2024-07-24 02:25:10', '2024-07-24 02:25:10'),
(3, 'JBM-8c650', 2, '2024-07-06', 'Inventaris', 'Baik', 8, 120000, 960000, '-', '2024-07-24 02:26:31', '2024-07-24 02:26:31'),
(4, 'JBM-400df', 1, '2024-07-08', 'Inventaris', 'Baik', 6, 95000, 570000, '-', '2024-07-24 02:27:39', '2024-07-24 02:27:39'),
(5, 'JBM-6847e', 5, '2024-07-24', 'Alat Peraga', 'Baik', 10, 755000, 7550000, '-', '2024-07-25 06:58:51', '2024-07-25 06:58:51'),
(6, 'JBM-74dd6', 6, '2024-07-26', 'Peserta', 'Baik', 20, 25000, 500000, '-', '2024-07-29 01:09:12', '2024-07-29 01:09:12'),
(7, 'JBM-b6119', 7, '2024-07-17', 'Peserta', 'Baik', 100, 2000, 200000, '-', '2024-07-29 02:26:02', '2024-07-29 02:26:02'),
(9, 'JBM-1983e', 8, '2024-07-24', 'Normal', 'Baik', 120, 3500, 420000, '-', '2024-07-29 07:39:18', '2024-07-29 07:39:18'),
(10, 'JBM-b6948', 9, '2024-07-23', 'Normal', 'Baik', 100, 3500, 350000, '-', '2024-07-29 07:53:36', '2024-07-29 07:53:36'),
(13, 'JBM-ded53', 10, '2024-07-24', 'Peminjaman', 'Baik', 12, 5400000, 64800000, '-', '2024-07-31 02:56:06', '2024-07-31 02:56:06'),
(14, 'JBM-a55ad', 1, '2024-07-29', 'Peminjaman', 'Baik', 45, 6700000, 301500000, '-', '2024-07-31 03:57:54', '2024-07-31 03:57:54');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_inventaris`
--

CREATE TABLE `jurnal_inventaris` (
  `id` int(11) NOT NULL,
  `kode_inventaris` varchar(100) DEFAULT NULL,
  `id_jurnal_barang_masuk` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `kondisi_asset` enum('Aktif','Digunakan','Tercatat','Tidak Aktif') NOT NULL DEFAULT 'Digunakan',
  `tanggal_assign` date NOT NULL,
  `tanggal_return` date DEFAULT NULL,
  `status_assets` enum('Baru','Bekas') NOT NULL,
  `jumlah_assets` int(11) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurnal_inventaris`
--

INSERT INTO `jurnal_inventaris` (`id`, `kode_inventaris`, `id_jurnal_barang_masuk`, `id_karyawan`, `kondisi_asset`, `tanggal_assign`, `tanggal_return`, `status_assets`, `jumlah_assets`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'KJI-3533b', 1, 6, 'Tercatat', '2024-07-22', '2024-07-23', 'Baru', 1, 'Asset dalam kondisi layak digunakan.', '2024-07-24 02:29:07', '2024-07-24 06:18:45'),
(2, 'KJI-23de4', 1, 4, 'Digunakan', '2024-07-23', NULL, 'Bekas', 1, 'Asset dalam kondisi layak digunakan.', '2024-07-24 06:18:45', '2024-07-24 06:18:45'),
(3, 'KJI-4b572', 2, 6, 'Digunakan', '2024-07-23', NULL, 'Baru', 1, 'Asset dalam kondisi layak digunakan.', '2024-07-24 06:22:58', '2024-07-24 06:22:58'),
(4, 'KJI-7dca7', 3, 2, 'Digunakan', '2024-07-23', NULL, 'Baru', 1, 'Asset dalam kondisi layak digunakan.', '2024-07-24 06:25:25', '2024-07-24 06:25:25'),
(5, 'KJI-482eb', 4, 3, 'Digunakan', '2024-07-23', NULL, 'Baru', 1, 'Asset dalam kondisi layak digunakan.', '2024-07-24 06:26:24', '2024-07-24 06:26:24'),
(6, 'KJI-ef7a8', 4, 4, 'Aktif', '2024-07-23', '2024-07-24', 'Baru', 1, 'Asset dalam kondisi layak digunakan.', '2024-07-24 06:32:17', '2024-07-25 03:42:31');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_pinjam_inventaris`
--

CREATE TABLE `jurnal_pinjam_inventaris` (
  `id` int(11) NOT NULL,
  `kode_pinjam_inventaris` varchar(100) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `id_jurnal_barang_masuk` int(11) NOT NULL,
  `tujuan_pinjam` varchar(200) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `jumlah_pinjam` int(11) NOT NULL,
  `kondisi_pinjam` text NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `kondisi_kembali` text DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurnal_pinjam_inventaris`
--

INSERT INTO `jurnal_pinjam_inventaris` (`id`, `kode_pinjam_inventaris`, `id_karyawan`, `id_jurnal_barang_masuk`, `tujuan_pinjam`, `tanggal_pinjam`, `jumlah_pinjam`, `kondisi_pinjam`, `tanggal_kembali`, `kondisi_kembali`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'JPI-eaab0', 6, 14, 'Digunakan untuk pelatihan', '2024-07-24', 5, 'Barang dalam keadaan layak digunakan.', '2024-08-01', 'Barang dalam keadaan baik', 'Dikembalikan', '-', '2024-07-31 06:30:57', '2024-07-31 06:30:57'),
(2, 'JPI-68c3c', 5, 14, 'Digunakan untuk pelatihan', '2024-08-01', 3, 'Barang dalam keadaan layak digunakan.', NULL, NULL, 'Dipinjam', '-', '2024-08-01 02:40:11', '2024-08-01 02:40:11'),
(3, 'JPI-aa35e', 3, 13, 'Digunakan untuk pelatihan', '2024-08-01', 2, 'Barang dalam keadaan layak digunakan.', NULL, NULL, 'Dipinjam', '-', '2024-08-01 02:40:47', '2024-08-01 02:40:47');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_stok_barang`
--

CREATE TABLE `jurnal_stok_barang` (
  `id` int(11) NOT NULL,
  `id_jurnal_barang` int(11) NOT NULL,
  `tanggal_update` datetime DEFAULT NULL,
  `jumlah_masuk` int(11) NOT NULL DEFAULT 0,
  `jumlah_keluar` int(11) NOT NULL,
  `stok_akhir` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurnal_stok_barang`
--

INSERT INTO `jurnal_stok_barang` (`id`, `id_jurnal_barang`, `tanggal_update`, `jumlah_masuk`, `jumlah_keluar`, `stok_akhir`, `created_at`, `updated_at`) VALUES
(1, 4, '2024-07-24 13:18:45', 20, 1, 19, '2024-07-24 02:23:55', '2024-07-24 02:23:55'),
(2, 3, '2024-07-24 13:22:58', 20, 1, 19, '2024-07-24 02:25:10', '2024-07-24 02:25:10'),
(3, 2, '2024-07-24 13:25:25', 8, 1, 7, '2024-07-24 02:26:31', '2024-07-24 02:26:31'),
(4, 1, '2024-07-25 10:42:31', 6, 1, 5, '2024-07-24 02:27:39', '2024-07-24 02:27:39'),
(5, 5, '2024-07-31 02:54:07', 10, 5, 5, '2024-07-25 06:58:51', '2024-07-25 06:58:51'),
(6, 6, '2024-07-29 10:36:31', 20, 8, 12, '2024-07-29 01:09:12', '2024-07-29 01:09:12'),
(7, 7, '2024-07-31 02:47:15', 100, 6, 94, '2024-07-29 02:26:02', '2024-07-29 02:26:02'),
(8, 8, '2024-07-31 02:41:47', 120, 4, 116, '2024-07-29 07:39:18', '2024-07-29 07:39:18'),
(9, 9, NULL, 100, 0, 100, '2024-07-29 07:53:36', '2024-07-29 07:53:36'),
(10, 10, '2024-08-01 09:40:47', 12, 2, 10, '2024-07-31 02:56:06', '2024-07-31 02:56:06'),
(11, 11, '2024-08-01 09:40:11', 45, 3, 42, '2024-07-31 03:57:54', '2024-07-31 03:57:54');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_stok`
--

CREATE TABLE `laporan_stok` (
  `id` int(11) NOT NULL,
  `data_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nama_barang` varchar(50) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `stok_akhir` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laporan_stok`
--

INSERT INTO `laporan_stok` (`id`, `data_created`, `nama_barang`, `jumlah_masuk`, `jumlah_keluar`, `stok_akhir`, `kategori`) VALUES
(1, '2023-07-11 17:00:00', 'Pulpen', 3, 4, 1, 'ATK'),
(2, '2023-07-04 02:16:23', 'Pulpen', 2, 1, 1, 'ATK');

-- --------------------------------------------------------

--
-- Table structure for table `master_barang`
--

CREATE TABLE `master_barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_barang`
--

INSERT INTO `master_barang` (`id`, `nama_barang`, `created_at`, `updated_at`) VALUES
(1, 'Laptop (Dummy)', '2024-07-12 06:59:36', '2024-07-12 06:59:36'),
(11, 'Mouse (Dummy)', '2024-07-15 07:46:52', '2024-07-15 07:46:52'),
(12, 'Tandu (Dummy)', '2024-07-25 06:53:02', '2024-07-25 06:53:02'),
(13, 'Buku (Dummy)', '2024-07-29 01:01:34', '2024-07-29 01:01:34'),
(14, 'Pulpen Peserta (Dummy)', '2024-07-29 02:23:47', '2024-07-29 02:23:47'),
(15, 'Pensil (Dummy)', '2024-07-29 07:33:19', '2024-07-29 07:33:19'),
(16, 'Pulpen Karyawan (Dummy)', '2024-07-29 07:49:23', '2024-07-29 07:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `master_barang_old`
--

CREATE TABLE `master_barang_old` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(100) NOT NULL,
  `nama_barang` varchar(200) NOT NULL,
  `foto_barang` varchar(150) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_divisi`
--

CREATE TABLE `master_divisi` (
  `id` int(11) NOT NULL,
  `id_kantor` int(11) DEFAULT NULL,
  `nama_divisi` varchar(200) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_divisi`
--

INSERT INTO `master_divisi` (`id`, `id_kantor`, `nama_divisi`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, 1, 'Digital Marketing', 'Divisi Digital Marketing Delta', '2024-07-17 03:49:56', '2024-07-17 03:49:56'),
(4, 1, 'Divisi IT', 'Divisi IT Delta', '2024-07-17 04:22:55', '2024-07-17 04:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `master_kantor`
--

CREATE TABLE `master_kantor` (
  `id` int(11) NOT NULL,
  `nama_kantor` varchar(100) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_kantor`
--

INSERT INTO `master_kantor` (`id`, `nama_kantor`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Delta Indonesia (Training Center)', 'Delta Indonesia', '2024-07-01 03:34:35', '2024-07-01 03:34:35'),
(2, 'Delta Nusantara (Riksa Uji Center)', 'Delta Nusantara', '2024-07-01 03:34:35', '2024-07-01 03:34:35'),
(3, 'BSI', 'Biro Sertifikasi Indonesia', '2024-07-01 04:38:57', '2024-07-01 04:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `master_karyawan`
--

CREATE TABLE `master_karyawan` (
  `id` int(11) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `nama_karyawan` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_karyawan`
--

INSERT INTO `master_karyawan` (`id`, `id_divisi`, `nama_karyawan`, `created_at`, `updated_at`) VALUES
(2, 2, 'Satria Akbar (Dummy)', '2024-07-17 04:37:07', '2024-07-17 04:37:07'),
(3, 4, 'Indra Elvian (Dummy)', '2024-07-18 03:00:08', '2024-07-18 03:00:08'),
(4, 4, 'Dendy Aziz (Dummy)', '2024-07-18 06:56:11', '2024-07-18 06:56:11'),
(5, 4, 'Dea (Dummy)', '2024-07-22 02:24:13', '2024-07-22 02:24:13'),
(6, 4, 'Mario Tomy (Dummy)', '2024-07-23 04:21:30', '2024-07-23 04:21:30');

-- --------------------------------------------------------

--
-- Table structure for table `master_kategori`
--

CREATE TABLE `master_kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(150) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_kategori`
--

INSERT INTO `master_kategori` (`id`, `nama_kategori`, `keterangan`) VALUES
(1, 'ATK', 'Alat Tulis Kantor'),
(2, 'Perlengkapan Peserta', 'Digunakan untuk perlengkapan peserta sekali pakai.'),
(7, 'Asset Kantor', 'Kategori asset kantor untuk karywan'),
(8, 'Alat Peraga Pelatihan', 'Digunakan untuk alat peraga pelatihan.'),
(9, 'Barang Pinjam', 'Barang yang digunakan untuk peminjaman antara karyawan.');

-- --------------------------------------------------------

--
-- Table structure for table `master_lokasi`
--

CREATE TABLE `master_lokasi` (
  `id` int(11) NOT NULL,
  `id_kantor` int(11) NOT NULL,
  `nama_lokasi` varchar(100) NOT NULL,
  `keterangan` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_lokasi`
--

INSERT INTO `master_lokasi` (`id`, `id_kantor`, `nama_lokasi`, `keterangan`) VALUES
(1, 2, 'Gudang', 'Gudang Lt. 1'),
(2, 2, 'FO', 'Front Office'),
(3, 1, 'FO Lt. 1', 'Delta Indonesia'),
(9, 2, 'Lantai 2', 'Di lantai 2 Ruangan Admin'),
(10, 3, 'Lt 1', 'Gedung BSI');

-- --------------------------------------------------------

--
-- Table structure for table `master_merek`
--

CREATE TABLE `master_merek` (
  `id` int(11) NOT NULL,
  `nama_merek` varchar(150) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_merek`
--

INSERT INTO `master_merek` (`id`, `nama_merek`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Stabilo', 'Digunakan Untuk: Marker dan highlighter', '2024-07-01 02:46:33', '2024-07-01 02:46:33'),
(2, 'Faber-Castell', 'Digunakan Untuk: Pensil, pulpen, dan alat tulis lainnya.', '2024-07-01 02:47:16', '2024-07-01 02:47:16'),
(3, 'Pilot', 'Digunakan Untuk: Pulpen dan marker', '2024-07-01 02:48:01', '2024-07-01 02:48:01'),
(4, 'Joyko', 'Digunakan Untuk: Berbagai macam alat tulis dan perlengkapan kantor.', '2024-07-01 02:48:34', '2024-07-01 02:48:34'),
(5, 'Kenko', 'Digunakan Untuk: Alat tulis dan perlengkapan kantor.', '2024-07-01 02:49:00', '2024-07-01 02:49:00'),
(6, 'Sidu', 'Digunakan Untuk: Kertas fotokopi dan kertas lainnya.', '2024-07-01 02:49:31', '2024-07-01 02:49:31'),
(7, 'Deli', 'Digunakan Untuk: Perlengkapan kantor seperti stapler, perforator, dan lainnya.', '2024-07-01 02:52:31', '2024-07-01 02:52:31'),
(8, 'Lenovo', 'Digunakan Untuk: Jenis Merek Laptop', '2024-07-01 02:53:03', '2024-07-01 02:53:03'),
(9, 'Artline', 'Digunakan Untuk: Marker dan alat tulis.', '2024-07-01 02:53:39', '2024-07-01 02:53:39'),
(10, 'Paperone', 'Digunakan Untuk: Kertas fotokopi dan kertas lainnya.', '2024-07-01 02:54:10', '2024-07-01 02:54:10'),
(11, 'Maped', 'Digunakan Untuk: Alat tulis dan perlengkapan kantor.', '2024-07-01 02:54:39', '2024-07-01 02:54:39'),
(12, 'Pentel', 'Digunakan Untuk: Pulpen, pensil, dan alat tulis lainnya.', '2024-07-01 02:55:15', '2024-07-01 02:55:15'),
(13, 'Luxor', 'Digunakan Untuk: Marker dan alat tulis.', '2024-07-01 02:55:45', '2024-07-01 02:55:45'),
(14, 'Snowman', 'Digunakan Untuk: Marker dan alat tulis.', '2024-07-01 02:56:15', '2024-07-01 02:56:15'),
(15, 'Kokuyo', 'Digunakan Untuk: Berbagai perlengkapan kantor.', '2024-07-01 02:56:47', '2024-07-01 02:56:47'),
(16, 'Staedtler', 'Digunakan Untuk: Pensil, pulpen, dan alat tulis lainnya.', '2024-07-01 02:57:19', '2024-07-01 02:57:19'),
(17, 'Paperline', 'Digunakan Untuk: Kertas fotokopi dan kertas lainnya.', '2024-07-01 02:57:45', '2024-07-01 02:57:45'),
(18, 'Bantex', 'Digunakan Untuk: File, binder, dan perlengkapan kantor.', '2024-07-01 02:58:16', '2024-07-01 02:58:16'),
(19, 'Lion', 'Digunakan Untuk: Stapler, perforator, dan perlengkapan kantor lainnya.', '2024-07-01 02:58:41', '2024-07-01 02:58:41'),
(20, 'Max', 'Digunakan Untuk: Stapler, perforator, dan perlengkapan kantor lainnya.', '2024-07-01 02:59:10', '2024-07-01 02:59:10'),
(25, 'Logitech', 'Digunakan Untuk: mouse atau keyboard', '2024-07-18 07:56:54', '2024-07-18 07:56:54'),
(26, 'Dell', 'Digunakan Untuk: Laptop dan Server Fisik', '2024-07-19 00:59:48', '2024-07-19 00:59:48'),
(28, '4Life Simple Stretcher', 'Digunakan Untuk: Tandu', '2024-07-25 06:55:48', '2024-07-25 06:55:48'),
(29, 'Agenda Peserta', 'Buku Tulis untuk Peserta', '2024-07-29 01:02:43', '2024-07-29 01:02:43'),
(30, '2B Joyko', 'Digunakan untuk Merek Pensil.', '2024-07-29 07:34:38', '2024-07-29 07:34:38');

-- --------------------------------------------------------

--
-- Table structure for table `master_satuan`
--

CREATE TABLE `master_satuan` (
  `id` int(11) NOT NULL,
  `nama_satuan` varchar(150) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_satuan`
--

INSERT INTO `master_satuan` (`id`, `nama_satuan`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Rim', 'Contoh: Kertas (500 lembar)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(2, 'Pack', 'Contoh: Pulpen (10 buah)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(3, 'Unit', 'Contoh: Printer (1 unit)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(4, 'Box', 'Contoh: Staples (1000 buah)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(5, 'Dozen', 'Contoh: Pensil (12 buah)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(6, 'Piece', 'Contoh: Penggaris (1 buah)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(7, 'Set', 'Contoh: Alat tulis (misalnya, set berisi pulpen, pensil, penghapus)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(8, 'Bottle', 'Contoh: Tinta printer (1 botol)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(9, 'Roll', 'Contoh: Lakban (1 roll)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(10, 'Pad', 'Contoh: Sticky notes (1 pad)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(11, 'Envelope', 'Contoh: Amplop (1 buah)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(12, 'Folder', 'Contoh: Map (1 buah)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(13, 'Box', 'Contoh: Kertas file (misalnya, 10 file per box)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(14, 'Carton', 'Contoh: Kertas cetak (misalnya, 5 rim per carton)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(15, 'Packet', 'Contoh: Kertas label (misalnya, 100 lembar per packet)', '2024-07-01 02:43:24', '2024-07-01 02:43:24'),
(16, 'Spool', 'Contoh: Pita mesin ketik (1 spool)', '2024-07-01 02:43:24', '2024-07-01 02:43:24');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `kegiatan` varchar(50) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `jml_peserta` int(11) NOT NULL,
  `program` varchar(50) NOT NULL,
  `marketing` varchar(50) NOT NULL,
  `pic` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `id_gudang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `peminjaman`
--
DELIMITER $$
CREATE TRIGGER `tr_penambahan_barang` AFTER UPDATE ON `peminjaman` FOR EACH ROW BEGIN
    IF NEW.status = 'sudah dikembalikan' AND OLD.status != 'sudah dikembalikan' THEN
        UPDATE perlengkapan_peserta SET jumlah = jumlah + (SELECT jumlah FROM detail_peminjaman WHERE id_peminjaman = NEW.id) WHERE kode_barang IN (SELECT kode_barang FROM detail_peminjaman WHERE id_peminjaman = NEW.id);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_update_peminjaman` AFTER UPDATE ON `peminjaman` FOR EACH ROW BEGIN
  IF (OLD.`status` <> NEW.`status` AND NEW.`status` = 'sudah dikembalikan') THEN
    UPDATE `perlengkapan_peserta` SET `jumlah_barang_keluar` = `jumlah_barang_keluar` - (
      SELECT `jumlah` FROM `detail_peminjaman`
      WHERE `id_peminjaman` = NEW.`id`
    )
    WHERE `kode_barang` = (
      SELECT `kode_barang` FROM `detail_peminjaman`
      WHERE `id_peminjaman` = NEW.`id`
    );
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id` int(11) NOT NULL,
  `id_peminjaman` int(11) NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `keterlambatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `perlengkapan_peserta_old`
--

CREATE TABLE `perlengkapan_peserta_old` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` varchar(20) NOT NULL,
  `lokasi` varchar(30) NOT NULL,
  `stok_awal` int(10) NOT NULL,
  `masuk` int(20) NOT NULL,
  `jumlah_barang_keluar` int(10) NOT NULL,
  `stok_akhir` int(11) NOT NULL,
  `kategori` varchar(30) NOT NULL,
  `id_gudang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perlengkapan_peserta_old`
--

INSERT INTO `perlengkapan_peserta_old` (`id`, `kode_barang`, `nama_barang`, `jumlah`, `harga`, `lokasi`, `stok_awal`, `masuk`, `jumlah_barang_keluar`, `stok_akhir`, `kategori`, `id_gudang`) VALUES
(547, 'BRG-1cf2', 'Kertas A4', -774, '0', 'Gudang', 16, 820, 834, 26, 'ATK', 2),
(548, 'BRG-1d53', 'Kertas Paper Glossy', 4, '', 'Gudang', 4, 5, 6, 0, 'ATK', 2),
(549, 'BRG-1d74', 'Kertas A4 Biru', 0, '', 'Gudang', 0, -10, 0, 0, 'ATK', 2),
(550, 'BRG-1d95', 'Kertas A4 Pink', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(551, 'BRG-1db6', 'Kertas F4', 700, '', 'Gudang', 0, 700, 8, -5, 'ATK', 2),
(552, 'BRG-1dd7', 'Kertas Kado', 2, '', 'Gudang', 2, 50, 0, 0, 'ATK', 2),
(553, 'BRG-1de8', 'Data Print Black', 4, '', 'FO', 4, 5, 29, 0, 'ATK', 2),
(554, 'BRG-1df9', 'Data Print Warna', 5, '', 'FO', 5, 5, 30, 0, 'ATK', 2),
(555, 'BRG-1e110', 'Tinta Warna Hitam Epson', 0, '', 'FO', 0, 0, 3, 1, 'ATK', 2),
(556, 'BRG-1e311', 'Cartrige Tinta Black', 0, '', 'FO', 0, 0, 0, 0, 'ATK', 2),
(557, 'BRG-1e412', 'Tinta Warna Merah Epson 644', 0, '', 'FO', 0, 0, 1, 0, 'ATK', 2),
(558, 'BRG-1e613', 'Tinta Warna Biru Epson 644', 0, '', 'FO', 0, 0, 1, 0, 'ATK', 2),
(559, 'BRG-1e714', 'Tinta Warna Kuning Epson 644', 0, '', 'FO', 0, 0, 1, 0, 'ATK', 2),
(560, 'BRG-1e915', 'Tinta Warna Merah HP GT52', 0, '', 'FO', 0, 0, 2, 0, 'ATK', 2),
(561, 'BRG-1eb16', 'Tinta Warna Biru HP GT53', 0, '', 'FO', 0, 0, 0, 0, 'ATK', 2),
(562, 'BRG-1ec17', 'Tinta Warna Kuning HP GT52', 0, '', 'FO', 0, 0, 2, 0, 'ATK', 2),
(563, 'BRG-1ee18', 'Spidol Hitam', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(564, 'BRG-1ef19', 'Spidol Biru', 17, '', 'Gudang', 17, 0, 12, 0, 'ATK', 2),
(565, 'BRG-1f020', 'Stabilo', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(566, 'BRG-1f221', 'Lem Glue Stick Joyko (Kecil)', 0, '', 'Gudang', 0, 0, 12, 0, 'ATK', 2),
(567, 'BRG-1f322', 'Lem Glue Stick Joyko (Sedang)', 12, '', 'Gudang', 12, 24, 11, 0, 'ATK', 2),
(568, 'BRG-1f523', 'Double Tip Besar', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(569, 'BRG-1f724', 'Double Tip Kecil', 7, '', 'Gudang', 7, 0, 1, 0, 'ATK', 2),
(570, 'BRG-1f925', 'Lakban Hitam 2 Inc', 0, '', 'Gudang', 0, 3, 2, 0, 'ATK', 2),
(571, 'BRG-1fa26', 'Lakban Hitam 1 Inc', 0, '', 'Gudang', 0, 3, 1, 0, 'ATK', 2),
(572, 'BRG-1fb27', 'Lakban Hitam 1/2 Inc', 0, '', 'Gudang', 0, 0, 1, 0, 'ATK', 2),
(573, 'BRG-1fc28', 'Lakban Bening Besar', 3, '', 'Gudang', 3, 6, 2, 0, 'ATK', 2),
(574, 'BRG-1ff29', 'Lakban Bening sedang', 3, '', 'Gudang', 3, 6, 4, 0, 'ATK', 2),
(575, 'BRG-20030', 'Lakban Bening Kecil', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(576, 'BRG-20231', 'Buku Tulis Kampus', 0, '', 'FO', 0, 12, 2, 0, 'ATK', 2),
(577, 'BRG-20332', 'Buku Tanda Terima', 5, '', 'Gudang', 5, 0, 2, 36, 'ATK', 2),
(578, 'BRG-20433', 'Kwitansi Besar', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(579, 'BRG-20634', 'Blinder Clip 155', 0, '', 'Gudang', 0, 0, 2, 0, 'ATK', 2),
(580, 'BRG-20835', 'Blinder Clip 111', 0, '', 'Gudang', 0, 12, 1, 0, 'ATK', 2),
(581, 'BRG-20936', 'Blinder Clip 107', 0, '', 'Gudang', 0, 12, 2, 0, 'ATK', 2),
(582, 'BRG-20b37', 'Blinder Clip 260', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(583, 'BRG-20c38', 'Blinder Clip 280', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(584, 'BRG-20d39', 'Blinder Clip 105', 0, '', 'Gudang', 0, 12, 2, 0, 'ATK', 2),
(585, 'BRG-20f40', 'Blinder Clip 200', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(586, 'BRG-21041', 'Isi Steples Kecil', 2, '', 'Gudang', 2, 20, 3, 0, 'ATK', 2),
(587, 'BRG-21242', 'Isi Steples Besar', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(588, 'BRG-21443', 'Isi Kater Besar', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(589, 'BRG-21544', 'Kater Kecil', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(590, 'BRG-21645', 'Bantex Besar', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(591, 'BRG-21846', 'Bantex Kecil', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(592, 'BRG-21947', 'Map Bening', 1000, '', 'Gudang', 1000, 0, 352, 0, 'ATK', 2),
(593, 'BRG-21b48', 'Amplop Putih Besar', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(594, 'BRG-21d49', 'Amplop Putih Kecil', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(595, 'BRG-21e50', 'Batarai Alkalin A2', 2, '', 'FO', 2, 0, 2, 0, 'ATK', 2),
(596, 'BRG-22051', 'Batarai Alkalin A3', 2, '', 'FO', 2, 0, 0, 0, 'ATK', 2),
(597, 'BRG-22152', 'Sticky Note Kecil', 0, '', 'FO', 0, 0, 6, 0, 'ATK', 2),
(598, 'BRG-22253', 'Sticky Note Besar', 0, '', 'FO', 0, 0, 1, 0, 'ATK', 2),
(599, 'BRG-22454', 'Sticky Note Sedang', 0, '', 'FO', 0, 0, 6, 2, 'ATK', 2),
(600, 'BRG-22555', 'Plastik Suket', 10, '', 'Gudang', 10, 100, 1, 0, 'ATK', 2),
(601, 'BRG-22756', 'Tip-X', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(602, 'BRG-22857', 'Paper Clip', 2, '', 'Gudang', 2, 24, 19, 0, 'ATK', 2),
(603, 'BRG-22958', 'Penggaris Besi', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(604, 'BRG-22a59', 'Pulpen Gel Joyko', 0, '', 'Gudang', 0, 0, 0, 0, 'ATK', 2),
(605, 'BRG-c1a2', 'T-Shirt', 226, '', '', 226, 180, 657, 0, 'peserta', 2),
(606, 'BRG-c203', 'T-Shirt (BPJS)', 0, '', '', 0, 0, 0, 0, 'peserta', 2),
(607, 'BRG-c224', 'Topi', 64, '', '', 64, 100, 446, 0, 'peserta', 2),
(608, 'BRG-c245', 'sarung Tangan', 20, '', '', 20, 20, 82, 0, 'peserta', 2),
(609, 'BRG-c256', 'Tas Reguler', 114, '', '', 114, 132, 456, 0, 'peserta', 2),
(610, 'BRG-c277', 'BLOCKNOTE', 0, '', '', 0, 0, 925, 729, 'peserta', 2),
(611, 'BRG-c288', 'PULPEN', 1189, '', '', 1189, 0, 893, 877, 'peserta', 2),
(612, 'BRG-c299', 'SOUVENIR BOTOL MINUM', 100, '', '', 100, 100, 459, 0, 'peserta', 2),
(613, 'BRG-c2b10', 'BLANKO SERTIFIKAT', 0, '', '', 0, 0, 0, 0, 'peserta', 2),
(614, 'BRG-c2d11', 'SERTIFIKAT JUARA', 0, '', '', 0, 0, 0, 0, 'peserta', 2),
(615, 'BRG-c2e12', 'HADIAH JUARA', 0, '', '', 0, 0, 19, -4, 'peserta', 2),
(616, 'BRG-c3013', 'PIN ( KHUSUS AKLI )', 17, '', '', 17, 30, 83, 0, 'peserta', 2),
(617, 'BRG-c3114', 'AMPLOP COKELAT BESAR', -200, '', '', -200, 1000, 200, 0, 'peserta', 2),
(618, 'BRG-c3215', 'ROMPI', 0, '', '', 0, 0, 0, 0, 'peserta', 2),
(619, 'BRG-c3416', 'JAKET DELTA', 0, '', '', 0, 0, 0, 0, 'peserta', 2),
(620, 'BRG-c3517', 'TAS EKSEKUTIF', 0, '', '', 0, 0, 0, 0, 'peserta', 2),
(621, 'BRG-c3718', 'Buku Agenda', 0, '', '', 0, 0, 432, 84, 'peserta', 2),
(622, 'BRG-c3819', 'Map Bening  kancing', 0, '', '', 0, 0, 8, 66, 'peserta', 2),
(623, 'BRG-c3a20', 'Amplop Coklat Kecil', 0, '', '', 0, 0, 200, 1600, 'peserta', 2),
(624, 'BRG-c3b21', 'Amplop Coklat Sedang', 0, '', '', 0, 0, 0, 0, 'peserta', 2),
(625, 'BRG-c3d22', 'Mouse Pad', 0, '', '', 0, 0, 1, 0, 'peserta', 2),
(626, 'BRG-c3f23', 'Headphone', 0, '', '', 0, 0, 0, 0, 'peserta', 2),
(627, 'BRG-c4024', 'Amplop cokelat 1/5', 0, '', '', 0, 0, 0, 0, 'peserta', 2),
(658, 'BRG-d552', 'Kertas A4', 0, '', 'DNP', 0, 0, 2, 13, 'ATK', 1),
(659, 'BRG-d5a3', 'Kertas F4', 7, '', 'DNP', 7, 0, 2, 0, 'ATK', 1),
(660, 'BRG-d5c4', 'Materai', 0, '', 'DNP', 0, 0, 0, 0, 'ATK', 1),
(661, 'BRG-d5d5', 'Batarai Alkalin A2', 0, '', 'DNP', 0, 0, 0, 0, 'ATK', 1),
(662, 'BRG-d5f6', 'Batarai Alkalin A3', 0, '', 'DNP', 0, 0, 0, 0, 'ATK', 1),
(663, 'BRG-d607', 'Batarai Alkalin 9VOLT', 0, '', 'DNP', 0, 0, 0, 0, 'ATK', 1),
(664, 'BRG-d618', 'Sticky Note Kecil', 0, '', 'DNP', 0, 0, 0, 0, 'ATK', 1),
(665, 'BRG-d639', 'Sticky Note Besar', 0, '', 'DNP', 0, 0, 0, 0, 'ATK', 1),
(666, 'BRG-d6410', 'Paper Clip', 0, '', 'DNP', 0, 0, 5, 2, 'ATK', 1),
(667, 'BRG-d6511', 'BINDER CLIP 105', 0, '', 'DNP', 0, 0, 15, 0, 'ATK', 1),
(668, 'BRG-d6712', 'Blinder Clip 111', 0, '', 'DNP', 0, 0, 0, 0, 'ATK', 1),
(669, 'BRG-d6813', 'Blinder Clip 107', 0, '', 'DNP', 0, 0, 0, 0, 'ATK', 1),
(670, 'BRG-d6914', 'Blinder Clip 260', 0, '', 'DNP', 0, 0, 0, 0, 'ATK', 1),
(671, 'BRG-d6a15', 'Blinder Clip 280', 0, '', 'DNP', 0, 0, 0, 0, 'ATK', 1),
(672, 'BRG-d6c16', 'Pulpen Snowman OPF', 0, '1000', 'DNP', 0, 0, 0, 0, 'ATK', 1),
(673, 'BRG-e7eb', 'Kantong mata', 30, '0', '', 30, 0, 0, 10, 'ATK', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pralatan_kantor`
--

CREATE TABLE `pralatan_kantor` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `tgl_beli` date NOT NULL,
  `lokasi_barang` varchar(30) NOT NULL,
  `keterangan` varchar(30) NOT NULL,
  `id_gudang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pralatan_kantor`
--

INSERT INTO `pralatan_kantor` (`id`, `kode_barang`, `nama_barang`, `jumlah`, `harga`, `tgl_beli`, `lokasi_barang`, `keterangan`, `id_gudang`) VALUES
(1181, 'KTR-83a2', 'Kaca / cermin', 1, '0', '0000-00-00', 'Lantai 1', '', 1),
(1182, 'KTR-9353', 'Rak serbaguna', 1, '0', '0000-00-00', 'Lantai 1 (Gudang)', '', 1),
(1183, 'KTR-a2e4', 'Tangga lipat', 2, '0', '0000-00-00', 'Lantai 1 (Gudang)', '', 1),
(1184, 'KTR-b1c5', 'Meja panjang putih', 1, '0', '0000-00-00', 'Lantai 1 (Gudang)', '', 1),
(1185, 'KTR-c046', 'AC', 3, '1100000', '0000-00-00', 'Lantai 1', '1 Rusak', 2),
(1186, 'KTR-cda7', 'Bunga plastik', 4, '0', '0000-00-00', 'Lantai 1', '2 Besar 2 Kecil', 1),
(1187, 'KTR-db78', 'Sanyo', 1, '0', '0000-00-00', 'Lantai 1 (Gudang)', '', 1),
(1188, 'KTR-e9c9', 'Figura ', 10, '0', '0000-00-00', 'Lantai 1', '', 1),
(1189, 'KTR-f7d10', 'Kursi plastik roda biru', 12, '0', '0000-00-00', 'Lantai 1 (Ruang Rapat)', '', 1),
(1190, 'KTR-04811', 'Meja rapat', 1, '0', '0000-00-00', 'Lantai 1 (Ruang Rapat)', '', 1),
(1191, 'KTR-11f12', 'Tempat tisu', 2, '0', '0000-00-00', 'Lantai 1', '', 1),
(1192, 'KTR-21b13', 'Kursi coklat besi', 3, '0', '0000-00-00', 'Lantai 1 (Ruang Rapat)', '', 1),
(1193, 'KTR-2ff14', 'Kursi kerja ', 3, '0', '0000-00-00', 'Lantai 1', '', 1),
(1194, 'KTR-3ed15', 'Wifi', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1195, 'KTR-4ca16', 'Meja coklat panjang', 1, '0', '0000-00-00', 'Lantai 1 (Ruang Rapat)', '', 1),
(1196, 'KTR-5a017', 'Meja coklat tinggi', 1, '0', '0000-00-00', 'Lantai 1 (Ruang Rapat)', '', 1),
(1197, 'KTR-68818', 'Kursi coklat tinggi', 1, '0', '0000-00-00', 'Lantai 1 (Ruang Rapat)', '', 1),
(1198, 'KTR-76a19', 'Jam dinding', 1, '0', '0000-00-00', 'Lantai 1 (Ruang Rapat)', '', 1),
(1199, 'KTR-84120', 'Kabel roll / colokan', 4, '0', '0000-00-00', 'Lantai 1', '', 1),
(1200, 'KTR-91b21', 'Papan tulis', 1, '0', '0000-00-00', 'Lantai 1 (Ruang Rapat)', '', 1),
(1201, 'KTR-a0f22', 'Fire alarm control panel', 1, '0', '0000-00-00', 'Lantai 1', '', 1),
(1202, 'KTR-b1323', 'Rak penyimpanan', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1203, 'KTR-c0824', 'Minatur mobil', 9, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1204, 'KTR-ce625', 'Meja FO', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1205, 'KTR-dc826', 'Penghancur kertas', 2, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1206, 'KTR-e9d27', 'Scanner', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1207, 'KTR-f7028', 'Meja bulat', 2, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1208, 'KTR-04229', 'Kursi plastik coklat', 4, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1209, 'KTR-11230', 'Kotak P3K', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1210, 'KTR-1f031', 'Kursi plastik putih', 4, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1211, 'KTR-2c132', 'Laptop ', 2, '0', '0000-00-00', 'Lantai 1 (FO)', '1 Lemot', 1),
(1212, 'KTR-39333', 'Printer', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1213, 'KTR-47334', 'Pembolong kertas', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1214, 'KTR-54935', 'Kotak plastik', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1215, 'KTR-61e36', 'Rak dokumen', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 1),
(1216, 'KTR-67137', 'Kursi kerja ', 10, '0', '0000-00-00', 'Lantai 2', '', 1),
(1217, 'KTR-73e38', 'Meja kerja', 9, '0', '0000-00-00', 'Lantai 2', '', 1),
(1218, 'KTR-85c39', 'Lemari dokumen', 1, '0', '0000-00-00', 'Lantai 2 (Ruang Pak Pri)', '', 1),
(1219, 'KTR-8ac40', 'AC', 4, '0', '0000-00-00', 'Lantai 2', '2 Mati / rusak', 1),
(1220, 'KTR-99241', 'Lemari plastik', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1221, 'KTR-a6542', 'Lemari penyimpanan', 3, '0', '0000-00-00', 'Lantai 2', '', 1),
(1222, 'KTR-ac343', 'Printer', 8, '0', '0000-00-00', 'Lantai 2', '1 Sedang diperbaiki', 1),
(1223, 'KTR-b0d44', 'Jam dinding', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1224, 'KTR-b5645', 'Kotak P3K', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1225, 'KTR-bac46', 'Rak dokumen', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1226, 'KTR-bf847', 'Laptop ', 9, '0', '0000-00-00', 'Lantai 2', '1 Rusak', 1),
(1227, 'KTR-cca48', 'CCTV', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1228, 'KTR-d1f49', 'Wifi', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1229, 'KTR-df450', 'Tempat sampah', 5, '0', '0000-00-00', 'Lantai 2', '', 1),
(1230, 'KTR-ecd51', 'Rak kayu putih', 1, '0', '0000-00-00', 'Lantai 2 (Ruang Pak Pranan)', '', 1),
(1231, 'KTR-f2952', 'Kabel roll / colokan', 7, '0', '0000-00-00', 'Lantai 2', '', 1),
(1232, 'KTR-00153', 'Heksos', 2, '0', '0000-00-00', 'Lantai 2', '', 1),
(1233, 'KTR-0f154', 'Dispenser', 1, '0', '0000-00-00', 'Lantai 2 (Dapur)', '', 1),
(1234, 'KTR-20955', 'Kitchen set', 1, '0', '0000-00-00', 'Lantai 2 (Dapur)', '', 1),
(1235, 'KTR-32c56', 'Kulkas', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1236, 'KTR-39957', 'Kaca / cermin', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1237, 'KTR-49b58', 'Kemoceng', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1238, 'KTR-59b59', 'Pengki', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1239, 'KTR-69360', 'Pel', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1240, 'KTR-77b61', 'Sapu', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1241, 'KTR-88062', 'Wipper', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1242, 'KTR-99b63', 'Sajadah', 4, '0', '0000-00-00', 'Lantai 2', '', 1),
(1243, 'KTR-aa564', 'Mukena', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1244, 'KTR-baf65', 'Karpet', 1, '0', '0000-00-00', 'Lantai 2', '', 1),
(1245, 'KTR-c1466', 'Figura ', 3, '0', '0000-00-00', 'Lantai 2', '', 1),
(1246, 'KTR-c6c67', 'Tempat tisu', 3, '0', '0000-00-00', 'Lantai 2', '', 1),
(1247, 'KTR-cd868', 'Penghancur kertas', 1, '0', '0000-00-00', 'Lantai 2 (Ruang Pak Pranan)', '', 1),
(1248, 'KTR-dda69', 'Komputer ', 1, '0', '0000-00-00', 'Lantai 2 (Ruang Pak Pranan)', '', 1),
(1249, 'KTR-e5970', 'Tempat sampah', 2, '0', '0000-00-00', 'Lantai 3', '', 1),
(1250, 'KTR-f3a71', 'Kursi biru besi', 20, '0', '0000-00-00', 'Lantai 3', '', 1),
(1251, 'KTR-01672', 'Kursi biru roda', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1252, 'KTR-07f73', 'Papan tulis', 2, '0', '0000-00-00', 'Lantai 3', '', 1),
(1253, 'KTR-0fd74', 'Meja coklat panjang', 9, '0', '0000-00-00', 'Lantai 3', '', 1),
(1254, 'KTR-15b75', 'Meja bulat', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1255, 'KTR-27076', 'Meja putih kecil', 4, '0', '0000-00-00', 'Lantai 3', '', 1),
(1256, 'KTR-2d077', 'Lemari penyimpanan', 3, '0', '0000-00-00', 'Lantai 3', '', 1),
(1257, 'KTR-3a878', 'Sound system', 1, '0', '0000-00-00', 'Lantai 3', 'Include mic & speaker', 1),
(1258, 'KTR-48279', 'Meja laci coklat', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1259, 'KTR-4fb80', 'AC', 2, '0', '0000-00-00', 'Lantai 3', '', 1),
(1260, 'KTR-75b81', 'Proyektor', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1261, 'KTR-84182', 'Alat pemadam api', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1262, 'KTR-8b583', 'Kabel roll / colokan', 11, '0', '0000-00-00', 'Lantai 3', '', 1),
(1263, 'KTR-91484', 'Bunga plastik', 2, '0', '0000-00-00', 'Lantai 3', '', 1),
(1264, 'KTR-96e85', 'Kotak P3K', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1265, 'KTR-9de86', 'Kitchen set', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1266, 'KTR-a3587', 'Dispenser', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1267, 'KTR-b1288', 'Pemanas air', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1268, 'KTR-b7389', 'CCTV', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1269, 'KTR-bce90', 'Heksos', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1270, 'KTR-c2791', 'Tempat tisu', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1271, 'KTR-caa92', 'Sapu', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1272, 'KTR-d1993', 'Pengki', 1, '0', '0000-00-00', 'Lantai 3', '', 1),
(1273, 'KTR-d6f94', 'Tempat sampah', 1, '0', '0000-00-00', 'Lantai 4', '', 1),
(1274, 'KTR-dc195', 'Meja panjang putih', 14, '0', '0000-00-00', 'Lantai 4', '2 Rusak 4 Berlubang', 1),
(1275, 'KTR-ea296', 'Meja tenis', 1, '0', '0000-00-00', 'Lantai 4', 'Patah', 1),
(1276, 'KTR-f7597', 'Bangku baso biru', 17, '0', '0000-00-00', 'Lantai 4', '', 1),
(1277, 'KTR-05798', 'Bangku baso coklat', 15, '0', '0000-00-00', 'Lantai 4', '', 1),
(1278, 'KTR-12f99', 'Kursi coklat plastik', 4, '0', '0000-00-00', 'Lantai 4', '', 1),
(1279, 'KTR-203100', 'kursi coklat besi', 3, '0', '0000-00-00', 'Lantai 4', '', 1),
(1280, 'KTR-2d6101', 'Kursi coklat tua plastik', 4, '0', '0000-00-00', 'Lantai 4', '', 1),
(1281, 'KTR-328102', 'Kursi biru besi', 10, '0', '0000-00-00', 'Lantai 4', '', 1),
(1282, 'KTR-376103', 'Lemari penyimpanan', 1, '0', '0000-00-00', 'Lantai 4', '', 1),
(1283, 'KTR-3c4104', 'CCTV', 1, '0', '0000-00-00', 'Lantai 4', '', 1),
(1284, 'KTR-0aa2', 'Meja Kelas', 4, '0', '0000-00-00', 'Lantai 4', '', 2),
(1285, 'KTR-1ca3', 'Kursi Kelas', 8, '0', '0000-00-00', 'Lantai 4', '', 2),
(1286, 'KTR-2ec4', 'Kursi Plastik', 8, '0', '0000-00-00', 'Lantai 4', '', 2),
(1287, 'KTR-4035', 'Kursi Kampus', 2, '0', '0000-00-00', 'Lantai 4', '', 2),
(1288, 'KTR-50c6', 'Kipas Angin', 2, '0', '0000-00-00', 'Lantai 4', '', 2),
(1289, 'KTR-6637', 'Kursi Kayu', 2, '0', '0000-00-00', 'Lantai 3', '', 2),
(1290, 'KTR-7d08', 'Meja Kayu', 1, '0', '0000-00-00', 'Lantai 3', '', 2),
(1291, 'KTR-8839', 'Kursi Plastik', 2, '0', '0000-00-00', 'Lantai 3', '', 2),
(1292, 'KTR-a3a10', 'Lemari', 1, '0', '0000-00-00', 'Lantai 3', '', 2),
(1293, 'KTR-dac13', 'Termos', 1, '0', '0000-00-00', 'Lantai 3', '', 2),
(1294, 'KTR-e0514', 'Kipas Angin', 1, '0', '0000-00-00', 'Lantai 3', '', 2),
(1295, 'KTR-f6b16', 'Kursi Kelas', 22, '0', '0000-00-00', 'Lantai 3 (Ruang Kelas)', '', 2),
(1296, 'KTR-fc617', 'Meja Kelas', 13, '0', '0000-00-00', 'Lantai 3 (Ruang Kelas)', '', 2),
(1297, 'KTR-1e719', 'TV', 1, '0', '0000-00-00', 'Lantai 3 (Ruang Kelas)', '', 2),
(1298, 'KTR-a4e29', 'Kursi Plastik', 3, '0', '0000-00-00', 'Lantai 3 (BSI)', '', 2),
(1299, 'KTR-bbe31', 'Rak Dispenser', 1, '0', '0000-00-00', 'Lantai 3 (BSI)', '', 2),
(1300, 'KTR-d3433', 'Telephone', 8, '0', '0000-00-00', 'Lantai 3 (BSI)', '', 2),
(1301, 'KTR-e3d34', 'Cabinet', 1, '0', '0000-00-00', 'Lantai 3 (BSI)', '', 2),
(1302, 'KTR-0ac37', 'Kursi', 2, '0', '0000-00-00', 'Lantai 2', '', 2),
(1303, 'KTR-1b238', 'Cermin', 1, '0', '0000-00-00', 'Lantai 2', '', 2),
(1304, 'KTR-2b539', 'Meja', 1, '0', '0000-00-00', 'Lantai 2', '', 2),
(1305, 'KTR-46642', 'Lemari Besi', 1, '0', '0000-00-00', 'Lantai 2', '', 2),
(1306, 'KTR-56a43', 'Lemari Kayu', 1, '0', '0000-00-00', 'Lantai 2', '', 2),
(1307, 'KTR-5bc44', 'Cabinet', 1, '0', '0000-00-00', 'Lantai 2', '', 2),
(1308, 'KTR-6bd45', 'Mesin Fotocopy', 1, '0', '0000-00-00', 'Lantai 2', '', 2),
(1309, 'KTR-80449', 'TV', 1, '0', '0000-00-00', 'Lantai 2 (Office)', '', 2),
(1310, 'KTR-91a50', 'Meja Belajar', 2, '0', '0000-00-00', 'Lantai 2 (Office)', '', 2),
(1311, 'KTR-96d51', 'Telephone', 8, '0', '0000-00-00', 'Lantai 2 (Office)', '', 2),
(1312, 'KTR-a0853', 'Cabinet', 3, '0', '0000-00-00', 'Lantai 2 (Office)', '', 2),
(1313, 'KTR-c9d59', 'Kursi', 7, '0', '0000-00-00', 'Lantai 2 (Ruang Rapat)', '', 2),
(1314, 'KTR-ce960', 'TV', 1, '0', '0000-00-00', 'Lantai 2 (Ruang Rapat)', '', 2),
(1315, 'KTR-ed663', 'Blower', 1, '0', '0000-00-00', 'Lantai 2 (Ruang Rapat)', '', 2),
(1316, 'KTR-f3164', 'Lemari', 1, '0', '0000-00-00', 'Lantai 2 (Ruang Rapat)', '', 2),
(1317, 'KTR-0db67', 'Mesin Penghancur Kertas', 1, '0', '0000-00-00', 'Lantai 2 (BSI)', '', 2),
(1318, 'KTR-2e071', 'Telephone', 1, '0', '0000-00-00', 'Lantai 2 (BSI)', '', 2),
(1319, 'KTR-48074', 'Kursi Rotan', 2, '0', '0000-00-00', 'Lantai 2 (BSI)', '', 2),
(1320, 'KTR-58175', 'Rak Sepatu', 1, '0', '0000-00-00', 'Lantai 2 (BSI)', '', 2),
(1321, 'KTR-62177', 'Cermin', 1, '0', '0000-00-00', 'Lantai 2 (Mushola)', '', 2),
(1322, 'KTR-66b78', 'Kipas Angin', 1, '0', '0000-00-00', 'Lantai 2 (Mushola)', '', 2),
(1323, 'KTR-6c779', 'Cabinet', 1, '0', '0000-00-00', 'Lantai 2 (Mushola)', '', 2),
(1324, 'KTR-8d481', 'Kursi Tamu Besi', 4, '0', '0000-00-00', 'Lantai 1', '', 2),
(1325, 'KTR-9d782', 'Meja Bulat Kaca', 2, '0', '0000-00-00', 'Lantai 1', '', 2),
(1326, 'KTR-adf83', 'Kursi Informa Lipat', 4, '0', '0000-00-00', 'Lantai 1', '', 2),
(1327, 'KTR-c3b85', 'Pot Bunga', 21, '0', '0000-00-00', 'Lantai 1', '', 2),
(1328, 'KTR-ca886', 'Kursi Tamu Besi', 2, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1329, 'KTR-cff87', 'Meja Bulat Kaca', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1330, 'KTR-e0988', 'Meja Pajangan', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1331, 'KTR-e8089', 'Kursi Kayu', 2, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1332, 'KTR-ee390', 'Meja Kayu', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1333, 'KTR-f4591', 'Kursi', 2, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1334, 'KTR-fa592', 'Pot Bunga', 2, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1335, 'KTR-00493', 'Cabinet', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1336, 'KTR-17d95', 'Laptop Lenovo', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1337, 'KTR-29e96', 'Laptop Acer', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1338, 'KTR-3ac97', 'Laptop Redmi', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1339, 'KTR-4a898', 'Maneken', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1340, 'KTR-5f299', 'AC Panasonic', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1341, 'KTR-78c100', 'Mesin Absensi Kartu', 2, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1342, 'KTR-936103', 'Mesin Fotocopy & Printer', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1343, 'KTR-a46104', 'Cabinet Kecil', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1344, 'KTR-a98105', 'Telephone', 3, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1345, 'KTR-b93106', 'Faximile', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1346, 'KTR-c8e107', 'Try', 1, '0', '0000-00-00', 'Lantai 1 (FO)', '', 2),
(1347, 'KTR-ce0108', 'Kursi', 4, '0', '0000-00-00', 'Lantai 1 (Ruang Ibu)', '', 2),
(1348, 'KTR-d2e109', 'Meja', 3, '0', '0000-00-00', 'Lantai 1 (Ruang Ibu)', '', 2),
(1349, 'KTR-d7b110', 'Try', 1, '0', '0000-00-00', 'Lantai 1 (Ruang Ibu)', '', 2),
(1350, 'KTR-dc6111', 'Mesin Fotocopy', 1, '0', '0000-00-00', 'Lantai 1 (Ruang Ibu)', '', 2),
(1351, 'KTR-edc112', 'Bufet', 1, '0', '0000-00-00', 'Lantai 1 (Ruang Ibu)', '', 2),
(1352, 'KTR-0e6116', 'Vase Bunga', 1, '0', '0000-00-00', 'Lantai 1 (Ruang Ibu)', '', 2),
(1353, 'KTR-1e7117', 'Meja Makan', 1, '0', '0000-00-00', 'Lantai 1 (Ruang Makan)', '', 2),
(1354, 'KTR-241118', 'Kursi', 6, '0', '0000-00-00', 'Lantai 1 (Ruang Makan)', '', 2),
(1355, 'KTR-33e119', 'Lemari Informa', 1, '0', '0000-00-00', 'Lantai 1 (Ruang Makan)', '', 2),
(1356, 'KTR-38c120', 'Kipas Angin', 1, '0', '0000-00-00', 'Lantai 1 (Ruang Makan)', '', 2),
(1357, 'KTR-3d8121', 'Cermin', 1, '0', '0000-00-00', 'Lantai 1', '', 2),
(1358, 'KTR-4d2122', 'Bingkai', 1, '0', '0000-00-00', 'Lantai 1', '', 2),
(1359, 'KTR-5ce123', 'Genset', 1, '0', '0000-00-00', 'Gudang', '', 2),
(1360, 'KTR-845125', 'Mesin Timbangan', 1, '0', '0000-00-00', 'Gudang', '', 2),
(1361, 'KTR-945126', 'Rak', 1, '0', '0000-00-00', 'Gudang', '', 2),
(1362, 'KTR-a58127', 'Mesin Penggiling Kopi', 1, '0', '0000-00-00', 'Gudang', '', 2),
(1363, 'KTR-aaa128', 'Meja', 3, '0', '0000-00-00', 'Gudang', '', 2),
(1364, 'KTR-af5129', 'Kursi', 3, '0', '0000-00-00', 'Gudang', '', 2),
(1365, 'KTR-beb130', 'Lemari Cabinet', 3, '0', '0000-00-00', 'Gudang', '', 2),
(1366, 'KTR-ceb131', 'Kursi Plastik Napoli', 8, '0', '0000-00-00', 'Gudang', '', 2),
(1367, 'KTR-dff132', 'Kursi Kayu Tinggi', 1, '0', '0000-00-00', 'Gudang', '', 2),
(1368, 'KTR-f2d133', 'Rak Besi', 7, '0', '0000-00-00', 'Gudang', '', 2),
(1369, 'KTR-04c134', 'Galon', 8, '0', '0000-00-00', 'Gudang', '', 2),
(1370, 'KTR-16b135', 'Tabung Gas', 2, '0', '0000-00-00', 'Gudang', '', 2),
(1371, 'KTR-1ea136', 'Meja Kelas', 1, '0', '0000-00-00', 'Gudang', '', 2),
(1372, 'KTR-2fd137', 'Appar', 6, '0', '0000-00-00', 'Gudang', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pralatan_praktek`
--

CREATE TABLE `pralatan_praktek` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `tgl_beli` date NOT NULL,
  `harga` varchar(50) NOT NULL,
  `tanggal_kalibrasi` date NOT NULL,
  `masa_berlaku_kalibrasi` date NOT NULL,
  `lokasi_barang` varchar(50) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `id_gudang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pralatan_praktek`
--

INSERT INTO `pralatan_praktek` (`id`, `kode_barang`, `nama_barang`, `jumlah`, `tgl_beli`, `harga`, `tanggal_kalibrasi`, `masa_berlaku_kalibrasi`, `lokasi_barang`, `keterangan`, `kategori`, `id_gudang`) VALUES
(325, 'BRG-3f92', 'Earth tester cable', 2, '1970-01-01', '0', '2023-02-14', '1970-01-01', 'Lantai 2', 'Habis', 'riksa', 1),
(326, 'BRG-4653', 'Earth clamp tester', 1, '2023-04-11', '0', '2023-02-14', '1970-01-01', 'Lantai 2', 'Habis', 'riksa', 1),
(327, 'BRG-4c44', 'Panel box mcb, 6 mcb, 1 elcb, tang potong dan obeng +', 1, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'Lantai 2', 'Habis', 'riksa', 1),
(328, 'BRG-5345', 'Thermograph/Thermal Imager', 1, '2023-04-11', '0', '2023-02-14', '1970-01-01', 'Lantai 2', 'Habis', 'riksa', 1),
(329, 'BRG-5896', 'Lux meter, Vibration meter, Sound level (1 set) / Envinronment Meter', 1, '2023-04-11', '0', '2023-02-14', '1970-01-01', 'Lantai 3', 'Habis', 'riksa', 1),
(330, 'BRG-5df7', 'Sigmat 15cm/Sigmat Digital', 1, '2023-04-11', '0', '2023-02-14', '1970-01-01', 'Lantai 2', 'Habis', 'riksa', 1),
(331, 'BRG-6338', 'Meteran', 1, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'Mas terzha', 'Habis', 'riksa', 1),
(332, 'BRG-6849', 'NDT Liquid penetrant set', 1, '1970-01-01', '0', '1970-01-01', '1970-01-01', 'Mas terzha', 'Habis', 'riksa', 1),
(333, 'BRG-6d510', 'Thickness gauge meter', 1, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'Mas terzha', 'Habis', 'riksa', 1),
(334, 'BRG-72711', 'NDT magnetic partikel test', 1, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'Lantai 3', 'Habis', 'riksa', 1),
(335, 'BRG-77912', 'Meteran gulung', 1, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'Lantai 3', 'Habis', 'riksa', 1),
(336, 'BRG-7e013', 'Meteran manual 5 meter', 2, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'Mas deni', 'Habis', 'riksa', 1),
(337, 'BRG-83914', 'Wire rope test', 1, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'lantai 3', 'Habis', 'riksa', 1),
(338, 'BRG-89015', 'Tool Box', 1, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'lantai 3', 'Habis', 'riksa', 1),
(339, 'BRG-8f016', 'Sigmat 50cm', 1, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'Lantai 2', 'Habis', 'riksa', 1),
(340, 'BRG-94317', 'Head Lamp', 1, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'Lantai 3', 'Habis', 'riksa', 1),
(341, 'BRG-99718', 'Insulation tester', 1, '2023-04-11', '0', '2023-02-14', '1970-01-01', 'Lantai 2', 'Habis', 'riksa', 1),
(342, 'BRG-9eb19', 'Tang Amphere/Clamp Meter', 1, '2023-04-11', '0', '2023-02-14', '1970-01-01', 'Lantai 2', 'Habis', 'riksa', 1),
(343, 'BRG-a4a20', 'Helm Riksa Uji', 4, '2022-04-12', '0', '1970-01-01', '1970-01-01', 'Mobil APV & Mobil mas terzha', 'Habis', 'riksa', 1),
(344, 'BRG-a9b21', 'Kacamata Riksa Uji', 4, '1970-01-01', '0', '1970-01-01', '1970-01-01', 'Lantai 3', 'Habis', 'riksa', 1),
(345, 'BRG-aec22', 'Sepatu Riksa Uji', 7, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'Lantai 3', 'Habis', 'riksa', 1),
(346, 'BRG-b3d23', 'Body Hardness', 2, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'Lantai 3', 'Habis', 'riksa', 1),
(347, 'BRG-b9424', 'Meteran Laser', 2, '2023-04-11', '0', '2023-02-14', '1970-01-01', 'Mas terzha', 'Habis', 'riksa', 1),
(348, 'BRG-bfb25', 'Vibration Meter', 1, '2023-04-11', '0', '2023-02-14', '1970-01-01', 'Mas terzha', 'Habis', 'riksa', 1),
(349, 'BRG-c5426', 'Sound Imager', 1, '2023-04-11', '0', '2023-02-14', '1970-01-01', 'Mas terzha', 'Habis', 'riksa', 1),
(350, 'BRG-ca827', 'Lux meter', 1, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'Mas terzha', 'Habis', 'riksa', 1),
(351, 'BRG-d0728', 'Anemometer', 1, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'Mas terzha', 'Habis', 'riksa', 1),
(352, 'BRG-d5729', 'Pitto Gauge', 1, '2023-04-11', '0', '1970-01-01', '1970-01-01', 'Mas terzha', 'Habis', 'riksa', 1),
(353, 'BRG-daa30', 'Dial Calliper', 1, '1970-01-01', '0', '2023-02-14', '1970-01-01', 'Mas terzha', 'Habis', 'riksa', 1),
(354, 'BRG-5242', 'Boneka Maneken', 5, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(355, 'BRG-6913', 'Maneken Tangan', 4, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(356, 'BRG-7eb4', 'Hansaplast Rol Kain', 6, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(357, 'BRG-9375', 'Betadine Kecil', 12, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(358, 'BRG-a7b6', 'Hansaplast Plester Sachet', 100, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(359, 'BRG-bc67', 'Nata Kasa Masinal', 84, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(360, 'BRG-d078', 'Kasa Hidrophyl Kecil', 40, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(361, 'BRG-e489', 'Kasa Hidrophyl Besar', 10, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(362, 'BRG-fb910', 'One Swabs', 2400, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(363, 'BRG-12d11', 'Biday Panjang', 1, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(364, 'BRG-27612', 'Biday Pendek', 1, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(365, 'BRG-3d213', 'Tandu', 1, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(366, 'BRG-52514', 'Masker', 2000, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(367, 'BRG-66315', 'Mitela', 100, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(368, 'BRG-7a816', 'Mesin Las', 16, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(369, 'BRG-8eb17', 'Mesin Gerinda', 10, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(370, 'BRG-a3c18', 'Plat Besi', 40, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(371, 'BRG-b8019', 'Pipa Besi', 50, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(372, 'BRG-cbc20', 'Fallet Plastik', 7, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(373, 'BRG-df621', 'Fallet Besi', 1, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(374, 'BRG-f3922', 'Fallet Kayu', 2, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(375, 'BRG-07b23', 'Cone', 16, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(376, 'BRG-1b724', 'Karung Goni', 3, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(377, 'BRG-2fd25', 'Gentong', 2, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(378, 'BRG-43926', 'Jerigen', 2, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(379, 'BRG-57427', 'Scaf Folding', 1, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2),
(380, 'BRG-6b328', 'Alat Beban', 50, '1970-01-01', '0', '1970-01-01', '1970-01-01', '', 'Habis', 'praktik', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `id_kantor` int(11) NOT NULL,
  `Nama` varchar(200) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_kantor`, `Nama`, `nama_lengkap`, `email`, `password`, `image`) VALUES
(1, 2, 'dnp', 'Fulana', 'dnp@gmail.com', 'b43e691700a8a4f5c1e903b6bc29a60a', 'default.jpg'),
(2, 1, 'dip', 'Puspita', 'dip@gmail.com', 'b43e691700a8a4f5c1e903b6bc29a60a', 'default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `detail_barang_keluar`
--
ALTER TABLE `detail_barang_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_peminjaman` (`id_peminjaman`);

--
-- Indexes for table `history_assets`
--
ALTER TABLE `history_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnal_alat_peraga`
--
ALTER TABLE `jurnal_alat_peraga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnal_alat_peserta`
--
ALTER TABLE `jurnal_alat_peserta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnal_alat_tulis_kantor`
--
ALTER TABLE `jurnal_alat_tulis_kantor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnal_barang`
--
ALTER TABLE `jurnal_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnal_barang_masuk`
--
ALTER TABLE `jurnal_barang_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnal_inventaris`
--
ALTER TABLE `jurnal_inventaris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnal_pinjam_inventaris`
--
ALTER TABLE `jurnal_pinjam_inventaris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnal_stok_barang`
--
ALTER TABLE `jurnal_stok_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_stok`
--
ALTER TABLE `laporan_stok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_barang`
--
ALTER TABLE `master_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_barang_old`
--
ALTER TABLE `master_barang_old`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_divisi`
--
ALTER TABLE `master_divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_kantor`
--
ALTER TABLE `master_kantor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_karyawan`
--
ALTER TABLE `master_karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_kategori`
--
ALTER TABLE `master_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_lokasi`
--
ALTER TABLE `master_lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_merek`
--
ALTER TABLE `master_merek`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_satuan`
--
ALTER TABLE `master_satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perlengkapan_peserta_old`
--
ALTER TABLE `perlengkapan_peserta_old`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pralatan_kantor`
--
ALTER TABLE `pralatan_kantor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pralatan_praktek`
--
ALTER TABLE `pralatan_praktek`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `detail_barang_keluar`
--
ALTER TABLE `detail_barang_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `history_assets`
--
ALTER TABLE `history_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jurnal_alat_peraga`
--
ALTER TABLE `jurnal_alat_peraga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jurnal_alat_peserta`
--
ALTER TABLE `jurnal_alat_peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jurnal_alat_tulis_kantor`
--
ALTER TABLE `jurnal_alat_tulis_kantor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jurnal_barang`
--
ALTER TABLE `jurnal_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jurnal_barang_masuk`
--
ALTER TABLE `jurnal_barang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jurnal_inventaris`
--
ALTER TABLE `jurnal_inventaris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jurnal_pinjam_inventaris`
--
ALTER TABLE `jurnal_pinjam_inventaris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jurnal_stok_barang`
--
ALTER TABLE `jurnal_stok_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `laporan_stok`
--
ALTER TABLE `laporan_stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_barang`
--
ALTER TABLE `master_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `master_barang_old`
--
ALTER TABLE `master_barang_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_divisi`
--
ALTER TABLE `master_divisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `master_kantor`
--
ALTER TABLE `master_kantor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `master_karyawan`
--
ALTER TABLE `master_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `master_kategori`
--
ALTER TABLE `master_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `master_lokasi`
--
ALTER TABLE `master_lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `master_merek`
--
ALTER TABLE `master_merek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `master_satuan`
--
ALTER TABLE `master_satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `perlengkapan_peserta_old`
--
ALTER TABLE `perlengkapan_peserta_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=674;

--
-- AUTO_INCREMENT for table `pralatan_kantor`
--
ALTER TABLE `pralatan_kantor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1373;

--
-- AUTO_INCREMENT for table `pralatan_praktek`
--
ALTER TABLE `pralatan_praktek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=381;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_barang_keluar`
--
ALTER TABLE `detail_barang_keluar`
  ADD CONSTRAINT `detail_barang_keluar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `barang_keluar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD CONSTRAINT `detail_peminjaman_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
