-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Jan 2025 pada 15.30
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ujikom_jwd`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_mahasiswa`
--

CREATE TABLE `daftar_mahasiswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `hp` varchar(15) NOT NULL,
  `semester` int(11) NOT NULL,
  `ipk` float NOT NULL,
  `beasiswa` varchar(30) NOT NULL,
  `berkas` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_mahasiswa`
--

INSERT INTO `daftar_mahasiswa` (`id`, `nama`, `email`, `hp`, `semester`, `ipk`, `beasiswa`, `berkas`, `status`) VALUES
(1, 'Irfan Sabrian', 'irfansabrian34@gmail.com', '089508669156', 4, 3.6, 'Akademik', 'Tanda Tangan.jpg', 'Diverifikasi'),
(2, 'Naruto Uzumaki', 'naruto@gmail.com', '08312347123', 2, 3.2, 'Non Akademik', 'naruto.png', 'Diverifikasi'),
(3, 'Sakura Haruno', 'sakura@gmail.com', '0812312631', 4, 3.9, 'Akademik', 'sakura.png', 'Belum Diverifikasi'),
(4, 'Sasuke Uchiha', 'sasuke@gmail.com', '0832132141', 5, 3.5, 'Akademik', 'sasuke.png', 'Belum Diverifikasi'),
(5, 'Hinata Hyuga', 'hinata@gmail.com', '3127312632', 6, 3.2, 'Akademik', 'hinata.png', 'Belum Diverifikasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `email_terverifikasi`
--

CREATE TABLE `email_terverifikasi` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `ipk` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `email_terverifikasi`
--

INSERT INTO `email_terverifikasi` (`id`, `email`, `nama`, `ipk`) VALUES
(1, 'irfansabrian34@gmail.com', 'Irfan Sabrian', 3.6),
(2, 'naruto@gmail.com', 'Naruto Uzumaki', 3.2),
(3, 'sakura@gmail.com', 'Sakura Haruno', 3.9),
(4, 'sasuke@gmail.com', 'Sasuke Uchiha', 3.5),
(5, 'hinata@gmail.com', 'Hinata Hyuga', 3.2),
(6, 'kakashi@gmail.com', 'Kakashi Hatake', 3.8),
(7, 'jiraiya@gmail.com', 'Jiraiya Sensei', 2.7),
(8, 'tsunade@gmail.com', 'Tsunade Senju', 3.9),
(9, 'orochimaru@gmail.com', 'Orochimaru', 3.6),
(10, 'itachi@gmail.com', 'Itachi Uchiha', 4);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `daftar_mahasiswa`
--
ALTER TABLE `daftar_mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `email_terverifikasi`
--
ALTER TABLE `email_terverifikasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `daftar_mahasiswa`
--
ALTER TABLE `daftar_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `email_terverifikasi`
--
ALTER TABLE `email_terverifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
