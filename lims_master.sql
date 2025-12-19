-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2025 at 06:06 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lims_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_settings`
--

CREATE TABLE `business_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_settings`
--

INSERT INTO `business_settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'system_default_currency', '8', '2020-10-11 04:43:44', '2025-06-01 08:15:14'),
(2, 'language', '[{\"id\":\"1\",\"name\":\"english\",\"direction\":\"ltr\",\"code\":\"en\",\"status\":1,\"default\":true},{\"id\":2,\"name\":\"Arabic\",\"code\":\"sa\",\"direction\":\"rtl\",\"status\":1,\"default\":false}]', '2020-10-11 04:53:02', '2025-07-11 15:39:33'),
(3, 'mail_config', '{\"status\":0,\"name\":\"demo\",\"host\":\"mail.demo.com\",\"driver\":\"SMTP\",\"port\":\"587\",\"username\":\"info@demo.com\",\"email_id\":\"info@demo.com\",\"encryption\":\"TLS\",\"password\":\"demo\"}', '2020-10-12 07:29:18', '2021-07-06 09:32:01'),
(4, 'cash_on_delivery', '{\"status\":\"1\"}', NULL, '2021-05-25 18:21:15'),
(6, 'ssl_commerz_payment', '{\"status\":\"0\",\"environment\":\"sandbox\",\"store_id\":\"\",\"store_password\":\"\"}', '2020-11-09 06:36:51', '2023-01-10 03:51:56'),
(7, 'paypal', '{\"status\":\"0\",\"environment\":\"sandbox\",\"paypal_client_id\":\"\",\"paypal_secret\":\"\"}', '2020-11-09 06:51:39', '2023-01-10 03:51:56'),
(8, 'stripe', '{\"status\":\"0\",\"api_key\":null,\"published_key\":null}', '2020-11-09 07:01:47', '2021-07-06 09:30:05'),
(10, 'company_phone', '01150099801', NULL, '2020-12-08 12:15:01'),
(11, 'company_name', 'Tally', NULL, '2021-02-27 16:11:53'),
(12, 'company_web_logo', '2021-05-25-60ad1b313a9d4.png', NULL, '2021-05-25 18:43:45'),
(13, 'company_mobile_logo', '2021-02-20-6030c88c91911.png', NULL, '2021-02-20 12:30:04'),
(14, 'terms_condition', '<p>terms and conditions</p>', NULL, '2021-06-10 22:51:36'),
(15, 'about_us', '<h1><strong>Our Work</strong></h1>\r\n\r\n<h3>We&nbsp;develop simple, reliable,&nbsp; &nbsp; flexible and cost effective solutions which are adaptable to the client&rsquo;s environment. Our team are always equipped with the global technology updates; we evaluate and review our processes and knowledge base to implement the best available solutions that can bring value addition to our customers.</h3>\r\n\r\n<h1><strong>Environment, Employment, and Growth</strong></h1>\r\n\r\n<p>As a company and as individuals, we take great pride in contributing to the growth of our clients, employees, and communities where we live and work.</p>\r\n\r\n<p>Our persistent efforts to improve on our employee skills in a good work environment continue to pay off. We have always been recruiting with great employment opportunities with very high potential to learn, work and earn.</p>\r\n\r\n<h1><strong>Mission</strong></h1>\r\n\r\n<h3>Providing best and reliable IT solutions leveraging global opportunities for quality and cost effective services to our customers and helping them to achieve maximum efficiency and profitability in their business objectives.</h3>\r\n\r\n<h1><strong>Vision</strong></h1>\r\n\r\n<h3>To be an innovative IT &amp; ITES Solution provider and advisor for the enterprise consulting and systems integration in the emerging networked global economy.</h3>', NULL, '2025-06-01 05:30:26'),
(16, 'sms_nexmo', '{\"status\":\"0\",\"nexmo_key\":\"custo5cc042f7abf4c\",\"nexmo_secret\":\"custo5cc042f7abf4c@ssl\"}', NULL, NULL),
(17, 'company_email', 'support@tallybahrain.com', NULL, '2021-03-15 10:29:51'),
(18, 'colors', '{\"primary\":\"#1b7fed\",\"secondary\":\"#000000\",\"primary_light\":\"#CFDFFB\"}', '2020-10-11 10:53:02', '2023-10-13 02:34:53'),
(19, 'company_footer_logo', '2021-02-20-6030c8a02a5f9.png', NULL, '2021-02-20 12:30:24'),
(20, 'company_copyright_text', 'CopyRight Tally@2021', NULL, '2021-03-15 10:30:47'),
(21, 'download_app_apple_stroe', '{\"status\":\"1\",\"link\":\"https:\\/\\/www.target.com\\/s\\/apple+store++now?ref=tgt_adv_XS000000&AFID=msn&fndsrc=tgtao&DFA=71700000012505188&CPNG=Electronics_Portable+Computers&adgroup=Portable+Computers&LID=700000001176246&LNM=apple+store+near+me+now&MT=b&network=s&device=c&location=12&targetid=kwd-81913773633608:loc-12&ds_rl=1246978&ds_rl=1248099&gclsrc=ds\"}', NULL, '2020-12-08 10:54:53'),
(22, 'download_app_google_stroe', '{\"status\":\"1\",\"link\":\"https:\\/\\/play.google.com\\/store?hl=en_US&gl=US\"}', NULL, '2020-12-08 10:54:48'),
(23, 'company_fav_icon', '2021-03-02-603df1634614f.png', '2020-10-11 10:53:02', '2021-03-02 12:03:48'),
(24, 'fcm_topic', '', NULL, NULL),
(25, 'fcm_project_id', '', NULL, NULL),
(26, 'push_notification_key', 'Put your firebase server key here.', NULL, NULL),
(27, 'order_pending_message', '{\"status\":\"1\",\"message\":\"order pen message\"}', NULL, NULL),
(28, 'order_confirmation_msg', '{\"status\":\"1\",\"message\":\"Order con Message\"}', NULL, NULL),
(29, 'order_processing_message', '{\"status\":\"1\",\"message\":\"Order pro Message\"}', NULL, NULL),
(30, 'out_for_delivery_message', '{\"status\":\"1\",\"message\":\"Order ouut Message\"}', NULL, NULL),
(31, 'order_delivered_message', '{\"status\":\"1\",\"message\":\"Order del Message\"}', NULL, NULL),
(32, 'razor_pay', '{\"status\":\"0\",\"razor_key\":null,\"razor_secret\":null}', NULL, '2021-07-06 09:30:14'),
(33, 'sales_commission', '0', NULL, '2025-06-26 06:05:17'),
(34, 'seller_registration', '1', NULL, '2025-06-26 06:04:32'),
(35, 'pnc_language', '[\"en\",\"sa\"]', NULL, NULL),
(36, 'order_returned_message', '{\"status\":\"1\",\"message\":\"Order hh Message\"}', NULL, NULL),
(37, 'order_failed_message', '{\"status\":null,\"message\":\"Order fa Message\"}', NULL, NULL),
(40, 'delivery_boy_assign_message', '{\"status\":0,\"message\":\"\"}', NULL, NULL),
(41, 'delivery_boy_start_message', '{\"status\":0,\"message\":\"\"}', NULL, NULL),
(42, 'delivery_boy_delivered_message', '{\"status\":0,\"message\":\"\"}', NULL, NULL),
(43, 'terms_and_conditions', '', NULL, NULL),
(44, 'minimum_order_value', '1', NULL, NULL),
(45, 'privacy_policy', '<p>my privacy policy</p>\r\n\r\n<p>&nbsp;</p>', NULL, '2021-07-06 08:09:07'),
(46, 'paystack', '{\"status\":\"0\",\"publicKey\":null,\"secretKey\":null,\"paymentUrl\":\"https:\\/\\/api.paystack.co\",\"merchantEmail\":null}', NULL, '2021-07-06 09:30:35'),
(47, 'senang_pay', '{\"status\":\"0\",\"secret_key\":null,\"merchant_id\":null}', NULL, '2021-07-06 09:30:23'),
(48, 'currency_model', 'single_currency', NULL, NULL),
(49, 'social_login', '[{\"login_medium\":\"google\",\"client_id\":\"\",\"client_secret\":\"\",\"status\":\"\"},{\"login_medium\":\"facebook\",\"client_id\":\"\",\"client_secret\":\"\",\"status\":\"\"}]', NULL, NULL),
(50, 'digital_payment', '{\"status\":\"1\"}', NULL, NULL),
(51, 'phone_verification', '', NULL, NULL),
(52, 'email_verification', '', NULL, NULL),
(53, 'order_verification', '0', NULL, NULL),
(54, 'country_code', 'BH', NULL, NULL),
(55, 'pagination_limit', '10', NULL, NULL),
(56, 'shipping_method', 'inhouse_shipping', NULL, NULL),
(57, 'paymob_accept', '{\"status\":\"0\",\"api_key\":\"\",\"iframe_id\":\"\",\"integration_id\":\"\",\"hmac\":\"\"}', NULL, NULL),
(58, 'bkash', '{\"status\":\"0\",\"environment\":\"sandbox\",\"api_key\":\"\",\"api_secret\":\"\",\"username\":\"\",\"password\":\"\"}', NULL, '2023-01-10 03:51:56'),
(59, 'forgot_password_verification', 'email', NULL, NULL),
(60, 'paytabs', '{\"status\":0,\"profile_id\":\"\",\"server_key\":\"\",\"base_url\":\"https:\\/\\/secure-egypt.paytabs.com\\/\"}', NULL, '2021-11-21 01:01:40'),
(61, 'stock_limit', '10', NULL, NULL),
(62, 'flutterwave', '{\"status\":0,\"public_key\":\"\",\"secret_key\":\"\",\"hash\":\"\"}', NULL, NULL),
(63, 'mercadopago', '{\"status\":0,\"public_key\":\"\",\"access_token\":\"\"}', NULL, NULL),
(64, 'announcement', '{\"status\":null,\"color\":null,\"text_color\":null,\"announcement\":null}', NULL, NULL),
(65, 'fawry_pay', '{\"status\":0,\"merchant_code\":\"\",\"security_key\":\"\"}', NULL, '2022-01-18 07:46:30'),
(66, 'recaptcha', '{\"status\":0,\"site_key\":\"\",\"secret_key\":\"\"}', NULL, '2022-01-18 07:46:30'),
(67, 'seller_pos', '1', NULL, '2025-06-26 06:05:17'),
(68, 'liqpay', '{\"status\":0,\"public_key\":\"\",\"private_key\":\"\"}', NULL, NULL),
(69, 'paytm', '{\"status\":0,\"environment\":\"sandbox\",\"paytm_merchant_key\":\"\",\"paytm_merchant_mid\":\"\",\"paytm_merchant_website\":\"\",\"paytm_refund_url\":\"\"}', NULL, '2023-01-10 03:51:56'),
(70, 'refund_day_limit', '0', NULL, NULL),
(71, 'business_mode', 'multi', NULL, NULL),
(72, 'mail_config_sendgrid', '{\"status\":0,\"name\":\"\",\"host\":\"\",\"driver\":\"\",\"port\":\"\",\"username\":\"\",\"email_id\":\"\",\"encryption\":\"\",\"password\":\"\"}', NULL, NULL),
(73, 'decimal_point_settings', '3', NULL, NULL),
(74, 'shop_address', 'PO BOX: 21448, Manama, Bahrain', NULL, NULL),
(75, 'billing_input_by_customer', '1', NULL, NULL),
(76, 'wallet_status', '0', NULL, NULL),
(77, 'loyalty_point_status', '0', NULL, NULL),
(78, 'wallet_add_refund', '0', NULL, NULL),
(79, 'loyalty_point_exchange_rate', '0', NULL, NULL),
(80, 'loyalty_point_item_purchase_point', '0', NULL, NULL),
(81, 'loyalty_point_minimum_point', '0', NULL, NULL),
(82, 'minimum_order_limit', '1', NULL, NULL),
(83, 'product_brand', '1', NULL, NULL),
(84, 'digital_product', '1', NULL, NULL),
(85, 'delivery_boy_expected_delivery_date_message', '{\"status\":0,\"message\":\"\"}', NULL, NULL),
(86, 'order_canceled', '{\"status\":0,\"message\":\"\"}', NULL, NULL),
(87, 'refund-policy', '{\"status\":1,\"content\":\"\"}', NULL, '2023-03-04 04:25:36'),
(88, 'return-policy', '{\"status\":1,\"content\":\"\"}', NULL, '2023-03-04 04:25:36'),
(89, 'cancellation-policy', '{\"status\":1,\"content\":\"\"}', NULL, '2023-03-04 04:25:36'),
(90, 'offline_payment', '{\"status\":0}', NULL, '2023-03-04 04:25:36'),
(91, 'temporary_close', '{\"status\":0}', NULL, '2023-03-04 04:25:36'),
(92, 'vacation_add', '{\"status\":0,\"vacation_start_date\":null,\"vacation_end_date\":null,\"vacation_note\":null}', NULL, '2023-03-04 04:25:36'),
(93, 'cookie_setting', '{\"status\":0,\"cookie_text\":null}', NULL, '2023-03-04 04:25:36'),
(94, 'maximum_otp_hit', '0', NULL, '2023-06-13 10:04:49'),
(95, 'otp_resend_time', '0', NULL, '2023-06-13 10:04:49'),
(96, 'temporary_block_time', '0', NULL, '2023-06-13 10:04:49'),
(97, 'maximum_login_hit', '0', NULL, '2023-06-13 10:04:49'),
(98, 'temporary_login_block_time', '0', NULL, '2023-06-13 10:04:49'),
(99, 'maximum_otp_hit', '0', NULL, '2023-10-13 02:34:53'),
(100, 'otp_resend_time', '0', NULL, '2023-10-13 02:34:53'),
(101, 'temporary_block_time', '0', NULL, '2023-10-13 02:34:53'),
(102, 'maximum_login_hit', '0', NULL, '2023-10-13 02:34:53'),
(103, 'temporary_login_block_time', '0', NULL, '2023-10-13 02:34:53'),
(104, 'apple_login', '[{\"login_medium\":\"apple\",\"client_id\":\"\",\"client_secret\":\"\",\"status\":0,\"team_id\":\"\",\"key_id\":\"\",\"service_file\":\"\",\"redirect_url\":\"\"}]', NULL, '2023-10-13 02:34:53'),
(105, 'ref_earning_status', '0', NULL, '2023-10-13 02:34:53'),
(106, 'ref_earning_exchange_rate', '0', NULL, '2023-10-13 02:34:53'),
(107, 'guest_checkout', '0', NULL, '2023-10-13 08:34:53'),
(108, 'minimum_order_amount', '0', NULL, '2023-10-13 08:34:53'),
(109, 'minimum_order_amount_by_seller', '0', NULL, '2025-06-26 06:04:32'),
(110, 'minimum_order_amount_status', '0', NULL, '2023-10-13 08:34:53'),
(111, 'admin_login_url', 'admin', NULL, '2023-10-13 08:34:53'),
(112, 'employee_login_url', 'employee', NULL, '2023-10-13 08:34:53'),
(113, 'free_delivery_status', '0', NULL, '2023-10-13 08:34:53'),
(114, 'free_delivery_responsibility', 'admin', NULL, '2023-10-13 08:34:53'),
(115, 'free_delivery_over_amount', '0', NULL, '2023-10-13 08:34:53'),
(116, 'free_delivery_over_amount_seller', '0', NULL, '2023-10-13 08:34:53'),
(117, 'add_funds_to_wallet', '0', NULL, '2023-10-13 08:34:53'),
(118, 'minimum_add_fund_amount', '0', NULL, '2023-10-13 08:34:53'),
(119, 'maximum_add_fund_amount', '0', NULL, '2023-10-13 08:34:53'),
(120, 'user_app_version_control', '{\"for_android\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"},\"for_ios\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"}}', NULL, '2023-10-13 08:34:53'),
(121, 'seller_app_version_control', '{\"for_android\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"},\"for_ios\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"}}', NULL, '2023-10-13 08:34:53'),
(122, 'delivery_man_app_version_control', '{\"for_android\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"},\"for_ios\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"}}', NULL, '2023-10-13 08:34:53'),
(123, 'whatsapp', '{\"status\":\"1\",\"phone\":\"+201150099801\"}', '2025-06-01 10:38:24', '2025-06-01 10:38:24'),
(124, 'currency_symbol_position', 'left', NULL, '2023-10-13 08:34:53'),
(125, 'cancellation-policy', '{\"status\":1,\"content\":\"\"}', NULL, NULL),
(126, 'timezone', 'Asia/Kuwait', NULL, NULL),
(127, 'default_location', '{\"lat\":null,\"lng\":null}', NULL, NULL),
(128, 'new_product_approval', '0', NULL, '2025-06-26 06:04:32'),
(129, 'product_wise_shipping_cost_approval', '0', NULL, '2025-06-26 06:04:32');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `result_id` int(11) NOT NULL,
  `sample_id` int(11) DEFAULT NULL,
  `authorized_id` varchar(255) DEFAULT NULL,
  `temp_id` int(11) DEFAULT NULL,
  `generated_by` int(11) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `generated_Date` date DEFAULT NULL,
  `coa_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `result_id`, `sample_id`, `authorized_id`, `temp_id`, `generated_by`, `client`, `generated_Date`, `coa_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 23, 26, '6', NULL, 6, NULL, '2025-08-29', 'COA-68B1C45CB3884', 'issued', '2025-08-29 15:16:44', '2025-08-29 15:16:44'),
