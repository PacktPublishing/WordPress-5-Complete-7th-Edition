<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Daily Cooking Custom
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function daily_cooking_custom_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'daily_cooking_custom_jetpack_setup' );
