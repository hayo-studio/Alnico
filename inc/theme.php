<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

if(!class_exists('Alnico')) {

  class Alnico {
    static public $_var = array();
    public function __construct() {
      // Define constants
      $this->define_constants();

      // Include required files
      $this->includes();

      // setup theme
      $this->setup();
    }

    static public function init() {
        // Named global variable to make access for other scripts easier.
        $GLOBALS[ __CLASS__ ] = new self;
      }

    private function setup() {
      load_theme_textdomain( 'alnico', get_template_directory() . '/languages' );
      
      add_theme_support( 'automatic-feed-links' );
      add_theme_support( 'post-thumbnails' );
      add_theme_support( "title-tag" );
      add_theme_support( 'html5', array(
        'comment-form', 'comment-list', 'gallery', 'caption',
      ));

      add_theme_support( 'post-formats', array(
        'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio', 'chat'
      ));

      register_nav_menus( array(
        //'drawer_menu' => __( '抽屉', 'alnico' ),
        'header' => __( '页眉链接', 'alnico' ),
        'footer' => __( '页脚链接', 'alnico' )
      ));

      add_theme_support( 'custom-background', array( 'wp-head-callback' => 'alnico_custom_background' ));
      add_theme_support( 'admin-bar', array( 'callback' => 'alnico_admin_bar' ) );

      add_image_size( 'card-thumb', 752, 216, true );

      add_action ('after_switch_theme', array( &$this, 'theme_activation') );
      add_editor_style( array( 'assets/css/editor-style.css' ) );
    }
    function theme_activation () {
      $v1 = self::get('version');
      $v2 = self::get('install_version');

      if ($v2 == '') { //first time activate
        set_theme_mod('site_width', '768px');
        set_theme_mod('primary_color', '607d8b');
        set_theme_mod('header_size', 'small');
        update_option(self::get('unique').'_version', $v1);
      }
      if ( version_compare( $v1, $v2 ) > 0 ) {
        //do upgrade
      }
    }

    private function define_constants() {
      $arr = array();

      //versions
      $arr['version'] = '1.0.0';
      $arr['verid'] = 1;
      $arr['unique'] = 'alnico';

      $arr['v']['mdl-js'] = 1;
      $arr['v']['jq-js'] = 1;
      $arr['v']['my-js'] = 7;
      $arr['v']['ll-js'] = 1;
      $arr['v']['cr-js'] = 1;
      $arr['v']['mdl-css'] = 1;
      $arr['v']['my-css'] = 5;
      $arr['v']['icons-css'] = 1;

      //paths
      $arr['path']['base'] = get_template_directory().'/';
      $arr['path']['inc'] = $arr['path']['base'].'inc/';
      $arr['path']['css'] = $arr['path']['base'].'assets/css/';
      $arr['path']['js'] = $arr['path']['base'].'assets/js/';

      //urls
      $arr['url']['base'] = get_template_directory_uri().'/';
      $arr['url']['css'] = $arr['url']['base'].'assets/css/';
      $arr['url']['js'] = $arr['url']['base'].'assets/js/';

      //settings
      $arr['install_version'] = get_option($arr['unique'].'_version');
      $arr['settings'] = get_theme_mods();
      $arr['settings'] = $arr['settings'] && is_array($arr['settings']) ? $arr['settings'] : array();
      $arr['social_fields'] = array(
          array('name'  => 'Facebook',
             'field' => 'facebook',
             'help'  => __('Enter your Facebook profile URL.', 'alnico')),
          array('name'  => 'Google+',
             'field' => 'gplus',
             'help'  => __('Enter your Google+ profile URL.', 'alnico')),
          array('name'  => 'Twitter',
            'field' => 'twitter',
            'help'  => __('Enter your Twitter acount profile URL.', 'alnico')),
          array('name'  => 'LinkedIn',
             'field' => 'linkedin',
             'help'  => __('Enter your LinkedIn profile URL.', 'alnico')),
          array('name'  => 'YouTube',
             'field' => 'youtube',
             'help'  => __('Enter your YouTube profile/channel URL.', 'alnico')),
          array('name'  => 'Blogger',
             'field' => 'blogger',
             'help'  => __('Enter your Blogger URL.', 'alnico')),
          array('name'  => 'Pinterest',
             'field' => 'pinterest',
             'help'  => __('Enter your Pinterest profile URL.', 'alnico')),
          array('name'  => 'Instagram',
             'field' => 'instagram',
             'help'  => __('Enter your Instagram profile URL.', 'alnico')),
          array('name'  => 'Tumblr',
             'field' => 'tumblr',
             'help'  => __('Enter your Tumblr profile URL.', 'alnico')),
        );
      self::$_var = $arr;
    }

    private function includes() {
      require self::get('path','inc').'common-functions.php';
      require self::get('path','inc').'front.php';
      require self::get('path','inc').'customizer.php';
      require self::get('path','inc').'walker-menu.php';
    }

    static public function get($key,$key1='') {
      if($key1==='' && isset(self::$_var[$key])){
        return self::$_var[$key];
      }else if(isset(self::$_var[$key][$key1])){
        return self::$_var[$key][$key1];
      }
      return '';
    }

    public function set($key,$value) {
      self::$_var[$key] = $value;
      return true;
    }
  }
  add_action( 'after_setup_theme', array ( 'Alnico', 'init' ) );
}