<section>
	<div id="images">
		<? if(!empty($radio['RadioStationImage'])){ ?>
		<?=$this->Html->image($radio['RadioStationImage'][0]['path'].$radio['RadioStationImage'][0]['thumbname'], array('alt'=>'No Logo for '.$radio['RadioStation']['name'])); ?>
		<? } else { ?>
		<?=$this->Html->image('no_radio_logo.jpg', array('alt'=>'No Logo for '.$radio['RadioStation']['name'], 'style'=>'width:100px;')); ?>
		<? } ?>
	</div>
	<header>
		<hgroup>
			<h1><span class="smaller">Reported Airplay</span><br /> <?=$radio['RadioStation']['name'];?></h1>
			<h2><?=Inflector::humanize($radio['RadioStation']['type']); ?> Airplay Reporter</h2>
		</hgroup>
	</header>
	<?=$this->Html->link('edit playlist', array('action'=>'admin_edit', $radio['RadioStation']['id'])); ?>
</section>
<div class="clearfloats">&nbsp;</div>
<article>
	<h2>Radio Station Reported Airplay</h2>
	<? if($playlists){?>
	<table>
		<tr>
			<th><?=$this->Paginator->sort('Song.name', 'Song Title');?></th>
			<th><?=$this->Paginator->sort('Album.name', 'Album Title');?></th>
			<th><?=$this->Paginator->sort('Band.name', 'Band Name');?></th>
			<th>Label</th>
			<th>Genre</th>
			<th><?=$this->Paginator->sort('RadioStationPlaylist.spins', 'Spins');?></th>
		</tr>

	<? foreach($playlists as $item): ?>
		<tr>
			<td>&ldquo;<?=$item['Song']['name'];?>&rdquo;</td>
			<td><?=$item['Album']['name'];?></td>
			<td><?=$item['Band']['name'];?></td>
			<td><?=$this->Logic->unknown($item['Album']['Label'],'name');?></td>
			<td><?=$this->Logic->unknown($item['Song']['SubGenre'],'name');?></td>
			<td><?=$item['RadioStationPlaylist']['spins']; //ReporterPlaylistArchive ?></td>
		</tr>
	<? endforeach; ?>
	</table>
	<? } else { ?>
	This station has not yet reported this week.
	<? } ?>
</article>
<?// pr($radio); ?>
<? //pr($playlists); ?>