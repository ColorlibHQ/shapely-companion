<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Function to import widgets based on a JSON config file
 * JSON file is generated using plugin: Widget Importer / Exporter
 *
 * @link https://github.com/stevengliebe/widget-importer-exporter
 */
function shapely_companion_add_default_widgets() {
	$json             = '{"sidebar-1":{"search-2":{"title":""},"recent-posts-2":{"title":"","number":5},"categories-2":{"title":"","count":0,"hierarchical":0,"dropdown":0}},"sidebar-home":{"shapely_home_parallax-2":{"title":"We Change Everything WordPress","image_src":"http://colorlibhub.com/shapely/wp-content/uploads/sites/59/2016/03/photo-1443527216320-7e744084f5a7-1.jpg","image_pos":"background-full","body_content":"This is the only WordPress theme you will ever want to use.","button1":"Read More","button2":"Download Now","button1_link":"#","button2_link":"#","border_bottom":""},"shapely_home_parallax-3":{"title":"SEO Friendly","image_src":"https://colorlibhub.com/shapely/wp-content/uploads/sites/59/2016/03/macbook-preview-flexible.png","image_pos":"left","body_content":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pulvinar luctus sem, eget porta orci. Maecenas molestie dui id diam feugiat, eu tincidunt mauris aliquam. Duis commodo vitae ligula et interdum. Maecenas faucibus mattis imperdiet. In rhoncus ac ligula id ultricies.","button1":"Read more","button2":"","button1_link":"#","button2_link":"","border_bottom":""},"shapely_home_parallax-4":{"title":"Portfolio Section","image_src":"https://colorlibhub.com/shapely/wp-content/uploads/sites/59/2016/03/flexible-portfolio.png","image_pos":"right","body_content":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pulvinar luctus sem, eget porta orci. Maecenas molestie dui id diam feugiat, eu tincidunt mauris aliquam. Duis commodo vitae ligula et interdum.","button1":"See it in action","button2":"","button1_link":"#","button2_link":"","border_bottom":""},"shapely_home_parallax-5":{"title":"Small Parallax Section","image_src":"http://colorlibhub.com/shapely/wp-content/uploads/sites/59/2016/12/photo-1452723312111-3a7d0db0e024.jpg","image_pos":"background-small","body_content":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus imperdiet rhoncus porta. Ut quis sem quis purus lobortis dictum. Aliquam nec dignissim nisl. Vivamus cursus feugiat sapien, eget tincidunt leo ornare quis.","button1":"MORE INFO","button2":"","button1_link":"#","button2_link":"","border_bottom":""},"shapely_home_parallax-6":{"title":"Limitless Options","image_src":"https://colorlibhub.com/wp-content/uploads/sites/59/2016/12/photo-1440557653082-e8e186733eeb-1.jpg","image_pos":"bottom","body_content":"Phasellus sed nisi ac dui interdum semper. Etiam consequat fermentum sollicitudin. Fusce vulputate porta faucibus. Vivamus nulla tellus, accumsan non efficitur id, pretium quis ante","button1":"Download Now","button2":"","button1_link":"#","button2_link":"","border_bottom":""},"shapely_home_portfolio-2":{"title":"Our Latest Projects","body_content":"Here is our latest projects. You&#039;ll love them!"},"shapely_home_testimonial-2":{"title":"What Our Customers Say","limit":5,"image_src":"https://colorlibhub.com/shapely/wp-content/uploads/sites/59\/2016\/12\/photo-1451417379553-15d8e8f49cde.jpg"},"shapely_home_contact-2":{"title":"Contact us","image_src":"","body_content":"Mauris vestibulum, metus at semper efficitur, est ex tincidunt elit, vitae tincidunt sem sem in est. Sed eget enim nunc.","phone":"(650) 652-8500","address":"33 Farlane Street Keilor East VIC 3033, New York","email":"mail@mail.com","contactform":32,"socialicons":""},"shapely_home_clients-2":{"title":"Our Main Clients","client_logo":{"img":["https://colorlibhub.com/shapely/wp-content/uploads/sites/59\/2016\/03\/colorlib-logo.png","https://colorlibhub.com/shapely/wp-content/uploads/sites/59\/2016\/03\/js-logo.png","https://colorlibhub.com/shapely/wp-content/uploads/sites/59\/2016\/03\/html5-logo.png","https://colorlibhub.com/shapely/wp-content/uploads/sites/59\/2016\/03\/css-logo.png","https://colorlibhub.com/shapely/wp-content/uploads/sites/59\/2016\/03\/less-logo.png","https://colorlibhub.com/shapely/wp-content/uploads/sites/59\/2016\/03\/sass-logo.png","https://colorlibhub.com/shapely/wp-content/uploads/sites/59\/2016\/03\/bootstrap-logo.jpg","https://colorlibhub.com/shapely/wp-content/uploads/sites/59\/2016\/03\/adobe-logo.png","https://colorlibhub.com/shapely/wp-content/uploads/sites/59\/2016\/03\/facebook-logo.png"],"link":["#","#","#","#","#","#","#","#","#"]}},"shapely_home_cfa-2":{"title":"Do you like this awesome WordPress theme?","button":"Download Now","button_link":"#"}}}';
	$config           = json_decode( $json );
	$sidebars_widgets = get_option( 'sidebars_widgets', array() );

	/*
	 * Neither option is guaranteed to exist yet -- widget_shapely_home_cfa
	 * certainly does not on a site that never used that widget -- and
	 * get_option() then returns false. Writing $widgets[ $index ] into false
	 * is deprecated since PHP 8.1 ("Automatic conversion of false to array").
	 */
	if ( ! is_array( $sidebars_widgets ) ) {
		$sidebars_widgets = array();
	}
	# Parse config
	foreach ( $config as $sidebar => $elemements ) {
		# verify if the sidebar doesn't have ny widgets
		if ( false === strpos( $sidebar, 'orphaned_widgets' ) && ! is_active_sidebar( $sidebar ) ) {
			# create an empty array for active widgets
			$this_sidebar_active_widgets = array();
			# parse all widgets for current sidebar
			foreach ( $elemements as $id_widget => $args ) {
				# add current widget to current sidebar
				$this_sidebar_active_widgets[] = $id_widget;
				# split widget name in order to get widget name and index
				$id_widget_parts = explode( '-', $id_widget );
				# get widget index
				$index_widget = end( $id_widget_parts );
				#remove widget index from array
				array_pop( $id_widget_parts );
				#generate widget name
				$widget_name = implode( '-', $id_widget_parts );
				#get all widgets who are like current widget
				$widgets = get_option( 'widget_' . $widget_name, array() );
				if ( ! is_array( $widgets ) ) {
					$widgets = array();
				}
				#check if current index exist in array
				if ( ! isset( $widgets[ $index_widget ] ) ) {

					/*
					 * Point the Contact section at a form that exists on this
					 * site. The JSON carries form 32 from the demo site; left
					 * as is, the section showed administrators a "form does
					 * not exist" warning, or embedded an unrelated form that
					 * happened to be ID 32. Kali Forms is what the widget's form
					 * offers, so prefer it; Contact Form 7 is kept for sites
					 * that imported with it before.
					 */
					if ( false !== strpos( $id_widget, 'shapely_home_contact' ) ) {
						$args->contactform = '';
						foreach ( array( 'kaliforms_forms', 'wpcf7_contact_form' ) as $form_type ) {
							$forms = get_posts(
								array(
									'post_type'      => $form_type,
									'post_status'    => 'publish',
									'posts_per_page' => 1,
									'fields'         => 'ids',
								)
							);
							if ( ! empty( $forms ) ) {
								$args->contactform = (int) $forms[0];
								break;
							}
						}
					}

					#add current widget with his index and args
					$widgets[ $index_widget ] = get_object_vars( $args );

				}
				#update widgets who are like current widget
				update_option( 'widget_' . $widget_name, $widgets );
			}
			$sidebars_widgets[ $sidebar ] = $this_sidebar_active_widgets;
		}
	}
	update_option( 'sidebars_widgets', $sidebars_widgets );
}

