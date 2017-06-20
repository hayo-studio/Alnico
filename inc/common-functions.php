<?php

function alnico_admin_bar() {
?>
<style media="screen">
#wpadminbar {
  position: absolute;
  background: transparent;
  z-index: 3
}
header { padding-top: 26px!important }
.mdl-layout__drawer-button { top: 26px }
@media screen and (max-width:782px) {
  header { padding-top: 40px!important }
  .mdl-layout__drawer-button { top: 40px }
}
</style>
<?php
}

function alnico_custom_background() {
  // $background is the saved custom image, or the default image.
  $background = set_url_scheme( get_background_image() );

  if ( !$background ) {
    if ( is_customize_preview() ) {
      echo '<style id="custom-background-css"></style>';
    }
    return;
  }

  if ( $background ) {
    // $background is the saved custom image, or the default image.
    // $image = ' background-image: url("' . esc_url_raw( $background ) . '");'; //lazyload

    // $color is the saved custom color.
    // A default has to be specified in style.css. It will not be printed here.
    $color = get_background_color();

    if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
      $color = false;
    }

    if ( ! $background && ! $color ) {
      if ( is_customize_preview() ) {
        echo '<style id="custom-background-css"></style>';
      }
      return;
    }

    $style = $color ? "background-color: #$color;" : '';

    // Background Position.
    $position_x = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
    $position_y = get_theme_mod( 'background_position_y', get_theme_support( 'custom-background', 'default-position-y' ) );

    if ( ! in_array( $position_x, array( 'left', 'center', 'right' ), true ) ) {
      $position_x = 'left';
    }

    if ( ! in_array( $position_y, array( 'top', 'center', 'bottom' ), true ) ) {
      $position_y = 'top';
    }

    $position = " background-position: $position_x $position_y;";

    // Background Size.
    $size = get_theme_mod( 'background_size', get_theme_support( 'custom-background', 'default-size' ) );

    if ( ! in_array( $size, array( 'auto', 'contain', 'cover' ), true ) ) {
      $size = 'auto';
    }

    $size = " background-size: $size;";

    // Background Repeat.
    $repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );

    if ( ! in_array( $repeat, array( 'repeat-x', 'repeat-y', 'repeat', 'no-repeat' ), true ) ) {
      $repeat = 'repeat';
    }

    $repeat = " background-repeat: $repeat;";

    // Background Scroll.
    $attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );

    if ( 'fixed' !== $attachment ) {
      $attachment = 'scroll';
    }

    $attachment = " background-attachment: $attachment;";

    $style .= $position . $size . $repeat . $attachment;
  }
?>
<style id="custom-background-css">
#main { <?php echo trim( $style );?> }
<?php
if ( alnico__t( 'transparent_card' ) ) :?>
.lv .mdl-card { background: rgba( 255, 255, 255, .5); }
.lv .mdl-card:hover { background: rgba( 255, 255, 255, .7); }
.lv .mdl-card mdl-card__supporting-text { text-shadow:1px 1px 6px #fff; }
<?php endif;?>
</style>
<?php
}

function alnico_nav_menu($menu, $container_class = '', $item_class = '', $echo = true) {
  $walker = new Alnico_Walker();
  $walker->item_class = $item_class;
  
  return wp_nav_menu( array(
      'theme_location' => $menu,
      'container' => 'nav',
      'container_class' => $container_class,
      'items_wrap' => '%3$s',
      'depth' => 1,
      'walker' => $walker,
      'echo' => $echo
    )
  );
}

