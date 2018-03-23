<!--projectform-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/public/subpage/css/005_project/style.css"> <!-- Resource style -->
<script src="/public/subpage/js/005_project/modernizr.js"></script> <!-- Modernizr -->
<!--// jQuery UI CSS파일--> 
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />  
<!--// jQuery 기본 js파일-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>  
<!--jQuery UI 라이브러리 js파일-->
<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script> 


<!--프리랜서지원폼 시작-->
<?php if ( $this->className ==="base" ): ?>
<section class="home-hero-freelancer">
	<div class="animated fadeInUp">
	<h2 class="home-hero-title-freelancer">FREELANCER</h2>
    <p class="home-hero-des-freelancer">
		코리아 통번역 센터와 함께<br class="br_free">
        더 좋은 번역 산업의 미래를 만들어가고 싶으시다면<br class="br_free">
        아래 지원서를 작성해주세요.
    </p>
    <a href="/translation_order/list" class="home-btn">포트폴리오 보러가기</a></div>
</section>
<?php endif; ?>

<div id="free_wrapper" style="margin: 100px 0 150px; 0;">
<form action="<?=$this->className === "admin"? "/admin" : "" ?>/freelancer/<?=$mode?>" method="post"  onsubmit="" class="project_form floating-labels" enctype="multipart/form-data">
<fieldset>
	
	<legend>프리랜서 지원</legend>

	

	<!--개인일때-->
	<div class="icon">
		<label class="project_label" for="free_name">이름</label>
		<input value="<?=DEBUG === false ? my_set_value($row,"name") : "이름테스트" ?>" class="user" type="text" name="name" id="free_name" style="width:99%;" required>
	</div> 

	<div>
		  <h4>생년월일</h4>
 
		<p class="project_select icon">
			<select name="birth_year" class="budget" style="width:33%; display:inline-block;">
				<option value="">연도</option>
				<?php 
				$numOfMinus = 90;
				$startYear = date('Y', strtotime("-$numOfMinus years"));
				 for ( $i = 0 ; $i < $numOfMinus-10 ; $i++ ): $year=$startYear + $i;?>
					<option  <?=my_set_selected($row,"birth_year",$year)?>><?=$year?></option>
				<?php endfor; ?>
		    </select>
		    <select name="birth_month" class="budget" style="width:32%; display:inline-block;">
				<option  value="">월</option>
				<?php for ( $i = 1 ; $i <=12 ; $i++ ): ?>
					<option <?=DEBUG === false ? my_set_selected($row,"birth_month",$i) : "selected"?>><?=$i?></option>
				<?php endfor; ?>
			</select>
			<select name="birth_day" class="budget" style="width:32.8%; display:inline-block;">
			  	<option  value="">일</option>
				<?php for ( $i = 1 ; $i <=31 ; $i++ ): ?>
					<option <?=DEBUG === false ? my_set_selected($row,"birth_day",$i) : "selected"?>><?=$i?></option>
				<?php endfor; ?>
			</select>
		</p>
	</div>

    <div>
		<h4>성별</h4>

		<ul class="project_form-list">
			<li>
				<input type="radio" name="sex" value="남성" <?=my_set_checked($row,"sex","남성",true)?> id="free_radio_sex1">
				<label for="free_radio_sex1">남성</label>
			</li>
			<li>
				<input type="radio" name="sex" value="여성" <?=my_set_checked($row,"sex","여성")?> id="free_radio_sex2">
				<label for="free_radio_sex2">여성</label>
			</li>
		</ul>
	</div>


	<div class="icon">
		<label class="project_label" for="free_phone">연락처</label>
		<input value="<?=DEBUG === false ? my_set_value($row,"phone") : "개인번호3" ?>" class="budget" type="text" name="phone" id="free_phone" style="width:99%;" required>
	</div> 

	<div class="icon">
		<label class="project_label" for="email">E-mail</label>
		<input value="<?=DEBUG === false ? my_set_value( isset($row->email) ? $this->post_helper->extractUserNameOnEmail($row->email) : null,"email_first") : "emailtestr" ?>" style="width:99%;" class="email" type="text" name="email_first" id="free_email">
	</div>

	<div>
		<div class="icon" style="width:99%;">
			<h4>주소</h4>
			<input value="<?=DEBUG === false ? my_set_value($row,"new_address") : "주소테스트" ?>" onclick="sample4_execDaumPostcode(); return false;" placeholder="주소" class="email" type="text" name="new_address" required id="sample4_roadAddress" value=" " readonly>
			<input type="hidden" id="sample4_postcode" name="post_number" value="<?=DEBUG === false ? my_set_value($row,"post_number"): "지번테스트" ?>">
			<input type="hidden" id="sample4_jibunAddress" name="old_address" value="<?=DEBUG === false ? my_set_value($row,"old_address"): "구주소 테스트" ?>">

		
		</div>
		<div class="icon" style="margin-top:20px;">
			<label class="project_label" for="project_detailaddress">상세 주소</label>
			<input value="<?=DEBUG === false ? my_set_value($row,"address_detail") : "상세주소테스트" ?>" class="email" type="text" name="address_detail" id="free_address" style="width:99%;" required>
			<span id="guide" style="color:#999"></span>
		</div>
	</div>

	<div>
		<h4>지원 분야</h4>

		<ul class="project_form-list">
			<li>
				<input type="radio" name="apply_field" value="통역" <?=my_set_checked($row,"apply_field","통역",true)?> id="free_radio_apply1">
				<label for="free_radio_apply1">통역</label>
			</li>
			<li>
				<input type="radio" name="apply_field" value="번역" <?=my_set_checked($row,"apply_field","번역")?> id="free_radio_apply2">
				<label for="free_radio_apply2">번역</label>
			</li>
		</ul>
	</div>

	<div>
		<h4>계좌 정보</h4>

		<p class="project_select icon_account">
			<select name="account_bank" class="budget" style="width:24%; display:inline-block;">
				<option value="">은행</option>
			    <option value="NH농협은행" <?=my_set_selected($row,"account_bank","NH농협은행")?>>NH농협은행</option>
			    <option value="우리은행" <?=my_set_selected($row,"account_bank","우리은행")?>>우리은행</option>
			    <option value="SC은행" <?=my_set_selected($row,"account_bank","SC은행")?>>SC은행</option>
			    <option value="기업은행" <?=my_set_selected($row,"account_bank","기업은행")?>>기업은행</option>
			    <option value="수협중앙회" <?=my_set_selected($row,"account_bank","수협중앙회")?>>수협중앙회</option>
			    <option value="신한은행" <?=my_set_selected($row,"account_bank","신한은행")?>>신한은행</option>
			    <option value="한국씨티은행" <?=my_set_selected($row,"account_bank","한국씨티은행")?>>한국씨티은행</option>
			    <option value="대구은행" <?=my_set_selected($row,"account_bank","대구은행")?>>대구은행</option>
                <option value="부산은행" <?=my_set_selected($row,"account_bank","부산은행")?>>부산은행</option>
                <option value="한국산업은행" <?=my_set_selected($row,"account_bank","한국산업은행")?>>한국산업은행</option>
                <option value="광주은행" <?=my_set_selected($row,"account_bank","광주은행")?>>광주은행</option>
                <option value="제주은행" <?=my_set_selected($row,"account_bank","제주은행")?>>제주은행</option>
                <option value="전북은행" <?=my_set_selected($row,"account_bank","전북은행")?>>전북은행</option>
                <option value="경남은행" <?=my_set_selected($row,"account_bank","경남은행")?>>경남은행</option>
                <option value="KEB 하나은행" <?=my_set_selected($row,"account_bank","KEB 하나은행")?>>KEB 하나은행</option>
                <option value="새마을금고" <?=my_set_selected($row,"account_bank","국민")?>>새마을금고</option>
                <option value="우체국" <?=my_set_selected($row,"account_bank","국민")?>>우체국</option>
                <option value="새마을금고" <?=my_set_selected($row,"account_bank","국민")?>>새마을금고</option>
                <option value="신협" <?=my_set_selected($row,"account_bank","국민")?>>신협</option>
                <option value="산림조합" <?=my_set_selected($row,"account_bank","국민")?>>산림조합</option>
			</select>
			<input value="<?=DEBUG === false ? my_set_value($row,"account_number") : "1245967" ?>" placeholder="계좌번호" type="text" name="account_number" id="free_account" required style="display:inline-block; width: 50%;">
			<input value="<?=DEBUG === false ? my_set_value($row,"account_name") : "예금주테스트" ?>" placeholder="예금주" type="text" name="account_name" id="free_account" required style="width: 23%; display:inline-block;">
		</p>
	</div>

		<div >
		<h4>사용 언어</h4>
		<span style="color:red !important;"><?=form_error("languages[]",null,null)?></span>
		<ul class="project_form-list">
			<?php $i=1; foreach ( $languages as $language ): ?>
			<li>
			<input type="checkbox" name="languages[]" value="<?=$language?>" <?=DEBUG === false ? my_set_checked($row,"languages",$language,false,",") : "checked"?> id="free_checkbox-<?=$i?>">
			<label for="free_checkbox-<?=$i?>"><?=$language?></label>
		</li>
		<?php $i++; endforeach; ?>
		</ul>
	</div>

	<div>
		<h4>언어 방향</h4>

		<ul class="project_form-list">
		<li>
		<input type="radio" name="translation_direction" value="외국어->한국어" <?=my_set_checked($row,"translation_direction","외국어->한국어",true)?> id="free_radio_1">
		<label for="free_radio_1">외국어 → 한국어</label>
		</li>
	<li>
		<input type="radio" name="translation_direction" value="한국어->외국어" <?=my_set_checked($row,"translation_direction","한국어->외국어")?> id="free_radio_2">
		<label for="free_radio_2">한국어 ← 외국어</label>
	</li>
	<li>
		<input type="radio" name="translation_direction" value="외국어<->한국어" <?=my_set_checked($row,"translation_direction","외국어<->한국어")?> id="free_radio_3">
		<label for="free_radio_3">외국어 ↔ 한국어</label>
	</li>
		</ul>
	</div>

	<div>
		<h4>재직유무</h4>

		<ul class="project_form-list">
		<li>
			<input type="radio" name="is_employed" value="1" <?=DEBUG === false ? my_set_checked($row,"is_employed","1") : "checked" ?>  id="is_employed-1" checked>
			<label for="is_employed-1">유</label>
		</li>
		<li>
			<input type="radio" name="is_employed" value="0" <?=my_set_checked($row,"is_employed","0")?> id="is_employed-2">
			<label for="is_employed-2">무</label>
		</li>
		</ul>
	</div>
	<div>
		<h4>학력 사항</h4>
		<ul class="project_form-list" style="margin-bottom:1px;">
				  <li>
					  <input type="radio" name="is_graduate_school" value="0" onclick="div_OnOff(this.value,'school');" <?=my_set_checked($row,"is_graduate_school","0",true)?> id="free_want-1" checked>
					  <label for="free_want-1"><?php $equipment="요청"?>대학교</label>
				  </li>
				  <li>
					  <input type="radio" name="is_graduate_school" value="1" onclick="div_OnOff(this.value,'school');" <?=my_set_checked($row,"is_graduate_school","1")?> id="free_want-2">
					  <label for="free_want-2"><?php $equipment="미요청"?>대학원</label>
				  </li>
			  </ul>
		<div class="icon">
		  <label class="project_label" for="free_schoolname">대학명</label>
		  <input class="company" type="text" name="university" value="<?=DEBUG === false ? my_set_value($row,"university") : "대학교이름 테스트"?>" id="free_schoolname">
		</div> 

		<div class="icon">
		  <label class="project_label" for="free_subname">전공명</label>
		  <input class="company" type="text" name="university_major" value="<?=DEBUG === false ? my_set_value($row,"university_major") : "대학교전공 테스트"?>" id="free_subname">
		</div>


		  <div id="school" style="display:none;">
			<div class="icon">
				<label style="width:45%;" class="project_label" for="free_graduate_schoolname">대학원명</label>
				<input class="company" type="text" name="graduate_school" value="<?=DEBUG === false ? my_set_value($row,"graduate_school") : "대학원이름 테스트"?>" style="width:49.5%; display:inline-block;" id="free_graduate_schoolname">
				<select style="width:49.5%; display:inline-block;" class="email" name="graduate_school_degree">
					<option>학위</option>	
					<option <?=set_select("graduate_school_degree","석사")?>>석사</option>
					<option <?=set_select("graduate_school_degree","박사")?>>박사</option>
					<option <?=set_select("graduate_school_degree","학사")?>>학사</option>
				</select>
			</div>
			<div class="icon">
		  		<label class="project_label" for="free_graduate_schoolsubname">전공명</label>
		  		<input class="company" type="text" name="graduate_school_major" value="<?=DEBUG === false ? my_set_value($row,"graduate_school_major") : "대학원전공 테스트"?>" id="free_graduate_schoolsubname">
			</div>

		</div>

		  <script>
			  function div_OnOff(v,id){
				   // 라디오 버튼 value 값 조건 비교
				   if(v == "1"){
					   document.getElementById(id).style.display = ""; // 보여줌
				   }
				   else{
					   document.getElementById(id).style.display = "none"; // 숨김
				   }
			  }
				//어드민페이지 업데이트 페이지에서 대학원이라면 대학원필드 보이게 시작
			  <?php if($row->is_graduate_school ==="1"):?>
			  	$(document).ready(function(){
					document.getElementById("school").style.display = ""; // 보여줌
				  });
				//어드민페이지 업데이트 페이지에서 대학원이라면 대학원필드 보이게 끝
			<?php endif;?>
		  </script>
    </div>

	<!--첨부파일폼시작-->
	<div class="row">
	    <h4>이력서 및 포트폴리오</h4>
		<div class="col s12">
            <button type="button" onclick="$('#jy-input-file').click();" class="replace">파일 업로드</button><input id="jy-input-file" multiple="multiple" type="file" name="files[]" style="display:none;" />
			<!-- <iframe class="iframe_dynamic_height" height="100px;" width="100%" maginwidth="0" marginheight="0" frameborder="0"  scrolling="no"  src="/file/upload" ></iframe>
			<script  src="/public/subpage/js/000_fileuproad/iframe-dynmic-height.js"></script> -->
		</div>
	</div>
	<!--첨부파일폼 끝-->

	<div>
		<input type="submit" value="지원하기">
	</div>
