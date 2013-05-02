-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 15, 2013 at 06:37 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `appevolution`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE IF NOT EXISTS `about` (
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`image`, `description`) VALUES
('http://192.168.0.32/appevolution/upload/2012/10/22/about_66.png', 'asdfasdfasdfasdf');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `sort_description` varchar(500) NOT NULL,
  `image_original` varchar(255) NOT NULL,
  `image_web` varchar(255) NOT NULL,
  `image_web_thumb` varchar(255) NOT NULL,
  `image_mobile` varchar(255) NOT NULL,
  `image_mobile_thumb` varchar(255) NOT NULL,
  `actived` char(1) NOT NULL DEFAULT 'Y',
  `created` datetime NOT NULL,
  `store_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `title`, `description`, `sort_description`, `image_original`, `image_web`, `image_web_thumb`, `image_mobile`, `image_mobile_thumb`, `actived`, `created`, `store_id`) VALUES
(1, 'Mens Nike Shox TL3 Brand New White Red SZ', 'US Size 8 8.5 9.5 10 11 12\r\nUK Size 7 7.5 8.5 9 10 11\r\nEUR Size 41 42 43 44 45 46\r\nWidth: Medium (D, M) Style: Athletic\r\nSub Style: Running Main Color: Multi-Colored\r\nCondition: New: In Box\r\n\r\n* Perfect for pounding the playground in cool, breathable comfort.\r\n\r\n* Triple-layer constructed upper ensures breathability and a comfortable fit.\r\n\r\n* TPU midfoot support structure works with lacing for great lockdown.\r\n\r\n* Full-length Nike Shox columns between Pebax plates provides improved ride, transition, and durability with reduced weight.\r\n\r\n* Solid rubber outsole offers great traction in all conditions.', 'US Size 8 8.5 9.5 10 11 12\r\nUK Size 7 7.5 8.5 9 10 11\r\nEUR Size 41 42 43 44 45 46', 'http://192.168.0.32/appevolution/upload/2012/09/20/Mens+Nike+Shox+TL3+Brand+New+White+Red+SZ.jpg', 'http://192.168.0.32/appevolution/upload/2012/09/20/Mens+Nike+Shox+TL3+Brand+New+White+Red+SZ-533x400.jpg', 'http://192.168.0.32/appevolution/upload/2012/09/20/Mens+Nike+Shox+TL3+Brand+New+White+Red+SZ-187x105.jpg', 'http://192.168.0.32/appevolution/upload/2012/09/20/Mens+Nike+Shox+TL3+Brand+New+White+Red+SZ-287x215.jpg', 'http://192.168.0.32/appevolution/upload/2012/09/20/Mens+Nike+Shox+TL3+Brand+New+White+Red+SZ-100x100.jpg', 'Y', '2012-09-20 16:41:04', 1000000001);

-- --------------------------------------------------------

--
-- Table structure for table `checks`
--

CREATE TABLE IF NOT EXISTS `checks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `coupon_id` bigint(20) NOT NULL,
  `device_id` bigint(20) NOT NULL,
  `registed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE IF NOT EXISTS `configurations` (
  `order_num` int(3) NOT NULL,
  `config_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `config_value` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `config_comment` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`order_num`, `config_name`, `config_value`, `config_comment`) VALUES
