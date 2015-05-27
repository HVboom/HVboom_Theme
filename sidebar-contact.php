<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package HVboom
 */

if (! is_active_sidebar('contact')) {
	return;
}
?>

<div id="secondary" class="widget-area col-md-3 well" role="complementary">
	<?php dynamic_sidebar('contact'); ?>
</div><!-- #secondary -->
