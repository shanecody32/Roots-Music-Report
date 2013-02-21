<? // DW ?>
<section id="profile">
	<h1 id="radioname"><span class="smaller">Roots Radio Airplay Reporter</span><br /> <?=$radio['RadioStation']['name'];?></h1>
	<div id="images">
		<? if(!empty($radio['RadioStationImage']) && file_exists(WWW_ROOT.'img'.DS.$radio['RadioStationImage'][0]['path'].$radio['RadioStationImage'][0]['filename'])){ ?>
		<?=$this->Image->resize($radio['RadioStationImage'][0]['path'].$radio['RadioStationImage'][0]['filename'], 150, 150, true, array('alt'=>'Logo for '.$radio['RadioStation']['name'])); ?><br />
		<?=$this->Html->link('change logo', array('controller'=>'radio_station_images','action'=>'admin_add/'.$radio['RadioStation']['id'])); ?>
		<? } else { ?>
		<?=$this->Html->image('no_radio_logo.jpg', array('alt'=>'No Logo for '.$radio['RadioStation']['name'])); ?>
		<?=$this->Html->link('add logo', array('controller'=>'radio_station_images','action'=>'admin_add/'.$radio['RadioStation']['id'])); ?>
		<? } ?>
	</div>
	<article id="radioinfo">

		<? if($radio['RadioStation']['type'] == 'terrestrial'){ ?>
			<h2>Terrestrial Reporting Station Information</h2>
			<?=$this->Html->link('Visit Station Website',$radio['RadioLink'][0]['link']);?><br />
			<span class="bold">Call Sign:</span> <?=$radio['RadioTerrestrialDetail']['call_letters']; ?><br />
			<?if($radio['RadioTerrestrialDetail']['fm_frequency']) { ?><span class="bold">FM Frequency:</span> <?=$radio['RadioTerrestrialDetail']['fm_frequency']; ?><br /><? } ?>
			<?if($radio['RadioTerrestrialDetail']['am_frequency']) { ?><span class="bold">AM Frequency:</span> <?=$radio['RadioTerrestrialDetail']['am_frequency']; ?><br /><? } ?>
			<?if($radio['RadioTerrestrialDetail']['hd_frequency']) { ?><span class="bold">HD Frequency:</span> <?=$radio['RadioTerrestrialDetail']['fm_frequency']; ?><br /><? } ?>
			<?if($radio['RadioTerrestrialDetail']['power']) { ?><span class="bold">Power:</span> <?=$radio['RadioTerrestrialDetail']['power']; ?> watts<br /><? } ?>
			<?if($radio['RadioTerrestrialDetail']['college']) { ?><span class="bold">College Station</span><br /><? } ?>
			<?if($radio['RadioTerrestrialDetail']['public']) { ?><span class="bold">Public Station</span><br /><? } ?>
		<? } if($radio['RadioStation']['type'] == 'syndicated'){ ?>
			<h2>Syndicated Radio Program Information</h2>
			<?=$this->Html->link('Visit Station Website',$radio['RadioLink'][0]['link']);?><br />
			<?if($radio['RadioSyndicatedDetail']['stations_playing']) { ?><span class="bold">Stations Playing:</span> <?=$radio['RadioSyndicatedDetail']['stations_playing']; ?><br /><? } ?>
		<? } if($radio['RadioStation']['type'] == 'internet'){ ?>
			<h2>Internet Reporting Station Information</h2>
			<?=$this->Html->link('Visit Station Website',$radio['RadioLink'][0]['link']);?><br />
			<?if($radio['RadioInternetDetail']['visitors']) { ?><span class="bold">Unique Visitors:</span> <?=$radio['RadioInternetDetail']['visitors']; ?><br /><? } ?>
			<?if($radio['RadioInternetDetail']['hits']) { ?><span class="bold">Unique Visitors:</span> <?=$radio['RadioInternetDetail']['hits']; ?><br /><? } ?>
		<? } if($radio['RadioStation']['type'] == 'satellite'){ ?>
			<h2>Satellite Reporting Channel Information</h2>
			<?=$this->Html->link('Visit Station Website',$radio['RadioLink'][0]['link']);?><br />
			<?if($radio['RadioSatelliteDetail']['channel_name']) { ?><span class="bold">Unique Visitors:</span> <?=$radio['RadioSatelliteDetail']['channel_name']; ?><br /><? } ?>
			<?if($radio['RadioSatelliteDetail']['channel_number']) { ?><span class="bold">Unique Visitors:</span> <?=$radio['RadioSatelliteDetail']['channel_number']; ?><br /><? } ?>
			<?if($radio['RadioSatelliteDetail']['service_provider']) { ?><span class="bold">Unique Visitors:</span> <?=$radio['RadioSatelliteDetail']['service_provider']; ?><br /><? } ?>

		<? } ?>
			<span class="edit"><?=$this->Html->link('edit', array('controller'=>'radio_stations','action'=>'admin_edit/'.$radio['RadioStation']['id']));?></span>

	</article>
	<div class="clearfloats">&nbsp;</div>
	<? if(1 == 1){ //$user=='gold' ?>
	<section id="radiocontact">
		<h2>Station Contact Information</h2>
		<article id="radiophone">
			<h3>Phone Numbers:</h3><br />
			<?=$this->Html->link('add new',array('controller'=>'radio_phone_numbers', 'action'=>'admin_add/'.$radio['RadioStation']['id'])); ?>
			<table>
			<? foreach($radio['RadioPhoneNumber'] as $phone): ?>
				<tr>
					<td><?=Inflector::humanize($phone['type']);?> - <?=$this->Format->phone($phone['phone'], $radio['RadioAddress'][0]['Country']); ?></td>
					<td><?=$this->Html->link('edit',array('controller'=>'radio_phone_numbers', 'action'=>'admin_edit/'.$phone['id'])); ?></td>
					<td><?=$this->Html->link(__('delete'), array('controller'=>'radio_phone_numbers','action' => 'admin_delete', $phone['id']), null, sprintf(__('Are you sure you want to delete the phone number: '.$this->Format->phone($phone['phone'], $radio['RadioAddress'][0]['Country']).'?'), $phone['id'])); ?></td>
				</tr>
			<? endforeach; ?>
			</table>
		</article>
		<article id ="radioaddress">
			<h3>Addresses:</h3>
			<?=$this->Html->link('add new',array('controller'=>'radio_addresses', 'action'=>'admin_add/'.$radio['RadioStation']['id'])); ?>
			<? foreach($radio['RadioAddress'] as $address): ?>
			<address>
				<?=$this->Format->address($address);?>
			</address>
			<?=$this->Html->link('edit',array('controller'=>'radio_addresses', 'action'=>'admin_edit/'.$address['id'])); ?>&nbsp;
			<?=$this->Html->link(__('delete'), array('controller'=>'radio_addresses','action' => 'admin_delete', $address['id']), null, sprintf(__('Are you sure you want to delete this address?', $address['id']))); ?>
			<? endforeach; ?>
		</article>
		<article id="radiolinks">
			<h3>Links:</h3>
			<?=$this->Html->link('add new',array('controller'=>'radio_links', 'action'=>'admin_add/'.$radio['RadioStation']['id'])); ?>
			<table>
		<? foreach($radio['RadioLink'] as $link): ?>
				<tr>
					<td><?=Inflector::humanize($link['type']);?> - <?=$this->Link->$link['type']($link['link'], 'clean_link', '', '_blank'); ?></td>
					<td><?=$this->Html->link('edit',array('controller'=>'radio_links', 'action'=>'admin_edit/'.$link['id'])); ?></td>
					<td><?=$this->Html->link(__('delete'), array('controller'=>'radio_links','action' => 'admin_delete', $link['id']), null, sprintf(__('Are you sure you want to delete the link to '.$link['link'].'?'), $link['id'])); ?></td>
				</tr>
		<? endforeach; ?>
			</table>
		</article>
	</section>
	<aside id="radiostaff">
		<h2>Radio Staff Members</h2>
		<?=$this->Html->link('add new',array('controller'=>'radio_staff_members', 'action'=>'admin_add/'.$radio['RadioStation']['id'])); ?>
		<table>
		<? foreach($radio['RadioStaffMember'] as $member): ?>
				<tr>
					<td><?=$member['first_name'];?> <?=$member['last_name'];?></td>
					<td><?=$this->Format->date($member['created'], 'standard');?></td>
					<td><?=$this->Html->link(__('delete'), array('controller'=>'radio_staff_members','action' => 'admin_delete', $link['id']), null, sprintf(__('Are you sure you want to delete the link to '.$link['link'].'?'), $link['id'])); ?></td>
				</tr>
		<? endforeach; ?>
			</table>
	</aside>
	
	<? } ?>
	






</section>
<div class="clearfloats">&nbsp;</div>
<?  //pr($radio); ?>