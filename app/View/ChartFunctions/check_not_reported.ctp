<? //pr($not_reported); ?>
<h1>Reporters that did not Report this week,<br /> <span class="smaller">but reported last week.</span></h1>

<table>
<?=$this->Html->tableHeaders(array('Station', 'Member'));?>
<? foreach($not_reported as $staff): ?>
	<?=$this->Html->tableCells(array(
		$staff['RadioStation']['name'],
		$this->Html->link($this->Display->fullName($staff['RadioStaffMember']),array('controller' => 'RadioStaffPlaylists', 'action' => 'admin_edit', $staff['RadioStaffMember']['id']), array('target' => '_blank')), 
	));?>
<? endforeach; ?>
</table>

<h3><?=$this->Html->link('Continue Generating Charts', array('action' => 'compile_radio_playlists'));?></h2>