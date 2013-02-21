<?php

class SubGenresController extends AppController {

	var $name = 'SubGenres';

	function admin_add() {
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));

		if (!empty($this->request->data)) {
			if ($this->SubGenre->add($this->request->data['SubGenre'], 'name')) {
				$this->Session->setFlash(__('The sub genre has been saved'));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The sub genre link could not be saved. Please, try again.'));
			}
		}

		$this->set('genres', $this->SubGenre->Genre->find('list', array('order'=>array('name' => 'ASC'))));
	}
	
	function admin_view_all(){
		$this->set('styles',array('tables'));
		$this->SubGenre->Behaviors->attach('Containable');
		$this->SubGenre->contain('Genre');
		$this->set('sub_genres', $this->SubGenre->find('all', array('order'=>array('Genre.name'=>'ASC','SubGenre.name'=>'ASC'))));
	}
	
	function view_all(){
		$this->SubGenre->recursive = -1;
		$this->set('sub_genres', $this->SubGenre->find('all', array('order'=>array('SubGenre.name'=>'ASC'))));
	}

	function admin_edit($id = 0) {
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid sub genre'));
			$this->redirect($this->referer());
		}
		if (!empty($this->request->data)) {			
			if ($this->SubGenre->save($this->request->data)) {
				$this->Session->setFlash(__('The Sub Genre has been saved'));
				$this->redirect($this->origReferer());
			} else {
				$this->Session->setFlash(__('The Sub Genre could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->SubGenre->read(null, $id);
			$this->setReferer();
		}
		
		$this->set('genres', $this->SubGenre->Genre->find('list', array('order' => array('name'=>'asc'))));
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
