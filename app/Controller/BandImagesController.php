<?php
class BandImagesController extends AppController {

	var $name = 'BandImages';

	function index() {
		$this->BandImage->recursive = 0;
		$this->set('band_images', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid band image'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('band_image', $this->BandImage->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->BandImage->create();
			if ($this->BandImage->save($this->request->data)) {
				$this->Session->setFlash(__('The band image has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The band image could not be saved. Please, try again.'));
			}
		}
		$bands = $this->BandImage->Band->find('list');
		$this->set(compact('bands'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid band image'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->BandImage->save($this->request->data)) {
				$this->Session->setFlash(__('The band image has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The band image could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->BandImage->read(null, $id);
		}
		$bands = $this->BandImage->Band->find('list');
		$this->set(compact('bands'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for band image'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BandImage->delete($id)) {
			$this->Session->setFlash(__('Band image deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Band image was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->BandImage->recursive = 0;
		$this->set('band_images', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid band image'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('band_image', $this->BandImage->read(null, $id));
	}

	function admin_add($band_id = null) {
		  // Sets info for form to select a new image

		  $this->set('styles',array('forms'));
		  $this->set('scripts',array('jquery.forms'));
		  if(!$band_id && empty($this->request->data)){
			 $this->Session->setFlash(__('Invalid band'));
			 $this->redirect(Controller::referer());
		  }
		  $this->set('band_id', $band_id);
	}

	   function admin_add_step_2(){
		  $this->set('styles',array('forms', 'imgareaselect-animated'));
		  $this->set('scripts',array('jquery.forms','jquery.imgareaselect.noresize.min'));
		  if (!empty($this->request->data)) {
			 //check for band id, none found redirect
			 if(!empty($this->request->data['BandImage']['band_id'])){
				$band = $this->BandImage->Band->findById($this->request->data['BandImage']['band_id']);
				if(!$band){
				    $this->Session->setFlash(__('Invalid band'));
				    $this->redirect(array('controller' => 'Bands', 'action' => 'index', 'admin' => 1));
				}
				$this->set('band', $band);
			 }

			 // make sure band image folder exists
			 $name = Inflector::slug(strtolower($band['Band']['name']));
			 $folder = 'bands/'.$name;
			 if(!is_dir(WWW_ROOT.DS.'img'.DS.$folder)) {
				mkdir(WWW_ROOT.DS.'img'.DS.$folder);
				chmod (WWW_ROOT.DS.'img'.DS.$folder , 0777);
				mkdir(WWW_ROOT.DS.'img'.DS.$folder.'/images');
				chmod (WWW_ROOT.DS.'img'.DS.$folder.'/images' , 0777);
			 }
			 $folder .= '/images/';
			 $filename = $name;
			 // set crop info
			 $uploaded = $this->JqImgcrop->uploadImage($this->request->data['BandImage']['image'], $folder, $filename);
			 $this->set('uploaded',$uploaded);
			 $this->set('folder',$folder);
		  } else {
			 $this->Session->setFlash(__('Invalid band'));
			 $this->redirect(array('controller' => 'Bands', 'action' => 'index', 'admin' => 1));
		  }
	   }

	   function admin_add_step_3(){
		  // perform crops and rezise on image
		  if(!empty($this->request->data['BandImage']['band_id'])){
			 $band = $this->BandImage->Band->findById($this->request->data['BandImage']['band_id']);
			 if(!$band){
				$this->Session->setFlash(__('Invalid band'));
				$this->redirect(array('controller' => 'Bands', 'action' => 'index', 'admin' => 1));
			 }
			 $this->set('band', $band);
		  }
		  $filename = basename($this->request->data['BandImage']['imagePath']);
		  $file_ext = substr($filename, strrpos($filename, ".") + 1);
		  $this->request->data['BandImage']['thumbPath'] = $this->request->data['BandImage']['path'].str_replace(".".$file_ext,'',$filename).'_thumbnail.'.$file_ext;
		  $this->JqImgcrop->cropImage(150, $this->request->data['BandImage']['x1'], $this->request->data['BandImage']['y1'], $this->request->data['BandImage']['x2'],
			 $this->request->data['BandImage']['y2'], $this->request->data['BandImage']['w'], $this->request->data['BandImage']['h'], $this->request->data['BandImage']['thumbPath'],
			 $this->request->data['BandImage']['imagePath']) ;
		  $exists = $this->BandImage->find('first', array(
			 'conditions' => array(
				'BandImage.band_id' => $this->request->data['BandImage']['band_id'],
				'BandImage.type' => 'primary'
			 )
		  ));
		  if($exists)
			  $image['BandImage']['id'] = $exists['BandImage']['id'];
		  
		  $image['BandImage']['band_station_id'] = $band['Band']['id'];
		  $image['BandImage']['path'] = $this->request->data['BandImage']['path'];
		  $image['BandImage']['filename'] = str_replace($this->request->data['BandImage']['path'],'',$this->request->data['BandImage']['imagePath']);
		  $image['BandImage']['thumbname'] = str_replace($this->request->data['BandImage']['path'],'',$this->request->data['BandImage']['thumbPath']);
		  $image['BandImage']['type'] = "primary";

		  $this->BandImage->save($image);
	   }

	   function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid band image'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->BandImage->save($this->request->data)) {
				$this->Session->setFlash(__('The band image has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The band image could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->BandImage->read(null, $id);
		}
		$bands = $this->BandImage->Band->find('list');
		$this->set(compact('bands'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for band image'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BandImage->delete($id)) {
			$this->Session->setFlash(__('Band image deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Band image was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>