<?php
/**
	* Data library
	* 
	* Constants of the application are loaded here
*/
class Account_Data /*extends Zend_View_Helper_GetTranslation*/
{
	public function Account_Data()
	{
		try {
			//$this->translator = new Zend_View_Helper_Translate(Zend_Registry::get('Zend_Translate'));
			$this->setData();
		} catch (Exception $exception) {
			echo '<br>==>' . $exception->getMessage();
		}
	}
	/**
		* Perpage [ADMIN]
		*
		* @var array perpage
	*/
	private $_perpage = array('5' => '5', '10' => '10', '20' => '20', '30' => '30', '40' => '40', '50' => '50');
	/**
		* default perpage [ADMIN]
		* 
		* @var string default perpage value
	*/
	private $_defaultPerPage = '10';
	/**
		* user role values
		* 
		* @var array userRole
	*/
	private $_userRole;
	/**
		* gender values
		* 
		* @var array gender
	*/
	private $_gender;
	/**
		* uncategorized values
		* 
		* @var array unCategorized
	*/
	private $_unCategorized;
    /**
		* country values
		* 
		* @var array country
	*/
	private $_country;
	/**
		* currency values
		* 
		* @var array currencies
	*/
	private $_currencies;
	 /**
		* Account types
		* 
		* @var array account_types
	*/
	private $_account_types;
	/**
		* _documents values
		* 
		* @var array documentType
	*/
	private $_documentType;
	/**
		* _payment method values
		* 
		* @var array payMethod
	*/
	private $_payMethod;
	/**
		* qualification values
		* 
		* @var array qualification
	*/
	private $_qualification;
    /**
		* asset array values
		* 
		* @var array assetArray
	*/
    private $_accountArray;
	/**
		* account array values
		* 
		* @var array accountArray
	*/
	private $_assetArray;
	/**
		* liability array values
		* 
		* @var array liabilityArray
	*/
	private $_liabilityArray;
	/**
		* income array values
		* 
		* @var array incomeArray
	*/
	private $_incomeArray;
	/**
		* expense array values
		* 
		* @var array expenseArray
	*/
	private $_expenseArray;
	/**
		* equity array values
		* 
		* @var array equityArray
	*/
	private $_equityArray;
	/**
		* credit term array values
		* 
		* @var array creditTermArray
	*/
	private $_creditTermArray;
	/**
		* product/service title array
		* 
		* @var array productTitleArray
	*/
	private $_productTitleArray;
	/**
		* Correspondance possible en
		* 
		* @var array correspondancePossible
	*/
	
	private $_correspondancePossible = array('Anglais' => 'English', 'Italien' => 'Italian', 'Francais' => 'French', 'Espagnol' => 'Spanish',
												'Allemand' => 'German', 'Neerlandais' => 'Dutch');

	
	/**
	* Site multi language array.when add new language in emailimmo site please add that language in this array
	* 
	* @var array languageArray
	*/
	
	private $_languageArray	=	array('fr','en','pt','es');
	
	/**
	* Site Translation language array. when add new Translational language in emailimmo site please add that language in this array
	* 
	* @var array translationLanguageArray
	*/
	
