<? // DW ?> 
<section id="nav-column">
	<?=$this->element('nav');?>

	<article id="hot-radiosubmit">
		<h2 class="content_title">Hot Download on Radio Submit</h2>
		<?
			$imagesDir = 'img/featured_radio_submit/';
			$images = glob($imagesDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
			$randomImage = str_replace('img/', '', $images[array_rand($images)]);
		?>
		<?=$this->Html->image($randomImage); ?>
	</article>
		<aside id="side-ad">
	<!-- <?=$this->Html->image('advertisments/text-ads-250x250.png', array('alt' => __('Advertisements', true), 'id'=>'ad-200x200')); ?> -->
	<?=$this->Html->image('advertisments/ad-video-300x250.jpg', array('alt' => __('Advertisements', true), 'id'=>'ad-200x200')); ?>
	<!-- <?=$this->Html->image('advertisments/text-ads-200x200.png', array('alt' => __('Advertisements', true), 'id'=>'ad-200x200')); ?> -->
	</aside>
</section>
<div id="content">
	<!-- AnythingSlider initialization -->

	<? // pr($_SESSION); ?>
	
	<section id="charts">
		<ul id="slider">
		<? foreach($charts as $chart): ?>
			<li>
				<article id="<?=$chart['Genre']['name']; ?>" class="slide">
					<h2><?=$chart['Genre']['name']; ?> Top 10 Albums</h2>
					<table>
						<?=$this->Html->tableHeaders(array(
							'', 
							'TW', 
							'LW', 
							'Album Title', 
							'Band/Artist Name', 
							'Label'
						)); ?>
						
						<? foreach($chart['Chart'] as $entry): ?>
							<? if($entry[$chart['ModelName']]['movement'] > 0) $move = '<span class="up"></span>'; ?>
							<? if($entry[$chart['ModelName']]['movement'] < 0) $move = '<span class="down"></span>'; ?>
							<? if($entry[$chart['ModelName']]['movement'] == 0) $move = '-'; ?>
							<? if($entry[$chart['ModelName']]['weeks_on'] == 1 && $entry['Album']['AlbumStat']['first_charted'] == 00-00-0000) $move = '<span class="new">NEW</span>'; ?>
							<?=$this->Html->tableCells(array(
								$move ,
								$entry[$chart['ModelName']]['rank'], 
								$entry[$chart['ModelName']]['last_rank'],
								$this->Display->maxLength($entry['Album']['name']), 
								$this->Display->maxLength($entry['Album']['Band']['name']), 
								$this->Display->maxLength($entry['Album']['Label']['name'])
							), false, array('class'=>'altrow')); 
						?>
						<? endforeach; ?>
					</table>
					<div class="chart_bottom">
						<p><?=$this->Html->link('View Top 50 '.$chart['Genre']['name'].' Albums', array('action'=>'view', 'album', $chart['Genre']['name']), array('target' => '_blank'));?></p>
					</div>
				</article>
			</li>
			<? endforeach; ?>
		</ul>
	</section>
	<aside id="top-banner-ad">
		<?=$this->Html->image('advertisments/prweb.gif', array('alt'=>'Advertisment', 'id'=>'top-ad-728x90')); ?>
	</aside>
	<?=$this->element('blues_deluxe');?>
</div>
<div id="bottom-content">
	<article id="featured-review">
		<h2 class="content_title">Latest Album Reviews</h2>
		<ul id='review-slider'>
			<? foreach($reviews as $review): ?>
			<li>
					<?=$this->Image->show($review['Album']['AlbumImage'], array('class'=>'review-album-front-cover', 'url'=>array('controller'=>'reviews', 'action'=>'view', $review['Review']['id'])), 100, 100); ?>
					<article class="review-album-info">
						<h4 class="hidden">Album Info: <?=$review['Album']['name'];?></h4>
						<?=$this->Html->link($review['Band']['name'], array('controller'=>'reviews', 'action'=>'view', $review['Review']['id'])); ?><br />
						<strong>Album:</strong> <?=$review['Album']['name']; ?><br />
						<strong>Label:</strong> <?=$review['Album']['Label']['name']; ?><br />
						<strong>Genre(s):</strong> <? foreach($review['Album']['SubGenre']as $genre){ 
							echo $genre['name']; 
							if(next($review['Album']['SubGenre'])) echo ", "; 
						} ?><br />
						<? for($j=0; $j < $review['Review']['rating']; $j++): ?>
							<?=$this->Html->image('ratingstar.gif', array('alt'=>'Review Rating Star', 'class'=>'rating-star')); ?>
						<? endfor; ?><br />
						<strong style="font-weight:normal;">Posted By:</strong> <?=$review['User']['UserDetail']['first_name'].' '.$review['User']['UserDetail']['last_name'] ; ?><br />
						<?=$this->Format->date($review['Review']['created'], 'standard'); ?>
					</article>
					<article id="review-brief">
						<?
							if(strlen($review['Review']['review']) > 200) {
								// truncate string
								$stringCut = substr($review['Review']['review'], 0, 200);
								// make sure it ends in a word so assassinate doesn't become ass...
								$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'... '.$this->Html->link(__('Read More'), array('controller'=>'reviews', 'action'=>'view', $review['Review']['id'])); 
							}
							echo $string;
						?>				
						<div class="clearfloats">&nbsp;</div>
					</article>
			</li>
			<? endforeach; ?>
		</li>
	</article>
	
	<article id="latest-news">
		<h2 class="content_title">Latest Articles</h2>
		<section id="articles-list">
		<? foreach($articles as $article): ?>
				<h4><span class="smaller"><?=$article['Category']['name'];?>: </span><br /><?=$this->Html->link($article['Article']['title'], array('controller' => 'articles', 'action'=>'view', $article['Article']['id'])); ?></h4>
			
			<?=$this->Format->date($article['Article']['created'], 'standard'); ?>
			<? 
				$stringCut = substr($article['Article']['article'], 0, 150);
				$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'... ';
				echo $string;
			?><br />
			<?=$this->Html->link(__('Read Article'), array('controller'=>'articles', 'action'=>'view', $article['Article']['id'])); ?>
			<hr />
		<? endforeach; ?>
		</section>
	</article>	
	
	<article id="featured-dj">
		<h2 class="content_title">Reporting DJ Spotlight</h2>
	</article>
</div>