(3, 27, 26, '6', NULL, 6, NULL, '2025-08-29', 'COA-68B1CAA88D60A', 'issued', '2025-08-29 15:43:36', '2025-08-29 15:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `certificate_items`
--

CREATE TABLE `certificate_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `certificate_id` bigint(20) UNSIGNED NOT NULL,
  `result_test_method_id` bigint(20) UNSIGNED NOT NULL,
  `result_id` bigint(20) UNSIGNED NOT NULL,
  `test_method_item_id` bigint(20) UNSIGNED NOT NULL,
  `result` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'in_range',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certificate_items`
--

INSERT INTO `certificate_items` (`id`, `certificate_id`, `result_test_method_id`, `result_id`, `test_method_item_id`, `result`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 35, 23, 4, NULL, 'normal', '2025-08-29 15:16:44', '2025-08-29 15:16:44'),
(2, 1, 36, 23, 9, NULL, 'warning', '2025-08-29 15:16:44', '2025-08-29 15:16:44'),
(3, 1, 37, 23, 7, NULL, 'normal', '2025-08-29 15:16:44', '2025-08-29 15:16:44'),
(6, 3, 45, 27, 7, NULL, 'normal', '2025-08-29 15:43:36', '2025-08-29 15:43:36'),
(7, 3, 44, 27, 4, NULL, 'normal', '2025-08-29 15:43:40', '2025-08-29 15:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Eslam', '01150099801', 'eslam@gmail.com', '2025-08-08 12:35:01', '2025-08-08 12:35:01');

-- --------------------------------------------------------

--
-- Table structure for table `coa_generation_settings`
--

CREATE TABLE `coa_generation_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `frequency` tinyint(4) NOT NULL,
  `execution_time` time NOT NULL,
  `generation_condition` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coa_generation_settings_emails`
--

CREATE TABLE `coa_generation_settings_emails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email_id` int(11) NOT NULL,
  `coa_generation_setting_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coa_generation_settings_samples`
--

CREATE TABLE `coa_generation_settings_samples` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coa_generation_setting_id` int(11) NOT NULL,
  `sample_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coa_settings`
--

CREATE TABLE `coa_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `frequency` varchar(255) NOT NULL,
  `day` varchar(255) NOT NULL,
  `execution_time` time NOT NULL,
  `condition` varchar(255) NOT NULL,
  `sample_points` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`sample_points`)),
  `email_recipients` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coa_template_samples`
--

CREATE TABLE `coa_template_samples` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coa_temp_id` bigint(20) UNSIGNED NOT NULL,
  `sample_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coa_template_samples`
