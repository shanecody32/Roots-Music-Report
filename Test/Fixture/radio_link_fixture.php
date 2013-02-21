<?php
/* RadioLink Fixture generated on: 2011-03-18 12:03:51 : 1300472271 */
class RadioLinkFixture extends CakeTestFixture {
	var $name = 'RadioLink';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'radio_station_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'link' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'radio_station_id' => 1,
			'link' => 'Lorem ipsum dolor sit amet',
			'type' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>