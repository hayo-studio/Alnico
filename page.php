<?php get_header();?>
<div class="mdl-grid site-width">
  <div id="primary" class="mdl-cell mdl-cell--12-col">
    <div id="content">

      <?php
      while ( have_posts() ) {
        the_post();
        get_template_part( 'content' );
        alnico_page_nav();
        comments_template();
      }
      ?>

    </div>
  </div>
</div>
<?php get_footer();?>