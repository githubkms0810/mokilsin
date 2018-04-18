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
            <a href="/content/list?board_key=free" style="color: #292b2c; font-weight: 400; font-size: 22px;">동요제 지정곡</a></span></h2>
		
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
        
        <?php if ( $board_key === "free" ): ?>
        
        <div id="content">
    <script type="text/javascript">
        $(document).ready(function() {});

        function search() {
            location.href = "/board?board_id=182&menu_id=961&site_id=41&" + $("#frm").serialize();
        }

    </script>
    <dl class="totalNum">
        <dt>전체 :</dt>
        <dd><strong>5</strong>건</dd>
        <dt>현재 :</dt>
        <dd><strong>1</strong>/1페이지</dd>
    </dl>
    <table summary="문화예술인_자료실 게시판으로 해당 글제목과 작성자, 작성일 등을 제공하고 있습니다." class="boardList">
        <caption>문화예술인_자료실 목록</caption>
        <colgroup>
            <col width="50" />
            <col />
            <col width="150" />
            <col width="80" />
            <col width="60" />
        </colgroup>
        <thead>
            <tr>
                <th scope="col" abbr="번호">번호</th>
                <th scope="col" abbr="제목">제목</th>
                <th scope="col" abbr="작성자">작성자</th>
                <th scope="col" abbr="작성일">작성일</th>
                <th scope="col" abbr="조회" class="bgNone">조회</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    5
                </td>
                <td class="txt_left">
                    <a href="/boardview?board_no=21584&site_id=41&board_id=182&menu_id=961">제1회「고흥군 송수권 시문학상」시낭송대회 참가신청서                  </a>
                    </a>
                </td>
                <td>고흥문화예술팀</td>
                <td>2015-07-28</td>
                <td>278</td>
            </tr>
        </tbody>
    </table>
    <div class="pagingType">
        <div class="floatR">

        </div>
        <div class="paging">
            <div class="paging"><strong>1</strong>
            </div>
        </div>
    </div>

</div>
<?php endif; ?>
        
	
		
	</div>
	</section>
	<!-- End Featured
	================================================== -->
	<div style="margin-bottom:150px;">
	    <a class="btn btn-default" href="/content/add?board_key=<?=$board->key?>" style="color:#000;">글쓰기</a>
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

