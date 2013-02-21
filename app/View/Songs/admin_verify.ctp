<? // pr($song); ?>

<div>
	<h3><?=$song['Song']['name']; ?> by <?=$song['Band']['name'];?></h3>
</div>
<br />
<div>
	<?=$this->Link->google($song['Band']['name']. " " . $song['Song']['name']);?><br />
	<?=$this->Link->all_music($song['Band']['name']);?><br />
	<?=$this->Link->music_brainz($song['Song']['name'], 'recording');?><br />
	<?=$this->Link->discogs(array($song['Band']['name'], $song['Song']['name']), 'song');?><br />
</div>
<br />
<div>
<?=$this->Form->create('Song');?>
<?=$this->Form->input('name', array('label' => "Song Title"));?>
<?=$this->Form->input('sub_genre_id', array('label' => "Sub Genre", 'empty'=>'Select One', 'options'=>$sub_genres,));?>
<?=$this->Form->hidden('id');?>
<?=$this->Form->end(__('Save Changes'));?>
</div>
<br />

<? if(!empty($song['Album'])): ?>
<div>
	<h5>Albums this song appears on:</h5>
	<ul>
	<? foreach($song['Album'] as $album): ?>
		<li style="list-style: none;"><em><?=$album['name'];?></em></li>
	<? endforeach; ?>					   
	</ul>
</div>
<? endif; ?>
<br />

<div>
	<?=$this->Html->link("Verify & Approve This Song for Charting", array('action' => 'admin_verify', $song['Song']['id'], "approve"));?><br /><br />
	<?=$this->Html->link("Verify & Deny This Song for Charting", array('action' => 'admin_verify', $song['Song']['id'], "deny"));?> <br /><br />
</div> 