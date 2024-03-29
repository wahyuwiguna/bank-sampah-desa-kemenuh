-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.33-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for db_bank_sampah_desa_kemenuh
CREATE DATABASE IF NOT EXISTS `db_bank_sampah_desa_kemenuh` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_bank_sampah_desa_kemenuh`;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_arus_kas
CREATE TABLE IF NOT EXISTS `tb_arus_kas` (
  `id_arus_kas` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `kode_transaksi` varchar(50) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `kredit` double DEFAULT NULL,
  PRIMARY KEY (`id_arus_kas`),
  UNIQUE KEY `kode_transaksi` (`kode_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_arus_kas: ~2 rows (approximately)
DELETE FROM `tb_arus_kas`;
/*!40000 ALTER TABLE `tb_arus_kas` DISABLE KEYS */;
INSERT INTO `tb_arus_kas` (`id_arus_kas`, `tanggal`, `kode_transaksi`, `keterangan`, `status`, `debit`, `kredit`) VALUES
	(6, '2024-02-22', 'TRS-202402-0001', 'Penarikan tabungan sampah - TRS-202402-0001', 'Penarikan Kas', 0, 5000),
	(7, '2024-02-22', 'PNS-202402-0001', 'Penjualan sampah - PNS-202402-0001', 'Penambahan Kas', 4500, 0),
	(9, '2024-02-01', 'KAS-202402-0001', 'Saldo awal kas', 'Kas', 500000, 0),
	(10, '2024-03-02', 'PNS-202403-0001', 'Penjualan sampah - PNS-202403-0001', 'Penambahan Kas', 11500, 0),
	(11, '2024-03-08', 'PNS-202403-0002', 'Penjualan sampah - PNS-202403-0002', 'Penambahan Kas', 12000, 0),
	(12, '2024-03-15', 'PNS-202403-0003', 'Penjualan sampah - PNS-202403-0003', 'Penambahan Kas', 8900, 0);
/*!40000 ALTER TABLE `tb_arus_kas` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_banjar
CREATE TABLE IF NOT EXISTS `tb_banjar` (
  `id_banjar` int(11) NOT NULL AUTO_INCREMENT,
  `nama_banjar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_banjar`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_banjar: ~11 rows (approximately)
DELETE FROM `tb_banjar`;
/*!40000 ALTER TABLE `tb_banjar` DISABLE KEYS */;
INSERT INTO `tb_banjar` (`id_banjar`, `nama_banjar`) VALUES
	(1, 'Tegenungan'),
	(2, 'Kemenuh Kelod'),
	(3, 'Kemenuh Induk'),
	(4, 'Kemenuh Kangin'),
	(5, 'Medahan'),
	(6, 'Sumampan'),
	(7, 'Batusepih'),
	(8, 'Tengkulak Mas'),
	(9, 'Tengkulak Tengah'),
	(10, 'Tengkulak Kaja Kauh'),
	(11, 'Tengkulak Kaja Kangin');
/*!40000 ALTER TABLE `tb_banjar` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_bulan
CREATE TABLE IF NOT EXISTS `tb_bulan` (
  `id` varchar(50) NOT NULL,
  `bulan` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_bulan: ~12 rows (approximately)
DELETE FROM `tb_bulan`;
/*!40000 ALTER TABLE `tb_bulan` DISABLE KEYS */;
INSERT INTO `tb_bulan` (`id`, `bulan`) VALUES
	('01', 'Januari'),
	('02', 'Februari'),
	('03', 'Maret'),
	('04', 'April'),
	('05', 'Mei'),
	('06', 'Juni'),
	('07', 'Juli'),
	('08', 'Agustus'),
	('09', 'September'),
	('10', 'Oktober'),
	('11', 'November'),
	('12', 'Desember');
