-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 26, 2014 at 12:12 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ummtech1_accounting_24`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_type` int(2) NOT NULL COMMENT '1 - Assets, 2 - Liabilities, 3 - Income, 4 - Expenses, 5 - Equity',
  `level1` int(11) NOT NULL,
  `level2` int(11) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `debit_opening_balance` decimal(11,2) NOT NULL,
  `credit_opening_balance` decimal(11,2) NOT NULL,
  `pay_status` int(2) NOT NULL COMMENT '1 - Payment Account, 2 - Normal Account',
  `edit_status` int(11) NOT NULL COMMENT '1 - Edit, 2 - Non-Editable',
  `delete_status` int(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `account_type`, `level1`, `level2`, `account_name`, `currency`, `debit_opening_balance`, `credit_opening_balance`, `pay_status`, `edit_status`, `delete_status`, `date_created`, `date_modified`) VALUES
(1, 2, 1, 0, 'Unrealised Foreign Exchange Gain / (Loss)', NULL, 0.00, 0.00, 0, 2, 1, '2014-05-15 17:11:08', '2014-06-13 20:40:35'),
(2, 4, 0, 0, 'Foreign Exchange Gain/(Loss)', NULL, 0.00, 950.00, 0, 2, 1, '2014-05-15 17:11:08', '2014-06-13 20:40:35'),
(3, 1, 1, 4, 'Trade Receivables', NULL, 321.00, 0.00, 0, 2, 1, '2014-05-15 17:11:08', '2014-06-13 20:40:35'),
(4, 1, 1, 5, 'Account Receivables - Others', NULL, 0.00, 654.00, 0, 2, 1, '2014-05-15 17:11:08', '2014-06-13 20:40:35'),
(5, 2, 1, 3, 'Trade Creditors', NULL, 0.00, 0.00, 0, 2, 1, '2014-05-15 17:11:08', '2014-06-13 20:40:35'),
(6, 2, 1, 8, 'Account Payables - Others', NULL, 0.00, 2350.00, 0, 2, 1, '2014-05-15 17:11:08', '2014-06-13 20:40:35'),
(7, 3, 1, 0, 'Discounts Given', NULL, 0.00, 23.00, 0, 2, 1, '2014-05-15 17:11:08', '2014-06-13 20:40:35'),
(8, 4, 1, 0, 'Discounts Received', NULL, 25.00, 0.00, 0, 2, 1, '2014-05-15 17:11:08', '2014-06-13 20:40:35'),
(9, 5, 4, 1, 'Retained Earnings', NULL, 0.00, 50.00, 0, 2, 1, '2014-05-15 17:11:08', '2014-06-13 20:40:35'),
(10, 5, 4, 1, 'Current Year Earnings', NULL, 1350.00, 0.00, 0, 2, 1, '2014-05-15 17:11:08', '2014-06-13 20:40:35'),
(11, 2, 1, 4, 'Sales Tax Payables', NULL, 0.00, 0.00, 2, 2, 1, '2014-06-03 09:58:30', '2014-06-13 20:40:35'),
(12, 4, 3, 8, 'Income Tax', NULL, 250.00, 0.00, 2, 2, 1, '2014-06-03 09:58:30', '2014-06-13 20:40:35'),
(14, 3, 1, 1, 'Agricultural Program Paymentss', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-05-16 11:33:01', '2014-06-13 20:40:35'),
(15, 1, 1, 2, 'GIC & Term Deposits', 'SGD', 6.00, 0.00, 2, 1, 1, '2014-05-16 11:32:48', '2014-06-13 20:40:35'),
(17, 1, 1, 2, 'Brokerage Account', 'SGD', 0.00, 0.00, 2, 1, 2, '2014-05-16 14:37:57', '2014-05-16 14:38:17'),
(36, 1, 1, 1, 'Current Account - DBS', 'SGD', 0.00, 150.00, 2, 1, 1, '2014-05-16 18:52:21', '2014-06-13 20:40:35'),
(39, 1, 1, 1, 'Other Bank Accountsss', 'SGD', 150.00, 0.00, 2, 1, 1, '2014-05-17 12:25:23', '2014-06-13 20:40:35'),
(44, 1, 1, 5, 'gfgff', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-05-19 17:52:53', '2014-06-13 20:40:35'),
(45, 1, 1, 5, 'sss', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-05-19 17:59:18', '2014-06-13 20:40:35'),
(46, 1, 1, 5, 'gfgfdgf', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-05-20 13:21:47', '2014-06-13 20:40:35'),
(47, 2, 1, 8, 'fgfgf', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-05-20 20:10:30', '2014-06-13 20:40:35'),
(48, 2, 1, 8, 'test', 'SGD', 120.00, 0.00, 2, 1, 1, '2014-05-20 20:28:24', '2014-06-13 20:40:35'),
(49, 4, 1, 1, 'Purchases of Products', 'SGD', 0.00, 1545.00, 2, 1, 1, '2014-05-21 14:34:11', '2014-06-13 20:40:35'),
(50, 3, 2, 1, 'Finance Charge Income', 'SGD', 3500.00, 0.00, 2, 1, 1, '2014-05-26 10:33:02', '2014-06-13 20:40:35'),
(53, 1, 1, 5, 'other coa', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-05-29 18:47:19', '2014-06-13 20:40:35'),
(54, 1, 1, 5, 'aass', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-05-29 19:10:44', '2014-06-13 20:40:35'),
(57, 1, 1, 5, 'osfdfsd', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-05-29 19:38:59', '2014-06-13 20:40:35'),
(58, 2, 1, 8, 'testvend', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-05-29 19:49:06', '2014-06-13 20:40:35'),
(59, 2, 1, 8, 'dsdsds', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-05-29 20:01:33', '2014-06-13 20:40:35'),
(60, 1, 1, 1, 'Current Accounts - DBS', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-05-31 10:33:10', '2014-06-13 20:40:35'),
(61, 1, 1, 1, 'Other Bank Accounts', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-05-31 10:33:11', '2014-06-13 20:40:35'),
(62, 1, 2, 1, 'Leasehold Land', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-06-24 10:28:16', '0000-00-00 00:00:00'),
(63, 1, 2, 5, 'Construction In Progress', 'SGD', 0.00, 0.00, 2, 1, 1, '2014-06-24 10:28:22', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `accounting_entries`
--

INSERT INTO `accounting_entries` (`id`, `fkiei_id`, `account_entry_id`, `amount`, `entry_date`, `entry_type`, `entry_status`, `expiry_status`, `date_created`, `date_modified`) VALUES
(1, 1, 3, 3200.00, '2014-05-20', 1, 1, 1, '2014-05-20 17:55:33', '2014-05-31 18:13:49'),
(2, 1, 1, 3274.20, '2014-05-20', 1, 1, 1, '2014-05-20 17:55:33', '2014-05-31 18:13:49'),
(3, 1, 5, 3210.00, '2014-05-20', 1, 2, 1, '2014-05-20 17:55:33', '2014-05-31 18:13:50'),
(4, 1, 4, 64.20, '2014-05-20', 1, 2, 1, '2014-05-20 17:55:33', '2014-05-31 18:13:50'),
(5, 6, 3, 49.00, '2014-05-21', 2, 2, 1, '2014-05-21 17:06:04', '2014-06-10 16:22:49'),
(6, 6, 2, 2597.92, '2014-05-21', 2, 2, 1, '2014-05-21 17:06:04', '2014-06-10 16:22:49'),
(7, 8, 2, 2597.92, '2014-05-21', 2, 2, 1, '2014-05-27 14:21:57', '2014-06-05 14:17:25'),
(8, 2, 3, 365.00, '2014-05-22', 3, 1, 1, '2014-05-31 11:27:07', '2014-06-03 19:23:43'),
(9, 2, 1, 6619.80, '2014-05-22', 3, 1, 1, '2014-05-31 11:27:07', '2014-06-03 19:23:43'),
(10, 2, 5, 6490.00, '2014-05-22', 3, 2, 1, '2014-05-31 11:27:07', '2014-06-03 19:23:43'),
(11, 2, 4, 129.80, '2014-05-22', 3, 2, 1, '2014-05-31 11:27:07', '2014-06-03 19:23:43'),
(12, 2, 1, 2346.00, '2014-05-20', 1, 1, 1, '2014-06-03 13:06:01', '2014-06-05 14:00:01'),
(13, 2, 5, 2300.00, '2014-05-20', 1, 2, 1, '2014-06-03 13:06:01', '2014-06-05 14:00:01'),
(14, 2, 4, 46.00, '2014-05-20', 1, 2, 1, '2014-06-03 13:06:01', '2014-06-05 14:00:01'),
(15, 6, 3, 4500.00, '2014-05-21', 1, 1, 1, '2014-06-03 13:16:23', '2014-06-13 23:27:05'),
(16, 6, 1, 4645.08, '2014-05-21', 1, 1, 1, '2014-06-03 13:16:23', '2014-06-13 23:27:05'),
(17, 6, 5, 4554.00, '2014-05-21', 1, 2, 1, '2014-06-03 13:16:23', '2014-06-13 23:27:05'),
(18, 6, 4, 91.08, '2014-05-21', 1, 2, 1, '2014-06-03 13:16:23', '2014-06-13 23:27:05'),
(19, 2, 1, 39088.00, '2014-05-22', 4, 2, 1, '2014-06-03 15:06:28', '0000-00-00 00:00:00'),
(20, 2, 5, 38960.00, '2014-05-22', 4, 1, 1, '2014-06-03 15:06:28', '0000-00-00 00:00:00'),
(21, 2, 4, 128.00, '2014-05-22', 4, 1, 1, '2014-06-03 15:06:28', '0000-00-00 00:00:00'),
(22, 8, 3, 68.00, '2014-05-21', 2, 2, 1, '2014-06-03 15:34:25', '2014-06-05 14:17:25'),
(23, 2, 3, 35.00, '2014-05-20', 1, 1, 1, '2014-06-04 17:53:22', '2014-06-05 14:00:01'),
(24, 3, 3, 1300.00, '2014-05-22', 3, 1, 1, '2014-06-04 18:11:25', '2014-06-05 14:17:07'),
(25, 3, 1, 65120.00, '2014-05-22', 3, 1, 1, '2014-06-04 18:11:25', '2014-06-05 14:17:07'),
(26, 3, 5, 65120.00, '2014-05-22', 3, 2, 1, '2014-06-04 18:11:25', '2014-06-05 14:17:07'),
(27, 3, 4, 0.00, '2014-05-22', 3, 2, 1, '2014-06-04 18:11:25', '2014-06-05 14:17:07'),
(28, 7, 3, 656.00, '2014-06-12', 3, 1, 1, '2014-06-13 11:30:15', '0000-00-00 00:00:00'),
(29, 7, 1, 65120.00, '2014-06-12', 3, 1, 1, '2014-06-13 11:30:15', '0000-00-00 00:00:00'),
(30, 7, 5, 65120.00, '2014-06-12', 3, 2, 1, '2014-06-13 11:30:15', '0000-00-00 00:00:00'),
(31, 7, 4, 0.00, '2014-06-12', 3, 2, 1, '2014-06-13 11:30:15', '0000-00-00 00:00:00'),
(32, 3, 3, 40454.00, '2014-05-21', 2, 2, 1, '2014-06-14 11:44:48', '2014-06-14 11:52:16'),
(33, 3, 2, 249925.50, '2014-05-21', 2, 2, 1, '2014-06-14 11:44:48', '2014-06-14 11:52:16'),
(34, 11, 2, 9545.72, '2014-06-24', 2, 2, 1, '2014-06-24 10:49:16', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE IF NOT EXISTS `audit_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL,
  `fkuser_id` int(11) NOT NULL,
  `event` tinyint(2) NOT NULL COMMENT '1 - Add, 2 - Edit, 3 - Delete, 4 - Active, 5 - Inactive, 6 - Verified, 7 - Unverified, 8 - Draft, 9 - Activity',
  `source` varchar(100) NOT NULL COMMENT '1 - Income, 2 - Expense,3 - Invoice, 4 - Credit, 5 - Jounal, 6 - Customer, 7 - Vendor, 8 - Account, 9 - Tax, 10 - Product, 11 - Payment, 12 - Logged In, 13- Logged Out',
  `name_number` varchar(255) NOT NULL,
  `reference` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fkuser_id` (`fkuser_id`),
  KEY `fkcompany_id` (`fkcompany_id`),
  KEY `reference` (`reference`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=324 ;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `fkcompany_id`, `fkuser_id`, `event`, `source`, `name_number`, `reference`, `timestamp`) VALUES
(1, 24, 4, 1, '8', 'GIC & Term Deposits', 11, '2014-05-16 11:32:48'),
(2, 24, 4, 1, '8', 'Agricultural Program Payments', 12, '2014-05-16 11:33:01'),
(3, 24, 4, 1, '8', 'GIC & Term Deposits', 13, '2014-05-16 12:01:12'),
(4, 24, 4, 1, '8', 'GIC & Term Deposits', 14, '2014-05-16 12:13:18'),
(5, 24, 4, 1, '8', 'GIC & Term Deposits', 15, '2014-05-16 12:16:40'),
(6, 24, 4, 1, '8', 'GIC & Term Deposits', 16, '2014-05-16 12:17:52'),
(7, 24, 4, 2, '8', 'Agricultural Program Payments', 12, '2014-05-16 14:37:38'),
(8, 24, 4, 2, '8', 'Agricultural Program Paymentss', 12, '2014-05-16 14:37:45'),
(9, 24, 4, 1, '8', 'Brokerage Account', 17, '2014-05-16 14:37:57'),
(10, 24, 4, 2, '8', 'Brokerage Account', 17, '2014-05-16 14:38:01'),
(11, 24, 4, 3, '8', 'Brokerage Account', 17, '2014-05-16 14:38:17'),
(12, 24, 4, 2, '8', 'Trade Receivables', 3, '2014-05-16 15:54:57'),
(13, 24, 4, 2, '8', 'Trade Receivables', 3, '2014-05-16 15:56:08'),
(14, 24, 4, 2, '8', 'GIC & Term Deposits', 11, '2014-05-16 15:56:25'),
(15, 24, 4, 2, '8', 'Discounts', 7, '2014-05-16 16:04:16'),
(16, 24, 4, 1, '8', 'Current Account - DBS', 18, '2014-05-16 17:46:26'),
(17, 24, 4, 1, '8', 'Other Bank Account', 19, '2014-05-16 17:46:27'),
(18, 24, 4, 1, '8', 'Current Account - DBS', 20, '2014-05-16 18:08:50'),
(19, 24, 4, 1, '8', 'Other Bank Account', 21, '2014-05-16 18:08:50'),
(20, 24, 4, 1, '8', 'Current Account - DBS', 22, '2014-05-16 18:11:11'),
(21, 24, 4, 1, '8', 'Other Bank Account', 23, '2014-05-16 18:11:11'),
(22, 24, 4, 1, '8', 'Other Bank Accountss', 24, '2014-05-16 18:11:47'),
(23, 24, 4, 1, '8', 'Other Bank Accountss', 25, '2014-05-16 18:14:12'),
(24, 24, 4, 1, '8', 'Other Bank Accountss', 26, '2014-05-16 18:19:18'),
(25, 24, 4, 1, '8', 'Other Bank Accountss', 27, '2014-05-16 18:20:40'),
(26, 24, 4, 1, '8', 'Other Bank Accountss', 28, '2014-05-16 18:22:19'),
(27, 24, 4, 1, '8', 'Other Bank Accountss', 29, '2014-05-16 18:23:37'),
(28, 24, 4, 1, '8', 'Other Bank Accountss', 30, '2014-05-16 18:25:07'),
(29, 24, 4, 1, '8', 'Other Bank Accountss', 31, '2014-05-16 18:25:47'),
(30, 24, 4, 1, '8', 'Current Account - DBS', 32, '2014-05-16 18:47:14'),
(31, 24, 4, 1, '8', 'Other Bank Accountsss', 33, '2014-05-16 18:47:14'),
(32, 24, 4, 1, '8', 'Current Account - DBS', 34, '2014-05-16 18:50:49'),
(33, 24, 4, 1, '8', 'Other Bank Accountsss', 35, '2014-05-16 18:50:49'),
(34, 24, 4, 1, '8', 'Current Account - DBS', 36, '2014-05-16 18:52:21'),
(35, 24, 4, 1, '8', 'Other Bank Accountsss', 37, '2014-05-16 18:52:21'),
(36, 24, 4, 1, '8', 'Other Bank Accountsss', 38, '2014-05-17 12:11:06'),
(37, 24, 4, 1, '8', 'Other Bank Accountsss', 39, '2014-05-17 12:25:23'),
(38, 24, 4, 1, '6', 'fdsdfdsf', 2, '2014-05-19 17:53:09'),
(39, 24, 4, 1, '6', 'hghfhgfh', 3, '2014-05-19 18:24:21'),
(40, 24, 4, 2, '6', 'Hghfhgfh', 3, '2014-05-19 18:40:45'),
(41, 24, 4, 2, '6', 'Hghfhgfh', 3, '2014-05-20 12:50:39'),
(42, 24, 4, 2, '6', 'Hghfhgfh', 3, '2014-05-20 12:50:49'),
(43, 24, 4, 2, '6', 'Hghfhgfh', 3, '2014-05-20 12:53:24'),
(44, 24, 4, 1, '9', '1', 1, '2014-05-20 13:40:17'),
(45, 24, 4, 1, '9', '5', 2, '2014-05-20 13:40:27'),
(46, 24, 4, 1, '9', '2', 3, '2014-05-20 13:40:37'),
(47, 24, 4, 4, '9', '2', 3, '2014-05-20 13:40:38'),
(48, 24, 4, 4, '9', '5', 2, '2014-05-20 13:40:40'),
(49, 24, 4, 1, '9', '5', 4, '2014-05-20 13:40:49'),
(50, 24, 4, 1, '1', 'Income', 1, '2014-05-20 13:54:29'),
(51, 24, 4, 2, '6', 'Hghfhgfh', 3, '2014-05-20 14:04:15'),
(52, 24, 4, 1, '1', 'Income', 2, '2014-05-20 17:36:27'),
(53, 24, 4, 1, '11', 'Income', 1, '2014-05-20 17:55:18'),
(54, 24, 4, 6, '1', 'Income', 1, '2014-05-20 17:55:33'),
(55, 24, 4, 1, '11', 'Income', 1, '2014-05-20 17:55:41'),
(56, 24, 4, 7, '1', 'Income', 1, '2014-05-20 17:55:59'),
(57, 24, 4, 6, '1', 'Income', 1, '2014-05-20 17:56:01'),
(58, 24, 4, 8, '1', 'Income', 3, '2014-05-20 18:18:01'),
(59, 24, 4, 8, '1', 'Income', 4, '2014-05-20 18:21:00'),
(60, 24, 4, 3, '1', 'Income', 4, '2014-05-20 18:21:09'),
(61, 24, 4, 8, '1', 'Income', 5, '2014-05-20 18:23:28'),
(62, 24, 4, 3, '1', 'Income', 3, '2014-05-20 18:23:38'),
(63, 24, 4, 7, '1', 'Income', 1, '2014-05-20 18:28:10'),
(64, 24, 4, 2, '11', 'Income', 1, '2014-05-20 18:58:07'),
(65, 24, 4, 6, '1', 'Income', 1, '2014-05-20 18:58:30'),
(66, 24, 4, 1, '10', 'SGD Product', 1, '2014-05-20 19:29:32'),
(67, 24, 4, 1, '10', 'INR Product', 2, '2014-05-20 19:30:15'),
(68, 24, 4, 1, '7', 'dsdsd', 2, '2014-05-20 20:14:20'),
(69, 24, 4, 2, '7', 'Dsdsd', 2, '2014-05-20 20:28:29'),
(70, 24, 4, 1, '1', 'Income', 6, '2014-05-21 12:45:56'),
(71, 24, 4, 1, '1', 'Income', 7, '2014-05-21 12:54:43'),
(72, 24, 4, 1, '1', 'Income', 10, '2014-05-21 13:27:46'),
(73, 24, 4, 1, '8', 'Purchases of Products', 49, '2014-05-21 14:34:11'),
(74, 24, 4, 1, '2', 'Expense', 1, '2014-05-21 15:07:13'),
(75, 24, 4, 1, '2', 'Expense', 2, '2014-05-21 15:14:32'),
(76, 24, 4, 1, '2', 'Expense', 3, '2014-05-21 15:34:42'),
(77, 24, 4, 1, '2', 'Expense', 4, '2014-05-21 15:36:13'),
(78, 24, 4, 1, '2', 'Expense', 5, '2014-05-21 16:07:35'),
(79, 24, 4, 1, '2', 'Expense', 6, '2014-05-21 16:11:02'),
(80, 24, 4, 1, '11', 'Expense', 6, '2014-05-21 17:05:56'),
(81, 24, 4, 6, '2', 'Expense', 6, '2014-05-21 17:06:04'),
(82, 24, 4, 7, '2', 'Expense', 6, '2014-05-21 17:53:39'),
(83, 24, 4, 2, '2', 'Expense', 6, '2014-05-21 17:56:23'),
(84, 24, 4, 2, '11', 'Expense', 6, '2014-05-21 17:57:38'),
(85, 24, 4, 8, '2', 'Expense', 7, '2014-05-21 18:41:41'),
(86, 24, 4, 8, '2', 'Expense', 1, '2014-05-21 18:41:56'),
(87, 24, 4, 1, '2', 'Expense', 8, '2014-05-21 18:42:22'),
(88, 24, 4, 1, '3', 'Invoice', 1, '2014-05-22 15:59:58'),
(89, 24, 4, 1, '3', 'Invoice', 2, '2014-05-22 16:24:56'),
(90, 24, 4, 1, '3', 'Invoice', 3, '2014-05-22 16:25:23'),
(91, 24, 4, 1, '3', 'Invoice', 4, '2014-05-22 16:31:56'),
(92, 24, 4, 1, '3', 'Invoice', 5, '2014-05-22 16:40:17'),
(93, 24, 4, 1, '3', 'Invoice', 6, '2014-05-22 16:43:51'),
(94, 24, 4, 1, '3', 'Invoice', 3, '2014-05-23 11:31:57'),
(95, 24, 4, 1, '3', 'Invoice', 3, '2014-05-23 11:32:06'),
(96, 24, 4, 1, '11', 'Invoice', 2, '2014-05-23 15:53:15'),
(97, 24, 4, 1, '1', 'Income', 11, '2014-05-23 15:54:30'),
(98, 24, 4, 2, '10', 'SGD Product', 1, '2014-05-24 15:26:49'),
(99, 24, 4, 1, '8', 'Finance Charge Income', 50, '2014-05-26 10:33:02'),
(100, 24, 4, 1, '10', 'test product', 3, '2014-05-26 10:33:28'),
(101, 24, 4, 1, '3', 'Invoice', 5, '2014-05-26 10:38:39'),
(102, 24, 4, 1, '4', 'Credit Note', 1, '2014-05-26 14:59:53'),
(103, 24, 4, 1, '4', 'Credit Note', 2, '2014-05-26 15:31:01'),
(104, 24, 4, 1, '4', 'Credit Note', 3, '2014-05-26 17:15:16'),
(105, 24, 4, 1, '4', 'Credit Note', 4, '2014-05-26 17:20:38'),
(106, 24, 4, 3, '4', 'Credit Note', 4, '2014-05-26 17:21:15'),
(107, 24, 4, 2, '4', 'Credit Note', 2, '2014-05-26 19:08:06'),
(108, 24, 4, 6, '2', 'Expense', 8, '2014-05-27 14:21:57'),
(109, 24, 4, 1, '11', 'Invoice', 5, '2014-05-27 18:21:29'),
(110, 24, 4, 1, '11', 'Invoice', 5, '2014-05-27 18:21:41'),
(111, 24, 4, 2, '6', 'Hghfhgfh', 3, '2014-05-27 22:55:39'),
(112, 24, 4, 1, '3', 'Invoice', 4, '2014-05-27 22:56:31'),
(113, 24, 4, 1, '1', 'Income', 12, '2014-05-28 11:37:44'),
(114, 24, 4, 1, '1', 'Income', 13, '2014-05-28 11:41:38'),
(115, 24, 4, 1, '1', 'Income', 14, '2014-05-28 11:46:45'),
(116, 24, 4, 2, '1', 'Income', 13, '2014-05-28 11:48:42'),
(117, 24, 4, 2, '2', 'Expense', 4, '2014-05-28 11:58:18'),
(118, 24, 26, 9, '12', 'Logged In', 2, '2014-05-28 15:47:20'),
(119, 24, 26, 9, '13', 'Logged Out', 2, '2014-05-28 17:05:12'),
(120, 24, 26, 9, '12', 'Logged In', 2, '2014-05-28 17:08:27'),
(121, 24, 26, 9, '13', 'Logged Out', 2, '2014-05-28 17:08:32'),
(122, 24, 4, 1, '6', 'gddfgdf', 4, '2014-05-29 19:02:48'),
(123, 24, 4, 2, '6', 'Hghfhgfh', 3, '2014-05-29 19:36:52'),
(124, 24, 4, 2, '6', 'Hghfhgfh', 3, '2014-05-29 19:36:54'),
(125, 24, 4, 2, '6', 'Gddfgdf', 4, '2014-05-29 19:39:04'),
(126, 24, 4, 2, '6', 'Hghfhgfh', 3, '2014-05-29 19:39:10'),
(127, 24, 4, 2, '6', 'Hghfhgfh', 3, '2014-05-29 19:39:12'),
(128, 24, 4, 1, '7', 'fdsfsdf', 3, '2014-05-29 19:49:30'),
(129, 24, 4, 2, '7', 'Dsdsd', 2, '2014-05-29 20:01:19'),
(130, 24, 4, 2, '7', 'Dsdsd', 2, '2014-05-29 20:01:21'),
(131, 24, 4, 2, '7', 'Fdsfsdf', 3, '2014-05-29 20:01:37'),
(132, 24, 4, 2, '6', 'Hghfhgfh', 3, '2014-05-29 21:00:41'),
(133, 24, 4, 2, '11', 'Invoice', 2, '2014-05-29 23:14:37'),
(134, 24, 26, 9, '12', 'Logged In', 2, '2014-05-30 17:51:57'),
(135, 24, 26, 9, '13', 'Logged Out', 2, '2014-05-30 18:04:40'),
(136, 24, 4, 1, '8', 'Current Accounts - DBS', 60, '2014-05-31 10:33:10'),
(137, 24, 4, 1, '8', 'Other Bank Accounts', 61, '2014-05-31 10:33:11'),
(138, 24, 4, 1, '8', 'IN 01', 62, '2014-05-31 11:18:01'),
(139, 24, 4, 1, '8', 'IN 02', 63, '2014-05-31 11:18:01'),
(140, 24, 4, 1, '8', 'IN 03', 64, '2014-05-31 11:18:01'),
(141, 24, 4, 1, '8', 'IN 04', 65, '2014-05-31 11:18:01'),
(142, 24, 4, 1, '8', 'IN 05', 66, '2014-05-31 11:18:01'),
(143, 24, 4, 1, '8', 'IN 06', 67, '2014-05-31 11:18:01'),
(144, 24, 4, 1, '8', 'IN 07', 68, '2014-05-31 11:18:01'),
(145, 24, 4, 1, '8', 'IN 08', 69, '2014-05-31 11:18:01'),
(146, 24, 4, 1, '8', 'IN 09', 70, '2014-05-31 11:18:01'),
(147, 24, 4, 1, '8', 'IN 10', 71, '2014-05-31 11:18:01'),
(148, 24, 4, 1, '8', 'IN 11', 72, '2014-05-31 11:18:01'),
(149, 24, 4, 1, '8', 'IN 12', 73, '2014-05-31 11:18:01'),
(150, 24, 4, 1, '8', 'IN 13', 74, '2014-05-31 11:18:01'),
(151, 24, 4, 1, '8', 'IN 14', 75, '2014-05-31 11:18:01'),
(152, 24, 4, 1, '8', 'IN 15', 76, '2014-05-31 11:18:01'),
(153, 24, 4, 1, '8', 'IN 16', 77, '2014-05-31 11:18:01'),
(154, 24, 4, 1, '8', 'IN 17', 78, '2014-05-31 11:18:01'),
(155, 24, 4, 1, '8', 'IN 18', 79, '2014-05-31 11:18:01'),
(156, 24, 4, 1, '8', 'IN 19', 80, '2014-05-31 11:18:02'),
(157, 24, 4, 1, '8', 'IN 20', 81, '2014-05-31 11:18:02'),
(158, 24, 4, 1, '8', 'IN 21', 82, '2014-05-31 11:18:02'),
(159, 24, 4, 1, '8', 'IN 22', 83, '2014-05-31 11:18:02'),
(160, 24, 4, 1, '8', 'IN 23', 84, '2014-05-31 11:18:02'),
(161, 24, 4, 1, '8', 'IN 24', 85, '2014-05-31 11:18:02'),
(162, 24, 4, 1, '8', 'IN 25', 86, '2014-05-31 11:18:02'),
(163, 24, 4, 1, '8', 'IN 26', 87, '2014-05-31 11:18:02'),
(164, 24, 4, 1, '8', 'IN 27', 88, '2014-05-31 11:18:02'),
(165, 24, 4, 1, '8', 'IN 28', 89, '2014-05-31 11:18:02'),
(166, 24, 4, 1, '8', 'IN 29', 90, '2014-05-31 11:18:02'),
(167, 24, 4, 1, '8', 'IN 30', 91, '2014-05-31 11:18:02'),
(168, 24, 4, 1, '8', 'IN 31', 92, '2014-05-31 11:18:02'),
(169, 24, 4, 1, '8', 'IN 32', 93, '2014-05-31 11:18:02'),
(170, 24, 4, 1, '8', 'IN 33', 94, '2014-05-31 11:18:02'),
(171, 24, 4, 1, '8', 'IN 34', 95, '2014-05-31 11:18:02'),
(172, 24, 4, 1, '8', 'IN 35', 96, '2014-05-31 11:18:02'),
(173, 24, 4, 1, '8', 'IN 36', 97, '2014-05-31 11:18:02'),
(174, 24, 4, 1, '8', 'IN 37', 98, '2014-05-31 11:18:03'),
(175, 24, 4, 1, '8', 'IN 38', 99, '2014-05-31 11:18:03'),
(176, 24, 4, 1, '8', 'IN 39', 100, '2014-05-31 11:18:03'),
(177, 24, 4, 1, '8', 'IN 40', 101, '2014-05-31 11:18:03'),
(178, 24, 4, 1, '8', 'IN 41', 102, '2014-05-31 11:18:03'),
(179, 24, 4, 1, '8', 'IN 42', 103, '2014-05-31 11:18:03'),
(180, 24, 4, 1, '8', 'IN 43', 104, '2014-05-31 11:18:03'),
(181, 24, 4, 1, '8', 'IN 44', 105, '2014-05-31 11:18:03'),
(182, 24, 4, 1, '8', 'IN 45', 106, '2014-05-31 11:18:03'),
(183, 24, 4, 1, '8', 'IN 46', 107, '2014-05-31 11:18:03'),
(184, 24, 4, 1, '8', 'IN 47', 108, '2014-05-31 11:18:03'),
(185, 24, 4, 1, '8', 'IN 48', 109, '2014-05-31 11:18:03'),
(186, 24, 4, 1, '8', 'IN 49', 110, '2014-05-31 11:18:03'),
(187, 24, 4, 1, '8', 'IN 50', 111, '2014-05-31 11:18:03'),
(188, 24, 4, 1, '8', 'IN 51', 112, '2014-05-31 11:18:03'),
(189, 24, 4, 1, '8', 'IN 52', 113, '2014-05-31 11:18:03'),
(190, 24, 4, 1, '8', 'IN 53', 114, '2014-05-31 11:18:03'),
(191, 24, 4, 1, '8', 'IN 54', 115, '2014-05-31 11:18:03'),
(192, 24, 4, 1, '8', 'IN 55', 116, '2014-05-31 11:18:03'),
(193, 24, 4, 1, '8', 'IN 56', 117, '2014-05-31 11:18:03'),
(194, 24, 4, 1, '8', 'IN 57', 118, '2014-05-31 11:18:04'),
(195, 24, 4, 1, '8', 'IN 58', 119, '2014-05-31 11:18:04'),
(196, 24, 4, 1, '8', 'IN 59', 120, '2014-05-31 11:18:04'),
(197, 24, 4, 1, '8', 'IN 60', 121, '2014-05-31 11:18:04'),
(198, 24, 4, 1, '8', 'IN 61', 122, '2014-05-31 11:18:04'),
(199, 24, 4, 1, '8', 'IN 62', 123, '2014-05-31 11:18:04'),
(200, 24, 4, 1, '8', 'IN 63', 124, '2014-05-31 11:18:04'),
(201, 24, 4, 1, '8', 'IN 64', 125, '2014-05-31 11:18:04'),
(202, 24, 4, 1, '8', 'IN 65', 126, '2014-05-31 11:18:04'),
(203, 24, 4, 1, '8', 'IN 66', 127, '2014-05-31 11:18:04'),
(204, 24, 4, 1, '8', 'IN 67', 128, '2014-05-31 11:18:04'),
(205, 24, 4, 1, '8', 'IN 68', 129, '2014-05-31 11:18:04'),
(206, 24, 4, 1, '8', 'IN 69', 130, '2014-05-31 11:18:04'),
(207, 24, 4, 1, '8', 'IN 70', 131, '2014-05-31 11:18:04'),
(208, 24, 4, 1, '8', 'IN 71', 132, '2014-05-31 11:18:04'),
(209, 24, 4, 1, '8', 'IN 72', 133, '2014-05-31 11:18:04'),
(210, 24, 4, 1, '8', 'IN 73', 134, '2014-05-31 11:18:04'),
(211, 24, 4, 1, '8', 'IN 74', 135, '2014-05-31 11:18:04'),
(212, 24, 4, 1, '8', 'IN 75', 136, '2014-05-31 11:18:04'),
(213, 24, 4, 1, '8', 'IN 76', 137, '2014-05-31 11:18:04'),
(214, 24, 4, 1, '8', 'IN 77', 138, '2014-05-31 11:18:05'),
(215, 24, 4, 1, '8', 'IN 78', 139, '2014-05-31 11:18:05'),
(216, 24, 4, 1, '8', 'IN 79', 140, '2014-05-31 11:18:05'),
(217, 24, 4, 1, '8', 'IN 80', 141, '2014-05-31 11:18:05'),
(218, 24, 4, 1, '8', 'IN 81', 142, '2014-05-31 11:18:05'),
(219, 24, 4, 1, '8', 'IN 82', 143, '2014-05-31 11:18:05'),
(220, 24, 4, 1, '8', 'IN 83', 144, '2014-05-31 11:18:05'),
(221, 24, 4, 1, '8', 'IN 84', 145, '2014-05-31 11:18:05'),
(222, 24, 4, 1, '8', 'IN 85', 146, '2014-05-31 11:18:05'),
(223, 24, 4, 1, '8', 'IN 86', 147, '2014-05-31 11:18:05'),
(224, 24, 4, 1, '8', 'IN 87', 148, '2014-05-31 11:18:05'),
(225, 24, 4, 1, '8', 'IN 88', 149, '2014-05-31 11:18:05'),
(226, 24, 4, 1, '8', 'IN 89', 150, '2014-05-31 11:18:05'),
(227, 24, 4, 1, '8', 'IN 90', 151, '2014-05-31 11:18:05'),
(228, 24, 4, 1, '8', 'IN 91', 152, '2014-05-31 11:18:05'),
(229, 24, 4, 1, '8', 'IN 92', 153, '2014-05-31 11:18:05'),
(230, 24, 4, 1, '8', 'IN 93', 154, '2014-05-31 11:18:05'),
(231, 24, 4, 1, '8', 'IN 94', 155, '2014-05-31 11:18:05'),
(232, 24, 4, 1, '8', 'IN 95', 156, '2014-05-31 11:18:05'),
(233, 24, 4, 1, '8', 'IN 96', 157, '2014-05-31 11:18:05'),
(234, 24, 4, 1, '8', 'IN 97', 158, '2014-05-31 11:18:05'),
(235, 24, 4, 1, '8', 'IN 98', 159, '2014-05-31 11:18:05'),
(236, 24, 4, 1, '8', 'IN 99', 160, '2014-05-31 11:18:05'),
(237, 24, 4, 1, '8', 'IN 100', 161, '2014-05-31 11:18:05'),
(238, 24, 4, 6, '3', 'Invoice', 2, '2014-05-31 11:27:07'),
(239, 24, 4, 7, '1', 'Income', 1, '2014-05-31 18:13:16'),
(240, 24, 4, 2, '1', 'Income', 1, '2014-05-31 18:13:40'),
(241, 24, 4, 6, '1', 'Income', 1, '2014-05-31 18:13:50'),
(242, 24, 4, 1, '1', 'Income', 15, '2014-06-02 13:50:16'),
(243, 24, 4, 2, '1', 'Income', 15, '2014-06-02 13:51:18'),
(244, 24, 4, 1, '11', 'Income', 15, '2014-06-02 14:34:42'),
(245, 24, 4, 1, '2', 'Expense', 9, '2014-06-02 15:44:16'),
(246, 24, 4, 1, '11', 'Expense', 9, '2014-06-02 15:44:39'),
(247, 24, 4, 2, '2', 'Expense', 9, '2014-06-02 15:44:58'),
(248, 24, 4, 1, '10', 'gjgjhgj', 4, '2014-06-02 15:57:11'),
(249, 24, 4, 1, '10', 'Fountain', 5, '2014-06-02 16:19:04'),
(250, 24, 4, 1, '11', 'Income', 15, '2014-06-03 10:35:34'),
(251, 24, 4, 1, '11', 'Income', 15, '2014-06-03 10:37:59'),
(252, 24, 4, 1, '11', 'Expense', 9, '2014-06-03 11:01:53'),
(253, 24, 4, 1, '11', 'Invoice', 3, '2014-06-03 11:02:21'),
(254, 24, 4, 1, '4', 'Credit Note', 5, '2014-06-03 11:17:31'),
(255, 24, 4, 1, '4', 'Credit Note', 6, '2014-06-03 11:20:08'),
(256, 24, 4, 2, '4', 'Credit Note', 6, '2014-06-03 11:27:55'),
(257, 24, 4, 1, '5', 'Jounral Entry', 1, '2014-06-03 11:49:28'),
(258, 24, 4, 6, '5', 'Jounral Entry', 1, '2014-06-03 11:49:36'),
(259, 24, 4, 6, '1', 'Income', 2, '2014-06-03 13:06:01'),
(260, 24, 4, 6, '1', 'Income', 6, '2014-06-03 13:16:23'),
(261, 24, 4, 6, '4', 'Credit Note', 2, '2014-06-03 15:06:29'),
(262, 24, 4, 1, '11', 'Expense', 8, '2014-06-03 15:34:25'),
(263, 24, 4, 1, '11', 'Income', 6, '2014-06-03 17:51:18'),
(264, 24, 4, 1, '11', 'Invoice', 2, '2014-06-03 19:23:43'),
(265, 24, 4, 1, '11', 'Income', 2, '2014-06-04 17:53:22'),
(266, 24, 4, 6, '3', 'Invoice', 3, '2014-06-04 18:11:25'),
(267, 24, 4, 1, '11', 'Expense', 8, '2014-06-04 18:27:00'),
(268, 24, 4, 2, '11', 'Income', 2, '2014-06-05 12:54:45'),
(269, 24, 4, 2, '11', 'Income', 2, '2014-06-05 12:54:57'),
(270, 24, 4, 2, '11', 'Income', 2, '2014-06-05 13:57:41'),
(271, 24, 4, 2, '11', 'Income', 2, '2014-06-05 13:58:19'),
(272, 24, 4, 2, '11', 'Income', 2, '2014-06-05 13:58:33'),
(273, 24, 4, 2, '11', 'Income', 2, '2014-06-05 13:58:49'),
(274, 24, 4, 2, '11', 'Income', 2, '2014-06-05 14:00:01'),
(275, 24, 4, 2, '11', 'Invoice', 3, '2014-06-05 14:05:44'),
(276, 24, 4, 2, '11', 'Invoice', 3, '2014-06-05 14:10:22'),
(277, 24, 4, 2, '11', 'Invoice', 3, '2014-06-05 14:11:46'),
(278, 24, 4, 2, '11', 'Invoice', 3, '2014-06-05 14:12:25'),
(279, 24, 4, 2, '11', 'Invoice', 3, '2014-06-05 14:12:48'),
(280, 24, 4, 2, '11', 'Invoice', 3, '2014-06-05 14:14:46'),
(281, 24, 4, 2, '11', 'Invoice', 3, '2014-06-05 14:17:07'),
(282, 24, 4, 2, '11', 'Expense', 8, '2014-06-05 14:17:25'),
(283, 24, 4, 3, '11', 'Income', 2, '2014-06-05 14:30:42'),
(284, 24, 4, 1, '11', 'Income', 14, '2014-06-09 17:33:32'),
(285, 24, 4, 1, '5', 'Jounral Entry', 2, '2014-06-10 12:32:52'),
(286, 24, 4, 6, '5', 'Jounral Entry', 2, '2014-06-10 12:32:52'),
(287, 24, 4, 2, '11', 'Expense', 6, '2014-06-10 16:22:19'),
(288, 24, 4, 2, '2', 'Expense', 6, '2014-06-10 16:22:24'),
(289, 24, 4, 6, '2', 'Expense', 6, '2014-06-10 16:22:24'),
(290, 24, 4, 2, '11', 'Expense', 6, '2014-06-10 16:22:49'),
(291, 24, 4, 1, '2', 'Expense', 10, '2014-06-12 15:28:07'),
(292, 24, 4, 3, '11', 'Expense', 10, '2014-06-12 15:28:39'),
(293, 24, 4, 2, '2', 'Expense', 10, '2014-06-12 15:48:16'),
(294, 24, 4, 1, '11', 'Expense', 10, '2014-06-12 15:57:16'),
(295, 24, 4, 1, '3', 'Invoice', 7, '2014-06-12 16:12:39'),
(296, 24, 4, 1, '3', 'Invoice', 7, '2014-06-12 16:29:17'),
(297, 24, 4, 1, '4', 'Credit Note', 7, '2014-06-12 17:01:52'),
(298, 24, 4, 2, '4', 'Credit Note', 7, '2014-06-12 17:05:10'),
(299, 24, 4, 1, '1', 'Income', 16, '2014-06-12 17:44:10'),
(300, 24, 4, 1, '1', 'Income', 17, '2014-06-12 18:03:00'),
(301, 24, 4, 6, '3', 'Invoice', 7, '2014-06-13 11:30:15'),
(302, 24, 4, 1, '4', 'Credit Note', 8, '2014-06-13 11:45:19'),
(303, 24, 4, 1, '11', 'Income', 7, '2014-06-13 22:18:49'),
(304, 24, 4, 1, '11', 'Income', 6, '2014-06-13 23:27:05'),
(305, 24, 4, 2, '11', 'Expense', 3, '2014-06-14 11:44:23'),
(306, 24, 4, 2, '2', 'Expense', 3, '2014-06-14 11:44:48'),
(307, 24, 4, 6, '2', 'Expense', 3, '2014-06-14 11:44:48'),
(308, 24, 4, 2, '11', 'Expense', 3, '2014-06-14 11:51:56'),
(309, 24, 4, 1, '11', 'Expense', 3, '2014-06-14 11:52:16'),
(310, 24, 4, 1, '8', 'Leasehold Land', 62, '2014-06-24 10:28:16'),
(311, 24, 4, 1, '8', 'Construction In Progress', 63, '2014-06-24 10:28:22'),
(312, 24, 4, 1, '2', 'Expense', 11, '2014-06-24 10:49:16'),
(313, 24, 4, 6, '2', 'Expense', 11, '2014-06-24 10:49:16'),
(314, 24, 4, 8, '3', 'Invoice', 8, '2014-06-24 11:28:23'),
(315, 24, 4, 8, '3', 'Invoice', 9, '2014-06-24 11:30:35'),
(316, 24, 4, 1, '3', 'Invoice', 9, '2014-06-24 12:10:48'),
(317, 24, 4, 1, '3', 'Invoice', 9, '2014-06-24 12:14:16'),
(318, 24, 4, 1, '3', 'Invoice', 9, '2014-06-24 12:20:40'),
(319, 24, 4, 8, '2', 'Expense', 12, '2014-06-24 12:33:29'),
(320, 24, 4, 8, '1', 'Income', 18, '2014-06-24 12:34:59'),
(321, 24, 4, 2, '1', 'Income', 18, '2014-06-24 12:35:39'),
(322, 24, 4, 2, '2', 'Expense', 12, '2014-06-24 12:39:22'),
(323, 24, 4, 2, '1', 'Income', 14, '2014-06-24 12:41:01');

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
  `exchange_rate` decimal(11,5) NOT NULL,
  `date` date NOT NULL,
  `memo` varchar(255) NOT NULL,
  `approval_for` int(11) NOT NULL DEFAULT '0',
  `credit_status` tinyint(2) NOT NULL COMMENT '1 - Approved, 2 - Unapproved, 3 - Draft',
  `sent_status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '1 - Sent, 2 - Not Sent',
  `delete_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `credit_no` (`credit_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkinvoice_id`,`fkcustomer_id`),
  KEY `fkinvoice_id` (`fkinvoice_id`,`fkcustomer_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `approval_for` (`approval_for`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `credit`
--

INSERT INTO `credit` (`id`, `fkcompany_id`, `credit_no`, `fkinvoice_id`, `fkcustomer_id`, `transaction_currency`, `exchange_rate`, `date`, `memo`, `approval_for`, `credit_status`, `sent_status`, `delete_status`, `date_created`, `date_modified`) VALUES
(2, 24, 'CR-0000000001', 5, 3, 'INR', 0.00000, '2014-05-22', 'test credit note\r\n', 26, 1, 2, 1, '2014-05-26 15:31:01', '2014-06-03 15:06:28'),
(3, 24, 'CR-0000000002', 5, 3, 'INR', 0.00000, '2014-05-22', 'ngbgnvbnjkjk', 26, 2, 2, 1, '2014-05-26 17:15:16', '0000-00-00 00:00:00'),
(4, 24, 'CR-0000000003', 5, 3, 'INR', 0.00000, '2014-05-22', 'bfgvvvvvvvvvvv', 26, 2, 2, 2, '2014-05-26 17:20:38', '2014-05-26 17:21:15'),
(6, 24, 'CR-0000000004', 5, 3, 'INR', 0.00000, '2014-05-22', 'tggdgdfgfbf', 26, 2, 2, 1, '2014-06-03 11:20:03', '2014-06-03 11:27:46'),
(7, 24, 'CR-0000000005', 4, 3, 'INR', 0.05000, '2014-05-22', 'dsdfdfdfdfd', 26, 2, 2, 1, '2014-06-12 17:01:46', '2014-06-12 17:05:02'),
(8, 24, 'CR-0000000006', 7, 4, 'INR', 0.06000, '2014-06-12', 'fdfdfdfdf fdfdf', 26, 2, 2, 1, '2014-06-13 11:45:10', '0000-00-00 00:00:00');

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
  `discount_amount` decimal(11,2) NOT NULL,
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

INSERT INTO `credit_product_list` (`id`, `fkcredit_id`, `product_id`, `product_description`, `quantity`, `unit_price`, `discount_amount`, `fktax_id`, `tax_value`, `date_created`, `date_modified`) VALUES
(3, 2, 'INR25', '2', 1, 32560.00, 0.00, 0, 0.00, '2014-05-26 15:31:01', '0000-00-00 00:00:00'),
(4, 2, 'INR2', '3', 2, 3200.00, 20.00, 3, 2.00, '2014-05-26 15:31:01', '0000-00-00 00:00:00'),
(5, 3, 'INR25', '2', 1, 32560.00, 0.00, 0, 0.00, '2014-05-26 17:15:16', '0000-00-00 00:00:00'),
(6, 3, 'INR2', '3', 0, 3200.00, 0.00, 3, 2.00, '2014-05-26 17:15:16', '0000-00-00 00:00:00'),
(7, 4, 'INR25', '2', 1, 32560.00, 0.00, 0, 0.00, '2014-05-26 17:20:38', '0000-00-00 00:00:00'),
(8, 4, 'INR2', '3', 1, 3200.00, 0.00, 3, 2.00, '2014-05-26 17:20:38', '0000-00-00 00:00:00'),
(10, 6, 'INR25', '2', 1, 32560.00, 85.00, 0, 0.00, '2014-06-03 11:20:03', '0000-00-00 00:00:00'),
(11, 7, 'SG12', '1', 1, 3250.00, 21.00, 3, 2.00, '2014-06-12 17:01:46', '0000-00-00 00:00:00'),
(12, 8, 'INR25', '2', 1, 32560.00, 0.00, 0, 0.00, '2014-06-13 11:45:10', '0000-00-00 00:00:00');

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
  `coa_link` int(11) NOT NULL COMMENT '3 - Trade Receivables, 4 - Other Receivables',
  `other_coa_link` tinytext NOT NULL,
  `delete_status` int(2) NOT NULL DEFAULT '1' COMMENT '1- active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`),
  KEY `coa_link` (`coa_link`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fkcompany_id`, `customer_id`, `customer_name`, `address1`, `address2`, `company_registration_no`, `office_number`, `fax_number`, `city`, `state`, `country`, `website`, `email`, `company_gst_no`, `postcode`, `gst_verified_date`, `coa_link`, `other_coa_link`, `delete_status`, `date_created`, `date_modified`) VALUES
(3, 24, 'CUS-0000000001', 'Hghfhgfh', 'ratley street', '', 'hgfhfg', '65656554', '', 'Bangalore', 'Karnataka', 'AW', '', '', '', '655655', '2014-05-24', 3, '45,46', 1, '2014-05-19 18:24:21', '2014-05-29 21:00:41'),
(4, 24, 'CUS-0000000002', 'Gddfgdf', 'gfgfgfgfgfg', '', 'gfgfgf', '046565656', '', 'Chennai', 'Tn', 'IN', '', '', '', '802320', '2014-05-15', 57, '', 1, '2014-05-29 19:02:48', '2014-05-29 19:39:04');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `customer_contact_person`
--


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
(1, 3, 'chester le street', '', 'Edgabston', 'London', 'GB', '9gj6767', '2014-05-29 21:00:41', '2014-05-29 21:00:41');

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
  `exchange_rate` decimal(11,5) NOT NULL,
  `fkpayment_account` int(11) DEFAULT NULL,
  `discount_status` tinyint(2) NOT NULL COMMENT '1 - Yes, 2 - No',
  `discount_amount` decimal(11,2) NOT NULL,
  `permit_no` varchar(100) NOT NULL,
  `do_so_no` varchar(60) NOT NULL,
  `fkreceipt_id` varchar(255) DEFAULT NULL,
  `approval_for` int(11) NOT NULL DEFAULT '0',
  `transaction_status` tinyint(2) NOT NULL COMMENT '1 - Approved/Verified, 2 - Unverified, 3 - Draft',
  `payment_status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '1- Completed, 2 - Pending',
  `payment_id` int(11) NOT NULL,
  `final_payment_date` date NOT NULL,
  `delete_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_no` (`expense_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkvendor_id`),
  KEY `fkcustomer_id` (`fkvendor_id`),
  KEY `fkpayment_account` (`fkpayment_account`),
  KEY `approval_for` (`approval_for`),
  KEY `payment_id` (`payment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `expense_transaction`
--

INSERT INTO `expense_transaction` (`id`, `fkcompany_id`, `expense_no`, `date`, `receipt_no`, `fkvendor_id`, `shipping_address`, `credit_term`, `due_date`, `transaction_currency`, `exchange_rate`, `fkpayment_account`, `discount_status`, `discount_amount`, `permit_no`, `do_so_no`, `fkreceipt_id`, `approval_for`, `transaction_status`, `payment_status`, `payment_id`, `final_payment_date`, `delete_status`, `date_created`, `date_modified`) VALUES
(1, 24, 'EXP-0000000001', '2014-05-21', 'test123', 2, '', '2', '2014-06-20', 'SGD', 0.00000, 5, 2, 0.00, 'gfggt', '', '', 26, 2, 2, 0, '0000-00-00', 1, '2014-05-21 15:07:13', '0000-00-00 00:00:00'),
(2, 24, 'EXP-0000000002', '2014-05-21', 'fdsdfsdf', 2, '', '1', '2014-05-21', 'INR', 0.00000, 39, 2, 0.00, 'hghgfhfgh', '', '', 26, 2, 2, 0, '0000-00-00', 1, '2014-05-21 15:14:32', '0000-00-00 00:00:00'),
(3, 24, 'EXP-0000000003', '2014-05-21', 'fdsfdsf', 2, '', '2', '2014-05-21', 'SGD', 0.00000, 36, 2, 0.00, 'fdfsdf', '', '', 26, 1, 1, 37, '2014-06-14', 1, '2014-05-21 15:34:42', '2014-06-14 11:52:16'),
(4, 24, 'EXP-0000000004', '2014-05-21', 'gfgfdg', 2, '', '1', '2014-05-21', 'SGD', 0.00000, 36, 2, 0.00, 'fgfdg', '', '', 26, 2, 2, 0, '0000-00-00', 1, '2014-05-21 15:36:12', '2014-05-28 11:58:13'),
(5, 24, 'EXP-0000000005', '2014-05-21', 'dsdsds', 2, '', '1', '2014-05-21', 'SGD', 0.00000, 36, 2, 0.00, 'dsdsd', '', '', 26, 2, 2, 0, '0000-00-00', 1, '2014-05-21 16:07:34', '0000-00-00 00:00:00'),
(6, 24, 'EXP-0000000006', '2014-05-21', 'addsa', 2, '', '1', '2014-05-21', 'INR', 0.02300, 36, 2, 0.00, 'dsdsd', '', '', 26, 1, 2, 0, '2014-06-11', 1, '2014-05-21 16:11:01', '2014-06-10 16:22:49'),
(7, 24, 'EXP-0000000007', '2014-05-21', '', 2, '', '1', '2014-05-21', 'SGD', 0.00000, 36, 2, 0.00, '', '', '', 0, 3, 2, 0, '0000-00-00', 1, '2014-05-21 18:41:41', '2014-05-21 18:41:56'),
(8, 24, 'EXP-0000000008', '2014-05-21', 'aasss', 2, '', '2', '2014-05-21', 'INR', 0.02300, 36, 2, 0.00, 'dsdsd', '', '', 26, 1, 1, 29, '2014-06-03', 1, '2014-05-21 18:42:21', '2014-06-05 14:17:24'),
(9, 24, 'EXP-0000000009', '2014-06-02', 'gfdgfdg', 2, '', '2', '2014-07-02', 'SGD', 0.00000, NULL, 1, 0.00, 'gfgfg', '', '', 26, 2, 1, 0, '0000-00-00', 1, '2014-06-02 15:44:11', '2014-06-03 11:01:53'),
(10, 24, 'EXP-0000000010', '2014-06-12', 'hghgdhghg', 2, '', '1', '2014-06-12', 'INR', 1.25000, NULL, 2, 0.00, 'hghghg', '', '', 26, 2, 2, 0, '0000-00-00', 1, '2014-06-12 15:27:58', '2014-06-12 15:48:08'),
(11, 24, 'EXP-0000000011', '2014-06-24', 'test receipt', 2, '', '2', '2014-07-24', 'SGD', 0.00000, NULL, 2, 0.00, 'dfdfd', '', '', 0, 1, 2, 0, '0000-00-00', 1, '2014-06-24 10:49:16', '0000-00-00 00:00:00'),
(12, 24, 'EXP-0000000012', '2014-06-24', 'jhjhff', 3, '', '1', '2014-06-24', 'SGD', 0.00000, NULL, 2, 0.00, 'hghghg', '', '', 26, 2, 2, 0, '0000-00-00', 1, '2014-06-24 12:33:29', '2014-06-24 12:39:07');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `expense_transaction_list`
--

INSERT INTO `expense_transaction_list` (`id`, `fkexpense_id`, `fkexpense_type`, `product_id`, `product_description`, `quantity`, `unit_price`, `fktax_id`, `tax_value`, `date_created`, `date_modified`) VALUES
(1, 1, 49, '4343', 'dsffsdf', 3, 434.00, 2, 2.00, '2014-05-21 15:07:13', '0000-00-00 00:00:00'),
(2, 1, 49, '343', 'fdfsdfs', 2, 2323.00, 0, 0.00, '2014-05-21 15:07:13', '0000-00-00 00:00:00'),
(3, 2, 49, 'ghghg', 'hghgfh', 3, 22322.00, 2, 2.00, '2014-05-21 15:14:32', '0000-00-00 00:00:00'),
(4, 3, 49, 'gfgfdg', 'gfgf', 45, 5445.00, 2, 2.00, '2014-05-21 15:34:42', '0000-00-00 00:00:00'),
(5, 4, 49, 'gfg', 'gfgfd', 4, 5454.00, 2, 2.00, '2014-05-21 15:36:13', '0000-00-00 00:00:00'),
(6, 5, 49, 'dsds', 'dsds', 21, 212.00, 0, 0.00, '2014-05-21 16:07:34', '0000-00-00 00:00:00'),
(7, 6, 49, 'sdsd', 'dsd', 10, 232.00, 0, 0.00, '2014-05-21 16:11:01', '0000-00-00 00:00:00'),
(8, 6, 49, 'dsd', 'dsd', 2, 23.00, 2, 2.00, '2014-05-21 16:11:01', '0000-00-00 00:00:00'),
(9, 6, 49, 'fdfd', 'fdsf', 1, 231.00, 0, 0.00, '2014-05-21 17:56:23', '0000-00-00 00:00:00'),
(10, 7, NULL, '', '', 0, 0.00, 0, 0.00, '2014-05-21 18:41:41', '0000-00-00 00:00:00'),
(11, 8, 49, 'sdsd', 'dsd', 10, 232.00, 0, 0.00, '2014-05-21 18:42:21', '0000-00-00 00:00:00'),
(12, 8, 49, 'dsd', 'dsd', 2, 23.00, 2, 2.00, '2014-05-21 18:42:22', '0000-00-00 00:00:00'),
(13, 8, 49, 'fdfd', 'fdsf', 1, 231.00, 0, 0.00, '2014-05-21 18:42:22', '0000-00-00 00:00:00'),
(14, 9, 49, 'gfdg', 'fdgfdg', 3, 434.00, 2, 2.00, '2014-06-02 15:44:11', '0000-00-00 00:00:00'),
(15, 9, 49, 'gfg', 'ddf', 1, 43.00, 0, 0.00, '2014-06-02 15:44:11', '0000-00-00 00:00:00'),
(16, 10, 2, 'hgh', 'hghgh', 2, 332.00, 2, 2.00, '2014-06-12 15:27:58', '0000-00-00 00:00:00'),
(17, 10, 49, '', 'dfdfd', 2, 350.00, 2, 2.00, '2014-06-12 15:27:58', '0000-00-00 00:00:00'),
(18, 11, 63, 'fdfd', 'fdfdfd', 2, 4343.00, 2, 2.00, '2014-06-24 10:49:16', '0000-00-00 00:00:00'),
(19, 11, 49, 'fdfd', 'fdsf', 2, 343.00, 0, 0.00, '2014-06-24 10:49:16', '0000-00-00 00:00:00'),
(20, 12, 49, 'ghgh', 'hghg', 3, 343.00, 0, 0.00, '2014-06-24 12:33:29', '0000-00-00 00:00:00');

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
  `exchange_rate` decimal(11,5) NOT NULL,
  `fkincome_type` int(11) NOT NULL DEFAULT '0',
  `transaction_description` varchar(255) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `fkreceipt_id` varchar(255) DEFAULT NULL,
  `fktax_id` int(11) NOT NULL,
  `tax_value` decimal(6,2) NOT NULL,
  `approval_for` int(11) NOT NULL DEFAULT '0',
  `transaction_status` tinyint(2) NOT NULL COMMENT '1 - Approved/Verified, 2 - Unverified & Saved, 3 - Draft',
  `payment_status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '1- Completed, 2 - Pending',
  `payment_id` int(11) NOT NULL,
  `final_payment_date` date NOT NULL,
  `delete_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_no` (`income_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkcustomer_id`,`fkpayment_account`,`fkincome_type`,`fktax_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `fktax_id` (`fktax_id`),
  KEY `fkpayment_account` (`fkpayment_account`),
  KEY `fkreceipt_id` (`fkreceipt_id`),
  KEY `approval_for` (`approval_for`),
  KEY `payment_id` (`payment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `income_transaction`
--

INSERT INTO `income_transaction` (`id`, `fkcompany_id`, `income_no`, `date`, `receipt_no`, `fkcustomer_id`, `fkpayment_account`, `credit_term`, `transaction_currency`, `exchange_rate`, `fkincome_type`, `transaction_description`, `amount`, `fkreceipt_id`, `fktax_id`, `tax_value`, `approval_for`, `transaction_status`, `payment_status`, `payment_id`, `final_payment_date`, `delete_status`, `date_created`, `date_modified`) VALUES
(1, 24, 'INC-0000000001', '2014-05-20', 'test1234', 3, 3, '3', 'SGD', 0.00000, 14, 'asdff asdffg', 3210.00, '', 3, 2.00, 26, 1, 2, 0, '0000-00-00', 1, '2014-05-20 13:54:29', '2014-05-31 18:13:49'),
(2, 24, 'INC-0000000002', '2014-05-20', 'gfgdg', 3, 3, '3', 'INR', 0.00000, 14, 'hghgfhgfhgfh', 2300.00, '', 3, 2.00, 26, 1, 2, 0, '2014-06-07', 1, '2014-05-20 17:36:27', '2014-06-05 14:30:42'),
(3, 24, 'INC-0000000003', '2014-05-20', '', 3, 3, '3', 'INR', 0.00000, 14, 'hghgfhgfhgfh', 2.00, '', 3, 2.00, 26, 3, 2, 0, '0000-00-00', 2, '2014-05-20 18:18:01', '2014-05-20 18:23:38'),
(4, 24, 'INC-0000000004', '2014-05-20', '', 3, 3, '3', 'INR', 0.00000, 14, 'hghgfhgfhgfh', 2.00, '', 3, 2.00, 26, 3, 2, 0, '0000-00-00', 2, '2014-05-20 18:21:00', '2014-05-20 18:21:08'),
(5, 24, 'INC-0000000005', '2014-05-20', '', 3, 3, '3', 'INR', 0.00000, 14, 'hghgfhgfhgfh', 2300.00, '', 3, 2.00, 26, 3, 2, 0, '0000-00-00', 1, '2014-05-20 18:23:28', '0000-00-00 00:00:00'),
(6, 24, 'INC-0000000006', '2014-05-21', 'gfgdfgfdg', 3, 39, '1', 'SGD', 0.00000, 50, 'gfgfgfggfgfgfg', 4554.00, '', 3, 2.00, 26, 1, 1, 36, '2014-06-13', 1, '2014-05-21 12:45:56', '2014-06-13 23:27:05'),
(7, 24, 'INC-0000000007', '2014-05-21', 'gfgfdgf', 3, 39, '1', 'SGD', 0.00000, 14, 'gffffffffffffff', 45454.00, '', 3, 2.00, 26, 2, 2, 0, '0000-00-00', 1, '2014-05-21 12:54:43', '0000-00-00 00:00:00'),
(10, 24, 'INC-0000000008', '2014-05-21', 'vfgdfgfd', 3, 36, '1', 'SGD', 0.00000, 14, 'gfdgfdgdfdfdf', 45454.00, '', 0, 0.00, 26, 2, 2, 0, '0000-00-00', 1, '2014-05-21 13:27:46', '0000-00-00 00:00:00'),
(11, 24, 'INC-0000000009', '2014-05-23', 'hgfhggf', 3, 3, '3', 'SGD', 0.00000, 14, 'gfgfdgfdgfd', 545.00, '11_2764_income.jpg', 3, 2.00, 26, 2, 2, 0, '0000-00-00', 1, '2014-05-23 15:54:30', '0000-00-00 00:00:00'),
(12, 24, 'INC-0000000010', '2014-05-28', 'testqwwii', 3, 3, '3', 'SGD', 0.00000, 14, 'fdsfdsf sfsfdsfd', 6523.00, '', 0, 0.00, 26, 2, 2, 0, '0000-00-00', 1, '2014-05-28 11:37:43', '0000-00-00 00:00:00'),
(13, 24, 'INC-0000000011', '2014-05-28', 'fdsfsdfsdf', 3, 3, '3', 'SGD', 0.00000, 14, 'fdsfsdf dfdsfds', 6582.00, '', 3, 2.00, 26, 2, 2, 0, '0000-00-00', 1, '2014-05-28 11:41:32', '0000-00-00 00:00:00'),
(14, 24, 'INC-0000000012', '2014-05-28', 'fssdfgdf', 3, 46, '3', 'SGD', 0.00000, 14, 'gfgdfgdfgdfg', 3433.00, '', 0, 0.00, 26, 2, 2, 0, '0000-00-00', 1, '2014-05-28 11:46:40', '0000-00-00 00:00:00'),
(15, 24, 'INC-0000000013', '2014-06-02', 'folfksf', 4, NULL, '3', 'SGD', 0.00000, 50, 'tetsjskdss', 3210.00, '', 3, 2.00, 26, 2, 1, 0, '0000-00-00', 1, '2014-06-02 13:50:10', '2014-06-03 10:37:59'),
(16, 24, 'INC-0000000014', '2014-06-12', 'hgfhfghg', 3, NULL, '1', 'INR', 0.02000, 14, 'fhgfhfghhghghgh', 434.00, '', 3, 2.00, 26, 2, 2, 0, '0000-00-00', 1, '2014-06-12 17:44:02', '0000-00-00 00:00:00'),
(17, 24, 'INC-0000000015', '2014-06-12', 'ffgfgfg', 3, NULL, '1', 'INR', 0.06000, 14, 'fhgfhfghhghghgh', 433.00, '', 3, 2.00, 26, 2, 2, 0, '0000-00-00', 1, '2014-06-12 18:02:45', '0000-00-00 00:00:00'),
(18, 24, 'INC-0000000016', '2014-06-24', 'fvxvxcx', 4, NULL, '1', 'SGD', 0.00000, 14, 'vcxvxcvcxfdfd', 5454.00, '', 0, 0.00, 26, 2, 2, 0, '0000-00-00', 1, '2014-06-24 12:34:59', '0000-00-00 00:00:00');

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
  `exchange_rate` decimal(11,5) NOT NULL,
  `discount_status` tinyint(2) NOT NULL COMMENT '1 - Yes, 2 - No',
  `non_revenue_tax` tinyint(2) NOT NULL COMMENT '1 - Yes, 2 - No',
  `memo` varchar(255) NOT NULL,
  `do_so_no` varchar(60) NOT NULL,
  `approval_for` int(11) NOT NULL DEFAULT '0',
  `invoice_status` tinyint(2) NOT NULL COMMENT '1 - Approved, 2 - Unapproved, 3 - Draft',
  `sent_status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '1 - Sent, 2 - Not Sent',
  `payment_status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '1 - Completed, 2 - Pending',
  `payment_id` int(11) NOT NULL,
  `final_payment_date` date NOT NULL,
  `delete_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_no` (`invoice_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkcustomer_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `approval_for` (`approval_for`),
  KEY `payment_id` (`payment_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `fkcompany_id`, `invoice_no`, `date`, `fkcustomer_id`, `fkshipping_address`, `credit_term`, `due_date`, `transaction_currency`, `exchange_rate`, `discount_status`, `non_revenue_tax`, `memo`, `do_so_no`, `approval_for`, `invoice_status`, `sent_status`, `payment_status`, `payment_id`, `final_payment_date`, `delete_status`, `date_created`, `date_modified`) VALUES
(2, 24, 'INV-0000000001', '2014-05-22', 3, 0, '2', '2014-06-21', 'SGD', 0.00000, 2, 2, '', '', 26, 1, 2, 2, 0, '0000-00-00', 1, '2014-05-22 16:24:56', '2014-05-31 11:27:07'),
(3, 24, 'INV-0000000002', '2014-05-22', 3, 0, '2', '2014-06-21', 'INR', 0.02300, 2, 2, '', '', 26, 1, 2, 1, 24, '2014-06-04', 1, '2014-05-22 16:25:23', '2014-06-05 14:17:07'),
(4, 24, 'INV-0000000003', '2014-05-22', 3, 1, '1', '2014-05-22', 'SGD', 0.00000, 2, 2, '', '', 26, 2, 2, 2, 0, '0000-00-00', 1, '2014-05-22 16:31:55', '2014-05-27 22:56:31'),
(5, 24, 'INV-0000000004', '2014-05-22', 3, 0, '2', '2014-06-21', 'INR', 0.00000, 2, 2, '', '', 26, 2, 2, 2, 0, '0000-00-00', 1, '2014-05-22 16:40:17', '2014-05-26 10:38:39'),
(6, 24, 'INV-0000000005', '2014-05-22', 3, 0, '1', '2014-05-22', 'INR', 0.00000, 2, 2, '', '', 26, 2, 2, 2, 0, '0000-00-00', 1, '2014-05-22 16:43:51', '0000-00-00 00:00:00'),
(7, 24, 'INV-0000000006', '2014-06-12', 4, 0, '1', '2014-06-12', 'INR', 0.06000, 2, 2, '', '', 26, 1, 2, 2, 0, '0000-00-00', 1, '2014-06-12 16:12:31', '2014-06-13 11:30:15'),
(9, 24, 'INV-0000000007', '2014-06-24', 4, 0, '1', '2014-06-24', 'SGD', 0.00000, 2, 2, '', '', 26, 2, 2, 2, 0, '0000-00-00', 1, '2014-06-24 11:30:35', '2014-06-24 12:20:33');

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
  `credit_prefix` varchar(60) NOT NULL,
  `credit_next_running_number` int(11) NOT NULL,
  `default_credit_term` int(11) NOT NULL,
  `default_tax_code` int(11) NOT NULL,
  `default_currency` varchar(10) NOT NULL,
  `default_product_title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `invoice_credit_note_customization`
--

INSERT INTO `invoice_credit_note_customization` (`id`, `template`, `company_logo`, `display_logo`, `invoice_prefix`, `invoice_next_running_number`, `credit_prefix`, `credit_next_running_number`, `default_credit_term`, `default_tax_code`, `default_currency`, `default_product_title`) VALUES
(1, 2, 'logo24.png', 2, 'INV', 0, 'CR', 0, 2, 0, 'SGD', '1');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `invoice_product_list`
--

INSERT INTO `invoice_product_list` (`id`, `fkinvoice_id`, `product_id`, `product_description`, `quantity`, `unit_price`, `discount_amount`, `fktax_id`, `tax_value`, `date_created`, `date_modified`) VALUES
(2, 2, 'SG12', '1', 2, 3250.00, 10.00, 3, 2.00, '2014-05-22 16:24:56', '0000-00-00 00:00:00'),
(3, 3, 'INR25', '2', 2, 32560.00, 0.00, 0, 0.00, '2014-05-22 16:25:23', '0000-00-00 00:00:00'),
(4, 4, 'SG12', '1', 3, 3250.00, 21.00, 0, 0.00, '2014-05-22 16:31:56', '0000-00-00 00:00:00'),
(5, 5, 'INR25', '2', 3, 32560.00, 0.00, 0, 0.00, '2014-05-22 16:40:17', '0000-00-00 00:00:00'),
(6, 6, 'INR25', '2', 3, 32560.00, 0.00, 0, 0.00, '2014-05-22 16:43:51', '0000-00-00 00:00:00'),
(7, 5, 'INR2', '3', 2, 3200.00, 0.00, 3, 2.00, '2014-05-26 10:38:39', '0000-00-00 00:00:00'),
(8, 7, 'INR25', '2', 2, 32560.00, 0.00, 0, 0.00, '2014-06-12 16:12:31', '0000-00-00 00:00:00'),
(10, 9, 'hjgjh', '4', 2, 1000.00, 0.00, 0, 0.00, '2014-06-24 11:30:35', '0000-00-00 00:00:00');

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
  `delete_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `journal_no` (`journal_no`),
  KEY `fkcompany_id` (`fkcompany_id`),
  KEY `approval_for` (`approval_for`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `journal_entries`
--

INSERT INTO `journal_entries` (`id`, `fkcompany_id`, `journal_no`, `date`, `description`, `attachment`, `approval_for`, `journal_status`, `delete_status`, `date_created`, `date_modified`) VALUES
(1, 24, 'JEN-0000000001', '2014-06-03', 'test jounral', '', 26, 1, 1, '2014-06-03 11:49:23', '2014-06-03 11:49:36'),
(2, 24, 'JEN-0000000002', '2014-06-10', 'gfgdfg gfdgfdgdfgdfg', '', 26, 1, 1, '2014-06-10 12:32:52', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `journal_entries_list`
--

INSERT INTO `journal_entries_list` (`id`, `fkjournal_id`, `fkaccount_id`, `journal_description`, `debit`, `credit`, `date_created`, `date_modified`) VALUES
(1, 1, 50, 'jhgjgjhg', 756.00, 0.00, '2014-06-03 11:49:23', '0000-00-00 00:00:00'),
(2, 1, 15, 'jhhgjhgj', 0.00, 756.00, '2014-06-03 11:49:23', '0000-00-00 00:00:00'),
(3, 2, 14, 'test journal', 121.00, 0.00, '2014-06-10 12:32:52', '0000-00-00 00:00:00'),
(4, 2, 36, 'fgsf', 0.00, 121.00, '2014-06-10 12:32:52', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification` tinyint(2) NOT NULL COMMENT '1 - On, 2 - Off',
  `email_setting` tinyint(2) NOT NULL COMMENT '1 - Immediate, 2 - Daily',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notification`, `email_setting`, `date_created`, `date_modified`) VALUES
(1, 1, 1, '2014-05-28 00:24:28', '2014-05-28 10:49:57');

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
  `bank_date` date NOT NULL,
  `fkpayment_account` int(11) DEFAULT NULL,
  `payment_amount` decimal(11,2) NOT NULL,
  `payment_method` tinyint(4) NOT NULL,
  `cheque_draft_no` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkiei_id` (`fkiei_id`),
  KEY `fkpayment_account` (`fkpayment_account`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `discount_status`, `discount_amount`, `payment_description`, `payment_status`, `date_created`, `date_modified`, `fkiei_id`, `date`, `bank_date`, `fkpayment_account`, `payment_amount`, `payment_method`, `cheque_draft_no`) VALUES
(1, 2, 0.00, '', 1, '2014-05-20 17:55:18', '2014-05-20 18:58:06', 1, '2014-05-20', '0000-00-00', 45, 3200.00, 2, ''),
(2, 2, 25.00, '', 1, '2014-05-21 12:45:56', '0000-00-00 00:00:00', 6, '2014-05-21', '0000-00-00', 39, 3000.00, 5, 'gdgdf'),
(4, 2, 0.00, 'gfgdfgdfgd', 1, '2014-05-21 12:54:43', '0000-00-00 00:00:00', 7, '2014-05-21', '0000-00-00', 36, 32.00, 3, ''),
(7, 2, 0.00, '', 1, '2014-05-21 13:27:46', '0000-00-00 00:00:00', 10, '2014-05-21', '0000-00-00', 36, 654.00, 2, ''),
(8, 2, 0.00, '', 2, '2014-05-21 15:14:32', '0000-00-00 00:00:00', 2, '2014-05-21', '0000-00-00', 5, 3200.00, 2, ''),
(9, 2, 0.00, '', 2, '2014-05-21 15:34:42', '2014-06-14 11:51:56', 3, '2014-05-21', '0000-00-00', 36, 5454.00, 2, ''),
(10, 2, 0.00, '', 2, '2014-05-21 15:36:13', '0000-00-00 00:00:00', 4, '2014-05-21', '0000-00-00', 36, 6541.00, 2, ''),
(11, 2, 0.00, '', 2, '2014-05-21 16:07:34', '0000-00-00 00:00:00', 5, '2014-05-21', '0000-00-00', 36, 5600.00, 3, ''),
(12, 2, 0.00, '', 2, '2014-05-21 16:11:02', '2014-06-13 20:23:07', 6, '2014-05-21', '0000-00-00', 36, 46.00, 2, ''),
(13, 2, 0.00, '', 2, '2014-05-21 17:05:56', '2014-06-13 20:34:33', 6, '2014-06-11', '2014-06-12', 36, 3.00, 2, ''),
(14, 2, 0.00, '', 3, '2014-05-22 16:31:56', '0000-00-00 00:00:00', 4, '2014-05-22', '0000-00-00', 46, 3200.00, 1, ''),
(15, 2, 0.00, '', 3, '2014-05-22 16:43:51', '0000-00-00 00:00:00', 6, '2014-05-22', '0000-00-00', 3, 1800.00, 2, ''),
(16, 2, 0.00, '', 3, '2014-05-23 15:53:15', '2014-05-29 23:14:37', 36, '2014-06-01', '0000-00-00', 3, 235.00, 2, ''),
(17, 2, 0.00, '', 3, '2014-05-27 18:21:29', '0000-00-00 00:00:00', 5, '2014-05-27', '0000-00-00', 36, 23.00, 3, ''),
(18, 2, 0.00, '', 3, '2014-05-27 18:21:41', '0000-00-00 00:00:00', 5, '2014-05-27', '0000-00-00', 36, 60.00, 5, ''),
(19, 2, 0.00, '', 1, '2014-06-02 14:34:42', '0000-00-00 00:00:00', 15, '2014-06-02', '0000-00-00', 57, 350.00, 2, ''),
(20, 2, 0.00, '', 2, '2014-06-02 15:44:39', '0000-00-00 00:00:00', 9, '2014-06-02', '0000-00-00', 5, 125.00, 2, ''),
(22, 2, 0.00, '', 1, '2014-06-03 10:37:59', '0000-00-00 00:00:00', 15, '2014-06-03', '0000-00-00', 36, 2900.00, 3, ''),
(23, 1, 0.00, '', 2, '2014-06-03 11:01:53', '0000-00-00 00:00:00', 9, '2014-06-03', '0000-00-00', 36, 1200.00, 2, ''),
(24, 2, 0.00, '', 3, '2014-06-03 11:02:21', '2014-06-13 20:34:33', 3, '2014-06-04', '2014-06-14', 36, 1300.00, 1, ''),
(25, 2, 10.00, '', 2, '2014-06-03 15:34:25', '2014-06-13 20:23:07', 8, '2014-06-03', '0000-00-00', 36, 23.00, 2, ''),
(26, 1, 120.00, '', 1, '2014-06-03 17:51:18', '2014-06-13 20:23:07', 6, '2014-06-03', '0000-00-00', 36, 1000.00, 3, ''),
(27, 1, 25.00, '', 3, '2014-06-03 19:23:43', '2014-06-13 20:23:07', 2, '2014-06-03', '0000-00-00', 36, 365.00, 3, ''),
(29, 2, 0.00, '', 2, '2014-06-04 18:27:00', '2014-06-13 20:34:33', 8, '2014-06-03', '2014-06-10', 36, 45.00, 3, ''),
(30, 2, 0.00, '', 1, '2014-06-09 17:33:32', '0000-00-00 00:00:00', 14, '2014-06-09', '0000-00-00', 36, 6500.00, 2, ''),
(32, 2, 0.00, '', 2, '2014-06-12 15:57:16', '0000-00-00 00:00:00', 10, '2014-06-12', '0000-00-00', 36, 20.00, 3, ''),
(33, 2, 0.00, '', 3, '2014-06-12 16:12:31', '2014-06-13 20:23:07', 7, '2014-06-12', '0000-00-00', 36, 656.00, 3, ''),
(34, 2, 0.00, '', 1, '2014-06-12 17:44:02', '0000-00-00 00:00:00', 16, '2014-06-12', '0000-00-00', 36, 5.00, 2, ''),
(35, 1, 1122.00, '', 1, '2014-06-13 22:18:49', '0000-00-00 00:00:00', 7, '2014-06-13', '0000-00-00', 36, 3100.00, 1, ''),
(36, 2, 0.00, '', 1, '2014-06-13 23:27:05', '0000-00-00 00:00:00', 6, '2014-06-13', '0000-00-00', 36, 500.00, 2, ''),
(37, 2, 0.00, '', 2, '2014-06-14 11:52:16', '0000-00-00 00:00:00', 3, '2014-06-14', '0000-00-00', 36, 35000.00, 2, ''),
(38, 2, 0.00, '', 3, '2014-06-24 11:30:35', '0000-00-00 00:00:00', 9, '2014-06-26', '0000-00-00', 36, 650.00, 1, ''),
(39, 2, 0.00, '', 2, '2014-06-24 12:33:29', '0000-00-00 00:00:00', 12, '2014-06-24', '0000-00-00', 36, 1000.00, 2, ''),
(40, 2, 0.00, '', 1, '2014-06-24 12:34:59', '0000-00-00 00:00:00', 18, '2014-06-24', '0000-00-00', 36, 1000.00, 2, '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `fkcompany_id`, `product_id`, `description`, `price`, `currency`, `fkincomeaccount_id`, `date_created`, `date_modified`) VALUES
(1, 'SGD Product', 24, 'SG12', '', 4000.00, 'SGD', 14, '2014-05-20 19:29:32', '2014-05-24 15:26:49'),
(2, 'INR Product', 24, 'INR25', '', 32560.00, 'INR', 14, '2014-05-20 19:30:15', '0000-00-00 00:00:00'),
(3, 'test product', 24, 'INR2', '', 3200.00, 'INR', 50, '2014-05-26 10:33:28', '0000-00-00 00:00:00'),
(4, 'gjgjhgj', 24, 'hjgjh', '', 1000.00, 'SGD', 50, '2014-06-02 15:57:11', '0000-00-00 00:00:00'),
(5, 'Fountain', 24, 'fggf', 'Garden rock fountain', 32052.00, 'INR', 50, '2014-06-02 16:19:04', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `taxcodes`
--

INSERT INTO `taxcodes` (`id`, `fkcompany_id`, `tax_code`, `tax_percentage`, `description`, `tax_type`, `tax_status`, `date_created`, `date_modified`) VALUES
(1, 24, '1', 7.00, 'Purchases with gstd sdsds', '1', 2, '2014-05-20 13:40:17', '0000-00-00 00:00:00'),
(2, 24, '5', 2.00, 'Purchases with gst', '1', 1, '2014-05-20 13:40:27', '2014-05-20 13:40:40'),
(3, 24, '2', 2.00, 'Purchases with gst dds', '2', 1, '2014-05-20 13:40:37', '2014-05-20 13:40:38'),
(4, 24, '5', 2.00, 'Purchases with gst', '2', 2, '2014-05-20 13:40:48', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `theme_setting`
--

CREATE TABLE IF NOT EXISTS `theme_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `default_theme` tinyint(2) NOT NULL COMMENT '1 - Default, 2 - Not Default',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `theme_setting`
--

INSERT INTO `theme_setting` (`id`, `theme_name`, `description`, `default_theme`, `date_modified`) VALUES
(1, 'Red', 'Basic Theme', 2, '2014-06-05 16:38:56'),
(2, 'Black', 'Black Theme', 2, '2014-05-30 01:25:00'),
(3, 'Blue', 'Blue Theme', 1, '2014-06-05 16:38:56');

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
  `coa_link` int(11) NOT NULL COMMENT '5 - Trade Payables, 6 - Other Creditors',
  `other_coa_link` tinytext NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`vendor_id`),
  KEY `coa_link` (`coa_link`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `fkcompany_id`, `vendor_id`, `vendor_name`, `address1`, `address2`, `company_registration_no`, `office_number`, `fax_number`, `city`, `state`, `country`, `website`, `email`, `company_gst_no`, `postcode`, `gst_verified_date`, `delete_status`, `coa_link`, `other_coa_link`, `date_created`, `date_modified`) VALUES
(2, 24, 'VEN-0000000002', 'Dsdsd', 'sdsdsddsdsd', '', 'dsds', '434343334', '', 'Dsdsd', 'Sdsdsd', 'AU', '', '', '', '432343', '2014-05-23', 1, 5, '47,48', '2014-05-20 20:14:20', '2014-05-29 20:01:21'),
(3, 24, 'VEN-0000000003', 'Fdsfsdf', 'fsdfdsfdfdf', '', 'fdsfd', '43434', '', 'Fdfd', 'Fdfdf', 'AT', '', '', '', '543434', '2014-06-07', 1, 59, '', '2014-05-29 19:49:30', '2014-05-29 20:01:37');

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
