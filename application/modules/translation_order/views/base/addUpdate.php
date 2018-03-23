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
<?php if ( $this->className === "base" ): ?>
<section class="home-hero-project">
	<div class="animated fadeInUp">
  <h2 class="home-hero-title-project">REQUEST</h2>
  <p class="home-hero-des-project">
	  고객님의 의뢰에 최선을 다하는 코리아 통번역 센터입니다!
  </p>
  <a href="/translation_order/list" class="home-btn">포트폴리오 보러가기</a></div>
</section>
<?php endif; ?>
<!--번역,통역 폼 시작-->
  <form action="<?=$this->className ==="admin" ? "/admin": ""?>/translation_order/<?=$mode?>" method="post"  enctype="multipart/form-data" class="project_form floating-labels" style="margin-top:100px; margin-bottom:150px;">
	  <input type="hidden" name="type" value="<?=$type?>">
	  <fieldset>
		  
		  <legend><?=$type?></legend>
		  <script>
			  $(document).ready(function() {
				
				setViewByCompanyOrPersonal(getCompanyOrPersonalByCheckedInput());

				$("input[name='buyer']:radio").change(function () {
					//라디오 버튼 값을 가져온다.
					var buyer = this.value;
					setViewByCompanyOrPersonal(buyer);
										
					});
			  });
			  function setViewByCompanyOrPersonal(companyOrPersonal)
			  {
				if(companyOrPersonal == "회사"){//회사인 경우
					  //회사 일때 개인 hide
					  $( "#viewPersonal" ).hide();
					  //회사 일때 회사 카테고리 show
					  $( "#viewCompany" ).show();
					  removeAttrNameOnPersonalEmail();
					  setAttrNameOnManagerEmail();
					  settAttrRequriedManagerPhone(true);
					  settAttrRequriedPersonalPhone(false);
				  }
				  else if(companyOrPersonal == "개인"){//개인인 경우
					  //개인 일때 개인 카테고리 show
					  $( "#viewPersonal" ).show();
					  //개인 일때 회사 카테고리 hide
					  $( "#viewCompany" ).hide();
					  removeAttrNameOnManagerEmail();
					  setAttrNameOnPersonalEmail();
					  settAttrRequriedManagerPhone(false);
					  settAttrRequriedPersonalPhone(true);
				  }
			  }
			  function settAttrRequriedPersonalPhone(value)
			  {
				setAttrRequiredBySelector(value,"input[name=personal_phone]");  
			  }
			  function settAttrRequriedManagerPhone(value)
			  {
				setAttrRequiredBySelector(value,"input[name=manager_phone]");
			  }

			  function setAttrRequiredBySelector(value,selector)
			  {
					$(selector).prop('required',value);
			  }
			  function getCompanyOrPersonalByCheckedInput()
			  {
				if($('input:radio[name="buyer"][value="회사"]').prop('checked'))
					return "회사";
				else if($('input:radio[name="buyer"][value="개인"]').prop('checked'))
					return "개인";
			  }
			  function removeAttrNameOnManagerEmail()
			  {	
				setNameBySelector("","#manager_email_first");
				setNameBySelector("","#manager_email_second");
			  }
			  function removeAttrNameOnPersonalEmail()
			  {	
				setNameBySelector("","#personal_email_first");
				setNameBySelector("","#personal_email_second");
			  }
			  function setAttrNameOnManagerEmail()
			  {	
				setNameBySelector("email_first","#manager_email_first");
				setNameBySelector("email_second","#manager_email_second");
			  }
			  
			  function setAttrNameOnPersonalEmail()
			  {	
				setNameBySelector("email_first","#personal_email_first");
				setNameBySelector("email_second","#personal_email_second");
			  }
			  function setNameBySelector(nameValue,selector)
			  {
					$(selector).attr("name",nameValue);
			  }
		  </script>
		  <div>
			  <ul class="project_form-list">
				  <li>
					  <input type="radio" name="buyer" value="회사" <?=my_set_checked($row,"buyer","회사",true)?> id="project_select-1">
					  <label for="project_select-1">기업</label>
				  </li>
				  <li>
					  <input type="radio" name="buyer" value="개인" <?=my_set_checked($row,"buyer","개인")?> id="project_select-2">
					  <label for="project_select-2">개인</label>
				  </li>
			  </ul>
		  </div>

		  <div id="viewCompany">

              <div class="icon">
                  <label class="project_label" for="company">회사명</label>
                  <input class="company" type="text" name="company" value="<?=DEBUG === false ? my_set_value($row,"company") : "회사이름테스트" ?>" id="project_company" >
              </div> 

              <div class="icon">
                  <label class="project_label" for="department">부서</label>
                  <input class="company" type="text" name="department" value="<?=DEBUG === false ? my_set_value($row,"department") : "부서이름테스트" ?>" id="project_depart" >
              </div>
              <div class="icon">
                     <label class="project_label" for="company_phone">회사 연락처</label>
                      <input value="<?=DEBUG === false ? my_set_value($row,"company_phone") : "회사번호3" ?>" class="budget" type="text" name="company_phone" id="project_name" >
              </div>
              <div class="icon">
                      <label class="project_label" for="fax">FAX</label>
                      <input  value="<?=DEBUG === false ? my_set_value($row,"fax") : "팩스번호3" ?>" class="budget" type="text" name="fax" id="project_name" >
              </div>
              <div class="icon">
                  <label class="project_label" for="manager">담당자</label>
                  <input class="user" type="text" name="manager"  value="<?=DEBUG === false ? my_set_value($row,"manager") : "매니저이름 테스트" ?>" id="project_name" >
              </div> 
              <div class="icon">
                    <label class="project_label" for="manager_phone">담당자 연락처</label>
                    <input value="<?=DEBUG === false ? my_set_value($row,"manager_phone") : "매니저번호3" ?>" class="budget" type="text" name="manager_phone" id="project_name" >
              </div>
              <div class="icon">
                  <label style="width:49.5%;" class="project_label" for="project_email">담당자 E-mail</label>
                  <input value="<?=DEBUG === false ? my_set_value( isset($row->email) ? $this->post_helper->extractUserNameOnEmail($row->email) : null,"email_first") : "emailtestr" ?>" class="email" type="text" name="email_first" id="manager_email_first">
              </div>
		  </div>
		  <!--개인일때-->
          <div  id="viewPersonal">
              <div class="icon">
                  <label class="project_label" for="personal_name">이름</label>
                  <input value="<?=DEBUG === false ? my_set_value($row,"personal_name") : "개인이름테스트" ?>" class="user" type="text" name="personal_name" id="project_alonename" >
              </div> 
              <div class="icon">
                      <label class="project_label" for="personal_phone">연락처</label>
                      <input value="<?=DEBUG === false ? my_set_value($row,"personal_phone") : "개인번호3" ?>" class="budget" type="text" name="personal_phone" id="project_name" >
              </div>
              <div class="icon">
                  <label style="width:49.5%;" class="project_label" for="project_email">E-mail</label>
                  	<input value="<?=DEBUG === false ? my_set_value( isset($row->email) ? $this->post_helper->extractUserNameOnEmail($row->email) : null,"email_first") : "emailtestr" ?>" class="email" type="text" name="email_first" id="personal_email_first">
              </div>
		  </div>
	  </fieldset>
  
	  <fieldset>
		  <legend>프로젝트 내용</legend>


		  <?php if ( $type === "통역" ): ?>
		  <div>

		  <div>
			  <h4>통역 형태</h4>
  
			  <p class="project_select icon">
				  <select name="interpret_kind" class="budget">
					  <option value="">선택해주세요.</option>
					  <option <?=DEBUG === true ? "selected" : ""?> <?=my_set_selected($row,"interpret_kind","포도")?>>포도</option>
					  <option <?=my_set_selected($row,"interpret_kind","사과")?>>사과</option>
					  <option <?=my_set_selected($row,"interpret_kind","오렌지")?>>오렌지</option>
				  </select>
			  </p>
		  </div> 

		  <div>
			  <h4>통역 사항</h4>
			  <p class="project_select icon">
				  <select name="translation_kind" class="budget">
					  <option value="">선택해주세요.</option>
					  <option <?=my_set_selected($row,"translation_kind","이것")?> <?=DEBUG === true ? "selected" : ""?>>이것</option>
					  <option <?=my_set_selected($row,"translation_kind","저것")?>>저것</option>
					  <option <?=my_set_selected($row,"translation_kind","그것")?>>그것</option>
				  </select>
			  </p>
		  </div>

		  </div>
		  <?php endif; ?>

		  <?php if ( $type === "번역" ): ?>
		  <div>

		  <div>
			  <h4>통역 사항</h4>
			  <p class="project_select icon">
				  <select name="translation_kind" class="budget">
					  <option  value="">선택해주세요.</option>
					  <option  <?=my_set_selected($row,"translation_kind","이것")?> <?=DEBUG === true ? "selected" : ""?>>이것</option>
					  <option  <?=my_set_selected($row,"translation_kind","저것")?>>저것</option>
					  <option <?=my_set_selected($row,"translation_kind","그것")?>>그것</option>
				  </select>
			  </p>
		  </div>

		  </div>
		  <?php endif; ?>


		  <div>
			  <h4>번역 언어쌍</h4>
  
			  <p class="project_select icon">
				  <select name="translation_before" class="budget" style="width:49.4%; display:inline-block;">
					  <option  value="">시작 언어</option>
					  <option <?=my_set_selected($row,"translation_before","포도")?> <?=DEBUG === true ? "selected" : ""?>>포도</option>
					  <option <?=my_set_selected($row,"translation_before","사과")?>>사과</option>
					  <option <?=my_set_selected($row,"translation_before","오렌지")?>>오렌지</option>
				  </select>
				  <select name="translation_after" class="budget" style="width:49.5%; display:inline-block;">
					  <option  value="">번역 언어</option>
					  <option <?=my_set_selected($row,"translation_after","포도")?> <?=DEBUG === true ? "selected" : ""?> >포도</option>
					  <option <?=my_set_selected($row,"translation_after","사과")?>>사과</option>
					  <option <?=my_set_selected($row,"translation_after","오렌지")?>>오렌지</option>
				  </select>
			  </p>
		  </div>

		  <?php if ( $type === "통역" ): ?>
		  <div>
