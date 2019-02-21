<?php
/*
Plugin Name: Karol K's REST API Demo
Description: Displays a list of posts from another blog based on a shortcode.
Plugin URI: http://nio.tips/
Version: 1.0
Author: Karol K
Author URI: http://karol.cc/
License: GNU General Public License v2 or later

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. | This is a fork of a plugin originally developed by Daniel Pataki (https://premium.wpmudev.org/blog/using-wordpress-rest-api/).
*/

// define the shortcode
function kk_rest_handler($atts, $content=null) {
	extract(shortcode_atts(array(
		'website_domain' => 'newinternetorder.com',
		'how_many' => '3'
		), $atts));
	
	$response = wp_remote_get( 'http://' . $website_domain . '/wp-json/wp/v2/posts/' );

	if( is_wp_error( $response ) ) {
		$error_string = $response->get_error_message();
		return 'Error occurred: <em>' . $error_string . '</em>';
	}

	$posts = json_decode( wp_remote_retrieve_body( $response ) );

	if( empty( $posts ) ) { return 'No posts found'; }
	else {
		$result = '<ul>';
		$post_count = 0;
		foreach( $posts as $post ) {
			$post_count++;
			if ($post_count <= $how_many) {
				$result .= '<li><a href="' . $post->link. '">' . $post->title->rendered . '</a></li>';
			}
		}
		$result .= '</ul>';
		return $result;
	}
}

// make it available
add_shortcode('kk_rest', 'kk_rest_handler');
