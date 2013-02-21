<? // dw ?>

<?=$this->Form->create('RadioStation');?>

<p>
<? $who_options=array('dj'=>'DJ','station_manager'=>'Station Manager','program_director'=>'Program Director','music_director'=>'Music Director', 'other'=>'Other');
    echo $this->Form->radio('RadioStaffMember.position',$who_options, array('legend' => 'You Position at the Station', 'default' => 'dj'));
?>
</p>

<p>
<? $options=array('terrestrial'=>'Terrestrial Station','internet'=>'Internet Station','syndicated'=>'Syndicated Radio Program','satellite'=>'Satellite Radio Station');
    echo $this->Form->radio('RadioStation.type',$options, array('legend' => 'Station Type', 'default' => 'terrestrial'));
?>
</p>
<p> Please fill out all of the information below.
    <?=$this->Form->input('RadioStation.name', array('label'=>'Station or Show Name')); ?>
    <?=$this->Form->input('RadioLink.0.link', array('label'=>'Website')); ?>
    <?=$this->Form->input('RadioEmail.0.email', array('label'=>'Primary Station-wide Email')); ?>
    <div class="terrestrial toggle">
	   <p class="form_subtitle">Specific Information for Terrestrial Radio Stations Only:</p><hr />
	   <?=$this->Form->checkbox('RadioTerrestrialDetail.public'); ?><label for="RadioTerrestrialDetailPublic">Public Station?</label>
	   <?=$this->Form->checkbox('RadioTerrestrialDetail.college'); ?><label for="RadioTerrestrialDetailCollege">College Station?</label>
	   <?=$this->Form->input('RadioTerrestrialDetail.call_letters', array('label'=>'Call Sign')); ?>
	   Provide each of the following that apply:
	   <?=$this->Form->input('RadioTerrestrialDetail.fm_frequency', array('label'=>'FM Frequency')); ?>
	   <?=$this->Form->input('RadioTerrestrialDetail.hd_frequency', array('label'=>'HD Frequency')); ?>
	   <?=$this->Form->input('RadioTerrestrialDetail.am_frequency', array('label'=>'AM Frequency')); ?>
	   <?=$this->Form->input('RadioTerrestrialDetail.power', array('label'=>'Power in Watts')); ?>
    </div>
    <div class="internet toggle">
	   <p class="form_subtitle">Specific Information for Internet Radio Stations Only:</p><hr />
	   <?=$this->Form->input('RadioInternetDetail.hits', array('label'=>'Average Monthly Hits to Web Site Recieved')); ?>
	   <?=$this->Form->input('RadioInternetDetail.visitors', array('label'=>'Average Monthly Unique Visitors to Web Site Recieved')); ?>
    </div>
    <div class="syndicated toggle">
	   <p class="form_subtitle">Specific Information for Syndicated Radio Shows Only:</p><hr />
	   <?=$this->Form->input('RadioSyndicatedDetail.stations_playing', array('label'=>'Number of Stations Syndicated On (0 if unknown)')); ?>
    </div>
    <div class="satellite toggle">
	   <p class="form_subtitle">Specific Information for Satellite Radio Only:</p><hr />
	   <?=$this->Form->input('RadioSatelliteDetail.channel_name', array('label'=>'Channel Name')); ?>
	   <?=$this->Form->input('RadioSatelliteDetail.channel_number', array('label'=>'Channel Number')); ?>
	   <?=$this->Form->input('RadioSatelliteDetail.service_provider', array('label'=>'Service Provider (XM, Sirius, etc)')); ?>
    </div>
		<p class="form_subtitle">Contact Information for the Station or Show:</p><hr />
	   <?=$this->Form->input('RadioPhoneNumber.0.phone', array('label'=>'Station Primary Phone Number')); ?>
	   <? array_pop($countries); ?>
	   <?=$this->Form->input('RadioAddress.0.country_id', array('options' => $countries, 'empty' => '(choose one)', 'selected'=>'225')); ?>
	   <?=$this->Format->address_form($country['Country']['address_format'],'RadioAddress.0'); ?>
</p>

<?=$this->Form->end('Submit Application'); ?>