	private $_translationLanguageArray	=	array('1'=>'French',
												  '31'=>'English',
												  '56'=>'Portuguese',
												  '27'=>'Spanish');
	

	
	public function setData() 
	{
				
				$this->_country = array(
								  "GB" => "United Kingdom",
								  "US" => "United States",
								  "AF" => "Afghanistan",
								  "AL" => "Albania",
								  "DZ" => "Algeria",
								  "AS" => "American Samoa",
								  "AD" => "Andorra",
								  "AO" => "Angola",
								  "AI" => "Anguilla",
								  "AQ" => "Antarctica",
								  "AG" => "Antigua And Barbuda",
								  "AR" => "Argentina",
								  "AM" => "Armenia",
								  "AW" => "Aruba",
								  "AU" => "Australia",
								  "AT" => "Austria",
								  "AZ" => "Azerbaijan",
								  "BS" => "Bahamas",
								  "BH" => "Bahrain",
								  "BD" => "Bangladesh",
								  "BB" => "Barbados",
								  "BY" => "Belarus",
								  "BE" => "Belgium",
								  "BZ" => "Belize",
								  "BJ" => "Benin",
								  "BM" => "Bermuda",
								  "BT" => "Bhutan",
								  "BO" => "Bolivia",
								  "BA" => "Bosnia And Herzegowina",
								  "BW" => "Botswana",
								  "BV" => "Bouvet Island",
								  "BR" => "Brazil",
								  "IO" => "British Indian Ocean Territory",
								  "BN" => "Brunei Darussalam",
								  "BG" => "Bulgaria",
								  "BF" => "Burkina Faso",
								  "BI" => "Burundi",
								  "KH" => "Cambodia",
								  "CM" => "Cameroon",
								  "CA" => "Canada",
								  "CV" => "Cape Verde",
								  "KY" => "Cayman Islands",
								  "CF" => "Central African Republic",
								  "TD" => "Chad",
								  "CL" => "Chile",
								  "CN" => "China",
								  "CX" => "Christmas Island",
								  "CC" => "Cocos (Keeling) Islands",
								  "CO" => "Colombia",
								  "KM" => "Comoros",
								  "CG" => "Congo",
								  "CD" => "Congo, The Democratic Republic Of The",
								  "CK" => "Cook Islands",
								  "CR" => "Costa Rica",
								  "CI" => "Cote D'Ivoire",
								  "HR" => "Croatia (Local Name: Hrvatska)",
								  "CU" => "Cuba",
								  "CY" => "Cyprus",
								  "CZ" => "Czech Republic",
								  "DK" => "Denmark",
								  "DJ" => "Djibouti",
								  "DM" => "Dominica",
								  "DO" => "Dominican Republic",
								  "TP" => "East Timor",
								  "EC" => "Ecuador",
								  "EG" => "Egypt",
								  "SV" => "El Salvador",
								  "GQ" => "Equatorial Guinea",
								  "ER" => "Eritrea",
								  "EE" => "Estonia",
								  "ET" => "Ethiopia",
								  "FK" => "Falkland Islands (Malvinas)",
								  "FO" => "Faroe Islands",
								  "FJ" => "Fiji",
								  "FI" => "Finland",
								  "FR" => "France",
								  "FX" => "France, Metropolitan",
								  "GF" => "French Guiana",
								  "PF" => "French Polynesia",
								  "TF" => "French Southern Territories",
								  "GA" => "Gabon",
								  "GM" => "Gambia",
								  "GE" => "Georgia",
								  "DE" => "Germany",
								  "GH" => "Ghana",
								  "GI" => "Gibraltar",
								  "GR" => "Greece",
								  "GL" => "Greenland",
								  "GD" => "Grenada",
								  "GP" => "Guadeloupe",
								  "GU" => "Guam",
								  "GT" => "Guatemala",
								  "GN" => "Guinea",
								  "GW" => "Guinea-Bissau",
								  "GY" => "Guyana",
								  "HT" => "Haiti",
								  "HM" => "Heard And Mc Donald Islands",
								  "VA" => "Holy See (Vatican City State)",
								  "HN" => "Honduras",
								  "HK" => "Hong Kong",
								  "HU" => "Hungary",
								  "IS" => "Iceland",
								  "IN" => "India",
								  "ID" => "Indonesia",
								  "IR" => "Iran (Islamic Republic Of)",
								  "IQ" => "Iraq",
								  "IE" => "Ireland",
								  "IL" => "Israel",
								  "IT" => "Italy",
								  "JM" => "Jamaica",
								  "JP" => "Japan",
								  "JO" => "Jordan",
								  "KZ" => "Kazakhstan",
								  "KE" => "Kenya",
								  "KI" => "Kiribati",
								  "KP" => "Korea, Democratic People's Republic Of",
								  "KR" => "Korea, Republic Of",
								  "KW" => "Kuwait",
								  "KG" => "Kyrgyzstan",
								  "LA" => "Lao People's Democratic Republic",
								  "LV" => "Latvia",
								  "LB" => "Lebanon",
								  "LS" => "Lesotho",
								  "LR" => "Liberia",
								  "LY" => "Libyan Arab Jamahiriya",
								  "LI" => "Liechtenstein",
								  "LT" => "Lithuania",
								  "LU" => "Luxembourg",
								  "MO" => "Macau",
								  "MK" => "Macedonia, Former Yugoslav Republic Of",
								  "MG" => "Madagascar",
								  "MW" => "Malawi",
								  "MY" => "Malaysia",
								  "MV" => "Maldives",
								  "ML" => "Mali",
								  "MT" => "Malta",
								  "MH" => "Marshall Islands",
								  "MQ" => "Martinique",
								  "MR" => "Mauritania",
								  "MU" => "Mauritius",
								  "YT" => "Mayotte",
								  "MX" => "Mexico",
								  "FM" => "Micronesia, Federated States Of",
								  "MD" => "Moldova, Republic Of",
								  "MC" => "Monaco",
								  "MN" => "Mongolia",
								  "MS" => "Montserrat",
								  "MA" => "Morocco",
								  "MZ" => "Mozambique",
								  "MM" => "Myanmar",
								  "NA" => "Namibia",
								  "NR" => "Nauru",
								  "NP" => "Nepal",
								  "NL" => "Netherlands",
								  "AN" => "Netherlands Antilles",
								  "NC" => "New Caledonia",
								  "NZ" => "New Zealand",
								  "NI" => "Nicaragua",
								  "NE" => "Niger",
								  "NG" => "Nigeria",
								  "NU" => "Niue",
								  "NF" => "Norfolk Island",
								  "MP" => "Northern Mariana Islands",
								  "NO" => "Norway",
								  "OM" => "Oman",
								  "PK" => "Pakistan",
								  "PW" => "Palau",
								  "PA" => "Panama",
								  "PG" => "Papua New Guinea",
								  "PY" => "Paraguay",
								  "PE" => "Peru",
								  "PH" => "Philippines",
								  "PN" => "Pitcairn",
								  "PL" => "Poland",
								  "PT" => "Portugal",
								  "PR" => "Puerto Rico",
								  "QA" => "Qatar",
								  "RE" => "Reunion",
								  "RO" => "Romania",
								  "RU" => "Russian Federation",
								  "RW" => "Rwanda",
								  "KN" => "Saint Kitts And Nevis",
								  "LC" => "Saint Lucia",
								  "VC" => "Saint Vincent And The Grenadines",
								  "WS" => "Samoa",
								  "SM" => "San Marino",
								  "ST" => "Sao Tome And Principe",
								  "SA" => "Saudi Arabia",
								  "SN" => "Senegal",
								  "SC" => "Seychelles",
								  "SL" => "Sierra Leone",
								  "SG" => "Singapore",
								  "SK" => "Slovakia (Slovak Republic)",
								  "SI" => "Slovenia",
								  "SB" => "Solomon Islands",
								  "SO" => "Somalia",
								  "ZA" => "South Africa",
								  "GS" => "South Georgia, South Sandwich Islands",
								  "ES" => "Spain",
								  "LK" => "Sri Lanka",
								  "SH" => "St. Helena",
								  "PM" => "St. Pierre And Miquelon",
								  "SD" => "Sudan",
								  "SR" => "Suriname",
								  "SJ" => "Svalbard And Jan Mayen Islands",
								  "SZ" => "Swaziland",
								  "SE" => "Sweden",
								  "CH" => "Switzerland",
								  "SY" => "Syrian Arab Republic",
								  "TW" => "Taiwan",
								  "TJ" => "Tajikistan",
								  "TZ" => "Tanzania, United Republic Of",
								  "TH" => "Thailand",
								  "TG" => "Togo",
								  "TK" => "Tokelau",
								  "TO" => "Tonga",
								  "TT" => "Trinidad And Tobago",
								  "TN" => "Tunisia",
								  "TR" => "Turkey",
								  "TM" => "Turkmenistan",
								  "TC" => "Turks And Caicos Islands",
								  "TV" => "Tuvalu",
								  "UG" => "Uganda",
								  "UA" => "Ukraine",
								  "AE" => "United Arab Emirates",
								  "UM" => "United States Minor Outlying Islands",
								  "UY" => "Uruguay",
								  "UZ" => "Uzbekistan",
								  "VU" => "Vanuatu",
								  "VE" => "Venezuela",
								  "VN" => "Viet Nam",
								  "VG" => "Virgin Islands (British)",
								  "VI" => "Virgin Islands (U.S.)",
								  "WF" => "Wallis And Futuna Islands",
								  "EH" => "Western Sahara",
								  "YE" => "Yemen",
								  "YU" => "Yugoslavia",
								  "ZM" => "Zambia",
								  "ZW" => "Zimbabwe"
				);

				$this->_account_types = array(
										  "1" => "Developer",
										  "2" => "Super User",
										  "3" => "Manager",
										  "4" => "User",
										  "5" => "Viewer"
										  );

				$this->_accountArray = array(
										  "1" => "Asset",
										  "2" => "Liability",
										  "3" => "Income",
										  "4" => "Expense",
										  "5" => "Equity"
										  );				

				$this->_currencies = array(
									    'AFA' => 'Afghan Afghani',
									    'AWG' => 'Aruban Florin',
									    'AUD' => 'Australian Dollars',
									    'ARS' => 'Argentine Pes',
									    'AZN' => 'Azerbaijanian Manat',
									    'BSD' => 'Bahamian Dollar',
									    'BDT' => 'Bangladeshi Taka',
									    'BBD' => 'Barbados Dollar',
									    'BYR' => 'Belarussian Rouble',
									    'BOB' => 'Bolivian Boliviano',
									    'BRL' => 'Brazilian Real',
									    'GBP' => 'British Pounds Sterling',
									    'BGN' => 'Bulgarian Lev',
									    'KHR' => 'Cambodia Riel',
									    'CAD' => 'Canadian Dollars',
									    'KYD' => 'Cayman Islands Dollar',
									    'CLP' => 'Chilean Peso',
									    'CNY' => 'Chinese Renminbi Yuan',
									    'COP' => 'Colombian Peso',
									    'CRC' => 'Costa Rican Colon',
									    'HRK' => 'Croatia Kuna',
									    'CPY' => 'Cypriot Pounds',
									    'CZK' => 'Czech Koruna',
									    'DKK' => 'Danish Krone',
									    'DOP' => 'Dominican Republic Peso',
									    'XCD' => 'East Caribbean Dollar',
									    'EGP' => 'Egyptian Pound',
									    'ERN' => 'Eritrean Nakfa',
									    'EEK' => 'Estonia Kroon',
									    'EUR' => 'Euro',
									    'GEL' => 'Georgian Lari',
									    'GHC' => 'Ghana Cedi',
									    'GIP' => 'Gibraltar Pound',
									    'GTQ' => 'Guatemala Quetzal',
									    'HNL' => 'Honduras Lempira',
									    'HKD' => 'Hong Kong Dollars',
									    'HUF' => 'Hungary Forint',
									    'ISK' => 'Icelandic Krona',
									    'INR' => 'Indian Rupee',
									    'IDR' => 'Indonesia Rupiah',
									    'ILS' => 'Israel Shekel',
									    'JMD' => 'Jamaican Dollar',
									    'JPY' => 'Japanese yen',
									    'KZT' => 'Kazakhstan Tenge',
									    'KES' => 'Kenyan Shilling',
									    'KWD' => 'Kuwaiti Dinar',
									    'LVL' => 'Latvia Lat',
									    'LBP' => 'Lebanese Pound',
									    'LTL' => 'Lithuania Litas',
									    'MOP' => 'Macau Pataca',
									    'MKD' => 'Macedonian Denar',
									    'MGA' => 'Malagascy Ariary',
									    'MYR' => 'Malaysian Ringgit',
									    'MTL' => 'Maltese Lira',
									    'BAM' => 'Marka',
									    'MUR' => 'Mauritius Rupee',
									    'MXN' => 'Mexican Pesos',
									    'MZM' => 'Mozambique Metical',
									    'NPR' => 'Nepalese Rupee',
									    'ANG' => 'Netherlands Antilles Guilder',
									    'TWD' => 'New Taiwanese Dollars',
									    'NZD' => 'New Zealand Dollars',
									    'NIO' => 'Nicaragua Cordoba',
									    'NGN' => 'Nigeria Naira',
									    'KPW' => 'North Korean Won',
									    'NOK' => 'Norwegian Krone',
									    'OMR' => 'Omani Riyal',
									    'PKR' => 'Pakistani Rupee',
									    'PYG' => 'Paraguay Guarani',
									    'PEN' => 'Peru New Sol',
									    'PHP' => 'Philippine Pesos',
									    'QAR' => 'Qatari Riyal',
									    'RON' => 'Romanian New Leu',
									    'RUB' => 'Russian Federation Ruble',
									    'SAR' => 'Saudi Riyal',
									    'CSD' => 'Serbian Dinar',
									    'SCR' => 'Seychelles Rupee',
									    'SGD' => 'Singapore Dollars',
									    'SKK' => 'Slovak Koruna',
									    'SIT' => 'Slovenia Tolar',
									    'ZAR' => 'South African Rand',
									    'KRW' => 'South Korean Won',
									    'LKR' => 'Sri Lankan Rupee',
									    'SRD' => 'Surinam Dollar',
									    'SEK' => 'Swedish Krona',
									    'CHF' => 'Swiss Francs',
									    'TZS' => 'Tanzanian Shilling',
									    'THB' => 'Thai Baht',
									    'TTD' => 'Trinidad and Tobago Dollar',
									    'TRY' => 'Turkish New Lira',
									    'AED' => 'UAE Dirham',
									    'USD' => 'US Dollars',
									    'UGX' => 'Ugandian Shilling',
									    'UAH' => 'Ukraine Hryvna',
									    'UYU' => 'Uruguayan Peso',
									    'UZS' => 'Uzbekistani Som',
									    'VEB' => 'Venezuela Bolivar',
									    'VND' => 'Vietnam Dong',
									    'AMK' => 'Zambian Kwacha',
									    'ZWD' => 'Zimbabwe Dollar',
									);

						
				$this->_productTitleArray = array(
										  "1" => "Product",
										  "2" => "Services",
										  "3" => "Product / Services"
										  );	
			

$this->_assetArray	=	array(
							'Bank'	=>	array(
												'Bank Cash'	=>	array(
																		'1'	=>	'Checking Account',
																		'2'	=>	'Saving Account',
																		'3'	=>	'Money Market Account',
																		'4'	=>	'Cash Management Account',
																		'5'	=>	'Other Bank Account'
																	)
											),
							'Current Asset'	=>	array(
														'Investment'	=>	array(
																					'6'	=>	'GIC & Term Deposit',
																					'7'	=>	'Certificate of Deposit',
																					'8'	=>	'Other Asset Account',
																					'9'	=>	'Borkerage Account',
																					'10'	=>	'Mutual Fund Account',
																					'11'	=>	'Shares',
																					'12'	=>	'Bonds',
																					'13'	=> 	'T-Bills',
																					'14'	=>	'Other Short Term Investment'
																				),
														'Other Current Assets'	=>	array(
																							'15'	=>	'Allowance for Bad Debt',
																							'16'	=>	'Sales Tax Receivable',
																							'17'	=>	'Notes & Loans Receivable',
																							'18'	=>	'Inventory',
																							'19'	=>	'Due From Related Party',
																							'20'	=>	'Perpaid Expenses',
																							'21'	=>	'Future (deferred) Incomes Taxes',
																							'22'	=>	'Accured Investment Income',
																							'23'	=>	'Taxes Recoverable/Refundable',
																							'24'	=>	'Other Current Accets'
																						 )
													),
							'Fixed Assets'	=>	array(
														'Long-Term Assets'	=>	array(
																						'25'	=>	'Land Improvments',
																						'26'	=>	'Accumulated Amortization of Land Improvements',
																						'27'	=>	'Depletable Assets',
																						'28'	=>	'Accumulated Amortization of Depletable Assets',
																						'29'	=>	'Resource Properties',
																						'30'	=>	'Accumulated Amortization of Resource Properties',
																						'31'	=>	'Buildings',
																						'32'	=>	'Accumulated Amortization of Buildings',
																						'33'	=>	'Machinery, equipment, furniture & fixtures',
																						'34'	=>	'Accumulated Amortization of Machinery, Equipment, Furniture & Fixtures',
																						'35'	=>	'Other Tangible Capital Assets',
																						'36'	=>	'Accumulated Amortization of Other Tangible Assets',
																						'37'	=>	'Goodwill',
																						'38'	=>	'Accumulated Amortization of Goodwill',
																						'39'	=>	'Incorporation Costs',
																						'40'	=>	'Accumulated Amortization of Incorporation Costs',
																						'41'	=>	'Resource Rights',
																						'42'	=>	'Accumulated Amortization of Resource Rights',
																						'43'	=>	'Other Intangible Assets',
																						'44'	=>	'Other Long Term Assets'
																					),
														'Long-Term Investments'	=>	array(
																							'45'	=>	'Whole Life Insurance',
																							'46'	=>	'Universal Life Insurance',
																							'47'	=>	'Term Life Insurance',
																							'48'	=>	'Annuity',
																							'49'	=>	'Other Investments'
																						)
													)
				);


		$this->_liabilityArray	=	array(
						'Current Liability'	=>	array(
														'Current Bank Debt'	=>	array(
																						'1'	=>	'Bank Overdraft',
																						'2'	=>	'Line of Credit',
																						'3'	=>	'Billing Accounts',
																						'4'	=>	'Credit Card',
																						'5'	=>	'Other Current Bank Debt'
																					),
														'Current Debt'	=>	array(
																					'6'	=>	'Other Short-Term Debt',
																					'7'	=>	'Shareholder Loan',
																					'8'	=>	'Due to Other Related Party',
																					'9'	=>	'Deposits Received',
																					'10'	=>	'Dividends Payable',
																					'11'	=>	'Taxes Payable',
																					'12'	=>	'Future (deferred) Income Taxes',
																					'13'	=>	'Other Current Debt',
																					'14'	=>	'Prepaid Income',
																					'15'	=>	'Sales Tax Payable',
																					'16'	=>	'Payroll Liabilities'
																				)
													),
						'Non-Current Liability'	=>	array(
															'Long-Term Debt'	=> array(
																							'17'	=>	'Mortgages',
																							'18'	=>	'Home Equity Loans',
																							'19'	=>	'Loans',
																							'20'	=>	'Other Long-Term Debt'
																						)
														)
					);

		$this->_incomeArray	=	array(
				   'Income'	=>	array(
						'Agriculture'	=>	array(
													'1'	=>	'Agricultural Program Payments',
													'2'	=>	'Commodity Credit Loans',
													'3'	=>	'Cooperative Distributions',
													'4'	=>	'Crop Insurance Proceeds',
													'5'	=>	'Crop Sales',
													'6'	=>	'Custom Hire Income',
													'7'	=>	'Farmers Market Sales',
													'8'	=>	'Livestock Sales',
													'9'	=>	'Other Agriculture Revenue'
												),
						'Commissions'	=>	array(
													'10'	=>	'Commission Income',
													'12'	=>	'Commission Adjustments',
													'13'	=>	'Other Commission Income'
												),
						'Fees & Charges'	=>	array(
														'14'	=>	'Finance Charge Income'
													),
						'Investments'	=>	array(
													'15'	=>	'Investments -> Dividends',
													'16'	=>	'Investments -> Interest',
													'17'	=>	'Investments -> Asset Sales',
													'18'	=>	'Investments -> Other Investment Revenue',
													'19'	=>	'Other Investment Revenue'
												),
						'Non-Profit'	=>	array(
													'20'	=>	'Benevolence Offerings',
													'21'	=>	'Building Fund',
													'22'	=>	'Children\'s Church Offering',
													'23'	=>	'Direct Public Grants -> Corporate and Business',
													'24'	=>	'Direct Public Grants -> Foundation and Trust Grants',
													'25'	=>	'Direct Public Grants -> Nonprofit Organization Grants',
													'26'	=>	'Direct Public Support -> Corporate Contributions',
													'27'	=>	'Direct Public Support -> Donated Art',
													'28'	=>	'Direct Public Support -> Donated Professional Fees or Facilities',
													'29'	=>	'Direct Public Support -> Gifts in Kind',
													'30'	=>	'Direct Public Support -> Business Contributions',
													'31'	=>	'Direct Public Support -> Individual Contributions',
													'32'	=>	'Direct Public Support -> Legacies and Bequests',
													'33'	=>	'Direct Public Support -> Uncollectible Pledges',
													'34'	=>	'Direct Public Support -> Volunteer Services',
													'35'	=>	'General Fund',
													'36'	=>	'Government Contracts -> Agency',
													'37'	=>	'Government Contracts -> Federal',
													'38'	=>	'Government Contracts -> Local Government',
													'39'	=>	'Government Contracts -> State or Provincial',
													'40'	=>	'Government Grants -> Agency',
													'41'	=>	'Government Grants -> Federal',
													'42'	=>	'Government Grants -> Local Government',
													'43'	=>	'Government Grants -> State or Provincial',
													'44'	=>	'Indirect Public Support',
													'45'	=>	'Mission Offerings',
													'46'	=>	'Program Income -> Member Assessments',
													'47'	=>	'Program Income -> Membership Dues',
													'48'	=>	'Program Income -> Program Service Fees',
													'49'	=>	'Pledges',
													'50'	=>	'Youth Group'
												),
						'Other Income'	=>	array(
													'51'	=>	'Proceeds from Sale of Assets',
													'52'	=>	'Insurance Proceeds Received',
													'53'	=>	'Interest Income'
												),
						'Professional Services'	=>	array(
															'54'	=>	'Accounting Services',
															'55'	=>	'Bookkeeping Services',
															'56'	=>	'Legal Fees',
															'57'	=>	'Non-Medical Income',
															'58'	=>	'Other Medical Income',
															'59'	=>	'Payroll Services',
															'60'	=>	'Tax Preparation Services',
															'61'	=>	'Other Professional Services'
														),
						'Sales Products & Services'	=>	array(
																'62'	=>	'Bar Sales',
																'63'	=>	'Booth Rental Income',
																'64'	=>	'Construction Income',
																'65'	=>	'Consulting Income',
																'66'	=>	'Design Income',
																'67'	=>	'Facial Treatments',
																'68'	=>	'Food & Beverage Sales',
																'69'	=>	'Gift Shop & Vending Sales',
																'70'	=>	'Gross Trucking Income',
																'71'	=>	'Hair Coloring Services',
																'72'	=>	'Installation Services',
																'73'	=>	'Inventory Sales',
																'74'	=>	'Job Income',
																'75'	=>	'Lodging',
																'76'	=>	'Maintenance Services',
																'77'	=>	'Manicure/Pedicure',
																'78'	=>	'Massage Services',
																'79'	=>	'Rental Income',
																'80'	=>	'Sales -> Retail Products',
																'81'	=>	'Security Sales',
																'82'	=>	'Services',
																'83'	=>	'Special Events Income',
																'84'	=>	'Photo & Video Services Income',
																'85'	=>	'Product Sales',
																'86'	=>	'Royalties Received',
																'87'	=>	'Seminars',
																'88'	=>	'Special Services',
																'89'	=>	'Tape & Book Sales',
																'90'	=>	'Labor Income',
																'91'	=>	'Parts & Materials Sales',
																'92'	=>	'Sales -> Software',
																'93'	=>	'Sales -> Software Subscription',
																'94'	=>	'Sales -> Support and Maintenance',
																'95'	=>	'Shipping & Delivery Income',
																'96'	=>	'Coaching',
																'97'	=>	'Training',
																'98'	=>	'Assessments',
																'99'	=>	'Facilitation',
																'100'	=>	'Other Products & Services',
																'101'	=>	'Reimbursed Expenses'
															)
								)
							);

			$this->_expenseArray	=	array(
						'Cost of Goods'	=>	array(
													'Cost of Goods'	=>	array(
																				'1'	=>	'Merchant Account Fees',
																				'2'	=>	'Subcontracted Services'
																			)
												),
						'Expense'	=>	array(
													'Agriculture'	=>	array(
																				'3'	=>	'Chemicals Purchased',
																				'4'	=>	'Custom Hire & Contract Labor',
																				'5'	=>	'Feed Purchased',
																				'6'	=>	'Fertilizers & Lime',
																				'7'	=>	'Freight & Trucking',
																				'8'	=>	'Gasoline, Fuel & Oil',
																				'9'	=>	'Seed & Plants Purchased',
																				'10'	=>	'Vaccines & Medicines',
																				'11'	=>	'Veterinary, Breeding, Medicine',
																				'12'	=>	'Other Agriculture Expense'
																			),
													'Buildings & Equipment'	=>	array(
																						'13'	=>	'Equipment Lease or Rental'
																					 ),
													'Computers/Communication'	=>	array(
																							'14'	=>	'Other Computer & Communication'
																						 ),
													'Fees, Charges & Subscriptions'	=>	array(
																								'15'	=>	'Business Licenses & Permits',
																								'16'	=>	'Dues & Subscriptions'
																							 ),
													'Insurance'	=>	array(
																			'17'	=>	'Insurance -> Life & Disability',
																			'18'	=>	'Insurance -> Worker\'s Compensation',
																			'19'	=>	'Insurance -> Professional Liability',
																			'20'	=>	'Insurance -> General Liability',
																			'21'	=>	'Insurance -> Health'
																		),
													'Non-Profit'	=>	array(
																				'22'	=>	'Awards & Grants',
																				'23'	=>	'Evangelism & Special Events',
																				'24'	=>	'Ministry Expenses',
																				'25'	=>	'Other Non-Profit Expenses'
																			 ),
													'Office'	=>	array(
																			'26'	=>	'Janitorial Expense',
																			'27'	=>	'Postage & Delivery',
																			'28'	=>	'Printing and Reproduction'
																		 ),
													'Other Expenses'	=>	array(
																					'29'	=>	'Donations',
																					'30'	=>	'Miscellaneous Expense',
																					'31'	=>	'Political Contributions'
																				 ),
													'Payroll'	=>	array(
																			'32'	=>	'Management Fees',
																			'33'	=>	'Payroll -> Commissions',
																			'34'	=>	'Payroll -> Bonuses',
																			'35'	=>	'Other Payroll',
																			'36'	=>	'Payroll -> Tax',
																			'37'	=>	'Payroll -> Employee Expenses Paid'
																		 ),
													'Services'	=>	array(
																			'38'	=>	'Education & Training'
																		 ),
													'Taxes'	=>	array(
																		'39'	=>	'Taxes -> Property Tax'
																	 ),
													'Tools & Supplies'	=>	array(
																					'40'	=>	'Linen Expense',
																					'41'	=>	'Medical Supplies',
																					'42'	=>	'Salon Supplies, Linens, Laundry',
																					'43'	=>	'Small Medical Equipment',
																					'44'	=>	'Small Tools & Equipment',
																					'45'	=>	'Uniforms',
																					'46'	=>	'Other Tools & Supplies'
																				 ),
													'Vehicle Expenses'	=>	array(
																					'47'	=>	'Vehicle -> Lease Payments'
																				 )
											)
					);

		$this->_equityArray	=	array(
					'Equity'	=>	array(
											'Equity'	=>	array(
																	'1'	=>	'Owner Investment / Drawings'
																 )
										  )
				 );	

						$this->_creditTermArray = array(
												  "1" => "Upon Receipt (Cash)",
												  "2" => "30",
												  "3" => "60",
												  "4" => "90",
												  "5" => "120"
												  );
						$this->_payMethod = array(
												  "1" => "Bank Transfer",
												  "2" => "Cheque",
												  "3" => "Cash",
												  "4" => "Credit Card",
												  "5" => "Other"
												  );

/*												$this->_purchaseTaxCodes = array(
														"1" => "TX7",
														"2" => "IM",
														"3" => "ME",
														"4" => "BL",
														"5" => "NR",
														"6" => "ZP",
														"7" => "EP",
														"8" => "OP",
														"9" => "TX-E33",
														"10" => "TX-N33",
														"11" => "TX-RE"
														);*/

						$this->_purchaseTaxCodes = array(
														"1" => array(
																	"name" => "TX7",
																	"percentage" => "7.00",
																	"description" => "Purchases with GST incurred at 7% and directly attributable to taxable supplies"
																	),
														"2" => array(
																	"name" => "IM",
																	"percentage" => "7.00",
																	"description" => "GST incurred for import of goods"
																	),
														"3" => array(
																	"name" => "ME",
																	"percentage" => "0.00",
																	"description" => "Imports under special scheme with no GST incurred (e.g. Major Exporter Scheme, 3rd Party Logistic Scheme)"
																	),
														"4" => array(
																	"name" => "BL",
																	"percentage" => "7.00",
																	"description" => "Purchases with GST incurred but not claimable under Regulations 26/27 (e.g. medical expenses for staff)"
																	),
														"5" => array(
																	"name" => "NR",
																	"percentage" => "0.00",
																	"description" => "Purchases from non GST-registered supplier with no GST incurred"
																	),
														"6" => array(
																	"name" => "ZP",
																	"percentage" => "0.00",
																	"description" => "Purchases from  GST-registered supplier with no GST incurred. (e.g. supplier provides transportation of goods that qualify as international service)"
																	),
														"7" => array(
																	"name" => "EP",
																	"percentage" => "0.00",
																	"description" => "Purchases exempted from GST. (e.g. purhcase of residential property or financial services)"
																	),
														"8" => array(
																	"name" => "OP",
																	"percentage" => "0.00",
																	"description" => "Purchase transactions which is out of the scope of GST legislation (e.g. purchase of goods overseas)"
																	),
														"9" => array(
																	"name" => "TX-E33",
																	"percentage" => "7.00",
																	"description" => "GST incurred directly attributable to Regulation 33 exempt supplies"
																	),
														"10" => array(
																	"name" => "TX-N33",
																	"percentage" => "7.00",
																	"description" => "GST incurred directly attributable to Non-Regulation 33 exempt supplies"
																	),
														"11" => array(
																	"name" => "TX-RE",
																	"percentage" => "7.00",
																	"description" => "GST incurred that is not directly attributable to taxable or exempt supplies"
																	)
														);

						$this->_supplyTaxCodes =   array(
														"1" => array(
																	"name" => "SR",
																	"percentage" => "7.00",
																	"description" => "Standard-rated supplies with GST charged"
																	),
														"2" => array(
																	"name" => "ZR",
																	"percentage" => "0.00",
																	"description" => "Zero-rated supplies"
																	),
														"3" => array(
																	"name" => "ES33",
																	"percentage" => "0.00",
																	"description" => "Regulation 33 Exempt supplies"
																	),
														"4" => array(
																	"name" => "ESN33",
																	"percentage" => "0.00",
																	"description" => "Non Regulation 33 Exempt supplies"
																	),
														"5" => array(
																	"name" => "DS",
																	"percentage" => "7.00",
																	"description" => "Deemed supplies (e.g. transfer or disposal of business assets without consideration)"
																	),
														"6" => array(
																	"name" => "OS",
																	"percentage" => "0.00",
																	"description" => "Out-of-scope Supplies"
																	)
														);
					

	}
	
