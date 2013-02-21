<?=$this->Form->create('RadioStaffLink');?>
<?=$this->Form->input('link');?>
<? $options = array('website'=>'Website','facebook'=>'Facebook','myspace'=>'MySpace','youtube'=>'YouTube','twitter'=>'Twitter','blog'=>'Blog'); ?>
<?=$this->Form->input('type', array('options'=>$options,'empty'=>'(Select One)'));?>
<?=$this->Form->hidden('radio_staff_member_id', array('value'=>$staff_id));?>
<?=$this->Form->end(__('Add Link'));?>