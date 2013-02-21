<ul>
    <li>Admin
	   <ul>
		  <li><?=$this->Html->link('Stations', array('controller'=>'radio_stations', 'action'=>'admin_index')); ?>
				<ul>
					<li><?=$this->Html->link('Add Station', array('controller'=>'radio_stations', 'action'=>'admin_create')); ?></li>
					<li><?=$this->Html->link('Veiw Unverified Stations', array('controller'=>'radio_stations', 'action'=>'admin_view_unverified')); ?></li>
					<li><?=$this->Html->link('Veiw Unapproved Stations', array('controller'=>'radio_stations', 'action'=>'admin_view_unapproved')); ?></li>
				</ul>
			</li>
		  <li><?=$this->Html->link('All Artists', array('controller'=>'bands', 'action'=>'admin_view_all')); ?>
				<ul>
					<li><?=$this->Html->link('Add Artist/Band', array('controller'=>'bands', 'action'=>'admin_add')); ?></li>
					<li><?=$this->Html->link('Veiw Unverified Bands/Artists', array('controller'=>'bands', 'action'=>'admin_view_unverified')); ?></li>
					<li><?=$this->Html->link('Veiw Unapproved Bands/Artists', array('controller'=>'bands', 'action'=>'admin_view_unapproved')); ?></li>
				</ul>
			</li>
			<li><?=$this->Html->link('All Albums', array('controller'=>'albums', 'action'=>'admin_view_all')); ?>
				<ul>
					<li><?=$this->Html->link('Add Album', array('controller'=>'albums', 'action'=>'admin_add')); ?></li>
					<li><?=$this->Html->link('Veiw Unverified Albums', array('controller'=>'albums', 'action'=>'admin_view_unverified')); ?></li>
					<li><?=$this->Html->link('Veiw Unapproved Albums', array('controller'=>'albums', 'action'=>'admin_view_unapproved')); ?></li>
				</ul>
			</li>
			<li><?=$this->Html->link('All Reporting Members', array('controller'=>'radio_staff_members', 'action'=>'admin_view_all')); ?>
				<ul>
					<li><?=$this->Html->link('Veiw Unverified Reporting Members', array('controller'=>'radio_staff_members', 'action'=>'admin_view_unverified')); ?></li>
					<li><?=$this->Html->link('Veiw Unapproved Reporting Members', array('controller'=>'radio_staff_members', 'action'=>'admin_view_unapproved')); ?></li>
				</ul>
			</li>
			<li><?=$this->Html->link('Create Violation', array('controller'=>'violations', 'action'=>'admin_add')); ?></li>
	   </ul>
    </li>
	<li>
		<a href="http://crookedcomma.com/developement/">Forum to report issues</a>
	</li>
    
</ul>


