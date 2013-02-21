<? // pr($bands); ?>
<?
if($this->Paginator->params['paging']['State']['count'] >= $page_limit){
	$one_page = false; 	
} else {
	$one_page = true; 	
}
?>

<div class="states index">
	<h2><?=__('States');?></h2>
	<p class="smaller"><?=$this->Html->link('Create State', array('controller'=>'states', 'action'=>'admin_add')); ?></span>

<? if(!$one_page) echo $this->Display->pages(false);?>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?=$this->Paginator->sort('State.new', 'New');?></th>
		<th><?=$this->Paginator->sort('State.name', 'Name');?></th>
		<th><?=$this->Paginator->sort('State.abbrv', 'Abbrv.');?></th>
		<th><?=$this->Paginator->sort('Country.name', 'Country');?></th>
		<th class="actions"><?=__('Actions');?></th>
	</tr>
	<?
	$i = 0;
	foreach ($states as $state):
		$altrow = false;
		$class = ' class="row"';
		if ($i++ % 2 == 0) {
			$altrow = true;
			$class = ' class="altrow"';
		}
		
		

	?>
	<tr<?=$class;?>>
		<td style="color:#f00;"><? if($state['State']['new'] == 1){ echo 'NEW'; } ?></td>
		<td><?=$state['State']['name']; ?>&nbsp;</td>
		<td><?=$state['State']['abbrv']; ?>&nbsp;</td>
		<td><?=$state['Country']['name']; ?>&nbsp;</td>
		<td class="actions">
			<?=$this->Html->link(__('Edit'), array('action' => 'admin_edit', $state['State']['id'])); ?>
			<?=$this->Html->link(__('Delete'), array('action' => 'admin_delete', $state['State']['id']), null, sprintf(__('Are you sure you want to delete %s?'), $state['State']['name'])); ?>
		</td>
	</tr>
<? endforeach; ?>
		</table>
	<p>
	<?
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<? if(!$one_page) echo $this->Display->pages();?>
</div>