/*!40000 ALTER TABLE `tb_bulan` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_jenis_sampah
CREATE TABLE IF NOT EXISTS `tb_jenis_sampah` (
  `id_jenis_sampah` int(11) NOT NULL AUTO_INCREMENT,
  `kode_sampah` varchar(50) DEFAULT NULL,
  `jenis_sampah` varchar(150) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `harga_beli` double DEFAULT NULL,
  `stok` decimal(10,1) DEFAULT '0.0',
  `harga_jual` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id_jenis_sampah`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_jenis_sampah: ~25 rows (approximately)
DELETE FROM `tb_jenis_sampah`;
/*!40000 ALTER TABLE `tb_jenis_sampah` DISABLE KEYS */;
INSERT INTO `tb_jenis_sampah` (`id_jenis_sampah`, `kode_sampah`, `jenis_sampah`, `keterangan`, `harga_beli`, `stok`, `harga_jual`, `status`) VALUES
	(1, 'JS-0001', 'PET Kotor', 'Botol plastik minuman berisi label dan tutup', 1500, 0.0, 2000, 1),
	(2, 'JS-0002', 'PET Bening Bersih', 'Botol plastik bening. Ex : teh pucuk, teh botol, coca-cola, dll', 2500, 0.0, 3000, 1),
	(3, 'JS-0003', 'PET Bening Biru Bersih', 'Botol plastik dengan warna biru tranparan. Ex : Aqua, Le mineral', 2000, 2.0, 3700, 1),
	(4, 'JS-0004', 'PET Warna Bersih', 'Botol plastik berwarna. Ex : Sprite, Mizone', 1000, 0.0, 1500, 1),
	(5, 'JS-0005', 'Gelas Plastik Bening Kotor', 'Gelas plastik yang masih berisi label dan tutup', 1500, 0.0, 2000, 1),
	(6, 'JS-0006', 'Gelas Plastik Bening Bersih', 'Gelas plastik bening tanpa label dan tutup', 4000, 2.0, 4500, 1),
	(7, 'JS-0007', 'Gelas Plastik Warna', 'Gelas plastik yang berisi sablon', 1000, 3.0, 1500, 1),
	(8, 'JS-0008', 'Besi', 'Bahan yang mudah berkarat', 1200, 1.0, 2500, 1),
	(9, 'JS-0009', 'Kerasan', 'Plastik yang mudah pecah', 300, 0.0, 500, 1),
	(10, 'JS-0010', 'Botol Kaca', 'Botol kaca yang berwarna bening dan utuh', 200, 0.0, 300, 1),
	(11, 'JS-0011', 'Saset', 'Plastik kemasan yang memiliki lapisan', 300, 0.0, 500, 1),
	(12, 'JS-0012', 'Tutup PET', 'Tutup botol plastik', 2500, 0.0, 4000, 1),
	(14, 'JS-0014', 'Kresek Campur', 'Semua jenis plastik lembaran yang berwarna', 400, 0.0, 600, 1),
	(15, 'JS-0015', 'Kardus A', 'Kardus dengan kondisi bagus', 1500, 2.0, 2900, 1),
	(16, 'JS-0016', 'Kardus B', 'Kardus dengan kondisi basah,robek dan kotor', 800, 0.0, 1700, 1),
	(17, 'JS-0017', 'Kaleng Aluminium', 'Kaleng yang mudah diremukkan', 8000, 0.0, 11000, 1),
	(18, 'JS-0018', 'Bir Besar', 'Berisi tulisan BINTANG timbul', 700, 0.0, 1000, 1),
	(19, 'JS-0019', 'Bir Kecil', 'Berisi tulisan BINTANG timbul', 300, 2.4, 450, 1),
	(20, 'JS-0020', 'Duplex', 'Kertas tebal berwarna seperti sampul buku', 700, 2.0, 1200, 1),
	(21, 'JS-0021', 'Minyak Jelatah', 'Minyak bekas', 2500, 0.0, 4000, 1),
	(22, 'JS-0022', 'Jerigen', 'jerigen 5L', 1500, 2.0, 3000, 1),
	(23, 'JS-0023', 'Paku', 'Jenis Paku besi', 700, 0.0, 1800, 1),
	(24, 'JS-0024', 'HVS', 'Kertas HVS', 1500, 1.0, 3000, 1),
	(25, 'JS-0025', 'Omplong', 'Kaleng yang sulit diremukkan', 700, 0.0, 1600, 1),
	(26, 'JS-0026', 'Kertas Tipis', 'Kertas buku tipis', 700, 0.0, 1000, 0),
	(27, 'JS-0027', 'Elektronik Ringan', 'Barang ekektronik bekas ringan', 200, 0.0, 500, 1);
