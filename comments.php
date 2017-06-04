<?php if ( post_password_required() )
  return;
?>

<?php if ( comments_open() || have_comments() ) : ?>
<div id="comments" class="mdl-card card-mid mdl-shadow--2dp">

  <?php if ( comments_open() ) :
  $commenter = wp_get_current_commenter();
  $req = get_option( 'require_name_email' );
  $aria_req = ( $req ? " aria-required='true'" : '' );

  $args = array(
    'title_reply_before' => '<h2 class="mdl-card__title">',
    'title_reply_after' => '</h2>',
    'fields' => array(
      'author' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' /><label class="mdl-textfield__label" for="author">'.__( '姓名', 'alnico' ).( $req ? ' <span class="required">*</span>' : '' ).'</label></div>',
      'email' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" name="email" id="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '"' . $aria_req . ' /><label class="mdl-textfield__label" for="email">'.__( '邮箱', 'alnico' ).( $req ? ' <span class="required">*</span>' : '' ).'</label></div>',
      'url' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="text" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" /><label class="mdl-textfield__label" for="author">'.__( '网站', 'alnico' ).'</label></div>'
    ),
    'comment_field' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><textarea class="mdl-textfield__input" id="comment" name="comment" type="text" rows="3"></textarea><label class="mdl-textfield__label" for="comment">'. __( '写下你的评论', 'alnico' ) .'</label></div>',
    'class_form' => 'mdl-card__content',
    'class_submit' => '',
    'submit_field' => '<span class="hide">%2$s</span>',
    'cancel_reply_before'  => '<span>',
    'cancel_reply_after'   => '</span>',
    'format' => 'html5'
  );
  comment_form($args);
  ?>
  <?php endif; ?>

  <?php if ( have_comments() ) : ?>

    <h2 class="mdl-card__title">
      <?php
      $num_comments = get_comments_number();
      echo _n( '评论', '评论', $num_comments, 'alnico');
      echo '<span class="count mdl-color-text--grey-600 mdl-color--grey-300">'.$num_comments.'</span>';
      ?>
    </h2>

    <ul class="mdl-list">
      <?php
      wp_list_comments( array(
        'callback' => 'alnico_list_comments',
      ) );
      ?>
    </ul>
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :?>
      <nav id="comment-nav">
        <div class="prev">
          <?php previous_comments_link( '<button class="mdl-button mdl-js-button mdl-js-ripple-effect"><i class="material-icons">arrow_back</i> '.__('之前的评论', 'alnico').'</button>'); ?>
        </div>
        <div class="mdl-layout-spacer"></div>
        <div class="next">
            <?php next_comments_link( '<button class="mdl-button mdl-js-button mdl-js-ripple-effect">'. __('之后的评论', 'alnico').' <i class="material-icons">arrow_forward</i></button>' );?>
        </div>
      </nav>
      <?php endif; ?>
    
  <?php endif; ?>

</div>
<?php endif; ?>
