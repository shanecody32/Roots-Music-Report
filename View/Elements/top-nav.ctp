<? // for dreamweaver ?>
<nav id='header-nav'>
	<h2 class="hidden" hidden>Main Site Navigation</h2>
	<ul class="triple">
		<li><span>&nbsp;</span><?=$this->Html->link( __('Home'), 'http://www.rootsmusicreport.com/rmr_test/');?></li>
		<li><span>&nbsp;</span><?=$this->Html->link( __('CD Reviews'), array('controller'=>'reviews', 'action'=>'search'));?></li>
		<li><span>&nbsp;</span><?=$this->Html->link('Stations', array('controller'=>'radio_stations', 'action'=>'search')); ?></li>
		<li><span>&nbsp;</span><?=$this->Html->link('Reporters', array('controller'=>'radio_staff_members', 'action'=>'search')); ?></li>
		<li><span>&nbsp;</span><?=$this->Html->link('Tracking', array('controller'=>'bands', 'action'=>'search')); ?></li>
		<li><span>&nbsp;</span><?=$this->Html->link('Articles', array('controller'=>'articles')); ?></li>
	</ul>
</nav>