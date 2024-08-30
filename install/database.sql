-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2024 at 08:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `realvast_buyer`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admins', 'admin@site.com', 'admin', NULL, '65fabc00bdfbe1710930944.png', '$2y$10$ttArcUVDiEZf1cz7K4DJO.k01pcV.wOqbta/MWzkKW98HWS24c6Dq', 'vEV7O5JYpLilpXeXlNHy2ERrIJ1FHRf6kb1Bib8YsDQmsX0N18YwnfljUpLf', NULL, '2024-03-20 04:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `click_url` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cron_jobs`
--

CREATE TABLE `cron_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `alias` varchar(40) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `cron_schedule_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `next_run` datetime DEFAULT NULL,
  `last_run` datetime DEFAULT NULL,
  `is_running` tinyint(1) NOT NULL DEFAULT 1,
  `is_default` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_jobs`
--

INSERT INTO `cron_jobs` (`id`, `name`, `alias`, `action`, `url`, `cron_schedule_id`, `next_run`, `last_run`, `is_running`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Profit Cron', 'profit_cron', '[\"App\\\\Http\\\\Controllers\\\\CronController\", \"profit\"]', NULL, 1, '2024-03-21 06:03:17', '2024-03-21 05:58:17', 1, 1, '2023-06-21 23:29:14', '2024-03-20 23:58:17'),
(3, 'Installment Cron', 'installment', '[\"App\\\\Http\\\\Controllers\\\\CronController\", \"installment\"]', NULL, 1, '2024-03-16 13:01:54', '2024-03-16 12:56:54', 1, 1, '2023-06-22 06:10:31', '2024-03-16 06:56:54');

-- --------------------------------------------------------

--
-- Table structure for table `cron_job_logs`
--

CREATE TABLE `cron_job_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cron_job_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `duration` int(11) NOT NULL DEFAULT 0,
  `error` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cron_schedules`
--

CREATE TABLE `cron_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `interval` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cron_schedules`
--

INSERT INTO `cron_schedules` (`id`, `name`, `interval`, `status`, `created_at`, `updated_at`) VALUES
(1, '5 Minutes', 300, 1, '2023-06-21 08:14:52', '2023-06-21 08:14:52'),
(2, '10 Minutes', 600, 1, '2023-06-21 23:28:22', '2023-06-21 23:28:22');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `property_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `invest_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `installment_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `payment_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = onetime, 2 = installment',
  `method_code` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `invest_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `method_currency` varchar(40) DEFAULT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `final_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `detail` text DEFAULT NULL,
  `btc_amount` varchar(255) DEFAULT NULL,
  `btc_wallet` varchar(255) DEFAULT NULL,
  `trx` varchar(40) DEFAULT NULL,
  `payment_try` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT 0,
  `admin_feedback` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `script` text DEFAULT NULL,
  `shortcode` text DEFAULT NULL COMMENT 'object',
  `support` text DEFAULT NULL COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Tawk.to', 'Key location is shown bellow', 'tawky_big.png', '<script>\r\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n                        (function(){\r\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n                        s1.async=true;\r\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\r\n                        s1.charset=\"UTF-8\";\r\n                        s1.setAttribute(\"crossorigin\",\"*\");\r\n                        s0.parentNode.insertBefore(s1,s0);\r\n                        })();\r\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"------\"}}', 'twak.png', 0, '2019-10-18 23:16:05', '2022-03-22 05:22:24'),
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"----------------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"--------------------\"}}', 'recaptcha.png', 0, '2019-10-18 23:16:05', '2024-03-21 00:53:14'),
(3, 'custom-captcha', 'Custom Captcha', 'Just put any random string', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, '2019-10-18 23:16:05', '2024-02-24 07:07:23'),
(4, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', 'google_analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{app_key}}\"></script>\r\n                <script>\r\n                  window.dataLayer = window.dataLayer || [];\r\n                  function gtag(){dataLayer.push(arguments);}\r\n                  gtag(\"js\", new Date());\r\n                \r\n                  gtag(\"config\", \"{{app_key}}\");\r\n                </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"------\"}}', 'ganalytics.png', 0, NULL, '2021-05-04 10:19:12'),
(5, 'fb-comment', 'Facebook Comment ', 'Key location is shown bellow', 'Facebook.png', '<div id=\"fb-root\"></div><script async defer crossorigin=\"anonymous\" src=\"https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v4.0&appId={{app_key}}&autoLogAppEvents=1\"></script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"----\"}}', 'fb_com.PNG', 0, NULL, '2024-02-14 06:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) DEFAULT NULL,
  `form_data` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `act`, `form_data`, `created_at`, `updated_at`) VALUES
(7, 'kyc', '{\"full_name\":{\"name\":\"Full Name\",\"label\":\"full_name\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"gender\":{\"name\":\"Gender\",\"label\":\"gender\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"Male\",\"Female\",\"Others\"],\"type\":\"select\"},\"you_hobby\":{\"name\":\"You Hobby\",\"label\":\"you_hobby\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"Programming\",\"Gardening\",\"Traveling\",\"Others\"],\"type\":\"checkbox\"},\"nid_photo\":{\"name\":\"NID Photo\",\"label\":\"nid_photo\",\"is_required\":\"required\",\"extensions\":\"jpg,png\",\"options\":[],\"type\":\"file\"}}', '2022-03-17 02:56:14', '2023-12-27 13:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data_keys` varchar(40) DEFAULT NULL,
  `data_values` longtext DEFAULT NULL,
  `tempname` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `tempname`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"real state\",\"real state investment\",\"investment\",\"property\",\"profit\",\"Investment opportunities\",\"Investment software\",\"Investment website\"],\"description\":\"Introducing RealVest - Real Estate Investment System, the cutting-edge solution for navigating the complexities of real estate investment with unparalleled ease and efficiency. RealVest offers a robust platform developed on advanced technology, designed to meet the needs of both novice investors and seasoned professionals in the real estate industry.\",\"social_title\":\"RealVest - Real Estate Investment System\",\"social_description\":\"Introducing RealVest - Real Estate Investment System, the cutting-edge solution for navigating the complexities of real estate investment with unparalleled ease and efficiency. RealVest offers a robust platform developed on advanced technology, designed to meet the needs of both novice investors and seasoned professionals in the real estate industry.\",\"image\":\"65fa6e75321d81710911093.png\"}', 'basic', '2020-07-04 23:42:52', '2024-03-20 05:04:53'),
(24, 'about.content', '{\"has_image\":\"1\",\"title\":\"About RealVest\",\"heading\":\"About Our Real Estate\",\"subheading\":\"Finding great properties for investment\",\"description\":\"we specialize in providing a streamlined platform for real estate investors to discover lucrative opportunities. Our user-friendly interface offers access to a diverse range of properties, complete with detailed analytics and expert guidance to help you make informed decisions. Whether you\'re a seasoned investor or just getting started, RealVest is your trusted partner for success in the real estate market\",\"button_text\":\"Discover More\",\"button_url\":\"about\",\"top_card_title\":\"Average Profit Upto\",\"top_card_number\":\"20%\",\"bottom_card_title\":\"Investors\",\"bottom_card_number\":\"3K+\",\"image\":\"65c46856b5a681707370582.jpg\",\"group_image\":\"65c4685716ce41707370583.png\"}', 'basic', '2020-10-28 00:51:20', '2024-03-16 09:32:25'),
(25, 'blog.content', '{\"title\":\"Our blogs\",\"heading\":\"Latest News & Articles\"}', 'basic', '2020-10-28 00:51:34', '2024-03-09 06:59:25'),
(26, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Important Tips for Real Estate Investing Career\",\"description\":\"<p>\\r\\n  Embarking on a journey into real estate investing demands a comprehensive\\r\\n  approach that encompasses various critical factors. Here are ten essential\\r\\n  tips to consider as you set foot into this dynamic and potentially lucrative\\r\\n  field.\\r\\n<\\/p>\\r\\n\\r\\n<h6>Prioritize Education<\\/h6>\\r\\n<p>Real estate investing isn\'t merely about buying and selling properties; it\'s about understanding market dynamics, financial analysis, risk assessment, and legal considerations. Equip yourself with knowledge through books, seminars, online courses, and mentorship programs.<\\/p>\\r\\n\\r\\n<h6>Define Clear Goals<\\/h6>\\r\\n<p>Clarity in goals is paramount. Define your investment objectives with precision. Are you seeking short-term gains through property flipping, or do you aim for long-term wealth accumulation via rental properties? Establishing clear goals will provide direction and focus amidst the diverse opportunities in the real estate market.<\\/p>\\r\\n\\r\\n<h6>Build a Robust Network<\\/h6>\\r\\n<p>Surround yourself with professionals who can offer valuable insights and support, including real estate agents, lenders, contractors, and fellow investors. Cultivating these relationships can provide access to opportunities and resources that may otherwise remain inaccessible.<\\/p>\\r\\n\\r\\n<h6>Conduct Thorough Market Research<\\/h6>\\r\\n<p>Stay abreast of local market trends, economic indicators, and demographic shifts that influence property values and rental demand. Conduct thorough analyses to identify emerging opportunities and potential risks in your target areas.<\\/p>\\r\\n\\r\\n<h6>Start Small<\\/h6>\\r\\n<p>Beginning with manageable investments such as single-family homes or duplexes allows you to gain valuable experience and mitigate risks as you gradually expand your portfolio.<\\/p>\\r\\n\\r\\n<h6>Prioritize Cash Flow<\\/h6>\\r\\n<p>Invest in properties that generate positive cash flow from rental income, ensuring a steady stream of revenue that exceeds expenses.<\\/p>\\r\\n\\r\\n<h6>Manage Risks<\\/h6>\\r\\n<p>Conduct comprehensive due diligence before making investment decisions and mitigate risks through careful planning and contingency measures.<\\/p>\\r\\n\\r\\n<h6>Persistence and Patience<\\/h6>\\r\\n<p>Success in real estate investing requires dedication, resilience, and a willingness to weather challenges and setbacks along the way.<\\/p>\\r\\n\\r\\n<h6>Continuously Learn<\\/h6>\\r\\n<p>Stay curious, seek out new knowledge, and adapt to evolving market trends, regulations, and investment strategies<\\/p>\\r\\n\\r\\n<h6>Seek Professional Guidance<\\/h6>\\r\\n<p>Consult with experts such as real estate attorneys, tax advisors, and financial planners to ensure informed decision-making aligned with your financial objectives.<\\/p>\\r\\n\\r\\n<p>In conclusion, launching a successful real estate investing career requires a holistic approach that encompasses education, goal-setting, networking, market research, risk management, patience, continuous learning, and professional guidance. By embracing these essential tips and committing to your growth as an investor, you can embark on a rewarding journey towards financial success in real estate.<\\/p>\",\"image\":\"65ec1ec1c185f1709973185.png\"}', 'basic', '2020-10-07 00:57:19', '2024-03-19 10:29:10'),
(27, 'contact_us.content', '{\"has_image\":\"1\",\"title\":\"Get in Touch\",\"heading\":\"Let\'s ask your questions\",\"address_icon\":\"<i class=\\\"fas fa-map-marker-alt\\\"><\\/i>\",\"address_title\":\"Location\",\"address\":\"123 Main Street, London\",\"email_icon\":\"<i class=\\\"fas fa-envelope\\\"><\\/i>\",\"email_title\":\"Email\",\"email\":\"support@realvest.com\",\"mobile_icon\":\"<i class=\\\"fas fa-phone\\\"><\\/i>\",\"mobile_title\":\"Phone\",\"mobile_number\":\"+44 20 1234 5678\",\"image\":\"65c46977ae0b91707370871.png\"}', 'basic', '2020-10-28 00:59:19', '2024-03-19 06:30:21'),
(33, 'feature.content', '{\"title\":\"Built to help smart investors invest smarter\",\"heading\":\"Why Invest in Real Estate?\"}', 'basic', '2021-01-03 23:40:54', '2023-11-18 08:59:30'),
(39, 'banner.content', '{\"has_image\":\"1\",\"title\":\"Smart & secure real estate investment platform\",\"heading\":\"Invest in The Future of Real Estate\",\"button_text\":\"Get Started\",\"button_url\":\"user\\/register\",\"image\":\"65ec2b2b832361709976363.png\"}', 'basic', '2021-05-02 06:09:30', '2024-03-20 04:46:00'),
(41, 'cookie.data', '{\"short_desc\":\"We may use cookies or any other tracking technologies when you visit our website, including any other media form, mobile website, or mobile application related or connected to help customize the Site and improve your experience.\",\"description\":\"<div><h6 class=\\\"mb-1\\\">What information do we collect?<\\/h6><p>We gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p><p><br><\\/p><\\/div><div><h6 class=\\\"mb-1\\\">How do we protect your information?<\\/h6><p>All provided delicate\\/credit data is sent through Stripe.<br>After an exchange, your private data (credit cards, social security numbers, financials, and so on) won\'t be put away on our workers.<\\/p><p><br><\\/p><\\/div><div><h6 class=\\\"mb-1\\\">Do we disclose any information to outside parties?<\\/h6><p>We don\'t sell, exchange, or in any case move to outside gatherings by and by recognizable data. This does exclude confided in outsiders who help us in working our site, leading our business, or adjusting you, since those gatherings consent to keep this data private. We may likewise deliver your data when we accept discharge is suitable to follow the law, implement our site strategies, or ensure our own or others\' rights, property, or wellbeing.<\\/p><p><br><\\/p><\\/div><div><h6 class=\\\"mb-1\\\">Children\'s Online Privacy Protection Act Compliance<\\/h6><p>We are consistent with the prerequisites of COPPA (Children\'s Online Privacy Protection Act), we don\'t gather any data from anybody under 13 years old. Our site, items, and administrations are completely coordinated to individuals who are in any event 13 years of age or more established.<\\/p><p><br><\\/p><\\/div><div><h6 class=\\\"mb-1\\\">Changes to our Privacy Policy<\\/h6><p>If we decide to change our privacy policy, we will post those changes on this page.<\\/p><p><br><\\/p><\\/div><div><h6 class=\\\"mb-1\\\">How long we retain your information?<\\/h6><p>At the point when you register for our site, we cycle and keep your information we have about you however long you don\'t erase the record or withdraw yourself (subject to laws and guidelines).<\\/p><p><br><\\/p><\\/div><div><h6 class=\\\"mb-1\\\">What we don\\u2019t do with your data<\\/h6><p>We don\'t and will never share, unveil, sell, or in any case give your information to different organizations for the promoting of their items or administrations.<\\/p><\\/div>\",\"status\":1}', 'basic', '2020-07-04 23:42:52', '2024-03-09 12:01:43'),
(42, 'policy_pages.element', '{\"title\":\"Privacy Policy\",\"details\":\"<div>\\r\\n    <h6>What\\r\\n        information do we collect?<\\/h6>\\r\\n    <p>We gather data from you when you\\r\\n        register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the\\r\\n        point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter\\r\\n        your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p><p><br \\/><\\/p>\\r\\n<\\/div><div>\\r\\n    <h6>How do\\r\\n        we protect your information?<\\/h6>\\r\\n    <p>All provided delicate\\/credit data is\\r\\n        sent through Stripe.<br \\/>After an exchange, your private data (credit cards, social security numbers, financials,\\r\\n        and so on) won\'t be put away on our workers.<\\/p><p><br \\/><\\/p>\\r\\n<\\/div>\\r\\n\\r\\n<div>\\r\\n    <h6>Do we\\r\\n        disclose any information to outside parties?<\\/h6>\\r\\n    <p>We don\'t sell, exchange, or in any case\\r\\n        move to outside gatherings by and by recognizable data. This does exclude confided in outsiders who help us in\\r\\n        working our site, leading our business, or adjusting you, since those gatherings consent to keep this data\\r\\n        private. We may likewise deliver your data when we accept discharge is suitable to follow the law, implement our\\r\\n        site strategies, or ensure our own or others\' rights, property, or wellbeing.<\\/p><p><br \\/><\\/p>\\r\\n<\\/div>\\r\\n<div>\\r\\n    <h6>\\r\\n        Children\'s Online Privacy Protection Act Compliance<\\/h6>\\r\\n    <p>We are consistent with the prerequisites\\r\\n        of COPPA (Children\'s Online Privacy Protection Act), we don\'t gather any data from anybody under 13 years old.\\r\\n        Our site, items, and administrations are completely coordinated to individuals who are in any event 13 years of\\r\\n        age or more established.<\\/p><p><br \\/><\\/p>\\r\\n<\\/div>\\r\\n<div>\\r\\n    <h6>Changes\\r\\n        to our Privacy Policy<\\/h6>\\r\\n    <p>If we decide to change our privacy\\r\\n        policy, we will post those changes on this page.<\\/p><p><br \\/><\\/p>\\r\\n<\\/div>\\r\\n<div>\\r\\n    <h6>How long\\r\\n        we retain your information?<\\/h6>\\r\\n    <p>At the point when you register for our\\r\\n        site, we cycle and keep your information we have about you however long you don\'t erase the record or withdraw\\r\\n        yourself (subject to laws and guidelines).<\\/p><p><br \\/><\\/p>\\r\\n<\\/div>\\r\\n<div>\\r\\n    <h6>What we\\r\\n        don\\u2019t do with your data<\\/h6>\\r\\n    <p>We don\'t and will never share, unveil,\\r\\n        sell, or in any case give your information to different organizations for the promoting of their items or\\r\\n        administrations.<\\/p>\\r\\n<\\/div>\"}', 'basic', '2021-06-09 08:50:42', '2024-03-09 12:00:57'),
(43, 'policy_pages.element', '{\"title\":\"Terms of Service\",\"details\":\"<div><h6 class=\\\"mb-1\\\">Terms & Conditions for Users<\\/h6><p>Before getting to this site, you are consenting to be limited by these site Terms and Conditions of Use, every single appropriate law, and guidelines, and concur that you are answerable for consistency with any material neighborhood laws. If you disagree with any of these terms, you are restricted from utilizing or getting to this site.<\\/p><p><br \\/><\\/p><\\/div><div><h6 class=\\\"mb-1\\\">Support<\\/h6><p>Whenever you have downloaded our item, you may get in touch with us for help through email and we will give a valiant effort to determine your issue. We will attempt to answer using the Email for more modest bug fixes, after which we will refresh the center bundle. Content help is offered to confirmed clients by Tickets as it were. Backing demands made by email and Livechat.<\\/p><p>On the off chance that your help requires extra adjustment of the System, at that point, you have two alternatives:<\\/p><ul><li>Hang tight for additional update discharge.<\\/li><li>Or on the other hand, enlist a specialist (We offer customization for extra charges).<\\/li><li><br \\/><\\/li><\\/ul><\\/div><div><h6 class=\\\"mb-1\\\">Ownership<\\/h6><p>You may not guarantee scholarly or selective possession of any of our items, altered or unmodified. All items are property, we created them. Our items are given \\\"with no guarantees\\\" without guarantee of any sort, either communicated or suggested. On no occasion will our juridical individual be subject to any harms including, however not restricted to, immediate, roundabout, extraordinary, accidental, or significant harms or different misfortunes emerging out of the utilization of or powerlessness to utilize our items.<\\/p><p><br \\/><\\/p><\\/div><div><h6 class=\\\"mb-1\\\">Warranty<\\/h6><p>We don\'t offer any guarantee or assurance of these Services in any way. When our Services have been modified we can\'t ensure they will work with all outsider plugins, modules, or internet browsers. Program similarity ought to be tried against the show formats on the demo worker. If you don\'t mind guarantee that the programs you use will work with the component, as we can not ensure that our systems will work with all program mixes.<\\/p><p><br \\/><\\/p><\\/div><div><h6 class=\\\"mb-1\\\">Unauthorized\\/Illegal Usage<\\/h6><p>You may not utilize our things for any illicit or unapproved reason or may you, in the utilization of the stage, disregard any laws in your locale (counting yet not restricted to copyright laws) just as the laws of your nation and International law. Specifically, it is disallowed to utilize the things on our foundation for pages that advance: brutality, illegal intimidation, hard sexual entertainment, bigotry, obscenity content or warez programming joins.<\\/p><p><br \\/><\\/p><\\/div><div><h6 class=\\\"mb-1\\\">Payment\\/Refund Policy<\\/h6><p>No refund or cash back will be made. After a deposit has been finished, it is extremely unlikely to invert it. You should utilize your equilibrium on requests our administrations, Hosting, SEO campaign. You concur that once you complete a deposit, you won\'t document a debate or a chargeback against us in any way, shape, or form.<br \\/><br \\/>If you document a debate or chargeback against us after a deposit, we claim all authority to end every single future request, prohibit you from our site. False action, for example, utilizing unapproved or taken charge cards will prompt the end of your record. There are no special cases.<\\/p><p><br \\/><\\/p><\\/div><div><h6 class=\\\"mb-1\\\">Free Balance \\/ Coupon Policy<\\/h6><p>We offer numerous approaches to get FREE Balance, Coupons and Deposit offers yet we generally reserve the privilege to audit it and deduct it from your record offset with any explanation we may it is a sort of misuse. If we choose to deduct a few or all of free Balance from your record balance, and your record balance becomes negative, at that point the record will naturally be suspended. If your record is suspended because of a negative Balance you can request to make a custom payment to settle your equilibrium to actuate your record.<\\/p><\\/div>\"}', 'basic', '2021-06-09 08:51:18', '2024-03-09 12:00:06'),
(44, 'maintenance.data', '{\"description\":\"Our site is undergoing maintenance to provide you with an enhanced experience. We apologize for any inconvenience caused during this period. Rest assured, our team is working diligently to bring you a better platform. Thank you for your patience and understanding. We look forward to serving you better soon.\",\"image\":\"65c73f28b723e1707556648.png\",\"heading\":\"THE SITE UNDER MAINTENANCE\"}', 'basic', '2020-07-04 23:42:52', '2024-02-10 03:23:28'),
(45, 'banner.element', '{\"title\":\"Member\",\"count\":\"9k+\"}', 'basic', '2023-11-18 06:01:30', '2024-03-09 05:44:54'),
(46, 'banner.element', '{\"title\":\"Investors\",\"count\":\"3k+\"}', 'basic', '2023-11-18 06:02:02', '2024-03-09 05:45:06'),
(47, 'banner.element', '{\"title\":\"Average Profit Upto\",\"count\":\"20%\"}', 'basic', '2023-11-18 06:02:22', '2024-03-16 09:31:26'),
(48, 'feature.element', '{\"title\":\"Secure Investment\",\"description\":\"Rest assured with our secure investment solutions, your financial future is protected\",\"feature_icon\":\"<i class=\\\"las la-hand-holding-usd\\\"><\\/i>\"}', 'basic', '2023-11-18 09:10:22', '2024-03-09 05:48:00'),
(49, 'feature.element', '{\"title\":\"Transparent Platform\",\"description\":\"Experience the confidence of a transparent platform for your peace of mind\",\"feature_icon\":\"<i class=\\\"lab la-gg-circle\\\"><\\/i>\"}', 'basic', '2023-11-18 09:18:35', '2024-03-09 05:49:06'),
(50, 'feature.element', '{\"title\":\"Passive Income\",\"description\":\"Explore opportunities for generating passive income streams\",\"feature_icon\":\"<i class=\\\"las la-cloud-meatball\\\"><\\/i>\"}', 'basic', '2023-11-18 09:19:30', '2024-03-09 05:50:13'),
(51, 'feature.element', '{\"title\":\"Support\",\"description\":\"Count on our dedicated support team for prompt and reliable assistance\",\"feature_icon\":\"<i class=\\\"las la-headset\\\"><\\/i>\"}', 'basic', '2023-11-18 09:21:49', '2024-03-09 05:50:56'),
(53, 'latest_property.content', '{\"title\":\"Latest properties\",\"heading\":\"Explore Latest Properties\"}', 'basic', '2023-11-18 11:11:09', '2024-03-09 06:56:51'),
(54, 'cities.content', '{\"title\":\"Cities\",\"heading\":\"Explore By Cities\"}', 'basic', '2023-11-18 13:55:22', '2023-11-18 13:55:22'),
(60, 'testimonial.content', '{\"title\":\"Investors trust us\",\"heading\":\"Trusted by Over 3000+ Investors\"}', 'basic', '2023-11-19 13:26:34', '2024-03-09 06:58:14'),
(61, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Sarah Johnson\",\"address\":\"Cir. Shiloh, Hawaii\",\"review\":\"Exceptional service! The team goes above and beyond to ensure their clients\' success. From start to finish, they provided thorough guidance and support, making my investment journey smooth and rewarding.\",\"image\":\"65fa74cb84b8f1710912715.png\"}', 'basic', '2023-11-19 13:27:44', '2024-03-20 05:31:55'),
(62, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Michael Thompson\",\"address\":\"Berlin\",\"review\":\"I\'ve tried various investment platforms, but none compare to the professionalism and expertise offered here. Their attention to detail and commitment to client satisfaction sets them apart. Highly recommend!\",\"image\":\"65fa750f0d0781710912783.png\"}', 'basic', '2023-11-19 13:28:34', '2024-03-20 05:33:03'),
(63, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Emily Hughes\",\"address\":\"Australia\",\"review\":\"Five stars all the way! This platform helped me diversify my investment portfolio with real estate, and I couldn\'t be happier with the results. Trustworthy, knowledgeable, and always available to address any concerns.\",\"image\":\"65fa755d201401710912861.png\"}', 'basic', '2023-11-19 13:30:18', '2024-03-20 05:34:21'),
(64, 'brands.element', '{\"has_image\":\"1\",\"image\":\"65e00411b8b5a1709179921.png\"}', 'basic', '2023-11-19 13:31:28', '2024-02-29 04:12:01'),
(65, 'brands.element', '{\"has_image\":\"1\",\"image\":\"65e00418d311a1709179928.png\"}', 'basic', '2023-11-19 13:31:33', '2024-02-29 04:12:08'),
(66, 'brands.element', '{\"has_image\":\"1\",\"image\":\"65e0041e884771709179934.png\"}', 'basic', '2023-11-19 13:31:39', '2024-02-29 04:12:14'),
(67, 'brands.element', '{\"has_image\":\"1\",\"image\":\"65e00423d2d7e1709179939.png\"}', 'basic', '2023-11-19 13:31:45', '2024-02-29 04:12:19'),
(68, 'brands.element', '{\"has_image\":\"1\",\"image\":\"65e00429c295e1709179945.png\"}', 'basic', '2023-11-19 13:31:51', '2024-02-29 04:12:25'),
(69, 'brands.element', '{\"has_image\":\"1\",\"image\":\"65e00430592e81709179952.png\"}', 'basic', '2023-11-19 13:31:56', '2024-02-29 04:12:32'),
(70, 'brands.element', '{\"has_image\":\"1\",\"image\":\"65e00435e6f411709179957.png\"}', 'basic', '2023-11-19 13:32:02', '2024-02-29 04:12:37'),
(71, 'brands.element', '{\"has_image\":\"1\",\"image\":\"65e0043ae02c01709179962.png\"}', 'basic', '2023-11-19 13:32:06', '2024-02-29 04:12:42'),
(72, 'featured_property.content', '{\"title\":\"Featured properties\",\"heading\":\"All Properties Spotlight\"}', 'basic', '2023-11-21 07:26:49', '2024-03-09 06:57:13'),
(73, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"What is Turn Key Real Estate Investing?\",\"description\":\"<h6>Investing in Real Estate: A Guide to Turnkey Investing<\\/h6>\\r\\n<p>Investing in real estate can be a lucrative venture, but it often requires significant time, effort, and expertise to find, purchase, renovate, and manage properties successfully. However, turnkey real estate investing offers an alternative approach that appeals to many investors seeking passive income and minimal involvement in the day-to-day operations of property management.<\\/p>\\r\\n\\r\\n<h6>Understanding Turnkey Real Estate Investing<\\/h6>\\r\\n<p>Turnkey real estate investing involves purchasing properties that are fully renovated, leased, and managed by a third-party company. Investors typically buy these properties from turnkey providers who specialize in identifying, acquiring, renovating, and renting out properties in desirable locations. The turnkey provider handles all aspects of the investment, from property acquisition and renovation to tenant placement and ongoing management.<\\/p>\\r\\n\\r\\n<h6>The Benefits of Turnkey Real Estate Investing<\\/h6>\\r\\n<p>One of the primary benefits of turnkey real estate investing is its hands-off nature. Investors can leverage the expertise of turnkey providers to acquire rental properties without the need to personally oversee renovations, tenant screening, or property management tasks. This passive approach appeals to busy professionals, retirees, and investors looking to diversify their portfolios without committing significant time and resources.<\\/p>\\r\\n\\r\\n<h6>Immediate Income Generation<\\/h6>\\r\\n<p>Additionally, turnkey properties are often marketed as \\\"income-producing\\\" assets from day one. Since these properties are typically already leased to tenants, investors can start generating rental income immediately after purchasing them. This immediate cash flow can provide a steady stream of passive income, making turnkey real estate investing an attractive option for those seeking regular returns on their investment.<\\/p>\\r\\n\\r\\n<h6>Geographic Diversification and Stability<\\/h6>\\r\\n<p>Another advantage of turnkey investing is its potential for geographic diversification. Turnkey providers often operate in multiple markets, allowing investors to spread their risk across different locations and property types. This diversification can help mitigate the impact of local market fluctuations and economic downturns, providing a more stable investment strategy.<\\/p>\\r\\n\\r\\n<h6>Turnkey Properties: Fully Renovated and Move-In Ready<\\/h6>\\r\\n<p>Furthermore, turnkey properties are usually fully renovated and in move-in condition, eliminating the need for costly and time-consuming repairs or upgrades. This aspect not only saves investors the hassle of managing renovations but also reduces the risk of unexpected maintenance expenses in the early stages of ownership.<\\/p>\\r\\n\\r\\n<h6>Considerations and Potential Drawbacks<\\/h6>\\r\\n<p>However, despite its benefits, turnkey real estate investing is not without its drawbacks. One potential downside is the higher upfront cost associated with purchasing fully renovated and leased properties. Compared to traditional real estate investing, where investors can buy properties at lower prices and potentially add value through renovations, turnkey properties typically come with a premium price tag.<\\/p>\\r\\n\\r\\n<h6>Thorough Due Diligence is Key<\\/h6>\\r\\n<p>Moreover, investors must conduct thorough due diligence before choosing a turnkey provider. Not all turnkey companies are created equal, and some may cut corners or fail to deliver on their promises. It\'s essential to research potential providers carefully, evaluate their track record, and assess the quality of their properties and services before making any investment decisions.<\\/p>\\r\\n\\r\\n\\r\\n<p>In conclusion, turnkey real estate investing offers a convenient and potentially profitable way for investors to acquire rental properties with minimal hassle and involvement. By leveraging the expertise of turnkey providers, investors can enjoy passive income, immediate cash flow, and geographic diversification while avoiding the complexities of property management. However, like any investment strategy, turnkey investing requires careful consideration and due diligence to ensure success.<\\/p>\",\"image\":\"65ec1e6b4a4061709973099.png\"}', 'basic', '2023-11-21 09:22:03', '2024-03-19 10:31:23'),
(74, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"How to Build Your Real Estate Portfolio\",\"description\":\"<p>\\r\\n  Are you tired of renting and dreaming of owning multiple properties?\\r\\n  Transitioning from being a renter to becoming a real estate investor can be a\\r\\n  transformative journey. It\'s not just about owning a home; it\'s about building\\r\\n  a portfolio that generates passive income and secures your financial future.\\r\\n  Here\'s a guide on how to embark on this exciting path\\r\\n<\\/p>\\r\\n\\r\\n<h6>Educate Yourself: Understanding the Financial Aspects<\\/h6>\\r\\n<p>\\r\\n  Firstly, before diving into real estate investing, it\'s crucial to educate\\r\\n  yourself about the financial aspects. Understand concepts like leverage, cash\\r\\n  flow, appreciation, and the risks associated with real estate investment. Take\\r\\n  courses, read books, and seek guidance from experienced investors or financial\\r\\n  advisors\\r\\n<\\/p>\\r\\n\\r\\n<h6>Set Clear Goals: Defining Your Objectives<\\/h6>\\r\\n<p>\\r\\n  Once you\'ve gained a solid understanding of the financial fundamentals, set\\r\\n  clear goals for your real estate investment journey. Determine your\\r\\n  objectives\\u2014are you aiming for long-term wealth accumulation, immediate cash\\r\\n  flow, or a combination of both? Define your risk tolerance, investment\\r\\n  horizon, and target returns. Having clear goals will guide your investment\\r\\n  decisions and help you stay focused amidst market fluctuations\\r\\n<\\/p>\\r\\n\\r\\n<h6>Assess Your Financial Situation: Establishing a Solid Foundation<\\/h6>\\r\\n<p>\\r\\n  With your goals in mind, assess your current financial situation and establish\\r\\n  a solid foundation before diving into real estate. Pay off high-interest debt,\\r\\n  build an emergency fund, and ensure you have a stable source of income to\\r\\n  cover your living expenses. Having financial stability will provide a safety\\r\\n  net as you navigate the challenges of real estate investment\\r\\n<\\/p>\\r\\n\\r\\n<h6>Start Small: Beginning with Manageable Investments<\\/h6>\\r\\n<p>\\r\\n  When you\'re ready to start investing, consider beginning with manageable\\r\\n  investments. Start small with a single-family home, duplex, or small\\r\\n  multi-unit property. Starting small allows you to gain hands-on experience,\\r\\n  learn the ropes of property management, and minimize your financial exposure\\r\\n<\\/p>\\r\\n\\r\\n<h6>Location Matters: Conducting Thorough Research<\\/h6>\\r\\n<p>\\r\\n  Location is paramount in real estate investment. Conduct thorough research to\\r\\n  identify markets with strong fundamentals, such as job growth, population\\r\\n  expansion, and infrastructure development. Analyze local market trends,\\r\\n  vacancy rates, rental demand, and comparable property prices to make informed\\r\\n  investment decisions\\r\\n<\\/p>\\r\\n\\r\\n<h6>Financial Analysis: Evaluating Potential Investment Properties<\\/h6>\\r\\n<p>\\r\\n  Perform comprehensive financial analysis for each potential investment\\r\\n  property. Calculate the potential rental income, operating expenses, vacancy\\r\\n  rates, and projected cash flow. Factor in property taxes, insurance,\\r\\n  maintenance costs, and potential capital expenditures. Ensure that the\\r\\n  property\'s cash flow aligns with your investment goals and risk tolerance\\r\\n<\\/p>\\r\\n\\r\\n<h6>Build Relationships: Networking within the Real Estate Community<\\/h6>\\r\\n<p>\\r\\n  Building relationships within the real estate community is essential for\\r\\n  success. Attend networking events, join real estate investment clubs, and\\r\\n  connect with other investors, agents, lenders, and property managers.\\r\\n  Collaborating with experienced professionals can provide valuable insights and\\r\\n  open doors to potential partnerships or deals\\r\\n<\\/p>\\r\\n\\r\\n<h6>Due Diligence: Conducting Thorough Research<\\/h6>\\r\\n<p>\\r\\n  Conduct thorough due diligence before finalizing any real estate transaction.\\r\\n  Inspect the property, review financial statements, assess market comparables,\\r\\n  and verify legal documents. Consider hiring professionals, such as inspectors,\\r\\n  appraisers, and attorneys, to assist with the due diligence process and\\r\\n  mitigate risks\\r\\n<\\/p>\\r\\n\\r\\n<h6>Explore Financing Options: Evaluating Available Choices<\\/h6>\\r\\n<p>\\r\\n  Explore various financing options available for real estate investment, such\\r\\n  as conventional mortgages, FHA loans, private lenders, or partnerships.\\r\\n  Evaluate the terms, interest rates, and repayment schedules to choose the most\\r\\n  suitable financing option for your investment strategy\\r\\n<\\/p>\\r\\n\\r\\n<h6>Stay Informed: Adapting to Market Changes<\\/h6>\\r\\n<p>\\r\\n  Real estate investment is a dynamic and evolving field. Stay updated on market\\r\\n  trends, regulatory changes, and investment strategies through ongoing\\r\\n  education and networking. Be flexible and willing to adapt your investment\\r\\n  approach based on changing market conditions and opportunities\\r\\n<\\/p>\\r\\n\\r\\nIn conclusion, transitioning from a renter to a real estate investor requires\\r\\ncareful planning, financial education, and strategic decision-making. By\\r\\nsetting clear goals, starting small, conducting thorough research, and\\r\\nbuilding a network of professionals, you can gradually build a successful real\\r\\nestate portfolio that generates passive income and creates long-term wealth\",\"image\":\"65ec1dda255de1709972954.png\"}', 'basic', '2023-11-21 09:23:00', '2024-03-19 10:01:56'),
(75, 'footer.content', '{\"description\":\"RailVest offers a seamless avenue for establishing a cutting-edge investment platform without necessitating coding expertise within a short time.\"}', 'basic', '2023-11-21 10:52:57', '2024-03-19 06:24:23'),
(76, 'footer.element', '{\"social_icon\":\"<i class=\\\"fab fa-instagram\\\"><\\/i>\",\"social_link\":\"https:\\/\\/www.instagram.com\\/\"}', 'basic', '2023-11-21 10:53:32', '2023-11-21 10:53:32'),
(77, 'footer.element', '{\"social_icon\":\"<i class=\\\"fab fa-facebook-f\\\"><\\/i>\",\"social_link\":\"https:\\/\\/www.facebook.com\\/\"}', 'basic', '2023-11-21 10:53:50', '2023-11-21 10:53:50'),
(78, 'footer.element', '{\"social_icon\":\"<i class=\\\"fab fa-linkedin\\\"><\\/i>\",\"social_link\":\"https:\\/\\/www.linkedin.com\\/\"}', 'basic', '2023-11-21 10:54:24', '2023-11-21 10:54:24'),
(79, 'footer.element', '{\"social_icon\":\"<i class=\\\"fab fa-twitter\\\"><\\/i>\",\"social_link\":\"https:\\/\\/twitter.com\\/\"}', 'basic', '2023-11-21 10:54:35', '2023-11-21 10:54:35'),
(80, 'subscribe.content', '{\"heading\":\"Subscribe for updates\",\"subheading\":\"Stay on top of the latest blog posts, news and announcements\"}', 'basic', '2023-11-21 11:03:28', '2023-11-21 11:03:28'),
(84, 'faq.content', '{\"title\":\"All Your Concern\",\"heading\":\"All Your Concern\"}', 'basic', '2023-11-21 11:40:35', '2024-03-09 11:27:08'),
(85, 'faq.element', '{\"question\":\"What is real estate investment?\",\"answer\":\"Real estate investment involves purchasing, owning, managing, renting, or selling properties for the purpose of generating income or profit.\"}', 'basic', '2023-11-21 11:40:57', '2024-03-09 11:45:57'),
(86, 'faq.element', '{\"question\":\"What types of real estate investments are available?\",\"answer\":\"Common types of real estate investments include residential properties (such as single-family homes, condos, and apartments), commercial properties (such as office buildings, retail spaces, and warehouses), industrial properties, and vacant land.\"}', 'basic', '2023-11-21 11:41:20', '2024-03-09 11:46:16'),
(87, 'faq.element', '{\"question\":\"How do I get started with real estate investment?\",\"answer\":\"To get started, you can educate yourself about the market, develop a clear investment strategy, conduct thorough research, build a network of professionals (such as real estate agents, lenders, and contractors), and consider working with experienced mentors or advisors.\"}', 'basic', '2023-11-21 11:41:38', '2024-03-09 11:46:29'),
(88, 'breadcrumb.content', '{\"has_image\":\"1\",\"background_image\":\"65c469d3e22771707370963.png\"}', 'basic', '2023-11-21 12:53:15', '2024-02-07 23:42:44'),
(89, 'login.content', '{\"heading\":\"Account Login\"}', 'basic', '2023-11-26 06:21:26', '2023-11-26 06:21:26'),
(90, 'register.content', '{\"heading\":\"Create an Account\"}', 'basic', '2023-11-26 06:37:37', '2023-11-26 06:37:37'),
(91, 'kyc_instruction.content', '{\"kyc_required_description\":\"Please submit the required KYC information to verify yourself. Otherwise, you couldn\'t make any withdrawal requests to the system.\",\"kyc_pending_description\":\"Your submitted KYC information is pending for admin approval. Please wait till that.\"}', 'basic', '2023-12-28 04:50:14', '2023-12-28 04:50:14'),
(92, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"The Ultimate Guide to Real Estate Investing\",\"description\":\"<p>Real estate investing has long been hailed as one of the most lucrative avenues for wealth accumulation. It offers a tangible asset that can appreciate over time, generate passive income, and provide numerous tax benefits. However, navigating the complex world of real estate requires knowledge, strategy, and a solid understanding of the market. In \\\"Unlocking Wealth: The Ultimate Guide to Real Estate Investing,\\\" we delve into the fundamental principles and strategies that can help both novice and seasoned investors unlock the full potential of real estate.<\\/p>\\r\\n\\r\\n<h6>Understanding Market Dynamics<\\/h6>\\r\\n<p>At its core, successful real estate investing requires a thorough understanding of the market dynamics. This includes analyzing supply and demand trends, assessing economic indicators, and identifying emerging opportunities. Whether it\'s residential properties, commercial real estate, or niche markets like vacation rentals or fix-and-flip properties, investors must conduct extensive research to make informed decisions.<\\/p>\\r\\n\\r\\n<h6>The Importance of Location<\\/h6>\\r\\n<p>One of the key principles emphasized in our guide is the importance of location. The adage \\\"location, location, location\\\" rings true in real estate investing. A property\'s location not only determines its potential for appreciation but also influences its rental income and overall demand. Factors such as proximity to amenities, schools, employment centers, and transportation hubs can significantly impact the property\'s desirability and long-term value.<\\/p>\\r\\n\\r\\n<h6>Financial Aspects of Real Estate Investing<\\/h6>\\r\\n<p>In addition to location, investors must also consider the financial aspects of real estate investing. This includes evaluating the property\'s cash flow potential, assessing its return on investment (ROI), and understanding financing options. From traditional mortgages to creative financing strategies like seller financing or private lending, there are various ways to fund real estate investments. Our guide provides insights into the pros and cons of each approach, helping investors choose the most suitable financing strategy for their goals and risk tolerance.<\\/p>\\r\\n\\r\\n<h6>Effective Property Management<\\/h6>\\r\\n<p>Moreover, successful real estate investing requires a proactive approach to property management. Whether you\'re a hands-on investor managing your properties directly or you opt for a hands-off approach by hiring a property management company, effective management is essential for maximizing returns and minimizing risks. This involves ensuring timely rent collection, conducting regular maintenance and repairs, and staying updated on landlord-tenant laws and regulations.<\\/p>\\r\\n\\r\\n<h6>Diversification<\\/h6>\\r\\n<p>Furthermore, \\\"Unlocking Wealth: The Ultimate Guide to Real Estate Investing\\\" explores the importance of diversification in building a robust real estate portfolio. While investing in residential properties may offer stability and consistent cash flow, diversifying into commercial real estate or alternative asset classes can provide additional sources of income and hedge against market volatility.<\\/p>\\r\\n\\r\\n<h6>Continuous Learning and Adaptation<\\/h6>\\r\\n<p>Lastly, our guide emphasizes the significance of continuous learning and adaptation in the ever-evolving real estate landscape. Markets fluctuate, economic conditions change, and new technologies emerge, reshaping the way we invest in real estate. By staying informed, remaining agile, and continuously honing their skills, investors can navigate challenges and seize opportunities in any market environment.<\\/p>\\r\\n\\r\\n<p>In conclusion, real estate investing offers a pathway to wealth creation for those willing to educate themselves, take calculated risks, and stay committed for the long term. \\\"Unlocking Wealth: The Ultimate Guide to Real Estate Investing\\\" serves as a comprehensive resource for investors looking to harness the power of real estate to achieve their financial goals and unlock lasting prosperity.<\\/p>\",\"image\":\"65ec1d0b9648f1709972747.png\"}', 'basic', '2024-02-07 23:56:21', '2024-03-19 09:54:23'),
(93, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Inspiring Stories from Real Estate Investors\",\"description\":\"<p>In the dynamic world of real estate investing, success stories abound, each one a testament to the vision, dedication, and resilience of individuals who dared to chase their dreams. One such tale of triumph belongs to Sarah, a determined investor who defied the odds to carve her niche in the competitive real estate market. Starting with modest savings and a burning desire to build wealth, Sarah embarked on her journey with unwavering determination. Despite facing initial hurdles and skepticism from peers, she remained steadfast in her pursuit, leveraging her keen eye for opportunities and willingness to take calculated risks.<\\/p>\\r\\n\\r\\n\\r\\n<h6>Michael: Transformative Power of Passion<\\/h6>\\r\\n<p>Similarly, the story of Michael serves as a testament to the transformative power of passion and persistence. Coming from humble beginnings, Michael harbored a lifelong fascination with real estate, viewing it not merely as a means to financial gain but as a vehicle for community revitalization and social impact. Armed with this vision, he embarked on a mission to breathe new life into neglected neighborhoods, one property at a time. Despite facing skepticism and naysayers, Michael remained undeterred, pouring his heart and soul into revitalization projects that revitalized communities and provided much-needed affordable housing. His commitment to sustainable development and community engagement earned him not only financial success but also the respect and admiration of his peers.<\\/p>\\r\\n\\r\\n\\r\\n<h6>Maria: Overcoming Adversity<\\/h6>\\r\\n<p>Then there\'s the story of Maria, a single mother who overcame adversity to build a thriving real estate empire from scratch. Juggling multiple jobs and familial responsibilities, Maria refused to let her circumstances define her destiny. With unwavering determination and a laser focus on her goals, she embarked on a journey of self-discovery and empowerment. Through sheer grit and resourcefulness, Maria navigated the complexities of the real estate market, leveraging her unique perspective and life experiences to identify lucrative investment opportunities. Her journey serves as a testament to the indomitable spirit of individuals who refuse to be bound by limitations, turning adversity into opportunity and paving the way for a brighter future.<\\/p>\\r\\n\\r\\n\\r\\n<p>These are just a few examples of the countless inspiring stories that illuminate the landscape of real estate investing. Each one is a reminder that success is not merely the result of luck or circumstance but of vision, perseverance, and unwavering determination. As we celebrate these achievements, let us draw inspiration from their journeys and embark on our own paths towards greatness. After all, in the world of real estate investing, the possibilities are as limitless as our imagination and determination to succeed.<\\/p>\",\"image\":\"65ec1c4af26c61709972554.png\"}', 'basic', '2024-02-07 23:58:32', '2024-03-19 09:43:32'),
(94, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Overcoming Common Challenges in Real Estate Investment\",\"description\":\"<p>Investing in real estate can be a lucrative venture, but it\'s not without its challenges. From market fluctuations to regulatory hurdles, navigating the world of real estate investment requires skill, knowledge, and perseverance. In this blog, we\'ll explore some of the common barriers that investors face and discuss strategies for overcoming them.<\\/p>\\r\\n\\r\\n<h6>Market Volatility: A Natural Challenge<\\/h6>\\r\\n<p>One of the most significant challenges in real estate investment is market volatility. The real estate market is subject to fluctuations influenced by factors such as economic conditions, interest rates, and consumer confidence. These fluctuations can make it difficult for investors to predict future returns and plan their investments accordingly. However, savvy investors understand that market volatility is a natural part of the investment landscape and take steps to mitigate its impact.One strategy for overcoming market volatility is diversification. By spreading their investments across different properties and geographic locations, investors can reduce their exposure to risk. Diversification allows investors to capitalize on opportunities in different markets while minimizing the impact of downturns in any one area.<\\/p>\\r\\n\\r\\n<h6>Financing: Overcoming Barriers to Capital<\\/h6>\\r\\n<p>Another common challenge in real estate investment is financing. Securing funding for real estate projects can be challenging, especially for new investors or those with less-than-perfect credit. Traditional lenders may require large down payments and extensive documentation, making it difficult for some investors to access the capital they need.To overcome financing barriers, investors can explore alternative financing options such as private lenders, crowdfunding platforms, or seller financing. These alternative sources of funding may offer more flexible terms and faster approval processes, allowing investors to seize opportunities quickly and efficiently.<\\/p>\\r\\n\\r\\n<h6>Navigating Regulatory Hurdles<\\/h6>\\r\\n<p>Regulatory hurdles are another obstacle that investors may encounter in real estate investment. Local zoning laws, building codes, and permitting requirements can vary widely from one jurisdiction to another, making it essential for investors to understand and comply with all applicable regulations.To navigate regulatory barriers, investors should conduct thorough due diligence and work closely with experienced real estate professionals who understand the local market and regulatory landscape. Building relationships with local officials and stakeholders can also help investors streamline the permitting process and avoid costly delays.\\r\\n<\\/p>\\r\\n\\r\\n<h6>Property Management: A Critical Component<\\/h6>\\r\\n<p>Effective property management is critical to the long-term success of a real estate investment. Investors must ensure that their properties are well-maintained, attract and retain quality tenants, and generate consistent cash flow. This may require outsourcing property management tasks to professionals or investing in technology solutions that streamline the management process.\\r\\nMaintaining positive tenant relations is another key aspect of successful real estate investment. Happy tenants are more likely to renew their leases, take care of the property, and recommend it to others. Investors should strive to provide responsive and attentive customer service, address tenant concerns promptly, and maintain open lines of communication.<\\/p>\\r\\n\\r\\n<h6>Preparing for the Unexpected<\\/h6>\\r\\n<p>Finally, investors must be prepared to deal with unexpected expenses such as repairs, vacancies, or changes in market conditions. Building a financial cushion and conducting regular property inspections can help investors anticipate and mitigate these expenses, ensuring the long-term profitability of their investments.<\\/p>\\r\\n\\r\\n<p>In conclusion, while real estate investment presents numerous challenges, savvy investors can overcome these barriers and achieve success in the market. By diversifying their portfolios, exploring alternative financing options, understanding and complying with regulatory requirements, and adopting effective property management practices, investors can build a resilient and profitable real estate portfolio. With diligence, patience, and perseverance, breaking barriers in real estate investment is not only possible but highly achievable.<\\/p>\",\"image\":\"65ec1f75d0b011709973365.png\"}', 'basic', '2024-02-08 00:00:21', '2024-03-19 09:49:22'),
(96, 'referral.content', '{\"title\":\"Refer & Enjoy the Bonus\",\"description\":\"You\'ll get commission against your referral\'s activities. Level has been decided by the RealVest authority. If you reach the level, you\'ll get commission.\"}', 'basic', '2024-02-10 01:35:47', '2024-02-10 01:35:47'),
(97, 'banned.content', '{\"has_image\":\"1\",\"heading\":\"You are banned\",\"image\":\"65c736943a12b1707554452.png\"}', 'basic', '2024-02-10 02:40:52', '2024-02-10 02:40:52'),
(98, 'brands.element', '{\"has_image\":\"1\",\"image\":\"65e004417ef681709179969.png\"}', 'basic', '2024-02-29 04:12:49', '2024-02-29 04:12:49'),
(99, 'brands.element', '{\"has_image\":\"1\",\"image\":\"65e004467627f1709179974.png\"}', 'basic', '2024-02-29 04:12:54', '2024-02-29 04:12:54'),
(100, 'brands.element', '{\"has_image\":\"1\",\"image\":\"65e0044b651701709179979.png\"}', 'basic', '2024-02-29 04:12:59', '2024-02-29 04:12:59'),
(101, 'faq.element', '{\"question\":\"How much money do I need to invest in real estate?\",\"answer\":\"The amount of money needed depends on various factors, including the type of property, its location, market conditions, financing options, and your investment goals. You can invest directly or indirectly through real estate investment trusts (REITs) or crowdfunding platforms, which may require lower initial investments.\"}', 'basic', '2024-03-09 11:47:09', '2024-03-09 11:47:09'),
(102, 'faq.element', '{\"question\":\"How can I finance a real estate investment?\",\"answer\":\"Financing options include traditional mortgages, private loans, hard money loans, seller financing, crowdfunding, and partnerships. The choice of financing depends on factors such as your creditworthiness, the property\'s value, and your investment strategy.\"}', 'basic', '2024-03-09 11:47:30', '2024-03-09 11:47:30');
INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `tempname`, `created_at`, `updated_at`) VALUES
(103, 'faq.element', '{\"question\":\"How can I maximize returns on my real estate investments?\",\"answer\":\"Strategies for maximizing returns include conducting thorough due diligence, investing in high-demand areas, maintaining properties effectively, optimizing rental income, minimizing expenses, leveraging tax advantages, and staying informed about market trends.\"}', 'basic', '2024-03-09 11:47:50', '2024-03-09 11:47:50'),
(104, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Rachel Lewis\",\"address\":\"Paris\",\"review\":\"I\'ve been with this platform for years, and they consistently deliver exceptional results. Their transparent communication and strategic investment advice have earned my trust and loyalty.\",\"image\":\"65fa75e5c16a21710912997.png\"}', 'basic', '2024-03-20 05:36:37', '2024-03-20 05:36:37'),
(105, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Mark Roberts\",\"address\":\"New York\",\"review\":\"A reliable partner for real estate investing! They guided me through every step of the process, from property selection to closing deals. Their expertise and professionalism are unmatched\",\"image\":\"65fa762d3be721710913069.png\"}', 'basic', '2024-03-20 05:37:49', '2024-03-20 05:37:49'),
(106, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Samantha Garcia\",\"address\":\"San Francisco\",\"review\":\"I\'m impressed by the level of professionalism and dedication displayed here. They genuinely care about their clients\' success and go above and beyond to ensure optimal outcomes.\",\"image\":\"65fa76d4033ca1710913236.png\"}', 'basic', '2024-03-20 05:40:36', '2024-03-20 05:40:36');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `code` int(11) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `alias` varchar(40) NOT NULL DEFAULT 'NULL',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` text DEFAULT NULL,
  `supported_currencies` text DEFAULT NULL,
  `crypto` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `form_id`, `code`, `name`, `alias`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES
(1, 0, 101, 'Paypal', 'Paypal', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-owud61543012@business.example.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 00:04:38'),
(2, 0, 102, 'Perfect Money', 'PerfectMoney', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"-------------\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-03-21 00:57:00'),
(3, 0, 103, 'Stripe Hosted', 'Stripe', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---------------\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"----------------------\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-03-21 00:56:51'),
(4, 0, 104, 'Skrill', 'Skrill', 1, '{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"merchant@skrill.com\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:30:16'),
(5, 0, 105, 'PayTM', 'Paytm', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"------------\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"-----------------\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"------------\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"---------------\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"---------------\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-03-21 00:57:13'),
(6, 0, 106, 'Payeer', 'Payeer', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"866989763\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"7575\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.Payeer\"}}', NULL, '2019-09-14 13:14:22', '2022-08-28 10:11:14'),
(7, 0, 107, 'PayStack', 'Paystack', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_cd330608eb47970889bca397ced55c1dd5ad3783\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_8a0b1f199362d7acc9c390bff72c4e81f74e2ac3\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\"}}\r\n', NULL, '2019-09-14 13:14:22', '2021-05-21 01:49:51'),
(8, 0, 108, 'VoguePay', 'Voguepay', 1, '{\"merchant_id\":{\"title\":\"MERCHANT ID\",\"global\":true,\"value\":\"demo\"}}', '{\"USD\":\"USD\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:22:38'),
(9, 0, 109, 'Flutterwave', 'Flutterwave', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"----------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------------------\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"------------------\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-06-05 11:37:45'),
(10, 0, 110, 'RazorPay', 'Razorpay', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"rzp_test_kiOtejPbRZU90E\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"osRDebzEqbsE1kbyQJ4y0re7\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:51:32'),
(11, 0, 111, 'Stripe Storefront', 'StripeJs', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 00:53:10'),
(12, 0, 112, 'Instamojo', 'Instamojo', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"-----------------\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"---------------\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"--------------\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-03-21 00:55:51'),
(13, 0, 501, 'Blockchain', 'Blockchain', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"--------------\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"-------------------\"}}', '{\"BTC\":\"BTC\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2024-03-21 00:54:51'),
(15, 0, 503, 'CoinPayments', 'Coinpayments', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"---------------------\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"---------------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"---------------------\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"USDT.BEP20\":\"Tether USD (BSC Chain)\",\"USDT.ERC20\":\"Tether USD (ERC20)\",\"USDT.TRC20\":\"Tether USD (Tron/TRC20)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2023-04-08 03:17:18'),
(16, 0, 504, 'CoinPayments Fiat', 'CoinpaymentsFiat', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"----------\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-03-21 00:55:32'),
(17, 0, 505, 'Coingate', 'Coingate', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"-----------------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-03-21 00:55:23'),
(18, 0, 506, 'Coinbase Commerce', 'CoinbaseCommerce', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"---------------------\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"----------------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\"}}', NULL, '2019-09-14 13:14:22', '2024-03-21 00:55:14'),
(24, 0, 113, 'Paypal Express', 'PaypalSdk', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"-----------------\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"---------------\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-03-21 00:57:24'),
(25, 0, 114, 'Stripe Checkout', 'StripeV3', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------------------\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"---------------\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"------------------\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\"}}', NULL, '2019-09-14 13:14:22', '2024-03-21 00:56:40'),
(27, 0, 115, 'Mollie', 'Mollie', 1, '{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"vi@gmail.com\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:44:45'),
(30, 0, 116, 'Cashmaal', 'Cashmaal', 1, '{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"------------\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"------------\"}}', '{\"PKR\":\"PKR\",\"USD\":\"USD\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.Cashmaal\"}}', NULL, NULL, '2024-03-21 00:55:01'),
(36, 0, 119, 'Mercado Pago', 'MercadoPago', 1, '{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"----------\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-03-21 00:57:47'),
(37, 0, 120, 'Authorize.net', 'Authorize', 1, '{\"login_id\":{\"title\":\"Login ID\",\"global\":true,\"value\":\"-------\"},\"transaction_key\":{\"title\":\"Transaction Key\",\"global\":true,\"value\":\"----------\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-03-21 00:54:30'),
(46, 0, 121, 'NMI', 'NMI', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"2F822Rw39fx762MaV7Yy86jXGTC7sCDy\"}}', '{\"AED\":\"AED\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"RUB\":\"RUB\",\"SEC\":\"SEC\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2022-08-28 10:32:31'),
(50, 0, 507, 'BTCPay', 'BTCPay', 1, '{\"store_id\":{\"title\":\"Store Id\",\"global\":true,\"value\":\"-------------------\"},\"api_key\":{\"title\":\"Api Key\",\"global\":true,\"value\":\"-----------------\"},\"server_name\":{\"title\":\"Server Name\",\"global\":true,\"value\":\"---------------\"},\"secret_code\":{\"title\":\"Secret Code\",\"global\":true,\"value\":\"--------------\"}}', '{\"BTC\":\"Bitcoin\",\"LTC\":\"Litecoin\"}', 1, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.BTCPay\"}}', NULL, NULL, '2024-03-21 00:54:43'),
(51, 0, 508, 'Now payments hosted', 'NowPaymentsHosted', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"--------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------------\"}}', '{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDT\":\"USDT\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}', 1, '', NULL, NULL, '2023-02-14 05:08:23'),
(52, 0, 509, 'Now payments checkout', 'NowPaymentsCheckout', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"---------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------\"}}', '{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDT\":\"USDT\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}', 1, '', NULL, NULL, '2023-02-14 05:08:04'),
(53, 0, 122, '2Checkout', 'TwoCheckout', 1, '{\"merchant_code\":{\"title\":\"Merchant Code\",\"global\":true,\"value\":\"-----------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-------------\"}}', '{\"AFN\": \"AFN\",\"ALL\": \"ALL\",\"DZD\": \"DZD\",\"ARS\": \"ARS\",\"AUD\": \"AUD\",\"AZN\": \"AZN\",\"BSD\": \"BSD\",\"BDT\": \"BDT\",\"BBD\": \"BBD\",\"BZD\": \"BZD\",\"BMD\": \"BMD\",\"BOB\": \"BOB\",\"BWP\": \"BWP\",\"BRL\": \"BRL\",\"GBP\": \"GBP\",\"BND\": \"BND\",\"BGN\": \"BGN\",\"CAD\": \"CAD\",\"CLP\": \"CLP\",\"CNY\": \"CNY\",\"COP\": \"COP\",\"CRC\": \"CRC\",\"HRK\": \"HRK\",\"CZK\": \"CZK\",\"DKK\": \"DKK\",\"DOP\": \"DOP\",\"XCD\": \"XCD\",\"EGP\": \"EGP\",\"EUR\": \"EUR\",\"FJD\": \"FJD\",\"GTQ\": \"GTQ\",\"HKD\": \"HKD\",\"HNL\": \"HNL\",\"HUF\": \"HUF\",\"INR\": \"INR\",\"IDR\": \"IDR\",\"ILS\": \"ILS\",\"JMD\": \"JMD\",\"JPY\": \"JPY\",\"KZT\": \"KZT\",\"KES\": \"KES\",\"LAK\": \"LAK\",\"MMK\": \"MMK\",\"LBP\": \"LBP\",\"LRD\": \"LRD\",\"MOP\": \"MOP\",\"MYR\": \"MYR\",\"MVR\": \"MVR\",\"MRO\": \"MRO\",\"MUR\": \"MUR\",\"MXN\": \"MXN\",\"MAD\": \"MAD\",\"NPR\": \"NPR\",\"TWD\": \"TWD\",\"NZD\": \"NZD\",\"NIO\": \"NIO\",\"NOK\": \"NOK\",\"PKR\": \"PKR\",\"PGK\": \"PGK\",\"PEN\": \"PEN\",\"PHP\": \"PHP\",\"PLN\": \"PLN\",\"QAR\": \"QAR\",\"RON\": \"RON\",\"RUB\": \"RUB\",\"WST\": \"WST\",\"SAR\": \"SAR\",\"SCR\": \"SCR\",\"SGD\": \"SGD\",\"SBD\": \"SBD\",\"ZAR\": \"ZAR\",\"KRW\": \"KRW\",\"LKR\": \"LKR\",\"SEK\": \"SEK\",\"CHF\": \"CHF\",\"SYP\": \"SYP\",\"THB\": \"THB\",\"TOP\": \"TOP\",\"TTD\": \"TTD\",\"TRY\": \"TRY\",\"UAH\": \"UAH\",\"AED\": \"AED\",\"USD\": \"USD\",\"VUV\": \"VUV\",\"VND\": \"VND\",\"XOF\": \"XOF\",\"YER\": \"YER\"}', 1, '{\"approved_url\":{\"title\": \"Approved URL\",\"value\":\"ipn.TwoCheckout\"}}', NULL, NULL, '2024-03-21 00:56:29'),
(54, 0, 123, 'Checkout', 'Checkout', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------\"},\"public_key\":{\"title\":\"PUBLIC KEY\",\"global\":true,\"value\":\"------\"},\"processing_channel_id\":{\"title\":\"PROCESSING CHANNEL\",\"global\":true,\"value\":\"------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"AUD\":\"AUD\",\"CAN\":\"CAN\",\"CHF\":\"CHF\",\"SGD\":\"SGD\",\"JPY\":\"JPY\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2023-05-06 07:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `currency` varchar(40) DEFAULT NULL,
  `symbol` varchar(40) DEFAULT NULL,
  `method_code` int(11) DEFAULT NULL,
  `gateway_alias` varchar(40) DEFAULT NULL,
  `min_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `max_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `image` varchar(255) DEFAULT NULL,
  `gateway_parameter` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(40) DEFAULT NULL,
  `cur_text` varchar(40) DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) DEFAULT NULL,
  `email_template` text DEFAULT NULL,
  `sms_body` varchar(255) DEFAULT NULL,
  `sms_from` varchar(255) DEFAULT NULL,
  `base_color` varchar(40) DEFAULT NULL,
  `mail_config` text DEFAULT NULL COMMENT 'email configuration',
  `sms_config` text DEFAULT NULL,
  `global_shortcodes` text DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT 0,
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'mobile verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sms notification, 0 - dont send, 1 - send',
  `force_ssl` tinyint(1) NOT NULL DEFAULT 0,
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT 0,
  `secure_password` tinyint(1) NOT NULL DEFAULT 0,
  `agree` tinyint(1) NOT NULL DEFAULT 0,
  `multi_language` tinyint(1) NOT NULL DEFAULT 1,
  `registration` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Off	, 1: On',
  `active_template` varchar(40) DEFAULT NULL,
  `system_info` text DEFAULT NULL,
  `system_customized` tinyint(1) NOT NULL DEFAULT 0,
  `deposit_commission` tinyint(1) NOT NULL DEFAULT 1,
  `invest_commission` tinyint(1) NOT NULL DEFAULT 1,
  `profit_commission` tinyint(1) NOT NULL DEFAULT 1,
  `last_cron` timestamp NULL DEFAULT NULL,
  `socialite_credentials` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `cur_text`, `cur_sym`, `email_from`, `email_template`, `sms_body`, `sms_from`, `base_color`, `mail_config`, `sms_config`, `global_shortcodes`, `kv`, `ev`, `en`, `sv`, `sn`, `force_ssl`, `maintenance_mode`, `secure_password`, `agree`, `multi_language`, `registration`, `active_template`, `system_info`, `system_customized`, `deposit_commission`, `invest_commission`, `profit_commission`, `last_cron`, `socialite_credentials`, `created_at`, `updated_at`) VALUES
(1, 'RealVest', 'USD', '$', 'info@viserlab.com', '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n  <!--[if !mso]><!-->\r\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n  <!--<![endif]-->\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n  <title></title>\r\n  <style type=\"text/css\">\r\n.ReadMsgBody { width: 100%; background-color: #ffffff; }\r\n.ExternalClass { width: 100%; background-color: #ffffff; }\r\n.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }\r\nhtml { width: 100%; }\r\nbody { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }\r\ntable { border-spacing: 0; table-layout: fixed; margin: 0 auto;border-collapse: collapse; }\r\ntable table table { table-layout: auto; }\r\n.yshortcuts a { border-bottom: none !important; }\r\nimg:hover { opacity: 0.9 !important; }\r\na { color: #0087ff; text-decoration: none; }\r\n.textbutton a { font-family: \'open sans\', arial, sans-serif !important;}\r\n.btn-link a { color:#FFFFFF !important;}\r\n\r\n@media only screen and (max-width: 480px) {\r\nbody { width: auto !important; }\r\n*[class=\"table-inner\"] { width: 90% !important; text-align: center !important; }\r\n*[class=\"table-full\"] { width: 100% !important; text-align: center !important; }\r\n/* image */\r\nimg[class=\"img1\"] { width: 100% !important; height: auto !important; }\r\n}\r\n</style>\r\n\r\n\r\n\r\n  <table bgcolor=\"#414a51\" width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n    <tbody><tr>\r\n      <td height=\"50\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n          <tbody><tr>\r\n            <td align=\"center\" width=\"600\">\r\n              <!--header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#0087ff\" style=\"border-top-left-radius:6px; border-top-right-radius:6px;text-align:center;vertical-align:top;font-size:0;\" align=\"center\">\r\n                    <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#FFFFFF; font-size:16px; font-weight: bold;\">This is a System Generated Email</td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n              <!--end header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#FFFFFF\" align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"35\"></td>\r\n                      </tr>\r\n                      <!--logo-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"vertical-align:top;font-size:0;\">\r\n                          <a href=\"#\">\r\n                            <img style=\"display:block; line-height:0px; font-size:0px; border:0px;\" src=\"https://i.imgur.com/Z1qtvtV.png\" alt=\"img\">\r\n                          </a>\r\n                        </td>\r\n                      </tr>\r\n                      <!--end logo-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n                      <!--headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 22px;color:#414a51;font-weight: bold;\">Hello {{fullname}} ({{username}})</td>\r\n                      </tr>\r\n                      <!--end headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                          <table width=\"40\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                            <tbody><tr>\r\n                              <td height=\"20\" style=\" border-bottom:3px solid #0087ff;\"></td>\r\n                            </tr>\r\n                          </tbody></table>\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <!--content-->\r\n                      <tr>\r\n                        <td align=\"left\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#7f8c8d; font-size:16px; line-height: 28px;\">{{message}}</td>\r\n                      </tr>\r\n                      <!--end content-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n              \r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n                <tr>\r\n                  <td height=\"45\" align=\"center\" bgcolor=\"#f4f4f4\" style=\"border-bottom-left-radius:6px;border-bottom-right-radius:6px;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                      <!--preference-->\r\n                      <tr>\r\n                        <td class=\"preference-link\" align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#95a5a6; font-size:14px;\">\r\n                          © 2024 <a href=\"#\">{{site_name}}</a>&nbsp;. All Rights Reserved. \r\n                        </td>\r\n                      </tr>\r\n                      <!--end preference-->\r\n                      <tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n            </td>\r\n          </tr>\r\n        </tbody></table>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td height=\"60\"></td>\r\n    </tr>\r\n  </tbody></table>', 'hi {{fullname}} ({{username}}), {{message}}', 'ViserAdmin', 'FF6600', '{\"name\":\"php\"}', '{\"name\":\"nexmo\",\"clickatell\":{\"api_key\":\"----------------\"},\"infobip\":{\"username\":\"------------8888888\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}', '{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}', 0, 0, 1, 0, 1, 0, 0, 0, 1, 1, 1, 'basic', '[]', 0, 1, 1, 1, '2024-03-20 23:58:17', '{\"google\":{\"client_id\":\"-----------------\",\"client_secret\":\"-------------\",\"status\":1},\"facebook\":{\"client_id\":\"---------------\",\"client_secret\":\"---------------\",\"status\":1},\"linkedin\":{\"client_id\":\"----------------\",\"client_secret\":\"--------------\",\"status\":1}}', NULL, '2024-03-21 00:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `installments`
--

CREATE TABLE `installments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invest_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `paid_time` timestamp NULL DEFAULT NULL,
  `next_time` timestamp NULL DEFAULT NULL,
  `late_fee` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=Success,2=Pending\r\n',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invests`
--

CREATE TABLE `invests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `property_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `investment_id` varchar(40) DEFAULT NULL,
  `total_invest_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `initial_invest_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `paid_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `due_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `per_installment_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `invest_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = running, 2 = completed',
  `next_profit_date` timestamp NULL DEFAULT NULL,
  `profit_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '3 = investment running, 1 = running, 2 = complete',
  `total_profit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `get_profit_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `code` varchar(40) DEFAULT NULL,
  `image` varchar(40) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: not default language, 1: default language',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `image`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', '65f7c1a85f8f11710735784.png', 1, '2020-07-06 03:47:55', '2024-03-18 04:23:04'),
(9, 'Bangla', 'bn', '65f7c142e9bbc1710735682.png', 0, '2021-03-14 04:37:41', '2024-03-18 04:21:23'),
(11, 'Spanish', 'es', '65f7c1ded01571710735838.png', 0, '2024-03-18 04:23:58', '2024-03-18 04:23:58'),
(12, 'French', 'fr', '65f7c21c4fa981710735900.png', 0, '2024-03-18 04:25:00', '2024-03-18 04:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `image` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sender` varchar(40) DEFAULT NULL,
  `sent_from` varchar(40) DEFAULT NULL,
  `sent_to` varchar(40) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `notification_type` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `act` varchar(40) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `subj` varchar(255) DEFAULT NULL,
  `email_body` text DEFAULT NULL,
  `sms_body` text DEFAULT NULL,
  `shortcodes` text DEFAULT NULL,
  `email_status` tinyint(1) NOT NULL DEFAULT 1,
  `sms_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subj`, `email_body`, `sms_body`, `shortcodes`, `email_status`, `sms_status`, `created_at`, `updated_at`) VALUES
(1, 'BAL_ADD', 'Balance - Added', 'Your Account has been Credited', '<div><div style=\"font-family: Montserrat, sans-serif;\">{{amount}} {{site_currency}} has been added to your account .</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Your Current Balance is :&nbsp;</span><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">{{post_balance}}&nbsp; {{site_currency}}&nbsp;</span></font><br></div><div><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></font></div><div>Admin note:&nbsp;<span style=\"color: rgb(33, 37, 41); font-size: 12px; font-weight: 600; white-space: nowrap; text-align: var(--bs-body-text-align);\">{{remark}}</span></div>', '{{amount}} {{site_currency}} credited in your account. Your Current Balance {{post_balance}} {{site_currency}} . Transaction: #{{trx}}. Admin note is \"{{remark}}\"', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 0, '2021-11-03 12:00:00', '2022-04-03 02:18:28'),
(2, 'BAL_SUB', 'Balance - Subtracted', 'Your Account has been Debited', '<div style=\"font-family: Montserrat, sans-serif;\">{{amount}} {{site_currency}} has been subtracted from your account .</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">Your Current Balance is :&nbsp;</span><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">{{post_balance}}&nbsp; {{site_currency}}</span></font><br><div><font style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></font></div><div>Admin Note: {{remark}}</div>', '{{amount}} {{site_currency}} debited from your account. Your Current Balance {{post_balance}} {{site_currency}} . Transaction: #{{trx}}. Admin Note is {{remark}}', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, '2021-11-03 12:00:00', '2022-04-03 02:24:11'),
(3, 'DEPOSIT_COMPLETE', 'Deposit - Automated - Successful', 'Deposit Completed Successfully', '<div>Your deposit of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been completed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#000000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Received : {{method_amount}} {{method_currency}}<br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} Deposit successfully by {{method_name}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, '2021-11-03 12:00:00', '2022-04-03 02:25:43'),
(4, 'DEPOSIT_APPROVE', 'Deposit - Manual - Approved', 'Your Deposit is Approved', '<div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Received : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Admin Approve Your {{amount}} {{site_currency}} payment request by {{method_name}} transaction : {{trx}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, 1, '2021-11-03 12:00:00', '2022-04-03 02:26:07'),
(5, 'DEPOSIT_REJECT', 'Deposit - Manual - Rejected', 'Your Deposit Request is Rejected', '<div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}} has been rejected</span>.<span style=\"font-weight: bolder;\"><br></span></div><div><br></div><div><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Received : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge: {{charge}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number was : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">if you have any queries, feel free to contact us.<br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><br><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">{{rejection_message}}</span><br>', 'Admin Rejected Your {{amount}} {{site_currency}} payment request by {{method_name}}\r\n\r\n{{rejection_message}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"rejection_message\":\"Rejection message by the admin\"}', 1, 1, '2021-11-03 12:00:00', '2022-04-05 03:45:27'),
(6, 'DEPOSIT_REQUEST', 'Deposit - Manual - Requested', 'Deposit Request Submitted Successfully', '<div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}}<br></div><div>Pay via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} Deposit requested by {{method_name}}. Charge: {{charge}} . Trx: {{trx}}', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, 1, '2021-11-03 12:00:00', '2022-04-03 02:29:19'),
(7, 'PASS_RESET_CODE', 'Password - Reset - Code', 'Password Reset', '<div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">{{time}} .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">{{code}}</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div>', 'Your account recovery code is: {{code}}', '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, 0, '2021-11-03 12:00:00', '2022-03-20 20:47:05'),
(8, 'PASS_RESET_DONE', 'Password - Reset - Confirmation', 'You have reset your password', '<p style=\"font-family: Montserrat, sans-serif;\">You have successfully reset your password.</p><p style=\"font-family: Montserrat, sans-serif;\">You changed from&nbsp; IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{time}}</span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><font color=\"#ff0000\">If you did not change that, please contact us as soon as possible.</font></span></p>', 'Your password has been changed successfully', '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, 1, '2021-11-03 12:00:00', '2022-04-05 03:46:35'),
(9, 'ADMIN_SUPPORT_REPLY', 'Support - Reply', 'Reply Support Ticket', '<div><p><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\">A member from our support team has replied to the following ticket:</span></span></p><p><span style=\"font-weight: bolder;\"><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\"><br></span></span></span></p><p><span style=\"font-weight: bolder;\">[Ticket#{{ticket_id}}] {{ticket_subject}}<br><br>Click here to reply:&nbsp; {{link}}</span></p><p>----------------------------------------------</p><p>Here is the reply :<br></p><p>{{reply}}<br></p></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', 'Your Ticket#{{ticket_id}} :  {{ticket_subject}} has been replied.', '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}', 1, 1, '2021-11-03 12:00:00', '2022-03-20 20:47:51'),
(10, 'EVER_CODE', 'Verification - Email', 'Please verify your email address', '<br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;{{code}}</span></font></div></div>', '---', '{\"code\":\"Email verification code\"}', 1, 0, '2021-11-03 12:00:00', '2022-04-03 02:32:07'),
(11, 'SVER_CODE', 'Verification - SMS', 'Verify Your Mobile Number', '---', 'Your phone verification code is: {{code}}', '{\"code\":\"SMS Verification Code\"}', 0, 1, '2021-11-03 12:00:00', '2022-03-20 19:24:37'),
(12, 'WITHDRAW_APPROVE', 'Withdraw - Approved', 'Withdraw Request has been Processed and your money is sent', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been Processed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\">Details of Processed Payment :</font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\"><span style=\"font-weight: bolder;\">{{admin_details}}</span></font></div>', 'Admin Approve Your {{amount}} {{site_currency}} withdraw request by {{method_name}}. Transaction {{trx}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"admin_details\":\"Details provided by the admin\"}', 1, 1, '2021-11-03 12:00:00', '2022-03-20 20:50:16'),
(13, 'WITHDRAW_REJECT', 'Withdraw - Rejected', 'Withdraw Request has been Rejected and your money is refunded to your account', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been Rejected.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You should get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">----</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\"><br></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"3\">{{amount}} {{currency}} has been&nbsp;<span style=\"font-weight: bolder;\">refunded&nbsp;</span>to your account and your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}}</span><span style=\"font-weight: bolder;\">&nbsp;{{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">-----</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\">Details of Rejection :</font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\"><span style=\"font-weight: bolder;\">{{admin_details}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br><br><br></div><div></div><div></div>', 'Admin Rejected Your {{amount}} {{site_currency}} withdraw request. Your Main Balance {{post_balance}}  {{method_name}} , Transaction {{trx}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this action\",\"admin_details\":\"Rejection message by the admin\"}', 1, 1, '2021-11-03 12:00:00', '2022-03-20 20:57:46'),
(14, 'WITHDRAW_REQUEST', 'Withdraw - Requested', 'Withdraw Request Submitted Successfully', '<div style=\"font-family: Montserrat, sans-serif;\">Your withdraw request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp; via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been submitted Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your withdraw:<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">You will get: {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br><br><br></div>', '{{amount}} {{site_currency}} withdraw requested by {{method_name}}. You will get {{method_amount}} {{method_currency}} Trx: {{trx}}', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this transaction\"}', 1, 1, '2021-11-03 12:00:00', '2022-03-21 04:39:03'),
(15, 'DEFAULT', 'Default Template', '{{subject}}', '{{message}}', '{{message}}', '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, 1, '2019-09-14 13:14:22', '2021-11-04 09:38:55'),
(16, 'KYC_APPROVE', 'KYC Approved', 'KYC has been approved', NULL, NULL, '[]', 1, 1, NULL, NULL),
(17, 'KYC_REJECT', 'KYC Rejected Successfully', 'KYC has been rejected', NULL, NULL, '[]', 1, 1, NULL, NULL),
(18, 'INVESTMENT', 'Investment', 'Investment successfully completed', '<div style=\"font-family: Montserrat, sans-serif;\">Your&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;investment successfully completed.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Investment:</span></div><div style=\"font-family: Montserrat, sans-serif;\">Invested Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: rgb(33, 37, 41);\">Property name: {{property_name}}</span></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Your {{amount}} {{site_currency}} investment successfully completed. Property name: {{property_name}}.', '{\r\n    \"amount\": \"Amount paid by the user\",\"paid_amount\":\"Total paid amount\",\"due_amount\":\"Total due amount\",\"property_name\": \"Property name\",\"post_balance\": \"Balance of the user after this transaction\"\r\n}', 1, 1, '2023-09-07 05:47:27', '2024-02-29 06:10:04'),
(19, 'REFERRAL_COMMISSION', 'Referral Commission', 'Referral Commission', '<div style=\"font-family: Montserrat, sans-serif;\">You got&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;referral commission.</div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your referral commission:</span></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">{{type}} referral commission</div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: rgb(33, 37, 41);\">Transaction Number : {{trx}}</span><br></div><div style=\"font-family: Montserrat, sans-serif;\">{{level}} level referral commission.</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Your got {{amount}} {{site_currency}} referral commission from {{ref_username}}.', '{\n    \"trx\": \"Transaction number for the interest\",\n    \"amount\": \"Amount inserted by the user\",\n    \"type\": \"Commission type\",\n    \"level\": \"Which level referral commission\",\n    \"post_balance\": \"Balance of the user after this transaction\",\n}', 1, 1, '2023-09-07 05:47:55', '2023-09-07 05:47:55'),
(20, 'DOWN_PAYMENT', 'Down Payment', 'Down payment successful', '<div style=\"font-family: Montserrat, sans-serif;\">Your&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;down payment successfully completed.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Down payment:</span></div><div style=\"font-family: Montserrat, sans-serif;\">Paid Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\"><div><span style=\"color: rgb(33, 37, 41);\">Property Name: {{property_name}}</span></div><div>Transaction Number : {{trx}}</div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\">Total Invested Amount :&nbsp;{{invested_amount}}&nbsp;{{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Total Paid Amount :&nbsp;{{paid_amount}}&nbsp;{{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Total Due Amount :&nbsp;{{due_amount}}&nbsp;{{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Your {{amount}} {{site_currency}} down payment successfully completed. Property name: {{property_name}}. Trx: {{trx}}', '{\r\n    \"trx\": \"Transaction number for the interest\",\"amount\": \"Down payment by the user\",\"invested_amount\":\"Total invested amount\",\"paid_amount\":\"Total paid amount\",\"due_amount\":\"Total due amount\",\"property_name\": \"Property name\",\"post_balance\": \"Balance of the user after this transaction\"\r\n}', 1, 1, '2023-09-16 04:54:13', '2024-02-29 06:24:31'),
(21, 'INSTALLMENT', 'Installment', 'Installment successful', '<div style=\"font-family: Montserrat, sans-serif;\">Your&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;installment successfully completed.<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Installment:</span></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"color: rgb(33, 37, 41);\">Property name: {{property_name}}</span></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><div>Total Invested Amount :&nbsp;{{invested_amount}}&nbsp;{{site_currency}}</div><div>Total Paid Amount :&nbsp;{{paid_amount}}&nbsp;{{site_currency}}</div><div>Total Due Amount :&nbsp;{{due_amount}}&nbsp;{{site_currency}}</div></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Your {{amount}} {{site_currency}} installment successfully completed. Property name: {{property_name}}. Trx: {{trx}}', '{\r\n    \"trx\": \"Transaction number for the interest\",\"amount\": \"Installment payment by the user\",\"invested_amount\":\"Total invested amount\",\"paid_amount\":\"Total paid amount\",\"due_amount\":\"Total due amount\",\"property_name\": \"Property name\",\"post_balance\": \"Balance of the user after this transaction\"\r\n}', 1, 1, NULL, '2024-02-29 06:25:46'),
(22, 'PROFIT', 'Profit', 'Profit added to your balance', '<div style=\"font-family: Montserrat, sans-serif;\">You got&nbsp;<span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{amount}} {{site_currency}}</span><span style=\"color: rgb(33, 37, 41); font-size: 1rem; text-align: var(--bs-body-text-align);\">&nbsp;profit.</span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Profit:</span></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Property Name: {{property_name}}</div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'You got {{amount}} {{site_currency}} profit. Property: {{property_name}}. Trx: {{trx}}', '{\r\n    \"trx\": \"Transaction number for the interest\",\r\n    \"amount\": \"Profit amount\",\r\n    \"property_name\": \"Property name\",\r\n    \"post_balance\": \"Balance of the user after this transaction\"\r\n}', 1, 1, '2023-09-20 09:17:20', '2024-03-16 06:17:57'),
(23, 'CAPITAL_BACK', 'Capital back', 'Invested amount added to your balance', '<div style=\"font-family: Montserrat, sans-serif;\">You got&nbsp;<span style=\"font-size: 1rem; text-align: var(--bs-body-text-align); font-weight: bolder;\">{{amount}} {{site_currency}}</span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Capital back:</span></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Property Name: {{property_name}}</div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'You got {{amount}} {{site_currency}} capital back. Property: {{property_name}}. Trx: {{trx}}', '{\r\n    \"trx\": \"Transaction number for the capital back\",\r\n    \"amount\": \"Amount invested by the user\",\r\n    \"property_name\": \"Property name\",\r\n    \"post_balance\": \"Balance of the user after this transaction\"\r\n}', 1, 1, '2023-09-20 09:17:20', '2024-03-13 05:24:40');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `slug` varchar(40) DEFAULT NULL,
  `tempname` varchar(40) DEFAULT NULL COMMENT 'template name',
  `secs` text DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', '/', 'templates.basic.', '[\"feature\",\"latest_property\",\"about\",\"cities\",\"featured_property\",\"testimonial\",\"blog\"]', 1, '2020-07-11 06:23:58', '2024-03-18 07:55:19'),
(4, 'Blogs', 'blog', 'templates.basic.', NULL, 1, '2020-10-22 01:14:43', '2024-02-05 08:44:09'),
(5, 'Contact', 'contact', 'templates.basic.', '[\"faq\"]', 1, '2020-10-22 01:14:53', '2024-03-19 06:30:49'),
(19, 'Property', 'property', 'templates.basic.', NULL, 1, '2023-11-18 13:15:54', '2024-02-05 08:45:43'),
(27, 'About', 'about', 'templates.basic.', '[\"about\",\"faq\"]', 0, '2024-03-20 22:35:53', '2024-03-20 22:36:56');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(40) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profits`
--

CREATE TABLE `profits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `property_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `invest_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = pending, 1 = success',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `location_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `invest_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = onetime, 2 = installment',
  `total_share` int(11) NOT NULL DEFAULT 0,
  `per_share_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `is_capital_back` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = yes, 2 = no',
  `profit_back` int(11) NOT NULL DEFAULT 0,
  `total_installment` int(11) NOT NULL DEFAULT 0,
  `per_installment_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `down_payment` decimal(5,2) NOT NULL DEFAULT 0.00,
  `installment_late_fee` decimal(5,2) NOT NULL DEFAULT 0.00,
  `installment_duration` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'time_settings_id',
  `profit_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = fixed, 2 = range',
  `profit_amount_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = fixed, 2 = percent',
  `profit_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `minimum_profit_amount` decimal(28,8) DEFAULT 0.00000000,
  `maximum_profit_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `profit_schedule` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = lifetime, 2 = repeated time, 3 = onetime',
  `profit_schedule_period` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'time_setting_id',
  `profit_repeat_time` int(11) NOT NULL DEFAULT 0,
  `profit_distribution` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = manual, 2 = auto',
  `auto_profit_distribution_amount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `map_url` text DEFAULT NULL,
  `details` text DEFAULT NULL,
  `amenities` text DEFAULT NULL,
  `goal_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `invested_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `invest_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = running, 2= completed',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `thumb_image` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `complete_step` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Completed Property Setting,2=Completed Investment \r\nSetting',
  `keywords` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_galleries`
--

CREATE TABLE `property_galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(40) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commission_type` varchar(40) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 0,
  `percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_message_id` int(10) UNSIGNED DEFAULT 0,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `admin_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `message` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `ticket` varchar(40) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_settings`
--

CREATE TABLE `time_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `time` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `invest_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `installment_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `profit_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `post_balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx_type` varchar(40) DEFAULT NULL,
  `trx` varchar(40) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `remark` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `update_logs`
--

CREATE TABLE `update_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(40) DEFAULT NULL,
  `update_log` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(40) DEFAULT NULL,
  `lastname` varchar(40) DEFAULT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `country_code` varchar(40) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `ref_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL COMMENT 'contains full address',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: banned, 1: active',
  `kyc_data` text DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: KYC Unverified, 2: KYC pending, 1: KYC verified',
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: mobile unverified, 1: mobile verified',
  `profile_complete` tinyint(1) NOT NULL DEFAULT 0,
  `ver_code` varchar(40) DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) DEFAULT NULL,
  `ban_reason` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `login_by` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_ip` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `country_code` varchar(40) DEFAULT NULL,
  `longitude` varchar(40) DEFAULT NULL,
  `latitude` varchar(40) DEFAULT NULL,
  `browser` varchar(40) DEFAULT NULL,
  `os` varchar(40) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `currency` varchar(40) DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `trx` varchar(40) DEFAULT NULL,
  `final_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `after_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `withdraw_information` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel,  ',
  `admin_feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(40) DEFAULT NULL,
  `min_limit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `max_limit` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `percent_charge` decimal(5,2) DEFAULT NULL,
  `currency` varchar(40) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_job_logs`
--
ALTER TABLE `cron_job_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_schedules`
--
ALTER TABLE `cron_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installments`
--
ALTER TABLE `installments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invests`
--
ALTER TABLE `invests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profits`
--
ALTER TABLE `profits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_galleries`
--
ALTER TABLE `property_galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_settings`
--
ALTER TABLE `time_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `update_logs`
--
ALTER TABLE `update_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cron_job_logs`
--
ALTER TABLE `cron_job_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_schedules`
--
ALTER TABLE `cron_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `installments`
--
ALTER TABLE `installments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invests`
--
ALTER TABLE `invests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `profits`
--
ALTER TABLE `profits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_galleries`
--
ALTER TABLE `property_galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_settings`
--
ALTER TABLE `time_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `update_logs`
--
ALTER TABLE `update_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


ALTER TABLE `users` ADD `avatar` TEXT NULL DEFAULT NULL AFTER `login_by`;
