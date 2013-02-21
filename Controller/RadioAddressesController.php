<?php

class RadioAddressesController extends AppController {

    var $name = 'RadioAddresses';

    function admin_add($radio_id = 0) {
	   $this->set('styles',array('forms'));
	   $this->set('scripts',array('jquery.forms'));
	   if (!empty($this->request->data)) {
		  $radio_id = $this->request->data['RadioAddress']['radio_station_id'];
		  $this->RadioAddress->create();
		  if (!empty($this->request->data['RadioAddress']['state'])) {
			 $this->loadModel('State');
			 $state = $this->State->findByName($this->request->data['RadioAddress']['state']);
			 if (!$state) {
				$state = $this->State->findByAbbrv($this->request->data['RadioAddress']['state']);
				if (!$state) {
				   $state['State']['country_id'] = $this->request->data['RadioAddress']['country_id'];
				   $state['State']['name'] = $this->request->data['RadioAddress']['state'];
				   $state['State']['abbrv'] = '';
				   $state['State']['new'] = 1;
				   $this->State->save($state);
				   $state['State']['id'] = $this->State->getLastInsertID();
				}
			 }
			 if ($state) {
				$this->request->data['RadioAddress']['state_id'] = $state['State']['id'];
			 }
		  }
			if ($this->request->data['RadioAddress']['zip']) {
			 $this->loadModel('PostalCode');
			 $zip = $this->PostalCode->findByCode($this->request->data['RadioAddress']['zip']);
			 if ($zip) {
				$this->request->data['RadioAddress']['postal_code_id'] = $zip['PostalCode']['id'];
			 } else {
				$pdata['PostalCode']['code'] = $this->request->data['RadioAddress']['zip'];
				if(!empty($this->request->data['RadioAddress']['state_id'])){
				    $pdata['PostalCode']['state_id'] = $this->request->data['RadioAddress']['state_id'];
				}
				$pdata['PostalCode']['country_id'] = $this->request->data['RadioAddress']['country_id'];
				$zip = $this->PostalCode->save($pdata);
				$this->request->data['RadioAddress']['postal_code_id'] = $this->PostalCode->id;
			 }
		  }
		  if ($this->request->data['RadioAddress']['city']) {
			 $this->loadModel('City');
			 $city = $this->City->findByName($this->request->data['RadioAddress']['city']);
			 if ($city) {
				$this->request->data['RadioAddress']['city_id'] = $city['City']['id'];
			 } else {
				$cdata['City']['name'] = $this->request->data['RadioAddress']['city'];
				if(!empty($this->request->data['RadioAddress']['state_id'])){
				    $cdata['City']['state_id'] = $this->request->data['RadioAddress']['state_id'];
				}
					$cdata['City']['postal_code_id'] = $this->request->data['RadioAddress']['postal_code_id'];
				$cdata['City']['country_id'] = $this->request->data['RadioAddress']['country_id'];
				$city = $this->City->save($cdata);
				$this->request->data['RadioAddress']['city_id'] = $this->City->id;
			 }
		  }
		  
		  if ($this->RadioAddress->save($this->request->data)) {
			 $this->Session->setFlash(__('The radio station address has been saved'));
			 $this->redirect(array('controller'=>'radio_stations', 'action'=>'admin_view/'.$this->request->data['RadioAddress']['radio_station_id']));
		  } else {
			 $this->Session->setFlash(__('The radio station address could not be saved. Please, try again.'));
		  }
	   }
	   if(empty($radio_id)){
			 $this->Session->setFlash(__('No radio station selected.'));
			 $this->redirect(Controller::referer());
	   }
	   $this->loadModel('Country');
	   $country = $this->Country->findById('225');
	   $this->set(compact('country'));
	   $countries = $this->Country->find('list');
	   $this->set(compact('countries'));
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
		  $radio_id = $this->request->data['RadioAddress']['radio_station_id'];
			$this->request->data['RadioAddress']['id'] = $id;
		  if (!empty($this->request->data['RadioAddress']['state'])) {
			 $this->loadModel('State');
			 $state = $this->State->findByName($this->request->data['RadioAddress']['state']);
			 if (!$state) {
				$state = $this->State->findByAbbrv($this->request->data['RadioAddress']['state']);
				if (!$state) {
				   $state['State']['country_id'] = $this->request->data['RadioAddress']['country_id'];
				   $state['State']['name'] = $this->request->data['RadioAddress']['state'];
				   $state['State']['abbrv'] = '';
				   $state['State']['new'] = 1;
				   $this->State->save($state);
				   $state['State']['id'] = $this->State->getLastInsertID();
				}
			 }
			 if ($state) {
				$this->request->data['RadioAddress']['state_id'] = $state['State']['id'];
			 }
		  }
			if ($this->request->data['RadioAddress']['zip']) {
			 $this->loadModel('PostalCode');
			 $zip = $this->PostalCode->findByCode($this->request->data['RadioAddress']['zip']);
			 if ($zip) {
				$this->request->data['RadioAddress']['postal_code_id'] = $zip['PostalCode']['id'];
			 } else {
				$pdata['PostalCode']['code'] = $this->request->data['RadioAddress']['zip'];
				$this->request->data['RadioAddress']['postal_code_id'] = $zip['PostalCode']['id'];
				$cdata['City']['postal_code_id'] = $this->request->data['RadioAddress']['postal_code_id'];
				if(!empty($this->request->data['RadioAddress']['state_id'])){
				    $pdata['PostalCode']['state_id'] = $this->request->data['RadioAddress']['state_id'];
				}
				$pdata['PostalCode']['country_id'] = $this->request->data['RadioAddress']['country_id'];
				$zip = $this->PostalCode->save($pdata);
				$this->request->data['RadioAddress']['postal_code_id'] = $this->PostalCode->id;
			 }
		  }
		  if ($this->request->data['RadioAddress']['city']) {
			 $this->loadModel('City');
			 $city = $this->City->findByName($this->request->data['RadioAddress']['city']);
			 if ($city) {
				$this->request->data['RadioAddress']['city_id'] = $city['City']['id'];
			 } else {
				$cdata['City']['name'] = $this->request->data['RadioAddress']['city'];
				if(!empty($this->request->data['RadioAddress']['state_id'])){
				    $cdata['City']['state_id'] = $this->request->data['RadioAddress']['state_id'];
				}
				$cdata['City']['country_id'] = $this->request->data['RadioAddress']['country_id'];
				$city = $this->City->save($cdata);
				$this->request->data['RadioAddress']['city_id'] = $this->City->id;
			 }
		  }
		  
		  if ($this->RadioAddress->save($this->request->data)) {
			 $this->Session->setFlash(__('The address has been saved'));
			 $this->redirect(array('controller'=>'radio_stations', 'action'=>'admin_view/'.$this->request->data['RadioAddress']['radio_station_id']));
		  } else {
			 $this->Session->setFlash(__('The address was not saved. Please, try again.'));
		  }
	   }
	   if (empty($this->request->data)) {
		  $this->request->data = $this->RadioAddress->findById($id);
		  $this->request->data['RadioAddress']['zip'] = $this->request->data['PostalCode']['code'];
		  $this->request->data['RadioAddress']['state'] = $this->request->data['State']['name'];
		  $this->request->data['RadioAddress']['city'] = $this->request->data['City']['name'];
		  $this->set('selected',$this->request->data['RadioAddress']['country_id']);
	   }
	   $this->loadModel('Country');
	   $country = $this->Country->findById('225');
	   $this->set(compact('country'));
	   $countries = $this->Country->find('list');
	   $this->set(compact('countries'));
    }

    function admin_delete($id = 0) {
	   if (!$id) {
		  $this->Session->setFlash(__('Invalid id for the address'));
		  $this->redirect(Controller::referer());
	   }
	   $this->RadioAddress->id = $id;
	   $data = $this->RadioAddress->read();
	   $count = $this->RadioAddress->find('count', array(
		  'conditions' => array(
			 'radio_station_id'=> $data['RadioAddress']['radio_station_id']
		  )
	   ));
	   if($count > 1){
		  if ($this->RadioAddress->delete($id)) {
			 $this->Session->setFlash(__('Address deleted'));
			 $this->redirect(Controller::referer());
		  }
		  $this->Session->setFlash(__('Address was not deleted'));
		  $this->redirect(Controller::referer());
	   }
	   $this->Session->setFlash(__('Cannot delete address, must have at least one address availible for the station.'));
	   $this->redirect(Controller::referer());
    }

}
?>