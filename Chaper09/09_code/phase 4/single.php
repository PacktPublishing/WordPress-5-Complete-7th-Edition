<?php
/**
 * The template for displaying all single posts.
 *
 * @package Daily Cooking Custom
 */
?><?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while (have_posts()) : the_post(); ?>

			<?php get_template_part('content', 'single'); ?>

			<?php daily_cooking_custom_post_nav(); ?>

			<?php
			// If comments are open or we have at least one comment, load up the comment template
			if (comments_open() || get_comments_number())
				comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