	/**
		* this function will be helpful in deleting the folder
		* $dirname should be end-up with slash
	 **/
	function delete_directory($dirname)  {
	    if (is_dir($dirname))
	       $dir_handle = opendir($dirname);
	    if (!$dir_handle)
	       return false;
	    while($file = readdir($dir_handle)) {
	       if ($file != "." && $file != "..") {
	          if (!is_dir($dirname."/".$file))
	             unlink($dirname."/".$file);
	          else
	             $this->delete_directory($dirname.'/'.$file);    
	       }
	    }
	    closedir($dir_handle);
	    rmdir($dirname);
	    return true;
	 }
	/**
		* gets the form data and check if it set
		* 
		* @param	array		array of total fields
		* @param	array		array of form data
		* @return the form data
	*/
	function checkFormData($checkboxArray, $formData)
	{
		foreach ($checkboxArray as $key => $value){
			$formData[$key] = (isset($formData[$key])) ? $formData[$key] : 0;
		}
		return $formData;
	}
	
	/**
		* get data from array
		* 
		* @param	array		array of total fields
		* @param	array		array of form data
		* @return the form data
	*/
	function getFormData($fieldArray, $formData)
	{
		foreach ($fieldArray as $key => $value){
			$formData[$key] = (isset($formData[$key])) ? $value : 0;
		}
		return $formData;
	}
	
