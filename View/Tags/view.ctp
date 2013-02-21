<? // DW ?>
<section id="tag">
	<h1 id="page_title">
		<div class="smaller">Articles Tagged With:</div>
    	<?=$tag['Tag']['name']; ?>
	</h1>
<? foreach($tag['Article'] as $article) : ?>
<article>
	<h4><?=$this->Html->link($article['title'], array('controller' => 'articles', 'action'=>'view', $article['id'])); ?></h4>
	
	<?=$this->Format->date($article['created'], 'standard'); ?>
	<? 
		$stringCut = substr($article['article'], 0, 350);
								// make sure it ends in a word so assassinate doesn't become ass...
		$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'... '.$this->Html->link(__('Read More'), array('controller'=>'articles', 'action'=>'view', $article['id']));
		
		echo $string;
	?>
</article>
<? endforeach; ?>
</section>
