<div id="title">
    <div id="images">
	   <? if(!empty($radio['RadioStationImage'])){ ?>
	   <?=$this->Html->image($radio['RadioStationImage'][0]['path'].$radio['RadioStationImage'][0]['thumbname'], array('alt'=>'No Logo for '.$radio['RadioStation']['name'])); ?>
	   <? } else { ?>
	   <?=$this->Html->image('no_radio_logo.jpg', array('alt'=>'No Logo for '.$radio['RadioStation']['name'], 'style'=>'width:100px;')); ?>
	   <? } ?>
    </div>
    <h1 id="radioname"><span class="smaller">Reported Airplay</span><br /> <?=$radio['RadioStation']['name'];?></h1>
    <?=Inflector::humanize($radio['RadioStation']['type']); ?> Airplay Reporter
</div>


<div class="clearfloats">&nbsp;</div>
<?=$this->Form->create('RadioStationPlaylist',array('action'=>'admin_edit/'.$radio['RadioStation']['id'])); ?>
<? if(!$radio['RadioStation']['playlist_finalised']):?>
<div id="add_artist">
    <?=$this->Form->input('Band.name', array('label'=>'Band/Artist Name')); ?>
    <?=$this->Form->input('Song.name',array('label'=>'Song Title')); ?>
    <?=$this->Form->input('Song.sub_genre_id', array('empty'=>'Select One','label'=>'Song Genre', 'options'=>$sub_genres)); ?>
    <a class="function" id="AlbumNameChange" href="#">this is not the right album</a>
    <?=$this->Form->input('Album.name',array('label'=>'Album Title')); ?>
    <?=$this->Form->input('Label.name', array('label'=>'Label')); ?>
    <?=$this->Form->input('Album.compilation'); ?>
    <?=$this->Form->input('Album.soundtrack'); ?>
    <?=$this->Form->input('RadioStationPlaylist.new_spins', array('default'=>'0'));?>

    <?=$this->Form->hidden('RadioStationPlaylist.user_id', array('value' => '1')); ?>
    <?=$this->Form->hidden('RadioStationPlaylist.radio_id', array('value' => $radio['RadioStation']['id'])); ?>

    <div class="submit"><input type="submit" name="data[action]" value="Add to Playlist" /></div>
    <div class="submit"><input type="submit" name="data[action]" value="Get Last Weeks Playlist w/ Spins" /></div>
	<div class="submit"><input type="submit" name="data[action]" value="Get Last Weeks Playlist w/o Spins" /></div>
	<div class="submit"><input type="submit" name="data[action]" value="Upload Playlist" /></div>
	<div class="submit"><input type="submit" name="data[action]" value="Upload Uncompiled Playlist" /></div>
</div>
<? endif;?>
    <?=$this->Form->hidden('RadioStationPlaylist.radio_station_id', array('value' => $radio['RadioStation']['id'])); ?>
<hr />
<? if($playlists){?>

<table>
    <tr>
	   <?if(!$radio['RadioStation']['playlist_finalised']){ ?><th>&nbsp;</th><? } ?>
	   <th><?=$this->Paginator->sort('Song.name', 'Song Title');?></th>
	   <th><?=$this->Paginator->sort('Album.name', 'Album Title');?></th>
	   <th><?=$this->Paginator->sort('Band.name', 'Band Name');?></th>
	   <th>Label</th>
	   <th>Genre</th>
	   <th><?=$this->Paginator->sort('RadioStationPlaylist.spins', 'Spins');?></th>
    </tr>

<? foreach($playlists as $item): ?>
    <tr>
	   <?if(!$radio['RadioStation']['playlist_finalised']){ ?><td><?=$this->Form->input('RadioStationPlaylist.checks.'.$item['RadioStationPlaylist']['id'], array('type'=>'checkbox','label'=>''));?></td><? } ?>
	   <td>&ldquo;<?=$item['Song']['name'];?>&rdquo;</td>
	   <td><?=$item['Album']['name'];?></td>
	   <td><?=$item['Band']['name'];?></td>
	   <td><?=$this->Logic->unknown($item['Album']['Label'],'name');?></td>
	   <td><?=$this->Logic->unknown($item['Song']['SubGenre'],'name');?></td>
	   <td>
		  <?=$this->Form->hidden('RadioStationPlaylist.origSpins.'.$item['RadioStationPlaylist']['id'], array('value' => $item['RadioStationPlaylist']['spins'])); ?>
		  <input name="data[RadioStationPlaylist][spins][<?=$item['RadioStationPlaylist']['id']?>]" <? if($radio['RadioStation']['playlist_finalised']) echo 'disabled="disabled"';?> type="text" maxlength="4" value="<? if($item['RadioStationPlaylist']['spins']!= '0') echo $item['RadioStationPlaylist']['spins'];?>" id="RadioStationPlaylistSpins" />
	   </td>
    </tr>
<? endforeach; ?>
</table>
<div class="submit">
    <input type="submit" name="data[action]"
    <? if(!$radio['RadioStation']['playlist_finalised'])echo 'value="Save Spins"'; else echo 'value="Unlock Playlist"';?> />
    <? if(!$radio['RadioStation']['playlist_finalised'])echo '<input type="submit" name="data[action]" value="Save Spins and Finalise Playlist" />'; ?>
    <? if(!$radio['RadioStation']['playlist_finalised'])echo '<input type="submit" name="data[action]" value="Remove Selected" />'; ?>
</div>
</form>
<? } else { ?>
<h3>This station has not yet reported this week.</h3>
<? } ?>

<?// pr($radio); ?>
<? //pr($playlists); ?>