
   
<form <?=$this->ajax_helper->form("/user/$mode")?>>

    <input type="file" name="profile_image_file"  accept="image/*">
    <input type="hidden" name="profile_image" value="<?=my_set_value($user,"profile_image")?>">
    <img class="img-circle" style="width:80px;"name="profile_image"  alt="profile_image" src="<?=my_set_value($user,"profile_image")?>">
    <?php if ( $mode === "add" ): ?>
        <?php if ( $this->setting->is_userName_in_add_user === "1"  ): ?>
        <div class="form-group">
        <label for="userName">아이디</label>
        <input class="form-control"  type="text" name="userName">
        </div>
        <?php endif; ?>

  
    <?php endif; ?>
    <?php if ( $mode === "add" ): ?>
        <?php if ( $this->userstate->is_flashdataOauth() === false  && $this->setting->is_email_authentication_in_add_user === "1" ): ?>
        <div class="form-group">
            <label for="email">이메일</label>
            <input  class="form-control" type="text" name="email" value="<?=my_set_value($user,"email")?>">
            <button style="margin-top:10px;" class="btn btn-default" onclick ="auth_popup('<?=site_url("user/email_auth")?>','email'); return false;">이메일 인증</button>
        </div>
        <?php endif; ?>
        <?php if ( $this->setting->is_phone_authentication_in_add_user === "1" ): ?>
        <div class="form-group">
            <label for="phone">휴대폰</label>
            <input  class="form-control" type="text" name="phone" value="<?=my_set_value($user,"phone")?>">
            <button style="margin-top:10px;" class="btn btn-default" onclick ="auth_popup('<?=site_url("user/phone_auth")?>','phone'); return false;">휴대폰 인증</button>
        </div>
        <?php endif; ?>  
    <?php endif; ?>
    
    <div class="form-group">
    <label for="password">비밀번호</label>
    <input class="form-control" type="password" name="password">
    </div>
    <div class="form-group">
    <label for="re_password">비밀번호확인</label>
    <input class="form-control" type="password" name="re_password">
    </div>
   
        
  
    <?php if ( $mode === "add" ): ?>
    <div class="form-group">
    <label for="displayName">별명</label>
    <input  class="form-control" type="text" name="displayName" value="<?=my_set_value($user,"displayName")?>">
    </div>
    <?php endif; ?>
    <div class="form-group">
    <label for="name">이름</label>
    <input  class="form-control" type="text" name="name" value="<?=my_set_value($user,"name")?>">
    </div>

    <?php if ( strpos($mode,"update") >-1 ): ?>
    <button type="button" onclick="open_popup('/oauth/facebook/request_auth','facebook','800','880');" class="btn btn-default" >페이스북계정 연결</button>
    <?php endif; ?>


    <button type="submit" class="btn btn-default "><?=$mode === "add" ? "회원가입" : "정보수정"?></button>
<!--  
    <div class="checkbox">
        <label><input type="checkbox"> Remember me</label>
    </div> -->

</form>

<?php if ( $this->userstate->is_flashdataOauth() === true): ?>
<br>
<br>
<form <?=$this->ajax_helper->form("/user/linkUser")?>>
<input type="text" name="userName_orEmail_orPhone" placeholder="가입한 아이디 또는 이메일이나 휴대폰 번호를 적어주세요">
<input type="password" name="password" placeholder="비밀번호">
<button class="btn btn-default">기존계정에 연결</button>
</form>
<?php endif; ?>

<script>
$("input[type=file][name=profile_image_file]").change(function(){
    let files=this.files;
    let url = "/uploadImage";

    formData = new FormData();
    for (let i = 0; i < files.length; i++) {
        formData.append("files[]", files[i]);
    }
    $.ajax({
        // ajax를 통해 파일 업로드 처리
        data: formData,
        type: "POST",
        url: url,
        cache: false,
        contentType: false,
        processData: false,

        success: function (data) {
            
            let files = data.files;
            let result = files[0].result;
            if (result === "success") {
                $("img[name=profile_image]").attr("src",files[0].uri);
                $("input[type=hidden][name=profile_image]").val(files[0].uri);
            }
            else if (result === "fail")
            {
            }
            
        },
        error: function(xhr, textStatus, errorThrown){
            alert('에러... or 데이터 용량이 너무많습니다.');
            $('.loading').fadeOut(500);
            console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
            console.log(errorThrown);
        }

    });
            
});

        
</script>
