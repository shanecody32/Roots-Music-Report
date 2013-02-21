<?php

class BandLinksController extends AppController {

	var $name = 'BandLinks';

	function admin_add($band_id = 0) {
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));

		if (!empty($this->request->data)) {
			if (strpos($this->request->data['BandLink']['link'], 'airplaydirect') > 0 || strpos($this->request->data['BandLink']['link'], 'airplay-direct') > 0) {
				$this->Session->setFlash(__('This link cannot be saved. We do not support Airplay Direct links.'));
				$this->redirect(array('controller'=>'bands', 'action'=>'admin_view/'.$this->request->data['BandLink']['band_id']));
			}
			
			$this->Link = $this->Components->load('Link');

			if(!$this->Link->linkType($this->request->data['BandLink']['link'], $this->request->data['BandLink']['type'])){
				$this->Session->setFlash(__('The band link could not be saved. The link below is not a proper '.Inflector::humanize($this->request->data['BandLink']['type']).' link.'));
				$this->redirect(array('controller'=>'bands', 'action'=>'admin_view/'.$this->request->data['BandLink']['band_id']));
			} else { 
				$this->request->data['BandLink']['link'] = $this->Link->clean_link($this->request->data['BandLink']['link'], $this->request->data['BandLink']['type']);
			}
			
			if ($this->BandLink->save($this->request->data)) { //$this->BandLink->save($this->request->data)
				$this->Session->setFlash(__('The band link has been saved.'));
				$this->redirect(array('controller'=>'bands', 'action'=>'admin_view/'.$this->request->data['BandLink']['band_id']));
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
			if (strpos($this->request->data['BandLink']['link'], 'airplaydirect') > 0 || strpos($this->request->data['BandLink']['link'], 'airplay-direct') > 0) {
				$this->Session->setFlash(__('This link cannot be saved. We do not support Airplay Direct links.'));
				$this->redirect(array('controller'=>'bands', 'action'=>'admin_view/'.$this->request->data['BandLink']['band_id']));
			}
			$this->Link = $this->Components->load('Link');
			
			$this->request->data['BandLink']['id'] = $id;
			
			$this->request->data['BandLink']['link'] = $this->Link->clean_link($this->request->data['BandLink']['link'], $this->request->data['BandLink']['type']);
			
			if ($this->BandLink->save($this->request->data)) {
				$this->Session->setFlash(__('The link has been saved'));
				$this->redirect(array('controller'=>'bands', 'action'=>'admin_view/'.$this->request->data['BandLink']['band_id']));
			} else {
				$this->Session->setFlash(__('The link could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->BandLink->read(null, $id);
		}
	}

	function admin_delete($id = 0) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for link'));
			$this->redirect(Controller::referer());
		}
		if ($this->BandLink->delete($id)) {
			$this->Session->setFlash(__('link deleted'));
			$this->redirect(Controller::referer());
		}
		$this->Session->setFlash(__('Link was not deleted'));
		$this->redirect(Controller::referer());
	}

}
?>
