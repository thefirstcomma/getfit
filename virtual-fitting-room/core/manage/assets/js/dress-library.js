( function( $ ) {
	$(function() {

		function xhr_post(formData) {
			return $.post({
				url 		: VIRTUAL_FITTING_ROOM.ajaxurl,
				dataType	: 'json',
				data 		: formData,
				encode		: true

			});
		}

		$('.delete').click(function() {
			xhr_post({
				action: 'vfr_delete_dress',
				nonce: VIRTUAL_FITTING_ROOM.nonce,
				// DATA
				dress_id: $(this).data('id')
			})
			.done(function(response) {
				window.location.reload(true); // makes the window refresh
				console.log(response);
			})
			.fail(function(response) {
				console.log(response);
			});
		});

	});
})( jQuery );