function alnico_list_comments($comment, $args, $depth) {
  switch ( $comment->comment_type ) :

    case 'pingback'  :
    case 'trackback' :
      ?>
      <li <?php comment_class('mdl-list__item');?> id="comment-<?php comment_ID();?>">
        <p>
          <?php
          _e( 'Pingback: ', 'alnico' );
          comment_author_link();
          $link = get_edit_comment_link();
          if ($link) {
            echo "<nav class='btns'>"
              ."<a href='$link' class='mdl-button mdl-js-button mdl-button--icon mdl-button--accent'><i class='material-icons'>edit</i></a>"
              ."</nav>";
          }
          ?>
        </p>
      <?php
    break;

    default :
      global $post;
      ?>
      <li <?php comment_class('mdl-list__item');?> id="comment-<?php comment_ID();?>">
        <div>
          <div class="commenter-info">
            <?php echo get_avatar( $comment, 40 );?>
          </div>
          <div class="commenter-info">
            <div>
            <?php
              $url     = get_comment_author_url( $comment );
              $author  = get_comment_author( $comment );

              if ( empty( $url ) || 'http://' == $url ){
                if ( $comment->user_id > 0 && $user = get_userdata( $comment->user_id ) ) {
                  echo "<a href='".get_author_posts_url( $comment->user_id )."' rel='external nofollow' class='url'>$author</a>";
                }else{
                  echo $author;
                }

              }else{
                echo "<a href='$url' rel='external nofollow' class='url'>$author</a>";
              }
            ?>
            </div>
            <time><?php echo get_comment_date().' '.get_comment_time();?></time>
          </div>
          <?php comment_text();?>

          <nav class="btns">
            <?php $link = get_edit_comment_link();
            if ($link) {
              echo "<a href='$link' class='mdl-button mdl-js-button mdl-button--icon mdl-button--accent'><i class='material-icons'>edit</i></a>";
            }
            echo str_replace( 'comment-reply-link', 'mdl-button mdl-js-button mdl-button--icon mdl-button--accent', get_comment_reply_link(
              array_merge(
                $args,
                array(
                  'reply_text' => '<i class="material-icons">reply</i>',
                  'depth'      => $depth,
                  'max_depth'  => $args['max_depth'],
                )
              )
            ) );
            ?>
          </nav>
        </div>
      <?php
    break;
  endswitch;
}

function alnico_thumb() {
  if ( has_post_thumbnail() && !post_password_required() && !is_attachment() ) :?>
    <div class="mdl-card__media">
      <div class="thumb">
        <?php the_post_thumbnail( 'card-thumb' );?>
      </div>
      <div class="mdl-card__title">
        <h1 class="mdl-card__title-text t">
          <?php the_title();?>
        </h1>
      </div>
    </div>
  <?php else: ?>
    <div class="mdl-card__title">
      <h1 class="t"><?php the_title();?></h1>
    </div>
  <?php endif;
}

function alnico_meta($opt = array('author', 'date', 'category', 'edit'), $echo = 1) {
  $ret = '';
  if (in_array('author', $opt)) {
  $ret = '<a class="author-link mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><div class="name">'.get_avatar( get_the_author_meta( 'ID' ), 26 ).' ' . esc_html( get_the_author() ) . '</div></a>';
  }
  if (in_array('date', $opt)) {
    //$ret .= '<span class="lg-only mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect"><i class="material-icons mini">schedule</i> <date>'.get_the_date().'</date></span>';
    $ret .= '<time class="lg-only">'.get_the_date().'</time>';
  }
  if (in_array('publised_in', $opt)) {
  global $post;
    $ret .= '<span class="publish-in"><i class="material-icons">publish</i> '.__('发布于', 'alnico').' <a href="'.esc_url(get_permalink( $post->post_parent )).'">'.esc_html(get_the_title($post->post_parent)).'</a></span>';
  }
  if (in_array('edit', $opt)) {
  $elink = get_edit_post_link();
    if ($elink) {
    $ret .= '<a class="edit mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="'.esc_url(get_edit_post_link()).'"><i class="material-icons mini">edit</i> '.__( '编辑', 'alnico' ).'</a>';
    }
  }
  if (in_array('category', $opt)) {
    foreach((get_the_category()) as $category) {
      $ret .= '<a class="cat mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect clear" href="'.esc_url( get_category_link( $category->term_id ) ).'" rel="category"><i class="material-icons mini">folder_open</i> '.$category->name.'</a>';
    }
  }
  if ($echo) echo $ret;
  return $ret;
}

function alnico_tags($echo = 1) {
  $ret = get_the_tag_list('<div class="tags">', '', '</div>');
  if ($echo) echo $ret;
  return $ret;
}

