<?  // pr($track_songs); ?>
<section id="profile">
	<h1 id="bandname">Air-play Tracking for <?=$band['Band']['name'];?></h1>
	<p>
		<? 
			if(!empty($band['City']['name'])) echo $band['City']['name'].' - ';
			if(!empty($band['State']['name'])) echo $band['State']['name'].' - ';
			if(!empty($band['Country']['name'])) echo $band['Country']['name'];
		?>
	</p>
	<div id="images">
		<? if(!empty($band['BandImage'][0]['id']) && file_exists(WWW_ROOT.'img'.DS.$band['BandImage'][0]['path'].$band['BandImage'][0]['filename'])){ ?>
			<?=$this->Image->resize($band['BandImage'][0]['path'].$band['BandImage'][0]['filename'], 150, 150, true, array('alt'=>'Image for '.$band['Band']['name'])); ?><br />
		<? } else { ?>
			<?=$this->Image->resize('no_image.jpg', 150, 150, true, array('alt'=>'No Image for '.$band['Band']['name'])); ?><br />
		<? } ?>
	</div>

	<section id="band_details">
	<h2 class="hidden">Details for <?=$band['Band']['name'];?></h2>
		<? if(!empty($band['BandLink'])): ?>
<article id="links">
			<h3>Links</h3>			
<table>
			<? foreach($band['BandLink'] as $link): ?>
				<tr>
					<td><?=Inflector::humanize($link['type']);?> - <?=$this->Link->$link['type']($link['link'], 'link', '', '_blank'); ?></td>
					<td><?=$this->Html->link('edit',array('controller'=>'band_links', 'action'=>'admin_edit/'.$link['id'])); ?></td>
					<td><?=$this->Html->link(__('delete'), array('controller'=>'band_links','action' => 'admin_delete', $link['id']), null, sprintf(__('Are you sure you want to delete the link to '.$link['link'].'?'), $link['id'])); ?></td>
				</tr>
			<? endforeach; ?>
			</table>
		<? endif; ?>
	</section>
</section>
<script type="text/javascript">

	// Load the Visualization API and the piechart package.
	google.load('visualization', '1.0', {'packages':['corechart', 'table']});
	
	// Set a callback to run when the Google Visualization API is loaded.
	google.setOnLoadCallback(drawChart);
	
	// Callback that creates and populates a data table,
	// instantiates the pie chart, passes in the data and
	// draws it.
	function drawChart() {
		var chartoptions = {
			title:'# of Times Played Over 3 Months Since Last Week Played',
			width:718,
			height:500,
			colors:['#C92B00', '#343F3A','#C92B00','#C92B00','#343F3A','#C92B00'],
			vAxis: {title: "Spins"},
			hAxis: {title: "Week Ending", slantedText: true}						
		};
		
		var tableoptions = {
			showRowNumber: false,
			page: 'enable',
			pageSize: 10,
			pagingSymbols: {prev: 'prev', next: 'next'},
			pagingButtonsConfiguration: 'auto',
			alternatingRowStyle: 'true',
			cssClassNames: {oddTableRow: 'altrow', tableRow:'row', hoverTableRow: 'hover-row', headerRow: 'header-row'},
			allowHtml: "true"
		};
		
		// Create the data table.
		var band_chart = new google.visualization.DataTable();
		band_chart.addColumn('string', 'Week Ending');
		band_chart.addColumn('number', 'Total Spins for Artist/Band');
		band_chart.addRows([
			<? foreach($track_bands as $key => $entry): ?>
				<? if($key >= $dates['start_date'] && $key <= $dates['end_date']): ?>
					['<?=$this->Format->date($key, 'standard');?>', <?=$entry['spins']?>],
				<? endif; ?>
			<? endforeach; ?>
		]);
		
		var band_table = new google.visualization.DataTable();
		band_table.addColumn('date', 'Week Ending');
		band_table.addColumn('number', 'Spins Received');
		band_table.addColumn('number', 'Stations Played');
		band_table.addColumn('string', '');
		band_table.addRows([
			<? foreach($track_bands as $key => $entry): ?>
				[new Date(<?=$this->Format->date($key, 'javascript');?>), 
				<?=$entry['spins']?>, 
				<?=count($entry['radio']);?>,
				'<?=$this->Html->link(__('Details'), array(
					'action' => 'view_stations_playing_by_week', 
					$band['Band']['id'], 
					$this->Format->date($key, 'link')
				)); ?>'],
			<? endforeach; ?>
		]);

		// Instantiate and draw our chart, passing in some options.
		var bchart = new google.visualization.ColumnChart(document.getElementById('band-tracking-chart-area'));
		bchart.draw(band_chart, chartoptions);		
		
		var btable = new google.visualization.Table(document.getElementById('band-tracking-table-area'));
		btable.draw(band_table, tableoptions);
		
		
		// Create the data table.
		var album_chart = new google.visualization.DataTable();
		album_chart.addColumn('string', 'Week Ending');
		<? foreach($track_albums as $key => $entry): ?>
			<? foreach($entry as $key => $entry): ?>
 				album_chart.addColumn('number', '<?=$key ?>');
			<? endforeach; ?>		
		<? break; endforeach; ?>
		album_chart.addRows([
			<? foreach($track_albums as $key => $entry): ?>
				<? if($key >= $dates['start_date'] && $key <= $dates['end_date']): ?>
					['<?=$this->Format->date($key, 'standard');?>', 
						<? foreach($entry as $key => $entry): ?>
							<?=$entry['spins']?>,
						<? endforeach; ?>
					],
				<? endif; ?>
			<? endforeach; ?>
		]);
		
		var album_table = new google.visualization.DataTable();
		album_table.addColumn('date', 'Week Ending');
		<? foreach($track_albums as $key => $entry): ?>
			<? foreach($entry as $key => $entry): ?>
				album_table.addColumn('number', '<?=$key ?>');
			<? endforeach; ?>		
		<? break; endforeach; ?>
		album_table.addColumn('string', '');
		album_table.addRows([
		<? foreach($track_albums as $key => $entry): ?>
			[
					new Date(<?=$this->Format->date($key, 'javascript');?>),
					<? foreach($entry as $akey => $aentry): ?>
 					<?=$aentry['spins']?>,
					<? endforeach; ?>
				'<?=$this->Html->link(__('Details'), array(
					'action' => 'view_stations_playing_by_week', 
					$band['Band']['id'], 
					$this->Format->date($key, 'link')
				)); ?>'	 
			],
		<? endforeach; ?>
		]);

