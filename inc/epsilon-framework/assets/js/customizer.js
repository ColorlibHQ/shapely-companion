/**
 * File customizer.js.
 *
 */

(function ($) {
	jQuery(document).ready(function ($) {
		/**
		 * Bind an event for the add new widget
		 */
		$('.add-new-widget').on('click', function (event) {
			/**
			 * Define variables used in the script
			 * @type {any}
			 */
			var parent = $(this).parent(),
					id = parent.attr('id'),
					search = $('#widgets-search').parent(),
					widgetList = $('#available-widgets-list').find('.widget-tpl');

			/**
			 * Reset the widget display state
			 */
			$.each(widgetList, function ($k, $v) {
				$(this).show();
			});

			/**
			 * Initiate a switch for the sidebars
			 */
			switch ( id ) {
					/**
					 * In content, show only builder item
					 */
				case 'customize-control-sidebars_widgets-sidebar-home':
					$.each(widgetList, function ($k, $v) {
						var individualId = $(this).attr('data-widget-id');
						if ( individualId.search('shapely') === -1 ) {
							$(this).hide();
						}

					});
					search.hide();
					break;

				case 'customize-control-sidebars_widgets-sidebar-1':
				case 'customize-control-sidebars_widgets-footer-widget-1':
				case 'customize-control-sidebars_widgets-footer-widget-2':
				case 'customize-control-sidebars_widgets-footer-widget-3':
				case 'customize-control-sidebars_widgets-footer-widget-4':
					$.each(widgetList, function ($k, $v) {
						var individualId = $(this).attr('data-widget-id');
						if ( individualId.search('shapely') !== -1 ) {
							$(this).hide();
						}

					});
					search.hide();
					break;
			}
		});
	});
})(jQuery);