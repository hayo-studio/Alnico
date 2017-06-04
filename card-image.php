<article id="p<?php the_ID();?>" <?php post_class('mdl-card card-mid mdl-shadow--2dp'); ?>>
  <?php
  if (is_sticky()) {
    echo '<div class="sticky-border"></div><i class="material-icons sticky-icon mdl-color-text--white">attach_file</i>';
  } ?>
  <a id="t<?php the_ID(); ?>" class="mdl-js-button mdl-js-ripple-effect" href="<?php the_permalink(); ?>" rel="bookmark">
    <?php
    $first_img = alnico_catch_image();
    if ( $first_img ) {
      echo "<div class='lazy' data-original='".$first_img['url']."' style='padding-top:".$first_img['height']*100/$first_img['width']."%'></div>";
    }
    ?>
    <div class="mdl-card__actions t"><?php the_title(); ?></div>
  </a>
</article>
