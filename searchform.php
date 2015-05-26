<?php
/**
 * Search Form Template
 *
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
	<div class="row">
    <div class="input-group">
      <input type="search"
             name="s"
             class="form-control search-query"
             placeholder="<?php esc_attr_e('Search &hellip;', 'hvboom'); ?>"
             value="<?php echo get_search_query() ?>"
             aria-label="<?php esc_attr_e('Search for:', 'hvboom') ?>"
             title="<?php esc_attr_e('Search for:', 'hvboom') ?>" />
      <span class="input-group-btn">
        <button type="submit" class="btn btn-primary" name="submit" value="<?php esc_attr_e('Search', 'hvboom'); ?>"><?php _e('Search', 'hvboom'); ?></button>
      </span>
    </div>
	</div>
</form>
