<?php
class ArticleTag extends AppModel {
	var $name = 'ArticleTag';
	
	function make($article_id, $tag_id){
		$data = array();
		unset($this->id);
		$this->create();
		$check = $this->find('first', array(
			'conditions' => array(
				'article_id' => $article_id,
				'tag_id' => $tag_id
			)
		));
		if(!empty($check)){
			return $check;
		}
		$data['ArticleTag']['id'] = '';
		$data['ArticleTag']['article_id'] = $article_id;
		$data['ArticleTag']['tag_id'] = $tag_id;
		return $this->save($data);
	}
	
}

?>