// Instantiate and draw our chart, passing in some options.
		var achart = new google.visualization.ColumnChart(document.getElementById('album-tracking-chart-area'));
		achart.draw(album_chart, chartoptions);	
		
		var atable = new google.visualization.Table(document.getElementById('album-tracking-table-area'));
		atable.draw(album_table, tableoptions);	
		
		// Create the data table.
		var song_chart = new google.visualization.DataTable();
		song_chart.addColumn('string', 'Week Ending');
		<? foreach($track_songs as $key => $entry): ?>
			<? foreach($entry as $key => $entry): ?>
				<? // if($key != 'Unknown'): ?>
 					song_chart.addColumn('number', '<?=$key ?>');
				<? // endif; ?>
			<? endforeach; ?>		
		<? break; endforeach; ?>
		song_chart.addRows([
			<? foreach($track_songs as $key => $entry): ?>
				<? if($key >= $dates['start_date'] && $key <= $dates['end_date']): ?>
					['<?=$this->Format->date($key, 'standard');?>', 
						<? foreach($entry as $skey => $sentry): ?>
							<? // if($key != 'Unknown'): ?>
								<?=$sentry['spins']?>,
							<? // endif; ?>
						<? endforeach; ?>
					],
				<? endif; ?>
			<? endforeach; ?>
		]);
		
		var song_table = new google.visualization.DataTable();
		song_table.addColumn('date', 'Week Ending');
		<? foreach($track_songs as $key => $entry): ?>
			<? foreach($entry as $key => $entry): ?>
				<? // if($key != 'Unknown'): ?>
 					song_table.addColumn('number', '<?=$key ?>');
				<? // endif; ?>
			<? endforeach; ?>		
		<? break; endforeach; ?>
		song_table.addColumn('string', '');
		song_table.addRows([
		<? foreach($track_songs as $key => $entry): ?>
			[
				new Date(<?=$this->Format->date($key, 'javascript');?>),
				<?  foreach($entry as $skey => $sentry): ?>
 					<? // if($skey != 'Unknown'): ?>
						<?=$sentry['spins']?>,
					<? // endif; ?>
				<? endforeach; ?>
				'<?=$this->Html->link(__('Details'), array(
					'action' => 'view_stations_playing_by_week', 
					$band['Band']['id'], 
					$this->Format->date($key, 'link')
				)); ?>'	 
			],
		<? endforeach; ?>
		]);
		
		<? /*=$this->Html->link(__('Details'), array(
					'action' => 'view_stations_playing_by_week', 
					$band['Band']['id'], 
					$this->Format->date($key, 'link')
				)); */ ?>

// Instantiate and draw our chart, passing in some options.
		var schart = new google.visualization.ColumnChart(document.getElementById('song-tracking-chart-area'));
		schart.draw(song_chart, chartoptions);	
		
		var stable = new google.visualization.Table(document.getElementById('song-tracking-table-area'));
		stable.draw(song_table, tableoptions);	
		
	}	 
</script>
<script language="javascript">
$(function() {
        $( "#tabs" ).tabs();
    });
</script>
<div id="tabs">
	<ul>
        <li><a href="#band-totals">Band Totals</a></li>
        <li><a href="#album-totals">Album Totals</a></li>
        <li><a href="#song-totals">Song Totals</a></li>
    </ul>
<section id="band-totals">
	<h2 class="hidden">Band Totals</h2>
	<article id="tracking-chart">
		<h2 class="hidden">Chart: # of Times Band Played Over 3 Months Since Last Played</h2>
		<div id="band-tracking-chart-area">
		</div>
	</article>

	<article id="tracking-table">
		<h2>Complete List</h2>
		<div id='band-tracking-table-area'>
		</div>
	</article>
</section>
<section id="album-totals">
	<h2 class="hidden">Album Totals</h2>
	<article id="album-tracking-chart">
		<h2 class="hidden">Chart: # of Times Albums Played Over 3 Months Since Last Played</h2>
		<div id="album-tracking-chart-area">
		</div>
	</article>

	<article id="album-tracking-table">
		<h2>Complete List</h2>
		<div id='album-tracking-table-area'>
		</div>
	</article>
</section>
<section id="song-totals">
	<h2 class="hidden">Song Totals</h2>
	<article id="song-tracking-chart">
		<h2 class="hidden">Chart: # of Times Songs Played Over 3 Months Since Last Played</h2>
		<div id="song-tracking-chart-area">
		</div>
	</article>

	<article id="song-tracking-table">
		<h2>Complete List</h2>
		<div id='song-tracking-table-area'>
		</div>
	</article>
</section>
</div>