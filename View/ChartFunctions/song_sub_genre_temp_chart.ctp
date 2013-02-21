<? // pr($chart);?>
<h1><?=$sub_genre?> Song Chart Preview</h1> 
<p>This chart does not omit unverified/unapproved songs and artists, when the actual charted any unverified artists will not be included.</p>
<p>unverified artists/songs are marked in green - unapproved artists/songs are marked in red</p>
<table>
	<tr>
		<th>Rank</th>
		<th>Song Title</th>
		<th>Band/Artist Name</th>
		<th>Spins</th>
		<th>Stations</th>
	<tr>
	<? $i = 1; foreach($chart as $entry): ?>
	<tr>
		<td><?=$i;?></td>
		<td <? 
			if(!$entry['Song']['Band']['verified']) echo 'style="color:#0f0;"';
			else if(!$entry['Song']['Band']['approved']) echo 'style="color:#f00;"';
			?>><?=$entry['Song']['name'];
			?></td>
		<td <? 
			if(!$entry['Song']['Band']['verified']) echo 'style="color:#0f0;"';
			else if(!$entry['Song']['Band']['approved']) echo 'style="color:#f00;"';
			?>><?=$entry['Song']['Band']['name']; ?></td>
		<td><?=$entry['SongStat']['tw_spins']; ?></td>
		<td><?=$entry['SongStat']['tw_stations']; ?></td>
	<tr>
	
	<? $i++; endforeach; ?>


</table>
