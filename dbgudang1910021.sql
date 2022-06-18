/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.4.20-MariaDB : Database - dbgudang1910021
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbgudang1910021` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `dbgudang1910021`;

/*Table structure for table `barang1910021` */

DROP TABLE IF EXISTS `barang1910021`;

CREATE TABLE `barang1910021` (
  `brgkode1910021` char(10) NOT NULL,
  `brgnama1910021` varchar(100) NOT NULL,
  `brgkatid1910021` int(10) unsigned NOT NULL,
  `brgsatid1910021` int(10) unsigned NOT NULL,
  `brgharga1910021` double NOT NULL,
  `brggambar1910021` varchar(200) DEFAULT NULL,
  `brgstok1910021` int(11) DEFAULT NULL,
  PRIMARY KEY (`brgkode1910021`),
  KEY `barang1910021_brgkatid1910021_foreign` (`brgkatid1910021`),
  KEY `barang1910021_brgsatid1910021_foreign` (`brgsatid1910021`),
  CONSTRAINT `barang1910021_brgkatid1910021_foreign` FOREIGN KEY (`brgkatid1910021`) REFERENCES `kategori1910021` (`katid1910021`),
  CONSTRAINT `barang1910021_brgsatid1910021_foreign` FOREIGN KEY (`brgsatid1910021`) REFERENCES `satuan1910021` (`satid1910021`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `barang1910021` */

insert  into `barang1910021`(`brgkode1910021`,`brgnama1910021`,`brgkatid1910021`,`brgsatid1910021`,`brgharga1910021`,`brggambar1910021`,`brgstok1910021`) values ('12','Nutriboost',4,1,8000,'',24),('13','Pizza',19,3,10000,'',30),('6747','Plastik',19,3,75000,'upload/6747.jpg',100),('89','Bag',4,5,50000,'upload/89.jpg',30),('90','Sampoo',10,3,900000,'upload/90.jpg',100);

/*Table structure for table `barangkeluar1910021` */

DROP TABLE IF EXISTS `barangkeluar1910021`;

CREATE TABLE `barangkeluar1910021` (
  `faktur1910021` char(20) NOT NULL,
  `tglfaktur1910021` date DEFAULT NULL,
  `idpel1910021` int(11) DEFAULT NULL,
  `totalharga1910021` double DEFAULT NULL,
  `jumlahuang1910021` double DEFAULT NULL,
  `sisauang1910021` double DEFAULT NULL,
  PRIMARY KEY (`faktur1910021`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `barangkeluar1910021` */

insert  into `barangkeluar1910021`(`faktur1910021`,`tglfaktur1910021`,`idpel1910021`,`totalharga1910021`,`jumlahuang1910021`,`sisauang1910021`) values ('0201220003','2022-01-02',8,250000,500000,250000),('0301220001','2022-01-03',0,50000,100000,50000),('0501220001','2022-01-05',5,500000,1000000,500000),('0501220002','2022-01-05',8,400000,500000,100000),('1912210001','2021-12-19',7,100000,200000,50000),('1912210002','2021-12-19',6,550000,500000,250000),('1912210003','2021-12-19',6,100000,150000,50000),('1912210004','2021-12-19',5,40000,500000,460000),('1912210005','2021-12-19',0,150000,250000,100000),('1912210006','2021-12-19',5,50000,100000,50000),('1912210007','2021-12-19',5,10000,100000,90000),('1912210008','2021-12-19',6,10000,100000,90000),('1912210009','2021-12-19',0,20000,100000,80000),('1912210010','2021-12-19',5,50000,100000,50000),('1912210011','2021-12-19',0,10000,100000,90000),('1912210012','2021-12-19',5,250000,500000,250000),('1912210013','2021-12-19',6,150000,200000,50000),('2412210001','2021-12-24',5,500000,4000000,3500000),('2412210002','2021-12-24',5,50000,100000,50000),('2412210003','2021-12-24',5,8000,100000,92000),('2412210004','2021-12-24',8,150000,500000,350000),('2412210005','2021-12-24',0,50000,500000,450000),('2812210001','2021-12-28',0,50000,100000,50000),('2812210002','2021-12-28',0,50000,250000,200000),('2912210001','2021-12-29',0,50000,100000,50000),('2912210002','2021-12-29',0,50000,100000,50000);

/*Table structure for table `barangmasuk1910021` */

DROP TABLE IF EXISTS `barangmasuk1910021`;

CREATE TABLE `barangmasuk1910021` (
  `faktur1910021` char(20) NOT NULL,
  `tglfaktur1910021` date DEFAULT NULL,
  `totalharga1910021` double DEFAULT NULL,
  PRIMARY KEY (`faktur1910021`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `barangmasuk1910021` */

insert  into `barangmasuk1910021`(`faktur1910021`,`tglfaktur1910021`,`totalharga1910021`) values ('F-0002','2021-12-15',150000),('F-003','2021-12-29',500000),('F-11','2022-01-31',40000),('F-12','2022-01-31',4000);

/*Table structure for table `detail_barangkeluar1910021` */

DROP TABLE IF EXISTS `detail_barangkeluar1910021`;

CREATE TABLE `detail_barangkeluar1910021` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `detfaktur1910021` char(20) DEFAULT NULL,
  `detbrgkode1910021` char(10) DEFAULT NULL,
  `dethargajual1910021` double DEFAULT NULL,
  `detjml1910021` int(11) DEFAULT NULL,
  `detsubtotal1910021` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detbrgkode1910021` (`detbrgkode1910021`),
  KEY `detfaktur1910021` (`detfaktur1910021`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

/*Data for the table `detail_barangkeluar1910021` */

insert  into `detail_barangkeluar1910021`(`id`,`detfaktur1910021`,`detbrgkode1910021`,`dethargajual1910021`,`detjml1910021`,`detsubtotal1910021`) values (12,'0612210002','89',50000,5,250000),(13,'0612210002','13',10000,6,60000),(18,'1912210001','13',10000,10,100000),(19,'1912210002','89',50000,5,250000),(20,'1912210003','13',10000,10,100000),(21,'1912210004','12',8000,5,40000),(22,'1912210005','13',10000,5,50000),(23,'1912210005','13',10000,10,100000),(25,'1912210006','13',10000,5,50000),(26,'1912210007','13',10000,1,10000),(27,'1912210008','13',10000,1,10000),(28,'1912210009','13',10000,1,10000),(29,'1912210009','13',10000,1,10000),(30,'1912210010','89',50000,1,50000),(31,'1912210011','13',10000,1,10000),(32,'1912210012','13',10000,20,200000),(33,'1912210012','13',10000,5,50000),(34,'1912210013','13',10000,5,50000),(35,'1912210013','13',10000,10,100000),(36,'1912210002','89',50000,5,250000),(37,'1912210002','89',50000,1,50000),(51,'0201220003','89',50000,5,250000),(52,'0301220001','89',50000,1,50000),(54,'0501220001','89',50000,10,500000),(55,'0501220002','12',8000,50,400000);

/*Table structure for table `detail_barangmasuk1910021` */

DROP TABLE IF EXISTS `detail_barangmasuk1910021`;

CREATE TABLE `detail_barangmasuk1910021` (
  `iddetail1910021` bigint(20) NOT NULL AUTO_INCREMENT,
  `detfaktur1910021` char(20) DEFAULT NULL,
  `detbrgkode1910021` char(10) DEFAULT NULL,
  `dethargamasuk1910021` double DEFAULT NULL,
  `dethargajual1910021` double DEFAULT NULL,
  `detjml1910021` int(11) DEFAULT NULL,
  `detsubtotal1910021` double DEFAULT NULL,
  PRIMARY KEY (`iddetail1910021`),
  KEY `detbrgkode1910021` (`detbrgkode1910021`),
  KEY `detfaktur1910021` (`detfaktur1910021`),
  CONSTRAINT `detail_barangmasuk1910021_ibfk_1` FOREIGN KEY (`detbrgkode1910021`) REFERENCES `barang1910021` (`brgkode1910021`) ON UPDATE CASCADE,
  CONSTRAINT `detail_barangmasuk1910021_ibfk_2` FOREIGN KEY (`detfaktur1910021`) REFERENCES `barangmasuk1910021` (`faktur1910021`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `detail_barangmasuk1910021` */

insert  into `detail_barangmasuk1910021`(`iddetail1910021`,`detfaktur1910021`,`detbrgkode1910021`,`dethargamasuk1910021`,`dethargajual1910021`,`detjml1910021`,`detsubtotal1910021`) values (17,'F-0002','12',15000,8000,10,150000),(18,'F-003','13',25000,10000,20,500000),(20,'F-11','12',20000,8000,2,40000),(21,'F-12','12',2000,8000,2,4000);

/*Table structure for table `kategori1910021` */

DROP TABLE IF EXISTS `kategori1910021`;

CREATE TABLE `kategori1910021` (
  `katid1910021` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `katnama1910021` varchar(50) NOT NULL,
  KEY `katid1910021` (`katid1910021`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `kategori1910021` */

insert  into `kategori1910021`(`katid1910021`,`katnama1910021`) values (4,'Minumann'),(10,'Terserah'),(13,'sepatu'),(19,'Makanan'),(20,'Bagg'),(21,'Honda');

/*Table structure for table `levels1910021` */

DROP TABLE IF EXISTS `levels1910021`;

CREATE TABLE `levels1910021` (
  `levelid1910021` int(11) NOT NULL AUTO_INCREMENT,
  `levelnama1910021` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`levelid1910021`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `levels1910021` */

insert  into `levels1910021`(`levelid1910021`,`levelnama1910021`) values (1,'Admin'),(2,'Kasir'),(3,'Gudang'),(4,'Pimpinan');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`version`,`class`,`group`,`namespace`,`time`,`batch`) values (1,'2021-09-22-043051','App\\Database\\Migrations\\Kategori','default','App',1632285098,1),(2,'2021-09-22-043156','App\\Database\\Migrations\\Satuan','default','App',1632285145,2),(3,'2021-09-22-043236','App\\Database\\Migrations\\Barang','default','App',1632285204,3);

/*Table structure for table `pelanggan1910021` */

DROP TABLE IF EXISTS `pelanggan1910021`;

CREATE TABLE `pelanggan1910021` (
  `pelid1910021` int(11) NOT NULL AUTO_INCREMENT,
  `pelnama1910021` varchar(100) DEFAULT NULL,
  `peltelp1910021` char(20) DEFAULT NULL,
  PRIMARY KEY (`pelid1910021`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `pelanggan1910021` */

insert  into `pelanggan1910021`(`pelid1910021`,`pelnama1910021`,`peltelp1910021`) values (5,'Fazeel','5243'),(6,'Udin','8463'),(7,'Ucok','8475845'),(8,'Boy','08457387543');

/*Table structure for table `satuan1910021` */

DROP TABLE IF EXISTS `satuan1910021`;

CREATE TABLE `satuan1910021` (
  `satid1910021` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `satnama1910021` varchar(50) NOT NULL,
  KEY `satid1910021` (`satid1910021`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `satuan1910021` */

insert  into `satuan1910021`(`satid1910021`,`satnama1910021`) values (1,'Pack'),(3,'Kilo'),(5,'Kg'),(6,'Cm'),(7,'Pcs'),(8,'Dm'),(9,'Uc');

/*Table structure for table `temp_barangkeluar1910021` */

DROP TABLE IF EXISTS `temp_barangkeluar1910021`;

CREATE TABLE `temp_barangkeluar1910021` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `detfaktur1910021` char(20) DEFAULT NULL,
  `detbrgkode1910021` char(10) DEFAULT NULL,
  `dethargajual1910021` double DEFAULT NULL,
  `detjml1910021` int(11) DEFAULT NULL,
  `detsubtotal1910021` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

/*Data for the table `temp_barangkeluar1910021` */

insert  into `temp_barangkeluar1910021`(`id`,`detfaktur1910021`,`detbrgkode1910021`,`dethargajual1910021`,`detjml1910021`,`detsubtotal1910021`) values (47,'2412210001','89',50000,5,250000),(48,'2412210001','89',50000,5,250000),(49,'2412210002','89',50000,1,50000),(50,'2412210003','12',8000,1,8000),(51,'2412210004','89',50000,2,100000),(52,'2412210004','89',50000,1,50000),(53,'2412210005','89',50000,1,50000),(54,'2812210001','89',50000,1,50000),(55,'2812210002','89',50000,1,50000),(56,'2812210002','12',8000,1,8000),(57,'2912210001','13',10000,5,50000),(59,'2912210002','89',50000,1,50000),(60,'0201220001','89',50000,1,50000);

/*Table structure for table `temp_barangmasuk1910021` */

DROP TABLE IF EXISTS `temp_barangmasuk1910021`;

CREATE TABLE `temp_barangmasuk1910021` (
  `iddetail1910021` bigint(20) NOT NULL AUTO_INCREMENT,
  `detfaktur1910021` char(20) DEFAULT NULL,
  `detbrgkode1910021` char(10) DEFAULT NULL,
  `dethargamasuk1910021` double DEFAULT NULL,
  `dethargajual1910021` double DEFAULT NULL,
  `detjml1910021` int(11) DEFAULT NULL,
  `detsubtotal1910021` double DEFAULT NULL,
  PRIMARY KEY (`iddetail1910021`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `temp_barangmasuk1910021` */

/*Table structure for table `users1910021` */

DROP TABLE IF EXISTS `users1910021`;

CREATE TABLE `users1910021` (
  `userid1910021` char(50) NOT NULL,
  `usernama1910021` varchar(100) DEFAULT NULL,
  `userpassword1910021` varchar(100) DEFAULT NULL,
  `userlevelid1910021` int(11) DEFAULT NULL,
  PRIMARY KEY (`userid1910021`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `users1910021` */

insert  into `users1910021`(`userid1910021`,`usernama1910021`,`userpassword1910021`,`userlevelid1910021`) values ('admin','Administrator','$2y$10$Yw9DpCL8yHFi2CwJhwzMGOoKH42sOgLf8hkkVdUwKvmHOtN/HnYGi',1),('gudang','Ajo','$2y$10$Yw9DpCL8yHFi2CwJhwzMGOoKH42sOgLf8hkkVdUwKvmHOtN/HnYGi',3),('kasir','Fazeel','$2y$10$Yw9DpCL8yHFi2CwJhwzMGOoKH42sOgLf8hkkVdUwKvmHOtN/HnYGi',2),('pimpinan','Cugik','$2y$10$Yw9DpCL8yHFi2CwJhwzMGOoKH42sOgLf8hkkVdUwKvmHOtN/HnYGi',4);

/* Trigger structure for table `detail_barangkeluar1910021` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tri_insert_detailBarangKeluar` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tri_insert_detailBarangKeluar` AFTER INSERT ON `detail_barangkeluar1910021` FOR EACH ROW BEGIN
    UPDATE barang1910021 SET brgstok1910021 = brgstok1910021 - new.detjml1910021 WHERE brgkode1910021 = new.detbrgkode1910021;
	END */$$


DELIMITER ;

/* Trigger structure for table `detail_barangkeluar1910021` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tri_update_detailBarangKeluar` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tri_update_detailBarangKeluar` AFTER UPDATE ON `detail_barangkeluar1910021` FOR EACH ROW BEGIN
    UPDATE barang1910021 SET brgstok1910021 = (brgstok1910021 + old.detjml1910021) - new.detjml1910021 WHERE brgkode1910021 = new.detbrgkode1910021;
	END */$$


DELIMITER ;

/* Trigger structure for table `detail_barangkeluar1910021` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tri_delete_detailBarangKeluar` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tri_delete_detailBarangKeluar` AFTER DELETE ON `detail_barangkeluar1910021` FOR EACH ROW BEGIN
    UPDATE barang1910021 SET brgstok1910021 = brgstok1910021 + old.detjml1910021 WHERE brgkode1910021 = old.detbrgkode1910021;
	END */$$


DELIMITER ;

/* Trigger structure for table `detail_barangmasuk1910021` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tri_tambah_stok_barang` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tri_tambah_stok_barang` AFTER INSERT ON `detail_barangmasuk1910021` FOR EACH ROW BEGIN
	Update barang1910021 set barang1910021.`brgstok1910021` = barang1910021.`brgstok1910021` + new.detjml1910021 where barang1910021.`brgkode1910021`=new.detbrgkode1910021;
    END */$$


DELIMITER ;

/* Trigger structure for table `detail_barangmasuk1910021` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tri_update_stok_barang` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tri_update_stok_barang` AFTER UPDATE ON `detail_barangmasuk1910021` FOR EACH ROW BEGIN
	UPDATE `barang1910021` SET brgstok1910021 = (brgstok1910021 - old.detjml1910021) + new.detjml1910021 WHERE brgkode1910021 = new.detbrgkode1910021;
    END */$$


DELIMITER ;

/* Trigger structure for table `detail_barangmasuk1910021` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tri_kurangi_stok_barang` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tri_kurangi_stok_barang` AFTER DELETE ON `detail_barangmasuk1910021` FOR EACH ROW BEGIN
	update barang1910021 set brgstok1910021	= `brgstok1910021` - old.detjml1910021 where brgkode1910021 = old.detbrgkode1910021;
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
