jQuery(function( $ ) {
	'use strict';

	$('#vt_filter').keyup(function(){
		var value = $(this).val().toLowerCase();
		$('.vt_code').filter(function(){
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
		});
	});

});
