<?php
class LinkComponent extends Component {

	function clean_link($link){
		$link = str_replace('http://', '', $link);
	
		$link = 'http://'.$link;
		return $link;
	}
	
	function linkType($link, $type = 'website'){
		switch($type){
			case 'website':
				return true;
				break;
			case 'facebook':
				if(strpos($link,'facebook.com') == 0){
					return false;
				}
				break;
			case 'myspace':
				if(strpos($link,'myspace.com') == 0){
					return false;
				}
				break;
			case 'youtube':
				if(strpos($link,'youtube.com') == 0){
					return false;
				}
				break;
			case 'twitter':
				if(strpos($link,'twitter.com') == 0){
					return false;
				}
				break;
			case 'radio_submit':
				if(strpos($link,'radiosubmit.com') == 0){
					return false;
				}
				break;
		}
		return true;
	}

}
?>