<!--안쓰는폼-->

<link rel="stylesheet" type="text/css" media="all" href="/public/subpage/css/004_freesupport/form_styles.css">
  <link rel="stylesheet" type="text/css" media="all" href="/public/subpage/css/004_freesupport/form_switchery.min.css">
  <script type="text/javascript" src="/public/subpage/js/004_freesupport/form_switchery.min.js"></script>
  <script type="text/javascript" src="/public/subpage/js/004_freesupport/jquery.js"></script>

<!--프리랜서지원폼 시작-->
<section class="home-hero-freelancer">
    <h2 class="home-hero-title-freelancer">프리랜서 지원하기</h2>
    <p class="home-hero-des-freelancer">
        코리아 통번역 센터와 함께<br>
        더 좋은 번역 산업의 미래를 만들어가고 싶으시다면<br>
        아래 지원서를 작성해주세요
    </p>
    <a href="/translation_order/list" class="home-btn">포트폴리오 보러가기</a>
</section>
<div id="free_wrapper">
	<form action="/freelancer/add" method="post" class="freesupport" onsubmit="" style="max-width: 1024px; margin: 0 auto;" enctype="multipart/form-data">
	<div class="free_col-2">
	  <label style="padding: 20px 20px 10px; margin-top:2px;">
		이름
		<input required name="name" value="<?=DEBUG === false ? set_value('name') : "이름테스트"?>" placeholder="What is your full name?" id="free_name" tabindex="1" style="width: 100%;">
		<?=form_error("name")?>
		</label>
	</div>
	<div class="free_col-2">
	  <label style="padding: 20px 20px 23px;">
		생년월일</br>
		<select  name="birth_year" tabindex="2" style="width: 50%;">
			<option value="">연도</option>
			<option  <?=DEBUG === false ? set_select("birth_year","1939") : "selected"?>>1939</option>
			<option  <?=set_select("birth_year","1940")?>>1940</option>
			</select>
			
		  <select name="birth_month" tabindex="3" style="width: 24%;">
			<option value="">월</option>
			<?php for ( $i = 1 ; $i <=12 ; $i++ ): ?>
					<option <?=DEBUG === false ? set_select("birth_month",$i) : "selected"?>><?=$i?></option>
			<?php endfor; ?>
			</select>
			
		  <select name="birth_day" tabindex="4" style="width: 24%;">
			<option value="">일</option>
			<?php for ( $i = 1 ; $i <=31 ; $i++ ): ?>
				<option <?=DEBUG === false ? set_select("birth_day",$i) : "selected"?>><?=$i?></option>
			<?php endfor; ?>
		  </select>
	  </label>
	</div>



	<div class="free_col-3">
		<label for="" style="padding: 20px 20px 14px;">성별
			<ul class="free_form-list" style="margin-bottom:11px">
	    	<li>
		  		<input type="radio" name="sex" value="남성" <?=set_checkbox("sex","남성",true)?> id="free_radio_sex1" >
		  		<label for="free_radio_sex1">남성</label>
		  	</li>
				<li>
		  			<input type="radio" name="sex" value="여성" <?=set_checkbox("sex","여성")?> id="free_radio_sex2">
		  			<label for="free_radio_sex2">여성</label>
				</li>
			</ul>
		</label>
	  </div>	
	<div class="free_col-3">
	  <label style="padding: 20px 20px 11px;">
		전화번호
		<?=form_error_one_of_multiple(["phone_first","phone_second","phone_third"])?>
	</br>
		<select  name="phone_first" tabindex="5" style="width: 30%;">
			<option <?=set_select("phone_first","010")?> value="010">010</option>
			<option <?=set_select("phone_first","011")?> value="011">011</option>
			<option <?=set_select("phone_first","019")?> value="019">019</option>
		  </select>
		<input required name="phone_second" value="<?=DEBUG === false ? set_value("phone_second") : "1234"?>"placeholder="1234" id="free_phone" tabindex="6" style="width: 33%;">
		<input  required name="phone_third" value="<?=DEBUG === false ? set_value("phone_third") : "5125"?>" placeholder="5678" id="free_phone"  tabindex="7" style="width: 33%;">
	  </label>
	</div>
	<div class="free_col-3">
	  <label style="padding: 20px 20px 11px;">
		Email<br/>
		<input name="email_first" value="<?=DEBUG === false ? set_value("email_first") : "emailtestr"?>" placeholder="your id" id="free_email" tabindex="8" style="width: 50%;">
		@
		<select name="email_second" tabindex="9" style="width: 40%;">
			<option value="naver.com" <?=set_select("email_second","naver.com")?>>naver.com</option>
			<option value="gmail.com" <?=set_select("email_second","gmail.com")?>>gmail.com</option>
			<option value="daum.net" <?=set_select("email_second","daum.net")?>>daum.net</option>
		  </select>
	</label>
	</div>



	<div class="free_col-3">
		<label style="padding: 20px 20px 10px;">
			주소
			<?=form_error_one_of_multiple(["address","address_detail"])?>
		</br>
		<input type="hidden" id="sample4_postcode" name="post_number" value="<?=DEBUG === false ? set_value("post_number"): "지번테스트" ?>">
		<input type="hidden" id="sample4_jibunAddress" name="old_address" value="<?=DEBUG === false ? set_value("old_address"): "구주소 테스트" ?>">

		  <input  required id="sample4_roadAddress" name="new_address" value="<?=DEBUG === false ? set_value("new_address") : "주소테스트"?>" placeholder="주소" readonly id="free_address" tabindex="10" style="width: 70%;">
		  <button type="button" onclick="sample4_execDaumPostcode(); return false;" style="width:25%;">찾기</button>
		  <input required name="address_detail" value="<?=DEBUG === false ? set_value("address_detail") : "상세주소테스트"?>" placeholder="상세 주소" id="free_address" tabindex="11">		  
		</label>
	  </div>
	<div class="free_col-3">
		<label for="" style="padding: 20px 20px 10px;">지원 분야
		<?=form_error("apply_field")?>		
	</br></br>
			<ul class="free_form-list" style="margin-bottom:14px">
			<!-- 		<center style="padding-bottom:10px; position:relative; margin-bottom:9px;">
