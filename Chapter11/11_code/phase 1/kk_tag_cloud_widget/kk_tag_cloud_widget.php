<?php
/*
Plugin Name: Karol K's Tag Cloud Widget
Description: Displays a nice tag cloud.
Plugin URI: http://nio.tips/
Version: 1.0
Author: Karol K
Author URI: http://karol.cc/
License: GNU General Public License v2 or later

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
*/

// MAIN WIDGET CLASS =============

class KK_Widget_Tag_Cloud extends WP_Widget {

	// creates the widget
	public function __construct() {
		parent::__construct('kk-tag-cloud', 'KK Tag Cloud', array('description' => 'Your most used tags in cloud format; same height; custom background'));
	}
	
	// outputs the content of the widget
	public function widget($args, $instance) {
		extract($args);
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		if(!empty($instance['title'])) {
			$title = $instance['title'];
		}
		else {
			if('post_tag' == $current_taxonomy) {
				$title = 'Tags';
			}
			else {
				$tax = get_taxonomy($current_taxonomy);
				$title = $tax->labels->name;
			}
		}
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		$before_widget = '<div class="widget-container kk_widget_tag_cloud">';
		$after_widget = '</div>';
		$before_title = '<h1 class="widget-title">';
		$after_title = '</h1>';

		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;
		echo '<div class="kk_tagcloud">';
		wp_tag_cloud(apply_filters('widget_tag_cloud_args', array('taxonomy' => $current_taxonomy)));
		echo "</div>\n";
		echo $after_widget;
	}
	// getting the current taxonomy
	function _get_current_taxonomy($instance) {
		if ( !empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy']) )
			return $instance['taxonomy'];
		return 'post_tag';
	}

	// outputs the options form in the wp-admin
	public function form($instance) {
		$instance = wp_parse_args((array) $instance, array('template' => ''));
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset($instance['title'])) {echo esc_attr($instance['title']);} ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('taxonomy'); ?>">Taxonomy</label>
			<select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
			<?php foreach(get_object_taxonomies('post') as $taxonomy) :
				$tax = get_taxonomy($taxonomy);
				if(!$tax->show_tagcloud || empty($tax->labels->name))
					continue;
				?>
				<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy); ?>><?php echo $tax->labels->name; ?></option>
			<?php endforeach; ?>
			</select>
		</p>
		<?php
	}
	
	// processes widget options to be saved
	public function update($new_instance, $old_instance) {
		$instance['title'] = $new_instance['title'];
		$instance['taxonomy'] = stripslashes($new_instance['taxonomy']);
		return $instance;
	}
}

// HOOKS =============

function KK_Widget_Tag_Cloud_Reg() {
	register_widget('KK_Widget_Tag_Cloud');
}
add_action('widgets_init', 'KK_Widget_Tag_Cloud_Reg');

// enqueue the stylesheet
function kk_tag_cloud_widget_styles_load() {
	wp_register_style('kk_tag_cloud_widget_styles', plugins_url('kk_tag_cloud_widget.css', __FILE__));
	wp_enqueue_style('kk_tag_cloud_widget_styles');
}
add_action('wp_enqueue_scripts', 'kk_tag_cloud_widget_styles_load');
