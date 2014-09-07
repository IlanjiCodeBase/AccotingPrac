

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

INSERT INTO account VALUES("1","2","1","0","Unrealised Foreign Exchange Gain / (Loss)","","0.00","0.00","0","2","1","2014-07-08 19:29:43","2014-07-13 08:01:34");
INSERT INTO account VALUES("2","4","3","0","Foreign Exchange Gain/(Loss)","","0.00","0.00","0","2","1","2014-07-08 19:29:43","2014-07-13 08:01:34");
INSERT INTO account VALUES("3","1","1","4","Trade Receivables","","0.00","0.00","0","2","1","2014-07-08 19:29:43","2014-07-13 08:01:34");
INSERT INTO account VALUES("4","1","1","5","Account Receivables - Others","","0.00","0.00","0","2","1","2014-07-08 19:29:43","2014-07-13 08:01:34");
INSERT INTO account VALUES("5","2","1","3","Trade Creditors","","0.00","0.00","0","2","1","2014-07-08 19:29:43","2014-07-13 08:01:34");
INSERT INTO account VALUES("6","2","1","8","Account Payables - Others","","0.00","0.00","0","2","1","2014-07-08 19:29:43","2014-07-13 08:01:34");
INSERT INTO account VALUES("7","3","1","0","Discounts Given","","0.00","0.00","0","2","1","2014-07-08 19:29:43","2014-07-13 08:01:34");
INSERT INTO account VALUES("8","4","1","0","Discounts Received","","0.00","0.00","0","2","1","2014-07-08 19:29:43","2014-07-13 08:01:34");
INSERT INTO account VALUES("9","5","4","1","Retained Earnings","","0.00","0.00","0","2","1","2014-07-08 19:29:43","2014-07-13 08:01:34");
INSERT INTO account VALUES("10","5","4","1","Current Year Earnings","","0.00","0.00","0","2","1","2014-07-08 19:29:43","2014-07-13 08:01:34");
INSERT INTO account VALUES("11","2","1","4","Sales Tax Payables","","0.00","0.00","0","2","1","2014-07-08 19:29:43","2014-07-13 08:01:34");
INSERT INTO account VALUES("12","4","3","8","Income Tax","","0.00","0.00","0","2","1","2014-07-08 19:29:43","2014-07-13 08:01:34");
INSERT INTO account VALUES("13","1","1","1","BANK","SGD","0.00","0.00","2","1","1","2014-07-08 20:20:30","2014-07-13 08:01:34");
INSERT INTO account VALUES("14","1","1","4","TRADE DEBTORS","SGD","0.00","0.00","2","1","2","2014-07-08 20:20:30","2014-07-08 20:26:44");
INSERT INTO account VALUES("15","1","1","6","OTHER DEBTORS","SGD","0.00","0.00","2","1","2","2014-07-08 20:20:30","2014-07-08 20:25:01");
INSERT INTO account VALUES("16","1","2","5","CARS","SGD","0.00","0.00","2","1","2","2014-07-08 20:20:30","2014-07-08 20:30:33");
INSERT INTO account VALUES("17","1","2","5","ACC. DEPN - CARS","SGD","0.00","0.00","2","1","2","2014-07-08 20:20:30","2014-07-08 20:30:44");
INSERT INTO account VALUES("18","1","2","5","F & F","SGD","0.00","0.00","2","1","2","2014-07-08 20:20:30","2014-07-08 20:30:59");
INSERT INTO account VALUES("19","1","2","5","ACC. DEPN - F & F","SGD","0.00","0.00","2","1","2","2014-07-08 20:20:30","2014-07-08 20:31:16");
INSERT INTO account VALUES("20","1","2","5","COMPUTERS","SGD","0.00","0.00","2","1","2","2014-07-08 20:20:30","2014-07-10 15:33:47");
INSERT INTO account VALUES("21","1","2","5","ACC. DEPN - COMPUTERS","SGD","0.00","0.00","2","1","2","2014-07-08 20:20:30","2014-07-10 15:33:53");
INSERT INTO account VALUES("22","1","2","5","BUILDINGS","SGD","0.00","0.00","2","1","2","2014-07-08 20:20:30","2014-07-10 15:34:01");
INSERT INTO account VALUES("23","1","2","5","ACC. DEPN - BUILDINGS","SGD","0.00","0.00","2","1","2","2014-07-08 20:20:30","2014-07-10 15:34:07");
INSERT INTO account VALUES("24","3","1","7","REVENUE - TRADE","SGD","0.00","0.00","2","1","1","2014-07-08 20:20:30","2014-07-13 08:01:34");
INSERT INTO account VALUES("25","3","2","2","REVENUE - INTEREST","SGD","0.00","0.00","2","1","1","2014-07-08 20:20:30","2014-07-13 08:01:34");
INSERT INTO account VALUES("26","3","2","3","REVENUE - RENTAL","SGD","0.00","0.00","2","1","1","2014-07-08 20:20:30","2014-07-13 08:01:34");
INSERT INTO account VALUES("27","4","1","1","TRADING - PURCHASE","SGD","0.00","0.00","2","1","1","2014-07-08 20:20:30","2014-07-13 08:01:34");
INSERT INTO account VALUES("28","1","1","5","OTHER DEBTORS","SGD","0.00","0.00","2","1","1","2014-07-08 20:25:52","2014-07-13 08:01:34");
INSERT INTO account VALUES("29","1","1","5","TRADE DEBTORS","SGD","0.00","0.00","2","1","1","2014-07-08 20:26:56","2014-07-13 08:01:34");





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
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

