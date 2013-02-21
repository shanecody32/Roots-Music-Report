<? // file ?>
<section id="chart-bar">
	<?=$this->Html->link($this->Html->image('facebook_64.png', array('alt' => __('Like us on Facebook', true), 'class'=>'social-icon')),'http://www.facebook.com/pages/Roots-Music-Report/245118458893246', array('escape' => false));?>
	<?=$this->Html->link($this->Html->image('myspace_64.png', array('alt' => __('Join us on MySpace', true), 'class'=>'social-icon')),'http://www.myspace.com/rootsmusiccharts', array('escape' => false));?>
	<?=$this->Html->link($this->Html->image('twitter_64.png', array('alt' => __('Follow us on Twitter', true), 'class'=>'social-icon')),'https://twitter.com/@rootsmusreport', array('escape' => false));?>
	<ul id="chart-nav">
		<li class="chart-cat" id="nav-album">Album Charts
				<ul class="drop-list album-charts" id="nav-album-down">
					<li> 
						<div class="chart-nav-box-genres">
							<span class="drop-list-title">- Genres -</span>
							<div class="genre-list-container">
								<ul class="genre-list double">
									<? foreach($l_genres as $genre): ?>
										<? if($genre['Genre']['name'] != 'Unknown' && $genre['Genre']['name'] != 'Holiday'): ?>
											<li><?=$this->Html->link(__($genre['Genre']['name']), array('controller'=>'charts', 'action'=>'view', 'album', $genre['Genre']['name'], "Genre"));?></li>
										<? endif; ?>
									<? endforeach; ?>
								</ul>
							</div>
						</div>
						<div class="chart-nav-box-sub-genres">
							<span class="drop-list-title">- Sub Genres -</span>
							<div class="genre-list-container">
								<ul class="genre-list quad">
									<? foreach($l_sub_genres as $sub_genre): ?>
										<? if($sub_genre['SubGenre']['name'] != 'Unknown' && $sub_genre['SubGenre']['name'] != 'Christmas' ): ?>
											<? if($sub_genre['SubGenre']['name'] == "Alternative Country") $sub_genre['SubGenre']['name'] = 'Alt. Country'; ?>
											<? if($sub_genre['SubGenre']['name'] == "Alternative Rock") $sub_genre['SubGenre']['name'] = 'Alt. Rock'; ?>
											<? if($sub_genre['SubGenre']['name'] == "Roots-Americana Country") $sub_genre['SubGenre']['name'] = 'Roots-Americana'; ?>
											<li><?=$this->Html->link(__($sub_genre['SubGenre']['name']), array('controller'=>'charts', 'action'=>'view', 'album', $sub_genre['SubGenre']['name'], "SubGenre"));?></li>
										<? endif; ?>
									<? endforeach; ?>
								</ul>
								<span class="clearfloats">&nbsp;</span>
							</div>
						</div>
					</li>
				</ul>
			</li>
			<li class="chart-cat" id="nav-song">Song Charts
				<ul class="drop-list song-charts" id="nav-song-down">
					<li> 
						<div class="chart-nav-box-genres">
											<span class="drop-list-title">- Genres -</span>
											<div class="genre-list-container">
											<ul class="genre-list double">
												<? foreach($l_genres as $genre): ?>
													<? if($genre['Genre']['name'] != 'Unknown' && $genre['Genre']['name'] != 'Holiday'): ?>
													<li><?=$this->Html->link(__($genre['Genre']['name']), array('controller'=>'charts', 'action'=>'view', 'song', $genre['Genre']['name'], "Genre"));?></li>
													<? endif; ?>
												<? endforeach; ?>
											</ul>
											</div>
										</div>
										<div class="chart-nav-box-sub-genres">
											<span class="drop-list-title">- Sub Genres -</span>
											<div class="genre-list-container">
											<ul class="genre-list quad">
												<? foreach($l_sub_genres as $sub_genre): ?>
													<? if($sub_genre['SubGenre']['name'] != 'Unknown' && $sub_genre['SubGenre']['name'] != 'Christmas'): ?>
													<? if($sub_genre['SubGenre']['name'] == "Alternative Country") $sub_genre['SubGenre']['name'] = 'Alt. Country'; ?>
														<? if($sub_genre['SubGenre']['name'] == "Alternative Rock") $sub_genre['SubGenre']['name'] = 'Alt. Rock'; ?>
														<? if($sub_genre['SubGenre']['name'] == "Roots-Americana Country") $sub_genre['SubGenre']['name'] = 'Roots-Americana'; ?>
													<li><?=$this->Html->link(__($sub_genre['SubGenre']['name']), array('controller'=>'charts', 'action'=>'view', 'song', $sub_genre['SubGenre']['name'], "SubGenre"));?></li>
													<? endif; ?>
												<? endforeach; ?>
											</ul>
											<span class="clearfloats">&nbsp;</span>
											</div>
										</div>
									</li>
								</ul>
							</li>
							<li class="chart-cat">State Charts
								<!-- <ul class="drop-list state-charts">
									<li> 
										<div class="chart-nav-box-states">
											<!-- <span class="drop-list-title">- Genres -</span> 
											<div class="genre-list-container" style="height:225px; margin-bottom:10px;">
											<ul class="genre-list six">
												<? /* foreach($states as $state): ?>
													<? if($state['State']['name'] != 'Unknown' && $state['State']['name'] != 'Holiday'): ?>
													<li><?=$this->Html->link(__($state['State']['name']), array('action'=>'view', 'state', $state['State']['name'], "State"));?></li>
													<? endif; ?>
												<? endforeach; */ ?>
											</ul>
											</div>
										</div>
									</li>
								</ul> -->
							</li>
							
							<li class="chart-cat">International Charts</li>
						</ul>
						<span class="clearfloats">&nbsp;</span>
					</section>
