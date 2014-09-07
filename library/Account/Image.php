<?php
class Account_Image
{
	/**
     * @var array Error message templates
     */
	private $_messageTemplates;
	/**
     * Sets Error message
     *
     */
	public function __construct()
	{
		//$this->_setMessageTemplates();
	}
	/**
     * upload profil image
     *
     * @param  string path
	 * @param  int id
	 * @return error message | void
     */
	public function uploadProfilImage($uploadPath, $id)
	{
		$immoData = new Jobs_Data();
		$imageTypes = $immoData->getData('imageTypes');
		
		$data = array();
		$fileTransfer = new Zend_File_Transfer_Adapter_Http();
		$fileInfo = $fileTransfer->getFileInfo();
		$fileTransfer->addValidator('Extension', false, $imageTypes);
		$fileTransfer->addValidator('Size', false, 2024000);
		$fileTransfer->setDestination($uploadPath);
		
		// check image validation 
		foreach ($fileInfo as $file => $info) {
			if ($fileInfo[$file]['name']) {
				if(!$fileTransfer->isValid($file)) {
					foreach ($fileTransfer->getMessages() as $key =>$message) {
						$errorMessages[$key] = $key;
					}
					return $errorMessages;
				}
			}
		}
		// upload  images
		foreach ($fileInfo as $file => $info) {
			if ($fileInfo[$file]['name']) {
				$nam = $fileInfo[$file]['name'];
				$extension = explode('.', $nam);
				$data['Extn'] = $immoData->getImageType(strtolower($extension[1]));
				
				$this->_storage = new Zend_Session_Namespace('user');
				$this->_storage->user->Extn = $data['Extn'];
				
				$path = $this->generatePathForSource($id, $immoData->getImageTypeConversion(strtolower($extension[1])), $uploadPath);
				$immoData->makeDirectory($path);
				$this->resize($fileInfo[$file]['tmp_name'], $path, 110, 82);
				$profil = new Profil();
				$profil->updateImageType($data['Extn'], $id);
				return $id.'.'.strtolower($extension[1]);
			}
		}
	}
	
	

