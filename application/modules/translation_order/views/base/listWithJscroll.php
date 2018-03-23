<?php foreach ( $portfolioes as $portfolio ): ?>
<span class="jy-portfolio-item-wrapper">
<div class="container-contact100" style="width:100%; display:none; position:fixed !important; position: absolute; left:0px;">
    <div  class="wrap-contact100"  style="width:80%;display:block; max-width:300px;padding:0px;" >
        <button class="contact100-btn-hide" onclick="Portfolio.Close(this);">
            <i class="fa fa-close" aria-hidden="true"></i>
        </button>

        <div class="contact100-form validate-form" style="padding-bottom:0;">
        <!-- Begin Article================================================== -->
        <div class="container">
            <div class="row">
                <!-- Begin Fixed Left Share -->
                <!-- End Fixed Left Share -->
                <!-- Begin Post -->
                <div class="col-md-8 col-md-offset-2 col-xs-12" style="margin:0 auto;">

                    <!-- Begin Featured Image -->
                    <img class="featured-image img-fluid" src="<?=$portfolio->image?>" alt="">
                    <!-- End Featured Image -->

                    <!-- Begin Post Content -->
                    <div class="article-post jy-align-center" >
                        <div class="portfolio_content-sort jy-align-center" >
                            <span class="author-meta jy-align-center">
                            <?php if ( $portfolio->buyer ==="회사" ): ?>
                                <span class="post-name" style="font-size: 14px;">CLIENT</span>
                                <br/>
                                <span class="post-date" style="font-size: 14px;"><?=$portfolio->company?></span>
                            <?php elseif($portfolio->buyer ==="개인"): ?>
                                <span class="post-name" style="font-size: 14px;">CLIENT</span><br/>
                                <span class="post-date" style="font-size: 14px;"><?=$portfolio->personal_name?></span>
                            <?php endif ?>
                            </span>
                        </div>
                        
                        <div class="portfolio_content-sort  jy-align-center">
                            <span class="author-meta  jy-align-center">
                                <span class="post-name" style="font-size: 14px;">TRANSLATION</span>
                                <br/>
                                <span class="post-date" style="font-size: 14px;"><?=$portfolio->translation_before?>/<?=$portfolio->translation_after?></span>
                            </span>
                        </div>

                        <div class="portfolio_content-sort  jy-align-center">
                            <span class="author-meta  jy-align-center">
                                <span class="post-name" style="font-size: 14px;">CONTENTS</span>
                                <br/>
                                <span class="post-date" style="font-size: 14px;"><?=$portfolio->desc?></span>
                            </span>
                        </div>
                    </div>
                    <!-- End Post Content -->
                </div>
                <!-- End Post -->
            </div>
        </div>
        <!-- End Article -->
        </div>
    </div>
</div>


<!-- <li class="home-portfolio__itemlist" style="cursor:pointer;" onclick="location.href='/translation_order/<?=$portfolio->id?>';"> -->
<li class="home-portfolio__itemlist" style="cursor:pointer;" onclick="Portfolio.Open(this); return false;" >
    <img src="<?=$portfolio->image?>">
    <!-- <a href="/translation_order/<?=$portfolio->id?>">열람하기</a> -->
    <a href="#" style="color: #677871;">열람하기</a>
    <?php if ( DEBUG === true ): ?>
        <h1><?=$portfolio->id?></h1>
    <?php endif; ?>
</li>
</span>
<?php endforeach; ?>
<div>
    <a href="/translation_order/listWithJscroll?offset=<?=$offset+$limit?>&limit=<?=$limit?>" class="jscroll-next"></a>
</div>





<script>
    var Portfolio = new Jy.KTC.Portfolio();
</script>