<table>
	<?=$this->Html->tableHeaders(array('Genre', 'Sub Genre', 'Actions'));?>
	<? foreach($sub_genres as $sub_genre): ?>
		<? $actions = $this->Display->actions($sub_genre['SubGenre']['id'], array('edit', 'delete'), true); ?>
		<?=$this->Html->tableCells(array($sub_genre['Genre']['name'], $sub_genre['SubGenre']['name'], $actions)); ?>
	<? endforeach; ?>
</table>