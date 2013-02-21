<? // DW ?>
<section id="user">
	<h2 class="hidden" hidden>Login</h2>
	<?=$this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'login', 'admin'=>false), 'class'=>'login',));?>
	<?=$this->Form->input('User.username', array('label' => 'User:', 'placeholder'=>'E-mail'), array('class'=>'login')); ?>
	<?=$this->Form->input('User.password', array('label' => 'Pass:', 'type'=>'password', 'placeholder'=>'Password'), array('class'=>'login')); ?>
	<?=$this->Form->end('Login', array('class'=>'login')); ?>
</section>

