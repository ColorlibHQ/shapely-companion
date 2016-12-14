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
		'home-portfolio',
		'home-testimonials',
		'recent-posts',
		'social',
		'video'
	);

	foreach ( $widgets as $widget ) {
		require_once plugin_dir_path( __FILE__ ) . '/widgets/widget-' . $widget . '.php';
	}

	register_widget( 'shapely_recent_posts' );
	register_widget( 'shapely_categories' );
	register_widget( 'shapely_home_parallax' );
	register_widget( 'shapely_home_features' );
	register_widget( 'shapely_home_CFA' );
	register_widget( 'shapely_home_clients' );
	register_widget( 'shapely_video' );

	if ( defined( 'JETPACK__VERSION' ) ) {
		register_widget( 'shapely_home_testimonial' );
		register_widget( 'shapely_home_portfolio' );
	}
}