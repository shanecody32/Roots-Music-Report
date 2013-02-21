<? // DW ?>
<?=$this->Form->create('Category');?>
<?=$this->Form->input('name');?>
<?=$this->Form->input('genre_id', array('options'=>$genres,'empty'=>'(Select One)'));?>
<?=$this->Form->end(__('Add Sub Genre'));?>