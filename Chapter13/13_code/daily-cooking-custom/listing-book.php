<?php
/**
 * @package Daily Cooking Custom
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title(sprintf('<h1 class="entry-title">"<a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a>"</h1>'); ?>
	</header>

	<div class="entry-content">
		<?php if(has_post_thumbnail()) : ?>
			<div class="post-image alignleft">
				<?php echo '<a href="'.esc_url(get_permalink()).'" >'.get_the_post_thumbnail($post->ID, 'thumbnail').'</a>'; ?>
			</div>
		<?php endif; ?>
		
		<div class="entry clearfix">
			<p><em>by <?php echo get_post_meta($post->ID, 'book_author', true); ?></em></p>
			<?php the_content(sprintf(__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'daily-cooking-custom'),
			the_title('<span class="screen-reader-text">"', '"</span>', false))); ?>
		</div>
	</div>

	<footer class="entry-footer">
	</footer>
</article><!-- #post-## -->