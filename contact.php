<?php
/**
 * Template Name: Contact Page
 *
 * This is the template that displays a contact form.
 *
 * @package HVboom
 */

if(isset($_POST['submitted'])) {
  if(trim($_POST['contactName']) === '') {
    $contactNameError = true;
    $hasError = true;
  } else {
    $contactName = trim($_POST['contactName']);
  }

  if(trim($_POST['email']) === '')  {
    $emailError = true;
    $hasError = true;
  } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
    $emailError = true;
    $hasError = true;
  } else {
    $email = trim($_POST['email']);
  }

  if(trim($_POST['comments']) === '') {
    $commentError = true;
    $hasError = true;
  } else {
    if(function_exists('stripslashes')) {
      $comments = stripslashes(trim($_POST['comments']));
    } else {
      $comments = trim($_POST['comments']);
    }
  }

  if(! isset($hasError)) {
    $emailTo = get_option('admin_email');
    if (! isset($emailTo) || ($emailTo == '')){
      $emailTo = get_option('admin_email');
    }
    $subject = __('From ','hvboom').$contactName;
    $body = __('Name: ','hvboom').$contactName."\n".__('Email: ','hvboom').$email."\n".__('Comments: ','hvboom').$comments;
    $headers = __('From: ','hvboom') .$contactName. ' <'.$emailTo.'>' . "\r\n" . __('Reply-To:','hvboom') .$contactName. '<'.$email.'>';

    wp_mail($emailTo, $subject, $body, $headers);
    $emailSent = true;
  }
}

get_header(); ?>

  <div class="row">
    <div id="primary" class="col-md-9">
      <main id="main" class="site-main" role="main">

        <?php while (have_posts()) : the_post(); ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
              <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </header><!-- .entry-header -->

            <div class="entry-content">
              <?php the_content(); ?>

                <?php if(isset($emailSent) && $emailSent == true) { ?>
                  <div class="alert alert-success" role="alert">
                    <p><?php _e('Thanks, your email was sent successfully.', 'hvboom'); ?></p>
                  </div>
                <?php } else { ?>

                  <?php if(isset($hasError) || isset($captchaError)) { ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                      <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
                      <strong><?php _e('Error:', 'hvboom'); ?></strong> <?php _e('Please fill all fields.', 'hvboom'); ?>
                    </div>
                  <?php } ?>

                  <form action="<?php the_permalink(); ?>" id="contactForm" method="post">
                    <div class="form-group <?php if(isset($contactNameError)) { echo "has-error has-feedback"; }?>">
                      <label class="control-label" for="contactName"><?php _e('Name', 'hvboom'); ?></label>
                      <input class="form-control"
                             type="text"
                             name="contactName"
                             id="contactName"
                             value="<?php if(isset($contactName)) { echo $contactName; }?>"
                             aria-describedby="contactNameStatus"
                             aria-required="true"
                             autofocus />
                      <?php if(isset($contactNameError)) { ?>
                        <span class="fa fa-bolt form-control-feedback" aria-hidden="true"></span>
                        <span id="contactNameStatus" class="sr-only">(error)</span>
                      <?php } ?>
                    </div>

                    <div class="form-group <?php if(isset($emailError)) { echo "has-error has-feedback"; }?>">
                      <label class="control-label" for="email"><?php _e('Email', 'hvboom'); ?></label>
                      <input class="form-control"
                             type="email"
                             name="email"
                             id="email"
                             placeholder=<?php _e('jane.doe@example.com', 'hvboom'); ?>
                             value="<?php if(isset($email)) { echo $email; }?>"
                             aria-describedby="emailStatus"
                             aria-required="true" />
                      <?php if(isset($emailError)) { ?>
                        <span class="fa fa-bolt form-control-feedback" aria-hidden="true"></span>
                        <span id="emailStatus" class="sr-only">(error)</span>
                      <?php } ?>
                    </div>
                    <div class="form-group <?php if(isset($commentError)) { echo "has-error has-feedback"; }?>">
                      <label class="control-label" for="commentsText"><?php _e('Message', 'hvboom'); ?></label>
                      <textarea class="form-control"
                                name="comments"
                                id="commentsText"
                                rows="10"
                                cols="20"
                                aria-describedby="commentsTextStatus"
                                aria-required="true"><?php if(isset($comments)) { echo $comments; }?></textarea>
                      <?php if(isset($commentError)) { ?>
                        <span class="fa fa-bolt form-control-feedback" aria-hidden="true"></span>
                        <span id="commentsTextStatus" class="sr-only">(error)</span>
                      <?php } ?>
                    </div>

                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary"><?php _e('Send Email', 'hvboom'); ?></button>
                      <input type="hidden" name="submitted" id="submitted" value="true" />
                    </div>
                  </form>

              <?php } ?>
                    
              <?php
                wp_link_pages(array(
                  'before' => '<div class="page-links">' . __('Pages:', 'hvboom'),
                  'after'  => '</div>',
                ));
              ?>
            </div><!-- .entry-content -->

            <footer class="entry-footer">
              <?php edit_post_link(__('Edit', 'hvboom'), '<span class="edit-link">', '</span>'); ?>
            </footer><!-- .entry-footer -->
          </article><!-- #post-## -->

        <?php
          // If comments are open or we have at least one comment, load up the comment template
          if (comments_open() || '0' != get_comments_number()) :
            // Currently disable comments on the contact page
            // comments_template();
          endif;
        ?>

      <?php endwhile; // end of the loop. ?>

      </main><!-- #main -->
    </div><!-- #primary -->

    <?php get_sidebar('contact'); ?>

  </div><!-- #row -->

<?php get_footer(); ?>
