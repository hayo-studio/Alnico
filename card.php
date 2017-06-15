<article id="p<?php the_ID();?>" <?php post_class('mdl-card card-mid mdl-shadow--2dp');?>>
  <?php if (is_sticky()) {
    echo '<div class="sticky-border"></div><i class="material-icons sticky-icon mdl-color-text--white">attach_file</i>';
  } ?>
  <a id="t<?php the_ID();?>" class="mdl-js-button mdl-js-ripple-effect" href="<?php the_permalink();?>" rel="bookmark">
    <?php alnico_thumb();?>
    <div class="mdl-card__supporting-text">
      <?php
      the_excerpt();
      echo ' <span class="read-more mdl-color-text--primary">'. __('继续阅读', 'alnico'). '</span>';
      ?>
    </div>
  </a>
  <div class="mdl-card__actions mdl-card--border">
    <?php alnico_meta(array('author', 'date', 'category'));?>
  </div>
    
</article>
