<?=$this->Form->create('RadioStaffLink');?>
<?=$this->Form->input('link');?>
<? $options = array('website'=>'Website','facebook'=>'Facebook','myspace'=>'MySpace','twitter'=>'Twitter','blog'=>'Blog'); ?>
<?=$this->Form->input('type', array('options'=>$options,'empty'=>'(Select One)'), array('selected'=>$this->data['RadioStaffLink']['type']));?>
<?=$this->Form->hidden('radio_staff_member_id', array('value'=>$this->data['RadioStaffLink']['radio_staff_member_id']));?>
<?=$this->Form->input('id'); ?>
<?=$this->Form->end(__('Edit Link'));?>