--

INSERT INTO `coa_template_samples` (`id`, `coa_temp_id`, `sample_id`, `created_at`, `updated_at`) VALUES
(1, 1, 24, '2025-08-08 11:58:17', '2025-08-08 11:58:17');

-- --------------------------------------------------------

--
-- Table structure for table `c_o_a_settings`
--

CREATE TABLE `c_o_a_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `header_information` tinyint(4) NOT NULL DEFAULT 0,
  `company_logo` tinyint(4) NOT NULL DEFAULT 0,
  `company_name` tinyint(4) NOT NULL DEFAULT 0,
  `laboratory_accreditation` tinyint(4) NOT NULL DEFAULT 0,
  `coa_number` tinyint(4) NOT NULL DEFAULT 0,
  `lims_number` tinyint(4) NOT NULL DEFAULT 0,
  `report_date` tinyint(4) NOT NULL DEFAULT 0,
  `sample_information` tinyint(4) NOT NULL DEFAULT 0,
  `sample_plant` tinyint(4) NOT NULL DEFAULT 0,
  `sample_subplant` tinyint(4) NOT NULL DEFAULT 0,
  `sample_point` tinyint(4) NOT NULL DEFAULT 0,
  `sample_description` tinyint(4) NOT NULL DEFAULT 0,
  `batch_lot_number` tinyint(4) NOT NULL DEFAULT 0,
  `date_received` tinyint(4) NOT NULL DEFAULT 0,
  `date_analyzed` tinyint(4) NOT NULL DEFAULT 0,
  `date_authorized` tinyint(4) NOT NULL DEFAULT 0,
  `test_results` tinyint(4) NOT NULL DEFAULT 0,
  `component_name` tinyint(4) NOT NULL DEFAULT 0,
  `specification` tinyint(4) NOT NULL DEFAULT 0,
  `test_method` tinyint(4) NOT NULL DEFAULT 0,
  `pass_fail_status` tinyint(4) NOT NULL DEFAULT 0,
  `results` tinyint(4) NOT NULL DEFAULT 0,
  `analyst` tinyint(4) NOT NULL DEFAULT 0,
  `unit` tinyint(4) NOT NULL DEFAULT 0,
  `authorization` tinyint(4) NOT NULL DEFAULT 0,
  `analyzed_by` tinyint(4) NOT NULL DEFAULT 0,
  `authorized_by` tinyint(4) NOT NULL DEFAULT 0,
  `digital_signature` tinyint(4) NOT NULL DEFAULT 0,
  `comments` tinyint(4) NOT NULL DEFAULT 0,
  `footer_information` tinyint(4) NOT NULL DEFAULT 0,
  `disclaimer_text` tinyint(4) NOT NULL DEFAULT 0,
  `laboratory_contact_information` tinyint(4) NOT NULL DEFAULT 0,
  `page_numbers` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `c_o_a_settings`
--

INSERT INTO `c_o_a_settings` (`id`, `name`, `value`, `header_information`, `company_logo`, `company_name`, `laboratory_accreditation`, `coa_number`, `lims_number`, `report_date`, `sample_information`, `sample_plant`, `sample_subplant`, `sample_point`, `sample_description`, `batch_lot_number`, `date_received`, `date_analyzed`, `date_authorized`, `test_results`, `component_name`, `specification`, `test_method`, `pass_fail_status`, `results`, `analyst`, `unit`, `authorization`, `analyzed_by`, `authorized_by`, `digital_signature`, `comments`, `footer_information`, `disclaimer_text`, `laboratory_contact_information`, `page_numbers`, `created_at`, `updated_at`) VALUES
(1, 'Default', '1', 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, '2025-06-29 02:52:11', '2025-06-29 02:52:11');

-- --------------------------------------------------------

--
-- Table structure for table `c_o_a_templates`
--

CREATE TABLE `c_o_a_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `header_information` tinyint(4) NOT NULL DEFAULT 0,
  `company_logo` tinyint(4) NOT NULL DEFAULT 0,
  `company_name` tinyint(4) NOT NULL DEFAULT 0,
  `laboratory_accreditation` tinyint(4) NOT NULL DEFAULT 0,
  `coa_number` tinyint(4) NOT NULL DEFAULT 0,
  `lims_number` tinyint(4) NOT NULL DEFAULT 0,
  `report_date` tinyint(4) NOT NULL DEFAULT 0,
  `sample_information` tinyint(4) NOT NULL DEFAULT 0,
  `sample_plant` tinyint(4) NOT NULL DEFAULT 0,
  `sample_subplant` tinyint(4) NOT NULL DEFAULT 0,
  `sample_point` tinyint(4) NOT NULL DEFAULT 0,
  `sample_description` tinyint(4) NOT NULL DEFAULT 0,
  `batch_lot_number` tinyint(4) NOT NULL DEFAULT 0,
  `date_received` tinyint(4) NOT NULL DEFAULT 0,
  `date_analyzed` tinyint(4) NOT NULL DEFAULT 0,
  `date_authorized` tinyint(4) NOT NULL DEFAULT 0,
  `test_results` tinyint(4) NOT NULL DEFAULT 0,
  `component_name` tinyint(4) NOT NULL DEFAULT 0,
  `specification` tinyint(4) NOT NULL DEFAULT 0,
  `test_method` tinyint(4) NOT NULL DEFAULT 0,
  `pass_fail_status` tinyint(4) NOT NULL DEFAULT 0,
  `results` tinyint(4) NOT NULL DEFAULT 0,
  `analyst` tinyint(4) NOT NULL DEFAULT 0,
  `unit` tinyint(4) NOT NULL DEFAULT 0,
  `authorization` tinyint(4) NOT NULL DEFAULT 0,
  `analyzed_by` tinyint(4) NOT NULL DEFAULT 0,
  `authorized_by` tinyint(4) NOT NULL DEFAULT 0,
  `digital_signature` tinyint(4) NOT NULL DEFAULT 0,
  `comments` tinyint(4) NOT NULL DEFAULT 0,
  `footer_information` tinyint(4) NOT NULL DEFAULT 0,
  `disclaimer_text` tinyint(4) NOT NULL DEFAULT 0,
  `laboratory_contact_information` tinyint(4) NOT NULL DEFAULT 0,
  `page_numbers` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `c_o_a_templates`
--

