<?php
function alnico_customize_register($wp_customize) {
  $wp_customize->remove_section('colors');
  $wp_customize->remove_section('header_image');
  $wp_customize->remove_section('static_front_page');
  
  $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
  
  $wp_customize->selective_refresh->add_partial( 'blogname', array(
    'selector' => '.site-title',
    'render_callback' => 'alnico_customize_partial_blogname',
  ) );
  $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
    'selector' => '.site-description',
    'render_callback' => 'alnico_customize_partial_blogdescription',
  ) );
  
  /*theme options*/
  $wp_customize->add_section( 'alnico_options', array(
    'title' => __('首选项', 'alnico'),
    'priority' => 35,
    'capability' => 'edit_theme_options',
    'description' => __('Alnico 主题的主要选项。', 'alnico'),
  ) );
  $wp_customize->add_setting( 'meta_description', array(
    'type' => 'theme_mod',
    'transport' => 'postMessage',
  ) );
  $wp_customize->add_control( 'meta_description', array(
    'type' => 'text',
    'priority' => 1,
    'section' => 'alnico_options',
    'label' => 'Meta 介绍',
    'description' => '影响了被爬虫抓取的情况。'
  ) );
  $wp_customize->add_setting( 'meta_keywords', array(
    'type' => 'theme_mod',
    'transport' => 'postMessage',
  ) );
  $wp_customize->add_control( 'meta_keywords', array(
    'type' => 'text',
    'priority' => 1,
    'section' => 'alnico_options',
    'label' => 'Meta 关键词',
    'description' => '影响了被爬虫抓取的情况。'
  ) );
  $wp_customize->add_setting( 'mdl_custom_css', array(
    'type' => 'theme_mod',
    'transport' => 'postMessage',
    'sanitize_callback' => 'esc_url_raw'
  ) );
  $wp_customize->add_control( 'mdl_custom_css', array(
    'type' => 'text',
    'priority' => 1,
    'section' => 'alnico_options',
    'label' => '配色方案（选填）',
    'description' => sprintf(__('访问 <a href="%s" target="_blank">MDL Customize</a> 尝试不同配色。（你也可以使用 <a href="%s" target="_blank">BootCDN</a>）', 'alnico'), esc_url('http://www.getmdl.io/customize/index.html'), esc_url('http://www.bootcdn.cn/material-design-lite/'))
  ) );
  $wp_customize->add_setting( 'primary_color', array(
    'sanitize_callback'  => 'sanitize_hex_color_no_hash',
    'sanitize_js_callback' => 'maybe_hash_hex_color',
    'default' => '607d8b',
    'type' => 'theme_mod',
    'transport' => 'postMessage'
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
    'priority' => 2,
    'label' => __( '主色', 'alnico' ),
    'description' => __('Chrome 移动版顶部颜色。定义在<code>material.min.css</code>中。', 'alnico'),
    'section' => 'alnico_options',
  ) ) );
  $wp_customize->add_setting('site_width', array(
    'sanitize_callback' => 'alnico_sanitize_site_width',
    'default' => '768px',
    'type' => 'theme_mod',
    'transport' => 'postMessage'
  ) );
  $wp_customize->add_control('site_width', array(
    'type' => 'text',
    'priority' => 3,
    'section' => 'alnico_options',
    'label' => __('主区域宽度', 'alnico'),
    'description' => __('请在数值后加 px 或 %', 'alnico'),
  ) );

  /*background_image section*/
  foreach ( array( 'color', 'image', 'preset', 'position_x', 'position_y', 'size', 'repeat', 'attachment' ) as $prop ) {
    $wp_customize->get_setting( 'background_' . $prop )->transport = 'postMessage';
  }
  $wp_customize->add_setting( 'background_color', array(
    'sanitize_callback'  => 'sanitize_hex_color_no_hash',
    'sanitize_js_callback' => 'maybe_hash_hex_color',
    'default' => 'f5f5f5'
  ) );
  $wp_customize->add_control(new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
    'priority' => 100,
    'section' => 'background_image',
    'label' => __('背景颜色', 'alnico')
  ) ) );
  $wp_customize->add_setting( 'transparent_card', array(
    'default' => 1,
    //'sanitize_callback' => array( $wp_customize, '_sanitize_background_setting' ),
    'theme_supports' => 'custom-background',
    'transport' => 'postMessage'
  ) );

  $wp_customize->add_control( 'transparent_card', array(
    'label' => __( '部分页面卡片透明', 'alnico' ),
    'priority' => 99,
    'section' => 'background_image',
    'type' => 'checkbox'
  ) );

  /*CDN section*/
  /*
  $wp_customize->add_section('cdn', array(
    'title' => __('CDN','alnico'),
    'priority' => 36,
    'capability' => 'edit_theme_options',
    'description' => __('设置 Alnico 中的 CDN', 'alnico'),
  ) );
  */

  /*header section*/
  $wp_customize->add_section('header_options', array(
    'title' => __('导航栏', 'alnico'),
    'priority' => 107,
    'capability' => 'edit_theme_options',
    'description' => __('提供自定义导航栏的选项。', 'alnico'),
  ) );
  $wp_customize->add_setting('logo', array(
    'default' => Alnico::get('url','images').'logo.png',
    'type' => 'theme_mod',
    'transport' => 'postMessage',
    'sanitize_callback' => 'esc_url_raw'
  ) );
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'logo', array(
    'label' => __('站点 Logo', 'alnico'),
    'section' => 'header_options',
    'priority' => 3,
    'type' => 'image',
    'mime_type' => 'image',
  ) ) );

  /*Footer Section*/
  /*$wp_customize->add_section('footer_options', array(
    'title' => __('社会媒体', 'alnico'),
    'priority' => 108,
    'capability' => 'edit_theme_options',
    'description' => __('WIP', 'alnico'),
  ));
  
  $socials = Alnico::get('social_fields');
  $i = 1;
  foreach ($socials as $social) {
    $wp_customize->add_setting( 'social_'.$social['field'], array(
      'default' => '',
      'type' => 'theme_mod',
      'transport' => 'postMessage',
      'sanitize_callback' => 'esc_url_raw'
    ) );
    $wp_customize->add_control( 'social_'.$social['field'], array(
      'type' => 'text',
      'priority' => $i++,
      'section' => 'footer_options',
      'label' => $social['name']
    ) );
  }
  */

}

