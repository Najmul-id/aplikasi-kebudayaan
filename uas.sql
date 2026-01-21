-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2026 at 11:34 PM
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
-- Database: `uas`
--

-- --------------------------------------------------------

--
-- Table structure for table `budaya`
--

CREATE TABLE `budaya` (
  `id` int(11) NOT NULL,
  `nama_budaya` varchar(100) NOT NULL,
  `daerah` varchar(100) NOT NULL,
  `kategori` enum('Tari','Musik','Kerajinan','Rumah Adat','Makanan','Lainnya') NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `budaya`
--

INSERT INTO `budaya` (`id`, `nama_budaya`, `daerah`, `kategori`, `deskripsi`, `gambar`, `created_at`, `updated_at`) VALUES
(2, 'Wayang Kulit', 'Jawa', 'Tari', 'Seni pertunjukan tradisional menggunakan boneka kulit yang dimainkan di balik layar dengan cahaya.', 'img/1768859634_Desain tanpa judul (10).png', '2026-01-19 21:10:19', '2026-01-19 21:53:54'),
(3, 'Rumah Honai', 'Papua', 'Rumah Adat', 'Rumah adat Papua berbentuk bulat dengan dinding kayu dan atap berbentuk kerucut.', 'img/rumah_honai.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(5, 'Soto Ayam', 'Jawa', 'Makanan', 'Makanan tradisional Indonesia berupa kuah rempah kental dengan daging ayam yang lezat.', 'img/soto_ayam.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(6, 'Angklung', 'Jawa Barat', 'Musik', 'Alat musik tradisional berbentuk tabung bambu yang dimainkan dengan cara digoyangkan.', 'img/angklung.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(7, 'Rendang', 'Minangkabau', 'Makanan', 'Masakan daging dengan santan dan rempah-rempah yang menjadi hidangan khas Minangkabau.', 'img/1768861901_Desain tanpa judul (6).png', '2026-01-19 21:10:19', '2026-01-19 22:31:41'),
(8, 'Batik Cirebon', 'Cirebon', 'Kerajinan', 'Batik khas Cirebon dengan motif megamendung yang unik dan bernilai tinggi.', 'img/1768861454_download (1).jpg', '2026-01-19 21:10:19', '2026-01-19 22:24:14');

-- --------------------------------------------------------

--
-- Table structure for table `festival`
--

CREATE TABLE `festival` (
  `id` int(11) NOT NULL,
  `nama_festival` varchar(150) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `festival`
--

INSERT INTO `festival` (`id`, `nama_festival`, `lokasi`, `tanggal_mulai`, `tanggal_selesai`, `deskripsi`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Festival Kesenian Bali', 'Bali', '2026-06-01', '2026-06-30', 'Festival tahunan di Bali menampilkan kesenian tradisional, tari, dan musik Bali yang memukau.', 'img/festival_bali.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(2, 'Festival Danau Toba', 'Sumatera Utara', '2026-08-15', '2026-08-20', 'Festival budaya Batak dengan pertunjukan tari, musik, dan pameran kerajinan lokal.', 'img/festival_toba.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(3, 'Pesta Rakyat Yogyakarta', 'Yogyakarta', '2026-07-10', '2026-07-15', 'Festival perayaan dengan pertunjukan wayang, musik gamelan, dan budaya Jawa lainnya.', 'img/festival_jogja.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(4, 'Pesona Nusantara Bandung', 'Bandung', '2026-09-01', '2026-09-10', 'Festival multikultural menampilkan budaya dari berbagai daerah Indonesia.', 'img/festival_bandung.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(5, 'Festival Ramadhan Jakarta', 'Jakarta', '2026-03-01', '2026-03-30', 'Perayaan Ramadhan dengan kesenian Islam tradisional dan budaya lokal Jakarta.', 'img/festival_jakarta.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(6, 'alunan budaya', 'selong', '2026-08-23', '2026-08-30', 'alunan budaya adalah tradisi masyarakat pringgasela untuk memeriahkan dan meningkatkan budaya yang mulai tergerus oleh peradaban.', 'img/1768859863_Desain tanpa judul (10).png', '2026-01-19 21:57:43', '2026-01-19 21:57:43');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `pass`, `email`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$7H8r7R7N4Z9T5K3X8Q2L4O3K8Y9X2Z4W5V6U1T2S3R4Q5P6O7N8M9L0K1J', 'admin@budaya.com', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(2, 'user1', '$2y$10$9K8L7M6N5O4P3Q2R1S0T9U8V7W6X5Y4Z3A2B1C0D9E8F7G6H5I4J3K2L1M0N', 'user1@budaya.com', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(3, 'ijal', '$2y$10$.WJut4wPS436RB.mXr2BR.f/Ck4uYfMdFwqFIfllO/Fs53UYcOLUm', NULL, '2026-01-19 21:47:14', '2026-01-19 21:47:14');

-- --------------------------------------------------------

--
-- Table structure for table `seniman`
--

CREATE TABLE `seniman` (
  `id` int(11) NOT NULL,
  `nama_seniman` varchar(100) NOT NULL,
  `spesialisasi` varchar(100) DEFAULT NULL,
  `daerah` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seniman`
--

INSERT INTO `seniman` (`id`, `nama_seniman`, `spesialisasi`, `daerah`, `deskripsi`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'I Made Sudana', 'Tari Bali', 'Bali', 'Maestro tari Bali dengan pengalaman lebih dari 30 tahun di industri seni pertunjukan.', 'img/seniman_sudana.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(2, 'Siti Nurbaya', 'Batik Tulis', 'Jawa', 'Pengrajin batik tulis terkenal yang telah memenangkan berbagai penghargaan internasional.', 'img/seniman_siti.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(3, 'Budi Santoso', 'Wayang Kulit', 'Jawa Tengah', 'Dalang profesional yang terkenal dengan koleksi wayang kulit terlengkap di Indonesia.', 'img/seniman_budi.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(4, 'Dewi Pertiwi', 'Gamelan', 'Jawa', 'Pemain gamelan berbakat dengan suara yang indah dan mastery teknik yang sempurna.', 'img/seniman_dewi.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(5, 'Ahmad Hassan', 'Kerajinan Logam', 'Yogyakarta', 'Pengrajin logam tradisional dengan desain modern yang menggabungkan seni warisan dan inovasi.', 'img/seniman_ahmad.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19'),
(6, 'Rafiqa Maulida', 'Tari Kontemporer', 'Jakarta', 'Penari kontemporer yang menggabungkan gerakan tradisional dengan interpretasi modern.', 'img/seniman_rafiqa.jpg', '2026-01-19 21:10:19', '2026-01-19 21:10:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budaya`
--
ALTER TABLE `budaya`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `festival`
--
ALTER TABLE `festival`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `seniman`
--
ALTER TABLE `seniman`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budaya`
--
ALTER TABLE `budaya`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `festival`
--
ALTER TABLE `festival`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seniman`
--
ALTER TABLE `seniman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
