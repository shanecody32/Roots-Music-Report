<div>
<table>
    <tr>
		<th>New Station Information</th>
	   <th>Existing Station</th>
    </tr>
    <tr>
	   <td>
		  <div>
			 <h3><?=$original['RadioStation']['name'];?><br />
					<span class="smaller"><?=Inflector::humanize($original['RadioStation']['type']);?></span></h3>
			 <?=$this->Link->google($original['RadioStation']['name']);?><br />
			 Created: <?=$this->Format->date($original['RadioStation']['created']); ?>
		  </div>
		  <div>
			 <h5>Reporters:</h5>
					<? if(!empty($original['RadioStaffMember'])): ?>
				<ul>
				    <? foreach($original['RadioStaffMember'] as $staffmember): ?>
				    <li style="list-style: none;"><?=$this->Display->fullName($staffmember);?> - Reporter Since <?=$this->Format->date($staffmember['created']);?></li>
				    <? endforeach; ?>				   
				</ul>
				<? endif; ?>
		  </div>
	   </td>
	   <td>
		  <div>
			 <h3><?=$compare['RadioStation']['name'];?><br />
					<span class="smaller"><?=Inflector::humanize($compare['RadioStation']['type']);?></span></h3>
			 <?=$this->Link->google($compare['RadioStation']['name']);?><br />
			 Created: <?=$this->Format->date($compare['RadioStation']['created']); ?>
		  </div>
		  <div>
			 <h5>Reporters:</h5>
					<? if(!empty($original['RadioStaffMember'])): ?>
				<ul>
				    <? foreach($original['RadioStaffMember'] as $staffmember): ?>
				    <li style="list-style: none;"><?=$this->Display->fullName($staffmember);?> - Reporter Since <?=$this->Format->date($staffmember['created']);?></li>
				    <? endforeach; ?>				   
				</ul>
				<? endif; ?>
		  </div>
	   </td>
    </tr>
</table>
</div>
<?=$this->Html->link("Compare to Another", array('controller' => 'RadioStations', 'action' => 'admin_find_comparisons', $original['RadioStation']['id']));?><br /><br />

<?=$this->Html->link("Merge Existing Into New", array('controller' => 'RadioStations', 'action' => 'admin_merge', $original['RadioStation']['id'],$compare['RadioStation']['id']),array(),
	"Are you sure you want to perforn merge?");?><br /><br />

<?=$this->Html->link("Merge New Into Existing", array('controller' => 'RadioStations', 'action' => 'admin_merge', $compare['RadioStation']['id'],$original['RadioStation']['id']),array(),
	"Are you sure you want to perforn merge?");?><br /><br />

<?=$this->Html->link('Skip this Step',array('controller' => 'RadioStations', 'action' => 'admin_verify', $original['RadioStation']['id']));