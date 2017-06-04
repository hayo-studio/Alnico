<?php get_header(); ?>
<div class="mdl-color-text--grey-900" role="heading">
  <h1><?php printf( __( '“%s”的搜索结果：', 'alnico' ), get_search_query() ); ?></h1>
</div>
<div class="mdl-grid site-width">
  <div id="primary" class="lv mdl-cell mdl-cell--12-col">
    <div id="content">

    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'card', get_post_format() ); ?>
      <?php endwhile; ?>

      <?php alnico_page_nav(); ?>
    <?php else : ?>
      <div class="mdl-typography--title-color-contrast text-center">
        <?php _e( '没有找到搜索结果', 'alnico'); ?>
      </div>
    <?php endif; ?>

    </div>
  </div>
</div>
<?php get_footer(); ?>