<?php
/**
 * Daily Cooking Custom functions and definitions
 *
 * @package Daily Cooking Custom
 */

if(!function_exists('daily_cooking_custom_setup')) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function daily_cooking_custom_setup() {

	//Make theme available for translation.
	//Translations can be filed in the /languages/ directory.
	load_theme_textdomain('daily-cooking-custom', get_template_directory().'/languages');

	//Adds RSS feed links to <head> for posts and comments.
	add_theme_support('automatic-feed-links');

	//Let WordPress manage the document title.
	/* By adding theme support, we declare that this theme does not use a hard-coded <title> tag in the document head, and expect WordPress to provide it for us. */
	add_theme_support('title-tag');

	//Enable support for Post Thumbnails on posts and pages.
	//add_theme_support( 'post-thumbnails' );

	//This theme uses wp_nav_menu() in one location.
	register_nav_menus(array(
		'primary' => __('Primary Menu', 'daily-cooking-custom'),
	));

	//Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support('html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	));

	//Set up the WordPress core custom background feature.
	add_theme_support('custom-background', apply_filters( 'daily_cooking_custom_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	)));
}
endif; //daily_cooking_custom_setup
add_action('after_setup_theme', 'daily_cooking_custom_setup');

/**
 * Enqueue scripts and styles.
 */
function daily_cooking_custom_scripts() {
	wp_enqueue_style('daily-cooking-custom-style', get_stylesheet_uri());

	//wp_enqueue_script('daily-cooking-custom-navigation', get_template_directory_uri().'/js/navigation.js', array(), '20120206', true);

	//wp_enqueue_script( 'daily-cooking-custom-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	/*if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}*/
}
add_action('wp_enqueue_scripts', 'daily_cooking_custom_scripts');

// CHAPTER 9 -- the basic functions.php structure ends here --

/**
 * Register widget area.
 */
function daily_cooking_custom_widgets_init() {
	register_sidebar(array(
		'name'          => __('Sidebar', 'daily-cooking-custom'),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	));
}
add_action('widgets_init', 'daily_cooking_custom_widgets_init');

// CHAPTER 9 -- custom sidebar/widget definition ends here --

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
