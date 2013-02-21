<?php

class RadioPhoneNumbersController extends AppController {

    var $name = 'RadioPhoneNumbers';

    function admin_add($radio_id = 0) {
	   $this->set('styles',array('forms'));
	   $this->set('scripts',array('jquery.forms'));
	   
	   if (!empty($this->request->data)) {
		  $this->RadioPhoneNumber->create();
		  if ($this->RadioPhoneNumber->save($this->request->data)) {
			 $this->Session->setFlash(__('The radio station phone number has been saved'));
			 $this->redirect(array('controller'=>'radio_stations', 'action'=>'admin_view/'.$this->request->data['RadioPhoneNumber']['radio_station_id']));
		  } else {
			 $this->Session->setFlash(__('The radio station phone number could not be saved. Please, try again.'));
		  }
	   }
	   if(empty($radio_id)){
			 $this->Session->setFlash(__('No radio station selected.'));
			 $this->redirect(Controller::referer());
	   }
	  
	   $this->set('radio_id',$radio_id);
    }

    function admin_edit($id = 0) {
	   $this->set('styles',array('forms'));
	   $this->set('scripts',array('jquery.forms'));
	   if (!$id && empty($this->request->data)) {
		  $this->Session->setFlash(__('Invalid radio station'));
		  $this->redirect(Controller::referer());
	   }
	   if (!empty($this->request->data)) {
		  if ($this->RadioPhoneNumber->save($this->request->data)) {
			 $this->Session->setFlash(__('The phone number has been saved'));
			 $this->redirect(array('controller'=>'radio_stations', 'action'=>'admin_view/'.$this->request->data['RadioPhoneNumber']['radio_station_id']));
		  } else {
			 $this->Session->setFlash(__('The phone number could not be saved. Please, try again.'));
		  }
	   }
	   if (empty($this->request->data)) {
		  $this->request->data = $this->RadioPhoneNumber->read(null, $id);
	   }
    }

    function admin_delete($id = 0) {
	   if (!$id) {
		  $this->Session->setFlash(__('Invalid id for phone number'));
		  $this->redirect(Controller::referer());
	   }
	   $this->RadioPhoneNumber->id = $id;
	   $data = $this->RadioPhoneNumber->read();
	   $count = $this->RadioPhoneNumber->find('count', array(
		  'conditions' => array(
			 'radio_station_id'=> $data['RadioPhoneNumber']['radio_station_id']
		  )
	   ));
	   if($count > 1){
		  if ($this->RadioPhoneNumber->delete($id)) {
			 $this->Session->setFlash(__('Phone number deleted'));
			 $this->redirect(Controller::referer());
		  }
		  $this->Session->setFlash(__('Phone Number was not deleted'));
		  $this->redirect(Controller::referer());
	   }
	   $this->Session->setFlash(__('Cannot delete phone number, must have at least one phone number availible for the station.'));
	   $this->redirect(Controller::referer());
    }

}
?>