function alnico__t ($option, $echo = false) {
  if ($echo) {
    echo Alnico::get( 'settings', $option );
  } else {
    return Alnico::get( 'settings', $option );
  }
}

function alnico__tx($option, $value = '', $op = '=') {
  switch ($op) {
    case "=":  return alnico__t($option) == $value;
    case "!=": return alnico__t($option) != $value;
    case ">=": return alnico__t($option) >= $value;
    case "<=": return alnico__t($option) <= $value;
    case ">":  return alnico__t($option) >  $value;
    case "<":  return alnico__t($option) <  $value;
  }
}

function alnico_page_nav() {
  global $wp_query, $wp_rewrite;
  if ( $wp_query->max_num_pages < 2 ) {
    return;
  }
  
  // Setting up default values based on the current URL.
  $base = html_entity_decode( get_pagenum_link() );
  $url_parts    = explode( '?', $base );
 
  // Get max pages and current page out of the current query, if available.
  $total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
  $current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
 
  // Append the format placeholder to the base URL.
  $base = trailingslashit( $url_parts[0] ) . '%_%';
 
  // URL base depends on permalink settings.
  $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $base, 'index.php' ) ? 'index.php/' : '';
  $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

  echo "<nav id='page-nav' class='post-nav' role='navigation'><a class='mdl-button mdl-js-button mdl-button--icon mdl-color--grey-100'";

  if ( $current && 1 < $current ) {
      $link = str_replace( '%_%', 2 == $current ? '' : $format, $base );
      $link = str_replace( '%#%', $current - 1, $link );
      /**
       * Filters the paginated links for the given archive pages.
       *
       * @since 3.0.0
       *
       * @param string $link The paginated link URL.
       */
      echo " href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'><i class='material-icons'>&#xE5CB;</i";
  }

  echo "></a>";
  echo "<div class='mdl-layout-spacer text-center'>" . $current . "</div>";
  echo "<a class='mdl-button mdl-js-button mdl-button--icon mdl-color--grey-100'";

  if ( $current && $current < $wp_query->max_num_pages ) {
      $link = str_replace( '%_%', $format, $base );
      $link = str_replace( '%#%', $current + 1, $link );
      /** This filter is documented in wp-includes/general-template.php */
      echo " href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'><i class='material-icons'>&#xE5CC;</i";
  }
  echo "></a></nav>";
}

function alnico_post_nav($page_actions = true, $main_actions = true, $ajax = false) {
?>
  <nav id="post-nav" class='post-nav'>
  <?php
  if ( $page_actions ) {
    $link = get_next_post_link (
      '%link',
      '<i class="material-icons">&#xE5CB;</i><div class="mdl-tooltip" for="next-post">%title</div>'
    );
    if ( $link ) {
      echo str_replace( '<a ', '<a id="next-post" class="mdl-button mdl-js-button mdl-button--icon mdl-color--grey-100" ', $link );
    } else {
      echo "<a id='next-post'></a>";
    }
  }
  ?>
  <div class="mdl-layout-spacer"></div>
  <?php if ( $page_actions ):?>
    <a id="back" class="mdl-button mdl-js-button mdl-button--icon mdl-color--grey-100" href="<?php echo $ajax ? 'javascript:history.go(-1);' : esc_url(home_url( '/' ));?>">
      <i class="material-icons">home</i>
      <div class="mdl-tooltip" for="back"><?php _e('回到主页', 'alnico');?></div>
    </a>
    <?php
    $like_num = alnico_get_like( get_the_ID() );
    $is_liked = isset( $_COOKIE['liked'] ) ? $_COOKIE['liked'] : '';
    //$is_liked = base64_decode( $is_liked );
    $is_liked = alnico_is_liked( $is_liked, get_the_ID() )
    ?>
    <button id="like" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-color-text--red mdl-color--white<?php if ( $like_num == 0 ) echo ' zero';?>">
      <i class="material-icons"><?php echo $is_liked ? 'favorite' : 'favorite_border';?></i>
      <div id="like-num"><?php if ( $like_num != 0 ) echo $like_num;?></div>
      <div class="mdl-tooltip" for="like"><?php echo $is_liked ? __('取消赞', 'alnico') : __('赞', 'alnico');?></div>
    </button>
    <a id="share" class="mdl-button mdl-js-button mdl-button--icon mdl-color--grey-100">
      <i class="material-icons">share</i>
      <div class="mdl-tooltip" for="share"><?php _e('分享', 'alnico');?></div>
    </a>
    <?php alnico_share();?>
  <?php endif;?>
  <div class="mdl-layout-spacer"></div>
  <?php
  if ($page_actions) {
    $link = get_previous_post_link (
      '%link',
      '<i class="material-icons">&#xE5CC;</i><div class="mdl-tooltip" for="prev-post">%title</div>'
    );
    if ( $link ) {
      echo str_replace( '<a ', '<a id="prev-post" class="mdl-button mdl-js-button mdl-button--icon mdl-color--grey-100" ', $link );
    } else {
      echo "<a id='prev-post'></a>";
    }
  };
  ?>
  </nav>
<?php
}

