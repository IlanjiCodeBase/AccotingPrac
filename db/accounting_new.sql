-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 06, 2014 at 02:28 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bill`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bill_transaction`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `company_database`
--

INSERT INTO `company_database` (`id`, `fkcompany_id`, `server_address`, `username`, `password`, `database_name`, `date_created`, `date_modified`) VALUES
(1, 1, 'main_default', '', '', 'accounting', '2013-12-18 11:59:36', '0000-00-00 00:00:00'),
(2, 2, 'default', '', '', 'umm_accounting2', '2013-12-26 12:02:07', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `company_details`
--

INSERT INTO `company_details` (`id`, `company_name`, `company_uen`, `company_gst`, `telephone`, `block_no`, `street_name`, `level`, `unit_no`, `city`, `zip_code`, `region`, `country`, `financial_year_start_date`, `financial_year_end_date`, `currency`, `status`, `company_type`, `date_created`, `date_modified`) VALUES
(1, 'Xpand', 't454543543547676', 'hiuooiog12345678', '', NULL, 'ghgfhgfh', NULL, NULL, NULL, NULL, NULL, 'SG', '0000-00-00', '0000-00-00', '', 1, 0, '2013-12-18 11:53:52', '0000-00-00 00:00:00'),
(2, 'UMM Tech', 'sfdfs4545454s', 'dgdfg435345s', '', '', 'Velacherys', '', '', 'chennais', '600102', '', 'IN', '03-12', '01-12', 'INR', 1, 1, '2013-12-19 14:50:14', '2014-01-02 10:33:08'),
(3, 'techy', '40494ijgfkfkdgdk', 'ofdpsif40540394', '09343003430', '', 'gfgdg', '', '', '', '', '', 'AS', '18-12', '20-12', '', 2, 1, '2013-12-23 10:12:19', '2013-12-23 12:24:21');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `customer`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `customer_transaction`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `default_system_accounts`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `invoice`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `invoice_transaction`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `login_credentials`
--

INSERT INTO `login_credentials` (`id`, `username`, `password`, `fkcompany_id`, `account_type`, `account_status`, `date_created`, `date_modified`) VALUES
(2, 'divagarn@ummtech.com', '5f4dcc3b5aa765d61d8327deb882cf99', 2, 3, 1, '2013-12-19 14:50:14', '2013-12-20 11:49:19'),
(3, 'divagar@ummtech.com', '5f4dcc3b5aa765d61d8327deb882cf99', 3, 2, 1, '2013-12-23 10:12:19', '0000-00-00 00:00:00'),
(4, 'admin@ummtech.com', '5f4dcc3b5aa765d61d8327deb882cf99', 1, 0, 1, '2013-12-23 12:22:30', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `split_transaction`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sub_accounts`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `transactions`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `vendor`
--


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
-- Constraints for table `company_database`
--
ALTER TABLE `company_database`
  ADD CONSTRAINT `company_database_ibfk_1` FOREIGN KEY (`fkcompany_id`) REFERENCES `company_details` (`id`);

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
-- Constraints for table `login_credentials`
--
ALTER TABLE `login_credentials`
  ADD CONSTRAINT `login_credentials_ibfk_1` FOREIGN KEY (`fkcompany_id`) REFERENCES `company_details` (`id`);

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