/*!40000 ALTER TABLE `tb_jenis_sampah` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_nasabah
CREATE TABLE IF NOT EXISTS `tb_nasabah` (
  `id_nasabah` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal_register` date DEFAULT NULL,
  `no_rekening` varchar(50) DEFAULT NULL,
  `NIK` varchar(20) DEFAULT NULL,
  `nama_nasabah` varchar(200) DEFAULT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `id_banjar` int(11) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `saldo` double(22,0) DEFAULT '0',
  `status` varchar(20) DEFAULT NULL,
  `password` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`id_nasabah`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_nasabah: ~3 rows (approximately)
DELETE FROM `tb_nasabah`;
/*!40000 ALTER TABLE `tb_nasabah` DISABLE KEYS */;
INSERT INTO `tb_nasabah` (`id_nasabah`, `tanggal_register`, `no_rekening`, `NIK`, `nama_nasabah`, `alamat`, `id_banjar`, `no_telp`, `saldo`, `status`, `password`) VALUES
	(1, '2024-02-20', 'REK-00001', '5012198051119980001', 'Rudi Adi Made', 'Jl. Melati 1', 7, '08123456789', 31520, 'Aktif', '1755e8df56655122206c7c1d16b1c7e3'),
	(2, '2024-02-20', 'REK-00002', '5012399111219960002', 'Ni Made Ayu', 'Jl. Mawar 1', 3, '08123456789', 13000, 'Aktif', '4ab8710d781ba5b13aaf561cafd896b7'),
	(3, '2024-02-22', 'REK-00003', '5012399111219960003', 'Gede Sujati', 'Jl. Melati 1', 7, '08123456789', 0, 'Aktif', '13ad65cc032d4b04927943c33673a65d'),
	(4, '2024-03-15', 'REK-00004', '5012399111219960004', 'Kadek Murni', 'Jl. Melati 1', 7, '08123456789', 0, 'Aktif', '9bd0a034baadfaddd3a89af39bc4320b');
/*!40000 ALTER TABLE `tb_nasabah` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_penarikan_tabungan
CREATE TABLE IF NOT EXISTS `tb_penarikan_tabungan` (
  `id_penarikan_tabungan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_nasabah` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Selesai',
  PRIMARY KEY (`id_penarikan_tabungan`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_penarikan_tabungan: ~0 rows (approximately)
DELETE FROM `tb_penarikan_tabungan`;
/*!40000 ALTER TABLE `tb_penarikan_tabungan` DISABLE KEYS */;
INSERT INTO `tb_penarikan_tabungan` (`id_penarikan_tabungan`, `id_user`, `id_nasabah`, `tanggal`, `kode`, `jumlah`, `status`) VALUES
	(4, 13, 1, '2024-02-22', 'TRS-202402-0001', 5000, 'Selesai');
/*!40000 ALTER TABLE `tb_penarikan_tabungan` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_pengaturan
CREATE TABLE IF NOT EXISTS `tb_pengaturan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_perusahaan` varchar(200) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_hp` varchar(200) NOT NULL,
  `owner` varchar(200) NOT NULL,
  `logo` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_pengaturan: ~0 rows (approximately)
DELETE FROM `tb_pengaturan`;
/*!40000 ALTER TABLE `tb_pengaturan` DISABLE KEYS */;
INSERT INTO `tb_pengaturan` (`id`, `nama_perusahaan`, `alamat`, `no_hp`, `owner`, `logo`) VALUES
	(1, 'Bank Sampah Desa Kemenuh', 'Desa Kemenuh, Sukawati, Gianyar', '08123456789', 'ABC', '17072023082349.png');
/*!40000 ALTER TABLE `tb_pengaturan` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_pengepul
CREATE TABLE IF NOT EXISTS `tb_pengepul` (
  `id_pengepul` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pengepul` varchar(50) DEFAULT NULL,
  `nama_pengepul` varchar(150) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id_pengepul`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_pengepul: ~0 rows (approximately)
DELETE FROM `tb_pengepul`;
/*!40000 ALTER TABLE `tb_pengepul` DISABLE KEYS */;
INSERT INTO `tb_pengepul` (`id_pengepul`, `kode_pengepul`, `nama_pengepul`, `no_telp`, `status`) VALUES
	(1, 'PN-0001', 'Bang Joni', '08123456789', 1);
