-- --------------------------------------------------------
-- Strežnik:                     127.0.0.1
-- Verzija strežnika:            8.0.30 - MySQL Community Server - GPL
-- Operacijski sistem strežnika: Win64
-- HeidiSQL Različica:           12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping database structure for vaja2
CREATE DATABASE IF NOT EXISTS `vaja2` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `vaja2`;

-- Dumping structure for tabela vaja2.ads
CREATE TABLE IF NOT EXISTS `ads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `user_id` int NOT NULL,
  `image` longblob NOT NULL,
  `date` datetime DEFAULT NULL,
  `categories_id` int NOT NULL,
  `viewsCount` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_slovenian_ci;

-- Data exporting was unselected.

-- Dumping structure for tabela vaja2.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kategorija` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_slovenian_ci;

-- Data exporting was unselected.

-- Dumping structure for tabela vaja2.images
CREATE TABLE IF NOT EXISTS `images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ad_id` int DEFAULT NULL,
  `image` longblob,
  `isMain` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_slovenian_ci;

-- Data exporting was unselected.

-- Dumping structure for tabela vaja2.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `password` text CHARACTER SET utf8mb3 COLLATE utf8mb3_slovenian_ci NOT NULL,
  `naslov` text COLLATE utf8mb3_slovenian_ci,
  `posta` text COLLATE utf8mb3_slovenian_ci,
  `telefon` text COLLATE utf8mb3_slovenian_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_slovenian_ci;

-- Data exporting was unselected.

-- Dumping structure for tabela vaja2.views
CREATE TABLE IF NOT EXISTS `views` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `ad_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_slovenian_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
