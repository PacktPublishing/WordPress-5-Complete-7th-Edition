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
	add_theme_support( 'post-thumbnails' );

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

// CHAPTER 13 -- custom post types and taxonomies --

/**
 * Custom post type - Book
 */
function book_init() {
	$labels = array(
		'name' => 'Books',
		'singular_name' => 'Book',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Book',
		'edit_item' => 'Edit Book',
		'new_item' => 'New Book',
		'view_item' => 'View Book',
		'search_items' => 'Search Books',
		'not_found' =>  'No books found',
		'not_found_in_trash' => 'No books found in Trash'
	);
	$args = array(
		'labels' => $labels,
		'description' => 'A custom post type that holds my books',
		'public' => true,
		'rewrite' => array('slug' => 'books'),
		'has_archive' => true,
		'taxonomies' => array('book_category'),
		'supports' => array('title', 'editor', 'author', 'excerpt', 'custom-fields', 'thumbnail'),
		'show_in_rest' => true
	);
	register_post_type('book', $args);
	flush_rewrite_rules();
}
add_action('init', 'book_init');

/**
 * Admin messages for your custom post type
 */
function book_updated_messages( $messages ) {
	$messages['book'] = array(
		'', /* Unused. Messages start at index 1. */
		sprintf('Book updated. <a href="%s">View book</a>', esc_url(get_permalink($post_ID))), 
		'Custom field updated.', 
		'Custom field deleted.', 
		'Book updated.', 
		(isset($_GET['revision']) ? sprintf('Book restored to revision from %s', wp_post_revision_title((int)$_GET['revision'], false)) : false), 
		sprintf('Book published. <a href="%s">View book</a>', esc_url(get_permalink($post_ID))), 
		'Book saved.', 
		sprintf('Book submitted. <a target="_blank" href="%s">Preview book</a>', esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))), 
		sprintf('Book scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview book</a>', date_i18n('M j, Y @ G:i', strtotime($post->post_date)), esc_url(get_permalink($post_ID))), 
		sprintf('Book draft updated. <a target="_blank" href="%s">Preview book</a>', esc_url(add_query_arg('preview', 'true', get_permalink($post_ID))))
	);
	return $messages;
}
add_filter('post_updated_messages', 'book_updated_messages');

/**
 * Custom taxonomy for books
 */
function build_taxonomies() {
	register_taxonomy(
		'book_category',
		'book',
		array(
			'hierarchical' => true,
			'public' => true,
			'show_in_rest' => true,
			'label' => 'Book Category',
			'query_var' => true,
			'rewrite' => array('slug' => 'available-books')
		)
	);
}
add_action('init', 'build_taxonomies', 0);

/**
 * Adjusting the Books section in the wp-admin
 */
function ahskk_custom_columns($defaults) {
	global $wp_query, $pagenow;
	if ($pagenow == 'edit.php') {
		unset($defaults['author']);
		unset($defaults['categories']);
		unset($defaults['date']);
		$defaults['book_category'] = 'Categories';
		$defaults['thumbnail'] = 'Image';
	}
	return $defaults;
}
add_filter('manage_book_posts_columns', 'ahskk_custom_columns');
function ahskk_show_columns($name) {
	global $post;
	switch ($name) {
		case 'book_category':
			echo get_the_term_list($post->ID, 'book_category', '', ', ', '');
			break;
		case 'thumbnail':
			if (has_post_thumbnail($post->ID)) echo get_the_post_thumbnail($post->ID, array('40', '40'));
			break;
	}
}
add_action('manage_book_posts_custom_column', 'ahskk_show_columns');

// CHAPTER 13 -- custom post types and taxonomies ends here --