/*!40000 ALTER TABLE `tb_pengepul` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_penjualan
CREATE TABLE IF NOT EXISTS `tb_penjualan` (
  `id_penjualan` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_pengepul` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `total_berat` decimal(10,1) DEFAULT NULL,
  `total_harga` double DEFAULT NULL,
  PRIMARY KEY (`id_penjualan`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_penjualan: ~0 rows (approximately)
DELETE FROM `tb_penjualan`;
/*!40000 ALTER TABLE `tb_penjualan` DISABLE KEYS */;
INSERT INTO `tb_penjualan` (`id_penjualan`, `kode`, `tanggal`, `id_pengepul`, `id_user`, `total_berat`, `total_harga`) VALUES
	(2, 'PNS-202402-0001', '2024-02-22', 1, 13, 1.0, 4500),
	(3, 'PNS-202403-0001', '2024-03-02', 1, 1, 4.0, 11500),
	(4, 'PNS-202403-0002', '2024-03-08', 1, 13, 3.0, 12000),
	(5, 'PNS-202403-0003', '2024-03-15', 1, 1, 3.0, 8900);
/*!40000 ALTER TABLE `tb_penjualan` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_penjualan_detail
CREATE TABLE IF NOT EXISTS `tb_penjualan_detail` (
  `id_penjualan_detail` int(11) NOT NULL AUTO_INCREMENT,
  `kode_penjualan` varchar(50) DEFAULT NULL,
  `id_jenis_sampah` int(11) DEFAULT NULL,
  `jenis_sampah` varchar(200) DEFAULT NULL,
  `berat` decimal(10,1) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  PRIMARY KEY (`id_penjualan_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_penjualan_detail: ~7 rows (approximately)
DELETE FROM `tb_penjualan_detail`;
/*!40000 ALTER TABLE `tb_penjualan_detail` DISABLE KEYS */;
INSERT INTO `tb_penjualan_detail` (`id_penjualan_detail`, `kode_penjualan`, `id_jenis_sampah`, `jenis_sampah`, `berat`, `harga`, `subtotal`) VALUES
	(7, 'PNS-202402-0001', 6, 'Gelas Plastik Bening Bersih', 1.0, 4500, 4500),
	(8, 'PNS-202403-0001', 24, 'HVS', 3.0, 3000, 9000),
	(9, 'PNS-202403-0001', 8, 'Besi', 1.0, 2500, 2500),
	(10, 'PNS-202403-0002', 24, 'HVS', 1.0, 3000, 3000),
	(11, 'PNS-202403-0002', 6, 'Gelas Plastik Bening Bersih', 2.0, 4500, 9000),
	(12, 'PNS-202403-0003', 24, 'HVS', 2.0, 3000, 6000),
	(13, 'PNS-202403-0003', 15, 'Kardus A', 1.0, 2900, 2900);
