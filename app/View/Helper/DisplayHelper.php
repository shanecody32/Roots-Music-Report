<?php
/* 
 * Author: Shane Cody
 * Company: Crooked Comma Designs - crookedcomma.com
 */
class DisplayHelper extends AppHelper {

    var $helpers = array('Html', 'Form', 'Paginator');
	
	function fullName($data, $last_name_first = false){
		if(!$last_name_first){
			return $data['first_name'] . " " . $data['last_name'];
		} else {
			return $data['last_name'] . ", " . $data['first_name'];
		}
	}

	// returns value if not empty
	function show($value, $echo, $show_anyway = false){
		if(!empty($value)){
			return $echo.$value;
		} elseif($show_anyway) {
			return $echo.$value;
		}
	}
	
	function maxLength($string, $max = 25){
		if(strlen($string) > $max){ 
			return trim(substr($string, 0, $max))."..."; 
		} else return $string; 
	}
	
	function pages($show_page_number = true){
		$to_return = '
		<div class="paging">
			<div class="pagebar">'.
				$this->Paginator->prev('&laquo; Previous', array('escape'=>false), null, array('escape'=>false, 'class' => 'prev disabled')). 
				'<div class="numbers">'.$this->Paginator->numbers(array('first' => 2, 'last' => 2, 'modulus' => 4)).'</div>'.
				$this->Paginator->next('Next &raquo;', array('escape'=>false), null, array('escape'=>false, 'class' => 'next disabled')).
			'</div>';
		
		if($show_page_number){
			$to_return .= '<div class="pagenumber">';
			$to_return .= $this->Paginator->first('< first', array('tag'=>'span class="first"'));
			$to_return .= $this->Paginator->counter(array('format' => 'Page %page% of %pages%'));
			$to_return .= $this->Paginator->last('last >', array('tag'=>'span class="last"'));
			$to_return .= '</div>';
		}				
		$to_return .= '</div>';
		return $to_return;
	}
	
	function actions($id = 0, $actions = array('view'), $admin = false, $delimiter = " | "){
		if(!is_array($actions)){
			return 'Missing Action Array';
		}
		$to_return = "";
		$total = count($actions);
		$i = 0; 
		
		foreach($actions as $key => $value){ //$i = 0; $i < $total; $i++){
			if($admin){
				$action = 'admin_';
			} else {
				$action = '';	
			}
			if(!is_numeric($key)){
				$action .= $key;
			} else {
				$action .= $value;
			}
			
			$to_return .= $this->Html->link(__(ucwords($value)), array('action' => $action, $id));
			$i++;
			if($i != $total) $to_return .= $delimiter;
		}
		
		return $to_return;
	}
	

}
?>