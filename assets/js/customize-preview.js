(function($, api) {

  api.bind( 'preview-ready', function() {

    api('site_width', function (val) {
      val.bind( function( newval ) {
        $('.mdl-grid').css('maxWidth', newval);
      } );
    } );

    api('favicon', function (val, t) {
      val.bind( function( newval ) {
        if (newval === '') {
          $('#favicon').hide();
        } else {
          $('#favicon').attr('href', newval);
        }
      } );
    } );

    api('logo', function (val, t) {
      val.bind( function( newval ) {
        if (newval === '') {
          $('header .img-logo').hide();
        } else {
          $('header .img-logo').attr('src', newval).show();
        }
      } );
    } );

    api('blogname', function (val) {
      val.bind( function( newval ) {
        $('.site-title').text(newval);
      } );
    } );
    api('blogdescription', function (val) {
      val.bind( function( newval ) {
        $('.site-description').text(newval);
      } );
    } );

    var bg = $.map( ['color', 'image', 'preset', 'position_x', 'position_y', 'size', 'repeat', 'attachment'], function( prop ) {
      return 'background_' + prop;
    } );
    api.when.apply( api, bg ).done( function() {
      $.each( arguments, function() {
        this.unbind( api.settingPreviewHandlers.background );
      } );
    } );
    
    api.settingPreviewHandlers.background = function() {
      var css = '', extra = '', settings = {};
      _.each( ['color', 'image', 'preset', 'position_x', 'position_y', 'size', 'repeat', 'attachment'], function( prop ) {
      	settings[ prop ] = api( 'background_' + prop );
      } );
      /*
       * The body will support custom backgrounds if either the color or image are set.
       *
       * See get_body_class() in /wp-includes/post-template.php
       */
      $( document.body ).toggleClass( 'custom-background', !! ( settings.color() || settings.image() ) );
      if ( settings.color() ) {
      	css += 'background-color: ' + settings.color() + ';';
      }
      if ( settings.image() ) {
      	css += 'background-image: url("' + settings.image() + '");';
      	css += 'background-size: ' + settings.size() + ';';
      	css += 'background-position: ' + settings.position_x() + ' ' + settings.position_y() + ';';
      	css += 'background-repeat: ' + settings.repeat() + ';';
      	css += 'background-attachment: ' + settings.attachment() + ';';
      	if ( api( 'transparent_card' )() ) {
      	  extra = 'body.custom-background .lv .mdl-card { background: rgba( 255, 255, 255, .5); } body.custom-background .lv .mdl-card:hover { background: rgba( 255, 255, 255, .7); }'
      	}
      }
      $( '#custom-background-css' ).text( 'body.custom-background #main { ' + css + ' }' + extra );
    };

    api('transparent_card', function (val) {
      val.bind( api.settingPreviewHandlers.background )
    } );
    api.when.apply( api, bg ).done( function() {
      $.each( arguments, function() {
        console.log(api( 'transparent_card' ));
        console.log(api( 'transparent_card' )());
        this.bind( api.settingPreviewHandlers.background );
      } );
    } );

    api('mdl_custom_css', function (val) {
      val.bind( function( newval ) {
        if (substr (newval, -4) !== '.css') {
          $('#mdl-css').attr('href', newval)
        } else {
          $('#mdl-css').attr('href', a.home+'wp-content/themes/alnico/assets/css/material.min.css')
        }
      } );
    } );
  } );
} )(jQuery, wp.customize);