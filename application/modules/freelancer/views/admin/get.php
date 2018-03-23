
<link rel="stylesheet" href="/public/css/jy.css">
<a class="btn btn-default clickable " style="height:30px; padding-top:4px;" href="/admin/freelancer/update/<?=$row->id?>">상세 수정하러 가기</a>
<br>
<br>
<table class="table table-bordered">
    
    <tbody>
      <tr>
        <td class="jy-td-name">이름</td>
        <td colspan="2" ><?=$row->name?></td>
        <td class="jy-td-name">성별</td>
        <td colspan="2" ><?=$row->sex?></td>
        <td class="jy-td-name">생년월일</td>
        <td colspan="2"><?=$row->birth_year?>년 <?=$row->birth_month?>월 <?=$row->birth_day?>일</td>
      </tr>
      <tr>
      </tr>
      <tr>
        <td class="jy-td-name">연락처</td>
        <td colspan="2"><?=$row->tel?></td>
        <td class="jy-td-name">휴대폰</td>
        <td colspan="2"><?=$row->phone?></td>
        <td class="jy-td-name">국가</td>
        <td colspan="2"><?=$row->nation?></td>
      </tr>
      <tr>
      </tr>
      <tr>
        <td class="jy-td-name">이메일</td>
        <td colspan="8"><?=$row->email?></td>
      </tr>
      <tr>
        <td class="jy-td-name">우편번호</td>
        <td colspan="8"><?=$row->post_number?></td>
      </tr>
      <tr>
        <td class="jy-td-name">도로명주소</td>
        <td colspan="3"><?=$row->new_address?></td>
        <td class="jy-td-name">지번주소</td>
        <td colspan="4"><?=$row->old_address?></td>
      </tr>
      <tr>
        <td class="jy-td-name">상세주소</td>
        <td colspan="8"><?=$row->address_detail?></td>
      </tr>
      <tr>
        <td class="jy-td-name">계좌정보</td>
        <td colspan="8"><?=$row->account_bank?> <?=$row->account_number?> <?=$row->account_name?></td>
      </tr>
     
    </tbody>
  </table>



  <table class="table table-bordered">
    
    <tbody>
      <tr>
        <td class="jy-td-name">지원분야</td>
        <td colspan="8"><?=$row->apply_field?></td>
      </tr>
      <tr>
      </tr>
      <tr>
        <td class="jy-td-name">경력</td>
        <td colspan="3"><?=$row->is_have_career?></td>
        <td class="jy-td-name">언어수준</td>
        <td colspan="4"><?=$row->level?></td>
      </tr>
      <tr>
        <td class="jy-td-name">언어방향</td>
        <td colspan="8"><?=$row->translation_direction?></td>
      </tr>
      <tr>
        <td class="jy-td-name">언어종류</td>
        <td colspan="8"><?=$row->languages?></td>
      </tr>
      <tr>
        <td class="jy-td-name">분야</td>
        <td colspan="8"><?=$row->field_detail?></td>
      </tr>
      <tr>
        <td class="jy-td-name">재직유무</td>
        <td colspan="8"><?=$row->is_employed?></td>
      </tr>
      <tr>
        <td colspan="1" class="jy-td-name">대학</td>
        <td colspan="3"><?=$row->university?></td>
        <td colspan="1" class="jy-td-name">전공</td>
        <td colspan="4"><?=$row->university_major?></td>
      </tr>
      <tr>
      <td class="jy-td-name">대학원</td>
      <td colspan="2"><?=$row->graduate_school?></td>
      <td class="jy-td-name">학위</td>
      <td colspan="2"><?=$row->graduate_school_degree?></td>
      <td class="jy-td-name">전공</td>
      <td colspan="2"><?=$row->graduate_school_major?></td>
      </tr>
      <tr>
        <td class="jy-td-name">일할 수 있는 날짜</td>
        <td colspan="8"><?=$row->can_working_day?></td>
      </tr>
      <tr>
        <td class="jy-td-name">하루에 번역 가능 페이지수</td>
        <td colspan="8"><?=$row->num_translation_per_day?></td>
      </tr>
      <tr>
        <td class="jy-td-name">관리자 점수</td>
        <td colspan="4"><?=$row->admin_score?></td>
        <td colspan="4">
          <form style="display:inline-block" <?=$this->ajax_helper->form("/admin/freelancer/updateAjax/{$row->id}")?>>
                <div style="display:inline-block" class="form-group">
                <input name="admin_score" type="number" class="form-control" id="usr">
                </div>
                <button class="btn btn-default">확인</button>
            </form>
        </td>
      </tr>
      <tr>
        <td class="jy-td-name">관리자 메모</td>
        <td colspan="4"><?=$row->admin_memo?></td>
        <td colspan="4">
          <form style="display:inline-block" <?=$this->ajax_helper->form("/admin/freelancer/updateAjax/{$row->id}")?>>
                <div style="display:inline-block" class="form-group">
                <input name="admin_memo" type="text" class="form-control" id="usr">
                </div>
                <button class="btn btn-default">확인</button>
            </form>
        </td>
      </tr>
      <tr>
        <td class="jy-td-name">승인상태</td>
        <td colspan="1"><?=$row->is_admin_confirm?></td>
        <td colspan="3">
          <form style="display:inline-block" <?=$this->ajax_helper->form("/admin/freelancer/updateAjax/{$row->id}")?>>
              <div style="display:inline-block" class="form-group">
                  <select name="is_admin_confirm" class="form-control" id="sel1">
                      <option value="1">승인</option>
                      <option value="0">비승인</option>
                  </select>
              </div>
              <button class="btn btn-default">확인</button>
          </form>
        </td>
        <td colspan="4">
        <h4><a class="btn btn-default" target="_blank" href="/admin/email/add?email=<?=$row->email?>">이메일 보내기</a></h4>
        </td>
      </tr>
    </tbody>
  </table>



<?php foreach ( $application_files as $application_file ): ?>
<div class="row">
    <div class="col-sm-12">
      <h4 style="display:inline-block" >지원서파일 : <a href="/download/<?=$application_file->id?>"><?=$application_file->original_name?></a></h4>
      &nbsp
      <a style="display:inline-block" class="btn btn-default" <?=$this->ajax_helper->anchor("/file/delete/{$application_file->id}","복구할 방법이 없습니다 정말 삭제 하시겠습니까?")?>>삭제</a>
    </div>
</div>
<?php endforeach; ?>
<!-- 아래 주석풀꺼면 a링크 download 속성으로 간단하게 다운하게 되면 될듯?(최신브라우저만 지원...) -->
<!-- <div class="row">
    <div class="col-sm-12"><h4>지원서파일 : <?=$row->application_file_directory1?></h4></div>
</div>
<div class="row">
    <div class="col-sm-12"><h4>지원서파일 : <?=$row->application_file_directory2?></h4></div>
</div> -->

<hr>

<br>
<a class="btn btn-default clickable " style="height:30px; padding-top:4px;" href="/admin/freelancer/update/<?=$row->id?>">상세 수정하러 가기</a>
<br>
<br>