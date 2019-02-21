<?php
/**
 * @package Daily Cooking Custom
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>

		<div class="entry-meta">
			<?php daily_cooking_custom_posted_on(); ?>
		</div>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages(array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'daily-cooking-custom' ),
				'after'  => '</div>',
			));
		?>
	</div>

	<footer class="entry-footer">
		<?php daily_cooking_custom_entry_footer(); ?>
	</footer>
</article><!-- #post-## -->
