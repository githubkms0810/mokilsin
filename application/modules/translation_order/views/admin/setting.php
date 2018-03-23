
<p>현재파일 : <?=$row->security_file_name?></p>
<form <?=$this->ajax_helper->multipart("/admin/translation_order/setting")?>>
    <input type="file" name="files[]" >
    <input type="submit" value="저장">
</form>