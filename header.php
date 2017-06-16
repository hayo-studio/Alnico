<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
  <meta charset="<?php bloginfo( 'charset' );?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="<?php alnico__t('meta_description', true);?>">
  <meta name="keywords" content="<?php alnico__t('meta_keywords', true);?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
  <?php wp_head();?>
  <link rel="shortcut icon" href="<?php echo esc_url( home_url( '/favicon.png' ) );?>" />
</head>
<body <?php body_class('mdl-color--grey-100 mdl-color-text--grey-700 mdl-base')?>>
<div id="page" class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
  <header id="masthead" class="mdl-layout__header mdl-shadow--3dp">
    <div class="mdl-layout__header-row">
      <a class="mdl-layout-title" href="<?php echo esc_url( home_url( '/' ) );?>">
        <?php
        $logo = alnico__t('logo');
        if( !empty($logo) || is_customize_preview() ) {
          echo '<div class="site-logo">';
          echo '<img src="'.esc_url($logo).'">';
          echo '</div>';
        }
        ?>
        <span class="site-title mdl-color-text--primary-contrast"><?php bloginfo( 'name' );?></span>
        <span class="lg-only site-description mdl-color-text--primary-contrast"><?php bloginfo( 'description' );?></span>
      </a>
      <div class="mdl-layout-spacer"></div>
      <div id="for-search" class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right" role="search">
        <label class="mdl-button mdl-js-button mdl-button--icon" for="header-search" role="button" aria-label="<?php _ex('搜索', 'aria-label', 'alnico');?>">
          <i class="material-icons">search</i>
        </label>
        <div class="mdl-textfield__expandable-holder" role="searchbox">
          <input class="mdl-textfield__input" type="text" id="header-search">
        </div>
      </div>
      <label id="header-nav" class="mdl-button mdl-js-button mdl-button--icon mdl-layout--small-screen-only" role="none">
        <i class="material-icons">more_vert</i>
      </label>
      <?php
      $menu = alnico_nav_menu('header', 'mdl-menu', 'mdl-menu__item', false);
      echo alnico_str_replace('class="mdl-menu"', 'class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="header-nav"', $menu, 1);
      ?>
      <?php alnico_nav_menu('header', 'mdl-navigation mdl-layout--large-screen-only', 'mdl-navigation__link');?>
    </div>
  </header>
  <aside class="mdl-layout__drawer">
    <span class="mdl-layout-title"><?php bloginfo( 'name' );?></span>
    <nav class="mdl-navigation" role="navigation">
      <a class="mdl-navigation__link" href><?php _e('主页', 'alnico')?></a>
      <?php
      $cats = wp_list_categories( array(
        'echo' => 0,
        'separator' => '',
        'style' => '',
        'depth' => 1,
        'hide_empty' => 1,
        'order' => 'DESC',
        'orderby' => 'ID'
        )
      );
      echo str_replace( '<a href="', '<a class="mdl-navigation__link" href="', $cats );
      ?>
    </nav>
  </aside>
  <?php
    $background = set_url_scheme( get_background_image() );
    if ( $background ) {
      $image = esc_url_raw( $background );
      echo "<main id='main' class='mdl-layout-spacer' data-original='$image'>";
    } else {
      echo "<main id='main' class='mdl-layout-spacer'>";
    }
  ?>
