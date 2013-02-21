<?php

class GroupsController extends AppController {

	var $name = 'Groups';
	var $uses = array('Group');

	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('*');
	}
		
	function admin_add(){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if(!empty($this->request->data)){
			if($this->Group->saveAll($this->request->data)){
				$this->Session->setFlash(__('The Group has been added.'));
			}
		}

	}
	
	function admin_edit($id = 0){
		$this->set('styles',array('forms'));
		$this->set('scripts',array('jquery.forms'));
		
		if (!empty($this->request->data)) {
			if($this->Group->save($this->request->data)){
				$this->Session->setFlash(__('The Group has been saved.'));
			}
		}
		
		if (empty($this->request->data)) {
			$this->request->data = $this->Group->read(null, $id);
		}
	}
	
	function admin_view_all(){
		$this->set('styles',array('tables'));
		
		$this->Group->recursive = 0;
		$this->set('groups', $this->paginate());
	}

	function admin_delete($id = 0){
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Group'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		$group = $this->Group->findById($id);
		if ($this->Group->delete($id)) {
			$this->Group->GroupDetail->delete($group['GroupDetail']['id']);
			$this->Session->setFlash(__('Group Deleted'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		$this->Session->setFlash(__('Group was not deleted'));
		$this->redirect(array('action' => 'admin_view_all'));
	}
	
	function admin_view($id = 0){
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Group'));
			$this->redirect(array('action' => 'admin_view_all'));
		}
		$this->set('group', $this->Group->findById($id));
	}
}

?>