(1, 'SITE_TITLE', 'AppEvolution', '.....'),
(2, 'SESS_LIFE', '86400', '.....'),
(3, 'ADMIN_EMAIL_ADRESS', 'info@appevolution.com', '.....'),
(4, 'ACTION_DEBUG_ENABLE', 'yes', 'yes/no'),
(5, 'MAX_DISPLAY_COUNT_ONE_PAGE', '15', ''),
(6, 'MAX_DISPLAY_PAGE_LINKS', '20', '.....'),
(11, 'PUSH_NOTIFICATION', 'develop', ''),
(12, 'PUSH_NOTIFICATION_DEVELOP_PEM_FILE', 'D:/xampp/htdocs/appevolution/includes/develop_push.pem', ''),
(13, 'PUSH_NOTIFICATION_DEVELOP_PEM_PASS', '', ''),
(14, 'PUSH_NOTIFICATION_PRODUCT_PEM_FILE', '', ''),
(15, 'PUSH_NOTIFICATION_PRODUCT_PEM_PASS', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `sort_description` varchar(500) NOT NULL,
  `image_original` varchar(255) NOT NULL,
  `image_web` varchar(255) NOT NULL,
  `image_web_thumb` varchar(255) NOT NULL,
  `image_mobile` varchar(255) NOT NULL,
  `image_mobile_thumb` varchar(255) NOT NULL,
  `actived` char(1) NOT NULL DEFAULT 'N',
  `created` datetime NOT NULL,
  `store_id` int(10) NOT NULL DEFAULT '0',
  `is_gps_check` char(1) NOT NULL DEFAULT 'Y',
  `distance` double(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `title`, `description`, `sort_description`, `image_original`, `image_web`, `image_web_thumb`, `image_mobile`, `image_mobile_thumb`, `actived`, `created`, `store_id`, `is_gps_check`, `distance`) VALUES
(1, 'first visit', 'fasdfasdsafa', 'asdfasd', 'http://192.168.0.32/appevolution/upload/2012/10/24/first+visit.png', 'http://192.168.0.32/appevolution/upload/2012/10/24/first+visit-221x190.png', 'http://192.168.0.32/appevolution/upload/2012/10/24/first+visit-187x105.png', 'http://192.168.0.32/appevolution/upload/2012/10/24/first+visit-221x190.png', 'http://192.168.0.32/appevolution/upload/2012/10/24/first+visit-100x86.png', 'N', '2012-10-24 05:19:42', 1000000001, 'Y', 2.00),
(2, 'asdfasdfasdfasdf', 'sdfasdfasdfasdf', 'asdfa', 'http://192.168.0.32/appevolution/upload/2012/10/24/asdfasdfasdfasdf.jpg', 'http://192.168.0.32/appevolution/upload/2012/10/24/asdfasdfasdfasdf-156x400.jpg', 'http://192.168.0.32/appevolution/upload/2012/10/24/asdfasdfasdfasdf-187x105.jpg', 'http://192.168.0.32/appevolution/upload/2012/10/24/asdfasdfasdfasdf-84x215.jpg', 'http://192.168.0.32/appevolution/upload/2012/10/24/asdfasdfasdfasdf-39x100.jpg', 'Y', '2012-10-24 05:51:15', 1000000001, 'Y', 4.00);

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `device` varchar(128) NOT NULL,
  `os` enum('iphone','andorid') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `device`, `os`) VALUES
(1, '40f3efe63cf31e6d3026b2db65bac76234be369a00117a74b95770aa3dd9cc7d', 'iphone');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE IF NOT EXISTS `galleries` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `gallery_original` varchar(255) NOT NULL,
  `gallery_thumb` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `product_id`, `gallery_original`, `gallery_thumb`) VALUES
(76, 1000000068, 'http://localhost/appevolution/upload/2013/04/12/gallery11111111111111111-571x400.jpg', 'http://localhost/appevolution/upload/2013/04/12/gallery11111111111111111-187x105.jpg'),
(77, 1000000068, 'http://localhost/appevolution/upload/2013/04/12/gallery11111111111111112-600x383.png', 'http://localhost/appevolution/upload/2013/04/12/gallery11111111111111112-187x105.png'),
(78, 1000000069, 'http://localhost/appevolution/upload/2013/04/12/gallery22222221-533x400.jpg', 'http://localhost/appevolution/upload/2013/04/12/gallery22222221-187x105.jpg'),
(79, 1000000069, 'http://localhost/appevolution/upload/2013/04/12/gallery22222222_22-533x400.jpg', 'http://localhost/appevolution/upload/2013/04/12/gallery22222222_22-187x105.jpg'),
(80, 1000000069, 'http://localhost/appevolution/upload/2013/04/12/gallery22222223_59-533x400.jpg', 'http://localhost/appevolution/upload/2013/04/12/gallery22222223_59-187x105.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `sort_description` varchar(500) NOT NULL,
  `image_original` varchar(255) NOT NULL,
  `image_web` varchar(255) NOT NULL,
  `image_web_thumb` varchar(255) NOT NULL,
  `image_mobile` varchar(255) NOT NULL,
  `image_mobile_thumb` varchar(255) NOT NULL,
  `actived` char(1) NOT NULL DEFAULT 'Y',
  `created` datetime NOT NULL,
  `store_id` int(10) NOT NULL DEFAULT '0',
  `gallery_num` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000000070 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `sort_description`, `image_original`, `image_web`, `image_web_thumb`, `image_mobile`, `image_mobile_thumb`, `actived`, `created`, `store_id`, `gallery_num`) VALUES
