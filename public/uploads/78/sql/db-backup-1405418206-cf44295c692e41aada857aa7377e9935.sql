

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

INSERT INTO account VALUES("1","2","1","0","Unrealised Foreign Exchange Gain / (Loss)","","0.00","0.00","0","2","1","2014-07-15 04:11:48","2014-07-15 11:10:27");
INSERT INTO account VALUES("2","4","3","0","Foreign Exchange Gain/(Loss)","","0.00","0.00","0","2","1","2014-07-15 04:11:48","2014-07-15 11:10:27");
INSERT INTO account VALUES("3","1","1","4","Trade Receivables","","0.00","0.00","0","2","1","2014-07-15 04:11:48","2014-07-15 11:10:27");
INSERT INTO account VALUES("4","1","1","5","Account Receivables - Others","","0.00","0.00","0","2","1","2014-07-15 04:11:48","2014-07-15 11:10:27");
INSERT INTO account VALUES("5","2","1","3","Trade Creditors","","0.00","0.00","0","2","1","2014-07-15 04:11:48","2014-07-15 11:10:27");
INSERT INTO account VALUES("6","2","1","8","Account Payables - Others","","0.00","0.00","0","2","1","2014-07-15 04:11:48","2014-07-15 11:10:27");
INSERT INTO account VALUES("7","3","1","0","Discounts Given","","0.00","0.00","0","2","1","2014-07-15 04:11:48","2014-07-15 11:10:27");
INSERT INTO account VALUES("8","4","1","0","Discounts Received","","0.00","0.00","0","2","1","2014-07-15 04:11:48","2014-07-15 11:10:27");
INSERT INTO account VALUES("9","5","4","1","Retained Earnings","","0.00","150000.00","0","2","1","2014-07-15 04:11:48","2014-07-15 11:10:27");
INSERT INTO account VALUES("10","5","4","1","Current Year Earnings","","0.00","0.00","0","2","1","2014-07-15 04:11:48","2014-07-15 11:10:27");
INSERT INTO account VALUES("11","2","1","4","Sales Tax Payables","","0.00","0.00","0","2","1","2014-07-15 04:11:48","2014-07-15 11:10:27");
INSERT INTO account VALUES("12","4","3","8","Income Tax","","0.00","0.00","0","2","1","2014-07-15 04:11:48","2014-07-15 11:10:27");
INSERT INTO account VALUES("13","1","1","1","Cash in Hand","SGD","2500.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("14","1","1","1","Petty Cash","SGD","2000.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("15","1","1","1","UOB Bank","SGD","60000.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("16","1","1","1","Fixed Deposits","SGD","200000.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("17","1","1","1","OCBC Bank","SGD","105000.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("18","1","1","3","Inventory","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("19","1","1","6","Rental Deposit","SGD","60000.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("20","1","1","6","Security Deposit","SGD","500.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("21","1","1","5","Interest Receivbales","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("22","1","1","5","Staff Loan","SGD","12000.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("23","1","2","3","Machinery","SGD","10000.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("24","1","2","3","Acc. Depn - Machinery","SGD","0.00","2000.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("25","1","2","3","F & F","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("26","1","2","3","Acc. Depn - F & F","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("27","1","2","3","Computers","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("28","1","2","3","Acc. Depn - Computers","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("29","2","1","8","CPF Board Payable","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("30","2","1","8","Staff Payables","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("31","5","1","1","Capital Account","SGD","0.00","300000.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("32","2","1","8","Rent Payable","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("33","1","1","5","Rent Receivable","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("34","3","1","7","Sales - Food","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("35","3","1","7","Sales - B/V","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("36","3","1","7","Sales - Misc","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("37","3","1","7","Service Charge","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("38","3","1","8","Misc. Rcpts.","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("39","3","2","1","Admin Fees Income","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("40","3","2","2","Interest Income - Fixed Deposits","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("41","3","2","4","Other Non Operating Income","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("42","3","3","1","Government Grants - PIC","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("43","3","3","1","Government Grants - SEC","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("44","4","1","1","Opening Stock","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("45","4","1","1","Purchases - Food","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("46","4","1","1","Purchases - B/V","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("47","4","1","1","Purchases - Misc.","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("48","4","1","1","Closing Stock","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("49","4","2","6","Advertising & Promotion","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("50","4","2","9","Shop Maintance","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("51","4","2","9","Kitchen Maintance","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("52","4","2","9","Kitchen Equipment Maintenance","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("53","4","2","9","Cleaing Items","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("54","4","2","9","Cleaing Contractor","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("55","4","2","11","Salary & Wages","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("56","4","2","11","Overtime","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("57","4","2","11","Sales Promotion","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("58","4","2","11","CPF","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("59","4","2","11","SDL","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("60","4","2","11","Staff Welfare","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("61","4","2","11","Staff medical Expenses","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("62","4","2","17","Electricity / Water / Gas","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("63","1","2","5","Renovation in Progress","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("64","4","2","8","Warehouse Rental","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("65","4","3","1","Depreciation","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");
INSERT INTO account VALUES("66","3","1","8","Rental Income","SGD","0.00","0.00","2","1","1","2014-07-15 04:53:12","2014-07-15 11:10:27");





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
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1;

INSERT INTO accounting_entries VALUES("1","2","2","1000.00","2014-04-01","2","2","1","2014-07-15 04:57:46","2014-07-15 10:56:01");
INSERT INTO accounting_entries VALUES("2","3","2","5868.95","2014-04-01","2","2","1","2014-07-15 04:57:46","2014-07-15 09:07:36");
INSERT INTO accounting_entries VALUES("3","4","2","21400.00","2014-04-01","2","2","1","2014-07-15 04:57:46","2014-07-15 09:10:19");
INSERT INTO accounting_entries VALUES("4","5","2","10700.00","2014-04-01","2","2","1","2014-07-15 04:57:46","2014-07-15 10:58:55");
INSERT INTO accounting_entries VALUES("5","6","2","5350.00","2014-04-01","2","2","1","2014-07-15 04:57:46","2014-07-15 13:36:21");
INSERT INTO accounting_entries VALUES("6","7","2","2140.00","2014-04-01","2","2","1","2014-07-15 04:57:46","2014-07-15 10:55:41");
INSERT INTO accounting_entries VALUES("7","8","2","2500.00","2014-04-15","2","2","1","2014-07-15 04:57:46","2014-07-15 09:12:24");
INSERT INTO accounting_entries VALUES("8","9","2","14994.98","2014-04-30","2","2","1","2014-07-15 04:57:46","2014-07-15 09:06:37");
INSERT INTO accounting_entries VALUES("9","10","2","16478.00","2014-05-01","2","2","1","2014-07-15 04:57:46","2014-07-15 09:09:48");
INSERT INTO accounting_entries VALUES("10","11","2","42800.00","2014-05-01","2","2","1","2014-07-15 04:57:46","2014-07-15 09:10:38");
INSERT INTO accounting_entries VALUES("11","12","2","10700.00","2014-05-01","2","2","1","2014-07-15 04:57:46","2014-07-15 09:15:00");
INSERT INTO accounting_entries VALUES("12","13","2","5350.00","2014-05-01","2","2","1","2014-07-15 04:57:46","2014-07-15 09:16:25");
INSERT INTO accounting_entries VALUES("13","14","2","2140.00","2014-05-01","2","2","1","2014-07-15 04:57:46","2014-07-15 09:19:28");
INSERT INTO accounting_entries VALUES("14","15","2","16050.00","2014-05-31","2","2","1","2014-07-15 04:57:46","2014-07-15 09:06:56");
INSERT INTO accounting_entries VALUES("15","16","2","10000.00","2014-04-01","2","2","1","2014-07-15 04:57:46","2014-07-15 09:22:33");
INSERT INTO accounting_entries VALUES("16","1","1","2675.00","2014-04-01","3","1","1","2014-07-15 04:57:46","2014-07-15 13:28:27");
INSERT INTO accounting_entries VALUES("17","1","5","2500.00","2014-04-01","3","2","1","2014-07-15 04:57:46","2014-07-15 13:28:27");
INSERT INTO accounting_entries VALUES("18","1","4","175.00","2014-04-01","3","2","1","2014-07-15 04:57:46","2014-07-15 13:28:27");
INSERT INTO accounting_entries VALUES("19","2","1","24075.00","2014-04-15","3","1","1","2014-07-15 04:57:46","2014-07-15 08:55:03");
INSERT INTO accounting_entries VALUES("20","2","5","22500.00","2014-04-15","3","2","1","2014-07-15 04:57:46","2014-07-15 08:55:03");
INSERT INTO accounting_entries VALUES("21","2","4","1575.00","2014-04-15","3","2","1","2014-07-15 04:57:46","2014-07-15 08:55:03");
INSERT INTO accounting_entries VALUES("22","3","1","16050.00","2014-04-15","3","1","1","2014-07-15 04:57:46","2014-07-15 09:00:22");
INSERT INTO accounting_entries VALUES("23","3","5","15000.00","2014-04-15","3","2","1","2014-07-15 04:57:46","2014-07-15 09:00:22");
INSERT INTO accounting_entries VALUES("24","3","4","1050.00","2014-04-15","3","2","1","2014-07-15 04:57:46","2014-07-15 09:00:22");
INSERT INTO accounting_entries VALUES("25","4","1","13910.00","2014-04-30","3","1","1","2014-07-15 04:57:46","2014-07-15 08:55:40");
INSERT INTO accounting_entries VALUES("26","4","5","13000.00","2014-04-30","3","2","1","2014-07-15 04:57:46","2014-07-15 08:55:40");
INSERT INTO accounting_entries VALUES("27","4","4","910.00","2014-04-30","3","2","1","2014-07-15 04:57:46","2014-07-15 08:55:40");
INSERT INTO accounting_entries VALUES("28","5","1","2675.00","2014-05-01","3","1","1","2014-07-15 04:57:46","2014-07-15 13:27:54");
INSERT INTO accounting_entries VALUES("29","5","5","2500.00","2014-05-01","3","2","1","2014-07-15 04:57:46","2014-07-15 13:27:54");
INSERT INTO accounting_entries VALUES("30","5","4","175.00","2014-05-01","3","2","1","2014-07-15 04:57:46","2014-07-15 13:27:54");
INSERT INTO accounting_entries VALUES("31","6","1","4872.78","2014-05-05","3","1","1","2014-07-15 04:57:46","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("32","6","5","4554.00","2014-05-05","3","2","1","2014-07-15 04:57:46","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("33","6","4","318.78","2014-05-05","3","2","1","2014-07-15 04:57:46","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("34","7","1","50290.00","2014-05-15","3","1","1","2014-07-15 04:57:46","2014-07-15 08:56:21");
INSERT INTO accounting_entries VALUES("35","7","5","47000.00","2014-05-15","3","2","1","2014-07-15 04:57:46","2014-07-15 08:56:21");
INSERT INTO accounting_entries VALUES("36","7","4","3290.00","2014-05-15","3","2","1","2014-07-15 04:57:46","2014-07-15 08:56:21");
INSERT INTO accounting_entries VALUES("37","8","1","43870.00","2014-05-15","3","1","1","2014-07-15 04:57:46","2014-07-15 10:54:57");
INSERT INTO accounting_entries VALUES("38","8","5","41000.00","2014-05-15","3","2","1","2014-07-15 04:57:46","2014-07-15 10:54:57");
INSERT INTO accounting_entries VALUES("39","8","4","2870.00","2014-05-15","3","2","1","2014-07-15 04:57:46","2014-07-15 10:54:57");
INSERT INTO accounting_entries VALUES("40","1","3","1050.00","2014-04-25","1","1","1","2014-07-15 05:07:44","2014-07-15 11:03:21");
INSERT INTO accounting_entries VALUES("41","1","1","2675.00","2014-04-25","1","1","1","2014-07-15 05:07:44","2014-07-15 11:03:21");
INSERT INTO accounting_entries VALUES("42","1","5","2500.00","2014-04-25","1","2","1","2014-07-15 05:07:44","2014-07-15 11:03:21");
INSERT INTO accounting_entries VALUES("43","1","4","175.00","2014-04-25","1","2","1","2014-07-15 05:07:44","2014-07-15 11:03:21");
INSERT INTO accounting_entries VALUES("44","2","3","1050.00","2014-05-25","1","1","1","2014-07-15 05:29:08","2014-07-15 05:33:04");
INSERT INTO accounting_entries VALUES("45","2","1","2675.00","2014-05-25","1","1","1","2014-07-15 05:29:08","2014-07-15 05:33:04");
INSERT INTO accounting_entries VALUES("46","2","5","2500.00","2014-05-25","1","2","1","2014-07-15 05:29:08","2014-07-15 05:33:04");
INSERT INTO accounting_entries VALUES("47","2","4","175.00","2014-05-25","1","2","1","2014-07-15 05:29:08","2014-07-15 05:33:04");
INSERT INTO accounting_entries VALUES("48","3","3","312.50","2014-05-31","1","1","1","2014-07-15 05:34:21","2014-07-15 05:34:41");
INSERT INTO accounting_entries VALUES("49","3","1","312.50","2014-05-31","1","1","1","2014-07-15 05:34:21","2014-07-15 05:34:41");
INSERT INTO accounting_entries VALUES("50","3","5","312.50","2014-05-31","1","2","1","2014-07-15 05:34:21","2014-07-15 05:34:41");
INSERT INTO accounting_entries VALUES("51","3","4","0.00","2014-05-31","1","2","1","2014-07-15 05:34:21","2014-07-15 05:34:41");
INSERT INTO accounting_entries VALUES("52","17","3","530.80","2014-04-14","2","2","1","2014-07-15 05:36:09","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("53","17","2","530.80","2014-04-14","2","2","1","2014-07-15 05:36:09","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("54","1","3","1065.80","2014-05-14","2","2","1","2014-07-15 05:37:22","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("55","1","2","1065.80","2014-05-14","2","2","1","2014-07-15 05:37:22","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("56","1","1","909.50","2014-04-15","4","2","1","2014-07-15 08:15:24","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("57","1","5","850.00","2014-04-15","4","1","1","2014-07-15 08:15:24","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("58","1","4","59.50","2014-04-15","4","1","1","2014-07-15 08:15:24","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("59","2","1","1867.15","2014-04-30","4","2","2","2014-07-15 08:16:34","2014-07-15 08:48:14");
INSERT INTO accounting_entries VALUES("60","2","5","1745.00","2014-04-30","4","1","2","2014-07-15 08:16:34","2014-07-15 08:48:14");
INSERT INTO accounting_entries VALUES("61","2","4","122.15","2014-04-30","4","1","2","2014-07-15 08:16:34","2014-07-15 08:48:14");
INSERT INTO accounting_entries VALUES("62","3","1","442.98","2014-05-05","4","2","1","2014-07-15 08:17:52","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("63","3","5","414.00","2014-05-05","4","1","1","2014-07-15 08:17:52","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("64","3","4","28.98","2014-05-05","4","1","1","2014-07-15 08:17:52","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("65","4","1","5885.00","2014-05-15","4","2","1","2014-07-15 08:18:41","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("66","4","5","5500.00","2014-05-15","4","1","1","2014-07-15 08:18:41","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("67","4","4","385.00","2014-05-15","4","1","1","2014-07-15 08:18:41","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("68","5","1","1867.15","2014-05-15","4","2","1","2014-07-15 08:50:13","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("69","5","5","1745.00","2014-05-15","4","1","1","2014-07-15 08:50:13","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("70","5","4","122.15","2014-05-15","4","1","1","2014-07-15 08:50:13","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("71","5","3","2675.00","2014-05-01","3","1","1","2014-07-15 08:52:54","2014-07-15 13:27:54");
INSERT INTO accounting_entries VALUES("72","1","3","2675.00","2014-04-01","3","1","1","2014-07-15 08:53:46","2014-07-15 13:28:27");
INSERT INTO accounting_entries VALUES("73","2","3","23000.00","2014-04-15","3","1","1","2014-07-15 08:55:03","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("74","4","3","13910.00","2014-04-30","3","1","1","2014-07-15 08:55:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("75","7","3","48000.00","2014-05-15","3","1","1","2014-07-15 08:56:21","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("76","9","1","16050.00","2014-04-15","3","1","1","2014-07-15 09:03:02","2014-07-15 10:51:17");
INSERT INTO accounting_entries VALUES("77","9","5","15000.00","2014-04-15","3","2","1","2014-07-15 09:03:02","2014-07-15 10:51:17");
INSERT INTO accounting_entries VALUES("78","9","4","1050.00","2014-04-15","3","2","1","2014-07-15 09:03:02","2014-07-15 10:51:17");
INSERT INTO accounting_entries VALUES("79","9","3","14994.98","2014-04-30","2","2","1","2014-07-15 09:06:37","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("80","15","3","16050.00","2014-05-31","2","2","1","2014-07-15 09:06:56","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("81","3","3","5868.95","2014-04-01","2","2","1","2014-07-15 09:07:36","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("82","10","3","16000.00","2014-05-01","2","2","1","2014-07-15 09:09:48","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("83","4","3","21400.00","2014-04-01","2","2","1","2014-07-15 09:10:19","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("84","11","3","20000.00","2014-05-01","2","2","1","2014-07-15 09:10:38","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("85","8","3","2500.00","2014-04-15","2","2","1","2014-07-15 09:12:24","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("86","12","3","10539.50","2014-05-01","2","2","1","2014-07-15 09:15:00","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("87","6","3","5082.50","2014-04-01","2","2","1","2014-07-15 09:16:08","2014-07-15 13:36:21");
INSERT INTO accounting_entries VALUES("88","13","3","5350.00","2014-05-01","2","2","1","2014-07-15 09:16:25","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("89","14","3","2140.00","2014-05-01","2","2","1","2014-07-15 09:17:52","2014-07-15 09:19:28");
INSERT INTO accounting_entries VALUES("90","2","3","1300.00","2014-04-01","2","2","1","2014-07-15 09:20:08","2014-07-15 10:56:01");
INSERT INTO accounting_entries VALUES("91","16","3","18200.00","2014-04-01","2","2","1","2014-07-15 09:22:33","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("92","9","3","20060.00","2014-04-15","3","1","1","2014-07-15 10:51:17","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("93","8","3","47300.00","2014-05-15","3","1","1","2014-07-15 10:54:57","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("94","7","3","2140.00","2014-04-01","2","2","1","2014-07-15 10:55:41","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("95","5","3","10593.00","2014-04-01","2","2","1","2014-07-15 10:58:55","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=292 DEFAULT CHARSET=latin1;

INSERT INTO audit_log VALUES("1","78","1","1","9","15","1","2014-07-15 04:15:46");
INSERT INTO audit_log VALUES("2","78","1","1","9","12","2","2014-07-15 04:16:08");
INSERT INTO audit_log VALUES("3","78","1","1","9","13","3","2014-07-15 04:16:38");
INSERT INTO audit_log VALUES("4","78","1","1","9","23","4","2014-07-15 04:17:00");
INSERT INTO audit_log VALUES("5","78","1","1","8","Cash in Hand","13","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("6","78","1","1","8","Petty Cash","14","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("7","78","1","1","8","UOB Bank","15","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("8","78","1","1","8","Fixed Deposits","16","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("9","78","1","1","8","OCBC Bank","17","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("10","78","1","1","8","Inventory","18","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("11","78","1","1","8","Rental Deposit","19","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("12","78","1","1","8","Security Deposit","20","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("13","78","1","1","8","Interest Receivbales","21","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("14","78","1","1","8","Staff Loan","22","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("15","78","1","1","8","Machinery","23","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("16","78","1","1","8","Acc. Depn - Machinery","24","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("17","78","1","1","8","F & F","25","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("18","78","1","1","8","Acc. Depn - F & F","26","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("19","78","1","1","8","Computers","27","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("20","78","1","1","8","Acc. Depn - Computers","28","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("21","78","1","1","8","CPF Board Payable","29","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("22","78","1","1","8","Staff Payables","30","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("23","78","1","1","8","Capital Account","31","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("24","78","1","1","8","Rent Payable","32","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("25","78","1","1","8","Rent Receivable","33","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("26","78","1","1","8","Sales - Food","34","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("27","78","1","1","8","Sales - B/V","35","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("28","78","1","1","8","Sales - Misc","36","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("29","78","1","1","8","Service Charge","37","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("30","78","1","1","8","Misc. Rcpts.","38","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("31","78","1","1","8","Admin Fees Income","39","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("32","78","1","1","8","Interest Income - Fixed Deposits","40","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("33","78","1","1","8","Other Non Operating Income","41","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("34","78","1","1","8","Government Grants - PIC","42","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("35","78","1","1","8","Government Grants - SEC","43","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("36","78","1","1","8","Opening Stock","44","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("37","78","1","1","8","Purchases - Food","45","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("38","78","1","1","8","Purchases - B/V","46","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("39","78","1","1","8","Purchases - Misc.","47","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("40","78","1","1","8","Closing Stock","48","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("41","78","1","1","8","Advertising & Promotion","49","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("42","78","1","1","8","Shop Maintance","50","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("43","78","1","1","8","Kitchen Maintance","51","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("44","78","1","1","8","Kitchen Equipment Maintenance","52","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("45","78","1","1","8","Cleaing Items","53","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("46","78","1","1","8","Cleaing Contractor","54","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("47","78","1","1","8","Salary & Wages","55","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("48","78","1","1","8","Overtime","56","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("49","78","1","1","8","Sales Promotion","57","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("50","78","1","1","8","CPF","58","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("51","78","1","1","8","SDL","59","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("52","78","1","1","8","Staff Welfare","60","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("53","78","1","1","8","Staff medical Expenses","61","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("54","78","1","1","8","Electricity / Water / Gas","62","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("55","78","1","1","8","Renovation in Progress","63","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("56","78","1","1","8","Warehouse Rental","64","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("57","78","1","1","8","Depreciation","65","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("58","78","1","1","8","Rental Income","66","2014-07-15 04:53:12");
INSERT INTO audit_log VALUES("59","78","1","1","10","Pizza 12\"","1","2014-07-15 04:53:34");
INSERT INTO audit_log VALUES("60","78","1","1","10","Pizza 8\"","2","2014-07-15 04:53:34");
INSERT INTO audit_log VALUES("61","78","1","1","10","Pasta 01","3","2014-07-15 04:53:34");
INSERT INTO audit_log VALUES("62","78","1","1","10","Pasta 02","4","2014-07-15 04:53:34");
INSERT INTO audit_log VALUES("63","78","1","1","10","Pizza Dong","5","2014-07-15 04:53:34");
INSERT INTO audit_log VALUES("64","78","1","1","10","Service Charge - $100","6","2014-07-15 04:53:34");
INSERT INTO audit_log VALUES("65","78","1","1","10","Service Charge - $50","7","2014-07-15 04:53:34");
INSERT INTO audit_log VALUES("66","78","1","1","10","Whisky","8","2014-07-15 04:53:34");
INSERT INTO audit_log VALUES("67","78","1","1","10","Wine","9","2014-07-15 04:53:34");
INSERT INTO audit_log VALUES("68","78","1","1","10","Home Made Pasta","10","2014-07-15 04:53:34");
INSERT INTO audit_log VALUES("69","78","1","1","10","Rent - 113B","11","2014-07-15 04:53:34");
INSERT INTO audit_log VALUES("70","78","1","1","7","Natrad Foods","1","2014-07-15 04:53:44");
INSERT INTO audit_log VALUES("71","78","1","1","7","FoodXervices","2","2014-07-15 04:53:44");
INSERT INTO audit_log VALUES("72","78","1","1","7","APB","3","2014-07-15 04:53:44");
INSERT INTO audit_log VALUES("73","78","1","1","7","Magnum Wines","4","2014-07-15 04:53:44");
INSERT INTO audit_log VALUES("74","78","1","1","7","AA Corporation - Vietnam","5","2014-07-15 04:53:44");
INSERT INTO audit_log VALUES("75","78","1","1","7","Bakers & Chef - Italy","6","2014-07-15 04:53:44");
INSERT INTO audit_log VALUES("76","78","1","1","7","MCST 835","7","2014-07-15 04:53:44");
INSERT INTO audit_log VALUES("77","78","1","1","7","ID Ranger","8","2014-07-15 04:53:44");
INSERT INTO audit_log VALUES("78","78","1","1","7","Evergreen Cleaning Services","9","2014-07-15 04:53:44");
INSERT INTO audit_log VALUES("79","78","1","1","6","OPH","1","2014-07-15 04:53:56");
INSERT INTO audit_log VALUES("80","78","1","1","6","EZH & Qh","2","2014-07-15 04:53:56");
INSERT INTO audit_log VALUES("81","78","1","1","6","Dome - Dubai","3","2014-07-15 04:53:56");
INSERT INTO audit_log VALUES("82","78","1","1","6","Ciao Cafe - Vietnam","4","2014-07-15 04:53:56");
INSERT INTO audit_log VALUES("83","78","1","1","6","Melinium Sdn Bhd","5","2014-07-15 04:53:56");
INSERT INTO audit_log VALUES("84","78","1","1","6","Temasek LLC","6","2014-07-15 04:53:56");
INSERT INTO audit_log VALUES("85","78","1","1","6","Grean Ocean Pte Ltd","7","2014-07-15 04:53:56");
INSERT INTO audit_log VALUES("86","78","1","1","6","Indian Bank","8","2014-07-15 04:53:56");
INSERT INTO audit_log VALUES("87","78","1","1","6","Indian Overseas Bank","9","2014-07-15 04:53:56");
INSERT INTO audit_log VALUES("88","78","1","1","1","Income","1","2014-07-15 04:54:08");
INSERT INTO audit_log VALUES("89","78","1","1","1","Income","2","2014-07-15 04:54:13");
INSERT INTO audit_log VALUES("90","78","1","1","1","Income","3","2014-07-15 04:54:13");
INSERT INTO audit_log VALUES("91","78","1","1","2","Expense","1","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("92","78","1","1","2","Expense","2","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("93","78","1","1","2","Expense","3","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("94","78","1","1","2","Expense","4","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("95","78","1","1","2","Expense","5","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("96","78","1","1","2","Expense","6","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("97","78","1","1","2","Expense","7","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("98","78","1","1","2","Expense","8","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("99","78","1","1","2","Expense","9","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("100","78","1","1","2","Expense","10","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("101","78","1","1","2","Expense","11","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("102","78","1","1","2","Expense","12","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("103","78","1","1","2","Expense","13","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("104","78","1","1","2","Expense","14","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("105","78","1","1","2","Expense","15","2014-07-15 04:54:29");
INSERT INTO audit_log VALUES("106","78","1","1","2","Expense","16","2014-07-15 04:54:38");
INSERT INTO audit_log VALUES("107","78","1","1","2","Expense","17","2014-07-15 04:54:38");
INSERT INTO audit_log VALUES("108","78","1","1","3","Invoice","1","2014-07-15 04:54:50");
INSERT INTO audit_log VALUES("109","78","1","1","3","Invoice","2","2014-07-15 04:54:50");
INSERT INTO audit_log VALUES("110","78","1","1","3","Invoice","3","2014-07-15 04:55:11");
INSERT INTO audit_log VALUES("111","78","1","1","3","Invoice","4","2014-07-15 04:55:11");
INSERT INTO audit_log VALUES("112","78","1","1","3","Invoice","5","2014-07-15 04:55:11");
INSERT INTO audit_log VALUES("113","78","1","1","3","Invoice","6","2014-07-15 04:55:11");
INSERT INTO audit_log VALUES("114","78","1","1","3","Invoice","7","2014-07-15 04:55:11");
INSERT INTO audit_log VALUES("115","78","1","1","3","Invoice","8","2014-07-15 04:55:16");
INSERT INTO audit_log VALUES("116","78","1","6","2","Expense","2","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("117","78","1","6","2","Expense","3","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("118","78","1","6","2","Expense","4","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("119","78","1","6","2","Expense","5","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("120","78","1","6","2","Expense","6","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("121","78","1","6","2","Expense","7","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("122","78","1","6","2","Expense","8","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("123","78","1","6","2","Expense","9","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("124","78","1","6","2","Expense","10","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("125","78","1","6","2","Expense","11","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("126","78","1","6","2","Expense","12","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("127","78","1","6","2","Expense","13","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("128","78","1","6","2","Expense","14","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("129","78","1","6","2","Expense","15","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("130","78","1","6","2","Expense","16","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("131","78","1","6","3","Invoice","1","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("132","78","1","6","3","Invoice","2","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("133","78","1","6","3","Invoice","3","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("134","78","1","6","3","Invoice","4","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("135","78","1","6","3","Invoice","5","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("136","78","1","6","3","Invoice","6","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("137","78","1","6","3","Invoice","7","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("138","78","1","6","3","Invoice","8","2014-07-15 04:57:46");
INSERT INTO audit_log VALUES("139","78","1","2","1","Income","4","2014-07-15 05:07:44");
INSERT INTO audit_log VALUES("140","78","1","6","1","Income","1","2014-07-15 05:07:44");
INSERT INTO audit_log VALUES("141","78","1","2","1","Income","5","2014-07-15 05:29:08");
INSERT INTO audit_log VALUES("142","78","1","6","1","Income","2","2014-07-15 05:29:08");
INSERT INTO audit_log VALUES("143","78","1","7","1","Income","1","2014-07-15 05:31:31");
INSERT INTO audit_log VALUES("144","78","1","7","1","Income","2","2014-07-15 05:31:37");
INSERT INTO audit_log VALUES("145","78","1","2","1","Income","6","2014-07-15 05:32:14");
INSERT INTO audit_log VALUES("146","78","1","6","1","Income","1","2014-07-15 05:32:14");
INSERT INTO audit_log VALUES("147","78","1","2","11","Income","1","2014-07-15 05:32:37");
INSERT INTO audit_log VALUES("148","78","1","2","1","Income","7","2014-07-15 05:32:56");
INSERT INTO audit_log VALUES("149","78","1","6","1","Income","2","2014-07-15 05:32:56");
INSERT INTO audit_log VALUES("150","78","1","2","11","Income","2","2014-07-15 05:33:04");
INSERT INTO audit_log VALUES("151","78","1","2","1","Income","8","2014-07-15 05:34:21");
INSERT INTO audit_log VALUES("152","78","1","6","1","Income","3","2014-07-15 05:34:21");
INSERT INTO audit_log VALUES("153","78","1","2","11","Income","3","2014-07-15 05:34:41");
INSERT INTO audit_log VALUES("154","78","1","2","2","Expense","18","2014-07-15 05:36:09");
INSERT INTO audit_log VALUES("155","78","1","6","2","Expense","17","2014-07-15 05:36:09");
INSERT INTO audit_log VALUES("156","78","1","2","2","Expense","19","2014-07-15 05:37:22");
INSERT INTO audit_log VALUES("157","78","1","6","2","Expense","1","2014-07-15 05:37:22");
INSERT INTO audit_log VALUES("158","78","1","1","5","Jounral Entry","1","2014-07-15 07:58:10");
INSERT INTO audit_log VALUES("159","78","1","6","5","Jounral Entry","1","2014-07-15 07:58:10");
INSERT INTO audit_log VALUES("160","78","1","1","5","Jounral Entry","2","2014-07-15 08:02:06");
INSERT INTO audit_log VALUES("161","78","1","6","5","Jounral Entry","2","2014-07-15 08:02:06");
INSERT INTO audit_log VALUES("162","78","1","1","5","Jounral Entry","3","2014-07-15 08:03:17");
INSERT INTO audit_log VALUES("163","78","1","6","5","Jounral Entry","3","2014-07-15 08:03:17");
INSERT INTO audit_log VALUES("164","78","1","7","2","Expense","16","2014-07-15 08:05:47");
INSERT INTO audit_log VALUES("165","78","1","2","2","Expense","20","2014-07-15 08:06:29");
INSERT INTO audit_log VALUES("166","78","1","6","2","Expense","16","2014-07-15 08:06:29");
INSERT INTO audit_log VALUES("167","78","1","7","2","Expense","2","2014-07-15 08:08:50");
INSERT INTO audit_log VALUES("168","78","1","2","2","Expense","21","2014-07-15 08:09:22");
INSERT INTO audit_log VALUES("169","78","1","6","2","Expense","2","2014-07-15 08:09:22");
INSERT INTO audit_log VALUES("170","78","1","7","3","Invoice","8","2014-07-15 08:10:21");
INSERT INTO audit_log VALUES("171","78","1","7","3","Invoice","3","2014-07-15 08:10:22");
INSERT INTO audit_log VALUES("172","78","1","2","3","Invoice","9","2014-07-15 08:12:46");
INSERT INTO audit_log VALUES("173","78","1","6","3","Invoice","3","2014-07-15 08:12:46");
INSERT INTO audit_log VALUES("174","78","1","2","3","Invoice","10","2014-07-15 08:13:11");
INSERT INTO audit_log VALUES("175","78","1","6","3","Invoice","8","2014-07-15 08:13:11");
INSERT INTO audit_log VALUES("176","78","1","1","4","Credit Note","1","2014-07-15 08:15:24");
INSERT INTO audit_log VALUES("177","78","1","6","4","Credit Note","1","2014-07-15 08:15:24");
INSERT INTO audit_log VALUES("178","78","1","1","4","Credit Note","2","2014-07-15 08:16:34");
INSERT INTO audit_log VALUES("179","78","1","6","4","Credit Note","2","2014-07-15 08:16:34");
INSERT INTO audit_log VALUES("180","78","1","1","4","Credit Note","3","2014-07-15 08:17:52");
INSERT INTO audit_log VALUES("181","78","1","6","4","Credit Note","3","2014-07-15 08:17:52");
INSERT INTO audit_log VALUES("182","78","1","1","4","Credit Note","4","2014-07-15 08:18:41");
INSERT INTO audit_log VALUES("183","78","1","6","4","Credit Note","4","2014-07-15 08:18:41");
INSERT INTO audit_log VALUES("184","78","1","7","5","Jounral Entry","3","2014-07-15 08:19:10");
INSERT INTO audit_log VALUES("185","78","1","2","5","Jounral Entry","4","2014-07-15 08:19:31");
INSERT INTO audit_log VALUES("186","78","1","6","5","Jounral Entry","3","2014-07-15 08:19:31");
INSERT INTO audit_log VALUES("187","78","1","7","4","Credit Note","2","2014-07-15 08:28:12");
INSERT INTO audit_log VALUES("188","78","1","2","4","Credit Note","5","2014-07-15 08:32:32");
INSERT INTO audit_log VALUES("189","78","1","6","4","Credit Note","2","2014-07-15 08:32:32");
INSERT INTO audit_log VALUES("190","78","1","7","3","Invoice","7","2014-07-15 08:34:18");
INSERT INTO audit_log VALUES("191","78","1","2","3","Invoice","11","2014-07-15 08:41:33");
INSERT INTO audit_log VALUES("192","78","1","6","3","Invoice","7","2014-07-15 08:41:33");
INSERT INTO audit_log VALUES("193","78","1","7","2","Expense","9","2014-07-15 08:43:30");
INSERT INTO audit_log VALUES("194","78","1","2","2","Expense","22","2014-07-15 08:43:58");
INSERT INTO audit_log VALUES("195","78","1","6","2","Expense","9","2014-07-15 08:43:58");
INSERT INTO audit_log VALUES("196","78","1","7","5","Jounral Entry","1","2014-07-15 08:44:49");
INSERT INTO audit_log VALUES("197","78","1","2","5","Jounral Entry","5","2014-07-15 08:45:05");
INSERT INTO audit_log VALUES("198","78","1","6","5","Jounral Entry","1","2014-07-15 08:45:05");
INSERT INTO audit_log VALUES("199","78","1","7","3","Invoice","4","2014-07-15 08:48:01");
INSERT INTO audit_log VALUES("200","78","1","7","4","Credit Note","2","2014-07-15 08:48:14");
INSERT INTO audit_log VALUES("201","78","1","3","4","Credit Note","2","2014-07-15 08:48:28");
INSERT INTO audit_log VALUES("202","78","1","1","4","Credit Note","6","2014-07-15 08:50:13");
INSERT INTO audit_log VALUES("203","78","1","6","4","Credit Note","5","2014-07-15 08:50:13");
INSERT INTO audit_log VALUES("204","78","1","6","3","Invoice","4","2014-07-15 08:51:16");
INSERT INTO audit_log VALUES("205","78","1","7","3","Invoice","1","2014-07-15 08:52:03");
INSERT INTO audit_log VALUES("206","78","1","2","3","Invoice","12","2014-07-15 08:52:26");
INSERT INTO audit_log VALUES("207","78","1","6","3","Invoice","1","2014-07-15 08:52:26");
INSERT INTO audit_log VALUES("208","78","1","1","11","Invoice","4","2014-07-15 08:52:54");
INSERT INTO audit_log VALUES("209","78","1","1","11","Invoice","5","2014-07-15 08:53:46");
INSERT INTO audit_log VALUES("210","78","1","1","11","Invoice","6","2014-07-15 08:55:03");
INSERT INTO audit_log VALUES("211","78","1","1","11","Invoice","7","2014-07-15 08:55:40");
INSERT INTO audit_log VALUES("212","78","1","1","11","Invoice","8","2014-07-15 08:56:21");
INSERT INTO audit_log VALUES("213","78","1","7","3","Invoice","3","2014-07-15 08:57:11");
INSERT INTO audit_log VALUES("214","78","1","2","3","Invoice","13","2014-07-15 08:57:44");
INSERT INTO audit_log VALUES("215","78","1","6","3","Invoice","3","2014-07-15 08:57:44");
INSERT INTO audit_log VALUES("216","78","1","7","3","Invoice","3","2014-07-15 08:58:14");
INSERT INTO audit_log VALUES("217","78","1","2","3","Invoice","14","2014-07-15 08:58:53");
INSERT INTO audit_log VALUES("218","78","1","6","3","Invoice","3","2014-07-15 08:58:53");
INSERT INTO audit_log VALUES("219","78","1","7","3","Invoice","3","2014-07-15 08:59:10");
INSERT INTO audit_log VALUES("220","78","1","2","3","Invoice","15","2014-07-15 09:00:22");
INSERT INTO audit_log VALUES("221","78","1","6","3","Invoice","3","2014-07-15 09:00:22");
INSERT INTO audit_log VALUES("222","78","1","3","3","Invoice","3","2014-07-15 09:01:41");
INSERT INTO audit_log VALUES("223","78","1","1","3","Invoice","16","2014-07-15 09:03:02");
INSERT INTO audit_log VALUES("224","78","1","6","3","Invoice","9","2014-07-15 09:03:02");
INSERT INTO audit_log VALUES("225","78","1","7","3","Invoice","9","2014-07-15 09:03:12");
INSERT INTO audit_log VALUES("226","78","1","2","3","Invoice","17","2014-07-15 09:03:35");
INSERT INTO audit_log VALUES("227","78","1","6","3","Invoice","9","2014-07-15 09:03:35");
INSERT INTO audit_log VALUES("228","78","1","1","11","Expense","9","2014-07-15 09:06:37");
INSERT INTO audit_log VALUES("229","78","1","1","11","Expense","10","2014-07-15 09:06:56");
INSERT INTO audit_log VALUES("230","78","1","1","11","Expense","11","2014-07-15 09:07:36");
INSERT INTO audit_log VALUES("231","78","1","1","11","Expense","12","2014-07-15 09:09:48");
INSERT INTO audit_log VALUES("232","78","1","1","11","Expense","13","2014-07-15 09:10:19");
INSERT INTO audit_log VALUES("233","78","1","1","11","Expense","14","2014-07-15 09:10:38");
INSERT INTO audit_log VALUES("234","78","1","7","2","Expense","8","2014-07-15 09:11:06");
INSERT INTO audit_log VALUES("235","78","1","2","2","Expense","23","2014-07-15 09:12:24");
INSERT INTO audit_log VALUES("236","78","1","6","2","Expense","8","2014-07-15 09:12:24");
INSERT INTO audit_log VALUES("237","78","1","1","11","Expense","15","2014-07-15 09:15:01");
INSERT INTO audit_log VALUES("238","78","1","1","11","Expense","16","2014-07-15 09:16:08");
INSERT INTO audit_log VALUES("239","78","1","1","11","Expense","17","2014-07-15 09:16:25");
INSERT INTO audit_log VALUES("240","78","1","7","2","Expense","14","2014-07-15 09:16:40");
INSERT INTO audit_log VALUES("241","78","1","7","2","Expense","7","2014-07-15 09:16:57");
INSERT INTO audit_log VALUES("242","78","1","2","2","Expense","24","2014-07-15 09:17:52");
INSERT INTO audit_log VALUES("243","78","1","6","2","Expense","14","2014-07-15 09:17:52");
INSERT INTO audit_log VALUES("244","78","1","7","2","Expense","14","2014-07-15 09:18:08");
INSERT INTO audit_log VALUES("245","78","1","1","11","Expense","18","2014-07-15 09:19:12");
INSERT INTO audit_log VALUES("246","78","1","2","2","Expense","25","2014-07-15 09:19:28");
INSERT INTO audit_log VALUES("247","78","1","6","2","Expense","14","2014-07-15 09:19:28");
INSERT INTO audit_log VALUES("248","78","1","1","11","Expense","19","2014-07-15 09:20:08");
INSERT INTO audit_log VALUES("249","78","1","7","2","Expense","2","2014-07-15 09:20:15");
INSERT INTO audit_log VALUES("250","78","1","2","11","Expense","20","2014-07-15 09:21:12");
INSERT INTO audit_log VALUES("251","78","1","2","11","Expense","21","2014-07-15 09:21:25");
INSERT INTO audit_log VALUES("252","78","1","2","11","Expense","22","2014-07-15 09:21:37");
INSERT INTO audit_log VALUES("253","78","1","1","11","Expense","23","2014-07-15 09:22:33");
INSERT INTO audit_log VALUES("254","78","1","7","3","Invoice","9","2014-07-15 09:25:22");
INSERT INTO audit_log VALUES("255","78","1","2","3","Invoice","18","2014-07-15 09:26:31");
INSERT INTO audit_log VALUES("256","78","1","6","3","Invoice","9","2014-07-15 09:26:31");
INSERT INTO audit_log VALUES("257","78","1","7","3","Invoice","9","2014-07-15 09:28:14");
INSERT INTO audit_log VALUES("258","78","1","2","3","Invoice","19","2014-07-15 09:29:22");
INSERT INTO audit_log VALUES("259","78","1","6","3","Invoice","9","2014-07-15 09:29:22");
INSERT INTO audit_log VALUES("260","78","1","7","1","Income","1","2014-07-15 10:19:16");
INSERT INTO audit_log VALUES("261","78","1","3","11","Income","1","2014-07-15 10:19:32");
INSERT INTO audit_log VALUES("262","78","1","2","1","Income","9","2014-07-15 10:22:25");
INSERT INTO audit_log VALUES("263","78","1","6","1","Income","1","2014-07-15 10:22:25");
INSERT INTO audit_log VALUES("264","78","1","7","1","Income","1","2014-07-15 10:24:09");
INSERT INTO audit_log VALUES("265","78","2","7","3","Invoice","8","2014-07-15 10:28:15");
INSERT INTO audit_log VALUES("266","78","2","7","3","Invoice","9","2014-07-15 10:28:20");
INSERT INTO audit_log VALUES("267","78","2","6","3","Invoice","8","2014-07-15 10:28:31");
INSERT INTO audit_log VALUES("268","78","2","6","3","Invoice","9","2014-07-15 10:30:40");
INSERT INTO audit_log VALUES("269","78","2","1","11","Invoice","24","2014-07-15 10:51:17");
INSERT INTO audit_log VALUES("270","78","2","1","11","Invoice","25","2014-07-15 10:54:57");
INSERT INTO audit_log VALUES("271","78","2","6","2","Expense","7","2014-07-15 10:55:41");
INSERT INTO audit_log VALUES("272","78","2","6","2","Expense","2","2014-07-15 10:56:01");
INSERT INTO audit_log VALUES("273","78","2","6","1","Income","1","2014-07-15 10:56:55");
INSERT INTO audit_log VALUES("274","78","2","1","11","Expense","26","2014-07-15 10:58:55");
INSERT INTO audit_log VALUES("275","78","2","7","1","Income","1","2014-07-15 11:02:16");
INSERT INTO audit_log VALUES("276","78","2","3","11","Income","1","2014-07-15 11:02:34");
INSERT INTO audit_log VALUES("277","78","2","2","1","Income","10","2014-07-15 11:02:43");
INSERT INTO audit_log VALUES("278","78","2","6","1","Income","1","2014-07-15 11:02:43");
INSERT INTO audit_log VALUES("279","78","2","1","11","Income","27","2014-07-15 11:03:21");
INSERT INTO audit_log VALUES("280","78","2","7","3","Invoice","5","2014-07-15 13:27:31");
INSERT INTO audit_log VALUES("281","78","2","7","3","Invoice","1","2014-07-15 13:27:32");
INSERT INTO audit_log VALUES("282","78","2","2","11","Invoice","28","2014-07-15 13:27:51");
INSERT INTO audit_log VALUES("283","78","2","2","3","Invoice","20","2014-07-15 13:27:54");
INSERT INTO audit_log VALUES("284","78","2","6","3","Invoice","5","2014-07-15 13:27:54");
INSERT INTO audit_log VALUES("285","78","2","6","3","Invoice","1","2014-07-15 13:28:00");
INSERT INTO audit_log VALUES("286","78","2","7","3","Invoice","1","2014-07-15 13:28:07");
INSERT INTO audit_log VALUES("287","78","2","2","11","Invoice","29","2014-07-15 13:28:24");
INSERT INTO audit_log VALUES("288","78","2","2","3","Invoice","21","2014-07-15 13:28:27");
INSERT INTO audit_log VALUES("289","78","2","6","3","Invoice","1","2014-07-15 13:28:27");
INSERT INTO audit_log VALUES("290","78","2","7","2","Expense","6","2014-07-15 13:36:16");
INSERT INTO audit_log VALUES("291","78","2","6","2","Expense","6","2014-07-15 13:36:21");





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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO credit VALUES("1","78","CR-0000000001","2","1","SGD","0.00000","2014-04-15","Changes the Order","0","1","2","1","2014-07-15 08:15:24","0000-00-00 00:00:00");
INSERT INTO credit VALUES("2","78","CR-0000000002","4","2","SGD","0.00000","2014-04-30","Changes the Order","0","2","2","2","2014-07-15 08:16:34","2014-07-15 08:48:28");
INSERT INTO credit VALUES("3","78","CR-0000000003","6","1","SGD","0.00000","2014-05-05","Changes the Order","0","1","2","1","2014-07-15 08:17:52","0000-00-00 00:00:00");
INSERT INTO credit VALUES("4","78","CR-0000000004","8","3","USD","1.24640","2014-05-15","Changes the Order","0","1","2","1","2014-07-15 08:18:41","0000-00-00 00:00:00");
INSERT INTO credit VALUES("5","78","CR-0000000005","7","2","SGD","0.00000","2014-05-15","Changed the order","0","1","2","1","2014-07-15 08:50:13","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO credit_audit VALUES("1","1","2","1","SGD","0.00000","2014-04-15","Changes the Order","0","1","2","1","2014-07-15 08:15:24");
INSERT INTO credit_audit VALUES("2","2","4","2","SGD","0.00000","2014-04-30","Changes the Order","0","1","2","1","2014-07-15 08:16:34");
INSERT INTO credit_audit VALUES("3","3","6","1","SGD","0.00000","2014-05-05","Changes the Order","0","1","2","1","2014-07-15 08:17:52");
INSERT INTO credit_audit VALUES("4","4","8","3","USD","1.24640","2014-05-15","Changes the Order","0","1","2","1","2014-07-15 08:18:41");
INSERT INTO credit_audit VALUES("5","2","0","2","SGD","0.00000","2014-04-30","Changes the Order","0","1","2","1","2014-07-15 08:32:32");
INSERT INTO credit_audit VALUES("6","5","7","2","SGD","0.00000","2014-05-15","Changed the order","0","1","2","1","2014-07-15 08:50:13");





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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

INSERT INTO credit_product_list VALUES("1","1","P8","2","20","25.00","0.00","3","7.00","2014-07-15 08:15:24","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("2","1","Whisky","8","25","12.00","0.00","3","7.00","2014-07-15 08:15:24","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("3","1","SC50","7","1","50.00","0.00","3","7.00","2014-07-15 08:15:24","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("4","2","Whisky","8","50","12.00","0.00","3","7.00","2014-07-15 08:16:34","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("5","2","Wine","9","107","10.00","0.00","3","7.00","2014-07-15 08:16:34","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("6","2","SC100","6","1","100.00","25.00","3","7.00","2014-07-15 08:16:34","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("7","3","PA01","3","2","20.00","0.00","3","7.00","2014-07-15 08:17:52","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("8","3","PA02","4","2","30.00","0.00","3","7.00","2014-07-15 08:17:52","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("9","3","P12","1","2","35.00","0.00","3","7.00","2014-07-15 08:17:52","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("10","3","P8","2","2","25.00","0.00","3","7.00","2014-07-15 08:17:52","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("11","3","Whisky","8","2","12.00","0.00","3","7.00","2014-07-15 08:17:52","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("12","3","Wine","9","2","10.00","0.00","3","7.00","2014-07-15 08:17:52","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("13","3","SC100","6","1","100.00","0.00","3","7.00","2014-07-15 08:17:52","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("14","3","SC50","7","1","50.00","0.00","3","7.00","2014-07-15 08:17:52","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("15","4","HMP - USD","10","100","50.00","400.00","3","7.00","2014-07-15 08:18:41","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("16","4","PD - USD","5","100","10.00","100.00","3","7.00","2014-07-15 08:18:41","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("17","5","Whisky","8","100","12.00","200.00","3","7.00","2014-07-15 08:50:13","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("18","5","Wine","9","70","10.00","30.00","3","7.00","2014-07-15 08:50:13","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("19","5","SC100","6","1","100.00","25.00","3","7.00","2014-07-15 08:50:13","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

INSERT INTO credit_product_list_audit VALUES("1","1","P8","2","20","25.00","0.00","3","7.00","2014-07-15 08:15:24");
INSERT INTO credit_product_list_audit VALUES("2","1","Whisky","8","25","12.00","0.00","3","7.00","2014-07-15 08:15:24");
INSERT INTO credit_product_list_audit VALUES("3","1","SC50","7","1","50.00","0.00","3","7.00","2014-07-15 08:15:24");
INSERT INTO credit_product_list_audit VALUES("4","2","Whisky","8","100","12.00","0.00","3","7.00","2014-07-15 08:16:34");
INSERT INTO credit_product_list_audit VALUES("5","2","Wine","9","100","10.00","0.00","3","7.00","2014-07-15 08:16:34");
INSERT INTO credit_product_list_audit VALUES("6","2","SC100","6","1","100.00","25.00","3","7.00","2014-07-15 08:16:34");
INSERT INTO credit_product_list_audit VALUES("7","3","PA01","3","2","20.00","0.00","3","7.00","2014-07-15 08:17:52");
INSERT INTO credit_product_list_audit VALUES("8","3","PA02","4","2","30.00","0.00","3","7.00","2014-07-15 08:17:52");
INSERT INTO credit_product_list_audit VALUES("9","3","P12","1","2","35.00","0.00","3","7.00","2014-07-15 08:17:52");
INSERT INTO credit_product_list_audit VALUES("10","3","P8","2","2","25.00","0.00","3","7.00","2014-07-15 08:17:52");
INSERT INTO credit_product_list_audit VALUES("11","3","Whisky","8","2","12.00","0.00","3","7.00","2014-07-15 08:17:52");
INSERT INTO credit_product_list_audit VALUES("12","3","Wine","9","2","10.00","0.00","3","7.00","2014-07-15 08:17:52");
INSERT INTO credit_product_list_audit VALUES("13","3","SC100","6","1","100.00","0.00","3","7.00","2014-07-15 08:17:52");
INSERT INTO credit_product_list_audit VALUES("14","3","SC50","7","1","50.00","0.00","3","7.00","2014-07-15 08:17:52");
INSERT INTO credit_product_list_audit VALUES("15","4","HMP - USD","10","100","50.00","400.00","3","7.00","2014-07-15 08:18:41");
INSERT INTO credit_product_list_audit VALUES("16","4","PD - USD","5","100","10.00","100.00","3","7.00","2014-07-15 08:18:41");
INSERT INTO credit_product_list_audit VALUES("17","5","Whisky","8","50","12.00","0.00","3","7.00","2014-07-15 08:32:32");
INSERT INTO credit_product_list_audit VALUES("18","5","Wine","9","107","10.00","0.00","3","7.00","2014-07-15 08:32:32");
INSERT INTO credit_product_list_audit VALUES("19","5","SC100","6","1","100.00","25.00","3","7.00","2014-07-15 08:32:32");
INSERT INTO credit_product_list_audit VALUES("20","6","Whisky","8","100","12.00","200.00","3","7.00","2014-07-15 08:50:13");
INSERT INTO credit_product_list_audit VALUES("21","6","Wine","9","70","10.00","30.00","3","7.00","2014-07-15 08:50:13");
INSERT INTO credit_product_list_audit VALUES("22","6","SC100","6","1","100.00","25.00","3","7.00","2014-07-15 08:50:13");





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

INSERT INTO customers VALUES("1","78","CUS-0000000001","OPH","16 Sandilands Road","","1978885558M-PTE-04","69453482","","Singapore","Singapore","SG","","","","546080","0000-00-00","3","","1","2014-07-15 04:53:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("2","78","CUS-0000000002","EZH & Qh","123 Address Road","","1978885558M-PTE-05","69453483","","Singapore","Singapore","SG","","","","546080","0000-00-00","3","","1","2014-07-15 04:53:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("3","78","CUS-0000000003","Dome - Dubai","123 Address Road","","1978885558M-PTE-06","69453484","","Dubai","Dubai","AE","","","","546080","0000-00-00","3","","1","2014-07-15 04:53:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("4","78","CUS-0000000004","Ciao Cafe - Vietnam","123 Address Road","","1978885558M-PTE-07","69453485","","Ho Chi Minh","Saigon","VN","","","","546080","0000-00-00","3","","1","2014-07-15 04:53:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("5","78","CUS-0000000005","Melinium Sdn Bhd","123 Address Road","","1978885558M-PTE-08","69453486","","KL","Selangor","MY","","","","546080","0000-00-00","4","","1","2014-07-15 04:53:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("6","78","CUS-0000000006","Temasek LLC","123 Address Road","","1978885558M-PTE-09","69453487","","Dubai","Dubai","AE","","","","546080","0000-00-00","4","","1","2014-07-15 04:53:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("7","78","CUS-0000000007","Grean Ocean Pte Ltd","123 Address Road","","1978885558M-PTE-10","69453488","","Singapore","Singapore","SG","","","","546080","0000-00-00","33","","1","2014-07-15 04:53:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("8","78","CUS-0000000008","Indian Bank","123 Address Road","","1978885558M-PTE-11","69453489","","Singapore","Singapore","SG","","","","546080","0000-00-00","21","","1","2014-07-15 04:53:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("9","78","CUS-0000000009","Indian Overseas Bank","123 Address Road","","1978885558M-PTE-21","69453489","","Chennai","Tamil Nadu","IN","","","","600064","0000-00-00","21","","1","2014-07-15 04:53:56","0000-00-00 00:00:00");





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

INSERT INTO expense_transaction VALUES("1","78","EXP-0000000001","2014-05-14","PC2","7","","1","2014-05-14","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","5","2014-05-14","1","2014-07-15 04:54:29","2014-07-15 05:37:22");
INSERT INTO expense_transaction VALUES("2","78","EXP-0000000002","2014-04-01","2","5","","3","2014-05-31","USD","1.22000","87.50","","2","0.00","n/a","","","99","1","1","23","2014-05-25","1","2014-07-15 04:54:29","2014-07-15 10:56:01");
INSERT INTO expense_transaction VALUES("3","78","EXP-0000000003","2014-04-01","3","1","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","13","2014-04-27","1","2014-07-15 04:54:29","2014-07-15 09:07:36");
INSERT INTO expense_transaction VALUES("4","78","EXP-0000000004","2014-04-01","4","3","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","15","2014-04-27","1","2014-07-15 04:54:29","2014-07-15 09:10:19");
INSERT INTO expense_transaction VALUES("5","78","EXP-0000000005","2014-04-01","5","4","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","28","2014-04-25","1","2014-07-15 04:54:29","2014-07-15 10:58:55");
INSERT INTO expense_transaction VALUES("6","78","EXP-0000000006","2014-04-01","6","2","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","2","0","0000-00-00","1","2014-07-15 04:54:29","2014-07-15 13:36:21");
INSERT INTO expense_transaction VALUES("7","78","EXP-0000000007","2014-04-01","7","7","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","22","2014-04-01","1","2014-07-15 04:54:29","2014-07-15 10:55:41");
INSERT INTO expense_transaction VALUES("8","78","EXP-0000000008","2014-04-15","8","8","","1","2014-04-15","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","17","2014-04-15","1","2014-07-15 04:54:29","2014-07-15 09:12:24");
INSERT INTO expense_transaction VALUES("9","78","EXP-0000000009","2014-04-30","9","9","","2","2014-05-30","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","11","2014-04-30","1","2014-07-15 04:54:29","2014-07-15 09:06:37");
INSERT INTO expense_transaction VALUES("10","78","EXP-0000000010","2014-05-01","10","1","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","14","2014-05-27","1","2014-07-15 04:54:29","2014-07-15 09:09:48");
INSERT INTO expense_transaction VALUES("11","78","EXP-0000000011","2014-05-01","11","3","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","2","0","0000-00-00","1","2014-07-15 04:54:29","2014-07-15 04:57:46");
INSERT INTO expense_transaction VALUES("12","78","EXP-0000000012","2014-05-01","12","4","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","18","2014-05-25","1","2014-07-15 04:54:29","2014-07-15 09:15:00");
INSERT INTO expense_transaction VALUES("13","78","EXP-0000000013","2014-05-01","13","2","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","20","2014-05-25","1","2014-07-15 04:54:29","2014-07-15 09:16:25");
INSERT INTO expense_transaction VALUES("14","78","EXP-0000000014","2014-05-01","14","7","","1","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","21","2014-05-01","1","2014-07-15 04:54:29","2014-07-15 09:19:28");
INSERT INTO expense_transaction VALUES("15","78","EXP-0000000015","2014-05-31","15","9","","2","2014-06-30","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","12","2014-05-31","1","2014-07-15 04:54:29","2014-07-15 09:06:56");
INSERT INTO expense_transaction VALUES("16","78","EXP-0000000016","2014-04-01","1","6","","2","2014-05-01","EUR","1.70000","1225.00","","2","0.00","n/a","","","99","1","1","24","2014-05-31","1","2014-07-15 04:54:38","2014-07-15 09:22:33");
INSERT INTO expense_transaction VALUES("17","78","EXP-0000000017","2014-04-14","PC1","7","","1","2014-04-14","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","4","2014-04-14","1","2014-07-15 04:54:38","2014-07-15 05:36:09");





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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction_audit VALUES("1","1","2014-05-14","PC2","7","","1","2014-05-14","SGD","0.00000","0.00","","2","0.00","n/a","","","99","3","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("2","2","2014-04-01","2","5","","3","2014-05-31","USD","1.24100","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("3","3","2014-04-01","3","1","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("4","4","2014-04-01","4","3","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("5","5","2014-04-01","5","4","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("6","6","2014-04-01","6","2","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("7","7","2014-04-01","7","7","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("8","8","2014-04-15","8","8","","2","2014-05-15","SGD","0.00000","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("9","9","2014-04-30","9","9","","2","2014-05-30","SGD","0.00000","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("10","10","2014-05-01","10","1","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("11","11","2014-05-01","11","3","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("12","12","2014-05-01","12","4","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("13","13","2014-05-01","13","2","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("14","14","2014-05-01","14","7","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("15","15","2014-05-31","15","9","","2","2014-06-30","SGD","0.00000","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:29");
INSERT INTO expense_transaction_audit VALUES("16","16","2014-04-01","1","6","","2","2014-05-01","EUR","1.69060","0.00","","2","0.00","n/a","","","99","2","1","2014-07-15 04:54:38");
INSERT INTO expense_transaction_audit VALUES("17","17","2014-04-14","PC1","7","","1","2014-04-14","SGD","0.00000","0.00","","2","0.00","n/a","","","99","3","1","2014-07-15 04:54:38");
INSERT INTO expense_transaction_audit VALUES("18","17","2014-04-14","PC1","7","","1","2014-04-14","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","2014-07-15 05:36:09");
INSERT INTO expense_transaction_audit VALUES("19","1","2014-05-14","PC2","7","","1","2014-05-14","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","2014-07-15 05:37:22");
INSERT INTO expense_transaction_audit VALUES("20","16","2014-04-01","1","6","","2","2014-05-01","EUR","1.70000","1225.00","","2","0.00","n/a","","","99","1","1","2014-07-15 08:06:29");
INSERT INTO expense_transaction_audit VALUES("21","2","2014-04-01","2","5","","3","2014-05-31","USD","1.22000","87.50","","2","0.00","n/a","","","99","1","1","2014-07-15 08:09:22");
INSERT INTO expense_transaction_audit VALUES("22","9","2014-04-30","9","9","","2","2014-05-30","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","2014-07-15 08:43:58");
INSERT INTO expense_transaction_audit VALUES("23","8","2014-04-15","8","8","","1","2014-04-15","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","2014-07-15 09:12:24");
INSERT INTO expense_transaction_audit VALUES("24","14","2014-05-01","14","7","","1","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","2014-07-15 09:17:52");
INSERT INTO expense_transaction_audit VALUES("25","14","2014-05-01","14","7","","1","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","99","1","1","2014-07-15 09:19:28");





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

INSERT INTO expense_transaction_list VALUES("1","1","50","","Warehouse Apr 14","1","940.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("2","1","62","","Warehouse Apr 14","3","20.00","0","0.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("3","2","45","","Vietnamese Food Items - Apr 14","1","1000.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("4","3","45","","Food - Apr 14","1","5485.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("5","4","46","","Beer - Apr 14","1","20000.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("6","5","46","","Wines - Apr 14","1","10000.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("7","6","47","","Misc. - Apr 14","1","5000.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("8","7","64","","Apr 2014","1","2000.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("9","8","63","","Initial Design and Plan Processing","1","2500.00","0","0.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("10","9","54","","Apr 2014 - Cleaning Services","1","14014.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("11","10","45","","Food - May 14","1","15400.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("12","11","46","","Beer - May 14","1","40000.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("13","12","46","","Wines - May 14","1","10000.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("14","13","47","","Misc. - May 14","1","5000.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("15","14","64","","May 14","1","2000.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("16","15","54","","May 2014 - Cleaning Services","1","15000.00","4","7.00","2014-07-15 04:54:29","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("17","16","23","","Pasta Machines","1","10000.00","4","7.00","2014-07-15 04:54:38","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("18","17","50","","Warehouse Apr 14","1","440.00","4","7.00","2014-07-15 04:54:38","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("19","17","62","","Warehouse Apr 14","3","20.00","0","0.00","2014-07-15 04:54:38","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction_list_audit VALUES("1","1","50","","Warehouse Apr 14","1","940.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("2","1","62","","Warehouse Apr 14","3","20.00","0","0.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("3","2","45","","Vietnamese Food Items - Apr 14","1","1000.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("4","3","45","","Food - Apr 14","1","5485.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("5","4","46","","Beer - Apr 14","1","20000.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("6","5","46","","Wines - Apr 14","1","10000.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("7","6","47","","Misc. - Apr 14","1","5000.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("8","7","64","","Apr 2014","1","2000.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("9","8","63","","Initial Design and Plan Processing","1","2500.00","0","0.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("10","9","54","","Apr 2014 - Cleaning Services","1","15000.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("11","10","45","","Food - May 14","1","15400.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("12","11","46","","Beer - May 14","1","40000.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("13","12","46","","Wines - May 14","1","10000.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("14","13","47","","Misc. - May 14","1","5000.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("15","14","64","","May 14","1","2000.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("16","15","54","","May 2014 - Cleaning Services","1","15000.00","4","7.00","2014-07-15 04:54:29");
INSERT INTO expense_transaction_list_audit VALUES("17","16","23","","Pasta Machines","1","10000.00","4","7.00","2014-07-15 04:54:38");
INSERT INTO expense_transaction_list_audit VALUES("18","17","50","","Warehouse Apr 14","1","440.00","4","7.00","2014-07-15 04:54:38");
INSERT INTO expense_transaction_list_audit VALUES("19","17","62","","Warehouse Apr 14","3","20.00","0","0.00","2014-07-15 04:54:38");
INSERT INTO expense_transaction_list_audit VALUES("20","18","50","","Warehouse Apr 14","1","440.00","4","7.00","2014-07-15 05:36:09");
INSERT INTO expense_transaction_list_audit VALUES("21","18","62","","Warehouse Apr 14","3","20.00","0","0.00","2014-07-15 05:36:09");
INSERT INTO expense_transaction_list_audit VALUES("22","19","50","","Warehouse Apr 14","1","940.00","4","7.00","2014-07-15 05:37:22");
INSERT INTO expense_transaction_list_audit VALUES("23","19","62","","Warehouse Apr 14","3","20.00","0","0.00","2014-07-15 05:37:22");
INSERT INTO expense_transaction_list_audit VALUES("24","20","23","","Pasta Machines","1","10000.00","4","7.00","2014-07-15 08:06:29");
INSERT INTO expense_transaction_list_audit VALUES("25","21","45","","Vietnamese Food Items - Apr 14","1","1000.00","4","7.00","2014-07-15 08:09:22");
INSERT INTO expense_transaction_list_audit VALUES("26","22","54","","Apr 2014 - Cleaning Services","1","14014.00","4","7.00","2014-07-15 08:43:58");
INSERT INTO expense_transaction_list_audit VALUES("27","23","63","","Initial Design and Plan Processing","1","2500.00","0","0.00","2014-07-15 09:12:24");
INSERT INTO expense_transaction_list_audit VALUES("28","24","64","","May 14","1","2000.00","4","7.00","2014-07-15 09:17:52");
INSERT INTO expense_transaction_list_audit VALUES("29","25","64","","May 14","1","2000.00","4","7.00","2014-07-15 09:19:28");





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

INSERT INTO income_transaction VALUES("1","78","INC-0000000001","2014-04-25","3","5","","2","MYR","0.38940","39","Admin Fee - Apr 2014","2500.00","","3","7.00","99","1","1","29","2014-04-25","1","2014-07-15 04:54:08","2014-07-15 11:03:21");
INSERT INTO income_transaction VALUES("2","78","INC-0000000002","2014-05-25","4","5","","1","MYR","0.37000","39","Admin Fee - May 2014","2500.00","","3","7.00","99","1","1","2","2014-05-25","1","2014-07-15 04:54:13","2014-07-15 05:33:04");
INSERT INTO income_transaction VALUES("3","78","INC-0000000003","2014-05-31","FD02","8","","1","SGD","0.00000","40","Interest Added to Preminum","312.50","","1","0.00","99","1","1","3","2014-05-31","1","2014-07-15 04:54:13","2014-07-15 05:34:41");





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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO income_transaction_audit VALUES("1","1","2014-04-25","3","5","","1","MYR","0.39010","39","Admin Fee - Apr 2014","2500.00","","3","7.00","99","3","2014-07-15 04:54:08");
INSERT INTO income_transaction_audit VALUES("2","2","2014-05-25","4","5","","1","MYR","0.39010","39","Admin Fee - May 2014","2500.00","","3","7.00","99","3","2014-07-15 04:54:13");
INSERT INTO income_transaction_audit VALUES("3","3","2014-05-31","FD02","8","","1","SGD","0.00000","40","Interest Added to Preminum","312.50","","1","0.00","99","3","2014-07-15 04:54:13");
INSERT INTO income_transaction_audit VALUES("4","1","2014-04-25","3","5","","1","MYR","0.39010","39","Admin Fee - Apr 2014","2500.00","","3","7.00","99","2","2014-07-15 05:07:44");
INSERT INTO income_transaction_audit VALUES("5","2","2014-05-25","4","5","","1","MYR","0.39010","39","Admin Fee - May 2014","2500.00","","3","7.00","99","2","2014-07-15 05:29:08");
INSERT INTO income_transaction_audit VALUES("6","1","2014-04-25","3","5","","1","MYR","0.38940","39","Admin Fee - Apr 2014","2500.00","","3","7.00","99","2","2014-07-15 05:32:14");
INSERT INTO income_transaction_audit VALUES("7","2","2014-05-25","4","5","","1","MYR","0.37000","39","Admin Fee - May 2014","2500.00","","3","7.00","99","2","2014-07-15 05:32:56");
INSERT INTO income_transaction_audit VALUES("8","3","2014-05-31","FD02","8","","1","SGD","0.00000","40","Interest Added to Preminum","312.50","","1","0.00","99","2","2014-07-15 05:34:21");
INSERT INTO income_transaction_audit VALUES("9","1","2014-04-25","3","5","","1","MYR","0.38940","39","Admin Fee - Apr 2014","2500.00","","3","7.00","99","2","2014-07-15 10:22:25");
INSERT INTO income_transaction_audit VALUES("10","1","2014-04-25","3","5","","2","MYR","0.38940","39","Admin Fee - Apr 2014","2500.00","","3","7.00","99","2","2014-07-15 11:02:43");





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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO invoice VALUES("1","78","INV-0000000001","2014-04-01","7","0","2","2014-05-01","SGD","0.00000","1","2","rental - unit 113b","","99","1","1","7","2014-04-02","2","1","2014-07-15 04:54:50","2014-07-15 13:28:27");
INSERT INTO invoice VALUES("2","78","INV-0000000002","2014-04-15","1","0","2","2014-05-15","SGD","0.00000","1","2","apr intial order","","99","1","2","0","0000-00-00","2","1","2014-07-15 04:54:50","2014-07-15 04:57:46");
INSERT INTO invoice VALUES("3","78","INV-0000000003","2014-04-15","3","0","2","2014-05-15","USD","1.25000","1","2","apr 14 order","","99","1","2","0","0000-00-00","2","2","2014-07-15 04:55:11","2014-07-15 09:01:41");
INSERT INTO invoice VALUES("4","78","INV-0000000004","2014-04-30","2","0","2","2014-05-30","SGD","0.00000","1","2","apr 14 order","","99","1","1","9","2014-06-01","2","1","2014-07-15 04:55:11","2014-07-15 08:55:40");
INSERT INTO invoice VALUES("5","78","INV-0000000005","2014-05-01","7","0","2","2014-05-31","SGD","0.00000","1","2","may 14 - rental","","99","1","1","6","2014-05-02","2","1","2014-07-15 04:55:11","2014-07-15 13:27:54");
INSERT INTO invoice VALUES("6","78","INV-0000000006","2014-05-05","1","0","2","2014-06-04","SGD","0.00000","1","2","may 14 order","","99","1","2","0","0000-00-00","2","1","2014-07-15 04:55:11","2014-07-15 04:57:46");
INSERT INTO invoice VALUES("7","78","INV-0000000007","2014-05-15","2","0","2","2014-06-14","SGD","0.00000","1","2","may 14 order","","99","1","1","10","2014-06-01","2","1","2014-07-15 04:55:11","2014-07-15 08:56:21");
INSERT INTO invoice VALUES("8","78","INV-0000000008","2014-05-15","3","0","2","2014-06-14","USD","1.24640","1","2","may 14 order","","99","1","1","27","2014-06-30","2","1","2014-07-15 04:55:16","2014-07-15 10:54:57");
INSERT INTO invoice VALUES("9","78","INV-0000000009","2014-04-15","3","0","2","2014-05-15","USD","1.25000","2","2","","","0","1","1","26","2014-05-12","2","1","2014-07-15 09:03:02","2014-07-15 10:51:17");





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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

INSERT INTO invoice_audit VALUES("1","1","2014-06-01","7","0","2","2014-07-01","SGD","0.00000","1","2","rental - unit 113b","","99","2","2","1","2014-07-15 04:54:50");
INSERT INTO invoice_audit VALUES("2","2","2014-04-15","1","0","2","2014-05-15","SGD","0.00000","1","2","apr intial order","","99","2","2","1","2014-07-15 04:54:50");
INSERT INTO invoice_audit VALUES("3","3","2014-04-15","3","0","2","2014-05-15","USD","1.24110","1","2","apr 14 order","","99","2","2","1","2014-07-15 04:55:11");
INSERT INTO invoice_audit VALUES("4","4","2014-04-30","2","0","2","2014-05-30","SGD","0.00000","1","2","apr 14 order","","99","2","2","1","2014-07-15 04:55:11");
INSERT INTO invoice_audit VALUES("5","5","2014-05-01","7","0","2","2014-05-31","SGD","0.00000","1","2","may 14 - rental","","99","2","2","1","2014-07-15 04:55:11");
INSERT INTO invoice_audit VALUES("6","6","2014-05-05","1","0","2","2014-06-04","SGD","0.00000","1","2","may 14 order","","99","2","2","1","2014-07-15 04:55:11");
INSERT INTO invoice_audit VALUES("7","7","2014-05-15","2","0","2","2014-06-14","SGD","0.00000","1","2","may 14 order","","99","2","2","1","2014-07-15 04:55:11");
INSERT INTO invoice_audit VALUES("8","8","2014-05-15","3","0","2","2014-06-14","USD","1.24100","1","2","may 14 order","","99","2","2","1","2014-07-15 04:55:16");
INSERT INTO invoice_audit VALUES("9","3","2014-04-15","3","0","2","2014-05-15","USD","1.25000","1","2","apr 14 order","","99","1","2","1","2014-07-15 08:12:46");
INSERT INTO invoice_audit VALUES("10","8","2014-05-15","3","0","2","2014-06-14","USD","1.24640","1","2","may 14 order","","99","1","2","1","2014-07-15 08:13:11");
INSERT INTO invoice_audit VALUES("11","7","2014-05-15","2","0","2","2014-06-14","SGD","0.00000","1","2","may 14 order","","99","1","2","1","2014-07-15 08:41:32");
INSERT INTO invoice_audit VALUES("12","1","2014-04-01","7","0","2","2014-05-01","SGD","0.00000","1","2","rental - unit 113b","","99","1","2","1","2014-07-15 08:52:26");
INSERT INTO invoice_audit VALUES("13","3","2014-04-15","3","0","2","2014-05-15","USD","1.25000","1","2","apr 14 order","","99","1","2","1","2014-07-15 08:57:44");
INSERT INTO invoice_audit VALUES("14","3","2014-04-15","3","0","2","2014-05-15","USD","1.24210","1","2","apr 14 order","","99","1","2","1","2014-07-15 08:58:53");
INSERT INTO invoice_audit VALUES("15","3","2014-04-15","3","0","2","2014-05-15","USD","1.25000","1","2","apr 14 order","","99","1","2","1","2014-07-15 09:00:22");
INSERT INTO invoice_audit VALUES("16","9","2014-04-15","3","0","2","2014-05-15","USD","1.25000","2","2","","","0","1","2","1","2014-07-15 09:03:02");
INSERT INTO invoice_audit VALUES("17","9","2014-04-15","3","0","2","2014-05-15","USD","1.25000","2","2","","","0","1","2","1","2014-07-15 09:03:35");
INSERT INTO invoice_audit VALUES("18","9","2014-04-15","3","0","2","2014-05-15","USD","1.25000","2","2","","","0","1","2","1","2014-07-15 09:26:31");
INSERT INTO invoice_audit VALUES("19","9","2014-04-15","3","0","2","2014-05-15","USD","1.25000","2","2","","","0","1","2","1","2014-07-15 09:29:22");
INSERT INTO invoice_audit VALUES("20","5","2014-05-01","7","0","2","2014-05-31","SGD","0.00000","1","2","may 14 - rental","","99","1","2","1","2014-07-15 13:27:54");
INSERT INTO invoice_audit VALUES("21","1","2014-04-01","7","0","2","2014-05-01","SGD","0.00000","1","2","rental - unit 113b","","99","1","2","1","2014-07-15 13:28:27");





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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

INSERT INTO invoice_product_list VALUES("1","1","R - 113B","11","1","2500.00","0.00","3","7.00","2014-07-15 04:54:50","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("2","2","PA01","3","100","20.00","0.00","3","7.00","2014-07-15 04:54:50","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("3","2","PA02","4","100","30.00","0.00","3","7.00","2014-07-15 04:54:50","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("4","2","P12","1","100","35.00","0.00","3","7.00","2014-07-15 04:54:50","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("5","2","P8","2","100","25.00","0.00","3","7.00","2014-07-15 04:54:50","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("6","2","Whisky","8","250","12.00","0.00","3","7.00","2014-07-15 04:54:50","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("7","2","Wine","9","200","10.00","0.00","3","7.00","2014-07-15 04:54:50","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("8","2","SC100","6","30","100.00","0.00","3","7.00","2014-07-15 04:54:50","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("9","2","SC50","7","70","50.00","0.00","3","7.00","2014-07-15 04:54:50","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("10","3","HMP - USD","10","100","50.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("11","3","PD - USD","5","1000","10.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("12","4","Whisky","8","500","12.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("13","4","Wine","9","500","10.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("14","4","SC100","6","10","100.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("15","4","SC50","7","20","50.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("16","5","R - 113B","11","1","2500.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("17","6","PA01","3","22","20.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("18","6","PA02","4","22","30.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("19","6","P12","1","22","35.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("20","6","P8","2","22","25.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("21","6","Whisky","8","22","12.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("22","6","Wine","9","22","10.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("23","6","SC100","6","11","100.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("24","6","SC50","7","11","50.00","0.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("25","7","Whisky","8","2000","12.00","1000.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("26","7","Wine","9","2000","10.00","1000.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("27","7","SC100","6","28","100.00","800.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("28","7","SC50","7","72","50.00","600.00","3","7.00","2014-07-15 04:55:11","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("29","8","HMP - USD","10","500","50.00","2000.00","3","7.00","2014-07-15 04:55:16","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("30","8","PD - USD","5","2000","10.00","2000.00","3","7.00","2014-07-15 04:55:16","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("31","9","HMP - USD","10","100","50.00","0.00","3","7.00","2014-07-15 09:03:02","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("32","9","PD - USD","5","1000","10.00","0.00","3","7.00","2014-07-15 09:03:02","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

INSERT INTO invoice_product_list_audit VALUES("1","1","R - 113B","11","1","2500.00","0.00","3","7.00","2014-07-15 04:54:50");
INSERT INTO invoice_product_list_audit VALUES("2","2","PA01","3","100","20.00","0.00","3","7.00","2014-07-15 04:54:50");
INSERT INTO invoice_product_list_audit VALUES("3","2","PA02","4","100","30.00","0.00","3","7.00","2014-07-15 04:54:50");
INSERT INTO invoice_product_list_audit VALUES("4","2","P12","1","100","35.00","0.00","3","7.00","2014-07-15 04:54:50");
INSERT INTO invoice_product_list_audit VALUES("5","2","P8","2","100","25.00","0.00","3","7.00","2014-07-15 04:54:50");
INSERT INTO invoice_product_list_audit VALUES("6","2","Whisky","8","250","12.00","0.00","3","7.00","2014-07-15 04:54:50");
INSERT INTO invoice_product_list_audit VALUES("7","2","Wine","9","200","10.00","0.00","3","7.00","2014-07-15 04:54:50");
INSERT INTO invoice_product_list_audit VALUES("8","2","SC100","6","30","100.00","0.00","3","7.00","2014-07-15 04:54:50");
INSERT INTO invoice_product_list_audit VALUES("9","2","SC50","7","70","50.00","0.00","3","7.00","2014-07-15 04:54:50");
INSERT INTO invoice_product_list_audit VALUES("10","3","HMP - USD","10","100","50.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("11","3","PD - USD","5","1000","10.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("12","4","Whisky","8","500","12.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("13","4","Wine","9","500","10.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("14","4","SC100","6","10","100.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("15","4","SC50","7","20","50.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("16","5","R - 113B","11","1","2500.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("17","6","PA01","3","22","20.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("18","6","PA02","4","22","30.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("19","6","P12","1","22","35.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("20","6","P8","2","22","25.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("21","6","Whisky","8","22","12.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("22","6","Wine","9","22","10.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("23","6","SC100","6","11","100.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("24","6","SC50","7","11","50.00","0.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("25","7","Whisky","8","2000","12.00","1000.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("26","7","Wine","9","2000","10.00","1000.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("27","7","SC100","6","28","100.00","800.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("28","7","SC50","7","72","50.00","600.00","3","7.00","2014-07-15 04:55:11");
INSERT INTO invoice_product_list_audit VALUES("29","8","HMP - USD","10","500","50.00","2000.00","3","7.00","2014-07-15 04:55:16");
INSERT INTO invoice_product_list_audit VALUES("30","8","PD - USD","5","2000","10.00","2000.00","3","7.00","2014-07-15 04:55:16");
INSERT INTO invoice_product_list_audit VALUES("31","9","HMP - USD","10","100","50.00","0.00","3","7.00","2014-07-15 08:12:46");
INSERT INTO invoice_product_list_audit VALUES("32","9","PD - USD","5","1000","10.00","0.00","3","7.00","2014-07-15 08:12:46");
INSERT INTO invoice_product_list_audit VALUES("33","10","HMP - USD","10","500","50.00","2000.00","3","7.00","2014-07-15 08:13:11");
INSERT INTO invoice_product_list_audit VALUES("34","10","PD - USD","5","2000","10.00","2000.00","3","7.00","2014-07-15 08:13:11");
INSERT INTO invoice_product_list_audit VALUES("35","11","Whisky","8","2000","12.00","1000.00","3","7.00","2014-07-15 08:41:32");
INSERT INTO invoice_product_list_audit VALUES("36","11","Wine","9","2000","10.00","1000.00","3","7.00","2014-07-15 08:41:32");
INSERT INTO invoice_product_list_audit VALUES("37","11","SC100","6","28","100.00","800.00","3","7.00","2014-07-15 08:41:32");
INSERT INTO invoice_product_list_audit VALUES("38","11","SC50","7","72","50.00","600.00","3","7.00","2014-07-15 08:41:32");
INSERT INTO invoice_product_list_audit VALUES("39","12","R - 113B","11","1","2500.00","0.00","3","7.00","2014-07-15 08:52:26");
INSERT INTO invoice_product_list_audit VALUES("40","13","HMP - USD","10","100","50.00","0.00","3","7.00","2014-07-15 08:57:44");
INSERT INTO invoice_product_list_audit VALUES("41","13","PD - USD","5","1000","10.00","0.00","3","7.00","2014-07-15 08:57:44");
INSERT INTO invoice_product_list_audit VALUES("42","14","HMP - USD","10","100","50.00","0.00","3","7.00","2014-07-15 08:58:53");
INSERT INTO invoice_product_list_audit VALUES("43","14","PD - USD","5","1000","10.00","0.00","3","7.00","2014-07-15 08:58:53");
INSERT INTO invoice_product_list_audit VALUES("44","15","HMP - USD","10","100","50.00","0.00","3","7.00","2014-07-15 09:00:22");
INSERT INTO invoice_product_list_audit VALUES("45","15","PD - USD","5","1000","10.00","0.00","3","7.00","2014-07-15 09:00:22");
INSERT INTO invoice_product_list_audit VALUES("46","16","HMP - USD","10","100","50.00","0.00","3","7.00","2014-07-15 09:03:02");
INSERT INTO invoice_product_list_audit VALUES("47","16","PD - USD","5","1000","10.00","0.00","3","7.00","2014-07-15 09:03:02");
INSERT INTO invoice_product_list_audit VALUES("48","17","HMP - USD","10","100","50.00","0.00","3","7.00","2014-07-15 09:03:35");
INSERT INTO invoice_product_list_audit VALUES("49","17","PD - USD","5","1000","10.00","0.00","3","7.00","2014-07-15 09:03:35");
INSERT INTO invoice_product_list_audit VALUES("50","18","HMP - USD","10","100","50.00","0.00","3","7.00","2014-07-15 09:26:31");
INSERT INTO invoice_product_list_audit VALUES("51","18","PD - USD","5","1000","10.00","0.00","3","7.00","2014-07-15 09:26:31");
INSERT INTO invoice_product_list_audit VALUES("52","19","HMP - USD","10","100","50.00","0.00","3","7.00","2014-07-15 09:29:22");
INSERT INTO invoice_product_list_audit VALUES("53","19","PD - USD","5","1000","10.00","0.00","3","7.00","2014-07-15 09:29:22");
INSERT INTO invoice_product_list_audit VALUES("54","20","R - 113B","11","1","2500.00","0.00","3","7.00","2014-07-15 13:27:54");
INSERT INTO invoice_product_list_audit VALUES("55","21","R - 113B","11","1","2500.00","0.00","3","7.00","2014-07-15 13:28:27");





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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO journal_entries VALUES("1","78","JEN-0000000001","2014-04-30"," 	Payroll - Apr 2014","","0","1","1","2014-07-15 07:58:10","2014-07-15 08:45:05");
INSERT INTO journal_entries VALUES("2","78","JEN-0000000002","2014-04-25","Fund Transfer","","0","1","1","2014-07-15 08:02:06","0000-00-00 00:00:00");
INSERT INTO journal_entries VALUES("3","78","JEN-0000000003","2014-06-30","Depreciation for the Qtr","","0","1","1","2014-07-15 08:03:17","2014-07-15 08:19:31");





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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO journal_entries_audit VALUES("1","1","2014-04-30"," 	Payroll - Apr 2014","","0","1","1","2014-07-15 07:58:10");
INSERT INTO journal_entries_audit VALUES("2","2","2014-04-25","Fund Transfer","","0","1","1","2014-07-15 08:02:06");
INSERT INTO journal_entries_audit VALUES("3","3","2014-06-30","Depreciation for the Qtr","","0","1","1","2014-07-15 08:03:17");
INSERT INTO journal_entries_audit VALUES("4","3","2014-06-30","Depreciation for the Qtr","","0","1","1","2014-07-15 08:19:31");
INSERT INTO journal_entries_audit VALUES("5","1","2014-04-30"," 	Payroll - Apr 2014","","0","1","1","2014-07-15 08:45:05");





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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO journal_entries_list VALUES("1","1","55"," 	Payroll - Apr 2014","10000.00","0.00","0000-00-00","2014-07-15 07:58:10","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("2","1","56"," 	Payroll - Apr 2014","1500.00","0.00","0000-00-00","2014-07-15 07:58:10","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("3","1","57"," 	Payroll - Apr 2014","1000.00","0.00","0000-00-00","2014-07-15 07:58:10","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("4","1","58"," 	Payroll - Apr 2014","800.00","0.00","0000-00-00","2014-07-15 07:58:10","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("5","1","59"," 	Payroll - Apr 2014","11.25","0.00","0000-00-00","2014-07-15 07:58:10","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("6","1","22"," 	Payroll - Apr 2014","0.00","1000.00","0000-00-00","2014-07-15 07:58:10","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("7","1","29"," 	Payroll - Apr 2014","0.00","1811.25","0000-00-00","2014-07-15 07:58:10","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("8","1","30"," 	Payroll - Apr 2014","0.00","10500.00","0000-00-00","2014-07-15 07:58:10","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("9","2","14","Fund Transfer","1400.00","0.00","0000-00-00","2014-07-15 08:02:06","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("10","2","17","Fund Transfer","0.00","1400.00","2014-04-27","2014-07-15 08:02:06","2014-07-15 14:01:11");
INSERT INTO journal_entries_list VALUES("11","3","65","Depreciation for the Qtr","1350.00","0.00","0000-00-00","2014-07-15 08:03:17","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("12","3","24","Depreciation for the Qtr","0.00","1350.00","0000-00-00","2014-07-15 08:03:17","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

INSERT INTO journal_entries_list_audit VALUES("1","1","55"," 	Payroll - Apr 2014","10000.00","0.00","0000-00-00","2014-07-15 07:58:10");
INSERT INTO journal_entries_list_audit VALUES("2","1","56"," 	Payroll - Apr 2014","1500.00","0.00","0000-00-00","2014-07-15 07:58:10");
INSERT INTO journal_entries_list_audit VALUES("3","1","57"," 	Payroll - Apr 2014","1000.00","0.00","0000-00-00","2014-07-15 07:58:10");
INSERT INTO journal_entries_list_audit VALUES("4","1","58"," 	Payroll - Apr 2014","800.00","0.00","0000-00-00","2014-07-15 07:58:10");
INSERT INTO journal_entries_list_audit VALUES("5","1","59"," 	Payroll - Apr 2014","11.25","0.00","0000-00-00","2014-07-15 07:58:10");
INSERT INTO journal_entries_list_audit VALUES("6","1","22"," 	Payroll - Apr 2014","0.00","1000.00","0000-00-00","2014-07-15 07:58:10");
INSERT INTO journal_entries_list_audit VALUES("7","1","58"," 	Payroll - Apr 2014","0.00","1811.25","0000-00-00","2014-07-15 07:58:10");
INSERT INTO journal_entries_list_audit VALUES("8","1","30"," 	Payroll - Apr 2014","0.00","10500.00","0000-00-00","2014-07-15 07:58:10");
INSERT INTO journal_entries_list_audit VALUES("9","2","14","Fund Transfer","1400.00","0.00","0000-00-00","2014-07-15 08:02:06");
INSERT INTO journal_entries_list_audit VALUES("10","2","17","Fund Transfer","0.00","1400.00","0000-00-00","2014-07-15 08:02:06");
INSERT INTO journal_entries_list_audit VALUES("11","3","65","Depreciation for the Qtr","1750.00","0.00","0000-00-00","2014-07-15 08:03:17");
INSERT INTO journal_entries_list_audit VALUES("12","3","24","Depreciation for the Qtr","0.00","1750.00","0000-00-00","2014-07-15 08:03:17");
INSERT INTO journal_entries_list_audit VALUES("13","4","24","Depreciation for the Qtr","0.00","1350.00","0000-00-00","2014-07-15 08:19:31");
INSERT INTO journal_entries_list_audit VALUES("14","4","65","Depreciation for the Qtr","1350.00","0.00","0000-00-00","2014-07-15 08:19:31");
INSERT INTO journal_entries_list_audit VALUES("15","5","55"," 	Payroll - Apr 2014","10000.00","0.00","0000-00-00","2014-07-15 08:45:05");
INSERT INTO journal_entries_list_audit VALUES("16","5","56"," 	Payroll - Apr 2014","1500.00","0.00","0000-00-00","2014-07-15 08:45:05");
INSERT INTO journal_entries_list_audit VALUES("17","5","57"," 	Payroll - Apr 2014","1000.00","0.00","0000-00-00","2014-07-15 08:45:05");
INSERT INTO journal_entries_list_audit VALUES("18","5","58"," 	Payroll - Apr 2014","800.00","0.00","0000-00-00","2014-07-15 08:45:05");
INSERT INTO journal_entries_list_audit VALUES("19","5","59"," 	Payroll - Apr 2014","11.25","0.00","0000-00-00","2014-07-15 08:45:05");
INSERT INTO journal_entries_list_audit VALUES("20","5","22"," 	Payroll - Apr 2014","0.00","1000.00","0000-00-00","2014-07-15 08:45:05");
INSERT INTO journal_entries_list_audit VALUES("21","5","29"," 	Payroll - Apr 2014","0.00","1811.25","0000-00-00","2014-07-15 08:45:05");
INSERT INTO journal_entries_list_audit VALUES("22","5","30"," 	Payroll - Apr 2014","0.00","10500.00","0000-00-00","2014-07-15 08:45:05");





CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification` tinyint(2) NOT NULL COMMENT '1 - On, 2 - Off',
  `email_setting` tinyint(2) NOT NULL COMMENT '1 - Immediate, 2 - Off',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO notifications VALUES("1","1","2","2014-07-15 04:11:48","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

INSERT INTO payments VALUES("2","2","0.00","","1","2014-07-15 05:29:08","2014-07-15 14:01:11","2","2014-05-25","2014-05-27","17","1050.00","1","");
INSERT INTO payments VALUES("3","2","0.00","","1","2014-07-15 05:34:21","2014-07-15 05:34:41","3","2014-05-31","0000-00-00","16","312.50","1","");
INSERT INTO payments VALUES("4","2","0.00","","2","2014-07-15 05:36:09","0000-00-00 00:00:00","17","2014-04-14","0000-00-00","14","530.80","3","");
INSERT INTO payments VALUES("5","2","0.00","","2","2014-07-15 05:37:22","0000-00-00 00:00:00","1","2014-05-14","0000-00-00","14","1065.80","3","");
INSERT INTO payments VALUES("6","2","0.00","","3","2014-07-15 08:52:54","2014-07-15 13:27:51","5","2014-05-02","0000-00-00","15","2675.00","2","");
INSERT INTO payments VALUES("7","2","0.00","","3","2014-07-15 08:53:46","2014-07-15 13:28:24","1","2014-04-02","0000-00-00","15","2675.00","2","");
INSERT INTO payments VALUES("8","2","0.00","","3","2014-07-15 08:55:03","0000-00-00 00:00:00","2","2014-04-30","0000-00-00","15","23000.00","2","");
INSERT INTO payments VALUES("9","2","0.00","","3","2014-07-15 08:55:40","0000-00-00 00:00:00","4","2014-06-01","0000-00-00","15","13910.00","2","");
INSERT INTO payments VALUES("10","1","422.85","","3","2014-07-15 08:56:21","0000-00-00 00:00:00","7","2014-06-01","0000-00-00","15","48000.00","1","");
INSERT INTO payments VALUES("11","2","0.00","","2","2014-07-15 09:06:37","2014-07-15 14:01:11","9","2014-04-30","2014-05-05","17","14994.98","2","");
INSERT INTO payments VALUES("12","2","0.00","","2","2014-07-15 09:06:56","2014-07-15 14:01:11","15","2014-05-31","2014-06-08","17","16050.00","2","");
INSERT INTO payments VALUES("13","2","0.00","","2","2014-07-15 09:07:36","0000-00-00 00:00:00","3","2014-04-27","0000-00-00","15","5868.95","2","");
INSERT INTO payments VALUES("14","1","478.00","","2","2014-07-15 09:09:48","2014-07-15 14:01:11","10","2014-05-27","2014-06-01","17","16000.00","2","");
INSERT INTO payments VALUES("15","2","0.00","","2","2014-07-15 09:10:19","0000-00-00 00:00:00","4","2014-04-27","0000-00-00","15","21400.00","2","");
INSERT INTO payments VALUES("16","2","0.00","","2","2014-07-15 09:10:38","2014-07-15 14:01:11","11","2014-05-27","2014-06-02","17","20000.00","2","");
INSERT INTO payments VALUES("17","2","0.00","","2","2014-07-15 09:12:24","2014-07-15 14:01:11","8","2014-04-15","0000-00-00","17","2500.00","2","");
INSERT INTO payments VALUES("18","1","160.50","","2","2014-07-15 09:15:00","2014-07-15 14:01:11","12","2014-05-25","2014-05-27","17","10539.50","2","");
INSERT INTO payments VALUES("19","2","0.00","","2","2014-07-15 09:16:08","2014-07-15 14:01:11","6","2014-05-25","2014-05-27","17","5082.50","2","");
INSERT INTO payments VALUES("20","2","0.00","","2","2014-07-15 09:16:25","2014-07-15 14:01:11","13","2014-05-25","2014-07-01","17","5350.00","2","");
INSERT INTO payments VALUES("21","2","0.00","","2","2014-07-15 09:17:52","2014-07-15 14:01:11","14","2014-05-01","2014-05-02","17","2140.00","1","");
INSERT INTO payments VALUES("22","2","0.00","","2","2014-07-15 09:19:12","2014-07-15 14:01:11","7","2014-04-01","2014-04-01","17","2140.00","1","");
INSERT INTO payments VALUES("23","2","0.00","","2","2014-07-15 09:20:08","2014-07-15 09:21:37","2","2014-05-25","0000-00-00","15","1300.00","1","");
INSERT INTO payments VALUES("24","2","0.00","","2","2014-07-15 09:22:33","2014-07-15 14:01:11","16","2014-05-31","2014-06-01","17","18200.00","1","");
INSERT INTO payments VALUES("26","2","0.00","","3","2014-07-15 10:51:17","2014-07-15 14:01:11","9","2014-05-12","2014-05-13","17","20060.00","1","");
INSERT INTO payments VALUES("27","2","0.00","","3","2014-07-15 10:54:57","2014-07-15 14:01:11","8","2014-06-30","2014-07-02","17","47300.00","1","");
INSERT INTO payments VALUES("28","1","107.00","","2","2014-07-15 10:58:55","2014-07-15 14:01:11","5","2014-04-25","2014-04-27","17","10593.00","2","");
INSERT INTO payments VALUES("29","2","0.00","","1","2014-07-15 11:03:21","2014-07-15 14:01:11","1","2014-04-25","2014-04-27","17","1050.00","1","");





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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

INSERT INTO payments_audit VALUES("1","2","0.00","","1","2014-07-15 05:32:37","1","2014-04-25","0000-00-00","17","1050.00","1","");
INSERT INTO payments_audit VALUES("2","2","0.00","","1","2014-07-15 05:33:04","2","2014-05-25","0000-00-00","17","1050.00","1","");
INSERT INTO payments_audit VALUES("3","2","0.00","","1","2014-07-15 05:34:41","3","2014-05-31","0000-00-00","16","312.50","1","");
INSERT INTO payments_audit VALUES("4","2","0.00","","3","2014-07-15 08:52:54","5","2014-04-02","0000-00-00","15","2675.00","2","");
INSERT INTO payments_audit VALUES("5","2","0.00","","3","2014-07-15 08:53:46","1","2014-05-02","0000-00-00","15","2675.00","2","");
INSERT INTO payments_audit VALUES("6","2","0.00","","3","2014-07-15 08:55:03","2","2014-04-30","0000-00-00","15","23000.00","2","");
INSERT INTO payments_audit VALUES("7","2","0.00","","3","2014-07-15 08:55:40","4","2014-06-01","0000-00-00","15","13910.00","2","");
INSERT INTO payments_audit VALUES("8","1","422.85","","3","2014-07-15 08:56:21","7","2014-06-01","0000-00-00","15","48000.00","1","");
INSERT INTO payments_audit VALUES("9","2","0.00","","2","2014-07-15 09:06:37","9","2014-04-30","0000-00-00","17","14994.98","2","");
INSERT INTO payments_audit VALUES("10","2","0.00","","2","2014-07-15 09:06:56","15","2014-05-31","0000-00-00","17","16050.00","2","");
INSERT INTO payments_audit VALUES("11","2","0.00","","2","2014-07-15 09:07:36","3","2014-04-27","0000-00-00","15","5868.95","2","");
INSERT INTO payments_audit VALUES("12","1","478.00","","2","2014-07-15 09:09:48","10","2014-05-27","0000-00-00","17","16000.00","2","");
INSERT INTO payments_audit VALUES("13","2","0.00","","2","2014-07-15 09:10:19","4","2014-04-27","0000-00-00","15","21400.00","2","");
INSERT INTO payments_audit VALUES("14","2","0.00","","2","2014-07-15 09:10:38","11","2014-05-27","0000-00-00","17","20000.00","2","");
INSERT INTO payments_audit VALUES("15","1","160.50","","2","2014-07-15 09:15:00","12","2014-05-25","0000-00-00","17","10539.50","2","");
INSERT INTO payments_audit VALUES("16","2","0.00","","2","2014-07-15 09:16:08","6","2014-05-25","0000-00-00","17","5082.50","2","");
INSERT INTO payments_audit VALUES("17","2","0.00","","2","2014-07-15 09:16:25","13","2014-05-25","0000-00-00","17","5350.00","2","");
INSERT INTO payments_audit VALUES("18","2","0.00","","2","2014-07-15 09:19:12","7","2014-04-01","0000-00-00","17","2140.00","1","");
INSERT INTO payments_audit VALUES("19","2","0.00","","2","2014-07-15 09:20:08","2","1970-01-01","0000-00-00","15","1300.00","1","");
INSERT INTO payments_audit VALUES("20","2","0.00","","2","2014-07-15 09:21:12","2","2014-05-25","0000-00-00","13","1300.00","1","");
INSERT INTO payments_audit VALUES("21","2","0.00","","2","2014-07-15 09:21:25","2","2014-05-25","0000-00-00","15","1300.00","1","");
INSERT INTO payments_audit VALUES("22","2","0.00","","2","2014-07-15 09:21:37","2","2014-05-25","0000-00-00","15","1300.00","1","");
INSERT INTO payments_audit VALUES("23","2","0.00","","2","2014-07-15 09:22:33","16","2014-05-31","0000-00-00","17","18200.00","1","");
INSERT INTO payments_audit VALUES("24","2","0.00","","3","2014-07-15 10:51:17","9","2014-05-12","0000-00-00","17","20060.00","1","");
INSERT INTO payments_audit VALUES("25","2","0.00","","3","2014-07-15 10:54:57","8","2014-06-30","0000-00-00","17","47300.00","1","");
INSERT INTO payments_audit VALUES("26","1","107.00","","2","2014-07-15 10:58:55","5","2014-04-25","0000-00-00","17","10593.00","2","");
INSERT INTO payments_audit VALUES("27","2","0.00","","1","2014-07-15 11:03:21","1","2014-04-25","0000-00-00","17","1050.00","1","");
INSERT INTO payments_audit VALUES("28","2","0.00","","3","2014-07-15 13:27:51","5","2014-05-02","0000-00-00","15","2675.00","2","");
INSERT INTO payments_audit VALUES("29","2","0.00","","3","2014-07-15 13:28:24","1","2014-04-02","0000-00-00","15","2675.00","2","");





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

INSERT INTO products VALUES("1","Pizza 12\"","78","P12","Pizza 12\"","35.00","SGD","34","2014-07-15 04:53:34","0000-00-00 00:00:00");
INSERT INTO products VALUES("2","Pizza 8\"","78","P8","Pizza 8\"","25.00","SGD","34","2014-07-15 04:53:34","0000-00-00 00:00:00");
INSERT INTO products VALUES("3","Pasta 01","78","PA01","Pasta 01","20.00","SGD","34","2014-07-15 04:53:34","0000-00-00 00:00:00");
INSERT INTO products VALUES("4","Pasta 02","78","PA02","Pasta 02","30.00","SGD","34","2014-07-15 04:53:34","0000-00-00 00:00:00");
INSERT INTO products VALUES("5","Pizza Dong","78","PD - USD","Pizza Dong","10.00","USD","36","2014-07-15 04:53:34","0000-00-00 00:00:00");
INSERT INTO products VALUES("6","Service Charge - $100","78","SC100","Service Charge - $100","100.00","SGD","37","2014-07-15 04:53:34","0000-00-00 00:00:00");
INSERT INTO products VALUES("7","Service Charge - $50","78","SC50","Service Charge - $50","50.00","SGD","37","2014-07-15 04:53:34","0000-00-00 00:00:00");
INSERT INTO products VALUES("8","Whisky","78","Whisky","Whisky","12.00","SGD","35","2014-07-15 04:53:34","0000-00-00 00:00:00");
INSERT INTO products VALUES("9","Wine","78","Wine","Wine","10.00","SGD","35","2014-07-15 04:53:34","0000-00-00 00:00:00");
INSERT INTO products VALUES("10","Home Made Pasta","78","HMP - USD","Home Made Pasta","50.00","USD","36","2014-07-15 04:53:34","0000-00-00 00:00:00");
INSERT INTO products VALUES("11","Rent - 113B","78","R - 113B","Rent - 113B","2500.00","SGD","66","2014-07-15 04:53:34","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO taxcodes VALUES("1","78","15","0.00","Regulation 33 Exempt supplies","2","1","2014-07-15 04:15:46","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("2","78","12","7.00","Imports where the GST is suspended until the filing date of the GST return","1","1","2014-07-15 04:16:08","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("3","78","13","7.00","Standard-rated supplies with GST charged","2","1","2014-07-15 04:16:38","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("4","78","23","7.00","Purchases with GST incurred at 7% and directly attributable to taxable supplies","1","1","2014-07-15 04:17:00","0000-00-00 00:00:00");





CREATE TABLE `theme_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `default_theme` tinyint(2) NOT NULL COMMENT '1 - Default, 2 - Not Default',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO theme_setting VALUES("1","Red","Basic Theme","2","2014-07-15 04:17:33");
INSERT INTO theme_setting VALUES("2","Black","Black Theme","2","2014-07-15 04:11:48");
INSERT INTO theme_setting VALUES("3","Blue","Blue Theme","1","2014-07-15 04:17:33");





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

INSERT INTO vendors VALUES("1","78","VEN-0000000001","Natrad Foods","16 Sandilands Road","","201301587A-PTE-01","69453481","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-15 04:53:44","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("2","78","VEN-0000000002","FoodXervices","16 Sandilands Road","","201301587A-PTE-06","69453482","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-15 04:53:44","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("3","78","VEN-0000000003","APB","16 Sandilands Road","","201301587A-PTE-02","69453483","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-15 04:53:44","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("4","78","VEN-0000000004","Magnum Wines","16 Sandilands Road","","201301587A-PTE-03","69453484","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-15 04:53:44","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("5","78","VEN-0000000005","AA Corporation - Vietnam","16 Sandilands Road","","201301587A-PTE-04","69453485","","Ho Chi Minh","Saigon","VN","","","","546080","0000-00-00","1","6","","2014-07-15 04:53:44","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("6","78","VEN-0000000006","Bakers & Chef - Italy","16 Sandilands Road","","201301587A-PTE-15","69453485","","Italy","Italy","IT","","","","546080","0000-00-00","1","6","","2014-07-15 04:53:44","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("7","78","VEN-0000000007","MCST 835","16 Sandilands Road","","201301587A-PTE-18","69453482","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","32","","2014-07-15 04:53:44","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("8","78","VEN-0000000008","ID Ranger","16 Sandilands Road","","201301587A-PTE-19","69453483","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","6","","2014-07-15 04:53:44","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("9","78","VEN-0000000009","Evergreen Cleaning Services","16 Sandilands Road","","201301587A-PTE-20","69453484","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","6","","2014-07-15 04:53:44","0000-00-00 00:00:00");



