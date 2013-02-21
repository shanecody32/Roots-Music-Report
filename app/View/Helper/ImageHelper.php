<?php
class ImageHelper extends Helper {
	var $helpers = array('Html');

	var $app_root = '/app/webroot/';
	
	function show($image, $options = array(), $width = false, $height = false){
		$imagelink = '';
		if(!$width && !$height){
			if(isset($image['path'])){
				$imagelink .= $image['path'];
			}
			$imagelink .= $image['filename'];
			return $this->Html->image($imagelink, $options);
		}
		
		$imagelink = 'http://www.rootsmusicreport.com'.DS.'rmr_test'.DS.'app'.DS.'webroot'.DS.'image'.DS;
		if($width && $height){
			$imagelink .= 'w'.$width.'-h'.$height.DS;
		} elseif($width && !$height){
			$imagelink .= 'w'.$width.DS;
		} elseif(!$width && $height){
			$imagelink .= 'h'.$height.DS;
		}
		
		$imagelink .= 'rmr_test'.DS.'app'.DS.'webroot'.DS.'img'.DS;
		if(isset($image['path'])){
			$imagelink .= $image['path'];
		}
		$imagelink .= $image['filename'];

		return $this->Html->image($imagelink, $options);
	}
}
?>