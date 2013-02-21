<? // pr($album); ?>

<div>
	<h1><?=$album['Album']['name']; ?></h1>
	<h3>by <?=$album['Band']['name'];?></h3>
</div>
<br />
<div>
	<?=$this->Link->google($album['Band']['name'] . " " . $album['Album']['name']);?><br />
	<?=$this->Link->all_music($album['Band']['name'], 'album');?><br />
	<?=$this->Link->music_brainz($album['Band']['name'], 'release');?><br />
	<?=$this->Link->discogs(array($album['Band']['name'], $album['Album']['name']), 'release');?><br />
</div>
<br />
<? if(!empty($album['RadioStaffPlaylist'])){ ?>
<div>
	<h5>Reported By:</h5>
	<table>
	<?=$this->Html->tableHeaders(array('Reporter', 'Spins'));?>
	<? foreach($album['RadioStaffPlaylist'] as $list) : ?>
		<?=$this->Html->tableCells(array(
			$this->Html->link($this->Display->fullName($list['RadioStaffMember']), array(
				'controller'=>'RadioStaffPlaylists', 
				'action'=>'admin_view/'.$list['RadioStaffMember']['id'].'/'.$list['id'])), 
			$list['spins']
			)); ?>
	<? endforeach; ?>
	</table>
</div>
<? } else { ?>
	<h5>No Reporters Playing This Week</h5>
<? } ?>
<br />
<div>
	<?=$this->Form->create('Album');?>
	<?=$this->Form->input('name', array('label' => "Album Title"));?>
	<?=$this->Form->input('Label.name', array('label' => "Label"));?>
	<?=$this->Form->input('sub_genre_for_charting', array('empty'=>'Select One', 'options'=>$sub_genres, 'label'=>'Album Charts As Genre')); ?>
	<?=$this->Form->hidden('id', array('value'=>$id));?>
	<?=$this->Form->end(__('Save Changes'));?>
</div>
<br />
<? if(!empty($album['Song'])): ?>
<div>
	<h5>Songs:</h5>
	<ul>
	<? foreach($album['Song'] as $song): ?>
		<li style="list-style: none;">&ldquo;<?=$song['name'];?>&rdquo; - <?=$song['SubGenre']['name'];?> <? if(!$song['verified']) echo $this->Html->link("verify song", array('controller' => 'songs', 'action' => 'admin_find_comparisons', $song['id']), array('target' => '_blank'));?></li>
	<? endforeach; ?>					   
	</ul>
</div>
<? endif; ?>
<br />
<div>
	<?=$this->Html->link("Verify & Approve This Album for Charting", array('controller' => 'Albums', 'action' => 'admin_verify', $album['Album']['id'], "approve"));?><br /><br />
	<?=$this->Html->link("Verify & Deny This Album for Charting", array('controller' => 'Albums', 'action' => 'admin_verify', $album['Album']['id'], "deny"));?> <br /><br />
</div> 