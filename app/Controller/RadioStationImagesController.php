<?php
class RadioStationImagesController extends AppController {

	var $name = 'RadioStationImages';

	function index() {
		$this->RadioStationImage->recursive = 0;
		$this->set('radioStationImages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid radio station image'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('radioStationImage', $this->RadioStationImage->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->RadioStationImage->create();
			if ($this->RadioStationImage->save($this->request->data)) {
				$this->Session->setFlash(__('The radio station image has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The radio station image could not be saved. Please, try again.'));
			}
		}
		$radioStations = $this->RadioStationImage->RadioStation->find('list');
		$this->set(compact('radioStations'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid radio station image'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->RadioStationImage->save($this->request->data)) {
				$this->Session->setFlash(__('The radio station image has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The radio station image could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->RadioStationImage->read(null, $id);
		}
		$radioStations = $this->RadioStationImage->RadioStation->find('list');
		$this->set(compact('radioStations'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for radio station image'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->RadioStationImage->delete($id)) {
			$this->Session->setFlash(__('Radio station image deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Radio station image was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->RadioStationImage->recursive = 0;
		$this->set('radioStationImages', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid radio station image'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('radioStationImage', $this->RadioStationImage->read(null, $id));
	}

	function admin_add($radio_id = null) {
		  // Sets info for form to select a new image

		  $this->set('styles',array('forms'));
		  $this->set('scripts',array('jquery.forms'));
		  if(!$radio_id && empty($this->request->data)){
			 $this->Session->setFlash(__('Invalid radio station'));
			 $this->redirect(Controller::referer());
		  }
		  $this->set('radio_id', $radio_id);
	}

	   function admin_add_step_2(){
		  $this->set('styles',array('forms', 'imgareaselect-animated'));
		  $this->set('scripts',array('jquery.forms','jquery.imgareaselect.min'));
		  if (!empty($this->request->data)) {
			 //check for radio id, none found redirect
			 if(!empty($this->request->data['RadioStationImage']['radio_id'])){
				$radio = $this->RadioStationImage->RadioStation->findById($this->request->data['RadioStationImage']['radio_id']);
				if(!$radio){
				    $this->Session->setFlash(__('Invalid radio station'));
				    $this->redirect(array('controller' => 'RadioStations', 'action' => 'index', 'admin' => 1));
				}
				$this->set('radio', $radio);
			 }

			 // make sure radio image folder exists
			 $name = Inflector::slug(strtolower($radio['RadioStation']['name']));
			 $folder = 'radio_stations/'.$name;
			 if(!is_dir(WWW_ROOT.DS.'img'.DS.$folder)) {
				mkdir(WWW_ROOT.DS.'img'.DS.$folder);
				chmod (WWW_ROOT.DS.'img'.DS.$folder , 0777);
				mkdir(WWW_ROOT.DS.'img'.DS.$folder.'/images');
				chmod (WWW_ROOT.DS.'img'.DS.$folder.'/images' , 0777);
			 }
			 $folder .= '/images/';
			 $filename = $name.'_logo';
			 // set crop info
			 $uploaded = $this->JqImgcrop->uploadImage($this->request->data['RadioStationImage']['image'], $folder, $filename);
			 $this->set('uploaded',$uploaded);
			 $this->set('folder',$folder);
		  } else {
			 $this->Session->setFlash(__('Invalid radio station'));
			 $this->redirect(array('controller' => 'RadioStations', 'action' => 'index', 'admin' => 1));
		  }
	   }

	   function admin_add_step_3(){
		  // perform crops and rezise on image
		  if(!empty($this->request->data['RadioStationImage']['radio_id'])){
			 $radio = $this->RadioStationImage->RadioStation->findById($this->request->data['RadioStationImage']['radio_id']);
			 if(!$radio){
				$this->Session->setFlash(__('Invalid radio station'));
				$this->redirect(array('controller' => 'RadioStations', 'action' => 'index', 'admin' => 1));
			 }
			 $this->set('radio', $radio);
		  }
		  $filename = basename($this->request->data['RadioStationImage']['imagePath']);
		  $file_ext = substr($filename, strrpos($filename, ".") + 1);
		  $this->request->data['RadioStationImage']['thumbPath'] = $this->request->data['RadioStationImage']['path'].str_replace(".".$file_ext,'',$filename).'_thumbnail.'.$file_ext;
		  $this->JqImgcrop->cropImage(100, $this->request->data['RadioStationImage']['x1'], $this->request->data['RadioStationImage']['y1'], $this->request->data['RadioStationImage']['x2'],
			 $this->request->data['RadioStationImage']['y2'], $this->request->data['RadioStationImage']['w'], $this->request->data['RadioStationImage']['h'], $this->request->data['RadioStationImage']['thumbPath'],
			 $this->request->data['RadioStationImage']['imagePath']) ;
		  $exists = $this->RadioStationImage->find('first', array(
			 'conditions' => array(
				'RadioStationImage.radio_station_id' => $this->request->data['RadioStationImage']['radio_id'],
				'RadioStationImage.type' => 'primary'
			 )
		  ));
		  if($exists)
			  $image['RadioStationImage']['id'] = $exists['RadioStationImage']['id'];
		  
		  $image['RadioStationImage']['radio_station_id'] = $radio['RadioStation']['id'];
		  $image['RadioStationImage']['path'] = $this->request->data['RadioStationImage']['path'];
		  $image['RadioStationImage']['filename'] = str_replace($this->request->data['RadioStationImage']['path'],'',$this->request->data['RadioStationImage']['imagePath']);
		  $image['RadioStationImage']['thumbname'] = str_replace($this->request->data['RadioStationImage']['path'],'',$this->request->data['RadioStationImage']['thumbPath']);
		  $image['RadioStationImage']['type'] = "primary";

		  $this->RadioStationImage->save($image);
	   }

	   function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid radio station image'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->RadioStationImage->save($this->request->data)) {
				$this->Session->setFlash(__('The radio station image has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The radio station image could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->RadioStationImage->read(null, $id);
		}
		$radioStations = $this->RadioStationImage->RadioStation->find('list');
		$this->set(compact('radioStations'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for radio station image'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->RadioStationImage->delete($id)) {
			$this->Session->setFlash(__('Radio station image deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Radio station image was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>