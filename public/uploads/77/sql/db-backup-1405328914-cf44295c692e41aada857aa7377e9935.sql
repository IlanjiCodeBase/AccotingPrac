

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
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

INSERT INTO account VALUES("1","2","1","0","Unrealised Foreign Exchange Gain / (Loss)","","0.00","0.00","0","2","1","2014-07-14 13:52:52","0000-00-00 00:00:00");
INSERT INTO account VALUES("2","4","3","0","Foreign Exchange Gain/(Loss)","","0.00","0.00","0","2","1","2014-07-14 13:52:52","0000-00-00 00:00:00");
INSERT INTO account VALUES("3","1","1","4","Trade Receivables","","0.00","0.00","0","2","1","2014-07-14 13:52:52","0000-00-00 00:00:00");
INSERT INTO account VALUES("4","1","1","5","Account Receivables - Others","","0.00","0.00","0","2","1","2014-07-14 13:52:52","0000-00-00 00:00:00");
INSERT INTO account VALUES("5","2","1","3","Trade Creditors","","0.00","0.00","0","2","1","2014-07-14 13:52:52","0000-00-00 00:00:00");
INSERT INTO account VALUES("6","2","1","8","Account Payables - Others","","0.00","0.00","0","2","1","2014-07-14 13:52:52","0000-00-00 00:00:00");
INSERT INTO account VALUES("7","3","1","0","Discounts Given","","0.00","0.00","0","2","1","2014-07-14 13:52:52","0000-00-00 00:00:00");
INSERT INTO account VALUES("8","4","1","0","Discounts Received","","0.00","0.00","0","2","1","2014-07-14 13:52:52","0000-00-00 00:00:00");
INSERT INTO account VALUES("9","5","4","1","Retained Earnings","","0.00","0.00","0","2","1","2014-07-14 13:52:52","0000-00-00 00:00:00");
INSERT INTO account VALUES("10","5","4","1","Current Year Earnings","","0.00","0.00","0","2","1","2014-07-14 13:52:52","0000-00-00 00:00:00");
INSERT INTO account VALUES("11","2","1","4","Sales Tax Payables","","0.00","0.00","0","2","1","2014-07-14 13:52:52","0000-00-00 00:00:00");
INSERT INTO account VALUES("12","4","3","8","Income Tax","","0.00","0.00","0","2","1","2014-07-14 13:52:52","0000-00-00 00:00:00");
INSERT INTO account VALUES("13","1","1","1","Cash in Hand","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("14","1","1","1","Petty Cash","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("15","1","1","1","UOB Bank","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("16","1","1","1","Fixed Deposits","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("17","1","1","1","OCBC Bank","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("18","1","1","3","Inventory","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("19","1","1","6","Rental Deposit","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("20","1","1","6","Security Deposit","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("21","1","1","5","Interest Receivbales","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("22","1","1","5","Staff Loan","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("23","1","2","3","Machinery","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("24","1","2","3","Acc. Depn - Machinery","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("25","1","2","3","F & F","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("26","1","2","3","Acc. Depn - F & F","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("27","1","2","3","Computers","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("28","1","2","3","Acc. Depn - Computers","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("29","2","1","8","CPF Board Payable","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("30","2","1","8","Staff Payables","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("31","5","1","1","Capital Account","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("32","2","1","8","Rent Payable","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("33","1","1","5","Rent Receivable","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("34","3","1","7","Sales - Food","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("35","3","1","7","Sales - B/V","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("36","3","1","7","Sales - Misc","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("37","3","1","7","Service Charge","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("38","3","1","8","Misc. Rcpts.","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("39","3","2","1","Admin Fees Income","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("40","3","2","2","Interest Income - Fixed Deposits","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("41","3","2","4","Other Non Operating Income","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("42","3","3","1","Government Grants - PIC","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("43","3","3","1","Government Grants - SEC","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("44","4","1","1","Opening Stock","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("45","4","1","1","Purchases - Food","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("46","4","1","1","Purchases - B/V","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("47","4","1","1","Purchases - Misc.","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("48","4","1","1","Closing Stock","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("49","4","2","6","Advertising & Promotion","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("50","4","2","9","Shop Maintance","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("51","4","2","9","Kitchen Maintance","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("52","4","2","9","Kitchen Equipment Maintenance","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("53","4","2","9","Cleaing Items","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("54","4","2","9","Cleaing Contractor","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("55","4","2","11","Salary & Wages","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("56","4","2","11","Overtime","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("57","4","2","11","Sales Promotion","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("58","4","2","11","CPF","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("59","4","2","11","SDL","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("60","4","2","11","Staff Welfare","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("61","4","2","11","Staff medical Expenses","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("62","4","2","17","Electricity / Water / Gas","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("63","1","2","5","Renovation in Progress","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("64","4","2","8","Warehouse Rental","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("65","4","3","1","Depreciation","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");
INSERT INTO account VALUES("66","3","1","8","Rental Income","SGD","0.00","0.00","2","1","1","2014-07-14 13:56:59","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

INSERT INTO accounting_entries VALUES("1","1","1","2675.00","2014-04-25","1","1","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("2","1","5","2500.00","2014-04-25","1","2","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("3","1","4","175.00","2014-04-25","1","2","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("4","2","1","2675.00","2014-05-25","1","1","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("5","2","5","2500.00","2014-05-25","1","2","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("6","2","4","175.00","2014-05-25","1","2","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("7","3","1","312.50","2014-05-31","1","1","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("8","3","5","312.50","2014-05-31","1","2","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("9","3","4","0.00","2014-05-31","1","2","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("10","1","1","2675.00","2014-06-01","3","1","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("11","1","5","2500.00","2014-06-01","3","2","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("12","1","4","175.00","2014-06-01","3","2","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("13","5","1","2675.00","2014-05-01","3","1","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("14","5","5","2500.00","2014-05-01","3","2","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("15","5","4","175.00","2014-05-01","3","2","1","2014-07-14 14:00:55","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("16","1","2","10700.00","2014-04-01","2","2","1","2014-07-14 14:01:25","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("17","2","2","530.80","2014-04-14","2","2","1","2014-07-14 14:01:25","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("18","3","2","1065.80","2014-05-14","2","2","1","2014-07-14 14:01:25","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("19","4","2","1070.00","2014-04-01","2","2","1","2014-07-14 14:01:25","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("20","5","2","5868.95","2014-04-01","2","2","1","2014-07-14 14:01:25","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("21","6","2","21400.00","2014-04-01","2","2","1","2014-07-14 14:01:25","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("22","7","2","10700.00","2014-04-01","2","2","1","2014-07-14 14:01:25","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("23","8","2","5350.00","2014-04-01","2","2","1","2014-07-14 14:01:25","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("24","9","2","2140.00","2014-04-01","2","2","1","2014-07-14 14:01:25","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("25","10","2","2500.00","2014-04-15","2","2","1","2014-07-14 14:01:25","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("26","11","2","16050.00","2014-04-30","2","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("27","12","2","16478.00","2014-05-01","2","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("28","13","2","42800.00","2014-05-01","2","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("29","14","2","10700.00","2014-05-01","2","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("30","15","2","5350.00","2014-05-01","2","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("31","16","2","2140.00","2014-05-01","2","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("32","17","2","16050.00","2014-05-31","2","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("33","2","1","24075.00","2014-04-15","3","1","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("34","2","5","22500.00","2014-04-15","3","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("35","2","4","1575.00","2014-04-15","3","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("36","3","1","16050.00","2014-04-15","3","1","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("37","3","5","15000.00","2014-04-15","3","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("38","3","4","1050.00","2014-04-15","3","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("39","4","1","13910.00","2014-04-30","3","1","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("40","4","5","13000.00","2014-04-30","3","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("41","4","4","910.00","2014-04-30","3","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("42","6","1","4872.78","2014-05-05","3","1","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("43","6","5","4554.00","2014-05-05","3","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("44","6","4","318.78","2014-05-05","3","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("45","7","1","50290.00","2014-05-15","3","1","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("46","7","5","47000.00","2014-05-15","3","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("47","7","4","3290.00","2014-05-15","3","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("48","8","1","43870.00","2014-05-15","3","1","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("49","8","5","41000.00","2014-05-15","3","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("50","8","4","2870.00","2014-05-15","3","2","1","2014-07-14 14:01:40","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=latin1;

INSERT INTO audit_log VALUES("1","77","1","1","9","15","1","2014-07-14 13:54:05");
INSERT INTO audit_log VALUES("2","77","1","1","9","14","2","2014-07-14 13:54:13");
INSERT INTO audit_log VALUES("3","77","1","1","9","13","3","2014-07-14 13:54:21");
INSERT INTO audit_log VALUES("4","77","1","1","9","3","4","2014-07-14 13:54:28");
INSERT INTO audit_log VALUES("5","77","1","1","9","23","5","2014-07-14 13:54:36");
INSERT INTO audit_log VALUES("6","77","1","1","8","Cash in Hand","13","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("7","77","1","1","8","Petty Cash","14","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("8","77","1","1","8","UOB Bank","15","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("9","77","1","1","8","Fixed Deposits","16","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("10","77","1","1","8","OCBC Bank","17","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("11","77","1","1","8","Inventory","18","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("12","77","1","1","8","Rental Deposit","19","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("13","77","1","1","8","Security Deposit","20","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("14","77","1","1","8","Interest Receivbales","21","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("15","77","1","1","8","Staff Loan","22","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("16","77","1","1","8","Machinery","23","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("17","77","1","1","8","Acc. Depn - Machinery","24","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("18","77","1","1","8","F & F","25","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("19","77","1","1","8","Acc. Depn - F & F","26","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("20","77","1","1","8","Computers","27","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("21","77","1","1","8","Acc. Depn - Computers","28","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("22","77","1","1","8","CPF Board Payable","29","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("23","77","1","1","8","Staff Payables","30","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("24","77","1","1","8","Capital Account","31","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("25","77","1","1","8","Rent Payable","32","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("26","77","1","1","8","Rent Receivable","33","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("27","77","1","1","8","Sales - Food","34","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("28","77","1","1","8","Sales - B/V","35","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("29","77","1","1","8","Sales - Misc","36","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("30","77","1","1","8","Service Charge","37","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("31","77","1","1","8","Misc. Rcpts.","38","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("32","77","1","1","8","Admin Fees Income","39","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("33","77","1","1","8","Interest Income - Fixed Deposits","40","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("34","77","1","1","8","Other Non Operating Income","41","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("35","77","1","1","8","Government Grants - PIC","42","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("36","77","1","1","8","Government Grants - SEC","43","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("37","77","1","1","8","Opening Stock","44","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("38","77","1","1","8","Purchases - Food","45","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("39","77","1","1","8","Purchases - B/V","46","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("40","77","1","1","8","Purchases - Misc.","47","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("41","77","1","1","8","Closing Stock","48","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("42","77","1","1","8","Advertising & Promotion","49","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("43","77","1","1","8","Shop Maintance","50","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("44","77","1","1","8","Kitchen Maintance","51","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("45","77","1","1","8","Kitchen Equipment Maintenance","52","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("46","77","1","1","8","Cleaing Items","53","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("47","77","1","1","8","Cleaing Contractor","54","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("48","77","1","1","8","Salary & Wages","55","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("49","77","1","1","8","Overtime","56","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("50","77","1","1","8","Sales Promotion","57","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("51","77","1","1","8","CPF","58","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("52","77","1","1","8","SDL","59","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("53","77","1","1","8","Staff Welfare","60","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("54","77","1","1","8","Staff medical Expenses","61","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("55","77","1","1","8","Electricity / Water / Gas","62","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("56","77","1","1","8","Renovation in Progress","63","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("57","77","1","1","8","Warehouse Rental","64","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("58","77","1","1","8","Depreciation","65","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("59","77","1","1","8","Rental Income","66","2014-07-14 13:56:59");
INSERT INTO audit_log VALUES("60","77","1","1","10","Pizza 12\"","1","2014-07-14 13:57:16");
INSERT INTO audit_log VALUES("61","77","1","1","10","Pizza 8\"","2","2014-07-14 13:57:16");
INSERT INTO audit_log VALUES("62","77","1","1","10","Pasta 01","3","2014-07-14 13:57:16");
INSERT INTO audit_log VALUES("63","77","1","1","10","Pasta 02","4","2014-07-14 13:57:16");
INSERT INTO audit_log VALUES("64","77","1","1","10","Pizza Dong","5","2014-07-14 13:57:16");
INSERT INTO audit_log VALUES("65","77","1","1","10","Service Charge - $100","6","2014-07-14 13:57:16");
INSERT INTO audit_log VALUES("66","77","1","1","10","Service Charge - $50","7","2014-07-14 13:57:16");
INSERT INTO audit_log VALUES("67","77","1","1","10","Whisky","8","2014-07-14 13:57:16");
INSERT INTO audit_log VALUES("68","77","1","1","10","Wine","9","2014-07-14 13:57:16");
INSERT INTO audit_log VALUES("69","77","1","1","10","Home Made Pasta","10","2014-07-14 13:57:16");
INSERT INTO audit_log VALUES("70","77","1","1","10","Rent - 113B","11","2014-07-14 13:57:16");
INSERT INTO audit_log VALUES("71","77","1","1","6","OPH","1","2014-07-14 13:57:29");
INSERT INTO audit_log VALUES("72","77","1","1","6","EZH & Qh","2","2014-07-14 13:57:29");
INSERT INTO audit_log VALUES("73","77","1","1","6","Dome - Dubai","3","2014-07-14 13:57:29");
INSERT INTO audit_log VALUES("74","77","1","1","6","Ciao Cafe - Vietnam","4","2014-07-14 13:57:29");
INSERT INTO audit_log VALUES("75","77","1","1","6","Melinium Sdn Bhd","5","2014-07-14 13:57:29");
INSERT INTO audit_log VALUES("76","77","1","1","6","Temasek LLC","6","2014-07-14 13:57:29");
INSERT INTO audit_log VALUES("77","77","1","1","6","Grean Ocean Pte Ltd","7","2014-07-14 13:57:29");
INSERT INTO audit_log VALUES("78","77","1","1","6","Indian Bank","8","2014-07-14 13:57:29");
INSERT INTO audit_log VALUES("79","77","1","1","6","Indian Overseas Bank","9","2014-07-14 13:57:29");
INSERT INTO audit_log VALUES("80","77","1","1","7","Natrad Foods","1","2014-07-14 13:57:40");
INSERT INTO audit_log VALUES("81","77","1","1","7","FoodXervices","2","2014-07-14 13:57:40");
INSERT INTO audit_log VALUES("82","77","1","1","7","APB","3","2014-07-14 13:57:40");
INSERT INTO audit_log VALUES("83","77","1","1","7","Magnum Wines","4","2014-07-14 13:57:40");
INSERT INTO audit_log VALUES("84","77","1","1","7","AA Corporation - Vietnam","5","2014-07-14 13:57:40");
INSERT INTO audit_log VALUES("85","77","1","1","7","Bakers & Chef - Italy","6","2014-07-14 13:57:40");
INSERT INTO audit_log VALUES("86","77","1","1","7","MCST 835","7","2014-07-14 13:57:40");
INSERT INTO audit_log VALUES("87","77","1","1","7","ID Ranger","8","2014-07-14 13:57:40");
INSERT INTO audit_log VALUES("88","77","1","1","7","Evergreen Cleaning Services","9","2014-07-14 13:57:40");
INSERT INTO audit_log VALUES("89","77","1","1","1","Income","1","2014-07-14 13:58:00");
INSERT INTO audit_log VALUES("90","77","1","1","1","Income","2","2014-07-14 13:58:05");
INSERT INTO audit_log VALUES("91","77","1","1","1","Income","3","2014-07-14 13:58:05");
INSERT INTO audit_log VALUES("92","77","1","1","3","Invoice","1","2014-07-14 13:58:05");
INSERT INTO audit_log VALUES("93","77","1","1","3","Invoice","2","2014-07-14 13:58:05");
INSERT INTO audit_log VALUES("94","77","1","1","2","Expense","1","2014-07-14 13:58:09");
INSERT INTO audit_log VALUES("95","77","1","1","2","Expense","2","2014-07-14 13:58:09");
INSERT INTO audit_log VALUES("96","77","1","1","3","Invoice","3","2014-07-14 13:58:34");
INSERT INTO audit_log VALUES("97","77","1","1","3","Invoice","4","2014-07-14 13:58:34");
INSERT INTO audit_log VALUES("98","77","1","1","3","Invoice","5","2014-07-14 13:58:34");
INSERT INTO audit_log VALUES("99","77","1","1","3","Invoice","6","2014-07-14 13:58:34");
INSERT INTO audit_log VALUES("100","77","1","1","3","Invoice","7","2014-07-14 13:58:34");
INSERT INTO audit_log VALUES("101","77","1","1","3","Invoice","8","2014-07-14 13:58:34");
INSERT INTO audit_log VALUES("102","77","1","1","2","Expense","3","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("103","77","1","1","2","Expense","4","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("104","77","1","1","2","Expense","5","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("105","77","1","1","2","Expense","6","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("106","77","1","1","2","Expense","7","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("107","77","1","1","2","Expense","8","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("108","77","1","1","2","Expense","9","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("109","77","1","1","2","Expense","10","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("110","77","1","1","2","Expense","11","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("111","77","1","1","2","Expense","12","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("112","77","1","1","2","Expense","13","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("113","77","1","1","2","Expense","14","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("114","77","1","1","2","Expense","15","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("115","77","1","1","2","Expense","16","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("116","77","1","1","2","Expense","17","2014-07-14 13:58:44");
INSERT INTO audit_log VALUES("117","77","97","9","12","Logged In","2","2014-07-14 14:00:04");
INSERT INTO audit_log VALUES("118","77","97","6","1","Income","1","2014-07-14 14:00:55");
INSERT INTO audit_log VALUES("119","77","97","6","1","Income","2","2014-07-14 14:00:55");
INSERT INTO audit_log VALUES("120","77","97","6","1","Income","3","2014-07-14 14:00:55");
INSERT INTO audit_log VALUES("121","77","97","6","3","Invoice","1","2014-07-14 14:00:55");
INSERT INTO audit_log VALUES("122","77","97","6","3","Invoice","5","2014-07-14 14:00:55");
INSERT INTO audit_log VALUES("123","77","97","6","2","Expense","1","2014-07-14 14:01:25");
INSERT INTO audit_log VALUES("124","77","97","6","2","Expense","2","2014-07-14 14:01:25");
INSERT INTO audit_log VALUES("125","77","97","6","2","Expense","3","2014-07-14 14:01:25");
INSERT INTO audit_log VALUES("126","77","97","6","2","Expense","4","2014-07-14 14:01:25");
INSERT INTO audit_log VALUES("127","77","97","6","2","Expense","5","2014-07-14 14:01:25");
INSERT INTO audit_log VALUES("128","77","97","6","2","Expense","6","2014-07-14 14:01:25");
INSERT INTO audit_log VALUES("129","77","97","6","2","Expense","7","2014-07-14 14:01:25");
INSERT INTO audit_log VALUES("130","77","97","6","2","Expense","8","2014-07-14 14:01:25");
INSERT INTO audit_log VALUES("131","77","97","6","2","Expense","9","2014-07-14 14:01:25");
INSERT INTO audit_log VALUES("132","77","97","6","2","Expense","10","2014-07-14 14:01:25");
INSERT INTO audit_log VALUES("133","77","97","6","2","Expense","11","2014-07-14 14:01:40");
INSERT INTO audit_log VALUES("134","77","97","6","2","Expense","12","2014-07-14 14:01:40");
INSERT INTO audit_log VALUES("135","77","97","6","2","Expense","13","2014-07-14 14:01:40");
INSERT INTO audit_log VALUES("136","77","97","6","2","Expense","14","2014-07-14 14:01:40");
INSERT INTO audit_log VALUES("137","77","97","6","2","Expense","15","2014-07-14 14:01:40");
INSERT INTO audit_log VALUES("138","77","97","6","2","Expense","16","2014-07-14 14:01:40");
INSERT INTO audit_log VALUES("139","77","97","6","2","Expense","17","2014-07-14 14:01:40");
INSERT INTO audit_log VALUES("140","77","97","6","3","Invoice","2","2014-07-14 14:01:40");
INSERT INTO audit_log VALUES("141","77","97","6","3","Invoice","3","2014-07-14 14:01:40");
INSERT INTO audit_log VALUES("142","77","97","6","3","Invoice","4","2014-07-14 14:01:40");
INSERT INTO audit_log VALUES("143","77","97","6","3","Invoice","6","2014-07-14 14:01:40");
INSERT INTO audit_log VALUES("144","77","97","6","3","Invoice","7","2014-07-14 14:01:40");
INSERT INTO audit_log VALUES("145","77","97","6","3","Invoice","8","2014-07-14 14:01:40");





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






CREATE TABLE `credit_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkcredit_id` int(11) NOT NULL,
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
  PRIMARY KEY (`id`),
  KEY `fkcompany_id` (`fkcredit_id`,`fkinvoice_id`,`fkcustomer_id`),
  KEY `fkinvoice_id` (`fkinvoice_id`,`fkcustomer_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `approval_for` (`approval_for`)
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






CREATE TABLE `credit_product_list_audit` (
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
  PRIMARY KEY (`id`),
  KEY `fkexpense_id` (`fkcredit_id`),
  KEY `fktax_id` (`fktax_id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO customers VALUES("1","77","CUS-0000000001","OPH","16 Sandilands Road","","1978885558M-PTE-04","69453482","","Singapore","Singapore","SG","","","","546080","0000-00-00","3","","1","2014-07-14 13:57:29","0000-00-00 00:00:00");
INSERT INTO customers VALUES("2","77","CUS-0000000002","EZH & Qh","123 Address Road","","1978885558M-PTE-05","69453483","","Singapore","Singapore","SG","","","","546080","0000-00-00","3","","1","2014-07-14 13:57:29","0000-00-00 00:00:00");
INSERT INTO customers VALUES("3","77","CUS-0000000003","Dome - Dubai","123 Address Road","","1978885558M-PTE-06","69453484","","Dubai","Dubai","AE","","","","546080","0000-00-00","3","","1","2014-07-14 13:57:29","0000-00-00 00:00:00");
INSERT INTO customers VALUES("4","77","CUS-0000000004","Ciao Cafe - Vietnam","123 Address Road","","1978885558M-PTE-07","69453485","","Ho Chi Minh","Saigon","VN","","","","546080","0000-00-00","3","","1","2014-07-14 13:57:29","0000-00-00 00:00:00");
INSERT INTO customers VALUES("5","77","CUS-0000000005","Melinium Sdn Bhd","123 Address Road","","1978885558M-PTE-08","69453486","","KL","Selangor","MY","","","","546080","0000-00-00","4","","1","2014-07-14 13:57:29","0000-00-00 00:00:00");
INSERT INTO customers VALUES("6","77","CUS-0000000006","Temasek LLC","123 Address Road","","1978885558M-PTE-09","69453487","","Dubai","Dubai","AE","","","","546080","0000-00-00","4","","1","2014-07-14 13:57:29","0000-00-00 00:00:00");
INSERT INTO customers VALUES("7","77","CUS-0000000007","Grean Ocean Pte Ltd","123 Address Road","","1978885558M-PTE-10","69453488","","Singapore","Singapore","SG","","","","546080","0000-00-00","33","","1","2014-07-14 13:57:29","0000-00-00 00:00:00");
INSERT INTO customers VALUES("8","77","CUS-0000000008","Indian Bank","123 Address Road","","1978885558M-PTE-11","69453489","","Singapore","Singapore","SG","","","","546080","0000-00-00","21","","1","2014-07-14 13:57:29","0000-00-00 00:00:00");
INSERT INTO customers VALUES("9","77","CUS-0000000009","Indian Overseas Bank","123 Address Road","","1978885558M-PTE-21","69453489","","Chennai","Tamil Nadu","IN","","","","600064","0000-00-00","21","","1","2014-07-14 13:57:29","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction VALUES("1","77","EXP-0000000001","2014-04-01","1","6","","2","2014-05-01","EUR","1.69090","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:09","2014-07-14 14:01:25");
INSERT INTO expense_transaction VALUES("2","77","EXP-0000000002","2014-04-14","PC1","7","","1","2014-04-14","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:09","2014-07-14 14:01:25");
INSERT INTO expense_transaction VALUES("3","77","EXP-0000000003","2014-05-14","PC2","7","","1","2014-05-14","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:25");
INSERT INTO expense_transaction VALUES("4","77","EXP-0000000004","2014-04-01","2","5","","3","2014-05-31","USD","1.24030","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:25");
INSERT INTO expense_transaction VALUES("5","77","EXP-0000000005","2014-04-01","3","1","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:25");
INSERT INTO expense_transaction VALUES("6","77","EXP-0000000006","2014-04-01","4","3","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:25");
INSERT INTO expense_transaction VALUES("7","77","EXP-0000000007","2014-04-01","5","4","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:25");
INSERT INTO expense_transaction VALUES("8","77","EXP-0000000008","2014-04-01","6","2","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:25");
INSERT INTO expense_transaction VALUES("9","77","EXP-0000000009","2014-04-01","7","7","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:25");
INSERT INTO expense_transaction VALUES("10","77","EXP-0000000010","2014-04-15","8","8","","2","2014-05-15","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:25");
INSERT INTO expense_transaction VALUES("11","77","EXP-0000000011","2014-04-30","9","9","","2","2014-05-30","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:40");
INSERT INTO expense_transaction VALUES("12","77","EXP-0000000012","2014-05-01","10","1","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:40");
INSERT INTO expense_transaction VALUES("13","77","EXP-0000000013","2014-05-01","11","3","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:40");
INSERT INTO expense_transaction VALUES("14","77","EXP-0000000014","2014-05-01","12","4","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:40");
INSERT INTO expense_transaction VALUES("15","77","EXP-0000000015","2014-05-01","13","2","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:40");
INSERT INTO expense_transaction VALUES("16","77","EXP-0000000016","2014-05-01","14","7","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:40");
INSERT INTO expense_transaction VALUES("17","77","EXP-0000000017","2014-05-31","15","9","","2","2014-06-30","SGD","0.00000","0.00","","2","0.00","n/a","","","97","1","2","0","0000-00-00","1","2014-07-14 13:58:44","2014-07-14 14:01:40");





CREATE TABLE `expense_transaction_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkexpense_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in \n\nthe master database',
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
  `transaction_status` tinyint(2) NOT NULL COMMENT '1 - Approved/Verified, 2 - Unverified, 3 - \n\nDraft',
  `delete_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fkcompany_id` (`fkexpense_id`,`fkvendor_id`),
  KEY `fkcustomer_id` (`fkvendor_id`),
  KEY `fkpayment_account` (`fkpayment_account`),
  KEY `approval_for` (`approval_for`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction_audit VALUES("1","1","2014-04-01","1","6","","2","2014-05-01","EUR","1.69090","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:09");
INSERT INTO expense_transaction_audit VALUES("2","2","2014-04-14","PC1","7","","1","2014-04-14","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:09");
INSERT INTO expense_transaction_audit VALUES("3","3","2014-05-14","PC2","7","","1","2014-05-14","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("4","4","2014-04-01","2","5","","3","2014-05-31","USD","1.24030","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("5","5","2014-04-01","3","1","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("6","6","2014-04-01","4","3","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("7","7","2014-04-01","5","4","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("8","8","2014-04-01","6","2","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("9","9","2014-04-01","7","7","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("10","10","2014-04-15","8","8","","2","2014-05-15","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("11","11","2014-04-30","9","9","","2","2014-05-30","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("12","12","2014-05-01","10","1","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("13","13","2014-05-01","11","3","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("14","14","2014-05-01","12","4","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("15","15","2014-05-01","13","2","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("16","16","2014-05-01","14","7","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");
INSERT INTO expense_transaction_audit VALUES("17","17","2014-05-31","15","9","","2","2014-06-30","SGD","0.00000","0.00","","2","0.00","n/a","","","97","2","1","2014-07-14 13:58:44");





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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction_list VALUES("1","1","23","","Pasta Machines","1","10000.00","5","7.00","2014-07-14 13:58:09","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("2","2","50","","Warehouse Apr 14","1","440.00","5","7.00","2014-07-14 13:58:09","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("3","2","62","","Warehouse Apr 14","3","20.00","0","0.00","2014-07-14 13:58:09","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("4","3","50","","Warehouse Apr 14","1","940.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("5","3","62","","Warehouse Apr 14","3","20.00","0","0.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("6","4","45","","Vietnamese Food Items - Apr 14","1","1000.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("7","5","45","","Food - Apr 14","1","5485.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("8","6","46","","Beer - Apr 14","1","20000.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("9","7","46","","Wines - Apr 14","1","10000.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("10","8","47","","Misc. - Apr 14","1","5000.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("11","9","64","","Apr 2014","1","2000.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("12","10","63","","Initial Design and Plan Processing","1","2500.00","0","0.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("13","11","54","","Apr 2014 - Cleaning Services","1","15000.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("14","12","45","","Food - May 14","1","15400.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("15","13","46","","Beer - May 14","1","40000.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("16","14","46","","Wines - May 14","1","10000.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("17","15","47","","Misc. - May 14","1","5000.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("18","16","64","","May 14","1","2000.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("19","17","54","","May 2014 - Cleaning Services","1","15000.00","5","7.00","2014-07-14 13:58:44","0000-00-00 00:00:00");





CREATE TABLE `expense_transaction_list_audit` (
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
  PRIMARY KEY (`id`),
  KEY `fkexpense_id` (`fkexpense_id`),
  KEY `fkexpense_type` (`fkexpense_type`),
  KEY `fktax_id` (`fktax_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction_list_audit VALUES("1","1","23","","Pasta Machines","1","10000.00","5","7.00","2014-07-14 13:58:09");
INSERT INTO expense_transaction_list_audit VALUES("2","2","50","","Warehouse Apr 14","1","440.00","5","7.00","2014-07-14 13:58:09");
INSERT INTO expense_transaction_list_audit VALUES("3","2","62","","Warehouse Apr 14","3","20.00","0","0.00","2014-07-14 13:58:09");
INSERT INTO expense_transaction_list_audit VALUES("4","3","50","","Warehouse Apr 14","1","940.00","5","7.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("5","3","62","","Warehouse Apr 14","3","20.00","0","0.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("6","4","45","","Vietnamese Food Items - Apr 14","1","1000.00","5","7.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("7","5","45","","Food - Apr 14","1","5485.00","5","7.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("8","6","46","","Beer - Apr 14","1","20000.00","5","7.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("9","7","46","","Wines - Apr 14","1","10000.00","5","7.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("10","8","47","","Misc. - Apr 14","1","5000.00","5","7.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("11","9","64","","Apr 2014","1","2000.00","5","7.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("12","10","63","","Initial Design and Plan Processing","1","2500.00","0","0.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("13","11","54","","Apr 2014 - Cleaning Services","1","15000.00","5","7.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("14","12","45","","Food - May 14","1","15400.00","5","7.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("15","13","46","","Beer - May 14","1","40000.00","5","7.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("16","14","46","","Wines - May 14","1","10000.00","5","7.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("17","15","47","","Misc. - May 14","1","5000.00","5","7.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("18","16","64","","May 14","1","2000.00","5","7.00","2014-07-14 13:58:44");
INSERT INTO expense_transaction_list_audit VALUES("19","17","54","","May 2014 - Cleaning Services","1","15000.00","5","7.00","2014-07-14 13:58:44");





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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO income_transaction VALUES("1","77","INC-0000000001","2014-04-25","1","5","","1","MYR","0.39030","39","Admin Fee - Apr 2014","2500.00","","3","7.00","97","1","2","0","0000-00-00","1","2014-07-14 13:58:00","2014-07-14 14:00:55");
INSERT INTO income_transaction VALUES("2","77","INC-0000000002","2014-05-25","2","5","","1","MYR","0.39030","39","Admin Fee - May 2014","2500.00","","3","7.00","97","1","2","0","0000-00-00","1","2014-07-14 13:58:05","2014-07-14 14:00:55");
INSERT INTO income_transaction VALUES("3","77","INC-0000000003","2014-05-31","FD01","8","","1","SGD","0.00000","40","Interest Added to Preminum","312.50","","1","0.00","97","1","2","0","0000-00-00","1","2014-07-14 13:58:05","2014-07-14 14:00:55");





CREATE TABLE `income_transaction_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkincome_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in \n\nthe master database',
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
  `transaction_status` tinyint(2) NOT NULL COMMENT '1 - Approved/Verified, 2 - Unverified & Saved, \n\n3 - Draft',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fkcompany_id` (`fkincome_id`,`fkcustomer_id`,`fkpayment_account`,`fkincome_type`,`fktax_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `fktax_id` (`fktax_id`),
  KEY `fkpayment_account` (`fkpayment_account`),
  KEY `fkreceipt_id` (`fkreceipt_id`),
  KEY `approval_for` (`approval_for`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO income_transaction_audit VALUES("1","1","2014-04-25","1","5","","1","MYR","0.39030","39","Admin Fee - Apr 2014","2500.00","","3","7.00","97","2","2014-07-14 13:58:00");
INSERT INTO income_transaction_audit VALUES("2","2","2014-05-25","2","5","","1","MYR","0.39030","39","Admin Fee - May 2014","2500.00","","3","7.00","97","2","2014-07-14 13:58:05");
INSERT INTO income_transaction_audit VALUES("3","3","2014-05-31","FD01","8","","1","SGD","0.00000","40","Interest Added to Preminum","312.50","","1","0.00","97","2","2014-07-14 13:58:05");





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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO invoice VALUES("1","77","INV-0000000001","2014-06-01","7","0","2","2014-07-01","SGD","0.00000","1","2","rental - unit 113b","","97","1","2","0","0000-00-00","2","1","2014-07-14 13:58:05","2014-07-14 14:00:55");
INSERT INTO invoice VALUES("2","77","INV-0000000002","2014-04-15","1","0","2","2014-05-15","SGD","0.00000","1","2","apr intial order","","97","1","2","0","0000-00-00","2","1","2014-07-14 13:58:05","2014-07-14 14:01:40");
INSERT INTO invoice VALUES("3","77","INV-0000000003","2014-04-15","3","0","2","2014-05-15","USD","1.24030","1","2","apr 14 order","","97","1","2","0","0000-00-00","2","1","2014-07-14 13:58:34","2014-07-14 14:01:40");
INSERT INTO invoice VALUES("4","77","INV-0000000004","2014-04-30","2","0","2","2014-05-30","SGD","0.00000","1","2","apr 14 order","","97","1","2","0","0000-00-00","2","1","2014-07-14 13:58:34","2014-07-14 14:01:40");
INSERT INTO invoice VALUES("5","77","INV-0000000005","2014-05-01","7","0","2","2014-05-31","SGD","0.00000","1","2","may 14 - rental","","97","1","2","0","0000-00-00","2","1","2014-07-14 13:58:34","2014-07-14 14:00:55");
INSERT INTO invoice VALUES("6","77","INV-0000000006","2014-05-05","1","0","2","2014-06-04","SGD","0.00000","1","2","may 14 order","","97","1","2","0","0000-00-00","2","1","2014-07-14 13:58:34","2014-07-14 14:01:40");
INSERT INTO invoice VALUES("7","77","INV-0000000007","2014-05-15","2","0","2","2014-06-14","SGD","0.00000","1","2","may 14 order","","97","1","2","0","0000-00-00","2","1","2014-07-14 13:58:34","2014-07-14 14:01:40");
INSERT INTO invoice VALUES("8","77","INV-0000000008","2014-05-15","3","0","2","2014-06-14","USD","1.24030","1","2","may 14 order","","97","1","2","0","0000-00-00","2","1","2014-07-14 13:58:34","2014-07-14 14:01:40");





CREATE TABLE `invoice_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkinvoice_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in \n\nthe master database',
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
  `delete_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 \n\n- delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fkcompany_id` (`fkinvoice_id`,`fkcustomer_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `approval_for` (`approval_for`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO invoice_audit VALUES("1","1","2014-06-01","7","0","2","2014-07-01","SGD","0.00000","1","2","rental - unit 113b","","97","2","2","1","2014-07-14 13:58:05");
INSERT INTO invoice_audit VALUES("2","2","2014-04-15","1","0","2","2014-05-15","SGD","0.00000","1","2","apr intial order","","97","2","2","1","2014-07-14 13:58:05");
INSERT INTO invoice_audit VALUES("3","3","2014-04-15","3","0","2","2014-05-15","USD","1.24030","1","2","apr 14 order","","97","2","2","1","2014-07-14 13:58:34");
INSERT INTO invoice_audit VALUES("4","4","2014-04-30","2","0","2","2014-05-30","SGD","0.00000","1","2","apr 14 order","","97","2","2","1","2014-07-14 13:58:34");
INSERT INTO invoice_audit VALUES("5","5","2014-05-01","7","0","2","2014-05-31","SGD","0.00000","1","2","may 14 - rental","","97","2","2","1","2014-07-14 13:58:34");
INSERT INTO invoice_audit VALUES("6","6","2014-05-05","1","0","2","2014-06-04","SGD","0.00000","1","2","may 14 order","","97","2","2","1","2014-07-14 13:58:34");
INSERT INTO invoice_audit VALUES("7","7","2014-05-15","2","0","2","2014-06-14","SGD","0.00000","1","2","may 14 order","","97","2","2","1","2014-07-14 13:58:34");
INSERT INTO invoice_audit VALUES("8","8","2014-05-15","3","0","2","2014-06-14","USD","1.24030","1","2","may 14 order","","97","2","2","1","2014-07-14 13:58:34");





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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

INSERT INTO invoice_product_list VALUES("1","1","R - 113B","11","1","2500.00","0.00","3","7.00","2014-07-14 13:58:05","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("2","2","PA01","3","100","20.00","0.00","3","7.00","2014-07-14 13:58:05","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("3","2","PA02","4","100","30.00","0.00","3","7.00","2014-07-14 13:58:05","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("4","2","P12","1","100","35.00","0.00","3","7.00","2014-07-14 13:58:05","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("5","2","P8","2","100","25.00","0.00","3","7.00","2014-07-14 13:58:05","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("6","2","Whisky","8","250","12.00","0.00","3","7.00","2014-07-14 13:58:05","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("7","2","Wine","9","200","10.00","0.00","3","7.00","2014-07-14 13:58:05","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("8","2","SC100","6","30","100.00","0.00","3","7.00","2014-07-14 13:58:05","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("9","2","SC50","7","70","50.00","0.00","3","7.00","2014-07-14 13:58:05","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("10","3","HMP - USD","10","100","50.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("11","3","PD - USD","5","1000","10.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("12","4","Whisky","8","500","12.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("13","4","Wine","9","500","10.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("14","4","SC100","6","10","100.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("15","4","SC50","7","20","50.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("16","5","R - 113B","11","1","2500.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("17","6","PA01","3","22","20.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("18","6","PA02","4","22","30.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("19","6","P12","1","22","35.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("20","6","P8","2","22","25.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("21","6","Whisky","8","22","12.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("22","6","Wine","9","22","10.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("23","6","SC100","6","11","100.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("24","6","SC50","7","11","50.00","0.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("25","7","Whisky","8","2000","12.00","1000.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("26","7","Wine","9","2000","10.00","1000.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("27","7","SC100","6","28","100.00","800.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("28","7","SC50","7","72","50.00","600.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("29","8","HMP - USD","10","500","50.00","2000.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("30","8","PD - USD","5","2000","10.00","2000.00","3","7.00","2014-07-14 13:58:34","0000-00-00 00:00:00");





CREATE TABLE `invoice_product_list_audit` (
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
  PRIMARY KEY (`id`),
  KEY `fkexpense_id` (`fkinvoice_id`),
  KEY `fktax_id` (`fktax_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

INSERT INTO invoice_product_list_audit VALUES("1","1","R - 113B","11","1","2500.00","0.00","3","7.00","2014-07-14 13:58:05");
INSERT INTO invoice_product_list_audit VALUES("2","2","PA01","3","100","20.00","0.00","3","7.00","2014-07-14 13:58:05");
INSERT INTO invoice_product_list_audit VALUES("3","2","PA02","4","100","30.00","0.00","3","7.00","2014-07-14 13:58:05");
INSERT INTO invoice_product_list_audit VALUES("4","2","P12","1","100","35.00","0.00","3","7.00","2014-07-14 13:58:05");
INSERT INTO invoice_product_list_audit VALUES("5","2","P8","2","100","25.00","0.00","3","7.00","2014-07-14 13:58:05");
INSERT INTO invoice_product_list_audit VALUES("6","2","Whisky","8","250","12.00","0.00","3","7.00","2014-07-14 13:58:05");
INSERT INTO invoice_product_list_audit VALUES("7","2","Wine","9","200","10.00","0.00","3","7.00","2014-07-14 13:58:05");
INSERT INTO invoice_product_list_audit VALUES("8","2","SC100","6","30","100.00","0.00","3","7.00","2014-07-14 13:58:05");
INSERT INTO invoice_product_list_audit VALUES("9","2","SC50","7","70","50.00","0.00","3","7.00","2014-07-14 13:58:05");
INSERT INTO invoice_product_list_audit VALUES("10","3","HMP - USD","10","100","50.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("11","3","PD - USD","5","1000","10.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("12","4","Whisky","8","500","12.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("13","4","Wine","9","500","10.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("14","4","SC100","6","10","100.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("15","4","SC50","7","20","50.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("16","5","R - 113B","11","1","2500.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("17","6","PA01","3","22","20.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("18","6","PA02","4","22","30.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("19","6","P12","1","22","35.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("20","6","P8","2","22","25.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("21","6","Whisky","8","22","12.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("22","6","Wine","9","22","10.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("23","6","SC100","6","11","100.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("24","6","SC50","7","11","50.00","0.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("25","7","Whisky","8","2000","12.00","1000.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("26","7","Wine","9","2000","10.00","1000.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("27","7","SC100","6","28","100.00","800.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("28","7","SC50","7","72","50.00","600.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("29","8","HMP - USD","10","500","50.00","2000.00","3","7.00","2014-07-14 13:58:34");
INSERT INTO invoice_product_list_audit VALUES("30","8","PD - USD","5","2000","10.00","2000.00","3","7.00","2014-07-14 13:58:34");





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






CREATE TABLE `journal_entries_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkjournal_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` tinytext NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `approval_for` int(11) NOT NULL DEFAULT '0',
  `journal_status` tinyint(2) NOT NULL COMMENT '1 - Approved, 2 - Unapproved, 3 - Draft',
  `delete_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fkcompany_id` (`fkjournal_id`),
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






CREATE TABLE `journal_entries_list_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkjournal_id` int(11) NOT NULL,
  `fkaccount_id` int(11) DEFAULT NULL,
  `journal_description` tinytext NOT NULL,
  `debit` decimal(11,2) NOT NULL,
  `credit` decimal(11,2) NOT NULL,
  `bank_date` date NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fkjournal_id` (`fkjournal_id`,`fkaccount_id`),
  KEY `fkaccount_id` (`fkaccount_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification` tinyint(2) NOT NULL COMMENT '1 - On, 2 - Off',
  `email_setting` tinyint(2) NOT NULL COMMENT '1 - Immediate, 2 - Off',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO notifications VALUES("1","1","2","2014-07-14 13:52:52","0000-00-00 00:00:00");





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






CREATE TABLE `payments_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_status` tinyint(4) NOT NULL COMMENT '1 - Yes, 2 - No',
  `discount_amount` decimal(11,2) NOT NULL,
  `payment_description` varchar(255) NOT NULL,
  `payment_status` tinyint(4) NOT NULL COMMENT '1 - Income, 2 - Expense, 3 - Invoice',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fkiei_id` int(11) NOT NULL COMMENT 'Must be a primary key from income, \n\ninvoice or expense table',
  `date` date NOT NULL,
  `bank_date` date NOT NULL,
  `fkpayment_account` int(11) DEFAULT NULL,
  `payment_amount` decimal(11,2) NOT NULL,
  `payment_method` tinyint(4) NOT NULL,
  `cheque_draft_no` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkiei_id` (`fkiei_id`),
  KEY `fkpayment_account` (`fkpayment_account`)
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

INSERT INTO products VALUES("1","Pizza 12\"","77","P12","Pizza 12\"","35.00","SGD","34","2014-07-14 13:57:16","0000-00-00 00:00:00");
INSERT INTO products VALUES("2","Pizza 8\"","77","P8","Pizza 8\"","25.00","SGD","34","2014-07-14 13:57:16","0000-00-00 00:00:00");
INSERT INTO products VALUES("3","Pasta 01","77","PA01","Pasta 01","20.00","SGD","34","2014-07-14 13:57:16","0000-00-00 00:00:00");
INSERT INTO products VALUES("4","Pasta 02","77","PA02","Pasta 02","30.00","SGD","34","2014-07-14 13:57:16","0000-00-00 00:00:00");
INSERT INTO products VALUES("5","Pizza Dong","77","PD - USD","Pizza Dong","10.00","USD","36","2014-07-14 13:57:16","0000-00-00 00:00:00");
INSERT INTO products VALUES("6","Service Charge - $100","77","SC100","Service Charge - $100","100.00","SGD","37","2014-07-14 13:57:16","0000-00-00 00:00:00");
INSERT INTO products VALUES("7","Service Charge - $50","77","SC50","Service Charge - $50","50.00","SGD","37","2014-07-14 13:57:16","0000-00-00 00:00:00");
INSERT INTO products VALUES("8","Whisky","77","Whisky","Whisky","12.00","SGD","35","2014-07-14 13:57:16","0000-00-00 00:00:00");
INSERT INTO products VALUES("9","Wine","77","Wine","Wine","10.00","SGD","35","2014-07-14 13:57:16","0000-00-00 00:00:00");
INSERT INTO products VALUES("10","Home Made Pasta","77","HMP - USD","Home Made Pasta","50.00","USD","36","2014-07-14 13:57:16","0000-00-00 00:00:00");
INSERT INTO products VALUES("11","Rent - 113B","77","R - 113B","Rent - 113B","2500.00","SGD","66","2014-07-14 13:57:16","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO taxcodes VALUES("1","77","15","0.00","Regulation 33 Exempt supplies","2","1","2014-07-14 13:54:05","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("2","77","14","0.00","Zero-rated supplies","2","1","2014-07-14 13:54:13","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("3","77","13","7.00","Standard-rated supplies with GST charged","2","1","2014-07-14 13:54:21","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("4","77","3","0.00","Imports under special scheme with no GST incurred (e.g. Major Exporter Scheme, 3rd Party Logistic Scheme)","1","1","2014-07-14 13:54:28","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("5","77","23","7.00","Purchases with GST incurred at 7% and directly attributable to taxable supplies","1","1","2014-07-14 13:54:36","0000-00-00 00:00:00");





CREATE TABLE `theme_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `default_theme` tinyint(2) NOT NULL COMMENT '1 - Default, 2 - Not Default',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO theme_setting VALUES("1","Red","Basic Theme","1","2014-07-14 13:52:52");
INSERT INTO theme_setting VALUES("2","Black","Black Theme","2","2014-07-14 13:52:52");
INSERT INTO theme_setting VALUES("3","Blue","Blue Theme","2","2014-07-14 13:52:52");





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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO vendors VALUES("1","77","VEN-0000000001","Natrad Foods","16 Sandilands Road","","201301587A-PTE-01","69453481","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-14 13:57:40","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("2","77","VEN-0000000002","FoodXervices","16 Sandilands Road","","201301587A-PTE-06","69453482","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-14 13:57:40","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("3","77","VEN-0000000003","APB","16 Sandilands Road","","201301587A-PTE-02","69453483","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-14 13:57:40","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("4","77","VEN-0000000004","Magnum Wines","16 Sandilands Road","","201301587A-PTE-03","69453484","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-14 13:57:40","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("5","77","VEN-0000000005","AA Corporation - Vietnam","16 Sandilands Road","","201301587A-PTE-04","69453485","","Ho Chi Minh","Saigon","VN","","","","546080","0000-00-00","1","6","","2014-07-14 13:57:40","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("6","77","VEN-0000000006","Bakers & Chef - Italy","16 Sandilands Road","","201301587A-PTE-15","69453485","","Italy","Italy","IT","","","","546080","0000-00-00","1","6","","2014-07-14 13:57:40","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("7","77","VEN-0000000007","MCST 835","16 Sandilands Road","","201301587A-PTE-18","69453482","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","32","","2014-07-14 13:57:40","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("8","77","VEN-0000000008","ID Ranger","16 Sandilands Road","","201301587A-PTE-19","69453483","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","6","","2014-07-14 13:57:40","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("9","77","VEN-0000000009","Evergreen Cleaning Services","16 Sandilands Road","","201301587A-PTE-20","69453484","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","6","","2014-07-14 13:57:40","0000-00-00 00:00:00");