	/**
		* Construct update array for tables
		* 
		* @param	array		array of fields
		* @param	array		array of form data
		* @return the form data
	*/
	function constructUpdateArray($fieldArray, $formData)
	{
		$fieldsArray = array();
		foreach ($fieldArray as $key => $value){
			//echo '<br><br>'.$key.' => '.$value;
			if (isset ($formData[$value]))
				$fieldsArray[$value] =  $formData[$value];
		}
		return $fieldsArray;
	}
	
	function constructAlerteArray($fieldArray, $formData)
	{
		$fieldsArray = array();
		foreach ($fieldArray as $key => $value){
			if (isset ($formData[$value]))
				$fieldsArray[$value] =  $formData[$value];
			else
				$fieldsArray[$value] =  0;
		}
		return $fieldsArray;
	}
	
	/**
		* gets the data
		* 
		* @param string}array name of the data|array of names
		* @return the data, if exist
	*/
	public function getData($data)
	{
		
		if (is_string($data)) {
			$data = '_' . $data;
			if (isset($this->$data)) { 
				return $this->$data;
			}
		} else if (is_array($data)) {
			$resource = array();
			foreach ($data as $element) {
				$key = '_' . $element;
				$resource[$element] = $this->$key;
			}
			return $resource;
		} 
		return;
	}
	/**
		* gets image type
		* 
		* @param string ext of the image
		* @return the int type, if exist
	*/
	public function getImageType($extension)
	{
		$type = '';
		if (($extension == 'pjpeg') or ($extension == 'jpeg'))
			$extension = 'jpg';
		if ($extension == 'jpg')
			$type = '1';
		if ($extension == 'gif')
			$type = '2';
		if ($extension == 'png')
			$type = '3';
		if ($extension == 'bmp')
			$type = '4';
		return $type;
	}
	/**
		* change the image extension
		* jpeg, pjpeg, jep are jpg
		* gif as gif
		* png as png
		* @param string ext of the image
		* @return string type, if exist
	*/
	public function getImageTypeConversion($extension)
	{
		$type = '';
		if (($extension == 'pjpeg') || ($extension == 'jpeg') || ($extension == 'jpg'))
			$type = 'jpg';
		if ($extension == 'gif')
			$type = 'gif';
		if ($extension == 'png')
			$type = 'png';
		if ($extension == 'bmp')
			$type = 'bmp';
		return $type;
	}
	/**
		* gets image type
		* 
		* @param int ext of the image
		* @return string type, if exist
	*/
	public function getImageExtension($extension)
	{
		$type = '';
		if ($extension == '1')
			$type = 'jpg';
		else if ($extension == '2')
			$type = 'gif';
		else if ($extension == '3')
			$type = 'png';
		else if ($extension == '4')
			$type = 'bmp';
		return $type;
	}
	
