// Author: Himanshu Shakhar

jQuery(function($){


//------------------------------------------------------------------------
//						Define vars
//------------------------------------------------------------------------
  var win			= $(window),
      body			= $('body'),
      header		= $('#header'),
      toggler		= $('.navbar-toggle'),
      bgholder		= $('.banner__bg-holder'),
      footer		= $('#footer');


//------------------------------------------------------------------------
//			Determine viewport width matching with media queries
//------------------------------------------------------------------------
  function viewport() {
    var e = window,
        a = 'inner';

        if (!('innerWidth' in window)) {
          a = 'client';
          e = document.documentElement || document.body;
        }
        return {
          width: e[a + 'Width'],
          height: e[a + 'Height']
        };
  }


//------------------------------------------------------------------------
//					Toggle "mobile" class
//------------------------------------------------------------------------
  function mobileClass() {
    var vpWidth = viewport().width; // This should match media queries

    if ((vpWidth <= 768) && (!$('body').hasClass('mobile'))) {
      $('body').addClass('mobile');
    } else if ((vpWidth > 768) && ($('body').hasClass('mobile'))) {
      $('body').removeClass('mobile');
    }
  }

  mobileClass();
  win.resize(mobileClass);


//------------------------------------------------------------------------
//						sticky header
//------------------------------------------------------------------------
  $.fn.stickyHeader = function() {
    $(this).each(function() {
      var sh 					= $(this),
          shHeight				= sh.outerHeight(true),
          shOffsetTop 			= sh.offset().top,
          headershrinkHeight	= shOffsetTop + shHeight;

      sh.wrap( "<div class='sticky-header-height'></div>" );

      if (sh.css('position') != 'absolute') {
        $(".sticky-header-height").css('min-height', shHeight);

        $(window).bind('scroll resize load', function() {
          shHeight = sh.outerHeight(true);
          $(".sticky-header-height").css('min-height', shHeight);
        });
      }

      $(window).scroll(function() {
        if ($(window).scrollTop() > shOffsetTop) {
          sh.addClass('sticky-header');
        } else {
          sh.removeClass('sticky-header');
        }

        if ($(window).scrollTop() > headershrinkHeight) {
          sh.addClass('shrink');
        } else {
          sh.removeClass('shrink');
        }
      });
    });
  };

  header.stickyHeader();


//---------------------------------------------------------------------------
// Toggle classes in body for syncing sliding animation with other elements 
//---------------------------------------------------------------------------
  toggler.click(function (e) {
	e.preventDefault();
	body.toggleClass('menu-active');
    $(this).toggleClass('active');
    $('.navbar-collapse').toggleClass('menu-open');
  });


//------------------------------------------------------------------------
//		Append <img> with .bg-holder as CSS backgrounds
//------------------------------------------------------------------------
  bgholder.each(function() {
    var imgSrc = $(this).children('img').attr('src');
    var bColor = $(this).css('background-color');
    var bAttachment = $(this).css('background-attachment');
    if(imgSrc){$(this).css('background-image', 'url("' + imgSrc + '")');}
    $(this).css('background-position', '50% 50%');
    if(bColor){$(this).css('background-color', bColor);}
    if(bAttachment){$(this).css('background-attachment', bAttachment);}
    $(this).children('img').hide();
  });


//------------------------------------------------------------------------
//		stick footer always bottom
//------------------------------------------------------------------------
  $(window).bind('load resize', function() {
	var vpWidth = viewport().width;
	if (vpWidth > 767) {
	  footer.addClass('footer-fixed-bottom');
	  body.css('padding-bottom', footer.outerHeight(true));
	}
	else {
	  footer.removeClass('footer-fixed-bottom');
	  body.css('padding-bottom', 0);
	}
  });


}); // end function
