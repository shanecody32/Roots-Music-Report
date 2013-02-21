<?php
class RadioStationPlaylist extends AppModel {
	var $name = 'RadioStationPlaylist';
	var $displayField = 'spins';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'RadioStation' => array(
			'className' => 'RadioStation',
			'foreignKey' => 'radio_station_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Song' => array(
			'className' => 'Song',
			'foreignKey' => 'song_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Album' => array(
			'className' => 'Album',
			'foreignKey' => 'album_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Band' => array(
			'className' => 'Band',
			'foreignKey' => 'band_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	function add_to_list($data = false, $radio_id = 0, $overwrite = true){
		if(!$data){
			return false;
		}

		$data['radio_station_id'] = $radio_id;
		
		$result = $this->find('first',array(
			'conditions' => array(
				$this->alias.'.radio_station_id' => $data['radio_station_id'],
				$this->alias.'.song_id' => $data['song_id'],
				$this->alias.'.band_id' => $data['band_id'],
				$this->alias.'.album_id' => $data['album_id'],
			)
		));
		
		if(!$result){
			unset($this->id);
			unset($data['id']);
			$result = $this->save($data);
		} elseif($overwrite == false){
			$data['id'] = $result[$this->alias]['id'];
			$data['spins'] = $result[$this->alias]['spins'] + $data['spins'];
			return $this->save($data);
		} else {
			$data['id'] = $result[$this->alias]['id'];
			return $this->save($data);
		}
		return $result;

	}

	function new_to_playlist($data = null){
		$error = false;
		$band_model = ClassRegistry::init('Band');
		$band = $band_model->add($data['Band'], 'name');
		if(!$band){
			$error = true;
		}
		
		if($data['Album']['compilation']){
			$band_id = 1;
		} elseif($data['Album']['soundtrack']){
			$band_id = 2;
		} else {
			$band_id = $band['Band']['id'];
		}
		
		if(isset($band_id)){
			$data['Song']['band_id'] = $band_id;
		} else {
			$data['Song']['band_id'] = '';
		}
		
		if(empty($data['Song']['sub_genre_id'])){
			$data['Song']['sub_genre_id'] = '32';
		}
		
		$song_model = ClassRegistry::init('Song');
		$song = $song_model->add($data['Song'], array('name','band_id'), $data['Band']['name']);
		if(!$song){
			$error = true;
		}

		$song_stat_model = ClassRegistry::init('SongStat');
		$sStat['song_id'] = $song['Song']['id'];
		if(!$song_stat_model->add($sStat, 'song_id')){
			echo 'Error SongStat';
		}
		
		if(!empty($data['Band']['name']) && !empty($data['Song']['name'])){
			$label_model = ClassRegistry::init('Label');
			if(empty($data['Label']['name'])){
				$data['Label']['name'] = 'Unknown';
			}
			$label = $label_model->add($data['Label'], 'name');

			
				
			$data['Album']['band_id'] = $band_id;
			$data['Album']['label_id'] = $label['Label']['id'];
			$data['Album']['song_id'] = $song['Song']['id'];
			
			$data['Album']['sub_genre_id'] = $data['Song']['sub_genre_id'];

			$album_model = ClassRegistry::init('Album');
			if(empty($data['Album']['name'])){
				$data['Album']['name'] = 'Unknown';
			}
			$album = $album_model->add($data['Album'], array('name','band_id'), $data['Band']['name']);
			if(!$album['Album']['sub_genre_for_charting']){
				$album['Album']['sub_genre_for_charting'] = $data['Song']['sub_genre_id'];
				$album_model->save($album);
			}

			$album_stat_model = ClassRegistry::init('AlbumStat');
			$aStat['album_id'] = $album['Album']['id'];
			if(!$album_stat_model->add($aStat, 'album_id')){
				echo 'Error AlbumStat';
			}
			
			// associate data
			$album_song_model = ClassRegistry::init('AlbumTrack');
			$album_song_model->create($album['Album']['id'], $song['Song']['id']);
		}

		if(!empty($data['Band']['name']) && !empty($data['Song']['name'])){
			$band_model->add_genre($band['Band']['id'],$song['Song']['sub_genre_id']);
			$album_model->add_genre($album['Album']['id'],$song['Song']['sub_genre_id']);
		}

		if(!$error){
			$playlist['radio_station_id'] = $data['RadioStationPlaylist']['radio_station_id'];
			$playlist['band_id'] = $band['Band']['id'];
			$playlist['album_id'] = $album['Album']['id'];
			$playlist['song_id'] = $song['Song']['id'];
			$playlist['spins'] = $data['RadioStationPlaylist']['new_spins'];
			$this->add_to_list($playlist, $playlist['radio_station_id']);
			$radio_model = ClassRegistry::init('RadioStation');
			$radio = $radio_model->reported_toggle($data['RadioStationPlaylist']['radio_station_id']);			
		}
		
	}

	function save_spins($data = null){
		if(!$data){
			return false;
		}
		$count = $this->find('count', array('conditions'=>array('radio_station_id'=>$data['RadioStationPlaylist']['radio_station_id'])));
		if($count <= 0){
			return false;
		}
		if(isset($data['RadioStationPlaylist']['spins'])){
			foreach($data['RadioStationPlaylist']['spins'] as $key => $value){
				if($value != $data['RadioStationPlaylist']['origSpins'][$key]){
					$listItem = $this->findById($key);
					$listItem['RadioStationPlaylist']['spins'] = $value;
					$this->save($listItem);
				}
			}
		}
	}

	function finalise_toggle($radio_id){
		$radio_station_model = ClassRegistry::init('RadioStation');
		return $radio_station_model->finalise_toggle($radio_id);
	}

	function unset_form_data(){
		$data['Band']['name'] = '';
		$data['Song']['name'] = '';
		$data['Album']['name'] = '';
		$data['Label']['name'] = '';
		$data['Song']['genre_id'] = '';
		$data['Album']['compilation'] = '';
		$data['Album']['soundtrack'] = '';
	}

	function remove_entry($data = Null){
		if(!$data){
			return false;
		}

		foreach($data['RadioStationPlaylist']['checks'] as $key => $entry){
			if($entry){
				$this->delete($key);
			}
		}
		return true;
	}

	function process_playlist($data = Null){
		if(!$data){
			return false;
		}

		$file_handle = fopen($data['RadioStationPlaylist']['file']['tmp_name'], "r");
		while(!feof($file_handle)){
		   $line = fgetcsv($file_handle);
 
		   if(strtolower($line[0]) != 'artist'){
			   $data['Band']['name'] = $line[0];
			   $data['Song']['name'] = $line[1];
			   $data['Album']['name'] = $line[2];
			   $data['Label']['name'] = $line[3];
			   $data['Genre']['name'] = $line[4];
			   $data['RadioStationPlaylist']['new_spins'] = $line[5];
			   $this->new_to_playlist($data);
		   }
		}
		fclose($file_handle);

	}
	
	function update_entry($id, $band_id = false, $album_id = false, $song_id = false, $radio_id = false){
		$entry = $this->find('first', $id);
		$change_made = 0;
		if($entry['RadioStationPlaylist']['band_id'] != $band_id){
			$entry['RadioStationPlaylist']['band_id'] = $band_id;
			$change_made = 1;
		}
		if($entry['RadioStationPlaylist']['album_id'] != $album_id){
			$entry['RadioStationPlaylist']['album_id'] = $album_id;
			$change_made = 1;
		}
		if($entry['RadioStationPlaylist']['song_id'] != $song_id){
			$entry['RadioStationPlaylist']['song_id'] = $song_id;
			$change_made = 1;
		}
		if($entry['RadioStationPlaylist']['radio_station_id'] != $radio_id){
			$entry['RadioStationPlaylist']['radio_station_id'] = $radio_id;
			$change_made = 1;
		}
		if($change_made == 1){
			$this->save($entry['RadioStationPlaylist']);
		}
		
		$this->duplicate_check($entry);
		
		return $entry;
	}
	
	function duplicate_check($entry){
		if($entry){
			$duplicate = $this->find('first', array(
				'conditions' => array(
					$this->alias.'.band_id' => $entry[$this->alias]['band_id'],
					$this->alias.'.album_id' => $entry[$this->alias]['album_id'],
					$this->alias.'.song_id' => $entry[$this->alias]['song_id'],
					$this->alias.'.radio_station_id' => $entry[$this->alias]['radio_station_id'],
					$this->alias.'.id NOT' => $entry[$this->alias]['id']
				),
			));
			
			if(!$duplicate){
				return false;
			} else {
				$this->delete($duplicate[$this->alias]['id']);
				return true;
			}
		}
	}
	
	function delete_entire_playlist($id = 0){
		return $this->deleteAll(array(
			'radio_station_id' => $id, 
		));
	}
	
}
?>