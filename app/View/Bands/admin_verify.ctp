<?  //pr($band); ?>

<div>
	<h3><?=$band['Band']['name'];?></h3>
</div>
<br />
<div>
	<?=$this->Link->google($band['Band']['name']);?><br />
	<?=$this->Link->all_music($band['Band']['name']);?><br />
	<?=$this->Link->music_brainz($band['Band']['name']);?><br />
	<?=$this->Link->discogs($band['Band']['name']);?><br />
</div>
<br />
<div>
	<h5>Reported By:</h5>
	<table>
	<?=$this->Html->tableHeaders(array('Reporter', 'Spins'));?>
	<? foreach($band['RadioStaffPlaylist'] as $list) : ?>
		<?=$this->Html->tableCells(array(
			$this->Html->link($this->Display->fullName($list['RadioStaffMember']), array(
				'controller'=>'RadioStaffPlaylists', 
				'action'=>'admin_view/'.$list['RadioStaffMember']['id'].'/'.$list['id'])), 
			$list['spins']
			)); ?>
	<? endforeach; ?>
	</table>
</div>
<br />
<div>
	<?=$this->Form->create('Band');?>
	<?=$this->Form->input('name', array('label' => "Band/Artist Name"));?>
	<?=$this->Form->input('email', array('label' => "Primary Email"));?>
	<?=$this->Form->input('state_id', array('label' => "State/Provence", 'empty'=>'Select One'));?>
	<?=$this->Form->input('country_id', array('label' => "Country", 'empty'=>'Select One'));?>
	<?=$this->Form->hidden('id', array('value'=>$id));?>
	<?=$this->Form->end(__('Save Changes'));?>
</div>
<br />
<? if(!empty($band['Album'])): ?>
<div>
	<h5>Albums and Songs:</h5>
	<? foreach($band['Album'] as $album): ?>
	<div>
		<span><?=$album['name'];?> - <?=$album['Label']['name'];?> <? if(!$album['verified']) echo $this->Html->link("verify album", array('controller' => 'albums', 'action' => 'admin_find_comparisons', $album['id']), array('target' => '_blank'));?></span>
		<? if(!empty($album['Song'])): ?>
		<ul>
			<? foreach($album['Song'] as $song): ?>
			<li style="list-style: none; margin: 0 0 0 10px;">&ldquo;<?=$song['name'];?>&rdquo; - <?=$song['SubGenre']['name'];?> <? if(!$song['verified']) echo $this->Html->link("verify song", array('controller' => 'songs', 'action' => 'admin_find_comparisons', $song['id']), array('target' => '_blank'));?></li>
			<? endforeach; ?>					   
		</ul>
		<? endif; ?>
	</div>
	<? endforeach; ?>
</div>
<br />
<? endif; ?> 

<div>
	<?=$this->Html->link("Verify & Approve This Band for Charting", array('controller' => 'Bands', 'action' => 'admin_verify', $band['Band']['id'], "approve"));?><br /><br />
	<?=$this->Html->link("Verify & Deny This Band for Charting", array('controller' => 'Bands', 'action' => 'admin_verify', $band['Band']['id'], "deny"));?> <br /><br />
</div> 