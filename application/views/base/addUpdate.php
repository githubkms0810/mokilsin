<form <?=$this->ajax_helper->form("/{$moduleName}/$mode")?>>
    <?php if ( !isset($components[0]) ): ?>
        <strong>경고 -</strong> <?=$moduleName?>_m에서 _component_addUpdate를 정의해주세요
    <?php else: ?>

        <?php if ( !is_array($components[0])  ): ?>
            <?php foreach ( $components as $field ): ?>
            <div class="form-group">
                <label for="<?=$field?>"><?=$field?></label>
                <input class="form-control"  type="text" name="<?=$field?>" value="<?=my_set_value($row,$field)?>">
            </div>

            <?php endforeach; ?>    
        <?php else: ?>
            <?php foreach ( $components as $cpInfo ):
                if(!isset($cpInfo['inputName'])) continue;
                $cpInfo["row"] = $row;
                if(isset($cpInfo["rowsName"]))$cpInfo["rows"] = ${$cpInfo["rowsName"]};
                if(!isset($cpInfo["method"]))$cpInfo["method"] = "input";
                ?>
            
            <?=$this->component->{$cpInfo["method"]}($cpInfo)?>
            <?php endforeach; ?>    
        <?php endif; ?>

        <button class="btn btn-default" type="submit"><?=$mode === "add" ? "추가" : "수정"?></button>
        <span style="margin-left:10px;"></span>
        <?php if ( strpos($mode,"update") > -1 ): ?>
        <button type="button" class="btn btn-default clickable" data-href="<?=my_site_url("/{$moduleName}/get/{$row->id}")?>">뒤로</button>
        <?php endif; ?>
        <?php if ( $mode !== "setting" ): ?>
        <button type="button" class="btn btn-default clickable" data-href="<?=my_site_url("/{$moduleName}/list")?>">목록으로</button>
        <?php endif; ?>


    <?php endif; ?>
    
 

    <?php if ( strpos($mode,"update") > -1 ): ?>
        <button type="button" class="btn btn-default clickable" data-href="<?=my_site_url("/{$moduleName}/add")?>">추가</button>
        <span style="margin-left:10px;"></span>
        <button class="btn btn-default" <?=$this->ajax_helper->anchor("/{$moduleName}/delete/{$row->id}","복구할 방법이 없습니다. 정말 삭제하시겠습니까?")?> >삭제</button>
    <?php endif; ?>
</form>