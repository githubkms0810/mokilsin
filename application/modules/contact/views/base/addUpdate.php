
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="/public/subpage/partnership/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/public/subpage/partnership/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/public/subpage/partnership/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/public/subpage/partnership/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/public/subpage/partnership/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/public/subpage/partnership/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/public/subpage/partnership/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/public/subpage/partnership/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/public/subpage/partnership/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/public/subpage/partnership/css/util.css">
	<link rel="stylesheet" type="text/css" href="/public/subpage/partnership/css/main.css">
<!--===============================================================================================-->

<script>
$(document).ready(function () {
$('html, body').animate({
scrollTop: $('.container-contact100').offset().top
}, 'slow');
});
</script>

	<div class="container-contact100" style="margin-top:1px;">
		<div class="contact100-map" id="google_map" data-map-x="37.616217" data-map-y="126.834748" data-pin="images/icons/map-marker.png" data-scrollwhell="0" data-draggable="1"></div>
		<button class="contact100-btn-show" onclick="changeZIndexBySelector(99999,'.container-contact100');">
			<i class="fa fa-envelope-o" aria-hidden="true"></i>
		</button>

		<div  class="wrap-contact100">
			<button class="contact100-btn-hide" onclick="changeZIndexBySelector(0,'.container-contact100');">
				<i class="fa fa-close" aria-hidden="true"></i>
			</button>

			<form action="/contact/add" method="post" class="contact100-form validate-form">
				<span class="contact100-form-title" style="font-weight:bold;">
					제휴 문의
				</span>

				<div class="wrap-input100 rs1-wrap-input100 validate-input" data-validate="회사명을 입력해주세요.">
					<span class="label-input100">회사</span>
					<input class="input100" type="text" name="company_name" value="<?=DEBUG === true ? "테스트회사명": ""?>">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 rs1-wrap-input100 validate-input" data-validate = "E-mail을 입력해주세요.">
					<span class="label-input100">E-mail</span>
					<input class="input100" type="text" name="email" value="<?=DEBUG === true ? "test@email.com": ""?>">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 rs1-wrap-input100 validate-input" data-validate="담당자를 입력해주세요.">
					<span class="label-input100">담당자</span>
					<input class="input100" type="text" name="manager" value="<?=DEBUG === true ? "테스트 담당자명": ""?>">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 rs1-wrap-input100 validate-input" data-validate="담당자 연락처를 입력해주세요.">
					<span class="label-input100">담당자 연락처</span>
					<input class="input100" type="text" name="manager_phone" value="<?=DEBUG === true ? "테스트 담당자 연락처": ""?>">
					<span class="focus-input100"></span>
				</div>


				<div class="wrap-input100 validate-input" data-validate = "내용을 입력해주세요.">
					<span class="label-input100">내용</span>
					<textarea class="input100" name="desc"><?=DEBUG === true ? "테스트메세지": ""?></textarea>
					<span class="focus-input100"></span>
				</div>

				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn">
						<span>
							문의하기
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>
				</div>
			</form>

			<span class="contact100-more">
				빠른 답변을 원하시면 전화로 문의해주세요! <span class="contact100-more-highlight">02-6738-8220</span>
			</span>
		</div>
	</div>



	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="/public/subpage/partnership/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="/public/subpage/partnership/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="/public/subpage/partnership/vendor/bootstrap/js/popper.js"></script>
	<script src="/public/subpage/partnership/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="/public/subpage/partnership/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="/public/subpage/partnership/vendor/daterangepicker/moment.min.js"></script>
	<script src="/public/subpage/partnership/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="/public/subpage/partnership/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
	<script src="/public/subpage/partnership/js/map-custom.js"></script>
<!--===============================================================================================-->
	<script src="/public/subpage/partnership/js/main.js"></script>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
<script>
$(function() {
  //caches a jQuery object containing the header element
  var header = $(".home-header");
  var logobar = $(".home-header__logo");
  var color = $(".home-nav");
  var list = $(".home-nav__list");
  var colorLogo =$("#jy-color-logo-img");
  var whiteLogo =$("#jy-white-logo-img");
  var colormenu =$("#color-menu-img");
  var whitemenu =$("#white-menu-img");
  $(window).scroll(function() {
      var scroll = $(window).scrollTop();

      if (scroll <=100000000) {
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
</script>
