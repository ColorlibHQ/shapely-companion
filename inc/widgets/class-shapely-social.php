<?php

/**
 * Social  Widget
 * shapely Theme
 */
class Shapely_Social extends WP_Widget {
	function __construct() {

		$widget_ops = array(
			'classname'                   => 'shapely-social',
			'description'                 => esc_html__( 'shapely Social Widget', 'shapely-companion' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'shapely-social', esc_html__( '[Shapely] Social Widget', 'shapely-companion' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		$title = isset( $instance['title'] ) ? wp_kses_post( $instance['title'] ) : esc_html__( 'Follow us', 'shapely-companion' );

		if ( ! function_exists( 'shapely_social_icons' ) ) {
			echo __( 'This widget works only with Shapely theme. Please install and activate it first.', 'shapely-companion' );
		}
		echo $args['before_widget'];
		echo $args['before_title'];
		echo $title;
		echo $args['after_title'];

		/**
		 * Widget Content
		 */
		?>

		<!-- social icons -->
		<div class="social-icons sticky-sidebar-social">


			<?php shapely_social_icons(); ?>


		</div><!-- end social icons -->


		<?php

		echo $args['after_widget'];
	}


	function form( $instance ) {
		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = esc_html__( 'Follow us', 'shapely-companion' );
		}
		?>

		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title ', 'shapely-companion' ); ?></label>

			<input type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				   id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   class="widefat"/>
		</p>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_kses_post( $new_instance['title'] ) : '';

		return $instance;
	}

}

?>
