<?php
 public function _ajax_delete($id){
  header("content-type:application/json");
  $this->{$this->model}->_delete($id);

  $data['reload'] = true;
  echo json_encode($data);
  return;
}


   
ob_start();
$this->_view("ajax_target", $data);
$output = ob_get_clean();
         
?>


<form onsubmit="ajax_submit(this); return false;" method="post"action="<?=site_url(admin_ref_cate_product_uri."/ajax_update/{$products_in_cate[$i]->ref_id}")?>" style="display:inline-blcok">
onsubmit="ajax_submit(this); return false;"

<a onclick="ajax_a(this); return false;"  data-action='<?=site_url(content_reply_uri."/ajax_update_form")?>' data-callback='ajax_update_form_callback' data-querystring='{"id":"<?=$replys[$i]->id?>"}' href="#">수정</a>

onclick="confirm_callback(this,ajax_a,'복구할 방법이 없습니다. 삭제하시겠습니까?'); return false;" data-action="<?=my_site_url(admin_hotel_uri."/ajax_delete/{$rows[$i]->id}")?>" href="#"
<a onclick="confirm_callback(this,ajax_a,'복구할 방법이 없습니다. 삭제하시겠습니까?'); return false;" data-action="<?=my_site_url(admin_hotel_uri."/ajax_delete/{$rows[$i]->id}")?>" href="#">삭제</a> </li>


<a onclick="confirm_redirect('<?=my_site_url(admin_ref_cate_product_uri."/delete/{$products_in_cate[$i]->ref_id}")?>','정말 삭제하시겠습니까? 복구 할 방법이 없습니다.'); return false;" href="#">삭제</a>