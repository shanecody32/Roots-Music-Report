<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('roots_music_report', 'Roots Music Report: Music charts for all genres with the independant in mind.');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?=$this->Html->charset(); ?>
		<title>
			<?=$cakeDescription ?>:
			<?=$title_for_layout; ?>
		</title>
		<?
			echo $this->Html->meta('icon');
			echo $this->fetch('meta');
			?>
<meta property="fb:app_id" content="351378348303485"/>
<? if(!isset($facebook['title'])){ ?>
	<meta property="og:title" content="Roots Music report" />
<? } else { ?>
	<meta property="og:title" content="<?=$facebook['title']; ?>" />
<? } ?>
<meta property="og:type" content="article" />
<meta property="og:url" content="<?=str_replace('rmr_test/rmr_test/', 'rmr_test/', Router::url($this->here, true));?>" />
<? if(!isset($facebook['image'])){ ?>
	<meta property="og:image" content="http://www.rootsmusicreport.com/rmr_test/img/rmr_logo_for_social.png" />
<? } else { ?>
	<meta property="og:image" content="<?=$facebook['image']; ?>" />
<? } ?>

<meta property="og:site_name" content="Roots Music Report" />
<? if(!isset($facebook['description'])){ ?>
	<meta property="og:description" content="Radio Air-play Charts, Reviews, and More" />
<? } else { ?>
	<meta property="og:description" content="<?=$facebook['description']; ?>" />
<? } ?>


<?
			
			if(isset($keys_for_layout)){
				echo $this->Html->meta('keywords',$keys_for_layout);
			}
			if(isset($desc_for_layout)){
				echo $this->Html->meta('description',$desc_for_layout);
			}
			
			//echo $this->Html->css('cake.generic');
			echo $this->Html->css('jquery-ui-1.8.20.custom');
			echo $this->Html->css('back-end');
			if(isset($styles)){
				foreach($styles as $style){
					echo $this->Html->css($style);
				};
			}
			if(!$this->Session->check('Auth.User.id')){
				echo $this->Html->css('login');
			}
			
			// echo $this->Html->css('forms')
			echo $this->Html->script('html5-shiv');
			echo $this->Html->script('jquery-1.7.2.min');
			echo $this->Html->script('jquery-ui-1.8.20.custom.min');
			echo $this->Html->script('jquery.easing.1.3');
			echo $this->Html->script('menu');
			if(isset($scripts)){
				foreach($scripts as $script){
					echo $this->Html->script($script);
				};
			}
			if(isset($off_site_script)){
				foreach($off_site_script as $script){
					echo '<script type="text/javascript" src="'.$script.'"></script>';
				}
			}
		?>
	</head>
	<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=351378348303485";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

		<header id="header">
			<?=$this->Html->link($this->Html->image('roots_music_report_logo.png', array('alt' => __('Roots Music Report Logo', true), 'id'=>'header-logo')),'http://www.rootsmusicreport.com/rmr_test/', array('escape' => false)); ?>
			<h1 class="hidden" hidden>Roots Music Report</h1>
			<? if($this->Session->check('Auth.User.id')){
				echo $this->element('logged_in');
			} else {
				echo $this->element('login');
			}
			?>
			<?=$this->element('top-nav'); ?>
		</header>
		<div id="bg-wrap">
			<div id="container">
				<div id="content-area">
					<section id="nav-column">
						<script language="javascript">
	$(function() {
		$( "ul#nav" ).accordion();
	});
</script>

