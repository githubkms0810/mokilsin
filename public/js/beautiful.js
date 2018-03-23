// author: BEAUTIFUL CSS

$(document).ready(function(){
  
  $(".home-nav").on("mouseenter", function() {
    $(".home-header__logo").addClass("home-header__logo_remove");
  });
  
  $(".home-nav").on("mouseleave", function() {
    $(".home-header__logo").removeClass("home-header__logo_remove");
  });
  
  $('.home-nav--btn').on('click',function(){
    $('.home-nav').toggle();
  });


  // 로고 슬라이더 시간 단위는 밀리세컨드 입니다. 1000ms = 1초
  var duration = 17500;

  var home_logo = $('.home-logo--list');

  function logo_slide() {
    home_logo.animate({
      left: '-='+1225
    }, duration, 'linear', function(){
      home_logo.find('div').eq(0).clone().appendTo(home_logo);
      home_logo.find('div').eq(0).remove();
      home_logo.css({
        left: 0
      })
    });
  }

  setInterval(function(){
    logo_slide()
  }, 300);
  
});

$(function() {
  //caches a jQuery object containing the header element
  var header = $(".home-header");
  var color = $(".home-nav");
  var list = $(".home-nav__list");
  var colorLogo =$("#jy-color-logo-img");
  var whiteLogo =$("#jy-white-logo-img");
  var colormenu =$("#color-menu-img");
  var whitemenu =$("#white-menu-img");
  $(window).scroll(function() {
      var scroll = $(window).scrollTop();

      if (scroll >= 0.1) {
        header.removeClass('unchange-header').addClass("change-header");
        color.removeClass('unchange-home-nav').addClass("change-home-nav");
        list.removeClass('unchange-home-nav__list').addClass("change-home-nav__list");
        whiteLogo.css("display","none");
        colorLogo.css("display","inline-block");
        whitemenu.css("display","none");
        colormenu.css("display","inline-block");
      } else {
        header.removeClass("change-header").addClass('unchange-header');
        color.removeClass("change-home-nav").addClass('unchange-home-nav');
        list.removeClass("change-home-nav__list").addClass('unchange-home-nav__list');
        whiteLogo.css("display","inline-block");
        colorLogo.css("display","none");
        whitemenu.css("display","inline-block");
        colormenu.css("display","none");
      }
  });
});