	/**
		* gets image type
		* 
		* @param int ext of the image
		* @return string type, if exist
	*/
	public function getImageExtensionValue($extension)
	{
		$type = '';
		if ($extension == 'jpg')
			$type = '1';
		else if ($extension == 'gif')
			$type = '2';
		else if ($extension == 'png')
			$type = '3';
		else if ($extension == 'bmp')
			$type = '4';
		return $type;
	}
	/**
		* gets object type
		* 
		* @param array type
		* @return object type
	*/
	function parseArrayToObject($array) {
	   $object = new stdClass();
	   if (is_array($array) && count ($array) > 0) {
	      foreach ($array as $name=>$value) {
	         $name = trim($name);
	         if (!empty($name)) {
	            $object->$name = $value;
	         }
	      }
	   }
   	return $object;
	}
	/**
		* gets date in format
		* 
		* @param string input date
		* @param string date format
	*/
	function getDate($date, $format)
	{
		$format = str_replace("YYYY","yyyy",$format);
		$dateObject = new Zend_Date($date, $format, 'fr_FR');
		return $dateObject->toString($format);
	}
	/**
		* recursive call for an array to add/modifiy a value of it
		* 
	*/
	function array_walk_recursive($source, $key, $destination)
	{
		$destination[$key];
		//$destination[$key];
	}
	
