<?php
/**
 * The template used for displaying book content
 *
 * @package Daily Cooking Custom
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
	</header>

	<div class="entry-content">
		<?php if(has_post_thumbnail()) : ?>
			<div class="post-image alignleft"><?php echo get_the_post_thumbnail($post->ID, 'medium', array('style' => 'border: 1px solid black;')); ?></div>
		<?php endif; ?>
		<?php echo '<p><em>by '.get_post_meta($post->ID, 'book_author', true).'</em></p>'; ?>
		<?php the_content(); ?>
		<?php echo get_the_term_list($post->ID, 'book_category', '<em>Categories: ', ', ', '</em>'); ?>
	</div>

	<footer class="entry-footer">
	</footer>
</article><!-- #post-## -->
