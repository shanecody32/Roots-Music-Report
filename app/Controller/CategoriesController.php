<?php

class CategoriesController extends AppController {

	var $name = 'Categories';

	function add() {
		$this->set('styles',array('forms', 'jquery.tagit'));
		$this->set('scripts',array('jquery.forms', 'tag-it.min'));

		if (!empty($this->request->data)) {
			if ($this->Category->add($this->request->data['Category'], 'name')) {
				$this->Session->setFlash(__('The category has been saved'));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
			}
		}
	}
	
	function view_all(){
		$this->set('styles',array('tables'));
		
		$this->set('genres', $this->Genre->find('all', array('order'=>array('Genre.name'=>'ASC'))));
	}
	

	function edit($id = 0) {
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid genre'));
			$this->redirect($this->referer());
		}
		if (!empty($this->request->data)) {			
			if ($this->Genre->save($this->request->data)) {
				$this->Session->setFlash(__('The Genre has been saved'));
				$this->redirect($this->origReferer());
			} else {
				$this->Session->setFlash(__('The Genre could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Genre->read(null, $id);
			$this->setReferer();
		}

	}

	function delete($id = 0) {
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
