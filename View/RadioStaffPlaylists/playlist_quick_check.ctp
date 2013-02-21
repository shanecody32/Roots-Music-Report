<?

//pr($this->Paginator->params);
if($this->Paginator->params['paging']['RadioStaffPlaylist']['count'] >= $page_limit){
	$one_page = false; 	
} else {
	$one_page = true; 	
}
?>

<? if(!$one_page) echo $this->Display->pages(false);?>
<table>
	<tr>
		<th><?=$this->Paginator->sort('Song.name', 'Song Title');?></th>
		<th><?=$this->Paginator->sort('Album.name', 'Album Title');?></th>
		<th><?=$this->Paginator->sort('Band.name', 'Band Name');?></th>
		<th>Label</th>
		<th>Genre</th>
		<th><?=$this->Paginator->sort('RadioStaffPlaylist.spins', 'Spins');?></th>
	</tr>

<? foreach($lists as $item): ?>
	<tr>
		<td>&ldquo;<?=$item['Song']['name'];?>&rdquo;</td>
		<td><?=$item['Album']['name'];?></td>
		<td><?=$item['Band']['name'];?></td>
		<td><?=$this->Logic->unknown($item['Album']['Label'],'name');?></td>
		<td><?=$this->Logic->unknown($item['Song']['SubGenre'],'name');?></td>
		<td><?=$item['RadioStaffPlaylist']['spins']; //ReporterPlaylistArchive ?></td>
	</tr>
<? endforeach; ?>
</table>
<? if(!$one_page) echo $this->Display->pages(false);?>

<?// pr($staff); ?>
<? //pr($playlists); ?>