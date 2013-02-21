// JavaScript Document
var dir = '../../';
$(document).ready(function(){
	
	$("input:checkbox:checked").attr("checked", ""); 

	$("#BandName").autocomplete({
		source: function(request, response){
			$.post(dir+"band_autocomplete", {term:request.term}, function(data){
				response($.map(data, function(item) {
				return {
					label: item.name,
					value: item.id,
					album: item.album
				}
				}))
			}, "json");
		},
		minLength: 2,
		dataType: "json",
		cache: false,
		focus: function(event, ui) {
			return false;
		},
		select: function(event, ui) {
			this.value = ui.item.label;
			band = ui.item.value;
			$('#SongName').focus();
			html = '<table><caption>Existing Songs for '+ui.item.label;
			html += '<tr><th>&nbsp;</th><th>Song Title</th><th>Album Title</th><th>Label</th><th>New Spins</th></tr>';
			for(var index = 0; index < ui.item.album.length; index++){
				for(var index2 = 0; index2 < ui.item.album[index].Song.length; index2++){
					html += '<tr><td>';
					html += '<div class="input checkbox" style="display:inline;"><input type="hidden" name="data[RadioStaffPlaylist][AddSong]['+index+']['+index2+'][check]" id="RadioStaffPlaylistAddSong'+index+''+index2+'Check_" value="0"><input type="checkbox" name="data[RadioStaffPlaylist][AddSong]['+index+']['+index2+'][check]" value="1" id="RadioStaffPlaylistAddSong'+index+''+index2+'Check"><label for="RadioStaffPlaylistAddSong'+index+''+index2+'Check"></label></div>';
					html += '</td><td>';
					html += ui.item.album[index].Song[index2].name;
					html += '<input type="hidden" name="data[RadioStaffPlaylist][AddSong]['+index+']['+index2+'][song_id]" id="RadioStaffPlaylistAddSong'+index2+'SongId" value="'+ui.item.album[index].Song[index2].id+'">';
					html += '<input type="hidden" name="data[RadioStaffPlaylist][AddSong]['+index+']['+index2+'][album_id]" id="RadioStaffPlaylistAddSong'+index2+'AlbumId" value="'+ui.item.album[index].id+'">';
					html += '</td><td>';
					html += ui.item.album[index].name;
					html += '</td><td>';
					html += ui.item.album[index].Label.name;
					html += '</td><td>';
					html += ' <input style="display:inline; width:30px; height:12px;" name="data[RadioStaffPlaylist][AddSong]['+index+']['+index2+'][new_spins]" type="text" value="0" id="RadioStaffPlaylistAddSongNewSpins">';
					html += '</td></tr>';
				}
			}
			html += '</table>';
			html += '<div class="submit"><input type="submit" name="data[action]" value="Add Selected to Playlist"></div>';
			$("#search_results").html('');
			$("#search_results").append(html);
			/* Do something with user_id 
			alert('you selected ' + this.value)*/

			return false;
		}
	});

	   $("#LabelName").autocomplete({
		source: function(request, response){
			$.post(dir+"label_autocomplete", {term:request.term}, function(data){
				response($.map(data, function(item) {
				return {
					label: item.name,
					value: item.id
				}
				}))
			}, "json");
		},
		minLength: 2,
		dataType: "json",
		cache: false,
		focus: function(event, ui) {
			return false;
		},
		select: function(event, ui) {
			this.value = ui.item.label;

			$('#RadioStationPlaylistNewSpins').focus();

			return false;
		}
	});

	   $("#AlbumName").autocomplete({
		source: function(request, response){
			$.post(dir+"album_autocomplete/"+band, {term:request.term}, function(data){
				response($.map(data, function(item) {
				return {
					label: item.name,
					value: item.id,
								lab: item.lab
				}
				}))
			}, "json");
		},
		minLength: 2,
		dataType: "json",
		cache: false,
		focus: function(event, ui) {
			return false;
		},
		select: function(event, ui) {
			this.value = ui.item.label;
			$('#LabelName').val(ui.item.lab).attr('readonly',true).addClass('readonly');
			$('#RadioStationPlaylistNewSpins').focus();
			/* Do something with user_id
			alert('you selected ' + this.value)*/
			if(ui.item.compilation == '1'){
			   $('#AlbumCompilation').attr('checked', true).attr('readonly',true).addClass('readonly').hide();
			   $("[for='AlbumCompilation']").hide();
			} else {
			   $('#AlbumCompilation').attr('readonly',true).addClass('readonly').hide();
			   $("[for='AlbumCompilation']").hide();
			}
			if(ui.item.soundtrack == '1'){
			   $('#AlbumSoundtrack').attr('checked', true).attr('readonly',true).addClass('readonly').hide();
			   $("[for='AlbumSoundtrack']").hide();
			} else {
			   $('#AlbumSoundtrack').attr('readonly',true).addClass('readonly').hide();
			   $("[for='AlbumSoundtrack']").hide();
			}
			return false;
		}
	});

	   $("#SongName").autocomplete({
		source: function(request, response){
			$.post(dir+"song_autocomplete/"+band, {term:request.term}, function(data){
				response($.map(data, function(item) {
				return {
					label: item.name,
					value: item.id,
					album: item.album,
					genre: item.genre,
					genre_name: item.genre_name,
					lab: item.lab,
					compilation: item.compilation,
					soundtrack: item.soundtrack
				}
				}))
			}, "json");
		},
		minLength: 2,
		dataType: "json",
		cache: false,
		focus: function(event, ui) {
			return false;
		},
		select: function(event, ui) {
			this.value = ui.item.label;
				  //  $("#SongName").attr('disabled',true);
			$("[for='SongSubGenreId']").append('<span id="c">:</span>').addClass('bold');
			$('#SongSubGenreId').hide().after('<span id="b">'+ui.item.genre_name+'</span>');
				   
			$('#AlbumName').val(ui.item.album).attr('readonly',true).addClass('readonly');
			$('#LabelName').val(ui.item.lab).attr('readonly',true).addClass('readonly');
			if(ui.item.compilation == '1'){
			   $('#AlbumCompilation').attr('checked', true).attr('readonly',true).addClass('readonly').hide();
			   $("[for='AlbumCompilation']").hide();
			} else {
			   $('#AlbumCompilation').attr('readonly',true).addClass('readonly').hide();
			   $("[for='AlbumCompilation']").hide();
			}
			if(ui.item.soundtrack == '1'){
			   $('#AlbumSoundtrack').attr('checked', true).attr('readonly',true).addClass('readonly').hide();
			   $("[for='AlbumSoundtrack']").hide();
			} else {
			   $('#AlbumSoundtrack').attr('readonly',true).addClass('readonly').hide();
			   $("[for='AlbumSoundtrack']").hide();  
			}
			$("[for='AlbumName']").append('<span id="d">:</span>').addClass('bold');
			$("[for='AlbumName']").parent().removeClass('required');
			$("[for='LabelName']").append('<span id="e">:</span>').addClass('bold');
			$("[for='LabelName']").parent().removeClass('required');
			$('#AlbumNameChange').show();
			$('#RadioStationPlaylistNewSpins').focus();
			/* Do something with user_id */
			/*alert('you selected ' + this.value)*/
			return false;
		}
	});
	   $('#SongName').click(function(){
		  $('#SongSubGenreId').val('').attr('readonly',false).removeClass('readonly');
		  $('#AlbumNameChange').hide();
		  $('#b').remove();
		  $('#c').remove();
		  $('#d').remove();
		  $('#e').remove();
		  $("[for='SongSubGenreId']").removeClass('bold');
		  $('#SongSubGenreId').show();
		  $("[for='AlbumName']").parent().addClass('required');
		  $("[for='LabelName']").parent().addClass('required');
		  $('#AlbumName').val('').attr('readonly',false).removeClass('readonly');
		  $('#LabelName').val('').attr('readonly',false).removeClass('readonly');
		  $('#AlbumCompilation').attr('checked', false).attr('readonly',false).removeClass('readonly').show();
		  $('#AlbumSoundtrack').attr('checked', false).attr('readonly',false).removeClass('readonly').show();
		  $("[for='AlbumSoundtrack']").show();
		  $("[for='AlbumCompilation']").show();
	   });

	   $('#AlbumName').keypress(function(){
		  $('#AlbumNameChange').hide();
		  $('#b').remove();
		  $('#c').remove();
		  $('#d').remove();
		  $('#e').remove();
		  $("[for='LabelName']").parent().addClass('required');
		  $('#LabelName').val('').attr('readonly',false).removeClass('readonly');
		  $('#AlbumCompilation').attr('checked', false).attr('readonly',false).removeClass('readonly').show();
		  $('#AlbumSoundtrack').attr('checked', false).attr('readonly',false).removeClass('readonly').show();
		  $("[for='AlbumSoundtrack']").show();
		  $("[for='AlbumCompilation']").show();
	   });

	   $('#AlbumNameChange').click(function(){
		  $('#SongSubGenreId').attr('readonly',false).removeClass('readonly');
		  $('#AlbumNameChange').hide();
		  $('#b').remove();
		  $('#c').remove();
		  $('#d').remove();
		  $('#e').remove();
		  $("[for='SongSubGenreId']").removeClass('bold');
		  $('#SongSubGenreId').show();
		  $("[for='AlbumName']").parent().addClass('required');
		  $("[for='LabelName']").parent().addClass('required');
		  $('#AlbumName').attr('readonly',false).removeClass('readonly');
		  $('#LabelName').attr('readonly',false).removeClass('readonly');
		  $('#AlbumCompilation').attr('readonly',false).removeClass('readonly').show();
		  $('#AlbumSoundtrack').attr('readonly',false).removeClass('readonly').show();
		  $("[for='AlbumSoundtrack']").show();
		  $("[for='AlbumCompilation']").show();
	   }).hide();
	/*var ajax = ['new', 'newt', 'newtging'];
	$('#BandName').autocomplete({
		minLength: 2,
		source: 'reporter_playlists/autocomplete' ,
	});*/
	
});