<ul>
    <li>Admin
	   <ul>
		  <li><?=$this->Html->link('All Stations', array('controller'=>'radio_stations', 'action'=>'search')); ?>
				<ul>
					<li><?=$this->Html->link('Add Station', array('controller'=>'radio_stations', 'action'=>'admin_create')); ?></li>
					<li><?=$this->Html->link('View Unverified Stations', array('controller'=>'radio_stations', 'action'=>'search/status:unverified/')); ?></li>
					<li><?=$this->Html->link('View Unapproved Stations', array('controller'=>'radio_stations', 'action'=>'search/not_approved:1')); ?></li>
					<li><?=$this->Html->link('Search Stations', array('controller'=>'radio_stations', 'action'=>'search')); ?></li>
				</ul>
			</li>
		  <li><?=$this->Html->link('All Artists', array('controller'=>'bands', 'action'=>'search')); ?>
				<ul>
					<li><?=$this->Html->link('Add Artist/Band', array('controller'=>'bands', 'action'=>'admin_add')); ?></li>
					<li><?=$this->Html->link('View Unverified Bands/Artists', array('controller'=>'bands', 'action'=>'search/status:unverified/')); ?></li>
					<li><?=$this->Html->link('View Unapproved Bands/Artists', array('controller'=>'bands', 'action'=>'search/not_approved:1')); ?></li>
				</ul>
			</li>
			<li><?=$this->Html->link('All Albums', array('controller'=>'albums', 'action'=>'search')); ?>
				<ul>
					<li><?=$this->Html->link('Add Album', array('controller'=>'albums', 'action'=>'admin_add')); ?></li>
					<li><?=$this->Html->link('View Unverified Albums', array('controller'=>'albums', 'action'=>'search/status:unverified/')); ?></li>
					<li><?=$this->Html->link('View Unapproved Albums', array('controller'=>'albums', 'action'=>'search/not_approved:1')); ?></li>
				</ul>
			</li>
			<li><?=$this->Html->link('All Reporting Members', array('controller'=>'radio_staff_members', 'action'=>'search')); ?>
				<ul>
					<li><?=$this->Html->link('View Unverified Members', array('controller'=>'radio_staff_members', 'action'=>'search/status:unverified/')); ?></li>
					<li><?=$this->Html->link('View Unapproved Members', array('controller'=>'radio_staff_members', 'action'=>'search/not_approved:1')); ?></li>
					<li><?=$this->Html->link('Search Members', array('controller'=>'radio_staff_members', 'action'=>'search')); ?></li>
				</ul>
			</li>
			<li><?=$this->Html->link('View All Violations', array('controller'=>'violations', 'action'=>'admin_view_all')); ?>
				<ul>
					<li><?=$this->Html->link('Create Violation', array('controller'=>'violations', 'action'=>'admin_add')); ?></li>
				</ul>
			</li>
			<li><?=$this->Html->link('View All System Notes', array('controller'=>'system_notes', 'action'=>'admin_view_all')); ?>
				<ul>
					<li><?=$this->Html->link('Create System Note', array('controller'=>'system_notes', 'action'=>'admin_add')); ?></li>
				</ul>
			</li>
			<li><?=$this->Html->link('View All Users', array('controller'=>'users', 'action'=>'admin_view_all')); ?>
				<ul>
					<li><?=$this->Html->link('Create User', array('controller'=>'users', 'action'=>'admin_add')); ?></li>
				</ul>
			</li>
			<li>Generate Charts
				<ul>
					<li><?=$this->Html->link('Total Spins', array('controller'=>'chart_functions', 'action'=>'check_finalized')); ?></li>
					<li><?=$this->Html->link('View Test Charts', array('controller'=>'chart_functions', 'action'=>'view_temp_charts')); ?></li>
					<li><?=$this->Html->link('Generate/Re-generate Charts', array('controller'=>'chart_functions', 'action'=>'generate_song_charts'));?></li>

				</ul>
			</li>
			<li><?=$this->Html->link('View Charts', array('controller'=>'charts', 'action'=>'show_charts')); ?></li>
			<li>Genres
				<ul>
					<li>Add Genre</li>
					<li><?=$this->Html->link('Add Sub Genre', array('controller'=>'sub_genres', 'action'=>'admin_add')); ?></li>
					<li>View Genres</li>
					<li><?=$this->Html->link('View Sub Genres', array('controller'=>'sub_genres', 'action'=>'admin_view_all')); ?></li>
				</ul>
			</li>
			<li><?=$this->Html->link('States', array('controller'=>'states', 'action'=>'admin_view_all')); ?>
	   </ul>
    </li>
	<li>
		<a href="http://crookedcomma.com/developement/">Forum to report issues</a>
	</li>
</ul>


