<?=$this->Form->create('State');?>
<?=$this->Form->input('name', array('label' => "Name"));?>
<?=$this->Form->input('abbrv', array('label' => "Abbreviation"));?>
<?=$this->Form->input('country_id', array('label' => "Country", 'options'=>$countries, 'empty'=>'Select One'));?>
<?=$this->Form->hidden('id');?>
<?=$this->Form->end(__('Save State'));?>
