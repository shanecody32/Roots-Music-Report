<?php

class LinkHelper extends AppHelper {
    var $helpers = array('Html', 'Session');
	
	function show($val, $description = '', $class = '', $target = ""){
		$tags = array();
		
		if(!empty($class)){
			$tags['class'] = $class; 
		}
		if(!empty($target)){
			$tags['target'] = $target; 
		}
		
		if($description == 'clean_link'){
			$show = $this->Html->link(str_replace('http://', '', $val), $val, $tags);
		} else if($description == 'link'){
			$show = $this->Html->link($val, $val, $tags);
		} else if(!empty($description)){
			$show = $this->Html->link($description, $val, $tags);
		} else {
			$show = $this->Html->link($val, $val, $tags);
		}
		
		return $show;
	}
	
	function website($val, $description = '', $class = '', $target = ""){
		return $this->show($val, $description, $class, $target);
	}
	
	function blog($val, $description = '', $class = '', $target = ""){
		return $this->show($val, $description, $class, $target);
	}

    function google($val){
	  return $this->Html->link("Find on Google","http://www.google.com/#q=".urlencode($val),array('class' => 'button', 'target' => '_blank'));
    }
	
	function all_music($val, $type = "artist"){
	  return $this->Html->link("Find on All Music","http://allmusic.com/search/".$type."/".urlencode($val),array('class' => 'button', 'target' => '_blank'));
    }

	function music_brainz($val, $type = "artist"){
		return $this->Html->link("Find on MusicBrainz","http://musicbrainz.org/search?query=".urlencode($val)."&type=".$type,array('class' => 'button', 'target' => '_blank'));
	}
	
	function discogs($val, $type = "artist"){
		if(!is_array($val)){
			$val = array($val);
		}
		$search = "http://www.discogs.com/advanced_search?";
		if($type == "artist" || $type == "release" || $type == "song"){
			$search .= "artist=".urlencode($val[0]);
		}
		if($type == "release"){
			$search .= "&release_title=".urlencode($val[1]);
		}
		
		if($type == "song"){
			$search .= "&track=".urlencode($val[1]);
		}
		return $this->Html->link("Find on Discogs", $search ,array('class' => 'button', 'target' => '_blank'));
	}
	
	function facebook($val, $show_val = false, $image = false){
		if($show_val){
			$name = $val;
		} else {
			$name = 'Facebook';
		}
		if($image){
			return $this->Html->link($this->Html->image('facebook_64.png', array('class' => 'social', 'alt'=>'Facebook')), $val, array('class' => 'social', 'target' => '_blank', 'escape' => false));
		} else {
			return $this->Html->link($name, $val, array('class' => 'social', 'target' => '_blank'));
		}
	}
	
	function twitter($val, $show_val = false, $image = false){
		if($show_val){
			$name = $val;
		} else {
			$name = 'Twitter';
		}
		if($image){
			return $this->Html->link($this->Html->image('twitter_64.png', array('class' => 'social', 'alt'=>'Twitter')), $val, array('class' => 'social', 'target' => '_blank', 'escape' => false));
		} else {
			return $this->Html->link($name, $val, array('class' => 'social', 'target' => '_blank'));
		}
	}
	
	function myspace($val, $show_val = false, $image = false){
		if($show_val){
			$name = $val;
		} else {
			$name = 'MySpace';
		}
		if($image){
			return $this->Html->link($this->Html->image('myspace_64.png', array('class' => 'social', 'alt'=>'MySpace')), $val, array('class' => 'social', 'target' => '_blank', 'escape' => false));
		} else {
			return $this->Html->link($name, $val, array('class' => 'social', 'target' => '_blank'));
		}
	}
	
	function youtube($val, $show_val = false, $image = false){
		if($show_val){
			$name = $val;
		} else {
			$name = 'You Tube';
		}
		if($image){
			return $this->Html->link($this->Html->image('youtube_64.png', array('class' => 'social', 'alt'=>'YouTube')), $val, array('class' => 'social', 'target' => '_blank', 'escape' => false));
		} else {
			return $this->Html->link($name, $val, array('class' => 'social', 'target' => '_blank'));
		}
	}
	
	function radio_submit($val, $show_val = false, $image = false){
		if($show_val){
			$name = $val;
		} else {
			$name = 'Radio Submit';
		}
		if($image){
			return $this->Html->link($this->Html->image('radio_submit_64.png', array('class' => 'social', 'alt'=>'Radio Submit')), $val, array('class' => 'social', 'target' => '_blank', 'escape' => false));
		} else {
			return $this->Html->link($name, $val, array('class' => 'social', 'target' => '_blank'));
		}
	}
	
	private function check($path){
        // assuming that allow('controllers') grands access to all actions
        if($this->Session->check('Auth.Permissions.controllers') 
        && $this->Session->read('Auth.Permissions.controllers') === true){
            return true;
        }
        if($this->Session->check('Auth.Permissions'.$path)
        && $this->Session->read('Auth.Permissions'.$path) === true){
            return true;
        }
        return false;
    }
	
	private function admin_check(){
		if($this->Session->check('Auth.Permissions.controllers') 
        && $this->Session->read('Auth.Permissions.controllers') === true){
            return 1;
        }
	}
	
	function smart_link($link_name = '', $controller = '', $action = '', $additional = ''){
		if($this->check($controller.'.'.$action)){
			echo $this->Html->link($link_name,
				array(
					'controller' => $controller,
					'action' => $action,
					'admin' => $this->admin_check(),
					$additional
				)
			);
		}
	}
}

?>