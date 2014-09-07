

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

INSERT INTO account VALUES("1","2","1","0","Unrealised Foreign Exchange Gain / (Loss)","","0.00","0.00","0","2","1","2014-07-12 20:09:35","2014-07-12 22:53:57");
INSERT INTO account VALUES("2","4","3","0","Foreign Exchange Gain/(Loss)","","0.00","0.00","0","2","1","2014-07-12 20:09:35","2014-07-12 22:53:57");
INSERT INTO account VALUES("3","1","1","4","Trade Receivables","","0.00","0.00","0","2","1","2014-07-12 20:09:35","2014-07-12 22:53:57");
INSERT INTO account VALUES("4","1","1","5","Account Receivables - Others","","0.00","0.00","0","2","1","2014-07-12 20:09:35","2014-07-12 22:53:57");
INSERT INTO account VALUES("5","2","1","3","Trade Creditors","","0.00","0.00","0","2","1","2014-07-12 20:09:35","2014-07-12 22:53:57");
INSERT INTO account VALUES("6","2","1","8","Account Payables - Others","","0.00","0.00","0","2","1","2014-07-12 20:09:35","2014-07-12 22:53:57");
INSERT INTO account VALUES("7","3","1","0","Discounts Given","","0.00","0.00","0","2","1","2014-07-12 20:09:35","2014-07-12 22:53:57");
INSERT INTO account VALUES("8","4","1","0","Discounts Received","","0.00","0.00","0","2","1","2014-07-12 20:09:35","2014-07-12 22:53:57");
INSERT INTO account VALUES("9","5","4","1","Retained Earnings","","0.00","150000.00","0","2","1","2014-07-12 20:09:35","2014-07-12 22:53:57");
INSERT INTO account VALUES("10","5","4","1","Current Year Earnings","","0.00","0.00","0","2","1","2014-07-12 20:09:35","2014-07-12 22:53:57");
INSERT INTO account VALUES("11","2","1","4","Sales Tax Payables","","0.00","0.00","0","2","1","2014-07-12 20:09:35","2014-07-12 22:53:57");
INSERT INTO account VALUES("12","4","3","8","Income Tax","","0.00","0.00","0","2","1","2014-07-12 20:09:35","2014-07-12 22:53:57");
INSERT INTO account VALUES("13","1","1","1","Cash in Hand","SGD","2500.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("14","1","1","1","Petty Cash","SGD","2000.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("15","1","1","1","UOB Bank","SGD","60000.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("16","1","1","1","Fixed Deposits","SGD","200000.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("17","1","1","1","OCBC Bank","SGD","105000.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("18","1","1","3","Inventory","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("19","1","1","6","Rental Deposit","SGD","60000.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("20","1","1","6","Security Deposit","SGD","500.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("21","1","1","5","Interest Receivbales","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("22","1","1","5","Staff Loan","SGD","12000.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("23","1","2","3","Machinery","SGD","10000.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("24","1","2","3","Acc. Depn - Machinery","SGD","0.00","2000.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("25","1","2","3","F & F","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("26","1","2","3","Acc. Depn - F & F","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("27","1","2","3","Computers","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("28","1","2","3","Acc. Depn - Computers","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("29","2","1","8","CPF Board Payable","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("30","2","1","8","Staff Payables","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("31","5","1","1","Capital Account","SGD","0.00","300000.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("32","2","1","8","Rent Payable","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("33","1","1","5","Rent Receivable","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("34","3","1","7","Sales - Food","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("35","3","1","7","Sales - B/V","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("36","3","1","7","Sales - Misc","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("37","3","1","7","Service Charge","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("38","3","1","8","Misc. Rcpts.","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("39","3","2","1","Admin Fees Income","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("40","3","2","2","Interest Income - Fixed Deposits","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("41","3","2","4","Other Non Operating Income","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("42","3","3","1","Government Grants - PIC","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("43","3","3","1","Government Grants - SEC","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("44","4","1","1","Opening Stock","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("45","4","1","1","Purchases - Food","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("46","4","1","1","Purchases - B/V","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("47","4","1","1","Purchases - Misc.","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("48","4","1","1","Closing Stock","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("49","4","2","6","Advertising & Promotion","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("50","4","2","9","Shop Maintance","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("51","4","2","9","Kitchen Maintance","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("52","4","2","9","Kitchen Equipment Maintenance","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("53","4","2","9","Cleaing Items","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("54","4","2","9","Cleaing Contractor","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("55","4","2","11","Salary & Wages","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("56","4","2","11","Overtime","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("57","4","2","11","Sales Promotion","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("58","4","2","11","CPF","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("59","4","2","11","SDL","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("60","4","2","11","Staff Welfare","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("61","4","2","11","Staff medical Expenses","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("62","4","2","17","Electricity / Water / Gas","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("63","1","2","5","Renovation in Progress","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("64","4","2","8","Warehouse Rental","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("65","4","3","1","Depreciation","SGD","0.00","0.00","2","1","1","2014-07-12 20:13:16","2014-07-12 22:53:57");
INSERT INTO account VALUES("66","3","1","8","Rental Income","SGD","0.00","0.00","2","1","1","2014-07-12 20:30:29","2014-07-12 22:53:57");





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
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;

INSERT INTO accounting_entries VALUES("1","9","1","235.40","2014-04-24","3","1","1","2014-07-12 20:45:08","2014-07-12 23:46:38");
INSERT INTO accounting_entries VALUES("2","9","5","220.00","2014-04-24","3","2","1","2014-07-12 20:45:08","2014-07-12 23:46:38");
INSERT INTO accounting_entries VALUES("3","9","4","15.40","2014-04-24","3","2","1","2014-07-12 20:45:08","2014-07-12 23:46:38");
INSERT INTO accounting_entries VALUES("4","1","1","161.57","2014-04-27","4","2","1","2014-07-12 20:47:03","2014-07-12 23:45:26");
INSERT INTO accounting_entries VALUES("5","1","5","151.00","2014-04-27","4","1","1","2014-07-12 20:47:03","2014-07-12 23:45:26");
INSERT INTO accounting_entries VALUES("6","1","4","10.57","2014-04-27","4","1","1","2014-07-12 20:47:03","2014-07-12 23:45:26");
INSERT INTO accounting_entries VALUES("7","9","3","88.25","2014-04-24","3","1","1","2014-07-12 20:54:29","2014-07-12 23:46:38");
INSERT INTO accounting_entries VALUES("8","18","2","10000.00","2014-06-10","2","2","1","2014-07-12 21:14:57","2014-07-13 06:26:05");
INSERT INTO accounting_entries VALUES("9","18","3","12470.00","2014-06-10","2","2","1","2014-07-12 21:16:03","2014-07-13 06:26:05");
INSERT INTO accounting_entries VALUES("10","2","1","442.98","2014-05-05","4","2","1","2014-07-12 21:23:38","2014-07-12 21:23:58");
INSERT INTO accounting_entries VALUES("11","2","5","414.00","2014-05-05","4","1","1","2014-07-12 21:23:38","2014-07-12 21:23:58");
INSERT INTO accounting_entries VALUES("12","2","4","28.98","2014-05-05","4","1","1","2014-07-12 21:23:38","2014-07-12 21:23:58");
INSERT INTO accounting_entries VALUES("13","3","1","1867.15","2014-05-15","4","2","1","2014-07-12 21:25:32","2014-07-12 21:38:24");
INSERT INTO accounting_entries VALUES("14","3","5","1745.00","2014-05-15","4","1","1","2014-07-12 21:25:32","2014-07-12 21:38:24");
INSERT INTO accounting_entries VALUES("15","3","4","122.15","2014-05-15","4","1","1","2014-07-12 21:25:32","2014-07-12 21:38:24");
INSERT INTO accounting_entries VALUES("16","4","1","5885.00","2014-05-15","4","2","2","2014-07-12 21:26:32","2014-07-12 21:26:42");
INSERT INTO accounting_entries VALUES("17","4","5","5500.00","2014-05-15","4","1","2","2014-07-12 21:26:32","2014-07-12 21:26:42");
INSERT INTO accounting_entries VALUES("18","4","4","385.00","2014-05-15","4","1","2","2014-07-12 21:26:32","2014-07-12 21:26:42");
INSERT INTO accounting_entries VALUES("19","5","1","43870.00","2014-05-15","3","1","1","2014-07-12 21:27:44","2014-07-12 23:46:12");
INSERT INTO accounting_entries VALUES("20","5","5","41000.00","2014-05-15","3","2","1","2014-07-12 21:27:44","2014-07-12 23:46:12");
INSERT INTO accounting_entries VALUES("21","5","4","2870.00","2014-05-15","3","2","1","2014-07-12 21:27:44","2014-07-12 23:46:12");
INSERT INTO accounting_entries VALUES("22","1","1","16050.00","2014-04-15","3","1","1","2014-07-12 21:28:46","2014-07-12 21:58:43");
INSERT INTO accounting_entries VALUES("23","1","5","15000.00","2014-04-15","3","2","1","2014-07-12 21:28:46","2014-07-12 21:58:43");
INSERT INTO accounting_entries VALUES("24","1","4","1050.00","2014-04-15","3","2","1","2014-07-12 21:28:46","2014-07-12 21:58:43");
INSERT INTO accounting_entries VALUES("25","5","1","5885.00","2014-05-15","4","2","1","2014-07-12 21:33:11","2014-07-12 23:45:21");
INSERT INTO accounting_entries VALUES("26","5","5","5500.00","2014-05-15","4","1","1","2014-07-12 21:33:11","2014-07-12 23:45:21");
INSERT INTO accounting_entries VALUES("27","5","4","385.00","2014-05-15","4","1","1","2014-07-12 21:33:11","2014-07-12 23:45:21");
INSERT INTO accounting_entries VALUES("28","6","1","909.50","2014-04-15","4","2","1","2014-07-12 21:34:42","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("29","6","5","850.00","2014-04-15","4","1","1","2014-07-12 21:34:42","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("30","6","4","59.50","2014-04-15","4","1","1","2014-07-12 21:34:42","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("31","4","1","50097.40","2014-05-15","3","1","1","2014-07-12 21:36:21","2014-07-12 22:04:19");
INSERT INTO accounting_entries VALUES("32","4","5","46820.00","2014-05-15","3","2","1","2014-07-12 21:36:21","2014-07-12 22:04:19");
INSERT INTO accounting_entries VALUES("33","4","4","3277.40","2014-05-15","3","2","1","2014-07-12 21:36:21","2014-07-12 22:04:19");
INSERT INTO accounting_entries VALUES("34","2","1","2675.00","2014-05-25","1","1","1","2014-07-12 21:40:09","2014-07-12 22:10:08");
INSERT INTO accounting_entries VALUES("35","2","5","2500.00","2014-05-25","1","2","1","2014-07-12 21:40:09","2014-07-12 22:10:08");
INSERT INTO accounting_entries VALUES("36","2","4","175.00","2014-05-25","1","2","1","2014-07-12 21:40:09","2014-07-12 22:10:08");
INSERT INTO accounting_entries VALUES("37","9","2","14994.98","2014-04-30","2","2","1","2014-07-12 21:41:40","2014-07-12 22:27:18");
INSERT INTO accounting_entries VALUES("38","5","3","47300.00","2014-05-15","3","1","1","2014-07-12 21:57:58","2014-07-12 23:46:12");
INSERT INTO accounting_entries VALUES("39","1","3","20060.00","2014-04-15","3","1","1","2014-07-12 21:58:43","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("40","2","3","13910.00","2014-04-30","3","1","1","2014-07-12 22:00:14","2014-07-12 22:07:24");
INSERT INTO accounting_entries VALUES("41","2","1","13910.00","2014-04-30","3","1","1","2014-07-12 22:00:14","2014-07-12 22:07:24");
INSERT INTO accounting_entries VALUES("42","2","5","13000.00","2014-04-30","3","2","1","2014-07-12 22:00:14","2014-07-12 22:07:24");
INSERT INTO accounting_entries VALUES("43","2","4","910.00","2014-04-30","3","2","1","2014-07-12 22:00:14","2014-07-12 22:07:24");
INSERT INTO accounting_entries VALUES("44","4","3","48000.00","2014-05-15","3","1","1","2014-07-12 22:04:19","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("45","8","3","2675.00","2014-04-01","3","1","1","2014-07-12 22:05:15","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("46","8","1","2675.00","2014-04-01","3","1","1","2014-07-12 22:05:15","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("47","8","5","2500.00","2014-04-01","3","2","1","2014-07-12 22:05:15","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("48","8","4","175.00","2014-04-01","3","2","1","2014-07-12 22:05:15","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("49","7","3","2675.00","2014-05-01","3","1","1","2014-07-12 22:05:37","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("50","7","1","2675.00","2014-05-01","3","1","1","2014-07-12 22:05:37","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("51","7","5","2500.00","2014-05-01","3","2","1","2014-07-12 22:05:37","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("52","7","4","175.00","2014-05-01","3","2","1","2014-07-12 22:05:37","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("53","6","3","23000.00","2014-04-15","3","1","1","2014-07-12 22:07:11","2014-07-13 05:48:36");
INSERT INTO accounting_entries VALUES("54","6","1","24075.00","2014-04-15","3","1","1","2014-07-12 22:07:11","2014-07-13 05:48:36");
INSERT INTO accounting_entries VALUES("55","6","5","22500.00","2014-04-15","3","2","1","2014-07-12 22:07:11","2014-07-13 05:48:36");
INSERT INTO accounting_entries VALUES("56","6","4","1575.00","2014-04-15","3","2","1","2014-07-12 22:07:11","2014-07-13 05:48:36");
INSERT INTO accounting_entries VALUES("57","1","3","1050.00","2014-04-25","1","1","1","2014-07-12 22:08:41","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("58","1","1","2675.00","2014-04-25","1","1","1","2014-07-12 22:08:41","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("59","1","5","2500.00","2014-04-25","1","2","1","2014-07-12 22:08:41","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("60","1","4","175.00","2014-04-25","1","2","1","2014-07-12 22:08:41","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("61","2","3","1050.00","2014-05-25","1","1","1","2014-07-12 22:10:08","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("62","3","3","312.50","2014-05-31","1","1","1","2014-07-12 22:18:16","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("63","3","1","312.50","2014-05-31","1","1","1","2014-07-12 22:18:16","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("64","3","5","312.50","2014-05-31","1","2","1","2014-07-12 22:18:16","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("65","3","4","0.00","2014-05-31","1","2","1","2014-07-12 22:18:16","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("66","16","2","10000.00","2014-04-01","2","2","1","2014-07-12 22:19:59","2014-07-12 22:34:06");
INSERT INTO accounting_entries VALUES("67","2","2","1000.00","2014-04-01","2","2","1","2014-07-12 22:22:46","2014-07-12 22:25:39");
INSERT INTO accounting_entries VALUES("68","2","3","1300.00","2014-04-01","2","2","1","2014-07-12 22:25:39","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("69","15","3","16050.00","2014-05-31","2","2","1","2014-07-12 22:26:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("70","15","2","16050.00","2014-05-31","2","2","1","2014-07-12 22:26:40","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("71","9","3","14994.98","2014-04-30","2","2","1","2014-07-12 22:27:18","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("72","1","3","1065.80","2014-05-14","2","2","1","2014-07-12 22:28:07","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("73","1","2","1065.80","2014-05-14","2","2","1","2014-07-12 22:28:07","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("74","17","3","530.80","2014-04-14","2","2","1","2014-07-12 22:28:51","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("75","17","2","530.80","2014-04-14","2","2","1","2014-07-12 22:28:51","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("76","14","3","2140.00","2014-05-01","2","2","1","2014-07-12 22:29:33","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("77","14","2","2140.00","2014-05-01","2","2","1","2014-07-12 22:29:33","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("78","7","3","2140.00","2014-04-01","2","2","1","2014-07-12 22:29:58","2014-07-13 04:55:27");
INSERT INTO accounting_entries VALUES("79","7","2","2140.00","2014-04-01","2","2","1","2014-07-12 22:29:58","2014-07-13 04:55:27");
INSERT INTO accounting_entries VALUES("80","8","3","2500.00","2014-04-15","2","2","1","2014-07-12 22:30:36","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("81","8","2","2500.00","2014-04-15","2","2","1","2014-07-12 22:30:36","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("82","4","3","21400.00","2014-04-01","2","2","1","2014-07-12 22:32:34","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("83","4","2","21400.00","2014-04-01","2","2","1","2014-07-12 22:32:34","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("84","11","3","20000.00","2014-05-01","2","2","1","2014-07-12 22:33:10","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("85","11","2","42800.00","2014-05-01","2","2","1","2014-07-12 22:33:10","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("86","16","3","18220.00","2014-04-01","2","2","1","2014-07-12 22:34:06","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("87","13","3","5350.00","2014-05-01","2","2","1","2014-07-12 22:34:46","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("88","13","2","5350.00","2014-05-01","2","2","1","2014-07-12 22:34:46","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("89","6","3","5082.50","2014-04-01","2","2","1","2014-07-12 22:35:05","2014-07-12 23:22:10");
INSERT INTO accounting_entries VALUES("90","6","2","5350.00","2014-04-01","2","2","1","2014-07-12 22:35:05","2014-07-12 23:22:10");
INSERT INTO accounting_entries VALUES("91","3","3","5868.95","2014-04-01","2","2","1","2014-07-12 22:35:41","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("92","3","2","5868.95","2014-04-01","2","2","1","2014-07-12 22:35:41","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("93","10","3","16000.00","2014-05-01","2","2","1","2014-07-12 22:36:29","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("94","10","2","16478.00","2014-05-01","2","2","1","2014-07-12 22:36:29","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("95","5","3","10593.00","2014-04-01","2","2","1","2014-07-12 22:37:38","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("96","5","2","10700.00","2014-04-01","2","2","1","2014-07-12 22:37:38","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("97","12","3","10539.50","2014-05-01","2","2","1","2014-07-12 22:38:30","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("98","12","2","10700.00","2014-05-01","2","2","1","2014-07-12 22:38:30","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("99","3","1","4872.78","2014-05-05","3","1","1","2014-07-13 05:48:46","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("100","3","5","4554.00","2014-05-05","3","2","1","2014-07-13 05:48:46","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("101","3","4","318.78","2014-05-05","3","2","1","2014-07-13 05:48:46","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=311 DEFAULT CHARSET=latin1;

INSERT INTO audit_log VALUES("1","72","93","9","12","Logged In","2","2014-07-12 20:10:21");
INSERT INTO audit_log VALUES("2","72","93","1","8","Cash in Hand","13","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("3","72","93","1","8","Petty Cash","14","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("4","72","93","1","8","UOB Bank","15","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("5","72","93","1","8","Fixed Deposits","16","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("6","72","93","1","8","OCBC Bank","17","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("7","72","93","1","8","Inventory","18","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("8","72","93","1","8","Rental Deposit","19","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("9","72","93","1","8","Security Deposit","20","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("10","72","93","1","8","Interest Receivbales","21","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("11","72","93","1","8","Staff Loan","22","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("12","72","93","1","8","Machinery","23","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("13","72","93","1","8","Acc. Depn - Machinery","24","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("14","72","93","1","8","F & F","25","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("15","72","93","1","8","Acc. Depn - F & F","26","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("16","72","93","1","8","Computers","27","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("17","72","93","1","8","Acc. Depn - Computers","28","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("18","72","93","1","8","CPF Board Payable","29","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("19","72","93","1","8","Staff Payables","30","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("20","72","93","1","8","Capital Account","31","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("21","72","93","1","8","Rent Payable","32","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("22","72","93","1","8","Rent Receivable","33","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("23","72","93","1","8","Sales - Food","34","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("24","72","93","1","8","Sales - B/V","35","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("25","72","93","1","8","Sales - Misc","36","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("26","72","93","1","8","Service Charge","37","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("27","72","93","1","8","Misc. Rcpts.","38","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("28","72","93","1","8","Admin Fees Income","39","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("29","72","93","1","8","Interest Income - Fixed Deposits","40","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("30","72","93","1","8","Other Non Operating Income","41","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("31","72","93","1","8","Government Grants - PIC","42","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("32","72","93","1","8","Government Grants - SEC","43","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("33","72","93","1","8","Opening Stock","44","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("34","72","93","1","8","Purchases - Food","45","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("35","72","93","1","8","Purchases - B/V","46","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("36","72","93","1","8","Purchases - Misc.","47","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("37","72","93","1","8","Closing Stock","48","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("38","72","93","1","8","Advertising & Promotion","49","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("39","72","93","1","8","Shop Maintance","50","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("40","72","93","1","8","Kitchen Maintance","51","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("41","72","93","1","8","Kitchen Equipment Maintenance","52","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("42","72","93","1","8","Cleaing Items","53","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("43","72","93","1","8","Cleaing Contractor","54","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("44","72","93","1","8","Salary & Wages","55","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("45","72","93","1","8","Overtime","56","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("46","72","93","1","8","Sales Promotion","57","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("47","72","93","1","8","CPF","58","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("48","72","93","1","8","SDL","59","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("49","72","93","1","8","Staff Welfare","60","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("50","72","93","1","8","Staff medical Expenses","61","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("51","72","93","1","8","Electricity / Water / Gas","62","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("52","72","93","1","8","Renovation in Progress","63","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("53","72","93","1","8","Warehouse Rental","64","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("54","72","93","1","8","Depreciation","65","2014-07-12 20:13:16");
INSERT INTO audit_log VALUES("55","72","93","1","6","OPH","1","2014-07-12 20:14:31");
INSERT INTO audit_log VALUES("56","72","93","1","6","EZH & Qh","2","2014-07-12 20:14:31");
INSERT INTO audit_log VALUES("57","72","93","1","6","Dome - Dubai","3","2014-07-12 20:14:31");
INSERT INTO audit_log VALUES("58","72","93","1","6","Ciao Cafe - Vietnam","4","2014-07-12 20:14:31");
INSERT INTO audit_log VALUES("59","72","93","1","6","Melinium Sdn Bhd","5","2014-07-12 20:14:31");
INSERT INTO audit_log VALUES("60","72","93","1","6","Temasek LLC","6","2014-07-12 20:14:31");
INSERT INTO audit_log VALUES("61","72","93","1","6","Grean Ocean Pte Ltd","7","2014-07-12 20:14:31");
INSERT INTO audit_log VALUES("62","72","93","1","6","Indian Bank","8","2014-07-12 20:14:31");
INSERT INTO audit_log VALUES("63","72","93","1","6","Indian Overseas Bank","9","2014-07-12 20:14:31");
INSERT INTO audit_log VALUES("64","72","93","1","7","Natrad Foods","1","2014-07-12 20:15:17");
INSERT INTO audit_log VALUES("65","72","93","1","7","FoodXervices","2","2014-07-12 20:15:18");
INSERT INTO audit_log VALUES("66","72","93","1","7","APB","3","2014-07-12 20:15:18");
INSERT INTO audit_log VALUES("67","72","93","1","7","Magnum Wines","4","2014-07-12 20:15:18");
INSERT INTO audit_log VALUES("68","72","93","1","7","AA Corporation - Vietnam","5","2014-07-12 20:15:18");
INSERT INTO audit_log VALUES("69","72","93","1","7","Bakers & Chef - Italy","6","2014-07-12 20:15:18");
INSERT INTO audit_log VALUES("70","72","93","1","7","MCST 835","7","2014-07-12 20:15:18");
INSERT INTO audit_log VALUES("71","72","93","1","7","ID Ranger","8","2014-07-12 20:15:18");
INSERT INTO audit_log VALUES("72","72","93","1","7","Evergreen Cleaning Services","9","2014-07-12 20:15:18");
INSERT INTO audit_log VALUES("73","72","93","1","10","Pizza 12\"","1","2014-07-12 20:15:30");
INSERT INTO audit_log VALUES("74","72","93","1","10","Pizza 8\"","2","2014-07-12 20:15:30");
INSERT INTO audit_log VALUES("75","72","93","1","10","Pasta 01","3","2014-07-12 20:15:30");
INSERT INTO audit_log VALUES("76","72","93","1","10","Pasta 02","4","2014-07-12 20:15:30");
INSERT INTO audit_log VALUES("77","72","93","1","10","Pizza Dong","5","2014-07-12 20:15:30");
INSERT INTO audit_log VALUES("78","72","93","1","10","Service Charge - $100","6","2014-07-12 20:15:30");
INSERT INTO audit_log VALUES("79","72","93","1","10","Service Charge - $50","7","2014-07-12 20:15:30");
INSERT INTO audit_log VALUES("80","72","93","1","10","Whisky","8","2014-07-12 20:15:30");
INSERT INTO audit_log VALUES("81","72","93","1","10","Wine","9","2014-07-12 20:15:30");
INSERT INTO audit_log VALUES("82","72","93","1","10","Home Made Pasta","10","2014-07-12 20:15:30");
INSERT INTO audit_log VALUES("83","72","93","1","9","15","1","2014-07-12 20:16:07");
INSERT INTO audit_log VALUES("84","72","93","1","9","13","2","2014-07-12 20:16:18");
INSERT INTO audit_log VALUES("85","72","93","1","9","6","3","2014-07-12 20:16:32");
INSERT INTO audit_log VALUES("86","72","93","1","9","23","4","2014-07-12 20:16:47");
INSERT INTO audit_log VALUES("87","72","93","1","3","Invoice","1","2014-07-12 20:22:09");
INSERT INTO audit_log VALUES("88","72","93","1","3","Invoice","2","2014-07-12 20:22:09");
INSERT INTO audit_log VALUES("89","72","93","1","3","Invoice","3","2014-07-12 20:22:09");
INSERT INTO audit_log VALUES("90","72","93","1","3","Invoice","4","2014-07-12 20:22:09");
INSERT INTO audit_log VALUES("91","72","93","1","3","Invoice","5","2014-07-12 20:22:09");
INSERT INTO audit_log VALUES("92","72","93","1","3","Invoice","6","2014-07-12 20:22:22");
INSERT INTO audit_log VALUES("93","72","93","1","2","Expense","1","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("94","72","93","1","2","Expense","2","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("95","72","93","1","2","Expense","3","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("96","72","93","1","2","Expense","4","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("97","72","93","1","2","Expense","5","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("98","72","93","1","2","Expense","6","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("99","72","93","1","2","Expense","7","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("100","72","93","1","2","Expense","8","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("101","72","93","1","2","Expense","9","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("102","72","93","1","2","Expense","10","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("103","72","93","1","2","Expense","11","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("104","72","93","1","2","Expense","12","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("105","72","93","1","2","Expense","13","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("106","72","93","1","2","Expense","14","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("107","72","93","1","2","Expense","15","2014-07-12 20:22:44");
INSERT INTO audit_log VALUES("108","72","93","1","2","Expense","16","2014-07-12 20:22:53");
INSERT INTO audit_log VALUES("109","72","93","1","2","Expense","17","2014-07-12 20:22:53");
INSERT INTO audit_log VALUES("110","72","93","1","8","Rental Income","66","2014-07-12 20:30:29");
INSERT INTO audit_log VALUES("111","72","93","1","10","Rent - 113B","11","2014-07-12 20:32:31");
INSERT INTO audit_log VALUES("112","72","93","1","3","Invoice","7","2014-07-12 20:34:19");
INSERT INTO audit_log VALUES("113","72","93","1","3","Invoice","8","2014-07-12 20:34:31");
INSERT INTO audit_log VALUES("114","72","93","1","1","Income","1","2014-07-12 20:42:22");
INSERT INTO audit_log VALUES("115","72","93","1","1","Income","2","2014-07-12 20:42:28");
INSERT INTO audit_log VALUES("116","72","93","1","1","Income","3","2014-07-12 20:42:28");
INSERT INTO audit_log VALUES("117","72","93","1","3","Invoice","9","2014-07-12 20:45:08");
INSERT INTO audit_log VALUES("118","72","93","6","3","Invoice","9","2014-07-12 20:45:08");
INSERT INTO audit_log VALUES("119","72","93","1","4","Credit Note","1","2014-07-12 20:47:03");
INSERT INTO audit_log VALUES("120","72","93","6","4","Credit Note","1","2014-07-12 20:47:03");
INSERT INTO audit_log VALUES("121","72","93","1","11","Invoice","9","2014-07-12 20:54:29");
INSERT INTO audit_log VALUES("122","72","93","7","3","Invoice","9","2014-07-12 20:54:37");
INSERT INTO audit_log VALUES("123","72","93","2","11","Invoice","9","2014-07-12 20:54:58");
INSERT INTO audit_log VALUES("124","72","93","2","3","Invoice","9","2014-07-12 20:55:03");
INSERT INTO audit_log VALUES("125","72","93","6","3","Invoice","9","2014-07-12 20:55:03");
INSERT INTO audit_log VALUES("126","72","93","1","2","Expense","18","2014-07-12 21:14:57");
INSERT INTO audit_log VALUES("127","72","93","6","2","Expense","18","2014-07-12 21:14:57");
INSERT INTO audit_log VALUES("128","72","93","1","11","Expense","18","2014-07-12 21:16:03");
INSERT INTO audit_log VALUES("129","72","93","1","11","Expense","18","2014-07-12 21:16:51");
INSERT INTO audit_log VALUES("130","72","93","1","4","Credit Note","2","2014-07-12 21:23:38");
INSERT INTO audit_log VALUES("131","72","93","6","4","Credit Note","2","2014-07-12 21:23:38");
INSERT INTO audit_log VALUES("132","72","93","7","4","Credit Note","2","2014-07-12 21:23:45");
INSERT INTO audit_log VALUES("133","72","93","2","4","Credit Note","2","2014-07-12 21:23:58");
INSERT INTO audit_log VALUES("134","72","93","6","4","Credit Note","2","2014-07-12 21:23:58");
INSERT INTO audit_log VALUES("135","72","93","1","4","Credit Note","3","2014-07-12 21:25:32");
INSERT INTO audit_log VALUES("136","72","93","6","4","Credit Note","3","2014-07-12 21:25:32");
INSERT INTO audit_log VALUES("137","72","93","1","4","Credit Note","4","2014-07-12 21:26:32");
INSERT INTO audit_log VALUES("138","72","93","6","4","Credit Note","4","2014-07-12 21:26:32");
INSERT INTO audit_log VALUES("139","72","93","7","4","Credit Note","4","2014-07-12 21:26:42");
INSERT INTO audit_log VALUES("140","72","93","2","3","Invoice","5","2014-07-12 21:27:44");
INSERT INTO audit_log VALUES("141","72","93","6","3","Invoice","5","2014-07-12 21:27:44");
INSERT INTO audit_log VALUES("142","72","93","2","3","Invoice","1","2014-07-12 21:28:46");
INSERT INTO audit_log VALUES("143","72","93","6","3","Invoice","1","2014-07-12 21:28:46");
INSERT INTO audit_log VALUES("144","72","93","3","4","Credit Note","4","2014-07-12 21:29:18");
INSERT INTO audit_log VALUES("145","72","93","7","3","Invoice","5","2014-07-12 21:31:35");
INSERT INTO audit_log VALUES("146","72","93","2","3","Invoice","5","2014-07-12 21:31:54");
INSERT INTO audit_log VALUES("147","72","93","6","3","Invoice","5","2014-07-12 21:31:54");
INSERT INTO audit_log VALUES("148","72","93","1","4","Credit Note","5","2014-07-12 21:33:11");
INSERT INTO audit_log VALUES("149","72","93","6","4","Credit Note","5","2014-07-12 21:33:11");
INSERT INTO audit_log VALUES("150","72","93","1","4","Credit Note","6","2014-07-12 21:34:42");
INSERT INTO audit_log VALUES("151","72","93","6","4","Credit Note","6","2014-07-12 21:34:42");
INSERT INTO audit_log VALUES("152","72","93","2","3","Invoice","4","2014-07-12 21:36:21");
INSERT INTO audit_log VALUES("153","72","93","6","3","Invoice","4","2014-07-12 21:36:21");
INSERT INTO audit_log VALUES("154","72","93","7","4","Credit Note","3","2014-07-12 21:36:53");
INSERT INTO audit_log VALUES("155","72","93","2","4","Credit Note","3","2014-07-12 21:38:24");
INSERT INTO audit_log VALUES("156","72","93","6","4","Credit Note","3","2014-07-12 21:38:24");
INSERT INTO audit_log VALUES("157","72","93","2","1","Income","2","2014-07-12 21:40:09");
INSERT INTO audit_log VALUES("158","72","93","6","1","Income","2","2014-07-12 21:40:09");
INSERT INTO audit_log VALUES("159","72","93","2","2","Expense","9","2014-07-12 21:41:40");
INSERT INTO audit_log VALUES("160","72","93","6","2","Expense","9","2014-07-12 21:41:40");
INSERT INTO audit_log VALUES("161","72","93","6","1","Income","1","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("162","72","93","6","1","Income","3","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("163","72","93","6","2","Expense","1","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("164","72","93","6","2","Expense","2","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("165","72","93","6","2","Expense","3","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("166","72","93","6","2","Expense","4","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("167","72","93","6","2","Expense","5","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("168","72","93","6","2","Expense","6","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("169","72","93","6","2","Expense","7","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("170","72","93","6","2","Expense","8","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("171","72","93","6","2","Expense","10","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("172","72","93","6","2","Expense","11","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("173","72","93","6","2","Expense","12","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("174","72","93","6","2","Expense","13","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("175","72","93","6","2","Expense","14","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("176","72","93","6","2","Expense","15","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("177","72","93","6","2","Expense","16","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("178","72","93","6","2","Expense","17","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("179","72","93","6","3","Invoice","2","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("180","72","93","6","3","Invoice","3","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("181","72","93","6","3","Invoice","6","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("182","72","93","6","3","Invoice","7","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("183","72","93","6","3","Invoice","8","2014-07-12 21:42:44");
INSERT INTO audit_log VALUES("184","72","93","1","5","Jounral Entry","1","2014-07-12 21:48:40");
INSERT INTO audit_log VALUES("185","72","93","6","5","Jounral Entry","1","2014-07-12 21:48:40");
INSERT INTO audit_log VALUES("186","72","93","1","5","Jounral Entry","2","2014-07-12 21:51:41");
INSERT INTO audit_log VALUES("187","72","93","6","5","Jounral Entry","2","2014-07-12 21:51:41");
INSERT INTO audit_log VALUES("188","72","93","1","5","Jounral Entry","3","2014-07-12 21:56:21");
INSERT INTO audit_log VALUES("189","72","93","6","5","Jounral Entry","3","2014-07-12 21:56:21");
INSERT INTO audit_log VALUES("190","72","93","1","11","Invoice","5","2014-07-12 21:57:58");
INSERT INTO audit_log VALUES("191","72","93","1","11","Invoice","1","2014-07-12 21:58:43");
INSERT INTO audit_log VALUES("192","72","93","1","11","Invoice","2","2014-07-12 22:00:14");
INSERT INTO audit_log VALUES("193","72","93","1","11","Invoice","2","2014-07-12 22:00:48");
INSERT INTO audit_log VALUES("194","72","93","1","11","Invoice","2","2014-07-12 22:00:49");
INSERT INTO audit_log VALUES("195","72","93","7","3","Invoice","2","2014-07-12 22:01:18");
INSERT INTO audit_log VALUES("196","72","93","3","11","Invoice","2","2014-07-12 22:01:34");
INSERT INTO audit_log VALUES("197","72","93","3","11","Invoice","2","2014-07-12 22:01:41");
INSERT INTO audit_log VALUES("198","72","93","2","3","Invoice","2","2014-07-12 22:01:46");
INSERT INTO audit_log VALUES("199","72","93","6","3","Invoice","2","2014-07-12 22:01:46");
INSERT INTO audit_log VALUES("200","72","93","7","3","Invoice","2","2014-07-12 22:02:02");
INSERT INTO audit_log VALUES("201","72","93","2","11","Invoice","2","2014-07-12 22:02:21");
INSERT INTO audit_log VALUES("202","72","93","1","11","Invoice","4","2014-07-12 22:04:19");
INSERT INTO audit_log VALUES("203","72","93","1","11","Invoice","8","2014-07-12 22:05:15");
INSERT INTO audit_log VALUES("204","72","93","1","11","Invoice","7","2014-07-12 22:05:37");
INSERT INTO audit_log VALUES("205","72","93","1","11","Invoice","6","2014-07-12 22:07:11");
INSERT INTO audit_log VALUES("206","72","93","6","3","Invoice","2","2014-07-12 22:07:24");
INSERT INTO audit_log VALUES("207","72","93","1","11","Income","1","2014-07-12 22:08:41");
INSERT INTO audit_log VALUES("208","72","93","1","11","Income","2","2014-07-12 22:10:08");
INSERT INTO audit_log VALUES("209","72","93","7","1","Income","3","2014-07-12 22:17:32");
INSERT INTO audit_log VALUES("210","72","93","2","1","Income","3","2014-07-12 22:18:16");
INSERT INTO audit_log VALUES("211","72","93","6","1","Income","3","2014-07-12 22:18:16");
INSERT INTO audit_log VALUES("212","72","93","7","2","Expense","16","2014-07-12 22:18:57");
INSERT INTO audit_log VALUES("213","72","93","2","2","Expense","16","2014-07-12 22:19:59");
INSERT INTO audit_log VALUES("214","72","93","6","2","Expense","16","2014-07-12 22:19:59");
INSERT INTO audit_log VALUES("215","72","93","7","2","Expense","2","2014-07-12 22:21:57");
INSERT INTO audit_log VALUES("216","72","93","2","2","Expense","2","2014-07-12 22:22:46");
INSERT INTO audit_log VALUES("217","72","93","6","2","Expense","2","2014-07-12 22:22:46");
INSERT INTO audit_log VALUES("218","72","93","1","11","Expense","2","2014-07-12 22:25:39");
INSERT INTO audit_log VALUES("219","72","93","1","11","Expense","15","2014-07-12 22:26:40");
INSERT INTO audit_log VALUES("220","72","93","1","11","Expense","9","2014-07-12 22:27:18");
INSERT INTO audit_log VALUES("221","72","93","1","11","Expense","1","2014-07-12 22:28:07");
INSERT INTO audit_log VALUES("222","72","93","1","11","Expense","17","2014-07-12 22:28:51");
INSERT INTO audit_log VALUES("223","72","93","1","11","Expense","14","2014-07-12 22:29:33");
INSERT INTO audit_log VALUES("224","72","93","1","11","Expense","7","2014-07-12 22:29:58");
INSERT INTO audit_log VALUES("225","72","93","1","11","Expense","8","2014-07-12 22:30:36");
INSERT INTO audit_log VALUES("226","72","93","1","11","Expense","4","2014-07-12 22:32:34");
INSERT INTO audit_log VALUES("227","72","93","1","11","Expense","11","2014-07-12 22:33:10");
INSERT INTO audit_log VALUES("228","72","93","1","11","Expense","16","2014-07-12 22:34:06");
INSERT INTO audit_log VALUES("229","72","93","1","11","Expense","13","2014-07-12 22:34:46");
INSERT INTO audit_log VALUES("230","72","93","1","11","Expense","6","2014-07-12 22:35:05");
INSERT INTO audit_log VALUES("231","72","93","1","11","Expense","3","2014-07-12 22:35:41");
INSERT INTO audit_log VALUES("232","72","93","1","11","Expense","10","2014-07-12 22:36:29");
INSERT INTO audit_log VALUES("233","72","93","1","11","Expense","5","2014-07-12 22:37:38");
INSERT INTO audit_log VALUES("234","72","93","1","11","Expense","12","2014-07-12 22:38:30");
INSERT INTO audit_log VALUES("235","72","93","7","2","Expense","18","2014-07-12 22:50:06");
INSERT INTO audit_log VALUES("236","72","93","2","2","Expense","18","2014-07-12 22:50:36");
INSERT INTO audit_log VALUES("237","72","93","6","2","Expense","18","2014-07-12 22:50:36");
INSERT INTO audit_log VALUES("238","72","93","7","2","Expense","7","2014-07-12 22:56:24");
INSERT INTO audit_log VALUES("239","72","93","2","11","Expense","7","2014-07-12 22:57:12");
INSERT INTO audit_log VALUES("240","72","93","2","2","Expense","7","2014-07-12 22:57:17");
INSERT INTO audit_log VALUES("241","72","93","6","2","Expense","7","2014-07-12 22:57:17");
INSERT INTO audit_log VALUES("242","72","93","7","2","Expense","6","2014-07-12 23:02:35");
INSERT INTO audit_log VALUES("243","72","93","2","11","Expense","6","2014-07-12 23:03:03");
INSERT INTO audit_log VALUES("244","72","93","2","11","Expense","6","2014-07-12 23:03:16");
INSERT INTO audit_log VALUES("245","72","93","2","11","Expense","6","2014-07-12 23:03:26");
INSERT INTO audit_log VALUES("246","72","93","6","2","Expense","6","2014-07-12 23:22:10");
INSERT INTO audit_log VALUES("247","72","93","7","2","Expense","7","2014-07-12 23:24:58");
INSERT INTO audit_log VALUES("248","72","93","2","11","Expense","7","2014-07-12 23:26:10");
INSERT INTO audit_log VALUES("249","72","93","7","3","Invoice","5","2014-07-12 23:32:24");
INSERT INTO audit_log VALUES("250","72","93","7","3","Invoice","9","2014-07-12 23:32:45");
INSERT INTO audit_log VALUES("251","72","93","6","3","Invoice","9","2014-07-12 23:32:51");
INSERT INTO audit_log VALUES("252","72","93","6","3","Invoice","5","2014-07-12 23:32:56");
INSERT INTO audit_log VALUES("253","72","93","7","3","Invoice","5","2014-07-12 23:33:26");
INSERT INTO audit_log VALUES("254","72","93","2","11","Invoice","5","2014-07-12 23:34:09");
INSERT INTO audit_log VALUES("255","72","93","2","3","Invoice","5","2014-07-12 23:34:20");
INSERT INTO audit_log VALUES("256","72","93","6","3","Invoice","5","2014-07-12 23:34:20");
INSERT INTO audit_log VALUES("257","72","93","7","3","Invoice","5","2014-07-12 23:34:42");
INSERT INTO audit_log VALUES("258","72","93","7","3","Invoice","9","2014-07-12 23:34:59");
INSERT INTO audit_log VALUES("259","72","93","3","11","Invoice","9","2014-07-12 23:36:19");
INSERT INTO audit_log VALUES("260","72","93","7","4","Credit Note","1","2014-07-12 23:36:38");
INSERT INTO audit_log VALUES("261","72","93","6","4","Credit Note","1","2014-07-12 23:36:42");
INSERT INTO audit_log VALUES("262","72","93","2","3","Invoice","9","2014-07-12 23:36:53");
INSERT INTO audit_log VALUES("263","72","93","6","3","Invoice","9","2014-07-12 23:36:53");
INSERT INTO audit_log VALUES("264","72","93","1","11","Invoice","9","2014-07-12 23:37:42");
INSERT INTO audit_log VALUES("265","72","93","7","4","Credit Note","5","2014-07-12 23:37:58");
INSERT INTO audit_log VALUES("266","72","93","6","4","Credit Note","5","2014-07-12 23:38:03");
INSERT INTO audit_log VALUES("267","72","93","6","3","Invoice","5","2014-07-12 23:38:09");
INSERT INTO audit_log VALUES("268","72","93","7","3","Invoice","9","2014-07-12 23:40:06");
INSERT INTO audit_log VALUES("269","72","93","2","11","Invoice","9","2014-07-12 23:40:34");
INSERT INTO audit_log VALUES("270","72","93","6","3","Invoice","9","2014-07-12 23:41:23");
INSERT INTO audit_log VALUES("271","72","93","7","3","Invoice","5","2014-07-12 23:42:24");
INSERT INTO audit_log VALUES("272","72","93","7","3","Invoice","9","2014-07-12 23:42:25");
INSERT INTO audit_log VALUES("273","72","93","7","4","Credit Note","5","2014-07-12 23:42:34");
INSERT INTO audit_log VALUES("274","72","93","7","4","Credit Note","1","2014-07-12 23:42:38");
INSERT INTO audit_log VALUES("275","72","93","3","11","Invoice","9","2014-07-12 23:43:39");
INSERT INTO audit_log VALUES("276","72","93","2","3","Invoice","9","2014-07-12 23:43:44");
INSERT INTO audit_log VALUES("277","72","93","6","3","Invoice","9","2014-07-12 23:43:44");
INSERT INTO audit_log VALUES("278","72","93","3","11","Invoice","5","2014-07-12 23:44:13");
INSERT INTO audit_log VALUES("279","72","93","7","3","Invoice","9","2014-07-12 23:44:50");
INSERT INTO audit_log VALUES("280","72","93","6","3","Invoice","5","2014-07-12 23:44:56");
INSERT INTO audit_log VALUES("281","72","93","6","3","Invoice","9","2014-07-12 23:45:15");
INSERT INTO audit_log VALUES("282","72","93","6","4","Credit Note","5","2014-07-12 23:45:21");
INSERT INTO audit_log VALUES("283","72","93","6","4","Credit Note","1","2014-07-12 23:45:26");
INSERT INTO audit_log VALUES("284","72","93","1","11","Invoice","5","2014-07-12 23:46:12");
INSERT INTO audit_log VALUES("285","72","93","1","11","Invoice","9","2014-07-12 23:46:38");
INSERT INTO audit_log VALUES("286","72","1","8","1","Income","1","2014-07-13 01:06:48");
INSERT INTO audit_log VALUES("287","72","1","8","1","Income","2","2014-07-13 01:06:59");
INSERT INTO audit_log VALUES("288","72","93","9","12","Logged In","2","2014-07-13 04:50:59");
INSERT INTO audit_log VALUES("289","72","93","3","1","Income","4","2014-07-13 04:55:06");
INSERT INTO audit_log VALUES("290","72","93","6","2","Expense","7","2014-07-13 04:55:27");
INSERT INTO audit_log VALUES("291","72","93","7","3","Invoice","6","2014-07-13 05:48:31");
INSERT INTO audit_log VALUES("292","72","93","6","3","Invoice","6","2014-07-13 05:48:36");
INSERT INTO audit_log VALUES("293","72","93","7","3","Invoice","3","2014-07-13 05:48:42");
INSERT INTO audit_log VALUES("294","72","93","6","3","Invoice","3","2014-07-13 05:48:46");
INSERT INTO audit_log VALUES("295","72","93","9","13","Logged Out","2","2014-07-13 06:12:23");
INSERT INTO audit_log VALUES("296","72","93","9","12","Logged In","2","2014-07-13 06:23:58");
INSERT INTO audit_log VALUES("297","72","93","7","2","Expense","18","2014-07-13 06:24:18");
INSERT INTO audit_log VALUES("298","72","93","2","2","Expense","1","2014-07-13 06:24:58");
INSERT INTO audit_log VALUES("299","72","93","6","2","Expense","18","2014-07-13 06:24:58");
INSERT INTO audit_log VALUES("300","72","93","3","11","Expense","18","2014-07-13 06:25:05");
INSERT INTO audit_log VALUES("301","72","93","3","11","Expense","18","2014-07-13 06:25:11");
INSERT INTO audit_log VALUES("302","72","93","1","11","Expense","1","2014-07-13 06:25:42");
INSERT INTO audit_log VALUES("303","72","93","1","11","Expense","2","2014-07-13 06:26:05");
INSERT INTO audit_log VALUES("304","72","93","9","12","Logged In","2","2014-07-13 08:12:48");
INSERT INTO audit_log VALUES("305","72","93","9","13","Logged Out","2","2014-07-13 08:25:50");
INSERT INTO audit_log VALUES("306","72","93","9","12","Logged In","2","2014-07-13 18:48:56");
INSERT INTO audit_log VALUES("307","72","93","9","13","Logged Out","2","2014-07-13 18:50:50");
INSERT INTO audit_log VALUES("308","72","93","9","12","Logged In","2","2014-07-13 18:55:26");
INSERT INTO audit_log VALUES("309","72","93","9","13","Logged Out","2","2014-07-13 19:04:57");
INSERT INTO audit_log VALUES("310","72","93","9","12","Logged In","2","2014-07-14 15:51:37");





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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO credit VALUES("1","72","CR-0000000001","9","3","USD","1.24000","2014-04-27","Order Changes","0","1","2","1","2014-07-12 20:47:03","2014-07-12 23:45:26");
INSERT INTO credit VALUES("2","72","CR-0000000002","3","1","SGD","0.00000","2014-05-05","Changed or","0","1","2","1","2014-07-12 21:23:38","2014-07-12 21:23:58");
INSERT INTO credit VALUES("3","72","CR-0000000003","4","2","SGD","0.00000","2014-05-15","Changed the Order","0","1","2","1","2014-07-12 21:25:32","2014-07-12 21:38:24");
INSERT INTO credit VALUES("4","72","CR-0000000004","5","3","USD","1.24060","2014-05-15","Changed the order","0","2","2","2","2014-07-12 21:26:32","2014-07-12 21:29:18");
INSERT INTO credit VALUES("5","72","CR-0000000005","5","3","USD","1.24640","2014-05-15","Order Changed","0","1","2","1","2014-07-12 21:33:11","2014-07-12 23:45:21");
INSERT INTO credit VALUES("6","72","CR-0000000006","6","1","SGD","0.00000","2014-04-15","Order Changed","0","1","2","1","2014-07-12 21:34:41","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

INSERT INTO credit_product_list VALUES("1","1","HMP - USD","10","3","50.00","7.00","2","7.00","2014-07-12 20:47:03","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("2","1","PD - USD","5","2","10.00","12.00","2","7.00","2014-07-12 20:47:03","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("3","2","PA01","3","2","20.00","0.00","2","7.00","2014-07-12 21:23:38","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("4","2","PA02","4","2","30.00","0.00","2","7.00","2014-07-12 21:23:38","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("5","2","P12","1","2","35.00","0.00","2","7.00","2014-07-12 21:23:38","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("6","2","P8","2","2","25.00","0.00","2","7.00","2014-07-12 21:23:38","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("7","2","Whisky","8","2","12.00","0.00","2","7.00","2014-07-12 21:23:38","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("8","2","Wine","9","2","10.00","0.00","2","7.00","2014-07-12 21:23:38","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("9","2","SC100","6","1","100.00","0.00","2","7.00","2014-07-12 21:23:38","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("10","2","SC50","7","1","50.00","0.00","2","7.00","2014-07-12 21:23:38","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("11","3","Whisky","8","100","12.00","0.00","2","7.00","2014-07-12 21:25:32","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("12","3","Wine","9","47","10.00","0.00","2","7.00","2014-07-12 21:25:32","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("13","3","SC100","6","1","100.00","25.00","2","7.00","2014-07-12 21:25:32","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("14","4","HMP - USD","10","100","50.00","400.00","2","7.00","2014-07-12 21:26:32","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("15","4","PD - USD","5","100","10.00","100.00","2","7.00","2014-07-12 21:26:32","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("16","5","HMP - USD","10","100","50.00","400.00","2","7.00","2014-07-12 21:33:11","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("17","5","PD - USD","5","100","10.00","100.00","2","7.00","2014-07-12 21:33:11","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("18","6","P8","2","20","25.00","0.00","2","7.00","2014-07-12 21:34:41","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("19","6","Whisky","8","25","12.00","0.00","2","7.00","2014-07-12 21:34:41","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("20","6","SC50","7","1","50.00","0.00","2","7.00","2014-07-12 21:34:41","0000-00-00 00:00:00");





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

INSERT INTO customers VALUES("1","72","CUS-0000000001","OPH","16 Sandilands Road","","1978885558M-PTE-04","69453482","","Singapore","Singapore","SG","","","","546080","0000-00-00","3","","1","2014-07-12 20:14:31","0000-00-00 00:00:00");
INSERT INTO customers VALUES("2","72","CUS-0000000002","EZH & Qh","123 Address Road","","1978885558M-PTE-05","69453483","","Singapore","Singapore","SG","","","","546080","0000-00-00","3","","1","2014-07-12 20:14:31","0000-00-00 00:00:00");
INSERT INTO customers VALUES("3","72","CUS-0000000003","Dome - Dubai","123 Address Road","","1978885558M-PTE-06","69453484","","Dubai","Dubai","AE","","","","546080","0000-00-00","3","","1","2014-07-12 20:14:31","0000-00-00 00:00:00");
INSERT INTO customers VALUES("4","72","CUS-0000000004","Ciao Cafe - Vietnam","123 Address Road","","1978885558M-PTE-07","69453485","","Ho Chi Minh","Saigon","VN","","","","546080","0000-00-00","3","","1","2014-07-12 20:14:31","0000-00-00 00:00:00");
INSERT INTO customers VALUES("5","72","CUS-0000000005","Melinium Sdn Bhd","123 Address Road","","1978885558M-PTE-08","69453486","","KL","Selangor","MY","","","","546080","0000-00-00","4","","1","2014-07-12 20:14:31","0000-00-00 00:00:00");
INSERT INTO customers VALUES("6","72","CUS-0000000006","Temasek LLC","123 Address Road","","1978885558M-PTE-09","69453487","","Dubai","Dubai","AE","","","","546080","0000-00-00","4","","1","2014-07-12 20:14:31","0000-00-00 00:00:00");
INSERT INTO customers VALUES("7","72","CUS-0000000007","Grean Ocean Pte Ltd","123 Address Road","","1978885558M-PTE-10","69453488","","Singapore","Singapore","SG","","","","546080","0000-00-00","33","","1","2014-07-12 20:14:31","0000-00-00 00:00:00");
INSERT INTO customers VALUES("8","72","CUS-0000000008","Indian Bank","123 Address Road","","1978885558M-PTE-11","69453489","","Singapore","Singapore","SG","","","","546080","0000-00-00","21","","1","2014-07-12 20:14:31","0000-00-00 00:00:00");
INSERT INTO customers VALUES("9","72","CUS-0000000009","Indian Overseas Bank","123 Address Road","","1978885558M-PTE-21","69453489","","Chennai","Tamil Nadu","IN","","","","600064","0000-00-00","21","","1","2014-07-12 20:14:31","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction VALUES("1","72","EXP-0000000001","2014-05-14","PC2","7","","1","2014-05-14","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","1","19","2014-05-14","1","2014-07-12 20:22:44","2014-07-12 22:28:07");
INSERT INTO expense_transaction VALUES("2","72","EXP-0000000002","2014-04-01","2","5","","3","2014-05-31","USD","1.22000","87.50","","2","0.00","n/a","","","93","1","1","16","2014-05-25","1","2014-07-12 20:22:44","2014-07-12 22:25:39");
INSERT INTO expense_transaction VALUES("3","72","EXP-0000000003","2014-04-01","3","1","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","1","29","2014-04-25","1","2014-07-12 20:22:44","2014-07-12 22:35:41");
INSERT INTO expense_transaction VALUES("4","72","EXP-0000000004","2014-04-01","4","3","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","1","24","2014-04-25","1","2014-07-12 20:22:44","2014-07-12 22:32:34");
INSERT INTO expense_transaction VALUES("5","72","EXP-0000000005","2014-04-01","5","4","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","1","31","2014-04-25","1","2014-07-12 20:22:44","2014-07-12 22:37:38");
INSERT INTO expense_transaction VALUES("6","72","EXP-0000000006","2014-04-01","6","2","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","2","0","2014-04-25","1","2014-07-12 20:22:44","2014-07-12 23:22:10");
INSERT INTO expense_transaction VALUES("7","72","EXP-0000000007","2014-04-01","7","7","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","1","22","2014-04-01","1","2014-07-12 20:22:44","2014-07-13 04:55:27");
INSERT INTO expense_transaction VALUES("8","72","EXP-0000000008","2014-04-15","8","8","","2","2014-05-15","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","1","23","2014-04-15","1","2014-07-12 20:22:44","2014-07-12 22:30:36");
INSERT INTO expense_transaction VALUES("9","72","EXP-0000000009","2014-04-30","9","9","","2","2014-05-30","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","1","18","2014-04-30","1","2014-07-12 20:22:44","2014-07-12 22:27:18");
INSERT INTO expense_transaction VALUES("10","72","EXP-0000000010","2014-05-01","10","1","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","1","30","2014-05-25","1","2014-07-12 20:22:44","2014-07-12 22:36:29");
INSERT INTO expense_transaction VALUES("11","72","EXP-0000000011","2014-05-01","11","3","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","2","0","0000-00-00","1","2014-07-12 20:22:44","2014-07-12 21:42:44");
INSERT INTO expense_transaction VALUES("12","72","EXP-0000000012","2014-05-01","12","4","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","1","32","2014-05-25","1","2014-07-12 20:22:44","2014-07-12 22:38:30");
INSERT INTO expense_transaction VALUES("13","72","EXP-0000000013","2014-05-01","13","2","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","1","27","2014-05-25","1","2014-07-12 20:22:44","2014-07-12 22:34:46");
INSERT INTO expense_transaction VALUES("14","72","EXP-0000000014","2014-05-01","14","7","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","1","21","2014-05-01","1","2014-07-12 20:22:44","2014-07-12 22:29:33");
INSERT INTO expense_transaction VALUES("15","72","EXP-0000000015","2014-05-31","15","9","","2","2014-06-30","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","1","17","2014-05-31","1","2014-07-12 20:22:44","2014-07-12 22:26:40");
INSERT INTO expense_transaction VALUES("16","72","EXP-0000000016","2014-04-01","1","6","","2","2014-05-01","EUR","1.70000","1225.00","","2","0.00","n/a","","","93","1","1","26","2014-05-31","1","2014-07-12 20:22:53","2014-07-12 22:34:06");
INSERT INTO expense_transaction VALUES("17","72","EXP-0000000017","2014-04-14","PC1","7","","1","2014-04-14","SGD","0.00000","0.00","","2","0.00","n/a","","","93","1","1","20","2014-04-14","1","2014-07-12 20:22:53","2014-07-12 22:28:51");
INSERT INTO expense_transaction VALUES("18","72","EXP-0000000018","2014-06-10","19","6","","2","2014-07-10","AUD","1.16500","815.36","","2","0.00","N/A","","","0","1","1","37","2014-06-22","1","2014-07-12 21:14:57","2014-07-13 06:26:05");





CREATE TABLE `expense_transaction_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkexpense_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in the master database',
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
  `delete_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fkcompany_id` (`fkexpense_id`,`fkvendor_id`),
  KEY `fkcustomer_id` (`fkvendor_id`),
  KEY `fkpayment_account` (`fkpayment_account`),
  KEY `approval_for` (`approval_for`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction_audit VALUES("1","18","2014-06-10","19","6","","2","2014-07-10","AUD","1.16500","815.36","","2","0.00","N/A","","","0","1","1","2014-07-13 06:24:58");





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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction_list VALUES("1","1","50","","Warehouse Apr 14","1","940.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("2","1","62","","Warehouse Apr 14","3","20.00","0","0.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("3","2","45","","Vietnamese Food Items - Apr 14","1","1000.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("4","3","45","","Food - Apr 14","1","5485.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("5","4","46","","Beer - Apr 14","1","20000.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("6","5","46","","Wines - Apr 14","1","10000.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("7","6","47","","Misc. - Apr 14","1","5000.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("8","7","64","","Apr 2014","1","2000.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("9","8","63","","Initial Design and Plan Processing","1","2500.00","0","0.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("10","9","54","","Apr 2014 - Cleaning Services","1","14014.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("11","10","45","","Food - May 14","1","15400.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("12","11","46","","Beer - May 14","1","40000.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("13","12","46","","Wines - May 14","1","10000.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("14","13","47","","Misc. - May 14","1","5000.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("15","14","64","","May 14","1","2000.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("16","15","54","","May 2014 - Cleaning Services","1","15000.00","4","7.00","2014-07-12 20:22:44","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("17","16","23","","Pasta Machines","1","10000.00","4","7.00","2014-07-12 20:22:53","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("18","17","50","","Warehouse Apr 14","1","440.00","4","7.00","2014-07-12 20:22:53","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("19","17","62","","Warehouse Apr 14","3","20.00","0","0.00","2014-07-12 20:22:53","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("20","18","25","","Dish Washer","4","2500.00","4","7.00","2014-07-12 21:14:57","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction_list_audit VALUES("1","1","25","","Dish Washer","4","2500.00","4","7.00","2014-07-13 06:24:58");





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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO income_transaction VALUES("1","72","INC-0000000001","2014-04-25","1","5","","1","MYR","0.38940","39","Admin Fee - Apr 2014","2500.00","","2","7.00","93","1","1","13","2014-04-25","1","2014-07-12 20:42:22","2014-07-12 22:08:41");
INSERT INTO income_transaction VALUES("2","72","INC-0000000002","2014-05-25","2","5","","1","MYR","0.37000","39","Admin Fee - May 2014","2500.00","","2","7.00","93","1","1","14","2014-05-27","1","2014-07-12 20:42:28","2014-07-12 22:10:08");
INSERT INTO income_transaction VALUES("3","72","INC-0000000003","2014-05-31","FD01","8","","1","SGD","0.00000","40","Interest Added to Preminum","312.50","","1","0.00","93","1","1","15","2014-05-31","1","2014-07-12 20:42:28","2014-07-12 22:18:16");
INSERT INTO income_transaction VALUES("4","72","INC-0000000004","2014-07-13","jghjh tesr","4","","3","SGD","0.00000","39","","0.00","","0","0.00","0","3","2","0","0000-00-00","2","2014-07-13 01:06:48","2014-07-13 04:55:06");





CREATE TABLE `income_transaction_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkincome_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in the master database',
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
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fkcompany_id` (`fkincome_id`,`fkcustomer_id`,`fkpayment_account`,`fkincome_type`,`fktax_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `fktax_id` (`fktax_id`),
  KEY `fkpayment_account` (`fkpayment_account`),
  KEY `fkreceipt_id` (`fkreceipt_id`),
  KEY `approval_for` (`approval_for`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO income_transaction_audit VALUES("1","4","2014-07-13","jghjh","","","3","SGD","0.00000","39","","0.00","","0","0.00","0","3","2014-07-13 01:06:48");
INSERT INTO income_transaction_audit VALUES("2","4","2014-07-13","jghjh tesr","4","","3","SGD","0.00000","39","","0.00","","0","0.00","0","3","2014-07-13 01:06:59");





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

INSERT INTO invoice VALUES("1","72","INV-0000000001","2014-04-15","3","0","2","2014-05-15","USD","1.25000","1","2","apr 14 order","","93","1","1","5","2014-05-12","2","1","2014-07-12 20:22:09","2014-07-12 21:58:43");
INSERT INTO invoice VALUES("2","72","INV-0000000002","2014-04-30","2","0","2","2014-05-30","SGD","0.00000","1","2","apr 14 order","","93","1","1","6","2014-06-01","2","1","2014-07-12 20:22:09","2014-07-12 22:07:24");
INSERT INTO invoice VALUES("3","72","INV-0000000003","2014-05-05","1","0","2","2014-06-04","SGD","0.00000","1","2","may 14 order","","93","1","2","0","0000-00-00","2","1","2014-07-12 20:22:09","2014-07-13 05:48:46");
INSERT INTO invoice VALUES("4","72","INV-0000000004","2014-05-15","2","0","2","2014-06-14","SGD","0.00000","1","2","may 14 order","","93","1","1","9","2014-06-01","2","1","2014-07-12 20:22:09","2014-07-12 22:04:19");
INSERT INTO invoice VALUES("5","72","INV-0000000005","2014-05-15","3","0","2","2014-06-14","USD","1.24640","1","2","may 14 order","","93","1","1","34","2014-06-30","2","1","2014-07-12 20:22:09","2014-07-12 23:46:12");
INSERT INTO invoice VALUES("6","72","INV-0000000006","2014-04-15","1","0","2","2014-05-15","SGD","0.00000","1","2","apr intial order","","93","1","2","0","0000-00-00","2","1","2014-07-12 20:22:22","2014-07-13 05:48:36");
INSERT INTO invoice VALUES("7","72","INV-0000000007","2014-05-01","7","0","2","2014-05-31","SGD","0.00000","1","2","may 14 - rental","","93","1","1","11","2014-05-02","2","1","2014-07-12 20:34:19","2014-07-12 22:05:37");
INSERT INTO invoice VALUES("8","72","INV-0000000008","2014-04-01","7","0","2","2014-05-01","SGD","0.00000","1","2","rental - unit 113b","","93","1","1","10","2014-04-02","2","1","2014-07-12 20:34:31","2014-07-12 22:05:15");
INSERT INTO invoice VALUES("9","72","INV-0000000009","2014-04-24","3","0","2","2014-05-24","USD","1.24000","2","2","","","0","1","1","35","2014-06-30","2","1","2014-07-12 20:45:08","2014-07-12 23:46:38");





CREATE TABLE `invoice_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fkinvoice_id` int(11) NOT NULL COMMENT 'This will be a primary key of the company id exists in the master database',
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
  `delete_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - delete',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fkcompany_id` (`fkinvoice_id`,`fkcustomer_id`),
  KEY `fkcustomer_id` (`fkcustomer_id`),
  KEY `approval_for` (`approval_for`),
  KEY `id` (`id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

INSERT INTO invoice_product_list VALUES("1","1","HMP - USD","10","100","50.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("2","1","PD - USD","5","1000","10.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("3","2","Whisky","8","500","12.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("4","2","Wine","9","500","10.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("5","2","SC100","6","10","100.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("6","2","SC50","7","20","50.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("7","3","PA01","3","22","20.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("8","3","PA02","4","22","30.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("9","3","P12","1","22","35.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("10","3","P8","2","22","25.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("11","3","Whisky","8","22","12.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("12","3","Wine","9","22","10.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("13","3","SC100","6","11","100.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("14","3","SC50","7","11","50.00","0.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("15","4","Whisky","8","1985","12.00","1000.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("16","4","Wine","9","2000","10.00","1000.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("17","4","SC100","6","28","100.00","800.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("18","4","SC50","7","72","50.00","600.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("19","5","HMP - USD","10","500","50.00","2000.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("20","5","PD - USD","5","2000","10.00","2000.00","2","7.00","2014-07-12 20:22:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("21","6","PA01","3","100","20.00","0.00","2","7.00","2014-07-12 20:22:22","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("22","6","PA02","4","100","30.00","0.00","2","7.00","2014-07-12 20:22:22","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("23","6","P12","1","100","35.00","0.00","2","7.00","2014-07-12 20:22:22","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("24","6","P8","2","100","25.00","0.00","2","7.00","2014-07-12 20:22:22","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("25","6","Whisky","8","250","12.00","0.00","2","7.00","2014-07-12 20:22:22","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("26","6","Wine","9","200","10.00","0.00","2","7.00","2014-07-12 20:22:22","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("27","6","SC100","6","30","100.00","0.00","2","7.00","2014-07-12 20:22:22","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("28","6","SC50","7","70","50.00","0.00","2","7.00","2014-07-12 20:22:22","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("29","7","R - 113B","11","1","2500.00","0.00","2","7.00","2014-07-12 20:34:19","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("30","8","R - 113B","11","1","2500.00","0.00","2","7.00","2014-07-12 20:34:31","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("31","9","HMP - USD","10","4","50.00","10.00","2","7.00","2014-07-12 20:45:08","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("32","9","PD - USD","5","5","10.00","20.00","2","7.00","2014-07-12 20:45:08","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO journal_entries VALUES("1","72","JEN-0000000001","2014-05-31","May Payroll","","0","1","1","2014-07-12 21:48:40","0000-00-00 00:00:00");
INSERT INTO journal_entries VALUES("2","72","JEN-0000000002","2014-04-25","Fund Trasfer","","0","1","1","2014-07-12 21:51:41","0000-00-00 00:00:00");
INSERT INTO journal_entries VALUES("3","72","JEN-0000000003","2014-06-30","Depreciation for the Qtr","","0","1","1","2014-07-12 21:56:21","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO journal_entries_list VALUES("1","1","55","May Payroll","10000.00","0.00","0000-00-00","2014-07-12 21:48:40","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("2","1","56","May Payroll","1500.00","0.00","0000-00-00","2014-07-12 21:48:40","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("3","1","57","May Payroll","1000.00","0.00","0000-00-00","2014-07-12 21:48:40","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("4","1","58","May Payroll","800.00","0.00","0000-00-00","2014-07-12 21:48:40","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("5","1","59","May Payroll","11.25","0.00","0000-00-00","2014-07-12 21:48:40","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("6","1","22","May Payroll","0.00","1000.00","0000-00-00","2014-07-12 21:48:40","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("7","1","29","May Payroll","0.00","1811.25","0000-00-00","2014-07-12 21:48:40","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("8","1","30","May Payroll","0.00","10500.00","0000-00-00","2014-07-12 21:48:40","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("9","2","14","Fund Trasfer","1400.00","0.00","0000-00-00","2014-07-12 21:51:41","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("10","2","17","Fund Trasfer","0.00","1400.00","2014-04-27","2014-07-12 21:51:41","2014-07-13 06:06:37");
INSERT INTO journal_entries_list VALUES("11","3","65","Depreciation for the Qtr","1750.00","0.00","0000-00-00","2014-07-12 21:56:21","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("12","3","24","Depreciation for the Qtr","0.00","1750.00","0000-00-00","2014-07-12 21:56:21","0000-00-00 00:00:00");





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

INSERT INTO notifications VALUES("1","1","2","2014-07-12 20:09:35","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

INSERT INTO payments VALUES("5","1","0.00","","3","2014-07-12 21:58:43","2014-07-13 06:06:37","1","2014-05-12","2014-05-13","17","20060.00","1","DT1");
INSERT INTO payments VALUES("6","1","0.00","","3","2014-07-12 22:00:14","2014-07-12 22:02:21","2","2014-06-01","0000-00-00","15","13910.00","2","1");
INSERT INTO payments VALUES("9","1","230.25","","3","2014-07-12 22:04:19","0000-00-00 00:00:00","4","2014-06-01","0000-00-00","15","48000.00","2","2");
INSERT INTO payments VALUES("10","1","0.00","","3","2014-07-12 22:05:15","0000-00-00 00:00:00","8","2014-04-02","0000-00-00","15","2675.00","1","ST1");
INSERT INTO payments VALUES("11","1","0.00","","3","2014-07-12 22:05:37","0000-00-00 00:00:00","7","2014-05-02","0000-00-00","15","2675.00","1","ST2");
INSERT INTO payments VALUES("12","1","0.00","","3","2014-07-12 22:07:11","0000-00-00 00:00:00","6","2014-04-30","0000-00-00","15","23000.00","2","2");
INSERT INTO payments VALUES("13","2","0.00","","1","2014-07-12 22:08:41","2014-07-13 06:06:37","1","2014-04-25","2014-04-27","17","1050.00","1","KLT1");
INSERT INTO payments VALUES("14","2","0.00","","1","2014-07-12 22:10:08","2014-07-13 06:06:37","2","2014-05-27","2014-05-27","17","1050.00","1","KLT2");
INSERT INTO payments VALUES("15","2","0.00","","1","2014-07-12 22:18:16","0000-00-00 00:00:00","3","2014-05-31","0000-00-00","16","312.50","5","Premium Added");
INSERT INTO payments VALUES("16","2","0.00","","2","2014-07-12 22:25:39","0000-00-00 00:00:00","2","2014-05-25","0000-00-00","15","1300.00","1","VT1");
INSERT INTO payments VALUES("17","2","0.00","","2","2014-07-12 22:26:40","2014-07-13 06:06:37","15","2014-05-31","2014-06-08","17","16050.00","2","");
INSERT INTO payments VALUES("18","2","0.00","","2","2014-07-12 22:27:18","2014-07-13 06:06:37","9","2014-04-30","2014-05-05","17","14994.98","2","");
INSERT INTO payments VALUES("19","2","0.00","","2","2014-07-12 22:28:07","0000-00-00 00:00:00","1","2014-05-14","0000-00-00","14","1065.80","3","");
INSERT INTO payments VALUES("20","2","0.00","","2","2014-07-12 22:28:51","0000-00-00 00:00:00","17","2014-04-14","0000-00-00","14","530.80","3","");
INSERT INTO payments VALUES("21","2","0.00","","2","2014-07-12 22:29:33","2014-07-13 06:06:37","14","2014-05-01","2014-05-02","17","2140.00","2","");
INSERT INTO payments VALUES("22","2","0.00","","2","2014-07-12 22:29:58","2014-07-13 06:06:37","7","2014-04-01","2014-04-01","17","2140.00","2","");
INSERT INTO payments VALUES("23","2","0.00","","2","2014-07-12 22:30:36","2014-07-13 06:06:37","8","2014-04-15","0000-00-00","17","2500.00","2","");
INSERT INTO payments VALUES("24","2","0.00","","2","2014-07-12 22:32:34","0000-00-00 00:00:00","4","2014-04-25","0000-00-00","15","21400.00","2","");
INSERT INTO payments VALUES("25","2","0.00","","2","2014-07-12 22:33:10","2014-07-13 06:06:37","11","2014-05-25","1970-01-01","17","20000.00","2","");
INSERT INTO payments VALUES("26","2","0.00","","2","2014-07-12 22:34:06","2014-07-13 06:06:37","16","2014-05-31","2014-06-01","17","18220.00","1","");
INSERT INTO payments VALUES("27","2","0.00","","2","2014-07-12 22:34:46","2014-07-13 06:06:37","13","2014-05-25","2014-07-01","17","5350.00","2","");
INSERT INTO payments VALUES("28","2","0.00","","2","2014-07-12 22:35:05","2014-07-13 06:06:37","6","2014-04-25","2014-04-25","17","5082.50","2","");
INSERT INTO payments VALUES("29","2","0.00","","2","2014-07-12 22:35:41","0000-00-00 00:00:00","3","2014-04-25","0000-00-00","15","5868.95","2","");
INSERT INTO payments VALUES("30","1","478.00","","2","2014-07-12 22:36:29","2014-07-13 06:06:37","10","2014-05-25","2014-06-01","17","16000.00","2","");
INSERT INTO payments VALUES("31","1","107.00","","2","2014-07-12 22:37:38","2014-07-13 06:06:37","5","2014-04-25","2014-04-27","17","10593.00","2","");
INSERT INTO payments VALUES("32","1","160.50","","2","2014-07-12 22:38:30","2014-07-13 06:06:37","12","2014-05-25","2014-05-27","17","10539.50","2","");
INSERT INTO payments VALUES("34","2","0.00","","3","2014-07-12 23:46:12","2014-07-13 06:06:37","5","2014-06-30","2014-07-02","17","47300.00","1","DT2");
INSERT INTO payments VALUES("35","2","0.00","","3","2014-07-12 23:46:38","0000-00-00 00:00:00","9","2014-06-30","0000-00-00","15","88.25","1","DT3");
INSERT INTO payments VALUES("36","2","0.00","","2","2014-07-13 06:25:42","0000-00-00 00:00:00","18","2014-06-18","0000-00-00","17","8500.00","1","");
INSERT INTO payments VALUES("37","2","0.00","","2","2014-07-13 06:26:05","0000-00-00 00:00:00","18","2014-06-22","0000-00-00","17","3970.00","1","");





CREATE TABLE `payments_audit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_status` tinyint(4) NOT NULL COMMENT '1 - Yes, 2 - No',
  `discount_amount` decimal(11,2) NOT NULL,
  `payment_description` varchar(255) NOT NULL,
  `payment_status` tinyint(4) NOT NULL COMMENT '1 - Income, 2 - Expense, 3 - Invoice',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO payments_audit VALUES("1","2","0.00","","2","2014-07-13 06:25:42","18","2014-06-18","0000-00-00","17","8500.00","1","");
INSERT INTO payments_audit VALUES("2","2","0.00","","2","2014-07-13 06:26:05","18","2014-06-22","0000-00-00","17","3970.00","1","");





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

INSERT INTO products VALUES("1","Pizza 12\"","72","P12","Pizza 12\"","35.00","SGD","34","2014-07-12 20:15:30","0000-00-00 00:00:00");
INSERT INTO products VALUES("2","Pizza 8\"","72","P8","Pizza 8\"","25.00","SGD","34","2014-07-12 20:15:30","0000-00-00 00:00:00");
INSERT INTO products VALUES("3","Pasta 01","72","PA01","Pasta 01","20.00","SGD","34","2014-07-12 20:15:30","0000-00-00 00:00:00");
INSERT INTO products VALUES("4","Pasta 02","72","PA02","Pasta 02","30.00","SGD","34","2014-07-12 20:15:30","0000-00-00 00:00:00");
INSERT INTO products VALUES("5","Pizza Dong","72","PD - USD","Pizza Dong","10.00","USD","36","2014-07-12 20:15:30","0000-00-00 00:00:00");
INSERT INTO products VALUES("6","Service Charge - $100","72","SC100","Service Charge - $100","100.00","SGD","37","2014-07-12 20:15:30","0000-00-00 00:00:00");
INSERT INTO products VALUES("7","Service Charge - $50","72","SC50","Service Charge - $50","50.00","SGD","37","2014-07-12 20:15:30","0000-00-00 00:00:00");
INSERT INTO products VALUES("8","Whisky","72","Whisky","Whisky","12.00","SGD","35","2014-07-12 20:15:30","0000-00-00 00:00:00");
INSERT INTO products VALUES("9","Wine","72","Wine","Wine","10.00","SGD","35","2014-07-12 20:15:30","0000-00-00 00:00:00");
INSERT INTO products VALUES("10","Home Made Pasta","72","HMP - USD","Home Made Pasta","50.00","USD","36","2014-07-12 20:15:30","0000-00-00 00:00:00");
INSERT INTO products VALUES("11","Rent - 113B","72","R - 113B","","2500.00","SGD","66","2014-07-12 20:32:31","0000-00-00 00:00:00");





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

INSERT INTO taxcodes VALUES("1","72","15","0.00","Regulation 33 Exempt supplies","2","1","2014-07-12 20:16:07","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("2","72","13","7.00","Standard-rated supplies with GST charged","2","1","2014-07-12 20:16:18","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("3","72","6","0.00","Purchases from  GST-registered supplier with no GST incurred. (e.g. supplier provides transportation of goods that qualify as international service)","1","1","2014-07-12 20:16:32","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("4","72","23","7.00","Purchases with GST incurred at 7% and directly attributable to taxable supplies","1","1","2014-07-12 20:16:47","0000-00-00 00:00:00");





CREATE TABLE `theme_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `default_theme` tinyint(2) NOT NULL COMMENT '1 - Default, 2 - Not Default',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO theme_setting VALUES("1","Red","Basic Theme","1","2014-07-12 20:09:35");
INSERT INTO theme_setting VALUES("2","Black","Black Theme","2","2014-07-12 20:09:35");
INSERT INTO theme_setting VALUES("3","Blue","Blue Theme","2","2014-07-12 20:09:35");





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

INSERT INTO vendors VALUES("1","72","VEN-0000000001","Natrad Foods","16 Sandilands Road","","201301587A-PTE-01","69453481","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-12 20:15:17","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("2","72","VEN-0000000002","FoodXervices","16 Sandilands Road","","201301587A-PTE-06","69453482","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-12 20:15:18","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("3","72","VEN-0000000003","APB","16 Sandilands Road","","201301587A-PTE-02","69453483","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-12 20:15:18","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("4","72","VEN-0000000004","Magnum Wines","16 Sandilands Road","","201301587A-PTE-03","69453484","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-12 20:15:18","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("5","72","VEN-0000000005","AA Corporation - Vietnam","16 Sandilands Road","","201301587A-PTE-04","69453485","","Ho Chi Minh","Saigon","VN","","","","546080","0000-00-00","1","6","","2014-07-12 20:15:18","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("6","72","VEN-0000000006","Bakers & Chef - Italy","16 Sandilands Road","","201301587A-PTE-15","69453485","","Italy","Italy","IT","","","","546080","0000-00-00","1","6","","2014-07-12 20:15:18","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("7","72","VEN-0000000007","MCST 835","16 Sandilands Road","","201301587A-PTE-18","69453482","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","32","","2014-07-12 20:15:18","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("8","72","VEN-0000000008","ID Ranger","16 Sandilands Road","","201301587A-PTE-19","69453483","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","6","","2014-07-12 20:15:18","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("9","72","VEN-0000000009","Evergreen Cleaning Services","16 Sandilands Road","","201301587A-PTE-20","69453484","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","6","","2014-07-12 20:15:18","0000-00-00 00:00:00");