function alnico_customize_header_output() {
  global $wpdb;
  $v = $wpdb->get_var("SELECT MAX(ID) FROM $wpdb->posts;"); //内容性更新

  if ( !empty($_COOKIE['nls']) && $_COOKIE['nls'] != '0' ) {
    $_COOKIE['w'] = '0';
  }

  $pos = '';
  if ( is_home() || is_archive() || is_search() ) {
    $pos = 'list';
  } elseif ( is_single() ) {
    $pos = 'post';
  } elseif ( is_page() ) {
    $pos = 'page';
  }

?>

  <style><?php alnico_customize_generate_css('.site-width', 'max-width', 'site_width');?></style>
  <meta name="theme-color" content="#<?php echo get_theme_mod('primary_color', '607d8b');?>">
  <script>
    <?php
    if ( is_single() || is_page() ) {
      echo 'id='.get_the_ID().';';
    } else {
      echo 'id=0;';
    }
    ;?>
    a = {
      v: <?php echo $v;?>,
      home: "<?php echo home_url( '/' );?>",
      ajax: "<?php echo admin_url( 'admin-ajax.php' );?>",
      name: "<?php bloginfo( 'name' );?>",
      pos: "<?php echo $pos;?>"
    };
    !function(e,n,t) {
      function c(e,t) {
        n.cookie=e+"="+t+";path=/;expires=Tue, 15 Sep 2048 23:33:33 GMT"
      }
      e.L={}, L.h=L.l=L.c=function(){};
      var l="nls", i="innerHTML", o="execScript";
      try{
        t[l] = 0,
        L.h = function(e) {
          t[e]=n.getElementById(e)[i]
        },
        L.l = function(l,a) {
          var r = t[l] || "";
          if( r.length > 99 ) {
            var s = n.createElement( a ? "script" : "style" );
            e[o]&&a ? e[o](r) : (s[i]=r,n.head.appendChild(s))
          } else {
            n.documentElement.style.display="none";
            c("w",0);
            t.clear();
            location.reload()
          }
        },
        L.c=c
      } catch(a) {
        c(l,1)
      }
    }(this,document,localStorage)
  </script>
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-title" content="<?php bloginfo( 'name' );?>">
  <?php
  $mdl_css = alnico__t('mdl_custom_css');
  if ( is_customize_preview() ) {
      
    if ( $mdl_css == '' ) {
      $mdl_css = Alnico::get( 'url', 'css' ).'material.min.css';
    } else {
      echo '<link rel="stylesheet" id="mdl-icons-css" href="'.Alnico::get( 'url', 'css' ).'material-icons.css'.'">';
    }
    echo '<link rel="stylesheet" id="mdl-css" href="'.$mdl_css.'">';
  } elseif ( $mdl_css == '' ) {
    alnico_print_res( Alnico::get( 'path', 'css' ).'material.min.css', 'mdl-css', 0 );
  } else {
    echo '<link rel="stylesheet" id="mdl-css" href="'.$mdl_css.'">';
    alnico_print_res( Alnico::get( 'path', 'css' ).'material-icons.css', 'icons-css', 7 );
  }
  alnico_print_res( Alnico::get( 'path', 'css' ).'common.min.css', 'my-css', 1 );
}

