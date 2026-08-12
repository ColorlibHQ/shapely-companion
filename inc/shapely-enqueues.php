<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
add_action( 'admin_enqueue_scripts', 'shapely_companion_admin_scripts' );
function shapely_companion_admin_scripts( $hook ) {
	wp_enqueue_style( 'shapely-companion-admin-css', plugins_url( 'assets/css/admin.css', dirname( __FILE__ ) ) );
	wp_enqueue_script( 'shapely-companion-admin-js', plugins_url( 'assets/js/admin.js', dirname( __FILE__ ) ), array( 'jquery' ) );
	wp_localize_script(
		'shapely-companion-admin-js', 'shapelyCompanion', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( "welcome_nonce" ),
		)
	);
	if ( 'widgets.php' == $hook || 'customize.php' == $hook ) {
		wp_enqueue_media();
		wp_enqueue_script( 'shapely_cloneya_js', plugins_url( 'assets/js/vendor/jquery-cloneya.min.js', dirname( __FILE__ ) ), array( 'jquery' ) );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'widget-js', plugins_url( 'assets/js/widget.js', dirname( __FILE__ ) ), array( 'media-upload', 'wp-color-picker' ), '1.0', true );
		/*
		 * Font Awesome for the widget forms' icon fields.
		 *
		 * This used to load '/assets/css/font-awesome.min.css' from the theme
		 * under the generic 'font-awesome' handle. Two problems: Shapely 1.2.21
		 * removed that file when it moved to Font Awesome 6, so the request
		 * 404s; and claiming the generic handle can suppress whatever else on
		 * the page wanted to register it.
		 *
		 * Point at the theme's Font Awesome 6 under our own handle, and only if
		 * it is actually there -- the widgets work without it, the icon
		 * previews just render as blanks.
		 */
		$fa_path = get_template_directory() . '/assets/css/fontawesome6/all.min.css';

		if ( file_exists( $fa_path ) ) {
			wp_enqueue_style(
				'shapely-companion-font-awesome',
				get_template_directory_uri() . '/assets/css/fontawesome6/all.min.css',
				array(),
				'6.4.2'
			);
		}
	}

	if ( 'nav-menus.php' == $hook ) {
		wp_enqueue_script( 'shapley-nav-menu-js', plugins_url( 'assets/js/nav-menu.js', dirname( __FILE__ ) ), array( 'nav-menu' ), '1.0', true );
	}

}

function shapely_companion_customizer_live_preview() {
	wp_enqueue_script( 'shapely-companion-previewer', plugins_url( 'assets/js/previewer.js', dirname( __FILE__ ) ), array( 'jquery', 'customize-preview' ), '', true );
}
add_action( 'customize_preview_init', 'shapely_companion_customizer_live_preview' );
