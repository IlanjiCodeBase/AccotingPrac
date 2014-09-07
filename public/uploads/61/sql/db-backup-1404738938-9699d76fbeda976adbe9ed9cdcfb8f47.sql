

CREATE TABLE `account` (
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO account VALUES("1","2","1","0","Unrealised Foreign Exchange Gain / (Loss)","","0.00","0.00","0","2","1","2014-07-07 18:12:50","0000-00-00 00:00:00");
INSERT INTO account VALUES("2","4","3","0","Foreign Exchange Gain/(Loss)","","0.00","0.00","0","2","1","2014-07-07 18:12:50","0000-00-00 00:00:00");
INSERT INTO account VALUES("3","1","1","4","Trade Receivables","","0.00","0.00","0","2","1","2014-07-07 18:12:50","0000-00-00 00:00:00");
INSERT INTO account VALUES("4","1","1","5","Account Receivables - Others","","0.00","0.00","0","2","1","2014-07-07 18:12:50","0000-00-00 00:00:00");
INSERT INTO account VALUES("5","2","1","3","Trade Creditors","","0.00","0.00","0","2","1","2014-07-07 18:12:50","0000-00-00 00:00:00");
INSERT INTO account VALUES("6","2","1","8","Account Payables - Others","","0.00","0.00","0","2","1","2014-07-07 18:12:50","0000-00-00 00:00:00");
INSERT INTO account VALUES("7","3","1","0","Discounts Given","","0.00","0.00","0","2","1","2014-07-07 18:12:50","0000-00-00 00:00:00");
INSERT INTO account VALUES("8","4","1","0","Discounts Received","","0.00","0.00","0","2","1","2014-07-07 18:12:50","0000-00-00 00:00:00");
INSERT INTO account VALUES("9","5","4","1","Retained Earnings","","0.00","0.00","0","2","1","2014-07-07 18:12:50","0000-00-00 00:00:00");
INSERT INTO account VALUES("10","5","4","1","Current Year Earnings","","0.00","0.00","0","2","1","2014-07-07 18:12:50","0000-00-00 00:00:00");
INSERT INTO account VALUES("11","2","1","4","Sales Tax Payables","","0.00","0.00","0","2","1","2014-07-07 18:12:50","0000-00-00 00:00:00");
INSERT INTO account VALUES("12","4","3","8","Income Tax","","0.00","0.00","0","2","1","2014-07-07 18:12:50","0000-00-00 00:00:00");
INSERT INTO account VALUES("13","4","1","1","Purchases of Raw Material","SGD","0.00","0.00","2","1","1","2014-07-07 18:22:10","0000-00-00 00:00:00");
INSERT INTO account VALUES("14","3","1","1","Agricultural Program Payments","SGD","0.00","0.00","2","1","1","2014-07-07 18:30:22","0000-00-00 00:00:00");





CREATE TABLE `accounting_entries` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `audit_log` (
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO audit_log VALUES("1","61","1","1","7","vendor1","1","2014-07-07 18:21:28");
INSERT INTO audit_log VALUES("2","61","1","1","8","Purchases of Raw Material","13","2014-07-07 18:22:10");
INSERT INTO audit_log VALUES("3","61","1","1","6","dfdsfdsf","1","2014-07-07 18:29:38");
INSERT INTO audit_log VALUES("4","61","1","1","8","Agricultural Program Payments","14","2014-07-07 18:30:23");
INSERT INTO audit_log VALUES("5","61","1","1","1","Income","1","2014-07-07 18:30:43");
INSERT INTO audit_log VALUES("6","61","1","1","2","Expense","1","2014-07-07 18:36:52");





CREATE TABLE `credit` (
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
  KEY `approval_for` (`approval_for`),
  CONSTRAINT `credit_ibfk_1` FOREIGN KEY (`fkinvoice_id`) REFERENCES `invoice` (`id`),
  CONSTRAINT `credit_ibfk_2` FOREIGN KEY (`fkcustomer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `credit_product_list` (
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
  KEY `fktax_id` (`fktax_id`),
  CONSTRAINT `credit_product_list_ibfk_2` FOREIGN KEY (`fkcredit_id`) REFERENCES `credit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `customer_contact_person` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `customer_shipping_address` (
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
  KEY `fkcustomer_id` (`fkcustomer_id`),
  CONSTRAINT `customer_shipping_address_ibfk_1` FOREIGN KEY (`fkcustomer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `customers` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO customers VALUES("1","61","CUS-0000000001","dfdsfdsf","fdfdsffdfdsf","","fdfdsfds","3434343","","fdfdsf","","AU","","","","fdfdsf","0000-00-00","3","","1","2014-07-07 18:29:38","0000-00-00 00:00:00");





CREATE TABLE `expense_transaction` (
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
  `total_gst` decimal(11,2) NOT NULL,
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
  CONSTRAINT `expense_transaction_ibfk_1` FOREIGN KEY (`fkvendor_id`) REFERENCES `vendors` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction VALUES("1","61","EXP-0000000001","2014-07-07","dfdsfdsf","1","","2","2014-08-06","SGD","0.00000","0.00","","2","0.00","dsfds","","","74","2","2","0","0000-00-00","1","2014-07-07 18:36:52","0000-00-00 00:00:00");





CREATE TABLE `expense_transaction_list` (
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
  KEY `fktax_id` (`fktax_id`),
  CONSTRAINT `expense_transaction_list_ibfk_1` FOREIGN KEY (`fkexpense_id`) REFERENCES `expense_transaction` (`id`),
  CONSTRAINT `expense_transaction_list_ibfk_2` FOREIGN KEY (`fkexpense_type`) REFERENCES `account` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction_list VALUES("1","1","13","sdsd","dsad","33","343.00","0","0.00","2014-07-07 18:36:52","0000-00-00 00:00:00");





CREATE TABLE `income_transaction` (
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
  CONSTRAINT `income_transaction_ibfk_1` FOREIGN KEY (`fkcustomer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `income_transaction_ibfk_2` FOREIGN KEY (`fkpayment_account`) REFERENCES `account` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO income_transaction VALUES("1","61","INC-0000000001","2014-07-07","fdfdfd","1","","3","SGD","0.00000","14","fdsfdsffdfdfdsfds","4343.00","","0","0.00","74","2","2","0","0000-00-00","1","2014-07-07 18:30:43","0000-00-00 00:00:00");





CREATE TABLE `invoice` (
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
  `payment_status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '1- Completed, 2 - Pending',
  `payment_id` int(11) NOT NULL,
  `final_payment_date` date NOT NULL,
  `sent_status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '1 - Sent, 2 - Not Sent',
  `delete_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_no` (`invoice_no`),
  KEY `fkcompany_id` (`fkcompany_id`,`fkcustomer_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `approval_for` (`approval_for`),
  CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`fkcustomer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `invoice_credit_note_customization` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO invoice_credit_note_customization VALUES("1","2","","2","INV","0","CR","0","2","0","SGD","1");





CREATE TABLE `invoice_product_list` (
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
  KEY `fktax_id` (`fktax_id`),
  CONSTRAINT `invoice_product_list_ibfk_1` FOREIGN KEY (`fkinvoice_id`) REFERENCES `invoice` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `journal_entries` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `journal_entries_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkjournal_id` int(11) NOT NULL,
  `fkaccount_id` int(11) DEFAULT NULL,
  `journal_description` tinytext NOT NULL,
  `debit` decimal(11,2) NOT NULL,
  `credit` decimal(11,2) NOT NULL,
  `bank_date` date NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkjournal_id` (`fkjournal_id`,`fkaccount_id`),
  KEY `fkaccount_id` (`fkaccount_id`),
  CONSTRAINT `journal_entries_list_ibfk_1` FOREIGN KEY (`fkjournal_id`) REFERENCES `journal_entries` (`id`),
  CONSTRAINT `journal_entries_list_ibfk_2` FOREIGN KEY (`fkaccount_id`) REFERENCES `account` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification` tinyint(2) NOT NULL COMMENT '1 - On, 2 - Off',
  `email_setting` tinyint(2) NOT NULL COMMENT '1 - Immediate, 2 - Off',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO notifications VALUES("1","1","2","2014-07-07 18:12:50","0000-00-00 00:00:00");





CREATE TABLE `payments` (
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
  KEY `fkpayment_account` (`fkpayment_account`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`fkpayment_account`) REFERENCES `account` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `products` (
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
  KEY `fkcompany_id` (`fkcompany_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`fkincomeaccount_id`) REFERENCES `account` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `receipt_uploads` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `taxcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcompany_id` int(11) NOT NULL,
  `tax_code` smallint(4) NOT NULL,
  `tax_percentage` decimal(6,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `tax_type` tinyint(2) NOT NULL COMMENT '1 - Purchase, 2 - Supply',
  `tax_status` int(2) NOT NULL DEFAULT '2' COMMENT '1 - active, 2 - inactive',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkcompany_id` (`fkcompany_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `theme_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `default_theme` tinyint(2) NOT NULL COMMENT '1 - Default, 2 - Not Default',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO theme_setting VALUES("1","Red","Basic Theme","1","2014-07-07 18:12:50");
INSERT INTO theme_setting VALUES("2","Black","Black Theme","2","2014-07-07 18:12:50");
INSERT INTO theme_setting VALUES("3","Blue","Blue Theme","2","2014-07-07 18:12:50");





CREATE TABLE `vendors` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO vendors VALUES("1","61","VEN-0000000001","vendor1","dffdsfdsfds","","fdfsdfdsf","434343344","","fdfdsfdsf","","AU","","","","434343","0000-00-00","1","5","","2014-07-07 18:21:28","0000-00-00 00:00:00");



