( function( $ ) {
	$(function() {

		var additional_size = 0;
		$('#layer1 path').attr("transform", "scale(0.5,1)");

		function xhr_post(formData) {
			return $.post({
				url 		: PROFILE.ajaxurl,
				dataType	: 'json',
				data 		: formData,
				encode		: true

			});
		}

		$('.delete').click(function() {
			xhr_post({
				action: 'vfr_delete_save',
				nonce: PROFILE.nonce,
				// DATA
				dress_id: $(this).data('id')
			}).done(function(response) {
				window.location.reload(true); // makes the window refresh
				console.log(response);
			}).fail(function(response) {
				console.log(response);
			});
		});

		$('.btn-view-save').click(function() {
			xhr_post({
				action: 'vfr_additional_size',
				nonce: PROFILE.nonce,
				// DATA
				id: $(this).data('id')
			}).done(function(response) {
				console.log("Response: " + response);

				additional_size = response;
			}).fail(function(response) {
				console.log(response);
			});

			xhr_post({
				action: 'vfr_get_dress_location_by_id',
				nonce: PROFILE.nonce,
				// DATA
				dress_id: $(this).data('dress')
			}).done(function(response) {
				console.log(response);

				loadImage("arm-left");
				loadImage("arm-right");
				loadImage("chest");
				loadImage("hips");
				loadImage("legs");
				loadImage("waist");
				loadDressImage(response);
			}).fail(function(response) {
				console.log(response);
			});

			$('.modal-title').text($(this).data('title'));
			$('.body-measurements .height').text("Height: " + $(this).data('height'));
			$('.body-measurements .chest').text("Chest: " + $(this).data('chest'));
			$('.body-measurements .waist').text("Waist: " + $(this).data('waist'));
			$('.body-measurements .hips').text("Hips: " + $(this).data('hips'));
			$('.body-measurements .inseam').text("Inseam: " + $(this).data('inseam'));
			$('.body-measurements .size').text("Dress size: " + $(this).data('size'));
		});

		var images = {};

		function loadImage(name) {
			images[name] = new Image();
			images[name].onload = function() { 
				resourceLoaded();
			}
			images[name].src = PROFILE.dress_images_dir + name + ".png";
		}

		function loadDressImage(loc) {
			images["dress"] = new Image();
			images["dress"].onload = function() { 
				resourceLoaded();
			}
			images["dress"].src = PROFILE.uploads_dir + loc;
		}

		var totalResources = 6;
		var numResourcesLoaded = 0;
		var fps = 30;

		function resourceLoaded() {
			numResourcesLoaded += 1;
			if(numResourcesLoaded === totalResources) {
				setInterval(redraw, 1000 / fps);
			}
		}

		var context = document.getElementById('canvas').getContext("2d");

		var charX = 245;
		var charY = 185;

		function redraw() {
			var x = charX;
			var y = charY;

			canvas.width = 500; // clears the canvas 
			canvas.height = 500;

			// console.log(images["chest"].height);

			// $('#canvas').css('width', 500 + (additional_size * 2));
								
			context.drawImage(images["arm-left"], 0 + 29 - additional_size, 45, 100 + additional_size, 300);
			context.drawImage(images["arm-right"], x + 13, 50, 100 + additional_size, 300);
			context.drawImage(images["chest"], x / 2 + 7, 55, 130, 137);
			context.drawImage(images["dress"], -230, 85, 750, 800); // (dress, x-cord, y-cord, width, height)
			// context.drawImage(images["waist"], x / 2 + 5, y * 2 - 180, 138, 69);
			// context.drawImage(images["hips"], x / 2 - 18, y * 2 - 115);
			// context.drawImage(images["legs"], x / 2 - 25, y * 2);
			// if(additional_size < 0) {
			// 	context.drawImage(images["dress"], -175, 85, 650, 700); // (dress, x-cord, y-cord, width, height)
			// } else {
			// 	context.drawImage(images["dress"], -230, 85, 750, 800); // (dress, x-cord, y-cord, width, height)
			// }
		}

	});
})( jQuery );