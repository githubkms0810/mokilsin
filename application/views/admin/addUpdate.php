
<?php $renderMenu=function () use($moduleName,$row,$mode)
{
    ?>
<?php if ( strpos($mode,"update") > -1 ): ?>
<!-- <button type="button" class="btn btn-default clickable" data-href="<?=my_site_url("/admin/{$moduleName}/update/{$row->id}")?>">뒤로</button> -->
<?php endif; ?>
<?php if ( $mode !== "setting" ): ?>
<button type="button" class="btn btn-default clickable" data-href="<?=my_site_url("/admin/{$moduleName}/list")?>">목록으로</button>
<?php endif; ?>

<?php if ( strpos($mode,"update") > -1 ): ?>
    <button type="button" class="btn btn-default clickable" data-href="<?=my_site_url("/admin/{$moduleName}/add")?>">추가</button>
    <span style="margin-left:10px;"></span>
    <button class="btn btn-default" <?=$this->ajax_helper->anchor("/admin/{$moduleName}/delete/{$row->id}","복구할 방법이 없습니다. 정말 삭제하시겠습니까?")?> >삭제</button>
<?php endif; ?>
    <?php
} ?>



<?=$renderMenu()?>

<?php if ( count($componentData) === 0 ): ?>
<div class="alert alert-danger">
    <strong>경고 -</strong> <?=$moduleName?>_m에서 _component_addUpdate를 정의해주세요
</div>
<?php exit; endif; ?>


<?php foreach ( $componentData as $components ): ?>
<br>
     <label for=""><?=$components["formDisplayName"] ?? "" ?></label>
     
    <form <?=$this->ajax_helper->form(isset($components["moduleName"]) ? "/admin/".$components["moduleName"]."/add": "/admin/{$moduleName}/$mode") ?>>
                
          <?php if(is_array($components)):
             foreach ( $components as $component ):
                if(!isset($component['inputName'])) continue;
                $component["row"] = $row;
                if(!isset($component["method"]))$component["method"] = "input";
                ?>
                <?=$this->component->{$component["method"]}($component)?>
            <?php endforeach;
            endif;
          ?>      
          
            <button class="btn btn-default" type="submit">확인</button>
            <hr>
    </form>
    <?php if ( $mode === "add" ) break; ?>
    <!-- update 할떄 추가 edit시작 -->
    <?php if (isset($components["rows"]) ===false ) continue;  ?>
    <br>
    <label for=""><?=$components["rows"]["displayName"]?> </label> 
    <hr>
    <ul>
    <?php foreach ( ${$components["rows"]["variableName"]} as $row ): ?>
        <form <?=$this->ajax_helper->form("/admin/{$components["rows"]["moduleName"]}/update/{$row->id}") ?>>
            <?php foreach ( $components["rows"] as $subComponent ): ?>
                <?php if ( is_array($subComponent) ): 
                    //   if(!isset($subComponent['inputName'])) continue;
                      $subComponent["row"] = $row;
                      if(!isset($subComponent["method"]))$subComponent["method"] = "input";
                      ?>
                      <?=$this->component->{$subComponent["method"]}($subComponent)?>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if ( !isset($components["rows"]["alertButton"]) ): ?>
                <button class="btn btn-default" type="submit">수정</button>
            <?php endif; ?>
        </form>
        <?=$this->component->ajaxDelete(["action"=>"/admin/{$components['moduleName']}/delete/$row->id"])?> 
        <?=$this->component->ajaxAlterSortForm(["action"=>"/admin/{$components['moduleName']}/update/$row->id","row"=>$row])?> 
        <br>
        <br>
    <?php endforeach; ?>
</ul>
    
<?php endforeach; ?>
<br>
<hr>
<?=$renderMenu()?>
<!-- <span style="margin-left:10px;"></span> -->




