<? pr($this->data); ?>

<?=$this->Html->image($this->data['BandImage']['imagePath']); ?>
<?=$this->Html->image($this->data['BandImage']['thumbPath']); ?>

<?=$this->Html->link('Return to Profile', array('controller'=>'bands', 'action'=>'admin_view/'.$this->data['BandImage']['band_id']));?>