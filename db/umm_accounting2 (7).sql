-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 25, 2014 at 02:15 PM
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
  `invoice_status` tinyint(2) NOT NULL COMMENT '1 - Saved, 2 - Draft, 3 - Sent',
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
(6, 2, 'INV-0000000001', '2014-01-22', 13, 4, '3', '2014-02-06', 'SGD', 1, 1, 'test11233', '', 3, '2014-01-22 18:53:45', '2014-01-24 18:03:17'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `discount_status`, `discount_amount`, `payment_description`, `payment_status`, `date_created`, `date_modified`, `fkiei_id`, `date`, `fkpayment_account`, `payment_amount`, `payment_method`, `cheque_draft_no`) VALUES
(2, 2, 0.00, '', 3, '2014-01-24 15:49:28', '0000-00-00 00:00:00', 6, '2014-01-07', 10, 2000.00, 1, ''),
(3, 2, 0.00, 'gf dfgdfg', 3, '2014-01-24 15:51:02', '2014-01-24 16:35:53', 6, '2014-01-29', 12, 100.00, 2, 'fsdfsgfgf'),
(6, 1, 100.00, 'Test 123', 2, '2014-01-25 15:15:12', '0000-00-00 00:00:00', 8, '2014-01-22', 9, 350.00, 3, 'ljjklkj545');

--
-- Constraints for dumped tables
--

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
