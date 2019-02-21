<?php
/*
Plugin Name: Add Document Type Styles New
Plugin URI: http://nio.tips/
Description: Detects URLs in your posts and pages and displays nice document type icons next to them. Includes support for: PDF, DOC, MP3 and ZIP.
Version: 1.0
Author: Karol K
Author URI: http://karol.cc/
Text Domain: add_doctype_styles_new
License: GNU General Public License v2 or later

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. | This is a fork of a plugin called "Add Document Type Styles" created by Aaron Hodge Silver (https://springthistle.com) | Icons made by https://www.freepik.com from https://www.flaticon.com - licensed under CC BY 3.0.
*/

// this function does the magic
function doctype_styles_new_regex($text) {
	$text = preg_replace('/href=([\'|"][[:alnum:]|[:punct:]]*)\.(pdf|doc|mp3|zip)([\'|"])/', 'href=\\1.\\2\\3 class="link \\2"', $text);
	return $text;
}

// this functions adds the stylesheet to the head
function doctype_styles_new_styles() {
	wp_register_style('doctypes_styles', plugins_url('doctype_styles_new.css', __FILE__));
	wp_enqueue_style('doctypes_styles');
}

// HOOKS =============

add_filter('the_content', 'doctype_styles_new_regex', 9);
add_action('wp_enqueue_scripts', 'doctype_styles_new_styles');
