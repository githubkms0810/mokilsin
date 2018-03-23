<form <?=$this->ajax_helper->form("/user/login?return_url=".urlencode($this->input->get("return_url")),null,false)?>>

<div class="form-group">
  <label for="usr">아이디</label>
  <input class="form-control" type="text" name="userName_orEmail_orPhone">
</div>
<div class="form-group">
  <label for="password">비밀번호</label>
  <input class="form-control" type="password" name="password">
</div>
    
<input class="btn" type="submit" value="로그인">
</form>


