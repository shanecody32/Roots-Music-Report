<? // pr($review); ?>

<section id="review">
	<h1 id="page_title">
		<div class="smaller">Album Review of</div>
    	<?=$review['Album']['name']; ?>
        <div class="smaller bottom-line">George Clark & Dixie Flyer</div>
	</h1> 
	<article id="album-details">
		<?=$this->Image->show($review['Album']['AlbumImage'], array('id'=>'album-cover')); ?>
		<h2 class="hidden">Album Details</h2>
		<strong>Label:</strong> <?=$review['Album']['Label']['name'];?><br />
		<strong>Genres:</strong> 
			<? foreach($review['Album']['SubGenre'] as $subgenre): ?>
				<?=$subgenre['name']; ?>
				<? if(next($review['Album']['SubGenre'])) echo ","; ?>
			<? endforeach; ?>
			<br />
		
		<? foreach($review['Band']['BandLink'] as $link) : ?>
			<?=$this->Html->link(__($link['type']), $link['link']); ?>
		<? endforeach; ?>
	</article>

	<article id='review-content'>
	
		<h2 class="hidden">Review of Album <?=$review['Album']['name']; ?></h2>
		Posted by <?=$review['User']['UserDetail']['first_name'].' '.$review['User']['UserDetail']['last_name'] ; ?><br />
		<?=$this->Format->date($review['Review']['created'], 'standard'); ?>
		<div id="review-review">
			<? for($i=0; $i < $review['Review']['rating']; $i++): ?>
				<?=$this->Html->image('ratingstar.gif', array('alt'=>'Review Rating Star', 'class'=>'rating-star')); ?>
			<? endfor; ?>
			<div>
				<?=nl2br($review['Review']['review']); ?>
			</div>
		</div>
<?=$this->Form->create('Review', array('type' => 'file'));?>
<?=$this->Form->input('user_id', array('type'=>'hidden', 'value'=>$review['User']['id']));?>
<?=$this->Form->input('approved_by', array('type'=>'hidden', 'value'=>$this->Session->read('Auth.User.id')));?>
<?=$this->Form->input('id', array('type'=>'hidden', 'value'=>$review['Review']['id']));?>
<?=$this->Form->end(__('Approve Review'));?>
	</article>
	
</section>
	