/**
 * Find a post or page an earlier demo import created, or create it.
 *
 * Every run of "Import Demo Content" used to insert new posts: set-frontpage
 * always created another "Front Page" and "Blog" page (front-page-2, blog-2,
 * ...), and import-all created another pair of "Sample Post" posts each time.
 * 1.2.11 made import-all look pages up by title, but not set-frontpage or the
 * sample posts, and a title lookup misses a page the owner has since renamed.
 *
 * Lookup order:
 * 1. A post of this type tagged with the _shapely_companion_demo meta key
 *    holding $key -- anything this importer created from 1.2.14 on.
 * 2. A post with the slug the importer gives it (sanitize_title() of the
 *    title), which is what earlier versions produced, so their pages and
 *    posts are adopted and tagged rather than duplicated.
 *
 * Trashed posts are ignored: the owner deleted them, so a fresh one is made.
 * get_page_by_title() is deliberately not used; it was deprecated in 6.2.
 *
 * @param string $key     Stable identifier for this piece of demo content.
 * @param array  $postarr wp_insert_post() arguments; needs post_type and
 *                        post_title. Content is used only when creating.
 *
 * @return int Post ID, or 0 if it could not be created.
 */
function shapely_companion_get_or_create_demo_post( $key, $postarr ) {
	$meta_key  = '_shapely_companion_demo';
	$post_type = $postarr['post_type'];
	$slug      = sanitize_title( $postarr['post_title'] );
	$statuses  = array( 'publish', 'future', 'draft', 'pending', 'private' );

	$tagged = get_posts(
		array(
			'post_type'              => $post_type,
			'post_status'            => $statuses,
			'meta_key'               => $meta_key,
			'meta_value'             => $key,
			'posts_per_page'         => 1,
			'orderby'                => 'ID',
			'order'                  => 'ASC',
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		)
	);

	$id = $tagged ? (int) $tagged[0] : 0;

	if ( ! $id && '' !== $slug ) {
		$by_slug = get_page_by_path( $slug, OBJECT, $post_type );
		if ( $by_slug && in_array( $by_slug->post_status, $statuses, true ) ) {
			$id = (int) $by_slug->ID;
		}
	}

	if ( $id ) {
		if ( 'publish' !== get_post_status( $id ) ) {
			wp_update_post(
				array(
					'ID'          => $id,
					'post_status' => 'publish',
				)
			);
		}
		update_post_meta( $id, $meta_key, $key );

		return $id;
	}

	$postarr['post_status'] = 'publish';
	$postarr['post_name']   = $slug;
	$postarr['meta_input']  = array( $meta_key => $key );

	$id = wp_insert_post( $postarr, true );

	return is_wp_error( $id ) ? 0 : (int) $id;
}