	public function resize($src, $des, $maxwidth = 50, $hght = 50) {
		ini_set('memory_limit', '100M');
		echo $des;
		if(file_exists($src))
		   	$size=getimagesize($src);
		$mime_type	=	$size['mime'];
		$itype	=	substr($mime_type,strpos($mime_type,'/')+1);
		if($mime_type	==	'image/gif') $exn	= 'gif';
		if($mime_type	==	'image/pjpeg') $exn	= 'pjpeg';
		if($mime_type	==	'image/jpg') $exn	= 'jpg';
		if($mime_type	==	'image/jpeg') $exn	= 'jpeg';
		if($mime_type	==	'image/png') $exn	= 'png';
		if($mime_type	==	'image/bmp') $exn	= 'bmp';
		
		$n_width=$size[0];
		$n_height=$size[1];
		$imagehw = GetImageSize($src);
	
		$imagewidth = $imagehw[0];
		$imageheight = $imagehw[1];
		$imgorig = $imagewidth;
		$n_width1 = $maxwidth;
		$n_height1 = $hght;
		if (($n_width - $n_width1) > ($n_height - $n_height1)) 
		{
		  //$imageprop=($n_width1*100)/$imagewidth;
		  //$imagevsize= ($imageheight*$imageprop)/100 ;
		  $imagewidth=$n_width1; 
		  $imageheight=($n_width1/$n_width)*$n_height;
		}else
		{		
			//$imageprop=($n_height1*100)/$imageheight;
		  	//$imagevsize= ($imageheight*$imageprop)/100 ;
		    $imagewidth=($n_height1/$n_height)*$n_width; 
		    $imageheight=$n_height1;	  
	
		}
		
		if($imagewidth > $n_width1){
			$imagewidth = $n_width1;
			$imageheight = round($imageheight / ($imagewidth/$n_width1));
		}
		
		if($n_width <= $n_width1 && $n_height <= $n_height1){
			$imagewidth = $n_width;
			$imageheight = $n_height;
		}
			
		/*
		$n_width = $imagewidth;
		$n_height = $imageheight;
		*/
		$destimg=imagecreatetruecolor($n_width1,$n_height1) or die("Problem In Creating image");
		switch($exn)
		{
		case "jpg":	
		$srcimg=ImageCreateFromJPEG($src) or die("Problem In opening Source Image");
		$destimg=imagecreatetruecolor($n_width1,$n_height1) or die("Problem In Creating image");
		break;
		case "jpeg":
		$srcimg=ImageCreateFromJPEG($src) or die("Problem In opening Source Image");
		$destimg=imagecreatetruecolor($n_width1,$n_height1) or die("Problem In Creating image");
		break;
		case "pjpeg":
		$srcimg=ImageCreateFromJPEG($src) or die("Problem In opening Source Image");
		$destimg=imagecreatetruecolor($n_width1,$n_height1) or die("Problem In Creating image");
		break;
		case "gif":
		$srcimg=ImageCreateFromGIF($src) or die("Problem In opening Source Image");
		$destimg=ImageCreate($n_width1,$n_height1) or die("Problem In Creating image");
		break;
		case "png":
		$srcimg=ImageCreateFromPNG($src) or die("Problem In opening Source Image");
		$destimg=imagecreatetruecolor($n_width1,$n_height1) or die("Problem In Creating image");
		break;
		case "bmp":
		$srcimg =ImageCreateFromBMP($src) or die("Problem In opening Source Image");
		$destimg=imagecreatetruecolor($n_width1,$n_height1) or die("Problem In Creating image");
		break;
		}
		$int = hexdec('ffffff');
		$arr = array("red" => 0xFF & ($int >> 0x10),
	               "green" => 0xFF & ($int >> 0x8),
	               "blue" => 0xFF & $int);
	
		//$black = ImageColorAllocate($image, $arr["red"], $arr["green"], $arr["blue"]); 
		$transparent = imagecolorallocate($destimg,  $arr["red"], $arr["green"], $arr["blue"]);
		
		for($x=0;$x<$n_width1;$x++) {
	           for($y=0;$y<$n_height1;$y++) {
	             imageSetPixel( $destimg, $x, $y, $transparent );
	           }
	         }
		$dest_x = (( $n_width1 / 2 ) - ( $imagewidth / 2 )); // centered
		$dest_y = (( $n_height1 / 2 ) - ( $imageheight / 2 )); // centered	
		ImageCopyresampled($destimg,$srcimg,$dest_x,$dest_y,0,0,$imagewidth,$imageheight,$n_width,$n_height) or die("Problem In resizing");
		/*
		if(($itype=="jpeg")||($itype=="jpg")||($itype=="pjpeg"))
			imagejpeg($destimg, $des, 100);
		else if($itype=="gif")
			ImageGIF($destimg,$des) or die("Problem In saving");
		else if($itype=="png")
			imagepng($destimg, $des, 9) or die("Problem In saving");
		*/
		if(($itype=="jpg")||($itype=="jpeg")||($itype=="pjpeg"))
		{	
			//header('Content-type:image/jpeg');
			imagejpeg($destimg, $des, 75); //ImageJPEG($destimg) or die('Problem In saving');
		}
		else
		if($itype=="gif")
		{
			//header('Content-type:image/gif');
			ImageGIF($destimg,$des) or die("Problem In saving"); //ImageGIF($destimg) or die('Problem In saving');
		}
		else
		if($itype=="png")
		{
			//header('Content-type:image/png');
			imagepng($destimg, $des, 9, PNG_NO_FILTER) or die("Problem In saving"); //ImagePNG($destimg) or die('Problem In saving');
		}
		else
		if($itype=="bmp")
		{
			//header('Content-type:image/png');
			imagebmp($destimg, $des, 9, BMP_NO_FILTER) or die("Problem In saving"); //ImagePNG($destimg) or die('Problem In saving');
		}
		imagedestroy($destimg);
	}
	public function resizeWhileShowImage($src, $maxwidth = 50, $hght = 50) {
		ini_set('memory_limit', '100M');
		
		if(file_exists($src))
		   	$size=getimagesize($src);
		$mime_type	=	$size['mime'];
		$itype	=	substr($mime_type,strpos($mime_type,'/')+1);
		if($mime_type	==	'image/gif') $exn	= 'gif';
		if($mime_type	==	'image/pjpeg') $exn	= 'pjpeg';
		if($mime_type	==	'image/jpg') $exn	= 'jpg';
		if($mime_type	==	'image/jpeg') $exn	= 'jpeg';
		if($mime_type	==	'image/png') $exn	= 'png';
		if($mime_type	==	'image/bmp') $exn	= 'bmp';
		
		$n_width=$size[0];
		$n_height=$size[1];
		$imagehw = GetImageSize($src);
	
		$imagewidth = $imagehw[0];
		$imageheight = $imagehw[1];
		$imgorig = $imagewidth;
		$n_width1 = $maxwidth;
		$n_height1 = $hght;
		if (($n_width - $n_width1) > ($n_height - $n_height1)) 
		{
		  //$imageprop=($n_width1*100)/$imagewidth;
		  //$imagevsize= ($imageheight*$imageprop)/100 ;
		  $imagewidth=$n_width1; 
		  $imageheight=($n_width1/$n_width)*$n_height;
		}else
		{		
			//$imageprop=($n_height1*100)/$imageheight;
		  	//$imagevsize= ($imageheight*$imageprop)/100 ;
		    $imagewidth=($n_height1/$n_height)*$n_width; 
		    $imageheight=$n_height1;	  
	
		}
		
		if($imagewidth > $n_width1){
			$imagewidth = $n_width1;
			$imageheight = round($imageheight / ($imagewidth/$n_width1));
		}
		
		if($n_width <= $n_width1 && $n_height <= $n_height1){
			$imagewidth = $n_width;
			$imageheight = $n_height;
		}
			
		/*
		$n_width = $imagewidth;
		$n_height = $imageheight;
		*/
	
		$destimg=imagecreatetruecolor($n_width1,$n_height1) or die("Problem In Creating image");
		switch($exn)
		{
		case "jpg":	
		$srcimg=ImageCreateFromJPEG($src) or die("Problem In opening Source Image");
		$destimg=imagecreatetruecolor($n_width1,$n_height1) or die("Problem In Creating image");
		break;
		case "jpeg":
		$srcimg=ImageCreateFromJPEG($src) or die("Problem In opening Source Image");
		$destimg=imagecreatetruecolor($n_width1,$n_height1) or die("Problem In Creating image");
		break;
		case "pjpeg":
		$srcimg=ImageCreateFromJPEG($src) or die("Problem In opening Source Image");
		$destimg=imagecreatetruecolor($n_width1,$n_height1) or die("Problem In Creating image");
		break;
		case "gif":
		$srcimg=ImageCreateFromGIF($src) or die("Problem In opening Source Image");
		$destimg=ImageCreate($n_width1,$n_height1) or die("Problem In Creating image");
		break;
		case "png":
		$srcimg=ImageCreateFromPNG($src) or die("Problem In opening Source Image");
		$destimg=imagecreatetruecolor($n_width1,$n_height1) or die("Problem In Creating image");
		break;
		case "bmp":
		$srcimg=ImageCreateFromBMP($src) or die("Problem In opening Source Image");
		$destimg=imagecreatetruecolor($n_width1,$n_height1) or die("Problem In Creating image");
		break;
		}
		$int = hexdec('ffffff');
		$arr = array("red" => 0xFF & ($int >> 0x10),
	               "green" => 0xFF & ($int >> 0x8),
	               "blue" => 0xFF & $int);
	
		//$black = ImageColorAllocate($image, $arr["red"], $arr["green"], $arr["blue"]); 
		$transparent = imagecolorallocate($destimg,  $arr["red"], $arr["green"], $arr["blue"]);
		
		for($x=0;$x<$n_width1;$x++) {
	           for($y=0;$y<$n_height1;$y++) {
	             imageSetPixel( $destimg, $x, $y, $transparent );
	           }
	         }
		$dest_x = (( $n_width1 / 2 ) - ( $imagewidth / 2 )); // centered
		$dest_y = (( $n_height1 / 2 ) - ( $imageheight / 2 )); // centered	
		ImageCopyresampled($destimg,$srcimg,$dest_x,$dest_y,0,0,$imagewidth,$imageheight,$n_width,$n_height) or die("Problem In resizing");
		
		if(($itype=="jpg")||($itype=="jpeg")||($itype=="pjpeg"))
		{	
			header('Content-type:image/jpeg');
			ImageJPEG($destimg) or die('Problem In saving');
		}
		else
		if($itype=="gif")
		{
			header('Content-type:image/gif');
			ImageGIF($destimg) or die('Problem In saving');
		}
		else
		if($itype=="png")
		{

			ImagePNG($destimg) or die('Problem In saving');
		}
		else
		if($itype=="bmp")
		{
			ImageBMP($destimg) or die('Problem In saving');
		}
		imagedestroy($destimg);
	}
	//image uploading
	public function generatePathForSource($source_id, $type, $source_path) {
		$tmpPath= substr($source_id, 0, (strlen($source_id) -2) );
		$tmpFile = substr($source_id, strlen($tmpPath));
		$k = '';
		for ($i=0; $i<strlen($tmpPath); $i++)
			$k .= substr($tmpPath, $i, 1).'/';
		$tmpFile = substr($source_id, strlen($tmpPath));
		return $source_path.'/'.$k.$tmpFile.'.'.$type;
	}
}