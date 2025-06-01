-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Bulan Mei 2025 pada 04.12
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kai`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `import_data`
--

CREATE TABLE `import_data` (
  `id` int(11) NOT NULL,
  `laporan_laba_rugi_komprehensif` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_keuangan`
--

CREATE TABLE `laporan_keuangan` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `uraian` text NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `kategori` enum('pendapatan','beban','laba','pajak','laba (rugi) usaha','pendapatan (beban) lain-lain','laba (rugi) sebelum pajak penghasilan','pajak penghasilan','laba (rugi) bersih tahun berjalan','kepentingan non pengendaili','lainnya') DEFAULT 'lainnya',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan_keuangan`
--

INSERT INTO `laporan_keuangan` (`id`, `kode`, `uraian`, `parent_id`, `kategori`, `created_at`, `updated_at`) VALUES
(3, '1.', 'Angkutan KA Penumpang', NULL, 'pendapatan', '2025-05-27 16:01:39', '2025-05-27 17:18:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_nilai`
--

CREATE TABLE `laporan_nilai` (
  `id` int(11) NOT NULL,
  `laporan_id` int(11) DEFAULT NULL,
  `bulan` tinyint(4) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `realisasi` bigint(20) DEFAULT 0,
  `anggaran` bigint(20) DEFAULT 0,
  `anggaran_tahun` bigint(20) DEFAULT 0,
  `ach` decimal(6,2) DEFAULT 0.00,
  `growth` decimal(6,2) DEFAULT 0.00,
  `ach_lalu` decimal(6,2) DEFAULT 0.00,
  `analisis_vertical` decimal(6,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan_nilai`
--

INSERT INTO `laporan_nilai` (`id`, `laporan_id`, `bulan`, `tahun`, `realisasi`, `anggaran`, `anggaran_tahun`, `ach`, `growth`, `ach_lalu`, `analisis_vertical`, `created_at`, `updated_at`) VALUES
(2, 3, 1, 2025, 7788888888, 555555555, 9999999999, '87.08', '77.89', '9999.99', '56.98', '2025-05-27 16:01:39', '2025-05-27 16:01:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendapatan`
--

CREATE TABLE `pendapatan` (
  `id` int(11) NOT NULL,
  `no` varchar(100) DEFAULT NULL,
  `Uraian` varchar(100) DEFAULT NULL,
  `REALISASI_tahunSebelum` decimal(15,2) DEFAULT NULL,
  `ANGGARAN_tahun` decimal(15,2) DEFAULT NULL,
  `REALISASI_tahun` decimal(15,2) DEFAULT NULL,
  `ANALISIS_perTahun` decimal(15,2) DEFAULT NULL,
  `ACH` decimal(5,2) DEFAULT NULL,
  `GROWTH` decimal(5,2) DEFAULT NULL,
  `ANALISIS_VERTICAL` decimal(5,2) DEFAULT NULL,
  `ach_realisasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendapatan`
--

INSERT INTO `pendapatan` (`id`, `no`, `Uraian`, `REALISASI_tahunSebelum`, `ANGGARAN_tahun`, `REALISASI_tahun`, `ANALISIS_perTahun`, `ACH`, `GROWTH`, `ANALISIS_VERTICAL`, `ach_realisasi`) VALUES
(2, '1', 'Angkutan KA Penumpang', '507778782000.00', '584654885000.00', '572482886274.00', '2031365759.00', '97.92', '12.74', '83.86', NULL),
(3, '2', 'Angkutan KA Barang', '18551268263.00', '20393654984.93', '22778918810.00', '66252181.60', '111.70', '22.79', '3.34', NULL),
(4, '3', 'Pendapatan Pendukung Angkutan KA', '10872758521.00', '11611416486.38', '10508418000.00', '34889116.45', '90.50', '-3.35', '1.54', NULL),
(5, '4', 'Non Angkutan KA', '23305274726.00', '33131653075.21', '39483835312.00', '117060038.59', '119.17', '69.42', '5.78', NULL),
(6, '5', 'Kompensasi Pemerintah (PSO-IMO-KA Perintis)', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', NULL),
(7, '5. a', 'Kontribusi Pemerintah sebagai Bentuk Kewajiban Pelayanan Publik (PSO)', '17073812904.00', '12590563303.47', '13759668152.00', NULL, '109.29', '-19.41', '2.02', NULL),
(8, '5. b', 'Kontribusi Pemerintah sebagai Bentuk Subsidi Angkutan', '1085432282.00', '2360241489.69', '4351359919.00', '37579945.66', '184.36', '300.89', '0.64', NULL),
(9, '5. c', 'Kontribusi Negara untuk Penyediaan Prasarana (IMO)', '33909982332.00', '32691070335.20', '19336503380.00', '98073211.01', '59.15', '-42.98', '2.83', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(2, '', 'user@example.com', '$2y$10$JQckvjxcxqDr1ti6CdLh8OUkbhccjAY69ZAPqYYuCh.5CKz/XNTsa', '2025-05-23 04:44:51'),
(5, 'admin', 'admin@example.com', '$2y$10$U4YQUchx/86fsJgLhfJfd.D90zIDPna8DMdXZbtligp/sDyux92aq', '2025-05-23 03:19:11');

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `import_data`
--
ALTER TABLE `import_data`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indeks untuk tabel `laporan_nilai`
--
ALTER TABLE `laporan_nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_id` (`laporan_id`);

--
-- Indeks untuk tabel `pendapatan`
--
ALTER TABLE `pendapatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `import_data`
--
ALTER TABLE `import_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `laporan_nilai`
--
ALTER TABLE `laporan_nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pendapatan`
--
ALTER TABLE `pendapatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  ADD CONSTRAINT `laporan_keuangan_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `laporan_keuangan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_nilai`
--
ALTER TABLE `laporan_nilai`
  ADD CONSTRAINT `laporan_nilai_ibfk_1` FOREIGN KEY (`laporan_id`) REFERENCES `laporan_keuangan` (`id`) ON DELETE CASCADE;

-- --------------------------------------------------------

--
-- Struktur dari tabel `investasi`
--

CREATE TABLE `investasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no` int(11) DEFAULT NULL,
  `uraian` varchar(255) DEFAULT NULL,
  `wbs` varchar(50) DEFAULT NULL,
  `lokasi_pengadaan` varchar(255) DEFAULT NULL,
  `volume_satuan` varchar(50) DEFAULT NULL,
  `harga_satuan` decimal(20,2) DEFAULT NULL,
  `jumlah_dana` decimal(20,2) DEFAULT NULL,
  `budget_tahun_2024` decimal(20,2) DEFAULT NULL,
  `tambahan_dana` decimal(20,2) DEFAULT NULL,
  `total_tahun_2024` decimal(20,2) DEFAULT NULL,
  `commitment` decimal(20,2) DEFAULT NULL,
  `actual` decimal(20,2) DEFAULT NULL,
  `consumed_budget` decimal(20,2) DEFAULT NULL,
  `available_budget` decimal(20,2) DEFAULT NULL,
  `progres_saat_ini` text DEFAULT NULL,
  `tanggal_kontrak` date DEFAULT NULL,
  `no_kontrak` varchar(100) DEFAULT NULL,
  `nilai_kontrak` decimal(20,2) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
</create_file>
