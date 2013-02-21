<? // for dreamweaver ?>
<nav id='footer-nav'>
	<h2 class="hidden" hidden>Main Site Navigation</h2>
	<ul class="five">
		<li><span>&nbsp;</span><?=$this->Html->link( __('Home'), 'http://www.rootsmusicreport.com/rmr_test/');?></li>
		<li><span>&nbsp;</span><?=$this->Html->link( __('CD Reviews'), array('controller'=>'reviews', 'action'=>'search'));?></li>
		<li><span>&nbsp;</span><?=$this->Html->link('Stations', array('controller'=>'radio_stations', 'action'=>'search')); ?></li>
		<li><span>&nbsp;</span><?=$this->Html->link('Reporters', array('controller'=>'radio_staff_members', 'action'=>'search')); ?></li>
		<li><span>&nbsp;</span><?=$this->Html->link('Tracking', array('controller'=>'bands', 'action'=>'search')); ?></li>
		<li><span>&nbsp;</span><?=$this->Html->link('Articles', array('controller'=>'articles')); ?></li>
		<li><span>&nbsp;</span><?=$this->Html->link( __('Contact Us'), 'http://www.rootsmusicreport.com/rmr_test/');?></li>
		<li><span>&nbsp;</span><?=$this->Html->link( __('About Us'), 'http://www.rootsmusicreport.com/rmr_test/');?></li>
		<li><span>&nbsp;</span><?=$this->Html->link( __('Site Map'), 'http://www.rootsmusicreport.com/rmr_test/');?></li>
		<li><span>&nbsp;</span><?=$this->Html->link( __('Advertising'), 'http://www.rootsmusicreport.com/rmr_test/');?></li>
	</ul>
</nav>