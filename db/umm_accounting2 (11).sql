-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 31, 2014 at 02:16 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `umm_accounting2`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in the master database',
  `account_type` int(2) NOT NULL COMMENT '1 - Assets, 2 - Liabilities, 3 - Income, 4 - Expenses, 5 - Equity',
  `account_id` int(3) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `pay_status` int(2) NOT NULL COMMENT '1 - Payment Account, 2 - Normal Account',
  `delete_status` int(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `fkcompany_id`, `account_type`, `account_id`, `account_name`, `currency`, `pay_status`, `delete_status`, `date_created`, `date_modified`) VALUES
(2, 2, 3, 54, 'Accounting Services', '', 2, 1, '2014-01-02 15:29:56', '0000-00-00 00:00:00'),
(3, 2, 4, 31, 'Political Contributions', '', 2, 2, '2014-01-02 15:37:39', '2014-01-03 13:15:01'),
(6, 2, 1, 15, 'Allowance for Bad Debt', 'DZ', 1, 2, '2014-01-02 16:34:45', '2014-01-03 13:17:31'),
(7, 2, 2, 17, 'Mortgagesss', 'MYR', 1, 2, '2014-01-02 16:35:04', '2014-01-03 16:10:32'),
(8, 2, 1, 1, 'Checking Account', 'INR', 1, 1, '2014-01-03 15:25:09', '0000-00-00 00:00:00'),
(9, 2, 1, 2, 'Saving Accountss', 'INR', 1, 1, '2014-01-03 15:33:07', '0000-00-00 00:00:00'),
(10, 2, 1, 2, 'Saving Accounts', 'INR', 1, 1, '2014-01-03 15:52:19', '2014-01-03 16:10:19'),
(11, 2, 2, 17, 'Mortgages', 'INR', 1, 1, '2014-01-03 16:08:49', '0000-00-00 00:00:00'),
(12, 2, 1, 37, 'Buildings', 'INR', 1, 1, '2014-01-03 16:09:35', '2014-01-10 10:34:00'),
(13, 2, 4, 13, 'Equipment Lease or Rental', '', 2, 1, '2014-01-18 17:49:17', '0000-00-00 00:00:00'),
(14, 2, 4, 4, 'Custom Hire & Contract Labor', '', 2, 1, '2014-01-27 14:13:05', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in the master database',
  `customer_id` varchar(30) NOT NULL COMMENT 'Customer ID format is CUS-0000000001',
  `customer_name` varchar(60) NOT NULL,
  `address1` tinytext NOT NULL,
  `address2` tinytext NOT NULL,
  `company_registration_no` varchar(30) NOT NULL,
  `office_number` varchar(30) NOT NULL,
  `fax_number` varchar(30) NOT NULL,
  `city` varchar(60) NOT NULL,
  `state` varchar(60) NOT NULL,
  `country` varchar(10) NOT NULL,
  `website` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `company_gst_no` varchar(30) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `gst_verified_date` date NOT NULL,
  `delete_status` int(2) NOT NULL DEFAULT '1' COMMENT '1- active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fkcompany_id`, `customer_id`, `customer_name`, `address1`, `address2`, `company_registration_no`, `office_number`, `fax_number`, `city`, `state`, `country`, `website`, `email`, `company_gst_no`, `postcode`, `gst_verified_date`, `delete_status`, `date_created`, `date_modified`) VALUES
(13, 2, 'CUS-0000000001', 'Demo', 'Velachery 100', '', 'jkkhjkj', '656546546', '', 'Hjhjhg', 'Jhgjghjdds', 'DZ', '', '', 'hjhgjg', '676767', '2014-01-24', 1, '2014-01-07 12:42:55', '2014-01-20 16:05:17'),
(14, 2, 'CUS-0000000002', 'Ghghgh', 'ghgfhfhghfg', '', '', '654654654', '', 'Hgfhfh', 'Hghgfh', 'FR', '', '', 'hghgf', '6565465', '2014-01-22', 1, '2014-01-08 10:15:18', '2014-01-20 16:02:48'),
(15, 2, 'CUS-0000000003', 'adsds', 'sdsdsdsadssads', '', 'dsdsd', '53665', '', 'tegfd', 'Jhgjghj', 'AT', '', '', '', '5656', '1970-01-01', 1, '2014-01-20 15:50:18', '0000-00-00 00:00:00'),
(16, 2, 'CUS-0000000004', 'dgdfgdf', 'fgfdgfdg5656565', '', 'fdgdfgd', '56656', '', 'ghfghfgh', 'hfghfgh', 'AU', '', '', '', '6554654', '1970-01-01', 1, '2014-01-20 15:57:26', '0000-00-00 00:00:00'),
(17, 2, 'CUS-0000000005', 'ghgfhg', 'jyhjhgjhgjhgjgj', '', 'hghgfhg', '6767657', '', 'hjghjgh', 'jghjghj', 'AZ', '', '', '', '7676767', '1970-01-01', 1, '2014-01-20 16:43:58', '0000-00-00 00:00:00'),
(18, 2, 'CUS-0000000006', 'testing', 'fgfdgfdgfdg', '', 'gfdgfdgfdgfdg', '6565654', '', 'Hghgfhfghfg', 'Hgfhgfh', 'AQ', '', '', '', '56565', '0000-00-00', 1, '2014-01-20 16:47:21', '2014-01-20 17:05:02'),
(19, 2, 'CUS-0000000007', 'Testing', 'fgfdgfdgfdg', '', 'gfdgfdgfdgfdg', '6565654', '', 'Hghgfhfghfg', 'Hgfhgfh', 'AQ', '', '', '', '56565', '0000-00-00', 1, '2014-01-20 17:05:25', '0000-00-00 00:00:00'),
(20, 2, 'CUS-0000000008', 'Testing', 'fgfdgfdgfdg', '', 'gfdgfdgfdgfdg', '6565654', '', 'Hghgfhfghfg', 'Hgfhgfh', 'AQ', '', '', '', '56565', '0000-00-00', 1, '2014-01-20 17:05:45', '0000-00-00 00:00:00'),
(21, 2, 'CUS-0000000009', 'test', 'jhjhgjjhjhgjg', '', 'hjghjgh', '85878678', '', 'jhghj', 'jhghj', 'BV', '', '', '', '676767', '0000-00-00', 1, '2014-01-29 16:33:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer_contact_person`
--

CREATE TABLE IF NOT EXISTS `customer_contact_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcustomer_id` int(11) NOT NULL,
  `contact_name` varchar(60) NOT NULL,
  `designation` varchar(60) NOT NULL,
  `contact_office_number` varchar(30) NOT NULL,
  `contact_mobile_number` varchar(30) NOT NULL,
  `contact_email` varchar(60) NOT NULL,
  `default_key_contact` int(2) NOT NULL COMMENT '1 - Yes, 2 - No',
  `contact_type` int(2) NOT NULL COMMENT '1 - Customer Contact, 2 - Vendor Contact',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkcustomer_id` (`fkcustomer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `customer_contact_person`
--

INSERT INTO `customer_contact_person` (`id`, `fkcustomer_id`, `contact_name`, `designation`, `contact_office_number`, `contact_mobile_number`, `contact_email`, `default_key_contact`, `contact_type`, `date_created`, `date_modified`) VALUES
(4, 13, 'Tester', 'Jggj', '', '655656', 'test@gmail.com', 1, 1, '2014-01-07 12:42:55', '2014-01-07 19:05:25'),
(6, 13, 'Test123', 'Fdsgsg', '', '9994533083', 'dfdgg@ymail.com', 2, 1, '2014-01-07 19:05:25', '2014-01-07 19:18:43'),
(9, 13, 'Test123', 'MDS', '', '7896541230', 'dfdgg@rediffmail.com', 2, 1, '2014-01-07 19:18:43', '2014-01-20 16:05:17'),
(10, 3, 'fdgfsgsdg', 'gfdgdf', '', '6566546', 'test@gmail.com', 1, 2, '2014-01-08 10:01:26', '0000-00-00 00:00:00'),
(11, 3, 'gfgfg', 'gfgf', '', '5454545', 'dfdgg@ymail.com', 2, 2, '2014-01-08 10:01:26', '0000-00-00 00:00:00'),
(12, 14, 'Hghgfh', 'Hgfhgf', '', '868787687', 'hghs@asd.com', 1, 1, '2014-01-08 10:15:18', '2014-01-20 16:02:49'),
(13, 5, 'gfdgdfg', 'gdgdgdf', '', '656556565', 'test@gmail.com', 1, 2, '2014-01-08 10:17:42', '0000-00-00 00:00:00'),
(14, 5, 'gffgfg', 'gfgfd', '', '656565', 'dfdgg@ymail.com', 2, 2, '2014-01-08 10:20:01', '0000-00-00 00:00:00'),
(15, 9, 'kjkhukhj', 'kkhjkhk', '', '', '', 1, 2, '2014-01-20 16:38:39', '0000-00-00 00:00:00'),
(16, 17, 'jhjhgjhg', 'jhjghj', '', '', '', 1, 1, '2014-01-20 16:43:58', '0000-00-00 00:00:00'),
(17, 18, 'Ghgfhgfh', 'Hgfhgfh', '', '', '', 1, 1, '2014-01-20 16:47:21', '2014-01-20 17:05:02'),
(18, 19, 'Ghgfhgfh', 'Hgfhgfh', '', '', '', 1, 1, '2014-01-20 17:05:25', '0000-00-00 00:00:00'),
(19, 20, 'Ghgfhgfh', 'Hgfhgfh', '', '', '', 1, 1, '2014-01-20 17:05:45', '0000-00-00 00:00:00'),
(20, 20, 'ghghgfh', 'ghgf', '', '', '', 2, 1, '2014-01-20 17:05:46', '0000-00-00 00:00:00'),
(21, 10, 'Kjkhukhj', 'Kkhjkhk', '', '', '', 1, 2, '2014-01-20 17:11:20', '0000-00-00 00:00:00'),
(22, 11, 'Kjkhukhj', 'Kkhjkhk', '', '', '', 1, 2, '2014-01-20 17:11:58', '0000-00-00 00:00:00'),
(23, 11, 'jhjhgj', 'jhjghj', '', '', '', 2, 2, '2014-01-20 17:11:58', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer_shipping_address`
--

CREATE TABLE IF NOT EXISTS `customer_shipping_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcustomer_id` int(11) NOT NULL,
  `shipping_address1` tinytext NOT NULL,
  `shipping_address2` tinytext NOT NULL,
  `shipping_city` varchar(60) NOT NULL,
  `shipping_state` varchar(60) NOT NULL,
  `shipping_country` varchar(10) NOT NULL,
  `shipping_postcode` varchar(20) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkcustomer_id` (`fkcustomer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `customer_shipping_address`
--

INSERT INTO `customer_shipping_address` (`id`, `fkcustomer_id`, `shipping_address1`, `shipping_address2`, `shipping_city`, `shipping_state`, `shipping_country`, `shipping_postcode`, `date_created`, `date_modified`) VALUES
(4, 13, 'jhjg', '', 'Jhggj', 'Jghj', 'AM', '67767', '2014-01-20 16:05:17', '2014-01-20 16:05:17'),
(6, 13, 'testing123', '', 'Chennai', 'Andhra', 'IN', '260102', '2014-01-20 16:05:17', '2014-01-20 16:05:17'),
(7, 13, 'dsdsd', '', 'Sdsada', 'Dsadfs', 'BS', '545445', '2014-01-20 16:05:17', '2014-01-20 16:05:17'),
(8, 14, 'hghgfh', '', 'Hgfhfgh', 'Hfgjfj', 'CR', '65656', '2014-01-20 16:02:49', '2014-01-20 16:02:49'),
(9, 15, 'ghghgh', '', 'hghgfh', 'hghgf', 'AU', '65655', '2014-01-20 15:50:18', '0000-00-00 00:00:00'),
(10, 16, 'nbnbvnv', '', 'nbvnvbn', 'nbvnvn', 'AU', 'nvbnbnvvn', '2014-01-20 15:57:26', '0000-00-00 00:00:00'),
(11, 17, 'jhjhgjhg', '', 'jhjhg', 'jhgjhg', 'BH', '76767', '2014-01-20 16:43:58', '0000-00-00 00:00:00'),
(12, 18, 'hghgfh', '', 'Hghfghhgfh', 'Hgfhgfh', 'AU', '65465', '2014-01-20 17:05:02', '2014-01-20 17:05:02'),
(13, 19, 'hghgfh', '', 'Hghfghhgfh', 'Hgfhgfh', 'AU', '65465', '2014-01-20 17:05:25', '0000-00-00 00:00:00'),
(14, 20, 'hghgfh', '', 'Hghfghhgfh', 'Hgfhgfh', 'AU', '65465', '2014-01-20 17:05:45', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `expense_transaction`
--

CREATE TABLE IF NOT EXISTS `expense_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in the master database',
  `expense_no` varchar(30) NOT NULL COMMENT 'Expense no format is EXP-0000000001',
  `date` date NOT NULL,
  `receipt_no` varchar(60) NOT NULL,
  `fkvendor_id` int(11) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `credit_term` varchar(100) NOT NULL,
  `due_date` date NOT NULL,
  `transaction_currency` varchar(10) NOT NULL,
  `discount_status` tinyint(2) NOT NULL COMMENT '1 - Yes, 2 - No',
  `discount_amount` decimal(11,2) NOT NULL,
  `permit_no` varchar(100) NOT NULL,
  `do_so_no` varchar(60) NOT NULL,
  `fkreceipt_id` int(11) NOT NULL,
  `transaction_status` tinyint(2) NOT NULL COMMENT '1 - Approved/Verified, 2 - Unverified',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_no` (`expense_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkvendor_id`),
  KEY `fkcustomer_id` (`fkvendor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `expense_transaction`
--

INSERT INTO `expense_transaction` (`id`, `fkcompany_id`, `expense_no`, `date`, `receipt_no`, `fkvendor_id`, `shipping_address`, `credit_term`, `due_date`, `transaction_currency`, `discount_status`, `discount_amount`, `permit_no`, `do_so_no`, `fkreceipt_id`, `transaction_status`, `date_created`, `date_modified`) VALUES
(8, 2, 'EXP-0000000003', '2014-01-20', '123456998', 3, '1', '1', '2014-01-20', 'SGD', 1, 25.00, 'ghghg', '', 3, 2, '2014-01-20 11:13:22', '2014-01-31 18:04:08'),
(9, 2, 'EXP-0000000004', '2014-01-20', '123456998', 2, '1', '1', '2014-01-20', 'SGD', 1, 25.00, 'ghghg', '', 0, 2, '2014-01-24 20:23:25', '0000-00-00 00:00:00'),
(10, 2, 'EXP-0000000005', '2014-01-20', '123456998', 2, '1', '1', '2014-01-20', 'SGD', 1, 25.00, 'ghghg', '', 0, 1, '2014-01-24 20:24:37', '2014-01-29 11:00:53'),
(11, 2, 'EXP-0000000006', '2014-01-20', '123456998', 2, '1', '1', '2014-01-20', 'SGD', 1, 25.00, 'ghghg', '', 0, 1, '2014-01-24 20:25:33', '2014-01-25 18:36:57'),
(12, 2, 'EXP-0000000007', '2014-01-20', '123456998', 2, '1', '1', '2014-01-20', 'SGD', 1, 25.00, 'ghghg', '', 0, 2, '2014-01-24 20:26:23', '0000-00-00 00:00:00'),
(13, 2, 'EXP-0000000008', '2014-01-27', 'kjhkhjk', 6, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'jghjjgh', 'jghjhgjg', 0, 2, '2014-01-27 14:18:56', '0000-00-00 00:00:00'),
(14, 2, 'EXP-0000000009', '2014-01-27', 'kjkhjkhj', 6, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'kjkjhkh', '', 0, 2, '2014-01-27 14:19:58', '0000-00-00 00:00:00'),
(15, 2, 'EXP-0000000010', '2014-01-27', 'jkhkjhjk', 5, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'kjkjhkh', '', 0, 2, '2014-01-27 14:28:47', '0000-00-00 00:00:00'),
(16, 2, 'EXP-0000000011', '2014-01-27', 'jkhkjhjk', 5, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'kjkjhkh', '', 0, 2, '2014-01-27 14:30:12', '0000-00-00 00:00:00'),
(17, 2, 'EXP-0000000012', '2014-01-27', 'jkhkjhjk', 5, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'kjkjhkh', '', 0, 2, '2014-01-27 14:33:24', '0000-00-00 00:00:00'),
(18, 2, 'EXP-0000000013', '2014-01-27', 'jkhkjhjk', 5, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'kjkjhkh', '', 0, 2, '2014-01-27 14:34:47', '0000-00-00 00:00:00'),
(19, 2, 'EXP-0000000014', '2014-01-27', 'jkhkjhjk', 5, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'kjkjhkh', '', 0, 2, '2014-01-27 14:35:53', '0000-00-00 00:00:00'),
(20, 2, 'EXP-0000000015', '2014-01-27', 'test123', 8, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'fdfdsf', '', 0, 1, '2014-01-27 14:36:42', '0000-00-00 00:00:00'),
(21, 2, 'EXP-0000000016', '2014-01-27', 'test123', 8, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'fdfdsf', '', 0, 1, '2014-01-27 14:37:17', '0000-00-00 00:00:00'),
(22, 2, 'EXP-0000000017', '2014-01-27', 'test123', 8, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'fdfdsf', '', 0, 1, '2014-01-27 14:37:27', '0000-00-00 00:00:00'),
(23, 2, 'EXP-0000000018', '2014-01-27', 'test123', 8, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'fdfdsf', '', 0, 1, '2014-01-27 14:37:52', '0000-00-00 00:00:00'),
(24, 2, 'EXP-0000000019', '2014-01-27', 'test123', 8, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'fdfdsf', '', 0, 1, '2014-01-27 14:38:10', '0000-00-00 00:00:00'),
(25, 2, 'EXP-0000000020', '2014-01-27', 'test123', 8, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'fdfdsf', '', 0, 1, '2014-01-27 14:38:25', '0000-00-00 00:00:00'),
(26, 2, 'EXP-0000000021', '2014-01-27', 'test123', 8, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'fdfdsf', '', 0, 1, '2014-01-27 14:39:29', '0000-00-00 00:00:00'),
(27, 2, 'EXP-0000000022', '2014-01-27', 'test123', 8, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'fdfdsf', '', 0, 1, '2014-01-27 14:39:36', '0000-00-00 00:00:00'),
(28, 2, 'EXP-0000000023', '2014-01-27', 'test123', 8, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'fdfdsf', '', 0, 1, '2014-01-27 14:39:53', '0000-00-00 00:00:00'),
(29, 2, 'EXP-0000000024', '2014-01-27', 'test123', 8, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'fdfdsf', '', 0, 1, '2014-01-27 14:42:34', '0000-00-00 00:00:00'),
(30, 2, 'EXP-0000000025', '2014-01-27', 'test123', 8, '1', '1', '2014-02-11', 'SGD', 2, 0.00, 'fdfdsf', '', 0, 1, '2014-01-27 14:42:40', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `expense_transaction_list`
--

CREATE TABLE IF NOT EXISTS `expense_transaction_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkexpense_id` int(11) NOT NULL,
  `fkexpense_type` int(11) NOT NULL,
  `product_id` varchar(60) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(11,2) NOT NULL,
  `fktax_id` int(11) DEFAULT '0',
  `tax_value` decimal(6,2) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkexpense_id` (`fkexpense_id`),
  KEY `fkexpense_type` (`fkexpense_type`),
  KEY `fktax_id` (`fktax_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `expense_transaction_list`
--

INSERT INTO `expense_transaction_list` (`id`, `fkexpense_id`, `fkexpense_type`, `product_id`, `product_description`, `quantity`, `unit_price`, `fktax_id`, `tax_value`, `date_created`, `date_modified`) VALUES
(5, 8, 13, 'fdgd', 'gfdgdfg', 1, 50.00, 2, 20.00, '2014-01-20 11:13:22', '0000-00-00 00:00:00'),
(7, 8, 14, '122gdrdfd', 'test00', 2, 200.00, 2, 20.00, '2014-01-20 12:27:52', '0000-00-00 00:00:00'),
(9, 8, 13, '122', 'gfdgdfg', 2, 100.00, 2, 20.00, '2014-01-20 12:32:37', '0000-00-00 00:00:00'),
(10, 8, 13, 'fdfsfs', 'trgefgdgdg', 1, 300.00, 2, 20.00, '2014-01-24 20:14:03', '0000-00-00 00:00:00'),
(11, 9, 13, 'fdgd', 'gfdgdfg', 1, 50.00, 2, 20.00, '2014-01-24 20:23:25', '0000-00-00 00:00:00'),
(12, 9, 13, '122gdrdfd', 'test1', 3, 200.00, 2, 20.00, '2014-01-24 20:23:25', '0000-00-00 00:00:00'),
(13, 9, 13, '122', 'gfdgdfg', 2, 100.00, 2, 20.00, '2014-01-24 20:23:25', '0000-00-00 00:00:00'),
(14, 9, 13, 'fdfsfs', 'trgefgdgdg', 1, 300.00, 2, 20.00, '2014-01-24 20:23:25', '0000-00-00 00:00:00'),
(15, 10, 13, 'fdgd', 'gfdgdfg', 1, 50.00, 2, 20.00, '2014-01-24 20:24:37', '0000-00-00 00:00:00'),
(16, 10, 13, '122gdrdfd', 'test2', 2, 200.00, 2, 20.00, '2014-01-24 20:24:37', '0000-00-00 00:00:00'),
(17, 10, 13, '122', 'gfdgdfg', 2, 100.00, 2, 20.00, '2014-01-24 20:24:37', '0000-00-00 00:00:00'),
(18, 10, 13, 'fdfsfs', 'trgefgdgdg', 1, 300.00, 2, 20.00, '2014-01-24 20:24:37', '0000-00-00 00:00:00'),
(19, 11, 13, 'fdgd', 'gfdgdfg', 1, 50.00, 2, 20.00, '2014-01-24 20:25:33', '0000-00-00 00:00:00'),
(20, 11, 13, '122gdrdfd', 'gfdgdfg', 2, 200.00, 2, 20.00, '2014-01-24 20:25:33', '0000-00-00 00:00:00'),
(21, 11, 13, '122', 'gfdgdfg', 2, 100.00, 2, 20.00, '2014-01-24 20:25:33', '0000-00-00 00:00:00'),
(22, 11, 13, 'fdfsfs', 'trgefgdgdg', 2, 300.00, 2, 20.00, '2014-01-24 20:25:33', '0000-00-00 00:00:00'),
(23, 12, 13, 'fdgd', 'gfdgdfg', 1, 50.00, 2, 20.00, '2014-01-24 20:26:23', '0000-00-00 00:00:00'),
(24, 12, 13, '122gdrdfdfdf', 'test3', 3, 200.00, 2, 20.00, '2014-01-24 20:26:23', '0000-00-00 00:00:00'),
(25, 12, 13, '122', 'gfdgdfg', 2, 100.00, 2, 20.00, '2014-01-24 20:26:23', '0000-00-00 00:00:00'),
(26, 12, 13, 'fdfsfsfdfdsf', 'trgefgdgdg', 3, 300.00, 2, 20.00, '2014-01-24 20:26:23', '0000-00-00 00:00:00'),
(27, 14, 13, 'kjkh', 'kkjkh', 7, 67.00, 2, 20.00, '2014-01-27 14:19:58', '0000-00-00 00:00:00'),
(28, 15, 14, 'ffsg', 'fggdg', 1, 100.00, 2, 20.00, '2014-01-27 14:28:47', '0000-00-00 00:00:00'),
(29, 16, 14, 'ffsg', 'fggdg', 1, 100.00, 2, 20.00, '2014-01-27 14:30:12', '0000-00-00 00:00:00'),
(30, 17, 14, 'ffsg', 'fggdg', 1, 100.00, 2, 20.00, '2014-01-27 14:33:24', '0000-00-00 00:00:00'),
(31, 18, 14, 'ffsg', 'fggdg', 1, 100.00, 2, 20.00, '2014-01-27 14:34:47', '0000-00-00 00:00:00'),
(32, 19, 14, 'ffsg', 'fggdg', 1, 100.00, 2, 20.00, '2014-01-27 14:35:53', '0000-00-00 00:00:00'),
(38, 30, 14, 'dfdsf', 'dfdfdsf', 2, 200.00, 0, 0.00, '2014-01-27 14:42:40', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `income_transaction`
--

CREATE TABLE IF NOT EXISTS `income_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in the master database',
  `income_no` varchar(30) NOT NULL COMMENT 'Income no format is INC-0000000001',
  `date` date NOT NULL,
  `receipt_no` varchar(60) NOT NULL,
  `fkcustomer_id` int(11) NOT NULL,
  `fkpayment_account` int(11) NOT NULL,
  `credit_term` varchar(100) NOT NULL,
  `transaction_currency` varchar(10) NOT NULL,
  `fkincome_type` int(11) NOT NULL,
  `transaction_description` varchar(255) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `fkreceipt_id` int(11) NOT NULL,
  `fktax_id` int(11) NOT NULL,
  `tax_value` decimal(6,2) NOT NULL,
  `transaction_status` tinyint(2) NOT NULL COMMENT '1 - Approved/Verified, 2 - Unverified & Saved',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_no` (`income_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkcustomer_id`,`fkpayment_account`,`fkincome_type`,`fktax_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `fktax_id` (`fktax_id`),
  KEY `fkpayment_account` (`fkpayment_account`),
  KEY `fkreceipt_id` (`fkreceipt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `income_transaction`
--

INSERT INTO `income_transaction` (`id`, `fkcompany_id`, `income_no`, `date`, `receipt_no`, `fkcustomer_id`, `fkpayment_account`, `credit_term`, `transaction_currency`, `fkincome_type`, `transaction_description`, `amount`, `fkreceipt_id`, `fktax_id`, `tax_value`, `transaction_status`, `date_created`, `date_modified`) VALUES
(2, 2, 'INC-0000000001', '2014-01-17', 'dsads', 14, 10, '4', 'BDT', 2, 'test 123ddsdyy', 201.50, 0, 1, 12.00, 1, '2014-01-17 17:29:20', '2014-01-17 18:04:57'),
(4, 2, 'INC-0000000002', '2014-01-17', 'dfdfds', 13, 9, '3', 'SGD', 2, 'fdfdsfdsfgfds', 543543.00, 0, 1, 12.00, 1, '2014-01-17 17:32:49', '2014-01-17 19:36:23'),
(5, 2, 'INC-0000000003', '2014-01-17', 'dfdfds', 13, 8, '1', 'AFA', 2, 'fdfdsfdsfgfds', 541233.27, 0, 0, 0.00, 2, '2014-01-18 11:44:03', '2014-01-28 16:55:32'),
(6, 2, 'INC-0000000004', '2014-01-17', 'dsads', 14, 10, '4', 'BDT', 2, 'test 123ddsdyy', 201.50, 0, 1, 12.00, 1, '2014-01-18 11:48:09', '0000-00-00 00:00:00'),
(11, 2, 'INC-0000000005', '2014-01-17', 'dsads', 14, 10, '4', 'BDT', 2, 'test 123ddsdyy', 201.50, 0, 1, 12.00, 1, '2014-01-18 12:07:18', '0000-00-00 00:00:00'),
(12, 2, 'INC-0000000006', '2014-01-28', 'gfghg', 15, 8, '2', 'SGD', 2, 'hgffghgdfgfdgdf', 54.00, 0, 1, 12.00, 2, '2014-01-28 16:41:26', '0000-00-00 00:00:00'),
(13, 2, 'INC-0000000007', '2014-01-17', 'test', 13, 8, '1', 'AFA', 2, 'fdfdsfdsfgfds', 541233.27, 0, 0, 0.00, 1, '2014-01-29 12:26:42', '0000-00-00 00:00:00'),
(14, 2, 'INC-0000000008', '2014-01-20', 'hoo', 15, 8, '2', 'SGD', 2, 'hgffghgdfgfdgdf', 54.00, 0, 1, 12.00, 1, '2014-01-29 12:27:25', '0000-00-00 00:00:00'),
(15, 2, 'INC-0000000009', '2014-01-31', 'test12334', 13, 9, '2', 'SGD', 2, 'test demos', 200.00, 1, 1, 12.00, 2, '2014-01-31 15:19:47', '2014-01-31 15:20:41'),
(16, 2, 'INC-0000000010', '2014-01-31', 'test12334', 13, 9, '2', 'SGD', 2, 'test demos', 200.00, 1, 1, 12.00, 2, '2014-01-31 16:41:41', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in the master database',
  `invoice_no` varchar(30) NOT NULL COMMENT 'Invoice no format is INV-0000000001',
  `date` date NOT NULL,
  `fkcustomer_id` int(11) NOT NULL,
  `fkshipping_address` int(11) NOT NULL,
  `credit_term` varchar(100) NOT NULL,
  `due_date` date NOT NULL,
  `transaction_currency` varchar(10) NOT NULL,
  `discount_status` tinyint(2) NOT NULL COMMENT '1 - Yes, 2 - No',
  `non_revenue_tax` tinyint(2) NOT NULL COMMENT '1 - Yes, 2 - No',
  `memo` varchar(255) NOT NULL,
  `do_so_no` varchar(60) NOT NULL,
  `invoice_status` tinyint(2) NOT NULL COMMENT '1 - Saved, 2 - Draft, 3 - Sent, 4 - Waiting',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_no` (`invoice_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkcustomer_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `fkcompany_id`, `invoice_no`, `date`, `fkcustomer_id`, `fkshipping_address`, `credit_term`, `due_date`, `transaction_currency`, `discount_status`, `non_revenue_tax`, `memo`, `do_so_no`, `invoice_status`, `date_created`, `date_modified`) VALUES
(6, 2, 'INV-0000000001', '2014-01-22', 13, 0, '3', '2014-02-06', 'SGD', 1, 1, 'test11233', '', 3, '2014-01-22 18:53:45', '2014-01-29 20:22:37'),
(7, 2, 'INV-0000000002', '2014-01-25', 16, 10, '1', '2014-02-09', 'SGD', 2, 2, '', 'vddsdf', 3, '2014-01-25 16:25:08', '2014-01-25 17:37:35');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_product_list`
--

CREATE TABLE IF NOT EXISTS `invoice_product_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkinvoice_id` int(11) NOT NULL,
  `product_id` varchar(60) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(11,2) NOT NULL,
  `discount_amount` decimal(11,2) NOT NULL,
  `fktax_id` int(11) NOT NULL,
  `tax_value` decimal(6,2) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkexpense_id` (`fkinvoice_id`),
  KEY `fktax_id` (`fktax_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `invoice_product_list`
--

INSERT INTO `invoice_product_list` (`id`, `fkinvoice_id`, `product_id`, `product_description`, `quantity`, `unit_price`, `discount_amount`, `fktax_id`, `tax_value`, `date_created`, `date_modified`) VALUES
(3, 6, 'hfgh', '2', 1, 67657.00, 0.00, 1, 12.00, '2014-01-22 18:53:45', '0000-00-00 00:00:00'),
(5, 6, '8678', '3', 1, 867.00, 0.00, 1, 12.00, '2014-01-23 17:25:34', '0000-00-00 00:00:00'),
(6, 7, '8678', '3', 3, 867.00, 0.00, 1, 12.00, '2014-01-25 16:25:08', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_status` tinyint(4) NOT NULL COMMENT '1 - Yes, 2 - No',
  `discount_amount` decimal(11,2) NOT NULL,
  `payment_description` varchar(255) NOT NULL,
  `payment_status` tinyint(4) NOT NULL COMMENT '1 - Income, 2 - Expense, 3 - Invoice',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  `fkiei_id` int(11) NOT NULL COMMENT 'Must be a primary key from income, invoice or expense table',
  `date` date NOT NULL,
  `fkpayment_account` int(11) DEFAULT NULL,
  `payment_amount` decimal(11,2) NOT NULL,
  `payment_method` tinyint(4) NOT NULL,
  `cheque_draft_no` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkiei_id` (`fkiei_id`),
  KEY `fkpayment_account` (`fkpayment_account`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `discount_status`, `discount_amount`, `payment_description`, `payment_status`, `date_created`, `date_modified`, `fkiei_id`, `date`, `fkpayment_account`, `payment_amount`, `payment_method`, `cheque_draft_no`) VALUES
(2, 2, 0.00, '', 3, '2014-01-24 15:49:28', '0000-00-00 00:00:00', 6, '2014-01-07', 10, 2000.00, 1, ''),
(3, 2, 0.00, 'gf dfgdfg', 3, '2014-01-24 15:51:02', '2014-01-24 16:35:53', 6, '2014-01-29', 12, 100.00, 2, 'fsdfsgfgf'),
(6, 1, 100.00, 'Test 123', 2, '2014-01-25 15:15:12', '0000-00-00 00:00:00', 8, '2014-01-22', 9, 350.00, 3, 'ljjklkj545'),
(7, 1, 10.00, 'gfg dfg', 1, '2014-01-27 15:44:44', '2014-01-27 16:11:44', 2, '2014-01-15', 9, 150.00, 2, ''),
(8, 2, 0.00, '', 1, '2014-01-29 10:33:33', '0000-00-00 00:00:00', 2, '2014-01-29', 10, 35.68, 3, ''),
(10, 1, 0.00, '', 2, '2014-01-29 10:36:57', '0000-00-00 00:00:00', 8, '2014-01-29', 10, 365.00, 2, ''),
(12, 2, 0.00, '', 1, '2014-01-29 10:39:33', '0000-00-00 00:00:00', 2, '2014-01-29', 10, 40.00, 2, ''),
(13, 1, 0.00, '', 2, '2014-01-29 10:40:35', '0000-00-00 00:00:00', 8, '2014-01-29', 8, 400.00, 2, ''),
(16, 2, 0.00, '', 3, '2014-01-29 10:43:33', '0000-00-00 00:00:00', 7, '2014-01-29', 9, 1913.12, 1, ''),
(17, 2, 0.00, '', 3, '2014-01-29 20:15:13', '0000-00-00 00:00:00', 7, '2014-01-29', 11, 1000.00, 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `fkcompany_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in the master database',
  `product_id` varchar(60) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `fkincomeaccount_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkaccount_id` (`fkincomeaccount_id`),
  KEY `fkcompany_id` (`fkcompany_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `fkcompany_id`, `product_id`, `description`, `price`, `currency`, `fkincomeaccount_id`, `date_created`, `date_modified`) VALUES
(2, 'hghfg', 2, 'hfgh', 'jhgjhgjhgj', 67657.00, 'BGN', 2, '2014-01-16 14:14:12', '0000-00-00 00:00:00'),
(3, 'Kjkjh', 2, '8678', 'khjkhjkkhkj', 867.00, 'BRL', 2, '2014-01-16 15:38:48', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `receipt_uploads`
--

CREATE TABLE IF NOT EXISTS `receipt_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkbusiness_id` int(11) NOT NULL COMMENT 'This will be a primary key of the customer id (or) vendor id',
  `name` varchar(100) NOT NULL,
  `receipt` varchar(100) NOT NULL,
  `extension` varchar(30) NOT NULL,
  `receipt_type` int(2) NOT NULL COMMENT '1 - Customer Receipt, 2 - Vendor Receipt',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkcustomer_id` (`fkbusiness_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `receipt_uploads`
--

INSERT INTO `receipt_uploads` (`id`, `fkbusiness_id`, `name`, `receipt`, `extension`, `receipt_type`, `date_created`, `date_modified`) VALUES
(1, 13, 'Test', '13_7625_13.pdf', 'pdf', 1, '2014-01-08 17:23:24', '0000-00-00 00:00:00'),
(2, 13, 'dgf', '13_3961_13.pdf', 'pdf', 1, '2014-01-31 17:37:27', '0000-00-00 00:00:00'),
(3, 3, 'test', '3_935_3.pdf', 'pdf', 2, '2014-01-31 17:40:34', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `taxcodes`
--

CREATE TABLE IF NOT EXISTS `taxcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL,
  `tax_code` varchar(30) NOT NULL,
  `tax_percentage` decimal(6,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `tax_type` int(2) NOT NULL COMMENT '1 - Purchase, 2 - Supply',
  `tax_status` int(2) NOT NULL DEFAULT '2' COMMENT '1 - active, 2 - inactive',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkcompany_id` (`fkcompany_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `taxcodes`
--

INSERT INTO `taxcodes` (`id`, `fkcompany_id`, `tax_code`, `tax_percentage`, `description`, `tax_type`, `tax_status`, `date_created`, `date_modified`) VALUES
(1, 2, 'GST', 12.00, 'Test tax code', 2, 1, '2014-01-17 15:29:53', '2014-01-17 15:30:12'),
(2, 2, 'SGT', 20.00, 'dfd dfdfds', 1, 1, '2014-01-19 10:31:52', '2014-01-19 10:32:03');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE IF NOT EXISTS `vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in the master database',
  `vendor_id` varchar(30) NOT NULL COMMENT 'Vendor ID format is VEN-0000000001',
  `vendor_name` varchar(60) NOT NULL,
  `address1` tinytext NOT NULL,
  `address2` tinytext NOT NULL,
  `company_registration_no` varchar(30) NOT NULL,
  `office_number` varchar(30) NOT NULL,
  `fax_number` varchar(30) NOT NULL,
  `city` varchar(60) NOT NULL,
  `state` varchar(60) NOT NULL,
  `country` varchar(10) NOT NULL,
  `website` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `company_gst_no` varchar(30) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `gst_verified_date` date NOT NULL,
  `delete_status` int(2) NOT NULL DEFAULT '1' COMMENT '1- active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`vendor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `fkcompany_id`, `vendor_id`, `vendor_name`, `address1`, `address2`, `company_registration_no`, `office_number`, `fax_number`, `city`, `state`, `country`, `website`, `email`, `company_gst_no`, `postcode`, `gst_verified_date`, `delete_status`, `date_created`, `date_modified`) VALUES
(2, 2, 'VEN-0000000001', 'Hghgfhgf', 'hgfhgfhhjjghj', '', 'hghgfh', '7878768', '', 'Gjjghjg', 'Jgjhgjg', 'AT', '', '', '', '878787', '1970-01-01', 1, '2014-01-08 09:54:59', '2014-01-20 17:10:32'),
(3, 2, 'VEN-0000000002', 'Gfdgd', 'gfgfdgfdgfdg', '', 'gfdgfdg', '56546546546', '', 'Fggffdg', 'Gfdgdfgdfg', 'AW', '', '', 'gfgfdgdf', '6565464', '2014-01-14', 1, '2014-01-08 10:01:26', '2014-01-20 16:29:10'),
(5, 2, 'VEN-0000000003', 'Testing', 'degfgfdg fgfdgfd', '', 'gfgfg', '4534543543', '', 'Gfdgdfgd', 'Gdgdgf', 'KM', '', '', 'gdgdfgdf', '54545', '2014-01-23', 2, '2014-01-08 10:17:41', '2014-01-08 10:21:51'),
(6, 2, 'VEN-0000000004', 'fgfdg', 'gfgfdgfdgfdg', '', 'fgfg', '563655', '', 'hgfhf', 'hghgf', 'AW', '', '', '', '5654654', '1970-01-01', 1, '2014-01-20 15:50:46', '0000-00-00 00:00:00'),
(7, 2, 'VEN-0000000005', 'gfgdg', 'gfdgfdggfdgdfg', '', 'gfdgfdg', '656565', '', 'hgfhfh', 'hfghfgh', 'AU', '', '', '', '563656', '1970-01-01', 1, '2014-01-20 16:29:35', '0000-00-00 00:00:00'),
(8, 2, 'VEN-0000000006', 'fhfghgf', 'hghgfhgfhghgh', '', 'ghgfhgfh', '677676', '', 'jhjhgj', 'Jhgjghjdd', 'AU', '', '', '', '767766', '1970-01-01', 1, '2014-01-20 16:36:11', '0000-00-00 00:00:00'),
(9, 2, 'VEN-0000000007', 'hghgfhgf', 'hgfhgfhhjjghj', '', 'hghgfh', '7878768', '', 'gjjghjg', 'jgjhgjg', 'AT', '', '', '', '878787', '1970-01-01', 1, '2014-01-20 16:38:39', '0000-00-00 00:00:00'),
(10, 2, 'VEN-0000000008', 'Hghgfhgf', 'hgfhgfhhjjghj', '', 'hghgfh', '7878768', '', 'Gjjghjg', 'Jgjhgjg', 'AT', '', '', '', '878787', '1970-01-01', 1, '2014-01-20 17:11:19', '0000-00-00 00:00:00'),
(11, 2, 'VEN-0000000009', 'Hghgfhgf', 'hgfhgfhhjjghj', '', 'hghgfh', '7878768', '', 'Gjjghjg', 'Jgjhgjg', 'AT', '', '', '', '878787', '1970-01-01', 1, '2014-01-20 17:11:58', '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_shipping_address`
--
ALTER TABLE `customer_shipping_address`
  ADD CONSTRAINT `customer_shipping_address_ibfk_1` FOREIGN KEY (`fkcustomer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `expense_transaction`
--
ALTER TABLE `expense_transaction`
  ADD CONSTRAINT `expense_transaction_ibfk_1` FOREIGN KEY (`fkvendor_id`) REFERENCES `vendors` (`id`);

--
-- Constraints for table `expense_transaction_list`
--
ALTER TABLE `expense_transaction_list`
  ADD CONSTRAINT `expense_transaction_list_ibfk_1` FOREIGN KEY (`fkexpense_id`) REFERENCES `expense_transaction` (`id`),
  ADD CONSTRAINT `expense_transaction_list_ibfk_2` FOREIGN KEY (`fkexpense_type`) REFERENCES `account` (`id`);

--
-- Constraints for table `income_transaction`
--
ALTER TABLE `income_transaction`
  ADD CONSTRAINT `income_transaction_ibfk_1` FOREIGN KEY (`fkcustomer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `income_transaction_ibfk_2` FOREIGN KEY (`fkpayment_account`) REFERENCES `account` (`id`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`fkcustomer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `invoice_product_list`
--
ALTER TABLE `invoice_product_list`
  ADD CONSTRAINT `invoice_product_list_ibfk_1` FOREIGN KEY (`fkinvoice_id`) REFERENCES `invoice` (`id`),
  ADD CONSTRAINT `invoice_product_list_ibfk_2` FOREIGN KEY (`fktax_id`) REFERENCES `taxcodes` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`fkpayment_account`) REFERENCES `account` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`fkincomeaccount_id`) REFERENCES `account` (`id`);
