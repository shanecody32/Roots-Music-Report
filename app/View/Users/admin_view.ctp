<?// pr($band); ?>

<section id="profile">
	<h1 id="radioname"><?=$band['Band']['name'];?></span></h1>
	<p>
		<? 
			if(!empty($band['City']['name'])) echo $band['City']['name'].' - ';
			if(!empty($band['State']['name'])) echo $band['State']['name'].' - ';
			if(!empty($band['Country']['name'])) echo $band['Country']['name'];
		?>
	</p>
	<?=$this->Html->link('Edit Band', array('action'=>'admin_edit/'.$band['Band']['id'])); ?>
	<div id="images">
		<? if(!empty($band['BandImage']['id']) && file_exists(WWW_ROOT.'img'.DS.$band['BandImage']['path'].$band['BandImage']['filename'])){ ?>
		<?=$this->Image->resize($band['BandImage']['path'].$band['BandImage']['filename'], 150, 150, true, array('alt'=>'Image for '.$band['Band']['name'])); ?><br />
		<?=$this->Html->link('change image', array('controller'=>'Band_images','action'=>'admin_add/'.$band['Band']['id'])); ?>
		<? } else { ?>
		<?=$this->Image->resize('no_image.jpg', 150, 150, true, array('alt'=>'No Image for '.$band['Band']['name'])); ?><br />
		<?=$this->Html->link('add image', array('controller'=>'Band_images','action'=>'admin_add/'.$band['Band']['id'])); ?>
		<? } ?>
	</div>

	<section id="band_details">
		<h1>Band Details</h1>	
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
					$genre_count = count($album['Genre'])
				?>
				<td><? foreach($album['Genre'] as $genre): ?>
					<?=$genre['sub_genre'];?><? if($i<$genre_count) echo ','; $i++;?>
					<? endforeach; ?>
			</tr>
		<? endforeach; ?>
		</table>
		</article>
	</section>
</section>
