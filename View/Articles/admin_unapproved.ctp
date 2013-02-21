<? // DW ?>
<?
//pr($this->Paginator->params);
if($this->Paginator->params['paging']['Article']['count'] >= $page_limit){
	$one_page = false; 	
} else {
	$one_page = true; 	
}
?>
<?=$this->Form->create('Article', array('url' => array_merge(array('controller'=>'articles', 'action' => 'index'), $this->params['pass']))); ?>
<? //=$this->Form->input('field', array('type'=>'hidden','value'=>'name'));?>
<div id="advanced">
	<div>Categories:</div>
	<div id="check-list">
		<?=$this->Form->input('categories', array('type'=>'select', 'multiple' => 'checkbox', 'options'=>$categories, 'label'=>'')); ?>
	</div>
	<div id="update-results">
		<?=$this->Form->submit(__('Update Results', true),array('div'=>false)); ?>
	</div>
</div>

<?=$this->Form->end(); ?>
<section id="results">	

	<? if(!$one_page) echo $this->Display->pages(false);?>
	<!-- <table>
		<?=$this->Html->tableHeaders(array($this->Paginator->sort('Article.created', 'Created ')));?>
	</table> -->
	<? foreach($articles as $article): ?>
				<article class="article">
					<h4 class="article-title">
						<div class="smaller"><?=$article['Category']['name'];?>:</div>
						<?=$this->Html->link($article['Article']['title'], array('controller' => 'articles', 'action'=>'approve', $article['Article']['id'], 'admin'=>'true')); ?></h4>
						<div style="float:right;"><?=$this->Html->link(__('Delete'), array('action' => 'delete', $article['Article']['id'], 'admin'=>true), null, sprintf(__('Are you sure you want to delete the article: "%s"?'), $article['Article']['title'])); ?></div>
				Written by <?=$article['User']['UserDetail']['first_name'].' '.$article['User']['UserDetail']['last_name'] ; ?><br />
				<?=$this->Format->date($article['Article']['created'], 'standard'); ?><br />
				<aside id="tags">
					<h5>Related Articles:</h5>
					<ul>
					 <? foreach($article['Tag'] as $tag): ?>
						<li><?=$this->Html->link(__($tag['name']), array('controller'=>'tags', 'action' => 'view', $tag['id'], 'admin'=>false));?>
						<? if(next($article['Tag'])) echo ","; ?></li>
					 <? endforeach; ?>
					 </ul>
				</aside>
				<div>
	<? 
		$stringCut = substr($article['Article']['article'], 0, 1500);
								// make sure it ends in a word so assassinate doesn't become ass...
		$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'... '.$this->Html->link(__('Read More'), array('controller'=>'articles', 'action'=>'approve', $article['Article']['id'], 'admin'=>'true'));
		
		echo $string;
	?>
				</div>
				</article>	
	<? endforeach; ?>
	<? if(!$one_page) echo $this->Display->pages();?>
</section>