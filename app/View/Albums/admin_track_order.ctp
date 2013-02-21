<?//  pr($album); ?>
<?=$this->Form->create('Album');?>
<table>
	<tr>
		<th>Track Number</th>
		<th>Song Title</th>
	</tr>
	<? $i = 0; foreach($album['Song'] as $song): ?>
	<tr>
		<td><?=$this->Form->input($i.'.AlbumTrack.track_num', array('label' => "", 'value'=>$song['AlbumTracks']['track_num']));?>
			<?=$this->Form->input($i.'.AlbumTrack.album_id', array('label' => "", 'type'=>'hidden', 'value'=>$song['AlbumTracks']['album_id']));?>
			<?=$this->Form->input($i.'.AlbumTrack.song_id', array('label' => "", 'type'=>'hidden', 'value'=>$song['AlbumTracks']['song_id']));?>
			<?=$this->Form->input($i.'.AlbumTrack.id', array('label' => "", 'type'=>'hidden', 'value'=>$song['AlbumTracks']['id']));?></td>
		<td><?=$song['name']; ?></td>
	</tr>
	<? $i++; endforeach; ?>
</table>
<?=$this->Form->end(__('Save Changes'));?>