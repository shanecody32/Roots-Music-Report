<?=$this->Form->create('RadioStaffMember');?>
<p>Please fill out all of the information below.</p>
<!-- general user information -->
<?=$this->Form->input('Violation.id', array('options' => $violations, 'empty' => '(choose one)', 'label' => 'Violation to Add')); ?>
<?=$this->Form->end('Add Violation'); ?>