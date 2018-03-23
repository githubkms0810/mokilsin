<!DOCTYPE html>
<html lang="ko">
<head>
<!-- 구글 애널리틱스 시작 -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-60119583-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-60119583-4');
</script>

<!-- 구글 애널리틱스 끝 -->

<!-- 페이스북 픽셀 추적 시작 -->
<!-- 페이스북 픽셀 추적 끝 -->

<!-- 구글 url등록하기 -->
<!-- 구글 웹마스터 등록 -->
<!-- 네이버 웹마스터 등록 -->
<!-- 다음 웹마스터 있나? -->

<meta http-equiv="Content-Type" content="text/html ; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index">
    
    <title><?=$global_info->title?></title>
    <meta name="description" content="<?=$global_info->desc?>">
    <meta name="keywords" content="<?=$global_info->keywords?>">

    <meta propert="og:type" content="<?=$global_info->og_type?>">
    <meta propert="og:site_name" content="<?=$global_info->og_site_name?>">
    <meta property="og:title" content="<?=$global_info->og_title?>">
    <meta property="og:url" content="<?=$global_info->og_url?>">
    <meta property="og:description" content="<?=$global_info->og_desc?>">
    <meta property="og:image" content="<?=$global_info->og_image?>">
  <!-- // -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="/public/css/common.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/public/libraries/animate.css">
  <link rel="stylesheet" href="/public/libraries/summernote/summernote.css">
  
  <!-- <link href="//code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" type="text/css" rel="stylesheet" media="all"> -->

  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <style>
    /* custom on below */
    .nav.navbar-nav.navbar-right li > form
    {
      padding-top : 10px;
      padding-bottom : 10px;
      height:30px;
    }
    .nav.navbar-nav.navbar-right li > button
    {
      margin-top:10px;
    }
    a:hover{
      text-decoration: none;
    }
    /* pgi active */
    .pagination > li.active > a
    {
      background-color : #444;
      color: white;
      border: 1px solid #444;
    }
    .pagination > li > a
    {
      /* font-size : 20px; */
      /* background-color : white; */
      color: black;
    }
    /* nav active */
    .nav.nav-pills.nav-stacked > li.active > a
    {
      background-color : #444;
      color: white;
    }
    .nav.nav-pills.nav-stacked > li > a
    {
      font-size : 20px;
      /* background-color : white; */
      color: black;
    }
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 1000px;}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
      /*custom code on below*/
      /* width:100%; */
      /* position:fixed; */
      /* bottom:0px; */
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>
  
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="<?=base_url()?>"><?=$global_info->title?></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <!-- 메인메뉴 -->
      <ul class="nav navbar-nav">
        <?php if ( $this->userstate->isAdmin()===true ): ?>
          <li><a href="<?=site_url("admin/main/index?mainMenu=메인")?>">관리자 페이지</a></li>
        <?php endif; ?>
        
        <?php foreach ( $mainMenus as $mainMenu ): ?>
          <li class="<?=set_active("mainMenu",$mainMenu->id,"active")?>"><a href="<?=$mainMenu->url?>" target="<?=$mainMenu->target?>"><?=$mainMenu->name?> </a></li>
        <?php endforeach; ?>

        <?php if ( $this->userstate->isDeveloper() === true  ): ?>
          <li><a href="<?=site_url("/phpmyadmin/db_structure.php?server=1&db=program")?>" target="_blank">phpMyAdmin </a></li>  
          <li><a href="<?=site_url("/init")?>"  target="_blank">Init </a></li>  
        <?php endif; ?>
      </ul>
      <!-- 메인메뉴 -->

      <!-- 메인 오른쪽메뉴 -->
      <ul class="nav navbar-nav navbar-right">
      <!-- <li><form ><input type="text" maxlength="40"><button type="submit" class="btn"><i class="icon-search" title="Search"></i></button></form>&nbsp;&nbsp;</li> -->
      <?php if ( $this->userstate->isLogin() ===false ): ?>
      
        <li> 
          <form style="display:inline-block" name="login_form" <?=$this->ajax_helper->form("/user/login")?>>
            <input type="text" name="userName_orEmail_orPhone" placeholder="아이디">
            <input type="password" name="password" placeholder="비밀번호">
            <button style="color:white"class="linkButton" type="submit"><span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;로그인</button>
            <label style="line-height:22px; color:white" class="checkbox-inline"><input type="checkbox" name="login_maintain" value="true">로그인유지</label>
          </form>
        </li>
        <li><button style="line-height:23px;color:white"class="linkButton clickable"data-href="<?=site_url("user/add")?>">
        <!-- <i class="fa fa-check-square"></i> -->
        <i class="glyphicon glyphicon-user"></i>
        회원가입</button></li>
        <li><a style="line-height:10px;color:white" href="/user/login"><i class="fa fa-plus-square"></i>더보기</a></li>
     
      <?php else: ?>     
      <li><img class="img-circle" style="width:50px;" src="<?=$this->user->profile_image?>" alt=""></li>
        <li><a href="/user/get"> <?=$this->user->displayName?>님 환영합니다.</a></li>
        <!-- <li><a href="<?=site_url("user/update")?>" >내정보수정</a></li> -->
        <li><a <?=$this->ajax_helper->anchor("/user/logout")?> >로그아웃</a></li>
      <?php endif;?>   
     
      </ul>
        <!-- 메인 오른쪽메뉴 -->
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">

      <!-- 사이드바 -->
      <ul class="nav nav-pills nav-stacked">
        <?php foreach ( $subMenus as $subMenu ): ?>
          <li class="<?=set_active("subMenu",$subMenu->id,"active")?>"><a href="<?=$subMenu->url?>" target="<?=$subMenu->target?>"><?=$subMenu->name?></a></li>
        <?php endforeach; ?> 
      </ul>
      <!-- 사이드바 -->

    </div>
    <article class="col-sm-9 text-left"> 

        <!-- 메인 -->
        <div style="margin-top:50px;"></div>
        <?=$this->load->views($content_view)?>
        
        <!-- 메인 -->

    </article>
    <div class="col-sm-1 sidenav">

      <!-- 오른쪽 사이드바 -->
      <!-- <div class="well">
        <p>ADS</p>
      </div>
      <div class="well">
        <p>ADS</p>
      </div> -->
      <!-- 오른쪽 사이드바 -->

    </div>
  </div>
</div>

<!-- 푸터 -->
<footer class="container-fluid text-center">
<p><?=$global_info->copyright?></p>
</footer>
<!-- 푸터 -->


  <!-- script load start-->
  



<script src="/public/libraries/summernote/summernote.js"></script><!-- 서머노트 위지위그 에디터 -->
<script src="/public/libraries/bootstrapNotify/bootstrap-notify.js" type="text/javascript"></script>
<?= !AJAX_DEBUG ? $this->ajax_helper->createScript() : ""; ?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/public/js/common.js" type="text/javascript"></script>
<!-- script load end-->

<!-- custom script start-->
<script>

if (typeof window.FileReader === 'undefined') {
      console.log("FileReader undefinded");
  } else {
    // console.log("FileReader success");
  }

</script>
<!-- custom script end-->
</body>
</html>


