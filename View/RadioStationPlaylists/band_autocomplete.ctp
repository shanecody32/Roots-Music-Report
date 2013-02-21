<?php
/*<ul>
<? foreach($bands as $band): ?>
	<li><?=$band['Band']['name'];?></li>
<? endforeach; ?>
</ul>
	*/


$data = array();
foreach($bands as $bid => $bname)
	$data[] = array('id'=>$bid, 'name'=>$bname);

echo json_encode($data);

?>