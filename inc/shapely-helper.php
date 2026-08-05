<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function shapely_allow_skype_protocol( $protocols ) {
	$protocols[] = 'skype';

	return $protocols;
}

add_filter( 'kses_allowed_protocols', 'shapely_allow_skype_protocol' );

/* Social Fields in Author Profile */
function shapely_author_social_links( $contactmethods ) {
	// Add Twitter
	$contactmethods['twitter'] = 'Twitter';
	//add Facebook
	$contactmethods['facebook'] = 'Facebook';
	//add Github
	$contactmethods['github'] = 'Github';
	//add Dribble
	$contactmethods['dribble'] = 'Dribble';
	//add Vimeo
	$contactmethods['vimeo'] = 'Vimeo';

	return $contactmethods;
}
add_filter( 'user_contactmethods', 'shapely_author_social_links', 10, 1 );

/**
 * Authorise an attachment-resolution AJAX request.
 *
 * These endpoints back the media picker on the widget/customizer admin screens,
 * which only a logged-in editor ever reaches. They were also registered for
 * wp_ajax_nopriv_*, with no nonce and no capability check, so any logged-out
 * visitor could POST an attachment ID and receive its URL -- enough to walk the
 * ID space and enumerate every attachment on the site, including media attached
 * to drafts and private posts.
 *
 * @return int Validated attachment ID, or 0.
 */
function shapely_validate_attachment_request() {
	check_ajax_referer( 'welcome_nonce', 'nonce' );

	if ( ! current_user_can( 'upload_files' ) ) {
		wp_die( '', '', array( 'response' => 403 ) );
	}

	$id = isset( $_POST['attachment_id'] ) ? absint( wp_unslash( $_POST['attachment_id'] ) ) : 0;

	if ( $id > 0 && 'attachment' !== get_post_type( $id ) ) {
		return 0;
	}

	return $id;
}

add_action( 'wp_ajax_shapely_get_attachment_image', 'shapely_get_attachment_image' );

function shapely_get_attachment_image() {
	$id  = shapely_validate_attachment_request();
	$src = wp_get_attachment_image_src( $id, 'full', false );

	if ( ! empty( $src[0] ) ) {
		echo esc_url( $src[0] );
	}

	die();
}

add_action( 'wp_ajax_shapely_get_attachment_media', 'shapely_get_attachment_media' );

function shapely_get_attachment_media() {
	$id  = shapely_validate_attachment_request();
	$src = wp_get_attachment_image_src( $id, 'full', false );

	if ( ! empty( $src[0] ) ) {
		echo esc_url( $src[0] );
		die();
	}

	$src = wp_get_attachment_url( $id );
	if ( ! empty( $src ) ) {
		echo esc_url( $src );
	}

	die();
}
