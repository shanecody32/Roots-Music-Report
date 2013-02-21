<? // pr($staff); ?>
<section id="profile">
	<h1 id="radioname"><span class="smaller">Roots Radio Airplay Reporter</span><br /> <?=$this->Display->fullName($staff['RadioStaffMember']);?></h1>
	<div id="images">
		<? if(!empty($staff['RadioStaffImage']) && file_exists(WWW_ROOT.'img'.DS.$staff['RadioStaffImage'][0]['path'].$staff['RadioStaffImage'][0]['filename'])){ ?>
		<?=$this->Image->resize($staff['RadioStaffImage'][0]['path'].$staff['RadioStaffImage'][0]['filename'], 150, 150, true, array('alt'=>'Profile Image for '.$this->Display->fullName($staff['RadioStaffMember']))); ?><br />
		<?=$this->Html->link('change main image', array('controller'=>'radio_staff_images','action'=>'admin_add/'.$staff['RadioStaffMember']['id'])); ?>
		<? } else { ?>
		<?=$this->Html->image('no_image.jpg', array('alt'=>'No Profile Image for '.$this->Display->fullName($staff['RadioStaffMember']))); ?>
		<?=$this->Html->link('add main image', array('controller'=>'radio_staff_images','action'=>'admin_add/'.$staff['RadioStaffMember']['id'])); ?>
		<? } ?>
	</div>
	<div class="clearfloats">&nbsp;</div>
	<? if(1 == 1){ //$user=='gold' ?>
	<section id="staffinfo">
		<h2>Staff Information</h2>
		<?=$this->Display->show($staff['RadioStaffMember']['on_air_name'], '<strong>On Air Name:</strong> ', true);?>
		<?=$this->Display->show($staff['RadioStaffMember']['position'], '<br /><strong>Position:</strong> ', true);?>
		<?=$this->Display->show($staff['RadioStaffMember']['show_name'], '<br /><strong>Show Name:</strong> ', true);?>
		<?=$this->Display->show($staff['RadioStaffMember']['days_on'], '<br /><strong>Days On Air:</strong> ', true);?>
		<? if($staff['RadioStaffMember']['start_time'] != '00:00:00') echo '<br /><strong>Show Start:</strong> '.$staff['RadioStaffMember']['start_time'];?>
		<? if($staff['RadioStaffMember']['end_time'] != '00:00:00') echo '<br /><strong>Show End:</strong> '.$staff['RadioStaffMember']['end_time'];?>
		<? if($staff['RadioStaffMember']['show_description']): ?>
		<article id="show_desc">
			<h1>Show Description:</h1>
			<?=$staff['RadioStaffMember']['show_description'];?>
		</article>
		<? endif; ?>
		<? if($staff['RadioStaffMember']['bio']): ?>
		<article id="show_desc">
			<h1>Staff Member Biography:</h1>
			<?=$staff['RadioStaffMember']['bio'];?>
		</article>
		<? endif; ?>
		<?=$this->Html->link(__('Playlist'), array('controller'=>'radio_staff_playlists','action' => 'view', $staff['RadioStaffMember']['id']));?>
		<strong>Last Reported:</strong> <?=$this->Format->date($staff['RadioStaffMember']['last_reported'], 'standard'); ?><br />
		<article id="staffphone">
			<h3>Phone Numbers:</h3><br />
			<?=$this->Html->link('add new',array('controller'=>'radio_staff_phone_numbers', 'action'=>'admin_add/'.$staff['RadioStaffMember']['id'])); ?>
			<table>
			<? foreach($staff['RadioStaffPhoneNumber'] as $phone): ?>
				<tr>
					<td><?=Inflector::humanize($phone['type']);?> - <?=$this->Format->phone($phone['phone'], $staff['RadioStaffAddress'][0]['Country']); ?></td>
					<td><?=$this->Html->link('edit',array('controller'=>'radio_staff_phone_numbers', 'action'=>'admin_edit/'.$phone['id'])); ?></td>
					<td><?=$this->Html->link(__('delete'), array('controller'=>'radio_staff_phone_numbers','action' => 'admin_delete', $phone['id']), null, sprintf(__('Are you sure you want to delete the phone number: '.$this->Format->phone($phone['phone'], $staff['RadioStaffAddress'][0]['Country']).'?'), $phone['id'])); ?></td>
				</tr>
			<? endforeach; ?>
			</table>
		</article>
		<article id ="staffaddress">
			<h3>Addresses:</h3>
			<?=$this->Html->link('add new',array('controller'=>'radio_staff_addresses', 'action'=>'admin_add/'.$staff['RadioStaffMember']['id'])); ?>
			<? foreach($staff['RadioStaffAddress'] as $address): ?>
			<address>
				<?=$this->Format->address($address);?>
			</address>
			<?=$this->Html->link('edit',array('controller'=>'radio_staff_addresses', 'action'=>'admin_edit/'.$address['id'])); ?>&nbsp;
			<?=$this->Html->link(__('delete'), array('controller'=>'radio_staff_addresses','action' => 'admin_delete', $address['id']), null, sprintf(__('Are you sure you want to delete this address?', $address['id']))); ?>
			<? endforeach; ?>
		</article>
		<article id="stafflinks">
			<h3>Links:</h3>
			<?=$this->Html->link('add new',array('controller'=>'radio_staff_links', 'action'=>'admin_add/'.$staff['RadioStaffMember']['id'])); ?>
			<table>
		<? foreach($staff['RadioStaffLink'] as $link): ?>
				<tr>
					<td><?=Inflector::humanize($link['type']);?> - <?=$this->Link->$link['type']($link['link'], 'clean_link', '', '_blank'); ?></td>
					<td><?=$this->Html->link('edit',array('controller'=>'radio_staff_links', 'action'=>'admin_edit/'.$link['id'])); ?></td>
					<td><?=$this->Html->link(__('delete'), array('controller'=>'radio_staff_links','action' => 'admin_delete', $link['id']), null, sprintf(__('Are you sure you want to delete the link to '.$link['link'].'?'), $link['id'])); ?></td>
				</tr>
		<? endforeach; ?>
			</table>
		</article>
	</section>
		
	</section>
	
	<? } ?>
	






</section>
<div class="clearfloats">&nbsp;</div>
<?  //pr($staff); ?>