(1000000068, '1111111111111111', 'qqqqqqqqqq', '', 'http://localhost/appevolution/upload/2013/04/12/1111111111111111.png', 'http://localhost/appevolution/upload/2013/04/12/1111111111111111-600x389.png', 'http://localhost/appevolution/upload/2013/04/12/1111111111111111-187x105.png', 'http://localhost/appevolution/upload/2013/04/12/1111111111111111-320x207.png', 'http://localhost/appevolution/upload/2013/04/12/1111111111111111-100x64.png', 'Y', '2013-04-12 17:41:14', 0, 2),
(1000000069, '2222222', '3333333333333', '', 'http://localhost/appevolution/upload/2013/04/12/2222222.jpg', 'http://localhost/appevolution/upload/2013/04/12/2222222-196x255.jpg', 'http://localhost/appevolution/upload/2013/04/12/2222222-187x105.jpg', 'http://localhost/appevolution/upload/2013/04/12/2222222-165x215.jpg', 'http://localhost/appevolution/upload/2013/04/12/2222222-76x100.jpg', 'Y', '2013-04-12 18:28:06', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `sesskey` varchar(100) NOT NULL,
  `expiry` int(11) unsigned NOT NULL DEFAULT '0',
  `value` text NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`sesskey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`sesskey`, `expiry`, `value`, `user_id`) VALUES
('tqvl8ttv667a7lfntfurdc4tn2', 1365789466, 'appevolution_admin_userid|s:10:"1234567890";appevolution_admin_username|s:5:"admin";', 1234567890),
('gia8h2it7ru4ca2tls9hf0r900', 1365871314, 'appevolution_admin_userid|s:10:"1234567890";appevolution_admin_username|s:5:"admin";', 1234567890),
('ahuqn54khn52hl7tvitimdhr53', 1365789252, 'appevolution_admin_userid|s:10:"1234567890";appevolution_admin_username|s:5:"admin";', 1234567890),
('804d0tjsvqgs9ns7e8jr5iun63', 1365883252, 'appevolution_admin_userid|s:10:"1234567890";appevolution_admin_username|s:5:"admin";', 1234567890),
('u874krofdv36h65fmka9s5n0s3', 1365778083, 'appevolution_admin_userid|s:10:"1234567890";appevolution_admin_username|s:5:"admin";', 1234567890),
('n018lvsq7pvibm60016d1n0993', 1365783653, 'appevolution_admin_userid|s:10:"1234567890";appevolution_admin_username|s:5:"admin";', 1234567890),
('u9j94hb0ssns0a5sup6uts1nf0', 1366082275, 'appevolution_admin_userid|s:10:"1234567890";appevolution_admin_username|s:5:"admin";', 1234567890);

-- --------------------------------------------------------

--
-- Table structure for table `specials`
--

CREATE TABLE IF NOT EXISTS `specials` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `sort_description` varchar(500) NOT NULL,
  `image_original` varchar(255) NOT NULL,
  `image_web` varchar(255) NOT NULL,
  `image_web_thumb` varchar(255) NOT NULL,
  `image_mobile` varchar(255) NOT NULL,
  `image_mobile_thumb` varchar(255) NOT NULL,
  `actived` char(1) NOT NULL DEFAULT 'Y',
  `created` datetime NOT NULL,
  `store_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000000002 ;

--
-- Dumping data for table `specials`
--

INSERT INTO `specials` (`id`, `title`, `description`, `sort_description`, `image_original`, `image_web`, `image_web_thumb`, `image_mobile`, `image_mobile_thumb`, `actived`, `created`, `store_id`) VALUES
(1000000001, 'Apt. 9Â® Ivy Bedding Coordinates', 'Product Questions & Answers\r\n53 Questions & 57 Answers\r\n\r\nThese Apt. 9 Ivy bedding coordinates make a chic statement. The contemporary design will take your home decor to the next level. Make your bedroom modern using these bedding accessories. In multi.\r\n\r\n    Natural theme with coordinating leaf and striped patterns lend a charming, updated look.', 'Product Questions & Answers', 'http://192.168.0.32/appevolution/upload/2012/09/20/Apt.+9C2AE+Ivy+Bedding+Coordinates.jpg', 'http://192.168.0.32/appevolution/upload/2012/09/20/Apt.+9C2AE+Ivy+Bedding+Coordinates-399x399.jpg', 'http://192.168.0.32/appevolution/upload/2012/09/20/Apt.+9C2AE+Ivy+Bedding+Coordinates-187x105.jpg', 'http://192.168.0.32/appevolution/upload/2012/09/20/Apt.+9C2AE+Ivy+Bedding+Coordinates-215x215.jpg', 'http://192.168.0.32/appevolution/upload/2012/09/20/Apt.+9C2AE+Ivy+Bedding+Coordinates-100x100.jpg', 'Y', '2012-09-20 12:22:25', 1000000001);

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE IF NOT EXISTS `stores` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `sort_description` varchar(500) NOT NULL,
  `image_original` varchar(255) NOT NULL,
  `image_web` varchar(255) NOT NULL,
  `image_web_thumb` varchar(255) NOT NULL,
  `image_mobile` varchar(255) NOT NULL,
  `image_mobile_thumb` varchar(255) NOT NULL,
  `actived` char(1) NOT NULL DEFAULT 'Y',
  `created` datetime NOT NULL,
  `location` varchar(500) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000000007 ;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `description`, `sort_description`, `image_original`, `image_web`, `image_web_thumb`, `image_mobile`, `image_mobile_thumb`, `actived`, `created`, `location`, `latitude`, `longitude`) VALUES
