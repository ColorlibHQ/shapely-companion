<?php
/*
 * Plugin Name:       Shapely Companion
 * Plugin URI:        https://colorlib.com/wp/themes/shapely/
 * Description:       Shapely Companion is a companion plugin for Shapely theme.
 * Version:           1.0.5
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

define( 'SHAPELY_COMPANION', '1.0.5' );

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
 * WooCoomerce Support
 */
if ( class_exists( 'WooCommerce' ) ) {
	require_once plugin_dir_path( __FILE__ ) . '/inc/shapely-woo-setup.php';
}

/**
 * Epsilon Framework
 */
require_once plugin_dir_path( __FILE__ ) . '/inc/class-epsilon-framework.php';

/**
 * Color schemes
 */
require_once plugin_dir_path( __FILE__ ) . '/inc/class-epsilon-color-scheme.php';