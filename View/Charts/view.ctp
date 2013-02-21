<? // pr($chart);?>
<h1>Roots Top 50 <?=ucwords($chart_title); ?>s</h1> 
<? //pr($chart); ?>
<table>
<? if(strtolower($type) == 'song'): ?>
	<?=$this->Html->tableHeaders(array(
		'', 
		'TW', 
		'LW', 
		'Song Title', 
		'Band/Artist Name', 
		'Label',
		'Sub Genre'
	));?>
	
	<? foreach($chart as $entry): ?>
		<? if($entry[$model_name]['movement'] > 0) $move = '<span class="up"></span>'; ?>
		<? if($entry[$model_name]['movement'] < 0) $move = '<span class="down"></span>'; ?>
		<? if($entry[$model_name]['movement'] == 0) $move = '-'; ?>
		<? if($entry[$model_name]['weeks_on'] == 1 && $entry['Song']['SongStat']['first_charted'] == 00-00-0000) $move = '<span class="new">NEW</span>'; ?>
		
		<?=$this->Html->tableCells(array(
			$move,
			$entry[$model_name]['rank'], 
			$entry[$model_name]['last_rank'],
			$entry['Song']['name'], 
			$entry['Song']['Band']['name'],
			$entry['Song']['Album'][0]['Label']['name'],
			$entry['Song']['SubGenre']['name']
		), false, array('class'=>'altrow')); ?>
	<? endforeach; ?>
<? endif; ?>

<? if(strtolower($type) == 'album'): ?>
	<?=$this->Html->tableHeaders(array(
		'', 
		'TW', 
		'LW', 
		'Album Title', 
		'Band/Artist Name', 
		'Label'
	)); ?>
	
	<? foreach($chart as $entry): ?>
		<? if($entry[$model_name]['movement'] > 0) $move = '<span class="up"></span>'; ?>
		<? if($entry[$model_name]['movement'] < 0) $move = '<span class="down"></span>'; ?>
		<? if($entry[$model_name]['movement'] == 0) $move = '-'; ?>
		<? if($entry[$model_name]['weeks_on'] == 1 && $entry['Album']['AlbumStat']['first_charted'] == 00-00-0000) $move = '<span class="new">NEW</span>'; ?>
		<?=$this->Html->tableCells(array(
			$move ,
			$entry[$model_name]['rank'], 
			$entry[$model_name]['last_rank'],
			$entry['Album']['name'], 
			$entry['Album']['Band']['name'],
			$entry['Album']['Label']['name']
		), false, array('class'=>'altrow')); ?>
	<? endforeach; ?>
<? endif; ?>
</table>
