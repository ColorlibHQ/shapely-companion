<?php

/**
 * Homepage parralax section Widget
 * Shapely Theme
 */
class Shapely_Home_Portfolio extends WP_Widget {
	function __construct() {

		$widget_ops = array(
			'classname'                   => 'shapely_home_portfolio',
			'description'                 => esc_html__( 'Shapely Porfolio for Home Widget Section', 'shapely-companion' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'shapely_home_portfolio', esc_html__( '[Shapely] Porfolio for Home Widget Section', 'shapely-companion' ), $widget_ops );

	}

	function widget( $args, $instance ) {

		$defaults = array(
			'title' => '',
			'body_content' => '',
			'fullwidth' => '1',
			'mansonry' => '1',
			'backgroundcolor' => '#0e1015',
			'textcolor' => '#ffffff',
			'postsnumber' => 10,
		);

		$instance = wp_parse_args( $instance, $defaults );

		if ( post_type_exists( 'jetpack-portfolio' ) ) {

			echo $args['before_widget'];

			/**
			 * Widget Content
			 */
			?>
			<section class="projects pb0" style="background-color:<?php echo esc_attr( $instance['backgroundcolor'] ); ?>">
				<div class="container">
					<div class="col-sm-12 text-center">
						<h3 class="mb32" style="color:<?php echo esc_attr( $instance['textcolor'] ); ?>"><?php echo wp_kses_post( $instance['title'] ); ?></h3>
						<p class="mb40" style="color:<?php echo esc_attr( $instance['textcolor'] ); ?>"><?php echo wp_kses_post( $instance['body_content'] ); ?></p>
					</div>
				</div>
				<?php

				$portfolio_args = array(
					'post_type'           => 'jetpack-portfolio',
					'posts_per_page'      => absint( $instance['postsnumber'] ),
					'ignore_sticky_posts' => 1,
				);

				$portfolio_query = new WP_Query( $portfolio_args );

				if ( $portfolio_query->have_posts() ) :
				?>

					<div class="row masonry-loader fixed-center fadeOut">
						<div class="col-sm-12 text-center">
							<div class="spinner"></div>
						</div>
					</div>
					<?php if ( '1' != $instance['fullwidth'] ) : ?>
						<div class="container">
					<?php endif ?>
					<div class="row fadeIn<?php echo $instance['mansonry'] ? ' masonry masonryFlyIn' : ''; ?>">
					<?php

					while ( $portfolio_query->have_posts() ) :
						$portfolio_query->the_post();

						if ( has_post_thumbnail() ) {

							$permalink = get_the_permalink();
							$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
							$item_style = '';
							if ( ! $instance['mansonry'] ) {
								$item_style = 'background-image: url(' . $thumbnail_url . ')';
							}

							$url = get_post_meta( get_the_ID(), 'shapely_companion_portfolio_link', true );
							if ( $url ) {
								$permalink = $url;
							}

							$args_projects = array(
								'fields' => 'names',
							);
							$project_types = wp_get_post_terms( get_the_ID(), 'jetpack-portfolio-type', $args_projects );

							?>
							<div class="col-md-3 col-sm-6 project fadeIn<?php echo $instance['mansonry'] ? ' masonry-item' : ''; ?>">
								<div class="image-tile inner-title hover-reveal text-center" style="<?php echo $item_style; ?>">
									<a href="<?php echo esc_url( $permalink ); ?>" title="<?php the_title_attribute(); ?>">
									<?php
									if ( $instance['mansonry'] ) {
										the_post_thumbnail( 'medium' );
									}
									?>
										<div class="title">
										<?php
											the_title( '<h5 class="mb0">', '</h5>' );
										if ( ! empty( $project_types ) ) {
											echo '<span>' . implode( ' / ', $project_types ) . '</span>';
										}
										?>
										</div>
									</a>
								</div>
							</div>
							<?php
						}
					endwhile;
					?>
					</div>
					<?php if ( '1' != $instance['fullwidth'] ) : ?>
						</div>
					<?php endif ?>
					<?php
				endif;
				wp_reset_postdata();
				?>
			</section>


			<?php

			echo $args['after_widget'];

		}// End if().
	}


	function form( $instance ) {
		$defaults = array(
			'title' => '',
			'body_content' => '',
			'fullwidth' => '1',
			'mansonry' => '1',
			'backgroundcolor' => '#0e1015',
			'textcolor' => '#ffffff',
			'postsnumber' => 10,
		);

		$instance = wp_parse_args( $instance, $defaults );

		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title ', 'shapely-companion' ); ?></label>
			<input type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" class="widefat"/>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'body_content' ) ); ?>"><?php esc_html_e( 'Content ', 'shapely-companion' ); ?></label>
			<textarea name="<?php echo esc_attr( $this->get_field_name( 'body_content' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'body_content' ) ); ?>" class="widefat">
				<?php echo wp_kses_post( $instance['body_content'] ); ?>
			</textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'postsnumber' ); ?>"><?php esc_html_e( 'Number of Projects ', 'shapely-companion' ); ?></label>
			<input type="text" value="<?php echo esc_attr( $instance['postsnumber'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'postsnumber' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'postsnumber' ) ); ?>" class="widefat"/>
		</p>

		<div class="checkbox_switch">
				<span class="customize-control-title onoffswitch_label">
					<?php _e( 'Full Width Container', 'shapely-companion' ); ?>
				</span>
			<div class="onoffswitch">
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_name( 'fullwidth' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'fullwidth' ) ); ?>"
					   class="onoffswitch-checkbox"
					   value="1"
					<?php checked( $instance['fullwidth'], '1' ); ?>>
				<label class="onoffswitch-label" for="<?php echo esc_attr( $this->get_field_name( 'fullwidth' ) ); ?>"></label>
			</div>
		</div>

