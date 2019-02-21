<?php
/**
 * Daily Cooking Custom Theme Customizer
 *
 * @package Daily Cooking Custom
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function daily_cooking_custom_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	//$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	/////
	
	$wp_customize->add_section( 'menu_bar_colors' , array(
		'title' => 'Menu Bar Colors', 
		'priority' => 30) );
	
	$wp_customize->add_setting( 'menu_bar_color1' , array(
		'default' => '#69CACA') );
	$wp_customize->add_setting( 'menu_bar_color2' , array(
		'default' => '#279090') );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_bar_color1', array(
		'label' => 'Menu Bar Color 1', 
		'section' => 'menu_bar_colors', 
		'settings' => 'menu_bar_color1') ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_bar_color2', array(
		'label' => 'Menu Bar Color 2', 
		'section' => 'menu_bar_colors', 
		'settings' => 'menu_bar_color2') ) );
}
add_action( 'customize_register', 'daily_cooking_custom_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function daily_cooking_custom_customize_preview_js() {
	wp_enqueue_script( 'daily_cooking_custom_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'daily_cooking_custom_customize_preview_js' );

/////

function daily_cooking_customizer_menu_css()
{
    ?>
	<style type="text/css">
	.site-header .site-branding { background: <?php echo get_theme_mod('menu_bar_color1', '#69CACA'); ?>; }
	.main-navigation ul li { border-bottom: 1px solid <?php echo get_theme_mod('menu_bar_color1', '#69CACA'); ?>; }
	.site-header { background: <?php echo get_theme_mod('menu_bar_color2', '#279090'); ?>; }
	</style>
    <?php
}
add_action( 'wp_head', 'daily_cooking_customizer_menu_css');
