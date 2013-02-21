<? // pr($albums); ?>
<div class="albums index">
	<h2><?=__('Albums');?></h2>
		<table>
			<tr>
				<th style="border:none;"><?=$this->Paginator->sort('approved');?></th>
				<th style="border:none;"><?=$this->Paginator->sort('verified');?></th>
				<th style="border:none;"><?=$this->Paginator->sort('violations');?></th>
			</tr>
		</table>


	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?=$this->Paginator->sort('name');?></th>
			<th class="actions"><?=__('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($albums as $album):
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

		if(!$album['Album']['verified']){ //!$album['Album']['violations'] && 
			if(!$altrow)
				$class = ' class="yellow"';
			else
				$class = ' class="altyellow"';
		}
		
		if(!$album['Album']['verified'] && $album['Album']['approved']){
			if(!$altrow)
				$class = ' class="red"';
			else
				$class = ' class="altred"';
		}
		
		if($album['Album']['verified'] && !$album['Album']['approved']){ //!$album['Album']['violations'] && 
			if(!$altrow)
				$class = ' class="green"';
			else
				$class = ' class="altgreen"';
		}

	?>
	<tr<?=$class;?>>
		<td><?=$album['Album']['name']; ?>&nbsp;</td>
		<td class="actions">
					<?=$this->Html->link(__('View'), array('action' => 'admin_view', $album['Album']['id'])); ?>
					<?=$this->Html->link(__('Verify'), array('action' => 'admin_find_comparisons', $album['Album']['id'])); ?>
					<?=$this->Html->link(__('Edit'), array('action' => 'admin_edit', $album['Album']['id'])); ?>
					<!-- remove in final version --><?=$this->Html->link(__('Delete'), array('action' => 'admin_delete', $album['Album']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $album['Album']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
		</table>
	<?=$this->Display->pages(); ?>
</div>