<input name="" type="checkbox" class="free_js-switch" style="width: 100%;"> -->
				<li>
					<input type="radio" name="apply_field" value="번역" <?=set_checkbox("apply_field","번역",true)?> id="free_radio_apply1">
					<label for="free_radio_apply1">번역</label>
				</li>
				<li>
					<input type="radio" name="apply_field" value="통역" <?=set_checkbox("apply_field","통역")?> id="free_radio_apply2">
		  		<label for="free_radio_apply2">통역</label>
				</li>
			</ul>
		</label>
		</div>

	<div class="free_col-3">
		<label style="padding: 20px 20px 10px;">
			계좌정보
			<?=form_error_one_of_multiple(["account_bank","account_number","account_name"])?>
		</br></br>
		  <select required name="account_bank" tabindex="11" style="width: 23%;" >
			  <option value="">은행</option>
			  <option value="신한" <?=DEBUG === false ? set_select("account_bank","신한") : "selected"?>>신한</option>
			  <option value="국민" <?=set_select("account_bank","국민")?>>국민</option>
			</select>
		  <input required name="account_number" value="<?=DEBUG === false ? set_value("account_number") : "1245967"?>" placeholder="계좌번호" id="free_phone" name="free_phone" tabindex="12" style="width: 50%;">
		  <input required name="account_name" value="<?=DEBUG === false ? set_value("account_name") : "예금주테스트"?>" placeholder="예금주" id="free_phone" name="free_phone" tabindex="13" style="width:23%;">
		</label>
		</div>



	  <div class="free_col-2">
		<label style="padding: 20px 20px 20px;">
			사용 언어
			<?=form_error("languages[]")?>
			<ul class="free_form-list">
				<?php $i=1; foreach ( $languages as $language ): ?>
					<!--재윤:: 목록 많아지면 겹치는 현상 발생해서 li태그에 style margin-top 값 줌-->
					<li style="margin-top: 20px;">
					<input type="checkbox" name="languages[]" value="<?=$language?>" <?=DEBUG === false ? set_checkbox("languages[]",$language) : "checked"?> id="free_checkbox-<?=$i?>">
					<label for="free_checkbox-<?=$i?>"><?=$language?></label>
				</li>
				<?php $i++; endforeach; ?>
		
			</ul>
		  <!-- <input name="" placeholder="What is your full name?" id="free_name" name="free_name" tabindex="1" style="width: 100%;"> -->
		</label>

	  </div>
	  <div class="free_col-2">
		<label for="" style="padding: 20px 20px 20px;">
			언어 방향
		<?=form_error("translation_direction")?>
		</br>
		  <ul class="free_form-list" style="margin-bottom:0px">
		<li>
		  <input type="radio" name="translation_direction" value="외국어->한국어" <?=set_checkbox("translation_direction","외국어->한국어")?> checked id="free_radio_1" style="width:33%">
		  <label for="free_radio_1">외국어->한국어</label>
		  </li>
		<li>
		  <input type="radio" name="translation_direction" value="한국어->외국어" <?=set_checkbox("translation_direction","한국어->외국어")?> id="free_radio_2" style="width:33%">
		  <label for="free_radio_2">한국어->외국어</label>
		</li>
		<li>
		  <input type="radio" name="translation_direction" value="외국어<->한국어" <?=set_checkbox("translation_direction","외국어<->한국어")?> id="free_radio_3" style="width:33%">
		  <label for="free_radio_3">외국어<->한국어</label>
		</li>
	</ul>
		</label>
	  </div>
	  <div class="free_col-3">
			<label style="padding: 20px 20px 10px;">재직유무</label>
			<center style="padding-botto	m:10px; position:relative; margin-bottom:9px;">
				<input type="checkbox" name="is_employed" value="1" <?=DEBUG === false ? set_checkbox("is_employed","1") : "checked"?> class="free_js-switch" style="width: 100%;">
			</center>
		  </div>

	  <div class="free_col-3">
			<label style="padding: 20px 20px 10px;">학력 사항</br>
			<label>대학교</br>
			<input name="university" value="<?=DEBUG === false ? set_value("university") : "대학교이름 테스트"?>" placeholder="학교명"  id="free_schoolname" tabindex="1" style="width: 63%;">
			<input name="university_major" value="<?=DEBUG === false ? set_value("university_major") : "대학교전공 테스트"?>" placeholder="전공명" id="free_subname" tabindex="1" style="width: 33%;">
			</label>
			</label>
	  </div>
	  <div class="free_col-3">
			<label style="padding: 20px 20px 10px;">대학원</br>
			<input name="graduate_school" value="<?=DEBUG === false ? set_value("graduate_school") : "대학원이름 테스트"?>" placeholder="학교명" id="free_schoolname"  tabindex="1" style="width: 40%;">
			<select name="graduate_school_degree" tabindex="2" style="width: 23%;">
					<option value="석사" <?=set_select("graduate_school_degree","석사")?>>석사</option>
					<option value="박사" <?=set_select("graduate_school_degree","박사")?>>박사</option>
			</select>			
			<input name="graduate_school_major" value="<?=DEBUG === false ? set_value("graduate_school_major") : "대학원전공명테스트"?>" placeholder="전공명" id="free_subname" tabindex="1" style="width: 33%;">
			</label>
	  </div>

	  <div class="free_col-2">
			<label style="padding: 20px 20px 10px;">
				<!-- 파일업로드 폼 적용하려다 이상한거같아서 주석처리 해놈 시작-->
				<!-- <iframe class="iframe_dynamic_height" height="100px;" width="100%" maginwidth="0" marginheight="0" frameborder="0"  scrolling="no"  src="/file/upload" ></iframe>
					<script  src="/public/subpage/js/000_fileuproad/iframe-dynmic-height.js"></script> -->
					<!-- 파일업로드 폼 적용하려다 이상한거같아서 주석처리 해놈 끝-->
				첨부파일</br>
				<input type="file" name="files[]" multiple="multiple">
			  <!-- <input placeholder="파일명" readonly id="free_file" name="free_file" tabindex="1" style="width: 80%;"> -->
			  <!-- <button type="button" style="width:15%;">첨부하기</button> -->
			</label>
		  </div>
		  <div class="free_col-2">
			<!-- <label style="padding: 20px 20px 10px;">
				<input placeholder="파일명.jpg" id="free_filelist" name="free_filelist" tabindex="1" style="width: 80%;">
				<button type="button" style="width:20%;">삭제하기</button>
			</label> -->
		  </div>
	
	<div class="free_col-submit">
	  <button type="submit" class="free_submitbtn">Submit Form</button>
	</div>
	
	</form>
	</div>
  <script type="text/javascript">
  var elems = Array.prototype.slice.call(document.querySelectorAll('.free_js-switch'));
  
  elems.forEach(function(html) {
	var switchery = new Switchery(html);
  });
  </script>
<!--프리랜서지원폼 끝-->  
<script>
		$("button[type='submit']").click(function(){
			var $fileUpload = $("input[type='file']");
			if (parseInt($fileUpload.get(0).files.length)>5){
			alert("파일은 5개이하만 업로드 할 수 있습니다.");
			event.preventDefault();
			return false;
			}
	});    
</script>
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
