<? // pr($album_image['AlbumImage']['path'].$album_image['AlbumImage']['filename']); ?>
<?=$this->Image->show($album_image['AlbumImage'], array('id'=>'album-cover'), 200, 200);?>
<?=$this->Form->create('Review', array('type' => 'file'));?>
<?=$this->Form->input('Band.name', array('label' => "Band/Artist Name"));?>
<?=$this->Form->input('BandLink.link', array('label' => "Website"));?>
<?=$this->Form->hidden('BandLink.type', array('value'=>'website'));?>
<?=$this->Form->input('Album.name', array('label' => "Album Title"));?>
<?=$this->Form->file('AlbumImage.image'); ?>
<?=$this->Form->input('Label.name', array('label' => "Label"));?>
<?=$this->Form->input('sub_genre_id', array('label' => "Sub Genre", 'empty'=>'Select One'));?>
<?=$this->Form->input('rating', array('label' => "Rating", 'empty'=>'Select One', 'options'=>array('1','2','3','4','5')));?>
<?=$this->Form->input('review', array('label' => "Review", 'type'=>'textarea', 'class'=>'ckeditor'));?>
<?=$this->Form->input('edited_by', array('type'=>'hidden', 'value'=>$this->Session->read('Auth.User.id')));?>
<?=$this->Form->input('user_id', array('type'=>'hidden', 'value'=>$this->request->data['Review']['user_id']));?>
<?=$this->Form->input('id', array('type'=>'hidden', 'value'=>$this->request->data['Review']['id']));?>
<?=$this->Form->end(__('Make Changes'));?>