  </main>
  <div>
    <button id="totop" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect mdl-color-text--grey-700 mdl-color--grey-400">
      <i class="material-icons">expand_less</i>
    </button>
  </div>
  <footer class="mdl-mini-footer">
    <div class="mdl-mini-footer__left-section">
      <div class="mdl-logo"><span class="site-title"><?php bloginfo('name');?></span> &copy; 2017</div>
      <?php
      if ( has_nav_menu( 'footer' ) )
      wp_nav_menu( array(
          'theme_location' => 'footer',
          'container' => false,
          'menu_class' => 'mdl-mini-footer__link-list',
          'menu_id' => 'footer-links',
          'depth' => 1
        )
      )?>
    </div>
    <div class="mdl-mini-footer__right-section">
      <ul class="mdl-mini-footer__link-list">
        <li>Theme: <a class="mdl-color-text--white" href="https://github.com/hayo-studio/Alnico">Alnico</a> by Snownee</li>
      </ul>
    </div>
  </footer>
</div>
<?php wp_footer();?>
</body>
</html>