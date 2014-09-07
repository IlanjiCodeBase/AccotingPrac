-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 10, 2014 at 05:41 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

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
(12, 2, 1, 37, 'Buildings', 'INR', 1, 1, '2014-01-03 16:09:35', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fkcompany_id`, `customer_id`, `customer_name`, `address1`, `address2`, `company_registration_no`, `office_number`, `fax_number`, `city`, `state`, `country`, `website`, `email`, `company_gst_no`, `postcode`, `gst_verified_date`, `delete_status`, `date_created`, `date_modified`) VALUES
(13, 2, 'CUS-0000000001', 'Demo', 'Velachery 100', '', 'test123dd', '656546546', '', 'Hjhjhg', 'Jhgjghjdds', 'DZ', '', '', 'hjhgjg', '676767', '2014-01-24', 1, '2014-01-07 12:42:55', '2014-01-07 19:31:21'),
(14, 2, 'CUS-0000000002', 'ghghgh', 'ghgfhfhghfg', '', 'hghgfhg', '654654654', '', 'hgfhfh', 'hghgfh', 'FR', '', '', 'hghgf', '6565465', '2014-01-22', 1, '2014-01-08 10:15:18', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `customer_contact_person`
--

INSERT INTO `customer_contact_person` (`id`, `fkcustomer_id`, `contact_name`, `designation`, `contact_office_number`, `contact_mobile_number`, `contact_email`, `default_key_contact`, `contact_type`, `date_created`, `date_modified`) VALUES
(4, 13, 'Tester', 'Jggj', '', '655656', 'test@gmail.com', 1, 1, '2014-01-07 12:42:55', '2014-01-07 19:05:25'),
(6, 13, 'Test123', 'Fdsgsg', '', '9994533083', 'dfdgg@ymail.com', 2, 1, '2014-01-07 19:05:25', '2014-01-07 19:18:43'),
(9, 13, 'Test123', 'MDS', '', '7896541230', 'dfdgg@rediffmail.com', 2, 1, '2014-01-07 19:18:43', '2014-01-07 19:31:21'),
(10, 3, 'fdgfsgsdg', 'gfdgdf', '', '6566546', 'test@gmail.com', 1, 2, '2014-01-08 10:01:26', '0000-00-00 00:00:00'),
(11, 3, 'gfgfg', 'gfgf', '', '5454545', 'dfdgg@ymail.com', 2, 2, '2014-01-08 10:01:26', '0000-00-00 00:00:00'),
(12, 14, 'hghgfh', 'hgfhgf', '', '868787687', 'hghs@asd.com', 1, 1, '2014-01-08 10:15:18', '0000-00-00 00:00:00'),
(13, 5, 'gfdgdfg', 'gdgdgdf', '', '656556565', 'test@gmail.com', 1, 2, '2014-01-08 10:17:42', '0000-00-00 00:00:00'),
(14, 5, 'gffgfg', 'gfgfd', '', '656565', 'dfdgg@ymail.com', 2, 2, '2014-01-08 10:20:01', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `customer_shipping_address`
--

INSERT INTO `customer_shipping_address` (`id`, `fkcustomer_id`, `shipping_address1`, `shipping_address2`, `shipping_city`, `shipping_state`, `shipping_country`, `shipping_postcode`, `date_created`, `date_modified`) VALUES
(4, 13, 'jhjg', '', 'Jhggj', 'Jghj', 'AM', '67767', '2014-01-07 19:31:21', '2014-01-07 19:31:21'),
(6, 13, 'testing123', '', 'Chennai', 'Andhra', 'IN', '260102', '2014-01-07 19:31:21', '2014-01-07 19:31:21'),
(7, 13, 'dsdsd', '', 'Sdsada', 'Dsadfs', 'BS', '545445', '2014-01-07 19:31:21', '2014-01-07 19:31:21'),
(8, 14, 'hghgfh', '', 'hgfhfgh', 'hfgjfj', 'CR', '65656', '2014-01-08 10:15:18', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `tax_rate` varchar(255) NOT NULL,
  `product_type` int(2) NOT NULL COMMENT '1 - Buy, 2 - Sell',
  `fkaccount_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkaccount_id` (`fkaccount_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `products`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `receipt_uploads`
--

INSERT INTO `receipt_uploads` (`id`, `fkbusiness_id`, `name`, `receipt`, `extension`, `receipt_type`, `date_created`, `date_modified`) VALUES
(1, 13, 'Test', '13_7625_13.pdf', 'pdf', 1, '2014-01-08 17:23:24', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `fkcompany_id`, `vendor_id`, `vendor_name`, `address1`, `address2`, `company_registration_no`, `office_number`, `fax_number`, `city`, `state`, `country`, `website`, `email`, `company_gst_no`, `postcode`, `gst_verified_date`, `delete_status`, `date_created`, `date_modified`) VALUES
(2, 2, 'VEN-0000000001', 'dasd', 'dasdasdnbbnvbn', '', 'dsadsad', '565656', '', 'gfgfd', 'gfdg', 'AI', '', '', 'jljlljkl90980', '09090', '2014-01-15', 1, '2014-01-08 09:54:59', '0000-00-00 00:00:00'),
(3, 2, 'VEN-0000000002', 'Gfdgd', 'gfgfdgfdgfdg', '', '', '56546546546', '', 'Fggffdg', 'Gfdgdfgdfg', 'AW', '', '', 'gfgfdgdf', '6565464', '2014-01-14', 1, '2014-01-08 10:01:26', '2014-01-08 10:06:28'),
(5, 2, 'VEN-0000000003', 'Testing', 'degfgfdg fgfdgfd', '', 'gfgfg', '4534543543', '', 'Gfdgdfgd', 'Gdgdgf', 'KM', '', '', 'gdgdfgdf', '54545', '2014-01-23', 2, '2014-01-08 10:17:41', '2014-01-08 10:21:51');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_shipping_address`
--
ALTER TABLE `customer_shipping_address`
  ADD CONSTRAINT `customer_shipping_address_ibfk_1` FOREIGN KEY (`fkcustomer_id`) REFERENCES `customers` (`id`);
