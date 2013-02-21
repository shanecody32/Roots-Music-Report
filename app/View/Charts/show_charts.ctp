<div style="float:left; width:45%;">
	<h2>Sub Genre Charts</h2><hr>
	<ul style="list-style:none;">
	<? foreach($sub_genres as $value): ?>
		<li>
			<?=$value['SubGenre']['name'];?> - <?=$this->Html->link('Song', array('action'=>'view', 'song', $value['SubGenre']['name'], 'SubGenre'), array('target' => '_blank'));?> 
			<?=$this->Html->link('Album', array('action'=>'view', 'album', $value['SubGenre']['name'], 'SubGenre'), array('target' => '_blank'));?>
		</li>
	<? endforeach; ?>
	</ul>
</div>
<div style="float:left; width:45%; margin: 0px 0px 0px 10px;">
	<h2>Genre Charts</h2><hr>
	<ul style="list-style:none;">
	<? foreach($genres as $value): ?>
		<li>
			<?=$value['Genre']['name'];?> - 
			<?=$this->Html->link('Song', array('action'=>'view', 'song', $value['Genre']['name']), array('target' => '_blank'));?> 
			<?=$this->Html->link('Album', array('action'=>'view', 'album', $value['Genre']['name']), array('target' => '_blank'));?>
		</li>
	<? endforeach; ?>
	</ul>
</div>
