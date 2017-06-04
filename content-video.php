<article id="post-<?php the_ID(); ?>" <?php post_class('mdl-card card-mid mdl-shadow--2dp expanded'); ?>>
  <header>
    <h1><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
    <div>
      <?php alnico_meta();?>
    </div>
  </header>
  <div>
    <?php alnico_tags(); ?>
    <?php the_content(); ?>
    <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __('页数：', 'alnico') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
  </div>
</article>