-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2013 at 11:13 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `accounting`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE IF NOT EXISTS `bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` varchar(255) NOT NULL COMMENT 'Starts with BILL-0000000001',
  `fkaccount_id` int(11) NOT NULL,
  `fkvendor_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `due_date` date NOT NULL,
  `description` tinytext NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `delete_status` int(2) NOT NULL DEFAULT '1' COMMENT '1- active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkaccount_id` (`fkaccount_id`,`fkvendor_id`),
  KEY `fkvendor_id` (`fkvendor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `bill_id`, `fkaccount_id`, `fkvendor_id`, `date`, `due_date`, `description`, `amount`, `delete_status`, `date_created`, `date_modified`) VALUES
(1, 'BILL-0000000001', 1, 2, '2013-11-23', '2013-11-30', 'Electricity charge', 3000.00, 1, '2013-11-18 18:52:40', '2013-11-20 11:04:43'),
(2, 'BILL-0000000002', 1, 1, '2013-11-21', '2013-11-22', 'Test Bill', 200.00, 2, '2013-11-20 10:58:44', '2013-11-20 11:07:44');

-- --------------------------------------------------------

--
-- Table structure for table `bill_transaction`
--

CREATE TABLE IF NOT EXISTS `bill_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fktransaction_id` int(11) NOT NULL,
  `fkbill_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fktransaction_id` (`fktransaction_id`,`fkbill_id`),
  KEY `fkinvoice_id` (`fkbill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bill_transaction`
--

INSERT INTO `bill_transaction` (`id`, `fktransaction_id`, `fkbill_id`, `date_created`) VALUES
(1, 112, 1, '2013-11-25 13:35:25');

-- --------------------------------------------------------

--
-- Table structure for table `company_details`
--

CREATE TABLE IF NOT EXISTS `company_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `company_name` varchar(60) NOT NULL,
  `company_uen` varchar(20) NOT NULL,
  `company_gst` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `account_status` int(2) NOT NULL DEFAULT '1' COMMENT '1- active, 2 - locked',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_uen` (`company_uen`,`company_gst`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `company_details`
--

INSERT INTO `company_details` (`id`, `username`, `password`, `company_name`, `company_uen`, `company_gst`, `phone`, `address`, `account_status`, `date_created`, `date_modified`) VALUES
(1, 'admin@ummtech.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'UMM', 'UESSDO49854985', 'PODSDs49304', '044-2569707', 'Velachery, Chennai', 1, '2013-11-12 12:30:52', '0000-00-00 00:00:00'),
(3, 'divagar.btech@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'cognizant', 'UESSDO49854989', 'PODSDs49306', '4343434343', 'dfsf gfgdfgdf', 1, '2013-11-13 12:02:57', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) NOT NULL COMMENT 'Starts with CST-0000000001',
  `fkaccount_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `state` varchar(60) NOT NULL,
  `city` varchar(60) NOT NULL,
  `country` varchar(10) NOT NULL,
  `zipcode` varchar(30) NOT NULL,
  `website` varchar(60) NOT NULL,
  `delete_status` int(2) NOT NULL DEFAULT '1' COMMENT '1- active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkaccount_id` (`fkaccount_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_id`, `fkaccount_id`, `name`, `email`, `first_name`, `last_name`, `phone`, `fax`, `address1`, `address2`, `state`, `city`, `country`, `zipcode`, `website`, `delete_status`, `date_created`, `date_modified`) VALUES
(1, 'CST-0000000001', 1, 'Divagar', 'divagar.btech@gmail.com', '', '', '', '', '', '', '', '', '', '', '', 1, '2013-11-16 11:06:25', '2013-11-20 13:10:53'),
(2, 'CST-0000000002', 1, 'testings', 'test@gmail.com', '', '', '', '', '', '', '', '', '', '', '', 2, '2013-11-18 15:38:50', '2013-11-20 13:10:34'),
(3, 'CST-0000000003', 1, 'testghf', 'divagar.developer@gmail.com', 'hghg', 'gfg', '7418191913', '656546', 'hgfhfh', 'hghghgfh', 'TN', 'chennai', 'AU', '600100', 'www.uss.com', 2, '2013-11-19 02:26:52', '2013-11-19 02:54:52'),
(4, 'CST-0000000004', 1, 'hhghg', 'tester@gmail.com', 'hgfh', 'hgfh', '', '', '', '', '', '', '', '', '', 2, '2013-11-19 02:52:28', '2013-11-19 02:56:21');

-- --------------------------------------------------------

--
-- Table structure for table `customer_transaction`
--

CREATE TABLE IF NOT EXISTS `customer_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fktransaction_id` int(11) NOT NULL,
  `fkcustomer_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fktransaction_id` (`fktransaction_id`,`fkcustomer_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `customer_transaction`
--

INSERT INTO `customer_transaction` (`id`, `fktransaction_id`, `fkcustomer_id`, `date_created`, `date_modified`) VALUES
(2, 65, 2, '2013-11-18 23:59:59', '2013-11-19 00:22:34'),
(3, 68, 2, '2013-11-19 15:55:34', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `default_system_accounts`
--

CREATE TABLE IF NOT EXISTS `default_system_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` varchar(10) NOT NULL,
  `fksys_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `account_type` int(2) NOT NULL COMMENT '1 - Uncategory,2 - Aged,3 - Payments',
  PRIMARY KEY (`id`),
  KEY `fksys_id` (`fksys_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `default_system_accounts`
--

INSERT INTO `default_system_accounts` (`id`, `did`, `fksys_id`, `name`, `account_type`) VALUES
(1, 'r1', 1, 'Accounts Receivable', 2),
(2, 'p1', 2, 'Accounts Payable', 2),
(3, 'i1', 4, 'Uncategoirzed Income', 1),
(4, 'e1', 5, 'Uncategoirzed Expense', 1),
(5, 'inv1', 4, 'invoice', 3),
(6, 'bill1', 5, 'bill', 3);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(255) NOT NULL COMMENT 'Starts with INV-0000000001',
  `fkaccount_id` int(11) NOT NULL,
  `fkcustomer_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `due_date` date NOT NULL,
  `description` tinytext NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `delete_status` int(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkaccount_id` (`fkaccount_id`,`fkcustomer_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `invoice_id`, `fkaccount_id`, `fkcustomer_id`, `date`, `due_date`, `description`, `amount`, `delete_status`, `date_created`, `date_modified`) VALUES
(1, 'INV-0000000001', 1, 1, '2013-11-20', '2013-11-28', 'Website Building', 500.00, 2, '2013-11-18 18:52:04', '2013-11-19 18:58:26'),
(2, 'INV-0000000002', 1, 2, '2013-11-22', '2013-11-30', 'digital marketing digital marketing digital marketing digital marketing digital marketing', 300.00, 1, '2013-11-18 19:57:05', '2013-11-21 17:11:22'),
(3, 'INV-0000000003', 1, 1, '2013-11-29', '2013-11-30', 'Demo paymentss', 2010.00, 2, '2013-11-19 12:35:43', '2013-11-19 18:58:15'),
(4, 'INV-0000000004', 1, 1, '2013-11-20', '2013-11-27', 'fgdf', 65.00, 1, '2013-11-25 12:27:08', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_transaction`
--

CREATE TABLE IF NOT EXISTS `invoice_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fktransaction_id` int(11) NOT NULL,
  `fkinvoice_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fktransaction_id` (`fktransaction_id`,`fkinvoice_id`),
  KEY `fkinvoice_id` (`fkinvoice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `invoice_transaction`
--

INSERT INTO `invoice_transaction` (`id`, `fktransaction_id`, `fkinvoice_id`, `date_created`) VALUES
(2, 75, 2, '2013-11-21 17:20:31'),
(3, 84, 4, '2013-11-25 12:27:16');

-- --------------------------------------------------------

--
-- Table structure for table `split_transaction`
--

CREATE TABLE IF NOT EXISTS `split_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fktransaction_id` int(11) NOT NULL,
  `description` tinytext NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fktransaction_id` (`fktransaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `split_transaction`
--

INSERT INTO `split_transaction` (`id`, `fktransaction_id`, `description`, `amount`, `date_created`, `date_modified`) VALUES
(4, 74, 'fghfh', 96.00, '2013-11-20 17:09:16', '0000-00-00 00:00:00'),
(5, 74, 'hgfh', 670.00, '2013-11-20 17:09:16', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sub_accounts`
--

CREATE TABLE IF NOT EXISTS `sub_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkaccount_id` int(11) NOT NULL,
  `fksys_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `payment_status` int(2) NOT NULL DEFAULT '0' COMMENT '1 - payment account, 0 - Non payment account',
  `delete_status` int(2) NOT NULL DEFAULT '1' COMMENT '1- active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fksys_id` (`fksys_id`),
  KEY `fkaccount_id` (`fkaccount_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `sub_accounts`
--

INSERT INTO `sub_accounts` (`id`, `fkaccount_id`, `fksys_id`, `name`, `payment_status`, `delete_status`, `date_created`, `date_modified`) VALUES
(1, 1, 2, 'testing demo', 0, 2, '2013-11-12 15:30:22', '2013-11-20 12:28:06'),
(2, 1, 1, 'accounting', 0, 2, '2013-11-12 16:09:51', '2013-11-20 12:43:14'),
(4, 1, 3, 'owners', 0, 1, '2013-11-13 17:55:42', '0000-00-00 00:00:00'),
(5, 1, 1, 'tester', 0, 1, '2013-11-13 18:20:24', '2013-11-20 11:22:12'),
(9, 1, 4, 'Salarys', 0, 1, '2013-11-13 19:51:48', '2013-11-20 12:31:00'),
(10, 1, 2, 'demo', 0, 1, '2013-11-13 20:20:17', '2013-11-20 12:30:45'),
(11, 1, 1, 'houses', 1, 1, '2013-11-14 10:36:08', '2013-11-20 12:30:54'),
(12, 1, 2, 'Bank loan', 0, 1, '2013-11-14 10:36:26', '0000-00-00 00:00:00'),
(13, 1, 5, 'food', 0, 1, '2013-11-14 13:08:15', '2013-11-14 13:08:25'),
(14, 1, 5, 'transport', 0, 1, '2013-11-14 13:10:17', '0000-00-00 00:00:00'),
(15, 1, 4, 'home rent', 0, 1, '2013-11-14 15:04:22', '0000-00-00 00:00:00'),
(16, 1, 5, 'fees', 0, 1, '2013-11-14 15:04:33', '0000-00-00 00:00:00'),
(17, 1, 3, 'owner equitties', 1, 1, '2013-11-20 11:24:44', '2013-11-20 12:26:48'),
(18, 1, 1, 'lands', 1, 1, '2013-11-20 12:31:59', '0000-00-00 00:00:00'),
(19, 1, 1, 'ggdfg', 1, 1, '2013-11-22 13:26:35', '0000-00-00 00:00:00'),
(20, 1, 4, 'hghg', 0, 1, '2013-11-22 13:26:57', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `system_accounts`
--

CREATE TABLE IF NOT EXISTS `system_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `system_accounts`
--

INSERT INTO `system_accounts` (`id`, `account`) VALUES
(1, 'assets'),
(2, 'liabilities'),
(3, 'equity'),
(4, 'income'),
(5, 'expenses');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkaccount_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL COMMENT 'Starts with TXN-0000000001',
  `date` date NOT NULL,
  `description` tinytext NOT NULL,
  `category` varchar(20) NOT NULL,
  `account` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `transaction_category` int(2) NOT NULL COMMENT '1 - Income, 2 - Expense',
  `transaction_type` int(2) NOT NULL COMMENT '1- Simple Transaction, 2- Split Transaction, 3 - Customer Transaction, 4 - Vendor Transaction,5 - Invoice, 6 - Bill',
  `verify_status` int(2) NOT NULL DEFAULT '0' COMMENT '0 - unverified, 1 - verified',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkaccount_id` (`fkaccount_id`,`category`,`account`),
  KEY `account` (`account`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `fkaccount_id`, `transaction_id`, `date`, `description`, `category`, `account`, `amount`, `transaction_category`, `transaction_type`, `verify_status`, `date_created`, `date_modified`) VALUES
(65, 1, 'TXN-0000000008', '2013-11-14', 'jggh', 'inv1', 2, 276.00, 1, 5, 1, '2013-11-18 23:59:59', '2013-11-22 18:03:21'),
(68, 1, 'TXN-0000000011', '2013-11-13', 'hhjhgj', 'inv1', 2, 7867.00, 1, 5, 1, '2013-11-19 15:55:34', '2013-11-20 13:02:41'),
(69, 1, 'TXN-0000000012', '2013-11-09', 'hgfg', '10', 11, 76.00, 1, 1, 0, '2013-11-20 12:55:13', '2013-11-22 17:44:37'),
(74, 1, 'TXN-0000000015', '2013-11-22', 'gh hgfhfg', '12', 17, 766.00, 1, 2, 0, '2013-11-20 17:09:16', '2013-11-25 11:18:19'),
(75, 1, 'TXN-0000000016', '2013-11-06', 'gfdfg', 'inv1', 11, 556.00, 1, 5, 0, '2013-11-21 17:20:14', '2013-11-21 17:20:31'),
(76, 1, 'TXN-0000000017', '2013-11-22', 'hghgfh', '12', 19, 76.00, 2, 1, 0, '2013-11-25 10:47:37', '0000-00-00 00:00:00'),
(77, 1, 'TXN-0000000018', '2013-11-15', 'hghh hgfhgfh', '5', 19, 6565.00, 1, 1, 0, '2013-11-25 11:23:43', '0000-00-00 00:00:00'),
(78, 1, 'TXN-0000000019', '2013-11-29', 'jhjhg', '5', 11, 7676.00, 2, 1, 0, '2013-11-25 11:36:51', '0000-00-00 00:00:00'),
(79, 1, 'TXN-0000000020', '2013-11-14', 'kjkh', '5', 11, 87787.00, 1, 1, 0, '2013-11-25 11:37:02', '0000-00-00 00:00:00'),
(80, 1, 'TXN-0000000021', '2013-11-29', 'kkhjk', '5', 18, 889.00, 1, 1, 0, '2013-11-25 11:37:13', '0000-00-00 00:00:00'),
(81, 1, 'TXN-0000000022', '2013-11-27', 'iuiuy', '5', 18, 87.00, 1, 1, 0, '2013-11-25 11:37:28', '0000-00-00 00:00:00'),
(82, 1, 'TXN-0000000023', '2013-11-14', 'ghf', '5', 11, 7676.00, 1, 1, 0, '2013-11-25 11:40:35', '0000-00-00 00:00:00'),
(83, 1, 'TXN-0000000024', '2013-11-20', 'ghfh', '10', 18, 656.00, 1, 1, 0, '2013-11-25 11:46:17', '0000-00-00 00:00:00'),
(84, 1, 'TXN-0000000025', '2013-11-28', 'fgfdg', 'inv1', 18, 5665.00, 1, 5, 0, '2013-11-25 11:48:40', '2013-11-25 12:27:16'),
(85, 1, 'TXN-0000000026', '2013-11-21', 'gnngnvbn', '5', 18, 78.00, 1, 1, 0, '2013-11-25 12:19:18', '0000-00-00 00:00:00'),
(86, 1, 'TXN-0000000027', '2013-11-08', 'kjkjhk', '5', 11, 878.00, 1, 1, 0, '2013-11-25 12:20:56', '0000-00-00 00:00:00'),
(87, 1, 'TXN-0000000028', '2013-11-21', 'fhdgh', '5', 11, 87.00, 1, 1, 0, '2013-11-25 12:22:01', '0000-00-00 00:00:00'),
(88, 1, 'TXN-0000000029', '2013-11-20', 'gfdg', '5', 11, 656.00, 1, 1, 0, '2013-11-25 12:30:26', '0000-00-00 00:00:00'),
(89, 1, 'TXN-0000000030', '2013-11-27', 'hghfj', '5', 11, 7676.00, 1, 1, 0, '2013-11-25 12:32:46', '0000-00-00 00:00:00'),
(90, 1, 'TXN-0000000031', '2013-11-27', 'gjfhj', '5', 11, 767.00, 1, 1, 0, '2013-11-25 12:33:19', '0000-00-00 00:00:00'),
(91, 1, 'TXN-0000000032', '2013-11-22', 'hgfh', '5', 19, 5656.00, 1, 1, 0, '2013-11-25 12:37:01', '0000-00-00 00:00:00'),
(92, 1, 'TXN-0000000033', '2013-11-22', 'hgfh', '5', 19, 5656.00, 1, 1, 0, '2013-11-25 12:37:07', '0000-00-00 00:00:00'),
(93, 1, 'TXN-0000000034', '2013-10-31', 'hgh', '5', 18, 656.00, 1, 1, 0, '2013-11-25 12:38:44', '0000-00-00 00:00:00'),
(94, 1, 'TXN-0000000035', '2013-10-31', 'hgh', '5', 18, 656.00, 1, 1, 0, '2013-11-25 12:39:01', '0000-00-00 00:00:00'),
(95, 1, 'TXN-0000000036', '2013-11-14', 'hgfh', '5', 18, 767.00, 1, 1, 0, '2013-11-25 12:39:13', '0000-00-00 00:00:00'),
(96, 1, 'TXN-0000000037', '2013-11-13', 'hgfh', '5', 11, 766.00, 1, 1, 0, '2013-11-25 12:39:44', '0000-00-00 00:00:00'),
(97, 1, 'TXN-0000000038', '2013-11-15', 'hghf', '12', 19, 67.00, 1, 1, 0, '2013-11-25 12:40:34', '0000-00-00 00:00:00'),
(98, 1, 'TXN-0000000039', '2013-11-09', 'hghfg', '5', 18, 76.00, 1, 1, 0, '2013-11-25 12:43:01', '0000-00-00 00:00:00'),
(99, 1, 'TXN-0000000040', '2013-11-09', 'hghfgh', '5', 11, 677.00, 1, 1, 0, '2013-11-25 12:43:34', '0000-00-00 00:00:00'),
(100, 1, 'TXN-0000000041', '2013-11-07', 'ghfh', '5', 17, 56.00, 1, 1, 0, '2013-11-25 12:44:05', '0000-00-00 00:00:00'),
(101, 1, 'TXN-0000000042', '2013-11-09', 'hgh', '5', 19, 6.00, 1, 1, 0, '2013-11-25 12:44:44', '0000-00-00 00:00:00'),
(102, 1, 'TXN-0000000043', '2013-11-08', 'gdhg', '5', 17, 7679.00, 1, 1, 0, '2013-11-25 13:18:54', '0000-00-00 00:00:00'),
(103, 1, 'TXN-0000000044', '2013-11-20', 'testing', '4', 17, 96.00, 1, 1, 0, '2013-11-25 13:19:53', '0000-00-00 00:00:00'),
(104, 1, 'TXN-0000000045', '2013-11-15', 'hghjhgjh', '5', 19, 87.00, 1, 1, 0, '2013-11-25 13:21:25', '0000-00-00 00:00:00'),
(105, 1, 'TXN-0000000046', '2013-11-15', 'jhjghj', '9', 19, 29.00, 1, 1, 1, '2013-11-25 13:25:09', '2013-11-25 13:25:12'),
(106, 1, 'TXN-0000000047', '2013-11-20', 'jhjgh jghjg', '12', 17, 10.00, 1, 1, 0, '2013-11-25 13:26:18', '0000-00-00 00:00:00'),
(107, 1, 'TXN-0000000048', '2013-11-16', 'hjjhj hjh', '4', 17, 123.00, 1, 1, 0, '2013-11-25 13:28:45', '0000-00-00 00:00:00'),
(108, 1, 'TXN-0000000049', '2013-11-21', 'jhjhg hjhg', '12', 19, 877.00, 1, 1, 0, '2013-11-25 13:29:26', '0000-00-00 00:00:00'),
(109, 1, 'TXN-0000000050', '2013-11-22', 'jkj', '5', 11, 787.00, 1, 1, 0, '2013-11-25 13:31:58', '0000-00-00 00:00:00'),
(110, 1, 'TXN-0000000051', '2013-11-01', 'hghfg', '12', 18, 67.00, 1, 1, 0, '2013-11-25 13:32:44', '0000-00-00 00:00:00'),
(111, 1, 'TXN-0000000052', '2013-11-06', 'hjghj', '5', 18, 76.00, 1, 1, 0, '2013-11-25 13:35:06', '2013-11-25 13:35:30'),
(112, 1, 'TXN-0000000053', '2013-11-21', 'nvbnvb', 'bill1', 17, 67.00, 2, 6, 0, '2013-11-25 13:35:16', '2013-11-25 13:35:25'),
(113, 1, 'TXN-0000000054', '2013-11-06', 'hgf', '5', 17, 676.00, 2, 1, 0, '2013-11-25 13:36:28', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE IF NOT EXISTS `vendor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` varchar(255) NOT NULL COMMENT 'Starts with VEN-0000000001',
  `fkaccount_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `state` varchar(60) NOT NULL,
  `city` varchar(60) NOT NULL,
  `country` varchar(10) NOT NULL,
  `website` varchar(60) NOT NULL,
  `zipcode` varchar(30) NOT NULL,
  `delete_status` int(11) NOT NULL DEFAULT '1' COMMENT '1- active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkaccount_id` (`fkaccount_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `vendor_id`, `fkaccount_id`, `name`, `email`, `first_name`, `last_name`, `phone`, `fax`, `address1`, `address2`, `state`, `city`, `country`, `website`, `zipcode`, `delete_status`, `date_created`, `date_modified`) VALUES
(1, 'VEN-0000000001', 1, 'UMM', '', '', '', '', '', '', '', '', '', '0', '', '', 1, '2013-11-16 12:08:13', '2013-11-20 13:11:31'),
(2, 'VEN-0000000002', 1, 'testings', 'test@gmail.com', '', '', '', '', '', '', '', '', '0', '', '', 1, '2013-11-18 16:44:38', '2013-11-19 03:09:22'),
(3, 'VEN-0000000003', 1, 'admin diva', 'demo@gmail.com', 'fgsfg', 'gfgdfg', '', '', '', '', 'ghg', 'hgfh', 'AG', 'www.umm.com', '', 2, '2013-11-19 03:10:54', '2013-11-19 03:13:01');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_transaction`
--

CREATE TABLE IF NOT EXISTS `vendor_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fktransaction_id` int(11) NOT NULL,
  `fkvendor_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fktransaction_id` (`fktransaction_id`,`fkvendor_id`),
  KEY `fkcustomer_id` (`fkvendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `vendor_transaction`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`fkaccount_id`) REFERENCES `company_details` (`id`),
  ADD CONSTRAINT `bill_ibfk_2` FOREIGN KEY (`fkvendor_id`) REFERENCES `vendor` (`id`);

--
-- Constraints for table `bill_transaction`
--
ALTER TABLE `bill_transaction`
  ADD CONSTRAINT `bill_transaction_ibfk_1` FOREIGN KEY (`fktransaction_id`) REFERENCES `transactions` (`id`),
  ADD CONSTRAINT `bill_transaction_ibfk_2` FOREIGN KEY (`fkbill_id`) REFERENCES `bill` (`id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`fkaccount_id`) REFERENCES `company_details` (`id`);

--
-- Constraints for table `customer_transaction`
--
ALTER TABLE `customer_transaction`
  ADD CONSTRAINT `customer_transaction_ibfk_1` FOREIGN KEY (`fktransaction_id`) REFERENCES `transactions` (`id`),
  ADD CONSTRAINT `customer_transaction_ibfk_2` FOREIGN KEY (`fkcustomer_id`) REFERENCES `customer` (`id`);

--
-- Constraints for table `default_system_accounts`
--
ALTER TABLE `default_system_accounts`
  ADD CONSTRAINT `default_system_accounts_ibfk_1` FOREIGN KEY (`fksys_id`) REFERENCES `system_accounts` (`id`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`fkaccount_id`) REFERENCES `company_details` (`id`),
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`fkcustomer_id`) REFERENCES `customer` (`id`);

--
-- Constraints for table `invoice_transaction`
--
ALTER TABLE `invoice_transaction`
  ADD CONSTRAINT `invoice_transaction_ibfk_1` FOREIGN KEY (`fktransaction_id`) REFERENCES `transactions` (`id`),
  ADD CONSTRAINT `invoice_transaction_ibfk_2` FOREIGN KEY (`fkinvoice_id`) REFERENCES `invoice` (`id`);

--
-- Constraints for table `split_transaction`
--
ALTER TABLE `split_transaction`
  ADD CONSTRAINT `split_transaction_ibfk_1` FOREIGN KEY (`fktransaction_id`) REFERENCES `transactions` (`id`);

--
-- Constraints for table `sub_accounts`
--
ALTER TABLE `sub_accounts`
  ADD CONSTRAINT `sub_accounts_ibfk_1` FOREIGN KEY (`fksys_id`) REFERENCES `system_accounts` (`id`),
  ADD CONSTRAINT `sub_accounts_ibfk_2` FOREIGN KEY (`fkaccount_id`) REFERENCES `company_details` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`fkaccount_id`) REFERENCES `company_details` (`id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`account`) REFERENCES `sub_accounts` (`id`);

--
-- Constraints for table `vendor`
--
ALTER TABLE `vendor`
  ADD CONSTRAINT `vendor_ibfk_1` FOREIGN KEY (`fkaccount_id`) REFERENCES `company_details` (`id`);

--
-- Constraints for table `vendor_transaction`
--
ALTER TABLE `vendor_transaction`
  ADD CONSTRAINT `vendor_transaction_ibfk_1` FOREIGN KEY (`fktransaction_id`) REFERENCES `transactions` (`id`),
  ADD CONSTRAINT `vendor_transaction_ibfk_2` FOREIGN KEY (`fkvendor_id`) REFERENCES `vendor` (`id`);
