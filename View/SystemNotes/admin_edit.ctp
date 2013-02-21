<?=$this->Form->create('SystemNote');?>
<p>Please fill out all of the information below.</p>
<!-- general user information -->
<?=$this->Form->input('SystemNote.group', array('options' => $group_opt, 'empty' => '(choose one)')); ?>
<?=$this->Form->input('SystemNote.type', array('options' => $type_opt, 'empty' => '(choose one)')); ?>
<?=$this->Form->input('SystemNote.title', array('label'=>'Note Title')); ?>
<?=$this->Form->input('SystemNote.description', array('label' => 'Description of System Note')); ?>
<?=$this->Form->input('id'); ?>
<?=$this->Form->end('Create System Note'); ?>