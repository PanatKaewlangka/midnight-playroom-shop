-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: mysql    Database: laravel
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-admin@gmail.com|172.21.0.1','i:1;',1760303659),('laravel-cache-admin@gmail.com|172.21.0.1:timer','i:1760303659;',1760303659),('laravel-cache-new.admin@test.com|172.21.0.1','i:1;',1760304562),('laravel-cache-new.admin@test.com|172.21.0.1:timer','i:1760304562;',1760304562);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `category_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Cure'),(4,'Disruptive'),(5,'Evil'),(3,'Playful'),(2,'Protective');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_10_11_173731_create_categories_table',1),(5,'2025_10_11_173738_create_products_table',1),(6,'2025_10_11_173744_create_reviews_table',1),(7,'2025_10_11_173750_create_orders_table',1),(8,'2025_10_11_173757_create_order_items_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `order_item_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `price_at_purchase` decimal(8,2) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (2,5,4,1,999.00),(3,6,4,1,999.00),(6,7,4,3,999.00),(9,8,25,1,1739.00),(10,8,24,1,2668.00),(11,8,23,1,9173.00),(12,8,21,1,14741.00),(13,9,16,3,28485.00),(14,10,16,1,28485.00),(15,10,25,1,1739.00),(16,11,22,1,35958.00),(17,11,14,1,8486.00),(18,12,25,1,1739.00),(19,12,24,1,2668.00),(20,12,23,1,9173.00),(21,13,25,9,1739.00),(22,14,25,4,1739.00),(23,14,24,3,2668.00),(24,15,16,4,28485.00),(25,15,12,1,2286.00),(26,16,25,1,1739.00),(27,16,23,1,9173.00),(28,16,22,1,35958.00),(29,17,25,4,1739.00),(30,17,22,1,35958.00),(31,17,16,1,28485.00),(32,18,25,2,1739.00),(33,18,17,1,16972.00),(34,19,18,1,5550.00),(35,19,21,2,14741.00),(36,19,17,1,16972.00),(37,20,19,3,5091.00),(38,20,24,1,2668.00),(39,21,23,3,9173.00),(40,21,20,2,4511.00);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `order_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_address_snapshot` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (5,3,'COMPLETED',1198.96,'{\"name\":\"admin1\",\"address\":\"g\",\"phone\":\"g\"}','2025-10-12 23:02:34','2025-10-12 23:05:39'),(6,3,'COMPLETED',1068.98,'{\"name\":\"admin1\",\"address\":\"\\u0e14\",\"phone\":\"\\u0e49\\u0e14\",\"email\":\"admin1@gmail.com\"}','2025-10-12 23:09:28','2025-10-12 23:09:37'),(7,3,'COMPLETED',3066.98,'{\"name\":\"admin1\",\"address\":\"we\",\"phone\":\"f\",\"email\":\"admin1@gmail.com\"}','2025-10-13 16:12:14','2025-10-13 18:19:10'),(8,3,'COMPLETED',28321.00,'{\"name\":\"admin1\",\"address\":\"\\u0e40\",\"phone\":\"\\u0e40\",\"email\":\"admin1@gmail.com\"}','2025-10-13 22:16:12','2025-10-13 22:16:17'),(9,3,'COMPLETED',85455.00,'{\"name\":\"admin1\",\"address\":\"trg v5w4\",\"phone\":\"543 v\",\"email\":\"admin1@gmail.com\"}','2025-10-15 05:49:15','2025-10-15 05:49:41'),(10,3,'COMPLETED',30224.00,'{\"name\":\"admin1\",\"address\":\"\\u0e1a\\u0e49\\u0e32\\u0e19\\u0e19\\u0e2d\\u0e01\",\"phone\":\"000000000\",\"email\":\"admin1@gmail.com\"}','2025-10-16 12:52:48','2025-10-16 12:57:46'),(11,5,'COMPLETED',44444.00,'{\"name\":\"panita\",\"address\":\"\\u0e43\\u0e19\\u0e14\\u0e34\\u0e19\",\"phone\":\"00000\",\"email\":\"panita@test.com\"}','2025-10-16 12:57:02','2025-10-16 12:57:12'),(12,3,'COMPLETED',13580.00,'{\"name\":\"admin1\",\"address\":\"\\u0e2b\\u0e1f\\u0e1c\",\"phone\":\"\\u0e34\\u0e40\",\"email\":\"admin1@gmail.com\"}','2025-10-16 13:26:15','2025-10-16 13:26:18'),(13,3,'COMPLETED',15651.00,'{\"name\":\"admin1\",\"address\":\"\\u0e33\\u0e1e\\u0e49\",\"phone\":\"\\u0e01\\u0e1e\\u0e49\\u0e49\",\"email\":\"admin1@gmail.com\"}','2025-10-16 13:27:31','2025-10-16 13:27:33'),(14,3,'COMPLETED',14960.00,'{\"name\":\"admin1\",\"address\":\"\\u0e14\",\"phone\":\"\\u0e14\",\"email\":\"admin1@gmail.com\"}','2025-10-18 18:14:06','2025-10-18 18:14:51'),(15,3,'COMPLETED',116226.00,'{\"name\":\"admin1\",\"address\":\"\\u0e40\",\"phone\":\"\\u0e40\",\"email\":\"admin1@gmail.com\"}','2025-10-18 18:14:45','2025-10-18 18:14:46'),(16,5,'COMPLETED',46870.00,'{\"name\":\"panita\",\"address\":\"wg\",\"phone\":\"r3ff\",\"email\":\"panita@test.com\"}','2025-10-18 18:50:17','2025-10-18 18:50:21'),(17,3,'COMPLETED',71399.00,'{\"name\":\"admin1\",\"address\":\"yf7iy\",\"phone\":\"0885\",\"email\":\"admin1@gmail.com\"}','2025-10-20 13:57:03','2025-10-20 13:57:07'),(18,3,'COMPLETED',20450.00,'{\"name\":\"admin1\",\"address\":\"67tk\",\"phone\":\"67\",\"email\":\"admin1@gmail.com\"}','2025-10-24 10:07:24','2025-10-24 10:07:29'),(19,7,'COMPLETED',52004.00,'{\"name\":\"costomer1\",\"address\":\"my home\",\"phone\":\"111111111111\",\"email\":\"costomer1@test.com\"}','2025-10-31 10:46:04','2025-10-31 10:46:27'),(20,8,'COMPLETED',17941.00,'{\"name\":\"customer2\",\"address\":\"home\",\"phone\":\"111111111\",\"email\":\"costomer2@test.com\"}','2025-10-31 11:26:28','2025-10-31 11:26:44'),(21,8,'COMPLETED',36541.00,'{\"name\":\"customer2\",\"address\":\"home\",\"phone\":\"111111111\",\"email\":\"costomer2@test.com\"}','2025-10-31 11:41:35','2025-10-31 11:41:51');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `product_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `stock_quantity` int NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (4,5,'Annabelle','HEEYAI้',999.00,11,'/images/products/Annabelle.png','2025-10-12 22:01:50','2025-10-31 11:44:18'),(6,3,'Soul Daria Haunted Doll','Daria is a doll with beautiful, curly blonde hair, and captivating brown eyes. She is haunted by a 34-year-old friendly soul, that loves nature and animal. She is beginner-friendly',1952.00,10,'/images/products/Soul Daria Haunted Doll.png','2025-10-13 17:54:47','2025-10-13 17:54:47'),(7,4,'Evangeline Hartwell - the Neutral Spirit Doll','Evangeline is a doll with curly, dirty blonde hair, and light blue eyes. She is haunted by a neutral spirit, who misses her life. So, she tends to find ways to live her life again, even if it bothers her owner.',2568.00,10,'/images/products/Evangeline Hartwell.png','2025-10-13 18:28:20','2025-10-13 18:28:20'),(8,1,'Liesel  - the Haunted Doll','Liesel is a doll with straight, shiny brown hair, and heterochromia eyes, one brown and one blue. She is haunted by a positive German spirit, whose main ability is healing. She is beginner-friendly.',3938.00,10,'/images/products/Liesel  - the Haunted Doll.png','2025-10-13 18:43:08','2025-10-13 18:43:08'),(9,3,'Adam, Haunted Clown Doll','Adam is a doll with straight, platinum blond hair, and blue eyes. He is dressed in a clown suit, with the signature red nose. He is haunted by a gentle, positive spirit, who aims to make everyone happy with his presence.',5550.00,10,'/images/products/Adam, Haunted Clown Doll.png','2025-10-13 19:34:06','2025-10-13 19:34:06'),(10,5,'Viv, the Changeling Haunted Doll','Viv is a doll with beautifully done curly, blonde hair, and bright pink eyes. She is from 1990s and is dressed according to a vintage era. She is haunted by a changeling spirit, similar to fae.',8732.00,10,'/images/products/Viv, the Changeling Haunted Doll.png','2025-10-13 19:43:43','2025-10-13 19:43:43'),(11,2,'Ernie - the Haunted Doll','Ernie is a bald doll with thick, black facial hair. He has abnormally large hands and a sad-looking face. He is haunted by a spirite of a 40-50 years old man. He is kind and protective soul.',2226.00,10,'/images/products/Ernie - the Haunted Doll.png','2025-10-13 19:49:02','2025-10-13 19:52:50'),(12,4,'Katerina - Spirit Haunted Doll','Katerina is a doll with curly, red hair and green eyes. She is haunted by a 39-year-old soul, who is a neutral soul that comes and goes as she pleases.',2286.00,9,'/images/products/Katerina - Spirit Haunted Doll.png','2025-10-13 20:34:05','2025-10-18 18:14:45'),(13,1,'Faith, the Vintage Haunted Porcelain Doll','Faith is a porcelain doll with blonde hair and blue eyes. She is haunted by a kind and fragile soul of a 14-year-old girl, whose life ended due to a heart condition. She aims to heal others with all she got.',4128.00,10,'/images/products/Faith, the Vintage Haunted Porcelain Doll.png','2025-10-13 20:38:39','2025-10-13 20:38:39'),(14,4,'The Twins Haunted Doll','The twin dolls have blond hair with dimmed blue eyes. Their names are Elsa and Edie. They are inseparable, even their heads are always turned toward each other. They are a non-frightening, but still firm spirits.',8486.00,10,'/images/products/The Twins Haunted Doll.png','2025-10-13 20:42:35','2025-10-13 20:42:35'),(15,2,'Greta, Haunted German Bisque Doll','Greta is a doll with short brown hair and blue eyes. She is haunted by a \'Dream Listener\' spirit, which is a spirit attuned to emotion, memory, and sound. She often protect people around her with her ability.',6651.00,10,'/images/products/Greta, Haunted German Bisque Doll.png','2025-10-13 20:53:57','2025-10-13 20:53:57'),(16,2,'Thai Princess Luk Thep','This Thai Princess Luk Thep is a doll with beautiful, charming face, decorated by platinum blonde with blue highlights hair, blue eyes, and make up. She is haunted by a sweet spirit, who is a guardian to whoever owns her.',28485.00,5,'/images/products/Thai Princess Luk Thep.png','2025-10-13 20:56:20','2025-10-20 13:57:03'),(17,1,'Dragon Lover Luk Thep','This Dragon Lover Luk Thep is a doll with brown hair and sparkly brown eyes. She is haunted by a joyful and curious spirit, who loves dragon. She hopes to one day find a forever home, and heal them whenever needed.',16972.00,8,'/images/products/Dragon Lover Luk Thep.png','2025-10-13 21:01:55','2025-10-31 10:46:04'),(18,4,'Abby - the Haunted Doll','Abby is a doll with nicely curled brown hair and blue eyes. She is haunted by a lingering soul of a young woman from the 1970s. She is a neutral spirit, whose actions depend on how well you treat her.',5550.00,9,'/images/products/Abby - the Haunted Doll.png','2025-10-13 21:03:32','2025-10-31 10:46:04'),(19,3,'Mei Lee, the Chinese-Canadian Haunted Doll','Mei Lee is a doll with predominantly asian features, containing brown hair, put up in space buns, and brown eyes. She is haunted by a soul of a 14-year-old Hong Kong girl, who is friendly.',5091.00,7,'/images/products/Mei Lee, the Chinese-Canadian Haunted Doll.png','2025-10-13 21:05:24','2025-10-31 11:26:28'),(20,5,'Margaret - the Haunted Doll','Margaret is a doll with curled blonde hair and green eyes. She is wearing a period dress and a hat. She is haunted by a vengeful spirit, who will do whatever it takes to bring hell to Earth.',4511.00,8,'/images/products/Margaret - the Haunted Doll.png','2025-10-13 21:06:50','2025-10-31 11:41:35'),(21,3,'Isabella - the Elegant Haunted Doll','Isabella is a doll with dark curly hair and blue eyes. She is haunted by a spirit from the 1800s, who excudes mystery and elegance. She tends to play with toddlers, and children.',14741.00,8,'/images/products/Isabella - the Elegant Haunted Doll.png','2025-10-13 21:09:01','2025-10-31 10:46:04'),(22,1,'Monroe, Tucanian Starseed/Crystal Healer Haunted Doll','Monroe is a ball-jointed doll with platinum blonde hair with pink and purple highlights and pink-ish eyes. She is haunted by a mesmerizing and healing soul. She is beginner-friendly.',35958.00,8,'/images/products/Monroe, Tucanian Starseed.png','2025-10-13 21:11:24','2025-10-20 13:57:03'),(23,5,'Mary and Richard, the Raggedy Ann and Andy Haunted Dolls','Mary and Richard\'s souls reside in a Raggedy Ann and a Raggedy Andy dolls. They are a bonded pair, who found their way back to each other in death after a brief separation in life. And they will make sure that no one will be as happy as they are.',9173.00,5,'/images/products/Mary and Richard, the Raggedy Ann and Andy Haunted Dolls.png','2025-10-13 21:16:15','2025-10-31 11:41:35'),(24,2,'Jess, the Rare Clown Haunted Doll','Jess is a clown haunted doll with super curly white hair and brown eyes. He is haunted by a fun and nice soul, who brings harmony and protection into your home.',2668.00,5,'/images/products/Jess, the Rare Clown Haunted Doll.png','2025-10-13 21:17:29','2025-10-31 11:26:28'),(25,5,'Elizabeth, the Haunted Teddy Bear','Elizabeth is a haunted stuffed animal in the form of a teddy bear. She is wearing a nurse attire to simulate the nurse of the Great War soul that resides in her. She will force the Great War trauma to anyone who comes within her reach.',1739.00,11,'/images/products/Elizabeth, the Haunted Teddy Bear.png','2025-10-13 21:19:58','2025-10-24 10:28:34');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `review_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `rating` tinyint NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`review_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,3,4,5,'เย้ภะำewbagzjvk','2025-10-12 23:19:14','2025-10-13 16:12:26'),(2,3,16,5,'มีแล้วรู้สึกไม่โดนผีอำอีก น้องใช้ดีมากค่า','2025-10-15 05:50:01','2025-10-16 12:49:35'),(3,5,23,5,'I use them to kill my ex.','2025-10-18 18:50:59','2025-10-18 18:50:59'),(4,3,25,5,'50734','2025-10-20 13:57:23','2025-10-20 13:57:23'),(5,3,17,4,'gu45sbyq54','2025-10-24 10:07:42','2025-10-24 10:07:42'),(6,7,21,5,'I love you','2025-10-31 10:46:38','2025-10-31 10:46:38'),(7,8,24,4,'good','2025-10-31 11:26:57','2025-10-31 11:26:57'),(8,3,24,2,'6y5','2025-10-31 11:30:29','2025-10-31 11:30:29'),(9,8,23,4,'555','2025-10-31 11:42:15','2025-10-31 11:42:15');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('gS7uPxN7dy3WRVd3FJSwNpfhA95w7jnOw5FKhSpj',3,'172.21.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWFNLSWx2QlVKUUJpQU1KbjRJT0o2Q0xJVXBnR053emkzUjFTNkE1aiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9sb2NhbGhvc3QvcHJvZHVjdHMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc2MTkxMDk1Njt9fQ==',1761911086);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CUSTOMER',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@gmail.com',NULL,'$2y$12$g6BMhcN2cUhncHgB.Y2kIejHOypKYyXyPtGXHUMCcjvEoGnxqM7Le','CUSTOMER',NULL,'2025-10-12 21:13:49','2025-10-12 21:13:49'),(2,'f','f@g.l',NULL,'$2y$12$7exdnmpIKh5fqPlxSJpwouLbvJhQWLJPI0cgTCmIUX90Kq8ZzQF.a','CUSTOMER',NULL,'2025-10-12 21:27:55','2025-10-12 21:27:55'),(3,'admin1','admin1@gmail.com',NULL,'$2y$12$iz/lQ..sY8SlHrklodGao.EZvhTGVngiid36VCeC9hVwCzTuBB.3i','admin',NULL,'2025-10-12 21:36:18','2025-10-12 21:36:18'),(4,'user1','user1@gmail.com',NULL,'$2y$12$F9mDocKM76AoXO9PdKzvneFn3S5e3DWq/gLIF3ujV8yfZahu3ZDne','CUSTOMER',NULL,'2025-10-12 23:57:57','2025-10-12 23:57:57'),(5,'panita','panita@test.com',NULL,'$2y$12$SWis7homFnldHS780zH1Wu95apfYLhdAZGx.iIYrnHWL4nqW0Xc.a','CUSTOMER',NULL,'2025-10-16 12:38:16','2025-10-16 12:38:16'),(6,'faii','faii@test.com',NULL,'$2y$12$So.YGJermIHQxcd.4Rxd7eTMZCqaUni57Av2DyslqwQY0mKNbiAq.','CUSTOMER',NULL,'2025-10-24 10:43:35','2025-10-24 10:43:35'),(7,'costomer1','costomer1@test.com',NULL,'$2y$12$Gcz2W.dzkUPdJcMntVHw2.jrCdl5LhBs4OGy7AKZc8PUrSlEo6d9a','CUSTOMER',NULL,'2025-10-31 10:43:43','2025-10-31 10:43:43'),(8,'customer2','costomer2@test.com',NULL,'$2y$12$oayb1oTDq51Tgeka2UJ8f.g8DC2ueYX7AZsEnc6uYPebiKeJJM8Ly','CUSTOMER',NULL,'2025-10-31 11:23:43','2025-10-31 11:23:43');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-31 14:42:33
