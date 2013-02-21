<? // pr($details); ?>

<script type="text/javascript">


	// Load the Visualization API and the piechart package.
	google.load('visualization', '1.0', {'packages':['corechart', 'table']});
	
	// Set a callback to run when the Google Visualization API is loaded.
	google.setOnLoadCallback(drawChart);
	
	// Callback that creates and populates a data table,
	// instantiates the pie chart, passes in the data and
	// draws it.
function drawChart() {
			
	var tableoptions = {
		showRowNumber: false,
		alternatingRowStyle: 'true',
		cssClassNames: {oddTableRow: 'altrow', tableRow:'row', hoverTableRow: 'hover-row', headerRow: 'header-row'},
		allowHtml: "true"
	};
		
	// Create the data table.
	var band_table = new google.visualization.DataTable();
	band_table.addColumn('string', 'Station');
	band_table.addColumn('string', 'Song Played');
	band_table.addColumn('string', 'Album Played');
	band_table.addColumn('number', 'Spins');
	band_table.addRows([
		<? foreach($details as $entry): ?>
			[
				'<?=$this->Html->link($entry['RadioStation']['name'], array(
					'controller' => 'radio_stations',
					'action' => 'view', 
					$entry['RadioStation']['id']
					)); 
				?>',
				'<?=$entry['Song']['name']; ?>',
				'<?=$entry['Album']['name']; ?>',
				<?=$entry['RadioStationPlaylistArchive']['spins']; ?>
			],
		<? endforeach; ?>
	]);

	var btable = new google.visualization.Table(document.getElementById('band-tracking-table-area'));
	btable.draw(band_table, tableoptions);		
}	 
</script>
<section id="profile">
	<h1 id="bandname">
    	<span class="smaller">Stations Playing</span></br>
     	<?=$band['Band']['name'];?><br />
        <span class="smaller">for The Week of <?=$this->Format->date($date, 'full'); ?></span>
        </h1>
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
	<article id="tracking-table">
		<h2 class="hidden">Table of Stations Playing <?=$band['Band']['name'];?> for The Week of <?=$this->Format->date($date, 'full'); ?></h2>
		<div id='band-tracking-table-area'>
		</div>
	</article>
</section>