$(document).ready(function() {
   soundManager.url = 'files/';
   soundManager.flashVersion = 8; 
   var theMP3;
   var currentSong = 0;
   var tracks = ["1","2","3","4"];
   var id3s=[];
   $jScroller.add("#scroller_container","#scroller","left",2);
   $jScroller.cache.init = true; // Turn off default Event
   $jScroller.config.refresh = 100;
	 $( "#progressbar" ).progressbar({
			value: 0
		});
	function updateArtist(){
		$("#scroller p").text(id3s[currentSong]["theTitle"]); // id3s[currentSong]["theArtist"] + " : " + id3s[currentSong]["theTitle"]
   }
	function startScroller(){
	   
	}
	soundManager.onready(function() {
		function playSound(){
			if(currentSong>=tracks.length){
				currentSong=0;
			}
			if(currentSong<0){
				currentSong = tracks.length-1;
			}
					
			theMP3= soundManager.createSound({
				id:'sound'+currentSong,
				url:"files/blues-deluxe/bdPart"+tracks[currentSong]+".mp3",
				whileplaying:function(){
					duration = this.duration;
					pos = this.position;
					songPosition = (pos/duration)*100;
					$( "#progressbar" ).progressbar( "option", "value", songPosition);
					
					var time = pos/1000;
					var min = Math.floor(time/60);
					var minDisplay = (min<10) ? "0"+min : min;
					var sec = Math.floor(time%60);
					var secDisplay = (sec<10) ? "0"+sec : sec;
					var amountPlayed = minDisplay+":"+secDisplay;
						
					var timeduration = duration/1000;
					var minduration = Math.floor(timeduration/60);
					var minDisplay = (minduration<10) ? "0"+minduration : minduration;
					var secduration = Math.floor(timeduration%60);
					var secDisplay = (secduration<10) ? "0"+secduration : secduration;
					var totalDuration = minDisplay+":"+secDisplay; 
				
					$("#time").text(amountPlayed + " / " + totalDuration);
				},
				onid3: function() {
					//artist = this.id3["TPE1"];
					title  = this.id3["TIT2"];
					id3s.push({theTitle:title});
					updateArtist();
				},
				onfinish:function() {
					if(currentSong != 3){
						currentSong++;
						playSound();
						updateArtist();
					} else {
						theMP3.stop();
					}						
				}
			});
			theMP3.play();
		};
		
		$("#play_btn").click(function(){
			$(this).attr("src","img/player/play_selected.png");
			$("#pause_btn").attr("src","img/player/pause_button.png");
			$("#stop_btn").attr("src","img/player/stop_button.png");
			playSound();
			$jScroller.start();
		}).mouseover(function(){
			$(this).css("cursor","pointer");
		});
		
		$("#stop_btn").click(function(){
			theMP3.stop();
			$("#play_btn").attr("src","img/player/play_button.png");
			$("#pause_btn").attr("src","img/player/pause_button.png");
			$(this).attr("src","img/player/stop_selected.png");
		}).mouseover(function(){
			$(this).css("cursor","pointer");
		});
		
		$("#pause_btn").click(function(){
			$("#play_btn").attr("src","img/player/play_button.png");
			$("#stop_btn").attr("src","img/player/stop_button.png");
			$(this).attr("src","img/player/pause_selected.png");
			theMP3.pause();
		}).mouseover(function(){
			$(this).css("cursor","pointer");
		});
		
		$("#fwd_btn").click(function(){
			if(theMP3 !=undefined){
				theMP3.stop();
				currentSong++;
				playSound();
				updateArtist();
		   }
		}).mouseover(function(){
			$(this).css("cursor","pointer");
		});
		$("#back_btn").click(function(){
			if(theMP3 != undefined){
				theMP3.stop();
				currentSong--;
				playSound();
				updateArtist();
			}
		}).mouseover(function(){
			$(this).css("cursor","pointer");
		});
		
		$("#volumebar").mousemove(function(e){
			var parentOffset = $(this).parent().offset();
			var relX = Math.floor(e.pageX - parentOffset.left);	  
			var vol = Math.ceil( (relX-7)/10)-4;
			console.log(vol);
			if(vol >=1 && vol <=10){
				$(this).attr("src","img/player/vb"+vol+".png");
				if(theMP3 != undefined){
					theMP3.setVolume(vol*10)
				}
			}
		}).mouseover(function(){
			$(this).css("cursor","pointer");
		});
		
		$('#track1').click(function(){
			if(theMP3 != undefined){
				theMP3.stop();
				$jScroller.stop();
			}
			$("#play_btn").attr("src","img/player/play_selected.png");
			$("#pause_btn").attr("src","img/player/pause_button.png");
			$("#stop_btn").attr("src","img/player/stop_button.png");
			currentSong=0;
			playSound();
			updateArtist();
			$jScroller.start();
		}).mouseover(function(){
			$(this).css("cursor","pointer");
		});
		
		$('#track2').click(function(){
			if(theMP3 != undefined){
				theMP3.stop();
				$jScroller.stop();
			}
			$("#play_btn").attr("src","img/player/play_selected.png");
			$("#pause_btn").attr("src","img/player/pause_button.png");
			$("#stop_btn").attr("src","img/player/stop_button.png");
			currentSong=1;
			playSound();
			updateArtist();
			$jScroller.start();
		}).mouseover(function(){
			$(this).css("cursor","pointer");
		});
		
		$('#track3').click(function(){
			if(theMP3 != undefined){
				theMP3.stop();
				$jScroller.stop();
			}
			$("#play_btn").attr("src","img/player/play_selected.png");
			$("#pause_btn").attr("src","img/player/pause_button.png");
			$("#stop_btn").attr("src","img/player/stop_button.png");
			currentSong=2;
			playSound();
			updateArtist();
			$jScroller.start();
		}).mouseover(function(){
			$(this).css("cursor","pointer");
		});
		
		$('#track4').click(function(){
			if(theMP3 != undefined){
				theMP3.stop();
				$jScroller.stop();
			}
			$("#play_btn").attr("src","img/player/play_selected.png");
			$("#pause_btn").attr("src","img/player/pause_button.png");
			$("#stop_btn").attr("src","img/player/stop_button.png");
			currentSong=3;
			playSound();
			updateArtist();
			$jScroller.start();
		}).mouseover(function(){
			$(this).css("cursor","pointer");
		});
		
	});
});
