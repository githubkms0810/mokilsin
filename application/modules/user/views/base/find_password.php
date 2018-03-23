<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<div style="margin-top:180px;"></div>
<div class="container" style="margin-bottom: 150px;">
    <div class="row">
        <div class="col-md-4 col-md-offset-4" style="margin: 0 auto;">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                        <h2 class="text-center">비밀번호 재설정</h2>
                        <p>
                        <?php if($mode === "userName"){?>
                            가입 시 작성한 아이디를 작성해주세요!
                        <?php }else if($mode === "auth_code"){?>
                            인증코드를 입력해주세요.
                        <?php }?>
                        </p>
                        <div class="panel-body">

                            <form action="<?=site_url("/user/find_password")?>" id="register-form" role="form" autocomplete="off" class="form" method="post">

                                <div class="form-group">
                                    <div class="input-group">
                                    <?php if($mode === "userName"){?>
                                        <input id="email" name="userName" placeholder="아이디를 입력해주세요." class="form-control" type="TEL">
                                    <?php }else if($mode === "auth_code"){?>
                                        <input id="email" name="auth_code" placeholder="인증코드를 입력해주세요." class="form-control" type="TEL">
                                        <?=$email?>
                                       
                                    <?php }else if($mode ==="password"){?>
                                        <input id="email"type="password"  name="password" placeholder="패스워드를 입력해주세요" class="form-control" type="TEL">
                                        <?php }?>
                                    </div>
                                </div>
                                <?php if($mode ==="password"){?>
                                <div class="form-group">
                                    <div class="input-group">
                                    <input id="email" type="password" name="re_password" placeholder="패스워드를 재입력해주세요" class="form-control" type="TEL">
                                    </div>
                                </div>
                                <?php }?>
                                <div class="form-group">
                                    <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="확인" type="submit" style="background-color: #79b754; border: 0px;">
                                </div>

                                <input type="hidden" class="hide" name="token" id="token" value="">
                            </form>
                            <?php if ( $mode ==="auth_code"): ?>
                                <form action="<?=site_url("/user/find_password")?>" id="register-form" role="form" autocomplete="off" class="form" method="post">
                                    <input type="hidden" name="userName" value="<?=$userName?>">
                                    <input type="hidden" name="resend_auth_code" value="1">
                                    <button>인증코드 재발송</button>
                                </form>
                            <?php endif; ?>
                                     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>