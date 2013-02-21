<?php
class RadioStaffMemberSubGenre extends AppModel {
	var $name = 'RadioStaffMemberSubGenre';

	
	var $belongsTo = array(
		'RadioStaffMember' => array(
			'className' => 'RadioStaffMember',
			'foriegnKey' => 'radio_staff_member_id',
		),
		'SubGenre' => array(
			'className' => 'SubGenre',
			'foriegnKey' => 'sub_genre_id',
		),
	);
	
}


?>