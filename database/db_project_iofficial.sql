-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2017 at 08:06 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_project_iofficial`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `created_date`, `user_id`, `description`, `type`, `status`) VALUES
(25, '2017-03-12 17:32:36', 2, 'Menyukai Posting Della : Bisnis Terus', 2, 1),
(26, '2017-03-12 17:19:21', 3, 'Mengomentari Posting Sunarto : Lagi Tidur', 3, 1),
(28, '2017-03-12 17:32:08', 1, 'Menyukai Posting Katrina Kaif : Liburan Ke Jogja', 3, 1),
(29, '2017-03-12 17:32:11', 2, 'Menyukai Posting Della : Liburan Ke Jogja', 3, 1),
(30, '2017-03-12 17:32:13', 3, 'Menyukai Posting Sunarto : Liburan Ke Jogja', 3, 1),
(31, '2017-03-12 17:32:15', 4, 'Menyukai Posting muhamad abdul rojak : Liburan Ke Jogja', 3, 1),
(32, '2017-03-12 17:32:16', 5, 'Menyukai Posting Firman Maulana : Liburan Ke Jogja', 3, 1),
(33, '2017-03-12 17:32:18', 6, 'Menyukai Posting gates : Liburan Ke Jogja', 3, 1),
(34, '2017-03-12 17:33:16', 6, 'Menyukai Posting gates : Liburan Ke Jogja', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

CREATE TABLE IF NOT EXISTS `api` (
  `id_post` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `url` varchar(125) NOT NULL,
  `views` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `api`
--

INSERT INTO `api` (`id_post`, `created_date`, `title`, `description`, `image`, `status`, `tags`, `keyword`, `url`, `views`, `likes`, `id_user`, `id_category`, `id_tag`) VALUES
(1, '2017-05-20 06:05:58', 'Login', '<p>Asdf<br></p>', 'post.jpg', 0, 'username, email, passwords', 'Cek Data User', 'http://localhost/project_iofficial/index.php/api/create.html', 0, 0, 1, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id_category`, `name`, `icon`, `image`, `url`, `status`) VALUES
(1, 'Multimedia Apps', 'icon-compass', 'prodak.png', 'produk', 1),
(2, 'Mobile Apps', 'icon-compass', 'berita.png', 'siaran', 1),
(3, 'Web Apps', 'icon-compass', 'kegiatan.jpg', 'kegiatan', 1),
(4, 'Design', 'icon-compass', '4.jpg', 'design', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_sub`
--

CREATE TABLE IF NOT EXISTS `category_sub` (
  `id_category_sub` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `image` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_sub`
--

INSERT INTO `category_sub` (`id_category_sub`, `category_id`, `name`, `image`, `url`, `status`) VALUES
(1, 1, 'Aksesoris', '', 'aksesoris', 1),
(2, 1, 'Tas', '', 'tas', 1),
(3, 1, 'Pakaian', '', 'pakaian', 1),
(8, 2, 'Artikel', '', 'artikel', 1),
(9, 2, 'Cerita Pendek', '', 'cerita-pendek', 1),
(10, 2, 'Panduan DIY', '', 'panduan-diy', 1),
(11, 2, 'Sajak dan Puisi', '', 'sajak-dan-puisi', 1),
(12, 2, 'Warta', '', 'warta', 1),
(13, 3, 'Komunitas', '', '', 1),
(14, 3, 'Info Workshop', '', '', 1),
(15, 3, 'Agenda', '15.jpg', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chat_rooms`
--

CREATE TABLE IF NOT EXISTS `chat_rooms` (
  `chat_room_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_rooms`
--

INSERT INTO `chat_rooms` (`chat_room_id`, `name`, `type`, `created_at`) VALUES
(1, '', 1, '2017-03-24 17:44:28'),
(2, '', 1, '2017-03-24 17:44:44'),
(3, '', 1, '2017-03-24 20:45:27'),
(4, '', 1, '2017-03-24 22:17:00'),
(5, '', 1, '2017-03-24 22:17:10'),
(6, '', 1, '2017-03-24 23:37:19'),
(7, '', 1, '2017-03-27 06:51:49'),
(8, '', 1, '2017-04-10 23:29:57');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE IF NOT EXISTS `division` (
  `id_division` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`id_division`, `name`, `description`, `status`) VALUES
(1, 'Divisi Fashion', 'Divisi Fashion', 1),
(2, 'Divisi Furniture', 'Divisi Furniture', 1),
(3, 'Hore', 'Berhasil', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `like_count` int(11) NOT NULL,
  `comment_count` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `created_date`, `user_id`, `image`, `title`, `description`, `like_count`, `comment_count`, `status`) VALUES
(1, '2017-03-23 00:00:00', 1, '1.jpg', 'Arisan Keluarga', 'Jangan lupa ya arisan jilid dua dirumahnya Ibu Hafsah', 1, 1, 1),
(2, '2017-03-23 00:00:00', 1, '2.jpg', 'Syukuran keluarga Pak Burhan', 'Keberhasilan anak kami menjadi top scorer EPL 2017', 23, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_comment`
--

CREATE TABLE IF NOT EXISTS `event_comment` (
  `id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `event_id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `comment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_like`
--

CREATE TABLE IF NOT EXISTS `event_like` (
  `id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member_rooms`
--

CREATE TABLE IF NOT EXISTS `member_rooms` (
  `member_rooms_id` int(11) NOT NULL,
  `chat_room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member_rooms`
--

INSERT INTO `member_rooms` (`member_rooms_id`, `chat_room_id`, `user_id`, `created_at`, `status`) VALUES
(1, 1, 1, '2017-03-25 07:44:28', 1),
(2, 1, 3, '2017-03-25 07:44:28', 1),
(3, 2, 1, '2017-03-25 07:44:44', 1),
(4, 2, 2, '2017-03-25 07:44:44', 1),
(5, 3, 4, '2017-03-25 10:45:27', 1),
(6, 3, 1, '2017-03-25 10:45:27', 1),
(7, 4, 4, '2017-03-25 12:17:00', 1),
(8, 4, 3, '2017-03-25 12:17:00', 1),
(9, 5, 4, '2017-03-25 12:17:10', 1),
(10, 5, 2, '2017-03-25 12:17:10', 1),
(11, 6, 5, '2017-03-25 13:37:19', 1),
(12, 6, 3, '2017-03-25 13:37:19', 1),
(13, 7, 5, '2017-03-27 20:51:49', 1),
(14, 7, 1, '2017-03-27 20:51:49', 1),
(15, 8, 7, '2017-04-11 13:29:57', 1),
(16, 8, 4, '2017-04-11 13:29:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL,
  `chat_room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `file` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `chat_room_id`, `user_id`, `message`, `file`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'assalamualaikum', '', 1, '2017-03-24 17:44:35', '0000-00-00 00:00:00'),
(2, 2, 1, 'assalamualaikum', '', 1, '2017-03-24 17:44:49', '0000-00-00 00:00:00'),
(3, 2, 1, 'aha', '', 1, '2017-03-24 17:52:57', '0000-00-00 00:00:00'),
(4, 2, 1, '***', '', 1, '2017-03-24 18:02:44', '0000-00-00 00:00:00'),
(5, 2, 1, 'hai', '', 1, '2017-03-24 18:03:09', '0000-00-00 00:00:00'),
(6, 2, 1, 'hehehe', '', 1, '2017-03-24 18:03:27', '0000-00-00 00:00:00'),
(7, 2, 1, '***', '', 1, '2017-03-24 18:03:43', '0000-00-00 00:00:00'),
(8, 2, 1, '***', '', 1, '2017-03-24 18:04:27', '0000-00-00 00:00:00'),
(9, 1, 1, 'wss', '', 1, '2017-03-24 18:30:15', '0000-00-00 00:00:00'),
(10, 2, 1, 'siap ki?', '', 1, '2017-03-24 19:40:16', '0000-00-00 00:00:00'),
(11, 2, 2, 'naon atuh ah,nn', '', 1, '2017-03-24 19:41:21', '0000-00-00 00:00:00'),
(12, 2, 2, '??', '', 1, '2017-03-24 19:41:23', '0000-00-00 00:00:00'),
(13, 2, 2, 'shsjdbss', '', 1, '2017-03-24 19:41:27', '0000-00-00 00:00:00'),
(14, 2, 2, 's', '', 1, '2017-03-24 19:41:28', '0000-00-00 00:00:00'),
(15, 2, 1, 'eeeh', '', 1, '2017-03-24 19:41:28', '0000-00-00 00:00:00'),
(16, 2, 2, 'behebd', '', 1, '2017-03-24 19:41:31', '0000-00-00 00:00:00'),
(17, 2, 2, 'behdbdhwhs', '', 1, '2017-03-24 19:41:37', '0000-00-00 00:00:00'),
(18, 2, 2, 'behdbdhwhs', '', 1, '2017-03-24 19:41:37', '0000-00-00 00:00:00'),
(19, 2, 1, 'kutil', '', 1, '2017-03-24 19:41:46', '0000-00-00 00:00:00'),
(20, 3, 4, 'asalamualaikum', '', 1, '2017-03-24 20:45:34', '0000-00-00 00:00:00'),
(21, 5, 4, 'test', '', 1, '2017-03-24 22:18:13', '0000-00-00 00:00:00'),
(22, 3, 4, 'teat', '', 1, '2017-03-24 22:29:36', '0000-00-00 00:00:00'),
(23, 2, 1, 'ki?', '', 1, '2017-03-24 23:20:24', '0000-00-00 00:00:00'),
(24, 3, 1, 'jak?', '', 1, '2017-03-24 23:20:45', '0000-00-00 00:00:00'),
(25, 2, 2, 'yah??', '', 1, '2017-03-24 23:20:53', '0000-00-00 00:00:00'),
(26, 3, 4, 'oy', '', 1, '2017-03-24 23:20:57', '0000-00-00 00:00:00'),
(27, 3, 4, 'ah *** barusan kejedot', '', 1, '2017-03-24 23:21:24', '0000-00-00 00:00:00'),
(28, 2, 2, 'yang??', '', 1, '2017-03-25 04:57:39', '0000-00-00 00:00:00'),
(29, 2, 1, 'kamu *** yah', '', 1, '2017-03-25 04:58:20', '0000-00-00 00:00:00'),
(30, 2, 2, 'ah kamu mah ****', '', 1, '2017-03-25 04:58:49', '0000-00-00 00:00:00'),
(31, 2, 1, 'anjiiiing', '', 1, '2017-03-25 04:59:10', '0000-00-00 00:00:00'),
(32, 2, 2, '\\uD83D\\uDE0D', '', 1, '2017-03-25 04:59:11', '0000-00-00 00:00:00'),
(33, 2, 2, '***', '', 1, '2017-03-25 04:59:27', '0000-00-00 00:00:00'),
(34, 2, 2, 'babbi', '', 1, '2017-03-25 04:59:30', '0000-00-00 00:00:00'),
(35, 2, 1, 'ahbegolu', '', 1, '2017-03-25 04:59:36', '0000-00-00 00:00:00'),
(36, 2, 2, 'anjinglu', '', 1, '2017-03-25 04:59:50', '0000-00-00 00:00:00'),
(37, 2, 1, 'parah', '', 1, '2017-03-25 04:59:59', '0000-00-00 00:00:00'),
(38, 2, 1, 'tunggu dulu ya', '', 1, '2017-03-25 05:00:23', '0000-00-00 00:00:00'),
(39, 2, 2, 'it', '', 1, '2017-03-25 05:00:24', '0000-00-00 00:00:00'),
(40, 2, 2, 'apa yg ditunggu??', '', 1, '2017-03-25 05:00:44', '0000-00-00 00:00:00'),
(41, 2, 1, 'ditunggu dipelaminan?', '', 1, '2017-03-25 05:00:58', '0000-00-00 00:00:00'),
(42, 2, 2, 'siapa??', '', 1, '2017-03-25 05:01:06', '0000-00-00 00:00:00'),
(43, 2, 1, '\\uD83D\\uDE02', '', 1, '2017-03-25 05:01:10', '0000-00-00 00:00:00'),
(44, 2, 2, 'yg nanya...', '', 1, '2017-03-25 05:01:13', '0000-00-00 00:00:00'),
(45, 2, 1, '\\uD83D\\uDE24', '', 1, '2017-03-25 05:01:25', '0000-00-00 00:00:00'),
(46, 2, 2, '\\uD83D\\uDE1A\\uD83D\\uDE1A', '', 1, '2017-03-25 05:01:30', '0000-00-00 00:00:00'),
(47, 2, 1, '\\uD83D\\uDCBB', '', 1, '2017-03-25 05:01:43', '0000-00-00 00:00:00'),
(48, 2, 2, '\\uD83D\\uDC59', '', 1, '2017-03-25 05:01:51', '0000-00-00 00:00:00'),
(49, 2, 1, '\\u26BD', '', 1, '2017-03-25 05:01:52', '0000-00-00 00:00:00'),
(50, 2, 2, '\\uD83D\\uDC8B', '', 1, '2017-03-25 05:01:57', '0000-00-00 00:00:00'),
(51, 2, 1, '\\uD83C\\uDFC7', '', 1, '2017-03-25 05:02:01', '0000-00-00 00:00:00'),
(52, 2, 1, '\\uD83C\\uDFCA', '', 1, '2017-03-25 05:02:06', '0000-00-00 00:00:00'),
(53, 2, 1, '\\uD83C\\uDFF9', '', 1, '2017-03-25 05:02:10', '0000-00-00 00:00:00'),
(54, 2, 2, '\\uD83D\\uDC3D\\uD83D\\uDC37', '', 1, '2017-03-25 05:02:22', '0000-00-00 00:00:00'),
(55, 2, 2, '\\uD83D\\uDC36', '', 1, '2017-03-25 05:02:26', '0000-00-00 00:00:00'),
(56, 2, 2, '\\uD83D\\uDC17', '', 1, '2017-03-25 05:02:28', '0000-00-00 00:00:00'),
(57, 2, 1, '\\uD83C\\uDFBB', '', 1, '2017-03-25 05:02:32', '0000-00-00 00:00:00'),
(58, 2, 1, '\\uD83C\\uDFB8', '', 1, '2017-03-25 05:02:34', '0000-00-00 00:00:00'),
(59, 2, 1, '\\uD83C\\uDFBA', '', 1, '2017-03-25 05:02:36', '0000-00-00 00:00:00'),
(60, 2, 1, '\\uD83C\\uDFB7', '', 1, '2017-03-25 05:02:39', '0000-00-00 00:00:00'),
(61, 2, 1, '\\uD83C\\uDFB9', '', 1, '2017-03-25 05:02:42', '0000-00-00 00:00:00'),
(62, 2, 1, '\\uD83C\\uDFBC', '', 1, '2017-03-25 05:02:43', '0000-00-00 00:00:00'),
(63, 2, 2, '\\uD83C\\uDFA8', '', 1, '2017-03-25 05:02:47', '0000-00-00 00:00:00'),
(64, 2, 2, '\\uD83C\\uDFA4', '', 1, '2017-03-25 05:02:55', '0000-00-00 00:00:00'),
(65, 2, 2, '\\uD83C\\uDFB1', '', 1, '2017-03-25 05:03:02', '0000-00-00 00:00:00'),
(66, 2, 2, '\\uD83C\\uDFB1', '', 1, '2017-03-25 05:03:08', '0000-00-00 00:00:00'),
(67, 2, 1, '\\uD83D\\uDC76', '', 1, '2017-03-25 05:03:08', '0000-00-00 00:00:00'),
(68, 2, 2, '\\uD83D\\uDE21', '', 1, '2017-03-25 05:03:19', '0000-00-00 00:00:00'),
(69, 2, 2, '\\uD83D\\uDC4C', '', 1, '2017-03-25 05:03:24', '0000-00-00 00:00:00'),
(70, 2, 1, '\\uD83D\\uDE82', '', 1, '2017-03-25 05:05:46', '0000-00-00 00:00:00'),
(71, 2, 1, 'ki, sandi lagi seneng ', '', 1, '2017-03-25 08:23:07', '0000-00-00 00:00:00'),
(72, 2, 2, 'iyah a..', '', 1, '2017-03-25 08:32:03', '0000-00-00 00:00:00'),
(73, 2, 1, 'baru nyampe ki', '', 1, '2017-03-25 11:40:48', '0000-00-00 00:00:00'),
(74, 7, 5, 'fir?', '', 1, '2017-03-27 06:51:54', '0000-00-00 00:00:00'),
(75, 7, 1, 'naon jak?', '', 1, '2017-03-27 06:52:11', '0000-00-00 00:00:00'),
(76, 2, 2, 'a gaduh *** teu??', '', 1, '2017-03-28 05:40:08', '0000-00-00 00:00:00'),
(77, 2, 1, 'naon ki?', '', 1, '2017-03-28 05:40:49', '0000-00-00 00:00:00'),
(78, 2, 2, 'ngetes a hehhee... \\uD83D\\uDE2C', '', 1, '2017-03-28 05:41:50', '0000-00-00 00:00:00'),
(79, 2, 1, 'aah *** lu', '', 1, '2017-03-28 05:44:36', '0000-00-00 00:00:00'),
(80, 2, 1, 'haha', '', 1, '2017-03-28 05:44:58', '0000-00-00 00:00:00'),
(81, 2, 1, 'tes', '', 1, '2017-05-08 01:25:36', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `notification_list`
--

CREATE TABLE IF NOT EXISTS `notification_list` (
  `id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `subject_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification_list`
--

INSERT INTO `notification_list` (`id`, `created_date`, `subject_id`, `type`, `object_id`, `status`, `description`) VALUES
(2, '2017-03-25 08:09:58', 2, 2, 3, 1, ' commented your post: ngomong apa ai kamu bego ??'),
(3, '2017-03-25 08:15:27', 1, 3, 2, 1, 'invite you as Ayah'),
(4, '2017-03-25 13:30:54', 4, 1, 5, 1, ' liked your post'),
(5, '2017-03-25 13:31:00', 4, 2, 5, 1, ' commented your post: keren kak'),
(7, '2017-03-28 11:11:59', 2, 1, 7, 1, ' liked your post'),
(8, '2017-03-28 11:12:48', 2, 2, 7, 1, ' commented your post: pameran naon a??'),
(9, '2017-03-28 19:45:15', 1, 1, 6, 1, ' liked your post'),
(10, '2017-03-28 19:45:57', 1, 2, 7, 1, ' commented your post: pameran furniture eta ki'),
(11, '2017-03-29 14:49:28', 6, 2, 7, 1, ' commented your post: mantap buat future yah a...'),
(12, '2017-04-03 20:40:32', 1, 1, 2, 1, ' liked your post'),
(13, '2017-04-03 20:40:37', 1, 1, 5, 1, ' liked your post');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `like_count` int(11) NOT NULL,
  `comment_count` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `created_date`, `user_id`, `image`, `description`, `like_count`, `comment_count`, `status`) VALUES
(1, '2017-03-25 07:40:14', 2, '', 'ayo semangat.... \\u263A', 0, 0, 0),
(2, '2017-03-25 07:41:07', 1, '21490402469pk0.jpg,21490402470hm1.jpg', 'Persiapan \\u261D', 1, 0, 0),
(3, '2017-03-25 07:42:05', 1, '', '***', 0, 1, 0),
(4, '2017-03-25 07:51:44', 0, '41490403105pk0.jpg', 'pagi', 0, 0, 0),
(5, '2017-03-25 13:29:48', 1, '51490423389pk0.jpg', 'Dev + 2017 \\uD83D\\uDC4D', 2, 1, 0),
(6, '2017-03-25 14:17:34', 1, '61490426266pk0.jpg,61490426271hm1.jpg', 'testing', 1, 0, 0),
(7, '2017-03-27 14:34:30', 1, '71490600073pk0.jpg,71490600075hm1.jpg', 'Pameran 2017 \\uD83D\\uDC4D', 1, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_comment`
--

CREATE TABLE IF NOT EXISTS `post_comment` (
  `id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_comment`
--

INSERT INTO `post_comment` (`id`, `created_date`, `post_id`, `user_id`, `comment`, `status`) VALUES
(1, '2017-03-25 08:09:58', 3, 2, 'ngomong apa ai kamu *** ??', 1),
(2, '2017-03-25 13:31:00', 5, 4, 'keren kak', 1),
(3, '2017-03-28 11:12:48', 7, 2, 'pameran naon a??', 1),
(4, '2017-03-28 19:45:57', 7, 1, 'pameran furniture eta ki', 1),
(5, '2017-03-29 14:49:28', 7, 6, 'mantap buat future yah a...', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_like`
--

CREATE TABLE IF NOT EXISTS `post_like` (
  `id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_like`
--

INSERT INTO `post_like` (`id`, `created_date`, `post_id`, `user_id`) VALUES
(2, '2017-03-25 13:30:54', 5, 4),
(4, '2017-03-28 11:11:59', 7, 2),
(5, '2017-03-28 19:45:15', 6, 1),
(6, '2017-04-03 20:40:32', 2, 1),
(7, '2017-04-03 20:40:37', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `relation`
--

CREATE TABLE IF NOT EXISTS `relation` (
  `id_relation` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id_site` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `keywords` varchar(150) NOT NULL,
  `favicon` varchar(25) NOT NULL,
  `logo` varchar(25) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(25) NOT NULL,
  `email` varchar(150) NOT NULL,
  `facebook` varchar(150) NOT NULL,
  `instagram` varchar(150) NOT NULL,
  `twitter` varchar(150) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id_site`, `name`, `description`, `keywords`, `favicon`, `logo`, `address`, `phone`, `email`, `facebook`, `instagram`, `twitter`, `status`) VALUES
(1, 'IOFFICIAL', 'Sebuah portal digital di Kabupaten Bandung yang dibangun dengan berlandaskan pada 3 aspek utama, yaitu; Lokal, Kreatif, dan Kolektif.', 'lokolektif, lokal, kreatif, kolektif, kabupaten bandung, kabupaten bandung barat, kabupaten bandung timur, kabupaten bandung selatan,', 'lokolektif.JPG', '1.jpg', 'Ciburial Timur RT:06/RW:06 Kec. Soreang Kab. Bandung', '089525692769', 'info@lokolektif.com', 'https://www.facebook.com/lokolektif.kab/', 'https://www.instagram.com/lokolektif.kab', 'https://twitter.com/lokolektif', 1),
(2, 'WEFAY', 'Mengembangkan bisnis melalui ekosistem IT, menghadirkan inovasi solusi yang terintegrasi.', 'wefay, apps, mobile, web', '2.jpg', '2.png', 'Jl. Raya Sorekarno Hatta No.46 Bandung', '087824931504', 'info@wefay.com', 'wefaycorp', 'wefaycorp', 'wefaycorp', 1),
(3, 'BASCOM', 'Barudak Seni Computer (PKN & STMIK LPKIA Bandung)', 'lokolektif, lokal, kreatif, kolektif, kabupaten bandung, kabupaten bandung barat, kabupaten bandung timur, kabupaten bandung selatan,', 'bascom.JPG', '1.jpg', 'Ciburial Timur RT:06/RW:06 Kec. Soreang Kab. Bandung', '089525692769', 'info@lokolektif.com', 'https://www.facebook.com/lokolektif.kab/', 'https://www.instagram.com/lokolektif.kab', 'https://twitter.com/lokolektif', 1),
(4, 'REGAL 036', 'Regal Group Official', 'lokolektif, lokal, kreatif, kolektif, kabupaten bandung, kabupaten bandung barat, kabupaten bandung timur, kabupaten bandung selatan,', 'lokolektif.JPG', '', 'Ciburial Timur RT:06/RW:06 Kec. Soreang Kab. Bandung', '0895256927695', 'info@lokolektif.com', 'https://www.facebook.com/lokolektif.kab/s3', 'https://www.instagram.com/lokolektif.kabs', 'https://twitter.com/lokolektifss', 0),
(5, 'Komunitas Barbara', '', '', '', '', 'Jl. Jakarta No.5 Bandung', '0588859859898', 'barbara@community.com', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `visit_time` datetime DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `gender` varchar(2) DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(11) DEFAULT '3',
  `division` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'profile.png',
  `ipaddress` varchar(25) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT '0',
  `community_id` int(11) NOT NULL,
  `reg_id` varchar(255) NOT NULL,
  `field_one` varchar(255) NOT NULL,
  `field_two` varchar(255) NOT NULL,
  `field_three` varchar(255) NOT NULL,
  `field_four` varchar(255) NOT NULL,
  `field_five` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `create_time`, `update_time`, `visit_time`, `fullname`, `gender`, `birth`, `email`, `username`, `password`, `level`, `division`, `image`, `ipaddress`, `active`, `status`, `community_id`, `reg_id`, `field_one`, `field_two`, `field_three`, `field_four`, `field_five`) VALUES
(1, '2017-05-17 03:19:02', '2017-05-17 03:19:02', '2017-05-20 12:58:35', 'Mugi Rachmat', NULL, '2017-05-17', 'infomugi@gmail.com', 'infomugi', '21232f297a57a5a743894a0e4a801fc3', 1, 0, 'infomugi.jpg', '0', 0, 0, 0, '0', '0', '0', '0', '0', ''),
(2, '2017-05-17 03:19:30', '2017-05-17 03:19:30', '2017-05-20 10:42:12', 'Andi Saputra', NULL, '2017-05-17', 'andi@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 2, 0, 'avatar.png', '0', 1, 0, 0, '0', '0', '0', '0', '0', ''),
(3, '2017-05-17 03:21:13', '2017-05-17 03:21:13', '2017-05-17 03:21:13', 'Sandi Auliya', NULL, '2017-05-17', 'sandi@gmail.com', 'sandi', '21232f297a57a5a743894a0e4a801fc3', 3, 0, 'avatar.png', '0', 0, 0, 0, '0', '0', '0', '0', '0', ''),
(4, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, '0', '0', '0', '0', '0', ''),
(5, '2017-05-17 03:22:16', '2017-05-17 03:22:16', '2017-05-17 08:35:51', 'Wahyu Wiwoho', NULL, '2017-05-17', 'wahyu@gmail.com', 'wahyu', '21232f297a57a5a743894a0e4a801fc3', 3, 0, 'avatar.png', '0', 0, 0, 0, '0', '0', '0', '0', '0', ''),
(6, '2017-05-18 07:22:21', '2017-05-18 07:22:21', '2017-05-18 07:22:21', 'Abudin', NULL, '2017-05-18', 'abudin@gmail.com', 'abudin', '21232f297a57a5a743894a0e4a801fc3', 3, 0, 'avatar.png', '0', 0, 0, 0, '0', '0', '0', '0', '0', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`id_post`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `category_sub`
--
ALTER TABLE `category_sub`
  ADD PRIMARY KEY (`id_category_sub`);

--
-- Indexes for table `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id_division`);

--
-- Indexes for table `relation`
--
ALTER TABLE `relation`
  ADD PRIMARY KEY (`id_relation`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id_site`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api`
--
ALTER TABLE `api`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `category_sub`
--
ALTER TABLE `category_sub`
  MODIFY `id_category_sub` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `division`
--
ALTER TABLE `division`
  MODIFY `id_division` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `relation`
--
ALTER TABLE `relation`
  MODIFY `id_relation` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id_site` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