		<div class="checkbox_switch">
				<span class="customize-control-title onoffswitch_label">
					<?php _e( 'Mansonry Layout', 'shapely-companion' ); ?>
				</span>
			<div class="onoffswitch">
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_name( 'mansonry' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'mansonry' ) ); ?>"
					   class="onoffswitch-checkbox"
					   value="1"
					<?php checked( $instance['mansonry'], '1' ); ?>>
				<label class="onoffswitch-label" for="<?php echo esc_attr( $this->get_field_name( 'mansonry' ) ); ?>"></label>
			</div>
		</div>

		<p>
			<label for="<?php echo $this->get_field_id( 'backgroundcolor' ); ?>"><?php esc_html_e( 'Background Color ', 'shapely-companion' ); ?></label><br>
			<input type="text" value="<?php echo esc_attr( $instance['backgroundcolor'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'backgroundcolor' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'backgroundcolor' ) ); ?>" class="widefat shapely-color-picker"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'textcolor' ); ?>"><?php esc_html_e( 'Text Color ', 'shapely-companion' ); ?></label><br>
			<input type="text" value="<?php echo esc_attr( $instance['textcolor'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'textcolor' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'textcolor' ) ); ?>" class="widefat shapely-color-picker"/>
		</p>


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
		$instance['title']        = ( ! empty( $new_instance['title'] ) ) ? wp_kses_post( $new_instance['title'] ) : '';
		$instance['postsnumber']  = ( ! empty( $new_instance['postsnumber'] ) ) ? absint( $new_instance['postsnumber'] ) : '10';
		$instance['body_content'] = ( ! empty( $new_instance['body_content'] ) ) ? wp_kses_post( $new_instance['body_content'] ) : '';
		$instance['fullwidth']    = ( ! empty( $new_instance['fullwidth'] )) ? absint( $new_instance['fullwidth'] ) : 0;
		$instance['mansonry']        = ( ! empty( $new_instance['mansonry'] )) ? absint( $new_instance['mansonry'] ) : 0;
		$instance['backgroundcolor'] = ( ! empty( $new_instance['backgroundcolor'] )) ? sanitize_hex_color( $new_instance['backgroundcolor'] ) : '#0e1015';
		$instance['textcolor'] = ( ! empty( $new_instance['textcolor'] )) ? sanitize_hex_color( $new_instance['textcolor'] ) : '#ffffff';

		return $instance;
	}

}

?>
