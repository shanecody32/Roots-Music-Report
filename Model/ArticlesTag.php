<?php
class ArticleTag extends AppModel {
	var $name = 'ArticleTag';
	
	function make_tags($article_id, $tag_id){
		$data = array();
		unset($this->id);
		$check = $this->find('first', array(
			'conditons' => array(
				'article_id' => $article_id,
				'tag_id' => $tag_id
			)
		));
		if(!empty($check)){
			return true;
		}
		$data['ArticlesTag']['article_id'] = $article_id;
		$data['ArticlesTag']['tag_id'] = $tag_id;
		return $this->save($data);
	}
	
	function bed(){
		echo "function";
	}
	
	
}


?>