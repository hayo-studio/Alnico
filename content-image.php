<article id="post-<?php the_ID();?>" <?php post_class('mdl-card card-mid mdl-shadow--2dp expanded');?>>
  <div class="mdl-card__media">
    <?php the_content();?>
    <?php alnico_tags();?>
    <?php wp_link_pages( array(
      'before' => '<div class="page-links"><span class="page-links-title">' . __('页数：', 'alnico') . '</span>',
      'after' => '</div>',
      'link_before' => '<span>',
      'link_after' => '</span>'
    ) );?>
  </div>
</article>
