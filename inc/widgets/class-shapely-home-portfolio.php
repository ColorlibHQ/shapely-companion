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
		$title        = isset( $instance['title'] ) ? $instance['title'] : '';
		$body_content = isset( $instance['body_content'] ) ? $instance['body_content'] : '';

		if ( post_type_exists( 'jetpack-portfolio' ) ) {

			echo $args['before_widget'];

			/**
			 * Widget Content
			 */
			?>
			<section class="projects bg-dark pb0">
				<div class="container">
					<div class="col-sm-12 text-center">
						<h3 class="mb32"><?php echo wp_kses_post( $title ); ?></h3>
						<p class="mb40"><?php echo wp_kses_post( $body_content ); ?></p>
					</div>
				</div>
				<?php

				$portfolio_args = array(
					'post_type'           => 'jetpack-portfolio',
					'posts_per_page'      => 10,
					'ignore_sticky_posts' => 1,
				);

				$portfolio_query = new WP_Query( $portfolio_args );

				if ( $portfolio_query->have_posts() ) : ?>

					<div class="row masonry-loader fixed-center fadeOut">
						<div class="col-sm-12 text-center">
							<div class="spinner"></div>
						</div>
					</div>
					<div class="row masonry masonryFlyIn fadeIn">
					<?php

					while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();

						if ( has_post_thumbnail() ) {

							$permalink = get_the_permalink();
							$url = get_post_meta( get_the_ID(), 'shapely_companion_portfolio_link', true );
							if ( $url ) {
								$permalink = $url;
							}

							$args_projects = array(
								'fields' => 'names',
							);
							$project_types = wp_get_post_terms( get_the_ID(), 'jetpack-portfolio-type', $args_projects );

							?>
							<div class="col-md-3 col-sm-6 masonry-item project fadeIn">
								<div class="image-tile inner-title hover-reveal text-center">
									<a href="<?php echo esc_url( $permalink ); ?>" title="<?php the_title_attribute(); ?>">
									<?php the_post_thumbnail( 'full' ); ?>
										<div class="title"><?php
											the_title( '<h5 class="mb0">', '</h5>' );
										if ( ! empty( $project_types ) ) {
											echo '<span>' . implode( ' / ', $project_types ) . '</span>';
										} ?>
										</div>
									</a>
								</div>
							</div><?php
						}
					endwhile; ?>
					</div><?php
				endif;
				wp_reset_postdata(); ?>
			</section>


			<?php

			echo $args['after_widget'];

		}// End if().
	}


	function form( $instance ) {
		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = '';
		}
		if ( ! isset( $instance['body_content'] ) ) {
			$instance['body_content'] = '';
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title ', 'shapely-companion' ) ?></label>
			<input type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" class="widefat"/>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'body_content' ) ); ?>"><?php esc_html_e( 'Content ', 'shapely-companion' ) ?></label>
			<textarea name="<?php echo esc_attr( $this->get_field_name( 'body_content' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'body_content' ) ); ?>" class="widefat">
				<?php echo wp_kses_post( $instance['body_content'] ); ?>
			</textarea>
		</p><?php
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
		$instance['body_content'] = ( ! empty( $new_instance['body_content'] ) ) ? wp_kses_post( $new_instance['body_content'] ) : '';

		return $instance;
	}

}

?>
