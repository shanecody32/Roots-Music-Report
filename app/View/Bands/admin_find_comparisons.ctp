<div>Please select a artist/band you would like to compare to or skip.</div>
<div>
Current Band:<br />
<strong><?=$band['Band']['name']; ?></strong><br />
</div>

<table>
    <tr>
  	<th>Band Name</th>
	   <th>% Match</th>
    </tr>
<? foreach($compare_options as $option) : ?>
    <tr>
  	<td><?=$this->Html->link($option['info']['Band']['name'], array('controller' => 'Bands', 'action' => 'admin_compare', $band['Band']['id'], $option['info']['Band']['id'])); ?></td>
	   <td style="color:rgba(255,0,0,1);"><?=number_format(($option['percent'] * 100),2)."% match"; ?></td>
    </tr>
<? endforeach; ?>
</table>

<?=$this->Html->link('Skip this Step',array('controller' => 'Bands', 'action' => 'admin_verify', $band['Band']['id']));