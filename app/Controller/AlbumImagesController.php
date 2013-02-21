<?php
class AlbumImagesController extends AppController {
	var $name = 'AlbumImages';

	function index() {
		$this->AlbumImage->recursive = 0;
		$this->set('AlbumImages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid album image'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('AlbumImage', $this->AlbumImage->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->AlbumImage->create();
			if ($this->AlbumImage->save($this->request->data)) {
				$this->Session->setFlash(__('The album image has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The album image could not be saved. Please, try again.'));
			}
		}
		$albumStations = $this->AlbumImage->RadioStation->find('list');
		$this->set(compact('radioStations'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid album image'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->AlbumImage->save($this->request->data)) {
				$this->Session->setFlash(__('The album image has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The album image could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->AlbumImage->read(null, $id);
		}
		$albumStations = $this->AlbumImage->RadioStation->find('list');
		$this->set(compact('radioStations'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for album image'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AlbumImage->delete($id)) {
			$this->Session->setFlash(__('album image deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('album image was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->AlbumImage->recursive = 0;
		$this->set('AlbumImages', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid album image'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('AlbumImage', $this->AlbumImage->read(null, $id));
	}

	function admin_add($album_id = null) {
			// Sets info for form to select a new image

			$this->set('styles',array('forms'));
			$this->set('scripts',array('jquery.forms'));
			if(!$album_id && empty($this->request->data)){
				$this->Session->setFlash(__('Invalid album id'));
				$this->redirect(Controller::referer());
			}
			$this->set('album_id', $album_id);
	}

	function admin_add_step_2(){
		$this->set('styles',array('forms', 'imgareaselect-animated'));
		$this->set('scripts',array('jquery.forms','jquery.imgareaselect.min'));
		if (!empty($this->request->data)) {
			//check for album id, none found redirect
			if(!empty($this->request->data['AlbumImage']['album_id'])){
				$album = $this->AlbumImage->Album->findById($this->request->data['AlbumImage']['album_id']);
				if(!$album){
					$this->Session->setFlash(__('Invalid album id.'));
					$this->redirect(Controller::referer());
				}
				$this->set('album', $album);
			}

			// make sure radio image folder exists
			$name = Inflector::slug(strtolower($album['Band']['name']));
			$folder = 'bands/'.$name;
			if(!is_dir(WWW_ROOT.DS.'img'.DS.$folder)) {
				mkdir(WWW_ROOT.DS.'img'.DS.$folder);
				chmod (WWW_ROOT.DS.'img'.DS.$folder , 0777);
				mkdir(WWW_ROOT.DS.'img'.DS.$folder.'/images');
				chmod (WWW_ROOT.DS.'img'.DS.$folder.'/images' , 0777);
				mkdir(WWW_ROOT.DS.'img'.DS.$folder.'/images/albums');
				chmod (WWW_ROOT.DS.'img'.DS.$folder.'/images/albums' , 0777);
			}
			$folder .= '/images/';
			$filename = Inflector::slug(strtolower($album['Album']['name']." by ".$album['Band']['name']));;
			// set crop info
			$uploaded = $this->JqImgcrop->uploadImage($this->request->data['AlbumImage']['image'], $folder, $filename);
			$this->set('uploaded',$uploaded);
			$this->set('folder',$folder);
		} else {
			$this->Session->setFlash(__('Invalid radio station'));
			$this->redirect(Controller::referer());
		}
	}

	function admin_add_step_3(){
		// perform crops and rezise on image
		if(!empty($this->request->data['AlbumImage']['album_id'])){
			$album = $this->AlbumImage->Album->findById($this->request->data['AlbumImage']['album_id']);
			if(!$album){
				$this->Session->setFlash(__('Invalid album id'));
				$this->redirect(array('controller' => 'Albums', 'action' => 'index', 'admin' => 1));
			}
			$this->set('radio', $album);
		}
		$filename = basename($this->request->data['AlbumImage']['imagePath']);
		$file_ext = substr($filename, strrpos($filename, ".") + 1);
		$this->request->data['AlbumImage']['thumbPath'] = $this->request->data['AlbumImage']['path'].str_replace(".".$file_ext,'',$filename).'_thumbnail.'.$file_ext;
		$this->JqImgcrop->cropImage(100, $this->request->data['AlbumImage']['x1'], $this->request->data['AlbumImage']['y1'], $this->request->data['AlbumImage']['x2'],
			$this->request->data['AlbumImage']['y2'], $this->request->data['AlbumImage']['w'], $this->request->data['AlbumImage']['h'], $this->request->data['AlbumImage']['thumbPath'],
			$this->request->data['AlbumImage']['imagePath']) ;
		$exists = $this->AlbumImage->find('first', array(
			'conditions' => array(
				'AlbumImage.album_id' => $this->request->data['AlbumImage']['album_id'],
				'AlbumImage.type' => 'primary'
			)
		));
		if($exists)
			$image['AlbumImage']['id'] = $exists['AlbumImage']['id'];
		
		$image['AlbumImage']['album_id'] = $album['Album']['id'];
		$image['AlbumImage']['path'] = $this->request->data['AlbumImage']['path'];
		$image['AlbumImage']['filename'] = str_replace($this->request->data['AlbumImage']['path'],'',$this->request->data['AlbumImage']['imagePath']);
		$image['AlbumImage']['thumbname'] = str_replace($this->request->data['AlbumImage']['path'],'',$this->request->data['AlbumImage']['thumbPath']);
		$image['AlbumImage']['type'] = "primary";
		$this->AlbumImage->save($image);
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid album image'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->AlbumImage->save($this->request->data)) {
				$this->Session->setFlash(__('The album image has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The album image could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->AlbumImage->read(null, $id);
		}
		$albumStations = $this->AlbumImage->RadioStation->find('list');
		$this->set(compact('radioStations'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for album image'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AlbumImage->delete($id)) {
			$this->Session->setFlash(__('album image deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('album image was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>