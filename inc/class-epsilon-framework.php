<?php

if ( ! class_exists( 'Epsilon_Framework' ) ) {
	class Epsilon_Framework {
		public function __construct( $controls ) {
			wp_enqueue_style( 'epsilon-style', plugins_url( 'epsilon-framework/assets/css/style.css', __FILE__ ) );

			/**
			 * Custom controls
			 */
			$path = plugin_dir_path( dirname( __FILE__ ) ) . '/inc/epsilon-framework';

			foreach ( $controls as $control ) {
				if ( file_exists( $path . '/control-epsilon-' . $control . '.php' ) ) {
					require_once $path . '/control-epsilon-' . $control . '.php';
				}
			}
		}
	}

	function shapely_customize_register_epsilon() {
		$controls = array( 'slider-control', 'toggle', 'color-scheme' );
		$epsilon  = new Epsilon_Framework( $controls );
	}

	function shapely_customize_register_remove() {
		global $wp_customize;
		$wp_customize->remove_control( 'blogdescription' );
	}
	add_action( 'customize_register', 'shapely_customize_register_epsilon' );
	add_action( 'customize_register', 'shapely_customize_register_remove', 50 );

}
