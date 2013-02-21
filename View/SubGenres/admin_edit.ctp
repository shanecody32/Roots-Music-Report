<?=$this->Form->create('SubGenre');?>
<?=$this->Form->input('name');?>
<?=$this->Form->input('genre_id', array($genres,'empty'=>'(Select One)'));?>
<?=$this->Form->input('id'); ?>
<?=$this->Form->end(__('Edit Sub Genre'));?>