function alnico_customize_footer_output() {

  alnico_print_res( Alnico::get( 'path', 'js' ).'material.min.js', 'mdl-js', 2, 1 );
  alnico_print_res( ABSPATH.'wp-includes/js/jquery/jquery.js', 'jq-js', 3, 1 );
  alnico_print_res( Alnico::get( 'path', 'js' ).'jquery.lazyload.min.js', 'll-js', 4, 1 );
  alnico_print_res( Alnico::get( 'path', 'js' ).'common.min.js', 'my-js', 5, 1 );

}

function alnico_print_res( $path, $id, $cookie_location, $type = 'style' ) {

  $w_list = str_split( '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~!()*_-.+' );
  $n = (int)Alnico::get( 'v', $id ) % 70 - 1;
  $n = $n == -1 ? 70 : $n;

  $len = (alnico__t('mdl_custom_css') == '') ? 7 : 8;
  if( empty( $_COOKIE['w'] ) || strlen( $_COOKIE['w'] ) != $len ) $_COOKIE['w'] = str_repeat('0', $len);
  $old_w = str_split( $_COOKIE['w'] );

  $type = $type == 1 ? 'script' : $type;
  if( empty( $old_w[ $cookie_location ] ) || $old_w[ $cookie_location ] !== $w_list[ $n ] ) {
    if( file_exists( $path ) ) {
      echo "<$type id='$id'>" . file_get_contents( $path ) . "</$type>";
      echo "<script>L.h('$id')</script>";

      $old_w[ $cookie_location ] = $w_list[ $n ];
      $_COOKIE['w'] = implode( '', $old_w );
      setcookie('w', $_COOKIE['w'], time () + 3600*24*180, '/');
    }
  } else {
    echo "<script>L.l('$id'" . ( $type==="script"?",1":"" ) . ")</script>";
  }
}

function alnico_customize_live_preview() {
  wp_enqueue_script( 'alnico-customizer', Alnico::get( 'url','js' ).'customize-preview.js', array( 'customize-preview' ) , '', true);
}

function alnico_customize_generate_css($selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true) {
  $return = '';
  $mod = esc_attr(get_theme_mod($mod_name));
  if (!empty($mod)) {
    $return = sprintf('%s{%s:%s}', $selector, $style, $prefix . $mod . $postfix);
    if ($echo) echo $return;
  }
  return $return;
}

add_action('wp_head', 'alnico_customize_header_output');
add_action('wp_footer', 'alnico_customize_footer_output');
add_action('customize_register', 'alnico_customize_register');
add_action('customize_preview_init', 'alnico_customize_live_preview');

function alnico_customize_partial_blogname() {
  bloginfo( 'name' );
}

function alnico_customize_partial_blogdescription() {
  bloginfo( 'description' );
}
