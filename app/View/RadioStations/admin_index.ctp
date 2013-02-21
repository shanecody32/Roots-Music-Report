<div class="radio_stations index">
	<h2><?=__('Radio Stations');?></h2>
		<table>
			<tr>
				<th style="border:none;"><?=$this->Paginator->sort('approved');?></th>
				<th style="border:none;"><?=$this->Paginator->sort('verified');?></th>
				<th style="border:none;"><?=$this->Paginator->sort('violations');?></th>
				<th style="border:none;"><?=$this->Paginator->sort('automatic');?></th>
			</tr>
		</table>
		
		
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th></th>
			<th><?=$this->Paginator->sort('name');?></th>
			<th><?=$this->Paginator->sort('type');?></th>
			<th class="actions"><?=__('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($radio_stations as $radioStation):
		$altrow = false;
		$class = ' class="row"';
		if ($i++ % 2 == 0) {
			$altrow = true;
			$class = ' class="altrow"';
		}

		/*if(!empty($album['Album']['violations'])){
			if(!$altrow)
				$class = ' class="red"';
			else
				$class = ' class="altred"';
		} */

		if(!$radioStation['RadioStation']['verified']){ //!$album['Album']['violations'] && 
			if(!$altrow)
				$class = ' class="yellow"';
			else
				$class = ' class="altyellow"';
		}
		
		if(!$radioStation['RadioStation']['verified'] && $radioStation['RadioStation']['approved']){
			if(!$altrow)
				$class = ' class="red"';
			else
				$class = ' class="altred"';
		}
		
		if($radioStation['RadioStation']['verified'] && !$radioStation['RadioStation']['approved']){ //!$album['Album']['violations'] && 
			if(!$altrow)
				$class = ' class="green"';
			else
				$class = ' class="altgreen"';
		}

	?>
	<tr <?=$class;?>>
		<td><? if($radioStation['RadioStation']['automatic']) echo "&infin;"; ?></td>
		<td><?=$radioStation['RadioStation']['name']; ?>&nbsp;</td>
		<td><?=$radioStation['RadioStation']['type']; ?>&nbsp;</td>
		<td class="actions">
			<?=$this->Html->link(__('Verify'), array('action' => 'admin_find_comparisons', $radioStation['RadioStation']['id'])); ?>
			<?=$this->Html->link(__('View'), array('action' => 'admin_view', $radioStation['RadioStation']['id'])); ?>
			<?=$this->Html->link(__('Playlist'), array('controller'=>'radio_station_playlists','action' => 'admin_view', $radioStation['RadioStation']['id'])); ?>
			<?=$this->Html->link(__('Edit'), array('action' => 'admin_edit', $radioStation['RadioStation']['id'])); ?>
			<?=$this->Html->link(__('Delete'), array('action' => 'admin_delete', $radioStation['RadioStation']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $radioStation['RadioStation']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
		</table>
	<?=$this->Display->pages(); ?>
</div>
