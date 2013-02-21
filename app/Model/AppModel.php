<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	 Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link		  http://cakephp.org CakePHP(tm) Project
 * @package	   cake
 * @subpackage	cake.app
 * @since		 CakePHP(tm) v 0.2.9
 * @license	   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package	   cake
 * @subpackage	cake.app
 */
class AppModel extends Model {

	function lev_it($input, $to_compare, $var1, $var2, $max_percent = .01){
		$shortest = -1;
		$stack = array(array('info' => '','percent' => '0'));
		foreach($to_compare as $check){
			$lev = levenshtein(strtolower($input[$var1][$var2]), strtolower($check[$var1][$var2]));
			$percent = 1 - $lev / max(strlen($input[$var1][$var2]), strlen($check[$var1][$var2]));
			if($percent >= $max_percent){
				array_push($stack,array('info'=>$check,'percent' => $percent));
			}
		}
		$stack = $this->array_sort($stack,'percent');
		$sorted_trimmed = array();
		for($i=0;$i<10;$i++){
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
	
/**********************************************************
Function Add:
Checks database for Unique data using fields to supply fields to check, returns matching data, or newly added data.
or false if there is error adding data
$data = Cakephp Array Set to save
$fields = array or var - key for fields to check uniqueness.
***********************************************************/
	function add($data, $fields, $validate = true, $seo_specific = false) {

		if (!is_array($fields)) {
			$fields = array($fields);
		}
		
		$search = array('conditions'=>'');
		
		foreach($fields as $key) {
			$data[$key] = trim($data[$key]);
			$search['conditions'][$this->alias.".".$key] = $data[$key];
		}
		
		$result = $this->find('first', $search);
		if(!$result){
			unset($this->id);
			if(isset($data['name'])){
				if($seo_specific){
					$data['seo_name'] = strtolower(Inflector::slug($seo_specific . " " .$data['name']));
				} else {
					$data['seo_name'] = strtolower(Inflector::slug($data['name']));
				}
			}
			if($validate){
				$result = $this->save($data);
			} else {
				$result = $this->save($data, array('validate' => false));
			}
			$result = $this->find('first', $search);
			if(!$result) return false;
		}
		return $result;
	}
	
	function approve($id){
		$data = $this->findById($id);
		$data[$this->alias]["approved"] = 1;
		return($this->save($data));	
	}
	
	function verify($id){
		$data = $this->findById($id);
		$data[$this->alias]["verified"] = 1;
		return($this->save($data));	
	}
	
	function deny($id){
		$data = $this->findById($id);
		$data[$this->alias]["approved"] = 0;
		return($this->save($data));	
	}

	/** 
	* truncate TABLE (already validated, that table exists) 
	* @param string table [default:null = current model table] 
	**/ 
	function truncate($table = null) { 
		if (empty($table)) { 
			$table = $this->table; 
		} 
		$db = &ConnectionManager::getDataSource($this->useDbConfig); 
		$res = $db->truncate($table); 
		return $res; 
	} 
	
	function cleanPhoneNumber($number){
		$number = str_replace('(', '', $number);
		$number = str_replace(' ', '', $number);
		$number = str_replace(')', '', $number);
		$number = str_replace('.', '', $number);
		$number = str_replace('-', '', $number);
		$number = str_replace('/', '', $number);
		$number = str_replace('+', '', $number);
		$number = str_replace('x', 'ext', $number);
		return trim($number);
	}
	
	function cleanIt($string){
		return $this->replaceComma(ucwords(strtolower(trim($string))));
	}
	
	function replaceComma($value){
		return str_replace('%',',',$value);
	}
	
	function subQuery($build = array('field' => 'id', 'operation' => '!=', 'value' => 0,), $in = true){
		if(isset($build['in_model']) && $build['in_model'] != $this->alias){
			$conditionsSubQuery[$build['in_model'].'.'.$build['field'].' '.$build['operation']] = $build['value'];
			$dbo = $this->$build['in_model']->getDataSource();
			$subQuery = $dbo->buildStatement(
				array(
					'fields' => array($build['in_model'].".".$build['field']),
					'table' => $dbo->fullTableName($this->$build['in_model']),
					'alias' => $build['in_model'],
					'limit' => null,
					'offset' => null,
					'joins' => array(),
					'conditions' => $conditionsSubQuery,
					'order' => null,
					'group' => null
				),
				$this->$build['in_model']
			);	
		} else {
			$conditionsSubQuery[$this->alias.'.'.$build['field'].' '.$build['operation']] = $build['value'];
			$dbo = $this->getDataSource();
			$subQuery = $dbo->buildStatement(
				array(
					'fields' => array($this->alias."2.".$build['field']),
					'table' => $dbo->fullTableName(Inflector::tableize($this->alias)),
					'alias' => $this->alias."2",
					'limit' => null,
					'offset' => null,
					'joins' => array(),
					'conditions' => $conditionsSubQuery,
					'order' => null,
					'group' => null
				),
				$this->alias
			);	
		}
		if($in != true){
			$subQuery = $this->alias.'.id NOT IN (' . $subQuery . ') ';
		} else {
			$subQuery = $this->alias.'.id IN (' . $subQuery . ') ';
		}
		
		$subQueryExpression = $dbo->expression($subQuery);

		$conditions[] = $subQueryExpression;
		return $this->find('all', compact('conditions'));
	}
}
