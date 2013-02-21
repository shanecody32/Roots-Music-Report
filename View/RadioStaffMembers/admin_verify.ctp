<? // pr($album); ?>

<div>
	<h3><?=$this->Display->fullName($staff['RadioStaffMember']); ?><br />
		<span class="smaller"><?=$staff['RadioStation']['name']; ?> - <?=Inflector::humanize($staff['RadioStation']['type']);?></span></h3>
</div>

<div>
	<?=$this->Link->google($staff['RadioStation']['name']. ' ' .$this->Display->fullName($staff['RadioStaffMember']));?><br />
</div>


<div>
	<?=$this->Html->link("Verify & Approve This Staff Member for Reporting", array('controller' => 'RadioStaffMembers', 'action' => 'admin_verify', $staff['RadioStaffMember']['id'], "approve"));?><br /><br />
	<?=$this->Html->link("Verify & Deny This Staff Member for Reporting", array('controller' => 'RadioStaffMembers', 'action' => 'admin_verify', $staff['RadioStaffMember']['id'], "deny"));?> <br /><br />
</div> 