<br>
		  <div>
			  <h4>통역 장소</h4>
			  <div class="icon" onclick="sample4_execDaumPostcode(); return false;" >
				  <input value="<?=DEBUG === false ? my_set_value($row,"interpret_new_address") : "주소테스트" ?>" class="email" type="text" name="interpret_new_address" id="sample4_roadAddress" placeholder="주소" readonly>
				  <input value="<?=DEBUG === false ? my_set_value($row,"interpret_old_address") : "지번주소테스트" ?>" id="sample4_jibunAddress"type="hidden" name="interpret_old_address">
				  <input value="<?=DEBUG === false ? my_set_value($row,"interpret_post_number") : "우편번호테스트" ?>" id="sample4_postcode"type="hidden" name="interpret_post_number">
			  </div>
			  <div class="icon" style="margin-top:20px;">
				  <label class="project_label" for="project_detailaddress">상세 주소</label>
				  <input value="<?=DEBUG === false ? my_set_value($row,"interpret_address_detail") : "상세주소테스트" ?>" class="email" type="text" name="interpret_address_detail" id="project_detailaddress">
				  <span id="guide" style="color:#999"></span>
			  </div>
		  </div>
<br>
		  <script>
			  (function($) {
				  $.fn.goTo = function() {
				  $('html, body').animate({
					  scrollTop: $(this).offset().top + 'px'
				  }, 'fast');
				  return this; // for chaining...
						}
			  })(jQuery);
				  $.datepicker.setDefaults({
				  dateFormat: 'yy-mm-dd',
				  prevText: '이전 달',
				  nextText: '다음 달',
				  monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
				  monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
				  dayNames: ['일', '월', '화', '수', '목', '금', '토'],
				  dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
				  dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				  showMonthAfterYear: true,
				  yearSuffix: '년'
			  });

			  $(function() {
				  $("#datepicker1").datepicker();
			  });
  
			  $(function() {
				  $("#datepicker2").datepicker();
			  });
			  
		  </script>
		  
		  <div>
			  <h4>통역 일정</h4>

			  <div class="icon">
				  <input type="text" value="<?=DEBUG === false ? my_set_value($row,"interpret_start_date") : "시작날짜테스트" ?>" placeholder="시작 날짜" style="width:49.4%; display:inline-block;" class="email" name="interpret_start_date" id="datepicker1" readonly>
				  <input type="text" value="<?=DEBUG === false ? my_set_value($row,"interpret_end_date") : "종료날자테스트" ?>" placeholder="종료 날짜" style="width:49.5%; display:inline-block;" class="email" name="interpret_end_date" id="datepicker2" readonly>
		  
			  </div>
		  </div>
