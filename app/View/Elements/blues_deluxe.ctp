<? //=$this->Html->script('audio.min');?>
<?=$this->Html->script('soundmanager2');?>
<?=$this->Html->script('inlineplayer'); ?>
<?=$this->Html->script('jscroller-0.4');?>

    <article id="blues-deluxe">
		<div id="sm2-container">
			<!-- SM2 flash goes here -->
		</div>
		<h1 class="hidden" hidden>Blues Deluxe</h1>
		<?=$this->Html->link($this->Html->image('blues-deluxe-logo.png', array('alt' => __('Blues Deluxe Logo', true), 'id'=>'blues-deluxe-logo')),'http://www.bluesdeluxe.com/', array('escape' => false)); ?>
		<div id="player">
			<!-- <ul id="tracks">
				<li id="track1">Part 1</li>
				<li id="track2">Part 2</li>
				<li id="track3">Part 3</li>
				<li id="track4">Part 4</li>
			</ul> -->
			<div id="scroller_container">
				<div id="scroller">
					<p>Blues Deluxe</p>
				</div>
			</div>
			<img src="img/player/play_button.png" id="play_btn"/>
			<img src="img/player/pause_button.png" id="pause_btn"/>
			<img src="img/player/stop_button.png" id="stop_btn"/>
			<img src="img/player/fwd_button.png" id="fwd_btn"/>
			<img src="img/player/back_button.png" id="back_btn"/>
			
			<!-- <img src="img/player/vb10.png" id="volumebar"/>-->
			<div id="progressbar"></div>
			<div id="time">00:00 / 00:00</div>
			
		</div>
		<script type="text/javascript">
		 $(document).ready(function() {
		  for(i = 1; i <=10; i++) {
			 $('<button/>', {
				text: i, //set text 1 to 10
				id: 'btn_'+i,
				click: function () { alert('hi'); }
			});
		  }
		});
		</script>
    </article>

