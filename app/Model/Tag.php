<?php
class Tag extends AppModel {
	var $name = 'Tag';
	var $displayField = 'tag';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasAndBelongsToMany = array(
		'Article' => array(
			'className' => 'Article',
			'joinTable' => 'article_tags',
			'with' => 'ArticleTag',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'article_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'created DESC',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	function add($tag){
		$exists = $this->find('first', array(
			'conditions' => array(
				'name' => $tag
			)
		));
		$this->create();
		if($exists){
			$exists['Tag']['count'] += 1;
			return $this->save($exists);
		} else {
			$to_save['name'] = $tag;
			$to_save['count'] = 1;
			return $this->save($to_save);
		}
	}
}
?>