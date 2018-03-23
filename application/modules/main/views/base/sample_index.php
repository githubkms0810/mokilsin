
<!-- 로그인폼 -->
<?php if ( $this->userstate->isLogin() ===false ): ?>
<form  <?=$this->ajax_helper->form("/user/login")?>>
    <input type="text" name="userName">
    <input type="password" name="password">
    <input type="submit" name="로그인">
</form>
<?php else: ?>
    <?="{$this->user->name}({$this->user->userName})"?>님 환영합니다.
<?php endif;?>
<!-- 로그인폼 -->

<!-- 메뉴바 -->
<?php if ( $this->userstate->isLogin() ===false ): ?>
    <a href="<?=site_url("user/login?".QSreturnURL())?>">로그인</a>
    <a href="<?=site_url("user/add")?>">회원가입</a>
<?php else: ?>
<?php if ( $this->userstate->isAdmin()===true ): ?>
<a href="<?=site_url("admin/main/index?mainMenu=메인")?>">관리자 페이지</a>
<?php endif; ?>
<a <?=$this->ajax_helper->anchor("/user/logout")?> >로그아웃</a>
<a href="<?=site_url("user/update")?>" >내정보수정</a>
<?php endif;?>
메뉴바


<!-- 상품리스트 -->
<ul>
<?php foreach ( $products as $product ): ?>
    <li><a href="<?=site_url("product/get/{$product->id}")?>"><?=$product->name?></a></li>
<?php endforeach; ?>
</ul>
<!-- 상품리스트 -->
<?=$this->ajax_helper->createScript()?>