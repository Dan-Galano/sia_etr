-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 06:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psunifydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendanceId` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `totalAttendance` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `organization_id`, `user_id`, `message`, `created_at`, `updated_at`) VALUES
(38, 26, 33, 'Calling all IT students! Suggest activities for College of Computing Week: Sports, E-sports, games!', '2024-12-17 06:53:00', '2024-12-17 06:53:00'),
(40, 26, 41, 'Sounds fun po! How about MLBB, trivia, basketball, coding duels. Excited na HAHAHA', '2024-12-17 06:55:14', '2024-12-17 06:55:14'),
(43, 26, 40, 'League of Legends or Valorant po!', '2024-12-17 07:05:21', '2024-12-17 07:05:21'),
(44, 30, 34, 'hello po', '2024-12-18 08:54:50', '2024-12-18 08:54:50'),
(45, 30, 43, 'hello', '2024-12-18 08:55:01', '2024-12-18 08:55:01');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(27, 104, 40, 'papasa ako! :)))', '2024-12-17 07:34:43', '2024-12-17 07:34:43'),
(28, 123, 34, 'hello', '2024-12-18 08:56:36', '2024-12-18 08:56:36');

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_students`
--

CREATE TABLE `enrolled_students` (
  `studentid` varchar(255) NOT NULL,
  `firrstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolled_students`
--

INSERT INTO `enrolled_students` (`studentid`, `firrstname`, `middlename`, `lastname`) VALUES
('22-UR-0001', 'John', 'Michael', 'Doe'),
('22-UR-0002', 'Jane', 'Elizabeth', 'Smith'),
('22-UR-0003', 'Mark', NULL, 'Johnson'),
('22-UR-0004', 'Emily', 'Grace', 'Williams'),
('22-UR-0005', 'Michael', NULL, 'Brown');

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_05_14_123101_create_school_organizations_table', 1),
(6, '2024_05_14_123120_create_organization_members_table', 1),
(7, '2024_05_14_123134_create_posts_table', 1),
(8, '2024_05_14_123246_create_photo_posts_table', 1),
(9, '2024_05_14_123301_create_comments_table', 1),
(10, '2024_05_14_123309_create_reactions_table', 1),
(11, '2024_05_14_124129_create_chats_table', 1),
(12, '2024_06_04_044008_create_reports_table', 2),
(13, '2024_06_04_044641_create_reports_table', 3),
(19, '2024_12_13_154754_add_with_tag_to_posts_table', 4),
(20, '2024_12_16_032710_create_officer_table', 4),
(21, '2024_12_15_002036_update_payment_status_in_organization_members_table', 5),
(22, '2024_12_16_031331_create_org_required_docs_table', 6),
(23, '2024_12_14_005943_create_attendance_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--

CREATE TABLE `officers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_organization_id` bigint(20) UNSIGNED NOT NULL,
  `officer_first_name` varchar(255) NOT NULL,
  `officer_last_name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `officer_contact` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `officers`
--

INSERT INTO `officers` (`id`, `from_organization_id`, `officer_first_name`, `officer_last_name`, `position`, `officer_contact`, `created_at`, `updated_at`) VALUES
(5, 27, 'John', 'Cruz', 'Governor', '09123456789', '2024-12-18 07:59:30', '2024-12-18 07:59:30'),
(6, 27, 'Dani', 'Go', 'Vice Governor', '09256558745', '2024-12-18 08:00:09', '2024-12-18 08:00:09'),
(7, 27, 'Leila', 'Lee', 'Secretary', '09556300214', '2024-12-18 08:00:33', '2024-12-18 08:00:33'),
(9, 26, 'Lance Jericho', 'Salcedo', 'Governor', '09123456789', '2024-12-18 08:40:22', '2024-12-18 08:40:22'),
(10, 30, 'John', 'Cruz', 'Governor', '09123456789', '2024-12-18 08:52:33', '2024-12-18 08:52:33');

-- --------------------------------------------------------

--
-- Table structure for table `organization_members`
--

CREATE TABLE `organization_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `payment_status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organization_members`
--

INSERT INTO `organization_members` (`id`, `organization_id`, `member_id`, `is_admin`, `status`, `payment_status`, `created_at`, `updated_at`) VALUES
(37, 26, 40, 0, 'approved', 'Half-year', '2024-12-17 06:44:44', '2024-12-17 06:44:44'),
(38, 26, 41, 0, 'approved', 'Full-year', '2024-12-17 06:49:21', '2024-12-17 06:49:21'),
(39, 27, 34, 0, 'approved', 'Full-year', '2024-12-18 08:01:36', '2024-12-18 08:01:36'),
(42, 30, 34, 0, 'approved', NULL, '2024-12-18 08:54:29', '2024-12-18 08:54:29'),
(43, 30, 38, 0, 'approved', NULL, '2024-12-19 03:58:45', '2024-12-19 03:58:45');

-- --------------------------------------------------------

--
-- Table structure for table `org_required_docs`
--

CREATE TABLE `org_required_docs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_org_id` bigint(20) UNSIGNED NOT NULL,
  `doc_filename` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `org_required_docs`
--

INSERT INTO `org_required_docs` (`id`, `school_org_id`, `doc_filename`, `created_at`, `updated_at`) VALUES
(9, 26, '1734414372_676110241abcd.pdf', '2024-12-17 05:46:12', '2024-12-17 05:46:12'),
(10, 26, '1734414372_67611024804d3.pdf', '2024-12-17 05:46:12', '2024-12-17 05:46:12'),
(11, 27, '1734415637_676115153a50e.pdf', '2024-12-17 06:07:17', '2024-12-17 06:07:17'),
(12, 27, '1734415637_676115153dda1.pdf', '2024-12-17 06:07:17', '2024-12-17 06:07:17'),
(13, 28, '1734415862_676115f6005e2.pdf', '2024-12-17 06:11:02', '2024-12-17 06:11:02'),
(14, 29, '1734416292_676117a485aa4.pdf', '2024-12-17 06:18:12', '2024-12-17 06:18:12'),
(15, 30, '1734423085_6761322d63623_1734415856_676115f0e40d5.pdf', '2024-12-17 08:11:25', '2024-12-17 08:11:25'),
(16, 31, '1734511740_67628c7c91a27_1734415856_676115f0e40d5.pdf', '2024-12-18 08:49:00', '2024-12-18 08:49:00'),
(17, 32, '1734511779_67628ca3b8fd3_1734415856_676115f0e40d5.pdf', '2024-12-18 08:49:39', '2024-12-18 08:49:39'),
(18, 32, '1734511779_67628ca3bab10_1734415856_676115f0e71d5.pdf', '2024-12-18 08:49:39', '2024-12-18 08:49:39');

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
-- Table structure for table `photo_posts`
--

CREATE TABLE `photo_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `photo_filename` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `photo_posts`
--

INSERT INTO `photo_posts` (`id`, `post_id`, `photo_filename`, `created_at`, `updated_at`) VALUES
(118, 104, '1734414499_676110a3ad01a_intel_endterm_pubmat.jpg', '2024-12-17 05:48:19', '2024-12-17 05:48:19'),
(119, 105, '1734414560_676110e0ba668_intel_gen_assembly.jpg', '2024-12-17 05:49:20', '2024-12-17 05:49:20'),
(120, 106, '1734415737_676115796bf0e_uapsa_post_pic2.jpg', '2024-12-17 06:08:57', '2024-12-17 06:08:57'),
(121, 106, '1734415737_676115796cf2d_uapsa_post_01.jpg', '2024-12-17 06:08:57', '2024-12-17 06:08:57'),
(122, 107, '1734415989_6761167599add_technoscope_post_01_pic_01.jpg', '2024-12-17 06:13:09', '2024-12-17 06:13:09'),
(123, 108, '1734416015_6761168f81082_technoscope_breaking_news.jpg', '2024-12-17 06:13:35', '2024-12-17 06:13:35'),
(124, 109, '1734416507_6761187b93594_gma2_04.jpg', '2024-12-17 06:21:47', '2024-12-17 06:21:47'),
(125, 109, '1734416507_6761187b95a78_gma2_03.jpg', '2024-12-17 06:21:47', '2024-12-17 06:21:47'),
(126, 109, '1734416507_6761187b96a2e_gma2_02.jpg', '2024-12-17 06:21:47', '2024-12-17 06:21:47'),
(127, 109, '1734416507_6761187b985e2_gma2_01.jpg', '2024-12-17 06:21:47', '2024-12-17 06:21:47'),
(128, 110, '1734416544_676118a06dbe5_gma_post_01_pic_02.jpg', '2024-12-17 06:22:24', '2024-12-17 06:22:24'),
(129, 110, '1734416544_676118a06eacd_gma_post_01_pic_01.jpg', '2024-12-17 06:22:24', '2024-12-17 06:22:24'),
(131, 111, '1734424066_1734416867_676119e306d36_uapsa_post.jpg', '2024-12-17 08:27:46', '2024-12-17 08:27:46'),
(137, 120, '1734509976_site-logo.jpg', '2024-12-18 08:19:36', '2024-12-18 08:19:36'),
(138, 120, '1734509976_sample_img.jpeg', '2024-12-18 08:19:36', '2024-12-18 08:19:36'),
(140, 123, '1734512179_1734416867_676119e306d36_uapsa_post.jpg', '2024-12-18 08:56:19', '2024-12-18 08:56:19'),
(141, 123, '1734512179_site-logo.jpg', '2024-12-18 08:56:19', '2024-12-18 08:56:19'),
(142, 123, '1734512179_defaultpfp.png', '2024-12-18 08:56:19', '2024-12-18 08:56:19');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('text','withphoto','event','eventwithphoto') NOT NULL,
  `privacy` enum('Public','Private') NOT NULL DEFAULT 'Private',
  `content` text DEFAULT NULL,
  `event_title` varchar(255) DEFAULT NULL,
  `event_start_time` datetime DEFAULT NULL,
  `event_end_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `withTag` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `organization_id`, `user_id`, `type`, `privacy`, `content`, `event_title`, `event_start_time`, `event_end_time`, `created_at`, `updated_at`, `withTag`) VALUES
(104, 26, 33, 'withphoto', 'Public', 'Finals Week or My Final Week?! Oh, paano? Nakareview ka na ba o chill-chill pa rin? Tama na muna ang TikTok scroll at online games, kinakamusta ka na ng gabundok mong reviewers! 💻📚\r\nLet’s gear up, IT Barkadas, and handle this Finals Week like pros! Share your study tips, motivational quotes, or kahit memes para chill pa rin kahit ngarag na.\r\nP.S. Coffee and your study chair might be your new BFFs, pero huwag kalilimutan mag-hydrate and take breaks. ☕ Kaya natin \'to, let’s finish strong mga ka-IT! 💪', NULL, NULL, NULL, '2024-12-17 05:48:19', '2024-12-17 05:48:19', NULL),
(105, 26, 33, 'withphoto', 'Public', '𝗣𝗦𝗨 𝗨𝗿𝗱𝗮𝗻𝗲𝘁𝗮 𝗜𝗡𝗧𝗘𝗟: 𝗨𝗻𝗶𝘁𝗲𝗱 𝗪𝗲 𝗦𝘁𝗮𝗻𝗱\r\nGear up for the General Assembly 2024! This is the perfect opportunity for all PSU Urdaneta INTEL members to connect and prepare for another exciting year of innovation and collaboration. Together, let’s set the tone for success and progress. 💡\r\n𝗗𝗮𝘁𝗲: 𝗡𝗼𝘃𝗲𝗺𝗯𝗲𝗿 𝟯𝟬, 𝟮𝟬𝟮𝟰\r\n𝗧𝗶𝗺𝗲: 𝟵:𝟬𝟬 𝗔𝗠\r\n𝗩𝗲𝗻𝘂𝗲: 𝗣𝗦𝗨 𝗨𝗿𝗱𝗮𝗻𝗲𝘁𝗮 𝗜𝗡𝗧𝗘𝗟 𝗗𝗶𝘀𝗰𝗼𝗿𝗱 𝗦𝗲𝗿𝘃𝗲𝗿\r\nLet’s come together to discuss new opportunities, share updates, and strengthen the bonds of our growing community.', NULL, NULL, NULL, '2024-12-17 05:49:20', '2024-12-17 05:49:20', NULL),
(106, 27, 35, 'withphoto', 'Public', '𝑮𝒆𝒕 𝒓𝒆𝒂𝒅𝒚 𝒕𝒐 𝒓𝒂𝒄𝒆 🏁✨\r\nVerdant Voyage: WAD-a-Quest is here to put your skills to the ultimate test! From blueprint brain-busters to green team challenges, it’s time to think fast, laugh harder, and conquer the Verdant Vistas one clue at a time! 🧭💪 Who will claim the trophy in this epic quest through lush landscapes? \r\nLet the adventure begin!\r\nCaption by:\r\nMs. Nipritini E. Quiaoit | Chapter Secretary \r\nMx. Jayson R. Francisco | Chief-of-Staff — Chapter Secretary\r\nGraphic design by:\r\nMs. Angela Dacanay | Graphic Media Staff\r\n#WAD2024\r\n#EmpoweringTheYouth\r\n#CulminateUAPSA \r\n#OneStrongUAPSA\r\n#VerdantVistas\r\n#VerdantVoyagee', NULL, NULL, NULL, '2024-12-17 06:08:57', '2024-12-17 08:28:45', NULL),
(107, 28, 36, 'withphoto', 'Public', '𝗣𝗮𝗽𝗮𝘀𝗮 𝗸𝗮 𝗮𝘁 𝗸𝗮𝗸𝗮𝗶𝗻 𝗻𝗴 𝘀𝗮𝗹𝗮𝗱 𝘄𝗶𝘁𝗵 𝗽𝗲𝗮𝗰𝗲 𝗼𝗳 𝗺𝗶𝗻𝗱.\r\nGood luck and God bless on your final exams, PSUnians! \r\n#TheTechnoscopePublications', NULL, NULL, NULL, '2024-12-17 06:13:09', '2024-12-17 06:13:09', NULL),
(108, 28, 36, 'withphoto', 'Public', '𝗕𝗥𝗘𝗔𝗞𝗜𝗡𝗚 𝗡𝗘𝗪𝗦 | 𝗣𝗦𝗨-𝗨𝗖𝗖 𝗽𝗿𝗼𝗱𝘂𝗰𝗲𝘀 𝟮𝟲 𝗻𝗲𝘄𝗹𝘆 𝗟𝗶𝗰𝗲𝗻𝘀𝗲𝗱 𝗣𝗿𝗼𝗳𝗲𝘀𝘀𝗶𝗼𝗻𝗮𝗹 𝗧𝗲𝗮𝗰𝗵𝗲𝗿𝘀, 𝗮𝗰𝗵𝗶𝗲𝘃𝗲𝘀 𝟭𝟬𝟬%, 𝟳𝟲.𝟲𝟳% 𝗽𝗮𝘀𝘀𝗶𝗻𝗴 𝗿𝗮𝘁𝗲𝘀\r\nTwenty-six (26) graduates from Pangasinan State University-Urdaneta City Campus passed the Licensure Examination for Teachers (LET), as announced by the Professional Regulation Commission (PRC) today.\r\nAll three first time examinees from Bachelor of Early Childhood Education passed, resulting to 100% passing rate.\r\nMeanwhile, 23 out of 30 secondary level examinees passed, attaining a 76.67% passing rate for the university. Twenty two (22) of the passers were first-time takers, with an 88% passing rate, while one retaker passed, resulting in a 20% passing rate for retakers.\r\nAccording to PRC, 20,025 out of 44,002 examinees in elementary level (45.51%) and 48,875 out of 85,926 examinees in secondary level (56.88%)  passed the Licensure Examination for Teachers.\r\nThe Licensure Exam for Teachers was conducted on September 29, 2024, at various testing centers nationwide.\r\nvia Don James Plaza\r\n#TheTechnoscopePublications', NULL, NULL, NULL, '2024-12-17 06:13:35', '2024-12-17 06:13:35', NULL),
(109, 29, 37, 'withphoto', 'Public', '𝐌𝐞𝐦𝐛𝐞𝐫𝐬𝐡𝐢𝐩 𝐀𝐩𝐩𝐥𝐢𝐜𝐚𝐭𝐢𝐨𝐧 𝐟𝐨𝐫 𝐏𝐒𝐔 - 𝐔𝐂 𝐆𝐮𝐢𝐥𝐝 𝐨𝐟 𝐌𝐮𝐥𝐭𝐢𝐦𝐞𝐝𝐢𝐚 𝐀𝐫𝐭𝐢𝐬𝐭 𝐢𝐬 𝐧𝐨𝐰 𝐎𝐏𝐄𝐍! (𝐎𝐧 𝐬𝐢𝐭𝐞 𝐚𝐧𝐝 𝐎𝐧𝐥𝐢𝐧𝐞 𝐑𝐞𝐠𝐢𝐬𝐭𝐫𝐚𝐭𝐢𝐨𝐧)\r\nFor on-site application, visit our booth at PSU Main Building ground floor. \r\nFor online application, you can either scan the QR code or click the provided link to access the membership form https://forms.gle/acX42DaxV4hTqMkCA\r\nImportant reminders:\r\n1. For PSU-Urdaneta Campus students ONLY. \r\n2. Before filling, prepare first your ID photo, COR, Copy of Schedule, and Portfolio.\r\nPORTFOLIO REQUIREMENTS:\r\nCompile your portfolio in \"PDF\" form and for videos, send it to: psuucgma2324@gmail.com (subject: your complete name) \r\nImportant note:\r\nThe data or information you provide will be treated with utmost respect and confidentiality. The PSU-UC GMA follows general principles and rules of data privacy protection in the Philippines. \r\nApply now!\r\nLayout by: Dessamine Almuete', NULL, NULL, NULL, '2024-12-17 06:21:47', '2024-12-17 06:21:47', NULL),
(110, 29, 37, 'withphoto', 'Public', '𝐋𝐀𝐒𝐓 𝐂𝐀𝐋𝐋 𝐎𝐅 𝐓𝐇𝐄 𝐃𝐀𝐘!\r\n𝐌𝐞𝐦𝐛𝐞𝐫𝐬𝐡𝐢𝐩 𝐀𝐩𝐩𝐥𝐢𝐜𝐚𝐭𝐢𝐨𝐧 𝐟𝐨𝐫 𝐏𝐒𝐔 - 𝐔𝐂 𝐆𝐮𝐢𝐥𝐝 𝐨𝐟 𝐌𝐮𝐥𝐭𝐢𝐦𝐞𝐝𝐢𝐚 𝐀𝐫𝐭𝐢𝐬𝐭 𝐢𝐬 𝐧𝐨𝐰 𝐎𝐏𝐄𝐍! (𝐎𝐧 𝐬𝐢𝐭𝐞 𝐚𝐧𝐝 𝐎𝐧𝐥𝐢𝐧𝐞 𝐑𝐞𝐠𝐢𝐬𝐭𝐫𝐚𝐭𝐢𝐨𝐧)\r\nFor on-site application, visit our booth at PSU Main Building ground floor. \r\nFor online application, you can either scan the QR code or click the provided link to access the membership form https://forms.gle/acX42DaxV4hTqMkCA\r\nImportant reminders:\r\n1. For PSU-Urdaneta Campus students ONLY. \r\n2. Before filling, prepare first your ID photo, COR, Copy of Schedule, and Portfolio.\r\nPORTFOLIO REQUIREMENTS:\r\nCompile your portfolio in \"PDF\" form and for videos, send it to: psuucgma2324@gmail.com (subject: your complete name) \r\nImportant note:\r\nThe data or information you provide will be treated with utmost respect and confidentiality. The PSU-UC GMA follows general principles and rules of data privacy protection in the Philippines. \r\nApply now!\r\nLayout by: Dessamine Almuete', NULL, NULL, NULL, '2024-12-17 06:22:24', '2024-12-17 06:22:24', NULL),
(111, 27, 35, 'withphoto', 'Public', '𝓖𝓮𝓪𝓻 𝓤𝓹 𝓯𝓸𝓻 𝓥𝓮𝓻𝓭𝓪𝓷𝓽 𝓥𝓲𝓼𝓽𝓪𝓼 – 𝓓𝓪𝔂 1 & 𝓓𝓪𝔂 2! 🌿🌞\r\n🌿 Gear up for Verdant Vistas!!!! 🌟\r\nYour 2-day survival kit for inspiration, creativity, and a little chaos:\r\n☔ Umbrella – Shield big ideas (or the sun!).\r\n🍫 Snacks – Fuel genius moments.\r\n💧 Drinks – Hydrate for unstoppable energy.\r\n🌬️ E-Fan – Stay cool under pressure.\r\n👕 Extra Shirt – For brilliance-induced sweat.\r\n🧻 Handkerchief – Wipe away sweat, tears, or crumbs.\r\n\r\nLet’s make the world bloom, future architects! 🌱✨\r\n📣 Caption: Ms. Nipritini E. Quiaoit | Mx. Jayson R. Francisco\r\n🎨 Design: Ms. Shiela Gala', NULL, NULL, NULL, '2024-12-17 06:27:47', '2024-12-17 08:27:46', NULL),
(115, 27, 35, 'event', 'Private', 'Hello po', 'Hello', '2024-12-18 15:57:00', '2024-12-18 15:57:00', '2024-12-18 07:57:16', '2024-12-18 07:57:16', NULL),
(118, 26, 33, 'text', 'Private', 'hello', NULL, NULL, NULL, '2024-12-18 08:16:09', '2024-12-18 08:16:09', NULL),
(119, 26, 33, 'text', 'Public', 'hello public', NULL, NULL, NULL, '2024-12-18 08:16:21', '2024-12-18 08:16:21', NULL),
(120, 26, 33, 'withphoto', 'Public', 'hello with photo edited', NULL, NULL, NULL, '2024-12-18 08:17:21', '2024-12-18 08:19:36', NULL),
(121, 30, 43, 'text', 'Private', 'this is private', NULL, NULL, NULL, '2024-12-18 08:53:42', '2024-12-18 08:53:42', NULL),
(122, 30, 43, 'text', 'Public', 'this is public', NULL, NULL, NULL, '2024-12-18 08:53:50', '2024-12-18 08:53:50', NULL),
(123, 30, 43, 'withphoto', 'Public', 'this is a post with photo edited', NULL, NULL, NULL, '2024-12-18 08:55:51', '2024-12-18 08:56:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reaction_type` varchar(255) NOT NULL DEFAULT 'like',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`id`, `post_id`, `user_id`, `reaction_type`, `created_at`, `updated_at`) VALUES
(41, 122, 34, 'like', '2024-12-18 08:55:15', '2024-12-18 08:55:15'),
(42, 122, 43, 'like', '2024-12-18 08:55:30', '2024-12-18 08:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_organization_id` bigint(20) UNSIGNED NOT NULL,
  `reported_user_id` bigint(20) UNSIGNED NOT NULL,
  `reporter_id` bigint(20) UNSIGNED NOT NULL,
  `reasons` varchar(255) NOT NULL,
  `other` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `from_organization_id`, `reported_user_id`, `reporter_id`, `reasons`, `other`, `created_at`, `updated_at`) VALUES
(6, 30, 42, 38, 'Pretending to be someone, Posting inappropriate things', 'Not okay', '2024-12-19 03:59:40', '2024-12-19 03:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `school_organizations`
--

CREATE TABLE `school_organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `orgname` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `mission` text NOT NULL,
  `vision` text NOT NULL,
  `contact` text DEFAULT NULL,
  `facebook` text DEFAULT NULL,
  `instagram` text DEFAULT NULL,
  `twitter` text DEFAULT NULL,
  `tiktok` text DEFAULT NULL,
  `youtube` text DEFAULT NULL,
  `coverphoto` varchar(255) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_organizations`
--

INSERT INTO `school_organizations` (`id`, `status`, `orgname`, `course`, `bio`, `mission`, `vision`, `contact`, `facebook`, `instagram`, `twitter`, `tiktok`, `youtube`, `coverphoto`, `admin_id`, `created_at`, `updated_at`) VALUES
(26, 'approved', 'PSU Urdaneta INTEL', 'Bachelor of Science in Information Technology', 'The official PSUnify page of the Information Technology Student Organization (ITSO) of PSU Urdaneta.', 'The Information Technology Student Organization (ITSO) of PSU Urdaneta commits to fostering a dynamic, inclusive, and innovative community that empowers IT students to excel academically, professionally, and socially. We aim to provide opportunities for skill development, collaboration, and engagement with the latest technological trends, ensuring our members are well-prepared to address real-world challenges and contribute meaningfully to society and the IT industry.', 'To be a leading student organization recognized for cultivating globally competitive IT professionals, driving technological innovation, and promoting a culture of excellence, leadership, and community engagement within PSU Urdaneta and beyond.', '09123456789', 'https://www.facebook.com/psuurdanetaintel', 'https://www.instagram.com/psuurdanetaintel', 'null', 'null', 'https://www.youtube.com/psuurdanetaintel', '1734414371_676110235489c.jpg', 33, '2024-12-17 05:46:12', '2024-12-17 08:08:14'),
(27, 'approved', 'PSU Urdaneta UAPSA', 'Bachelor of Arts in Architecture', 'UAPSA - PSU Urdaneta Chapter is the official student auxiliary of the United Architects of the Philippines. Serving as the voice of architecture students, UAPSA empowers its members through educational initiatives, collaborative projects, and hands-on activities that bridge theory and practice. We aim to produce skilled, ethical, and innovative future architects who can shape a sustainable and inclusive built environment.', 'UAPSA - PSU Urdaneta Chapter is committed to supporting architecture students in their academic and professional journey. By fostering an environment of mentorship, collaboration, and creativity, we provide opportunities for growth through workshops, competitions, community projects, and industry linkages.', 'To cultivate future-ready architects who are equipped with the knowledge, creativity, and leadership skills to contribute meaningfully to the local and global built environment.', '09123456789', 'https://www.facebook.com/UapsaPSU.urd', 'https://www.instagram.com/UapsaPSU.urd', 'null', 'https://www.tiktok.com/UapsaPSU.urd', 'null', '1734415637_676115150852f.jpg', 35, '2024-12-17 06:07:17', '2024-12-17 08:08:01'),
(28, 'approved', 'The Technoscope', 'No Specific Program (Open to All)', 'Technoscope is the official student publication of Pangasinan State University - Urdaneta City Campus', 'The Technoscope is dedicated to delivering timely, relevant, and impactful stories that inform, inspire, and engage the student body. Through responsible journalism, creative writing, and multimedia storytelling, we aim to foster a culture of transparency, critical thinking, and campus unity.', 'To be the voice of truth, creativity, and progress, inspiring the PSU Urdaneta community through responsible journalism, storytelling, and thought-provoking publications.', '09123456789', 'https://www.facebook.com/technoscopeurda', 'null', 'null', 'null', 'null', '1734415861_676115f5c1cd9.jpg', 36, '2024-12-17 06:11:01', '2024-12-17 08:08:23'),
(29, 'approved', 'Guild of Multimedia Artists', 'No Specific Program (Open to All)', 'The Guild of Multimedia Artists (GMA) is the home for student creatives at PSU Urdaneta. Focused on digital design, animation, videography, and visual arts, GMA serves as a platform for students to showcase their talents, collaborate on projects, and build a portfolio of creative work. We aim to elevate the artistry and digital literacy of the campus community while encouraging innovative multimedia solutions for real-world challenges.', 'The Guild of Multimedia Artists is dedicated to nurturing the creativity and technical skills of multimedia enthusiasts by providing a platform for learning, expression, and collaboration. Through workshops, events, and real-world projects, GOMA empowers its members to excel in digital arts, visual storytelling, and design.', 'To be the leading creative hub in PSU Urdaneta, fostering innovation and excellence in multimedia arts through collaboration, skills development, and real-world application.', '09123456789', 'https://www.facebook.com/psuucgma', 'null', 'null', 'null', 'null', '1734416292_676117a4501fd.jpg', 37, '2024-12-17 06:18:12', '2024-12-17 08:08:31'),
(30, 'approved', 'VISUAL ARTS CLUB', 'Bachelor of Science in Architecture', 'arts bio', 'arts mission', 'arts vision', '09123456789', 'fb.com/visual', 'null', 'null', 'null', 'null', '1734423085_6761322d27136.png', 43, '2024-12-17 08:11:25', '2024-12-18 08:51:17'),
(31, 'approved', 'PSU Urdaneta LEMS', 'Bachelor of Arts in English Language', 'Lems bio', 'mission lems', 'vision lems', '09123456789', 'https://facebook.com/lems', 'null', 'null', 'null', 'null', '1734511738_67628c7a5d768.jpg', 44, '2024-12-18 08:49:00', '2024-12-19 04:21:37'),
(32, 'pending', 'PSU Urdaneta LEMSS', 'Bachelor of Arts in English Language', 'Lems bio', 'mission lems', 'vision lems', '09123456789', 'https://facebook.com/lems', 'null', 'null', 'null', 'null', '1734511778_67628ca2b64e8.jpg', 45, '2024-12-18 08:49:39', '2024-12-18 08:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('member','organizer','admin') NOT NULL DEFAULT 'member',
  `studentid` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `type`, `studentid`, `firstname`, `middlename`, `lastname`, `email`, `photo`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(33, 'organizer', NULL, 'PSU Urdaneta INTEL', NULL, NULL, 'intel@gmail.com', '1734414371_676110235489c.jpg', NULL, '$2y$12$qgsI/fJUdd/so92imd4A9OfkdeXqV.NCw7oRfoMnjfrU3l05BmDMS', NULL, '2024-12-17 05:46:12', '2024-12-17 05:46:12'),
(34, 'member', '21-UR-0219', 'Lance Jericho', 'Reynaldo', 'Salcedo', 'jau@gmail.com', '676111cddd355.jpg', NULL, '$2y$12$fqKSfT6yx6rgZSI7pJYfNuOgJCcwQcVvNH1xklv0V3WL/cV/mIelW', NULL, '2024-12-17 05:53:18', '2024-12-17 05:53:18'),
(35, 'organizer', NULL, 'PSU Urdaneta UAPSA', NULL, NULL, 'uapsa@gmail.com', '1734415637_676115150852f.jpg', NULL, '$2y$12$cOC7SCL.gvYlGKAlrbqmBOPSwtJmFSeefXezCR/Udd8wjTUXHvgb2', NULL, '2024-12-17 06:07:17', '2024-12-17 06:07:17'),
(36, 'organizer', NULL, 'The Technoscope', NULL, NULL, 'technoscope@gmail.com', '1734415861_676115f5c1cd9.jpg', NULL, '$2y$12$dJFGyClP8qk/kqpCpKdfCe.fdXxy9MG2BNr6hQNhlqz.Iwe/VjPUi', NULL, '2024-12-17 06:11:01', '2024-12-17 06:11:01'),
(37, 'organizer', NULL, 'Guild of Multimedia Artists', NULL, NULL, 'gma@gmail.com', '1734416292_676117a4501fd.jpg', NULL, '$2y$12$zUj7ymNxSr9gmRdV1KJwde2bEpBgoJ9ryXL9fUXpowhj0XvV27M3K', NULL, '2024-12-17 06:18:12', '2024-12-17 06:18:12'),
(38, 'member', '21-UR-0002', 'Patricia Mae', 'Dela Pena', 'Puaso', 'puaso@gmail.com', '67611c89a4330.jpg', NULL, '$2y$12$tPCDKseMpDqqybN1Xi1g3uGwrSITsnAxix22lcj6/Vje2/1H0oRBe', NULL, '2024-12-17 06:39:05', '2024-12-17 06:39:05'),
(40, 'member', '21-UR-0183', 'Cedric Joel', 'Fernandez', 'Cayaban', 'ced@gmail.com', '67611dd265f9a.jpg', NULL, '$2y$12$yPp6wdamfZ2KPegQ8vodlOIjSN54zPmMzCML4Iu9KJKO.MNQYoxHC', NULL, '2024-12-17 06:44:34', '2024-12-17 06:44:34'),
(41, 'member', '21-UR-0217', 'Elijah Japheth', 'Pacariem', 'Macatiag', 'ej@gmail.com', '67611ebc201b9.jpg', NULL, '$2y$12$cS3xqG1hx8K8VW3SmzQOO.6VPDIg9SEEDsnTbQI9zAaDKV3NtpGz.', NULL, '2024-12-17 06:48:28', '2024-12-17 06:48:28'),
(42, 'admin', NULL, 'admin', NULL, NULL, 'admin@gmail.com', '', NULL, '$2y$12$qgsI/fJUdd/so92imd4A9OfkdeXqV.NCw7oRfoMnjfrU3l05BmDMS', NULL, NULL, NULL),
(43, 'organizer', NULL, 'VISUAL ARTS CLUB', NULL, NULL, 'arts@gmail.com', '1734423085_6761322d27136.png', NULL, '$2y$12$nA5BtQsLiaPV.8Lv3Wj9i.siFS4BAYubeGv5oINJZttruF9pthwR6', NULL, '2024-12-17 08:11:25', '2024-12-17 08:11:25'),
(44, 'organizer', NULL, 'PSU Urdaneta LEMS', NULL, NULL, 'lems@gmail.com', '1734511738_67628c7a5d768.jpg', NULL, '$2y$12$Uvw5QdNeq4/L8/4nwJ8PGO3kTq84GElFgroBut/Ya6bi.hWBIZWrm', NULL, '2024-12-18 08:49:00', '2024-12-18 08:49:00'),
(45, 'organizer', NULL, 'PSU Urdaneta LEMSS', NULL, NULL, 'lemss@gmail.com', '1734511778_67628ca2b64e8.jpg', NULL, '$2y$12$XR3Cb11YuMb7NSfsPbbmHObU7DHvaY0JY78UAt0Q.kfd2wM4Lq2mu', NULL, '2024-12-18 08:49:39', '2024-12-18 08:49:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendanceId`),
  ADD KEY `attendance_post_id_foreign` (`post_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_organization_id_foreign` (`organization_id`),
  ADD KEY `chats_user_id_foreign` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_post_id_foreign` (`post_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `enrolled_students`
--
ALTER TABLE `enrolled_students`
  ADD PRIMARY KEY (`studentid`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `officers`
--
ALTER TABLE `officers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `officers_from_organization_id_foreign` (`from_organization_id`);

--
-- Indexes for table `organization_members`
--
ALTER TABLE `organization_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `organization_id` (`organization_id`,`member_id`),
  ADD KEY `organization_members_member_id_foreign` (`member_id`);

--
-- Indexes for table `org_required_docs`
--
ALTER TABLE `org_required_docs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `org_required_docs_school_org_id_foreign` (`school_org_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `photo_posts`
--
ALTER TABLE `photo_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photo_posts_post_id_foreign` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_organization_id_foreign` (`organization_id`),
  ADD KEY `posts_user_id_foreign` (`user_id`),
  ADD KEY `posts_withtag_foreign` (`withTag`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reactions_post_id_foreign` (`post_id`),
  ADD KEY `reactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_reported_user_id_foreign` (`reported_user_id`),
  ADD KEY `reports_reporter_id_foreign` (`reporter_id`),
  ADD KEY `from_organization_id` (`from_organization_id`);

--
-- Indexes for table `school_organizations`
--
ALTER TABLE `school_organizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_organizations_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_studentid_unique` (`studentid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendanceId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `officers`
--
ALTER TABLE `officers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `organization_members`
--
ALTER TABLE `organization_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `org_required_docs`
--
ALTER TABLE `org_required_docs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photo_posts`
--
ALTER TABLE `photo_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `school_organizations`
--
ALTER TABLE `school_organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `school_organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `officers`
--
ALTER TABLE `officers`
  ADD CONSTRAINT `officers_from_organization_id_foreign` FOREIGN KEY (`from_organization_id`) REFERENCES `school_organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `organization_members`
--
ALTER TABLE `organization_members`
  ADD CONSTRAINT `organization_members_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `organization_members_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `school_organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `org_required_docs`
--
ALTER TABLE `org_required_docs`
  ADD CONSTRAINT `org_required_docs_school_org_id_foreign` FOREIGN KEY (`school_org_id`) REFERENCES `school_organizations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `photo_posts`
--
ALTER TABLE `photo_posts`
  ADD CONSTRAINT `photo_posts_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `school_organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_withtag_foreign` FOREIGN KEY (`withTag`) REFERENCES `school_organizations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reactions`
--
ALTER TABLE `reactions`
  ADD CONSTRAINT `reactions_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`from_organization_id`) REFERENCES `school_organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_reported_user_id_foreign` FOREIGN KEY (`reported_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_reporter_id_foreign` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `school_organizations`
--
ALTER TABLE `school_organizations`
  ADD CONSTRAINT `school_organizations_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
