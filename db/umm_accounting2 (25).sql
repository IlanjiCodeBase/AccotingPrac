-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 07, 2014 at 02:22 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `fkcompany_id`, `account_type`, `account_id`, `account_name`, `currency`, `pay_status`, `delete_status`, `date_created`, `date_modified`) VALUES
(20, 2, 1, 1, 'Cash in Hands', 'CRC', 1, 1, '2014-02-17 16:09:11', '2014-03-25 14:39:45'),
(21, 2, 1, 8, 'GIC & Term Deposits', 'SGD', 1, 1, '2014-02-17 18:00:23', '0000-00-00 00:00:00'),
(22, 2, 1, 56, 'Machinery', 'SGD', 1, 1, '2014-02-17 18:00:29', '0000-00-00 00:00:00'),
(23, 2, 3, 1, 'Agricultural Program Paymentse', 'SGD', 2, 1, '2014-02-18 10:40:51', '2014-02-18 11:39:43'),
(26, 2, 3, 2, 'Commodity Credit Loans', NULL, 2, 2, '2014-02-18 11:02:12', '2014-02-18 15:04:52'),
(27, 2, 1, 1, 'Cash in Hand', NULL, 1, 1, '2014-02-18 11:03:48', '2014-03-25 14:38:19'),
(28, 2, 2, 1, 'Bank Overdraft', 'SGD', 1, 1, '2014-02-18 12:20:13', '0000-00-00 00:00:00'),
(29, 2, 4, 154, 'Depreciation - Leasehold Land', NULL, 2, 1, '2014-02-18 14:44:24', '0000-00-00 00:00:00'),
(30, 2, 4, 155, 'Depreciation - Freehold Land', NULL, 2, 1, '2014-02-18 15:03:26', '0000-00-00 00:00:00'),
(31, 2, 3, 2, 'Commodity Credit Loans', NULL, 2, 1, '2014-02-18 15:05:15', '0000-00-00 00:00:00'),
(32, 2, 5, 1, 'Issued and Paid Ordinary Shares', 'SGD', 1, 1, '2014-02-18 15:14:27', '0000-00-00 00:00:00'),
(33, 2, 3, 83, 'Finance Charge Income', NULL, 2, 1, '2014-02-18 16:21:50', '0000-00-00 00:00:00'),
(34, 2, 2, 3, 'Bank Revolving Credit', 'BBD', 1, 1, '2014-02-18 20:57:34', '0000-00-00 00:00:00'),
(35, 2, 1, 6, 'Bank - Fixed Deposits', 'SAR', 1, 1, '2014-02-22 11:37:32', '2014-03-25 14:39:58'),
(36, 2, 1, 2, 'Petty Cash and pay', 'SGD', 1, 1, '2014-03-14 09:41:06', '0000-00-00 00:00:00'),
(37, 2, 3, 10, 'Sale of Work of Arts', 'AUD', 2, 1, '2014-03-14 20:39:38', '0000-00-00 00:00:00'),
(38, 2, 5, 11, 'Owners Cash Investment', 'SGD', 1, 1, '2014-03-14 20:45:50', '0000-00-00 00:00:00'),
(39, 2, 4, 1, 'Purchases of Raw Material', 'SGD', 2, 1, '2014-03-15 01:13:53', '2014-03-15 01:14:01'),
(40, 2, 1, 9, 'Leasehold Land', 'SGD', 1, 1, '2014-03-20 15:06:54', '0000-00-00 00:00:00'),
(41, 2, 3, 1, 'Agricultural Program Payments', 'AUD', 2, 1, '2014-03-25 14:18:37', '0000-00-00 00:00:00'),
(42, 2, 3, 84, 'Late Fees Collected', 'SGD', 2, 1, '2014-03-31 11:16:49', '2014-03-31 18:06:21'),
(43, 2, 4, 8, 'Restaurant Supplies', 'SGD', 2, 1, '2014-03-31 15:37:27', '0000-00-00 00:00:00'),
(44, 2, 1, 7, 'Other Bank Accounts', 'SGD', 1, 1, '2014-04-02 11:11:06', '2014-04-07 15:05:07'),
(49, 2, 1, 9, 'Certificate of Deposit', 'SGD', 1, 2, '2014-04-07 15:00:20', '2014-04-07 15:05:43');

-- --------------------------------------------------------

--
-- Table structure for table `accounting_entries`
--

