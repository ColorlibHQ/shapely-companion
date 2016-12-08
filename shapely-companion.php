<?php
/*
 * Plugin Name:       Shapely Companion
 * Plugin URI:        http://colorlib.com/wp/themes/shapely/
 * Description:       Shapely Companion is a companion plugin for Shapely theme.
 * Version:           1.0.2
 * Author:            Colorlib
 * Author URI:        http://colorlib.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shapely-companion
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'SHAPELY_COMPANION', '1.0.2' );

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