function alnico_share() {
  $pfnames = array(
    '微博',
    'QQ',
    'QQ空间'
  );
  $pflinks = array(
    'http://service.weibo.com/share/share.php?appkey=&title={title} - {author}&url={link}&pic=&searchPic=false&style=simple',
    'http://connect.qq.com/widget/shareqq/index.html?site={name}&title={title}&summary={desc}&pics=' . esc_url( home_url( '/favicon.png' ) ) . '&url={link}',
    'https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url={link}&showcount=1&desc=&summary={desc}&title={title}&site={name}&pics=&style=203&width=98&height=22'
  );
  $pfclasses = array(
    'wb',
    'qq',
    'qz'
  );
  $len = count( $pflinks );

  $title = get_the_title();
  $author = get_the_author();
  $link = get_permalink();
  $blogname = get_bloginfo( 'name' );
  $blogdescription = get_bloginfo( 'description' );

  echo "<ul id='for-share' class='mdl-menu mdl-menu--bottom-left mdl-js-menu' for='share'>";
  for ( $i=0; $i<$len; $i++ ) {
    $url = str_replace( array(
    '{link}', '{author}', '{title}', '{name}', '{desc}'
    ), array(
    $link, $author, $title, $blogname, $blogdescription
    ),
    $pflinks [$i]
    );
    echo "<a title='" . sprintf( __( '分享到%s', 'alnico' ), $pfnames [$i] ) . "' class='mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect svg svg-" . $pfclasses [$i] . "' href=" .esc_url( $url ). " target='_blank'><li>";
    echo "<i class='material-icons'></i>";
    echo "</li></a>";
  }
  echo "</ul>";
}

function alnico_sanitize_site_width($value) {
  preg_match("/(\d*)(px|%)?/", $value, $matches);
  if (strlen($matches[1]) < 1) {
      $value = '768px';
  } else if (empty($matches[2])) {
      $value = $matches[1].'px';
  }
  return $value;
}

function alnico_sanitize_display_favicon($value) {
  if (empty($value) || !in_array($value, array(1, 0))) {
      $value = 0;
  }
  return $value;
}

function alnico_sanitize_c_header_size($value) {
  if (!in_array($value, array( 'small', 'big'))) {
      $value = 'big';
  }
  return $value;
}

function alnico_pr($obj, $val=null) {
  echo "<pre>";
  echo str_repeat("-",10)."Start".str_repeat("-",10)."<br>";
    print_r($obj);
  echo "<br>".str_repeat("-",11)."End".str_repeat("-",11);
  echo "</pre>";
  if($val) exit;
}

