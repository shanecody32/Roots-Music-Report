<?php
/* RadioLink Test cases generated on: 2011-03-18 12:03:51 : 1300472271*/
App::import('Model', 'RadioLink');

class RadioLinkTest extends CakeTestCase {
	var $fixtures = array('app.radio_link', 'app.radio_station');

	function startTest() {
		$this->RadioLink =& ClassRegistry::init('RadioLink');
	}

	function endTest() {
		unset($this->RadioLink);
		ClassRegistry::flush();
	}

}
?>