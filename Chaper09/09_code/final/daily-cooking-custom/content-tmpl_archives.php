<?php
/**
 * The template used for displaying archive content
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
		
		<div style="float: left; width: 50%;">
			<h2>Categories</h2>
			<ul>
			<?php wp_list_categories('orderby=name&title_li='); ?> 
			</ul>
		</div>
		<div style="float: left; width: 50%;">
			<h2>Tags</h2>
			<?php wp_tag_cloud('smallest=8&largest=20'); ?> 
		</div>
		<div style="clear: both;"></div><!-- clears the floating -->
		
		<?php
		$how_many_last_posts = 15;
		echo '<h2>Last '.$how_many_last_posts.' Posts</h2>';
		$my_query = new WP_Query('post_type=post&nopaging=1');
		if($my_query->have_posts()) 
		{
			echo '<ul>';
			$counter = 1;
			while($my_query->have_posts() && $counter<=$how_many_last_posts)
			{
				$my_query->the_post(); 
				?>
				<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
				<?php
				$counter++;
			}
			echo '</ul>';
			wp_reset_postdata();
		}
		?>

		<h2>By Month</h2>
		<p><?php wp_get_archives('type=monthly&format=custom&after= |'); ?></p>
	</div>

	<footer class="entry-footer">
	</footer>
</article><!-- #post-## -->