	/**
		* encrypts the id
		* 
		* @param string input date
		* @param string date format
	*/
	function encode($id)
	{
		return dechex(($id + 5) * 101);
	}
	function decode($id)
	{
		return hexdec($id)/101-5;
	}
	/**
	* sub string
	* 
	* @param string 
	* @param int 
	*/
	function displayText($text, $length) {
		if (strlen($text) > $length) return strip_tags( substr ($text, 0, $length)).'...'; else return $text;
	}
	/**
	* make directory
	* 
	* @param string path
	* @param int optional for write permission
	*/
	function makeDirectory($path , $rights = 0777) 
	{
		$folder_path = array(strstr($path, '.') ? dirname($path) : $path);
		while(!@is_dir(dirname(end($folder_path)))
	         && dirname(end($folder_path)) != '/'
	         && dirname(end($folder_path)) != '.'
	         && dirname(end($folder_path)) != '')
	   		array_push($folder_path, dirname(end($folder_path)));
		while($parent_folder_path = array_pop($folder_path)) {
			@mkdir($parent_folder_path);
		}
	}
	/**
		* delete image in directory
		* 
		* @param string path
	*/
	function deleteFile($path) {
		if (file_exists($path)) {
			unlink($path);
		}
	}
	
	/**
		* calculate the expiry date
		* 
		* @param int expiration Days
	*/
	function calculateExpiryDate($expirationDays) {
		$locale = new Zend_Locale('fr_FR');
		$date = new Zend_Date(time(), false, $locale->toString());
		$date->add($expirationDays, Zend_Date::DAY);
		return $date->toString('yyyy-MM-dd H:mm:ss');
	}
	function checkEmptyFolder ( $folder )
	{
		$files = array ();
		if ( $handle = opendir ( $folder ) ) {
			while ( false !== ( $file = readdir ( $handle ) ) ) {
				if ( $file != "." && $file != ".." ) {
					$files [] = $file;
				}
			}
			closedir ( $handle );
		}
		return count ( $files );
	}
	
