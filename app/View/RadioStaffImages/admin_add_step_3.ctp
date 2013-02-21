<? pr($this->data); ?>

<?=$this->Html->image($this->data['RadioStaffImage']['imagePath']); ?>
<?=$this->Html->image($this->data['RadioStaffImage']['thumbPath']); ?>

<?=$this->Html->link('Return to Profile', array('controller'=>'radio_staff_members', 'action'=>'admin_view/'.$this->data['RadioStaffImage']['staff_id']));?>