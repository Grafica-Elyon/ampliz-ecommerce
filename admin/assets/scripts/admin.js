import 'jquery-mask-plugin';
import 'jquery.repeater';

(function () {
	$('.mp-repeater').each(function(i, e) {
		let repeater = $(e).repeater({
			initEmpty: true,
			show: function () {
				$(this).slideDown();
			}
		});

		let name = $(e).attr('data-valueFrom'),
			form = $(e).parents('form');

		if(typeof name !== 'undefined') {
			let json = form.find(name).val();
			json = JSON.parse(json);
			repeater.setList(json);

			if(name == "[name='product_producao_imagens']") {
				repeater.find('[data-repeater-item]').each(function(i,e) {
					$(e).find('.image-preview').attr('src', json[i].image);
				});
			}
		}
	});

	// Uploading files
	var file_frame;
	var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
	var set_to_post_id = null; // Set this
	$(document).on("click", '.media-library-field [type="button"]', function( event ){
		event.preventDefault();

		var parent = $(event.currentTarget).parent('.media-library-field');

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select a image to upload',
			button: {
				text: 'Use this image',
			},
			multiple: false	// Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			var attachment = file_frame.state().get('selection').first().toJSON();
			// Do something with attachment.id and/or attachment.url here
			parent.find('.image-preview').attr( 'src', attachment.url ).css( 'width', 'auto' );
			parent.find('.attachment_field').val( attachment.id );

			console.log(parent.find('.attachment_field').attr('name'));

			// Restore the main post ID
			wp.media.model.settings.post.id = wp_media_post_id;
		});
			// Finally, open the modal
			file_frame.open();
	});

	// Restore the main ID when the add media button is pressed
	$( 'a.add_media' ).on( 'click', function() {
		wp.media.model.settings.post.id = wp_media_post_id;
	});

})(jQuery);
