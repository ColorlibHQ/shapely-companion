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
if ( ! function_exists( 'shapely_author_socialLinks' ) ) {
	function shapely_author_socialLinks( $contactmethods ) {
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
}
add_filter( 'user_contactmethods', 'shapely_author_socialLinks', 10, 1 );