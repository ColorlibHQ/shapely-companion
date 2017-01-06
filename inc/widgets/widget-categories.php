<?php

/**
 * [Shapely] Categories Widget
 * shapely Theme
 */
class shapely_categories extends WP_Widget {
	function __construct() {
		add_action( 'admin_init', array( $this, 'enqueue' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'customize_preview_init', array( $this, 'enqueue' ) );

		$widget_ops = array(
			'classname'                   => 'shapely-cats',
			'description'                 => esc_html__( "Shapely Categories", 'shapely' ),
			'customize_selective_refresh' => true
		);
		parent::__construct( 'shapely-cats', esc_html__( '[Shapely] Categories', 'shapely' ), $widget_ops );
	}

	public function enqueue() {
		wp_enqueue_style( 'epsilon-styles', plugins_url( 'epsilon-framework/assets/css/style.css', dirname( __FILE__ ) ) );
		wp_enqueue_script( 'epsilon-object', plugins_url( 'epsilon-framework/assets/js/epsilon.js', dirname( __FILE__ ) ), array( 'jquery' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title        = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Categories', 'shapely' );
		$enable_count = !empty( $instance['enable_count'] ) ? $instance['enable_count'] : '';

		$limit = isset( $instance['limit'] ) ? $instance['limit'] : 4;

		echo $before_widget;
		echo $before_title;
		echo $title;
		echo $after_title;

		/**
		 * Widget Content
		 */
		?>
		<div class="cats-widget nolist">

			<ul class="category-list"><?php

				$args = array(
					'echo'       => 0,
					'show_count' => (int) $limit,
					'title_li'   => '',
					'depth'      => 1,
					'orderby'    => 'count',
					'order'      => 'DESC',
					'number'     => $limit,
				);

				$variable = wp_list_categories( $args );

				if ( $enable_count == 'on' ) {
					$variable = str_replace( "(", "<span>", $variable );
					$variable = str_replace( ")", "</span>", $variable );
				} else {
					$pattern  = '/\([0-9]+\)/';
					$variable = preg_replace( $pattern, '', $variable );
				}

				echo $variable; ?></ul>

		</div><!-- end widget content -->

		<?php

		echo $after_widget;
	}


	function form( $instance ) {
		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = esc_html__( 'Categories', 'shapely' );
		}
		if ( ! isset( $instance['limit'] ) ) {
			$instance['limit'] = 4;
		}
		if ( ! isset( $instance['enable_count'] ) ) {
			$instance['enable_count'] = '';
		}


		?>

		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title ', 'shapely' ) ?></label>

			<input type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       class="widefat"/>
		</p>

		<p><label
				for="<?php echo $this->get_field_id( 'limit' ); ?>"> <?php esc_html_e( 'Limit Categories ', 'shapely' ) ?></label>

			<input type="text" value="<?php echo esc_attr( $instance['limit'] ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"
			       class="widefat"/>
		</p>


		<div class="checkbox_switch">
				<span class="customize-control-title onoffswitch_label">
                    <?php _e( 'Enable Posts Count', 'shapely' ); ?>
				</span>
			<div class="onoffswitch">
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_name( 'enable_count' ) ); ?>"
				       name="<?php echo esc_attr( $this->get_field_name( 'enable_count' ) ); ?>"
				       class="onoffswitch-checkbox"
				       value="on"
					<?php checked( $instance['enable_count'], 'on' ); ?>>
				<label class="onoffswitch-label"
				       for="<?php echo esc_attr( $this->get_field_name( 'enable_count' ) ); ?>"></label>
			</div>
		</div>

		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                 = array();
		$instance['title']        = ( ! empty( $new_instance['title'] ) ) ? esc_html( $new_instance['title'] ) : '';
		$instance['limit']        = ( ! empty( $new_instance['limit'] ) ) ? absint( $new_instance['limit'] ) : '';
		$instance['enable_count'] = ( ! empty( $new_instance['enable_count'] ) ) ? esc_html( $new_instance['enable_count'] ) : '';

		return $instance;
	}
}

?>
