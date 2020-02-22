var currentPlaylist = new Array();
var shufflePlaylist = new Array();
var tmpPlaylist = new Array();
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;

$(document).click(function(click){
	var target = $(click.target);

	//if they are not clicking on the options or the menu itself then hide the menu
	if(!target.hasClass("item") && !target.hasClass("optionsBtn")){
		hideOptionsMenu();
	}
});

$(window).scroll(function(){
	hideOptionsMenu();
});

//when the select is changed, we are going to execute this function
$(document).on("change" , "select.playlist" , function(){

	var select = $(this);
	var playlistId = select.val(); //this refers to the element which this event was fired on "select"
	//prev -> to get the previous ancestor which is the input element.
	var songId = select.prev(".songId").val();

	//console.log("playlistId : " + playlistId);
	//console.log("Song Id : " + songId);

	$.post("Includes/Handlers/ajax/addToPlaylist.php" , {playlistId: playlistId , songId: songId})
	.done(function(error){

		if(error!=""){
			alert(error);
			return;
		}

		hideOptionsMenu();
		$(select).val("");
	});

});


function openPage(url){

	if(timer != null)
		clearTimeout(timer);

	if(url.indexOf("?") == -1){
		url +="?";
	}

	var encodedUrl = encodeURI(url + "&userLoggedIn=" +  userLoggedIn);
	console.log(encodedUrl);
	$("#mainContent").load(encodedUrl);
	$("body").scrollTop(0);
	history.pushState(null , null , url);

}

function removeFromPlaylist(button , playlistId){

	var songId = $(button).prevAll(".songId").val();	

	$.post("Includes/Handlers/ajax/removeFromPlaylist.php",{ playlistId: playlistId, songId:songId })
	.done(function(error){

		if(error != ""){ 
			alert(error);
			return;
		}

		//do something when ajax returns.
		openPage("playlist.php?id=" + playlistId); //basically just a page refresh.
	});

}

function createPlaylist(){
	console.log(userLoggedIn);
	var popup = prompt("Please enter the name of your playlist");

	if(popup != null){
		//INSERT IN QUERY.

		$.post("Includes/Handlers/ajax/createPlaylist.php",{name:popup , username: userLoggedIn})
		.done(function(error){

			if(error != ""){
				alert(error);
				return;
			}

			//do something when ajax returns.
			openPage("yourMusic.php"); //basically just a page refresh.
		});
	}

}

function deletePlaylist(playlistId){
	var prompt = confirm("Are you sure you want to delete this playlist?");

	if(prompt){

		$.post("Includes/Handlers/ajax/deletePlaylist.php",{ playlistId: playlistId })
		.done(function(error){

			if(error != ""){ 
				alert(error);
				return;
			}

			//do something when ajax returns.
			openPage("yourMusic.php"); //basically just a page refresh.
		});

	}
}

function playFirstSong(){

	setTrack(tmpPlaylist[0] , tmpPlaylist , true);

}


function showOptionsMenu(button){

	var songId = $(button).prevAll(".songId").val();
	var menu = $(".optionsMenu");

	var menuWidth = menu.width();
	menu.find(".songId").val(songId);

	//takes the position from the top of the scrolled window aand how far were that is from
	//the top of the document itself.
	var scrollTop = $(window).scrollTop(); // distance from top of window to top of page/document
	var elementOffset = $(button).offset().top; // distance from button to top of doc

	var top = elementOffset - scrollTop;
	var left = $(button).position().left; // how far from the left the position of the btn is.

	menu.css({ "top": top + "px" , "left": left - menuWidth + "px" , "display": "inline" });


}

function hideOptionsMenu(){

	var menu = $(".optionsMenu");

	if(menu.css("dispaly") != "none"){
		menu.css("display" , "none"); 
	}

}

function updateEmail(emailClass){

	var emailValue = $("." + emailClass).val();

	$.post("Includes/Handlers/ajax/updateEmail.php" , {email:emailValue , username: userLoggedIn})
	.done(function(response){

		$("." + emailClass).nextAll(".message").text(response);
	});

}

function updatePassword(oldPasswordClass , newPasswordClass1 , newPasswordClass2){

	var oldPassword = $("." + oldPasswordClass).val();
	var newPassword1 = $("." + newPasswordClass1).val();
	var newPassword2 = $("." + newPasswordClass2).val();


	$.post("Includes/Handlers/ajax/updatePassword.php" , 
		{oldPassword:oldPassword ,username: userLoggedIn, 
			newPassword1: newPassword1 , newPassword2:newPassword2})
	.done(function(response){

		$("." + emailClass).nextAll(".message").text(response);
	});

}

function logout(){

	$.post("Includes/Handlers/ajax/logout.php" , function(){
		location.reload();
	});

}

function formatTime(seconds){
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60);
	var seconds = time - (minutes * 60);
	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio){
	$(".progressTime.current").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

	var progress = audio.currentTime / audio.duration * 100;
	$(".playbackBar .progress").css("width" , progress+"%");
}

function updateVolumeProgressBar(audio){
	var volume = audio.volume * 100; //audio.volume element is always a decimal between [0,1].
	$(".volumeBar .progress").css("width" , volume+"%");	
}

function Audio(){

	this.currentlyPlaying;
	this.audio = document.createElement('audio');
	this.audio.addEventListener("canplay" , function(){
		// 'this' refers to the object that the event was called on , which here is audio object.
		var duration = formatTime(this.duration);
		$(".progressTime.remaining").text(duration); // dont do this -->  this.audio.duration.

	});


	this.audio.addEventListener("ended", function(){
		nextSong();
	});

	this.audio.addEventListener("timeupdate" , function(){

		if(this.duration){
			updateTimeProgressBar(this);
		}
	});

	this.audio.addEventListener("volumechange" , function(){
		updateVolumeProgressBar(this);
	});

	this.setTrack = function(track){
		this.currentlyPlaying = track;
		this.audio.src = track.path;
	}

	this.play = function(){
		this.audio.play();
	}
 
	this.pause = function(){
		this.audio.pause();
	}

	this.setTime = function(seconds){
		this.audio.currentTime = seconds;
	}

}