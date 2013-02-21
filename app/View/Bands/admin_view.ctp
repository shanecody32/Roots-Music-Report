<? // pr($band); ?>

<section id="profile">
	<h1 id="bandname"><?=$band['Band']['name'];?></h1>
	<p>
		<? 
			if(!empty($band['City']['name'])) echo $band['City']['name'].' - ';
			if(!empty($band['State']['name'])) echo $band['State']['name'].' - ';
			if(!empty($band['Country']['name'])) echo $band['Country']['name'];
		?>
	</p>
	<?=$this->Html->link('edit band', array('action'=>'admin_edit/'.$band['Band']['id'])); ?>
	<div id="images">
		<? if(!empty($band['BandImage'][0]['id']) && file_exists(WWW_ROOT.'img'.DS.$band['BandImage'][0]['path'].$band['BandImage'][0]['filename'])){ ?>
			<?=$this->Image->resize($band['BandImage'][0]['path'].$band['BandImage'][0]['filename'], 150, 150, true, array('alt'=>'Image for '.$band['Band']['name'])); ?><br />
			<?=$this->Html->link('change main image', array('controller'=>'band_images','action'=>'admin_add/'.$band['Band']['id'])); ?>
		<? } else { ?>
			<?=$this->Image->resize('no_image.jpg', 150, 150, true, array('alt'=>'No Image for '.$band['Band']['name'])); ?><br />
			<?=$this->Html->link('add main image', array('controller'=>'band_images','action'=>'admin_add/'.$band['Band']['id'])); ?>
		<? } ?>
	</div>

	<section id="band_details">
		<h1>Band Details</h1>
		<? if(!empty($band['BandDetail'])){
			echo $this->Html->link('edit band details', array('controller'=>'band_details', 'action'=>'admin_edit/'.$band['BandDetail']['id']));
		} else {
			echo $this->Html->link('edit band details', array('controller'=>'band_details', 'action'=>'admin_add/'.$band['Band']['id']));
		} ?>
		<article id="links">
			<h3>Links</h3>
			<?=$this->Html->link('add new',array('controller'=>'band_links', 'action'=>'admin_add/'.$band['Band']['id'])); ?>
			<table>
			<? foreach($band['BandLink'] as $link): ?>
				<tr>
					<td><?=Inflector::humanize($link['type']);?> - <?=$this->Link->$link['type']($link['link'], 'link', '', '_blank'); ?></td>
					<td><?=$this->Html->link('edit',array('controller'=>'band_links', 'action'=>'admin_edit/'.$link['id'])); ?></td>
					<td><?=$this->Html->link(__('delete'), array('controller'=>'band_links','action' => 'admin_delete', $link['id']), null, sprintf(__('Are you sure you want to delete the link to '.$link['link'].'?'), $link['id'])); ?></td>
				</tr>
			<? endforeach; ?>
			</table>
		</article>
		<article id="discography">
		<h1>Discography</h1>
		<?=$this->Html->link('add album', array('controller'=>'albums', 'action'=>'admin_add'.DS.$band['Band']['id'])); ?>
		<table>
			<tr>
				<th>Album Title</th>
				<th>Genres on Album</th>
			</tr>
		<? foreach($band['Album'] as $album): ?>
			<tr>
				<td><?=$this->Html->link($album['name'], array('controller'=>'albums', 'action'=>'admin_view'.DS.$album['id'])); ?></td>
				<? 
					$i = 1;
					$genre_count = count($album['SubGenre'])
				?>
				<td><? foreach($album['SubGenre'] as $genre): ?>
					<?=$genre['name'];?><? if($i<$genre_count) echo ','; $i++;?>
					<? endforeach; ?>
			</tr>
		<? endforeach; ?>
		</table>
		</article>
	</section>
</section>
