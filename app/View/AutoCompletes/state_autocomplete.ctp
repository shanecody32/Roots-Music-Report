<?php
/*<ul>
<? foreach($bands as $band): ?>
	<li><?=$band['Band']['name'];?></li>
<? endforeach; ?>
</ul>
	*/

   // print_r($songs);
$data = array();
foreach($states as $state){

    $data[] = array(
	   'name'=>$state['State']['name'],
    );
}
echo json_encode($data);

?>