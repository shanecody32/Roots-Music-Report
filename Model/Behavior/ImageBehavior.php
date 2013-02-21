<?php

class ImageBehavior extends ModelBehavior {
	
	function uploadImage($uploadedInfo, $uploadTo, $radioname){
	   $webpath = $uploadTo;
	   $upload_dir = WWW_ROOT.DS.'img'.DS.str_replace("/", DS, $uploadTo);
	   $upload_path = $upload_dir.DS;
	   $max_file = "34457280";					// Approx 30MB
	   $max_width = 600;
	   
	   $userfile_name = $uploadedInfo['name'];
	   $userfile_tmp =  $uploadedInfo["tmp_name"];
	   $userfile_size = $uploadedInfo["size"];
	   $filename = basename($uploadedInfo["name"]);
	   $file_ext = substr($filename, strrpos($filename, ".") + 1);
	   $filename = $radioname.'.'.$file_ext;
	   
	   $uploadTarget = $upload_path.$filename;

	   if(empty($uploadedInfo)) {
			   return false;
			 }

	   if (isset($uploadedInfo['name'])){
		  move_uploaded_file($userfile_tmp, $uploadTarget );
		  chmod ($uploadTarget , 0777);
		  $width = $this->getWidth($uploadTarget);
		  $height = $this->getHeight($uploadTarget);
		  // Scale the image if it is greater than the width set above
		  if ($width > $max_width){
			 $scale = $max_width/$width;
			 $uploaded = $this->resizeImage($uploadTarget,$width,$height,$scale);
		  }else{
			 $scale = 1;
			 $uploaded = $this->resizeImage($uploadTarget,$width,$height,$scale);
		  }
	   }
	   return array('imagePath' => $webpath.$filename, 'imageName' => $filename, 'imageWidth' => $this->getWidth($uploadTarget), 'imageHeight' => $this->getHeight($uploadTarget));
    }
	
	function getHeight($image) {
	   $sizes = getimagesize($image);
	   $height = $sizes[1];
	   return $height;
    }
    function getWidth($image) {
	   $sizes = getimagesize($image);
	   $width = $sizes[0];
	   return $width;
    }
}
