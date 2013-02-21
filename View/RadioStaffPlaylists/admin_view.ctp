<div id="title">
	<div id="images">
		<? if(!empty($staff['RadioStaffImage'])){ ?>
		<?=$this->Html->image($staff['RadioStaffImage'][0]['path'].$staff['RadioStaffImage'][0]['thumbname'], array('alt'=>'Image of '.$staff['RadioStaffMember']['first_name'].' '.$staff['RadioStaffMember']['last_name'])); ?>
		<? } else { ?>
		<?=$this->Html->image('no_radio_logo.jpg', array('alt'=>'No Logo for '.$staff['RadioStaffMember']['first_name'].' '.$staff['RadioStaffMember']['last_name'], 'style'=>'width:100px;')); ?>
		<? } ?>
	</div>
	<h1 id="radioname"><span class="smaller">Reported Airplay</span><br /> <?=$staff['RadioStaffMember']['first_name'].' '.$staff['RadioStaffMember']['last_name'];?></h1>
	<?=Inflector::humanize($staff['RadioStation']['type']); ?> Airplay Reporter for <?=$staff['RadioStation']['name']; ?><br />
	<?=$this->Html->link('edit playlist', array('action'=>'admin_edit', $staff['RadioStaffMember']['id'])); ?>
</div>
<div class="clearfloats">&nbsp;</div>
<? if($playlists){?>
<table>
	<tr>
		<th><?=$this->Paginator->sort('Song.name', 'Song Title');?></th>
		<th><?=$this->Paginator->sort('Album.name', 'Album Title');?></th>
		<th><?=$this->Paginator->sort('Band.name', 'Band Name');?></th>
		<th>Label</th>
		<th>Genre</th>
		<th><?=$this->Paginator->sort('RadioStaffPlaylist.spins', 'Spins');?></th>
	</tr>

<? foreach($playlists as $item): ?>
	<tr<? if(isset($highlight) && $item['RadioStaffPlaylist']['id'] == $highlight) echo ' class="highlight"';?>>
		<td>&ldquo;<?=$item['Song']['name'];?>&rdquo;</td>
		<td><?=$item['Album']['name'];?></td>
		<td><?=$item['Band']['name'];?></td>
		<td><?=$this->Logic->unknown($item['Album']['Label'],'name');?></td>
		<td><?=$this->Logic->unknown($item['Song']['SubGenre'],'name');?></td>
		<td><?=$item['RadioStaffPlaylist']['spins']; //ReporterPlaylistArchive ?></td>
	</tr>
<? endforeach; ?>
</table>
<? } else { ?>
<h3>This station has not yet reported this week.</h3>
<? } ?>

<?// pr($staff); ?>
<? //pr($playlists); ?>