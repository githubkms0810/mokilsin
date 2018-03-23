
<link type="text/css" media="all" href="/public/subpage/css/002_sub/customer/bootstrap.min.css" rel="stylesheet">
<link type="text/css" media="all" href="/public/subpage/css/002_sub/customer/mediumish.css" rel="stylesheet">


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
	<link rel="stylesheet" type="text/css" href="/public/subpage/partnership/css/main2.css">
<!--===============================================================================================-->



<section class="home-hero-portfolio">
    <div class="animated fadeInUp">
    <h2 class="home-hero-title-portfolio">PORTFOLIO</h2>
    <p class="home-hero-des-portfolio">
        코리아 통번역 센터는 다년간의 노하우로<br class="br_portfolio">
        총 <b class="count"><?=$num_translation+34?></b>건의 번역과 <b class="count"><?=$num_interpert+294?></b>건의 통역 프로젝트를<br class="br_portfolio">
        성공적으로 마무리하였습니다.
    </p>
    <a href="/translation_order/selectType" class="home-btn">프로젝트 의뢰하기</a></div>
</section>
<section class="home-section home-section__portfolio">
    <div class="bc-container" >
        <ul class="home-portfolio-list" id="jscroll-wapper">
                <a href="/translation_order/listWithJscroll?offset=0&limit=<?=$this->limit?>" class="jscroll-next"></a>
        </ul>
    </div>
</section>

<!-- 무한스크롤 스크립트 시작 -->
<script type="text/javascript" src="/public/libraries/jquery.jscroll.js"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#jscroll-wapper').jscroll({
				autoTrigger: true,
				padding: 0,
				loadingHtml: '<img src="/public/images/loading.gif" alt="Loading" />',
				nextSelector: 'a.jscroll-next:last',
                autoTriggerUntil : <?=$num_pages?>,
			});
		});
</script>
<!-- 무한스크롤 스크립트 끝 -->




<script>
    $('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 2000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});
</script>




