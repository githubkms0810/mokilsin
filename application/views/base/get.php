
<?php if ( count($fieldData) ===0 ): ?>
<div class="alert alert-danger">
<strong>경고 -</strong> <?=$moduleName?>_m에서 getData_base가 정의되지 않았습니다.
</div>
<?php endif; ?>

<div class="list-group">
<?php foreach ( $fieldData as $data ):
    
    $fieldName = getFieldName($data["fieldName"]);
    ?>
    <?php if ( isset($data["displayName"]) ): ?>
        <?php if ( $data["type"] === "image" ): ?>
            <img style="<?=$data["style"] ?? 'width:450px;'?>" class="<?=$data["class"] ?? "img-thumbnail" ?>"  src="<?=$row->$fieldName?>" alt="">
        <?php elseif($data["type"] === "text" ): ?>
            <a  class="list-group-item"><?=$data["displayName"]?> - <?=$row->$fieldName?></a>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>
</div>


<button class="btn btn-default clickable" data-href="<?=my_site_url("/{$moduleName}/list")?>">목록으로</button>
<span style="margin-left:20px;"></span>
<button  class="btn btn-default clickable" data-href="<?=my_site_url("/{$moduleName}/update/$row->id")?>">수정</button>
<button  type="button" class="btn btn-default clickable" data-href="<?=my_site_url("/{$moduleName}/add")?>">추가</button>
<button class="btn btn-default" <?=$this->ajax_helper->anchor("/{$moduleName}/delete/{$row->id}","복구할 방법이 없습니다. 정말 삭제하시겠습니까?")?> >삭제</button>

