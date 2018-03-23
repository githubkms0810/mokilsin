<?php if ( count($searchDataList) !== 0 ): ?>
<form style="margin-top:10px; width:260px; margin:0 auto;" class="form-inline" <?=$this->ajax_helper->form_get(my_site_url("/{$moduleName}/list",true,false,["offset"]))?> >
<!-- <form style="margin-top:10px;" class="form-inline" action="<?=my_site_url("/{$moduleName}/list")?>"> -->
	<div class="form-group">
	
	<label for=""></label>

	<input class="form-control" type="text" name="searchValue[]" value="<?=my_set_value_input('searchValue',0)?>">


	</div>
	<button type="submit" class="btn btn-default">검색</button>
	
	<?php if ( get("searchKey") !== null ): ?>
	<!-- $_GET["mainMenu"] 이상해서 그냥 되는대로 처리함... -->
	<?php $mainMenu = $_GET["mainMenu"] ?? ""?>
	<?php $subMenu = $_GET["subMenu"] ?? ""?>
		<button type="button"class="btn btn-default clickable" data-href="<?=site_url("/{$moduleName}/list?mainMenu={$mainMenu}&subMenu={$subMenu}")?>">모두보기</button>
	<?php endif; ?>
	<br>

	<br>
	<?php $this->load->views($searchOption_view) ?>


</form>
<?php endif; ?>

