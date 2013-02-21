$(document).ready(function () {
	$('li.hasmore').css( 'cursor', 'pointer' ).click(function () {
		$('ul.dropdown').slideToggle('medium');
	}).mouseleave(function () {
		$('ul.dropdown').slideUp('medium');
	});
});

$(document).ready(function () {
	$('li#nav-album').css( 'cursor', 'pointer' ).click(function () {
		$('ul#nav-album-down').slideToggle('medium');
	}).mouseleave(function () {
		$('ul#nav-album-down').slideUp('fast');
	});
});

$(document).ready(function () {
	$('li#nav-song').css( 'cursor', 'pointer' ).click(function () {
		$('ul#nav-song-down').slideToggle('medium');
	}).mouseleave(function () {
		$('ul#nav-song-down').slideUp('fast');
	});
});