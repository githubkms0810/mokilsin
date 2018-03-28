<link type="text/css" media="all" href="/public/mokilsin/css/bootstrap.min.css" rel="stylesheet">





<script>

$(document).ready(function(){
    //init
    $personal_radio=$('input[value=개인]');
    $personal_radio.attr("checked",true);
    Jy.Common.HideAndShow('.jy-group-wapper','.jy-personal-wapper');

    //개인 라디오 인풋 눌렀을떄 event
    $personal_radio.click(function(){
        $('.jy-group-item').val('');
         Jy.Common.HideAndShow('.jy-group-wapper','.jy-personal-wapper');
         $('.group_file').attr('name','');
        $('.personal_file').attr('name','files[]');
    });
    //단체 라디오 인풋 눌렀을떄 event
    $group_radio=$('input[value=단체]');
    $group_radio.click(function(){
        $('.jy-personal-item').val(''); 
        Jy.Common.HideAndShow('.jy-personal-wapper','.jy-group-wapper');
        $('.personal_file').attr('name','');
        $('.group_file').attr('name','files[]');
    });
    //개인으로 체크 끝
});
</script>
<div class="container" style="margin-top:100px; margin-bottom:100px;">
<form action="/applicationn/add" method="post" enctype="multipart/form-data">
    <input type="hidden" name="동요동시" value="<?=$kind?>">
    <!-- 접수번호 필요없을듯 시작-->
    <input type="text" name="접수번호" placeholder="접수번호">
    <!-- 접수번호 필요없을듯 끝-->
    <label for="개인">개인</label>
    <input type="radio" name="개인단체" value="개인" >
    <label for="단체">단체</label>
    <input type="radio" name="개인단체" value="단체">

    <!-- 동요시작 -->
    <?php if ( $kind === "동요" ): ?>
        <!-- 동요 공통 시작 -->
        <div>
            <input type="text" name="자유곡" placeholder="자유곡" value="<?=DEBUG === false ? "":"자유곡 테스트"?>">
            <input type="text" name="지정곡" placeholder="지정곡" value="<?=DEBUG === false ? "":"지정곡 테스트"?>">
            <input type="text" name="작곡" placeholder="작곡" value="<?=DEBUG === false ? "":"작곡 테스트"?>">
            <input type="text" name="작사" placeholder="작사" value="<?=DEBUG === false ? "":"작사 테스트"?>">
        </div>
        <!-- 동요 공통 끝 -->

        <!-- 동요 개인 시작 -->
        <div class="jy-personal-wapper">
            <input class="jy-personal-item" type="text" name="성명[]" placeholder="성명" value="<?=DEBUG === false ? "":"동요개인성명 테스트"?>">
            <input class="jy-personal-item" type="text" name="성별[]" placeholder="성별" value="<?=DEBUG === false ? "":"동요개인성별 테스트"?>">
            <input class="jy-personal-item" type="text" name="학교[]" placeholder="학교" value="<?=DEBUG === false ? "":"동요개인학교 테스트"?>">
            <input class="jy-personal-item" type="text" name="학년[]" placeholder="학년" value="<?=DEBUG === false ? "":"동요개인학년 테스트"?>">
            <input type="text" name="지역" placeholder="지역" value="<?=DEBUG === false ? "":"동요개인지역 테스트"?>">

            <input id="sample4_roadAddress" onclick="sample4_execDaumPostcode();" type="text" name="신주소" placeholder="주소" value="<?=DEBUG === false ? "":"동요개인신주소 테스트"?>">
            <input type="hidden" id="sample4_postcode" name="지번" value="<?=DEBUG === false ? "" : "동요개인 지번 테스트" ?>">
            <input type="hidden" id="sample4_jibunAddress" name="구주소" value="<?=DEBUG === false ? "": "동요개인 구주소 테스트" ?>">
            <input type="text" name="상세주소" placeholder="상세주소"  value="<?=DEBUG === false ? "" : "동요개인 상세주소테스트" ?>">
            <span id="guide" style="color:#999"></span>

            <input type="text" name="학부모연락처" placeholder="학부모연락처" value="<?=DEBUG === false ? "":"학부모연락처 테스트"?>">
            <input type="text" name="가창지도자연락처" placeholder="가창지도자연락처" value="<?=DEBUG === false ? "":"가창지도자연락처 테스트"?>">
            <input type="text" name="가창지도자이메일" placeholder="가창지도자이메일" value="<?=DEBUG === false ? "":"가창지도자이메일 테스트"?>">
            <input type="text" name="가창지도자주소" placeholder="가창지도자주소" value="<?=DEBUG === false ? "":"가창지도자주소 테스트"?>">
            <input class="personal_file" type="file" name="files[]">
        </div>
        <!-- 동요 개인 끝 -->

        <!-- 동요 단체 시작 -->
        <div class="jy-group-wapper">
            <input type="text" name="중창단명" placeholder="중창단명" value="<?=DEBUG === false ? "":"중창단명 테스트"?>">
            <input type="text" name="총인원" placeholder="총인원" value="<?=DEBUG === false ? "":"총인원 테스트"?>">
            <input class="group_file" type="file" name="files[]">
            <?php for ( $i = 0 ; $i < 10 ; $i++ ): ?>
                <input class="jy-group-item" type="text" name="성명[]" placeholder="성명" value="<?=DEBUG === false ? "":"동요단체성명 테스트$i"?>">
                <input class="jy-group-item" type="text" name="학교[]" placeholder="학교" value="<?=DEBUG === false ? "":"동요단체학교 테스트$i"?>">
                <input class="jy-group-item" type="text" name="학년[]" placeholder="학년" value="<?=DEBUG === false ? "":"동요단체학년 테스트$i"?>">
                <input class="jy-group-item" type="text" name="성별[]" placeholder="성별" value="<?=DEBUG === false ? "":"동요단체성별 테스트$i"?>">
            <?php endfor; ?>
        </div>
        <!-- 동요 단체 끝 -->
        <input type="text" name="신청인" placeholder="신청인" value="<?=DEBUG === false ? "":"신청인 테스트"?>">
        <button type="submit">신청</button>
    <?php endif; ?>
    <!-- 동요끝 -->

    <!-- 동시 시작 -->
    <?php if ( $kind ==="동시" ): ?>
        <!-- 동시 개인시작 -->
        <div class="jy-personal-wapper">
            <input class="jy-personal-item" type="text" name="성명[]" placeholder="성명" value="<?=DEBUG === false ? "":"동시개인성명 테스트"?>">
            <input class="jy-personal-item" type="text" name="성별[]" placeholder="성별" value="<?=DEBUG === false ? "":"동시개인성별 테스트"?>">
            <input class="jy-personal-item" type="text" name="학교[]" placeholder="학교" value="<?=DEBUG === false ? "":"동시개인학교 테스트"?>">
            <input class="jy-personal-item" type="text" name="학년[]" placeholder="학년" value="<?=DEBUG === false ? "":"동시개인학년 테스트"?>">
            <input class="jy-personal-item" type="text" name="반[]" placeholder="반" value="<?=DEBUG === false ? "":"동시개인반 테스트"?>">
            <input type="text" name="지역" placeholder="지역" value="<?=DEBUG === false ? "":"동시개인지역 테스트"?>">

            <input id="sample4_roadAddress" onclick="sample4_execDaumPostcode();" type="text" name="신주소" placeholder="주소" value="<?=DEBUG === false ? "":"동시개인신주소 테스트"?>">
            <input type="hidden" id="sample4_postcode" name="지번" value="<?=DEBUG === false ? "" : "동시개인 지번 테스트" ?>">
            <input type="hidden" id="sample4_jibunAddress" name="구주소" value="<?=DEBUG === false ? "": "동시개인 구주소 테스트" ?>">
            <input type="text" name="상세주소" placeholder="상세주소"  value="<?=DEBUG === false ? "" : "동시개인 상세주소테스트" ?>">
            <span id="guide" style="color:#999"></span>
        </div>
        <!-- 동시 개인끝 -->

        <!-- 동시 공통시작 -->
        <div>
            <input type="text" name="지도교사및보호자연락처" placeholder="지도교사및보호자연락처" value="<?=DEBUG === false ? "":"지도교사및보호자연락처 테스트"?>">
            <input type="text" name="지도교사및보호자성명" placeholder="지도교사및보호자성명" value="<?=DEBUG === false ? "":"지도교사및보호자성명 테스트"?>">
        </div>
        <!-- 동시 공통끝 -->

        <!-- 동시 단체 시작 -->
        <div class="jy-group-wapper">
            <?php for ( $i = 0 ; $i < 10 ; $i++ ): ?>
                <input class="jy-group-item" type="text" name="성명[]" placeholder="성명" value="<?=DEBUG === false ? "":"동시단체성명 테스트$i"?>">
                <input class="jy-group-item" type="text" name="학교[]" placeholder="학교" value="<?=DEBUG === false ? "":"동시단체학교 테스트$i"?>">
                <input class="jy-group-item" type="text" name="학년[]" placeholder="학년" value="<?=DEBUG === false ? "":"동시단체학년 테스트$i"?>">
                <input class="jy-group-item" type="text" name="반[]" placeholder="반" value="<?=DEBUG === false ? "":"동시단체반 테스트$i"?>">
                <input class="jy-group-item" type="text" name="성별[]" placeholder="성별" value="<?=DEBUG === false ? "":"동시단체성별 테스트$i"?>">
                <input class="jy-group-item" type="text" name="연락처[]" placeholder="연락처" value="<?=DEBUG === false ? "":"동시단체연락처 테스트$i"?>">
            <?php endfor; ?>
        </div>
        <!-- 동시 단체 끝 -->
        <input type="text" name="신청인" placeholder="신청인" value="<?=DEBUG === false ? "":"신청인 테스트"?>">
        <button type="submit">신청</button>
    <?php endif; ?>
    <!-- 동시 끝 -->
</form>
</div>





<!-- 다음주소시작 -->
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
  //본 예제에서는 도로명 주소 표기 방식에 대한 법령에 따라, 내려오는 데이터를 조합하여 올바른 주소를 구성하는 방법을 설명합니다.
  function sample4_execDaumPostcode() {
	  new daum.Postcode({
		  oncomplete: function(data) {
			  var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
			  var extraRoadAddr = ''; // 도로명 조합형 주소 변수
			  if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){extraRoadAddr += data.bname;}
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
			  document.getElementById('sample4_postcode').value = data.zonecode;
              document.getElementById('sample4_roadAddress').value = fullRoadAddr;document.getElementById('sample4_jibunAddress').value = data.jibunAddress;
              if(data.autoRoadAddress){var expRoadAddr = data.autoRoadAddress + extraRoadAddr;document.getElementById('guide').innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';}else if(data.autoJibunAddress){var expJibunAddr = data.autoJibunAddress;document.getElementById('guide').innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';}else{document.getElementById('guide').innerHTML = '';}
		  }
	  }).open();
  }
</script>
<!-- 다음주소끝 -->