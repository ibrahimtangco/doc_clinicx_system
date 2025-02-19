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

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2014_10_12_100000_create_password_reset_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2019_12_14_000001_create_personal_access_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2024_04_03_143549_create_services_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2024_04_18_152637_create_providers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2024_05_23_125902_create_patients_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2024_05_30_233927_create_medical_history_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2024_05_31_143139_create_activity_log_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2024_05_31_143140_add_event_column_to_activity_log_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2024_05_31_143141_add_batch_uuid_column_to_activity_log_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2024_06_15_181507_create_categories_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2024_06_16_124217_create_prescriptions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2024_08_24_190725_create_contacts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2024_08_27_214441_create_footers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2024_10_04_011255_create_unit_types_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2024_10_08_211506_create_transactions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2024_12_17_165233_create_products_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2024_10_08_213739_create_transaction_details_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2024_11_08_131439_create_daily_patient_capacity_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2024_11_08_131501_create_reservations_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2024_11_08_131540_create_appointments_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2024_12_04_180503_create_social_media_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2024_12_05_012851_create_jobs_table',3);
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (1,'Service','updated','App\\Models\\Service','updated',6,'App\\Models\\User',1,'{\"attributes\":{\"availability\":1},\"old\":{\"availability\":0}}',NULL,'2024-12-17 09:41:13','2024-12-17 09:41:13');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (2,'Category','updated','App\\Models\\Category','updated',1,'App\\Models\\User',1,'{\"attributes\":{\"availability\":0},\"old\":{\"availability\":1}}',NULL,'2024-12-17 09:45:55','2024-12-17 09:45:55');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (3,'Category','updated','App\\Models\\Category','updated',1,'App\\Models\\User',1,'{\"attributes\":{\"availability\":1},\"old\":{\"availability\":0}}',NULL,'2024-12-17 09:46:00','2024-12-17 09:46:00');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (4,'Category','updated','App\\Models\\Category','updated',1,'App\\Models\\User',1,'{\"attributes\":{\"availability\":0},\"old\":{\"availability\":1}}',NULL,'2024-12-17 11:04:36','2024-12-17 11:04:36');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (5,'Category','updated','App\\Models\\Category','updated',1,'App\\Models\\User',1,'{\"attributes\":{\"availability\":1},\"old\":{\"availability\":0}}',NULL,'2024-12-17 11:04:41','2024-12-17 11:04:41');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (6,'Dentist','created','App\\Models\\Provider','created',1,'App\\Models\\User',1,'{\"attributes\":{\"title\":\"Dr.\",\"reg_number\":\"9341234\"}}',NULL,'2024-12-17 11:18:11','2024-12-17 11:18:11');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (7,'Dentist','created','App\\Models\\Provider','created',2,'App\\Models\\User',1,'{\"attributes\":{\"title\":\"Dr.\",\"reg_number\":\"911\"}}',NULL,'2024-12-17 11:19:59','2024-12-17 11:19:59');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (8,'Transaction','created','App\\Models\\Transaction','created',1,'App\\Models\\User',1,'{\"attributes\":{\"transaction_code\":\"TRX-20241218-0001\",\"total_amount\":\"1500.00\"}}',NULL,'2024-12-17 16:35:15','2024-12-17 16:35:15');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (9,'Product','updated','App\\Models\\Product','updated',1,'App\\Models\\User',1,'{\"attributes\":{\"quantity\":111},\"old\":{\"quantity\":114}}',NULL,'2024-12-17 16:35:15','2024-12-17 16:35:15');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (10,'Transaction','created','App\\Models\\Transaction','created',2,'App\\Models\\User',1,'{\"attributes\":{\"transaction_code\":\"TRX-20241218-0002\",\"total_amount\":\"1700.00\"}}',NULL,'2024-12-17 16:35:40','2024-12-17 16:35:40');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (11,'Product','updated','App\\Models\\Product','updated',4,'App\\Models\\User',1,'{\"attributes\":{\"quantity\":54},\"old\":{\"quantity\":55}}',NULL,'2024-12-17 16:35:41','2024-12-17 16:35:41');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (12,'Product','updated','App\\Models\\Product','updated',13,'App\\Models\\User',1,'{\"attributes\":{\"quantity\":108},\"old\":{\"quantity\":109}}',NULL,'2024-12-17 16:35:41','2024-12-17 16:35:41');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (13,'Product','updated','App\\Models\\Product','updated',14,'App\\Models\\User',1,'{\"attributes\":{\"quantity\":38},\"old\":{\"quantity\":39}}',NULL,'2024-12-17 16:35:41','2024-12-17 16:35:41');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (14,'Transaction','created','App\\Models\\Transaction','created',3,'App\\Models\\User',1,'{\"attributes\":{\"transaction_code\":\"TRX-20241219-0003\",\"total_amount\":\"2200.00\"}}',NULL,'2024-12-19 05:30:03','2024-12-19 05:30:03');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (15,'Product','updated','App\\Models\\Product','updated',4,'App\\Models\\User',1,'{\"attributes\":{\"quantity\":53},\"old\":{\"quantity\":54}}',NULL,'2024-12-19 05:30:03','2024-12-19 05:30:03');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (16,'Product','updated','App\\Models\\Product','updated',1,'App\\Models\\User',1,'{\"attributes\":{\"quantity\":109},\"old\":{\"quantity\":111}}',NULL,'2024-12-19 05:30:03','2024-12-19 05:30:03');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (17,'Reservation','created','App\\Models\\Reservation','created',49,'App\\Models\\User',9,'{\"attributes\":{\"patient_id\":5,\"service_id\":4,\"preferred_schedule\":\"AM\",\"status\":\"pending\",\"queue_number\":null,\"date\":\"2024-12-29\",\"remarks\":null}}',NULL,'2024-12-28 09:38:47','2024-12-28 09:38:47');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (18,'Reservation','updated','App\\Models\\Reservation','updated',49,'App\\Models\\User',1,'{\"attributes\":{\"status\":\"declined\",\"remarks\":\"Reason to decline\"},\"old\":{\"status\":\"pending\",\"remarks\":null}}',NULL,'2024-12-28 09:39:17','2024-12-28 09:39:17');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (19,'Category','created','App\\Models\\Category','created',6,'App\\Models\\User',1,'{\"attributes\":{\"name\":\"123\",\"description\":\"Non exercitationem a\",\"availability\":1}}',NULL,'2024-12-29 08:32:38','2024-12-29 08:32:38');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (20,'Reservation','created','App\\Models\\Reservation','created',50,'App\\Models\\User',13,'{\"attributes\":{\"patient_id\":9,\"service_id\":1,\"preferred_schedule\":\"AM\",\"status\":\"pending\",\"queue_number\":null,\"date\":\"2024-12-29\",\"remarks\":null}}',NULL,'2024-12-29 08:44:24','2024-12-29 08:44:24');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (21,'Reservation','updated','App\\Models\\Reservation','updated',50,'App\\Models\\User',1,'{\"attributes\":{\"remarks\":\"Enim mollit minus fa\"},\"old\":{\"remarks\":null}}',NULL,'2024-12-29 08:51:04','2024-12-29 08:51:04');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (22,'Category','updated','App\\Models\\Category','updated',1,'App\\Models\\User',1,'{\"attributes\":{\"availability\":0},\"old\":{\"availability\":1}}',NULL,'2024-12-29 08:54:31','2024-12-29 08:54:31');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (23,'Reservation','updated','App\\Models\\Reservation','updated',50,'App\\Models\\User',1,'{\"attributes\":{\"status\":\"declined\",\"remarks\":\"Quod voluptatum rati\"},\"old\":{\"status\":\"pending\",\"remarks\":\"Enim mollit minus fa\"}}',NULL,'2025-01-15 10:29:45','2025-01-15 10:29:45');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (24,'Reservation','created','App\\Models\\Reservation','created',51,'App\\Models\\User',9,'{\"attributes\":{\"patient_id\":5,\"service_id\":4,\"preferred_schedule\":\"PM\",\"status\":\"pending\",\"queue_number\":null,\"date\":\"2025-01-16\",\"remarks\":null}}',NULL,'2025-01-15 10:35:13','2025-01-15 10:35:13');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (25,'Reservation','created','App\\Models\\Reservation','created',52,'App\\Models\\User',13,'{\"attributes\":{\"patient_id\":9,\"service_id\":1,\"preferred_schedule\":\"AM\",\"status\":\"pending\",\"queue_number\":null,\"date\":\"2025-01-16\",\"remarks\":null}}',NULL,'2025-01-15 10:39:51','2025-01-15 10:39:51');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (26,'Reservation','updated','App\\Models\\Reservation','updated',52,'App\\Models\\User',1,'{\"attributes\":{\"status\":\"approved\",\"queue_number\":\"20250116-AM-001\"},\"old\":{\"status\":\"pending\",\"queue_number\":null}}',NULL,'2025-01-15 10:40:29','2025-01-15 10:40:29');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (27,'Reservation','created','App\\Models\\Reservation','created',53,'App\\Models\\User',13,'{\"attributes\":{\"patient_id\":9,\"service_id\":1,\"preferred_schedule\":\"AM\",\"status\":\"pending\",\"queue_number\":null,\"date\":\"2025-01-19\",\"remarks\":null}}',NULL,'2025-01-17 06:06:59','2025-01-17 06:06:59');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (28,'Reservation','created','App\\Models\\Reservation','created',54,'App\\Models\\User',13,'{\"attributes\":{\"patient_id\":9,\"service_id\":1,\"preferred_schedule\":\"AM\",\"status\":\"pending\",\"queue_number\":null,\"date\":\"2025-01-19\",\"remarks\":null}}',NULL,'2025-01-17 06:07:04','2025-01-17 06:07:04');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (29,'Reservation','updated','App\\Models\\Reservation','updated',53,'App\\Models\\User',1,'{\"attributes\":{\"status\":\"approved\",\"queue_number\":\"20250119-AM-001\"},\"old\":{\"status\":\"pending\",\"queue_number\":null}}',NULL,'2025-01-17 06:11:37','2025-01-17 06:11:37');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (30,'Transaction','created','App\\Models\\Transaction','created',4,'App\\Models\\User',1,'{\"attributes\":{\"transaction_code\":\"TRX-20250117-0004\",\"total_amount\":\"700.00\"}}',NULL,'2025-01-17 06:15:43','2025-01-17 06:15:43');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (31,'Product','updated','App\\Models\\Product','updated',2,'App\\Models\\User',1,'{\"attributes\":{\"quantity\":95},\"old\":{\"quantity\":97}}',NULL,'2025-01-17 06:15:43','2025-01-17 06:15:43');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (32,'Product','updated','App\\Models\\Product','updated',3,'App\\Models\\User',1,'{\"attributes\":{\"quantity\":121},\"old\":{\"quantity\":122}}',NULL,'2025-01-17 06:15:43','2025-01-17 06:15:43');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (33,'Category','updated','App\\Models\\Category','updated',1,'App\\Models\\User',1,'{\"attributes\":{\"availability\":1},\"old\":{\"availability\":0}}',NULL,'2025-01-17 06:17:00','2025-01-17 06:17:00');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (34,'Product','updated','App\\Models\\Product','updated',1,'App\\Models\\User',1,'{\"attributes\":{\"status\":0},\"old\":{\"status\":1}}',NULL,'2025-01-17 06:17:47','2025-01-17 06:17:47');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (35,'Reservation','created','App\\Models\\Reservation','created',55,'App\\Models\\User',13,'{\"attributes\":{\"patient_id\":9,\"service_id\":5,\"preferred_schedule\":\"AM\",\"status\":\"pending\",\"queue_number\":null,\"date\":\"2025-01-19\",\"remarks\":null}}',NULL,'2025-01-18 12:44:55','2025-01-18 12:44:55');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (36,'Service','created','App\\Models\\Service','created',19,'App\\Models\\User',1,'{\"attributes\":{\"name\":\"Chava Patterson\",\"description\":\"Dolor in laboris eiu\",\"price\":null,\"availability\":0}}',NULL,'2025-01-18 16:49:40','2025-01-18 16:49:40');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (37,'Dentist','created','App\\Models\\Provider','created',3,'App\\Models\\User',1,'{\"attributes\":{\"title\":\"Dr.\",\"reg_number\":\"8-7000\"}}',NULL,'2025-01-18 16:50:29','2025-01-18 16:50:29');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (38,'Category','updated','App\\Models\\Category','updated',2,'App\\Models\\User',1,'{\"attributes\":{\"description\":null},\"old\":{\"description\":\"Procedures involving oral surgery or extractions.\"}}',NULL,'2025-01-18 17:20:31','2025-01-18 17:20:31');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (39,'Category','updated','App\\Models\\Category','updated',2,'App\\Models\\User',1,'{\"attributes\":{\"description\":\"Non neque laudantium\"},\"old\":{\"description\":null}}',NULL,'2025-01-18 17:21:38','2025-01-18 17:21:38');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (40,'Unit of Measurement','updated','App\\Models\\UnitType','updated',2,'App\\Models\\User',1,'{\"attributes\":{\"abbreviation\":\"tub\"},\"old\":{\"abbreviation\":\"tubme\"}}',NULL,'2025-01-18 17:25:41','2025-01-18 17:25:41');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (41,'Product','updated','App\\Models\\Product','updated',1,'App\\Models\\User',1,'{\"attributes\":{\"status\":1},\"old\":{\"status\":0}}',NULL,'2025-01-19 06:28:02','2025-01-19 06:28:02');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (42,'Reservation','updated','App\\Models\\Reservation','updated',51,'App\\Models\\User',1,'{\"attributes\":{\"status\":\"declined\",\"remarks\":\"Cupiditate eos enim\"},\"old\":{\"status\":\"pending\",\"remarks\":null}}',NULL,'2025-01-19 07:17:57','2025-01-19 07:17:57');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (43,'Reservation','updated','App\\Models\\Reservation','updated',55,'App\\Models\\User',1,'{\"attributes\":{\"status\":\"declined\",\"remarks\":\"Aut in incididunt mo\"},\"old\":{\"status\":\"pending\",\"remarks\":null}}',NULL,'2025-01-19 07:18:05','2025-01-19 07:18:05');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES (44,'Reservation','updated','App\\Models\\Reservation','updated',54,'App\\Models\\User',1,'{\"attributes\":{\"status\":\"declined\",\"remarks\":\"Sed eaque nisi offic\"},\"old\":{\"status\":\"pending\",\"remarks\":null}}',NULL,'2025-01-19 07:18:11','2025-01-19 07:18:11');
INSERT INTO `appointments` (`id`, `reservation_id`, `queue_number`, `status`, `remarks`, `created_at`, `updated_at`) VALUES (2,3,'20241218-PM-001','completed','Tooth was successfully filled.','2024-12-17 16:31:07','2024-12-17 16:36:32');
INSERT INTO `appointments` (`id`, `reservation_id`, `queue_number`, `status`, `remarks`, `created_at`, `updated_at`) VALUES (3,4,'20241218-AM-001','completed','Tooth was successfully extracted!','2024-12-17 16:31:10','2024-12-17 16:39:01');
INSERT INTO `appointments` (`id`, `reservation_id`, `queue_number`, `status`, `remarks`, `created_at`, `updated_at`) VALUES (4,5,'20241218-PM-002','completed','Tooth condition was great.','2024-12-17 16:31:13','2024-12-17 16:41:25');
INSERT INTO `appointments` (`id`, `reservation_id`, `queue_number`, `status`, `remarks`, `created_at`, `updated_at`) VALUES (5,6,'20241218-AM-002','no_show','Patient didn\'t show up','2024-12-17 16:33:33','2024-12-17 16:41:45');
INSERT INTO `appointments` (`id`, `reservation_id`, `queue_number`, `status`, `remarks`, `created_at`, `updated_at`) VALUES (6,8,'20241219-PM-001','completed','Proident in ipsam e','2024-12-19 05:21:21','2024-12-20 06:05:06');
INSERT INTO `appointments` (`id`, `reservation_id`, `queue_number`, `status`, `remarks`, `created_at`, `updated_at`) VALUES (7,21,'20241228-PM-001','completed','asfa','2024-12-28 06:55:23','2024-12-28 06:59:02');
INSERT INTO `appointments` (`id`, `reservation_id`, `queue_number`, `status`, `remarks`, `created_at`, `updated_at`) VALUES (8,22,'20241228-PM-002','no_show','Patient didn\'t show up','2024-12-28 06:57:39','2024-12-28 07:01:13');
INSERT INTO `appointments` (`id`, `reservation_id`, `queue_number`, `status`, `remarks`, `created_at`, `updated_at`) VALUES (9,24,'20241228-PM-003','completed','remarks','2024-12-28 07:14:06','2024-12-28 07:15:37');
INSERT INTO `appointments` (`id`, `reservation_id`, `queue_number`, `status`, `remarks`, `created_at`, `updated_at`) VALUES (10,26,'20241228-PM-004','no_show','Patient didn\'t show up','2024-12-28 07:14:44','2024-12-28 07:15:48');
INSERT INTO `appointments` (`id`, `reservation_id`, `queue_number`, `status`, `remarks`, `created_at`, `updated_at`) VALUES (11,48,'20241229-AM-001','no_show',NULL,'2024-12-28 07:18:43','2025-01-15 10:32:57');
INSERT INTO `appointments` (`id`, `reservation_id`, `queue_number`, `status`, `remarks`, `created_at`, `updated_at`) VALUES (12,52,'20250116-AM-001','completed','asgsdfsd','2025-01-15 10:40:29','2025-01-17 06:13:58');
INSERT INTO `appointments` (`id`, `reservation_id`, `queue_number`, `status`, `remarks`, `created_at`, `updated_at`) VALUES (13,53,'20250119-AM-001','completed','In rerum anim proide','2025-01-17 06:11:37','2025-01-18 16:08:03');
INSERT INTO `categories` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (1,'Prosthodontic','Restoration and replacement of missing teeth.',1,'2024-12-03 11:27:15','2025-01-17 06:17:00');
INSERT INTO `categories` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (2,'Surgical','Non neque laudantium',1,'2024-12-03 11:27:26','2025-01-18 17:21:38');
INSERT INTO `categories` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (3,'Oral Prophylaxis','Cleaning and maintenance of oral health.',1,'2024-12-03 11:27:37','2024-12-03 11:47:40');
INSERT INTO `categories` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (4,'Restorative','Repair and restoration of tooth structure.',1,'2024-12-03 11:27:49','2024-12-03 11:47:44');
INSERT INTO `categories` (`id`, `name`, `description`, `availability`, `created_at`, `updated_at`) VALUES (5,'Orthodontics','Alignment and correction of teeth and jaws.',1,'2024-12-03 11:45:16','2024-12-03 11:47:48');
INSERT INTO `daily_patient_capacity` (`id`, `date`, `am_capacity`, `pm_capacity`, `created_at`, `updated_at`) VALUES (1,'2024-12-18',2,2,'2024-12-17 15:55:48','2024-12-17 15:55:48');
INSERT INTO `daily_patient_capacity` (`id`, `date`, `am_capacity`, `pm_capacity`, `created_at`, `updated_at`) VALUES (2,'2024-12-19',2,2,'2024-12-17 16:34:55','2024-12-17 16:34:55');
INSERT INTO `daily_patient_capacity` (`id`, `date`, `am_capacity`, `pm_capacity`, `created_at`, `updated_at`) VALUES (3,'2024-12-20',15,15,'2024-12-19 05:23:11','2024-12-19 05:23:11');
INSERT INTO `daily_patient_capacity` (`id`, `date`, `am_capacity`, `pm_capacity`, `created_at`, `updated_at`) VALUES (4,'2024-12-28',0,4,'2024-12-27 14:32:29','2024-12-28 07:11:10');
INSERT INTO `daily_patient_capacity` (`id`, `date`, `am_capacity`, `pm_capacity`, `created_at`, `updated_at`) VALUES (5,'2024-12-29',2,2,'2024-12-28 07:18:03','2024-12-28 07:18:03');
INSERT INTO `daily_patient_capacity` (`id`, `date`, `am_capacity`, `pm_capacity`, `created_at`, `updated_at`) VALUES (6,'2025-01-16',2,2,'2025-01-15 10:30:44','2025-01-15 10:30:44');
INSERT INTO `daily_patient_capacity` (`id`, `date`, `am_capacity`, `pm_capacity`, `created_at`, `updated_at`) VALUES (7,'2025-01-17',2,0,'2025-01-15 10:30:50','2025-01-17 06:18:53');
INSERT INTO `daily_patient_capacity` (`id`, `date`, `am_capacity`, `pm_capacity`, `created_at`, `updated_at`) VALUES (9,'2025-01-18',2,2,'2025-01-15 10:31:38','2025-01-15 10:31:38');
INSERT INTO `daily_patient_capacity` (`id`, `date`, `am_capacity`, `pm_capacity`, `created_at`, `updated_at`) VALUES (10,'2025-01-19',2,2,'2025-01-15 10:31:45','2025-01-15 10:31:45');
INSERT INTO `daily_patient_capacity` (`id`, `date`, `am_capacity`, `pm_capacity`, `created_at`, `updated_at`) VALUES (11,'2025-01-21',2,2,'2025-01-19 06:58:15','2025-01-19 06:58:15');
INSERT INTO `daily_patient_capacity` (`id`, `date`, `am_capacity`, `pm_capacity`, `created_at`, `updated_at`) VALUES (12,'2025-01-22',2,2,'2025-01-19 06:58:30','2025-01-19 06:58:30');
INSERT INTO `footers` (`id`, `description`, `created_at`, `updated_at`) VALUES (1,'Filarca - Rabena Dental Clinic © 2025','2024-12-20 05:52:58','2025-01-19 07:40:39');
INSERT INTO `medical_history` (`id`, `patient_id`, `condition`, `description`, `diagnosed_date`, `treatment`, `status`, `created_at`, `updated_at`) VALUES (2,5,'Hypertension','Patient has been managing blood pressure with medication for the past 2 years. Regular check-ups and medication have been effective in maintaining stable blood pressure.','0202-11-01','Medication (ACE Inhibitors)','active','2025-01-18 15:06:32','2025-01-18 15:06:32');
INSERT INTO `medical_history` (`id`, `patient_id`, `condition`, `description`, `diagnosed_date`, `treatment`, `status`, `created_at`, `updated_at`) VALUES (3,5,'Diabetes','Patient is under insulin therapy and oral medication for managing blood sugar levels. Regular monitoring of blood sugar is required.','2022-01-12','Insulin Therapy, Oral Medication','inactive','2025-01-18 15:07:13','2025-01-18 16:09:10');
INSERT INTO `patients` (`id`, `user_id`, `telephone`, `birthday`, `age`, `status`, `created_at`, `updated_at`) VALUES (5,9,'09121496543','1975-12-18',49,'Married','2024-12-17 16:22:35','2024-12-17 16:22:35');
INSERT INTO `patients` (`id`, `user_id`, `telephone`, `birthday`, `age`, `status`, `created_at`, `updated_at`) VALUES (6,10,'09123545912','1994-05-11',30,'Separated','2024-12-17 16:25:32','2024-12-17 16:25:32');
INSERT INTO `patients` (`id`, `user_id`, `telephone`, `birthday`, `age`, `status`, `created_at`, `updated_at`) VALUES (7,11,'09151059542','2020-09-20',4,'Separated','2024-12-17 16:27:02','2024-12-17 16:27:02');
INSERT INTO `patients` (`id`, `user_id`, `telephone`, `birthday`, `age`, `status`, `created_at`, `updated_at`) VALUES (8,12,'09876548123','1973-05-13',51,'Single','2024-12-17 16:32:20','2024-12-17 16:32:20');
INSERT INTO `patients` (`id`, `user_id`, `telephone`, `birthday`, `age`, `status`, `created_at`, `updated_at`) VALUES (9,13,'09171049142','2002-07-14',22,'Single','2024-12-27 14:20:56','2025-01-18 13:27:33');
INSERT INTO `prescriptions` (`id`, `patient_id`, `provider_id`, `medicines`, `quantities`, `dosages`, `created_at`, `updated_at`) VALUES (1,5,2,'[\"Ibuprofen\",\"Amoxicillin\",\"Chlorhexidine Mouthwash (0.12%)\"]','[\"12\",\"21\",\"1\"]','[\"400mg. Take 1 tablet every 6-8 hours as needed for pain.\",\"500mg. Take 1 capsule every 8 hours for 7 days.\",\"bottle. Rinse mouth with 15 ml for 30 seconds twice daily. Do not swallow.\"]','2024-12-17 16:38:33','2024-12-17 16:38:33');
INSERT INTO `prescriptions` (`id`, `patient_id`, `provider_id`, `medicines`, `quantities`, `dosages`, `created_at`, `updated_at`) VALUES (2,7,2,'[\"Ibuprofen\"]','[\"12\"]','[\"400mg. Take 1 tablet every 6-8 hours as needed for pain.\"]','2024-12-17 16:40:24','2024-12-17 16:40:24');
INSERT INTO `prescriptions` (`id`, `patient_id`, `provider_id`, `medicines`, `quantities`, `dosages`, `created_at`, `updated_at`) VALUES (3,9,2,'[\"Biogesic\",\"Amoxicillin\"]','[\"12\",\"24\"]','[\"3x a day, after every meal\",\"twice a day, morning and night\"]','2025-01-17 06:14:24','2025-01-17 06:14:24');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (1,'Tropical Gin (Alginate)',1,3,'Impression material for molds.',109,385.00,500.00,1,'2024-12-03 11:33:42','2025-01-19 06:28:02');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (2,'Impression Tray',1,1,'Holds material for dental impressions.',95,75.00,100.00,1,'2024-12-03 11:34:38','2025-01-17 06:15:43');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (3,'Lidocaine Ointment',2,2,'Numbs soft tissues.',121,450.00,500.00,1,'2024-12-03 11:35:35','2025-01-17 06:15:43');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (4,'Anesthesia',2,5,'Pain relief during surgery.',53,1000.00,1200.00,1,'2024-12-03 11:36:22','2024-12-19 05:30:03');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (5,'Prophy Brush',3,1,'Cleans teeth during polishing.',75,10.00,12.00,1,'2024-12-03 11:37:46','2024-12-05 05:34:05');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (6,'Prophy Paste',3,3,'Abrasive paste for stain removal.',84,100.00,120.00,1,'2024-12-03 11:38:47','2024-12-05 05:34:05');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (7,'Mouthwash',3,4,'Kills bacteria and freshens breath.',53,450.00,500.00,1,'2024-12-03 11:39:42','2024-12-05 05:34:05');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (8,'Dental Floss',3,6,'Removes debris between teeth.',45,220.00,250.00,1,'2024-12-03 11:40:25','2024-12-05 05:34:05');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (9,'Tongue Scraper',3,1,'Cleans tongue surface.',91,100.00,150.00,1,'2024-12-03 11:41:04','2024-12-05 05:34:05');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (10,'Micro Applicator',4,1,'Applies adhesives and solutions.',49,200.00,250.00,1,'2024-12-03 11:42:00','2024-12-05 05:32:44');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (11,'Etchant',4,4,'Prepares tooth surface for bonding.',36,200.00,250.00,1,'2024-12-03 11:43:17','2024-12-05 05:32:11');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (12,'Matrix Bond',4,4,'Adhesive for restorative materials.',93,100.00,120.00,1,'2024-12-03 11:43:45','2024-12-05 05:32:11');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (13,'Orthodontic Kit',5,1,'Essential tools for orthodontic care.',108,200.00,250.00,1,'2024-12-03 11:45:44','2024-12-17 16:35:41');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (14,'Orthodontic Brush',5,1,'Brush designed for braces cleaning.',38,200.00,250.00,1,'2024-12-03 11:46:14','2024-12-17 16:35:41');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (15,'Interdental Brush',5,1,'Cleans between teeth and braces.',100,40.00,50.00,1,'2024-12-03 11:46:41','2024-12-03 11:46:41');
INSERT INTO `products` (`id`, `name`, `category_id`, `unit_type_id`, `description`, `quantity`, `buying_price`, `selling_price`, `status`, `created_at`, `updated_at`) VALUES (16,'Orthodontic Wax',5,3,'Covers braces to prevent irritation.',41,50.00,75.00,1,'2024-12-03 11:47:05','2024-12-05 05:32:11');
INSERT INTO `providers` (`id`, `user_id`, `title`, `reg_number`, `created_at`, `updated_at`) VALUES (2,7,'Dr.','911','2024-12-17 11:19:59','2024-12-17 11:19:59');
INSERT INTO `providers` (`id`, `user_id`, `title`, `reg_number`, `created_at`, `updated_at`) VALUES (3,14,'Dr.','8-7000','2025-01-18 16:50:29','2025-01-18 16:50:29');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (3,5,3,'Severe pain','PM','approved','20241218-PM-001','2024-12-18',NULL,'2024-12-17 16:24:15','2024-12-17 16:31:07');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (4,7,4,'Pain','AM','approved','20241218-AM-001','2024-12-18',NULL,'2024-12-17 16:30:21','2024-12-17 16:31:10');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (5,6,1,'just a routine check up','PM','approved','20241218-PM-002','2024-12-18',NULL,'2024-12-17 16:30:57','2024-12-17 16:31:13');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (6,8,9,'Et et magnam enim qu','AM','approved','20241218-AM-002','2024-12-18',NULL,'2024-12-17 16:33:05','2024-12-17 16:33:33');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (7,5,1,'Perferendis dignissi','AM','declined',NULL,'2024-12-18','Rebook for another day, the day you selected is fully booked.','2024-12-17 16:33:23','2024-12-17 16:34:22');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (8,5,4,'asdfad','PM','approved','20241219-PM-001','2024-12-19',NULL,'2024-12-19 05:20:25','2024-12-19 05:21:21');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (9,5,1,'check up','PM','declined',NULL,'2024-12-20','Nihil corrupti est','2024-12-19 05:29:11','2024-12-20 06:01:58');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (21,9,1,'Quibusdam occaecat l','PM','approved','20241228-PM-001','2024-12-28',NULL,'2024-12-27 15:33:28','2024-12-28 06:55:23');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (22,9,1,'Ut qui ut incidunt','PM','approved','20241228-PM-002','2024-12-28',NULL,'2024-12-27 15:38:48','2024-12-28 06:57:39');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (23,9,2,'Recusandae Voluptas','PM','declined',NULL,'2024-12-28','This is the reason','2024-12-27 15:40:16','2024-12-28 07:00:33');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (24,9,2,'Eiusmod quam autem e','PM','approved','20241228-PM-003','2024-12-28',NULL,'2024-12-27 15:42:14','2024-12-28 07:14:06');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (25,9,1,'Ea accusantium praes','PM','declined',NULL,'2024-12-28','reason for declining','2024-12-28 06:26:03','2024-12-28 07:14:16');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (26,9,3,'Nobis aut reprehende','PM','approved','20241228-PM-004','2024-12-28',NULL,'2024-12-28 06:28:25','2024-12-28 07:14:44');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (48,9,18,'Dicta lorem autem nu','AM','approved','20241229-AM-001','2024-12-29',NULL,'2024-12-28 07:18:11','2024-12-28 07:18:43');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (49,5,4,'This is current condition','AM','declined',NULL,'2024-12-29','Reason to decline','2024-12-28 09:38:47','2024-12-28 09:39:17');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (50,9,1,'In vel eum dolor com','AM','declined',NULL,'2024-12-29','Quod voluptatum rati','2024-12-29 08:44:24','2025-01-15 10:29:45');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (51,5,4,'Severe pain and swelling','PM','declined',NULL,'2025-01-16','Cupiditate eos enim','2025-01-15 10:35:13','2025-01-19 07:17:57');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (52,9,1,'Just want to have my annual checkup','AM','approved','20250116-AM-001','2025-01-16',NULL,'2025-01-15 10:39:51','2025-01-15 10:40:29');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (53,9,1,'Laborum Quos vel ex','AM','approved','20250119-AM-001','2025-01-19',NULL,'2025-01-17 06:06:59','2025-01-17 06:11:37');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (54,9,1,'Laborum Quos vel ex','AM','declined',NULL,'2025-01-19','Sed eaque nisi offic','2025-01-17 06:07:04','2025-01-19 07:18:11');
INSERT INTO `reservations` (`id`, `patient_id`, `service_id`, `current_condition`, `preferred_schedule`, `status`, `queue_number`, `date`, `remarks`, `created_at`, `updated_at`) VALUES (55,9,5,'Dolore quasi ullamco','AM','declined',NULL,'2025-01-19','Aut in incididunt mo','2025-01-18 12:44:55','2025-01-19 07:18:05');
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
INSERT INTO `social_media` (`id`, `platform`, `username`, `url`, `status`, `created_at`, `updated_at`) VALUES (5,'Facebook','Filarca - Rabena Dental Clinic','https://www.facebook.com/filarcarabenadentalclinic',1,'2025-01-19 07:47:58','2025-01-19 07:47:58');
INSERT INTO `transactions` (`id`, `transaction_code`, `total_amount`, `created_at`, `updated_at`) VALUES (1,'TRX-20241218-0001',1500.00,'2024-12-17 16:35:15','2024-12-17 16:35:15');
INSERT INTO `transactions` (`id`, `transaction_code`, `total_amount`, `created_at`, `updated_at`) VALUES (2,'TRX-20241218-0002',1700.00,'2024-12-17 16:35:40','2024-12-17 16:35:40');
INSERT INTO `transactions` (`id`, `transaction_code`, `total_amount`, `created_at`, `updated_at`) VALUES (3,'TRX-20241219-0003',2200.00,'2024-12-19 05:30:03','2024-12-19 05:30:03');
INSERT INTO `transactions` (`id`, `transaction_code`, `total_amount`, `created_at`, `updated_at`) VALUES (4,'TRX-20250117-0004',700.00,'2025-01-17 06:15:43','2025-01-17 06:15:43');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_id`, `quantity`, `price_at_time_of_sale`, `total_amount`, `created_at`, `updated_at`) VALUES (1,1,1,3,500.00,1500.00,'2024-12-17 16:35:15','2024-12-17 16:35:15');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_id`, `quantity`, `price_at_time_of_sale`, `total_amount`, `created_at`, `updated_at`) VALUES (2,2,4,1,1200.00,1200.00,'2024-12-17 16:35:41','2024-12-17 16:35:41');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_id`, `quantity`, `price_at_time_of_sale`, `total_amount`, `created_at`, `updated_at`) VALUES (3,2,13,1,250.00,250.00,'2024-12-17 16:35:41','2024-12-17 16:35:41');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_id`, `quantity`, `price_at_time_of_sale`, `total_amount`, `created_at`, `updated_at`) VALUES (4,2,14,1,250.00,250.00,'2024-12-17 16:35:41','2024-12-17 16:35:41');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_id`, `quantity`, `price_at_time_of_sale`, `total_amount`, `created_at`, `updated_at`) VALUES (5,3,4,1,1200.00,1200.00,'2024-12-19 05:30:03','2024-12-19 05:30:03');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_id`, `quantity`, `price_at_time_of_sale`, `total_amount`, `created_at`, `updated_at`) VALUES (6,3,1,2,500.00,1000.00,'2024-12-19 05:30:03','2024-12-19 05:30:03');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_id`, `quantity`, `price_at_time_of_sale`, `total_amount`, `created_at`, `updated_at`) VALUES (7,4,2,2,100.00,200.00,'2025-01-17 06:15:43','2025-01-17 06:15:43');
INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_id`, `quantity`, `price_at_time_of_sale`, `total_amount`, `created_at`, `updated_at`) VALUES (8,4,3,1,500.00,500.00,'2025-01-17 06:15:43','2025-01-17 06:15:43');
INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (1,'Piece','pc',1,'2024-12-03 11:28:24','2024-12-03 11:30:13');
INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (2,'Tube','tub',1,'2024-12-03 11:28:39','2025-01-18 17:25:41');
INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (3,'Grams','g',1,'2024-12-03 11:29:18','2024-12-03 11:29:18');
INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (4,'Milliliters','ml',1,'2024-12-03 11:31:15','2024-12-03 11:31:15');
INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (5,'Vial','vial',1,'2024-12-03 11:31:33','2024-12-03 11:31:33');
INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (6,'Roll','role',1,'2024-12-03 11:31:55','2024-12-03 11:31:55');
INSERT INTO `unit_types` (`id`, `name`, `abbreviation`, `availability`, `created_at`, `updated_at`) VALUES (7,'Set','set',1,'2024-12-03 11:32:05','2024-12-03 11:32:05');
INSERT INTO `users` (`id`, `profile`, `first_name`, `middle_name`, `last_name`, `address`, `email`, `userType`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES (1,'profiles/TV1z9lj3tXT2sSHdbsIgytTKTqVbk69NB7DbzBWR.jpg','Ibrahim',NULL,'Tangco','Buliclic, Santa Lucia, Ilocos Sur','ibrahim.tangco@lorma.edu','admin','2024-12-17 09:33:10','$2y$10$SVKbhs.vsmDHIxBmachIY.tfYHNaFAGa.pMnvK2FVULPFOWLFWG7K',1,NULL,NULL,'2025-01-18 16:36:35');
INSERT INTO `users` (`id`, `profile`, `first_name`, `middle_name`, `last_name`, `address`, `email`, `userType`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES (2,NULL,'Ira Hans',NULL,'Buguasen','Bayubay Sur, San Vicente, Ilocos Sur','hansbugoasen24@gmail.com','staff','2024-12-29 09:09:45','$2y$10$gk0RxmxD6hdoDrak3iK9WOZw8eGs42hHH8MTt1P03nrZn1/AQ4nMq',1,NULL,'2024-12-17 09:44:18','2024-12-29 09:12:51');
INSERT INTO `users` (`id`, `profile`, `first_name`, `middle_name`, `last_name`, `address`, `email`, `userType`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES (7,NULL,'Blaine','Autumn Buckley','Keller','Magni deleniti culpa, Cabaritan, Santa Lucia, Ilocos Sur','intangco.ccit@unp.edu.ph','superadmin','2024-12-17 11:21:54','$2y$10$TrHtaDYbio3oamOkvU4rpOE7iso9vlQvenag5KWWoz4EYBJsjqr8.',1,'ipwfc5lfmyWIazpZK4YqYC0aSZobjTcqb53gjd6XFw1QXdnYk8KHqchO7e1H','2024-12-17 11:19:59','2024-12-17 11:25:54');
INSERT INTO `users` (`id`, `profile`, `first_name`, `middle_name`, `last_name`, `address`, `email`, `userType`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES (9,NULL,'Charles Edwyne',NULL,'Rabino','Puro, Caoayan, Ilocos Sur','charles@gmail.com','user','2024-12-17 16:23:23','$2y$10$JAcEFCIRQkrgZylVV6uwiesngpQoecNkQcWoYLzVbLOtswDqYbmhy',1,NULL,'2024-12-17 16:22:35','2024-12-17 16:22:35');
INSERT INTO `users` (`id`, `profile`, `first_name`, `middle_name`, `last_name`, `address`, `email`, `userType`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES (10,NULL,'Arlene Jane',NULL,'Duldulao','Lungog, Narvacan, Ilocos Sur','arlene@gmail.com','user','2024-12-17 16:25:58','$2y$10$oswZvyNguu1IcFfIgM4wiOR./w4GTYi5VzpOXuHdF4fhWHFZHwVIy',1,NULL,'2024-12-17 16:25:32','2024-12-17 16:25:32');
INSERT INTO `users` (`id`, `profile`, `first_name`, `middle_name`, `last_name`, `address`, `email`, `userType`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES (11,NULL,'Hannah Rose',NULL,'Schmidt','Balaleng, Bantay, Ilocos Sur','hannah@gmail.com','user','2024-12-17 16:27:22','$2y$10$RUk4ywxDcYKZ5J/Q86ifyunCs1AJMM/HreX8vlyVtUZuRfa/.YuRm',1,NULL,'2024-12-17 16:27:02','2024-12-17 16:27:02');
INSERT INTO `users` (`id`, `profile`, `first_name`, `middle_name`, `last_name`, `address`, `email`, `userType`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES (12,NULL,'Gerome',NULL,'Valdez','Mira, Bantay, Ilocos Sur','gerome@gmail.com','user','2024-12-17 16:32:28','$2y$10$SfzIcf7lzKwbMpMDJS2PCuFAtXAGLdXP4m4g9Q8YWqvCLC6DJTaIK',1,NULL,'2024-12-17 16:32:20','2024-12-17 16:32:20');
INSERT INTO `users` (`id`, `profile`, `first_name`, `middle_name`, `last_name`, `address`, `email`, `userType`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES (13,NULL,'Barang',NULL,'Tangco','Buliclic, Santa Lucia, Ilocos Sur','barangobong13@gmail.com','user','2024-12-27 14:21:15','$2y$10$V13FgajG6HThoE.MvoBrXOtdAiHZTKX3H6y55JSVsJqEJz/hrdMxq',1,NULL,'2024-12-27 14:20:56','2025-01-19 14:23:00');
INSERT INTO `users` (`id`, `profile`, `first_name`, `middle_name`, `last_name`, `address`, `email`, `userType`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES (14,NULL,'Anna','Rina Chandler','Douglas','Quo irure tempora et, Ambalite, Pugo, La Union','qanemoxa@mailinator.com','superadmin',NULL,'$2y$10$6Z6hb1pkFcols/T5eafznuPp9U9S4va.30i75RG0HD7FXkPJrFYh2',1,NULL,'2025-01-18 16:50:29','2025-01-18 17:03:51');