<ul id='nav'>
	<li><h3>Albums</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'albums', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Compare', array('controller'=>'albums', 'action'=>'compare', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'albums', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Find Comparisons - first link in verify chain', array('controller'=>'albums', 'action'=>'find_comparisons', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Merge', array('controller'=>'albums', 'action'=>'merge', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Track Order', array('controller'=>'albums', 'action'=>'track_order', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Verify', array('controller'=>'albums', 'action'=>'', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View', array('controller'=>'albums', 'action'=>'view', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View All - Should change to Search', array('controller'=>'albums', 'action'=>'view_all', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View Unapproved - Change to Search', array('controller'=>'albums', 'action'=>'view_unapproved', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View Unverified', array('controller'=>'albums', 'action'=>'view_unverified', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Search', array('controller'=>'albums', 'action'=>'search', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Articles</h3>
		<ul>
			<li><?=$this->Html->link('Add', array('controller'=>'articles', 'action'=>'add', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Admin Approve', array('controller'=>'articles', 'action'=>'approve', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View Unapproved', array('controller'=>'articles', 'action'=>'unapproved', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Edit', array('controller'=>'articles', 'action'=>'edit', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Index', array('controller'=>'articles', 'action'=>'index', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Search', array('controller'=>'articles', 'action'=>'search', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('View', array('controller'=>'articles', 'action'=>'view', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Band Details</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'band_details', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'band_details', 'action'=>'edit', 'admin'=>true)); ?></li>
		</ul>
	</li>
	<li><h3>Band Images</h3>
		<ul>
			<li><?=$this->Html->link('Add', array('controller'=>'band_images', 'action'=>'add', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'band_images', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'band_images', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Index', array('controller'=>'band_images', 'action'=>'index', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View', array('controller'=>'band_images', 'action'=>'view', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Edit', array('controller'=>'band_images', 'action'=>'edit', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Index', array('controller'=>'band_images', 'action'=>'index', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('View', array('controller'=>'band_images', 'action'=>'view', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Band Links</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'band_links', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'band_links', 'action'=>'edit', 'admin'=>true)); ?></li>
		</ul>
	</li>
	<li><h3>Bands</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'bands', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Verify Chain', array('controller'=>'bands', 'action'=>'find_comparisons', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Convert From Roots', array('controller'=>'bands', 'action'=>'convert_from_roots', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'bands', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Index', array('controller'=>'bands', 'action'=>'index', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Search', array('controller'=>'bands', 'action'=>'search', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View', array('controller'=>'bands', 'action'=>'view', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View All', array('controller'=>'bands', 'action'=>'view_all', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View Unapproved', array('controller'=>'bands', 'action'=>'view_unapproved', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View Unverified', array('controller'=>'bands', 'action'=>'view_unverified', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Search', array('controller'=>'bands', 'action'=>'search', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Stations Playing', array('controller'=>'bands', 'action'=>'stations_playing', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Stations Playing by Week', array('controller'=>'bands', 'action'=>'stations_playing_by_week', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('View Reporters Playing by Week', array('controller'=>'bands', 'action'=>'view_reporters_playing_by_week', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Categories</h3>
		<ul>
			<li><?=$this->Html->link('Add', array('controller'=>'categories', 'action'=>'add', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Edit', array('controller'=>'categories', 'action'=>'edit', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('View All', array('controller'=>'categories', 'action'=>'view_all', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Chart Functions</h3>
		<ul>
			<li><?=$this->Html->link('Admin Radio From Staff Playlists', array('controller'=>'chart_functions', 'action'=>'radio_from_staff_playlists', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Album Genre Temp Chart', array('controller'=>'chart_functions', 'action'=>'album_genre_temp_chart', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Album Sub-Genre Temp Chart', array('controller'=>'chart_functions', 'action'=>'album_sub_genre_temp_chart', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Check Finalized', array('controller'=>'chart_functions', 'action'=>'check_finalized', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Check Not Reported', array('controller'=>'chart_functions', 'action'=>'check_not_reported', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Import RMR Reporters', array('controller'=>'chart_functions', 'action'=>'import_rmr_reporters', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Index', array('controller'=>'chart_functions', 'action'=>'index', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Song Genre Temp Chart', array('controller'=>'chart_functions', 'action'=>'song_genre_temp_chart', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Song Sub-Genre Temp Chart', array('controller'=>'chart_functions', 'action'=>'song_sub_genre_temp_chart', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Temp Chart', array('controller'=>'chart_functions', 'action'=>'temp_chart', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('View Temp Charts', array('controller'=>'chart_functions', 'action'=>'view_temp_chrts', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Charts</h3>
		<ul>
			<li><?=$this->Html->link('Index', array('controller'=>'charts', 'action'=>'index', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Show Charts', array('controller'=>'charts', 'action'=>'show_charts', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('View', array('controller'=>'charts', 'action'=>'view', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Genres</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'genres', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'genres', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View All', array('controller'=>'genres', 'action'=>'view_all', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('View All', array('controller'=>'genres', 'action'=>'view_all', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Groups</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'groups', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'groups', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View', array('controller'=>'groups', 'action'=>'view', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View All', array('controller'=>'groups', 'action'=>'view_all', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Index', array('controller'=>'groups', 'action'=>'index', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Radio Addresses</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'radio_addresses', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'radio_addresses', 'action'=>'edit', 'admin'=>true)); ?></li>
		</ul>
	</li>
	<li><h3>Radio Links</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'radio_links', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'radio_links', 'action'=>'edit', 'admin'=>true)); ?></li>
		</ul>
	</li>
	<li><h3>Radio Phone Numbers</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'radio_phone_numbers', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'radio_phone_numbers', 'action'=>'edit', 'admin'=>true)); ?></li>
		</ul>
	</li>
	<li><h3>Radio Staff Images</h3>
		<ul>
			<li><?=$this->Html->link('Add', array('controller'=>'radio_staff_images', 'action'=>'add', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'radio_staff_images', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'radio_staff_images', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Index', array('controller'=>'radio_staff_images', 'action'=>'index', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View', array('controller'=>'radio_staff_images', 'action'=>'view', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Edit', array('controller'=>'radio_staff_images', 'action'=>'edit', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Index', array('controller'=>'radio_staff_images', 'action'=>'index', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('View', array('controller'=>'radio_staff_images', 'action'=>'view', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Radio Staff Links</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'radio_staff_links', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'radio_staff_links', 'action'=>'edit', 'admin'=>true)); ?></li>
		</ul>
	</li>
	<li><h3>Radio Staff Members</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'radio_staff_members', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Add Violation', array('controller'=>'radio_staff_members', 'action'=>'add_violation', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Verify', array('controller'=>'radio_staff_members', 'action'=>'admin_verify', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View', array('controller'=>'radio_staff_members', 'action'=>'view', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View All', array('controller'=>'radio_staff_members', 'action'=>'view_all', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View By Radio', array('controller'=>'radio_staff_members', 'action'=>'view_by_radio', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View Unapproved', array('controller'=>'radio_staff_members', 'action'=>'view_unapproved', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View Unverified', array('controller'=>'radio_staff_members', 'action'=>'view_unverified', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Import RMR Reporters', array('controller'=>'radio_staff_members', 'action'=>'import_rmr_reporters', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Index', array('controller'=>'radio_staff_members', 'action'=>'index', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Main', array('controller'=>'radio_staff_members', 'action'=>'main', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Search', array('controller'=>'radio_staff_members', 'action'=>'search', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Thanks', array('controller'=>'radio_staff_members', 'action'=>'thanks', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('View', array('controller'=>'radio_staff_members', 'action'=>'view', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('View by Radio', array('controller'=>'radio_staff_members', 'action'=>'view_by_radio', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Radio Staff Playlist Archives</h3>
		<ul>
			<li><?=$this->Html->link('View', array('controller'=>'radio_staff_playlist_archives', 'action'=>'view', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Radio Staff Playlists</h3>
		<ul>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'radio_staff_playlists', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Upload Playlist', array('controller'=>'radio_staff_playlists', 'action'=>'upload_playlist', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Upload Uncompiled Playlist', array('controller'=>'radio_staff_playlists', 'action'=>'upload_uncompiled_playlist', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View', array('controller'=>'radio_staff_playlists', 'action'=>'view', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Edit', array('controller'=>'radio_staff_playlists', 'action'=>'edit', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Import RMR Spins', array('controller'=>'radio_staff_playlists', 'action'=>'import_rmr_spins', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Playlist Quick Check', array('controller'=>'radio_staff_playlists', 'action'=>'playlist_quick_check', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Search Bands', array('controller'=>'radio_staff_playlists', 'action'=>'search_bands', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('View', array('controller'=>'radio_staff_playlists', 'action'=>'view', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Radio Station Images</h3>
		<ul>
			<li><?=$this->Html->link('Add', array('controller'=>'radio_station_images', 'action'=>'add', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'radio_station_images', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'radio_station_images', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Index', array('controller'=>'radio_station_images', 'action'=>'index', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View', array('controller'=>'radio_station_images', 'action'=>'view', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Edit', array('controller'=>'radio_station_images', 'action'=>'edit', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Index', array('controller'=>'radio_station_images', 'action'=>'index', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('View', array('controller'=>'radio_station_images', 'action'=>'view', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Radio Station Playlists</h3>
		<ul>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'radio_staff_playlists', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View', array('controller'=>'radio_staff_playlists', 'action'=>'view', 'admin'=>true)); ?></li>
		</ul>
	</li>
	<li><h3>Radio Stations</h3>
		<ul>
			<li><?=$this->Html->link('Admin Create', array('controller'=>'radio_stations', 'action'=>'create', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'radio_stations', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Index', array('controller'=>'radio_stations', 'action'=>'index', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Search', array('controller'=>'radio_stations', 'action'=>'search', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Admin Verify', array('controller'=>'radio_stations', 'action'=>'admin_verify', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View', array('controller'=>'radio_stations', 'action'=>'view', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View All', array('controller'=>'radio_stations', 'action'=>'view_all', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View Unapproved', array('controller'=>'radio_stations', 'action'=>'view_unapproved', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View Unverified', array('controller'=>'radio_stations', 'action'=>'view_unverified', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Application', array('controller'=>'radio_stations', 'action'=>'application', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Edit', array('controller'=>'radio_stations', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Import RMR Reporters', array('controller'=>'radio_stations', 'action'=>'import_rmr_reporters', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Index', array('controller'=>'radio_stations', 'action'=>'index', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Search', array('controller'=>'radio_stations', 'action'=>'search', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Thanks', array('controller'=>'radio_stations', 'action'=>'thanks', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('View', array('controller'=>'radio_stations', 'action'=>'view', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Reviews</h3>
		<ul>
			<li><?=$this->Html->link('Add', array('controller'=>'reviews', 'action'=>'add', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'reviews', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Approve', array('controller'=>'reviews', 'action'=>'approve', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Search', array('controller'=>'reviews', 'action'=>'search', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Approve', array('controller'=>'reviews', 'action'=>'approve', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Edit', array('controller'=>'reviews', 'action'=>'edit', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Search', array('controller'=>'reviews', 'action'=>'search', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('View', array('controller'=>'reviews', 'action'=>'view', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Songs</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'songs', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'songs', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Verify', array('controller'=>'songs', 'action'=>'admin_verify', 'admin'=>true)); ?></li>
		</ul>
	</li>
	<li><h3>States</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'states', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'states', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View All', array('controller'=>'states', 'action'=>'view_all', 'admin'=>true)); ?></li>
		</ul>
	</li>
	<li><h3>Sub Genres</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'sub_genres', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'sub_genres', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View All', array('controller'=>'sub_genres', 'action'=>'view_all', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('View All', array('controller'=>'sub_genres', 'action'=>'view_all', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>System Notes</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'system_notes', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'system_notes', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View', array('controller'=>'system_notes', 'action'=>'view', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View All', array('controller'=>'system_notes', 'action'=>'view_all', 'admin'=>true)); ?></li>
		</ul>
	</li>
	<li><h3>Tags</h3>
		<ul>
			<li><?=$this->Html->link('View', array('controller'=>'tags', 'action'=>'view', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Users</h3>
		<ul>
			<li><?=$this->Html->link('Account', array('controller'=>'users', 'action'=>'account', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Activate', array('controller'=>'users', 'action'=>'activate', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Add', array('controller'=>'users', 'action'=>'add', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'users', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'users', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View', array('controller'=>'users', 'action'=>'view', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View All', array('controller'=>'users', 'action'=>'view_all', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('edit', array('controller'=>'users', 'action'=>'edit', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('index', array('controller'=>'users', 'action'=>'index', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('login', array('controller'=>'users', 'action'=>'login', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('payment', array('controller'=>'users', 'action'=>'payment', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('register', array('controller'=>'users', 'action'=>'register', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('thanks', array('controller'=>'users', 'action'=>'thanks', 'admin'=>false)); ?></li>
			<li><?=$this->Html->link('Verify Email', array('controller'=>'users', 'action'=>'verify_email', 'admin'=>false)); ?></li>
		</ul>
	</li>
	<li><h3>Violations</h3>
		<ul>
			<li><?=$this->Html->link('Admin Add', array('controller'=>'violations', 'action'=>'add', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin Edit', array('controller'=>'violations', 'action'=>'edit', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View', array('controller'=>'violations', 'action'=>'view', 'admin'=>true)); ?></li>
			<li><?=$this->Html->link('Admin View All', array('controller'=>'violations', 'action'=>'view_all', 'admin'=>true)); ?></li>
		</ul>
	</li>
</ul>
					</section>
					<div id="content">
						<?=$this->Session->flash(); ?>
						<div id="normal-content">
							<?php echo $content_for_layout; ?>
						</div>
					</div>
					<div class="clearfloats">&nbsp;</div>
				</div>
				<footer id="footer">
					<h2 class="hidden">Site Footer</h2>
					<?=$this->element('bot-nav'); ?>
					<div id="footer-info">
						© <?=date('Y'); ?> Roots Music Report All Rights Reserved<br />
						Sign up to receive our monthly newsletters and more.<br />
						Privacy Policy<br />
						Site Design by: Crooked Comma Designs<br />
						Download Blues Deluxe
					</div>
					<?
						echo $this->element('sql_dump');
						echo $this->Js->writeBuffer();
					?><div class="clearfloats">&nbsp;</div>
				</footer>
			</div>
		</div>
	</body>
</html>