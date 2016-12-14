jQuery(document).ready(function () {
	jQuery('#demo_content .button').click(function (evt) {
		evt.preventDefault();
		var currentButton = jQuery(this);
		jQuery(this).addClass('disabled');
		jQuery(this).next('.spinner').addClass('is-active');

		var ajaxData = { action: 'shapely_companion_import_content', import: jQuery(this).data('action') };

		jQuery.ajax({
			type   : "POST",
			data   : ajaxData,
			url    : shapelyCompanion.ajaxurl,
			success: function (data) {
				if ( data == 'succes' ) {
					currentButton.removeClass('disabled');
					currentButton.next('.spinner').removeClass('is-active');
					currentButton.parent().parent().find('.updated-message').show();
					location.reload();
				}
			}
		});

	});
});

jQuery(function ($) {
	mediaControl = {
		// Initializes a new media manager or returns an existing frame.
		// @see wp.media.featuredImage.frame()
		selector : null,
		size     : null,
		container: null,
		frame    : function () {
			if ( this._frame )
				return this._frame;

			this._frame = wp.media({
				title   : 'Media',
				button  : {
					text: 'Update'
				},
				multiple: false
			});

			this._frame.on('open', this.updateFrame).state('library').on('select', this.select);

			return this._frame;
		},

		select: function () {
			// Do something when the "update" button is clicked after a selection is made.
			var id = $('.attachments').find('.selected').attr('data-id');
			var selector = $('.shapely-media-control').find(mediaControl.selector);

			console.log($('.attachments').find('.selected'));
			if ( !selector.length ) {
				return false;
			}

			var data = {
				action       : 'shapely_get_attachment_media',
				attachment_id: id
			};

			jQuery.post(ajaxurl, data, function (response) {
				var ext = response.substr((response.lastIndexOf('.') + 1));
				if ( ext == 'mp4' ) {
					$(mediaControl.container).find('.video-path').text(response);
				} else {
					$(mediaControl.container).find('img').attr('src', response);
				}

				selector.val(response).change();
			});
		},

		init: function () {
			var context = $('#wpbody, .wp-customizer');
			context.on('click', '.shapely-media-control > .upload-button', function (e) {
				e.preventDefault();
				var container = $(this).parent(),
						sibling = container.find('.image-id'),
						id = sibling.attr('id');

				mediaControl.size = $('[data-delegate="' + id + '"]').val();
				mediaControl.container = container;
				mediaControl.selector = '#' + id;
				mediaControl.frame().open();
			});

			context.on('click', '.shapely-media-control > .remove-button', function (e) {
				e.preventDefault();
				var container = $(this).parent(),
						sibling = container.find('.image-id'),
						img = container.find('img'),
						span = container.find('.video-path');

				img.attr('src', '');
				span.text('');
				console.log(span);
				sibling.val('').trigger('change');
			})
		}
	};

	mediaControl.init();
});