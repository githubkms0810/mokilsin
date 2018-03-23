
<form action="/admin/email/add" method="post">
<?=$this->component->input(["displayName"=>"받는사람","row"=>$row,"inputName"=>"to"])?>

<?=$this->component->input(["displayName"=>"제목","row"=>$row,"inputName"=>"title"])?>

<?=$this->component->summernote(["displayName"=>"제목","row"=>$row,"inputName"=>"desc"])?>

<button class="btn btn-default" type="submit">보내기</button>

</form>