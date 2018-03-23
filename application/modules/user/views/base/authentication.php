<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="<?=base_url("public/css/common.css")?>">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<div style="margin-top:10px;" class="container">
<form action="<?=my_site_url("/user/{$mode}_auth")?>" method="post">
    <div class="form-group">
        <label for="auth_key">인증 코드</label>
        <input class="form-control" type="text" name="<?="{$mode}_auth_key"?>"/>
    </div>
    <button class="btn btn-default">인증</button>
</form>
<?=$msg?>
<br><a href="<?=my_site_url("/user/{$mode}_auth")?>">다시발송</a>
</div>

