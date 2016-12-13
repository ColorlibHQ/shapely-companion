<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'admin_enqueue_scripts', 'shapely_companion_admin_scripts' );
function shapely_companion_admin_scripts( $hook ) {

	wp_enqueue_style( 'shapely-companion-admin-css', plugins_url( 'assets/css/admin.css', dirname( __FILE__ ) ) );
	wp_enqueue_script( 'shapely-companion-admin-js', plugins_url( 'assets/js/admin.js', dirname( __FILE__ ) ), array( 'jquery' ) );
	wp_localize_script( 'shapely-companion-admin-js', 'shapelyCompanion', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	) );

	if ( $hook == 'widgets.php' || $hook == 'customize.php' ) {
		wp_enqueue_media();
		wp_enqueue_script( 'shapely_cloneya_js', plugins_url( 'assets/js/jquery-cloneya.min.js', dirname( __FILE__ ) ), array( 'jquery' ) );
		wp_enqueue_script( 'widget-js', plugins_url( 'assets/js/widget.js', dirname( __FILE__ ) ), array( 'media-upload' ), '1.0', true );

		// Add Font Awesome stylesheet
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/inc/css/font-awesome.min.css' );
	}
}


function shapely_customize_previewer_js() {
	wp_enqueue_script( 'epsilon_customizer', plugins_url( '/inc/epsilon-framework/assets/js/previewer.js', dirname( __FILE__ ) ), array( 'customize-preview' ), false, true );

	wp_localize_script( 'epsilon_customizer', 'WPUrls', array(
		'siteurl' => get_option( 'siteurl' ),
		'theme'   => get_template_directory_uri(),
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	) );
}

function shapely_customizer_enqueue_scripts() {
	wp_enqueue_script( 'epsilon-object', plugins_url( '/inc/epsilon-framework/assets/js/epsilon.js', dirname( __FILE__ ) ), array( 'jquery' ), false, true );
	wp_enqueue_script( 'customizer-scripts', plugins_url( '/inc/epsilon-framework/assets/js/customizer.js', dirname( __FILE__ ) ), array( 'customize-controls' ), false, true );
	wp_localize_script( 'epsilon-object', 'WPUrls', array(
		'siteurl' => get_option( 'siteurl' ),
		'theme'   => get_template_directory_uri(),
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	) );
}

add_action( 'customize_controls_enqueue_scripts', 'shapely_customizer_enqueue_scripts' );
add_action( 'customize_preview_init', 'shapely_customize_previewer_js' );