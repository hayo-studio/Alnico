jQuery(document).ready(function($) {

  var i = 'expanded', o = 'aria-'+i;
  history.replaceState({title: $('title').text(), pos: a.pos, id: id},'');

  $('.lv article>a').click(function(e) {
    //初始化变量
    var s = history.state, i = Number($(this).attr('id').match(/\d+/)), p = $('#p'+i);
    s.top = $(window).scrollTop();
    history.replaceState(s,'');
    //如果未展开，之后要做收起按钮
    if (!p.hasClass(i)) {
      e.preventDefault();

    if( !p.attr('data-pid') ) {
      $.getJSON(a.ajax, {
        action: "load-post",
        p: i,
        js: a.comment
      }, function(r) {
        if(r.ec==1) {
          articleExpand(p.attr('data-pid',r.id).append('<div class="mdl-card__content mdl-card--border">'+r.content+'</div>'),i);
          if(r.comment) {
            a.comment=1;
            p.after(r.comment);
            registerNav()
          }
        }
      } )
    } else {
      //如果已加载
      articleExpand(p,i);
      loadComments(p,i)
    }
    $('#p'+i).delay(500).show(0, function() {
      $('#p'+i).attr(o, 'true').addClass(i);
      $('#primary').removeClass('lv');
    } ).delay(500).show(0, function() {
      $('#t'+i+'>.mdl-button__ripple-container').hide();
      scrollTo()
    } );
    $('article:not(#p'+i+')').addClass('fadeout').delay(500).slideUp(500)
    }
  } );
  
  $('#header-search').keydown( function(e) {
    var s = $('#header-search').val();
    if(e.which==13 && s) {
      window.location.href='?s='+s
    }
  } );
  $('#totop').click(scrollTo);
  $(window).scroll( function() {
    if ($(window).scrollTop() < 99){
      $('#totop').fadeOut()
    } else {
      $('#totop').fadeIn()
    }
  } );
  function registerNav() {
    $('#like').click( function() {
      var t = '#like .mdl-tooltip';
      if ($('#like i').html() == 'favorite') {
        $('#like i').html('favorite_border');
        $(t).html('赞');
        var x = 'cancel'
      } else {
        $('#like i').html('favorite');
        $(t).html('取消赞')
      }
      $(t).css('left', $('#main').width()/2-3+'px').css('marginLeft', $(t).outerWidth()/-2+'px');
      $.post(a.ajax, {
        action: 'like',
        p: history.state.id,
        type: x
      }, function(r) {
        if (r.ec==1) {
          $('#like-num').html(r.num);
          if (r.num) {
            $('#like').removeClass('zero')
          } else {
            $('#like').addClass('zero')
          }
        }
      }, 'json'
      )
    } );
    $('#share').click( function() {
      $('#share .mdl-tooltip').removeClass('is-active')
    } );
    var f = componentHandler.upgradeDom;
    f('MaterialTextfield');
    f('MaterialButton');
    f('MaterialRipple');
    f('MaterialTooltip');
    f('MaterialMenu')
  }
  registerNav();
  function articleExpand(e,i) {
    $('#page-nav').hide();
    var t = e.find('.t').text()+' – '+a.name;
    history.pushState({title: t, id: i, pos: 'post'},'',a.home+'p/'+e.attr('data-pid'));
    $('title').text(t)
  }
  function scrollTo(t) {
    $("html,body").animate({scrollTop: isNaN(t)?0:t},'fast')
  }
  function loadComments(p,i) {
    $.getJSON(a.ajax, {
      action: "load-comment",
      p: i,
      js: a.comment
    }, function(r) {
      a.comment=1;
      p.after(r.comment);
      registerNav()
    } )
  }
  window.addEventListener('popstate', function(e) {
    var s = e.state;
    if (s) {
      $('title').text(s.title);
      if (s.pos == 'list') {
        $('.mdl-button__ripple-container,#page-nav').show();
        $('#comments,#post-nav').slideUp( function() {
          $(this).remove()
        } );
        $('#primary').addClass('lv').delay(500).show( function() {
          scrollTo(s.top)
        });
        $('article').attr(o, 'false').removeClass('fadeout '+i).slideDown(500);
      } else if (s.pos == 'post') {
        loadComments($('#p'+s.id),s.id);
        $('article:not(#p'+s.id+')').addClass('fadeout').delay(500).show(0, function() {
          $('#p'+s.id).attr(o, 'true').addClass(i);
          $('#primary').removeClass('lv');
        } ).slideUp(500, function() {
          $('#t'+s.id+'>.mdl-button__ripple-container,#page-nav').hide(scrollTo);
        } )
      }
    }
  } );
  
  $('#main').ll();
  $('.lazy').ll({effect: "fadeIn"});
  
} )
