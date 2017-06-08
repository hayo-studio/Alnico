<article id="p<?php the_ID();?>" <?php post_class('mdl-card card-mid mdl-shadow--2dp expanded');?>>
  <header>
    <h1><a href="<?php the_permalink();?>" rel="bookmark"><?php the_title();?></a></h1>
    <div>
      <?php alnico_meta(array('publised_in', 'date', 'attachment'));?>
    </div>
    <?php alnico_tags();?>
  </header>
  <div>
    <div class="mdl-card__media mdl-shadow--2dp">
      <?php echo wp_get_attachment_image( $post->ID, 'full' );?>
    </div>
  </div>
</article>