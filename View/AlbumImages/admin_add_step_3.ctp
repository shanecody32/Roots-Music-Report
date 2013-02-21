<? pr($this->data); ?>

<?=$this->Html->image($this->data['AlbumImage']['imagePath']); ?>
<?=$this->Html->image($this->data['AlbumImage']['thumbPath']); ?>

<?=$this->Html->link('Return to Profile', array('controller'=>'albums', 'action'=>'admin_view/'.$this->data['AlbumImage']['album_id']));?>