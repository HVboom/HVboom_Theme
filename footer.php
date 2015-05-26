<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package HVboom
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer container" role="contentinfo">
    <div class="row">
			<div class="col-md-6">
				<?php if (has_nav_menu('footer', 'hvboom')) { ?>
          <nav role="navigation">
            <?php wp_nav_menu(array(
              'container'       => '',
              'menu_class'      => 'footer-menu',
              'theme_location'  => 'footer')
            ); ?>
          </nav>
        <?php } ?>
			</div>

			<div class="col-md-6">
        <p class="text-right">&copy; <?php _e('Copyright', 'hvboom'); ?> <?php echo date('Y'); ?> - <a href="<?php echo esc_url(home_url('/')); ?>"
                   title="<?php bloginfo('name') ?>"
                   rel="homepage"><?php bloginfo('name') ?></a></p>
			</div>
    </div><!-- .row -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
