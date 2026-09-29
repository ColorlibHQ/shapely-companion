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
		shapely_companion_enqueue_font_awesome();
	}

	if ( 'nav-menus.php' == $hook ) {
		wp_enqueue_script( 'shapley-nav-menu-js', plugins_url( 'assets/js/nav-menu.js', dirname( __FILE__ ) ), array( 'nav-menu' ), '1.0', true );
	}

}

function shapely_companion_customizer_live_preview() {
	wp_enqueue_script( 'shapely-companion-previewer', plugins_url( 'assets/js/previewer.js', dirname( __FILE__ ) ), array( 'jquery', 'customize-preview' ), '', true );
}
add_action( 'customize_preview_init', 'shapely_companion_customizer_live_preview' );

/**
 * Font Awesome for the widget forms' icon fields.
 *
 * Loaded from the active Shapely theme, under our own handle so it cannot
 * suppress another copy registered as the generic 'font-awesome'. The theme
 * has moved its copy more than once, so use the newest layout present:
 *
 * - 1.3.7+: assets/css/fontawesome/all.min.css, the complete Font Awesome 7
 *   build including the v4 shims -- which is what the Features widget's
 *   stored "fa fa-paper-plane-o" style values need to render.
 * - 1.3.3 to 1.3.6: the same directory, split into fontawesome.min.css plus
 *   solid.min.css and brands.min.css, without shims.
 * - 1.2.21 to 1.3.2: assets/css/fontawesome6/all.min.css. Removed in 1.3.3,
 *   which is why the icon previews in the widget forms went blank.
 *
 * Versioned with the theme, because the files belong to it: a theme update
 * that rebuilds them must bust the browser cache.
 *
 * The widgets still work when none of these exist; the previews are blank.
 */
function shapely_companion_enqueue_font_awesome() {
	$layouts = array(
		array( 'assets/css/fontawesome/all.min.css' ),
		array( 'assets/css/fontawesome/fontawesome.min.css', 'assets/css/fontawesome/solid.min.css', 'assets/css/fontawesome/brands.min.css' ),
		array( 'assets/css/fontawesome6/all.min.css' ),
	);

	$dir     = get_template_directory();
	$uri     = get_template_directory_uri();
	$version = wp_get_theme( get_template() )->get( 'Version' );

	foreach ( $layouts as $files ) {
		if ( ! file_exists( $dir . '/' . $files[0] ) ) {
			continue;
		}

		$handle = 'shapely-companion-font-awesome';
		foreach ( $files as $i => $relative ) {
			if ( $i > 0 ) {
				$handle = 'shapely-companion-font-awesome-' . basename( $relative, '.min.css' );
			}
			wp_enqueue_style( $handle, $uri . '/' . $relative, $i > 0 ? array( 'shapely-companion-font-awesome' ) : array(), $version );
		}
		return;
	}
}

/**
 * Ask the theme for its complete icon set when a widget of ours needs it.
 *
 * Shapely 1.3.4+ loads only a subset of Font Awesome on the front end, and
 * the Features and Video widgets print icon classes chosen from the full list
 * (feature icons, play/pause), which render as empty squares against the
 * subset. Shapely 1.3.7 detects those two widgets itself; 1.3.4 to 1.3.6 only
 * honour this filter. On themes that predate the filter it is never applied.
 *
 * is_active_widget() reads the autoloaded sidebars_widgets option, so this
 * costs no query.
 *
 * @param bool $full Whether the theme already decided to load the full set.
 *
 * @return bool
 */
function shapely_companion_full_fontawesome( $full ) {
	if ( $full ) {
		return $full;
	}

	return is_active_widget( false, false, 'shapely_home_features' ) || is_active_widget( false, false, 'shapely_video_widget' );
}
add_filter( 'shapely_full_fontawesome', 'shapely_companion_full_fontawesome' );
