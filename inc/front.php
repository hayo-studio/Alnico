<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

if(!class_exists('AlnicoFront')) {
  class AlnicoFront {
    public function __construct() {
      add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
      add_action( 'the_password_form', array( &$this, 'password_form' ) );
      add_action( 'comment_form', array( &$this, 'submit_comment') );

      add_filter( 'script_loader_tag', array( &$this, 'filter_scripts'), 10, 3 );
      add_filter( 'style_loader_src', array( &$this, 'filter_styles' ), 10, 2 );
      add_filter( 'excerpt_more', array( &$this, 'excerpt_more' ) );

      remove_action( 'rest_api_init', 'wp_oembed_register_route');
      remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );

      remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
      remove_filter( 'oembed_response_data', 'get_oembed_response_data_rich', 10, 4 );

      remove_action( 'wp_head', 'wp_oembed_add_discovery_links');
      remove_action( 'wp_head', 'wp_oembed_add_host_js');

      remove_action( 'wp_head', 'wp_custom_css_cb', 101 );
      add_action( 'wp_head', array( &$this, 'custom_css_cb' ), 101 );
    }

    public function password_form($value='') {
      global $post;
      $post = get_post( $post );
      $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
      $output = 
      '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">'
      .'<i class="material-icons">warning</i>' . __( '这是一篇受密码保护的文章，您需要提供访问密码：', 'alnico' )
      .'<div class="mdl-textfield mdl-js-textfield"><input class="mdl-textfield__input" name="post_password" type="password" id="' . $label . '" size="20" autocomplete="off"/><label class="mdl-textfield__label" for="' . $label . '">' . __( '密码：', 'alnico' ) . '</label></div>'
      .'<button type="submit" class="mdl-button mdl-js-button mdl-button--with-icon mdl-button--raised mdl-js-ripple-effect mdl-button--accent">'
      .'<i class="material-icons">lock_open</i>'
      .'</button>'
      .'</form>';
      return $output;
    }

    public function enqueue_scripts() {
      if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
      }
    }

    public function custom_css_cb() {
      $styles = wp_get_custom_css();
      if ( $styles || is_customize_preview() ) : ?>
        <style>
          <?php echo strip_tags( $styles ); // Note that esc_html() cannot be used because `div &gt; span` is not interpreted properly. ?>
        </style>
      <?php endif;
    }

    public function filter_scripts( $tag, $handle, $src ) {
      $tag = alnico_str_replace( ' type=\'text/javascript\'', '', $tag, 1 );
      $tag = alnico_str_replace( '?ver=', '?', $tag, 1 );
      return $tag;
    }

    public function filter_styles( $src, $handle ) {
      $src = alnico_str_replace( '?ver=', '?', $src, 1 );
      return $src;
    }

    public function excerpt_more( $excerpt ) {
      return '';
    }

    public function submit_comment() {
      $js_content = "o=document.getElementById('comment');if(!o.value){o.style.borderColor='#d50000';return false}";
      echo '<button id="post-comment" type="submit" class="mdl-button mdl-js-button mdl-button--fab mdl-button--raised mdl-js-ripple-effect mdl-button--accent mdl-shadow--3dp" onclick="'.$js_content.'"><i class="material-icons">send</i></button>';
    }

  }

  return new AlnicoFront;
}
