<?php
/*
 * Plugin Name:       Shapely Companion
 * Plugin URI:        https://colorlib.com/wp/themes/shapely/
 * Description:       Shapely Companion is a companion plugin for Shapely theme.
 * Version:           1.0.6
 * Author:            Colorlib
 * Author URI:        https://colorlib.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shapely-companion
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'SHAPELY_COMPANION', '1.0.6' );

/**
 * Load the Dashboard Widget
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/epsilon-dashboard/class-epsilon-dashboard.php';

/**
 * The helper method to run the class
 *
 * @return Epsilon_Dashboard
 */
function shapely_companion_dashboard_widget() {
	$epsilon_dashboard_args = array(
		'widget_title' => esc_html__( 'WordPress News', 'shapely-companion' ),
		'feed_url'  => array( 'https://colorlib.com/wp/feed/' ),
	);
	return Epsilon_Dashboard::instance( $epsilon_dashboard_args );
}

shapely_companion_dashboard_widget();

/**
 * Load the Widgets
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/shapely-widgets.php';

/**
 * Load Enqueues
 */
require_once plugin_dir_path( __FILE__ ) . '/inc/shapely-enqueues.php';


/**
 * Load Helper
 */
require_once plugin_dir_path( __FILE__ ) . '/inc/shapely-helper.php';

/**
 * Load Import Demo Content Functionality
 */
require_once plugin_dir_path( __FILE__ ) . '/inc/shapely-demo-content.php';

/**
 * Load Metabox for Portfolio
 */
if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'custom-content-types' ) ) {
	$jetpack_portfolio = get_option( 'jetpack_portfolio' );
	if ( $jetpack_portfolio ) {
		require_once plugin_dir_path( __FILE__ ) . '/inc/shapely-metabox.php';
	}
}
