<? // pr($review); ?>

<section id="review">
	<h1 id="page_title">
		<div class="smaller">Album Review of</div>
    	<?=$review['Album']['name']; ?>
        <div class="smaller bottom-line"><?=$review['Band']['name']; ?></div>
	</h1> 
	<article id="album-details">
		<?=$this->Image->show($review['Album']['AlbumImage'], array('id'=>'album-cover'), 200, 200); ?>
		<h2 class="hidden">Album Details</h2>
		<strong>Label:</strong> <?=$review['Album']['Label']['name'];?><br />
		<strong>Genres:</strong> 
			<? foreach($review['Album']['SubGenre'] as $subgenre): ?>
				<?=$subgenre['name']; ?>
				<? if(next($review['Album']['SubGenre'])) echo ","; ?>
			<? endforeach; ?>
			<br />
		
		<? foreach($review['Band']['BandLink'] as $link) : ?>
		 	<? if($link['type'] != 'website'){ ?>
				<?=$this->Link->$link['type']($link['link'], false, true); ?>
			<? } else { ?>
				<br  /><?=$this->Link->website($link['link'], $description = 'Visit Artist/Band Website', '', '_blank'); ?>
			<? } ?>
		<? endforeach; ?>
	</article>

	<article id='review-content'>
		<? if($this->Session->read('Group.admin_access') == 1 || $this->Session->read('Auth.User.id') == $review['Review']['user_id']): ?>
			<div style="float:right;">
				<?=$this->Html->link('Edit Review', array('controller' => 'reviews', 'action'=> 'edit', $review['Review']['id']));?>
			</div>
		<? endif; ?>		
		<h2 class="hidden">Review of Album <?=$review['Album']['name']; ?></h2>
		<strong style="font-weight:normal;">Written by <?=$review['User']['UserDetail']['first_name'].' '.$review['User']['UserDetail']['last_name'] ; ?></strong><br />
		<?=$this->Format->date($review['Review']['created'], 'standard'); ?>
		<div id="review-review">
			<? for($i=0; $i < $review['Review']['rating']; $i++): ?>
				<?=$this->Html->image('ratingstar.gif', array('alt'=>'Review Rating Star', 'class'=>'rating-star')); ?>
			<? endfor; ?>
			<div>
				<?=$review['Review']['review']; ?>
			</div>
		</div>
		<div class="fb-like" data-href="<?=str_replace('rmr_test/rmr_test/', 'rmr_test/', Router::url($this->here, true));?>" data-send="true" data-width="500" data-show-faces="false"></div>
		<div class="fb-comments" data-href="<?=str_replace('rmr_test/rmr_test/', 'rmr_test/', Router::url($this->here, true));?>" data-width="470" data-num-posts="10" data-colorscheme="light"></div>
	</article>
	
</section>
	