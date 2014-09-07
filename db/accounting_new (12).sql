-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 05, 2014 at 02:29 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `accounting_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companies` tinytext NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `seen_users` mediumtext NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `companies`, `subject`, `message`, `seen_users`, `date_created`, `date_modified`) VALUES
(2, '2', 'Test one', 'demo testing of particular company', '', '2013-12-23 10:47:08', '2013-12-24 09:48:46');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `company_database`
--

INSERT INTO `company_database` (`id`, `fkcompany_id`, `server_address`, `username`, `password`, `database_name`, `date_created`, `date_modified`) VALUES
(1, 1, 'main_default', '', '', 'accounting', '2013-12-18 11:59:36', '0000-00-00 00:00:00'),
(2, 2, 'default', '', '', 'umm_accounting2', '2013-12-26 12:02:07', '0000-00-00 00:00:00'),
(3, 11, 'default', '', '', 'dkfdsfj_11', '2014-01-10 17:51:58', '0000-00-00 00:00:00'),
(4, 12, 'default', '', '', 'fhhghfg_12', '2014-01-11 18:28:26', '0000-00-00 00:00:00'),
(5, 13, 'default', '', '', 'ummtech1_accounting_13', '2014-01-20 17:55:14', '0000-00-00 00:00:00'),
(6, 14, 'default', '', '', 'ummtech1_accounting_14', '2014-02-08 17:32:57', '0000-00-00 00:00:00'),
(7, 15, 'default', '', '', 'ummtech1_accounting_15', '2014-02-18 17:18:37', '0000-00-00 00:00:00');

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
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_uen` (`company_uen`,`company_gst`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `company_details`
--

INSERT INTO `company_details` (`id`, `company_name`, `company_uen`, `company_gst`, `telephone`, `block_no`, `street_name`, `level`, `unit_no`, `city`, `zip_code`, `region`, `country`, `financial_year_start_date`, `financial_year_end_date`, `currency`, `status`, `company_type`, `date_created`, `date_modified`) VALUES
(1, 'Xpand', 't454543543547676', 'hiuooiog12345678', '', NULL, 'ghgfhgfh', NULL, NULL, NULL, NULL, NULL, 'SG', '0000-00-00', '0000-00-00', '', 1, 0, '2013-12-18 11:53:52', '0000-00-00 00:00:00'),
(2, 'UMM Tech', 'sfdfs4545454s', 'dgdfg435345s', '', '', 'Velacherys', '', '', 'chennais', '600102', '', 'IN', '04-Jan', '01-Dec', '', 1, 1, '2013-12-19 14:50:14', '2014-01-10 18:43:19'),
(3, 'techy', '40494ijgfkfkdgdk', 'ofdpsif40540394', '09343003430', '', 'gfgdg', '', '', '', '', '', 'AS', '18-12', '20-12', 'KYD', 1, 1, '2013-12-23 10:12:19', '2014-01-09 18:04:11'),
(4, 'test123', 'qwertrtt', 'ghhghgh', '7657657', '', 'hgjgj', '', '', '', '', '', 'AS', '14-01', '08-01', '', 2, 1, '2014-01-08 15:43:57', '0000-00-00 00:00:00'),
(5, 'hghgfhgfh', 'hghfghfg', 'hgfhfgh', '', '', 'hfhgfh', '', '', '', '', '', 'AR', '10-Jan', '10-Jan', '', 2, 1, '2014-01-10 13:00:17', '0000-00-00 00:00:00'),
(11, 'dkfdsfj', 'kfjdakfjdfk', 'kfjdakfjdkf', '', '', 'kdf;jskdf', '', '', '', '', '', 'BG', '10-Jan', '10-Jan', '', 2, 1, '2014-01-10 17:51:58', '0000-00-00 00:00:00'),
(12, 'fhhghfg', 'hgfhgfh', 'ghfgh', '', '', 'hgfhf', '', '', '', '', '', 'AG', '11-Jan', '11-Jan', '', 2, 1, '2014-01-11 18:28:26', '0000-00-00 00:00:00'),
(13, 'fgfgfdg', 'gdfgfdgfd', 'gfgfdgdfg', '', '', 'gfdgdfg', '', '', '', '', '', 'AW', '20-Jan', '20-Jan', '', 2, 1, '2014-01-20 17:55:14', '0000-00-00 00:00:00'),
(14, 'fkjdsfkfjksd', 'kfkfdjfkdsjfk', 'kfjdakfjsdkfdjf', '', '', 'djksjdkfd', '', '', '', '', '', 'DZ', '08-Feb', '08-Feb', '', 2, 1, '2014-02-08 17:32:56', '0000-00-00 00:00:00'),
(15, 'lfdklfdkf', 'flfdlsdkl', 'lklklkl', '', '', 'lklklkl', '', '', '', '', '', 'DK', '18-Feb', '18-Feb', 'AUD', 1, 1, '2014-02-18 17:18:36', '2014-02-18 17:20:14');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `login_credentials`
--

INSERT INTO `login_credentials` (`id`, `username`, `password`, `fkcompany_id`, `account_type`, `account_status`, `date_created`, `date_modified`) VALUES
(2, 'divagarn@ummtech.com', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 2, 1, '2013-12-19 14:50:14', '2014-02-20 15:50:41'),
(3, 'divagar@ummtech.com', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 4, 1, '2013-12-23 10:12:19', '2014-01-09 11:42:44'),
(4, 'admin@ummtech.com', '5f4dcc3b5aa765d61d8327deb882cf99', 1, 0, 1, '2013-12-23 12:22:30', '0000-00-00 00:00:00'),
(5, 'admin@ummtechs.com', '5f4dcc3b5aa765d61d8327deb882cf99', 4, 2, 1, '2014-01-08 15:43:57', '0000-00-00 00:00:00'),
(6, 'divagarn.btech@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 5, 2, 1, '2014-01-10 13:00:17', '0000-00-00 00:00:00'),
(12, 'fdfd@dddd.com', '5f4dcc3b5aa765d61d8327deb882cf99', 11, 2, 1, '2014-01-10 17:51:58', '2014-01-21 15:09:43'),
(13, 'divagfdfar@ummtech.com', '5f4dcc3b5aa765d61d8327deb882cf99', 12, 2, 1, '2014-01-11 18:28:26', '0000-00-00 00:00:00'),
(14, 'testerss@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 13, 2, 1, '2014-01-20 17:55:14', '0000-00-00 00:00:00'),
(15, 'manager@ummtech.com', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 3, 1, '2014-02-05 16:08:40', '0000-00-00 00:00:00'),
(16, 'divagartest@ummtech.com', '5f4dcc3b5aa765d61d8327deb882cf99', 14, 2, 1, '2014-02-08 17:32:57', '0000-00-00 00:00:00'),
(17, 'dhjd@dss.com', '5f4dcc3b5aa765d61d8327deb882cf99', 15, 2, 1, '2014-02-18 17:18:36', '0000-00-00 00:00:00');

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
