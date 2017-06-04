<?php get_header(); ?>
<div class="mdl-grid site-width">
  <div id="primary" class="lv mdl-cell mdl-cell--12-col">
    <div id="content">
    <?php
    if ( have_posts() ) {

      while ( have_posts() ) {
          the_post();
        get_template_part( 'card', get_post_format() );
      }

      alnico_page_nav();

    } else {
      //get_template_part( 'content', 'none' );
    }
    ?>

    </div>
  </div>
</div>
<?php get_footer(); ?>
