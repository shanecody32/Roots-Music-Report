<?=$this->Form->create('Group');?>
	<?=$this->Form->input('name', array('label' => 'Name for Group')); ?>
	<?=$this->Form->input('id', array('type'=>'hidden', 'value' => $this->request->data['Group']['id'])); ?>	
<?=$this->Form->end('Edit Group'); ?>