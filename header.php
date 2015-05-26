<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package HVboom
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
    <div id="page" class="hfeed site">
	    <header id="masthead" class="site-header" role="banner">
        <nav role="navigation">
          <div class="navbar navbar-static-top navbar-default">
            <div class="container">
              <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand"
                   href="<?php echo esc_url(home_url('/')); ?>"
                   title="<?php bloginfo('name') ?>"
                   rel="homepage"><?php bloginfo('name') ?></a>
              </div><!-- #navbar-header -->           

              <div class="navbar-collapse collapse navbar-responsive-collapse">
                <?php
                  $args = array(
                    'theme_location' => 'primary',
                    'depth'          => 2,
                    'container'      => false,
                    'menu_class'     => 'nav navbar-nav navbar-right',
                    'walker'         => new Bootstrap_Walker_Nav_Menu()
                   );

                  if (has_nav_menu('primary')) {
                    wp_nav_menu($args);
                  }
                ?>
              </div><!-- #navbar-collapse -->           
            </div><!-- #container -->           
          </div><!-- #navbar -->           
		    </nav><!-- #site-navigation -->
	    </header><!-- #masthead -->

      <div id="content" class="site-content container">
