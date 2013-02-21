<?php

class RadioStaffLinksController extends AppController {

	var $name = 'RadioStaffLinks';

	function admin_add($staff_id = 0) {
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));

		if (!empty($this->request->data)) {
			$this->Link = $this->Components->load('Link');
			$this->request->data['RadioStaffLink']['link'] = $this->Link->clean_link($this->request->data['RadioStaffLink']['link'], $this->request->data['RadioStaffLink']['type']);
			if ($this->RadioStaffLink->save($this->request->data)) {
				$this->Session->setFlash(__('The staff member link has been saved'));
				$this->redirect(array('controller'=>'radio_staff_members', 'action'=>'admin_view/'.$this->request->data['RadioStaffLink']['radio_staff_member_id']));
			} else {
				$this->Session->setFlash(__('The radio station link could not be saved. Please, try again.'));
			}
		}
		if(empty($staff_id)){
				$this->Session->setFlash(__('No staff member selected.'));
				$this->redirect(Controller::referer());
		}

		$this->set('staff_id',$staff_id);
	}

	function admin_edit($id = 0) {
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid staff member'));
			$this->redirect(Controller::referer());
		}
		if (!empty($this->request->data)) {
			$this->Link = $this->Components->load('Link');
			
			$this->request->data['RadioStaffLink']['id'] = $id;
			
			$this->request->data['RadioStaffLink']['link'] = $this->Link->clean_link($this->request->data['RadioStaffLink']['link'], $this->request->data['RadioStaffLink']['type']);
			
			if ($this->RadioStaffLink->save($this->request->data)) {
				$this->Session->setFlash(__('The link has been saved'));
				$this->redirect(array('controller'=>'radio_staff_members', 'action'=>'admin_view/'.$this->request->data['RadioStaffLink']['radio_staff_member_id']));
			} else {
				$this->Session->setFlash(__('The link could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->RadioStaffLink->read(null, $id);
		}
	}

	function admin_delete($id = 0) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for link'));
			$this->redirect(Controller::referer());
		}
		$this->RadioStaffLink->id = $id;
		$data = $this->RadioStaffLink->read();
		$count = $this->RadioStaffLink->find('count', array(
			'conditions' => array(
				'radio_staff_member_id'=> $data['RadioStaffLink']['radio_staff_member_id']
			)
		));
			if ($this->RadioStaffLink->delete($id)) {
				$this->Session->setFlash(__('link deleted'));
				$this->redirect(Controller::referer());
			}
			$this->Session->setFlash(__('Link was not deleted'));
			$this->redirect(Controller::referer());
	}

}
?>
