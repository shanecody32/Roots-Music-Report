<? //pr($not_final); ?>


<ul>
<? foreach($not_final as $staff): ?>
	<li><?=$this->Html->link( $staff['RadioStation']['name']." - ". $this->Display->fullName($staff['RadioStaffMember']),array('controller' => 'RadioStaffPlaylists', 'action' => 'edit', $staff['RadioStaffMember']['id'], 'admin'=>true), array('target' => '_blank')); ?></li>
<? endforeach; ?>
</ul>