</fieldset>
</form>
</div>
  
<!--프리랜서지원폼 끝-->  
<script src="/public/subpage/js/005_project/main.js"></script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
  //본 예제에서는 도로명 주소 표기 방식에 대한 법령에 따라, 내려오는 데이터를 조합하여 올바른 주소를 구성하는 방법을 설명합니다.
  function sample4_execDaumPostcode() {
	  new daum.Postcode({
		  oncomplete: function(data) {
			  // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

			  // 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
			  // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
			  var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
			  var extraRoadAddr = ''; // 도로명 조합형 주소 변수

			  // 법정동명이 있을 경우 추가한다. (법정리는 제외)
			  // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
			  if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
				  extraRoadAddr += data.bname;
			  }
			  // 건물명이 있고, 공동주택일 경우 추가한다.
			  if(data.buildingName !== '' && data.apartment === 'Y'){
				 extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
			  }
			  // 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
			  if(extraRoadAddr !== ''){
				  extraRoadAddr = ' (' + extraRoadAddr + ')';
			  }
			  // 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
			  if(fullRoadAddr !== ''){
				  fullRoadAddr += extraRoadAddr;
			  }

			  // 우편번호와 주소 정보를 해당 필드에 넣는다.
			  document.getElementById('sample4_postcode').value = data.zonecode; //5자리 새우편번호 사용
			  document.getElementById('sample4_roadAddress').value = fullRoadAddr;
			  document.getElementById('sample4_jibunAddress').value = data.jibunAddress;

			  // 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
			  if(data.autoRoadAddress) {
				  //예상되는 도로명 주소에 조합형 주소를 추가한다.
				  var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
				  document.getElementById('guide').innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';

			  } else if(data.autoJibunAddress) {
				  var expJibunAddr = data.autoJibunAddress;
				  document.getElementById('guide').innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';

			  } else {
				  document.getElementById('guide').innerHTML = '';
			  }
		  }
	  }).open();
  }
</script>