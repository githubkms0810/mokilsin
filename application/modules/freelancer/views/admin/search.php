<?php if ( count($searchDataList) !== 0 ): ?>
	<div style="text-align:center;">
		<form style="margin-top:10px;" class="form-inline" <?=$this->ajax_helper->form_get(my_site_url("/admin/{$moduleName}/list",true,false,["offset"]))?> >
			<div class="form-group">
			<label for=""></label>
		
			<select class="form-control" name="searchKey[]" id="">
				<?php foreach ( $searchDataList as $key=>$searchData ): ?>
					<?php if ( isset($searchData["displayName"]) ): ?>
						<option value="<?=$key?>" <?=my_set_selected(null, 'searchKey', $key)?>><?=$searchData["displayName"]?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
			<label for=""></label>
		
			<input class="form-control" type="text" name="searchValue[]" value="<?=my_set_value_input('searchValue',0)?>">

		
			</div>
			<button type="submit" class="btn btn-default">검색</button>
			
			<?php if ( get("searchKey") !== null ): ?>
				<button type="button"class="btn btn-default clickable" data-href="<?=site_url("/admin/{$moduleName}/list?mainMenu={$_GET["mainMenu"]}&subMenu={$_GET["subMenu"]}")?>">모두보기</button>
			<?php endif; ?>
			<br>

			<br>
			<?php $this->load->views($searchOption_view) ?>
		

		</form>

</div>
	<?php endif; ?>

