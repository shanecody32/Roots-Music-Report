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
	<meta property="og:description" content="Album Review of This guy" />
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
			echo $this->Html->css('main');
			echo $this->Html->css('chart-bar');
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
					<?=$this->element('chart-bar');?>
					<section id="nav-column">
						<?=$this->element('nav');?>
						<aside id="side-ad">
						<!-- <?=$this->Html->image('advertisments/text-ads-250x250.png', array('alt' => __('Advertisements', true), 'id'=>'ad-200x200')); ?> -->
						<?=$this->Html->image('advertisments/ad-video-300x250.jpg', array('alt' => __('Advertisements', true), 'id'=>'ad-200x200')); ?>
						<?=$this->Html->image('advertisments/ad-image-300x250.jpg', array('alt' => __('Advertisements', true), 'id'=>'ad-200x200')); ?>
						</aside>
					</section>
					<div id="content">
						<aside id="top-banner-ad">
							<?=$this->Html->image('advertisments/prweb.gif', array('alt'=>'Advertisment', 'id'=>'top-ad-728x90')); ?>
						</aside>
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