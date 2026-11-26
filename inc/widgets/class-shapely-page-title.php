<?php

/**
 * Page Title Widget
 * shapely Theme
 */
class Shapely_Page_Title extends WP_Widget {

	function __construct() {

		$widget_ops = array(
			'classname'                   => 'shapely-page-title',
			'description'                 => esc_html__( 'This widget is used only in pages with Template Widget', 'shapely-companion' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'shapely-page-title', esc_html__( '[Shapely] Page Title', 'shapely-companion' ), $widget_ops );
	}

	function widget( $args, $instance ) {

		/*
		 * The title bar is rendered by the theme. This used to print the notice
		 * below and then call shapely_top_callout() anyway, which is a fatal
		 * "call to undefined function" whenever the theme is not providing it.
		 * The notice is for whoever can fix it, not for visitors.
		 */
		if ( ! function_exists( 'shapely_top_callout' ) ) {
			if ( current_user_can( 'edit_theme_options' ) ) {
				echo esc_html__( 'This widget works only with Shapely theme. Please install and activate it first.', 'shapely-companion' );
			}
			return;
		}

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Markup from the theme's register_sidebar(); escaping would mangle it.

		?>

		<div class="header-callout">
			<?php shapely_top_callout(); ?>
		</div>

		<?php

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Markup from the theme's register_sidebar(); escaping would mangle it.
	}


	function form( $instance ) {
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $new_instance;

		return $instance;
	}

}
