$(function() {
	$('#quotehead-form').submit(function(e) {
		e.preventDefault();
		var formid = '#'+$(this).attr('id');
		var qnbr = $(this).find('$qnbr');
		isformcomplete($(this));
	});
});