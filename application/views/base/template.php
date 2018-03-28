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
				<h1><a href="/main/index"><img src="/public/mokilsin/images/logo.png" alt="잡댄스"></a></h1>
				<div class="gnb">
                <ul>
					<li>
                        <a href="#">목일신</a>
                            <ul>
                                <li>
                                    <a style="font-size:12px; font-weight:400;" href="/mokilsin/birth">생애/업적</a>
                                    <a style="font-size:12px; font-weight:400;" href="/mokilsin/list">작품집</a>
                                    <a style="font-size:12px; font-weight:400;" href="/mokilsin/movie">홍보 영상</a>
                                </li>
                            </ul>
                    </li>
					<li>
                        <a href="#">목일신 동요제</a>
                            <ul>
                                <li>
                                    <a style="font-size:12px; font-weight:400;" href="/mokilsin/introduce_music">동요제 소개</a>
                                    <a style="font-size:12px; font-weight:400;" href="/mokilsin/#">참가 신청</a>
                                    <a style="font-size:12px; font-weight:400;" href="/mokilsin/winner_music_eight">역대 수상자</a>
                                </li>
                            </ul>
                    </li>
                    <li>
                        <a href="#">목일신 동시대회</a>
                            <ul>
                                <li>
                                    <a style="font-size:12px; font-weight:400;" href="/mokilsin/introduce_poem">동시대회 소개</a>
                                    <a style="font-size:12px; font-weight:400;" href="/mokilsin/#">참가 신청</a>
                                    <a style="font-size:12px; font-weight:400;" href="/mokilsin/winner_poem_seven">역대 수상자</a>
                                </li>
                            </ul>
                    </li>
                    <li>
                        <a href="#">커뮤니티</a>
                            <ul>
                                <li>
                                    <a style="font-size:12px; font-weight:400;" href="/mokilsin/community_list">공지사항</a>
                                    <a style="font-size:12px; font-weight:400;" href="/mokilsin/community_list">자료실</a>
                                    <a style="font-size:12px; font-weight:400;" href="/mokilsin/#">자유 게시판</a>
                                </li>
                            </ul>
                    </li>
					<li class="m-menu login"><a href="#">등록하기</a></li>
					<li class="m-menu"><a href="#">마이페이지</a></li>
					<li class="m-menu"><a href="#">로그아웃</a></li>
				</ul>
                </div>
				
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