/*!40000 ALTER TABLE `tb_penjualan_detail` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_penjualan_detail_temp
CREATE TABLE IF NOT EXISTS `tb_penjualan_detail_temp` (
  `id_penjualan_detail_temp` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_session` varchar(50) DEFAULT NULL,
  `id_jenis_sampah` int(11) DEFAULT NULL,
  `kode_sampah` varchar(50) DEFAULT NULL,
  `jenis_sampah` varchar(100) DEFAULT NULL,
  `jumlah` decimal(10,1) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  PRIMARY KEY (`id_penjualan_detail_temp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_penjualan_detail_temp: ~0 rows (approximately)
DELETE FROM `tb_penjualan_detail_temp`;
/*!40000 ALTER TABLE `tb_penjualan_detail_temp` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_penjualan_detail_temp` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_tabungan
CREATE TABLE IF NOT EXISTS `tb_tabungan` (
  `id_tabungan` int(11) NOT NULL AUTO_INCREMENT,
  `id_nasabah` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `kode_transaksi` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `kredit` double DEFAULT NULL,
  PRIMARY KEY (`id_tabungan`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_tabungan: ~7 rows (approximately)
DELETE FROM `tb_tabungan`;
/*!40000 ALTER TABLE `tb_tabungan` DISABLE KEYS */;
INSERT INTO `tb_tabungan` (`id_tabungan`, `id_nasabah`, `id_user`, `kode_transaksi`, `tanggal`, `debit`, `kredit`) VALUES
	(1, 2, 13, 'TBS-202402-0001', '2024-02-21', 7000, 0),
	(2, 1, 13, 'TBS-202402-0002', '2024-02-21', 12720, 0),
	(3, 1, 13, 'TBS-202402-0003', '2024-02-22', 3000, 0),
	(4, 1, 13, 'TRS-202402-0001', '2024-02-22', 0, 5000),
	(5, 1, 13, 'TBS-202402-0004', '2024-02-22', 8000, 0),
	(6, 1, 1, 'TBS-202403-0001', '2024-03-02', 6900, 0),
	(7, 2, 1, 'TBS-202403-0002', '2024-03-02', 6000, 0),
	(8, 1, 1, 'TBS-202403-0003', '2024-03-15', 4500, 0),
	(9, 1, 1, 'TBS-202403-0004', '2024-03-25', 1400, 0);
/*!40000 ALTER TABLE `tb_tabungan` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_tabungan_sampah
CREATE TABLE IF NOT EXISTS `tb_tabungan_sampah` (
  `id_tabungan_sampah` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_nasabah` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `total_berat` decimal(10,1) DEFAULT NULL,
  `total_harga` double DEFAULT NULL,
  PRIMARY KEY (`id_tabungan_sampah`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_tabungan_sampah: ~6 rows (approximately)
DELETE FROM `tb_tabungan_sampah`;
/*!40000 ALTER TABLE `tb_tabungan_sampah` DISABLE KEYS */;
INSERT INTO `tb_tabungan_sampah` (`id_tabungan_sampah`, `kode`, `tanggal`, `id_nasabah`, `id_user`, `total_berat`, `total_harga`) VALUES
	(56, 'TBS-202402-0001', '2024-02-21', 2, 13, 5.0, 7000),
	(57, 'TBS-202402-0002', '2024-02-21', 1, 13, 5.4, 12720),
	(58, 'TBS-202402-0003', '2024-02-22', 1, 13, 2.0, 3000),
	(59, 'TBS-202402-0004', '2024-02-22', 1, 13, 2.0, 8000),
	(60, 'TBS-202403-0001', '2024-03-02', 1, 1, 5.0, 6900),
	(61, 'TBS-202403-0002', '2024-03-02', 2, 1, 4.0, 6000),
	(62, 'TBS-202403-0003', '2024-03-15', 1, 1, 3.0, 4500),
	(63, 'TBS-202403-0004', '2024-03-25', 1, 1, 2.0, 1400);
