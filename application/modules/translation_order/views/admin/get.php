
<link rel="stylesheet" href="/public/css/jy.css">


<a  class="btn btn-default clickable " style="height:30px; padding-top:4px;"  href="/admin/translation_order/update/<?=$row->id?>?type=<?=$row->type?>&amp;mainMenu=translation_order&amp;subMenu=translation_order_list">상세 수정하러 가기</a>

<hr/>
<div class="row">
    <div class="col-sm-4"><h3>상태: <?=$row->translation_status?></h3></div>
    <div class="col-sm-4">
        <form <?=$this->ajax_helper->form("/admin/translation_order/updateAjax/{$row->id}")?>>
        <div class="form-group">
            <label for="sel1">상태변경</label>
            <select name="translation_status" class="form-control" id="sel1">
                <option>전달중</option>
                <option>전달완료</option>
                <option>진행중</option>
                <option>완료</option>
            </select>
        </div>
        <button class="btn btn-default">확인</button>
        </form>
    </div>
    
</div>
<hr/>


<table class="table table-bordered">
    
    <tbody>
  
     

    <tr>
        <td class="jy-td-name">종류</td>
        <td colspan="8"><?=$row->type?></td>
    </tr>
    <tr>
        <td class="jy-td-name">구매자종류</td>
        <td colspan="8"><?=$row->buyer?></td>
    </tr>

<?php if ( $row->buyer ==="회사" ): ?>

<tr>
    <td class="jy-td-name">회사명</td>
    <td colspan="8"><?=$row->company?></td>
</tr>
<tr>
    <td class="jy-td-name">부서명</td>
    <td colspan="8"><?=$row->department?></td>
</tr>
<tr>
    <td class="jy-td-name">회사번호</td>
    <td colspan="8"><?=$row->company_phone?></td>
</tr>
<tr>
    <td class="jy-td-name">담당자</td>
    <td colspan="8"><?=$row->manager?></td>
</tr>
<tr>
    <td class="jy-td-name">담당자번호</td>
    <td colspan="8"><?=$row->manager_phone?></td>
</tr>



    
<?php endif; ?>
<?php if ( $row->buyer ==="개인" ): ?>
<tr>
    <td class="jy-td-name">이름</td>
    <td colspan="8"><?=$row->personal_name?></td>
</tr>

<tr>
    <td class="jy-td-name">번호</td>
    <td colspan="8"><?=$row->personal_phone?></td>
</tr>

<?php endif; ?>
    <tr>
        <td class="jy-td-name">팩스여부</td>
        <td colspan="3"><?=$row->is_exist_fax?></td>
        <td class="jy-td-name">팩스번호</td>
        <td colspan="4"><?=$row->fax?></td>
    </tr>
    <tr>
        <td class="jy-td-name">이메일</td>
        <td colspan="8"><?=$row->email?></td>
    </tr>
</tbody>
  </table>

<hr/>
<?php if ($row->type ==="통역" ): ?>

<table class="table table-bordered">
    
    <tbody>
      <tr>
        <td class="jy-td-name">통역종류</td>
        <td colspan="8"><?=$row->interpret_kind?></td>
      </tr>
      <tr>
        <td class="jy-td-name">우편번호</td>
        <td colspan="8"><?=$row->interpret_post_number?></td>
      </tr>
      <tr>
        <td class="jy-td-name">도로명</td>
        <td colspan="3"><?=$row->interpret_new_address?></td>
        <td class="jy-td-name">지번명</td>
        <td colspan="4"><?=$row->interpret_old_address?></td>
      </tr>
      <tr>
      <td class="jy-td-name">상세 주소</td>
      <td colspan="8"><?=$row->interpret_address_detail?></td>
    </tr>
      <tr>
      <td class="jy-td-name">시작일</td>
      <td colspan="3"><?=$row->interpret_start_date?></td>
      <td class="jy-td-name">마지막일</td>
      <td colspan="4"><?=$row->interpret_end_date?></td>
    </tr>
      <tr>
      <td class="jy-td-name">희망 납기일</td>
      <td colspan="8"><?=$row->interpret_pay_date?></td>
    </tr>
      <tr>
      <td class="jy-td-name">장비유무</td>
      <td colspan="3"><?=$row->is_need_equiment?></td>
      <td class="jy-td-name">장비갯수</td>
      <td colspan="4"><?=$row->num_equiment?></td>
    </tr>
    <tr>
      <td class="jy-td-name">프로필 유무</td>
      <td colspan="8"><?=$row->is_need_profile?></td>
    </tr>
    </tbody>
  </table>


<?php endif; ?>

