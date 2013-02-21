<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link		http://cakephp.org CakePHP(tm) Project
 * @package	  cake
 * @subpackage    cake.app
 * @since	    CakePHP(tm) v 0.2.9
 * @license	  MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package	  cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
	var $helpers = array('Html', 'Format', 'Session', 'Js' => array('Jquery'),'Display', 'Time', 'Form','Image', 'Logic', 'Link');
	//var $components = array('RequestHandler');
//	function beforeFilter() {
//			$this->RequestHandler->setContent('json', 'text/x-json');
//	}

	public $components = array(
        'Acl',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            )
        ),
        'Session'
    );

    public function beforeFilter() {
        //Configure AuthComponent
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'index');
    } 
	
	function stringToSlug($str) { 
		$str = trim($str);
		$str = str_replace("&", " and ", $str);
		$str = str_replace("'", "", $str);
		$str = str_replace(".", "", $str);
		$str = str_replace(",", "", $str);
		$str = str_replace(":", "", $str);
		$str = str_replace(";", "", $str);
		$str = str_replace("(", "", $str);
		$str = str_replace(")", "", $str);
		  
		// turn into slug  
		$str = Inflector::slug($str);
		$str = str_replace("__", "_", $str);
		$str = str_replace("___", "_", $str);
		// to lowercase  
		$str = strtolower($str);  
		return $str;  
	}
	
	function lev_it($input, $to_compare, $var1, $var2, $max_percent = .75){
		$shortest = -1;
		$stack = array(array('info' => '','percent' => '0'));
		foreach($to_compare as $check){
			$lev = levenshtein($input[$var1][$var2], $check[$var1][$var2]);
			if ($lev == 0) {
				return $check;				
			}
			$percent = 1 - $lev / max(strlen($input[$var1][$var2]), strlen($check[$var1][$var2]));
			if($percent >= $max_percent){
				array_push($stack,array('info'=>$check,'percent' => $percent));	
			}
		}	
		$stack = $this->array_sort($stack,'percent');
		$sorted_trimmed = array();
		for($i=0;$i<$this->compare_num;$i++){
			$temp = array_pop($stack);
			if($temp['percent'] >= $max_percent)
				$sorted_trimmed[$i] = $temp;
		}
		return $sorted_trimmed;	
	}
	
	function array_sort($array, $on, $order=SORT_ASC){
			$new_array = array();
			$sortable_array = array();
	
			if (count($array) > 0) {
					foreach ($array as $k => $v) {
							if (is_array($v)) {
									foreach ($v as $k2 => $v2) {
											if ($k2 == $on) {
													$sortable_array[$k] = $v2;
											}
									}
							} else {
									$sortable_array[$k] = $v;
							}
					}
	
					switch ($order) {
							case SORT_ASC:
									asort($sortable_array);
							break;
							case SORT_DESC:
									arsort($sortable_array);
							break;
					}
	
					foreach ($sortable_array as $k => $v) {
							$new_array[$k] = $array[$k];
					}
			}
	
			return $new_array;
	}
	
	function origReferer(){
		$referer = $this->Session->read('referer');

		if(true){
			return $this->Session->read('referer');
		} else {
			return $this->referer();
		}
	}
	
	function setReferer(){
		$this->Session->write('referer', $this->referer());
	}
}