INSERT INTO `c_o_a_templates` (`id`, `name`, `value`, `header_information`, `company_logo`, `company_name`, `laboratory_accreditation`, `coa_number`, `lims_number`, `report_date`, `sample_information`, `sample_plant`, `sample_subplant`, `sample_point`, `sample_description`, `batch_lot_number`, `date_received`, `date_analyzed`, `date_authorized`, `test_results`, `component_name`, `specification`, `test_method`, `pass_fail_status`, `results`, `analyst`, `unit`, `authorization`, `analyzed_by`, `authorized_by`, `digital_signature`, `comments`, `footer_information`, `disclaimer_text`, `laboratory_contact_information`, `page_numbers`, `created_at`, `updated_at`) VALUES
(1, 'Default', NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2025-08-08 11:56:49', '2025-08-08 11:56:49'),
(2, 'Owned', NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-08-08 12:07:01', '2025-08-08 12:07:01');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `field_samples`
--

CREATE TABLE `field_samples` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frequencies`
--

CREATE TABLE `frequencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `time_by_hours` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frequencies`
--

INSERT INTO `frequencies` (`id`, `name`, `time_by_hours`, `created_at`, `updated_at`) VALUES
(1, 'Every Day', '24', '2025-06-04 10:29:40', '2025-06-04 10:29:40'),
(2, 'Every 12 h', '12', '2025-06-04 10:29:55', '2025-06-04 10:29:55');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_09_15_000010_create_tenants_table', 2),
(3, '2024_10_11_010813_create_roles_table', 3),
(4, '2024_10_11_010819_create_sections_table', 4),
(5, '2024_10_11_010828_create_permissions_table', 5),
(6, '2025_04_27_004945_create_subscriptions_table', 6),
(7, '2025_04_27_005132_create_test_methods_table', 7),
(8, '2025_04_27_005310_create_test_method_items_table', 8),
(9, '2025_05_05_192845_create_units_table', 9),
(10, '2025_05_05_192852_create_result_types_table', 9),
(11, '2025_05_08_103100_create_plants_table', 10),
(31, '2014_10_12_100000_create_password_reset_tokens_table', 11),
(32, '2019_08_19_000000_create_failed_jobs_table', 11),
(33, '2019_12_14_000001_create_personal_access_tokens_table', 11),
(34, '2025_04_26_233249_create_admins_table', 11),
(35, '2025_05_08_103255_create_plant_samples_table', 11),
(49, '2025_05_13_125527_create_samples_table', 12),
(76, '2025_05_13_130111_create_sample_test_methods_table', 13),
(77, '2025_05_13_130151_create_field_samples_table', 13),
(78, '2025_05_20_163834_create_sample_test_method_items_table', 13),
(79, '2025_05_21_104245_create_toxic_degrees_table', 13),
(88, '2025_05_21_184910_create_submissions_table', 14),
(89, '2025_05_22_144006_create_submission_items_table', 14),
(95, '2025_05_25_133243_create_sample_routine_schedulers_table', 15),
(96, '2025_05_25_201742_create_frequencies_table', 15),
(97, '2025_06_04_130615_create_sample_routine_scheduler_items_table', 15),
(107, '2025_06_04_153809_create_results_table', 16),
(108, '2025_06_04_155353_create_result_test_methods_table', 16),
(109, '2025_06_04_155440_create_result_test_method_items_table', 16),
(110, '2025_06_25_142809_add_colmun_user_id_to_results_table', 17),
(113, '2025_06_27_223116_create_c_o_a_settings_table', 18),
(114, '2025_07_11_163949_create_business_settings_table', 19),
(115, '2025_06_27_223116_create_c_o_a_templates_table', 20),
(116, '2025_07_13_152418_create_coa_template_samples_table', 20),
(117, '2025_07_13_202727_create_coa_settings_table', 20),
(118, '2025_07_14_221340_create_clients_table', 20),
(120, '2025_07_15_154018_create_certificates_table', 21),
(123, '2025_08_18_051201_create_web_emails_table', 22),
(127, '2025_08_18_054959_create_coa_generation_settings_table', 23),
(128, '2025_08_18_055636_create_coa_generation_settings_emails_table', 23),
(129, '2025_08_18_055654_create_coa_generation_settings_samples_table', 23),
(131, '2025_08_29_150618_create_certificate_items_table', 24);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `allow` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `role_id`, `section_id`, `allow`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(2, 2, 2, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(3, 2, 3, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(4, 2, 4, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(5, 2, 5, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(6, 2, 6, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(7, 2, 7, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(8, 2, 8, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(9, 2, 9, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(10, 2, 10, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(11, 2, 11, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(12, 2, 12, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(13, 2, 13, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(14, 2, 14, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(15, 2, 15, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(16, 2, 16, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(17, 2, 17, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(18, 2, 18, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(19, 2, 19, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(20, 2, 20, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(21, 2, 21, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(22, 2, 22, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(23, 2, 23, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(24, 2, 24, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(25, 2, 25, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(26, 2, 26, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(27, 2, 27, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(28, 2, 28, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(29, 2, 29, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(30, 2, 30, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(31, 2, 31, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(32, 2, 32, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(33, 2, 33, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(34, 2, 34, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(35, 2, 35, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(36, 2, 36, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(37, 2, 37, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(38, 2, 38, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(39, 2, 39, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(40, 2, 40, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(41, 2, 41, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(42, 2, 42, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(43, 2, 43, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(44, 2, 44, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(45, 2, 45, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(46, 2, 46, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(47, 2, 47, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(48, 2, 48, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(49, 2, 49, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(50, 2, 50, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(51, 2, 51, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(52, 2, 52, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(53, 2, 53, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(54, 2, 54, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(55, 2, 55, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(56, 2, 56, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(57, 2, 57, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(58, 2, 58, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(59, 2, 59, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(60, 2, 60, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(61, 2, 61, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(62, 2, 62, 1, '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(63, 2, 63, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(64, 2, 64, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(65, 2, 65, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(66, 2, 66, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(67, 2, 67, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(68, 2, 68, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(69, 2, 69, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(70, 2, 70, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(71, 2, 71, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(72, 2, 72, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(73, 2, 73, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(74, 2, 74, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(75, 2, 75, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(76, 2, 76, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(77, 2, 77, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(78, 2, 78, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(79, 2, 79, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(80, 2, 80, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(81, 2, 81, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(82, 2, 82, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(83, 2, 83, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(84, 2, 84, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(85, 2, 85, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(86, 2, 86, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(87, 2, 87, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(88, 2, 88, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(89, 2, 89, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(90, 2, 90, 1, '2025-08-18 02:39:17', '2025-08-18 02:39:17'),
(91, 2, 91, 1, '2025-08-18 02:45:28', '2025-08-18 02:45:28'),
(92, 2, 92, 1, '2025-08-18 02:45:28', '2025-08-18 02:45:28'),
(93, 2, 93, 1, '2025-08-18 02:45:28', '2025-08-18 02:45:28'),
(94, 2, 94, 1, '2025-08-18 02:45:28', '2025-08-18 02:45:28'),
(95, 2, 95, 1, '2025-08-18 02:45:28', '2025-08-18 02:45:28'),
(144, 2, 1, 1, NULL, NULL),
(145, 2, 2, 1, NULL, NULL),
(146, 2, 3, 1, NULL, NULL),
(147, 2, 4, 1, NULL, NULL),
(148, 2, 5, 1, NULL, NULL),
(149, 2, 6, 1, NULL, NULL),
(150, 2, 7, 1, NULL, NULL),
(151, 2, 8, 1, NULL, NULL),
(152, 2, 9, 1, NULL, NULL),
(153, 2, 10, 1, NULL, NULL),
(154, 2, 11, 1, NULL, NULL),
(155, 2, 12, 1, NULL, NULL),
(156, 2, 13, 1, NULL, NULL),
(157, 2, 14, 1, NULL, NULL),
(158, 2, 15, 1, NULL, NULL),
(159, 2, 16, 1, NULL, NULL),
(160, 2, 17, 1, NULL, NULL),
(161, 2, 18, 1, NULL, NULL),
(162, 2, 19, 1, NULL, NULL),
(163, 2, 20, 1, NULL, NULL),
(164, 2, 21, 1, NULL, NULL),
(165, 2, 22, 1, NULL, NULL),
(166, 2, 23, 1, NULL, NULL),
(167, 2, 24, 1, NULL, NULL),
(168, 2, 25, 1, NULL, NULL),
(169, 2, 26, 1, NULL, NULL),
(170, 2, 27, 1, NULL, NULL),
(171, 2, 28, 1, NULL, NULL),
(172, 2, 29, 1, NULL, NULL),
(173, 2, 30, 1, NULL, NULL),
(174, 2, 31, 1, NULL, NULL),
(175, 2, 32, 1, NULL, NULL),
(176, 2, 33, 1, NULL, NULL),
(177, 2, 34, 1, NULL, NULL),
(178, 2, 35, 1, NULL, NULL),
(179, 2, 36, 1, NULL, NULL),
(180, 2, 37, 1, NULL, NULL),
(181, 2, 38, 1, NULL, NULL),
(182, 2, 39, 1, NULL, NULL),
(183, 2, 40, 1, NULL, NULL),
(184, 2, 41, 1, NULL, NULL),
(185, 2, 42, 1, NULL, NULL),
(186, 2, 43, 1, NULL, NULL),
(187, 2, 44, 1, NULL, NULL),
(188, 2, 45, 1, NULL, NULL),
(189, 2, 46, 1, NULL, NULL),
(190, 2, 47, 1, NULL, NULL),
(191, 2, 48, 1, NULL, NULL),
(192, 2, 49, 1, NULL, NULL),
(193, 2, 50, 1, NULL, NULL),
(194, 2, 51, 1, NULL, NULL),
(195, 2, 52, 1, NULL, NULL),
(196, 2, 53, 1, NULL, NULL),
(197, 2, 54, 1, NULL, NULL),
(198, 2, 55, 1, NULL, NULL),
(199, 2, 56, 1, NULL, NULL),
(200, 2, 57, 1, NULL, NULL),
(201, 2, 58, 1, NULL, NULL),
(202, 2, 59, 1, NULL, NULL),
(203, 2, 60, 1, NULL, NULL),
(204, 2, 61, 1, NULL, NULL),
(205, 2, 62, 1, NULL, NULL),
(206, 2, 63, 1, NULL, NULL),
(207, 2, 64, 1, NULL, NULL),
(208, 2, 65, 1, NULL, NULL),
(209, 2, 66, 1, NULL, NULL),
(210, 2, 67, 1, NULL, NULL),
(211, 2, 68, 1, NULL, NULL),
(212, 2, 69, 1, NULL, NULL),
(213, 2, 70, 1, NULL, NULL),
(214, 2, 71, 1, NULL, NULL),
(215, 2, 72, 1, NULL, NULL),
(216, 2, 73, 1, NULL, NULL),
(217, 2, 74, 1, NULL, NULL),
(218, 2, 75, 1, NULL, NULL),
(219, 2, 76, 1, NULL, NULL),
(220, 2, 77, 1, NULL, NULL),
(221, 2, 78, 1, NULL, NULL),
(222, 2, 80, 1, NULL, NULL),
(223, 2, 81, 1, NULL, NULL),
(224, 2, 82, 1, NULL, NULL),
(225, 2, 83, 1, NULL, NULL),
(226, 2, 84, 1, NULL, NULL),
(227, 2, 85, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plants`
--

CREATE TABLE `plants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `plant_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plants`
--

INSERT INTO `plants` (`id`, `name`, `plant_id`, `created_at`, `updated_at`) VALUES
(22, 'Plant A', NULL, '2025-06-01 15:13:10', '2025-06-01 15:13:10'),
(23, 'Plant B', 22, '2025-06-01 15:13:40', '2025-06-01 15:13:40'),
(24, 'Plant C', NULL, '2025-06-01 15:13:48', '2025-06-01 15:13:48');

-- --------------------------------------------------------

--
-- Table structure for table `plant_samples`
--

CREATE TABLE `plant_samples` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `plant_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plant_samples`
--

INSERT INTO `plant_samples` (`id`, `name`, `plant_id`, `created_at`, `updated_at`) VALUES
(7, 'Sample A', 22, '2025-06-01 15:58:37', '2025-06-01 15:58:37'),
(8, 'Sample B', 23, '2025-06-01 15:58:50', '2025-06-01 15:58:50'),
(9, 'Sample C', 24, '2025-06-01 16:01:02', '2025-06-01 16:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `plant_id` bigint(20) UNSIGNED NOT NULL,
  `sub_plant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plant_sample_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sample_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `priority` enum('high','normal','critical') NOT NULL DEFAULT 'normal',
  `sampling_date_and_time` datetime DEFAULT NULL,
  `internal_comment` text DEFAULT NULL,
  `external_comment` text DEFAULT NULL,
  `submission_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `submission_id`, `plant_id`, `sub_plant_id`, `plant_sample_id`, `sample_id`, `user_id`, `priority`, `sampling_date_and_time`, `internal_comment`, `external_comment`, `submission_number`, `status`, `created_at`, `updated_at`) VALUES
(23, 18, 24, NULL, 9, 26, 6, 'high', '2025-08-17 14:33:00', NULL, NULL, 'SUB-000018', 'approve', '2025-08-17 08:33:52', '2025-08-29 15:16:44'),
(27, 19, 24, NULL, 9, 26, 6, 'normal', '2025-08-29 18:21:00', NULL, NULL, 'SUB-000019', 'completed', '2025-08-29 15:43:26', '2025-08-29 15:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `result_test_methods`
--

CREATE TABLE `result_test_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `result_id` bigint(20) UNSIGNED NOT NULL,
  `test_method_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'in_range',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `result_test_methods`
--

INSERT INTO `result_test_methods` (`id`, `result_id`, `test_method_id`, `status`, `created_at`, `updated_at`) VALUES
(35, 23, 8, 'in_range', '2025-08-17 08:33:52', '2025-08-17 08:33:52'),
(36, 23, 11, 'in_range', '2025-08-17 08:33:52', '2025-08-17 08:33:52'),
(37, 23, 9, 'in_range', '2025-08-17 08:33:52', '2025-08-17 08:33:52'),
(44, 27, 8, 'in_range', '2025-08-29 15:43:26', '2025-08-29 15:43:26'),
(45, 27, 9, 'in_range', '2025-08-29 15:43:26', '2025-08-29 15:43:26');

-- --------------------------------------------------------

--
-- Table structure for table `result_test_method_items`
--

CREATE TABLE `result_test_method_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `result_test_method_id` bigint(20) UNSIGNED NOT NULL,
  `result_id` bigint(20) UNSIGNED NOT NULL,
  `test_method_item_id` bigint(20) UNSIGNED NOT NULL,
  `submission_item` int(255) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'in_range',
  `acceptance_status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `result_test_method_items`
--

INSERT INTO `result_test_method_items` (`id`, `result_test_method_id`, `result_id`, `test_method_item_id`, `submission_item`, `result`, `status`, `acceptance_status`, `created_at`, `updated_at`) VALUES
(31, 35, 23, 4, 29, '453', 'normal', 'approve', '2025-08-17 08:33:52', '2025-08-29 15:16:44'),
(32, 36, 23, 9, 30, '7657', 'warning', 'approve', '2025-08-17 09:04:46', '2025-08-29 15:16:44'),
(33, 37, 23, 7, 31, '564', 'normal', 'approve', '2025-08-17 09:04:46', '2025-08-29 15:16:44'),
(40, 44, 27, 4, 32, '453', 'normal', 'approve', '2025-08-29 15:43:26', '2025-08-29 15:43:40'),
(41, 45, 27, 7, 33, '564', 'normal', 'approve', '2025-08-29 15:43:26', '2025-08-29 15:43:36');

-- --------------------------------------------------------

--
-- Table structure for table `result_types`
--

CREATE TABLE `result_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `result_types`
--

INSERT INTO `result_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'number', '2025-05-05 17:12:47', '2025-05-05 17:12:47'),
(2, 'text2', '2025-05-05 17:12:59', '2025-05-21 07:34:40');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `caption` varchar(64) NOT NULL,
  `users_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `caption`, `users_count`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 'user', 'User role', 0, 0, '2025-08-18 02:45:27', '2025-08-18 02:45:28'),
(2, 'admin', 'Admin role', 0, 1, '2025-08-18 02:45:28', '2025-08-18 02:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `samples`
--

CREATE TABLE `samples` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plant_id` bigint(20) UNSIGNED NOT NULL,
  `sub_plant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plant_sample_id` bigint(20) UNSIGNED DEFAULT NULL,
  `toxic` tinyint(4) DEFAULT NULL,
  `coa` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `samples`
--

INSERT INTO `samples` (`id`, `plant_id`, `sub_plant_id`, `plant_sample_id`, `toxic`, `coa`, `created_at`, `updated_at`) VALUES
(24, 22, NULL, 7, NULL, NULL, '2025-07-20 19:16:18', '2025-07-20 19:16:18'),
(26, 24, NULL, 9, NULL, NULL, '2025-07-22 14:41:49', '2025-08-29 15:02:29');

-- --------------------------------------------------------

--
-- Table structure for table `sample_routine_schedulers`
--

CREATE TABLE `sample_routine_schedulers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sample_id` bigint(20) UNSIGNED NOT NULL,
  `plant_id` bigint(20) UNSIGNED NOT NULL,
  `sub_plant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `submission_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sample_routine_schedulers`
--

INSERT INTO `sample_routine_schedulers` (`id`, `sample_id`, `plant_id`, `sub_plant_id`, `submission_number`, `status`, `created_at`, `updated_at`) VALUES
(2, 26, 24, NULL, 'SUB-000002', 'pending', '2025-08-17 11:20:36', '2025-08-17 11:20:36');

-- --------------------------------------------------------

--
-- Table structure for table `sample_routine_scheduler_items`
--

CREATE TABLE `sample_routine_scheduler_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sample_scheduler_id` bigint(20) UNSIGNED NOT NULL,
  `sample_id` bigint(20) UNSIGNED NOT NULL,
  `plant_id` bigint(20) UNSIGNED NOT NULL,
  `sub_plant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `frequency_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_hour` varchar(255) DEFAULT NULL,
  `test_method_ids` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sample_routine_scheduler_items`
--

INSERT INTO `sample_routine_scheduler_items` (`id`, `sample_scheduler_id`, `sample_id`, `plant_id`, `sub_plant_id`, `frequency_id`, `schedule_hour`, `test_method_ids`, `created_at`, `updated_at`) VALUES
(2, 2, 26, 24, NULL, 2, '2', 8, '2025-08-17 11:20:37', '2025-08-17 11:20:37'),
(3, 2, 26, 24, NULL, 2, '2', 11, '2025-08-17 11:20:37', '2025-08-17 11:20:37');

-- --------------------------------------------------------

--
-- Table structure for table `sample_test_methods`
--

CREATE TABLE `sample_test_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sample_id` bigint(20) UNSIGNED NOT NULL,
  `test_method_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sample_test_methods`
--

INSERT INTO `sample_test_methods` (`id`, `sample_id`, `test_method_id`, `created_at`, `updated_at`) VALUES
(26, 24, 8, '2025-07-20 19:16:18', '2025-07-20 19:16:18'),
(27, 24, 9, '2025-07-20 19:16:18', '2025-07-22 12:57:40'),
(30, 26, 8, '2025-07-22 14:41:49', '2025-07-22 14:41:49'),
(31, 26, 11, '2025-07-22 14:41:49', '2025-07-22 14:41:49'),
(32, 26, 9, '2025-07-22 14:41:49', '2025-07-22 14:41:49');

-- --------------------------------------------------------

--
-- Table structure for table `sample_test_method_items`
--

CREATE TABLE `sample_test_method_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sample_id` bigint(20) UNSIGNED NOT NULL,
  `test_method_id` bigint(20) UNSIGNED NOT NULL,
  `test_method_item_id` bigint(20) UNSIGNED NOT NULL,
  `warning_limit` varchar(255) DEFAULT NULL,
  `warning_limit_end` varchar(255) DEFAULT NULL,
  `action_limit` varchar(255) DEFAULT NULL,
  `action_limit_end` varchar(255) DEFAULT NULL,
  `action_limit_type` varchar(255) DEFAULT NULL,
  `warning_limit_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sample_test_method_items`
--

INSERT INTO `sample_test_method_items` (`id`, `sample_id`, `test_method_id`, `test_method_item_id`, `warning_limit`, `warning_limit_end`, `action_limit`, `action_limit_end`, `action_limit_type`, `warning_limit_type`, `created_at`, `updated_at`) VALUES
(29, 24, 26, 4, '245', NULL, '646', '54645', '8646', '<', NULL, NULL),
(33, 26, 30, 4, '5345', NULL, '6776', NULL, '>', '<', NULL, NULL),
(34, 26, 31, 9, '7657', NULL, '8778', NULL, '=', '>=', NULL, NULL),
(35, 26, 32, 7, '7587', NULL, '7888', NULL, '>', '>', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `section_group_id` int(10) UNSIGNED DEFAULT NULL,
  `caption` varchar(128) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `section_group_id`, `caption`, `created_at`, `updated_at`) VALUES
(1, 'admin_general_dashboard', NULL, 'admin_general_dashboard', '2025-04-28 23:29:38', '2025-04-28 23:29:38'),
(2, 'admin_general_dashboard_show', 1, 'general_dashboard_page', '2025-04-28 23:29:38', '2025-04-28 23:29:38'),
(3, 'admin_roles', NULL, 'admin_roles', '2025-04-28 23:29:38', '2025-04-28 23:29:38'),
(4, 'show_admin_roles', 3, 'show_admin_roles', '2025-04-28 23:29:38', '2025-04-28 23:29:38'),
(5, 'create_admin_roles', 3, 'create_admin_roles', '2025-04-28 23:29:38', '2025-04-28 23:29:38'),
(6, 'edit_admin_roles', 3, 'edit_admin_roles', '2025-04-28 23:29:38', '2025-04-28 23:29:38'),
(7, 'update_admin_roles', 3, 'update_admin_roles', '2025-04-28 23:29:38', '2025-04-28 23:29:38'),
(8, 'delete_admin_roles', 3, 'delete_admin_roles', '2025-04-28 23:29:38', '2025-04-28 23:29:38'),
(9, 'user_management', NULL, 'user_management', '2025-04-28 23:29:39', '2025-04-28 23:29:39'),
(10, 'all_users', 9, 'show_all_users', '2025-04-28 23:29:39', '2025-04-28 23:29:39'),
(11, 'change_users_role', 9, 'change_users_role', '2025-04-28 23:29:39', '2025-04-28 23:29:39'),
(12, 'change_users_status', 9, 'change_users_status', '2025-04-28 23:29:39', '2025-04-28 23:29:39'),
(13, 'delete_user', 9, 'delete_user', '2025-04-28 23:29:39', '2025-04-28 23:29:39'),
(14, 'edit_user', 9, 'edit_user', '2025-04-28 23:29:39', '2025-04-28 23:29:39'),
(15, 'create_user', 9, 'create_user', '2025-04-28 23:29:39', '2025-04-28 23:29:39'),
(16, 'test_method_management', NULL, 'test_method_management', '2025-04-28 23:29:39', '2025-05-01 17:00:49'),
(17, 'all_test_methods', 16, 'show_all_test_methods', '2025-04-28 23:29:39', '2025-05-01 17:00:49'),
(18, 'create_test_method', 16, 'create_test_method', '2025-04-28 23:29:39', '2025-05-05 17:24:44'),
(19, 'change_test_methods_role', 16, 'change_test_methods_role', '2025-04-28 23:29:39', '2025-05-05 17:24:44'),
(20, 'change_test_methods_status', 16, 'change_test_methods_status', '2025-04-28 23:29:39', '2025-05-05 17:24:44'),
(21, 'delete_test_method', 16, 'delete_test_method', '2025-04-28 23:29:39', '2025-05-05 17:24:44'),
(22, 'edit_test_method', 16, 'edit_test_method', '2025-04-28 23:29:39', '2025-05-05 17:24:44'),
(23, 'unit_management', NULL, 'unit_management', '2025-05-05 16:40:34', '2025-05-05 16:46:31'),
(24, 'change_units_role', 23, 'change_units_role', '2025-05-05 16:40:34', '2025-05-05 16:46:31'),
(25, 'change_units_status', 23, 'change_units_status', '2025-05-05 16:40:34', '2025-05-05 16:46:31'),
(26, 'delete_unit', 23, 'delete_unit', '2025-05-05 16:40:34', '2025-05-05 16:46:31'),
(27, 'edit_unit', 23, 'edit_unit', '2025-05-05 16:40:34', '2025-05-05 16:46:31'),
(28, 'create_unit', 23, 'create_unit', '2025-05-05 16:40:34', '2025-05-05 16:46:31'),
(29, 'all_units', 23, 'show_all_units', '2025-05-05 16:40:34', '2025-05-05 16:46:31'),
(30, 'result_type_management', NULL, 'result_type_management', '2025-05-05 16:40:34', '2025-05-05 16:46:31'),
(31, 'change_result_types_status', 30, 'change_result_types_status', '2025-05-05 16:40:34', '2025-05-05 16:46:31'),
(32, 'delete_result_type', 30, 'delete_result_type', '2025-05-05 16:40:34', '2025-05-05 16:46:31'),
(33, 'edit_result_type', 30, 'edit_result_type', '2025-05-05 16:40:34', '2025-05-05 16:46:31'),
(34, 'create_result_type', 30, 'create_result_type', '2025-05-05 16:40:34', '2025-05-05 16:46:31'),
(35, 'change_result_types_role', 30, 'change_result_types_role', '2025-05-05 16:46:31', '2025-05-05 16:46:31'),
(36, 'all_result_types', 30, 'show_all_result_types', '2025-05-05 16:46:31', '2025-05-05 16:46:31'),
(37, 'sample_management', NULL, 'sample_management', '2025-05-08 07:24:02', '2025-05-08 07:24:02'),
(38, 'change_samples_status', 37, 'change_samples_status', '2025-05-08 07:24:02', '2025-05-08 07:24:02'),
(39, 'delete_sample', 37, 'delete_sample', '2025-05-08 07:24:02', '2025-05-08 07:24:02'),
(40, 'edit_sample', 37, 'edit_sample', '2025-05-08 07:24:02', '2025-05-08 07:24:02'),
(41, 'create_sample', 37, 'create_sample', '2025-05-08 07:24:02', '2025-05-08 07:24:02'),
(42, 'all_samples', 37, 'show_all_samples', '2025-05-08 07:24:02', '2025-05-08 07:24:02'),
(43, 'plant_management', NULL, 'plant_management', '2025-05-08 07:24:02', '2025-05-08 07:24:02'),
(44, 'change_plants_status', 43, 'change_plants_status', '2025-05-08 07:24:02', '2025-05-08 07:24:02'),
(45, 'delete_plant', 43, 'delete_plant', '2025-05-08 07:24:02', '2025-05-08 07:24:02'),
(46, 'edit_plant', 43, 'edit_plant', '2025-05-08 07:24:02', '2025-05-08 07:24:02'),
(47, 'create_plant', 43, 'create_plant', '2025-05-08 07:24:02', '2025-05-08 07:24:02'),
(48, 'all_plants', 43, 'show_all_plants', '2025-05-08 07:24:02', '2025-05-08 07:24:02'),
(49, 'toxic_degree_management', NULL, 'toxic_degree_management', '2025-05-21 07:47:35', '2025-05-21 07:47:35'),
(50, 'change_toxic_degrees_status', 49, 'change_toxic_degrees_status', '2025-05-21 07:47:35', '2025-05-21 07:47:35'),
(51, 'delete_toxic_degree', 49, 'delete_toxic_degree', '2025-05-21 07:47:35', '2025-05-21 07:47:35'),
(52, 'edit_toxic_degree', 49, 'edit_toxic_degree', '2025-05-21 07:47:35', '2025-05-21 07:47:35'),
(53, 'create_toxic_degree', 49, 'create_toxic_degree', '2025-05-21 07:47:35', '2025-05-21 07:47:35'),
(54, 'all_toxic_degrees', 49, 'show_all_toxic_degrees', '2025-05-21 07:47:35', '2025-05-21 07:47:35'),
(55, 'submission_management', NULL, 'submission_management', '2025-05-21 15:53:56', '2025-05-21 15:53:56'),
(56, 'change_submissions_status', 55, 'change_submissions_status', '2025-05-21 15:53:56', '2025-05-21 15:53:56'),
(57, 'delete_submission', 55, 'delete_submission', '2025-05-21 15:53:56', '2025-05-21 15:53:56'),
(58, 'edit_submission', 55, 'edit_submission', '2025-05-21 15:53:56', '2025-05-21 15:53:56'),
(59, 'create_submission', 55, 'create_submission', '2025-05-21 15:53:56', '2025-05-21 15:53:56'),
(60, 'all_submissions', 55, 'show_all_submissions', '2025-05-21 15:53:56', '2025-05-21 15:53:56'),
(61, 'sample_routine_scheduler', NULL, 'sample_routine_scheduler', '2025-05-25 17:32:19', '2025-05-25 17:32:19'),
(62, 'change_sample_routine_scheduler_status', 61, 'change_sample_routine_scheduler_status', '2025-05-25 17:32:19', '2025-05-25 17:32:19'),
(63, 'delete_sample_routine_scheduler', 61, 'delete_sample_routine_scheduler', '2025-05-25 17:32:19', '2025-05-25 17:32:19'),
(64, 'edit_sample_routine_scheduler', 61, 'edit_sample_routine_scheduler', '2025-05-25 17:32:19', '2025-05-25 17:32:19'),
(65, 'create_sample_routine_scheduler', 61, 'create_sample_routine_scheduler', '2025-05-25 17:32:19', '2025-05-25 17:32:19'),
(66, 'all_sample_routine_scheduler', 61, 'show_all_sample_routine_scheduler', '2025-05-25 17:32:19', '2025-05-25 17:32:19'),
(67, 'frequency_management', NULL, 'frequency_management', '2025-05-25 17:32:19', '2025-05-25 17:32:19'),
(68, 'change_frequencies_status', 67, 'change_frequencies_status', '2025-05-25 17:32:19', '2025-05-25 17:32:19'),
(69, 'delete_frequency', 67, 'delete_frequency', '2025-05-25 17:32:19', '2025-05-25 17:32:19'),
(70, 'edit_frequency', 67, 'edit_frequency', '2025-05-25 17:32:19', '2025-05-25 17:32:19'),
(71, 'create_frequency', 67, 'create_frequency', '2025-05-25 17:32:19', '2025-05-25 17:32:19'),
(72, 'all_frequencies', 67, 'show_all_frequencies', '2025-05-25 17:32:19', '2025-05-25 17:32:19'),
(73, 'result_management', NULL, 'result_management', '2025-06-04 12:32:06', '2025-06-04 12:32:06'),
(74, 'change_results_status', 73, 'change_results_status', '2025-06-04 12:32:06', '2025-06-04 12:32:06'),
(75, 'delete_result', 73, 'delete_result', '2025-06-04 12:32:06', '2025-06-04 12:32:06'),
(76, 'edit_result', 73, 'edit_result', '2025-06-04 12:32:06', '2025-06-04 12:32:06'),
(77, 'create_result', 73, 'create_result', '2025-06-04 12:32:06', '2025-06-04 12:32:06'),
(78, 'all_results', 73, 'show_all_results', '2025-06-04 12:32:06', '2025-06-04 12:32:06'),
(79, 'coa_management', NULL, 'coa_management', '2025-06-29 01:50:03', '2025-06-29 01:50:03'),
(80, 'change_coas_status', 79, 'change_coas_status', '2025-06-29 01:50:03', '2025-08-18 02:45:28'),
(81, 'delete_coa', 79, 'delete_coa', '2025-06-29 01:50:03', '2025-08-18 02:45:28'),
(82, 'edit_coa', 79, 'edit_coa', '2025-06-29 01:50:03', '2025-08-18 02:45:28'),
(83, 'create_coa', 79, 'create_coa', '2025-06-29 01:50:03', '2025-08-18 02:45:28'),
(84, 'all_coas', 79, 'show_all_coas', '2025-06-29 01:50:03', '2025-08-18 02:45:28'),
(85, 'coa_settings', 79, 'coa_settings', '2025-06-29 01:50:03', '2025-08-18 02:45:28'),
(86, 'emails', NULL, 'emails', '2025-08-18 02:39:16', '2025-08-18 02:39:16'),
(87, 'delete_email', 86, 'delete_email', '2025-08-18 02:39:16', '2025-08-18 02:45:28'),
(88, 'edit_email', 86, 'edit_email', '2025-08-18 02:39:16', '2025-08-18 02:45:28'),
(89, 'create_email', 86, 'create_email', '2025-08-18 02:39:16', '2025-08-18 02:45:28'),
(90, 'all_emails', 86, 'show_all_emails', '2025-08-18 02:39:16', '2025-08-18 02:45:28'),
(91, 'coa_generation_settings', NULL, 'coa_generation_settings', '2025-08-18 02:45:28', '2025-08-18 02:45:28'),
(92, 'delete_coa_generation_setting', 91, 'delete_coa_generation_setting', '2025-08-18 02:45:28', '2025-08-18 02:45:28'),
(93, 'edit_coa_generation_setting', 91, 'edit_coa_generation_setting', '2025-08-18 02:45:28', '2025-08-18 02:45:28'),
(94, 'create_coa_generation_setting', 91, 'create_coa_generation_setting', '2025-08-18 02:45:28', '2025-08-18 02:45:28'),
(95, 'all_coa_generation_settings', 91, 'show_all_emails', '2025-08-18 02:45:28', '2025-08-18 02:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plant_id` bigint(20) UNSIGNED NOT NULL,
  `sub_plant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plant_sample_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sample_id` bigint(20) UNSIGNED DEFAULT NULL,
  `priority` enum('high','normal','critical') NOT NULL DEFAULT 'normal',
  `sampling_date_and_time` datetime DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `submission_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'first_step',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `plant_id`, `sub_plant_id`, `plant_sample_id`, `sample_id`, `priority`, `sampling_date_and_time`, `comment`, `submission_number`, `status`, `created_at`, `updated_at`) VALUES
(18, 24, NULL, 9, 26, 'high', '2025-08-17 14:33:00', NULL, 'SUB-000018', 'fifth_step', '2025-08-17 08:33:09', '2025-08-17 09:04:46'),
(19, 24, NULL, 9, 26, 'normal', '2025-08-29 18:21:00', NULL, 'SUB-000019', 'fifth_step', '2025-08-29 15:21:42', '2025-08-29 15:43:26');

-- --------------------------------------------------------

--
-- Table structure for table `submission_items`
--

CREATE TABLE `submission_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `sample_test_method_item_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `submission_items`
--

INSERT INTO `submission_items` (`id`, `submission_id`, `sample_test_method_item_id`, `created_at`, `updated_at`) VALUES
(29, 18, 30, NULL, NULL),
(30, 18, 31, NULL, NULL),
(31, 18, 32, NULL, NULL),
(32, 19, 30, NULL, NULL),
(33, 19, 32, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `domain` varchar(255) NOT NULL,
  `database_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`database_options`)),
  `my_name` varchar(255) DEFAULT NULL,
  `tenant_id` varchar(255) NOT NULL,
  `user_count` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `setup_cost` varchar(255) DEFAULT NULL,
  `monthly_subscription_user` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `email` varchar(255) DEFAULT NULL,
  `applicable_date` date DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `name`, `phone`, `logo`, `domain`, `database_options`, `my_name`, `tenant_id`, `user_count`, `setup_cost`, `monthly_subscription_user`, `status`, `email`, `applicable_date`, `creation_date`, `created_at`, `updated_at`) VALUES
