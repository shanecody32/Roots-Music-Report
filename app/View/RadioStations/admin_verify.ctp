<? // pr($album); ?>

<div>
	<h3><?=$radio_station['RadioStation']['name']; ?><br /><span class="smaller"><?=Inflector::humanize($radio_station['RadioStation']['type']);?></span></h3>
</div>

<div>
	<?=$this->Link->google($radio_station['RadioStation']['name']);?><br />
</div>

<? if(!empty($radio_station['RadioStaffMember'])): ?>
<div>
	<h5>Reporters:</h5>
	<ul>
	<? foreach($radio_station['RadioStaffMember'] as $staffmember): ?>
		<li style="list-style: none;"><?=$staffmember['first_name'];?> <?=$staffmember['last_name'];?> - Reporting Since <?=$this->Format->date($staffmember['created']);?></li>
	<? endforeach; ?>					
	</ul>
</div>
<? endif; ?>

<div>
	<?=$this->Html->link("Verify & Approve This Station for Reporting", array('controller' => 'RadioStations', 'action' => 'admin_verify', $radio_station['RadioStation']['id'], "approve"));?><br /><br />
	<?=$this->Html->link("Verify & Deny This Station for Reporting", array('controller' => 'RadioStations', 'action' => 'admin_verify', $radio_station['RadioStation']['id'], "deny"));?> <br /><br />
</div> 