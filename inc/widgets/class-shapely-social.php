<?php

/**
 * Social  Widget
 * shapely Theme
 */
class Shapely_Social extends WP_Widget {

	private $defaults;

	private $social_icons = array(
		'behance',
		'codepen',
		'dropbox',
		'delicious',
		'deviantart',
		'digg',
		'dribbble',
		'facebook',
		'flickr',
		'github',
		'instagram',
		'linkedin',
		'medium',
		'pinterest',
		'reddit',
		'skype',
		'slack',
		'soundcloud',
		'tumblr',
		'tripadvisor',
		'twitch',
		'twitter',
		'vimeo',
		'youtube',
	);

	function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget-shapely-social',
			'description'                 => esc_html__( 'Shapely Social Widget', 'shapely-companion' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'shapely-social', esc_html__( '[Shapely] Social Widget', 'shapely-companion' ), $widget_ops );

		$this->defaults = array(
			'title' => esc_html__( 'Follow us', 'shapely-companion' ),
		);
	}

	function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		$social_links = array();
		foreach ( $this->social_icons as $social_icon ) {
			$social_links[ $social_icon ] = isset( $instance[ 'page_' . $social_icon ] ) ? $instance[ 'page_' . $social_icon ] : '';
		}

		echo $args['before_widget'];
		if ( '' != $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}
		?>
		<div class="shapely-social">
			<?php foreach ( $this->social_icons as $social_icon ) : ?>
				<?php if ( '' != $social_links[ $social_icon ] ) : ?>
				<a class="shapely-social-link shapely-social-link--<?php echo esc_attr( $social_icon ); ?>" href="<?php echo esc_url( $social_links[ $social_icon ] ); ?>">
					<span class="shapely-social-icon"></span>
				</a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php
		echo $args['after_widget'];
	}


	function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		foreach ( $this->social_icons as $social_icon ) :
			$instance[ 'page_' . $social_icon ] = esc_url_raw( $new_instance[ 'page_' . $social_icon ] );
		endforeach;

		return $instance;
	}

	function form( $instance ) {

		$defaults = $this->defaults;

		foreach ( $this->social_icons as $social_icon ) :
			$defaults[ 'page_' . $social_icon ] = '';
		endforeach;

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'shapely-companion' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<?php foreach ( $this->social_icons as $social_icon ) : ?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'page_' . $social_icon ) ); ?>"><?php printf( esc_html__( '%s Page', 'shapely-companion' ), esc_html( ucfirst( $social_icon ) ) ); ?></label><br/>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'page_' . $social_icon ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_' . $social_icon ) ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'page_' . $social_icon ] ); ?>" />
			</p>
		<?php endforeach; ?>

		<?php
	}

}
