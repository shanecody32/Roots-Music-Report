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
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
		<?=$this->Html->charset(); ?>
		<title>
			<?=$cakeDescription ?>:
			<?=$title_for_layout; ?>
		</title>
		<?
			echo $this->Html->meta('icon');
			echo $this->fetch('meta');
			
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
		?>
	</head>
	<body>
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
                	
					<?=$this->Session->flash(); ?>
					<?php echo $content_for_layout; ?>
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
						//echo $this->element('sql_dump');
						//echo $this->Js->writeBuffer();
					?><div class="clearfloats">&nbsp;</div>
				</footer>
			</div>
		</div>
	</body>
</html>