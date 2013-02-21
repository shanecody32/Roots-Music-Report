<?php

class ChartFunctionsController extends AppController {

	var $name = 'ChartFunctions';
	var $generate_time = 6; // in days

	function index(){

	}

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('*');
	}

	function check_finalized(){
		if(!$this->ChartFunction->chartGenCheck($this->generate_time)){
			$this->Session->setFlash(__('It\'s too soon to total spins this week.'));
			$this->set('not_final', array());
		} else {
			$not_final = $this->ChartFunction->checkFinalized();
			if($not_final){
				$this->set('not_final', $not_final);
				$this->Session->setFlash(__(count($not_final).' Reporters need finalizing.'));
			} else {
				$this->Session->setFlash(__('No reporters need finalizing.'));
				$this->redirect(array('action' => 'check_not_reported'));
			}
		}
	}

	

	function check_not_reported(){
		if(!$this->ChartFunction->chartGenCheck($this->generate_time)){
			$this->Session->setFlash(__('It\'s too soon to total spins this week.'));
			$this->set('not_final', array());
		} else {
			$not_reported = $this->ChartFunction->checkNotReported();
			if($not_reported){
				$this->set('not_reported', $not_reported);
				$this->Session->setFlash(__(count($not_reported).' stations did not report.')); 
			} else {
				$this->Session->setFlash(__('All stations reported.'));
				$this->redirect(array('action' => 'compile_radio_playlists'));
			}
		}
	}

	function compile_radio_playlists(){
		if(!$this->ChartFunction->chartGenCheck($this->generate_time)){
			$this->Session->setFlash(__('It\'s too soon to compile playlists this week.'));
			$this->set('not_final', array());
		} else {
			$this->ChartFunction->compileRadioPlaylist();
			$this->Session->setFlash(__('Radio Station Playlists Generated.'));
			$this->redirect(array('action' => 'total_spins'));
		}
	}

	function total_spins(){
		if(!$this->ChartFunction->chartGenCheck($this->generate_time)){
			$this->Session->setFlash(__('It\'s too soon to compile playlists this week.'));
			$this->set('not_final', array());
		} else {
			$this->ChartFunction->totalSpins();
			$this->Session->setFlash(__('stats totaled.'));
			$this->redirect(array('action' => 'archive_radio_playlists'));
		}
	}

	function archive_radio_playlists(){
		if(!$this->ChartFunction->chartGenCheck($this->generate_time)){
			$this->Session->setFlash(__('It\'s too soon to compile playlists this week.'));
			$this->set('not_final', array());
		} else {
			$this->ChartFunction->archivePlaylist('RadioStation');
			$this->Session->setFlash(__('playlist archived.'));
			$this->redirect(array('action' => 'archive_staff_playlists'));
		}
	}

	function archive_staff_playlists(){
		if(!$this->ChartFunction->chartGenCheck($this->generate_time)){
			$this->Session->setFlash(__('It\'s too soon to compile playlists this week.'));
			$this->set('not_final', array());
		} else {
			$this->ChartFunction->archivePlaylist('RadioStaff');
			$this->ChartFunction->setNotReported();
			$this->ChartFunction->unlockAllPlaylist();
			$this->Session->setFlash(__('staff playlist archived.'));
			$this->redirect(array('action' => 'archive_charts'));
		}
	}

	function archive_charts(){
		if(!$this->ChartFunction->chartGenCheck($this->generate_time)){
			$this->Session->setFlash(__('It\'s too soon to compile playlists this week.'));
			$this->set('not_final', array());
		} else {
			$this->ChartFunction->archiveCharts();
			$this->Session->setFlash(__('charts archived.'));
			$this->redirect(array('action' => 'set_last_rank'));
		}
	}
	
	function set_last_rank(){
		if(!$this->ChartFunction->chartGenCheck($this->generate_time)){
			$this->Session->setFlash(__('It\'s too soon to compile playlists this week.'));
			$this->set('not_final', array());
		} else {
			$this->ChartFunction->setLastRank('Album');
			$this->ChartFunction->setLastRank('Song');
			$this->ChartFunction->updateWeekEnding();
			$this->Session->setFlash(__('last week rank set.'));
			$this->redirect(array('action' => 'view_temp_charts'));
		}
	}

	/*'City',
	'CityPostalCode',*/

	// all above add week check to prevent duplicating archives
	/*'PostalCode',
			'RadioAddress',
			'RadioEmail',
			'RadioInternetDetail',
			'RadioLink',
			'RadioPhoneNumber',
			'RadioSatelliteDetails',
			'RadioStaffAddress',
			'RadioStaffImage',
			'RadioStaffLinks',
			'RadioStaffMember',
			'RadioStaffMemberViolation',
			'RadioStaffPhoneNumber',
			'RadioStaffPlaylist',
			'RadioStaffPlaylistArchive',
			'RadioStations',
			'RadioStationGenres',
			'RadioStationImage',
			'RadioStationPlaylist',
			'RadioStationPlaylistArchive',
			'RadioStationRawData',
			'RadioStationSubGenre',
			'RadioSyndicatedDetail',
			'RadioSyndicatedStation',
			'RadioTerrestrialDetail',*/

	function clean_database(){
		$models = array(
			'Album',
			'AlbumDetail',
			'AlbumSubGenre',
			'AlbumImage',
			'AlbumMonthlyGenreChart',
			'AlbumMonthlyGenreChartArchive',
			'AlbumMonthlySubGenreChart',
			'AlbumMonthlySubGenreChartArchive',
			'AlbumStat',
			'AlbumTrack',
			'AlbumWeeklyGenreChart',
			'AlbumWeeklyGenreChartArchive',
			'AlbumWeeklySubGenreChart',
			'AlbumWeeklySubGenreChartArchive',
			'Band',
			'BandSubGenre',
			'BandViolation',
			'Label',
			'Song',
			'SongMonthlyGenreChart',
			'SongMonthlyGenreChartArchive',
			'SongMonthlySubGenreChart',
			'SongMonthlySubGenreChartArchive',
			'SongStat',
			'SongWeeklyGenreChart',
			'SongWeeklyGenreChartArchive',
			'SongWeeklySubGenreChart',
			'SongWeeklySubGenreChartArchive',
			'SystemNotes',
			'Violations',	
			'RadioStationPlaylist',
			'RadioStationPlaylistArchive',
			'RadioStaffPlaylist',
			'RadioStaffPlaylistArchive',
		);

		foreach($models as $model){
			$this->loadModel($model);
			$this->$model->truncate();
		}
	}

	function view_temp_charts(){
		$this->loadModel('SubGenre');
		$this->SubGenre->recursive = -1;
		$sub_genres = $this->SubGenre->find('all',array(
			'order' => array(
				'name' => 'ASC'
			)
		));
		
		$this->loadModel('Genre');
		$this->Genre->recursive = -1;
		$genres = $this->Genre->find('all',array(
			'order' => array(
				'name' => 'ASC'
			)
		));
		
		$this->set('genres', $genres);
		$this->set('sub_genres', $sub_genres);
	}

	function song_sub_genre_temp_chart($sub_genre, $main = 0){
		$this->set('styles',array('playlists', 'tables'));
		$this->set('chart', $this->ChartFunction->getTempChart($sub_genre, 'song'));
		$this->set('sub_genre', Inflector::humanize($sub_genre));
	}
	
	function album_sub_genre_temp_chart($sub_genre, $main = 0){
		$this->set('styles',array('playlists', 'tables'));
		$this->set('chart', $this->ChartFunction->getTempChart($sub_genre, 'album'));
		$this->set('sub_genre', Inflector::humanize($sub_genre));
	}
	
	function song_genre_temp_chart($genre, $main = 0){
		$this->set('styles',array('playlists', 'tables'));
		$this->set('chart', $this->ChartFunction->getTempChart($genre, 'song', 'genre'));
		$this->set('genre', Inflector::humanize($genre));
	}
	
	function album_genre_temp_chart($genre, $main = 0){
		$this->set('styles',array('playlists', 'tables'));
		$this->set('chart', $this->ChartFunction->getTempChart($genre, 'album', false));
		$this->set('genre', Inflector::humanize($genre));
	}
	
	function generate_song_charts(){
		$this->ChartFunction->generateWeeklyCharts('song_weekly_sub_genre_charts');
		$this->ChartFunction->generateWeeklyCharts('song_weekly_genre_charts', 'song', 'Genre');
		$this->Session->setFlash(__('Weekly Song Charts Generated.'));
		$this->redirect(array('action' => 'generate_album_charts'));
	}

	function generate_album_charts(){
		$this->ChartFunction->generateWeeklyCharts('album_weekly_sub_genre_charts', 'album');
		$this->ChartFunction->generateWeeklyCharts('album_weekly_genre_charts', 'album', 'Genre');
		$this->Session->setFlash(__('All Charts Generated.'));
		$this->redirect(array('action' => 'finished'));
	}

	function finished(){
	}

	function create_stat_tables(){
		$this->ChartFunction->createStatTables();
	}
}
?>