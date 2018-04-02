<link type="text/css" media="all" href="/public/mokilsin/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" media="all" href="/public/mokilsin/css/mediumish.css" rel="stylesheet">
<link rel="stylesheet" href="/public/mokilsin/css/beautiful.css">

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

		

<section class="home-hero-cs">
	<div class="animated fadeInUp">
    <h2 class="home-hero-title-cs" style="font-weight:bold;">커뮤니티</h2>
</section>

<!-- Begin Site Title
================================================== -->
<div class="container">
	<!-- Begin Featured
	================================================== -->
	<section class="featured-posts" style="margin:100px 0 150px 0;">
	<div class="section-title">
		<h2><span><a href="/content/list?board_key=notice" style="color: #292b2c; font-weight: 400; font-size: 22px;">공지사항</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/content/list?board_key=data" style="color: #292b2c; font-weight: 400; font-size: 22px;">자료실</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/content/list?board_key=free" style="color: #292b2c; font-weight: 400; font-size: 22px;">자유 게시판</a></span></h2>
		
	</div>
	<div class="card-columns listfeaturedtag">
		<?php foreach ( $rows as $row ): ?>
		<!-- begin post -->
		<div class="card">
			<div class="row">
				<div class="col-md-5 wrapthumbnail">
					<a href="/content/<?=$row->id?>?board_key=<?=$board->key?>">
						<div class="thumbnail" style="background-image:url(<?=$row->image?>);">
						</div>
					</a>
				</div>
				<div class="col-md-7" style="cursor:pointer;" onclick="location.href='/content/<?=$row->id?>?board_key=<?=$board->key?>';">
					<div class="card-block">
						<h2 class="card-title"><?=$row->title?></h2>
						<h4 class="card-text">
							<?=renderDescriptionToPreview($row->desc,90)?>
						</h4>
						<div class="metafooter">
							<div class="wrapfooter">
								<span class="meta-footer-thumb">
								<img class="author-thumb" src="<?=$row->profile_image?>" alt="Sal">
								</span>
								<span class="author-meta">
								<span class="post-name"><?=$row->displayName?></span><br/>
								<span class="post-date"><?=$row->created?></span><span class="dot"></span><span class="post-read"><?=$row->hits?></span>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end post -->
		
		<?php endforeach; ?>
	
		
	</div>
	</section>
	<!-- End Featured
	================================================== -->
	<div style="margin-bottom:150px;">
	    <a class="btn btn-default" href="/content/add?board_key=<?=$board->key?>">글쓰기</a>
	</div>
	<div style=" width: 100px;margin:0 auto"> <?=$this->pagination->create_links();?></div>
</div>
<!-- /.container -->

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/public/subpage/js/002_sub/customer/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="/public/subpage/js/002_sub/customer/bootstrap.min.js"></script>
<script src="/public/subpage/js/002_sub/customer/ie10-viewport-bug-workaround.js"></script>