/**
 * Create (or reuse) the Front Page and Blog pages and make them the static
 * front page and posts page.
 *
 * @param array $log Import log, appended to.
 *
 * @return bool False if either page could not be created.
 */
function shapely_companion_import_static_front_page( &$log ) {
	$frontpage_id = shapely_companion_get_or_create_demo_post(
		'front-page',
		array(
			'post_type'    => 'page',
			'post_title'   => __( 'Front Page', 'shapely-companion' ),
			'post_content' => 'This is your front page. Click edit to change this text.',
		)
	);
	$log[] = 'Front page ID: ' . $frontpage_id;

	$blog_id = shapely_companion_get_or_create_demo_post(
		'blog',
		array(
			'post_type'    => 'page',
			'post_title'   => __( 'Blog', 'shapely-companion' ),
			'post_content' => 'This is your blog page.',
		)
	);
	$log[] = 'Blog page ID: ' . $blog_id;

	// wp_insert_post() reports failure as 0, never -1, which the old check tested for.
	if ( ! $frontpage_id || ! $blog_id ) {
		return false;
	}

	update_post_meta( $frontpage_id, '_wp_page_template', 'page-templates/template-home.php' );
	$log[] = 'Template set for front page';

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $frontpage_id );
	update_option( 'page_for_posts', $blog_id );
	$log[] = 'Front and blog pages set in WordPress settings';

	return true;
}

