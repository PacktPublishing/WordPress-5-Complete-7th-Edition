<?
/*
Plugin Name: Capture Searched Words New
Plugin URI: http://nio.tips/
Description: Captures all words used in the search field and displays a count for each.
Version: 1.0
Author: Karol K
Author URI: http://karol.cc/
Text Domain: capture_searches_new
License: GNU General Public License v2 or later

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. | This is a fork of a plugin called "Capture Searched Words" created by Aaron Hodge Silver (http://springthistle.com) and Hasin Hayder (http://hasin.phpxperts.com).
*/

function searchedwords_init($content) {
	global $wpdb;
	$sw_table_name = $wpdb->prefix.'searchedwords';

	//creating the table (if it doesn't exist) or updating it if necessary
	if(isset($_GET['activate']) && 'true' == $_GET['activate']) {
		$sql = 'CREATE TABLE `'.$sw_table_name.'` (
id INT NOT NULL AUTO_INCREMENT, 
word VARCHAR(255), 
created DATETIME NOT NULL DEFAULT \''.date('Y-m-d').' 00:00:01\', 
PRIMARY KEY  (id)
)';
	
		require_once(ABSPATH.'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	
	// in case a search has just been performed, store the searched word 
	if (!empty($_GET['s'])) {
		$current_searched_words = explode(" ",urldecode($_GET['s']));
		foreach ($current_searched_words as $word) {
			$wpdb->query($wpdb->prepare("INSERT into `$sw_table_name` VALUES(null,'%s','".date('Y-m-d H:i:s')."')", $word));
		}
	}
}

function modify_menu_for_searchedwords() {
	$page = add_management_page(
		"Capture Searched Words", 
		"Capture Searched Words", 
		'manage_options', 
		'capture_searches_new', 
		'searchedwords_page'
	);
}

function searchedwords_page() {
	global $wpdb;
	$sw_table_name = $wpdb->prefix.'searchedwords';
	
	$searched_words = $wpdb->get_results("SELECT COUNT(word) AS occurance, word FROM `$sw_table_name` GROUP BY word ORDER BY occurance DESC");
	?>
<div class="wrap" style="max-width: 600px;">
<h2>Searched Words</h2>
<table class="wp-list-table widefat">
<thead>
	<tr>
		<th scope="col">Search Words</th>
		<th scope="col"># of Searches</th>
	</tr>
</thead>
<tbody>
	<?php
	if($searched_words !== NULL) {
		foreach($searched_words as $searched_word) {
			echo '<tr valign="top"><td>'.$searched_word->word.'</td><td>'.$searched_word->occurance.'</td></tr>';
		}
		$searched_perfomed = true;
	}
	else {
		echo '<tr valign="top"><td colspan="2"><strong>No searches have been preformed yet</strong></td></tr>';
	}
	?>
</tbody>
</table>
</div>
	<?php
}

add_filter('init', 'searchedwords_init');
add_action('admin_menu', 'modify_menu_for_searchedwords');
