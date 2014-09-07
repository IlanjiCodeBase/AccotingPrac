

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
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

INSERT INTO account VALUES("1","2","1","0","Unrealised Foreign Exchange Gain / (Loss)","","0.00","0.00","0","2","1","2014-07-07 19:18:55","2014-07-07 20:43:46");
INSERT INTO account VALUES("2","4","3","0","Foreign Exchange Gain/(Loss)","","0.00","0.00","0","2","1","2014-07-07 19:18:55","2014-07-07 20:43:46");
INSERT INTO account VALUES("3","1","1","4","Trade Receivables","","0.00","0.00","0","2","1","2014-07-07 19:18:55","2014-07-07 20:43:46");
INSERT INTO account VALUES("4","1","1","5","Account Receivables - Others","","0.00","0.00","0","2","1","2014-07-07 19:18:55","2014-07-07 20:43:46");
INSERT INTO account VALUES("5","2","1","3","Trade Creditors","","0.00","0.00","0","2","1","2014-07-07 19:18:55","2014-07-07 20:43:46");
INSERT INTO account VALUES("6","2","1","8","Account Payables - Others","","0.00","0.00","0","2","1","2014-07-07 19:18:55","2014-07-07 20:43:46");
INSERT INTO account VALUES("7","3","1","0","Discounts Given","","0.00","0.00","0","2","1","2014-07-07 19:18:55","2014-07-07 20:43:46");
INSERT INTO account VALUES("8","4","1","0","Discounts Received","","0.00","0.00","0","2","1","2014-07-07 19:18:55","2014-07-07 20:43:46");
INSERT INTO account VALUES("9","5","4","1","Retained Earnings","","0.00","150000.00","0","2","1","2014-07-07 19:18:55","2014-07-07 20:43:46");
INSERT INTO account VALUES("10","5","4","1","Current Year Earnings","","0.00","0.00","0","2","1","2014-07-07 19:18:55","2014-07-07 20:43:46");
INSERT INTO account VALUES("11","2","1","4","Sales Tax Payables","","0.00","0.00","0","2","1","2014-07-07 19:18:55","2014-07-07 20:43:46");
INSERT INTO account VALUES("12","4","3","8","Income Tax","","0.00","0.00","0","2","1","2014-07-07 19:18:55","2014-07-07 20:43:46");
INSERT INTO account VALUES("13","1","1","1","Cash in Hand","SGD","2500.00","0.00","2","1","1","2014-07-07 19:24:18","2014-07-07 20:43:46");
INSERT INTO account VALUES("14","1","1","1","Petty Cash","SGD","2000.00","0.00","2","1","1","2014-07-07 19:24:18","2014-07-07 20:43:46");
INSERT INTO account VALUES("15","1","1","1","UOB Bank","SGD","60000.00","0.00","2","1","1","2014-07-07 19:24:18","2014-07-07 20:43:46");
INSERT INTO account VALUES("16","1","1","1","Fixed Deposits","SGD","200000.00","0.00","2","1","1","2014-07-07 19:24:18","2014-07-07 20:43:46");
INSERT INTO account VALUES("17","1","1","1","OCBC Bank","SGD","105000.00","0.00","2","1","1","2014-07-07 19:24:18","2014-07-07 20:43:46");
INSERT INTO account VALUES("18","1","1","3","Inventory","SGD","10000.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("19","1","1","6","Rental Deposit","SGD","60000.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("20","1","1","6","Security Deposit","SGD","500.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("21","1","1","5","Interest Receivbales","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("22","1","1","5","Staff Loan","SGD","10000.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("23","1","2","3","Machinery","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("24","1","2","3","Acc. Depn - Machinery","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("25","1","2","3","F & F","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("26","1","2","3","Computers","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("27","1","2","3","Acc. Depn - Computers","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("28","2","1","8","CPF Board Payable","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("29","2","1","8","Staff Payables","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("30","5","1","1","Capital Account","SGD","0.00","300000.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("31","3","1","7","Sales - Food","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("32","3","1","7","Sales - B/V","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("33","3","1","7","Sales - Misc","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("34","3","1","7","Service Charge","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("35","3","1","8","Misc. Rcpts.","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("36","3","2","1","Admin Fees Income","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("37","3","2","2","Interest Income - Fixed Deposits","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("38","3","2","4","Other Non Operating Income","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("39","3","3","1","Government Grants - PIC","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("40","3","3","1","Government Grants - SEC","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("41","4","1","1","Opening Stock","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("42","4","1","1","Purchases - Food","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("43","4","1","1","Purchases - B/V","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("44","4","1","1","Purchases - Misc.","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("45","4","1","1","Closing Stock","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("46","4","2","6","Advertising & Promotion","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("47","4","2","9","Shop Maintance","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("48","4","2","9","Kitchen Maintance","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("49","4","2","9","Kitchen Equipment Maintenance","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("50","4","2","9","Cleaing Items","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("51","4","2","9","Cleaing Contractor","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("52","4","2","11","Salary & Wages","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("53","4","2","11","Overtime","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("54","4","2","11","Sales Promotion","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("55","4","2","11","CPF","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("56","4","2","11","SDL","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("57","4","2","11","Staff Welfare","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("58","4","2","11","Staff medical Expenses","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("59","4","2","17","Electricity / Water / Gas","SGD","0.00","0.00","2","1","1","2014-07-07 19:24:19","2014-07-07 20:43:46");
INSERT INTO account VALUES("60","1","2","3","Acc. Depn - F  F","SGD","0.00","0.00","2","1","1","2014-07-07 19:27:22","2014-07-07 20:43:46");
INSERT INTO account VALUES("61","1","1","5","Rent Receivable","SGD","0.00","0.00","2","1","1","2014-07-07 19:40:29","2014-07-07 20:43:46");
INSERT INTO account VALUES("62","3","3","2","Rental Income","SGD","0.00","0.00","2","1","1","2014-07-07 20:53:44","2014-07-07 20:55:20");
INSERT INTO account VALUES("63","2","1","8","Rent Payable","SGD","0.00","0.00","2","1","1","2014-07-08 11:17:49","0000-00-00 00:00:00");
INSERT INTO account VALUES("64","1","2","2","Renovation in Progress","SGD","0.00","0.00","2","1","1","2014-07-08 11:33:20","0000-00-00 00:00:00");
INSERT INTO account VALUES("65","4","2","8","Warehouse Rental","SGD","0.00","0.00","2","1","1","2014-07-08 11:43:50","0000-00-00 00:00:00");
INSERT INTO account VALUES("66","4","3","1","Depreciation","SGD","0.00","0.00","2","1","1","2014-07-08 13:23:29","0000-00-00 00:00:00");
INSERT INTO account VALUES("67","3","1","7","Test Income","SGD","0.00","0.00","2","1","1","2014-07-09 08:06:22","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

INSERT INTO accounting_entries VALUES("1","1","2","10000.00","2014-04-01","2","2","1","2014-07-07 20:51:28","2014-07-08 18:27:10");
INSERT INTO accounting_entries VALUES("2","1","1","2675.00","2014-04-01","3","1","1","2014-07-07 20:57:29","2014-07-08 08:56:48");
INSERT INTO accounting_entries VALUES("3","1","5","2500.00","2014-04-01","3","2","1","2014-07-07 20:57:29","2014-07-08 08:56:48");
INSERT INTO accounting_entries VALUES("4","1","4","175.00","2014-04-01","3","2","1","2014-07-07 20:57:29","2014-07-08 08:56:48");
INSERT INTO accounting_entries VALUES("5","2","2","1000.00","2014-04-01","2","2","1","2014-07-07 21:02:16","2014-07-08 18:29:15");
INSERT INTO accounting_entries VALUES("6","2","1","24075.00","2014-04-15","3","1","1","2014-07-08 04:51:12","2014-07-08 08:57:25");
INSERT INTO accounting_entries VALUES("7","2","5","22500.00","2014-04-15","3","2","1","2014-07-08 04:51:12","2014-07-08 08:57:25");
INSERT INTO accounting_entries VALUES("8","2","4","1575.00","2014-04-15","3","2","1","2014-07-08 04:51:12","2014-07-08 08:57:25");
INSERT INTO accounting_entries VALUES("9","3","1","16050.00","2014-04-15","3","1","1","2014-07-08 04:56:09","2014-07-08 09:00:47");
INSERT INTO accounting_entries VALUES("10","3","5","15000.00","2014-04-15","3","2","1","2014-07-08 04:56:09","2014-07-08 09:00:47");
INSERT INTO accounting_entries VALUES("11","3","4","1050.00","2014-04-15","3","2","1","2014-07-08 04:56:09","2014-07-08 09:00:47");
INSERT INTO accounting_entries VALUES("12","4","1","13910.00","2014-04-30","3","1","1","2014-07-08 04:58:35","2014-07-09 01:31:27");
INSERT INTO accounting_entries VALUES("13","4","5","13000.00","2014-04-30","3","2","1","2014-07-08 04:58:35","2014-07-09 01:31:27");
INSERT INTO accounting_entries VALUES("14","4","4","910.00","2014-04-30","3","2","1","2014-07-08 04:58:35","2014-07-09 01:31:27");
INSERT INTO accounting_entries VALUES("15","5","1","4712.28","2014-05-05","3","1","1","2014-07-08 05:02:34","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("16","5","5","4404.00","2014-05-05","3","2","1","2014-07-08 05:02:34","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("17","5","4","308.28","2014-05-05","3","2","1","2014-07-08 05:02:34","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("18","6","1","50290.00","2014-05-15","3","1","2","2014-07-08 05:06:00","2014-07-12 19:43:07");
INSERT INTO accounting_entries VALUES("19","6","5","47000.00","2014-05-15","3","2","2","2014-07-08 05:06:00","2014-07-12 19:43:07");
INSERT INTO accounting_entries VALUES("20","6","4","3290.00","2014-05-15","3","2","2","2014-07-08 05:06:00","2014-07-12 19:43:07");
INSERT INTO accounting_entries VALUES("21","7","1","43870.00","2014-05-15","3","1","1","2014-07-08 05:10:31","2014-07-09 14:56:27");
INSERT INTO accounting_entries VALUES("22","7","5","41000.00","2014-05-15","3","2","1","2014-07-08 05:10:31","2014-07-09 14:56:27");
INSERT INTO accounting_entries VALUES("23","7","4","2870.00","2014-05-15","3","2","1","2014-07-08 05:10:31","2014-07-09 14:56:27");
INSERT INTO accounting_entries VALUES("24","8","1","2675.00","2014-05-01","3","1","1","2014-07-08 05:11:02","2014-07-08 09:09:41");
INSERT INTO accounting_entries VALUES("25","8","5","2500.00","2014-05-01","3","2","1","2014-07-08 05:11:02","2014-07-08 09:09:41");
INSERT INTO accounting_entries VALUES("26","8","4","175.00","2014-05-01","3","2","1","2014-07-08 05:11:02","2014-07-08 09:09:41");
INSERT INTO accounting_entries VALUES("27","1","1","909.50","2014-04-15","4","2","1","2014-07-08 05:18:57","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("28","1","5","850.00","2014-04-15","4","1","1","2014-07-08 05:18:57","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("29","1","4","59.50","2014-04-15","4","1","1","2014-07-08 05:18:57","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("30","2","1","2434.25","2014-04-30","4","2","1","2014-07-08 05:23:12","2014-07-09 13:32:53");
INSERT INTO accounting_entries VALUES("31","2","5","2275.00","2014-04-30","4","1","1","2014-07-08 05:23:12","2014-07-09 13:32:53");
INSERT INTO accounting_entries VALUES("32","2","4","159.25","2014-04-30","4","1","1","2014-07-08 05:23:12","2014-07-09 13:32:53");
INSERT INTO accounting_entries VALUES("33","3","1","442.98","2014-05-05","4","2","1","2014-07-08 05:25:29","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("34","3","5","414.00","2014-05-05","4","1","1","2014-07-08 05:25:29","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("35","3","4","28.98","2014-05-05","4","1","1","2014-07-08 05:25:29","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("36","4","1","5885.00","2014-04-15","4","2","1","2014-07-08 05:27:26","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("37","4","5","5500.00","2014-04-15","4","1","1","2014-07-08 05:27:26","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("38","4","4","385.00","2014-04-15","4","1","1","2014-07-08 05:27:26","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("39","1","3","2675.00","2014-04-01","3","1","1","2014-07-08 08:56:18","2014-07-08 08:56:48");
INSERT INTO accounting_entries VALUES("40","2","3","23165.50","2014-04-15","3","1","1","2014-07-08 08:57:25","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("41","3","3","20060.00","2014-04-15","3","1","1","2014-07-08 08:58:43","2014-07-08 09:00:47");
INSERT INTO accounting_entries VALUES("42","4","3","11475.75","2014-04-30","3","1","1","2014-07-08 09:02:45","2014-07-09 01:31:27");
INSERT INTO accounting_entries VALUES("43","6","3","50000.00","2014-05-15","3","1","2","2014-07-08 09:04:05","2014-07-12 19:43:07");
INSERT INTO accounting_entries VALUES("44","7","3","47300.00","2014-05-15","3","1","1","2014-07-08 09:07:40","2014-07-09 14:56:27");
INSERT INTO accounting_entries VALUES("45","8","3","2675.00","2014-05-01","3","1","1","2014-07-08 09:09:41","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("46","1","3","1050.00","2014-04-25","1","1","1","2014-07-08 09:13:00","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("47","1","1","2675.00","2014-04-25","1","1","1","2014-07-08 09:13:00","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("48","1","5","2500.00","2014-04-25","1","2","1","2014-07-08 09:13:00","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("49","1","4","175.00","2014-04-25","1","2","1","2014-07-08 09:13:00","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("50","2","3","1050.00","2014-05-25","1","1","2","2014-07-08 09:24:54","2014-07-11 20:31:33");
INSERT INTO accounting_entries VALUES("51","2","1","2675.00","2014-05-25","1","1","2","2014-07-08 09:24:54","2014-07-11 20:31:33");
INSERT INTO accounting_entries VALUES("52","2","5","2500.00","2014-05-25","1","2","2","2014-07-08 09:24:54","2014-07-11 20:31:33");
INSERT INTO accounting_entries VALUES("53","2","4","175.00","2014-05-25","1","2","2","2014-07-08 09:24:54","2014-07-11 20:31:33");
INSERT INTO accounting_entries VALUES("54","3","2","5868.95","2014-04-01","2","2","1","2014-07-08 10:58:00","2014-07-08 12:05:50");
INSERT INTO accounting_entries VALUES("55","4","2","21400.00","2014-04-01","2","2","1","2014-07-08 10:58:56","2014-07-10 16:23:53");
INSERT INTO accounting_entries VALUES("56","5","2","10700.00","2014-04-01","2","2","1","2014-07-08 11:00:33","2014-07-09 21:01:23");
INSERT INTO accounting_entries VALUES("57","6","2","5350.00","2014-04-01","2","2","1","2014-07-08 11:01:33","2014-07-08 12:09:47");
INSERT INTO accounting_entries VALUES("58","7","2","16478.00","2014-05-01","2","2","1","2014-07-08 11:03:37","2014-07-08 12:32:05");
INSERT INTO accounting_entries VALUES("59","8","2","42800.00","2014-05-01","2","2","1","2014-07-08 11:04:23","2014-07-08 12:32:48");
INSERT INTO accounting_entries VALUES("60","9","2","10700.00","2014-05-01","2","2","1","2014-07-08 11:04:59","2014-07-09 14:05:09");
INSERT INTO accounting_entries VALUES("61","10","2","5350.00","2014-05-01","2","2","1","2014-07-08 11:06:06","2014-07-08 12:48:51");
INSERT INTO accounting_entries VALUES("62","11","3","16050.00","2014-04-30","2","2","1","2014-07-08 11:31:40","2014-07-09 14:05:14");
INSERT INTO accounting_entries VALUES("63","11","2","16050.00","2014-04-30","2","2","1","2014-07-08 11:31:40","2014-07-09 14:05:14");
INSERT INTO accounting_entries VALUES("64","13","3","16050.00","2014-05-31","2","2","1","2014-07-08 11:41:39","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("65","13","2","16050.00","2014-05-31","2","2","1","2014-07-08 11:41:39","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("66","12","3","2500.00","2014-04-15","2","2","1","2014-07-08 11:42:37","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("67","12","2","2500.00","2014-04-15","2","2","1","2014-07-08 11:42:37","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("68","14","3","2140.00","2014-04-01","2","2","1","2014-07-08 11:51:33","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("69","14","2","2140.00","2014-04-01","2","2","1","2014-07-08 11:51:33","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("70","1","3","18225.00","2014-04-01","2","2","1","2014-07-08 11:59:54","2014-07-08 18:27:10");
INSERT INTO accounting_entries VALUES("71","2","3","1300.00","2014-04-01","2","2","1","2014-07-08 12:04:45","2014-07-08 18:29:15");
INSERT INTO accounting_entries VALUES("72","3","3","5868.95","2014-04-01","2","2","1","2014-07-08 12:05:50","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("73","4","3","21400.00","2014-04-01","2","2","1","2014-07-08 12:06:25","2014-07-10 16:23:53");
INSERT INTO accounting_entries VALUES("74","5","3","9630.00","2014-04-01","2","2","1","2014-07-08 12:07:50","2014-07-09 21:01:23");
INSERT INTO accounting_entries VALUES("75","6","3","5082.50","2014-04-01","2","2","1","2014-07-08 12:09:47","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("76","7","3","16000.00","2014-05-01","2","2","1","2014-07-08 12:32:05","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("77","8","3","21400.00","2014-05-01","2","2","1","2014-07-08 12:32:48","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("78","9","3","9095.00","2014-05-01","2","2","1","2014-07-08 12:45:41","2014-07-09 14:05:09");
INSERT INTO accounting_entries VALUES("79","10","3","5350.00","2014-05-01","2","2","1","2014-07-08 12:48:51","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("80","20","3","1070.00","2014-05-14","2","2","1","2014-07-08 12:57:05","2014-07-08 18:20:19");
INSERT INTO accounting_entries VALUES("81","20","2","1070.00","2014-05-14","2","2","1","2014-07-08 12:57:05","2014-07-08 18:20:19");
INSERT INTO accounting_entries VALUES("82","17","3","535.00","2014-04-14","2","2","2","2014-07-08 12:58:35","2014-07-11 21:06:03");
INSERT INTO accounting_entries VALUES("83","17","2","535.00","2014-04-14","2","2","2","2014-07-08 12:58:35","2014-07-11 21:06:03");
INSERT INTO accounting_entries VALUES("84","15","3","2140.00","2014-05-01","2","2","1","2014-07-08 12:59:42","2014-07-08 12:59:52");
INSERT INTO accounting_entries VALUES("85","15","2","2140.00","2014-05-01","2","2","1","2014-07-08 12:59:42","2014-07-08 12:59:52");





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
) ENGINE=InnoDB AUTO_INCREMENT=481 DEFAULT CHARSET=latin1;

INSERT INTO audit_log VALUES("1","62","75","9","12","Logged In","2","2014-07-07 19:19:17");
INSERT INTO audit_log VALUES("2","62","75","1","8","Cash in Hand","13","2014-07-07 19:24:18");
INSERT INTO audit_log VALUES("3","62","75","1","8","Petty Cash","14","2014-07-07 19:24:18");
INSERT INTO audit_log VALUES("4","62","75","1","8","UOB Bank","15","2014-07-07 19:24:18");
INSERT INTO audit_log VALUES("5","62","75","1","8","Fixed Deposits","16","2014-07-07 19:24:18");
INSERT INTO audit_log VALUES("6","62","75","1","8","OCBC Bank","17","2014-07-07 19:24:18");
INSERT INTO audit_log VALUES("7","62","75","1","8","Inventory","18","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("8","62","75","1","8","Rental Deposit","19","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("9","62","75","1","8","Security Deposit","20","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("10","62","75","1","8","Interest Receivbales","21","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("11","62","75","1","8","Staff Loan","22","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("12","62","75","1","8","Machinery","23","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("13","62","75","1","8","Acc. Depn - Machinery","24","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("14","62","75","1","8","F & F","25","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("15","62","75","1","8","Computers","26","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("16","62","75","1","8","Acc. Depn - Computers","27","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("17","62","75","1","8","CPF Board Payable","28","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("18","62","75","1","8","Staff Payables","29","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("19","62","75","1","8","Capital Account","30","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("20","62","75","1","8","Sales - Food","31","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("21","62","75","1","8","Sales - B/V","32","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("22","62","75","1","8","Sales - Misc","33","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("23","62","75","1","8","Service Charge","34","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("24","62","75","1","8","Misc. Rcpts.","35","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("25","62","75","1","8","Admin Fees Income","36","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("26","62","75","1","8","Interest Income - Fixed Deposits","37","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("27","62","75","1","8","Other Non Operating Income","38","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("28","62","75","1","8","Government Grants - PIC","39","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("29","62","75","1","8","Government Grants - SEC","40","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("30","62","75","1","8","Opening Stock","41","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("31","62","75","1","8","Purchases - Food","42","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("32","62","75","1","8","Purchases - B/V","43","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("33","62","75","1","8","Purchases - Misc.","44","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("34","62","75","1","8","Closing Stock","45","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("35","62","75","1","8","Advertising & Promotion","46","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("36","62","75","1","8","Shop Maintance","47","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("37","62","75","1","8","Kitchen Maintance","48","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("38","62","75","1","8","Kitchen Equipment Maintenance","49","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("39","62","75","1","8","Cleaing Items","50","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("40","62","75","1","8","Cleaing Contractor","51","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("41","62","75","1","8","Salary & Wages","52","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("42","62","75","1","8","Overtime","53","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("43","62","75","1","8","Sales Promotion","54","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("44","62","75","1","8","CPF","55","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("45","62","75","1","8","SDL","56","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("46","62","75","1","8","Staff Welfare","57","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("47","62","75","1","8","Staff medical Expenses","58","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("48","62","75","1","8","Electricity / Water / Gas","59","2014-07-07 19:24:19");
INSERT INTO audit_log VALUES("49","62","75","1","8","Acc. Depn - F & F","60","2014-07-07 19:27:22");
INSERT INTO audit_log VALUES("50","62","75","1","10","Pizza 12\"","1","2014-07-07 19:31:06");
INSERT INTO audit_log VALUES("51","62","75","1","10","Pizza 8\"","2","2014-07-07 19:31:06");
INSERT INTO audit_log VALUES("52","62","75","1","10","Pasta 01","3","2014-07-07 19:31:06");
INSERT INTO audit_log VALUES("53","62","75","1","10","Pasta 02","4","2014-07-07 19:31:06");
INSERT INTO audit_log VALUES("54","62","75","1","10","Pizza Dong","5","2014-07-07 19:31:06");
INSERT INTO audit_log VALUES("55","62","75","1","10","Service Charge - $100","6","2014-07-07 19:31:06");
INSERT INTO audit_log VALUES("56","62","75","1","10","Service Charge - $50","7","2014-07-07 19:31:06");
INSERT INTO audit_log VALUES("57","62","75","1","10","Whisky","8","2014-07-07 19:31:06");
INSERT INTO audit_log VALUES("58","62","75","1","10","Wine","9","2014-07-07 19:31:06");
INSERT INTO audit_log VALUES("59","62","75","1","10","Home Made Pasta","10","2014-07-07 19:31:06");
INSERT INTO audit_log VALUES("60","62","75","1","8","Rent Receivable","61","2014-07-07 19:40:29");
INSERT INTO audit_log VALUES("61","62","75","1","6","Gorman Hoa","1","2014-07-07 20:03:10");
INSERT INTO audit_log VALUES("62","62","75","1","6","testa","2","2014-07-07 20:03:10");
INSERT INTO audit_log VALUES("63","62","75","1","6","testb","3","2014-07-07 20:03:10");
INSERT INTO audit_log VALUES("64","62","75","1","6","OPH","4","2014-07-07 20:14:39");
INSERT INTO audit_log VALUES("65","62","75","1","6","EZH & QH","5","2014-07-07 20:15:56");
INSERT INTO audit_log VALUES("66","62","75","1","6","Dome - Dubai","6","2014-07-07 20:15:56");
INSERT INTO audit_log VALUES("67","62","75","1","6","Ciao Cafe - Vietnam","7","2014-07-07 20:15:56");
INSERT INTO audit_log VALUES("68","62","75","1","6","Melinium Sdn Bhd","8","2014-07-07 20:15:56");
INSERT INTO audit_log VALUES("69","62","75","1","6","Temasek LLC","9","2014-07-07 20:15:56");
INSERT INTO audit_log VALUES("70","62","75","1","6","Grean Ocean Pte Ltd","10","2014-07-07 20:15:56");
INSERT INTO audit_log VALUES("71","62","75","1","6","OPHa","11","2014-07-07 20:25:15");
INSERT INTO audit_log VALUES("72","62","75","1","6","EZH & Qha","12","2014-07-07 20:25:15");
INSERT INTO audit_log VALUES("73","62","75","1","6","Dome - Dubaia","13","2014-07-07 20:25:15");
INSERT INTO audit_log VALUES("74","62","75","1","6","Ciao Cafe - Vietnama","14","2014-07-07 20:25:15");
INSERT INTO audit_log VALUES("75","62","75","1","6","Melinium Sdn Bhda","15","2014-07-07 20:25:15");
INSERT INTO audit_log VALUES("76","62","75","1","6","Temasek LLCa","16","2014-07-07 20:25:15");
INSERT INTO audit_log VALUES("77","62","75","1","6","Grean Ocean Pte Ltda","17","2014-07-07 20:25:15");
INSERT INTO audit_log VALUES("78","62","75","1","6","Indian Bank","18","2014-07-07 20:26:05");
INSERT INTO audit_log VALUES("79","62","75","1","6","Indian Overseas Bank","19","2014-07-07 20:27:22");
INSERT INTO audit_log VALUES("80","62","75","3","6","Gorman Hoa","1","2014-07-07 20:28:11");
INSERT INTO audit_log VALUES("81","62","75","3","6","testa","2","2014-07-07 20:28:22");
INSERT INTO audit_log VALUES("82","62","75","3","6","testb","3","2014-07-07 20:28:30");
INSERT INTO audit_log VALUES("83","62","75","3","6","EZH & Qha","12","2014-07-07 20:28:38");
INSERT INTO audit_log VALUES("84","62","75","3","6","Dome - Dubaia","13","2014-07-07 20:28:46");
INSERT INTO audit_log VALUES("85","62","75","3","6","OPHa","11","2014-07-07 20:28:53");
INSERT INTO audit_log VALUES("86","62","75","3","6","Melinium Sdn Bhda","15","2014-07-07 20:29:02");
INSERT INTO audit_log VALUES("87","62","75","3","6","Grean Ocean Pte Ltda","17","2014-07-07 20:29:11");
INSERT INTO audit_log VALUES("88","62","75","3","6","Temasek LLCa","16","2014-07-07 20:29:19");
INSERT INTO audit_log VALUES("89","62","75","3","6","Ciao Cafe - Vietnama","14","2014-07-07 20:30:11");
INSERT INTO audit_log VALUES("90","62","75","2","6","Indian Bank","18","2014-07-07 20:30:40");
INSERT INTO audit_log VALUES("91","62","75","1","7","Gorman Hoaaa","1","2014-07-07 20:35:41");
INSERT INTO audit_log VALUES("92","62","75","1","7","Gorman Hobsss","2","2014-07-07 20:35:41");
INSERT INTO audit_log VALUES("93","62","75","1","7","Gorman Hobn","3","2014-07-07 20:35:41");
INSERT INTO audit_log VALUES("94","62","75","1","7","Gorman Hobgh","4","2014-07-07 20:35:41");
INSERT INTO audit_log VALUES("95","62","75","3","7","Gorman Hoaaa","1","2014-07-07 20:36:11");
INSERT INTO audit_log VALUES("96","62","75","3","7","Gorman Hobsss","2","2014-07-07 20:36:19");
INSERT INTO audit_log VALUES("97","62","75","3","7","Gorman Hobn","3","2014-07-07 20:37:11");
INSERT INTO audit_log VALUES("98","62","75","3","7","Gorman Hobgh","4","2014-07-07 20:37:25");
INSERT INTO audit_log VALUES("99","62","75","1","7","Natrad Foods","5","2014-07-07 20:37:50");
INSERT INTO audit_log VALUES("100","62","75","1","7","FoodXervices","6","2014-07-07 20:37:50");
INSERT INTO audit_log VALUES("101","62","75","1","7","APB","7","2014-07-07 20:37:50");
INSERT INTO audit_log VALUES("102","62","75","1","7","Magnum Wines","8","2014-07-07 20:37:50");
INSERT INTO audit_log VALUES("103","62","75","1","7","AA Corporation - Vietnam","9","2014-07-07 20:37:50");
INSERT INTO audit_log VALUES("104","62","75","1","7","Bakers & Chef - Italy","10","2014-07-07 20:38:32");
INSERT INTO audit_log VALUES("105","62","75","1","9","13","1","2014-07-07 20:39:17");
INSERT INTO audit_log VALUES("106","62","75","9","13","Logged Out","2","2014-07-07 20:39:22");
INSERT INTO audit_log VALUES("107","62","75","9","12","Logged In","2","2014-07-07 20:40:40");
INSERT INTO audit_log VALUES("108","62","75","1","9","23","2","2014-07-07 20:48:39");
INSERT INTO audit_log VALUES("109","62","75","1","2","Expense","1","2014-07-07 20:51:28");
INSERT INTO audit_log VALUES("110","62","75","6","2","Expense","1","2014-07-07 20:51:28");
INSERT INTO audit_log VALUES("111","62","75","1","8","Rntal Income","62","2014-07-07 20:53:44");
INSERT INTO audit_log VALUES("112","62","75","2","8","Rental Income","62","2014-07-07 20:55:20");
INSERT INTO audit_log VALUES("113","62","75","1","10","Rental - Unit 113B","11","2014-07-07 20:55:34");
INSERT INTO audit_log VALUES("114","62","75","1","3","Invoice","1","2014-07-07 20:57:29");
INSERT INTO audit_log VALUES("115","62","75","6","3","Invoice","1","2014-07-07 20:57:29");
INSERT INTO audit_log VALUES("116","62","75","7","3","Invoice","1","2014-07-07 20:57:36");
INSERT INTO audit_log VALUES("117","62","75","2","3","Invoice","1","2014-07-07 20:57:55");
INSERT INTO audit_log VALUES("118","62","75","6","3","Invoice","1","2014-07-07 20:57:55");
INSERT INTO audit_log VALUES("119","62","75","1","2","Expense","2","2014-07-07 21:02:16");
INSERT INTO audit_log VALUES("120","62","75","6","2","Expense","2","2014-07-07 21:02:16");
INSERT INTO audit_log VALUES("121","62","75","9","12","Logged In","2","2014-07-08 04:30:35");
INSERT INTO audit_log VALUES("122","62","75","7","2","Expense","1","2014-07-08 04:41:14");
INSERT INTO audit_log VALUES("123","62","75","7","2","Expense","2","2014-07-08 04:41:21");
INSERT INTO audit_log VALUES("124","62","75","2","2","Expense","2","2014-07-08 04:41:44");
INSERT INTO audit_log VALUES("125","62","75","6","2","Expense","2","2014-07-08 04:41:44");
INSERT INTO audit_log VALUES("126","62","75","6","2","Expense","1","2014-07-08 04:42:14");
INSERT INTO audit_log VALUES("127","62","75","1","3","Invoice","2","2014-07-08 04:51:12");
INSERT INTO audit_log VALUES("128","62","75","6","3","Invoice","2","2014-07-08 04:51:12");
INSERT INTO audit_log VALUES("129","62","75","1","3","Invoice","3","2014-07-08 04:56:09");
INSERT INTO audit_log VALUES("130","62","75","6","3","Invoice","3","2014-07-08 04:56:09");
INSERT INTO audit_log VALUES("131","62","75","1","3","Invoice","4","2014-07-08 04:58:35");
INSERT INTO audit_log VALUES("132","62","75","6","3","Invoice","4","2014-07-08 04:58:35");
INSERT INTO audit_log VALUES("133","62","75","1","3","Invoice","5","2014-07-08 05:02:34");
INSERT INTO audit_log VALUES("134","62","75","6","3","Invoice","5","2014-07-08 05:02:34");
INSERT INTO audit_log VALUES("135","62","75","1","3","Invoice","6","2014-07-08 05:06:00");
INSERT INTO audit_log VALUES("136","62","75","6","3","Invoice","6","2014-07-08 05:06:00");
INSERT INTO audit_log VALUES("137","62","75","1","3","Invoice","7","2014-07-08 05:10:31");
INSERT INTO audit_log VALUES("138","62","75","6","3","Invoice","7","2014-07-08 05:10:31");
INSERT INTO audit_log VALUES("139","62","75","1","3","Invoice","8","2014-07-08 05:11:02");
INSERT INTO audit_log VALUES("140","62","75","6","3","Invoice","8","2014-07-08 05:11:02");
INSERT INTO audit_log VALUES("141","62","75","7","3","Invoice","3","2014-07-08 05:11:29");
INSERT INTO audit_log VALUES("142","62","75","7","3","Invoice","7","2014-07-08 05:11:34");
INSERT INTO audit_log VALUES("143","62","75","2","3","Invoice","3","2014-07-08 05:11:54");
INSERT INTO audit_log VALUES("144","62","75","6","3","Invoice","3","2014-07-08 05:11:54");
INSERT INTO audit_log VALUES("145","62","75","2","3","Invoice","7","2014-07-08 05:12:16");
INSERT INTO audit_log VALUES("146","62","75","6","3","Invoice","7","2014-07-08 05:12:16");
INSERT INTO audit_log VALUES("147","62","75","1","4","Credit Note","1","2014-07-08 05:18:57");
INSERT INTO audit_log VALUES("148","62","75","6","4","Credit Note","1","2014-07-08 05:18:57");
INSERT INTO audit_log VALUES("149","62","75","1","4","Credit Note","2","2014-07-08 05:23:12");
INSERT INTO audit_log VALUES("150","62","75","6","4","Credit Note","2","2014-07-08 05:23:12");
INSERT INTO audit_log VALUES("151","62","75","1","4","Credit Note","3","2014-07-08 05:25:29");
INSERT INTO audit_log VALUES("152","62","75","6","4","Credit Note","3","2014-07-08 05:25:29");
INSERT INTO audit_log VALUES("153","62","75","1","4","Credit Note","4","2014-07-08 05:27:26");
INSERT INTO audit_log VALUES("154","62","75","6","4","Credit Note","4","2014-07-08 05:27:26");
INSERT INTO audit_log VALUES("155","62","75","9","12","Logged In","2","2014-07-08 08:11:23");
INSERT INTO audit_log VALUES("156","62","75","9","12","Logged In","2","2014-07-08 08:53:59");
INSERT INTO audit_log VALUES("157","62","75","1","11","Invoice","1","2014-07-08 08:56:18");
INSERT INTO audit_log VALUES("158","62","75","7","3","Invoice","1","2014-07-08 08:56:28");
INSERT INTO audit_log VALUES("159","62","75","2","11","Invoice","1","2014-07-08 08:56:44");
INSERT INTO audit_log VALUES("160","62","75","2","3","Invoice","1","2014-07-08 08:56:48");
INSERT INTO audit_log VALUES("161","62","75","6","3","Invoice","1","2014-07-08 08:56:48");
INSERT INTO audit_log VALUES("162","62","75","1","11","Invoice","2","2014-07-08 08:57:25");
INSERT INTO audit_log VALUES("163","62","75","1","11","Invoice","3","2014-07-08 08:58:43");
INSERT INTO audit_log VALUES("164","62","75","7","3","Invoice","3","2014-07-08 09:00:16");
INSERT INTO audit_log VALUES("165","62","75","2","3","Invoice","3","2014-07-08 09:00:29");
INSERT INTO audit_log VALUES("166","62","75","6","3","Invoice","3","2014-07-08 09:00:29");
INSERT INTO audit_log VALUES("167","62","75","2","11","Invoice","3","2014-07-08 09:00:47");
INSERT INTO audit_log VALUES("168","62","75","1","11","Invoice","4","2014-07-08 09:02:45");
INSERT INTO audit_log VALUES("169","62","75","1","11","Invoice","6","2014-07-08 09:04:05");
INSERT INTO audit_log VALUES("170","62","75","7","3","Invoice","7","2014-07-08 09:05:39");
INSERT INTO audit_log VALUES("171","62","75","2","3","Invoice","7","2014-07-08 09:05:50");
INSERT INTO audit_log VALUES("172","62","75","6","3","Invoice","7","2014-07-08 09:05:50");
INSERT INTO audit_log VALUES("173","62","75","1","11","Invoice","7","2014-07-08 09:07:40");
INSERT INTO audit_log VALUES("174","62","75","1","11","Invoice","8","2014-07-08 09:09:41");
INSERT INTO audit_log VALUES("175","62","75","1","1","Income","1","2014-07-08 09:13:00");
INSERT INTO audit_log VALUES("176","62","75","6","1","Income","1","2014-07-08 09:13:00");
INSERT INTO audit_log VALUES("177","62","75","8","1","Income","2","2014-07-08 09:17:39");
INSERT INTO audit_log VALUES("178","62","75","1","11","Income","2","2014-07-08 09:24:54");
INSERT INTO audit_log VALUES("179","62","75","1","2","Expense","3","2014-07-08 10:58:00");
INSERT INTO audit_log VALUES("180","62","75","6","2","Expense","3","2014-07-08 10:58:00");
INSERT INTO audit_log VALUES("181","62","75","1","2","Expense","4","2014-07-08 10:58:56");
INSERT INTO audit_log VALUES("182","62","75","6","2","Expense","4","2014-07-08 10:58:56");
INSERT INTO audit_log VALUES("183","62","75","1","2","Expense","5","2014-07-08 11:00:33");
INSERT INTO audit_log VALUES("184","62","75","6","2","Expense","5","2014-07-08 11:00:33");
INSERT INTO audit_log VALUES("185","62","75","1","2","Expense","6","2014-07-08 11:01:33");
INSERT INTO audit_log VALUES("186","62","75","6","2","Expense","6","2014-07-08 11:01:33");
INSERT INTO audit_log VALUES("187","62","75","1","2","Expense","7","2014-07-08 11:03:37");
INSERT INTO audit_log VALUES("188","62","75","6","2","Expense","7","2014-07-08 11:03:37");
INSERT INTO audit_log VALUES("189","62","75","1","2","Expense","8","2014-07-08 11:04:23");
INSERT INTO audit_log VALUES("190","62","75","6","2","Expense","8","2014-07-08 11:04:23");
INSERT INTO audit_log VALUES("191","62","75","1","2","Expense","9","2014-07-08 11:04:59");
INSERT INTO audit_log VALUES("192","62","75","6","2","Expense","9","2014-07-08 11:04:59");
INSERT INTO audit_log VALUES("193","62","75","1","2","Expense","10","2014-07-08 11:06:06");
INSERT INTO audit_log VALUES("194","62","75","6","2","Expense","10","2014-07-08 11:06:06");
INSERT INTO audit_log VALUES("195","62","75","1","8","Rent Payable","63","2014-07-08 11:17:49");
INSERT INTO audit_log VALUES("196","62","75","1","7","UMM Technologies","11","2014-07-08 11:19:17");
INSERT INTO audit_log VALUES("197","62","75","1","7","MCST 835","12","2014-07-08 11:19:17");
INSERT INTO audit_log VALUES("198","62","75","1","7","ID Ranger","13","2014-07-08 11:19:17");
INSERT INTO audit_log VALUES("199","62","75","1","7","Evergreen Cleaning Services","14","2014-07-08 11:19:17");
INSERT INTO audit_log VALUES("200","62","75","7","2","Expense","11","2014-07-08 11:31:24");
INSERT INTO audit_log VALUES("201","62","75","2","2","Expense","11","2014-07-08 11:31:40");
INSERT INTO audit_log VALUES("202","62","75","6","2","Expense","11","2014-07-08 11:31:40");
INSERT INTO audit_log VALUES("203","62","75","1","8","Renovation in Progress","64","2014-07-08 11:33:20");
INSERT INTO audit_log VALUES("204","62","75","8","2","Expense","13","2014-07-08 11:41:09");
INSERT INTO audit_log VALUES("205","62","75","2","2","Expense","13","2014-07-08 11:41:39");
INSERT INTO audit_log VALUES("206","62","75","6","2","Expense","13","2014-07-08 11:41:39");
INSERT INTO audit_log VALUES("207","62","75","7","2","Expense","11","2014-07-08 11:41:57");
INSERT INTO audit_log VALUES("208","62","75","7","2","Expense","12","2014-07-08 11:42:01");
INSERT INTO audit_log VALUES("209","62","75","2","11","Expense","11","2014-07-08 11:42:15");
INSERT INTO audit_log VALUES("210","62","75","2","11","Expense","12","2014-07-08 11:42:34");
INSERT INTO audit_log VALUES("211","62","75","2","2","Expense","12","2014-07-08 11:42:37");
INSERT INTO audit_log VALUES("212","62","75","6","2","Expense","12","2014-07-08 11:42:37");
INSERT INTO audit_log VALUES("213","62","75","6","2","Expense","11","2014-07-08 11:42:43");
INSERT INTO audit_log VALUES("214","62","75","1","8","Warehouse Rental","65","2014-07-08 11:43:50");
INSERT INTO audit_log VALUES("215","62","75","7","2","Expense","14","2014-07-08 11:47:19");
INSERT INTO audit_log VALUES("216","62","75","2","11","Expense","14","2014-07-08 11:47:45");
INSERT INTO audit_log VALUES("217","62","75","2","2","Expense","14","2014-07-08 11:51:33");
INSERT INTO audit_log VALUES("218","62","75","6","2","Expense","14","2014-07-08 11:51:33");
INSERT INTO audit_log VALUES("219","62","75","1","11","Expense","1","2014-07-08 11:59:54");
INSERT INTO audit_log VALUES("220","62","75","7","2","Expense","1","2014-07-08 12:01:08");
INSERT INTO audit_log VALUES("221","62","75","2","2","Expense","1","2014-07-08 12:01:34");
INSERT INTO audit_log VALUES("222","62","75","6","2","Expense","1","2014-07-08 12:01:34");
INSERT INTO audit_log VALUES("223","62","75","2","11","Expense","1","2014-07-08 12:02:03");
INSERT INTO audit_log VALUES("224","62","75","1","11","Expense","2","2014-07-08 12:04:45");
INSERT INTO audit_log VALUES("225","62","75","1","11","Expense","3","2014-07-08 12:05:50");
INSERT INTO audit_log VALUES("226","62","75","1","11","Expense","4","2014-07-08 12:06:25");
INSERT INTO audit_log VALUES("227","62","75","1","11","Expense","5","2014-07-08 12:07:50");
INSERT INTO audit_log VALUES("228","62","75","1","11","Expense","6","2014-07-08 12:09:47");
INSERT INTO audit_log VALUES("229","62","75","1","11","Expense","7","2014-07-08 12:32:05");
INSERT INTO audit_log VALUES("230","62","75","1","11","Expense","8","2014-07-08 12:32:48");
INSERT INTO audit_log VALUES("231","62","1","1","2","Expense","16","2014-07-08 12:34:30");
INSERT INTO audit_log VALUES("232","62","75","1","11","Expense","9","2014-07-08 12:45:41");
INSERT INTO audit_log VALUES("233","62","75","1","11","Expense","10","2014-07-08 12:48:51");
INSERT INTO audit_log VALUES("234","62","75","3","2","Expense","18","2014-07-08 12:50:41");
INSERT INTO audit_log VALUES("235","62","75","3","2","Expense","16","2014-07-08 12:50:50");
INSERT INTO audit_log VALUES("236","62","1","1","2","Expense","19","2014-07-08 12:51:11");
INSERT INTO audit_log VALUES("237","62","75","1","5","Jounral Entry","1","2014-07-08 12:54:50");
INSERT INTO audit_log VALUES("238","62","75","6","5","Jounral Entry","1","2014-07-08 12:54:50");
INSERT INTO audit_log VALUES("239","62","75","3","2","Expense","19","2014-07-08 12:55:09");
INSERT INTO audit_log VALUES("240","62","75","1","2","Expense","20","2014-07-08 12:57:05");
INSERT INTO audit_log VALUES("241","62","75","6","2","Expense","20","2014-07-08 12:57:05");
INSERT INTO audit_log VALUES("242","62","75","7","2","Expense","17","2014-07-08 12:58:18");
INSERT INTO audit_log VALUES("243","62","75","7","2","Expense","15","2014-07-08 12:58:19");
INSERT INTO audit_log VALUES("244","62","75","2","2","Expense","17","2014-07-08 12:58:35");
INSERT INTO audit_log VALUES("245","62","75","6","2","Expense","17","2014-07-08 12:58:35");
INSERT INTO audit_log VALUES("246","62","75","2","11","Expense","17","2014-07-08 12:58:48");
INSERT INTO audit_log VALUES("247","62","75","2","2","Expense","15","2014-07-08 12:59:42");
INSERT INTO audit_log VALUES("248","62","75","6","2","Expense","15","2014-07-08 12:59:42");
INSERT INTO audit_log VALUES("249","62","75","2","11","Expense","15","2014-07-08 12:59:52");
INSERT INTO audit_log VALUES("250","62","75","7","3","Invoice","7","2014-07-08 13:04:17");
INSERT INTO audit_log VALUES("251","62","75","2","11","Invoice","7","2014-07-08 13:04:52");
INSERT INTO audit_log VALUES("252","62","75","2","3","Invoice","7","2014-07-08 13:04:57");
INSERT INTO audit_log VALUES("253","62","75","6","3","Invoice","7","2014-07-08 13:04:57");
INSERT INTO audit_log VALUES("254","62","75","1","8","Depreciation","66","2014-07-08 13:23:29");
INSERT INTO audit_log VALUES("255","62","75","1","5","Jounral Entry","2","2014-07-08 13:23:56");
INSERT INTO audit_log VALUES("256","62","75","6","5","Jounral Entry","2","2014-07-08 13:23:56");
INSERT INTO audit_log VALUES("257","62","75","9","12","Logged In","2","2014-07-08 14:14:01");
INSERT INTO audit_log VALUES("258","62","75","1","5","Jounral Entry","3","2014-07-08 14:14:53");
INSERT INTO audit_log VALUES("259","62","75","6","5","Jounral Entry","3","2014-07-08 14:14:53");
INSERT INTO audit_log VALUES("260","62","75","7","5","Jounral Entry","1","2014-07-08 14:27:35");
INSERT INTO audit_log VALUES("261","62","75","2","5","Jounral Entry","1","2014-07-08 14:27:54");
INSERT INTO audit_log VALUES("262","62","75","6","5","Jounral Entry","1","2014-07-08 14:27:54");
INSERT INTO audit_log VALUES("263","62","75","7","5","Jounral Entry","1","2014-07-08 14:31:49");
INSERT INTO audit_log VALUES("264","62","75","2","5","Jounral Entry","1","2014-07-08 14:32:17");
INSERT INTO audit_log VALUES("265","62","75","2","5","Jounral Entry","1","2014-07-08 14:32:33");
INSERT INTO audit_log VALUES("266","62","75","6","5","Jounral Entry","1","2014-07-08 14:32:33");
INSERT INTO audit_log VALUES("267","62","1","7","5","Jounral Entry","1","2014-07-08 14:35:15");
INSERT INTO audit_log VALUES("268","62","1","2","5","Jounral Entry","1","2014-07-08 14:36:35");
INSERT INTO audit_log VALUES("269","62","75","6","5","Jounral Entry","1","2014-07-08 14:38:45");
INSERT INTO audit_log VALUES("270","62","75","7","5","Jounral Entry","1","2014-07-08 14:39:05");
INSERT INTO audit_log VALUES("271","62","75","2","5","Jounral Entry","1","2014-07-08 14:39:45");
INSERT INTO audit_log VALUES("272","62","75","6","5","Jounral Entry","1","2014-07-08 14:39:45");
INSERT INTO audit_log VALUES("273","62","75","7","2","Expense","1","2014-07-08 16:17:01");
INSERT INTO audit_log VALUES("274","62","75","2","2","Expense","1","2014-07-08 16:17:22");
INSERT INTO audit_log VALUES("275","62","75","6","2","Expense","1","2014-07-08 16:17:22");
INSERT INTO audit_log VALUES("276","62","75","2","11","Expense","1","2014-07-08 16:17:56");
INSERT INTO audit_log VALUES("277","62","75","7","2","Expense","1","2014-07-08 16:18:32");
INSERT INTO audit_log VALUES("278","62","75","2","2","Expense","1","2014-07-08 16:20:31");
INSERT INTO audit_log VALUES("279","62","75","6","2","Expense","1","2014-07-08 16:20:31");
INSERT INTO audit_log VALUES("280","62","75","3","11","Expense","1","2014-07-08 16:20:37");
INSERT INTO audit_log VALUES("281","62","75","7","2","Expense","2","2014-07-08 16:21:30");
INSERT INTO audit_log VALUES("282","62","75","1","11","Expense","1","2014-07-08 16:22:05");
INSERT INTO audit_log VALUES("283","62","75","2","11","Expense","2","2014-07-08 16:22:51");
INSERT INTO audit_log VALUES("284","62","75","6","2","Expense","2","2014-07-08 16:24:48");
INSERT INTO audit_log VALUES("285","62","75","9","12","Logged In","2","2014-07-08 17:52:13");
INSERT INTO audit_log VALUES("286","62","75","9","12","Logged In","2","2014-07-08 18:19:13");
INSERT INTO audit_log VALUES("287","62","75","7","2","Expense","20","2014-07-08 18:19:51");
INSERT INTO audit_log VALUES("288","62","75","7","2","Expense","2","2014-07-08 18:20:08");
INSERT INTO audit_log VALUES("289","62","75","6","2","Expense","20","2014-07-08 18:20:19");
INSERT INTO audit_log VALUES("290","62","75","7","2","Expense","1","2014-07-08 18:20:36");
INSERT INTO audit_log VALUES("291","62","75","2","2","Expense","1","2014-07-08 18:26:32");
INSERT INTO audit_log VALUES("292","62","75","6","2","Expense","1","2014-07-08 18:26:32");
INSERT INTO audit_log VALUES("293","62","75","2","11","Expense","1","2014-07-08 18:27:10");
INSERT INTO audit_log VALUES("294","62","75","2","2","Expense","2","2014-07-08 18:28:36");
INSERT INTO audit_log VALUES("295","62","75","6","2","Expense","2","2014-07-08 18:28:36");
INSERT INTO audit_log VALUES("296","62","75","2","11","Expense","2","2014-07-08 18:29:15");
INSERT INTO audit_log VALUES("297","62","75","7","3","Invoice","7","2014-07-08 18:30:02");
INSERT INTO audit_log VALUES("298","62","75","2","3","Invoice","7","2014-07-08 18:30:58");
INSERT INTO audit_log VALUES("299","62","75","6","3","Invoice","7","2014-07-08 18:30:58");
INSERT INTO audit_log VALUES("300","62","75","7","3","Invoice","7","2014-07-08 18:31:25");
INSERT INTO audit_log VALUES("301","62","75","2","3","Invoice","7","2014-07-08 18:31:49");
INSERT INTO audit_log VALUES("302","62","75","6","3","Invoice","7","2014-07-08 18:31:49");
INSERT INTO audit_log VALUES("303","62","75","2","11","Invoice","7","2014-07-08 18:32:33");
INSERT INTO audit_log VALUES("304","62","75","1","5","Jounral Entry","4","2014-07-08 18:56:39");
INSERT INTO audit_log VALUES("305","62","75","6","5","Jounral Entry","4","2014-07-08 18:56:39");
INSERT INTO audit_log VALUES("306","62","75","9","13","Logged Out","2","2014-07-08 19:19:28");
INSERT INTO audit_log VALUES("307","62","75","9","12","Logged In","2","2014-07-08 19:21:06");
INSERT INTO audit_log VALUES("308","62","75","9","12","Logged In","2","2014-07-08 19:33:00");
INSERT INTO audit_log VALUES("309","62","75","9","12","Logged In","2","2014-07-08 19:39:21");
INSERT INTO audit_log VALUES("310","62","75","7","5","Jounral Entry","1","2014-07-08 19:43:55");
INSERT INTO audit_log VALUES("311","62","75","2","5","Jounral Entry","1","2014-07-08 19:44:44");
INSERT INTO audit_log VALUES("312","62","75","6","5","Jounral Entry","1","2014-07-08 19:44:44");
INSERT INTO audit_log VALUES("313","62","75","7","5","Jounral Entry","1","2014-07-08 19:47:33");
INSERT INTO audit_log VALUES("314","62","75","2","5","Jounral Entry","1","2014-07-08 19:48:21");
INSERT INTO audit_log VALUES("315","62","75","6","5","Jounral Entry","1","2014-07-08 19:48:21");
INSERT INTO audit_log VALUES("316","62","1","1","6","Gorman Ho","20","2014-07-08 20:53:07");
INSERT INTO audit_log VALUES("317","62","1","1","6","test","21","2014-07-08 20:53:07");
INSERT INTO audit_log VALUES("318","62","1","1","6","Gorman Ho","22","2014-07-08 20:54:02");
INSERT INTO audit_log VALUES("319","62","1","1","6","test","23","2014-07-08 20:54:02");
INSERT INTO audit_log VALUES("320","62","1","1","6","Gorman Ho","24","2014-07-08 20:56:23");
INSERT INTO audit_log VALUES("321","62","1","1","6","test","25","2014-07-08 20:56:23");
INSERT INTO audit_log VALUES("322","62","1","1","6","Gorman Ho","26","2014-07-08 20:59:39");
INSERT INTO audit_log VALUES("323","62","1","1","6","test","27","2014-07-08 20:59:39");
INSERT INTO audit_log VALUES("324","62","1","1","6","Gorman Ho","28","2014-07-08 21:11:04");
INSERT INTO audit_log VALUES("325","62","1","1","6","test","29","2014-07-08 21:11:04");
INSERT INTO audit_log VALUES("326","62","1","1","6","Gorman Ho","30","2014-07-08 21:13:44");
INSERT INTO audit_log VALUES("327","62","1","1","7","Jhjhgjg","15","2014-07-08 21:19:31");
INSERT INTO audit_log VALUES("328","62","1","1","2","Expense","21","2014-07-08 22:58:16");
INSERT INTO audit_log VALUES("329","62","1","1","2","Expense","22","2014-07-08 23:03:02");
INSERT INTO audit_log VALUES("330","62","1","1","2","Expense","23","2014-07-08 23:10:17");
INSERT INTO audit_log VALUES("331","62","1","1","2","Expense","24","2014-07-08 23:14:07");
INSERT INTO audit_log VALUES("332","62","1","1","3","Invoice","9","2014-07-08 23:56:19");
INSERT INTO audit_log VALUES("333","62","1","1","3","Invoice","10","2014-07-08 23:59:28");
INSERT INTO audit_log VALUES("334","62","1","1","3","Invoice","11","2014-07-09 00:02:29");
INSERT INTO audit_log VALUES("335","62","1","1","3","Invoice","12","2014-07-09 00:05:05");
INSERT INTO audit_log VALUES("336","62","1","1","3","Invoice","13","2014-07-09 00:07:31");
INSERT INTO audit_log VALUES("337","62","1","1","3","Invoice","14","2014-07-09 00:07:32");
INSERT INTO audit_log VALUES("338","62","1","1","1","Income","3","2014-07-09 00:29:16");
INSERT INTO audit_log VALUES("339","62","1","1","10","testid","12","2014-07-09 01:03:53");
INSERT INTO audit_log VALUES("340","62","1","7","3","Invoice","4","2014-07-09 01:30:39");
INSERT INTO audit_log VALUES("341","62","1","6","3","Invoice","4","2014-07-09 01:31:26");
INSERT INTO audit_log VALUES("342","62","1","6","3","Invoice","4","2014-07-09 01:31:27");
INSERT INTO audit_log VALUES("343","62","75","9","12","Logged In","2","2014-07-09 07:57:10");
INSERT INTO audit_log VALUES("344","62","75","1","8","Test Income","67","2014-07-09 08:06:22");
INSERT INTO audit_log VALUES("345","62","75","1","10","Test 1","13","2014-07-09 08:06:37");
INSERT INTO audit_log VALUES("346","62","75","9","12","Logged In","2","2014-07-09 08:15:44");
INSERT INTO audit_log VALUES("347","62","75","1","3","Invoice","15","2014-07-09 08:31:19");
INSERT INTO audit_log VALUES("348","62","75","1","3","Invoice","16","2014-07-09 08:32:22");
INSERT INTO audit_log VALUES("349","62","75","1","3","Invoice","17","2014-07-09 08:32:27");
INSERT INTO audit_log VALUES("350","62","75","1","3","Invoice","18","2014-07-09 08:40:39");
INSERT INTO audit_log VALUES("351","62","75","1","3","Invoice","19","2014-07-09 08:40:44");
INSERT INTO audit_log VALUES("352","62","75","1","2","Expense","25","2014-07-09 08:42:15");
INSERT INTO audit_log VALUES("353","62","75","1","2","Expense","26","2014-07-09 08:42:15");
INSERT INTO audit_log VALUES("354","62","75","1","2","Expense","27","2014-07-09 08:44:33");
INSERT INTO audit_log VALUES("355","62","75","1","2","Expense","28","2014-07-09 08:44:33");
INSERT INTO audit_log VALUES("356","62","75","1","2","Expense","29","2014-07-09 08:46:03");
INSERT INTO audit_log VALUES("357","62","75","9","12","Logged In","2","2014-07-09 09:00:55");
INSERT INTO audit_log VALUES("358","62","75","9","12","Logged In","2","2014-07-09 10:10:13");
INSERT INTO audit_log VALUES("359","62","75","7","5","Jounral Entry","1","2014-07-09 10:10:20");
INSERT INTO audit_log VALUES("360","62","75","2","5","Jounral Entry","1","2014-07-09 10:10:49");
INSERT INTO audit_log VALUES("361","62","75","6","5","Jounral Entry","1","2014-07-09 10:10:49");
INSERT INTO audit_log VALUES("362","62","75","9","13","Logged Out","2","2014-07-09 10:14:11");
INSERT INTO audit_log VALUES("363","62","75","9","12","Logged In","2","2014-07-09 11:11:54");
INSERT INTO audit_log VALUES("364","62","75","9","13","Logged Out","2","2014-07-09 11:51:38");
INSERT INTO audit_log VALUES("365","62","75","9","12","Logged In","2","2014-07-09 11:55:52");
INSERT INTO audit_log VALUES("366","62","75","9","13","Logged Out","2","2014-07-09 11:59:23");
INSERT INTO audit_log VALUES("367","62","75","9","12","Logged In","2","2014-07-09 12:00:55");
INSERT INTO audit_log VALUES("368","62","75","9","13","Logged Out","2","2014-07-09 12:01:44");
INSERT INTO audit_log VALUES("369","62","75","9","12","Logged In","2","2014-07-09 12:08:40");
INSERT INTO audit_log VALUES("370","62","75","9","13","Logged Out","2","2014-07-09 12:09:42");
INSERT INTO audit_log VALUES("371","62","75","9","12","Logged In","2","2014-07-09 13:01:30");
INSERT INTO audit_log VALUES("372","62","75","3","3","Invoice","15","2014-07-09 13:01:42");
INSERT INTO audit_log VALUES("373","62","75","3","3","Invoice","16","2014-07-09 13:01:47");
INSERT INTO audit_log VALUES("374","62","75","3","3","Invoice","17","2014-07-09 13:01:54");
INSERT INTO audit_log VALUES("375","62","75","3","3","Invoice","18","2014-07-09 13:02:00");
INSERT INTO audit_log VALUES("376","62","75","3","3","Invoice","19","2014-07-09 13:02:04");
INSERT INTO audit_log VALUES("377","62","75","3","2","Expense","25","2014-07-09 13:02:24");
INSERT INTO audit_log VALUES("378","62","75","3","2","Expense","26","2014-07-09 13:02:39");
INSERT INTO audit_log VALUES("379","62","75","3","2","Expense","27","2014-07-09 13:02:45");
INSERT INTO audit_log VALUES("380","62","75","3","2","Expense","28","2014-07-09 13:02:52");
INSERT INTO audit_log VALUES("381","62","75","3","2","Expense","29","2014-07-09 13:02:59");
INSERT INTO audit_log VALUES("382","62","75","3","5","Jounral Entry","4","2014-07-09 13:03:16");
INSERT INTO audit_log VALUES("383","62","75","6","2","Expense","16","2014-07-09 13:13:53");
INSERT INTO audit_log VALUES("384","62","75","6","2","Expense","18","2014-07-09 13:13:53");
INSERT INTO audit_log VALUES("385","62","75","6","2","Expense","19","2014-07-09 13:13:53");
INSERT INTO audit_log VALUES("386","62","75","9","13","Logged Out","2","2014-07-09 13:16:32");
INSERT INTO audit_log VALUES("387","62","75","9","12","Logged In","2","2014-07-09 13:31:36");
INSERT INTO audit_log VALUES("388","62","75","7","4","Credit Note","2","2014-07-09 13:32:46");
INSERT INTO audit_log VALUES("389","62","75","6","4","Credit Note","2","2014-07-09 13:32:53");
INSERT INTO audit_log VALUES("390","62","75","7","2","Expense","9","2014-07-09 14:04:53");
INSERT INTO audit_log VALUES("391","62","75","7","2","Expense","11","2014-07-09 14:04:57");
INSERT INTO audit_log VALUES("392","62","75","6","2","Expense","9","2014-07-09 14:05:09");
INSERT INTO audit_log VALUES("393","62","75","6","2","Expense","11","2014-07-09 14:05:14");
INSERT INTO audit_log VALUES("394","62","75","9","12","Logged In","2","2014-07-09 14:55:28");
INSERT INTO audit_log VALUES("395","62","75","7","3","Invoice","7","2014-07-09 14:56:08");
INSERT INTO audit_log VALUES("396","62","75","6","3","Invoice","7","2014-07-09 14:56:27");
INSERT INTO audit_log VALUES("397","62","1","1","3","Invoice","20","2014-07-09 16:59:58");
INSERT INTO audit_log VALUES("398","62","1","3","3","Invoice","20","2014-07-09 17:00:37");
INSERT INTO audit_log VALUES("399","62","1","8","3","Invoice","21","2014-07-09 17:00:51");
INSERT INTO audit_log VALUES("400","62","1","8","3","Invoice","1","2014-07-09 17:01:00");
INSERT INTO audit_log VALUES("401","62","1","3","3","Invoice","21","2014-07-09 17:01:08");
INSERT INTO audit_log VALUES("402","62","75","9","12","Logged In","2","2014-07-09 19:22:40");
INSERT INTO audit_log VALUES("403","62","75","9","12","Logged In","2","2014-07-09 20:21:12");
INSERT INTO audit_log VALUES("404","62","75","9","12","Logged In","2","2014-07-09 20:26:03");
INSERT INTO audit_log VALUES("405","62","75","7","2","Expense","5","2014-07-09 21:01:04");
INSERT INTO audit_log VALUES("406","62","75","6","2","Expense","5","2014-07-09 21:01:23");
INSERT INTO audit_log VALUES("407","62","75","9","12","Logged In","2","2014-07-09 21:52:45");
INSERT INTO audit_log VALUES("408","62","75","9","12","Logged In","2","2014-07-10 07:57:03");
INSERT INTO audit_log VALUES("409","62","75","9","13","Logged Out","2","2014-07-10 07:57:08");
INSERT INTO audit_log VALUES("410","62","75","9","12","Logged In","2","2014-07-10 08:16:03");
INSERT INTO audit_log VALUES("411","62","75","9","12","Logged In","2","2014-07-10 10:21:13");
INSERT INTO audit_log VALUES("412","62","75","9","12","Logged In","2","2014-07-10 10:52:50");
INSERT INTO audit_log VALUES("413","62","75","9","12","Logged In","2","2014-07-10 12:30:52");
INSERT INTO audit_log VALUES("414","62","75","9","12","Logged In","2","2014-07-10 13:32:01");
INSERT INTO audit_log VALUES("415","62","75","9","13","Logged Out","2","2014-07-10 13:38:55");
INSERT INTO audit_log VALUES("416","62","75","9","12","Logged In","2","2014-07-10 13:54:26");
INSERT INTO audit_log VALUES("417","62","75","9","12","Logged In","2","2014-07-10 14:17:51");
INSERT INTO audit_log VALUES("418","62","75","9","12","Logged In","2","2014-07-10 16:14:11");
INSERT INTO audit_log VALUES("419","62","75","9","13","Logged Out","2","2014-07-10 16:21:30");
INSERT INTO audit_log VALUES("420","62","75","9","12","Logged In","2","2014-07-10 16:21:53");
INSERT INTO audit_log VALUES("421","62","75","7","2","Expense","4","2014-07-10 16:23:18");
INSERT INTO audit_log VALUES("422","62","75","6","2","Expense","4","2014-07-10 16:23:53");
INSERT INTO audit_log VALUES("423","62","75","9","12","Logged In","2","2014-07-10 17:54:04");
INSERT INTO audit_log VALUES("424","62","75","9","12","Logged In","2","2014-07-10 19:13:21");
INSERT INTO audit_log VALUES("425","62","1","1","3","Invoice","22","2014-07-10 19:15:27");
INSERT INTO audit_log VALUES("426","62","1","1","3","Invoice","23","2014-07-10 19:15:27");
INSERT INTO audit_log VALUES("427","62","1","3","3","Invoice","22","2014-07-10 19:16:22");
INSERT INTO audit_log VALUES("428","62","1","3","3","Invoice","23","2014-07-10 19:16:30");
INSERT INTO audit_log VALUES("429","62","1","1","3","Invoice","24","2014-07-10 19:17:30");
INSERT INTO audit_log VALUES("430","62","1","3","3","Invoice","24","2014-07-10 19:17:55");
INSERT INTO audit_log VALUES("431","62","1","1","2","Expense","30","2014-07-10 19:42:25");
INSERT INTO audit_log VALUES("432","62","1","1","2","Expense","31","2014-07-10 19:42:25");
INSERT INTO audit_log VALUES("433","62","1","1","2","Expense","32","2014-07-10 19:46:12");
INSERT INTO audit_log VALUES("434","62","1","3","2","Expense","32","2014-07-10 19:46:55");
INSERT INTO audit_log VALUES("435","62","1","8","3","Invoice","25","2014-07-10 19:54:25");
INSERT INTO audit_log VALUES("436","62","1","3","3","Invoice","25","2014-07-10 19:54:56");
INSERT INTO audit_log VALUES("437","62","1","1","3","Invoice","26","2014-07-10 19:55:40");
INSERT INTO audit_log VALUES("438","62","1","3","3","Invoice","26","2014-07-10 19:57:32");
INSERT INTO audit_log VALUES("439","62","1","8","3","Invoice","27","2014-07-10 20:00:52");
INSERT INTO audit_log VALUES("440","62","1","3","3","Invoice","27","2014-07-10 20:01:10");
INSERT INTO audit_log VALUES("441","62","1","8","2","Expense","33","2014-07-10 20:04:45");
INSERT INTO audit_log VALUES("442","62","1","3","2","Expense","33","2014-07-10 20:05:10");
INSERT INTO audit_log VALUES("443","62","1","8","2","Expense","34","2014-07-10 20:07:45");
INSERT INTO audit_log VALUES("444","62","1","3","2","Expense","34","2014-07-10 20:08:05");
INSERT INTO audit_log VALUES("445","62","1","8","1","Income","4","2014-07-10 20:10:48");
INSERT INTO audit_log VALUES("446","62","1","3","1","Income","4","2014-07-10 20:11:04");
INSERT INTO audit_log VALUES("447","62","1","7","1","Income","2","2014-07-10 20:11:07");
INSERT INTO audit_log VALUES("448","62","1","6","1","Income","2","2014-07-10 20:11:24");
INSERT INTO audit_log VALUES("449","62","1","8","1","Income","5","2014-07-10 20:11:34");
INSERT INTO audit_log VALUES("450","62","1","3","1","Income","5","2014-07-10 20:11:46");
INSERT INTO audit_log VALUES("451","62","75","9","12","Logged In","2","2014-07-10 22:18:07");
INSERT INTO audit_log VALUES("452","62","75","9","12","Logged In","2","2014-07-11 05:00:19");
INSERT INTO audit_log VALUES("453","62","75","9","12","Logged In","2","2014-07-11 05:41:25");
INSERT INTO audit_log VALUES("454","62","75","9","12","Logged In","2","2014-07-11 10:46:00");
INSERT INTO audit_log VALUES("455","62","75","9","12","Logged In","2","2014-07-11 11:32:25");
INSERT INTO audit_log VALUES("456","62","75","9","13","Logged Out","2","2014-07-11 11:39:34");
INSERT INTO audit_log VALUES("457","62","75","9","12","Logged In","2","2014-07-11 11:46:49");
INSERT INTO audit_log VALUES("458","62","75","9","12","Logged In","2","2014-07-11 13:17:44");
INSERT INTO audit_log VALUES("459","62","75","9","12","Logged In","2","2014-07-11 14:48:12");
INSERT INTO audit_log VALUES("460","62","75","9","12","Logged In","2","2014-07-11 15:23:18");
INSERT INTO audit_log VALUES("461","62","81","9","12","Logged In","2","2014-07-11 20:27:37");
INSERT INTO audit_log VALUES("462","62","81","7","1","Income","2","2014-07-11 20:31:33");
INSERT INTO audit_log VALUES("463","62","81","2","1","Income","2","2014-07-11 20:31:54");
INSERT INTO audit_log VALUES("464","62","81","1","10","Test Product","14","2014-07-11 20:46:05");
INSERT INTO audit_log VALUES("465","62","81","7","2","Expense","17","2014-07-11 21:06:03");
INSERT INTO audit_log VALUES("466","62","81","7","5","Jounral Entry","2","2014-07-11 21:07:19");
INSERT INTO audit_log VALUES("467","62","81","6","5","Jounral Entry","2","2014-07-11 21:07:52");
INSERT INTO audit_log VALUES("468","62","81","9","13","Logged Out","2","2014-07-11 21:29:11");
INSERT INTO audit_log VALUES("469","62","81","9","12","Logged In","2","2014-07-11 21:41:47");
INSERT INTO audit_log VALUES("470","62","81","9","12","Logged In","2","2014-07-12 08:30:28");
INSERT INTO audit_log VALUES("471","62","81","9","13","Logged Out","2","2014-07-12 08:31:01");
INSERT INTO audit_log VALUES("472","62","75","9","12","Logged In","2","2014-07-12 11:03:48");
INSERT INTO audit_log VALUES("473","62","75","9","13","Logged Out","2","2014-07-12 11:03:53");
INSERT INTO audit_log VALUES("474","62","75","9","12","Logged In","2","2014-07-12 19:22:55");
INSERT INTO audit_log VALUES("475","62","81","9","12","Logged In","2","2014-07-12 19:37:13");
INSERT INTO audit_log VALUES("476","62","81","8","3","Invoice","28","2014-07-12 19:37:28");
INSERT INTO audit_log VALUES("477","62","81","9","13","Logged Out","2","2014-07-12 19:38:49");
INSERT INTO audit_log VALUES("478","62","81","9","12","Logged In","2","2014-07-12 19:42:18");
INSERT INTO audit_log VALUES("479","62","81","7","3","Invoice","6","2014-07-12 19:43:07");
INSERT INTO audit_log VALUES("480","62","81","2","3","Invoice","6","2014-07-12 19:43:18");





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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO credit VALUES("1","62","CR-0000000001","2","4","SGD","0.00000","2014-04-15","Order Modified","0","1","2","1","2014-07-08 05:18:57","0000-00-00 00:00:00");
INSERT INTO credit VALUES("2","62","CR-0000000002","4","5","SGD","0.00000","2014-04-30","Order Changed","0","1","2","1","2014-07-08 05:23:12","2014-07-09 13:32:53");
INSERT INTO credit VALUES("3","62","CR-0000000003","5","4","SGD","0.00000","2014-05-05","Order Changed","0","1","2","1","2014-07-08 05:25:29","0000-00-00 00:00:00");
INSERT INTO credit VALUES("4","62","CR-0000000004","7","6","USD","1.24640","2014-04-15","Order Changed","0","1","2","1","2014-07-08 05:27:26","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

INSERT INTO credit_product_list VALUES("1","1","P8","2","20","25.00","0.00","1","7.00","2014-07-08 05:18:57","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("2","1","Whisky","8","25","12.00","0.00","1","7.00","2014-07-08 05:18:57","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("3","1","SC50","7","1","50.00","0.00","1","7.00","2014-07-08 05:18:57","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("4","2","Whisky","8","100","12.00","0.00","1","7.00","2014-07-08 05:23:12","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("5","2","Wine","9","100","10.00","0.00","1","7.00","2014-07-08 05:23:12","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("6","2","SC100","6","1","100.00","25.00","1","7.00","2014-07-08 05:23:12","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("7","3","PA01","3","2","20.00","0.00","1","7.00","2014-07-08 05:25:29","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("8","3","PA02","4","2","30.00","0.00","1","7.00","2014-07-08 05:25:29","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("9","3","P12","1","2","35.00","0.00","1","7.00","2014-07-08 05:25:29","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("10","3","P8","2","2","25.00","0.00","1","7.00","2014-07-08 05:25:29","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("11","3","Whisky","8","2","12.00","0.00","1","7.00","2014-07-08 05:25:29","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("12","3","Wine","9","2","10.00","0.00","1","7.00","2014-07-08 05:25:29","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("13","3","SC100","6","2","100.00","100.00","1","7.00","2014-07-08 05:25:29","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("14","3","SC50","7","2","50.00","50.00","1","7.00","2014-07-08 05:25:29","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("15","4","HMP - USD","10","100","50.00","400.00","1","7.00","2014-07-08 05:27:26","0000-00-00 00:00:00");
INSERT INTO credit_product_list VALUES("16","4","PD - USD","5","100","10.00","100.00","1","7.00","2014-07-08 05:27:26","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

INSERT INTO customers VALUES("4","62","CUS-0000000004","OPH","16 Sandilands Road","","199405558M-PTE-04","69453482","6945 3483","Singapore","Singapore","SG","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","3","","1","2014-07-07 20:14:39","0000-00-00 00:00:00");
INSERT INTO customers VALUES("5","62","CUS-0000000005","EZH & QH","123 Address Road","","199405558M-PTE-05","69453483","","Singapore","Singapore","SG","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","3","","1","2014-07-07 20:15:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("6","62","CUS-0000000006","Dome - Dubai","123 Address Road","","199405558M-PTE-06","69453484","6945 3483","Dubai","Dubai","AE","http://www.fafflesexcursions.com.sg","","","546080","0000-00-00","3","","1","2014-07-07 20:15:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("7","62","CUS-0000000007","Ciao Cafe - Vietnam","123 Address Road","","199405558M-PTE-07","69453485","6945 3483","Ho Chi Minh","Saigon","VN","","gormanho@singnet.com.sg","","546080","0000-00-00","3","","1","2014-07-07 20:15:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("8","62","CUS-0000000008","Melinium Sdn Bhd","123 Address Road","","199405558M-PTE-08","69453486","6945 3483","KL","Selangor","MY","","gormanho@singnet.com.sg","","546080","0000-00-00","4","","1","2014-07-07 20:15:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("9","62","CUS-0000000009","Temasek LLC","123 Address Road","","199405558M-PTE-09","69453487","6945 3483","Dubai","Dubai","AE","","gormanho@singnet.com.sg","","546080","0000-00-00","4","","1","2014-07-07 20:15:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("10","62","CUS-0000000010","Grean Ocean Pte Ltd","123 Address Road","","199405558M-PTE-10","69453488","6945 3483","Singapore","Singapore","SG","","gormanho@singnet.com.sg","","546080","0000-00-00","61","","1","2014-07-07 20:15:56","0000-00-00 00:00:00");
INSERT INTO customers VALUES("11","62","CUS-0000000011","OPHa","16 Sandilands Road","","1978885558M-PTE-04","69453482","6945 3483","Singapore","Singapore","SG","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","3","","2","2014-07-07 20:25:15","2014-07-07 20:28:53");
INSERT INTO customers VALUES("12","62","CUS-0000000012","EZH & Qha","123 Address Road","","1978885558M-PTE-05","69453483","","Singapore","Singapore","SG","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","3","","2","2014-07-07 20:25:15","2014-07-07 20:28:38");
INSERT INTO customers VALUES("13","62","CUS-0000000013","Dome - Dubaia","123 Address Road","","1978885558M-PTE-06","69453484","6945 3483","Dubai","Dubai","AE","http://www.fafflesexcursions.com.sg","","","546080","0000-00-00","3","","2","2014-07-07 20:25:15","2014-07-07 20:28:46");
INSERT INTO customers VALUES("14","62","CUS-0000000014","Ciao Cafe - Vietnama","123 Address Road","","1978885558M-PTE-07","69453485","6945 3483","Ho Chi Minh","Saigon","VN","","gormanho@singnet.com.sg","","546080","0000-00-00","3","","2","2014-07-07 20:25:15","2014-07-07 20:30:11");
INSERT INTO customers VALUES("15","62","CUS-0000000015","Melinium Sdn Bhda","123 Address Road","","1978885558M-PTE-08","69453486","6945 3483","KL","Selangor","MY","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","4","","2","2014-07-07 20:25:15","2014-07-07 20:29:02");
INSERT INTO customers VALUES("16","62","CUS-0000000016","Temasek LLCa","123 Address Road","","1978885558M-PTE-09","69453487","6945 3483","Dubai","Dubai","AE","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","4","","2","2014-07-07 20:25:15","2014-07-07 20:29:19");
INSERT INTO customers VALUES("17","62","CUS-0000000017","Grean Ocean Pte Ltda","123 Address Road","","1978885558M-PTE-10","69453488","6945 3483","Singapore","Singapore","SG","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","61","","2","2014-07-07 20:25:15","2014-07-07 20:29:11");
INSERT INTO customers VALUES("18","62","CUS-0000000018","Indian Bank","123 Address Road","","1978885558M-PTE-11","69453489","6945 3483","Singapore","Singapore","SG","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","21","","1","2014-07-07 20:26:05","2014-07-07 20:30:40");
INSERT INTO customers VALUES("19","62","CUS-0000000019","Indian Overseas Bank","123 Address Road","","1978885558M-PTE-21","69453489","","Chennai","Tamil Nadu","IN","","","","600064","0000-00-00","21","","1","2014-07-07 20:27:22","0000-00-00 00:00:00");
INSERT INTO customers VALUES("30","62","CUS-0000000020","Gorman Ho","16 Sandilands Road","","fdf343434","69453482","6945 3483","Singapore","","SG","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","3","","1","2014-07-08 21:13:44","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction VALUES("1","62","EXP-0000000001","2014-04-01","1","10","","2","2014-05-01","EUR","1.70000","1225.00","","2","0.00","N/A","","","0","1","1","30","2014-05-31","1","2014-07-07 20:51:28","2014-07-08 18:27:10");
INSERT INTO expense_transaction VALUES("2","62","EXP-0000000002","2014-04-01","2","9","","2","2014-05-01","USD","1.22000","87.50","","2","0.00","N/A","","","0","1","1","16","2014-05-25","1","2014-07-07 21:02:16","2014-07-08 18:29:15");
INSERT INTO expense_transaction VALUES("3","62","EXP-0000000003","2014-04-01","3","5","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","17","2014-04-25","1","2014-07-08 10:58:00","2014-07-08 12:05:50");
INSERT INTO expense_transaction VALUES("4","62","EXP-0000000004","2014-04-01","4","7","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","18","2014-04-25","1","2014-07-08 10:58:56","2014-07-10 16:23:53");
INSERT INTO expense_transaction VALUES("5","62","EXP-0000000005","2014-04-01","5","8","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","19","2014-04-25","1","2014-07-08 11:00:33","2014-07-09 21:01:23");
INSERT INTO expense_transaction VALUES("6","62","EXP-0000000006","2014-04-01","6","6","","2","2014-05-01","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","2","0","0000-00-00","1","2014-07-08 11:01:33","0000-00-00 00:00:00");
INSERT INTO expense_transaction VALUES("7","62","EXP-0000000007","2014-05-01","7","5","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","21","2014-05-25","1","2014-07-08 11:03:37","2014-07-08 12:32:05");
INSERT INTO expense_transaction VALUES("8","62","EXP-0000000008","2014-05-01","8","7","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","2","0","0000-00-00","1","2014-07-08 11:04:23","0000-00-00 00:00:00");
INSERT INTO expense_transaction VALUES("9","62","EXP-0000000009","2014-05-01","9","8","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","25","2014-05-25","1","2014-07-08 11:04:59","2014-07-09 14:05:09");
INSERT INTO expense_transaction VALUES("10","62","EXP-0000000010","2014-05-01","10","6","","2","2014-05-31","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","27","2014-05-25","1","2014-07-08 11:06:06","2014-07-08 12:48:51");
INSERT INTO expense_transaction VALUES("11","62","EXP-0000000011","2014-04-30","11","14","","1","2014-04-30","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","10","2014-04-30","1","2014-07-08 11:30:52","2014-07-09 14:05:14");
INSERT INTO expense_transaction VALUES("12","62","EXP-0000000012","2014-04-15","12","13","","1","2014-04-15","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","11","2014-04-15","1","2014-07-08 11:34:20","2014-07-08 11:42:37");
INSERT INTO expense_transaction VALUES("13","62","EXP-0000000013","2014-05-31","13","14","","1","2014-05-31","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","12","2014-05-31","1","2014-07-08 11:41:09","2014-07-08 11:41:39");
INSERT INTO expense_transaction VALUES("14","62","EXP-0000000014","2014-04-01","14","12","","1","2014-04-01","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","13","2014-04-01","1","2014-07-08 11:47:04","2014-07-08 11:51:33");
INSERT INTO expense_transaction VALUES("15","62","EXP-0000000015","2014-05-01","15","12","","1","2014-05-01","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","14","2014-05-01","1","2014-07-08 11:53:31","2014-07-08 12:59:52");
INSERT INTO expense_transaction VALUES("16","62","EXP-0000000016","2014-07-08","dfdfsdfsd","7","","1","2014-07-08","SGD","0.00000","0.00","","2","0.00","fdfdsf","","","75","1","2","0","0000-00-00","2","2014-07-08 12:34:30","2014-07-09 13:13:53");
INSERT INTO expense_transaction VALUES("17","62","EXP-0000000017","2014-04-14","P1","12","","1","2014-04-14","SGD","0.00000","0.00","","2","0.00","N/A","","","0","2","1","24","2014-04-14","1","2014-07-08 12:41:47","2014-07-11 21:06:03");
INSERT INTO expense_transaction VALUES("18","62","EXP-0000000018","2014-07-08","ggdf","12","","1","2014-07-08","SGD","0.00000","0.00","","2","0.00","xyz","","","75","1","2","0","0000-00-00","2","2014-07-08 12:46:17","2014-07-09 13:13:53");
INSERT INTO expense_transaction VALUES("19","62","EXP-0000000019","2014-07-08","ghghg","10","","1","2014-07-08","SGD","0.00000","0.00","","2","0.00","gfg","","","75","1","1","28","2014-07-08","2","2014-07-08 12:51:11","2014-07-09 13:13:53");
INSERT INTO expense_transaction VALUES("20","62","EXP-0000000020","2014-05-14","PC02","12","","1","2014-05-14","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","29","2014-05-14","1","2014-07-08 12:57:05","2014-07-08 18:20:19");
INSERT INTO expense_transaction VALUES("25","62","EXP-0000000021","2014-06-01","1125","5","","1","2014-06-01","SGD","0.00000","0.00","","1","0.00","n/a","","","79","2","2","0","0000-00-00","2","2014-07-09 08:42:15","2014-07-09 13:02:24");
INSERT INTO expense_transaction VALUES("26","62","EXP-0000000022","2014-06-01","52225","12","","2","2014-07-01","USD","1.24330","0.00","","2","0.00","asss","","","80","2","2","0","0000-00-00","2","2014-07-09 08:42:15","2014-07-09 13:02:39");
INSERT INTO expense_transaction VALUES("27","62","EXP-0000000023","2014-06-01","1126","5","","1","2014-06-01","SGD","0.00000","0.00","","1","0.00","n/a","","","79","2","2","0","0000-00-00","2","2014-07-09 08:44:33","2014-07-09 13:02:45");
INSERT INTO expense_transaction VALUES("28","62","EXP-0000000024","2014-06-01","52226","12","","2","2014-07-01","USD","1.24340","0.00","","2","0.00","asss","","","80","2","2","0","0000-00-00","2","2014-07-09 08:44:33","2014-07-09 13:02:52");
INSERT INTO expense_transaction VALUES("29","62","EXP-0000000025","2014-06-01","52227","12","","2","2014-07-01","USD","1.24330","0.00","","2","0.00","asss","","","80","2","2","0","0000-00-00","2","2014-07-09 08:46:03","2014-07-09 13:02:59");
INSERT INTO expense_transaction VALUES("32","62","EXP-0000000026","2014-06-01","11126","5","","1","2014-06-01","SGD","0.00000","0.00","","1","0.00","n/a","","","79","2","2","0","0000-00-00","2","2014-07-10 19:46:12","2014-07-10 19:46:55");
INSERT INTO expense_transaction VALUES("33","62","EXP-0000000027","2014-04-30","","14","","1","2014-04-30","SGD","0.00000","0.00","","2","0.00","N/A","","","0","3","2","0","0000-00-00","2","2014-07-10 20:04:45","2014-07-10 20:05:10");
INSERT INTO expense_transaction VALUES("34","62","EXP-0000000028","2014-04-30","","14","","1","2014-04-30","SGD","0.00000","0.00","","2","0.00","N/A","","","0","3","2","0","0000-00-00","2","2014-07-10 20:07:45","2014-07-10 20:08:05");





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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction_list VALUES("1","1","23","","Pasta Machines","1","10000.00","2","7.00","2014-07-07 20:51:28","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("2","2","42","","Vietnamese Food Items","1","1000.00","2","7.00","2014-07-07 21:02:16","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("3","3","42","","Food Items - Apr 14","1","5485.00","2","7.00","2014-07-08 10:58:00","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("4","4","43","","Bear - Apr 2014","2","10000.00","2","7.00","2014-07-08 10:58:56","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("5","5","43","","Wines - Apr 14","1","10000.00","2","7.00","2014-07-08 11:00:33","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("6","6","44","","Misc Purchases - Apr 14","1","5000.00","2","7.00","2014-07-08 11:01:33","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("7","7","42","","Food Items - May 14","2","7700.00","2","7.00","2014-07-08 11:03:37","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("8","8","43","","Bear - May 2014","4","10000.00","2","7.00","2014-07-08 11:04:23","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("9","9","43","","Wines - May 14","1","10000.00","2","7.00","2014-07-08 11:04:59","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("10","10","44","","Misc Purchases - May 14","1","5000.00","2","7.00","2014-07-08 11:06:06","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("11","11","51","","Apr 2014 - Cleaning Services","1","15000.00","2","7.00","2014-07-08 11:30:52","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("12","12","64","","Initial Design and Plan Processing","1","2500.00","0","0.00","2014-07-08 11:34:20","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("13","13","51","","May 2014 - Cleaning Services","1","15000.00","2","7.00","2014-07-08 11:41:09","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("14","14","65","","Apr 14","1","2000.00","2","7.00","2014-07-08 11:47:04","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("15","15","65","","May 14","1","2000.00","2","7.00","2014-07-08 11:53:31","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("16","16","53","fdfd","4343","3","4343.00","2","7.00","2014-07-08 12:34:30","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("17","17","47","","Warehouse Maintenance","1","500.00","2","7.00","2014-07-08 12:41:47","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("18","18","47","","test 113","1","500.00","2","7.00","2014-07-08 12:46:17","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("19","19","45","","fdfdf","2","233.00","2","7.00","2014-07-08 12:51:11","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("20","20","47","","Warehouse Maintenance - May 14","1","1000.00","2","7.00","2014-07-08 12:57:05","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("26","25","44","","Misc - June 2014","1","1000.00","2","7.00","2014-07-09 08:42:15","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("27","26","47","","Jun 14","1","500.00","2","7.00","2014-07-09 08:42:15","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("28","27","44","","Misc - June 2014","1","1000.00","2","7.00","2014-07-09 08:44:33","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("29","28","47","","Jun 14","1","500.00","2","7.00","2014-07-09 08:44:33","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("30","29","47","","Jun 14","1","500.00","2","7.00","2014-07-09 08:46:03","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("31","29","59","","Jun 14","3","60.00","0","0.00","2014-07-09 08:46:03","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("35","32","44","","Misc - June 2014","1","1000.00","2","7.00","2014-07-10 19:46:12","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("36","33","51","","Apr 2014 - Cleaning Services","1","15000.00","2","7.00","2014-07-10 20:04:45","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("37","34","51","","Apr 2014 - Cleaning Services","1","15000.00","2","7.00","2014-07-10 20:07:45","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO income_transaction VALUES("1","62","INC-0000000001","2014-04-25","1","8","","1","MYR","0.39000","36","Admin Fee - Apr 2014","2500.00","","1","7.00","0","1","1","8","2014-04-25","1","2014-07-08 09:13:00","2014-07-08 09:13:00");
INSERT INTO income_transaction VALUES("2","62","INC-0000000002","2014-05-25","2","8","","1","MYR","0.39500","36","Admin Fee - May 2014","2500.00","","1","7.00","81","2","1","9","2014-05-27","1","2014-07-08 09:17:39","2014-07-11 20:31:33");
INSERT INTO income_transaction VALUES("4","62","INC-0000000003","2014-05-25","","8","","1","MYR","0.39500","36","Admin Fee - May 2014","2500.00","","1","7.00","0","3","2","0","0000-00-00","2","2014-07-10 20:10:48","2014-07-10 20:11:04");
INSERT INTO income_transaction VALUES("5","62","INC-0000000004","2014-05-25","","8","","1","MYR","0.39500","36","Admin Fee - May 2014","2500.00","","1","7.00","0","3","2","0","0000-00-00","2","2014-07-10 20:11:34","2014-07-10 20:11:46");





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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

INSERT INTO invoice VALUES("1","62","INV-0000000001","2014-04-01","10","0","2","2014-05-01","SGD","0.00000","2","2","","","0","1","1","1","2014-04-02","2","1","2014-07-07 20:57:29","2014-07-08 08:56:48");
INSERT INTO invoice VALUES("2","62","INV-0000000002","2014-04-15","4","0","2","2014-05-15","SGD","0.00000","2","2","","","0","1","1","2","2014-04-30","2","1","2014-07-08 04:51:12","2014-07-08 08:57:25");
INSERT INTO invoice VALUES("3","62","INV-0000000003","2014-04-15","6","0","2","2014-05-15","USD","1.25000","2","2","","","0","1","1","3","2014-05-12","2","1","2014-07-08 04:56:09","2014-07-08 09:00:47");
INSERT INTO invoice VALUES("4","62","INV-0000000004","2014-04-30","5","0","2","2014-05-30","SGD","0.00000","2","2","","","0","1","1","4","2014-06-01","2","1","2014-07-08 04:58:35","2014-07-09 01:31:27");
INSERT INTO invoice VALUES("5","62","INV-0000000005","2014-05-05","4","0","2","2014-06-04","SGD","0.00000","2","2","Event Order","","0","1","2","0","0000-00-00","2","1","2014-07-08 05:02:34","0000-00-00 00:00:00");
INSERT INTO invoice VALUES("6","62","INV-0000000006","2014-05-15","5","0","2","2014-06-14","SGD","0.00000","2","2","","","92","2","1","5","2014-06-01","2","1","2014-07-08 05:06:00","2014-07-12 19:43:18");
INSERT INTO invoice VALUES("7","62","INV-0000000007","2014-05-15","6","0","2","2014-06-14","USD","1.24640","2","2","","","0","1","1","6","2014-06-30","2","1","2014-07-08 05:10:31","2014-07-09 14:56:27");
INSERT INTO invoice VALUES("8","62","INV-0000000008","2014-05-01","10","0","2","2014-05-31","SGD","0.00000","2","2","","","0","1","1","7","2014-05-02","2","1","2014-07-08 05:11:02","2014-07-08 09:09:41");
INSERT INTO invoice VALUES("15","62","INV-0000000009","2014-06-01","10","0","3","2014-07-31","SGD","0.00000","1","2","jun 14","","80","2","2","0","0000-00-00","2","2","2014-07-09 08:31:19","2014-07-09 13:01:42");
INSERT INTO invoice VALUES("16","62","INV-0000000010","2014-06-01","10","0","3","2014-07-31","SGD","0.00000","1","2","jun 14","","80","2","2","0","0000-00-00","2","2","2014-07-09 08:32:22","2014-07-09 13:01:47");
INSERT INTO invoice VALUES("17","62","INV-0000000011","2014-06-01","4","0","1","2014-06-01","USD","1.24340","1","2","jun 14","","80","2","2","0","0000-00-00","2","2","2014-07-09 08:32:27","2014-07-09 13:01:54");
INSERT INTO invoice VALUES("18","62","INV-0000000012","2014-06-01","10","0","3","2014-07-31","SGD","0.00000","1","2","jun 14","","80","2","2","0","0000-00-00","2","2","2014-07-09 08:40:39","2014-07-09 13:02:00");
INSERT INTO invoice VALUES("19","62","INV-0000000013","2014-06-01","4","0","1","2014-06-01","USD","1.24330","1","2","jun 14","","80","2","2","0","0000-00-00","2","2","2014-07-09 08:40:44","2014-07-09 13:02:04");
INSERT INTO invoice VALUES("20","62","INV-0000000014","2014-05-15","5","0","1","2014-05-15","SGD","0.00000","2","2","","","75","2","2","0","0000-00-00","2","2","2014-07-09 16:59:58","2014-07-09 17:00:37");
INSERT INTO invoice VALUES("21","62","INV-0000000015","2014-05-15","5","0","1","2014-05-15","SGD","0.00000","2","2","","","0","3","2","0","0000-00-00","2","2","2014-07-09 17:00:51","2014-07-09 17:01:08");
INSERT INTO invoice VALUES("22","62","INV-0000000016","2014-06-01","10","0","3","2014-07-31","SGD","0.00000","1","2","jun 14","","80","2","2","0","0000-00-00","2","2","2014-07-10 19:15:27","2014-07-10 19:16:22");
INSERT INTO invoice VALUES("23","62","INV-0000000017","2014-06-01","4","0","1","2014-06-01","USD","1.24240","1","2","jun 14","","80","2","2","0","0000-00-00","2","2","2014-07-10 19:15:27","2014-07-10 19:16:30");
INSERT INTO invoice VALUES("24","62","INV-0000000018","2014-06-01","10","0","3","2014-07-31","SGD","0.00000","1","2","jun 14","","80","2","2","0","0000-00-00","2","2","2014-07-10 19:17:30","2014-07-10 19:17:55");
INSERT INTO invoice VALUES("25","62","INV-0000000019","2014-04-15","6","0","1","2014-05-15","USD","1.25000","2","2","","","0","3","2","0","0000-00-00","2","2","2014-07-10 19:54:25","2014-07-10 19:54:56");
INSERT INTO invoice VALUES("26","62","INV-0000000020","2014-04-15","6","0","1","2014-05-15","USD","1.25000","2","2","ghfh","","75","2","2","0","0000-00-00","2","2","2014-07-10 19:55:40","2014-07-10 19:57:32");
INSERT INTO invoice VALUES("27","62","INV-0000000021","2014-04-15","6","0","1","2014-05-15","USD","1.25000","2","2","","","0","3","2","0","0000-00-00","2","2","2014-07-10 20:00:52","2014-07-10 20:01:10");
INSERT INTO invoice VALUES("28","62","INV-0000000022","2014-07-12","","0","2","2014-08-11","SGD","0.00000","2","2","","","0","3","2","0","0000-00-00","2","1","2014-07-12 19:37:28","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

INSERT INTO invoice_product_list VALUES("1","1","R - 113B","11","1","2500.00","0.00","1","7.00","2014-07-07 20:57:29","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("2","2","PA01","3","100","20.00","0.00","1","7.00","2014-07-08 04:51:12","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("3","2","PA02","4","100","30.00","0.00","1","7.00","2014-07-08 04:51:12","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("4","2","P12","1","100","35.00","0.00","1","7.00","2014-07-08 04:51:12","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("5","2","P8","2","100","25.00","0.00","1","7.00","2014-07-08 04:51:12","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("6","2","Whisky","8","250","12.00","0.00","1","7.00","2014-07-08 04:51:12","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("7","2","Wine","9","200","10.00","0.00","1","7.00","2014-07-08 04:51:12","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("8","2","SC100","6","30","100.00","0.00","1","7.00","2014-07-08 04:51:12","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("9","2","SC50","7","70","50.00","0.00","1","7.00","2014-07-08 04:51:12","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("10","3","HMP - USD","10","100","50.00","0.00","1","7.00","2014-07-08 04:56:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("11","3","PD - USD","5","1000","10.00","0.00","1","7.00","2014-07-08 04:56:09","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("12","4","Whisky","8","500","12.00","0.00","1","7.00","2014-07-08 04:58:35","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("13","4","Wine","9","500","10.00","0.00","1","7.00","2014-07-08 04:58:35","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("14","4","SC100","6","10","100.00","0.00","1","7.00","2014-07-08 04:58:35","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("15","4","SC50","7","20","50.00","0.00","1","7.00","2014-07-08 04:58:35","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("16","5","PA01","3","22","20.00","0.00","1","7.00","2014-07-08 05:02:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("17","5","PA02","4","22","30.00","0.00","1","7.00","2014-07-08 05:02:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("18","5","P12","1","22","35.00","0.00","1","7.00","2014-07-08 05:02:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("19","5","P8","2","22","25.00","0.00","1","7.00","2014-07-08 05:02:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("20","5","Whisky","8","22","12.00","0.00","1","7.00","2014-07-08 05:02:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("21","5","Wine","9","22","10.00","0.00","1","7.00","2014-07-08 05:02:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("22","5","SC100","6","11","100.00","100.00","1","7.00","2014-07-08 05:02:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("23","5","SC50","7","11","50.00","50.00","1","7.00","2014-07-08 05:02:34","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("24","6","Whisky","8","2000","12.00","1000.00","1","7.00","2014-07-08 05:06:00","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("25","6","Wine","9","2000","10.00","1000.00","1","7.00","2014-07-08 05:06:00","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("26","6","SC100","6","28","100.00","800.00","1","7.00","2014-07-08 05:06:00","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("27","6","SC50","7","72","50.00","600.00","1","7.00","2014-07-08 05:06:00","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("28","7","HMP - USD","10","500","50.00","2000.00","1","7.00","2014-07-08 05:10:31","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("29","7","PD - USD","5","2000","10.00","2000.00","1","7.00","2014-07-08 05:10:31","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("30","8","R - 113B","11","1","2500.00","0.00","1","7.00","2014-07-08 05:11:02","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("42","15","Test 1","13","1","100.00","50.00","1","7.00","2014-07-09 08:31:19","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("43","16","Test 1","13","1","100.00","50.00","1","7.00","2014-07-09 08:32:22","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("44","17","PD - USD","5","2","10.00","0.00","0","0.00","2014-07-09 08:32:27","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("45","18","Test 1","13","1","100.00","50.00","1","7.00","2014-07-09 08:40:39","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("46","19","PD - USD","5","2","10.00","0.00","0","0.00","2014-07-09 08:40:44","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("47","19","HMP - USD","10","1","50.00","2.00","1","7.00","2014-07-09 08:40:44","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("48","20","Whisky","8","2000","12.00","1000.00","1","7.00","2014-07-09 16:59:58","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("49","20","Wine","9","2000","10.00","1000.00","1","7.00","2014-07-09 16:59:58","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("50","20","SC100","6","28","100.00","800.00","1","7.00","2014-07-09 16:59:58","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("51","20","SC50","7","72","50.00","600.00","1","7.00","2014-07-09 16:59:58","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("52","21","Whisky","8","2000","12.00","1000.00","1","7.00","2014-07-09 17:00:51","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("53","21","Wine","9","2000","10.00","1000.00","1","7.00","2014-07-09 17:00:51","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("54","21","SC100","6","28","100.00","800.00","1","7.00","2014-07-09 17:00:51","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("55","21","SC50","7","72","50.00","600.00","1","7.00","2014-07-09 17:00:51","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("56","22","Test 1","13","1","100.00","50.00","1","7.00","2014-07-10 19:15:27","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("57","23","PD - USD","5","2","10.00","0.00","0","0.00","2014-07-10 19:15:27","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("58","23","HMP - USD","10","1","50.00","2.00","1","7.00","2014-07-10 19:15:27","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("59","24","Test 1","13","1","100.00","50.00","1","7.00","2014-07-10 19:17:30","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("60","25","HMP - USD","10","100","50.00","0.00","1","7.00","2014-07-10 19:54:25","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("61","25","PD - USD","5","1000","10.00","0.00","1","7.00","2014-07-10 19:54:25","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("62","26","HMP - USD","10","100","50.00","0.00","1","7.00","2014-07-10 19:55:40","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("63","26","PD - USD","5","1000","10.00","0.00","1","7.00","2014-07-10 19:55:40","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("64","27","HMP - USD","10","100","50.00","0.00","1","7.00","2014-07-10 20:00:52","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("65","27","PD - USD","5","1000","10.00","0.00","1","7.00","2014-07-10 20:00:52","0000-00-00 00:00:00");
INSERT INTO invoice_product_list VALUES("66","28","","","0","0.00","0.00","0","0.00","2014-07-12 19:37:28","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO journal_entries VALUES("1","62","JEN-0000000001","2014-04-30","Payroll - Apr 2014","","75","1","1","2014-07-08 12:54:50","2014-07-09 10:10:48");
INSERT INTO journal_entries VALUES("2","62","JEN-0000000002","2014-06-30","Depreciation for the Year ","","0","1","1","2014-07-08 13:23:56","2014-07-11 21:07:52");
INSERT INTO journal_entries VALUES("3","62","JEN-0000000003","2014-05-25","Fund Transfer","","0","1","1","2014-07-08 14:14:53","0000-00-00 00:00:00");
INSERT INTO journal_entries VALUES("4","62","JEN-0000000004","2014-06-30","Testing Jrnl","","0","1","2","2014-07-08 18:56:39","2014-07-09 13:03:16");





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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO journal_entries_list VALUES("1","1","52","Payroll - Apr 2014","10000.00","0.00","0000-00-00","2014-07-08 12:54:50","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("2","1","53","Payroll - Apr 2014","1500.00","0.00","0000-00-00","2014-07-08 12:54:50","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("3","1","54","Payroll - Apr 2014","1000.00","0.00","0000-00-00","2014-07-08 12:54:50","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("4","1","55","Payroll - Apr 2014","800.00","0.00","0000-00-00","2014-07-08 12:54:50","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("5","1","56","Payroll - Apr 2014","11.25","0.00","0000-00-00","2014-07-08 12:54:50","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("6","1","28","Payroll - Apr 2014","0.00","1811.25","0000-00-00","2014-07-08 12:54:50","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("7","1","22","Payroll - Apr 2014","0.00","1000.00","0000-00-00","2014-07-08 12:54:50","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("8","1","29","Payroll - Apr 2014","0.00","10500.00","0000-00-00","2014-07-08 12:54:50","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("9","2","66","Depreciation for the Year ","3400.00","0.00","0000-00-00","2014-07-08 13:23:56","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("10","2","24","Depreciation for the Year ","0.00","3400.00","0000-00-00","2014-07-08 13:23:56","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("11","3","14","Fund Transfer","1500.00","0.00","0000-00-00","2014-07-08 14:14:53","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("12","3","15","Fund Transfer","0.00","1500.00","0000-00-00","2014-07-08 14:14:53","0000-00-00 00:00:00");
INSERT INTO journal_entries_list VALUES("13","4","17","Testing","1000.00","0.00","2014-07-02","2014-07-08 18:56:39","2014-07-09 11:14:28");
INSERT INTO journal_entries_list VALUES("14","4","40","Testing","0.00","1000.00","0000-00-00","2014-07-08 18:56:39","0000-00-00 00:00:00");





CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification` tinyint(2) NOT NULL COMMENT '1 - On, 2 - Off',
  `email_setting` tinyint(2) NOT NULL COMMENT '1 - Immediate, 2 - Off',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO notifications VALUES("1","1","2","2014-07-07 19:18:55","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

INSERT INTO payments VALUES("1","2","0.00","","3","2014-07-08 08:56:18","2014-07-08 08:56:44","1","2014-04-02","0000-00-00","15","2675.00","2","623501");
INSERT INTO payments VALUES("2","2","0.00","","3","2014-07-08 08:57:25","0000-00-00 00:00:00","2","2014-04-30","0000-00-00","15","23165.50","2","");
INSERT INTO payments VALUES("3","2","0.00","","3","2014-07-08 08:58:43","2014-07-09 11:14:05","3","2014-05-12","2014-05-12","17","20060.00","1","DT1");
INSERT INTO payments VALUES("4","2","0.00","","3","2014-07-08 09:02:45","0000-00-00 00:00:00","4","2014-06-01","0000-00-00","15","11475.75","2","523651");
INSERT INTO payments VALUES("5","1","290.00","290 Waived","3","2014-07-08 09:04:05","0000-00-00 00:00:00","6","2014-06-01","0000-00-00","15","50000.00","2","523685");
INSERT INTO payments VALUES("6","2","0.00","Final Payment Less Exchange Loss","3","2014-07-08 09:07:40","2014-07-09 11:14:28","7","2014-06-30","2014-07-01","17","47300.00","1","DT2");
INSERT INTO payments VALUES("7","2","0.00","","3","2014-07-08 09:09:41","0000-00-00 00:00:00","8","2014-05-02","0000-00-00","15","2675.00","2","5236547");
INSERT INTO payments VALUES("8","2","0.00","","1","2014-07-08 09:13:00","2014-07-09 11:14:05","1","2014-04-25","2014-04-25","17","1050.00","1","KLT1");
INSERT INTO payments VALUES("9","2","0.00","","1","2014-07-08 09:24:54","2014-07-09 11:14:28","2","2014-05-27","2014-06-01","17","1050.00","1","KLT2");
INSERT INTO payments VALUES("10","2","0.00","","2","2014-07-08 11:30:52","2014-07-09 11:14:05","11","2014-04-30","2014-05-06","17","16050.00","2","000001");
INSERT INTO payments VALUES("11","2","0.00","","2","2014-07-08 11:34:20","2014-07-09 11:14:05","12","2014-04-15","2014-04-17","17","2500.00","2","000002");
INSERT INTO payments VALUES("12","2","0.00","","2","2014-07-08 11:41:09","2014-07-09 11:14:28","13","2014-05-31","2014-07-01","17","16050.00","2","000003");
INSERT INTO payments VALUES("13","2","0.00","","2","2014-07-08 11:47:04","2014-07-09 11:14:05","14","2014-04-01","2014-04-03","17","2140.00","2","000004");
INSERT INTO payments VALUES("14","2","0.00","","2","2014-07-08 11:53:31","2014-07-09 11:14:05","15","2014-05-01","2014-05-05","17","2140.00","2","000005");
INSERT INTO payments VALUES("16","2","0.00","Final Pymt Less Exchange Loss","2","2014-07-08 12:04:45","2014-07-09 11:14:28","2","2014-05-25","0000-00-00","17","1300.00","1","VT1");
INSERT INTO payments VALUES("17","2","0.00","","2","2014-07-08 12:05:50","0000-00-00 00:00:00","3","2014-04-25","0000-00-00","15","5868.95","2","000006");
INSERT INTO payments VALUES("18","2","0.00","","2","2014-07-08 12:06:25","0000-00-00 00:00:00","4","2014-04-25","0000-00-00","15","21400.00","2","000007");
INSERT INTO payments VALUES("19","1","1070.00","10% Discount","2","2014-07-08 12:07:50","2014-07-09 11:14:05","5","2014-04-25","2014-05-15","17","9630.00","2","000008");
INSERT INTO payments VALUES("20","2","0.00","","2","2014-07-08 12:09:47","2014-07-09 11:14:05","6","2014-04-25","2014-04-27","17","5082.50","2","000009");
INSERT INTO payments VALUES("21","1","478.00","$478.00 Discount Received","2","2014-07-08 12:32:05","2014-07-09 11:14:05","7","2014-05-25","2014-05-30","17","16000.00","2","000009");
INSERT INTO payments VALUES("22","2","0.00","","2","2014-07-08 12:32:48","2014-07-09 11:14:28","8","2014-05-25","2014-06-06","17","21400.00","2","000010");
INSERT INTO payments VALUES("23","2","0.00","","2","2014-07-08 12:34:30","0000-00-00 00:00:00","16","2014-07-08","0000-00-00","13","13029.00","2","");
INSERT INTO payments VALUES("24","2","0.00","","2","2014-07-08 12:41:47","2014-07-08 12:58:48","17","2014-04-14","0000-00-00","14","535.00","3","PC01");
INSERT INTO payments VALUES("25","1","1605.00","15% Discount","2","2014-07-08 12:45:41","2014-07-09 11:14:28","9","2014-05-25","2014-06-16","17","9095.00","2","000011");
INSERT INTO payments VALUES("26","2","0.00","","2","2014-07-08 12:46:17","0000-00-00 00:00:00","18","2014-07-08","0000-00-00","13","535.00","3","BC01");
INSERT INTO payments VALUES("27","2","0.00","","2","2014-07-08 12:48:51","2014-07-09 11:14:05","10","2014-05-25","2014-05-27","17","5350.00","2","000012");
INSERT INTO payments VALUES("28","2","0.00","","2","2014-07-08 12:51:11","0000-00-00 00:00:00","19","2014-07-08","0000-00-00","13","498.62","2","");
INSERT INTO payments VALUES("29","2","0.00","","2","2014-07-08 12:57:05","0000-00-00 00:00:00","20","2014-05-14","0000-00-00","14","1070.00","3","PC02");
INSERT INTO payments VALUES("30","2","0.00","Full & Final Pymt","2","2014-07-08 16:22:05","2014-07-08 18:27:10","1","2014-05-31","0000-00-00","15","18225.00","1","");
INSERT INTO payments VALUES("31","2","0.00","","3","2014-07-09 16:59:58","0000-00-00 00:00:00","20","2014-07-09","0000-00-00","13","50290.00","2","");
INSERT INTO payments VALUES("32","2","0.00","","3","2014-07-09 17:00:51","0000-00-00 00:00:00","21","2014-07-09","0000-00-00","13","0.00","0","");
INSERT INTO payments VALUES("33","2","0.00","","3","2014-07-10 20:00:52","0000-00-00 00:00:00","27","2014-07-10","0000-00-00","13","0.00","0","");
INSERT INTO payments VALUES("34","2","0.00","","2","2014-07-10 20:07:45","0000-00-00 00:00:00","34","2014-07-10","0000-00-00","13","0.00","0","");
INSERT INTO payments VALUES("35","2","0.00","","1","2014-07-10 20:10:48","0000-00-00 00:00:00","4","2014-07-10","0000-00-00","13","0.00","0","");
INSERT INTO payments VALUES("36","2","0.00","","1","2014-07-10 20:11:34","0000-00-00 00:00:00","5","2014-07-10","0000-00-00","13","0.00","0","");





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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO products VALUES("1","Pizza 12\"","62","P12","Pizza 12\"","35.00","SGD","31","2014-07-07 19:31:06","0000-00-00 00:00:00");
INSERT INTO products VALUES("2","Pizza 8\"","62","P8","Pizza 8\"","25.00","SGD","31","2014-07-07 19:31:06","0000-00-00 00:00:00");
INSERT INTO products VALUES("3","Pasta 01","62","PA01","Pasta 01","20.00","SGD","31","2014-07-07 19:31:06","0000-00-00 00:00:00");
INSERT INTO products VALUES("4","Pasta 02","62","PA02","Pasta 02","30.00","SGD","31","2014-07-07 19:31:06","0000-00-00 00:00:00");
INSERT INTO products VALUES("5","Pizza Dong","62","PD - USD","Pizza Dong","10.00","USD","33","2014-07-07 19:31:06","0000-00-00 00:00:00");
INSERT INTO products VALUES("6","Service Charge - $100","62","SC100","Service Charge - $100","100.00","SGD","34","2014-07-07 19:31:06","0000-00-00 00:00:00");
INSERT INTO products VALUES("7","Service Charge - $50","62","SC50","Service Charge - $50","50.00","SGD","34","2014-07-07 19:31:06","0000-00-00 00:00:00");
INSERT INTO products VALUES("8","Whisky","62","Whisky","Whisky","12.00","SGD","32","2014-07-07 19:31:06","0000-00-00 00:00:00");
INSERT INTO products VALUES("9","Wine","62","Wine","Wine","10.00","SGD","32","2014-07-07 19:31:06","0000-00-00 00:00:00");
INSERT INTO products VALUES("10","Home Made Pasta","62","HMP - USD","Home Made Pasta","50.00","USD","33","2014-07-07 19:31:06","0000-00-00 00:00:00");
INSERT INTO products VALUES("11","Rental - Unit 113B","62","R - 113B","","2500.00","SGD","62","2014-07-07 20:55:34","0000-00-00 00:00:00");
INSERT INTO products VALUES("12","testid","62","test12","","2500.00","SGD","35","2014-07-09 01:03:53","0000-00-00 00:00:00");
INSERT INTO products VALUES("13","Test 1","62","Test 1","","100.00","SGD","67","2014-07-09 08:06:37","0000-00-00 00:00:00");
INSERT INTO products VALUES("14","Test Product","62","Testing 01","","1000.00","SGD","31","2014-07-11 20:46:05","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO taxcodes VALUES("1","62","13","7.00","Standard-rated supplies with GST charged","2","1","2014-07-07 20:39:17","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("2","62","23","7.00","Purchases with GST incurred at 7% and directly attributable to taxable supplies","1","1","2014-07-07 20:48:39","0000-00-00 00:00:00");





CREATE TABLE `theme_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `default_theme` tinyint(2) NOT NULL COMMENT '1 - Default, 2 - Not Default',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO theme_setting VALUES("1","Red","Basic Theme","1","2014-07-11 20:28:00");
INSERT INTO theme_setting VALUES("2","Black","Black Theme","2","2014-07-07 19:18:55");
INSERT INTO theme_setting VALUES("3","Blue","Blue Theme","2","2014-07-11 20:28:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

INSERT INTO vendors VALUES("1","62","VEN-0000000001","Gorman Hoaaa","16 Sandilands Road","","201301587A-PTE-01","69453482","6945 3483","Singapore","Singapore","SG","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","2","5","","2014-07-07 20:35:41","2014-07-07 20:36:11");
INSERT INTO vendors VALUES("2","62","VEN-0000000002","Gorman Hobsss","16 Sandilands Road","","201301587A-PTE-04","69453482","6945 3483","Singapore","Singapore","SG","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","2","6","","2014-07-07 20:35:41","2014-07-07 20:36:19");
INSERT INTO vendors VALUES("3","62","VEN-0000000003","Gorman Hobn","16 Sandilands Road","","201301587A-PTE-02","69453483","6945 3483","Singapore","Singapore","SG","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","2","6","","2014-07-07 20:35:41","2014-07-07 20:37:11");
INSERT INTO vendors VALUES("4","62","VEN-0000000004","Gorman Hobgh","16 Sandilands Road","","201301587A-PTE-03","69453484","6945 3483","Singapore","Singapore","SG","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","2","6","","2014-07-07 20:35:41","2014-07-07 20:37:25");
INSERT INTO vendors VALUES("5","62","VEN-0000000005","Natrad Foods","16 Sandilands Road","","201301587A-PTE-01","69453481","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-07 20:37:50","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("6","62","VEN-0000000006","FoodXervices","16 Sandilands Road","","201301587A-PTE-06","69453482","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-07 20:37:50","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("7","62","VEN-0000000007","APB","16 Sandilands Road","","201301587A-PTE-02","69453483","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-07 20:37:50","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("8","62","VEN-0000000008","Magnum Wines","16 Sandilands Road","","201301587A-PTE-03","69453484","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-07 20:37:50","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("9","62","VEN-0000000009","AA Corporation - Vietnam","16 Sandilands Road","","201301587A-PTE-04","69453485","","Ho Chi Minh","Saigon","VN","","","","546080","0000-00-00","1","6","","2014-07-07 20:37:50","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("10","62","VEN-0000000010","Bakers & Chef - Italy","16 Sandilands Road","","201301587A-PTE-15","69453485","","Italy","Italy","IT","","","","546080","0000-00-00","1","6","","2014-07-07 20:38:32","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("11","62","VEN-0000000011","UMM Technologies","16 Sandilands Road","","201301587A-PTE-16","69453481","","Chennai","Tamil Nadu","IN","","","","600018","0000-00-00","1","6","","2014-07-08 11:19:17","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("12","62","VEN-0000000012","MCST 835","16 Sandilands Road","","201301587A-PTE-18","69453482","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","63","","2014-07-08 11:19:17","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("13","62","VEN-0000000013","ID Ranger","16 Sandilands Road","","201301587A-PTE-19","69453483","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","6","","2014-07-08 11:19:17","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("14","62","VEN-0000000014","Evergreen Cleaning Services","16 Sandilands Road","","201301587A-PTE-20","69453484","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","6","","2014-07-08 11:19:17","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("15","62","VEN-0000000015","Jhjhgjg","16 Sandilands Road","","fdf343434","69453482","6945 3483","Singapore","","SG","http://www.fafflesexcursions.com.sg","gormanho@singnet.com.sg","","546080","0000-00-00","1","5","","2014-07-08 21:19:31","0000-00-00 00:00:00");