/**
 * Create (or reuse) the two sample blog posts.
 *
 * No post_category: wp_insert_post() files a post under the site's default
 * category. The old hard-coded array( 1 ) assumed that was term 1.
 *
 * @param array $log Import log, appended to.
 */
function shapely_companion_import_sample_posts( &$log ) {
	$posts = array(
		'sample-post-1' => array(
			'post_title'   => 'Sample Post 1',
			'post_content' => 'This is a sample post with demo content.',
		),
		'sample-post-2' => array(
			'post_title'   => 'Sample Post 2',
			'post_content' => 'Another sample post with demo content.',
		),
	);

	foreach ( $posts as $key => $postarr ) {
		$postarr['post_type'] = 'post';

		$log[] = 'Demo post ID: ' . shapely_companion_get_or_create_demo_post( $key, $postarr );
	}
}

add_action( 'wp_ajax_shapely_companion_import_content', 'shapely_companion_import_content' );

/**
 * End an import request with a JSON error.
 *
 * The Shapely theme's welcome screen treats anything other than
 * `success: true` (or `data.status: true`) as a failure, so the shape of
 * this payload is part of the contract with every released theme version.
 *
 * @param string $message Short machine-readable reason.
 * @param int    $status  HTTP status code.
 */
function shapely_companion_import_error( $message, $status ) {
	wp_send_json_error(
		array(
			'status'  => false,
			'message' => $message,
		),
		$status
	);
}

/**
 * AJAX handler for the theme's "Import Demo Content" buttons.
 *
 * Contract with the Shapely theme (changing any of it breaks the import for
 * every released theme version): action shapely_companion_import_content, a
 * welcome_nonce nonce in $_POST['nonce'], and $_POST['import'] set to one of
 * import-all, import-widgets or set-frontpage.
 *
 * Both inputs are read defensively: an array (nonce[]=x) used to reach
 * wp_verify_nonce() unslashed and raise "Array to string conversion", and an
 * unrecognised import value used to fall through every branch and still
 * report success -- and set shapely_imported_demo -- having done nothing.
 *
 * Every path ends in wp_send_json_*(), which exits.
 */
function shapely_companion_import_content() {
	$nonce = ( isset( $_POST['nonce'] ) && is_string( $_POST['nonce'] ) ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

	if ( '' === $nonce ) {
		shapely_companion_import_error( 'missing nonce', 400 );
	}

	if ( ! wp_verify_nonce( $nonce, 'welcome_nonce' ) ) {
		shapely_companion_import_error( 'invalid nonce', 403 );
	}

	// manage_options, not edit_theme_options: the import rewrites show_on_front.
	if ( ! current_user_can( 'manage_options' ) ) {
		shapely_companion_import_error( 'user capabilities', 403 );
	}

	$import_option = ( isset( $_POST['import'] ) && is_string( $_POST['import'] ) ) ? sanitize_key( wp_unslash( $_POST['import'] ) ) : '';

	if ( '' === $import_option ) {
		shapely_companion_import_error( 'No import option specified', 400 );
	}

	if ( ! in_array( $import_option, array( 'import-all', 'import-widgets', 'set-frontpage' ), true ) ) {
		shapely_companion_import_error( 'Unknown import option', 400 );
	}

	$log = array();

	if ( 'import-all' === $import_option || 'set-frontpage' === $import_option ) {
		$log[] = 'Setting the static front page';

		if ( ! shapely_companion_import_static_front_page( $log ) ) {
			shapely_companion_import_error( 'Could not create the front page', 500 );
		}
	}

	if ( 'import-all' === $import_option || 'import-widgets' === $import_option ) {
		shapely_companion_add_default_widgets();
		$log[] = 'Default widgets imported';
	}

	if ( 'import-all' === $import_option ) {
		shapely_companion_import_sample_posts( $log );
	}

	update_option( 'shapely_imported_demo', true );
	$log[] = 'Saved shapely_imported_demo option as true';

	wp_send_json_success(
		array(
			'status'  => true,
			'message' => 'ok',
			'log'     => $log,
		)
	);
}
