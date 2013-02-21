<?php
/*<ul>
<? foreach($bands as $band): ?>
	<li><?=$band['Band']['name'];?></li>
<? endforeach; ?>
</ul>
	*/


$data = array();
foreach($albums as $album)
	$data[] = array(
		  'id'=>$album['Album']['id'],
		  'name'=>$album['Album']['name'],
		  'lab'=>$album['Label']['name']
	   );

echo json_encode($data);