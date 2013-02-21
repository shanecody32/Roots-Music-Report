<?php
class RadioStaffImagesController extends AppController {

	var $name = 'RadioStaffImages';

	function index() {
		$this->RadioStaffImage->recursive = 0;
		$this->set('radioStationImages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid staff member image'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('radioStationImage', $this->RadioStaffImage->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->RadioStaffImage->create();
			if ($this->RadioStaffImage->save($this->request->data)) {
				$this->Session->setFlash(__('The staff member image has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The staff member image could not be saved. Please, try again.'));
			}
		}
		$staff_members = $this->RadioStaffImage->RadioStaffMember->find('list');
		$this->set(compact('staffs'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid radio staff image'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->RadioStaffImage->save($this->request->data)) {
				$this->Session->setFlash(__('The radio staff image has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The radio staff image could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->RadioStaffImage->read(null, $id);
		}
		$staff_members = $this->RadioStaffImage->RadioStaffMember->find('list');
		$this->set(compact('staff'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for staff member image'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->RadioStaffImage->delete($id)) {
			$this->Session->setFlash(__('Radio station image deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Radio station image was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->RadioStaffImage->recursive = 0;
		$this->set('radioStaffImages', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid staff member image'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('radio_staff_image', $this->RadioStaffImage->read(null, $id));
	}

	function admin_add($staff_id = null) {
		  // Sets info for form to select a new image

		  $this->set('styles',array('forms'));
		  $this->set('scripts',array('jquery.forms'));
		  if(!$staff_id && empty($this->request->data)){
			 $this->Session->setFlash(__('Invalid staff member'));
			 $this->redirect(Controller::referer());
		  }
		  $this->set('staff_id', $staff_id);
	}

	   function admin_add_step_2(){
		  $this->set('styles',array('forms', 'imgareaselect-animated'));
		  $this->set('scripts',array('jquery.forms','jquery.imgareaselect.min'));
		  if (!empty($this->request->data)) {
			 //check for radio id, none found redirect
			 if(!empty($this->request->data['RadioStaffImage']['staff_id'])){
				$staff = $this->RadioStaffImage->RadioStaffMember->findById($this->request->data['RadioStaffImage']['staff_id']);
				if(!$staff){
				    $this->Session->setFlash(__('Invalid staff member'));
				    $this->redirect(array('controller' => 'RadioStaffMembers', 'action' => 'admin_view_all'));
				}
				$this->set('staff', $staff);
			 }

			 // make sure radio image folder exists
			 $name = Inflector::slug(strtolower($staff['RadioStaffMember']['first_name'].' '.$staff['RadioStaffMember']['last_name']));
			 $radio_name = Inflector::slug(strtolower($staff['RadioStation']['name']));
			 $folder = 'radio_stations'.DS.$radio_name.DS.'staff_members'.DS.$name;
			 if(!is_dir(WWW_ROOT.DS.'img'.DS.$folder)) {
				if(!is_dir(WWW_ROOT.DS.'img'.DS.'radio_stations'.DS.$radio_name)){
					mkdir(WWW_ROOT.DS.'img'.DS.'radio_stations'.DS.$radio_name);
					chmod (WWW_ROOT.DS.'img'.DS.'radio_stations'.DS.$radio_name , 0777);
				}
				mkdir(WWW_ROOT.DS.'img'.DS.'radio_stations'.DS.$radio_name.DS.'staff_members');
				chmod (WWW_ROOT.DS.'img'.DS.'radio_stations'.DS.$radio_name.DS.'staff_members' , 0777);
				mkdir(WWW_ROOT.DS.'img'.DS.'radio_stations'.DS.$radio_name.DS.'staff_members'.DS.$name);
				chmod (WWW_ROOT.DS.'img'.DS.'radio_stations'.DS.$radio_name.DS.'staff_members'.DS.$name , 0777);				
				mkdir(WWW_ROOT.DS.'img'.DS.$folder.DS.'images');
				chmod (WWW_ROOT.DS.'img'.DS.$folder.DS.'images' , 0777);
			 }
			 $folder .= DS.'images'.DS;
			 $filename = $name.'_main';
			 // set crop info
			 $uploaded = $this->JqImgcrop->uploadImage($this->request->data['RadioStaffImage']['image'], $folder, $filename);
			 $this->set('uploaded',$uploaded);
			 $this->set('folder',$folder);
		  } else {
			 $this->Session->setFlash(__('Invalid staff member'));
			 $this->redirect(array('controller' => 'RadioStaffMembers', 'action' => 'admin_view_all'));
		  }
	   }

	   function admin_add_step_3(){
		  // perform crops and rezise on image
		  if(!empty($this->request->data['RadioStaffImage']['staff_id'])){
			 $staff = $this->RadioStaffImage->RadioStaffMember->findById($this->request->data['RadioStaffImage']['staff_id']);
			 if(!$staff){
				$this->Session->setFlash(__('Invalid staff member'));
				$this->redirect(array('controller' => 'RadioStaffMembers', 'action' => 'admin_view_all'));
			 }
			 $this->set('staff', $staff);
		  }
		  $filename = basename($this->request->data['RadioStaffImage']['imagePath']);
		  $file_ext = substr($filename, strrpos($filename, ".") + 1);
		  $this->request->data['RadioStaffImage']['thumbPath'] = $this->request->data['RadioStaffImage']['path'].str_replace(".".$file_ext,'',$filename).'_thumbnail.'.$file_ext;
		  $this->JqImgcrop->cropImage(100, $this->request->data['RadioStaffImage']['x1'], $this->request->data['RadioStaffImage']['y1'], $this->request->data['RadioStaffImage']['x2'],
			 $this->request->data['RadioStaffImage']['y2'], $this->request->data['RadioStaffImage']['w'], $this->request->data['RadioStaffImage']['h'], $this->request->data['RadioStaffImage']['thumbPath'],
			 $this->request->data['RadioStaffImage']['imagePath']) ;
		  $exists = $this->RadioStaffImage->find('first', array(
			 'conditions' => array(
				'RadioStaffImage.radio_staff_member_id' => $staff['RadioStaffMember']['id'],
				'RadioStaffImage.type' => 'primary'
			 )
		  ));
		  if($exists)
			  $image['RadioStaffImage']['id'] = $exists['RadioStaffImage']['id'];
		  
		  $image['RadioStaffImage']['radio_staff_member_id'] = $staff['RadioStaffMember']['id'];
		  $image['RadioStaffImage']['path'] = $this->request->data['RadioStaffImage']['path'];
		  $image['RadioStaffImage']['filename'] = str_replace($this->request->data['RadioStaffImage']['path'],'',$this->request->data['RadioStaffImage']['imagePath']);
		  $image['RadioStaffImage']['thumbname'] = str_replace($this->request->data['RadioStaffImage']['path'],'',$this->request->data['RadioStaffImage']['thumbPath']);
		  $image['RadioStaffImage']['type'] = "primary";

		  $this->RadioStaffImage->save($image);
	   }

	   function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid staff member image'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->RadioStaffImage->save($this->request->data)) {
				$this->Session->setFlash(__('The staff member image has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The staff member image could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->RadioStaffImage->read(null, $id);
		}
		$staff_members = $this->RadioStaffImage->RadioStaffMember->find('list');
		$this->set(compact('staff_members'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for staff member image'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->RadioStaffImage->delete($id)) {
			$this->Session->setFlash(__('Radio station image deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Radio station image was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>