function alnico_catch_image() {
  global $post;
  if ( !preg_match_all( '/<img\s.*?src="(.+?)".+?width="(.+?)".+?height="(.+?)".+?>/i', $post->post_content, $matches ) )
    return '';//如果文章无图片，获取自定义图片？

  //调整图片尺寸
  //$ret = preg_replace( array(
  //  '/\sclass="/',
  //  '/\ssrc="(.+?)"/',
  //  '/\swidth=".+?"/',
  //  '/\sheight=".+?"/'
  //), array(
  //  ' class="lazy ',
  //  ' data-original="\1"',
  //  ' width="100%"',
  //  ' height="100%"'
  //), $matches [0] [0] );

  $ret = array();
  $ret ['url'] = $matches [1] [0];
  $ret ['width'] = $matches [2] [0];
  $ret ['height'] = $matches [3] [0];
  return $ret;
}

function alnico_is_mobile() {
  $user_agent = $_SERVER['HTTP_USER_AGENT'];
  $mobile_browser = Array(
    "mqqbrowser","opera mini","juc","iuc","ucbrowser","fennec","ios","applewebKit/420","applewebkit/525","applewebkit/532","ipad","ipaq","ipod","windows ce","240x320","480x640","acer","android","anywhereyougo.com","asus","audio","blackberry","blazer","coolpad" ,"dopod", "etouch", "hitachi","htc","huawei", "jbrowser", "lenovo","lg","lg-","lge-","lge", "mobi","moto","nokia","phone","samsung","sony","symbian","tianyu","wap","xda","xde","zte"
  );
  $is_mobile = false;
  foreach ($mobile_browser as $device) {
    if (stristr($user_agent, $device)) {
      $is_mobile = true;
      break;
    }
  }
  return $is_mobile;
}

function alnico_ajax_post() {
  header( "Content-Type: application/json" );

  if ( !isset($_GET['p']) ) {
    echo json_encode( array(
      'ec' => -1
    ) );
    exit;
  }

  global $post, $wp_query;
  $post = get_post( isset( $_GET['p'] ) ? $_GET['p'] : 0 );

  if ( !$post ) {
    echo json_encode( array(
      'ec' => -2
    ) );
    exit;
  }

  $wp_query->post = $post;
  $wp_query->is_single = true;
  $ret['id'] = $post->post_name;

  if ( post_password_required() ) {
    $content = get_the_password_form();
  } else {
    $content = apply_filters( 'the_content', $post->post_content );
    $content = str_replace( ']]>', ']]&gt;', $content );

    ob_start();
    comments_template();
    $comments = ob_get_clean();
  }
  
  // 以后可能会考虑单独缓存 post-nav
  //if ( !isset( $_GET['nav'] ) || $_GET['nav'] == '0' ) {
  //  ob_start();
  //  alnico_print_res( ABSPATH.'wp-includes/js/comment-reply.min.js', 'comment-js', 5, 1 );
  //  $script = ob_get_clean();
  //  $ret['comment'] .= $script;
  //}

  ob_start();
  alnico_post_nav( true, true, true, true );
  $ret['comment'] = ob_get_clean();

  if( $comments ) {
    $ret['comment'] .= $comments;
    $ret['comment'] = trim(preg_replace('/\>\s+\</', '><', $ret['comment']));

    if ( !isset( $_GET['js'] ) || $_GET['js'] == '0' ) {
      ob_start();
      alnico_print_res( ABSPATH.'wp-includes/js/comment-reply.min.js', 'comment-js', 5, 1 );
      $script = ob_get_clean();
      $ret['comment'] .= $script;
    }
  }

  $post_type = get_post_format( $post );
  if( $post_type ) {
    $ret['type'] = $post_type;
  }

  $ret['ec'] = 1;
  $ret['content'] = get_the_tag_list('<div class="tags">', '', '</div>', (Int)$_GET['p']) . $content;
  //$ret['like'] = alnico_get_like($id);

  echo json_encode( $ret );
  exit;
}
add_action( 'wp_ajax_nopriv_load-post', 'alnico_ajax_post' );
add_action( 'wp_ajax_load-post', 'alnico_ajax_post' );

