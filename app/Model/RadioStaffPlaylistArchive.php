<?php
class RadioStaffPlaylistArchive extends AppModel {
	var $name = 'RadioStaffPlaylistArchive';
	var $displayField = 'spins';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'RadioStaffMember' => array(
			'className' => 'RadioStaffMember',
			'foreignKey' => 'radio_staff_member_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Song' => array(
			'className' => 'Song',
			'foreignKey' => 'song_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Album' => array(
			'className' => 'Album',
			'foreignKey' => 'album_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Band' => array(
			'className' => 'Band',
			'foreignKey' => 'band_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function get_last_playlist($staff_id){
		$latest_date = $this->find('first', array(
			'conditions' => array(
				'radio_staff_member_id' => $staff_id
			),
			'order' => 'week_ending ASC',
			'fields' => 'week_ending'
		));
		return $latest_date['RadioStaffPlaylistArchive']['week_ending'];
	}
	
}
?>