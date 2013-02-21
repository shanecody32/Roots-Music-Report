<? // pr($staff); ?>
<section id="profile">
	<h1 id="radioname"><span class="smaller">Roots Radio Airplay Reporter</span><br /> <?=$this->Display->fullName($staff['RadioStaffMember']);?></h1>
	<div id="images">
		<? if(!empty($staff['RadioStaffImage']) && file_exists(WWW_ROOT.'img'.DS.$staff['RadioStaffImage'][0]['path'].$staff['RadioStaffImage'][0]['filename'])){ ?>
		<?=$this->Image->resize($staff['RadioStaffImage'][0]['path'].$staff['RadioStaffImage'][0]['filename'], 150, 150, true, array('alt'=>'Profile Image for '.$this->Display->fullName($staff['RadioStaffMember']))); ?><br />
		<? } else { ?>
		<?=$this->Html->image('no_image.jpg', array('alt'=>'No Profile Image for '.$this->Display->fullName($staff['RadioStaffMember']))); ?>
		<? } ?>
	</div>
	<div class="clearfloats">&nbsp;</div>
	<? if(1 == 1){ //$user=='gold' ?>
	<section id="staffinfo">
		<h2>Information</h2>
		<?=$this->Display->show($staff['RadioStaffMember']['on_air_name'], '<strong>On Air Name:</strong> ');?>
		<?=$this->Display->show($staff['RadioStaffMember']['position'], '<br /><strong>Position:</strong> ');?>
		<?=$this->Display->show($staff['RadioStaffMember']['show_name'], '<br /><strong>Show Name:</strong> ');?>
		<?=$this->Display->show($staff['RadioStaffMember']['days_on'], '<br /><strong>Days On Air:</strong> ');?>
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
		<? if($staff['RadioStaffMember']['last_reported'] != "0000-00-00"){ ?>
            <strong>Last Reported:</strong> <?=$this->Format->date($staff['RadioStaffMember']['last_reported'], 'standard'); ?> - 
            <?=$this->Html->link(__('Playlist'), array('controller'=>'radio_staff_playlist_archives','action' => 'view', $staff['RadioStaffMember']['id'])); ?>	
            <br />
        <? } else { ?><strong>This air-play reporter has not yet submitted a play-list.</strong> <? } ?> 
		<? if(!empty($staff['RadioStaffPhoneNumber'])): ?>
        <article id="staffphone">
			<h3>Phone Numbers:</h3>
			<table>
			<? foreach($staff['RadioStaffPhoneNumber'] as $phone): ?>
				<tr>
        	       	<td><?=Inflector::humanize($phone['type']);?></td>
					<td><?=$this->Format->phone($phone['phone'], $staff['RadioStaffAddress'][0]['Country']); ?></td>				
				</tr>
			<? endforeach; ?>
			</table>
		</article>
        <? endif;?>
		<article id ="staffaddress">
			<h3>Addresses:</h3>
			<? foreach($staff['RadioStaffAddress'] as $address): ?>
			<address>
				<?=$this->Format->address($address);?>
			</address>
			<? endforeach; ?>
		</article>
		<article id="stafflinks">
			<h3>Links:</h3>
			<table>
		<? foreach($staff['RadioStaffLink'] as $link): ?>
				<tr>
                	<td><?=Inflector::humanize($link['type']);?></td>
					<td><?=$this->Link->$link['type']($link['link'], 'clean_link', '', '_blank'); ?></td>
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