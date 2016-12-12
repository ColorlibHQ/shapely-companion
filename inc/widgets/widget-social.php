<?php

/**
 * Social  Widget
 * shapely Theme
 */
class shapely_social_widget extends WP_Widget {
	function __construct() {

		$widget_ops = array(
			'classname'                   => 'shapely-social',
			'description'                 => esc_html__( "shapely Social Widget", 'shapely' ),
			'customize_selective_refresh' => true
		);
		parent::__construct( 'shapely-social', esc_html__( '[Shapely] Social Widget', 'shapely' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = isset( $instance['title'] ) ? esc_html( $instance['title'] ) : esc_html__( 'Follow us', 'shapely' );

		if ( ! function_exists( 'shapely_social_icons' ) ) {
			echo __( 'This widget works only with Shapely theme. Please install and activate it first.', 'shapely' );
		}
		echo $before_widget;
		echo $before_title;
		echo $title;
		echo $after_title;

		/**
		 * Widget Content
		 */
		?>

		<!-- social icons -->
		<div class="social-icons sticky-sidebar-social">


			<?php shapely_social_icons(); ?>


		</div><!-- end social icons -->


		<?php

		echo $after_widget;
	}


	function form( $instance ) {
		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = esc_html__( 'Follow us', 'shapely' );
		}
		?>

		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title ', 'shapely' ) ?></label>

			<input type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       class="widefat"/>
		</p>

		<?php
	}

}

?>
