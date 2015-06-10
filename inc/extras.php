<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package HVboom
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function hvboom_body_classes($classes) {
  // Adds a class of group-blog to blogs with more than 1 published author.
  if (is_multi_author()) {
    $classes[] = 'group-blog';
  }

  return $classes;
}
add_filter('body_class', 'hvboom_body_classes');

if (version_compare($GLOBALS['wp_version'], '4.1', '<')) :
  /**
   * Filters wp_title to print a neat <title> tag based on what is being viewed.
   *
   * @param string $title Default title text for current view.
   * @param string $sep Optional separator.
   * @return string The filtered title.
   */
  function hvboom_wp_title($title, $sep) {
    if (is_feed()) {
      return $title;
    }

    global $page, $paged;

    // Add the blog name
    $title .= get_bloginfo('name', 'display');

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) {
      $title .= " $sep $site_description";
    }

    // Add a page number if necessary:
    if (($paged >= 2 || $page >= 2) && ! is_404()) {
      $title .= " $sep " . sprintf(esc_html__('Page %s', 'hvboom'), max($paged, $page));
    }

    return $title;
  }
  add_filter('wp_title', 'hvboom_wp_title', 10, 2);

  /**
   * Title shim for sites older than WordPress 4.1.
   *
   * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
   * @todo Remove this function when WordPress 4.3 is released.
   */
  function hvboom_render_title() {
    ?>
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php
  }
  add_action('wp_head', 'hvboom_render_title');
endif;

/**
 * Custom Read More Button
 */
function modify_read_more_link() {
  return '<p><a class="more-link btn btn-default btn-sm" href="' . get_permalink() . '">' . sprintf('%s', esc_html__('Read more', 'hvboom')) . '</a></p>';
}
add_filter('the_content_more_link', 'modify_read_more_link');

/**
 * Custom Post Edit Button
 */
function custom_edit_post_link($output) {
 $output = str_replace('class="post-edit-link"', 'class="post-edit-link btn btn-danger btn-xs"', $output);
 return $output;
}
add_filter('edit_post_link', 'custom_edit_post_link');

/**
 * Custom Comment Edit Button
 */
function custom_edit_comment_link($output) {
 $output = str_replace('class="comment-edit-link"', 'class="comment-edit-link btn btn-danger btn-xs"', $output);
 return $output;
}
add_filter('edit_comment_link', 'custom_edit_comment_link');

/**
 * Custom Comment Reply Button
 */
function custom_comment_reply_link($link, $args, $comment, $post) {
 $link = str_replace('comment-reply-link', 'comment-reply-link btn btn-default btn-sm', $link);
 return $link;
}
add_filter('comment_reply_link', 'custom_comment_reply_link');

/**
 * Custom Cancel Comment Reply Button
 */
function custom_cancel_comment_reply_link($formatted_link, $link, $text) {
 $formatted_link = str_replace('<a ', '<a class="cancel-comment-reply-link btn btn-warning btn-xs"', $formatted_link);
 return $formatted_link;
}
add_filter('cancel_comment_reply_link', 'custom_cancel_comment_reply_link');


/**
 * Custom Comment Fields
 */
function bootstrap3_comment_form_fields($fields) {
  $commenter = wp_get_current_commenter();
  
  $req = get_option('require_name_email');
  $aria_req = ($req ? " aria-required='true'" : '');
  $html5 = current_theme_supports('html5', 'comment-form') ? 1 : 0;
  
  $fields   =  array(
    'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . __('Name', 'hvboom') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
    '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></div>',
    'email'  => '<div class="form-group comment-form-email"><label for="email">' . __('Email', 'hvboom') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
    '<input class="form-control" id="email" name="email" ' . ($html5 ? 'type="email"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></div>',
    'url'  => '<div class="form-group comment-form-url"><label for="url">' . __('Website', 'hvboom') . '</label> ' .
    '<input class="form-control" id="url" name="url" ' . ($html5 ? 'type="url"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></div>'  
);
  
  return $fields;
}
add_filter('comment_form_default_fields', 'bootstrap3_comment_form_fields');


/**
 * Custom Comment Form
 */
function bootstrap3_comment_form($args) {
  $args['comment_field'] = '<div class="form-group comment-form-comment">
            <label for="comment">' . _x('Comment', 'noun') . '</label> 
            <textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
        </div>';
  $args['class_submit'] = 'btn btn-default'; // since WP 4.1
    
  return $args;
}
add_filter('comment_form_defaults', 'bootstrap3_comment_form');


/**
 * Custom function to highlight search terms
 */
function search_excerpt_highlight() {
  $excerpt = get_the_excerpt();
  $keys = implode('|', explode(' ', get_search_query()));
  $excerpt = preg_replace('/(' . $keys .')/iu', '<mark>\0</mark>', $excerpt);

  echo '<p>' . $excerpt . '</p>';
}
