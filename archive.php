<?php get_header();?>
<div class="mdl-grid site-width">
  <div id="primary" class="lv mdl-cell mdl-cell--12-col">
    <div id="content">
      <?php if ( is_author() ) :?>
        <div class="mdl-card card-mid mdl-shadow--2dp">
          <?php echo get_the_author();?>
          <br>
          <?php echo get_the_author_meta( 'description' );?>
        </div>
      <h1><?php printf(__('%s的文章：', 'alnico'), get_the_author());?></h1>
      <?php else:?>
        <?php the_archive_title('<h1>', '</h1>');?>
      <?php endif;?>

    <?php if ( have_posts() ) : ?>

      <?php while ( have_posts() ) : the_post();?>
        <?php get_template_part( 'card', get_post_format() );?>
      <?php endwhile;?>

      <?php alnico_page_nav();?>

    <?php else : ?>
      <?php //get_template_part( 'content', 'none' );?>
    <?php endif;?>

    </div>
  </div>
</div>
<?php get_footer();?>