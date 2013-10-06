/**
 * Scripts for cms admin login page
 */

function centerLoginBox(){

	var padding = ($('.body-wrap').height() - $('.login-wrap').outerHeight()) / 2;
	$('.body').css('padding-top', padding + 'px');

}

(function($){

	$(document).ready(function(){
		centerLoginBox();
		$('.login-wrap').addClass('animate')
	});
	$(window).resize(centerLoginBox);

})(jQuery);