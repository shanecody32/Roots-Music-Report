<? // pr($bands); ?>
<div class="bands index">
	<h2><?php echo __('Bands');?></h2>
		<table>
			<tr>
				<th style="border:none;"><?php echo $this->Paginator->sort('approved');?></th>
				<th style="border:none;"><?php echo $this->Paginator->sort('verified');?></th>
				<th style="border:none;"><?php echo $this->Paginator->sort('violations');?></th>
			</tr>
		</table>


	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($bands as $band):
		$altrow = false;
		$class = ' class="row"';
		if ($i++ % 2 == 0) {
			$altrow = true;
			$class = ' class="altrow"';
		}

		if(!empty($band['Violation'])){
			if(!$altrow)
				$class = ' class="red"';
			else
				$class = ' class="altred"';
		}

		if(!$band['Violation'] && !$band['Band']['verified']){
			if(!$altrow)
				$class = ' class="yellow"';
			else
				$class = ' class="altyellow"';
		}
		
		if(!$band['Band']['verified'] && $band['Band']['approved']){
			if(!$altrow)
				$class = ' class="red"';
			else
				$class = ' class="altred"';
		}
		
		if(!$band['Violation'] && $band['Band']['verified'] && !$band['Band']['approved']){
			if(!$altrow)
				$class = ' class="green"';
			else
				$class = ' class="altgreen"';
		}

	?>
	<tr<?php echo $class;?>>
		<td><?php echo $band['Band']['name']; ?>&nbsp;</td>
		<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'admin_view', $band['Band']['id'])); ?>
					<?php echo $this->Html->link(__('Verify'), array('action' => 'admin_find_comparisons', $band['Band']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'admin_edit', $band['Band']['id'])); ?>
					<?php echo $this->Html->link(__('Delete'), array('action' => 'admin_delete', $band['Band']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $band['Band']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
		</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
