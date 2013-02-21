<?php
/*<ul>
<? foreach($bands as $band): ?>
	<li><?=$band['Band']['name'];?></li>
<? endforeach; ?>
</ul>
	*/

   // print_r($songs);
$data = array();
foreach($songs as $song){

    $data[] = array(
	   'id'=>$song['Song']['id'],
	   'name'=>$song['Song']['name'],
	   'album'=>$song['Album'][0]['name'],
	   'genre'=>$song['SubGenre']['id'],
	   'genre_name'=>$song['SubGenre']['name'],
	   'lab'=>$song['Album'][0]['Label']['name'],
	   'compilation'=>$song['Album'][0]['compilation'],
	   'soundtrack'=>$song['Album'][0]['soundtrack'],
    );
}
echo json_encode($data);

?>