	function longText($text, $length) {
		$new_text = '';
	    $text_1 = explode ('>',$text);
	    $sizeof = sizeof($text_1);
	    for ($i=0; $i<$sizeof; ++$i) {
	    	$text_2 = explode ('<',$text_1[$i]);
	        if (!empty($text_2[0])) 
	        	$new_text .= preg_replace('#([^\n\r .]{' . $length . '})#i', '\\1  ', $text_2[0]);
			if (!empty($text_2[1]))
				$new_text .= '<' . $text_2[1] . '>';
		}
	    return $new_text;
	}
	function accentTextConveration ($filed) {
		return iconv("UTF-8", "CP1252",$filed);
	}
	/**
	 * Recursively delete a directory
	 *
	 * @param string $dir Directory name
	 * @param boolean $deleteRootToo Delete specified top-level directory as well
	 */
	function unlinkRecursive($dir, $deleteRootToo)
	{
		if (!$dh = @opendir($dir)) {
	        return;
	    }
	    while (false !== ($obj = readdir($dh))) {
	        if ($obj == '.' || $obj == '..') {
	            continue;
	        }
			if (!@unlink($dir . '/' . $obj)) {
	            $this->unlinkRecursive($dir.'/'.$obj, true);
	        }
	    }
	    closedir($dh);
	    if ($deleteRootToo) {
	        @rmdir($dir);
	    }
	    return;
	}
	
