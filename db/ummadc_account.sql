-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 07, 2014 at 07:43 PM
-- Server version: 5.5.37-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ummadc_account`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL,
  `users` mediumtext NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `seen_users` mediumtext NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkcompany_id` (`fkcompany_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `fkcompany_id`, `users`, `subject`, `message`, `seen_users`, `date_created`, `date_modified`) VALUES
(1, 0, 'all', 'Happy Holidays - Message from Pinnacle One', 'Welcome to 2014 New Year.. ', '100', '2014-07-11 16:09:31', '2014-07-25 12:29:24'),
(2, 0, 'all', 'Final Test Done', 'Final Test Done', '100', '2014-07-15 10:31:32', '2014-07-25 11:47:15');

-- --------------------------------------------------------

--
-- Table structure for table `company_database`
--

CREATE TABLE IF NOT EXISTS `company_database` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL,
  `server_address` varchar(100) NOT NULL DEFAULT 'default' COMMENT 'main_default,default,3 - some other ip or address',
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `database_name` varchar(60) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkcompany_id` (`fkcompany_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `company_database`
--

INSERT INTO `company_database` (`id`, `fkcompany_id`, `server_address`, `username`, `password`, `database_name`, `date_created`, `date_modified`) VALUES
(1, 1, 'main_default', '', '', 'account', '2013-12-18 06:29:36', '0000-00-00 00:00:00'),
(35, 61, 'default', '', '', 'ummadc_account_61', '2014-07-07 12:42:50', '0000-00-00 00:00:00'),
(36, 62, 'default', '', '', 'ummadc_account_62', '2014-07-07 13:48:55', '0000-00-00 00:00:00'),
(37, 63, 'default', '', '', 'ummadc_account_63', '2014-07-08 13:59:43', '0000-00-00 00:00:00'),
(38, 64, 'default', '', '', 'ummadc_account_64', '2014-07-09 06:35:56', '0000-00-00 00:00:00'),
(39, 65, 'default', '', '', 'ummadc_account_65', '2014-07-09 06:37:12', '0000-00-00 00:00:00'),
(40, 66, 'default', '', '', 'ummadc_account_66', '2014-07-09 10:53:13', '0000-00-00 00:00:00'),
(41, 67, 'default', '', '', 'ummadc_account_67', '2014-07-10 02:37:33', '0000-00-00 00:00:00'),
(42, 69, 'default', '', '', 'ummadc_account_69', '2014-07-10 23:23:53', '0000-00-00 00:00:00'),
(43, 71, 'default', '', '', 'ummadc_account_71', '2014-07-12 05:32:07', '0000-00-00 00:00:00'),
(44, 72, 'default', '', '', 'ummadc_account_72', '2014-07-12 14:39:35', '0000-00-00 00:00:00'),
(45, 73, 'default', '', '', 'ummadc_account_73', '2014-07-12 19:24:40', '0000-00-00 00:00:00'),
(46, 75, 'default', '', '', 'ummadc_account_75', '2014-07-13 23:49:20', '0000-00-00 00:00:00'),
(47, 77, 'default', '', '', 'ummadc_account_77', '2014-07-14 08:22:52', '0000-00-00 00:00:00'),
(48, 78, 'default', '', '', 'ummadc_account_78', '2014-07-14 22:41:48', '0000-00-00 00:00:00'),
(49, 79, 'default', '', '', 'ummadc_account_79', '2014-07-15 13:51:36', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `company_details`
--

CREATE TABLE IF NOT EXISTS `company_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(60) NOT NULL,
  `company_uen` varchar(20) NOT NULL,
  `company_gst` varchar(20) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `block_no` varchar(30) DEFAULT NULL,
  `street_name` varchar(60) NOT NULL,
  `level` varchar(30) DEFAULT NULL,
  `unit_no` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `region` varchar(30) DEFAULT NULL,
  `country` varchar(10) NOT NULL,
  `financial_year_start_date` varchar(20) NOT NULL,
  `financial_year_end_date` varchar(20) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '2' COMMENT '1 - Active, 2 - Inactive',
  `company_type` int(2) NOT NULL DEFAULT '1' COMMENT '0 - Main, 1 - Default',
  `company_logo` varchar(255) NOT NULL,
  `delete_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 - Active, 2 - Delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_uen` (`company_uen`,`company_gst`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `company_details`
--

INSERT INTO `company_details` (`id`, `company_name`, `company_uen`, `company_gst`, `telephone`, `block_no`, `street_name`, `level`, `unit_no`, `city`, `zip_code`, `region`, `country`, `financial_year_start_date`, `financial_year_end_date`, `currency`, `status`, `company_type`, `company_logo`, `delete_status`, `date_created`, `date_modified`) VALUES
(1, 'Pinnacle One', 't454543543547676', 'hiuooiog12345678', '', NULL, 'ghgfhgfh', NULL, NULL, NULL, NULL, NULL, 'SG', '0000-00-00', '0000-00-00', '', 1, 0, '', 1, '2013-12-18 06:23:52', '0000-00-00 00:00:00'),
(61, 'UMM', 'xyzearsggsgdg', 'dsjdhsdhsjhd', '', '', 'singapore', '', '', '', '', '', 'IN', '07-Jul', '06-Jul', '', 2, 1, '', 2, '2014-07-07 12:42:50', '2014-07-09 11:52:37'),
(62, 'Blue Ocean Pte Ltd', '201405555A', '201405555A', '', '', '123 Tanglin Halt', '', '', '', '', '', 'SG', '01-Apr', '31-Mar', 'SGD', 1, 1, '', 1, '2014-07-07 13:48:55', '2014-07-07 19:19:26'),
(63, 'ABC Pte Ltd', '199000000A', 'MX0199000G', '', '', '55 Newton Road', '', '', '', '', '', 'SG', '01-Jan', '31-Dec', 'SGD', 1, 1, '63_themelogo.jpg', 1, '2014-07-08 13:59:43', '2014-07-09 12:13:07'),
(64, 'Pinnone Pte Ltd', '201402000Z', '201402000Z', '', '', 'Street', '', '', '', '', '', 'SG', '01-Jan', '31-Dec', 'SGD', 1, 1, '', 1, '2014-07-09 06:35:56', '2014-07-13 14:43:54'),
(65, 'Kenneth Pte Ltd', '201402001A', '201402001A', '', '', 'Street', '', '', '', '', '', 'SG', '01-Jan', '31-Dec', 'SGD', 1, 1, '', 1, '2014-07-09 06:37:12', '2014-07-09 12:36:18'),
(66, 'Green Ocean Pte Ltd', '201400401A', '201400401A', '', '', 'Street', '', '', '', '', '', 'SG', '01-Apr', '31-Mar', 'SGD', 1, 1, '', 2, '2014-07-09 10:53:13', '2014-07-11 04:48:54'),
(67, 'Orange Ocean Pte Ltd', '123456789', '123456789', '', '', 'Street 1', '', '', '', '', '', 'SG', '01-Jan', '31-Dec', 'SGD', 1, 1, '', 2, '2014-07-10 02:37:33', '2014-07-11 04:49:01'),
(69, 'Green Ocean Pte Ltd', '1', '1', '', '', '1', '', '', '', '', '', 'SG', '01-Apr', '31-Mar', 'SGD', 1, 1, '', 1, '2014-07-10 23:23:53', '2014-07-11 04:56:17'),
(71, 'Yellow Ocean Pte Ltd', '123', '123', '', '', '123', '', '', '', '', '', 'SG', '01-Jan', '31-Dec', 'SGD', 1, 1, '', 2, '2014-07-12 05:32:07', '2014-07-15 15:24:05'),
(72, 'Ilanji', '16', '16092012', '', '', 'AMK AVE 3', '5', '', '', '', '', 'SG', '01-Jan', '31-Dec', 'SGD', 1, 1, '', 1, '2014-07-12 14:39:35', '2014-07-12 20:10:43'),
(73, 'dummy', 'huhuhuhu', 'hjuhuhuhuh', '', '', 'huuhuhu', '', '', '', '', '', 'SG', '13-Jul', '12-Jul', '', 2, 1, '', 2, '2014-07-12 19:24:40', '2014-07-13 01:49:35'),
(75, 'S', 'S', 'S', '', '', 'Street', '', '', '', '', '', 'SG', '01-Jan', '31-Dec', 'SGD', 1, 1, '', 2, '2014-07-13 23:49:20', '2014-07-15 15:24:14'),
(77, '8', '8', '1', '', '', '1', '', '', '', '', '', 'SG', '01-Apr', '31-Mar', 'SGD', 1, 1, '', 2, '2014-07-14 08:22:52', '2014-07-15 15:24:20'),
(78, 'Final Test', 'Final Test', 'Final Test', '', '', 'Final Test', '', '', '', '', '', 'SG', '01-Apr', '31-Mar', '', 2, 1, '', 1, '2014-07-14 22:41:48', '0000-00-00 00:00:00'),
(79, 'Accuracy Test', 'AT', 'AT', '', '', 'Street', '', '', '', '', '', 'SG', '01-Apr', '31-Mar', 'SGD', 1, 1, '', 1, '2014-07-15 13:51:36', '2014-07-15 19:22:04');

-- --------------------------------------------------------

--
-- Table structure for table `login_credentials`
--

CREATE TABLE IF NOT EXISTS `login_credentials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `fkcompany_id` int(11) NOT NULL,
  `account_type` int(2) NOT NULL COMMENT '0 - Main Developer to all accounts, 1 - Developer, 2 - Super user, 3 - Manager, 4 - User, 5 - Viewer',
  `account_status` int(2) NOT NULL DEFAULT '1' COMMENT '1- active, 2 - locked',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `fkcompany_id` (`fkcompany_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `login_credentials`
--

INSERT INTO `login_credentials` (`id`, `username`, `password`, `fkcompany_id`, `account_type`, `account_status`, `date_created`, `date_modified`) VALUES
(1, 'developer1@pinnone.com', '5f4dcc3b5aa765d61d8327deb882cf99', 1, 0, 1, '2013-12-23 06:52:30', '0000-00-00 00:00:00'),
(2, 'developer2@pinnone.com', '5f4dcc3b5aa765d61d8327deb882cf99', 1, 0, 1, '2014-07-07 11:28:02', '0000-00-00 00:00:00'),
(74, 'divagar@ummtech.com', '5f4dcc3b5aa765d61d8327deb882cf99', 61, 2, 1, '2014-07-07 12:42:50', '0000-00-00 00:00:00'),
(75, 'blue@ocean.com', '5f4dcc3b5aa765d61d8327deb882cf99', 62, 2, 1, '2014-07-07 13:48:55', '2014-07-09 02:20:58'),
(76, 'admin@abc.com', '5f4dcc3b5aa765d61d8327deb882cf99', 63, 2, 1, '2014-07-08 13:59:43', '0000-00-00 00:00:00'),
(77, 'user@ocean.com', '5f4dcc3b5aa765d61d8327deb882cf99', 62, 4, 1, '2014-07-09 02:33:21', '0000-00-00 00:00:00'),
(78, 'view@ocean.com', '5f4dcc3b5aa765d61d8327deb882cf99', 62, 5, 1, '2014-07-09 02:34:18', '0000-00-00 00:00:00'),
(79, 'manager@ocean.com', '5f4dcc3b5aa765d61d8327deb882cf99', 62, 3, 1, '2014-07-09 02:34:33', '0000-00-00 00:00:00'),
(80, 'admin@ocean.com', '5f4dcc3b5aa765d61d8327deb882cf99', 62, 2, 1, '2014-07-09 02:34:51', '0000-00-00 00:00:00'),
(81, 'test@ocean.com', '9b6b249ca27284311db1df1aae014ea8', 62, 2, 1, '2014-07-09 04:42:21', '2014-07-09 12:09:31'),
(82, 'admin@pinnone.com', '9b6b249ca27284311db1df1aae014ea8', 64, 2, 1, '2014-07-09 06:35:56', '0000-00-00 00:00:00'),
(83, 'admin@kenneth.com', '9b6b249ca27284311db1df1aae014ea8', 65, 2, 1, '2014-07-09 06:37:12', '0000-00-00 00:00:00'),
(84, 'test@abc.com', '9b6b249ca27284311db1df1aae014ea8', 63, 2, 1, '2014-07-09 06:40:31', '0000-00-00 00:00:00'),
(85, 'green@ocean.com', '2ac9cb7dc02b3c0083eb70898e549b63', 66, 2, 1, '2014-07-09 10:53:13', '0000-00-00 00:00:00'),
(86, 'orange@ocean.com', '2ac9cb7dc02b3c0083eb70898e549b63', 67, 2, 1, '2014-07-10 02:37:33', '0000-00-00 00:00:00'),
(87, 'manager@pinnone.com', '9b6b249ca27284311db1df1aae014ea8', 64, 3, 1, '2014-07-10 16:56:27', '0000-00-00 00:00:00'),
(88, 'user@pinnone.com', '9b6b249ca27284311db1df1aae014ea8', 64, 4, 1, '2014-07-10 16:56:51', '0000-00-00 00:00:00'),
(89, 'viewer@pinnone.com', '9b6b249ca27284311db1df1aae014ea8', 64, 5, 1, '2014-07-10 16:57:11', '0000-00-00 00:00:00'),
(90, 'raamaarun@gmail.com', '2ac9cb7dc02b3c0083eb70898e549b63', 69, 2, 1, '2014-07-10 23:23:53', '0000-00-00 00:00:00'),
(91, 'yellow@ocean.com', '2ac9cb7dc02b3c0083eb70898e549b63', 71, 2, 2, '2014-07-12 05:32:07', '2014-07-15 15:24:05'),
(92, 'ktan85@gmail.com', '9b6b249ca27284311db1df1aae014ea8', 62, 3, 1, '2014-07-12 14:13:00', '0000-00-00 00:00:00'),
(93, 'sriharia@ilanji.com', '70f8d3018274f771e31b5e98d1373ba7', 72, 2, 1, '2014-07-12 14:39:35', '2014-07-14 05:22:30'),
(94, 'admin@dummy.com', '0e7517141fb53f21ee439b355b5a1d0a', 73, 2, 2, '2014-07-12 19:24:40', '2014-07-13 01:49:35'),
(95, 'sriharib@ilanji.com', '2ac9cb7dc02b3c0083eb70898e549b63', 75, 2, 2, '2014-07-13 23:49:20', '2014-07-15 15:24:14'),
(96, 's@s.com', '2ac9cb7dc02b3c0083eb70898e549b63', 77, 2, 2, '2014-07-14 08:22:52', '2014-07-15 15:24:20'),
(97, 'srihari8@ilanji.com', '2ac9cb7dc02b3c0083eb70898e549b63', 77, 2, 2, '2014-07-14 08:23:39', '2014-07-15 15:24:20'),
(98, 'final@test.com', '2ac9cb7dc02b3c0083eb70898e549b63', 78, 2, 1, '2014-07-14 22:41:48', '0000-00-00 00:00:00'),
(99, 'srihariz@ilanji.com', '2ac9cb7dc02b3c0083eb70898e549b63', 78, 2, 1, '2014-07-14 22:45:15', '2014-07-15 19:20:31'),
(100, 'srihari@ilanji.com', '2ac9cb7dc02b3c0083eb70898e549b63', 79, 2, 1, '2014-07-15 13:51:36', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `taxcodes`
--

CREATE TABLE IF NOT EXISTS `taxcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `percentage` decimal(6,2) NOT NULL,
  `description` tinytext NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1- active, 2 - inactive',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `taxcodes`
--

INSERT INTO `taxcodes` (`id`, `type`, `name`, `percentage`, `description`, `status`, `date_created`, `date_modified`) VALUES
(1, 1, 'TX7', '7.00', 'Purchases with GST incurred at 7% and directly attributable to taxable supplies', 2, '2014-07-01 05:03:49', '2014-07-07 20:40:27'),
(2, 1, 'IM', '7.00', 'GST incurred for import of goods', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(3, 1, 'ME', '0.00', 'Imports under special scheme with no GST incurred (e.g. Major Exporter Scheme, 3rd Party Logistic Scheme)"', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(4, 1, 'BL', '7.00', 'Purchases with GST incurred but not claimable under Regulations 26/27 (e.g. medical expenses for staff)', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(5, 1, 'NR', '0.00', 'Purchases from non GST-registered supplier with no GST incurred', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(6, 1, 'ZP', '0.00', 'Purchases from  GST-registered supplier with no GST incurred. (e.g. supplier provides transportation of goods that qualify as international service)', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(7, 1, 'EP', '0.00', 'Purchases exempted from GST. (e.g. purhcase of residential property or financial services)', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(8, 1, 'OP', '0.00', 'Purchase transactions which is out of the scope of GST legislation (e.g. purchase of goods overseas)', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(9, 1, 'TX-E33', '7.00', 'GST incurred directly attributable to Regulation 33 exempt supplies', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(10, 1, 'TX-N33', '7.00', 'GST incurred directly attributable to Non-Regulation 33 exempt supplies', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(11, 1, 'TX-RE', '7.00', 'GST incurred that is not directly attributable to taxable or exempt supplies', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(12, 1, 'IGDS', '7.00', 'Imports where the GST is suspended until the filing date of the GST return', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(13, 2, 'SR', '7.00', 'Standard-rated supplies with GST charged', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(14, 2, 'ZR', '0.00', 'Zero-rated supplies', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(15, 2, 'ES33', '0.00', 'Regulation 33 Exempt supplies', 1, '2014-07-01 05:03:49', '0000-00-00 00:00:00'),
(16, 2, 'ESN33', '0.00', 'Non Regulation 33 Exempt supplies', 1, '2014-07-01 05:04:33', '0000-00-00 00:00:00'),
(17, 2, 'DS', '7.00', 'Deemed supplies (e.g. transfer or disposal of business assets without consideration)', 1, '2014-07-01 05:04:33', '0000-00-00 00:00:00'),
(18, 2, 'OS', '0.00', 'Out-of-scope Supplies', 1, '2014-07-01 05:04:55', '2014-07-01 12:24:39'),
(23, 1, 'TX', '7.00', 'Purchases with GST incurred at 7% and directly attributable to taxable supplies', 1, '2014-07-07 15:10:19', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE IF NOT EXISTS `themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `default_theme` tinyint(2) NOT NULL COMMENT '1 - Default, 2 - Not Default',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `theme_name`, `description`, `default_theme`, `date_modified`) VALUES
(1, 'Red', 'Basic Theme', 2, '2014-07-16 03:19:29'),
(2, 'Black', 'Black Theme', 2, '2014-07-02 23:29:29'),
(3, 'Blue', 'Blue Theme', 1, '2014-07-16 03:19:29');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `company_database`
--
ALTER TABLE `company_database`
  ADD CONSTRAINT `company_database_ibfk_1` FOREIGN KEY (`fkcompany_id`) REFERENCES `company_details` (`id`);

--
-- Constraints for table `login_credentials`
--
ALTER TABLE `login_credentials`
  ADD CONSTRAINT `login_credentials_ibfk_1` FOREIGN KEY (`fkcompany_id`) REFERENCES `company_details` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
