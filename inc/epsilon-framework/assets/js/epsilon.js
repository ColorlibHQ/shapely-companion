/**
 * File epsilon.js.
 *
 *
 * Epsilon Framework
 */

(function ($) {
	var EpsilonFramework = {};

	EpsilonFramework.rangeSliders = function (selector) {
		var context = $(selector),
				slider = context.find('.ss-slider'),
				input = context.find('.rl-slider'),
				input_id = input.attr('id'),
				id = slider.attr('id'),
				min = $('#' + id).attr('data-attr-min'),
				max = $('#' + id).attr('data-attr-max'),
				step = $('#' + id).attr('data-attr-step');

		$('#' + id).slider({
			value: $('#' + input_id).attr('value'),
			range: 'min',
			min  : parseFloat(min),
			max  : parseFloat(max),
			step : parseFloat(step),
			slide: function (event, ui) {
				$('#' + input_id).attr('value', ui.value).change();
			}
		});

		$(input).on('focus', function () {
			$(this).blur();
		});

		$('#' + input_id).attr('value', ($('#' + id).slider("value")));
		$('#' + input_id).change(function () {
			$('#' + id).slider({
				value: $(this).val()
			});
		});
	};

	EpsilonFramework.colorSchemes = function (selector) {
		/**
		 * Set variables
		 */
		var context = $(selector),
				options = context.find('.mte-color-option'),
				input = context.parent().find('.mte-color-scheme-input'),
				json = $.parseJSON(options.first().find('input').val()),
				api = wp.customize,
				colorSettings = [],
				css = {
					action: 'shapely_generate_css',
					data  : {}
				};

		$.each(json, function (index, value) {
			index = index.replace(/-/g, '_');
			colorSettings.push('epsilon_' + index + '_color');
		});

		function updateCSS() {
			_.each(colorSettings, function (setting) {
				css.data[ setting ] = api(setting)();
			});
			api.previewer.send('update-inline-css', css);
		}

		_.each(colorSettings, function (setting) {
			api(setting, function (setting) {
				setting.bind(updateCSS);
			});
		});

		/**
		 * On clicking a color scheme, update the color pickers
		 */
		$('.mte-color-option').on('click', function () {
			var val = $(this).attr('data-color-id'),
					json = $.parseJSON($(this).find('input').val());

			/**
			 * find the customizer options
			 */
			$.each(json, function (index, value) {
				index = index.replace(/-/g, '_');
				colorSettings.push('epsilon_' + index + '_color');
				/**
				 * Set values
				 */
				wp.customize('epsilon_' + index + '_color').set(value);
			});

			/**
			 * Remove the selected class from siblings
			 */
			$(this).siblings('.mte-color-option').removeClass('selected');
			/**
			 * Make active the current selection
			 */
			$(this).addClass('selected');
			/**
			 * Trigger change
			 */
			input.val(val).change();

			_.each(colorSettings, function (setting) {
				api(setting, function (setting) {
					setting.bind(updateCSS());
				});
			});
		});
	};

	$(document).on('widget-updated widget-added', function (a, selector) {
		EpsilonFramework.rangeSliders(selector);
	});

	if ( typeof(wp) !== 'undefined' ) {
		if ( typeof(wp.customize) !== 'undefined' ) {
			wp.customize.bind('ready', function () {
				EpsilonFramework.colorSchemes('.mte-color-scheme');
			});
		}
	}

})(jQuery);