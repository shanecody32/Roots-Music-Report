<?php
/*<ul>
<? foreach($bands as $band): ?>
	<li><?=$band['Band']['name'];?></li>
<? endforeach; ?>
</ul>
	*/


$data = array();
$i = 0;
foreach($bands as $band){
	$data[$i] = array(
		'id' => $band['Band']['id'], 
		'name' => $band['Band']['name']
	);
	$data[$i]['album'] = $band['Album'];
	$i++;
}

echo json_encode($data);

?>