CREATE TABLE IF NOT EXISTS `accounting_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkiei_id` int(11) NOT NULL,
  `account_entry_id` tinyint(2) NOT NULL COMMENT '1 - Account Receivables, 2 - Account Payables, 3 - Cash/Bank, 4 - GST Payables, 5 - Sales',
  `amount` decimal(11,2) NOT NULL,
  `entry_date` date NOT NULL,
  `entry_type` tinyint(2) NOT NULL COMMENT '1 - Income, 2 - Expense, 3 - Invoice, 4 - Credit',
  `entry_status` tinyint(2) NOT NULL COMMENT '1 - Debit, 2 - Credit',
  `expiry_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - Active, 2 - Expired',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkiei_id` (`fkiei_id`,`account_entry_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `accounting_entries`
--

INSERT INTO `accounting_entries` (`id`, `fkiei_id`, `account_entry_id`, `amount`, `entry_date`, `entry_type`, `entry_status`, `expiry_status`, `date_created`, `date_modified`) VALUES
(37, 1, 3, 3.00, '2014-02-19', 1, 1, 2, '2014-03-05 10:51:43', '2014-03-10 12:36:16'),
(38, 1, 1, 6.76, '2014-02-19', 1, 1, 2, '2014-03-05 10:51:43', '2014-03-10 12:36:16'),
(39, 1, 5, 6.32, '2014-02-19', 1, 2, 2, '2014-03-05 10:51:43', '2014-03-10 12:36:16'),
(40, 1, 4, 0.44, '2014-02-19', 1, 2, 2, '2014-03-05 10:51:43', '2014-03-10 12:36:16'),
(41, 2, 3, 4.25, '2013-02-19', 1, 1, 2, '2014-03-05 11:20:52', '2014-03-29 12:17:21'),
(42, 2, 1, 5.35, '2013-02-19', 1, 1, 2, '2014-03-05 11:20:52', '2014-03-29 12:17:21'),
(43, 2, 5, 5.00, '2013-02-19', 1, 2, 2, '2014-03-05 11:20:52', '2014-03-29 12:17:21'),
(44, 2, 4, 0.35, '2013-02-19', 1, 2, 2, '2014-03-05 11:20:52', '2014-03-29 12:17:21'),
(45, 1, 3, 19543.00, '2014-02-19', 3, 1, 1, '2014-03-05 12:45:33', '2014-03-18 10:17:23'),
(46, 1, 1, 105597.02, '2014-02-19', 3, 1, 1, '2014-03-05 12:45:33', '2014-03-18 10:17:23'),
(47, 1, 5, 100929.00, '2014-02-19', 3, 2, 1, '2014-03-05 12:45:33', '2014-03-18 10:17:23'),
(48, 1, 4, 4668.02, '2014-02-19', 3, 2, 1, '2014-03-05 12:45:33', '2014-03-18 10:17:23'),
(49, 1, 3, 320.00, '2014-02-19', 2, 2, 2, '2014-03-05 16:46:05', '2014-03-15 17:43:31'),
(50, 1, 2, 3004.28, '2014-02-19', 2, 2, 2, '2014-03-05 16:46:05', '2014-03-15 17:43:31'),
(56, 1, 1, 140.76, '2014-02-19', 4, 2, 1, '2014-03-10 18:53:16', '2014-03-15 17:50:46'),
(57, 1, 5, 136.00, '2014-02-19', 4, 1, 1, '2014-03-10 18:53:16', '2014-03-15 17:50:46'),
(58, 1, 4, 4.76, '2014-02-19', 4, 1, 1, '2014-03-10 18:53:16', '2014-03-15 17:50:46'),
(59, 3, 3, 6367.00, '2014-02-19', 1, 1, 2, '2014-03-14 18:09:20', '2014-03-14 18:09:23'),
(60, 3, 1, 58384940.55, '2014-02-19', 1, 1, 2, '2014-03-14 18:09:20', '2014-03-14 18:09:23'),
(61, 3, 5, 54565365.00, '2014-02-19', 1, 2, 2, '2014-03-14 18:09:20', '2014-03-14 18:09:23'),
(62, 3, 4, 3819575.55, '2014-02-19', 1, 2, 2, '2014-03-14 18:09:20', '2014-03-14 18:09:23'),
(63, 4, 1, 356.31, '2014-02-21', 1, 1, 1, '2014-03-14 18:09:37', '2014-04-02 13:08:02'),
(64, 4, 5, 333.00, '2014-02-21', 1, 2, 1, '2014-03-14 18:09:37', '2014-04-02 13:08:02'),
(65, 4, 4, 23.31, '2014-02-21', 1, 2, 1, '2014-03-14 18:09:37', '2014-04-02 13:08:02'),
(66, 6, 1, 6000.00, '2014-02-24', 1, 1, 2, '2014-03-14 18:12:13', '2014-03-15 15:55:42'),
(67, 6, 5, 6000.00, '2014-02-24', 1, 2, 2, '2014-03-14 18:12:14', '2014-03-15 15:55:42'),
(68, 6, 4, 0.00, '2014-02-24', 1, 2, 2, '2014-03-14 18:12:14', '2014-03-15 15:55:42'),
(69, 5, 1, 6000.00, '2014-02-22', 1, 1, 2, '2014-03-15 16:08:57', '2014-03-15 17:39:17'),
(70, 5, 5, 6000.00, '2014-02-22', 1, 2, 2, '2014-03-15 16:08:57', '2014-03-15 17:39:17'),
(71, 5, 4, 0.00, '2014-02-22', 1, 2, 2, '2014-03-15 16:08:57', '2014-03-15 17:39:17'),
(72, 5, 3, 300.00, '2014-02-22', 1, 1, 2, '2014-03-15 16:09:10', '2014-03-15 17:39:17'),
(73, 7, 3, 1000.00, '2014-03-15', 2, 2, 2, '2014-03-15 17:39:21', '2014-03-15 17:43:30'),
(74, 7, 2, 1062.00, '2014-03-15', 2, 2, 2, '2014-03-15 17:39:21', '2014-03-15 17:43:30'),
(75, 3, 3, 75632.00, '2014-03-15', 2, 2, 1, '2014-03-15 17:39:25', '2014-03-17 13:11:34'),
(76, 3, 2, 107000.00, '2014-03-15', 2, 2, 1, '2014-03-15 17:39:25', '2014-03-17 13:11:34'),
(77, 2, 3, 35759.26, '2014-02-19', 2, 2, 2, '2014-03-15 17:39:31', '2014-03-15 17:43:33'),
(78, 2, 2, 154759.26, '2014-02-19', 2, 2, 2, '2014-03-15 17:39:31', '2014-03-15 17:43:33'),
(79, 2, 1, 176523.02, '2014-02-19', 4, 2, 1, '2014-03-15 17:50:48', '0000-00-00 00:00:00'),
(80, 2, 5, 171715.00, '2014-02-19', 4, 1, 1, '2014-03-15 17:50:48', '0000-00-00 00:00:00'),
(81, 2, 4, 4808.02, '2014-02-19', 4, 1, 1, '2014-03-15 17:50:48', '0000-00-00 00:00:00'),
(82, 21, 1, 700.85, '2014-03-14', 1, 1, 2, '2014-03-18 12:31:55', '2014-03-18 12:31:58'),
(83, 21, 5, 655.00, '2014-03-14', 1, 2, 2, '2014-03-18 12:31:55', '2014-03-18 12:31:58'),
(84, 21, 4, 45.85, '2014-03-14', 1, 2, 2, '2014-03-18 12:31:55', '2014-03-18 12:31:58'),
(85, 26, 1, 321456.00, '2014-03-18', 1, 1, 1, '2014-03-18 12:32:00', '2014-04-03 17:17:55'),
(86, 26, 5, 321456.00, '2014-03-18', 1, 2, 1, '2014-03-18 12:32:00', '2014-04-03 17:17:55'),
(87, 26, 4, 0.00, '2014-03-18', 1, 2, 1, '2014-03-18 12:32:00', '2014-04-03 17:17:55'),
(88, 27, 1, 77878.00, '2014-03-21', 1, 1, 1, '2014-03-21 14:50:24', '0000-00-00 00:00:00'),
(89, 27, 5, 77878.00, '2014-03-21', 1, 2, 1, '2014-03-21 14:50:24', '0000-00-00 00:00:00'),
(90, 27, 4, 0.00, '2014-03-21', 1, 2, 1, '2014-03-21 14:50:24', '0000-00-00 00:00:00'),
(91, 30, 1, 0.00, '2014-03-28', 1, 1, 2, '2014-04-02 13:06:39', '2014-04-02 13:06:42'),
(92, 30, 5, 0.00, '2014-03-28', 1, 2, 2, '2014-04-02 13:06:39', '2014-04-02 13:06:42'),
(93, 30, 4, 0.00, '2014-03-28', 1, 2, 2, '2014-04-02 13:06:39', '2014-04-02 13:06:42'),
(94, 4, 1, 134338.00, '2014-03-18', 3, 1, 1, '2014-04-02 16:18:47', '2014-04-02 16:37:35'),
(95, 4, 5, 134338.00, '2014-03-18', 3, 2, 1, '2014-04-02 16:18:47', '2014-04-02 16:37:35'),
(96, 4, 4, 0.00, '2014-03-18', 3, 2, 1, '2014-04-02 16:18:48', '2014-04-02 16:37:35'),
(97, 25, 1, 4533.00, '2014-03-18', 1, 1, 1, '2014-04-02 18:03:50', '0000-00-00 00:00:00'),
(98, 25, 5, 4533.00, '2014-03-18', 1, 2, 1, '2014-04-02 18:03:50', '0000-00-00 00:00:00'),
(99, 25, 4, 0.00, '2014-03-18', 1, 2, 1, '2014-04-02 18:03:50', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE IF NOT EXISTS `audit_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL,
  `fkuser_id` int(11) NOT NULL,
  `event` tinyint(2) NOT NULL COMMENT '1 - Add, 2 - Edit, 3 - Delete, 4 - Active, 5 - Inactive, 6 - Verified, 7 - Unverified, 8 - Draft',
  `source` varchar(100) NOT NULL COMMENT '1 - Income, 2 - Expense,3 - Invoice, 4 - Credit, 5 - Jounal, 6 - Customer, 7 - Vendor, 8 - Account, 9 - Tax, 10 - Product, 11 - Payment',
  `name_number` varchar(255) NOT NULL,
  `reference` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fkuser_id` (`fkuser_id`),
  KEY `fkcompany_id` (`fkcompany_id`),
  KEY `reference` (`reference`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `fkcompany_id`, `fkuser_id`, `event`, `source`, `name_number`, `reference`, `timestamp`) VALUES
(1, 2, 2, 1, '8', 'Certificate of Deposit', 49, '2014-04-07 15:00:20'),
(2, 2, 2, 2, '8', 'Other Bank Accounts', 44, '2014-04-07 15:05:07'),
(3, 2, 2, 3, '8', 'Certificate of Deposit', 49, '2014-04-07 15:05:43'),
(4, 2, 2, 1, '10', 'gffdgfdgfd', 7, '2014-04-07 15:14:26'),
(5, 2, 2, 2, '10', 'Product-1', 1, '2014-04-07 15:14:50'),
(6, 2, 2, 3, '10', '÷Ý÷`}', 7, '2014-04-07 15:15:17'),
(7, 2, 2, 4, '9', 'jhgjhg', 6, '2014-04-07 15:23:56'),
(8, 2, 2, 1, '9', 'IST', 7, '2014-04-07 15:27:03'),
(9, 2, 2, 2, '9', 'IST', 7, '2014-04-07 15:27:14'),
(10, 2, 2, 3, '9', 'IST', 7, '2014-04-07 15:27:27'),
(11, 2, 2, 2, '6', 'Gfgdfgdf', 2, '2014-04-07 15:44:50'),
(12, 2, 2, 2, '7', 'Jhjhgjg', 1, '2014-04-07 15:45:05');