(6, 'eslam badawy', '115009801', NULL, '3.localhost', '{\"dbname\":\"lims_6\"}', NULL, '3', 5, '0', NULL, 'active', 'e@badawy.e', NULL, NULL, '2025-04-28 23:43:47', '2025-04-28 23:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `test_methods`
--

CREATE TABLE `test_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('added','not_added') NOT NULL DEFAULT 'added',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_methods`
--

INSERT INTO `test_methods` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(8, 'ICP Analysis', 'ASTM D1976', 'added', '2025-05-01 19:18:35', '2025-05-01 19:48:10'),
(9, 'PH', 'any', 'added', '2025-05-04 18:24:45', '2025-05-04 18:24:45'),
(11, 'New Test Method', NULL, 'added', '2025-05-21 08:00:22', '2025-05-21 08:00:22');

-- --------------------------------------------------------

--
-- Table structure for table `test_method_items`
--

CREATE TABLE `test_method_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_method_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `unit` int(11) DEFAULT NULL,
  `result_type` int(11) DEFAULT NULL,
  `precision` varchar(255) DEFAULT NULL,
  `lower_range` varchar(255) DEFAULT NULL,
  `upper_range` varchar(255) DEFAULT NULL,
  `reportable` enum('0','1') DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_method_items`
--

INSERT INTO `test_method_items` (`id`, `test_method_id`, `name`, `unit`, `result_type`, `precision`, `lower_range`, `upper_range`, `reportable`, `created_at`, `updated_at`) VALUES
(4, 8, 'Soduim (Na)', 3, 1, '2', '0.1', '1000', '1', '2025-05-01 19:18:35', '2025-05-01 19:18:35'),
(5, 8, 'Potassium (K)', 3, 2, NULL, '0.1', '1000', NULL, '2025-05-01 19:18:35', '2025-05-01 19:18:35'),
(6, 8, 'Iron (Fe)', 3, 1, NULL, '0.1', '100', NULL, '2025-05-01 19:18:35', '2025-05-01 19:18:35'),
(7, 9, 'ph', 3, 2, '2', '0', '14', '1', '2025-05-04 18:24:45', '2025-05-04 18:24:45'),
(9, 11, 'n', 3, 1, '32', '432', '43234', '1', '2025-05-21 08:00:22', '2025-05-21 08:00:22'),
(10, 11, 'n1', 4, 2, '423', '34545', '435563', '0', '2025-05-21 08:00:22', '2025-05-21 08:00:22'),
(11, 11, 'wrg', 4, 1, '2', '345', '4343', '0', '2025-07-22 14:32:44', '2025-07-22 14:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `toxic_degrees`
--

CREATE TABLE `toxic_degrees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `created_at`, `updated_at`) VALUES
(3, 'ppm', '2025-05-05 16:59:06', '2025-05-05 16:59:06'),
(4, 'ppb', '2025-05-05 16:59:47', '2025-05-05 16:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_name` varchar(64) NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `my_name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `signature` longtext DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `user_name`, `phone`, `password`, `role_name`, `role_id`, `my_name`, `slug`, `signature`, `remember_token`, `created_at`, `updated_at`) VALUES
(6, 'eslam badawy', 'e@badawy.e', 'admin22', '115009801', '$2y$10$ftlzU0f6t3hfwXY1rwn/iOC3tm8Evz0jBJPnRjvmDER5Hq1BwOi1.', 'admin', 2, '12345', 'eslam-lims', 'sign_68725ef5676ea.png', '2dqt9FMTnuW1NNtnS2C5yDj3ccDNZJgkgFsSJv0vKVFUmsKEMg2LZATHv7ov', '2025-04-28 23:43:48', '2025-07-12 10:11:17'),
(8, 'eslam badawy', 'e@badawy.eew', 'admin', '115009801', '$2y$10$nLRYUHvFJOPNBEkuqsextOJuNJ6sPJ3/MjlHgOU2xZkhZW7Ff5BOq', 'user', 1, NULL, NULL, NULL, 'Wh7F3zVlX3ML5ZDjNaWgJw1JDNnaRWYLmYueL2vFazIQsROv7V7DMKZcmtiZ', '2025-04-30 21:02:38', '2025-04-30 21:03:30');

-- --------------------------------------------------------

--
-- Table structure for table `web_emails`
--

CREATE TABLE `web_emails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_emails`
--

INSERT INTO `web_emails` (`id`, `email`, `created_at`, `updated_at`) VALUES
(1, 'eslam@gmail.com', '2025-08-18 02:33:21', '2025-08-18 02:33:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_user_name_unique` (`user_name`);

--
-- Indexes for table `business_settings`
--
ALTER TABLE `business_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificate_items`
--
ALTER TABLE `certificate_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certificate_items_certificate_id_foreign` (`certificate_id`),
  ADD KEY `certificate_items_result_test_method_id_foreign` (`result_test_method_id`),
  ADD KEY `certificate_items_result_id_foreign` (`result_id`),
  ADD KEY `certificate_items_test_method_item_id_foreign` (`test_method_item_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coa_generation_settings`
--
ALTER TABLE `coa_generation_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coa_generation_settings_emails`
--
ALTER TABLE `coa_generation_settings_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coa_generation_settings_samples`
--
ALTER TABLE `coa_generation_settings_samples`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coa_generation_settings_samples_sample_id_foreign` (`sample_id`);

--
-- Indexes for table `coa_settings`
--
ALTER TABLE `coa_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coa_template_samples`
--
ALTER TABLE `coa_template_samples`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coa_template_samples_coa_temp_id_foreign` (`coa_temp_id`),
  ADD KEY `coa_template_samples_sample_id_foreign` (`sample_id`);

--
-- Indexes for table `c_o_a_settings`
--
ALTER TABLE `c_o_a_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `c_o_a_settings_name_unique` (`name`);

--
-- Indexes for table `c_o_a_templates`
--
ALTER TABLE `c_o_a_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `c_o_a_templates_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `field_samples`
--
ALTER TABLE `field_samples`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frequencies`
--
ALTER TABLE `frequencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `frequencies_name_unique` (`name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_role_id_foreign` (`role_id`),
  ADD KEY `permissions_section_id_foreign` (`section_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plants`
--
ALTER TABLE `plants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plants_name_unique` (`name`);

--
-- Indexes for table `plant_samples`
--
ALTER TABLE `plant_samples`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plant_samples_plant_id_foreign` (`plant_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `results_submission_number_unique` (`submission_number`),
  ADD KEY `results_submission_id_foreign` (`submission_id`),
  ADD KEY `results_plant_id_foreign` (`plant_id`),
  ADD KEY `results_sub_plant_id_foreign` (`sub_plant_id`),
  ADD KEY `results_plant_sample_id_foreign` (`plant_sample_id`),
  ADD KEY `results_sample_id_foreign` (`sample_id`),
  ADD KEY `results_user_id_foreign` (`user_id`);

--
-- Indexes for table `result_test_methods`
--
ALTER TABLE `result_test_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `result_test_methods_result_id_foreign` (`result_id`),
  ADD KEY `result_test_methods_test_method_id_foreign` (`test_method_id`);

--
-- Indexes for table `result_test_method_items`
--
ALTER TABLE `result_test_method_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `result_test_method_items_result_test_method_id_foreign` (`result_test_method_id`),
  ADD KEY `result_test_method_items_result_id_foreign` (`result_id`),
  ADD KEY `result_test_method_items_test_method_item_id_foreign` (`test_method_item_id`);

--
-- Indexes for table `result_types`
--
ALTER TABLE `result_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `result_types_name_unique` (`name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `samples`
--
ALTER TABLE `samples`
  ADD PRIMARY KEY (`id`),
  ADD KEY `samples_plant_id_foreign` (`plant_id`),
  ADD KEY `samples_sub_plant_id_foreign` (`sub_plant_id`),
  ADD KEY `samples_plant_sample_id_foreign` (`plant_sample_id`);

--
-- Indexes for table `sample_routine_schedulers`
--
ALTER TABLE `sample_routine_schedulers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sample_routine_schedulers_submission_number_unique` (`submission_number`),
  ADD KEY `sample_routine_schedulers_sample_id_foreign` (`sample_id`),
  ADD KEY `sample_routine_schedulers_plant_id_foreign` (`plant_id`),
  ADD KEY `sample_routine_schedulers_sub_plant_id_foreign` (`sub_plant_id`);

--
-- Indexes for table `sample_routine_scheduler_items`
--
ALTER TABLE `sample_routine_scheduler_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sample_routine_scheduler_items_sample_scheduler_id_foreign` (`sample_scheduler_id`),
  ADD KEY `sample_routine_scheduler_items_sample_id_foreign` (`sample_id`),
  ADD KEY `sample_routine_scheduler_items_plant_id_foreign` (`plant_id`),
  ADD KEY `sample_routine_scheduler_items_sub_plant_id_foreign` (`sub_plant_id`),
  ADD KEY `sample_routine_scheduler_items_frequency_id_foreign` (`frequency_id`),
  ADD KEY `sample_routine_scheduler_items_test_method_ids_foreign` (`test_method_ids`);

--
-- Indexes for table `sample_test_methods`
--
ALTER TABLE `sample_test_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sample_test_methods_sample_id_foreign` (`sample_id`),
  ADD KEY `sample_test_methods_test_method_id_foreign` (`test_method_id`);

--
-- Indexes for table `sample_test_method_items`
--
ALTER TABLE `sample_test_method_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sample_test_method_items_sample_id_foreign` (`sample_id`),
  ADD KEY `sample_test_method_items_test_method_id_foreign` (`test_method_id`),
  ADD KEY `sample_test_method_items_test_method_item_id_foreign` (`test_method_item_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `submissions_submission_number_unique` (`submission_number`),
  ADD KEY `submissions_plant_id_foreign` (`plant_id`),
  ADD KEY `submissions_sub_plant_id_foreign` (`sub_plant_id`),
  ADD KEY `submissions_plant_sample_id_foreign` (`plant_sample_id`),
  ADD KEY `submissions_sample_id_foreign` (`sample_id`);

--
-- Indexes for table `submission_items`
--
ALTER TABLE `submission_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_items_submission_id_foreign` (`submission_id`),
  ADD KEY `submission_items_sample_test_method_item_id_foreign` (`sample_test_method_item_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenants_domain_unique` (`domain`),
  ADD UNIQUE KEY `tenants_tenant_id_unique` (`tenant_id`),
  ADD UNIQUE KEY `tenants_email_unique` (`email`);

--
-- Indexes for table `test_methods`
--
ALTER TABLE `test_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_methods_name_unique` (`name`);

--
-- Indexes for table `test_method_items`
--
ALTER TABLE `test_method_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_method_items_test_method_id_foreign` (`test_method_id`);

--
-- Indexes for table `toxic_degrees`
--
ALTER TABLE `toxic_degrees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `toxic_degrees_name_unique` (`name`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_name_unique` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_user_name_unique` (`user_name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `web_emails`
--
ALTER TABLE `web_emails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `web_emails_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_settings`
--
ALTER TABLE `business_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `certificate_items`
--
ALTER TABLE `certificate_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coa_generation_settings`
--
ALTER TABLE `coa_generation_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coa_generation_settings_emails`
--
ALTER TABLE `coa_generation_settings_emails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coa_generation_settings_samples`
--
ALTER TABLE `coa_generation_settings_samples`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coa_settings`
--
ALTER TABLE `coa_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coa_template_samples`
--
ALTER TABLE `coa_template_samples`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `c_o_a_settings`
--
ALTER TABLE `c_o_a_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `c_o_a_templates`
--
ALTER TABLE `c_o_a_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `field_samples`
--
ALTER TABLE `field_samples`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frequencies`
--
ALTER TABLE `frequencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plants`
--
ALTER TABLE `plants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `plant_samples`
--
ALTER TABLE `plant_samples`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `result_test_methods`
--
ALTER TABLE `result_test_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `result_test_method_items`
--
ALTER TABLE `result_test_method_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `result_types`
--
ALTER TABLE `result_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `samples`
--
ALTER TABLE `samples`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sample_routine_schedulers`
--
ALTER TABLE `sample_routine_schedulers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sample_routine_scheduler_items`
--
ALTER TABLE `sample_routine_scheduler_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sample_test_methods`
--
ALTER TABLE `sample_test_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `sample_test_method_items`
--
ALTER TABLE `sample_test_method_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `submission_items`
--
ALTER TABLE `submission_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `test_methods`
--
ALTER TABLE `test_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `test_method_items`
--
ALTER TABLE `test_method_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `toxic_degrees`
--
ALTER TABLE `toxic_degrees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `web_emails`
--
ALTER TABLE `web_emails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certificate_items`
--
ALTER TABLE `certificate_items`
  ADD CONSTRAINT `certificate_items_certificate_id_foreign` FOREIGN KEY (`certificate_id`) REFERENCES `certificates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificate_items_result_id_foreign` FOREIGN KEY (`result_id`) REFERENCES `results` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificate_items_result_test_method_id_foreign` FOREIGN KEY (`result_test_method_id`) REFERENCES `result_test_methods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificate_items_test_method_item_id_foreign` FOREIGN KEY (`test_method_item_id`) REFERENCES `test_method_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coa_generation_settings_samples`
--
ALTER TABLE `coa_generation_settings_samples`
  ADD CONSTRAINT `coa_generation_settings_samples_sample_id_foreign` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coa_template_samples`
--
ALTER TABLE `coa_template_samples`
  ADD CONSTRAINT `coa_template_samples_coa_temp_id_foreign` FOREIGN KEY (`coa_temp_id`) REFERENCES `c_o_a_settings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coa_template_samples_sample_id_foreign` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permissions_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `plant_samples`
--
ALTER TABLE `plant_samples`
  ADD CONSTRAINT `plant_samples_plant_id_foreign` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_plant_id_foreign` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_plant_sample_id_foreign` FOREIGN KEY (`plant_sample_id`) REFERENCES `plant_samples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_sample_id_foreign` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_sub_plant_id_foreign` FOREIGN KEY (`sub_plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `result_test_methods`
--
ALTER TABLE `result_test_methods`
  ADD CONSTRAINT `result_test_methods_result_id_foreign` FOREIGN KEY (`result_id`) REFERENCES `results` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `result_test_methods_test_method_id_foreign` FOREIGN KEY (`test_method_id`) REFERENCES `test_methods` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `result_test_method_items`
--
ALTER TABLE `result_test_method_items`
  ADD CONSTRAINT `result_test_method_items_result_id_foreign` FOREIGN KEY (`result_id`) REFERENCES `results` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `result_test_method_items_result_test_method_id_foreign` FOREIGN KEY (`result_test_method_id`) REFERENCES `result_test_methods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `result_test_method_items_test_method_item_id_foreign` FOREIGN KEY (`test_method_item_id`) REFERENCES `test_method_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `samples`
--
ALTER TABLE `samples`
  ADD CONSTRAINT `samples_plant_id_foreign` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `samples_plant_sample_id_foreign` FOREIGN KEY (`plant_sample_id`) REFERENCES `plant_samples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `samples_sub_plant_id_foreign` FOREIGN KEY (`sub_plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sample_routine_schedulers`
--
ALTER TABLE `sample_routine_schedulers`
  ADD CONSTRAINT `sample_routine_schedulers_plant_id_foreign` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sample_routine_schedulers_sample_id_foreign` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sample_routine_schedulers_sub_plant_id_foreign` FOREIGN KEY (`sub_plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sample_routine_scheduler_items`
--
ALTER TABLE `sample_routine_scheduler_items`
  ADD CONSTRAINT `sample_routine_scheduler_items_frequency_id_foreign` FOREIGN KEY (`frequency_id`) REFERENCES `frequencies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sample_routine_scheduler_items_plant_id_foreign` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sample_routine_scheduler_items_sample_id_foreign` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sample_routine_scheduler_items_sample_scheduler_id_foreign` FOREIGN KEY (`sample_scheduler_id`) REFERENCES `sample_routine_schedulers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sample_routine_scheduler_items_sub_plant_id_foreign` FOREIGN KEY (`sub_plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sample_routine_scheduler_items_test_method_ids_foreign` FOREIGN KEY (`test_method_ids`) REFERENCES `test_methods` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sample_test_methods`
--
ALTER TABLE `sample_test_methods`
  ADD CONSTRAINT `sample_test_methods_sample_id_foreign` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sample_test_methods_test_method_id_foreign` FOREIGN KEY (`test_method_id`) REFERENCES `test_methods` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sample_test_method_items`
--
ALTER TABLE `sample_test_method_items`
  ADD CONSTRAINT `sample_test_method_items_sample_id_foreign` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sample_test_method_items_test_method_id_foreign` FOREIGN KEY (`test_method_id`) REFERENCES `sample_test_methods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sample_test_method_items_test_method_item_id_foreign` FOREIGN KEY (`test_method_item_id`) REFERENCES `test_method_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_plant_id_foreign` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_plant_sample_id_foreign` FOREIGN KEY (`plant_sample_id`) REFERENCES `plant_samples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_sample_id_foreign` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_sub_plant_id_foreign` FOREIGN KEY (`sub_plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submission_items`
--
ALTER TABLE `submission_items`
  ADD CONSTRAINT `submission_items_sample_test_method_item_id_foreign` FOREIGN KEY (`sample_test_method_item_id`) REFERENCES `sample_test_methods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submission_items_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `test_method_items`
--
ALTER TABLE `test_method_items`
  ADD CONSTRAINT `test_method_items_test_method_id_foreign` FOREIGN KEY (`test_method_id`) REFERENCES `test_methods` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
