<div class="system_notes index">
	<h2><?=__('System Notes');?></h2>
	<span class="smaller"><?=$this->Html->link('Create System Note', array('controller'=>'system_notes', 'action'=>'admin_add')); ?></span>	
		
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?=$this->Paginator->sort('group');?></th>
			<th><?=$this->Paginator->sort('title');?></th>
			<th><?=$this->Paginator->sort('type');?></th>
			<th class="actions"><?=__('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($system_notes as $system_note):
	$altrow = false;
		$class = ' class="row"';
		if ($i++ % 2 == 0) {
			$altrow = true;
			$class = ' class="altrow"';
		}
	?>
	<tr <?=$class;?>>
		<td><?=$system_note['SystemNote']['group']; ?></td>
		<td><?=$system_note['SystemNote']['title']; ?>&nbsp;</td>
		<td><?=$system_note['SystemNote']['type']; ?>&nbsp;</td>
		<td class="actions">
			<?=$this->Html->link(__('View'), array('action' => 'admin_view', $system_note['SystemNote']['id'])); ?>
			<?=$this->Html->link(__('Edit'), array('action' => 'admin_edit', $system_note['SystemNote']['id'])); ?>
			<?=$this->Html->link(__('Delete'), array('action' => 'admin_delete', $system_note['SystemNote']['id']), null, sprintf(__('Are you sure you want to delete system note "%s"?'), $system_note['SystemNote']['title'])); ?>
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
