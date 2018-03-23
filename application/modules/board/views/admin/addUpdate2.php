
<form <?=$this->ajax_helper->form("/admin/{$moduleName}/$mode")?>>
<?=$this->component->inputByRows($users,"radio","user_id","id","name,userName",true)?>
<?=$this->component->inputByRows($products,"radio","product_id","id","name,id",true)?>

<?=$this->component->input("radio","is_fixed","1,0","정액제,무제한")?>
<?=$this->component->input("text","day","1","일")?>
<!-- <?=$this->component->datepicker("start_date","시작날자")?> -->
<!-- <?=$this->component->datepicker("start_date","끝 날자")?> -->
<input type="submit" value="보내기">
</form>



<!-- <?=$this->ajax_helper->createScript()?> -->