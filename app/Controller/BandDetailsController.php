<?php

class BandDetailsController extends AppController {

	var $name = 'BandDetails';

	function admin_add($band_id = 0) {
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));

		if (!empty($this->request->data)) {
			
			
			if ($this->BandDetail->save($this->request->data)) { //$this->BandDetail->save($this->request->data)
				$this->Session->setFlash(__('The band link has been saved.'));
				$this->redirect(array('controller'=>'bands', 'action'=>'admin_view/'.$this->request->data['BandDetail']['band_id']));
			} else {
				$this->Session->setFlash(__('The band link could not be saved. Please, try again.'));
			} 
		}
		if(empty($band_id)){
				$this->Session->setFlash(__('No band selected.'));
				$this->redirect(Controller::referer());
		}

		$this->set('band_id',$band_id);
	}

	function admin_edit($id = 0) {
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid band'));
			$this->redirect(Controller::referer());
		}
		if (!empty($this->request->data)) {
		
			if ($this->BandDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The link has been saved'));
				$this->redirect(array('controller'=>'bands', 'action'=>'admin_view/'.$this->request->data['BandDetail']['band_id']));
			} else {
				$this->Session->setFlash(__('The link could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->BandDetail->read(null, $id);
		}
	}

	function admin_delete($id = 0) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for link'));
			$this->redirect(Controller::referer());
		}
		if ($this->BandDetail->delete($id)) {
			$this->Session->setFlash(__('link deleted'));
			$this->redirect(Controller::referer());
		}
		$this->Session->setFlash(__('Link was not deleted'));
		$this->redirect(Controller::referer());
	}

}
?>
