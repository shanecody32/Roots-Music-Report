<?php
class RadioStaffPlaylist extends AppModel {
	var $name = 'RadioStaffPlaylist';
	var $displayField = 'spins';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'RadioStaffMember' => array(
			'className' => 'RadioStaffMember',
			'foreignKey' => 'radio_staff_member_id',
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
	
	var $file_types = array('.csv');
	
	function check_file_type($file = Null){
		if($file){
			$length = strlen($file['name']);
			$characters = 4;
			$start = $length - $characters;
			$file_ext = substr($file['name'] , $start ,$characters);
			foreach($this->file_types as $type){
				if(strtolower($file_ext) == $type){
					return true;
				}
			}
		}
		return false;
	}
	
	function process_file($file = Null){
		set_time_limit('15000');
		if($file){
			$file_handle = fopen($file['tmp_name'], "r");
			$i = 0;
			$data = array();
			$staff_model = ClassRegistry::init('RadioStaffMember');
			$sub_genre_model = ClassRegistry::init('SubGenre');
			while(!feof($file_handle)){
				$line = fgetcsv($file_handle);
				if($line[1] != 0){
					$staff = $staff_model->findByOrigUsername($this->cleanIt($line[0]));
					if($staff['RadioStaffMember']['id']){
						$sub_genre = $sub_genre_model->getSubGenre($this->cleanIt($this->fixGenre($line[6])));
						$data['RadioStaffPlaylist']['radio_staff_member_id'] = $staff['RadioStaffMember']['id'];
						$data['Song']['sub_genre_id'] = $sub_genre['SubGenre']['id'];
						$data['Band']['name'] = $this->cleanIt($line[2]);
						$data['Song']['name'] = $this->cleanIt($line[3]);
						$data['Album']['name'] = $this->cleanIt($line[4]);
						$data['Label']['name'] = $this->cleanIt($line[5]);
						$data['RadioStaffPlaylist']['new_spins'] = trim($line[1]);
						$this->new_to_playlist($data);
					}
					//echo $radio['RadioStation']['id']."<hr />";
					unset($data);
					unset($staff);
					unset($this->id);
					unset($sub_genre);
				}
			}
			fclose($file_handle);
			
		}
		return false;
	}
	
	function fixGenre($genre){
		if($genre == 'TRUECOUNTRY'){
			return 'TRUE COUNTRY';
		}
		if($genre == 'COWBOYWESTERN'){
			return 'COWBOY WESTERN';
		}
		if($genre == 'POPCOUNTRY'){
			return 'POP COUNTRY';
		}
		if($genre == 'OTHER'){
			return 'UNKNOWN';
		}
		if($genre == 'ROCK'){
			return 'ROOTS ROCK';
		}
		if($genre == 'COUNTRY'){
			return 'ROOTS/AMERICANA COUNTRY';
		}
		if($genre == 'HIPHOPRNB'){
			return 'Hip Hop/R&B';
		}
		if($genre == 'HARDROCK'){
			return 'HARD ROCK';
		}
		if($genre == 'ALTROCK'){
			return 'Alternative Rock';
		}
		
		return $genre;
	}
	
	function add_to_list($data = false, $staff_id = 0, $overwrite = true){
		if(!$data){
			return false;
		}

		$data['radio_staff_member_id'] = $staff_id;
		
		$result = $this->find('first',array(
			'conditions' => array(
				$this->alias.'.radio_staff_member_id' => $data['radio_staff_member_id'],
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
		return false;

	}

	function new_to_playlist($data = null, $overwrite = true){
		$error = false;
		$band_model = ClassRegistry::init('Band');
		$band = $band_model->add($data['Band'], 'name');
		if(!$band){
			$error = true;
		}
		
		if(isset($data['Album']['compilation']) && $data['Album']['compilation']){
			$band_id = 1;
		} elseif(isset($data['Album']['soundtrack']) && $data['Album']['soundtrack']){
			$band_id = 2;
		} else {
			$band_id = $band['Band']['id'];
		}
		
		if(isset($band_id)){
			$data['Song']['band_id'] = $band['Band']['id'];
		} else {
			$data['Song']['band_id'] = $band['Band']['id'];
		}
		
		if(empty($data['Song']['sub_genre_id'])){
			$data['Song']['sub_genre_id'] = '35';
		}
		
		$song_model = ClassRegistry::init('Song');
		if(empty($data['Song']['name'])){
			$data['Song']['name'] = 'Unknown';
		}
		$song = $song_model->add($data['Song'], array('name','band_id'));
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
			$album = $album_model->add($data['Album'], array('name','band_id'));
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
			$track['album_id'] = $album['Album']['id'];
			$track['song_id'] = $song['Song']['id'];
			$album_song_model->add($track, array('album_id','song_id'));
		}

		if(!empty($data['Band']['name']) && !empty($data['Song']['name'])){
			$band_model->add_genre($band['Band']['id'],$song['Song']['sub_genre_id']);
			$album_model->add_genre($album['Album']['id'],$song['Song']['sub_genre_id']);
		}

		if(!$error){
			$playlist['radio_staff_member_id'] = $data['RadioStaffPlaylist']['radio_staff_member_id'];
			$playlist['band_id'] = $band['Band']['id'];
			$playlist['album_id'] = $album['Album']['id'];
			$playlist['song_id'] = $song['Song']['id'];
			$playlist['spins'] = $data['RadioStaffPlaylist']['new_spins'];
			if($overwrite){
				$this->add_to_list($playlist, $playlist['radio_staff_member_id']);
			} else {
				$this->add_to_list($playlist, $playlist['radio_staff_member_id'], false);
			}
			$staff_model = ClassRegistry::init('RadioStaffMember');
			$staff = $staff_model->reported_toggle($data['RadioStaffPlaylist']['radio_staff_member_id']);	
		}
		return $band['Band']['name'];
	}

	function selected_to_playlist($data){
		$song_model = ClassRegistry::init('Song');
		$song_model = ClassRegistry::init('Album');
		$song_model->recursive = -1;
		foreach($data['RadioStaffPlaylist']['AddSong'] as $album){
			foreach($album as $song){
				if($song['check'] == 1){
					unset($song_model->id);
					$album_data = $song_model->find('first', array(
						'conditions' => array('Album.id'=>$song['album_id'])
					));
					$playlist['radio_staff_member_id'] = $data['RadioStaffPlaylist']['radio_staff_member_id'];
					$playlist['band_id'] = $album_data['Album']['band_id'];
					$playlist['album_id'] = $song['album_id'];
					$playlist['song_id'] = $song['song_id'];
					$playlist['spins'] = $song['new_spins'];
					
					if(!$this->add_to_list($playlist, $playlist['radio_staff_member_id'])){
						return false;	
					}
				}
			}
		}
		$staff_model = ClassRegistry::init('RadioStaffMember');
		$staff = $staff_model->reported_toggle($data['RadioStaffPlaylist']['radio_staff_member_id']);
		return true;
	}
	
	function save_spins($data = null){
		if(!$data){
			return false;
		}
		$count = $this->find('count', array('conditions'=>array('radio_staff_member_id'=>$data['RadioStaffPlaylist']['radio_staff_member_id'])));
		if($count <= 0){
			return false;
		}
		if(isset($data['RadioStaffPlaylist']['spins'])){
			foreach($data['RadioStaffPlaylist']['spins'] as $key => $value){
				if($value != $data['RadioStaffPlaylist']['origSpins'][$key]){
					$listItem = $this->findById($key);
					$listItem['RadioStaffPlaylist']['spins'] = $value;
					$this->save($listItem);
				}
			}
		}
	}

	function finalise_toggle($radio_id){
		$radio_station_model = ClassRegistry::init('RadioStaffMember');
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

		foreach($data['RadioStaffPlaylist']['checks'] as $key => $entry){
			if($entry){
				$this->delete($key);
			}
		}
		return true;
	}

	function process_playlist($data = Null){
		$file_handle = fopen($data['RadioStaffPlaylist']['file']['tmp_name'], "r");
		$sub_genre_model = ClassRegistry::init('SubGenre');
		while(!feof($file_handle)){
		   $line = fgetcsv($file_handle);
 
		   if(strtolower($line[0]) != 'artist'){
				$data['Band']['name'] = $line[0];
				$data['Song']['name'] = $line[1];
				$data['Album']['name'] = $line[2];
				$data['Label']['name'] = $line[3];
				if(empty($line[4]))
					$data['SubGenre']['name'] = 'Unknown';
				else
					$data['SubGenre']['name'] = $line[4];
				$sub_genre = $sub_genre_model->findByName($data['SubGenre']['name']);
				$data['Song']['sub_genre_id'] = $sub_genre['SubGenre']['id'];
				$data['RadioStaffPlaylist']['new_spins'] = $line[5];
				$this->new_to_playlist($data);
		   }
		}
		fclose($file_handle);
		return true;
	}
	
	function processUncompiledPlaylist($data = Null){
		if(!$data){
			return false;
		}

		$file_handle = fopen($data['RadioStaffPlaylist']['file']['tmp_name'], "r");
		
		$i = 0;
		while(!feof($file_handle)){
			$line = fgetcsv($file_handle);
			if($i == 0){
				$order[] = $line[0];
				
			}			
			if(strtolower($line[0]) != 'artist'){
				if(!empty($line[0]))
					$data['Band']['name'] = $line[0];
				if(!empty($line[1]))
					$data['Song']['name'] = $line[1];
				if(!empty($line[2]))
					$data['Album']['name'] = $line[2];
				if(!empty($line[3]))
					$data['Label']['name'] = $line[3];
				if(!empty($line[4]))
					$data['SubGenre']['name'] = $line[4];
				
				$data['RadioStaffPlaylist']['new_spins'] = 1;
				$this->new_to_playlist($data, false);
			}
		}
		fclose($file_handle);
	}
	
	function update_entry($id, $band_id = false, $album_id = false, $song_id = false){
		$entry = $this->find('first', $id);
		$change_made = 0;
		if($entry['RadioStaffPlaylist']['band_id'] != $band_id){
			$entry['RadioStaffPlaylist']['band_id'] = $band_id;
			$change_made = 1;
		}
		if($entry['RadioStaffPlaylist']['album_id'] != $album_id){
			$entry['RadioStaffPlaylist']['album_id'] = $album_id;
			$change_made = 1;
		}
		if($entry['RadioStaffPlaylist']['song_id'] != $song_id){
			$entry['RadioStaffPlaylist']['song_id'] = $song_id;
			$change_made = 1;
		}
		if($change_made == 1){
			$this->save($entry['RadioStaffPlaylist']);
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
	
	function getLastWeekPlaylist($staff_id, $get_spins = true){
		$archive_model = ClassRegistry::init('RadioStaffPlaylistArchive');
		$archive_date = $archive_model->find('first', array(
			'conditions' => array(
				'radio_staff_member_id' => $staff_id,
			),
			'order' => array(
				'week_ending' => 'DESC'
			)
		));
		
		$archive_list = $archive_model->find('all', array(
			'conditions' => array(
				'radio_staff_member_id' => $staff_id,
				'week_ending' => $archive_date['RadioStaffPlaylistArchive']['week_ending'],
			),
			'order' => array(
				'spins' => 'DESC'
			)
		));
		$playlist = array();
		
		$i = 0;
		foreach($archive_list as $entry){
			$playlist[$i]['RadioStaffPlaylist'] = $entry['RadioStaffPlaylistArchive'];
			unset($playlist[$i]['RadioStaffPlaylist']['id']);
			unset($playlist[$i]['RadioStaffPlaylist']['week_ending']);
			if(!$get_spins){
				$playlist[$i]['RadioStaffPlaylist']['spins'] = 0;
			}
			$i++;
		}
		if($this->saveAll($playlist)){
			return true;
		} else {
			return false;
		}
		
 	}
	
	function toggleInvalid($data){
		foreach($data['RadioStaffPlaylist']['checks'] as $key => $entry){
			if($entry){
				$listItem = $this->findById($key);
				if($listItem['RadioStaffPlaylist']['invalid'] == 0){
					$listItem['RadioStaffPlaylist']['invalid'] = 1;
				} else {
					$listItem['RadioStaffPlaylist']['invalid'] = 0;
				}
				$this->save($listItem);
			}
		}
	}

}
?>