-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jan 2023 pada 14.31
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_my_presensi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_absensi`
--

CREATE TABLE `tbl_absensi` (
  `id_absensi` int(15) NOT NULL,
  `id_siswa` int(15) DEFAULT NULL,
  `status` int(15) DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_absensi`
--

INSERT INTO `tbl_absensi` (`id_absensi`, `id_siswa`, `status`, `waktu`, `tanggal`) VALUES
(1, 1, 1, '08:01:00', '2022-12-05'),
(2, 1, 1, '08:02:00', '2022-12-06'),
(3, 1, 1, '08:03:00', '2022-12-07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(15) NOT NULL,
  `kode_admin` varchar(4) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `kode_admin`, `nama`, `nip`, `email`) VALUES
(1, 'A001', 'Nicholas Farel Alfiano', '2022122501', 'nicholas@gmail.com'),
(2, 'A002', 'Hafidz Izdihar Bintang', '2022122502', 'hafidz@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_alasan`
--

CREATE TABLE `tbl_alasan` (
  `id_alasan` int(15) NOT NULL,
  `id_siswa` int(15) DEFAULT NULL,
  `alasan` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_alasan`
--

INSERT INTO `tbl_alasan` (`id_alasan`, `id_siswa`, `alasan`, `tanggal`) VALUES
(1, 1, 'Izin Acara', '2023-01-09'),
(2, 2, 'Sakit Perut', '2023-01-09'),
(3, 1, 'Izin Acara', '2023-01-13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kegiatan`
--

CREATE TABLE `tbl_kegiatan` (
  `id_kegiatan` int(15) NOT NULL,
  `id_siswa` int(15) DEFAULT NULL,
  `kegiatan` varchar(255) DEFAULT NULL,
  `waktu_awal` time DEFAULT NULL,
  `waktu_akhir` time DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_kegiatan`
--

INSERT INTO `tbl_kegiatan` (`id_kegiatan`, `id_siswa`, `kegiatan`, `waktu_awal`, `waktu_akhir`, `tanggal`) VALUES
(1, 1, 'Melakukan Verifikasi Absensi', '08:00:09', '12:00:21', '2022-12-05'),
(2, 1, 'Melakukan Verifikasi Absensi', '14:13:10', '14:13:22', '2022-12-05'),
(3, 1, 'Melakukan Verifikasi Absensi', '08:09:09', '14:13:21', '2022-12-06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_siswa`
--

CREATE TABLE `tbl_siswa` (
  `id_siswa` int(15) NOT NULL,
  `kode_siswa` varchar(4) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `kelas` varchar(255) DEFAULT NULL,
  `jurusan` varchar(255) DEFAULT NULL,
  `nis` varchar(255) DEFAULT NULL,
  `mulai_semester` date DEFAULT NULL,
  `akhir_semester` date DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_siswa`
--

INSERT INTO `tbl_siswa` (`id_siswa`, `kode_siswa`, `nama`, `kelas`, `jurusan`, `nis`, `mulai_semester`, `akhir_semester`, `alamat`, `no_telp`, `foto`) VALUES
(1, 'M001', 'Siswa1', 'XI PPLG B', 'Pengembangan Perangkat Lunak dan Ginm', '062030701635', '2022-12-05', '2023-01-30', 'Jl. Sutan Syahrir No. 1023', '089662380814', 'foto_default.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_setting_absensi`
--

CREATE TABLE `tbl_setting_absensi` (
  `id_waktu` int(15) DEFAULT NULL,
  `mulai_absen` time DEFAULT NULL,
  `akhir_absen` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_setting_absensi`
--

INSERT INTO `tbl_setting_absensi` (`id_waktu`, `mulai_absen`, `akhir_absen`) VALUES
(1, '08:00:00', '09:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_site`
--

CREATE TABLE `tbl_site` (
  `id_site` int(15) DEFAULT NULL,
  `nama_instansi` varchar(255) DEFAULT NULL,
  `pimpinan` varchar(255) DEFAULT NULL,
  `pembimbing` varchar(255) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_site`
--

INSERT INTO `tbl_site` (`id_site`, `nama_instansi`, `pimpinan`, `pembimbing`, `no_telp`, `alamat`, `website`, `logo`) VALUES
(1, 'SMK Negeri 5 Surakarta', 'Dra. Ties Setyaningsih, M.pd M.M.', 'Bernadetha Sri Hardiyanti', '(0271) 713916', 'Jalan Adi Sucipto No. 42, Laweyan, Surakarta', 'www.smkn5solo.sch.id', 'smkn5.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(15) NOT NULL,
  `kode_pengguna` varchar(4) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `kode_pengguna`, `username`, `password`, `level`) VALUES
(1, 'A001', 'amin', 'e10adc3949ba59abbe56e057f20f883e', 'Admin'),
(2, 'M001', '062030701635', 'e10adc3949ba59abbe56e057f20f883e', 'Siswa'),
(3, 'M002', '062030701636', 'e10adc3949ba59abbe56e057f20f883e', 'Siswa');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_absensi`
--
ALTER TABLE `tbl_absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `tbl_absensi_ibfk1_1` (`id_siswa`);

--
-- Indeks untuk tabel `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `kode_admin` (`kode_admin`);

--
-- Indeks untuk tabel `tbl_alasan`
--
ALTER TABLE `tbl_alasan`
  ADD PRIMARY KEY (`id_alasan`),
  ADD KEY `tbl_alasan_ibfk1_1` (`id_siswa`);

--
-- Indeks untuk tabel `tbl_kegiatan`
--
ALTER TABLE `tbl_kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`),
  ADD KEY `tbl_kegiatan_ibfk1_1` (`id_siswa`);

--
-- Indeks untuk tabel `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `kode_siswa` (`kode_siswa`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `kode_pengguna` (`kode_pengguna`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_absensi`
--
ALTER TABLE `tbl_absensi`
  MODIFY `id_absensi` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT untuk tabel `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_alasan`
--
ALTER TABLE `tbl_alasan`
  MODIFY `id_alasan` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_kegiatan`
--
ALTER TABLE `tbl_kegiatan`
  MODIFY `id_kegiatan` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT untuk tabel `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  MODIFY `id_siswa` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_absensi`
--
ALTER TABLE `tbl_absensi`
  ADD CONSTRAINT `tbl_absensi_ibfk1_1` FOREIGN KEY (`id_siswa`) REFERENCES `tbl_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_admin`
--

DELETE FROM tbl_admin
WHERE kode_admin NOT IN (SELECT kode_pengguna FROM tbl_user);

ALTER TABLE `tbl_admin`
  ADD CONSTRAINT `tbl_admin_ibfk_1` FOREIGN KEY (`kode_admin`) REFERENCES `tbl_user` (`kode_pengguna`);

--
-- Ketidakleluasaan untuk tabel `tbl_alasan`
--

DELETE FROM tbl_alasan
WHERE id_siswa NOT IN (SELECT id_siswa FROM tbl_siswa);

ALTER TABLE `tbl_alasan`
  ADD CONSTRAINT `tbl_alasan_ibfk1_1` FOREIGN KEY (`id_siswa`) REFERENCES `tbl_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_kegiatan`
--
ALTER TABLE `tbl_kegiatan`
  ADD CONSTRAINT `tbl_kegiatan_ibfk1_1` FOREIGN KEY (`id_siswa`) REFERENCES `tbl_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD CONSTRAINT `tbl_siswa_ibfk_1` FOREIGN KEY (`kode_siswa`) REFERENCES `tbl_user` (`kode_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