INSERT INTO accounting_entries VALUES("1","1","1","5350.00","2011-10-28","1","1","1","2014-07-08 20:48:03","2014-07-08 20:55:43");
INSERT INTO accounting_entries VALUES("2","1","5","5000.00","2011-10-28","1","2","1","2014-07-08 20:48:03","2014-07-08 20:55:43");
INSERT INTO accounting_entries VALUES("3","1","4","350.00","2011-10-28","1","2","1","2014-07-08 20:48:03","2014-07-08 20:55:43");
INSERT INTO accounting_entries VALUES("4","2","1","1000.00","2011-10-28","1","1","1","2014-07-08 20:49:05","2014-07-08 20:56:31");
INSERT INTO accounting_entries VALUES("5","2","5","1000.00","2011-10-28","1","2","1","2014-07-08 20:49:05","2014-07-08 20:56:31");
INSERT INTO accounting_entries VALUES("6","2","4","0.00","2011-10-28","1","2","1","2014-07-08 20:49:05","2014-07-08 20:56:31");
INSERT INTO accounting_entries VALUES("7","3","1","650.00","2011-02-02","1","1","1","2014-07-08 20:49:48","2014-07-09 12:26:33");
INSERT INTO accounting_entries VALUES("8","3","5","650.00","2011-02-02","1","2","1","2014-07-08 20:49:48","2014-07-09 12:26:33");
INSERT INTO accounting_entries VALUES("9","3","4","0.00","2011-02-02","1","2","1","2014-07-08 20:49:48","2014-07-09 12:26:33");
INSERT INTO accounting_entries VALUES("10","4","1","3500.00","2011-10-28","1","1","1","2014-07-08 20:50:36","2014-07-08 20:57:49");
INSERT INTO accounting_entries VALUES("11","4","5","3500.00","2011-10-28","1","2","1","2014-07-08 20:50:36","2014-07-08 20:57:49");
INSERT INTO accounting_entries VALUES("12","4","4","0.00","2011-10-28","1","2","1","2014-07-08 20:50:36","2014-07-08 20:57:49");
INSERT INTO accounting_entries VALUES("13","5","1","1070.00","2011-11-01","1","1","1","2014-07-08 20:51:29","2014-07-08 20:58:25");
INSERT INTO accounting_entries VALUES("14","5","5","1000.00","2011-11-01","1","2","1","2014-07-08 20:51:29","2014-07-08 20:58:25");
INSERT INTO accounting_entries VALUES("15","5","4","70.00","2011-11-01","1","2","1","2014-07-08 20:51:29","2014-07-08 20:58:25");
INSERT INTO accounting_entries VALUES("16","6","1","10000.00","2011-11-10","1","1","1","2014-07-08 20:52:15","2014-07-08 20:59:01");
INSERT INTO accounting_entries VALUES("17","6","5","10000.00","2011-11-10","1","2","1","2014-07-08 20:52:15","2014-07-08 20:59:01");
INSERT INTO accounting_entries VALUES("18","6","4","0.00","2011-11-10","1","2","1","2014-07-08 20:52:15","2014-07-08 20:59:01");
INSERT INTO accounting_entries VALUES("19","7","1","6955.00","2011-10-28","1","1","1","2014-07-08 20:53:27","2014-07-13 15:53:26");
INSERT INTO accounting_entries VALUES("20","7","5","6500.00","2011-10-28","1","2","1","2014-07-08 20:53:27","2014-07-13 15:53:26");
INSERT INTO accounting_entries VALUES("21","7","4","455.00","2011-10-28","1","2","1","2014-07-08 20:53:27","2014-07-13 15:53:26");
INSERT INTO accounting_entries VALUES("22","8","1","1000.00","2011-10-28","1","1","1","2014-07-08 20:54:28","2014-07-08 21:00:02");
INSERT INTO accounting_entries VALUES("23","8","5","1000.00","2011-10-28","1","2","1","2014-07-08 20:54:28","2014-07-08 21:00:02");
INSERT INTO accounting_entries VALUES("24","8","4","0.00","2011-10-28","1","2","1","2014-07-08 20:54:28","2014-07-08 21:00:02");
INSERT INTO accounting_entries VALUES("25","1","3","5350.00","2011-10-28","1","1","1","2014-07-08 20:55:43","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("26","2","3","1000.00","2011-10-28","1","1","1","2014-07-08 20:56:31","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("27","3","3","650.00","2011-02-02","1","1","1","2014-07-08 20:57:05","2014-07-09 12:26:33");
INSERT INTO accounting_entries VALUES("28","4","3","3500.00","2011-10-28","1","1","1","2014-07-08 20:57:49","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("29","5","3","1070.00","2011-11-01","1","1","1","2014-07-08 20:58:25","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("30","6","3","10000.00","2011-11-10","1","1","1","2014-07-08 20:59:01","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("31","7","3","8485.10","2011-10-28","1","1","1","2014-07-08 20:59:40","2014-07-13 15:53:26");
INSERT INTO accounting_entries VALUES("32","8","3","1220.00","2011-10-28","1","1","1","2014-07-08 21:00:02","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("33","1","2","5350.00","2011-11-01","2","2","1","2014-07-08 21:01:40","2014-07-08 21:19:46");
INSERT INTO accounting_entries VALUES("34","2","2","5000.00","2011-11-10","2","2","1","2014-07-08 21:10:22","2014-07-08 21:20:22");
INSERT INTO accounting_entries VALUES("35","3","2","53500.00","2011-11-10","2","2","1","2014-07-08 21:11:24","2014-07-08 21:21:11");
INSERT INTO accounting_entries VALUES("36","4","2","100000.00","2011-11-10","2","2","1","2014-07-08 21:12:21","2014-07-08 21:21:50");
INSERT INTO accounting_entries VALUES("37","5","2","107000.00","2011-11-10","2","2","1","2014-07-08 21:13:09","2014-07-08 21:22:07");
INSERT INTO accounting_entries VALUES("38","6","2","1070000.00","2011-11-10","2","2","1","2014-07-08 21:14:40","2014-07-08 21:23:04");
INSERT INTO accounting_entries VALUES("39","7","2","50000.00","2011-11-10","2","2","1","2014-07-08 21:15:30","2014-07-08 21:23:56");
INSERT INTO accounting_entries VALUES("40","8","2","50000.00","2011-11-10","2","2","1","2014-07-08 21:16:07","2014-07-08 21:24:28");
INSERT INTO accounting_entries VALUES("41","9","2","10875.00","2011-11-01","2","2","1","2014-07-08 21:17:12","2014-07-08 21:25:11");
INSERT INTO accounting_entries VALUES("42","10","2","25000.00","2011-10-28","2","2","1","2014-07-08 21:18:38","2014-07-08 21:25:38");
INSERT INTO accounting_entries VALUES("43","1","3","5350.00","2011-11-01","2","2","1","2014-07-08 21:19:46","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("44","2","3","5000.00","2011-11-10","2","2","1","2014-07-08 21:20:22","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("45","3","3","53500.00","2011-11-10","2","2","1","2014-07-08 21:21:11","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("46","4","3","100000.00","2011-11-10","2","2","1","2014-07-08 21:21:50","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("47","5","3","107000.00","2011-11-10","2","2","1","2014-07-08 21:22:07","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("48","6","3","1070000.00","2011-11-10","2","2","1","2014-07-08 21:23:04","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("49","7","3","50000.00","2011-11-10","2","2","1","2014-07-08 21:23:56","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("50","8","3","50000.00","2011-11-10","2","2","1","2014-07-08 21:24:28","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("51","9","3","13075.00","2011-11-01","2","2","1","2014-07-08 21:25:11","0000-00-00 00:00:00");
INSERT INTO accounting_entries VALUES("52","10","3","30500.00","2011-10-28","2","2","1","2014-07-08 21:25:38","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=latin1;

INSERT INTO audit_log VALUES("1","63","76","9","12","Logged In","2","2014-07-08 19:30:10");
INSERT INTO audit_log VALUES("2","63","76","9","13","Logged Out","2","2014-07-08 19:32:23");
INSERT INTO audit_log VALUES("3","63","76","9","12","Logged In","2","2014-07-08 19:55:41");
INSERT INTO audit_log VALUES("4","63","76","1","8","BANK","13","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("5","63","76","1","8","TRADE DEBTORS","14","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("6","63","76","1","8","OTHER DEBTORS","15","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("7","63","76","1","8","CARS","16","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("8","63","76","1","8","ACC. DEPN - CARS","17","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("9","63","76","1","8","F & F","18","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("10","63","76","1","8","ACC. DEPN - F & F","19","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("11","63","76","1","8","COMPUTERS","20","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("12","63","76","1","8","ACC. DEPN - COMPUTERS","21","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("13","63","76","1","8","BUILDINGS","22","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("14","63","76","1","8","ACC. DEPN - BUILDINGS","23","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("15","63","76","1","8","REVENUE - TRADE","24","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("16","63","76","1","8","REVENUE - INTEREST","25","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("17","63","76","1","8","REVENUE - RENTAL","26","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("18","63","76","1","8","TRADING - PURCHASE","27","2014-07-08 20:20:30");
INSERT INTO audit_log VALUES("19","63","76","3","8","OTHER DEBTORS","15","2014-07-08 20:25:01");
INSERT INTO audit_log VALUES("20","63","76","1","8","OTHER DEBTORS","28","2014-07-08 20:25:52");
INSERT INTO audit_log VALUES("21","63","76","3","8","TRADE DEBTORS","14","2014-07-08 20:26:44");
INSERT INTO audit_log VALUES("22","63","76","1","8","TRADE DEBTORS","29","2014-07-08 20:26:56");
INSERT INTO audit_log VALUES("23","63","76","1","6","Harvey Tomato Co Pte Ltd","1","2014-07-08 20:27:07");
INSERT INTO audit_log VALUES("24","63","76","1","6","XYZ GmbH","2","2014-07-08 20:27:07");
INSERT INTO audit_log VALUES("25","63","76","1","6","Hitamoto Bank","3","2014-07-08 20:27:07");
INSERT INTO audit_log VALUES("26","63","76","1","6","XYZ Pte Ltd","4","2014-07-08 20:27:07");
INSERT INTO audit_log VALUES("27","63","76","1","6","Bee Hiang Pte Ltd","5","2014-07-08 20:27:07");
INSERT INTO audit_log VALUES("28","63","76","1","6","Macrohard Inc.","6","2014-07-08 20:27:07");
INSERT INTO audit_log VALUES("29","63","76","3","8","CARS","16","2014-07-08 20:30:33");
INSERT INTO audit_log VALUES("30","63","76","3","8","ACC. DEPN - CARS","17","2014-07-08 20:30:44");
INSERT INTO audit_log VALUES("31","63","76","3","8","F & F","18","2014-07-08 20:30:59");
INSERT INTO audit_log VALUES("32","63","76","3","8","ACC. DEPN - F & F","19","2014-07-08 20:31:17");
INSERT INTO audit_log VALUES("33","63","76","1","7","Storage Pte Ltd","1","2014-07-08 20:31:45");
INSERT INTO audit_log VALUES("34","63","76","1","7","CIC Pte Ltd","2","2014-07-08 20:31:45");
INSERT INTO audit_log VALUES("35","63","76","1","7","King King B.V.","3","2014-07-08 20:31:45");
INSERT INTO audit_log VALUES("36","63","76","1","7","Sheng Sheng GmbH","4","2014-07-08 20:31:45");
INSERT INTO audit_log VALUES("37","63","76","1","7","Merrari Pte Ltd","5","2014-07-08 20:31:45");
INSERT INTO audit_log VALUES("38","63","76","1","7","Sheng Sheng Pte Ltd","6","2014-07-08 20:31:45");
INSERT INTO audit_log VALUES("39","63","76","1","7","Peng Peng B.V.","7","2014-07-08 20:31:45");
INSERT INTO audit_log VALUES("40","63","76","1","7","XYZ GmbH","8","2014-07-08 20:31:45");
INSERT INTO audit_log VALUES("41","63","76","1","9","13","1","2014-07-08 20:33:29");
INSERT INTO audit_log VALUES("42","63","76","1","9","14","2","2014-07-08 20:34:36");
INSERT INTO audit_log VALUES("43","63","76","1","9","15","3","2014-07-08 20:34:59");
INSERT INTO audit_log VALUES("44","63","76","1","9","16","4","2014-07-08 20:35:23");
INSERT INTO audit_log VALUES("45","63","76","1","9","17","5","2014-07-08 20:36:05");
INSERT INTO audit_log VALUES("46","63","76","1","9","18","6","2014-07-08 20:36:27");
INSERT INTO audit_log VALUES("47","63","76","9","12","Logged In","2","2014-07-08 20:38:10");
INSERT INTO audit_log VALUES("48","63","76","1","9","23","7","2014-07-08 20:38:40");
INSERT INTO audit_log VALUES("49","63","76","1","9","6","8","2014-07-08 20:38:55");
INSERT INTO audit_log VALUES("50","63","76","1","9","2","9","2014-07-08 20:39:11");
INSERT INTO audit_log VALUES("51","63","76","1","9","3","10","2014-07-08 20:39:27");
INSERT INTO audit_log VALUES("52","63","76","1","9","12","11","2014-07-08 20:39:40");
INSERT INTO audit_log VALUES("53","63","76","1","9","4","12","2014-07-08 20:39:56");
INSERT INTO audit_log VALUES("54","63","76","1","9","7","13","2014-07-08 20:40:13");
INSERT INTO audit_log VALUES("55","63","76","1","9","8","14","2014-07-08 20:40:27");
INSERT INTO audit_log VALUES("56","63","76","9","12","Logged In","2","2014-07-08 20:46:08");
INSERT INTO audit_log VALUES("57","63","76","1","1","Income","1","2014-07-08 20:48:03");
INSERT INTO audit_log VALUES("58","63","76","6","1","Income","1","2014-07-08 20:48:03");
INSERT INTO audit_log VALUES("59","63","76","1","1","Income","2","2014-07-08 20:49:05");
INSERT INTO audit_log VALUES("60","63","76","6","1","Income","2","2014-07-08 20:49:05");
INSERT INTO audit_log VALUES("61","63","76","1","1","Income","3","2014-07-08 20:49:48");
INSERT INTO audit_log VALUES("62","63","76","6","1","Income","3","2014-07-08 20:49:48");
INSERT INTO audit_log VALUES("63","63","76","1","1","Income","4","2014-07-08 20:50:36");
INSERT INTO audit_log VALUES("64","63","76","6","1","Income","4","2014-07-08 20:50:36");
INSERT INTO audit_log VALUES("65","63","76","1","1","Income","5","2014-07-08 20:51:29");
INSERT INTO audit_log VALUES("66","63","76","6","1","Income","5","2014-07-08 20:51:29");
INSERT INTO audit_log VALUES("67","63","76","1","1","Income","6","2014-07-08 20:52:15");
INSERT INTO audit_log VALUES("68","63","76","6","1","Income","6","2014-07-08 20:52:15");
INSERT INTO audit_log VALUES("69","63","76","1","1","Income","7","2014-07-08 20:53:27");
INSERT INTO audit_log VALUES("70","63","76","6","1","Income","7","2014-07-08 20:53:27");
INSERT INTO audit_log VALUES("71","63","76","1","1","Income","8","2014-07-08 20:54:28");
INSERT INTO audit_log VALUES("72","63","76","6","1","Income","8","2014-07-08 20:54:28");
INSERT INTO audit_log VALUES("73","63","76","1","11","Income","1","2014-07-08 20:55:43");
INSERT INTO audit_log VALUES("74","63","76","1","11","Income","2","2014-07-08 20:56:31");
INSERT INTO audit_log VALUES("75","63","76","1","11","Income","3","2014-07-08 20:57:05");
INSERT INTO audit_log VALUES("76","63","76","1","11","Income","4","2014-07-08 20:57:49");
INSERT INTO audit_log VALUES("77","63","76","1","11","Income","5","2014-07-08 20:58:25");
INSERT INTO audit_log VALUES("78","63","76","1","11","Income","6","2014-07-08 20:59:01");
INSERT INTO audit_log VALUES("79","63","76","1","11","Income","7","2014-07-08 20:59:40");
INSERT INTO audit_log VALUES("80","63","76","1","11","Income","8","2014-07-08 21:00:02");
INSERT INTO audit_log VALUES("81","63","76","1","2","Expense","1","2014-07-08 21:01:40");
INSERT INTO audit_log VALUES("82","63","76","6","2","Expense","1","2014-07-08 21:01:40");
INSERT INTO audit_log VALUES("83","63","76","1","2","Expense","2","2014-07-08 21:10:22");
INSERT INTO audit_log VALUES("84","63","76","6","2","Expense","2","2014-07-08 21:10:22");
INSERT INTO audit_log VALUES("85","63","76","1","2","Expense","3","2014-07-08 21:11:24");
INSERT INTO audit_log VALUES("86","63","76","6","2","Expense","3","2014-07-08 21:11:24");
INSERT INTO audit_log VALUES("87","63","76","1","2","Expense","4","2014-07-08 21:12:21");
INSERT INTO audit_log VALUES("88","63","76","6","2","Expense","4","2014-07-08 21:12:21");
INSERT INTO audit_log VALUES("89","63","76","1","2","Expense","5","2014-07-08 21:13:09");
INSERT INTO audit_log VALUES("90","63","76","6","2","Expense","5","2014-07-08 21:13:09");
INSERT INTO audit_log VALUES("91","63","76","1","2","Expense","6","2014-07-08 21:14:40");
INSERT INTO audit_log VALUES("92","63","76","6","2","Expense","6","2014-07-08 21:14:40");
INSERT INTO audit_log VALUES("93","63","76","1","2","Expense","7","2014-07-08 21:15:30");
INSERT INTO audit_log VALUES("94","63","76","6","2","Expense","7","2014-07-08 21:15:30");
INSERT INTO audit_log VALUES("95","63","76","1","2","Expense","8","2014-07-08 21:16:07");
INSERT INTO audit_log VALUES("96","63","76","6","2","Expense","8","2014-07-08 21:16:07");
INSERT INTO audit_log VALUES("97","63","76","1","2","Expense","9","2014-07-08 21:17:12");
INSERT INTO audit_log VALUES("98","63","76","6","2","Expense","9","2014-07-08 21:17:12");
INSERT INTO audit_log VALUES("99","63","76","1","2","Expense","10","2014-07-08 21:18:38");
INSERT INTO audit_log VALUES("100","63","76","6","2","Expense","10","2014-07-08 21:18:38");
INSERT INTO audit_log VALUES("101","63","76","1","11","Expense","1","2014-07-08 21:19:46");
INSERT INTO audit_log VALUES("102","63","76","1","11","Expense","2","2014-07-08 21:20:22");
INSERT INTO audit_log VALUES("103","63","76","1","11","Expense","3","2014-07-08 21:21:11");
INSERT INTO audit_log VALUES("104","63","76","1","11","Expense","4","2014-07-08 21:21:50");
INSERT INTO audit_log VALUES("105","63","76","1","11","Expense","5","2014-07-08 21:22:07");
INSERT INTO audit_log VALUES("106","63","76","1","11","Expense","6","2014-07-08 21:23:04");
INSERT INTO audit_log VALUES("107","63","76","1","11","Expense","7","2014-07-08 21:23:56");
INSERT INTO audit_log VALUES("108","63","76","1","11","Expense","8","2014-07-08 21:24:28");
INSERT INTO audit_log VALUES("109","63","76","1","11","Expense","9","2014-07-08 21:25:11");
INSERT INTO audit_log VALUES("110","63","76","1","11","Expense","10","2014-07-08 21:25:38");
INSERT INTO audit_log VALUES("111","63","76","9","12","Logged In","2","2014-07-09 09:59:51");
INSERT INTO audit_log VALUES("112","63","76","9","13","Logged Out","2","2014-07-09 10:10:10");
INSERT INTO audit_log VALUES("113","63","76","9","12","Logged In","2","2014-07-09 10:14:25");
INSERT INTO audit_log VALUES("114","63","76","9","12","Logged In","2","2014-07-09 11:35:33");
INSERT INTO audit_log VALUES("115","63","76","9","12","Logged In","2","2014-07-09 12:10:01");
INSERT INTO audit_log VALUES("116","63","76","9","13","Logged Out","2","2014-07-09 12:10:36");
INSERT INTO audit_log VALUES("117","63","84","9","12","Logged In","2","2014-07-09 12:10:47");
INSERT INTO audit_log VALUES("118","63","84","9","13","Logged Out","2","2014-07-09 12:13:21");
INSERT INTO audit_log VALUES("119","63","76","7","1","Income","3","2014-07-09 12:26:07");
INSERT INTO audit_log VALUES("120","63","76","2","1","Income","3","2014-07-09 12:26:33");
INSERT INTO audit_log VALUES("121","63","76","6","1","Income","3","2014-07-09 12:26:33");
INSERT INTO audit_log VALUES("122","63","76","9","12","Logged In","2","2014-07-09 13:16:52");
INSERT INTO audit_log VALUES("123","63","76","9","13","Logged Out","2","2014-07-09 13:30:10");
INSERT INTO audit_log VALUES("124","63","76","9","12","Logged In","2","2014-07-09 16:13:54");
INSERT INTO audit_log VALUES("125","63","76","9","13","Logged Out","2","2014-07-09 16:21:34");
INSERT INTO audit_log VALUES("126","63","76","9","12","Logged In","2","2014-07-10 15:32:30");
INSERT INTO audit_log VALUES("127","63","76","3","8","COMPUTERS","20","2014-07-10 15:33:47");
INSERT INTO audit_log VALUES("128","63","76","3","8","ACC. DEPN - COMPUTERS","21","2014-07-10 15:33:53");
INSERT INTO audit_log VALUES("129","63","76","3","8","BUILDINGS","22","2014-07-10 15:34:01");
INSERT INTO audit_log VALUES("130","63","76","3","8","ACC. DEPN - BUILDINGS","23","2014-07-10 15:34:07");
INSERT INTO audit_log VALUES("131","63","76","9","12","Logged In","2","2014-07-11 07:57:17");
INSERT INTO audit_log VALUES("132","63","76","9","13","Logged Out","2","2014-07-11 10:45:52");
INSERT INTO audit_log VALUES("133","63","76","9","12","Logged In","2","2014-07-11 11:40:30");
INSERT INTO audit_log VALUES("134","63","76","9","13","Logged Out","2","2014-07-11 11:42:59");
INSERT INTO audit_log VALUES("135","63","84","9","12","Logged In","2","2014-07-11 20:26:18");
INSERT INTO audit_log VALUES("136","63","84","9","13","Logged Out","2","2014-07-11 20:26:58");
INSERT INTO audit_log VALUES("137","63","76","9","12","Logged In","2","2014-07-12 08:31:15");
INSERT INTO audit_log VALUES("138","63","76","9","13","Logged Out","2","2014-07-12 08:37:45");
INSERT INTO audit_log VALUES("139","63","76","9","12","Logged In","2","2014-07-12 09:55:52");
INSERT INTO audit_log VALUES("140","63","76","9","13","Logged Out","2","2014-07-12 10:01:29");
INSERT INTO audit_log VALUES("141","63","76","9","12","Logged In","2","2014-07-12 17:53:13");
INSERT INTO audit_log VALUES("142","63","76","9","13","Logged Out","2","2014-07-12 17:53:50");
INSERT INTO audit_log VALUES("143","63","84","9","12","Logged In","2","2014-07-12 19:39:09");
INSERT INTO audit_log VALUES("144","63","84","9","13","Logged Out","2","2014-07-12 19:42:05");
INSERT INTO audit_log VALUES("145","63","84","9","12","Logged In","2","2014-07-13 07:34:05");
INSERT INTO audit_log VALUES("146","63","76","9","12","Logged In","2","2014-07-13 08:01:02");
INSERT INTO audit_log VALUES("147","63","76","9","13","Logged Out","2","2014-07-13 08:12:44");
INSERT INTO audit_log VALUES("148","63","84","9","12","Logged In","2","2014-07-13 15:52:03");
INSERT INTO audit_log VALUES("149","63","84","7","1","Income","7","2014-07-13 15:53:00");
INSERT INTO audit_log VALUES("150","63","84","2","1","Income","1","2014-07-13 15:53:26");
INSERT INTO audit_log VALUES("151","63","84","6","1","Income","7","2014-07-13 15:53:26");
INSERT INTO audit_log VALUES("152","63","76","9","12","Logged In","2","2014-07-13 15:54:00");
INSERT INTO audit_log VALUES("153","63","84","9","12","Logged In","2","2014-07-14 08:55:59");
INSERT INTO audit_log VALUES("154","63","84","9","12","Logged In","2","2014-07-14 17:49:29");
INSERT INTO audit_log VALUES("155","63","84","9","13","Logged Out","2","2014-07-14 17:51:11");





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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO customers VALUES("1","63","CUS-0000000001","Harvey Tomato Co Pte Ltd","123 Address Road","","198000000B","69453482","","Singapore","Singapore","SG","","","","546080","0000-00-00","29","","1","2014-07-08 20:27:07","0000-00-00 00:00:00");
INSERT INTO customers VALUES("2","63","CUS-0000000002","XYZ GmbH","123 Address Road","","198000000D","69453483","","Singapore","Singapore","SG","","","","546080","0000-00-00","29","","1","2014-07-08 20:27:07","0000-00-00 00:00:00");
INSERT INTO customers VALUES("3","63","CUS-0000000003","Hitamoto Bank","123 Address Road","","198000000F","69453484","","Singapore","Singapore","SG","","","","546080","0000-00-00","28","","1","2014-07-08 20:27:07","0000-00-00 00:00:00");
INSERT INTO customers VALUES("4","63","CUS-0000000004","XYZ Pte Ltd","123 Address Road","","198000000H","69453485","","Singapore","Singapore","SG","","","","546080","0000-00-00","28","","1","2014-07-08 20:27:07","0000-00-00 00:00:00");
INSERT INTO customers VALUES("5","63","CUS-0000000005","Bee Hiang Pte Ltd","123 Address Road","","198000000K","69453486","","Singapore","Singapore","SG","","","","546080","0000-00-00","29","","1","2014-07-08 20:27:07","0000-00-00 00:00:00");
INSERT INTO customers VALUES("6","63","CUS-0000000006","Macrohard Inc.","123 Address Road","","198000000M","69453487","","Singapore","Singapore","SG","","","","546080","0000-00-00","29","","1","2014-07-08 20:27:07","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction VALUES("1","63","EXP-0000000001","2011-11-01","A1245","1","","2","2011-12-01","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","9","2011-12-10","1","2014-07-08 21:01:40","2014-07-08 21:19:46");
INSERT INTO expense_transaction VALUES("2","63","EXP-0000000002","2011-11-10","B5263","2","","2","2011-12-10","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","10","2011-12-10","1","2014-07-08 21:10:22","2014-07-08 21:20:22");
INSERT INTO expense_transaction VALUES("3","63","EXP-0000000003","2011-11-10","135286","3","","2","2011-12-10","SGD","0.00000","0.00","","2","0.00","IG30023514H","","","0","1","1","11","2011-11-10","1","2014-07-08 21:11:24","2014-07-08 21:21:11");
INSERT INTO expense_transaction VALUES("4","63","EXP-0000000004","2011-11-10","1134","4","","2","2011-12-10","SGD","0.00000","0.00","","2","0.00","ME10101233Y","","","0","1","1","12","2011-11-10","1","2014-07-08 21:12:21","2014-07-08 21:21:50");
INSERT INTO expense_transaction VALUES("5","63","EXP-0000000005","2011-11-10","1136","4","","2","2011-12-10","SGD","0.00000","0.00","","2","0.00","ME10101233Y","","","0","1","1","13","2011-11-10","1","2014-07-08 21:13:09","2014-07-08 21:22:07");
INSERT INTO expense_transaction VALUES("6","63","EXP-0000000006","2011-11-10","F555888","5","","2","2011-12-10","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","14","2012-01-01","1","2014-07-08 21:14:40","2014-07-08 21:23:04");
INSERT INTO expense_transaction VALUES("7","63","EXP-0000000007","2011-11-10","1138","6","","2","2011-12-10","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","15","2011-12-10","1","2014-07-08 21:15:30","2014-07-08 21:23:56");
INSERT INTO expense_transaction VALUES("8","63","EXP-0000000008","2011-11-10","1140","7","","2","2011-12-10","SGD","0.00000","0.00","","2","0.00","N/A","","","0","1","1","16","2012-02-02","1","2014-07-08 21:16:07","2014-07-08 21:24:28");
INSERT INTO expense_transaction VALUES("9","63","EXP-0000000009","2011-11-01","1141","1","","2","2011-12-01","USD","1.22000","875.00","","2","0.00","N/A","","","0","1","1","17","2011-12-10","1","2014-07-08 21:17:12","2014-07-08 21:25:11");
INSERT INTO expense_transaction VALUES("10","63","EXP-0000000010","2011-10-28","1142","8","","2","2011-11-27","USD","1.22000","0.00","","2","0.00","N/A","","","0","1","1","18","2011-10-28","1","2014-07-08 21:18:38","2014-07-08 21:25:38");





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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO expense_transaction_list VALUES("1","1","27","","PSS4 game sets","1","5000.00","7","7.00","2014-07-08 21:01:40","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("2","2","27","","Travel Insurance","1","5000.00","8","0.00","2014-07-08 21:10:22","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("3","3","27","","Office Chairs","1","50000.00","9","7.00","2014-07-08 21:11:24","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("4","4","27","","Tony Maio Computer sets","1","100000.00","10","0.00","2014-07-08 21:12:21","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("5","5","27","","Tony Maio Computer sets","1","100000.00","11","7.00","2014-07-08 21:13:09","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("6","6","27","","1 Merrari 599 GTO","1","1000000.00","12","7.00","2014-07-08 21:14:40","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("7","7","27","","Unit 14D at The Patterson Edge","1","50000.00","13","0.00","2014-07-08 21:15:30","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("8","8","27","","1000 desks","1","50000.00","14","0.00","2014-07-08 21:16:07","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("9","9","27","","PSS4 game sets","1","10000.00","7","7.00","2014-07-08 21:17:12","0000-00-00 00:00:00");
INSERT INTO expense_transaction_list VALUES("10","10","27","","Consultancy Services","1","25000.00","14","0.00","2014-07-08 21:18:38","0000-00-00 00:00:00");





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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO income_transaction VALUES("1","63","INC-0000000001","2011-10-28","1002","1","","3","SGD","0.00000","24","Hitichi Television sets","5000.00","","1","7.00","0","1","1","1","2011-10-28","1","2014-07-08 20:48:03","2014-07-08 20:55:43");
INSERT INTO income_transaction VALUES("2","63","INC-0000000002","2011-10-28","1004","2","","3","SGD","0.00000","24","Consultancy Services","1000.00","","2","0.00","0","1","1","2","2011-10-28","1","2014-07-08 20:49:05","2014-07-08 20:56:31");
INSERT INTO income_transaction VALUES("3","63","INC-0000000003","2011-02-02","1006","3","","3","SGD","0.00000","25","Interest Income Received","650.00","","3","0.00","0","1","1","3","2011-10-28","1","2014-07-08 20:49:48","2014-07-09 12:26:07");
INSERT INTO income_transaction VALUES("4","63","INC-0000000004","2011-10-28","1123","4","","3","SGD","0.00000","26","Lease of One Rochester, Unit 11B","3500.00","","4","0.00","0","1","1","4","2011-11-01","1","2014-07-08 20:50:36","2014-07-08 20:57:49");
INSERT INTO income_transaction VALUES("5","63","INC-0000000005","2011-11-01","1120","5","","3","SGD","0.00000","24","Hamper Gift for Opening Ceremony","1000.00","","5","7.00","0","1","1","5","2011-11-01","1","2014-07-08 20:51:29","2014-07-08 20:58:25");
INSERT INTO income_transaction VALUES("6","63","INC-0000000006","2011-11-10","1126","6","","3","SGD","0.00000","24","Semiconductor Chips","10000.00","","6","0.00","0","1","1","6","2011-11-01","1","2014-07-08 20:52:15","2014-07-08 20:59:01");
INSERT INTO income_transaction VALUES("7","63","INC-0000000007","2011-10-28","1075","1","","3","USD","1.22000","24","Sale of Hitichi Television sets","6500.00","","1","7.00","0","1","1","7","2011-10-28","1","2014-07-08 20:53:27","2014-07-13 15:53:00");
INSERT INTO income_transaction VALUES("8","63","INC-0000000008","2011-10-28","1100","2","","3","USD","1.22000","24","Consultancy services","1000.00","","2","0.00","0","1","1","8","2011-10-28","1","2014-07-08 20:54:28","2014-07-08 21:00:02");





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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO income_transaction_audit VALUES("1","7","2011-10-28","1075","1","","3","USD","1.22000","24","Sale of Hitichi Television sets","6500.00","","1","7.00","0","2","2014-07-13 15:53:26");





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

INSERT INTO invoice_credit_note_customization VALUES("1","2","","2","INV","0","CR","0","2","5","SGD","1");





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

INSERT INTO notifications VALUES("1","1","2","2014-07-08 19:29:43","0000-00-00 00:00:00");





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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

INSERT INTO payments VALUES("1","2","0.00","Receipt for Hitichi Television sets","1","2014-07-08 20:55:43","0000-00-00 00:00:00","1","2011-10-28","0000-00-00","13","5350.00","1","");
INSERT INTO payments VALUES("2","2","0.00","Receipt for Consultancy services","1","2014-07-08 20:56:31","0000-00-00 00:00:00","2","2011-10-28","0000-00-00","13","1000.00","1","");
INSERT INTO payments VALUES("3","2","0.00","Receipt for Interest income received","1","2014-07-08 20:57:05","0000-00-00 00:00:00","3","2011-10-28","0000-00-00","13","650.00","1","");
INSERT INTO payments VALUES("4","2","0.00","Receipt for Lease of One Rochester, Unit 11B","1","2014-07-08 20:57:49","0000-00-00 00:00:00","4","2011-11-01","0000-00-00","13","3500.00","1","");
INSERT INTO payments VALUES("5","2","0.00","Receipt for Hamper gift for opening ceremony","1","2014-07-08 20:58:25","0000-00-00 00:00:00","5","2011-11-01","0000-00-00","13","1070.00","1","");
INSERT INTO payments VALUES("6","2","0.00","Receipt for Semiconductor chips ","1","2014-07-08 20:59:01","0000-00-00 00:00:00","6","2011-11-01","0000-00-00","13","10000.00","1","");
INSERT INTO payments VALUES("7","2","0.00","Receipt for Hitichi Television sets","1","2014-07-08 20:59:40","0000-00-00 00:00:00","7","2011-10-28","0000-00-00","13","8485.10","1","");
INSERT INTO payments VALUES("8","2","0.00","Receipt for Consultancy services","1","2014-07-08 21:00:02","0000-00-00 00:00:00","8","2011-10-28","0000-00-00","13","1220.00","1","");
INSERT INTO payments VALUES("9","2","0.00","Payment for PSS4 game sets","2","2014-07-08 21:19:46","0000-00-00 00:00:00","1","2011-12-10","0000-00-00","13","5350.00","1","");
INSERT INTO payments VALUES("10","2","0.00","Payment for Travel Insurance","2","2014-07-08 21:20:22","0000-00-00 00:00:00","2","2011-12-10","0000-00-00","13","5000.00","1","");
INSERT INTO payments VALUES("11","2","0.00","Payment for Office chairs","2","2014-07-08 21:21:11","0000-00-00 00:00:00","3","2011-11-10","0000-00-00","13","53500.00","1","");
INSERT INTO payments VALUES("12","2","0.00","Payment for Tony Maio Computer sets","2","2014-07-08 21:21:50","0000-00-00 00:00:00","4","2011-11-10","0000-00-00","13","100000.00","1","");
INSERT INTO payments VALUES("13","2","0.00","Payment for Tony Maio Computer sets","2","2014-07-08 21:22:07","0000-00-00 00:00:00","5","2011-11-10","0000-00-00","13","107000.00","1","");
INSERT INTO payments VALUES("14","2","0.00","Payment for 1 Merrari 599 GTO","2","2014-07-08 21:23:04","0000-00-00 00:00:00","6","2012-01-01","0000-00-00","13","1070000.00","1","");
INSERT INTO payments VALUES("15","2","0.00","Payment for Unit 14D at The Patterson Edge","2","2014-07-08 21:23:56","0000-00-00 00:00:00","7","2011-12-10","0000-00-00","13","50000.00","1","");
INSERT INTO payments VALUES("16","2","0.00","Payment for 1000 desks","2","2014-07-08 21:24:27","0000-00-00 00:00:00","8","2012-02-02","0000-00-00","13","50000.00","1","");
INSERT INTO payments VALUES("17","2","0.00","Payment for PSS4 game sets ","2","2014-07-08 21:25:11","0000-00-00 00:00:00","9","2011-12-10","0000-00-00","13","13075.00","1","");
INSERT INTO payments VALUES("18","2","0.00","Payment for Consultancy services","2","2014-07-08 21:25:38","0000-00-00 00:00:00","10","2011-10-28","0000-00-00","13","30500.00","1","");





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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO taxcodes VALUES("1","63","13","7.00","Standard-rated supplies with GST charged","2","1","2014-07-08 20:33:29","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("2","63","14","0.00","Zero-rated supplies","2","1","2014-07-08 20:34:36","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("3","63","15","0.00","Regulation 33 Exempt supplies","2","1","2014-07-08 20:34:59","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("4","63","16","0.00","Non Regulation 33 Exempt supplies","2","1","2014-07-08 20:35:23","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("5","63","17","7.00","Deemed supplies (e.g. transfer or disposal of business assets without consideration)","2","1","2014-07-08 20:36:05","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("6","63","18","0.00","Out-of-scope Supplies","2","1","2014-07-08 20:36:27","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("7","63","23","7.00","Purchases with GST incurred at 7% and directly attributable to taxable supplies","1","1","2014-07-08 20:38:40","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("8","63","6","0.00","Purchases from  GST-registered supplier with no GST incurred. (e.g. supplier provides transportation of goods that qualify as international service)","1","1","2014-07-08 20:38:55","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("9","63","2","7.00","GST incurred for import of goods","1","1","2014-07-08 20:39:11","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("10","63","3","0.00","Imports under special scheme with no GST incurred (e.g. Major Exporter Scheme, 3rd Party Logistic Scheme)","1","1","2014-07-08 20:39:27","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("11","63","12","7.00","Imports where the GST is suspended until the filing date of the GST return","1","1","2014-07-08 20:39:40","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("12","63","4","7.00","Purchases with GST incurred but not claimable under Regulations 26/27 (e.g. medical expenses for staff)","1","1","2014-07-08 20:39:56","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("13","63","7","0.00","Purchases exempted from GST. (e.g. purhcase of residential property or financial services)","1","1","2014-07-08 20:40:13","0000-00-00 00:00:00");
INSERT INTO taxcodes VALUES("14","63","8","0.00","Purchase transactions which is out of the scope of GST legislation (e.g. purchase of goods overseas)","1","1","2014-07-08 20:40:27","0000-00-00 00:00:00");





CREATE TABLE `theme_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `default_theme` tinyint(2) NOT NULL COMMENT '1 - Default, 2 - Not Default',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO theme_setting VALUES("1","Red","Basic Theme","1","2014-07-11 20:26:33");
INSERT INTO theme_setting VALUES("2","Black","Black Theme","2","2014-07-11 20:26:33");
INSERT INTO theme_setting VALUES("3","Blue","Blue Theme","2","2014-07-08 19:29:43");





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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO vendors VALUES("1","63","VEN-0000000001","Storage Pte Ltd","321 Address Road","","298000000B","69453481","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-08 20:31:45","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("2","63","VEN-0000000002","CIC Pte Ltd","321 Address Road","","298000000D","69453482","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-08 20:31:45","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("3","63","VEN-0000000003","King King B.V.","321 Address Road","","298000000F","69453483","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-08 20:31:45","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("4","63","VEN-0000000004","Sheng Sheng GmbH","321 Address Road","","298000000H","69453484","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-08 20:31:45","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("5","63","VEN-0000000005","Merrari Pte Ltd","321 Address Road","","298000000M","69453485","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-08 20:31:45","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("6","63","VEN-0000000006","Sheng Sheng Pte Ltd","321 Address Road","","298000000P","69453486","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-08 20:31:45","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("7","63","VEN-0000000007","Peng Peng B.V.","321 Address Road","","298000000R","69453487","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-08 20:31:45","0000-00-00 00:00:00");
INSERT INTO vendors VALUES("8","63","VEN-0000000008","XYZ GmbH","321 Address Road","","298000000S","69453488","","Singapore","Singapore","SG","","","","546080","0000-00-00","1","5","","2014-07-08 20:31:45","0000-00-00 00:00:00");



