/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) unsigned DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reservation_id` bigint(20) unsigned NOT NULL,
  `queue_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('scheduled','completed','no_show') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled',
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_reservation_id_foreign` (`reservation_id`),
  CONSTRAINT `appointments_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `daily_patient_capacity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `daily_patient_capacity` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `am_capacity` int(11) NOT NULL,
  `pm_capacity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `daily_patient_capacity_date_unique` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `footers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `footers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `medical_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medical_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned NOT NULL,
  `condition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosed_date` date NOT NULL,
  `treatment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medical_history_patient_id_foreign` (`patient_id`),
  CONSTRAINT `medical_history_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `age` tinyint(3) unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patients_user_id_foreign` (`user_id`),
  CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `prescriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prescriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned NOT NULL,
  `provider_id` bigint(20) unsigned NOT NULL,
  `medicines` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`medicines`)),
  `quantities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`quantities`)),
  `dosages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`dosages`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prescriptions_patient_id_foreign` (`patient_id`),
  KEY `prescriptions_provider_id_foreign` (`provider_id`),
  CONSTRAINT `prescriptions_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  CONSTRAINT `prescriptions_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `unit_type_id` bigint(20) unsigned NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `buying_price` decimal(8,2) NOT NULL,
  `selling_price` decimal(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `minimum_stock` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_unit_type_id_foreign` (`unit_type_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `products_unit_type_id_foreign` FOREIGN KEY (`unit_type_id`) REFERENCES `unit_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `providers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `providers_user_id_foreign` (`user_id`),
  CONSTRAINT `providers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `provinces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provinces` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `province_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `psgc_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned NOT NULL,
  `service_id` bigint(20) unsigned NOT NULL,
  `current_condition` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferred_schedule` enum('AM','PM') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','declined') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `queue_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservations_patient_id_foreign` (`patient_id`),
  KEY `reservations_service_id_foreign` (`service_id`),
  CONSTRAINT `reservations_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservations_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `social_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `transaction_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_time_of_sale` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_details_transaction_id_foreign` (`transaction_id`),
  KEY `transaction_details_product_id_foreign` (`product_id`),
  CONSTRAINT `transaction_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_transaction_code_unique` (`transaction_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `unit_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `profile` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
NSERT INTO `categories` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (1,'Prosthodontic','Restoration and replacement of missing teeth.',1,'2024-12-03 11:27:15','2025-01-17 06:17:00');
INSERT INTO `categories` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (2,'Surgical','Non neque laudantium',1,'2024-12-03 11:27:26','2025-01-18 17:21:38');
INSERT INTO `categories` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (3,'Oral Prophylaxis','Cleaning and maintenance of oral health.',1,'2024-12-03 11:27:37','2024-12-03 11:47:40');
INSERT INTO `categories` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (4,'Restorative','Repair and restoration of tooth structure.',1,'2024-12-03 11:27:49','2024-12-03 11:47:44');
INSERT INTO `categories` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (5,'Orthodontics','Alignment and correction of teeth and jaws.',1,'2024-12-03 11:45:16','2024-12-03 11:47:48');

INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (1,'Piece','pc',1,'2024-12-03 11:28:24','2024-12-03 11:30:13');
INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (2,'Tube','tub',1,'2024-12-03 11:28:39','2025-01-18 17:25:41');
INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (3,'Grams','g',1,'2024-12-03 11:29:18','2024-12-03 11:29:18');
INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (4,'Milliliters','ml',1,'2024-12-03 11:31:15','2024-12-03 11:31:15');
INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (5,'Vial','vial',1,'2024-12-03 11:31:33','2024-12-03 11:31:33');
INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (6,'Roll','role',1,'2024-12-03 11:31:55','2024-12-03 11:31:55');
INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (7,'Set','set',1,'2024-12-03 11:32:05','2024-12-03 11:32:05');

INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (1,'Tropical Gin (Alginate)',1,3,'Impression material for molds.',109,385.00,500.00,1,'2024-12-03 11:33:42','2025-02-04 15:02:40',110);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (2,'Impression Tray',1,1,'Holds material for dental impressions.',92,75.00,100.00,1,'2024-12-03 11:34:38','2025-02-19 05:31:33',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (3,'Lidocaine Ointment',2,2,'Numbs soft tissues.',121,450.00,500.00,1,'2024-12-03 11:35:35','2025-01-17 06:15:43',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (4,'Anesthesia',2,5,'Pain relief during surgery.',52,1000.00,1200.00,1,'2024-12-03 11:36:22','2025-02-19 05:30:24',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (5,'Prophy Brush',3,1,'Cleans teeth during polishing.',75,10.00,12.00,1,'2024-12-03 11:37:46','2024-12-05 05:34:05',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (6,'Prophy Paste',3,3,'Abrasive paste for stain removal.',84,100.00,120.00,1,'2024-12-03 11:38:47','2024-12-05 05:34:05',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (7,'Mouthwash',3,4,'Kills bacteria and freshens breath.',53,450.00,500.00,1,'2024-12-03 11:39:42','2024-12-05 05:34:05',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (8,'Dental Floss',3,6,'Removes debris between teeth.',45,220.00,250.00,1,'2024-12-03 11:40:25','2024-12-05 05:34:05',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (9,'Tongue Scraper',3,1,'Cleans tongue surface.',91,100.00,150.00,1,'2024-12-03 11:41:04','2024-12-05 05:34:05',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (10,'Micro Applicator',4,1,'Applies adhesives and solutions.',49,200.00,250.00,1,'2024-12-03 11:42:00','2024-12-05 05:32:44',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (11,'Etchant',4,4,'Prepares tooth surface for bonding.',36,200.00,250.00,1,'2024-12-03 11:43:17','2024-12-05 05:32:11',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (12,'Matrix Bond',4,4,'Adhesive for restorative materials.',93,100.00,120.00,1,'2024-12-03 11:43:45','2024-12-05 05:32:11',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (13,'Orthodontic Kit',5,1,'Essential tools for orthodontic care.',108,200.00,250.00,1,'2024-12-03 11:45:44','2024-12-17 16:35:41',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (14,'Orthodontic Brush',5,1,'Brush designed for braces cleaning.',34,200.00,250.00,1,'2024-12-03 11:46:14','2025-02-19 05:31:33',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (15,'Interdental Brush',5,1,'Cleans between teeth and braces.',98,40.00,50.00,1,'2024-12-03 11:46:41','2025-02-19 05:30:24',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (16,'Orthodontic Wax',5,3,'Covers braces to prevent irritation.',39,50.00,75.00,1,'2024-12-03 11:47:05','2025-02-19 05:30:24',0);
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`, `minimum_stock`) VALUES (17,'Cairo Levine',2,4,'Et cillum voluptatum',391,166.00,607.00,1,'2025-02-05 10:43:39','2025-02-19 05:31:33',69);

INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (1,'Dental Consultation','Professional evaluation of oral health.',1,'2024-12-03 20:25:24','2024-12-03 20:25:24');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (2,'Oral Prophylaxis','Cleaning of teeth to remove plaque and tartar.',1,'2024-12-03 20:26:01','2024-12-03 20:26:01');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (3,'Tooth Filling','Restoring decayed or damaged teeth.',1,'2024-12-03 20:27:20','2024-12-03 20:27:20');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (4,'Tooth Extraction','Removing a damaged or problematic tooth.',1,'2024-12-03 20:27:51','2024-12-03 20:27:51');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (5,'Fluoride Treatment','Strengthening teeth to prevent decay.',1,'2024-12-03 20:29:18','2024-12-03 20:29:18');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (6,'Pit & Fissure Sealant Application','Protective coating for children’s teeth to prevent cavities.',1,'2024-12-03 20:29:43','2024-12-17 09:41:13');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (7,'Strip-off Crown','Temporary crown for baby teeth.',1,'2024-12-03 20:31:21','2024-12-03 20:31:21');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (8,'Orthodontic Treatment (Braces)','Straightening teeth and correcting bite issues.',1,'2024-12-03 20:32:01','2024-12-03 20:32:01');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (9,'Retainers','Devices used to maintain teeth alignment post-braces.',1,'2024-12-03 20:32:35','2024-12-03 20:32:35');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (10,'Laser Teeth Whitening','Improving tooth appearance by removing stains and whitening.',1,'2024-12-03 20:34:15','2024-12-03 20:34:15');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (11,'Odontectomy','Surgical removal of an impacted or damaged tooth.',1,'2024-12-03 20:34:55','2024-12-03 20:34:55');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (12,'Removable Partial Denture','Replace missing teeth with removable devices.',1,'2024-12-03 20:36:22','2024-12-03 20:36:22');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (13,'Complete Denture','Full set of artificial teeth for those without teeth.',1,'2024-12-03 20:36:50','2024-12-03 20:36:50');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (14,'Jacket Crown','Restoration that covers and strengthens a damaged tooth.',1,'2024-12-03 20:37:16','2024-12-03 20:37:16');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (16,'Fixed Bridge','Permanent replacement for one or more missing teeth.',1,'2024-12-03 20:41:31','2024-12-03 20:41:31');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (17,'Mouthguard/Nightguard','Custom-fit device to protect teeth during sports or prevent grinding.',1,'2024-12-03 20:45:36','2024-12-03 20:45:36');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (18,'Periapical X-ray','Imaging to examine teeth and surrounding bone structure.',1,'2024-12-03 20:45:51','2024-12-03 20:45:51');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (20,'Service 1','lorem ipsum',1,'2025-02-18 06:09:44','2025-02-18 06:09:44');
INSERT INTO `services` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (21,'Sawyer Benson','Vel ut nostrum debit',1,'2025-02-18 06:10:06','2025-02-18 06:10:06');
