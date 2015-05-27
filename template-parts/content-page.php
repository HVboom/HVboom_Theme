<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package HVboom
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if (has_post_thumbnail()) : ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <?php the_post_thumbnail('thumbnail', array('class' => 'img-responsive')); ?>
			</a>
		<?php endif; ?>

		<?php the_content(); ?>
		<?php
			wp_link_pages(array(
				'before' => '<div class="page-links">' . esc_html__('Pages:', 'hvboom'),
				'after'  => '</div>',
			));
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php edit_post_link(esc_html__('Edit', 'hvboom'), '<span class="edit-link">', '</span>'); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
