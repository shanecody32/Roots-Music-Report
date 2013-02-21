<? // pr($chart);?>
<h1><?=$sub_genre?> Album Chart Preview</h1> 
<p>This chart does not omit unverified/unapproved albums and artists, when the actual charted any unverified artists will not be included.</p>
<p>unverified artists/albums are marked in green - unapproved artists/albums are marked in red</p>
<table>
	<tr>
		<th>Rank</th>
		<th>Album Title</th>
		<th>Band/Artist Name</th>
		<th>Spins</th>
		<th>Stations</th>
	<tr>
	<? $i = 1; foreach($chart as $entry): ?>
	<tr>
		<td><?=$i;?></td>
		<td <? 
			if(!$entry['Album']['verified']) echo 'style="color:#0f0;"';
			else if(!$entry['Album']['approved']) echo 'style="color:#f00;"';
			?>><?=$entry['Album']['name'];
			?></td>
		<td <? 
			if(!$entry['Album']['Band']['verified']) echo 'style="color:#0f0;"';
			else if(!$entry['Album']['Band']['approved']) echo 'style="color:#f00;"';
			?>><?=$entry['Album']['Band']['name']; ?></td>
		<td><?=$entry['AlbumStat']['tw_spins']; ?></td>
		<td><?=$entry['AlbumStat']['tw_stations']; ?></td>
	<tr>
	
	<? $i++; endforeach; ?>


</table>
