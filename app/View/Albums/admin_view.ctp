<?// pr($album); ?>

<section id="profile">
	<h1 id="radioname"><?=$album['Album']['name'];?><br /> <span class="smaller">by <?=$this->Html->link($album['Band']['name'], array('controller'=>'bands','action'=>'admin_view'.DS.$album['Band']['id']));?></span></h1>
	<?=$this->Html->link('Edit Album', array('action'=>'admin_edit/'.$album['Album']['id']."/".$album['Band']['id'])); ?>
	<div id="images">
		<? if(!empty($album['AlbumImage']['id']) && file_exists(WWW_ROOT.'img'.DS.$album['AlbumImage']['path'].$album['AlbumImage']['filename'])){ ?>
		<?=$this->Image->resize($album['AlbumImage']['path'].$album['AlbumImage']['filename'], 150, 150, true, array('alt'=>'Image for '.$album['Album']['name'])); ?><br />
		<?=$this->Html->link('change image', array('controller'=>'album_images','action'=>'admin_add/'.$album['Album']['id'])); ?>
		<? } else { ?>
		<?=$this->Image->resize('no_image.jpg', 150, 150, true, array('alt'=>'No Image for '.$album['Album']['name'])); ?><br />
		<?=$this->Html->link('add image', array('controller'=>'album_images','action'=>'admin_add/'.$album['Album']['id'])); ?>
		<? } ?>
	</div>
	<article id="album_stats">
		<b>Highest Ranking Achieved:</b> <? if($album['AlbumStat']['hr_achieved'] != 0) echo $album['AlbumStat']['hr_achieved']; else echo "Has not yet charted."; ?><br />
		<b>First Charted on:</b> <? if($album['AlbumStat']['first_charted'] != "0000-00-00") echo $this->Format->date($album['AlbumStat']['first_charted']); else echo "Has not yet charted."; ?><br />
		<b>Total Spins Recieved:</b> <?=$album['AlbumStat']['total_spins']; ?><br />
		<b>This Week Spins Recieved:</b> <?=$album['AlbumStat']['tw_spins']; ?><br />
		<b>Last Week Spins Recieved:</b> <?=$album['AlbumStat']['lw_spins']; ?><br />
		<b>Total Stations Played:</b> <?=$album['AlbumStat']['total_stations']; ?><br />
		<b>This Week Stations Played:</b> <?=$album['AlbumStat']['tw_stations']; ?><br />
		<b>Last Week Stations Played:</b> <?=$album['AlbumStat']['tw_stations']; ?><br />
		<br /><b style="color:#f00;">*** Charts as <?=$charts_as['SubGenre']['name']; ?> ***</b><br /><br />
	</article>
	<article id="album_details">
		<h1>Songs on the Album:</h1>
		<?=$this->Html->link('add song', array('controller'=>'songs','action'=>'admin_add/'.$album['Album']['id'])); ?>
		<table>
			<tr>
				<th>Track # <?=$this->Html->link('edit track order', array('controller'=>'albums','action'=>'admin_track_order/'.$album['Album']['id'])); ?></th>
				<th>Song Title</th>
				<th>Genre</th>
				<th></th>
			</tr>
		<? foreach($album['Song'] as $song): ?>
			<tr>
				<td><? if(!empty($song['AlbumTracks']['track_num'])) echo $song['AlbumTracks']['track_num']; ?></td>
				<td><?=$song['name'];?></td>
				<td><?=$song['SubGenre']['name'];?></td>
				<td><?=$this->Html->link('edit', array('controller'=>'songs','action'=>'admin_edit/'.$song['id'].'/'.$album['Album']['id'])); ?></td>
			</tr>
		<? endforeach; ?>
		</table>
	</article>
</section>
