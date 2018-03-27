<!doctype html>
<html lang="ko">
    <head>
        <title>동요 작가 목일신</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
        <link rel="stylesheet" type="text/css" href="/public/mokilsin/css/jquery.bxslider.css" media="all">
        <link rel="stylesheet" type="text/css" href="/public/mokilsin/css/swiper.min.css" media="all">
        <link rel="stylesheet" type="text/css" href="/public/mokilsin/css/front-base.css" media="all">
        <link rel="stylesheet" type="text/css" href="/public/mokilsin/css/front-style.css" media="all">
        <link rel="stylesheet" type="text/css" href="/public/mokilsin/css/front-media.css" media="all">
        <script src="/public/mokilsin/js/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="/public/mokilsin/js/pace.js" type="text/javascript"></script>
        <script src="/public/mokilsin/js/jquery.bxslider.min.js" type="text/javascript"></script>
        <script src="/public/mokilsin/js/swiper.min.js" type="text/javascript"></script>
        <script src="/public/mokilsin/js/front-ui.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="wrap">
            <!-- header -->
            <header class="header fixed">
                <div>
                    <h1><a href="index.html"><img src="/public/mokilsin/images/logo.png" alt="동요 작가 목일신"></a></h1>
                    <ul class="gnb">
                        <li><a href="birth.php">생애/업적</a></li>
                        <li class="gnb__item">
                            <a href="list.php">작품집</a>
                            <ul>
                                <li>
                                    <a style="font-size:12px; font-weight:400;" href="/freelancer/add">프리랜서 지원</a>
                                    <a style="font-size:12px; font-weight:400;" href="/contact/add">업무 제휴 문의</a>
                                    <a style="font-size:12px; font-weight:400;" href="/small/security">기밀 유지 정책</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="movie.php">동영상</a></li>
                        <li><a href="introduce_music.php">목일신 동요제</a></li>
                        <li><a href="introduce_poem.php">목일신 동시대회</a></li>
                        <li class="m-menu login"><a href="#">등록하기</a></li>
                        <li class="m-menu"><a href="#">마이페이지</a></li>
                        <li class="m-menu"><a href="#">로그아웃</a></li>
                    </ul>
                    <div class="util">
                        <a href="#" class="login">등록하기</a>
                        <a href="#" class="join">마이페이지</a>
                        <a href="#" class="join">로그아웃</a>
                    </div>
                    <a href="javascript:mMenuOn();" class="m-menu-btn">모바일 메뉴 열기</a>
                    <a href="javascript:mMenuOff();" class="m-menu-btn_close">모바일 메뉴 닫기</a>
                    <a href="javascript:mMenuOff();" class="m-menu-btn_close_x">모바일 메뉴 닫기</a>
                </div>
            </header>
            <!-- /header -->
            <?=$this->load->views($content_view)?>
            <!-- footer -->
            <div class="footer">
                <div class="copy">
                    <p>우 59542 전남 고흥군 고흥읍 고흥군청로 1 / 대표전화 061-830-5898 / 팩스 061-830-5577</p>
                    <p>&copy; 2015 Goheung Country. ALL RIGHTS RESERVED.</p>
                </div>
            </div>
            <!-- /footer -->
        </div>
    </body>
</html>