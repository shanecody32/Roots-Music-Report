<div>Please select a album you would like to compare to or skip.</div>
<div>
Current Radio Station:<br />
<strong><?=$radio_station['RadioStation']['name'];?><br />
		<span class="smaller"><?=Inflector::humanize($radio_station['RadioStation']['type']);?></span></strong><br />
</div>

<table>
	<tr>
		<th>Album Name</th>
		<th>% Match</th>
	</tr>
<? foreach($compare_options as $option) : ?>
	<tr>
  	<td><?=$this->Html->link($option['info']['RadioStation']['name'], array('controller' => 'RadioStations', 'action' => 'admin_compare', $radio_station['RadioStation']['id'], $option['info']['RadioStation']['id'])); ?></td>
		<td style="color:rgba(255,0,0,1);"><?=number_format(($option['percent'] * 100),2)."% match"; ?></td>
	</tr>
<? endforeach; ?>
</table>

<?=$this->Html->link('Skip this Step',array('controller' => 'RadioStations', 'action' => 'admin_verify', $radio_station['RadioStation']['id']));