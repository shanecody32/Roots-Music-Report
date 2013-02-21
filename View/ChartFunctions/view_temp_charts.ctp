<div style="float:left; width:45%;">
	<h2>Sub Genre Charts</h2><hr>
	<ul style="list-style:none;">
	<? foreach($sub_genres as $value): ?>
		<li>
		<?=$value['SubGenre']['name'];?> - <?=$this->Html->link('Song', array('action'=>'song_sub_genre_temp_chart', $value['SubGenre']['name']), array('target' => '_blank'));?> <?=$this->Html->link('Album', array('action'=>'album_sub_genre_temp_chart', $value['SubGenre']['name']), array('target' => '_blank'));?>
		</li>
	<? endforeach; ?>
	</ul>
</div>
<div style="float:left; width:45%; margin: 0px 0px 0px 10px;">
	<h2>Genre Charts</h2><hr>
		<ul style="list-style:none;">
		<? foreach($genres as $value): ?>
			<li>
			<?=$value['Genre']['name'];?> - <?=$this->Html->link('Song', array('action'=>'song_genre_temp_chart', $value['Genre']['name']), array('target' => '_blank'));?> <?=$this->Html->link('Album', array('action'=>'album_genre_temp_chart', $value['Genre']['name']), array('target' => '_blank'));?>
			</li>
		<? endforeach; ?>
		</ul>
	</div>
<h3 style="clear:both; float:left; margin: 40px 0px;"><?=$this->Html->link('Generate Charts', array('action'=>'generate_song_charts'));?></h3>