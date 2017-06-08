<?php $gallery = get_post_gallery();?>
<article id="post-<?php the_ID();?>" <?php post_class('mdl-card card-mid mdl-shadow--2dp expanded');?>>
  <header>
    <h1><a href="<?php the_permalink();?>" rel="bookmark"><?php the_title();?></a></h1>
    <div>
      <?php alnico_meta();?>
    </div>
    <?php alnico_tags();?>
  </header>

  <?php if ( $gallery && !post_password_required()) : ?>
  <div>
    <?php echo $gallery;?>
  </div>
  <?php endif;?>

  <?php if ( has_post_thumbnail() && !post_password_required() ) : ?>
  <div class="mdl-card__media mdl-shadow--2dp">
    <?php the_post_thumbnail('full');?>
  </div>
  <?php endif;?>

  <div>
    <?php
    $content = alnico_strip_shortcode( get_the_content(), 'gallery' );
    $content = str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', $content ) );
    echo $content;
    ?>
    <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __('页数：', 'alnico') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );?>
  </div>
</article>