function alnico_ajax_comment() {
  header( "Content-Type: application/json" );

  if ( !isset($_GET['p']) ) {
    echo json_encode( array(
      'ec' => -1
    ) );
    exit;
  }

  global $post, $wp_query;
  $post = get_post( $_GET['p'] );

  if ( !$post ) {
    echo json_encode( array(
      'ec' => -2
    ) );
    exit;
  }

  $wp_query->post = $post;
  $wp_query->is_single = true;

  ob_start();
  alnico_post_nav();
  comments_template();
  $ret['comment'] = ob_get_clean();
  $ret['comment'] = trim(preg_replace('/\>\s+\</', '><', $ret['comment']));

  if ( !isset( $_GET['js'] ) || $_GET['js'] == '0' ) {
    ob_start();
    alnico_print_res( ABSPATH.'wp-includes/js/comment-reply.min.js', 'cr-js', 6, 1 );
    $script = ob_get_clean();
    $ret['comment'] .= $script;
  }

  $ret['ec'] = 1;

  echo json_encode( $ret );
  exit;
}
add_action( 'wp_ajax_nopriv_load-comment', 'alnico_ajax_comment' );
add_action( 'wp_ajax_load-comment', 'alnico_ajax_comment' );

function alnico_get_like($id) {
  $num = get_term_meta($id, 'like', true);
  return $num ? $num : 0;
}

function alnico_is_liked($liked, $id) {
  return strpos('-' . $liked, '-' . $id . '-') !== false;
}

function alnico_ajax_like() {
  header('Content-Type: application/json');

  if ( !isset($_POST['p']) ) {
    echo json_encode( array(
      'ec' => -1
    ) );
    exit;
  }

  $id = $_POST['p'];
  global $post, $wp_query;
  $post = get_post( $id );

  if ( !$post ) {
    echo json_encode( array(
      'ec' => -2
      //'em' => '文章ID不存在。'
    ));
    exit;
  }

  $wp_query->post = $post;
  $wp_query->is_single = true;

  $type = $_POST['type'] ? $_POST['type'] : '';
  $num = alnico_get_like($id);
  $liked = $_COOKIE['liked'] ? $_COOKIE['liked'] : '';
  //$liked = base64_decode($liked);
  $is_liked = alnico_is_liked($liked, $id);
  if($type == 'cancel') {
    if( $is_liked ) {
      if($num > 0) {
        $num = $num - 1;
        $liked = str_replace('-' . $id . '-', '-', '-' . $liked);
        $liked = alnico_str_replace('-', '', $liked, 1);
        //$liked = base64_encode($liked);
        setcookie('liked', $liked, time () + 3600*24*180, '/');
      } else {
        echo json_encode( array(
          'ec' => -3
          //'em' => '赞数为零。'
        ));
        exit;
      }
    } else {
      echo json_encode( array(
        'ec' => -4
        //'em' => '已经取消点赞过。'
      ));
      exit;
    }
  } else {
    if ( !$is_liked ) {
      $num = $num + 1;
      $liked = $liked . $id . '-';
      //$liked = base64_encode($liked);
      setcookie('liked', $liked, time () + 3600*24*180, '/');
    } else {
      echo json_encode( array(
        'ec' => -5
        //'em' => '已经点赞过。'
      ) );
      exit;
    }
  }
  update_term_meta( $id, 'like', $num);
  echo json_encode( array(
    'ec' => 1,
    'num' => $num
  ));
  exit;
}
add_action('wp_ajax_nopriv_like', 'alnico_ajax_like');
add_action('wp_ajax_like', 'alnico_ajax_like');

/**
 * 带次数限制的文本替换
 * 
 * @param  mixed    $search  查找的目标值
 * @param  string   $replace search 的替换值
 * @param  string   $content 执行替换的字符串
 * @param  int      $limit   替换次数
 * @return string            替换后的字符串
 */
function alnico_str_replace($search, $replace, $content, $limit = -1) {
  if (is_array ($search)) {
    foreach ($search as $k => $v) {
      $search[$k] = '`' . preg_quote ($search[$k], '`') . '`';
    }
  } else {
    $search = '`' . preg_quote ($search, '`') . '`';
  }
  $content = preg_replace ('/alt=([^ >]+)/is', '', $content);
  return preg_replace ($search, $replace, $content, $limit);
}

add_filter( 'pre_option_link_manager_enabled', '__return_true' );
