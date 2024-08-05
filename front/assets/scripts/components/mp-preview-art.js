import Components from '../Components';

export default function (el) {

	let icon    = $('.mp-preview-art-icon', el);
	let preview = $('.mp-preview-art-preview', el);
	let pagination = $('.preview-pagination', el);

	let showModel = () => {
		preview.attr('data-show', 'true');
		resetFlips();
	}

	let hideModel = () => {
		preview.attr('data-show', 'false');
		resetFlips();
	}

	let onImageLoad = ( image ) => {
		let width = image.naturalWidth;
		let height = image.naturalHeight;
		$( image )
		.parents('.mp-preview-image')
		.addClass(width > height ? 'mp-preview-art-horizontal' : 'mp-preview-art-vertical')
		// .css({
		//     '--image-width': width.toString(),
		//     '--image-height': height.toString()
		// });
	}

	let registerEvents = () => {
		icon.click(showModel);
		preview.mousedown(hideModel);
		preview.children().mousedown( e => e.stopPropagation() );
		preview.find('.mp-painel-close').click(hideModel);
		preview.find('.mp-btn-group-selection button').click(setPreviewType);
		pagination.find('.mp-pagination-list a').click(paginate);

		enableFlip();

		$(el).find('img')
		.on('error', function () {
			$(this).attr('data-error', true).hide();
		})
		.on('load', function () {
			onImageLoad( this );
		})
	}

	let resetFlips = () => {
		let flip = $('.mp-preview-image-flip', el);
		flip.each(function () {
			const self = $(this);
			const values = self.data('values');
			values.rotateY = 0;
			values.rotateX = 0;
			values.mouseX = 0;
			values.mouseY = 0;
			values.isClicked = null;
			self.css('transform', 'rotate(0)');
		})
	}

	let enableFlip = () => {
		let flip = $('.mp-preview-image-flip', el);
		flip.each(function () {
			var self = $(this);
			var parent = self.parent().parent();

			// return;

			var isClicked = false;

			var velocityX = 360;
			var velocityY = 180;

			var lastValues = {
				rotateY: 0,
				rotateX: 0,
				mouseX: 0,
				mouseY: 0,
				isClicked: null
			}

			self.data('values', lastValues);

			let updateCursor = () => {
				if ( isClicked !== lastValues.isClicked ) {
					parent.css('cursor', isClicked ? 'grabbing' : 'grab');
					lastValues.isClicked = isClicked;
				}
			}
			updateCursor();

			parent.on('mousedown', function (e) {
				e.preventDefault();
				// isClicked = true;
				// updateCursor();
				lastValues.mouseY = e.pageY;
				lastValues.mouseX = e.pageX;
			});

			parent.on('mouseup', function (e) {
				e.preventDefault();
				// isClicked = false;
				// updateCursor();
			});

			parent.on('mouseleave', function (e) {
				e.preventDefault();
				$(e.target).trigger('mouseup');
			});

			parent.on('mousemove', function (e) {
				e.preventDefault();
				if ( !isClicked ) return;

				// Remove o icone de ajuda
				self.removeClass('with-help');

				self.attr('enabled') !== 'true'

				var parentOffset = parent.offset();
				var parentWidth  = parent.width();
				var parentHeight = parent.height();

				var transform = '';

				if ( !e.ctrlKey ) {
					var relY = e.pageY - lastValues.mouseY;
					var rotateY = (velocityY * relY / parentHeight) + lastValues.rotateY;
					transform += ' rotateX( '+rotateY+'deg )';
					lastValues.mouseY = e.pageY;
					lastValues.rotateY = rotateY;
				}
				else if ( lastValues.rotateY ) {
					transform += ' rotateX( '+lastValues.rotateY+'deg )';
				}

				if ( !e.shiftKey ) {
					var relX = e.pageX - lastValues.mouseX;
					var rotateX = (velocityX * relX / parentWidth) + lastValues.rotateX;
					transform += ' rotateY( '+rotateX+'deg )';
					lastValues.mouseX = e.pageX;
					lastValues.rotateX = rotateX;
				}
				else if ( lastValues.rotateX ) {
					transform += ' rotateY( '+lastValues.rotateX+'deg )';
				}

				// self.css('transform', transform || 'rotate(0)');

			});
		})
	}

	let setPreviewType = ( event ) => {
		let target = $(event.target);
		let type = target.val();

		let previousSelected = target.parent().find('.mp-btn-primary');

		previousSelected.removeClass('mp-btn-primary').addClass('mp-btn-darker-transparent');
		target.removeClass('mp-btn-darker-transparent').addClass('mp-btn-primary');

		$('.mp-preview', el).each(function (index, element) {
			element = $(element);
			if ( element.is('.mp-preview-'+type) ) {
				element.show();
				element.find('.mp-pagination-list li:first-child a').click();
			}
			else {
				element.hide();
			}
			element[ element.is('.mp-preview-'+type) ? 'show' : 'hide' ]();
		})

	}

	let paginate = ( event ) => {
		let target = $(event.target);
		let page = target.data('page');
		let listItem = target.parent();

		let previewType = target.parents('.mp-preview');

		pagination.find('.active').removeClass('active');
		listItem.addClass('active');

		previewType.find('.mp-preview-image.active').removeClass('active');
		previewType.find('.mp-preview-image[data-art="'+page+'"]').addClass('active');

		resetFlips();
	}

	registerEvents();
}
