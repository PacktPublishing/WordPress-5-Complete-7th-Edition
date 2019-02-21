<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Daily Cooking Custom
 */

if(!is_active_sidebar('sidebar-1')) return;
?>
<div id="secondary" class="widget-area" role="complementary">
	<?php if(is_active_sidebar('sidebar-1')) dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
