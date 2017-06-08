<?php
/*
Template Name: 友情链接
*/
?>
<?php get_header();?>
<div class="mdl-grid site-width">
  <div id="primary" class="mdl-cell mdl-cell--12-col">
    <div id="content" class="mdl-grid">
      <style>
        .mdl-card { transition: .3s; }
        .mdl-card:hover {
            box-shadow:0 4px 5px 0 rgba(0,0,0,.14),0 1px 10px 0 rgba(0,0,0,.12),0 2px 4px -1px rgba(0,0,0,.2);
        }
        .mdl-card__content:empty { display: none; }
        #content>article{ min-height: initial; }
        #content>div {
          height: 120px;
          display: inline-block;
          border-bottom: 5px solid rgb(33,150,243); /*blue*/
        }
        #content>div:nth-child(2n + 1) { border-color: rgb(63,81,181); } /*indigo*/
        #content>div:nth-child(3n + 2), #content>div:nth-child(6) { border-color: rgb(156,39,176); } /*purple*/
        #content>div:nth-child(5n + 3) { border-color: rgb(244,67,54); } /*red*/
        #content>div:nth-child(7n + 5) { border-color: rgb(255,235,59); } /*yellow*/
      </style>
      <article id="p<?php the_ID();?>" <?php post_class('mdl-card mdl-cell mdl-cell--12-col mdl-shadow--2dp expanded');?>>
        <?php alnico_thumb();?>
        <div class="mdl-card__content">
          <?php the_content();?>
        </div>
      </article>
      <?php

        if ( $keys = get_post_custom_keys() ) {
          foreach ( (array) $keys as $raw_name ) {
            if ( is_protected_meta( trim($raw_name), 'post' ) )
              continue;
            $url = array_map('trim', get_post_custom_values($raw_name))[0];
            $name = preg_replace( '/(:\s|：)/', ':', $raw_name , 1 );
            $desc = '';
            if ( $raw_name != $name ) {
              $arr = explode( ':', $name );
              $name = $arr[0];
              $desc = $arr[1];
            }
            // echo "<div class='mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col' title='$url'>{$name}".(!empty($desc)?"：{$desc}":"")."</div>";
          }
        }
			wp_list_bookmarks('title_li=0&before=<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col">&after=</div>&link_before=<strong>&link_after=</strong>');
      ?>
    </div>

  </div>
</div>
<?php get_footer();?>
