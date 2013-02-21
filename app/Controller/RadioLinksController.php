<?php

class RadioLinksController extends AppController {

	var $name = 'RadioLinks';

	function admin_add($radio_id = 0) {
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));

		if (!empty($this->request->data)) {
			$this->Link = $this->Components->load('Link');
			$this->request->data['RadioLink']['link'] = $this->Link->clean_link($this->request->data['RadioLink']['link'], $this->request->data['RadioLink']['type']);
			$this->RadioLink->create();
			if ($this->RadioLink->save($this->request->data)) {
				$this->Session->setFlash(__('The radio station link has been saved'));
				$this->redirect(array('controller'=>'radio_stations', 'action'=>'admin_view/'.$this->request->data['RadioLink']['radio_station_id']));
			} else {
				$this->Session->setFlash(__('The radio station link could not be saved. Please, try again.'));
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
			$this->Link = $this->Components->load('Link');
			
			$this->request->data['RadioLink']['id'] = $id;
			
			$this->request->data['RadioLink']['link'] = $this->Link->clean_link($this->request->data['RadioLink']['link'], $this->request->data['RadioLink']['type']);
			
			if ($this->RadioLink->save($this->request->data)) {
				$this->Session->setFlash(__('The link has been saved'));
				$this->redirect(array('controller'=>'radio_stations', 'action'=>'admin_view/'.$this->request->data['RadioLink']['radio_station_id']));
			} else {
				$this->Session->setFlash(__('The link could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->RadioLink->read(null, $id);
		}
	}

	function admin_delete($id = 0) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for link'));
			$this->redirect(Controller::referer());
		}
		$this->RadioLink->id = $id;
		$data = $this->RadioLink->read();
		$count = $this->RadioLink->find('count', array(
			'conditions' => array(
				'radio_station_id'=> $data['RadioLink']['radio_station_id']
			)
		));
		if($count > 1){
			if ($this->RadioLink->delete($id)) {
				$this->Session->setFlash(__('link deleted'));
				$this->redirect(Controller::referer());
			}
			$this->Session->setFlash(__('Link was not deleted'));
			$this->redirect(Controller::referer());
		}
		$this->Session->setFlash(__('Cannot delete link, must have at least one link availible for the station.'));
		$this->redirect(Controller::referer());
	}

}
?>
