<?=$this->Form->create('Band');?>
<?=$this->Form->input('name', array('label' => "Band/Artist Name"));?>
<?=$this->Form->input('state_id', array('label' => "State/Provence", 'empty'=>'Select One'));?>
<?=$this->Form->input('country_id', array('label' => "Country", 'empty'=>'Select One'));?>
<?=$this->Form->end(__('Add Band'));?>