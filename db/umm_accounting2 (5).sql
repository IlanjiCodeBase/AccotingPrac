-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 20, 2014 at 01:41 PM
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
  `transaction_status` tinyint(2) NOT NULL COMMENT '1 - Approved/Verified, 2 - Unverified',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_no` (`expense_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkvendor_id`),
  KEY `fkcustomer_id` (`fkvendor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `expense_transaction`
--

INSERT INTO `expense_transaction` (`id`, `fkcompany_id`, `expense_no`, `date`, `receipt_no`, `fkvendor_id`, `shipping_address`, `credit_term`, `due_date`, `transaction_currency`, `discount_status`, `discount_amount`, `permit_no`, `do_so_no`, `transaction_status`, `date_created`, `date_modified`) VALUES
(8, 2, 'EXP-0000000003', '2014-01-20', '123456998', 2, '1', '1', '2014-01-20', 'SGD', 1, 25.00, 'ghghg', '', 1, '2014-01-20 11:13:22', '2014-01-20 12:32:36');

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
  `fktax_id` int(11) NOT NULL,
  `tax_value` decimal(6,2) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkexpense_id` (`fkexpense_id`),
  KEY `fkexpense_type` (`fkexpense_type`),
  KEY `fktax_id` (`fktax_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `expense_transaction_list`
--

INSERT INTO `expense_transaction_list` (`id`, `fkexpense_id`, `fkexpense_type`, `product_id`, `product_description`, `quantity`, `unit_price`, `fktax_id`, `tax_value`, `date_created`, `date_modified`) VALUES
(5, 8, 13, 'hgh', 'hg', 2, 50.00, 2, 20.00, '2014-01-20 11:13:22', '0000-00-00 00:00:00'),
(7, 8, 13, 'hgh', 'hg', 2, 50.00, 2, 20.00, '2014-01-20 12:27:52', '0000-00-00 00:00:00'),
(9, 8, 13, '122', 'gfdgdfg', 4, 43.00, 2, 20.00, '2014-01-20 12:32:37', '0000-00-00 00:00:00');

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
  `fktax_id` int(11) NOT NULL,
  `tax_value` decimal(6,2) NOT NULL,
  `transaction_status` tinyint(2) NOT NULL COMMENT '1 - Approved/Verified, 2 - Unverified',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_no` (`income_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkcustomer_id`,`fkpayment_account`,`fkincome_type`,`fktax_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `fktax_id` (`fktax_id`),
  KEY `fkpayment_account` (`fkpayment_account`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `income_transaction`
--

INSERT INTO `income_transaction` (`id`, `fkcompany_id`, `income_no`, `date`, `receipt_no`, `fkcustomer_id`, `fkpayment_account`, `credit_term`, `transaction_currency`, `fkincome_type`, `transaction_description`, `amount`, `fktax_id`, `tax_value`, `transaction_status`, `date_created`, `date_modified`) VALUES
(2, 2, 'INC-0000000001', '2014-01-17', 'dsads', 14, 10, '4', 'BDT', 2, 'test 123ddsdyy', 201.50, 1, 12.00, 1, '2014-01-17 17:29:20', '2014-01-17 18:04:57'),
(4, 2, 'INC-0000000002', '2014-01-17', 'dfdfds', 13, 9, '3', 'SGD', 2, 'fdfdsfdsfgfds', 543543.00, 1, 12.00, 1, '2014-01-17 17:32:49', '2014-01-17 19:36:23'),
(5, 2, 'INC-0000000003', '2014-01-17', 'dfdfds', 13, 8, '1', 'AFA', 2, 'fdfdsfdsfgfds', 543543.00, 0, 0.00, 2, '2014-01-18 11:44:03', '0000-00-00 00:00:00'),
(6, 2, 'INC-0000000004', '2014-01-17', 'dsads', 14, 10, '4', 'BDT', 2, 'test 123ddsdyy', 201.50, 1, 12.00, 1, '2014-01-18 11:48:09', '0000-00-00 00:00:00'),
(11, 2, 'INC-0000000005', '2014-01-17', 'dsads', 14, 10, '4', 'BDT', 2, 'test 123ddsdyy', 201.50, 1, 12.00, 1, '2014-01-18 12:07:18', '0000-00-00 00:00:00');

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

--
-- Constraints for dumped tables
--

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
  ADD CONSTRAINT `expense_transaction_list_ibfk_2` FOREIGN KEY (`fkexpense_type`) REFERENCES `account` (`id`),
  ADD CONSTRAINT `expense_transaction_list_ibfk_3` FOREIGN KEY (`fktax_id`) REFERENCES `taxcodes` (`id`);

--
-- Constraints for table `income_transaction`
--
ALTER TABLE `income_transaction`
  ADD CONSTRAINT `income_transaction_ibfk_1` FOREIGN KEY (`fkcustomer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `income_transaction_ibfk_2` FOREIGN KEY (`fkpayment_account`) REFERENCES `account` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`fkincomeaccount_id`) REFERENCES `account` (`id`);
