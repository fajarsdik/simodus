# Host: localhost  (Version 5.5.5-10.1.25-MariaDB)
# Date: 2018-03-16 22:33:28
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "tbl_aktivasi"
#

DROP TABLE IF EXISTS `tbl_aktivasi`;
CREATE TABLE `tbl_aktivasi` (
  `id_meter` int(11) NOT NULL AUTO_INCREMENT,
  `no_dummy` varchar(50) DEFAULT NULL,
  `no_meter_rusak` varchar(50) DEFAULT NULL,
  `merk_meter_rusak` varchar(50) DEFAULT NULL,
  `no_meter_baru` varchar(50) DEFAULT NULL,
  `merk_meter_baru` varchar(50) DEFAULT NULL,
  `id_pelanggan` varchar(50) DEFAULT NULL,
  `tgl_aktivasi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `nama` varchar(50) DEFAULT NULL,
  `id_user` tinyint(2) DEFAULT NULL,
  `unit` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_meter`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_aktivasi"
#


#
# Structure for table "tbl_instansi"
#

DROP TABLE IF EXISTS `tbl_instansi`;
CREATE TABLE `tbl_instansi` (
  `id_instansi` tinyint(1) NOT NULL,
  `institusi` varchar(150) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `website` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `logo` varchar(250) NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_instansi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

#
# Data for table "tbl_instansi"
#

INSERT INTO `tbl_instansi` VALUES (1,'PT. PLN','PT. PLN (Persero) Area Tanjungpinang','Smart, Excellent and The Winner!!','http://www.pln.co.id','fajar.sidik2@pln.co.id','logo.jpg',1);

#
# Structure for table "tbl_metdum"
#

DROP TABLE IF EXISTS `tbl_metdum`;
CREATE TABLE `tbl_metdum` (
  `id_rec` int(11) NOT NULL AUTO_INCREMENT,
  `no_dummy` varchar(15) DEFAULT NULL,
  `merk_meter_rusak` varchar(15) DEFAULT NULL,
  `no_meter_rusak` varchar(25) DEFAULT NULL,
  `alasan_rusak` varchar(200) DEFAULT NULL,
  `tgl_pakai` datetime DEFAULT NULL,
  `ptgs_pasang` varchar(50) DEFAULT NULL,
  `sisa_pulsa` float(10,2) DEFAULT NULL,
  `no_hp_plg` varchar(25) DEFAULT NULL,
  `stand_pakai` float(10,2) DEFAULT NULL,
  `no_meter_baru` varchar(25) DEFAULT NULL,
  `idpel` varchar(25) DEFAULT NULL,
  `tgl_aktivasi` datetime DEFAULT NULL,
  `lokasi_posko` varchar(50) DEFAULT NULL,
  `nama_cc` varchar(50) DEFAULT NULL,
  `stand_kembali` float(10,2) DEFAULT NULL,
  `tgl_kembali` datetime DEFAULT NULL,
  `status_aktivasi` varchar(25) DEFAULT NULL,
  `status_kembali` varchar(25) DEFAULT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `id_user` tinyint(2) DEFAULT NULL,
  `unit` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_rec`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "tbl_metdum"
#


#
# Structure for table "tbl_metdum_jml"
#

DROP TABLE IF EXISTS `tbl_metdum_jml`;
CREATE TABLE `tbl_metdum_jml` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(50) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_metdum_jml"
#

INSERT INTO `tbl_metdum_jml` VALUES (1,'18301',50);

#
# Structure for table "tbl_metdum_kbl"
#

DROP TABLE IF EXISTS `tbl_metdum_kbl`;
CREATE TABLE `tbl_metdum_kbl` (
  `id_meter` int(11) NOT NULL AUTO_INCREMENT,
  `no_dummy` varchar(50) NOT NULL DEFAULT '',
  `lokasi_posko` varchar(50) NOT NULL DEFAULT '',
  `nama_cc` varchar(50) NOT NULL DEFAULT '',
  `stand` float(10,2) NOT NULL DEFAULT '0.00',
  `tgl_kembali` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nama` varchar(50) NOT NULL DEFAULT '0',
  `id_user` tinyint(2) NOT NULL DEFAULT '0',
  `unit` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_meter`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_metdum_kbl"
#


#
# Structure for table "tbl_metdum_pakai"
#

DROP TABLE IF EXISTS `tbl_metdum_pakai`;
CREATE TABLE `tbl_metdum_pakai` (
  `id_meter` int(11) NOT NULL AUTO_INCREMENT,
  `no_dummy` varchar(50) NOT NULL DEFAULT '',
  `no_meter_rusak` varchar(50) NOT NULL DEFAULT '',
  `merk_meter_rusak` varchar(15) DEFAULT NULL,
  `alasan_rusak` varchar(10) DEFAULT NULL,
  `tgl_pakai` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ptgs_pasang` varchar(50) NOT NULL DEFAULT '',
  `sisa_pulsa` float(10,2) NOT NULL DEFAULT '0.00',
  `no_hp_plg` varchar(50) NOT NULL DEFAULT '',
  `std_dummy` float(10,2) NOT NULL DEFAULT '0.00',
  `aktivasi` varchar(25) DEFAULT NULL,
  `kembali` varchar(20) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `id_user` tinyint(2) DEFAULT NULL,
  `unit` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_meter`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_metdum_pakai"
#


#
# Structure for table "tbl_metdum_stok"
#

DROP TABLE IF EXISTS `tbl_metdum_stok`;
CREATE TABLE `tbl_metdum_stok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_dummy` int(11) NOT NULL DEFAULT '0',
  `unit` varchar(10) DEFAULT NULL,
  `tgl_pakai` datetime DEFAULT NULL,
  `tgl_aktivasi` datetime DEFAULT NULL,
  `tgl_kembali` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `no_meter_rusak` varchar(25) DEFAULT NULL,
  `posko` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_metdum_stok"
#

INSERT INTO `tbl_metdum_stok` VALUES (1,1,'18301','2018-03-16 22:32:34',NULL,NULL,'','23123',''),(2,2,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(3,3,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(4,4,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(5,5,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(6,6,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(7,7,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(8,8,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(9,9,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(10,10,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(11,11,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(12,12,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(13,13,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(14,14,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(15,15,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(16,16,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(17,17,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(18,18,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(19,19,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(20,20,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(21,21,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(22,22,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(23,23,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(24,24,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(25,25,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(26,26,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(27,27,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(28,28,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(29,29,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(30,30,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(31,31,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(32,32,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(33,33,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(34,34,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(35,35,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(36,36,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(37,37,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(38,38,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(39,39,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(40,40,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(41,41,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(42,42,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(43,43,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(44,44,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(45,45,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(46,46,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(47,47,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(48,48,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(49,49,'18301',NULL,NULL,NULL,'ready',NULL,NULL),(50,50,'18301',NULL,NULL,NULL,'ready',NULL,NULL);

#
# Structure for table "tbl_sett"
#

DROP TABLE IF EXISTS `tbl_sett`;
CREATE TABLE `tbl_sett` (
  `id_sett` tinyint(1) NOT NULL,
  `metdum_kbl` tinyint(2) NOT NULL DEFAULT '0',
  `metdum_pakai` tinyint(2) NOT NULL DEFAULT '0',
  `aktivasi` tinyint(2) DEFAULT NULL,
  `dft_aktivasi` tinyint(2) DEFAULT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_sett`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

#
# Data for table "tbl_sett"
#

INSERT INTO `tbl_sett` VALUES (1,10,10,5,5,1);

#
# Structure for table "tbl_user"
#

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id_user` tinyint(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `nip` varchar(25) NOT NULL,
  `unit` varchar(25) NOT NULL DEFAULT '',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

#
# Data for table "tbl_user"
#

INSERT INTO `tbl_user` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','Super Admin','-','18',1),(5,'admin_area','e10adc3949ba59abbe56e057f20f883e','Admin Area','123456','183',2),(6,'admin_rayon','e10adc3949ba59abbe56e057f20f883e','Admin Rayon','123456','18301',3),(7,'aktivasi','e10adc3949ba59abbe56e057f20f883e','Admin Aktivasi','123456','18301',4),(8,'posko','e10adc3949ba59abbe56e057f20f883e','Admin Posko','123456321','18301',5);
