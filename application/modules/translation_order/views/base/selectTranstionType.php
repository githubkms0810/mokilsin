<section class="home-hero-project">
    <div class="animated fadeInUp">
    <h2 class="home-hero-title-project">REQUEST</h2>
    <p class="home-hero-des-project">
        고객님의 의뢰에 최선을 다하는 코리아 통번역 센터입니다!
    </p>
    <a href="/translation_order/list" class="home-btn">포트폴리오 보러가기</a></div>
</section>

<link rel="stylesheet" type="text/css" href="/public/subpage/css/001_jobdance/css/jquery.bxslider.css" media="all">
<link rel="stylesheet" type="text/css" href="/public/subpage/css/001_jobdance/css/swiper.min.css" media="all">
<link rel="stylesheet" type="text/css" href="/public/subpage/css/001_jobdance/css/front-base.css" media="all">
<link rel="stylesheet" type="text/css" href="/public/subpage/css/001_jobdance/css/front-style.css" media="all">
<link rel="stylesheet" type="text/css" href="/public/subpage/css/001_jobdance/css/front-media.css" media="all">
<script src="/public/subpage/css/001_jobdance/js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="/public/subpage/css/001_jobdance/js/jquery.bxslider.min.js" type="text/javascript"></script>
<script src="/public/subpage/css/001_jobdance/js/swiper.min.js" type="text/javascript"></script>
<script src="/public/subpage/css/001_jobdance/js/front-ui.js" type="text/javascript"></script>

<div class="wrap">
    <div class="sub-content">
        <div class="join-navi">
            <div class="navianim">
                <ul>
                    <li class="on">
                        <div class="fix">
                            <div class="bom">1</div>
                            <p>분야 선택</p>
                        </div>
                    </li>
                    <li>
                        <div class="fix">
                            <div class="bom">2</div>
                            <p>정보 작성</p>
                        </div>
                    </li>
                    <li>
                        <div class="fix">
                            <div class="bom">3</div>
                            <p>의뢰 완료</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="join-wrap">
            <div class="join-tit">
                저희는 총 <b class="count"><?=$num_translation+34?></b>건의 번역과 <b class="count"><?=$num_interpert+294?></b>건의 통역을 맡았습니다!<br>
                지금 의뢰하시면 <b class="count"><?=$num_freelancer?></b>명의 통번역사가 함께합니다.
            </div>
            <div class="join-list">
                <ul>
                    <li class="join-listanim">
                        <div>
                            <a href="/translation_order/add?type=통역">
                                <div class="poi">
                                    <div class="img"><span><img src="/public/subpage/css/001_jobdance/images/j-icon01.png" alt=""></span></div>
                                    <div class="name">통역</div>
                                    <div class="txt">
                                        군영과 곧 인생에 끝까지 듣는다.<br class="one">
                                        용감하고 품고 위하여서, 사라지지 것이다.
                                    </div>
                                </div>
                                <div class="btn">의뢰하기</div>
                            </a>
                        </div>
                    </li>
                    <li class="join-listanim">
                        <div>
                            <a href="/translation_order/add?type=번역">
                                <div class="poi">
                                    <div class="img"><span><img src="/public/subpage/css/001_jobdance/images/j-icon02.png" alt=""></span></div>
                                    <div class="name">번역</div>
                                    <div class="txt">
                                        용감하고 품고 위하여서, 사라지지 것이다.<br class="one">
                                        군영과 곧 인생에 끝까지 듣는다.
                                    </div>
                                </div>
                                <div class="btn">의뢰하기</div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>	
    </div>
</div>

<script>
    // Changing the defaults
window.sr = ScrollReveal({ reset: true });

// Customizing a reveal set
sr.reveal('.navianim', { duration: 1500 });
sr.reveal('.join-listanim', { duration: 1500 });
sr.reveal('.join-tit', { duration: 1500 });
</script>
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