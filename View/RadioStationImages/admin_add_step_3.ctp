<? pr($this->data); ?>

<?=$this->Html->image($this->data['RadioStationImage']['imagePath']); ?>
<?=$this->Html->image($this->data['RadioStationImage']['thumbPath']); ?>

<?=$this->Html->link('Return to Profile', array('controller'=>'radio_stations', 'action'=>'admin_view/'.$this->data['RadioStationImage']['radio_id']));?>