# Host: localhost  (Version 5.5.5-10.1.34-MariaDB)
# Date: 2018-12-22 22:06:15
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "absensi"
#

DROP TABLE IF EXISTS `absensi`;
CREATE TABLE `absensi` (
  `absId` int(11) NOT NULL AUTO_INCREMENT,
  `karId` int(11) NOT NULL DEFAULT '0',
  `absTglAbsen` date NOT NULL,
  `absJamAbsen` time NOT NULL,
  `absStatusAbsen` varchar(30) NOT NULL,
  PRIMARY KEY (`absId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "absensi"
#

INSERT INTO `absensi` VALUES (1,1,'0000-00-00','00:00:00','1');

#
# Structure for table "karyawan"
#

DROP TABLE IF EXISTS `karyawan`;
CREATE TABLE `karyawan` (
  `karId` int(11) NOT NULL AUTO_INCREMENT,
  `karNomorKaryawan` int(11) NOT NULL,
  `karNama` varchar(30) NOT NULL,
  `karBidang` varchar(30) NOT NULL,
  `karUsername` varchar(30) NOT NULL,
  `karPassword` varchar(100) NOT NULL,
  PRIMARY KEY (`karId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "karyawan"
#

INSERT INTO `karyawan` VALUES (1,112233,'Gary Aldo','Support','gary.aldo','ggaa');