(1000000002, '22222222222', '333333333333', '', 'http://localhost/appevolution/upload/2013/04/12/22222222222_13.jpg', 'http://localhost/appevolution/upload/2013/04/12/22222222222_13-600x294.jpg', 'http://localhost/appevolution/upload/2013/04/12/22222222222_13-187x105.jpg', 'http://localhost/appevolution/upload/2013/04/12/22222222222_13-320x156.jpg', 'http://localhost/appevolution/upload/2013/04/12/22222222222_13-100x49.jpg', 'Y', '2013-04-12 15:02:38', 'wetqwet', 0, 0),
(1000000003, 'werwerw', 'erwerwe', '', 'http://localhost/appevolution/upload/2013/04/12/.jpg', 'http://localhost/appevolution/upload/2013/04/12/.jpg-600x294.jpg', 'http://localhost/appevolution/upload/2013/04/12/.jpg-187x105.jpg', 'http://localhost/appevolution/upload/2013/04/12/.jpg-320x156.jpg', 'http://localhost/appevolution/upload/2013/04/12/.jpg-100x49.jpg', 'Y', '2013-04-12 15:03:43', 'qwetqwet', 234, 2342),
(1000000004, 'sdgasdgsg', 'wertwet', '', 'http://localhost/appevolution/upload/2013/04/12/_16.jpg', 'http://localhost/appevolution/upload/2013/04/12/_16-600x277.jpg', 'http://localhost/appevolution/upload/2013/04/12/_16-187x105.jpg', 'http://localhost/appevolution/upload/2013/04/12/_16-320x147.jpg', 'http://localhost/appevolution/upload/2013/04/12/_16-100x46.jpg', 'Y', '2013-04-12 15:04:58', 'wetwet', 2342, 3423),
(1000000005, '11111111111', '2222222222', '', 'http://localhost/appevolution/upload/2013/04/12/11111111111.png', 'http://localhost/appevolution/upload/2013/04/12/11111111111-600x389.png', 'http://localhost/appevolution/upload/2013/04/12/11111111111-187x105.png', 'http://localhost/appevolution/upload/2013/04/12/11111111111-320x207.png', 'http://localhost/appevolution/upload/2013/04/12/11111111111-100x64.png', 'Y', '2013-04-12 15:22:55', '33333372347234754', 444, 52352),
(1000000006, '33333333333', '2222222222222', '', 'http://localhost/appevolution/upload/2013/04/15/33333333333.jpg', 'http://localhost/appevolution/upload/2013/04/15/33333333333-196x255.jpg', 'http://localhost/appevolution/upload/2013/04/15/33333333333-187x105.jpg', 'http://localhost/appevolution/upload/2013/04/15/33333333333-165x215.jpg', 'http://localhost/appevolution/upload/2013/04/15/33333333333-76x100.jpg', 'Y', '2013-04-15 05:17:20', 'Evinayong, Equatorial Guinea', 1.4061088354351594, 10.37109375);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `user_password` varchar(69) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phone` varchar(100) NOT NULL,
  `user_created` datetime NOT NULL,
  `user_modified` datetime NOT NULL,
  `user_last_logined` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=euckr CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1234567899 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_email`, `user_phone`, `user_created`, `user_modified`, `user_last_logined`) VALUES
(1234567890, 'admin', '2c1ff8e99ba562407f3fac2c80fe456c1b0f420f50eabc12b7927b3611a2f122:89be', 'info@appevolution.com', '111222', '2012-07-12 19:58:14', '2012-09-20 05:05:21', '2013-04-15 04:39:39');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
