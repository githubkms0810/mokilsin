//페이지 로드 중 대기화면
$(window).load(function(){
	$(".top-bar").addClass("on");
});

//메인 비쥬얼
$(function(){
	$('.v-slide').bxSlider({
		useCSS: false,
		caption: true,
		auto: true,
		pause: 4000
	});
});

//모바일 메뉴 열기
function mMenuOn(){
	$(".gnb").slideDown();
	$(".m-menu-btn_close").fadeIn();
	$(".m-menu-btn_close_x").fadeIn();
}

function mMenuOff(){
	$(".gnb").slideUp();
	$(".m-menu-btn_close").fadeOut();
	$(".m-menu-btn_close_x").fadeOut();
}

$(window).resize(function(){
	if ( $(window).width() > 1240 ){
		$(".gnb").show();
		$(".m-menu-btn_close").hide();
		$(".m-menu-btn_close_x").hide();
	}
	
	if ( $(window).width() < 1240 ){
		$("gnb").hide();
		$(".m-menu-btn_close").hide();
		$(".m-menu-btn_close_x").hide();
		if ( $(".gnb").css("display") == "block"){
			$(".gnb").hide();
			$(".m-menu-btn_close").show();
			$(".m-menu-btn_close_x").show();
		}
	}
});

//회원가입
$(function(){
	$(".join-list li").mouseover(function(){
		$(this).addClass("on");
	});
	$(".join-list li").mouseleave(function(){
		$(this).removeClass("on");
	});
});


//검색
$(function(){
	var swiper = new Swiper('.swiper-container', {
	  // Default parameters
	  slidesPerView: 4,
	  spaceBetween: 40,
	  // Responsive breakpoints
	  breakpoints: {
		   400: {
		  pagination: '.swiper-pagination',
			slidesPerView: 2,
			paginationClickable: true,
			spaceBetween: 5
		   },
		  560: {
		  pagination: '.swiper-pagination',
			slidesPerView: 3,
			paginationClickable: true,
			spaceBetween: 5
		},
		 // when window width is <= 550px
		620: {
			  pagination: '.swiper-pagination',
			slidesPerView: 4,
			paginationClickable: true,
			spaceBetween: 30
		},
		// when window width is <= 750px
		750: {
			  pagination: '.swiper-pagination',
			slidesPerView: 4,
			paginationClickable: true,
			spaceBetween: 30
		},
		// when window width is <= 1080px
		1080: {
			 pagination: '.swiper-pagination',
			slidesPerView: 5,
			paginationClickable: true,
			spaceBetween: 30
		},
		// when window width is <= 1080px
		2580: {
			 pagination: '.swiper-pagination',
			slidesPerView: 8,
			paginationClickable: true,
			spaceBetween: 30
		}
	  }
	})
});

//검색 카테고리
$(function(){
    $(".swiper-slide a").click(function(){
		$(".search-option .search-option-viewr").show();
		$(".search-option .search-option-viewr > div ul").hide();
		
		var href = $(this).attr("href");
		$(href).show();
		
		$(".search-option .mac").css("z-index","50");
		
		$(".search-option .mac").mouseover(function(){
			$(this).css("z-index","0");
			$(".search-option .search-option-viewr").hide();
		});
			
		return false;
	});
	
	
});


//검색 결과 on off
$(function(){
   $(".search-result ul").on({
      mouseenter: function () {
         $(this).addClass("on");
      },
      mouseleave: function () {
        $(this).removeClass("on");
      }
   },'li');
});

//회원가입
var joinCount = 0;

function joinOpen(){
	$(".join-pop").fadeIn();
	$(".layer-bg").fadeIn();
	$(".join-btn").fadeOut();
}

function joinClose(){
	$(".join-pop").fadeOut();
	$(".layer-bg").fadeOut();
	$(".join-btn").fadeIn();
}

$(function(){
	 $('#checkAll').click( function(){
	  $( '.checkK' ).prop( 'checked', this.checked );
	});
});

/* 170125 */
$(function(){
	$(".idpw p.bb input").focusin(function(){
		$(this).parent("p").prev("p").children("input").css("border-bottom","1px solid #3891ac");
	});
	
	$(".idpw p.bb input").focusout(function(){
		$(this).parent("p").prev("p").children("input").css("border-bottom","1px solid #c5c6c9");
	});
	
	$(".idpw p input").focusin(function(){
		$(this).parent().children("span").show();
	});
	
	$(".idpw p input").focusout(function(){
		$(this).parent().children("span").hide();
	});
});