<? // pr($review); ?>

<article id="article">
	<h1 id="page_title">
		<div class="smaller"><?=$article['Category']['name'];?>:</div>
    	<?=$article['Article']['title']; ?>
	</h1>

	<div id='article-content'>
		<? if($this->Session->read('Group.admin_access') == 1 || $this->Session->read('Auth.User.id') == $article['Article']['user_id']): ?>
			<div style="float:right;">
				<?=$this->Html->link('Edit Review', array('controller' => 'articles', 'action'=> 'edit', $article['Article']['id']));?>
			</div>
		<? endif; ?>
		Written by <?=$article['User']['UserDetail']['first_name'].' '.$article['User']['UserDetail']['last_name'] ; ?><br />
		<?=$this->Format->date($article['Article']['created'], 'standard'); ?>
			
		<div id="article-article">
			<div>
				<?=$article['Article']['article']; ?>
			</div>
		</div>
		<aside id="tags">
			<h5>Related Articles:</h5>
			<ul>
			 <? foreach($article['Tag'] as $tag): ?>
			 	<li><?=$this->Html->link(__($tag['name']), array('controller'=>'tags', 'action' => 'view', $tag['id']));?>
				<? if(next($article['Tag'])) echo ","; ?></li>
			 <? endforeach; ?>
			 </ul>
		</aside>
<?=$this->Form->create('Article', array('type' => 'file'));?>
<?=$this->Form->input('user_id', array('type'=>'hidden', 'value'=>$article['User']['id']));?>
<?=$this->Form->input('approved_by', array('type'=>'hidden', 'value'=>$this->Session->read('Auth.User.id')));?>
<?=$this->Form->input('id', array('type'=>'hidden', 'value'=>$article['Article']['id']));?>
<?=$this->Form->end(__('Approve Article'));?>
	</article>
	
</section>
	