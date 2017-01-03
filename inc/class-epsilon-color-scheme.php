<?php
if ( ! class_exists( 'Epsilon_Color_Scheme' ) ) {
	/**
	 * Class Epsilon_Color_Scheme
	 */
	class Epsilon_Color_Scheme {
		/**
		 * If there isn't any inline style, we don't need to generate the CSS
		 *
		 * @var bool
		 */
		protected $terminate = false;
		/**
		 * Options with defaults
		 *
		 * @var array
		 */
		protected $options = array();

		/**
		 * Array that defines the controls/settings to be added in the customizer
		 *
		 * @var array
		 */
		protected $customizer_controls = array();

		/**
		 * Epsilon_Color_Scheme constructor.
		 */
		public function __construct() {
			$this->options             = $this->get_options();
			$this->customizer_controls = $this->get_customizer_controls();

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 900 );
			add_action( 'customize_register', array( $this, 'add_controls_settings' ) );
		}

		public function get_options() {
			return array(
				'epsilon_accent_color'               => '#745cf9',
				'epsilon_text_color'                 => '#666666',
				'epsilon_content_widget_title_color' => '#0e1015',
				'epsilon_footer_bg_color'            => '#0e1015',
				'epsilon_footer_widget_title_color'  => '#ffffff',
				'epsilon_footer_links_color'         => '#ffffff',
			);
		}

		public function get_customizer_controls() {
			return array(
				'epsilon_accent_color' => array(
					'label'       => __( 'Accent Color', 'shapely' ),
					'description' => __( 'The main color used for links, buttons, and more.', 'shapely' ),
					'default'     => '#745cf9',
					'section'     => 'colors'
				),
				'epsilon_text_color'   => array(
					'label'       => __( 'Text Color', 'shapely' ),
					'description' => __( 'The color used for paragraphs.', 'shapely' ),
					'default'     => '#666666',
					'section'     => 'colors'
				),

				'epsilon_content_widget_title_color' => array(
					'label'       => __( 'Content Widget Title Color', 'shapely' ),
					'description' => __( 'The color used for content widgets title.', 'shapely' ),
					'default'     => '#0e1015',
					'section'     => 'colors'
				),

				'epsilon_footer_bg_color' => array(
					'label'       => __( 'Footer Background Color', 'shapely' ),
					'description' => __( 'The color used for the footer background.', 'shapely' ),
					'default'     => '#0e1015',
					'section'     => 'colors'
				),

				'epsilon_footer_widget_title_color' => array(
					'label'       => __( 'Footer Widget Title Color', 'shapely' ),
					'description' => __( 'The color used for the footer widgets title.', 'shapely' ),
					'default'     => '#ffffff',
					'section'     => 'colors'
				),

				'epsilon_footer_links_color' => array(
					'label'       => __( 'Footer Links Color', 'shapely' ),
					'description' => __( 'The color used for the footer links.', 'shapely' ),
					'default'     => '#ffffff',
					'section'     => 'colors'
				)
			);
		}

		/**
		 * When the function is called through AJAX, we update the colors by merging the 2 arrays
		 *
		 * @param $args
		 */
		public function update_colors( $args ) {
			if ( $args !== NULL ) {
				$array = array_merge( $this->options, $args );
				if ( ! empty( $array['epsilon_accent_color'] ) ) {
					$array['epsilon_accent_color_hover'] = $this->adjust_brightness( $array['epsilon_accent_color'], 20 );
				}
				if ( ! empty( $array['epsilon_footer_links_color'] ) ) {
					$array['epsilon_footer_link_color_hover'] = $this->adjust_brightness( $array['epsilon_footer_links_color'], 20 );
				}
				$this->options = $array;
			}
		}

		/**
		 * Grabs the instance of the epsilon color scheme class
		 *
		 * @param null $args
		 *
		 * @return Epsilon_Color_Scheme
		 */
		public static function get_instance( $args = NULL ) {
			static $inst;
			if ( ! $inst ) {
				$inst = new Epsilon_Color_Scheme( $args );
			}

			return $inst;
		}

		/**
		 * Create the array with the new settings
		 *
		 * @return array
		 */
		public function get_color_scheme() {
			$colors = array();

			foreach ( $this->options as $k => $v ) {
				$color        = get_theme_mod( $k, $v );
				$colors[ $k ] = $color;
			}

			/**
			 * small check
			 */
			$a = serialize( $this->options );
			$b = serialize( $colors );

			if ( $a === $b ) {
				$this->terminate = true;
			}

			if ( ! empty( $colors['epsilon_accent_color'] ) ) {
				$colors['epsilon_accent_color_hover'] = $this->adjust_brightness( $colors['epsilon_accent_color'], 10 );
			}
			if ( ! empty( $colors['epsilon_footer_links_color'] ) ) {
				$colors['epsilon_footer_link_color_hover'] = $this->adjust_brightness( $colors['epsilon_footer_links_color'], 10 );
			}

			return $colors;
		}

		/**
		 * Returns the whole CSS string
		 * 1 - Accent Color
		 * 2 - Text Color
		 * 3 - Content Widget Title
		 * 4 - Footer BG Color
		 * 5 - Footer Widget Title
		 * 6 - Footer Link Color
		 * 7 - Hover Accent Color
		 * 8 - Hover Footer Link
		 *
		 * @return string
		 */
		public function css_template() {
			if ( $this->terminate ) {
				return '';
			}
			$css = '		
				.image-bg .btn.btn-filled,
				.btn-filled, 
				.button,
				.woocommerce #respond input#submit.alt,
				.woocommerce a.button.alt,
				.woocommerce button.button.alt,
				.woocommerce input.button.alt,
				.woocommerce #respond input#submit,
				.woocommerce a.button,
				.woocommerce button.button,
		        .woocommerce input.button,
		        .btn.searchsubmit,
		        input[type="submit"],
		        .video-widget .video-controls button{
					background:%1$s;
					border-color:%1$s;
				}
				
				.btn-filled:hover, 
				.btn:visited:hover,
				.btn.searchsubmit:hover,
				.image-bg .btn.btn-filled:hover,
				input[type="submit"]:hover,
				.video-widget .video-controls button{
					background:%7$s;
					border-color:%7$s;
				}
				
				.btn, .button{
					border-color:%1$s;
				}
				
				
				.feature-1 i,
				.feature-2 i,
				.feature-3 i,
				.comment-reply, a:visited, a{
					color:%1$s;
				}
				
				a:hover, a:focus{
					color:%6$s;
				}
				
				.btn:hover, .button:hover{
					background:%7$s;
				}
				
				.menu > li > ul li a:hover, .dropdown-menu > .active > a:hover{
					background:%1$s;
				}
				
				a{
					color: %1$s;
				}
				
				a:hover,
				a:focus{
					color:%7$s;
				}
				
				.bg-dark{
					background: %4$s;
				}
				
				footer.bg-dark a{
					color: %6$s;
				}
				
				footer.bg-dark a:hover{
					color: %8$s;
				}
				
				.footer-widget .widget-title{
					color: %5$s;
				}
				
				body{
					color: %2$s;
				}
				
				.post-title a:hover{
					color: #292929;
				}
			';

			return $css;
		}

		/**
		 * Return the css inline styles for the AJAX function (through the customizer)
		 *
		 * @return string
		 */
		public function generate_live_css() {
			return vsprintf( $this->css_template(), $this->options );
		}

		/**
		 * Return the css string for the live website
		 *
		 * @return string
		 */
		public function generate_css() {
			$color_scheme = $this->get_color_scheme();

			return vsprintf( $this->css_template(), $color_scheme );
		}

		/**
		 * Enqueue the inline style CSS string
		 */
		public function enqueue() {
			$css = $this->generate_css();
			wp_add_inline_style( 'shapely-style', $css );
		}

		/**
		 * Add the controls to the customizer
		 *
		 * @todo - nu cred ca merge translation stuff
		 */
		public function add_controls_settings() {
			global $wp_customize;
			$i = 3;
			foreach ( $this->customizer_controls as $control => $properties ) {
				$wp_customize->add_setting( $control, array(
					'default'           => $properties['default'],
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
				) );

				$wp_customize->add_control( $control, array() );

				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $control, array(
					'label'       => $properties['label'],
					'description' => $properties['description'],
					'section'     => $properties['section'],
					'settings'    => $control,
					'priority'    => $i,
				) ) );

				$i ++;
			}
		}

		public function adjust_brightness( $hex, $steps ) {
			$steps = max( - 255, min( 255, $steps ) );
			$hex   = str_replace( '#', '', $hex );
			if ( strlen( $hex ) == 3 ) {
				$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
			}

			$color_parts = str_split( $hex, 2 );
			$return      = '#';
			foreach ( $color_parts as $color ) {
				$color = hexdec( $color ); // Convert to decimal
				$color = max( 0, min( 255, $color + $steps ) ); // Adjust color
				$return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
			}

			return $return;
		}
	}

	/**
	 * Instantiate the object
	 */
	Epsilon_Color_Scheme::get_instance();

	/**
	 * Add the actions for the customizer previewer
	 */
	add_action( 'wp_ajax_shapely_generate_css', 'shapely_generate_css' );
	add_action( 'wp_ajax_nopriv_shapely_generate_css', 'shapely_generate_css' );
	function shapely_generate_css() {
		$args = array();

		/**
		 * Sanitize the $_POST['args']
		 */
		foreach ( $_POST['args'] as $k => $v ) {
			$args[ $k ] = sanitize_hex_color( $v );
		}

		/**
		 * Grab the instance of the Epsilon Color Scheme
		 */
		$color_scheme = Epsilon_Color_Scheme::get_instance();
		/**
		 * Update the option array
		 */
		$color_scheme->update_colors( $args );
		/**
		 * Echo the css inline sheet
		 */
		echo $color_scheme->generate_live_css();
		wp_die();
	}
}
