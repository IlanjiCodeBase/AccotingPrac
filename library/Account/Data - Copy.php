<?php
/**
	* Data library
	* 
	* Constants of the application are loaded here
*/
class Jobs_Data /*extends Zend_View_Helper_GetTranslation*/
{
	public function Jobs_Data()
	{
		try {
			$this->translator = new Zend_View_Helper_Translate(Zend_Registry::get('Zend_Translate'));
			$this->setData();
		} catch (Exception $exception) {
			//echo '<br>==>' . $exception->getMessage();
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
		* gender values
		* 
		* @var array gender
	*/
	private $_gender;
    /**
		* country values
		* 
		* @var array country
	*/
	private $_country;
	/**
		* qualification values
		* 
		* @var array qualification
	*/
	private $_qualification;
	/**
		* Correspondance possible en
		* 
		* @var array correspondancePossible
	*/
	
	private $_correspondancePossible = array('Anglais' => 'English', 'Italien' => 'Italian', 'Francais' => 'French', 'Espagnol' => 'Spanish',
												'Allemand' => 'German', 'Neerlandais' => 'Dutch');

	/**
		* industry values
		* 
		* @var array industry
	*/
	private $_industryArray;
	/**
		* function Area values
		* 
		* @var array industry
	*/
	private $_functionAreaArray;
	/**
		* qualification values
		* 
		* @var array qualification
	*/
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
				$this->_country		=	array('0'	=>'Select',
											'1'		=>'France',
											'81'	=>'Algeria',
											'4'		=>'Germany',
											'8'		=>'Austria',
											'11'	=>'Belgium',
											'15'	=>'Bulgaria',
											'20'	=>'Cyprus',
											'79'	=>'CzechRepublic',
											'24'	=>'Denmark',
											'27'	=>'Spain',
											'77'	=>'Estonia',
											'29'	=>'Finland',
											'31'	=>'UnitedKingdom',
											'32'	=>'Greece',
											'37'	=>'Hungary',
											'39'	=>'Ireland',
											'42'	=>'Italy',
											'78'	=>'Lithuania',
											'44'	=>'Luxembourg',
											'46'	=>'Malta',
											'47'	=>'Morocco',
											'53'	=>'Netherlands',
											'54'	=>'Poland',
											'56'	=>'Portugal',
											'57'	=>'Romania',
											'71'	=>'Senegal',
											'62'	=>'Singapore',
											'80'	=>'Slovenia',
											'69'	=>'Sweden',
											'68'	=>'Switzerland',
											'74'	=>'Tunisia',
											'75'	=>'Turkey',
											'2'		=>'Acores',
											'3'		=>'SouthAfrica',
											'5'		=>'Andorra',
											'6'		=>'Argentina',
											'7'		=>'Australia',
											'9'		=>'Bahamas',
											'10'	=>'BalearicIslands',
											'12'	=>'Bermuda',
											'13'	=>'Bosnia',
											'14'	=>'Brazil',
											'16'	=>'Canada',
											'17'	=>'Canaries',
											'18'	=>'CapVerde',
											'19'	=>'China',
											'21'	=>'CostaRica',
											'22'	=>'Croatia',
											'23'	=>'Cuba',
											'25'	=>'Dominique',
											'26'	=>'Egypt',
											'28'	=>'UnitedStates',
											'30'	=>'Gibraltar',
											'33'	=>'Guadeloupe',
											'34'	=>'Guyana',
											'35'	=>'Haiti',
											'36'	=>'HongKong',
											'38'	=>'India',
											'40'	=>'Iceland',
											'41'	=>'Israel',
											'43'	=>'Barbados',
											'45'	=>'Macedonia',
											'48'	=>'Martinique',
											'49'	=>'Maurice',
											'50'	=>'Monaco',
											'51'	=>'Norway',
											'52'	=>'Paraguay',
											'55'	=>'FrenchPolynesia',
											'58'	=>'Russia',
											'59'	=>'DominicanRepublic',
											'60'	=>'Reunion',
											'61'	=>'Seychelles',
											'63'	=>'StBarthelemy',
											'64'	=>'StChristophe',
											'65'	=>'StMartin',
											'66'	=>'StVincent',
											'67'	=>'SteLucie',
											'70'	=>'Syria',
											'72'	=>'Tchequie',
											'73'	=>'Thailand',
											'76'	=>'Uruguay');

				$this->_gender		    =	array('1'	=>'Male', '2'      =>'Female');	

				$this->_qualification	=	array('1'	=> '10+2 or Below',
									    		  '2'   => 'Diploma / Vocational Course',
									              '3'   => 'Graduation',
									              '4'   => 'PG or Equivalent',
									              '5'   => 'Phd / Mphil or Equivalent ');
												  
				$this->_industryArray   =   array('1' 	=> "IT - Software",
												  '2'   => "Banking / Financial Services",
												  '3'	=> "Manufacturing",
												  '4'	=> "Engineering / Construction",
												  '5'   => "Education / Training",
												  '6'	=> "BPO / Call Center",
												  '7'	=> "IT - Hardware / Networking",
												  '8'   => "Automobile / Auto Ancillaries",
												  '9'	=> "Telecom / ISP",
												  '10'	=> "Medical / Healthcare",
												  '11'	=> "Advertising / MR / PR / Events",
												  '12'  => "Agriculture / Dairy",
												  '13'	=> "Architecture / Interior Design",
												  '14'	=> "Astrology",
												  '15'  => "Aviation / Airline",
												  '16'	=> "Cement / Building Material",
												  '17'	=> "Chemical / Plastic / Rubber / Glass",
												  '18'  => "Consumer Durables / Electronics",
												  '19'	=> "Environment / Waste Management",
												  '20'	=> "Export-Import / Trading",
												  '21'	=> "Fertilizers / Pesticides",
												  '22'  => "FMCG / F&B",
												  '23'	=> "Furnishings / Sanitaryware / Electricals",
												  '24'	=> "Gems / Jewellery",
												  '25'  => "Gifts / Toys / Stationary",
												  '26'	=> "Government Department",
												  '27'	=> "Hotel / Restaurant",
												  '28'  => "Industrial Design",
												  '29' 	=> "Insurance",
												  '30'	=> "KPO / Analytics",
												  '31'	=> "Legal",
												  '32'	=> "Logistics / Courier / Transportation",
												  '33'  => "Management Consulting / Strategy",
												  '34'	=> "Matrimony",
												  '35'	=> "Media / Dotcom / Entertainment",
												  '36'  => "Merchant Navy",
												  '37'	=> "Metal / Iron / Steel",
												  '38'	=> "Military / Police / Arms & Ammunition",
												  '39'  => "Mining",
												  '40'	=> "NGO / Social Work",
												  '41'	=> "Oil & Gas / Petroleum",
												  '42'	=> "Paint",
												  '43'  => "Paper / Wood",
												  '44'	=> "Personal Care / Beauty",
												  '45'	=> "Pharma / Biotech",
												  '46'  => "Politics",
												  '47'	=> "Power / Energy",
												  '48'	=> "Printing / Packaging",
												  '49'  => "Quality Certification",
												  '50'	=> "Real Estate",
												  '51'	=> "Recruitment Services",
												  '52'	=> "Religion / Spirituality",
												  '53'	=> "Retail",
												  '54'  => "Sculpture / Craft",
												  '55'	=> "Security / Detective Services",
												  '56'	=> "Sports / Fitness",
												  '57'  => "Textile / Garments / Fashion",
												  '58'	=> "Travel / Tourism",
												  '59'	=> "Unskilled Labor / Domestic Help",
												  '60'  => "Veterinary Science / Pet Care");	
												  
		$this->_functionAreaArray  = array('1' => array('1' => 'DBA / Datawarehousing','2' => 'Embedded / System Software','3'	=>	'ERP / CRM,General / Other Software','4' => 'IT Operations / EDP / MIS', '5' => 'Mainframe', '6' => 'Telecom Software', '7' => 'Web / Mobile Technologies'),

//Finance / Accounts / Investment Banking
										   '2' => array('11' => "Equity Research",	'12' => "Finance / Accounts / Tax", '13'=>"Investment Banking/ M&A", '14'=> "Risk / Underwriting", '15' => "Securities Trading"),


//Engineering Design / Construction 

										   '4' => array('16' =>"Engineering Design / Construction"),

//Education / Training / Language

										   '5' => array('17' => "Career / Education Counselling", '18' => "Curriculum Design", '19' => "Education Management / Director / Principal", '20' => "Language / Translation", '21' => "Library Management", '22' => "Pre-School / Day Care", '23' => "Professional / Soft Skills Training", '24' => "Professor / Lecturer", '25' => "Special Education", '26' => "Teacher / Tutor", '27' => "Teaching Assistant", '28' => "Technical / Process Training"), 					  

//IT - Hardware / Networking / Telecom Engineering

										   '7' => array('29' => "Hardware / Telecom Equipment Design", '30' => "Network / System Administration", '31' => "Telecom Network Design / Management"), 

//Marketing / Advertising / MR / PR / Events

										   '8' => array('32' => "Event Management", '33' => "Internet Marketing", '34' => "Market Research (MR)", '35' => "Marketing / Communication", '36' => "Media Planning / Buying", '37' => "Public Relations (PR)"));


/*Administration / Front Office / Secretary

array('1' => "Administration / Facility / Transport", '2' => "Front Office / Receptionist", '3' => "Secretary / PA / Steno"), 

Quality / Testing (QA-QC)

array('1' => "Quality (QA-QC)", '2' => "Testing"),
												  
Production / Maintenance / Service

array('1' => "Maintenance", '2' => "Production" , '3' => "Service / Installation / Repair"),

Sales / BD

array('1' => "Pre-Sales", '2' => "Sales / BD", '3' => "Sales Support / MIS"), */												  

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
