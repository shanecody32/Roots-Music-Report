<? // dw ?>

<?=$this->Form->create('User');?>
<?=$this->Form->input('User.username', array('label' => 'Username')); ?>
<?=$this->Form->input('User.password', array('label' => 'Password', 'type'=>'password')); ?>
<?=$this->Form->end('Login'); ?>