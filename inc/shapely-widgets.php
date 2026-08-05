<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Widgets
 */
add_action( 'widgets_init', 'shapely_companion_widgets_init' );
function shapely_companion_widgets_init() {

	$widgets = array(
		'categories',
		'home-call-for-action',
		'home-clients',
		'home-features',
		'home-parallax',
		'home-contact',
		'home-portfolio',
		'home-testimonials',
		'recent-posts',
		'social',
		'video',
		'page-content',
		'page-title',
	);

	foreach ( $widgets as $widget ) {
		require_once plugin_dir_path( __FILE__ ) . '/widgets/class-shapely-' . $widget . '.php';
	}

	register_widget( 'Shapely_Recent_Posts' );
	register_widget( 'Shapely_Categories' );
	register_widget( 'Shapely_Home_Parallax' );
	register_widget( 'Shapely_Home_Features' );
	register_widget( 'Shapely_Home_Call_For_Action' );
	register_widget( 'Shapely_Home_Clients' );
	register_widget( 'Shapely_Video' );
	register_widget( 'Shapely_Home_Contact' );
	register_widget( 'Shapely_Social' );
	register_widget( 'Shapely_Page_Title' );
	register_widget( 'Shapely_Page_Content' );

	/*
	 * Gate on the post type rather than Jetpack's legacy module flag. Jetpack 13+
	 * registers the Portfolio/Testimonial CPTs without marking
	 * 'custom-content-types' active in jetpack_active_modules, so
	 * Jetpack::is_module_active() returns false even when the post types are
	 * registered and the site owner has enabled them -- which silently dropped
	 * both widgets, and with them the Projects and Testimonials sections of the
	 * demo homepage.
	 *
	 * Both signals are checked: wp_widgets_init() runs on init priority 1 while
	 * Jetpack registers its CPTs at priority 10, so post_type_exists() is still
	 * false here on a normal request -- the option covers that -- while
	 * post_type_exists() covers post types supplied by another plugin or a child
	 * theme without the Jetpack option being set.
	 */
	if ( post_type_exists( 'jetpack-portfolio' ) || get_option( 'jetpack_portfolio' ) ) {
		register_widget( 'Shapely_Home_Portfolio' );
	}

	if ( post_type_exists( 'jetpack-testimonial' ) || get_option( 'jetpack_testimonial' ) ) {
		register_widget( 'Shapely_Home_Testimonials' );
	}
}
