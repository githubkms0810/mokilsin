

<article style="margin-left:15px;">
  <h1><?=$row->title?><span style="font-size:15px;"> -<?=$row->created?></span></h1>
  <div><?=$row->desc?></div>
  
</article>

<br>

<?php if ( count($files) !== 0 ): ?>
<hr/>
업로드파일
<br>
<?php endif; ?> 
<?php foreach ( $files as $file ): ?>
<a href="<?=site_url("/download/{$file->id}")?>"><?=$file->original_name?></a>
    <br>
<?php endforeach; ?>
<br>
<br>

<button class="btn btn-default clickable" data-href="<?=my_site_url("/{$moduleName}/list")?>">목록으로</button>
<span style="margin-left:20px;"></span>
<button  class="btn btn-default clickable" data-href="<?=my_site_url("/{$moduleName}/update/$row->id")?>">수정</button>
<button  type="button" class="btn btn-default clickable" data-href="<?=my_site_url("/{$moduleName}/add")?>">추가</button>
<button class="btn btn-default" <?=$this->ajax_helper->anchor("/{$moduleName}/noDisplay/{$row->id}","정말 삭제하시겠습니까?")?> >삭제</button>



<div>
<?php if ( count($replys) !== 0 ): ?>
    <hr/>
    <h4>댓글목록</h4>
<?php endif; ?> 
<?php foreach ( $replys as $reply ): ?>
<div class="media">
  <div class="media-left">
    <img src="<?=$reply->profile_image?>" class="media-object" style="width:60px">
  </div>
  <div class="media-body">
    <h4 class="media-heading"> <?=$reply->displayName?><small><i> <?=$reply->created?></i></small></h4>
    <p> <?=$reply->desc?></p>
    <a <?=$this->ajax_helper->anchor("/reply/noDisplay/{$reply->id}"," 정말 삭제하시겠습니까?")?>>삭제</a>
  </div>
</div>
<?php endforeach; ?>
  
<hr/>
<form <?=$this->ajax_helper->form("/reply/add?return_url=".urlencode(my_current_url()))?>>
    <div class="form-group">
        <label for="comment">내용:</label>
        <textarea class="form-control" rows="5" name="desc"></textarea>
    </div>

    
    <input type="hidden" name="content_id" value="<?=$row->id?>">
    <input type="hidden" name="parent_id" value="0">

    <?php if ( $this->userstate->isGuest() ): ?>
        <div class="form-group">
        <label for="guest_name">이름</label>
            <input class="form-control"  type="text" name="guest_name">
        </div>
        <div class="form-group">
            <label for="guest_password">비밀번호</label>
        <input class="form-control" type="password" name="guest_password">
        </div>
    <?php endif; ?>
        <button class="btn" type="submit">쓰기</button>
    </form>
</div>
