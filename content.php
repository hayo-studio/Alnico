<article id="p<?php the_ID();?>" <?php post_class('mdl-card card-mid mdl-shadow--2dp expanded');?>>
  <?php alnico_thumb();?>
  <div class="mdl-card__actions mdl-card--border">
    <?php alnico_meta();?>
  </div>
  <div class="mdl-card__content">
    <?php alnico_tags(); ?>
    <?php the_content(); ?>
    <?php wp_link_pages( array(
      'before' => '<div class="page-links"><span class="page-links-title">' . __('页数：', 'alnico') . '</span>',
      'after' => '</div>',
      'link_before' => '<span>',
      'link_after' => '</span>'
    ) );?>
  </div>

</article>