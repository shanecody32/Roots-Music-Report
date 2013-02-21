<? // DW ?>

			
<!--	<li>Admin
	   <ul>
		  <li><?=$this->Html->link('Stations', array('controller'=>'radio_stations', 'action'=>'index', 'admin'=>true)); ?>
				<ul>
					<li><?=$this->Js->link('Add Station', array('controller'=>'radio_stations', 'action'=>'create', 'admin'=>true), array('before'=>$this->Js->get('#loading')->effect('fadeIn'),'success'=>$this->Js->get('#loading')->effect('fadeOut'),'update'=>'#load-content', 'evalScripts' => true)); ?></li>
					<li><?=$this->Html->link('Veiw Unverified Stations', array('controller'=>'radio_stations', 'action'=>'view_unverified', 'admin'=>true)); ?></li>
					<li><?=$this->Html->link('Veiw Unapproved Stations', array('controller'=>'radio_stations', 'action'=>'view_unapproved', 'admin'=>true)); ?></li>
				</ul>
			</li>
		  <li><?=$this->Html->link('All Artists', array('controller'=>'bands', 'action'=>'view_all', 'admin'=>true)); ?>
				<ul>
					<li><?=$this->Html->link('Add Artist/Band', array('controller'=>'bands', 'action'=>'add', 'admin'=>true)); ?></li>
					<li><?=$this->Html->link('Veiw Unverified Bands/Artists', array('controller'=>'bands', 'action'=>'view_unverified', 'admin'=>true)); ?></li>
					<li><?=$this->Html->link('Veiw Unapproved Bands/Artists', array('controller'=>'bands', 'action'=>'view_unapproved', 'admin'=>true)); ?></li>
				</ul>
			</li>
			<li><?=$this->Html->link('All Albums', array('controller'=>'albums', 'action'=>'view_all', 'admin'=>true)); ?>
				<ul>
					<li><?=$this->Html->link('Add Album', array('controller'=>'albums', 'action'=>'admin_add')); ?></li>
					<li><?=$this->Html->link('Veiw Unverified Albums', array('controller'=>'albums', 'action'=>'view_unverified', 'admin'=>true)); ?></li>
					<li><?=$this->Html->link('Veiw Unapproved Albums', array('controller'=>'albums', 'action'=>'view_unapproved', 'admin'=>true)); ?></li>
				</ul>
			</li>
			<li><?=$this->Html->link('All Reporting Members', array('controller'=>'radio_staff_members', 'action'=>'view_all', 'admin'=>true)); ?>
				<ul>
					<li><?=$this->Html->link('Veiw Unverified Reporting Members', array('controller'=>'radio_staff_members', 'action'=>'view_unverified', 'admin'=>true)); ?></li>
					<li><?=$this->Html->link('Veiw Unapproved Reporting Members', array('controller'=>'radio_staff_members', 'action'=>'view_unapproved', 'admin'=>true)); ?></li>
				</ul>
			</li>
			<li><?=$this->Html->link('Create Violation', array('controller'=>'violations', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('All Reviews', array('controller'=>'reviews', 'action'=>'search', 'admin'=>true)); ?>
				<ul>
					<li><?=$this->Html->link('Create Review', array('controller'=>'reviews', 'action'=>'add', 'admin'=>true)); ?></li>
					<li><?=$this->Html->link('Veiw Unapproved Reviews', array('controller'=>'reviews', 'action'=>'search', 'not_approved' =>'1', 'admin'=>true)); ?></li>
					<li><?=$this->Js->link('Ajax Reviews', array('controller'=>'reviews', 'action'=>'search', 'admin'=>true), array('before'=>$this->Js->get('#loading')->effect('fadeIn'),'success'=>$this->Js->get('#loading')->effect('fadeOut'),'update'=>'#load-content', 'evalScripts' => true)); ?></li>
				</ul>
			</li>
	   </ul>
	</li>
	<li>
		<a href="http://crookedcomma.com/developement/">Forum to report issues</a>
	</li>
</ul> -->
<div id="load-content"></div>


