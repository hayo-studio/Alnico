<?php get_header(); ?>
<div class="mdl-grid site-width">
  <div id="primary" class="mdl-cell mdl-cell--12-col">
    <div id="content">

      <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content' ); ?>
        <?php alnico_page_nav(); ?>
        <?php comments_template(); ?>
      <?php endwhile; ?>

    </div>
  </div>
</div>
<?php get_footer(); ?>