<table class="table table-bordered">
    
    <tbody>
      <tr>
        <td class="jy-td-name">번역종류</td>
        <td colspan="8" ><?=$row->translation_kind?></td>
      </tr>
      <tr>
        <td class="jy-td-name">번역전</td>
        <td colspan="3" ><?=$row->translation_before?></td>
        <td class="jy-td-name">번역후</td>
        <td colspan="4" ><?=$row->translation_after?></td>
      </tr>
      <tr>
        <td class="jy-td-name">예산여부</td>
        <td colspan="3" ><?=$row->is_exist_budget?></td>
        <td class="jy-td-name">예산</td>
        <td colspan="4" ><?=$row->budget?></td>
      </tr>
      <tr>
        <td class="jy-td-name">마감일</td>
        <td colspan="8" ><?=$row->deadline?></td>
      </tr>
      <tr>
        <td class="jy-td-name">요구사항</td>
        <td colspan="8" ><?=$row->requirements?></td>
      </tr>
      <tr>
        <td class="jy-td-name">세금계산서 여부</td>
        <td colspan="8" ><?=$row->is_get_tax_bill?></td>
      </tr>
      <tr>
        <td class="jy-td-name">현금 영수증</td>
        <td colspan="8" ><?=$row->is_get_cash_receipt?></td>
      </tr>
     
      <tr>
        <td class="jy-td-name">메세지 여부</td>
        <td colspan="8" ><?=$row->message?></td>
      </tr>
      <tr>
        <td class="jy-td-name">분야 설정</td>
        <td colspan="4" ><?=$row->field?></td>
        <td colspan="4" >
        <form <?=$this->ajax_helper->form("/admin/translation_order/updateAjax/{$row->id}")?>>
                    <input type="text" name ="field">
                <button class="btn btn-default">확인</button>
            </form>
        </td>
      </tr>
      <tr>
        <td class="jy-td-name">기밀 여부</td>
        <td colspan="4" ><?=$row->is_use_confidential?></td>
        <td colspan="4" >
        <form style="display:inline-block" <?=$this->ajax_helper->form("/admin/translation_order/updateAjax/{$row->id}")?>>
                <div style="display:inline-block" class="form-group">
                    <select name="is_use_confidential" class="form-control" id="sel1">
                        <option value="1">기밀ON</option>
                        <option value="0">기밀OFF</option>
                    </select>
                </div>
                <button style="display:inline-block" class="btn btn-default">확인</button>
            </form>
        </td>
      </tr>
      <tr>
        <td class="jy-td-name">포트폴리오 여부</td>
        <td colspan="4" ><?=$row->is_portfolio?></td>
        <td colspan="4">
            <form style="display:inline-block" <?=$this->ajax_helper->form("/admin/translation_order/updateAjax/{$row->id}")?>>
                <div style="display:inline-block" class="form-group">
                    <select name="is_portfolio" class="form-control" id="sel1">
                        <option value="1">포트폴리오로 전환</option>
                        <option value="0">비전환</option>
                    </select>
                </div>
                <button style="display:inline-block" class="btn btn-default">확인</button>
            </form>
        </td>
      </tr>
     
    </tbody>
  </table>



<hr/>

<div class="row">
    <div class="col-sm-12"><h2>첨부파일 리스트</h2></div>
</div>
<?php foreach ( $files as $file ): ?>
<div class="row">
    <div class="col-sm-12">
    <h4 style="display:inline-block"><a href="/download/<?=$file->id?>"><?=$file->original_name?></a></h4>
    &nbsp
    <a style="display:inline-block" class="btn btn-default" <?=$this->ajax_helper->anchor("/file/delete/{$file->id}","복구할 방법이 없습니다 정말 삭제 하시겠습니까?")?>>삭제</a>
    </div>
</div>
<?php endforeach; ?>

<hr/>


<div class="row">
    <div class="col-sm-12">
    <form <?=$this->ajax_helper->form("/admin/translation_order/updateAjax/{$row->id}")?>>
    
        <div class="form-group">
            <label for="usr">프로젝트 이름</label>
            <input name="title" type="text" class="form-control" id="usr" value="<?=my_set_value($row,"title")?>">
        </div>
        <div class="form-group">
            <label for="comment">업무내용</label>
            <textarea name="desc" class="form-control" rows="5" id="comment"><?=my_set_value($row,"desc")?></textarea>
        </div>
        <button class="btn btn-default" type="submit">보내기</button>
    </form>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-sm-12">
        <form <?=$this->ajax_helper->form("/admin/translation_order/updateAjax/{$row->id}")?>>
        <?=$this->component->ajaxImage(["displayName"=>"포트폴리오 대표이미지 변경","inputName"=>"image","row"=>$row,"default"=>portfolioDefaultImage])?>
        <button class="btn btn-default" type="submit">보내기</button>
        </form>
    </div>
    
</div>
<hr/>
<a  class="btn btn-default clickable " style="height:30px; padding-top:4px;"  href="/admin/translation_order/update/<?=$row->id?>?type=<?=$row->type?>&amp;mainMenu=translation_order&amp;subMenu=translation_order_list">상세 수정하러 가기</a>

<br>
<br>