-- --------------------------------------------------------

--
-- Table structure for table `credit`
--

CREATE TABLE IF NOT EXISTS `credit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL,
  `credit_no` varchar(30) NOT NULL,
  `fkinvoice_id` int(11) DEFAULT NULL,
  `fkcustomer_id` int(11) DEFAULT NULL,
  `transaction_currency` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `memo` varchar(255) NOT NULL,
  `approval_for` int(11) NOT NULL DEFAULT '0',
  `credit_status` tinyint(2) NOT NULL COMMENT '1 - Approved, 2 - Unapproved, 3 - Draft',
  `sent_status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '1 - Sent, 2 - Not Sent',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `credit_no` (`credit_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkinvoice_id`,`fkcustomer_id`),
  KEY `fkinvoice_id` (`fkinvoice_id`,`fkcustomer_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `approval_for` (`approval_for`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `credit`
--

INSERT INTO `credit` (`id`, `fkcompany_id`, `credit_no`, `fkinvoice_id`, `fkcustomer_id`, `transaction_currency`, `date`, `memo`, `approval_for`, `credit_status`, `sent_status`, `date_created`, `date_modified`) VALUES
(1, 2, 'CR-0000000001', 1, 1, 'SGD', '2014-02-19', 'fjhgjhgjhgjhgj', 2, 1, 2, '2014-02-19 21:14:12', '2014-03-15 17:50:46'),
(2, 2, 'CR-0000000002', 1, 1, 'SGD', '2014-02-19', 'ghfhghfhgbgchgh', 2, 1, 2, '2014-02-19 21:15:47', '2014-03-15 17:50:48'),
(3, 2, 'CR-0000000003', 5, 1, 'INR', '2014-03-18', 'gfgfdgfd ggfdgdfg', 15, 2, 2, '2014-03-29 12:31:30', '0000-00-00 00:00:00'),
(4, 2, 'CR-0000000004', 1, 1, 'INR', '2014-02-19', 'fjhgjhgjhgjhgj', 2, 2, 2, '2014-03-31 10:40:11', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `credit_product_list`
--

CREATE TABLE IF NOT EXISTS `credit_product_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcredit_id` int(11) NOT NULL,
  `product_id` varchar(60) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(11,2) NOT NULL,
  `fktax_id` int(11) NOT NULL,
  `tax_value` decimal(6,2) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkexpense_id` (`fkcredit_id`),
  KEY `fktax_id` (`fktax_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `credit_product_list`
--

INSERT INTO `credit_product_list` (`id`, `fkcredit_id`, `product_id`, `product_description`, `quantity`, `unit_price`, `fktax_id`, `tax_value`, `date_created`, `date_modified`) VALUES
(1, 1, 'pd123', '1', 2, 34.00, 1, 7.00, '2014-02-19 21:14:12', '0000-00-00 00:00:00'),
(2, 1, 'pd123', '1', 1, 34.00, 0, 0.00, '2014-02-19 21:14:12', '0000-00-00 00:00:00'),
(3, 1, 'pd123', '1', 1, 34.00, 0, 0.00, '2014-02-19 21:14:12', '0000-00-00 00:00:00'),
(4, 2, 'pd123', '1', 2, 34343.00, 1, 7.00, '2014-02-19 21:15:47', '0000-00-00 00:00:00'),
(5, 2, 'pd123', '1', 1, 34343.00, 0, 0.00, '2014-02-19 21:15:47', '0000-00-00 00:00:00'),
(6, 2, 'pd123', '1', 1, 34343.00, 0, 0.00, '2014-02-19 21:15:47', '0000-00-00 00:00:00'),
(7, 2, 'pd123', '1', 1, 34343.00, 0, 0.00, '2014-02-19 21:16:03', '0000-00-00 00:00:00'),
(8, 3, 'pd123', '1', 2, 34343.00, 0, 0.00, '2014-03-29 12:31:30', '0000-00-00 00:00:00'),
(9, 3, 'fgfdgd', '3', 1, 65652.00, 1, 7.00, '2014-03-29 12:31:30', '0000-00-00 00:00:00'),
(10, 4, 'pd123', '1', 2, 34.00, 1, 7.00, '2014-03-31 10:40:11', '0000-00-00 00:00:00'),
(11, 4, 'pd123', '1', 1, 34.00, 0, 0.00, '2014-03-31 10:40:11', '0000-00-00 00:00:00'),
(12, 4, 'pd123', '1', 1, 34.00, 0, 0.00, '2014-03-31 10:40:11', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fkcompany_id`, `customer_id`, `customer_name`, `address1`, `address2`, `company_registration_no`, `office_number`, `fax_number`, `city`, `state`, `country`, `website`, `email`, `company_gst_no`, `postcode`, `gst_verified_date`, `delete_status`, `date_created`, `date_modified`) VALUES
(1, 2, 'CUS-0000000001', 'Test', 'kkjdkfdfk fgfgfg', '', 'test12345', '454545454', '', 'Chennai', 'Tamilnadu', 'TN', '', '', '', '56556', '0000-00-00', 1, '2014-02-19 16:45:26', '2014-04-02 12:24:00'),
(2, 2, 'CUS-0000000002', 'Gfgdfgdf', 'gfdfgdgfgdgfd', '', 'fgdgfdgdf', '5365365', '', 'Hgfhfgh', 'Hfghfh', 'CK', '', '', '', '54354', '0000-00-00', 1, '2014-02-19 16:46:48', '2014-04-07 15:44:50'),
(3, 2, 'CUS-0000000003', 'hghgfhgf', 'hgfhfghhgfhgf', '', 'hgfhfghfghfg', '5546565', '', 'jhjhgjhg', 'jhjhgj', 'AU', '', '', '', '656565', '0000-00-00', 2, '2014-03-13 17:09:34', '2014-03-13 17:09:43');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `customer_contact_person`
--

INSERT INTO `customer_contact_person` (`id`, `fkcustomer_id`, `contact_name`, `designation`, `contact_office_number`, `contact_mobile_number`, `contact_email`, `default_key_contact`, `contact_type`, `date_created`, `date_modified`) VALUES
(1, 3, 'jhgjghj', 'jhgjhgj', '', '', '', 1, 1, '2014-03-13 17:09:34', '0000-00-00 00:00:00'),
(2, 3, 'jhgjhgj', 'jhgjghjg', '', '', '', 1, 1, '2014-03-13 17:09:35', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `customer_shipping_address`
--

INSERT INTO `customer_shipping_address` (`id`, `fkcustomer_id`, `shipping_address1`, `shipping_address2`, `shipping_city`, `shipping_state`, `shipping_country`, `shipping_postcode`, `date_created`, `date_modified`) VALUES
(1, 1, 'gfgfgfg', '', 'Gfgfgfd', 'Gfdgd', 'AT', '455454', '2014-04-02 12:24:00', '2014-04-02 12:24:00');

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
  `fkvendor_id` int(11) DEFAULT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `credit_term` varchar(100) NOT NULL,
  `due_date` date NOT NULL,
  `transaction_currency` varchar(10) NOT NULL,
  `fkpayment_account` int(11) DEFAULT NULL,
  `discount_status` tinyint(2) NOT NULL COMMENT '1 - Yes, 2 - No',
  `discount_amount` decimal(11,2) NOT NULL,
  `permit_no` varchar(100) NOT NULL,
  `do_so_no` varchar(60) NOT NULL,
  `fkreceipt_id` varchar(255) DEFAULT NULL,
  `approval_for` int(11) NOT NULL DEFAULT '0',
  `transaction_status` tinyint(2) NOT NULL COMMENT '1 - Approved/Verified, 2 - Unverified, 3 - Draft',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_no` (`expense_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkvendor_id`),
  KEY `fkcustomer_id` (`fkvendor_id`),
  KEY `fkpayment_account` (`fkpayment_account`),
  KEY `approval_for` (`approval_for`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `expense_transaction`
--

INSERT INTO `expense_transaction` (`id`, `fkcompany_id`, `expense_no`, `date`, `receipt_no`, `fkvendor_id`, `shipping_address`, `credit_term`, `due_date`, `transaction_currency`, `fkpayment_account`, `discount_status`, `discount_amount`, `permit_no`, `do_so_no`, `fkreceipt_id`, `approval_for`, `transaction_status`, `date_created`, `date_modified`) VALUES
(1, 2, 'EXP-0000000001', '2014-02-19', 'jhgjhj', 1, '1', '3', '2014-03-06', 'SGD', 21, 2, 0.00, 'jhgjghjg', '', '', 2, 2, '2014-02-19 19:59:04', '2014-03-15 17:43:31'),
(2, 2, 'EXP-0000000002', '2014-02-19', 'tyrtrtyrt', 1, '1', '1', '2014-03-06', 'SGD', 21, 2, 0.00, 'yrtyrtytry', '', '', 2, 1, '2014-02-19 20:03:17', '2014-04-04 15:02:58'),
(3, 2, 'EXP-0000000003', '2014-03-15', 'ljkjkljklkj', 1, '1', '1', '2014-03-30', 'SGD', 20, 2, 0.00, 'fsfdsfsdf', '', '', 2, 1, '2014-03-15 11:58:28', '2014-03-17 13:11:34'),
(4, 2, 'EXP-0000000004', '2014-03-15', 'hgdhghgfh', 1, '1', '1', '2014-04-02', 'SGD', 20, 2, 0.00, 'hgfhgfhfg', '', '4_9763_4.pdf', 2, 2, '2014-03-15 12:04:59', '2014-03-18 10:28:52'),
(7, 2, 'EXP-0000000005', '2014-03-15', 'hghfghgfh', 1, '1', '1', '2014-03-30', 'SGD', 20, 2, 0.00, 'hghfghfgh', '', '', 2, 2, '2014-03-15 12:20:35', '2014-03-15 17:43:30'),
(8, 2, 'EXP-0000000006', '2014-03-15', 'fdasfdsafdsf', 1, '1', '3', '2014-05-15', 'SGD', 32, 2, 0.00, 'fdfdsfdsf', '', '', 15, 2, '2014-03-15 12:22:04', '0000-00-00 00:00:00'),
(9, 2, 'EXP-0000000007', '2014-03-15', '', NULL, '1', '1', '2014-03-30', 'SGD', NULL, 2, 0.00, '', '', NULL, 0, 3, '2014-03-15 12:23:30', '0000-00-00 00:00:00'),
(10, 2, 'EXP-0000000008', '2014-03-28', '', NULL, '1', '1', '2014-03-28', 'SGD', NULL, 2, 0.00, '', '', NULL, 0, 3, '2014-03-28 11:51:04', '0000-00-00 00:00:00'),
(11, 2, 'EXP-0000000009', '2014-03-28', '', NULL, '1', '1', '2014-03-28', 'SGD', NULL, 2, 0.00, '', '', '11_8884_expense.pdf', 0, 3, '2014-03-28 11:51:53', '0000-00-00 00:00:00'),
(12, 2, 'EXP-0000000010', '2014-03-15', 'fdasfdsafdsf', 1, '1', '3', '2014-05-15', 'SGD', 32, 2, 0.00, 'fdfdsfdsf', '', '12_9532_expense.pdf', 15, 2, '2014-03-28 11:53:07', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `expense_transaction_list`
--

CREATE TABLE IF NOT EXISTS `expense_transaction_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkexpense_id` int(11) NOT NULL,
  `fkexpense_type` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `expense_transaction_list`
--

INSERT INTO `expense_transaction_list` (`id`, `fkexpense_id`, `fkexpense_type`, `product_id`, `product_description`, `quantity`, `unit_price`, `fktax_id`, `tax_value`, `date_created`, `date_modified`) VALUES
(1, 1, 30, 'jhjgh', 'jhg', 2, 2.00, 1, 7.00, '2014-02-19 19:59:04', '0000-00-00 00:00:00'),
(2, 1, 29, 'jhjghjh', 'jhgjhg', 3, 1000.00, 0, 0.00, '2014-02-19 19:59:04', '0000-00-00 00:00:00'),
(3, 2, 29, 'hghfh', 'ghfgh', 2, 2009.00, 1, 7.00, '2014-02-19 20:03:17', '0000-00-00 00:00:00'),
(4, 2, 30, 'hgfhgf', 'hgfhgf', 3, 50000.00, 0, 0.00, '2014-02-19 20:03:17', '0000-00-00 00:00:00'),
(5, 2, 29, 'gfsg', 'gfdgd', 2, 230.00, 0, 0.00, '2014-02-19 20:05:50', '0000-00-00 00:00:00'),
(6, 3, 29, 'gdfgdfg', 'gfgdgfd', 2, 50000.00, 1, 7.00, '2014-03-15 11:58:28', '0000-00-00 00:00:00'),
(7, 4, 29, '', 'hghgfhgfhgf', 3, 333.00, 0, 0.00, '2014-03-15 12:04:59', '0000-00-00 00:00:00'),
(10, 7, 30, 'hghgf', 'hghfghgf', 3, 354.00, 0, 0.00, '2014-03-15 12:20:35', '0000-00-00 00:00:00'),
(11, 8, 39, 'fdfdsf', 'gdfgdf', 2, 3433.00, 0, 0.00, '2014-03-15 12:22:04', '0000-00-00 00:00:00'),
(12, 9, NULL, '', '', 0, 0.00, 0, 0.00, '2014-03-15 12:23:30', '0000-00-00 00:00:00'),
(13, 10, NULL, '', '', 0, 0.00, 0, 0.00, '2014-03-28 11:51:04', '0000-00-00 00:00:00'),
(14, 11, NULL, '', '', 0, 0.00, 0, 0.00, '2014-03-28 11:51:53', '0000-00-00 00:00:00'),
(15, 12, 39, 'fdfdsf', 'gdfgdf', 2, 3433.00, 0, 0.00, '2014-03-28 11:53:08', '0000-00-00 00:00:00');

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
  `fkcustomer_id` int(11) DEFAULT NULL,
  `fkpayment_account` int(11) DEFAULT NULL,
  `credit_term` varchar(100) NOT NULL,
  `transaction_currency` varchar(10) NOT NULL,
  `fkincome_type` int(11) NOT NULL DEFAULT '0',
  `transaction_description` varchar(255) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `fkreceipt_id` varchar(255) DEFAULT NULL,
  `fktax_id` int(11) NOT NULL,
  `tax_value` decimal(6,2) NOT NULL,
  `approval_for` int(11) NOT NULL DEFAULT '0',
  `transaction_status` tinyint(2) NOT NULL COMMENT '1 - Approved/Verified, 2 - Unverified & Saved, 3 - Draft',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_no` (`income_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkcustomer_id`,`fkpayment_account`,`fkincome_type`,`fktax_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `fktax_id` (`fktax_id`),
  KEY `fkpayment_account` (`fkpayment_account`),
  KEY `fkreceipt_id` (`fkreceipt_id`),
  KEY `approval_for` (`approval_for`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `income_transaction`
--

INSERT INTO `income_transaction` (`id`, `fkcompany_id`, `income_no`, `date`, `receipt_no`, `fkcustomer_id`, `fkpayment_account`, `credit_term`, `transaction_currency`, `fkincome_type`, `transaction_description`, `amount`, `fkreceipt_id`, `fktax_id`, `tax_value`, `approval_for`, `transaction_status`, `date_created`, `date_modified`) VALUES
(1, 2, 'INC-0000000001', '2014-02-19', 'jhjhjhgj', 1, 32, '3', 'SGD', 23, 'jhjghjghhjhjhgjg', 60.32, '', 1, 7.00, 2, 1, '2014-02-19 18:28:22', '2014-04-04 15:02:58'),
(2, 2, 'INC-0000000002', '2013-02-19', 'bnbnbvn', 2, 22, '3', 'SGD', 23, 'hgfhgfhfghfg', 35.00, '', 1, 7.00, 2, 2, '2014-02-19 18:29:03', '2014-03-29 12:17:21'),
(3, 2, 'INC-0000000003', '2014-02-19', 'hgghgfhgfh', 2, 32, '3', 'SGD', 23, 'hgfhgfhhghgfhfmnmbhg', 54565365.00, '', 1, 7.00, 2, 1, '2014-02-19 18:48:26', '2014-04-04 14:59:34'),
(4, 2, 'INC-0000000004', '2014-02-21', 'fsgfg', 1, 22, '3', 'SGD', 23, 'fgfdggfgffgfg', 333.00, '', 1, 7.00, 3, 1, '2014-02-21 15:15:52', '2014-04-02 13:08:02'),
(5, 2, 'INC-0000000005', '2014-02-22', 'dafdfdf', 1, 20, '1', 'SGD', 23, 'dfdfddfdfadd', 6000.00, '', 0, 0.00, 2, 2, '2014-02-22 15:17:28', '2014-03-15 17:39:17'),
(6, 2, 'INC-0000000006', '2014-02-24', 'gfdgdfgdf', 2, 20, '1', 'SGD', 23, 'gfdgfdgfdgfdg', 6000.00, '', 0, 0.00, 2, 1, '2014-02-24 11:43:52', '2014-04-04 15:00:11'),
(7, 2, 'INC-0000000007', '2014-02-24', 'testing', 1, 20, '1', 'SGD', 23, 'testing12345', 6000.00, '', 0, 0.00, 2, 2, '2014-02-24 11:55:12', '2014-03-10 12:36:41'),
(8, 2, 'INC-0000000008', '2014-02-24', 'fsdfdfsdf', 1, 20, '1', 'SGD', 23, 'sfdfdfdfsdf', 5000.00, '', 0, 0.00, 2, 2, '2014-02-24 11:55:52', '2014-03-10 12:36:45'),
(9, 2, 'INC-0000000009', '2014-02-24', 'dfdfdsfdsfds', 2, 20, '1', 'SGD', 23, 'klllllllllllllllklklk', 6000.00, '', 0, 0.00, 2, 1, '2014-02-24 11:57:03', '2014-04-04 14:59:34'),
(10, 2, 'INC-0000000010', '2014-02-24', 'gfgdfgdfg', 1, 20, '1', 'SGD', 23, 'gfddfgdfgfgfg', 8000.00, '', 0, 0.00, 2, 2, '2014-02-24 11:58:19', '0000-00-00 00:00:00'),
(11, 2, 'INC-0000000011', '2014-02-24', 'testers', 2, 20, '1', 'SGD', 23, 'fdfdfdfdfdfdfdfd', 25000.00, '', 0, 0.00, 2, 2, '2014-02-24 12:03:51', '0000-00-00 00:00:00'),
(12, 2, 'INC-0000000012', '2014-02-24', 'fhjjh', 1, 32, '3', 'SGD', 23, 'jhjgjhgfffghgfhgf', 6565.00, '', 0, 0.00, 2, 1, '2014-02-24 12:07:42', '2014-04-04 15:00:11'),
(13, 2, 'INC-0000000013', '2014-02-24', 'fdfsdfsdf', 1, 20, '1', 'SGD', 23, 'testin123dfdsf', 60000.00, '', 0, 0.00, 2, 2, '2014-02-24 12:47:32', '0000-00-00 00:00:00'),
(14, 2, 'INC-0000000014', '2014-02-24', 'gfgfdg', 1, 20, '1', 'SGD', 23, 'gfgfdgdfgfdgdf', 60500.00, '', 0, 0.00, 2, 2, '2014-02-24 13:21:55', '2014-03-10 12:36:23'),
(15, 2, 'INC-0000000015', '2014-02-24', 'testing123', 1, 20, '1', 'SGD', 23, 'testing demo', 652300.00, '', 0, 0.00, 2, 1, '2014-02-24 13:29:41', '2014-04-04 15:02:20'),
(16, 2, 'INC-0000000016', '2014-02-24', 'vdfdsfds', 1, 20, '1', 'SGD', 23, 'fdsfsdfsdf', 65000.00, '', 0, 0.00, 2, 2, '2014-02-24 14:49:54', '0000-00-00 00:00:00'),
(17, 2, 'INC-0000000017', '2014-02-24', 'fgfdgf', 1, 28, '3', 'SGD', 23, 'dfgdfgfdgdfg', 963000.00, '', 0, 0.00, 2, 2, '2014-02-24 14:55:42', '0000-00-00 00:00:00'),
(18, 2, 'INC-0000000018', '2014-02-26', 'dfdsfdsf', 1, 32, '3', 'SGD', 23, 'dfsdfdsfgfdgdfgdfg', 656546.00, '', 0, 0.00, 2, 2, '2014-02-26 18:16:20', '0000-00-00 00:00:00'),
(19, 2, 'INC-0000000019', '2014-02-26', 'kjjkkh', 2, 22, '3', 'SGD', 31, 'jkjhjhkhkjhj', 868.00, '', 0, 0.00, 2, 2, '2014-02-26 18:29:47', '2014-03-10 12:36:32'),
(20, 2, 'INC-0000000020', '2014-02-28', 'sdfgfsdgfk;k;', 2, 21, '3', 'INR', 31, 'gfdfgdfgpl;kl;kl;', 3000.00, '', 0, 0.00, 2, 2, '2014-02-28 12:31:07', '2014-03-10 12:36:27'),
(21, 2, 'INC-0000000021', '2014-03-14', 'hgfhgfhgfh', 2, 22, '3', 'SGD', 23, 'hgfhfghgfhfg', 655.00, '', 1, 7.00, 15, 2, '2014-03-14 15:57:06', '2014-03-18 12:31:58'),
(22, 2, 'INC-0000000022', '2014-03-14', '', NULL, 20, '1', 'SGD', 23, '', 0.00, NULL, 0, 0.00, 0, 3, '2014-03-14 17:50:52', '0000-00-00 00:00:00'),
(23, 2, 'INC-0000000023', '2014-03-14', '', NULL, 20, '1', 'SGD', 23, '', 0.00, NULL, 0, 0.00, 0, 3, '2014-03-14 17:53:40', '0000-00-00 00:00:00'),
(24, 2, 'INC-0000000024', '2014-03-18', 'fdsfgsfsdf', 2, 22, '3', 'SGD', 23, 'fgdsgfdgfdgdfcdasf', 56200.00, '24_5439_24.pdf', 1, 7.00, 2, 2, '2014-03-18 10:23:39', '0000-00-00 00:00:00'),
(25, 2, 'INC-0000000025', '2014-03-18', 'gfdgfdgdfg', 1, 32, '3', 'SGD', 23, 'gfdgfdgfdgfgdfg', 4533.00, '', 0, 0.00, 16, 1, '2014-03-18 11:27:04', '2014-04-02 18:03:50'),
(26, 2, 'INC-0000000026', '2014-03-18', 'testddfd', 2, 32, '3', 'SGD', 23, 'fgfgfdgdfg', 321456.00, '', 0, 0.00, 4, 1, '2014-03-18 11:27:59', '2014-04-03 17:17:55'),
(27, 2, 'INC-0000000027', '2014-03-21', 'jgjhjjjjhhh', 1, 22, '3', 'SGD', 23, 'jjhjhjgjgjgjgj', 77878.00, '', 0, 0.00, 4, 1, '2014-03-21 14:50:23', '0000-00-00 00:00:00'),
(28, 2, 'INC-0000000028', '2014-03-28', '', 1, 20, '3', 'SGD', 23, '', 0.00, '', 0, 0.00, 0, 3, '2014-03-28 09:32:26', '0000-00-00 00:00:00'),
(29, 2, 'INC-0000000029', '2014-03-28', 'fdfd', 1, 20, '3', 'SGD', 23, '', 0.00, '29_19_income.pdf', 0, 0.00, 0, 3, '2014-03-28 11:05:47', '0000-00-00 00:00:00'),
(30, 2, 'INC-0000000030', '2014-03-28', 'fdfd', 1, 22, '3', 'SGD', 23, 'gfhhgfhfhfh', 0.00, '30_7437_income.pdf', 0, 0.00, 2, 2, '2014-03-28 11:36:40', '2014-04-02 13:06:42'),
(31, 2, 'INC-0000000031', '2014-04-02', '', NULL, NULL, '3', 'SGD', 41, '', 0.00, '', 0, 0.00, 15, 3, '2014-04-02 14:25:39', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in the master database',
  `invoice_no` varchar(30) NOT NULL COMMENT 'Invoice no format is INV-0000000001',
  `date` date NOT NULL,
  `fkcustomer_id` int(11) DEFAULT NULL,
  `fkshipping_address` int(11) NOT NULL,
  `credit_term` varchar(100) NOT NULL,
  `due_date` date NOT NULL,
  `transaction_currency` varchar(10) NOT NULL,
  `discount_status` tinyint(2) NOT NULL COMMENT '1 - Yes, 2 - No',
  `non_revenue_tax` tinyint(2) NOT NULL COMMENT '1 - Yes, 2 - No',
  `memo` varchar(255) NOT NULL,
  `do_so_no` varchar(60) NOT NULL,
  `approval_for` int(11) NOT NULL DEFAULT '0',
  `invoice_status` tinyint(2) NOT NULL COMMENT '1 - Approved, 2 - Unapproved, 3 - Draft',
  `sent_status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '1 - Sent, 2 - Not Sent',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_no` (`invoice_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkcustomer_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `approval_for` (`approval_for`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `fkcompany_id`, `invoice_no`, `date`, `fkcustomer_id`, `fkshipping_address`, `credit_term`, `due_date`, `transaction_currency`, `discount_status`, `non_revenue_tax`, `memo`, `do_so_no`, `approval_for`, `invoice_status`, `sent_status`, `date_created`, `date_modified`) VALUES
(1, 2, 'INV-0000000001', '2014-02-19', 1, 0, '1', '2014-03-06', 'SGD', 2, 2, '', '', 2, 1, 2, '2014-02-19 20:58:38', '2014-03-18 10:17:23'),
(2, 2, 'INV-0000000002', '2014-03-14', NULL, 0, '1', '2014-03-29', 'SGD', 2, 2, '', '', 0, 3, 2, '2014-03-14 20:07:36', '0000-00-00 00:00:00'),
(3, 2, 'INV-0000000003', '2014-03-14', NULL, 0, '1', '2014-03-29', 'SGD', 2, 2, '', '', 0, 3, 2, '2014-03-14 23:03:01', '0000-00-00 00:00:00'),
(4, 2, 'INV-0000000004', '2014-03-18', 1, 0, '1', '2014-04-02', 'SGD', 2, 2, '', '', 4, 1, 2, '2014-03-18 11:08:36', '2014-04-02 16:37:35'),
(5, 2, 'INV-0000000005', '2014-03-18', 1, 0, '1', '2014-04-02', 'SGD', 2, 2, '', '', 2, 1, 2, '2014-03-18 11:09:39', '0000-00-00 00:00:00'),
(6, 2, 'INV-0000000006', '2014-03-18', 1, 0, '1', '2014-04-02', 'SGD', 2, 2, '', '', 2, 2, 2, '2014-03-18 11:16:24', '2014-03-31 10:36:38'),
(7, 2, 'INVOICE-0000000007', '2014-03-18', NULL, 0, '3', '2014-05-17', 'INR', 2, 2, '', '', 0, 3, 2, '2014-03-18 18:35:28', '0000-00-00 00:00:00'),
(8, 2, 'INVO-0000000008', '2014-03-25', NULL, 0, '3', '2014-05-24', 'INR', 2, 2, '', '', 0, 3, 2, '2014-03-25 14:51:40', '0000-00-00 00:00:00'),
(9, 2, 'INVO-0000000009', '2014-03-25', NULL, 0, '3', '2014-05-24', 'INR', 2, 2, '', '', 0, 3, 2, '2014-03-25 15:24:27', '0000-00-00 00:00:00'),
(10, 2, 'INVO-0000000010', '2014-03-25', NULL, 0, '3', '2014-05-24', 'INR', 2, 2, '', '', 0, 3, 2, '2014-03-25 15:24:50', '0000-00-00 00:00:00'),
(12, 2, 'INV-0000000011', '2014-03-18', 1, 0, '1', '2014-04-02', 'SGD', 2, 2, '', '', 2, 1, 2, '2014-03-31 10:39:19', '2014-04-04 15:02:58');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_credit_note_customization`
--

CREATE TABLE IF NOT EXISTS `invoice_credit_note_customization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template` int(11) NOT NULL,
  `company_logo` varchar(255) NOT NULL,
  `display_logo` smallint(2) NOT NULL DEFAULT '2' COMMENT '1 - Display, 2 - Not Display',
  `invoice_prefix` varchar(60) NOT NULL,
  `invoice_next_running_number` int(11) NOT NULL,
  `default_credit_term` int(11) NOT NULL,
  `default_tax_code` int(11) NOT NULL,
  `default_currency` varchar(10) NOT NULL,
  `default_product_title` varchar(100) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `invoice_credit_note_customization`
--

INSERT INTO `invoice_credit_note_customization` (`id`, `template`, `company_logo`, `display_logo`, `invoice_prefix`, `invoice_next_running_number`, `default_credit_term`, `default_tax_code`, `default_currency`, `default_product_title`, `date_created`, `date_modified`) VALUES
(1, 2, 'logo2.png', 2, 'INV', 0, 3, 1, 'INR', '3', '2014-03-18 15:11:08', '2014-03-31 09:54:45');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `invoice_product_list`
--

INSERT INTO `invoice_product_list` (`id`, `fkinvoice_id`, `product_id`, `product_description`, `quantity`, `unit_price`, `discount_amount`, `fktax_id`, `tax_value`, `date_created`, `date_modified`) VALUES
(1, 1, 'pd123', '1', 2, 34343.00, 2000.00, 1, 7.00, '2014-02-19 20:58:38', '0000-00-00 00:00:00'),
(2, 1, 'pd123', '1', 1, 34343.00, 100.00, 0, 0.00, '2014-02-19 20:59:04', '0000-00-00 00:00:00'),
(3, 2, '', '', 0, 0.00, 0.00, 0, 0.00, '2014-03-14 20:07:36', '0000-00-00 00:00:00'),
(4, 3, '', '', 0, 0.00, 0.00, 0, 0.00, '2014-03-14 23:03:01', '0000-00-00 00:00:00'),
(5, 4, 'pd123', '1', 2, 34343.00, 0.00, 0, 0.00, '2014-03-18 11:08:36', '0000-00-00 00:00:00'),
(6, 4, 'fgfdgd', '3', 1, 65652.00, 0.00, 0, 0.00, '2014-03-18 11:08:36', '0000-00-00 00:00:00'),
(7, 5, 'pd123', '1', 2, 34343.00, 0.00, 0, 0.00, '2014-03-18 11:09:39', '0000-00-00 00:00:00'),
(8, 5, 'fgfdgd', '3', 1, 65652.00, 0.00, 1, 7.00, '2014-03-18 11:09:39', '0000-00-00 00:00:00'),
(9, 6, 'fgfdgd', '3', 2, 65652.00, 0.00, 0, 0.00, '2014-03-18 11:16:24', '0000-00-00 00:00:00'),
(10, 6, 'pd123', '1', 1, 34343.00, 0.00, 1, 7.00, '2014-03-18 11:16:24', '0000-00-00 00:00:00'),
(11, 7, '', '', 0, 0.00, 0.00, 0, 0.00, '2014-03-18 18:35:28', '0000-00-00 00:00:00'),
(12, 8, '', '', 0, 0.00, 0.00, 1, 7.00, '2014-03-25 14:51:40', '0000-00-00 00:00:00'),
(13, 9, 'gdfgdfg', '2', 0, 54543.00, 0.00, 1, 7.00, '2014-03-25 15:24:27', '0000-00-00 00:00:00'),
(14, 10, '', '', 33, 0.00, 89.00, 1, 7.00, '2014-03-25 15:24:50', '0000-00-00 00:00:00'),
(17, 12, 'pd123', '1', 2, 34343.00, 0.00, 0, 0.00, '2014-03-31 10:39:19', '0000-00-00 00:00:00'),
(18, 12, 'fgfdgd', '3', 1, 65652.00, 0.00, 1, 7.00, '2014-03-31 10:39:19', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `journal_entries`
--

CREATE TABLE IF NOT EXISTS `journal_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL,
  `journal_no` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `description` tinytext NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `approval_for` int(11) NOT NULL DEFAULT '0',
  `journal_status` tinyint(2) NOT NULL COMMENT '1 - Approved, 2 - Unapproved, 3 - Draft',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `journal_no` (`journal_no`),
  KEY `fkcompany_id` (`fkcompany_id`),
  KEY `approval_for` (`approval_for`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `journal_entries`
--

INSERT INTO `journal_entries` (`id`, `fkcompany_id`, `journal_no`, `date`, `description`, `attachment`, `approval_for`, `journal_status`, `date_created`, `date_modified`) VALUES
(1, 2, 'JEN-0000000001', '2014-02-20', 'bfbvccvbgfdgfdgfdgd''s', '1_9913_journal.pdf', 2, 2, '2014-02-20 01:55:34', '2014-03-28 12:08:52'),
(2, 2, 'JEN-0000000002', '2014-03-14', 'gfgfdgfdgfd', '', 2, 1, '2014-03-14 20:28:30', '2014-03-18 10:18:20'),
(4, 2, 'JEN-0000000003', '2014-03-28', '', '', 0, 3, '2014-03-28 12:08:32', '2014-03-28 12:14:00'),
(5, 2, 'JEN-0000000004', '2014-02-20', 'bfbvccvbgfdgfdgfdgd''s', '31_9832_income.pdf', 2, 1, '2014-03-28 12:09:09', '2014-04-04 15:02:58'),
(7, 2, 'JEN-0000000005', '2014-03-14', 'gfgfdgfdgfd', '7_4888_journal.pdf', 2, 2, '2014-03-28 12:15:23', '2014-03-28 12:15:41');

-- --------------------------------------------------------

--
-- Table structure for table `journal_entries_list`
--

CREATE TABLE IF NOT EXISTS `journal_entries_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkjournal_id` int(11) NOT NULL,
  `fkaccount_id` int(11) DEFAULT NULL,
  `journal_description` tinytext NOT NULL,
  `debit` decimal(11,2) NOT NULL,
  `credit` decimal(11,2) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkjournal_id` (`fkjournal_id`,`fkaccount_id`),
  KEY `fkaccount_id` (`fkaccount_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `journal_entries_list`
--

INSERT INTO `journal_entries_list` (`id`, `fkjournal_id`, `fkaccount_id`, `journal_description`, `debit`, `credit`, `date_created`, `date_modified`) VALUES
(1, 1, 21, 'bvcb', 3000.00, 1000.00, '2014-02-20 01:55:34', '0000-00-00 00:00:00'),
(2, 1, 31, 'gfgfdgf', 3002.00, 5002.00, '2014-02-20 01:55:34', '0000-00-00 00:00:00'),
(3, 1, 31, 'fdggf', 300.00, 300.00, '2014-02-20 01:57:33', '0000-00-00 00:00:00'),
(4, 2, 20, '4334gfgdfgdfg', 43.00, 43.00, '2014-03-14 20:28:30', '0000-00-00 00:00:00'),
(6, 4, NULL, '', 0.00, 0.00, '2014-03-28 12:08:32', '0000-00-00 00:00:00'),
(7, 5, 21, 'bvcb', 3000.00, 1000.00, '2014-03-28 12:09:09', '0000-00-00 00:00:00'),
(8, 5, 31, 'gfgfdgf', 3002.00, 5002.00, '2014-03-28 12:09:09', '0000-00-00 00:00:00'),
(9, 5, 31, 'fdggf', 300.00, 300.00, '2014-03-28 12:09:09', '0000-00-00 00:00:00'),
(11, 7, 20, '4334gfgdfgdfg', 43.00, 43.00, '2014-03-28 12:15:23', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `discount_status`, `discount_amount`, `payment_description`, `payment_status`, `date_created`, `date_modified`, `fkiei_id`, `date`, `fkpayment_account`, `payment_amount`, `payment_method`, `cheque_draft_no`) VALUES
(2, 2, 0.00, '', 1, '2014-02-22 17:46:47', '0000-00-00 00:00:00', 3, '2014-02-22', 32, 767.00, 1, ''),
(3, 2, 0.00, '', 1, '2014-02-22 17:49:23', '2014-02-24 16:03:10', 3, '2014-02-22', 32, 300.00, 2, ''),
(5, 2, 0.00, '', 1, '2014-02-24 11:35:48', '0000-00-00 00:00:00', 2, '2014-02-24', 22, 2.00, 2, ''),
(6, 2, 0.00, '', 1, '2014-02-24 11:40:58', '0000-00-00 00:00:00', 2, '2014-02-24', 22, 2.00, 2, ''),
(7, 2, 0.00, '', 1, '2014-02-24 14:49:54', '0000-00-00 00:00:00', 16, '0000-00-00', 20, 10000.00, 2, ''),
(8, 2, 0.00, '', 1, '2014-02-24 14:51:15', '0000-00-00 00:00:00', 16, '2014-02-24', 20, 5000.00, 2, ''),
(9, 2, 0.00, '', 1, '2014-02-24 14:55:42', '0000-00-00 00:00:00', 17, '0000-00-00', 28, 963000.00, 0, ''),
(11, 2, 0.00, '', 2, '2014-02-24 16:05:40', '0000-00-00 00:00:00', 1, '2014-02-24', 21, 20.00, 2, ''),
(13, 2, 0.00, '', 2, '2014-02-24 16:06:14', '0000-00-00 00:00:00', 2, '2014-02-24', 21, 35759.26, 3, ''),
(14, 2, 0.00, '', 1, '2014-02-26 18:16:20', '0000-00-00 00:00:00', 18, '0000-00-00', 32, 0.00, 0, ''),
(15, 2, 0.00, '', 1, '2014-02-27 10:24:55', '2014-02-27 10:25:42', 3, '2014-02-27', 32, 300.00, 3, ''),
(16, 2, 0.00, '', 3, '2014-02-27 14:13:08', '2014-03-15 13:15:29', 1, '2014-01-09', 21, 5000.00, 2, ''),
(17, 2, 0.00, '', 1, '2014-03-05 10:41:27', '0000-00-00 00:00:00', 1, '2014-03-05', 32, 3.00, 1, ''),
(18, 2, 0.00, '', 1, '2014-03-05 11:59:45', '0000-00-00 00:00:00', 2, '2014-03-05', 22, 0.25, 3, ''),
(20, 2, 0.00, '', 2, '2014-03-11 13:15:05', '0000-00-00 00:00:00', 1, '2014-03-11', 21, 300.00, 1, ''),
(21, 2, 0.00, '', 1, '2014-03-14 17:50:52', '0000-00-00 00:00:00', 22, '0000-00-00', 20, 0.00, 0, ''),
(22, 2, 0.00, '', 1, '2014-03-14 17:53:40', '0000-00-00 00:00:00', 23, '0000-00-00', 20, 0.00, 0, ''),
(23, 2, 0.00, '', 2, '2014-03-15 12:20:35', '2014-03-15 12:45:47', 7, '1970-01-01', 20, 1000.00, 2, ''),
(24, 2, 0.00, '', 2, '2014-03-15 12:23:30', '0000-00-00 00:00:00', 9, '0000-00-00', 20, 0.00, 0, ''),
(25, 2, 0.00, '', 1, '2014-03-15 13:01:17', '2014-03-15 13:14:54', 3, '2014-03-15', 32, 1000.00, 2, ''),
(26, 2, 0.00, '', 2, '2014-03-15 13:04:57', '2014-03-15 13:15:13', 3, '1970-01-01', 20, 75632.00, 1, ''),
(27, 2, 0.00, '', 3, '2014-03-15 13:08:29', '0000-00-00 00:00:00', 1, '2014-03-15', 20, 6543.00, 4, ''),
(28, 2, 0.00, '', 3, '2014-03-15 16:00:46', '0000-00-00 00:00:00', 1, '2014-03-15', 36, 2000.00, 2, ''),
(29, 2, 0.00, '', 3, '2014-03-15 16:03:49', '0000-00-00 00:00:00', 1, '2013-03-01', 22, 6000.00, 1, ''),
(30, 2, 0.00, '', 1, '2014-03-15 16:09:10', '0000-00-00 00:00:00', 5, '2013-12-05', 20, 300.00, 3, ''),
(31, 2, 0.00, '', 3, '2014-03-18 11:16:24', '0000-00-00 00:00:00', 6, '0000-00-00', 20, 6523.00, 2, '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `fkcompany_id`, `product_id`, `description`, `price`, `currency`, `fkincomeaccount_id`, `date_created`, `date_modified`) VALUES
(1, 'Product-1', 2, 'pd123s', 'testing solution', 34343.00, 'CAD', 31, '2014-02-19 16:50:52', '2014-04-07 15:14:50'),
(2, 'gfgfdgfd', 2, 'gdfgdfg', 'hgdgdfgfdgfdgdfg', 54543.00, 'COP', 31, '2014-03-14 21:19:08', '0000-00-00 00:00:00'),
(3, 'Gdfgd', 2, 'fgfdgd', 'gfgdfgfdgfdfdsf', 65652.00, 'CNY', 23, '2014-03-14 21:31:57', '2014-03-14 21:35:08'),
(4, 'fdsffdsfs', 2, 'fdfsds', 'dfsdfsdfdsfs', 653212.00, 'CNY', 31, '2014-03-14 21:35:29', '0000-00-00 00:00:00'),
(6, 'Hkhhkh', 2, 'khkh', 'gkkujhkhkhjk', 998.00, 'CAD', 33, '2014-03-31 16:31:37', '2014-04-02 11:11:40');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `receipt_uploads`
--


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
  `tax_type` varchar(255) NOT NULL,
  `tax_status` int(2) NOT NULL DEFAULT '2' COMMENT '1 - active, 2 - inactive',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkcompany_id` (`fkcompany_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `taxcodes`
--

INSERT INTO `taxcodes` (`id`, `fkcompany_id`, `tax_code`, `tax_percentage`, `description`, `tax_type`, `tax_status`, `date_created`, `date_modified`) VALUES
(1, 2, 'GST', 7.00, 'Goods and services Goods and servicesGoods and servicesGoods and servicesGoods and servicesGoods and servicesGoods and servicesGoods and servicesGoods and servicesGoods and servicesGoods and servicesGoods and servicesGoods and servicesGoods and servicesG', 'Goods and services', 1, '2014-02-19 15:05:29', '2014-02-19 15:10:26'),
(2, 2, 'GSTS', 3.00, 'gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd gfdgdfgfdgd', 'gfdgdfgfdgd', 2, '2014-02-19 15:07:09', '0000-00-00 00:00:00'),
(3, 2, 'fghfgh', 65.00, 'hgfh  jhgjhgj kjhkj jkllj ;lk', 'ghfhfgh', 2, '2014-02-19 16:11:15', '2014-02-19 16:11:33'),
(5, 2, 'khjkhkh', 78.00, 'khjkh lkjljk jkljl', 'hkhkh', 2, '2014-02-19 16:11:45', '0000-00-00 00:00:00'),
(6, 2, 'jhgjhg', 7.00, 'jjjjjjjj jjjjjjjjjj', 'hjh jh ghjgh', 1, '2014-04-02 11:12:06', '2014-04-07 15:23:56');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `fkcompany_id`, `vendor_id`, `vendor_name`, `address1`, `address2`, `company_registration_no`, `office_number`, `fax_number`, `city`, `state`, `country`, `website`, `email`, `company_gst_no`, `postcode`, `gst_verified_date`, `delete_status`, `date_created`, `date_modified`) VALUES
(1, 2, 'VEN-0000000001', 'Jhjhgjg', 'jhgjghjjhgjghj', '', 'hjhg', '7667657', '', 'Jhgjhgj', 'Jhgjjh', 'DZ', '', '', '', '67676', '0000-00-00', 1, '2014-02-19 19:58:09', '2014-04-07 15:45:04');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `credit`
--
ALTER TABLE `credit`
  ADD CONSTRAINT `credit_ibfk_1` FOREIGN KEY (`fkinvoice_id`) REFERENCES `invoice` (`id`),
  ADD CONSTRAINT `credit_ibfk_2` FOREIGN KEY (`fkcustomer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `credit_product_list`
--
ALTER TABLE `credit_product_list`
  ADD CONSTRAINT `credit_product_list_ibfk_2` FOREIGN KEY (`fkcredit_id`) REFERENCES `credit` (`id`);

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
  ADD CONSTRAINT `expense_transaction_list_ibfk_1` FOREIGN KEY (`fkexpense_id`) REFERENCES `expense_transaction` (`id`);

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
  ADD CONSTRAINT `invoice_product_list_ibfk_1` FOREIGN KEY (`fkinvoice_id`) REFERENCES `invoice` (`id`);

--
-- Constraints for table `journal_entries_list`
--
ALTER TABLE `journal_entries_list`
  ADD CONSTRAINT `journal_entries_list_ibfk_1` FOREIGN KEY (`fkjournal_id`) REFERENCES `journal_entries` (`id`),
  ADD CONSTRAINT `journal_entries_list_ibfk_2` FOREIGN KEY (`fkaccount_id`) REFERENCES `account` (`id`);

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