	function addingMagicQuotes($value)
	{
		if (!get_magic_quotes_gpc()) {
			$add_value = is_array($value) ? array_map('addingMagicQuotes', $value) : addslashes($value);
			return $add_value;
		}
		else
			return $value;
	}
	//Function to disable  magic_quotes_gpc at runtime and to replace double quotes into HTML character entity references.
	//value may be an array or value
	function removeMagicQuotes ($value)
	{
		$obj = 0;
		if (is_object ($value)) {
			$value = (array) $value;
			$obj = 1;
		}
		
		$value = is_array($value) ? array_map(array($this, 'removeMagicQuotes'),  $value) : stripslashes ($value);
		
		if ($obj == 1) {
			$value = (object) $value;
		}
	    return $value;
	}
	
	function removeZerosForEuro($value)
	{
		$value = str_replace (',', '.', $value);
		$value = number_format($value, 2, ',', ' ');
		
		if (strpos($value, ',')) {
			if (substr($value, -2) == '00')
				$value = substr($value,0 , -3);
		} else if (strpos($value, '.')) {
			if (substr($value, -2) == '00')
				$value = substr($value,0 , -3);
		}
		
		return $value;
	}
	function removeZerosForEuroEdit($value)
	{
		if (strpos($value, ',')) {
			if (substr($value, -2) == '00')
				$value = substr($value,0 , -3);
			else if (substr($value, -1) == '0')
				$value = substr($value,0 , -1);
		} else if (strpos($value, '.')) {
			if (substr($value, -2) == '00')
				$value = substr($value,0 , -3);
			else if (substr($value, -1) == '0')
				$value = substr($value,0 , -1);
		}
		
		return $value;
	}
		
	function MultiArraySort($a,$subkey) {
		foreach($a as $k=>$v) {
			$b[$k] = strtolower($v[$subkey]);
		}
		arsort($b);
		foreach($b as $key=>$val) {
			$c[] = $a[$key];
		}
		return $c;
	}
}
