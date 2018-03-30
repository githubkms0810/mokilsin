	<div style="text-align:center;">
		<form style="margin-top:10px;" class="form-inline" <?=$this->ajax_helper->form_get(my_site_url("/admin/{$moduleName}/list",true,false,["offset"]))?> >
        <?php $this->load->views($searchOption_view) ?>
		<!-- <form style="margin-top:10px;" class="form-inline" action="<?=my_site_url("/admin/{$moduleName}/list")?>"> -->
        <div class="form-group">
        <label for=""></label>
    
        <select style="display:none;" class="form-control" name="searchKey[]" id="">
            <?php foreach ( $searchDataList as $key=>$searchData ): ?>
                <?php if ( isset($searchData["displayName"]) ): ?>
                    <option value="<?=$key?>" <?=my_set_selected(null, 'searchKey', $key)?>><?=$searchData["displayName"]?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <label for=""></label>
    
        <input  style="display:none;"  class="form-control" type="text" name="searchValue[]" value="<?=my_set_value_input('searchValue',0)?>">

    
        </div>
        <button type="submit" class="btn btn-default">검색</button>
        
        <?php if ( get("searchKey") !== null ): ?>
            <button type="button"class="btn btn-default clickable" data-href="<?=site_url("/admin/{$moduleName}/list?mainMenu={$_GET["mainMenu"]}&subMenu={$_GET["subMenu"]}")?>">모두보기</button>
        <?php endif; ?>
			<br>
		</form>
        <a href="/admin/applicationn/excel?kind=동요&personalOrGroup=독창">동요/독창 다운로드</a>
<br>
<a href="/admin/applicationn/excel?kind=동요&personalOrGroup=중창">동요/중창 다운로드</a>
<br>
<a href="/admin/applicationn/excel?kind=동시&personalOrGroup=개인">동시/개인 다운로드</a>
<br>
<a href="/admin/applicationn/excel?kind=동시&personalOrGroup=단체">동시/단체 다운로드</a>

</div>