/*!40000 ALTER TABLE `tb_tabungan_sampah` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_tabungan_sampah_detail
CREATE TABLE IF NOT EXISTS `tb_tabungan_sampah_detail` (
  `id_tabungan_sampah_detail` int(11) NOT NULL AUTO_INCREMENT,
  `kode_tabungan_sampah` varchar(50) DEFAULT NULL,
  `id_jenis_sampah` int(11) DEFAULT NULL,
  `jenis_sampah` varchar(200) DEFAULT NULL,
  `berat` decimal(10,1) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  PRIMARY KEY (`id_tabungan_sampah_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_tabungan_sampah_detail: ~8 rows (approximately)
DELETE FROM `tb_tabungan_sampah_detail`;
/*!40000 ALTER TABLE `tb_tabungan_sampah_detail` DISABLE KEYS */;
INSERT INTO `tb_tabungan_sampah_detail` (`id_tabungan_sampah_detail`, `kode_tabungan_sampah`, `id_jenis_sampah`, `jenis_sampah`, `berat`, `harga`, `subtotal`) VALUES
	(184, 'TBS-202402-0001', 7, 'Gelas Plastik Warna', 3.0, 1000, 3000),
	(185, 'TBS-202402-0001', 3, 'PET Bening Biru Bersih', 2.0, 2000, 4000),
	(187, 'TBS-202402-0002', 19, 'Bir Kecil', 2.4, 300, 720),
	(188, 'TBS-202402-0002', 6, 'Gelas Plastik Bening Bersih', 3.0, 4000, 12000),
	(189, 'TBS-202402-0003', 24, 'HVS', 2.0, 1500, 3000),
	(190, 'TBS-202402-0004', 6, 'Gelas Plastik Bening Bersih', 2.0, 4000, 8000),
	(191, 'TBS-202403-0001', 24, 'HVS', 3.0, 1500, 4500),
	(192, 'TBS-202403-0001', 8, 'Besi', 2.0, 1200, 2400),
	(193, 'TBS-202403-0002', 22, 'Jerigen', 2.0, 1500, 3000),
	(194, 'TBS-202403-0002', 15, 'Kardus A', 2.0, 1500, 3000),
	(195, 'TBS-202403-0003', 24, 'HVS', 2.0, 1500, 3000),
	(196, 'TBS-202403-0003', 15, 'Kardus A', 1.0, 1500, 1500),
	(197, 'TBS-202403-0004', 20, 'Duplex', 2.0, 700, 1400);
/*!40000 ALTER TABLE `tb_tabungan_sampah_detail` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_tabungan_sampah_detail_temp
CREATE TABLE IF NOT EXISTS `tb_tabungan_sampah_detail_temp` (
  `id_tabungan_sampah_detail_temp` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_session` varchar(50) DEFAULT NULL,
  `id_nasabah` int(11) DEFAULT NULL,
  `id_jenis_sampah` int(11) DEFAULT NULL,
  `kode_sampah` varchar(50) DEFAULT NULL,
  `jenis_sampah` varchar(100) DEFAULT NULL,
  `jumlah` decimal(10,1) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  PRIMARY KEY (`id_tabungan_sampah_detail_temp`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_tabungan_sampah_detail_temp: ~1 rows (approximately)
DELETE FROM `tb_tabungan_sampah_detail_temp`;
/*!40000 ALTER TABLE `tb_tabungan_sampah_detail_temp` DISABLE KEYS */;
INSERT INTO `tb_tabungan_sampah_detail_temp` (`id_tabungan_sampah_detail_temp`, `id_user`, `id_session`, `id_nasabah`, `id_jenis_sampah`, `kode_sampah`, `jenis_sampah`, `jumlah`, `harga`, `subtotal`) VALUES
	(1, 13, '9e3csu5kkfmeoj79cg3oclvmjo', 0, 24, 'JS-0024', 'HVS', 2.0, 1500, 3000);
/*!40000 ALTER TABLE `tb_tabungan_sampah_detail_temp` ENABLE KEYS */;

-- Dumping structure for table db_bank_sampah_desa_kemenuh.tb_user
CREATE TABLE IF NOT EXISTS `tb_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(10) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table db_bank_sampah_desa_kemenuh.tb_user: ~5 rows (approximately)
DELETE FROM `tb_user`;
/*!40000 ALTER TABLE `tb_user` DISABLE KEYS */;
INSERT INTO `tb_user` (`id_user`, `nama_user`, `jenis_kelamin`, `no_telp`, `username`, `password`, `role`, `status`) VALUES
	(1, 'Admin', 'Wanita', '-', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 1),
	(12, 'Gede Aji', 'Pria', '08123456789', 'gede', '13ad65cc032d4b04927943c33673a65d', 'ketua', 1),
	(13, 'Dayu Inten', 'Wanita', '081234567890', 'dayu', '3987f4d1031cc1a0e2cb11342ee154a6', 'pegawai', 1),
	(14, 'Kadek Murni', 'Wanita', '08123456789', 'kadek', '9bd0a034baadfaddd3a89af39bc4320b', 'LPD', 1),
	(15, 'Komang Murni', 'Wanita', '08123456789', 'komang', '3da015fb8727d60123f0543d2e6a63fa', 'pegawai', 1);
/*!40000 ALTER TABLE `tb_user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
