<? // DW ?>
<?
//pr($this->Paginator->params);
if($this->Paginator->params['paging']['Review']['count'] >= $page_limit){
	$one_page = false; 	
} else {
	$one_page = true; 	
}
?>

<?=$this->Form->create('Review', array('url' => array_merge(array('controller'=>'reviews', 'action' => 'search'), $this->params['pass']))); ?>

<?=$this->Form->input('band_name', array('label'=>'','div'=>false, 'placeholder'=>'Band Name'));?>
<?=$this->Form->input('album_name', array('label'=>'','div'=>false, 'placeholder'=>'Album Title'));?>
<? // see rs band search for usage =$this->Form->input('type', array('label'=>'&nbsp;', 'type'=>'select', 'div'=>false, 'options'=>$options)); ?>

<?=$this->Form->submit(__('Search', true),array('div'=>false)); ?>
<?//=$this->Form->input('field', array('type'=>'hidden','value'=>'name'));?>
<div id="advanced">
	<?=$this->Form->input('starts_with', array('type'=>'checkbox', 'div'=>false)); ?>
	<?=$this->Form->input('exact', array('type'=>'checkbox', 'div'=>false)); ?>
	<div class="toggle">
		<a id="sub_genre_toggle" href="#">Sub Genres</a>
		<div id="sub_genres">
			<?=$this->Form->input('sub_genres', array('type'=>'select', 'multiple' => 'checkbox',  'options'=>$sub_genres, 'label'=>'')); //'empty'=>'All Sub Genres', ?>
		</div>
	</div>
	<div class="toggle">
		<a id="genre_toggle" href="#">Genres</a>
		<div id="genres">
			<?=$this->Form->input('genres', array('type'=>'select', 'multiple' => 'checkbox', 'options'=>$genres, 'label'=>'')); ?>
		</div>
	</div>
</div>
<?=$this->Form->end(); ?>

<section id="results">

	<? 	if(isset($this->Paginator->params['named']['search'])){ ?>
		<? 	if($this->Paginator->params['paging']['Review']['count'] == 0){ ?>
				<h3>No results found for '<?=$this->Paginator->params['named']['search'];?>' in Reviews.</h3><br />
		<? 	} else { ?>
				<h3>Results for '<?=$this->Paginator->params['named']['search'];?>' in Reviews.</h3><br />
		<?	}
		} ?>
	

	<? if(!$one_page) echo $this->Display->pages(false);?>
	<table>
		<?=$this->Html->tableHeaders(array($this->Paginator->sort('Band.name', 'Band '),$this->Paginator->sort('Album.name', 'Album '), $this->Paginator->sort('Review.created', 'Created ')));?>
	</table>
	<table>
	<? $i=0; foreach($reviews as $review): ?>
		<? if($i % 2 == 0){ echo '<tr>'; } ?>
			<td id="album_<?=$i;?>"  class="each-album">
				<?=$this->Image->show($review['Album']['AlbumImage'], array('class'=>'album-front-cover', 'url'=>array('controller'=>'reviews', 'action'=>'view', $review['Review']['id'], 'admin'=>false)), 100, 100); ?>
				<article class="album-info">
					<h4 class="hidden"><?=$review['Album']['name'];?></h4>
					<?=$this->Html->link($review['Band']['name'], array('controller'=>'reviews', 'action'=>'view', $review['Review']['id'], 'admin'=>false)); ?><br />
					Album: <?=$review['Album']['name']; ?><br />
					Label: <?=$review['Album']['Label']['name']; ?><br />
					Genre(s):<? foreach($review['Album']['SubGenre']as $genre){ 
						echo $genre['name']; 
						if(next($review['Album']['SubGenre'])) echo ","; 
					} ?><br />
					<? for($j=0; $j < $review['Review']['rating']; $j++): ?>
						<?=$this->Html->image('ratingstar.gif', array('alt'=>'Review Rating Star', 'class'=>'rating-star')); ?>
					<? endfor; ?><br />
					Posted By: <?=$review['User']['UserDetail']['first_name'].' '.$review['User']['UserDetail']['last_name'] ; ?><br />
					<?=$this->Format->date($review['Review']['created'], 'standard'); ?>
				
				</article>	
			</td>
		<? if($i % 2 != 0){ echo '</tr>'; } ?>
	<? $i++; endforeach; ?>
	</table>
	<? if(!$one_page) echo $this->Display->pages();?>
</section>