<? // pr($details); ?>
<section id="profile">
	<h1 id="bandname">Stations Playing <?=$band['Band']['name'];?> for The Week of <?=$this->Format->date($date, 'band'); ?></h1>
	<p>
		<? 
			if(!empty($band['City']['name'])) echo $band['City']['name'].' - ';
			if(!empty($band['State']['name'])) echo $band['State']['name'].' - ';
			if(!empty($band['Country']['name'])) echo $band['Country']['name'];
		?>
	</p>
	<div id="images">
		<? if(!empty($band['BandImage'][0]['id']) && file_exists(WWW_ROOT.'img'.DS.$band['BandImage'][0]['path'].$band['BandImage'][0]['filename'])){ ?>
			<?=$this->Image->resize($band['BandImage'][0]['path'].$band['BandImage'][0]['filename'], 150, 150, true, array('alt'=>'Image for '.$band['Band']['name'])); ?><br />
		<? } else { ?>
			<?=$this->Image->resize('no_image.jpg', 150, 150, true, array('alt'=>'No Image for '.$band['Band']['name'])); ?><br />
		<? } ?>
	</div>

	<section id="band_details">
	<h2 class="hidden">Details for <?=$band['Band']['name'];?></h2>
		<? if(!empty($band['BandLink'])): ?>
<article id="links">
			<h3>Links</h3>			
<table>
			<? foreach($band['BandLink'] as $link): ?>
				<tr>
					<td><?=Inflector::humanize($link['type']);?> - <?=$this->Link->$link['type']($link['link'], 'link', '', '_blank'); ?></td>
					<td><?=$this->Html->link('edit',array('controller'=>'band_links', 'action'=>'admin_edit/'.$link['id'])); ?></td>
					<td><?=$this->Html->link(__('delete'), array('controller'=>'band_links','action' => 'admin_delete', $link['id']), null, sprintf(__('Are you sure you want to delete the link to '.$link['link'].'?'), $link['id'])); ?></td>
				</tr>
			<? endforeach; ?>
			</table>
		<? endif; ?>
	</section>
</section>
<section id="band-totals">
	<h2></h2>
</section>