<? // DW ?>
<section id="title">
	<hgroup>
		<h1 id="radioname"><span class="smaller">Reported Airplay</span><br /> <?=$staff['RadioStaffMember']['first_name'];?> <?=$staff['RadioStaffMember']['last_name'];?></h1>
		<h4 id="radioname">Airplay Reporter for <?=$staff['RadioStation']['name'];?></h4>
	</hgroup>
</section>

<div class="clearfloats">&nbsp;</div>
<?=$this->Form->create('RadioStaffPlaylist',array('action'=>'admin_edit/'.$staff['RadioStaffMember']['id'])); ?>
<? if(!$staff['RadioStaffMember']['playlist_finalised'] || !$playlists):?>
<div id="search_results">&nbsp;</div>
<div id="add_artist">
	<?=$this->Form->input('Band.name', array('label'=>'Band/Artist Name')); ?>
	<?=$this->Form->input('Song.name',array('label'=>'Song Title')); ?>
	<?=$this->Form->input('Song.sub_genre_id', array('empty'=>'Select One', 'options'=>$sub_genres, 'label'=>'Song Genre')); ?>
	<a class="function" id="AlbumNameChange" href="#">this is not the right album</a>
	<?=$this->Form->input('Album.name',array('label'=>'Album Title')); ?>
	<?=$this->Form->input('Label.name', array('label'=>'Label')); ?>
	<?=$this->Form->input('Album.compilation'); ?>
	<?=$this->Form->input('Album.soundtrack'); ?>
	<?=$this->Form->input('RadioStaffPlaylist.new_spins', array('default'=>'0'));?>
	<?=$this->Form->hidden('RadioStaffPlaylist.user_id', array('value' => '1')); ?>
	<?=$this->Form->hidden('RadioStaffPlaylist.radio_id', array('value' => $staff['RadioStaffMember']['id'])); ?>

	<div class="submit"><input type="submit" name="data[action]" value="Add to Playlist" /></div>
</div>

<? endif;?>
	 <?=$this->Form->hidden('RadioStaffPlaylist.radio_staff_member_id', array('value' => $staff['RadioStaffMember']['id'])); ?>
<hr />
<? if($playlists){?>

<table>
	<tr>
		<?if(!$staff['RadioStaffMember']['playlist_finalised']){ ?><th>&nbsp;</th><? } ?>
		<?if(!$staff['RadioStaffMember']['playlist_finalised']){ ?><th>&nbsp;</th><? } ?>
		<th><?=$this->Paginator->sort('Song.name', 'Song Title');?></th>
		<th><?=$this->Paginator->sort('Album.name', 'Album Title');?></th>
		<th><?=$this->Paginator->sort('Band.name', 'Band Name');?></th>
		<th>Label</th>
		<th>Genre</th>
		<th><?=$this->Paginator->sort('RadioStaffPlaylist.spins', 'Spins');?></th>
	</tr>

<? foreach($playlists as $item): ?>
	<tr>
		<?if(!$staff['RadioStaffMember']['playlist_finalised']){ ?><td style="color:#F00;"><? if($item['RadioStaffPlaylist']['invalid']) echo "X"; ?></td><? } ?>
		<?if(!$staff['RadioStaffMember']['playlist_finalised']){ ?><td><?=$this->Form->input('RadioStaffPlaylist.checks.'.$item['RadioStaffPlaylist']['id'], array('type'=>'checkbox','label'=>''));?></td><? } ?>
		<td>&ldquo;<?=$item['Song']['name'];?>&rdquo;</td>
		<td><?=$item['Album']['name'];?></td>
		<td><?=$item['Band']['name'];?></td>
		<td><?=$this->Logic->unknown($item['Album']['Label'],'name');?></td>
		<td><?=$this->Logic->unknown($item['Song']['SubGenre'],'name');?></td>
		<td>
			<?=$this->Form->hidden('RadioStaffPlaylist.origSpins.'.$item['RadioStaffPlaylist']['id'], array('value' => $item['RadioStaffPlaylist']['spins'])); ?>
			<input name="data[RadioStaffPlaylist][spins][<?=$item['RadioStaffPlaylist']['id']?>]" <? if($staff['RadioStaffMember']['playlist_finalised']) echo 'disabled="disabled"';?> type="text" maxlength="4" value="<? if($item['RadioStaffPlaylist']['spins']!= '0') echo $item['RadioStaffPlaylist']['spins'];?>" id="RadioStaffPlaylistSpins" />
		</td>
	</tr>
<? endforeach; ?>
</table>
<div class="submit">
	<input type="submit" name="data[action]"
	<? if(!$staff['RadioStaffMember']['playlist_finalised'])echo 'value="Save Spins"'; else echo 'value="Unlock Playlist"';?> />
	<? if(!$staff['RadioStaffMember']['playlist_finalised'])echo '<input type="submit" name="data[action]" value="Save Spins and Finalise Playlist" />'; ?>
	<? if(!$staff['RadioStaffMember']['playlist_finalised'])echo '<input type="submit" name="data[action]" value="Remove Selected" />'; ?>
	<? if(!$staff['RadioStaffMember']['playlist_finalised'])echo '<br /><br /><input type="submit" name="data[action]" value="Count/Do Not Count Selected" />'; ?>
</div>

<? } else { ?>
<h3>This member has not yet reported this week.</h3>
<? } ?>

	<div class="submit"><input type="submit" name="data[action]" value="Get Last Weeks Playlist w/ Spins" /></div>
	<div class="submit"><input type="submit" name="data[action]" value="Get Last Weeks Playlist w/o Spins" /></div>
	<div class="submit"><input type="submit" name="data[action]" value="Upload Playlist" /></div>
	<div class="submit"><input type="submit" name="data[action]" value="Upload Uncompiled Playlist" /></div>
</form>
<?// pr($staff); ?>
<? //pr($playlists); ?>