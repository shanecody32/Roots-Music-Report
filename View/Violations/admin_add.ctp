<?=$this->Form->create('Violation');?>
<p>Please fill out all of the information below.</p>
<!-- general user information -->
<?=$this->Form->input('Violation.group', array('options' => $group_opt, 'empty' => '(choose one)')); ?>
<?=$this->Form->input('Violation.type', array('options' => $type_opt, 'empty' => '(choose one)')); ?>
<?=$this->Form->input('Violation.title'); ?>
<?=$this->Form->input('Violation.description', array('label' => 'Description of Violation')); ?>
<?=$this->Form->end('Create Violation'); ?>