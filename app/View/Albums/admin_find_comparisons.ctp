<div>Please select a album you would like to compare to or skip.</div>
<div>
Current Album:<br />
<strong><?=$album['Album']['name']; ?> by <?=$album['Band']['name'];?></strong><br />
</div>

<table>
	<tr>
		<th>Album Name</th>
		<th>% Match</th>
	</tr>
<? foreach($compare_options as $option) : ?>
	<tr>
  	<td><?=$this->Html->link($option['info']['Album']['name'], array('controller' => 'Albums', 'action' => 'admin_compare', $album['Album']['id'], $option['info']['Album']['id'])); ?></td>
		<td style="color:rgba(255,0,0,1);"><?=number_format(($option['percent'] * 100),2)."% match"; ?></td>
	</tr>
<? endforeach; ?>
</table>

<?=$this->Html->link('Skip this Step',array('controller' => 'Albums', 'action' => 'admin_verify', $album['Album']['id']));