<br>
		  <div>  
			  <div class="icon">
				  <label class="project_label" for="budget">예산</label>
				  <input type="text" value="<?=DEBUG === false ? my_set_value($row,"budget") : "예산테스트" ?>" class="email" name="budget" id="project_budget">			
			  </div>
				  <ul class="project_form-list">
					  <li>
						  <input class="project_form-list" type="checkbox" name="is_exist_budget" value="0" <?=my_set_checked($row,"is_exist_budget","0")?> id="project_budgetyet">
						  <label for="project_budgetyet">미정</label>
					  </li>
				  </ul>
		  

		  </div>
		  <div style="margin-bottom:1px;">
			  <h4>통역 장비</h4>
  
			  <ul class="project_form-list" style="margin-bottom:1px;">
				  <li>
					  <input type="radio" name="is_need_equiment" value="1" onclick="div_OnOff(this.value,'equip_num');" <?=my_set_checked($row,"is_need_equiment","1",true)?> id="project_want-1">
					  <label for="project_want-1"><?php $equipment="요청"?>요청</label>
				  </li>
					  
				  <li>
					  <input type="radio" name="is_need_equiment" value="0" onclick="div_OnOff(this.value,'equip_num');" <?=my_set_checked($row,"is_need_equiment","0")?> id="project_want-2" checked>
					  <label for="project_want-2"><?php $equipment="미요청"?>미요청</label>
				  </li>
			  </ul>
			  
		  </div>
		  
		  <div id="equip_num" style="display:none; margin-top:1px; margin-bottom:50px;">
			  <h4>장비갯수</h4>
			  <select name="num_equiment">
				  <?php for ( $i = 1 ; $i <= 10 ; $i++ ): ?>
					  <option><?=$i?></option>
				  <?php endfor; ?>
			  </select>
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
		  </script>

		  <div>
			  <h4>통역사 프로필</h4>
  
			  <ul class="project_form-list">
				  <li>
					  <input type="radio" name="is_need_profile" value="1" <?=my_set_checked($row,"is_need_profile","1",true)?> id="project_profile-1" >
					  <label for="project_profile-1">요청</label>
				  </li>
					  
				  <li>
					  <input type="radio" name="is_need_profile" value="0" <?=my_set_checked($row,"is_need_profile","0")?> id="project_profile-2">
					  <label for="project_profile-2">미요청</label>
				  </li>
			  </ul>
		  </div>

		  </div>
		  <?php endif; ?>

		  <?php if ( $type === "번역" ): ?>
		  <script>
			  (function($) {
				  $.fn.goTo = function() {
				  $('html, body').animate({
					  scrollTop: $(this).offset().top + 'px'
				  }, 'fast');
				  return this; // for chaining...
						}
			  })(jQuery);
				  $.datepicker.setDefaults({
				  dateFormat: 'yy-mm-dd',
				  prevText: '이전 달',
				  nextText: '다음 달',
				  monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
				  monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
				  dayNames: ['일', '월', '화', '수', '목', '금', '토'],
				  dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
				  dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				  showMonthAfterYear: true,
				  yearSuffix: '년'
			  });
			  $(function() {
				  $("#datepicker3").datepicker();
			  });
		  </script>
		  <div>
		  <div>
			  <h4>희망 납기일</h4>

			  <div class="icon">
				  <input type="text" value="<?=DEBUG === false ? my_set_value($row,"interpret_pay_date") : "납기일테스트" ?>" placeholder="희망 납기일" class="email" name="interpret_pay_date" id="datepicker3" readonly>
			  </div>
		  </div>

		  </div>

		  <div>
			  <h4>번역 예산</h4>
  
			  <div class="icon" style="margin-bottom:10px;">
				  <input type="text" value="<?=DEBUG === false ? my_set_value($row,"budget") : "예산테스트" ?>" placeholder="1,000원" class="email" name="budget" id="project_budget">			
			  </div>
				  <ul class="project_form-list">
					  <li>
						  <input class="project_form-list" type="checkbox" name="is_exist_budget" value="0" <?=my_set_checked($row,"is_exist_budget","0")?> id="project_budgetyet">
						  <label for="project_budgetyet">미정</label>
					  </li>
				  </ul>
		  
		  </div>

		  <?php endif; ?>


		  <div>
            <div class="icon">
                <label class="project_label" for="project_textarea">요구 사항</label>
                <textarea class="message" name="message" id="project_textarea" ><?=DEBUG === false ? my_set_value($row,"message") : "메세지테스트" ?></textarea>
            </div>
		  </div>
  
		  <div>
			  <ul class="project_form-list">
				  <li>
					  <input type="checkbox" name="is_get_tax_bill" value="1" <?=my_set_checked($row,"is_get_tax_bill","1")?> id="project_checkbox-1">
					  <label for="project_checkbox-1">세금 계산서</label>
				  </li>
  
				  <li>
					  <input type="checkbox" name="is_get_cash_receipt" value="1" <?=my_set_checked($row,"is_get_cash_receipt","1")?> id="project_checkbox-2">
					  <label for="project_checkbox-2">현금 영수증</label>
				  </li>
  
				  <li>
					  <input type="checkbox" name="is_use_confidential" value="1" <?=my_set_checked($row,"is_use_confidential","1")?> id="project_checkbox-3">
					  <label for="project_checkbox-3">기밀 유지</label>
				  </li>
			  </ul>
		  </div>

		  <!--첨부파일폼시작-->
		  <div class="row">
			  <h4>프로젝트 관련 자료</h4>
			  <div class="col s12">
			      <button type="button" onclick="$('#jy-input-file').click();" class="replace">파일 업로드</button>
				  <input id="jy-input-file" multiple="multiple" type="file" name="files[]" style="display:none;" />
				  <!-- <iframe class="iframe_dynamic_height" height="100px;" width="100%" maginwidth="0" marginheight="0" frameborder="0"  scrolling="no"  src="/file/upload" ></iframe>
				  <script  src="/public/subpage/js/000_fileuproad/iframe-dynmic-height.js"></script> -->
			  </div>
		  </div>
		  <!--첨부파일폼 끝-->  
		  <div>
				<input type="submit" value="의뢰하기">
		  </div>
	  </fieldset>
  </form>

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
