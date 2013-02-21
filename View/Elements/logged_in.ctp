<? // DW ?>
<section id="user">
	<h2 class="hidden" hidden>Logged In</h2>
	<ul>
		<li>Welcome Back Shane!</li> 
		<li class="hasmore"><a>Account</a>
				<ul class="dropdown">
					<li><a href="#">Settings</a></li>
					<li><a href="#">Change Password</a></li>
					<li class="last"><a href="#">Account Info</a></li>
				</ul>
		</li>
		<li><?=$this->Html->link('Logout', array('controller'=>'users', 'action'=>'logout', 'admin'=>false)); ?></li>
	</ul>
</section>

