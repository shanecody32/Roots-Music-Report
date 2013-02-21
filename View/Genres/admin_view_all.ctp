<table>
	<?=$this->Html->tableHeaders(array('Genre', 'Actions'));?>
	<? foreach($sub_genres as $sub_genre): ?>
		<? $actions = $this->Display->actions($genre['Genre']['id'], array('edit', 'delete'), true); ?>
		<?=$this->Html->tableCells(array($genre['Genre']['name'], $actions)); ?>
	<? endforeach; ?>
</table>