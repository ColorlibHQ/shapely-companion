<?php

/**
 * Social  Widget
 * shapely Theme
 */
class Shapely_Social extends WP_Widget {

	private $defaults = array();

	function __construct() {

		$widget_ops = array(
			'classname'                   => 'shapely-social',
			'description'                 => esc_html__( 'shapely Social Widget', 'shapely-companion' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'shapely-social', esc_html__( '[Shapely] Social Widget', 'shapely-companion' ), $widget_ops );

		$this->defaults = array(
			'title' => esc_html__( 'Follow us', 'shapely-companion' ),
		);
	}

	function widget( $args, $instance ) {

		$instance = wp_parse_args( $instance, $this->defaults );

		if ( ! function_exists( 'shapely_social_icons' ) ) {
			echo __( 'This widget works only with Shapely theme. Please install and activate it first.', 'shapely-companion' );
		}
		echo $args['before_widget'];
		echo $args['before_title'];
		echo esc_html( $instance['title'] );
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

	/**
	 * @param array $instance
	 *
	 * @return string|void
	 */
	function form( $instance ) {
		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = esc_html__( 'Follow us', 'shapely-companion' );
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php echo esc_html__( 'Title ', 'shapely-companion' ); ?>
			</label>
			<input type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" class="widefat"/>
		</p>

		<?php
	}

	/**
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_kses_post( $new_instance['title'] ) : '';

		return $instance;
	}

}
