<div class="system_notes index">
	<h2><?=__('Violations');?></h2>
	<span class="smaller"><?=$this->Html->link('Create Violation', array('controller'=>'violations', 'action'=>'admin_add')); ?></span>	
		
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?=$this->Paginator->sort('group');?></th>
			<th><?=$this->Paginator->sort('title');?></th>
			<th><?=$this->Paginator->sort('type');?></th>
			<th class="actions"><?=__('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($violations as $violation):
	$altrow = false;
		$class = ' class="row"';
		if ($i++ % 2 == 0) {
			$altrow = true;
			$class = ' class="altrow"';
		}
	?>
	<tr <?=$class;?>>
		<td><?=$violation['Violation']['group']; ?></td>
		<td><?=$violation['Violation']['title']; ?>&nbsp;</td>
		<td><?=$violation['Violation']['type']; ?>&nbsp;</td>
		<td class="actions">
			<?=$this->Html->link(__('View'), array('action' => 'admin_view', $violation['Violation']['id'])); ?>
			<?=$this->Html->link(__('Edit'), array('action' => 'admin_edit', $violation['Violation']['id'])); ?>
			<?=$this->Html->link(__('Delete'), array('action' => 'admin_delete', $violation['Violation']['id']), null, sprintf(__('Are you sure you want to delete system note "%s"?'), $violation['Violation']['title'])); ?>
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
		<?=$this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?=$this->Paginator->numbers();?>
 |
		<?=$this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
