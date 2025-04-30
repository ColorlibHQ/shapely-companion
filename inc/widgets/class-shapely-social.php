<?php

/**
 * Social  Widget
 * shapely Theme
 */
class Shapely_Social extends WP_Widget {

	private $defaults;

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

		$defaults = array(
			'title'    => __( 'We are social', 'shapely-companion' ),
			'nav_menu' => 0,
			'alignment' => 'text-center',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		echo '<section class="shapely-social-links ' . esc_attr( $instance['alignment'] ) . '">';
		if ( '' != $title ) {
			echo '<h3 class="cfa-text">' . esc_html( $title ) . '</h3>';
		}
		
		wp_nav_menu(
			array(
				'menu'            => absint($instance['nav_menu']),
				'container'       => 'nav',
				'container_id'    => 'social',
				'container_class' => 'social-icons',
				'menu_id'         => 'menu-social-items',
				'menu_class'      => 'list-inline social-list',
				'depth'           => 1,
				'fallback_cb'     => '',
				'link_before'     => '<i class="fa-brands fa-',
				'link_after'      => '"></i>',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'walker'          => new Shapely_Social_Walker(),
			)
		);
		echo '</section>';

		echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
	}


	function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['nav_menu']  = absint( $new_instance['nav_menu'] );
		$instance['alignment'] = sanitize_text_field( $new_instance['alignment'] );

		return $instance;
	}

	function form( $instance ) {

		$defaults = array(
			'title'    => __( 'We are social', 'shapely-companion' ),
			'nav_menu' => 0,
			'alignment' => 'text-center',
		);
		$menus = wp_get_nav_menus();
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'shapely-companion' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'nav_menu' ) ); ?>"><?php esc_html_e( 'Select Menu:', 'shapely-companion' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'nav_menu' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'nav_menu' ) ); ?>">
				<option value="0"><?php esc_html_e( '&mdash; Select &mdash;', 'shapely-companion' ); ?></option>
				<?php foreach ( $menus as $menu ) : ?>
					<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $instance['nav_menu'], $menu->term_id ); ?>>
						<?php echo esc_html( $menu->name ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'alignment' ) ); ?>"><?php esc_html_e( 'Alignment:', 'shapely-companion' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'alignment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_id( 'alignment' ) ); ?>">
				<option value="text-left" <?php selected( $instance['alignment'], 'text-left' ); ?>>
					<?php esc_html_e( 'Left', 'shapely-companion' ); ?>
				</option>
				<option value="text-center" <?php selected( $instance['alignment'], 'text-center' ); ?>>
					<?php esc_html_e( 'Center', 'shapely-companion' ); ?>
				</option>
				<option value="text-right" <?php selected( $instance['alignment'], 'text-right' ); ?>>
					<?php esc_html_e( 'Right', 'shapely-companion' ); ?>
				</option>
			</select>
		</p>

		<?php
	}

}

/**
 * Custom walker class to handle social menu items
 */
class Shapely_Social_Walker extends Walker_Nav_Menu {
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$icon_class = '';
		
		// Find the icon class
		foreach ( $classes as $class ) {
			// Look for any class that starts with fa-
			if ( strpos( $class, 'fa-' ) === 0 ) {
				// Remove the fa- prefix and convert to lowercase
				$icon_class = strtolower( substr( $class, 3 ) );
				break;
			}
		}

		// If no icon class found, try to get it from the menu item title
		if ( empty( $icon_class ) ) {
			$icon_class = strtolower( sanitize_title( $item->title ) );
		}

		// Special handling for x.com links
		if ( strpos( $item->url, 'x.com' ) !== false || strpos( $item->url, 'twitter.com' ) !== false ) {
			$icon_class = 'twitter';
		}

		$output .= '<li class="' . implode( ' ', $classes ) . '">';
		$output .= '<a href="' . esc_url( $item->url ) . '">';
		$output .= '<i class="fa-brands fa-' . esc_attr( $icon_class ) . '"></i>';
		$output .= '</a>';
		$output .= '</li>';
	}
}
