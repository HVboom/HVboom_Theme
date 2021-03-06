<?php
/**
 * HVboom functions and definitions
 *
 * @package HVboom
 */

if (! function_exists('hvboom_setup')) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hvboom_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on HVboom, use a find and replace
	 * to change 'hvboom' to the name of your theme in all the template files
	 */
	load_theme_textdomain('hvboom', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(array(
		'primary' => esc_html__('Primary Menu', 'hvboom'),
		'footer' => esc_html__('Footer Menu', 'hvboom'),
	));

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support('html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	));

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support('post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	));

	// Set up the WordPress core custom background feature.
	add_theme_support('custom-background', apply_filters('hvboom_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	)));
}
endif; // hvboom_setup
add_action('after_setup_theme', 'hvboom_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hvboom_content_width() {
	$GLOBALS['content_width'] = apply_filters('hvboom_content_width', 640);
}
add_action('after_setup_theme', 'hvboom_content_width', 0);


/**
 *******
 * Security settings inspired from book Building Web Apps with WordPress / 78-1-4493-6407-6, chapter 8: Secure WordPress
 *******
 */

/**
 * Obscure, if the username or the password was wrong
 */
add_filter('login_errors', create_function('$a', '"Invalid username or password.";'));

/**
 * Don't write the WordPress version into generated files
 */
add_filter('the_generator', '__return_null');


/**
 * Hide standard login url
 */
//
// **** Not working - get always a 404  ****
//
// function hvboom_wp_login_filter($url, $path, $orig_scheme) {
//   $old = array("/(wp-login\.php)/");
//   $new = array("members");
// 
//   return preg_replace($old, $new, $url, 1);
// }
// add_filter('site_url', 'hvboom_wp_login_filter', 10, 3);
// 
// function hvboom_wp_login_redirect() {
//   if (strpos( $_SERVER["REQUEST_URI"], 'members') === false) {
//     wp_redirect(site_url());
//     exit();
//   }
// }
// add_action('login_init', 'hvboom_wp_login_redirect');



/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function hvboom_widgets_init() {
	register_sidebar(array(
		'name'          => esc_html__('Sidebar', 'hvboom'),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));

	register_sidebar(array(
		'name'          => esc_html__('Contact', 'hvboom'),
		'id'            => 'contact',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));
}
add_action('widgets_init', 'hvboom_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function hvboom_scripts() {
  $stylesheet_uri =  get_template_directory_uri() . '/assets/stylesheets';
  $javascript_uri =  get_template_directory_uri() . '/assets/javascripts';
  $vendor_bootstrap_javascript_uri =  get_template_directory_uri() . '/vendor/bootstrap-sass/assets/javascripts';

	wp_enqueue_style('hvboom-style', get_stylesheet_uri());

	wp_enqueue_script('bootstrap-js', $vendor_bootstrap_javascript_uri . '/bootstrap.js', array('jquery'), '3.3.4', true);

	wp_enqueue_script('hvboom-skip-link-focus-fix', $javascript_uri . '/skip-link-focus-fix.js', array(), '20130115', true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'hvboom_scripts');


/**
 * Add Respond.js for IE
 */
if(!function_exists('ie_scripts')) {
	function ie_scripts() {
	 	echo '<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->' . PHP_EOL;
	  echo '<!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->' . PHP_EOL; 
	  echo '<!--[if lt IE 9]>' . PHP_EOL;
	  echo '  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>' . PHP_EOL;
	  echo '  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>' . PHP_EOL;
	  echo '<![endif]-->' . PHP_EOL;
  }
  add_action('wp_head', 'ie_scripts');
} // end if


/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Bootstrap Menu.
 */
require get_template_directory() . '/inc/bootstrap-walker.php';

/**
 * Comments callback.
 */
require get_template_directory() . '/inc/comments-callback.php';
