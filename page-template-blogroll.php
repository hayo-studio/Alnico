<?php
/**
 * Template Name: Links Page
 *
 * @author 雪尼是智障
 * @link http://xuenizhizhang.com
 * @copyright [雪尼是智障](http://xuenizhizhang.com)
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
        #content>div { border-bottom: 5px solid rgb(33,150,243); }
        #content>div:nth-child(2n + 1) { border-color: rgb(63,81,181); }
        #content>div:nth-child(3n + 2), #content>div:nth-child(6) { border-color: rgb(156,39,176); }
        #content>div:nth-child(5n + 3) { border-color: rgb(244,67,54); }
        #content>div:nth-child(7n + 5) { border-color: rgb(255,235,59); }

        #content a {
            display: block;
            height: 100%;
            text-align: center;
        }
        #content .name {
            padding-top: 40px;
            font-size: 22px;
            font-weight: 400;
            line-height: 1.2;
            color: #222;
        }
        #content .domain {
            margin-bottom: 5px;
            color: #999;
        }
        #content .domain, #content .name {
            display: block;
            width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
      </style>
      <?php $content = get_the_content();?>
      <article id="p<?php the_ID();?>" <?php post_class( ( $content ? 'mdl-card mdl-shadow--2dp ' : '' ) .'mdl-cell mdl-cell--12-col');?>>
        <?php
        alnico_thumb();
        if ( $content ) :
        ?>
        <div class="mdl-card__content">
          <?php echo $content;?>
        </div>
        <?php endif;?>
      </article>

      <?php

      /*if ( $keys = get_post_custom_keys() ) {
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
          echo "<div class='mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col' title='$url'>{$name}".(!empty($desc)?"：{$desc}":"")."</div>";
        }
      }*/

      wp_list_bookmarks( array(
          'title_li' => 0,
          'before' => "<div class='mdl-card mdl-cell mdl-cell--4-col mdl-shadow--2dp'>",
          'after' => "</div>"
      ) );
      ?>

    </div>
    <script>
    window.onload = function(links) {
      var link, links = document.getElementById("content").getElementsByTagName("a");
      for (var i = 0, len = links.length; i < len; i++) {
        link = links[i];
        link.innerHTML = "<strong class='name'>" + link.innerHTML + "</strong><span class='domain'>" + link.host + "</span><img class='favicon' src='//api.byi.pw/favicon?url=" + link.href + "' width='16' height='16'>"
      }
    }
    </script>
  </div>
</div>
<?php get_footer();?>
