
<link type="text/css" media="all" href="/public/subpage/css/002_sub/customer/bootstrap.min.css" rel="stylesheet">
<link type="text/css" media="all" href="/public/subpage/css/002_sub/customer/mediumish.css" rel="stylesheet">



<section class="home-hero-cs">
	<div class="animated fadeInUp">
    <h2 class="home-hero-title-cs" style="font-weight:bold;">SERVICE CENTER</h2>
    <p class="home-hero-des-cs">
        편한 시간에 편한 방법으로 문의주세요. <br class="br_portfolio">
        모든 상담은 열려있습니다.
    </p>
    <a href="#" class="home-btn">카카오톡 KTC8220</a></div>
</section>

<!-- Begin Site Title
================================================== -->
<div class="container">
	<!-- Begin Featured
	================================================== -->
	<section class="featured-posts" style="margin:100px 0 150px 0;">
	<div class="section-title">
		<h2><span><a href="/content/list?board_key=notice" style="color: #292b2c; font-weight: 400; font-size: 22px;">공지사항</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/content/list?board_key=faq" style="color: #292b2c; font-weight: 400; font-size: 22px;">FAQ</a></span></h2>
		
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

</div>
<!-- /.container -->

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/public/subpage/js/002_sub/customer/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="/public/subpage/js/002_sub/customer/bootstrap.min.js"></script>
<script src="/public/subpage/js/002_sub/customer/ie10-viewport-bug-workaround.js"></script>

