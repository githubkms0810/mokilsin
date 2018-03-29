<link type="text/css" media="all" href="/public/mokilsin/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" media="all" href="/public/mokilsin/css/form_style.css" rel="stylesheet">
<link rel="stylesheet" href="/public/mokilsin/css/beautiful.css">
<script src="/public/mokilsin/js/modernizr.js"></script>
<!-- Modernizr -->


<!--// jQuery UI CSS파일-->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />
<!--// jQuery 기본 js파일-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<!--jQuery UI 라이브러리 js파일-->
<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>



<section class="home-hero-project">
    <div class="animated fadeInUp">
        <h2 class="home-hero-title-project">참가신청</h2>
        <p class="home-hero-des-project">
            참가신청페이지
        </p>
    </div>
</section>



<script>
    $(document).ready(function() {
        //init
        $personal_radio = $('input[value=개인]');
        $personal_radio.attr("checked", true);
        Jy.Common.HideAndShow('.jy-group-wapper', '.jy-personal-wapper');

        //개인 라디오 인풋 눌렀을떄 event
        $personal_radio.click(function() {
            $('.jy-group-item').val('');
            Jy.Common.HideAndShow('.jy-group-wapper', '.jy-personal-wapper');
            $('.group_file').attr('name', '');
            $('.personal_file').attr('name', 'files[]');
        });
        //단체 라디오 인풋 눌렀을떄 event
        $group_radio = $('input[value=단체]');
        $group_radio.click(function() {
            $('.jy-personal-item').val('');
            Jy.Common.HideAndShow('.jy-personal-wapper', '.jy-group-wapper');
            $('.personal_file').attr('name', '');
            $('.group_file').attr('name', 'files[]');
        });
    });

</script>
<div class="container" style="margin-top:100px; margin-bottom:100px;">
    <form action="/applicationn/add" method="post" enctype="multipart/form-data" class="project_form floating-labels" style="margin-top:100px; margin-bottom:150px;">
        <input type="hidden" name="동요동시" value="<?=$kind?>">
        <!-- 접수번호 필요없을듯 시작-->
        <div>
            <label class="project_label">접수번호</label>
            <input type="text" name="접수번호">
        </div>
        <!-- 접수번호 필요없을듯 끝-->

        <div>
            <ul class="project_form-list">
                <li>
                    <input type="radio" name="개인단체" value="개인" id="개인">
                    <label for="개인">개인</label>
                </li>
                <li>
                    <input type="radio" name="개인단체" value="단체" id="단체">
                    <label for="단체">단체</label>
                </li>
            </ul>
        </div>




        <!-- 동요시작 -->

        <?php if ( $kind === "동요" ): ?>
        <!-- 동요 공통 시작 -->

        <fieldset>

            <legend>공통</legend>
            <div>
                <label class="project_label">자유곡</label>
                <input class="company" type="text" name="자유곡" value="<?=DEBUG === false ? " ":"자유곡 테스트 "?>">
            </div>
            <div>
                <label class="project_label">지정곡</label>
                <input type="text" name="지정곡" value="<?=DEBUG === false ? " ":"지정곡 테스트 "?>">
            </div>
            <div>
                <label class="project_label">작곡</label>
                <input type="text" name="작곡" value="<?=DEBUG === false ? " ":"작곡 테스트 "?>">
            </div>
            <div>
                <label class="project_label">작사</label>
                <input type="text" name="작사" value="<?=DEBUG === false ? " ":"작사 테스트 "?>">
            </div>
        </fieldset>
        <!-- 동요 공통 끝 -->
        <fieldset>


            <!-- 동요 개인 시작 -->
            <div class="jy-personal-wapper">
                <legend>개인</legend>
                <div>
                    <label class="project_label">성명</label>
                    <input class="jy-personal-item" type="text" name="성명[]" value="<?=DEBUG === false ? " ":"동요개인성명 테스트 "?>">
                </div>

                <div>
                    <ul class="project_form-list">
                        <li>
                            <input type="radio" name="성별[]" value="<?=DEBUG === false ? " ":"동요개인성별 테스트 "?>" id="sex-1" checked>
                            <label for="sex-1">남자</label>
                        </li>
                        <li>
                            <input type="radio" name="성별[]" value="<?=DEBUG === false ? " ":"동요개인성별 테스트 "?>" id="sex-2">
                            <label for="sex-2">여자</label>
                        </li>
                    </ul>
                </div>

                <div>
                    <label class="project_label">학교</label>
                    <input class="jy-personal-item" type="text" name="학교[]" value="<?=DEBUG === false ? " ":"동요개인학교 테스트 "?>">
                </div>

                <div>
                    <label class="project_label">학년</label>
                    <input class="jy-personal-item" type="text" name="학년[]" value="<?=DEBUG === false ? " ":"동요개인학년 테스트 "?>">
                </div>

                <div>
                    <label class="project_label">지역</label>
                    <input type="text" name="지역" value="<?=DEBUG === false ? " ":"동요개인지역 테스트 "?>">
                </div>

                <div>

                    <h4>주소</h4>

                    <input id="sample4_roadAddress" onclick="sample4_execDaumPostcode();" type="text" name="신주소" placeholder="주소" value="<?=DEBUG === false ? " ":"동요개인신주소 테스트 "?>">
                    <input type="hidden" id="sample4_postcode" name="지번" value="<?=DEBUG === false ? " " : "동요개인 지번 테스트 " ?>">
                    <input type="hidden" id="sample4_jibunAddress" name="구주소" value="<?=DEBUG === false ? " ": "동요개인 구주소 테스트 " ?>">

                </div>
                <div style="margin-top:20px;">
                    <label class="project_label">상세 주소</label>
                    <input type="text" name="상세주소" value="<?=DEBUG === false ? " " : "동요개인 상세주소테스트 " ?>">
                    <span id="guide" style="color:#999"></span>
                </div>

                <div>
                    <label class="project_label">학부모 연락처</label>
                    <input type="text" name="학부모연락처" value="<?=DEBUG === false ? " ":"학부모연락처 테스트 "?>">
                </div>

                <div>
                    <label class="project_label">가창지도자 연락처</label>
                    <input type="text" name="가창지도자연락처" value="<?=DEBUG === false ? " ":"가창지도자연락처 테스트 "?>">
                </div>
                <div>
                    <label class="project_label">가창지도자 이메일</label>
                    <input type="text" name="가창지도자이메일" value="<?=DEBUG === false ? " ":"가창지도자이메일 테스트 "?>">
                </div>
                <div>
                    <label class="project_label">가창지도자 주소</label>
                    <input type="text" name="가창지도자주소" value="<?=DEBUG === false ? " ":"가창지도자주소 테스트 "?>">
                </div>
                <div>
                    <h4>자료</h4>
                    <input class="personal_file" type="file" name="files[]">
                </div>
            </div>
            <!-- 동요 개인 끝 -->

            <!-- 동요 단체 시작 -->
            <div class="jy-group-wapper">
                <legend>단체</legend>
                <div>
                    <label class="project_label">중창단명</label>
                    <input type="text" name="중창단명" value="<?=DEBUG === false ? " ":"중창단명 테스트 "?>">
                </div>

                <div>
                    <label class="project_label">총인원</label>
                    <input type="text" name="총인원" value="<?=DEBUG === false ? " ":"총인원 테스트 "?>">
                </div>

                <div>
                    <h4>자료</h4>
                    <input class="group_file" type="file" name="files[]">
                </div>

                <legend>
                    <h4 id="sel_group1">단체 참가자</h4>
                </legend>
                <table class="boardList" id="sel_group" summary="이 표는 목일신 동요대회 참가신청서 입니다. 단체 참가자  성명, 학교명, 학년, 성별, 연락처  등의 정보를 입력하는 표 입니다.">
                    <colgroup>
                        <col width="5%" />
                        <col />
                        <col />
                        <col width="15%" />
                        <col width="10%" />
                        <col />
                    </colgroup>
                    <thead>
                        <tr>
                            <th style="text-align:center;" scope="col"><label for="">연번</label></th>
                            <th style="text-align:center;" scope="col"><label for="pboardlist4">성명</label></th>
                            <th style="text-align:center;" scope="col"><label for="pboardlist5">학교명</label></th>
                            <th style="text-align:center;" scope="col"><label for="pboardlist6">학년</label></th>
                            <th style="text-align:center;" scope="col"><label for="pboardlist7">성별</label></th>
                            <th style="text-align:center;" scope="col"><label for="pboardlist8">연락처</label></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>

                            <tr>
                                <td style="text-align:center;">1</td>
                                <td><input type="text" name="pboardlist[1].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[1].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[1].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[1].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[1].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">2</td>
                                <td><input type="text" name="pboardlist[2].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[2].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[2].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[2].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[2].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">3</td>
                                <td><input type="text" name="pboardlist[3].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[3].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[3].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[3].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[3].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">4</td>
                                <td><input type="text" name="pboardlist[4].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[4].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[4].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[4].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[4].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">5</td>
                                <td><input type="text" name="pboardlist[5].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[5].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[5].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[5].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[5].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">6</td>
                                <td><input type="text" name="pboardlist[6].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[6].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[6].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[6].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[6].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">7</td>
                                <td><input type="text" name="pboardlist[7].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[7].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[7].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[7].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[7].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">8</td>
                                <td><input type="text" name="pboardlist[8].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[8].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[8].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[8].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[8].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">9</td>
                                <td><input type="text" name="pboardlist[9].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[9].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[9].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[9].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[9].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">10</td>
                                <td><input type="text" name="pboardlist[10].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[10].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[10].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[10].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[10].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                    </tbody>
                </table>

            </div>
        </fieldset>

        <!-- 동요 단체 끝 -->
        <div>
            <label class="project_label">신청인</label>
            <input type="text" name="신청인" value="<?=DEBUG === false ? " ":"신청인 테스트 "?>">
        </div>
        <div>
            <button type="submit">신청</button>
        </div>
        <?php endif; ?>
        <!-- 동요끝 -->

        <!-- 동시 시작 -->
        <?php if ( $kind ==="동시" ): ?>


        <fieldset>
            <!-- 동시 공통시작 -->

            <div>
                <legend>공통</legend>

                <div>
                    <label class="project_label">지도교사 및 보호자 연락처</label>
                    <input type="text" name="지도교사및보호자연락처" value="<?=DEBUG === false ? " ":"지도교사및보호자연락처 테스트 "?>">
                </div>

                <div>
                    <label class="project_label">지도교사 및 보호자 성명</label>
                    <input type="text" name="지도교사및보호자성명" value="<?=DEBUG === false ? " ":"지도교사및보호자성명 테스트 "?>">
                </div>
                
            </div>
            <!-- 동시 공통끝 -->
            <!-- 동시 개인시작 -->
            <div class="jy-personal-wapper">
                <legend>개인</legend>
                <div>
                    <label class="project_label">성명</label>
                    <input class="jy-personal-item" type="text" name="성명[]" value="<?=DEBUG === false ? " ":"동시개인성명 테스트 "?>">
                </div>

                <div>
                    <ul class="project_form-list">
                        <li>
                            <input type="radio" name="성별[]" value="<?=DEBUG === false ? " ":"동시개인성별 테스트 "?>" id="sex-1" checked>
                            <label for="sex-1">남자</label>
                        </li>
                        <li>
                            <input type="radio" name="성별[]" value="<?=DEBUG === false ? " ":"동시개인성별 테스트 "?>" id="sex-2">
                            <label for="sex-2">여자</label>
                        </li>
                    </ul>
                </div>

                <div>
                    <label class="project_label">학교</label>
                    <input class="jy-personal-item" type="text" name="학교[]" value="<?=DEBUG === false ? " ":"동시개인학교 테스트 "?>">
                </div>

                <div>
                    <label class="project_label">학년</label>
                    <input class="jy-personal-item" type="text" name="학년[]" value="<?=DEBUG === false ? " ":"동시개인학년 테스트 "?>">
                </div>

                <div>
                    <label class="project_label">반</label>
                    <input class="jy-personal-item" type="text" name="반[]" value="<?=DEBUG === false ? " ":"동시개인반 테스트 "?>">
                </div>

                <div>
                    <label class="project_label">지역</label>
                    <input type="text" name="지역" value="<?=DEBUG === false ? " ":"동시개인지역 테스트 "?>">
                </div>

                <div>

                    <h4>주소</h4>

                    <input id="sample4_roadAddress" onclick="sample4_execDaumPostcode();" type="text" name="신주소" placeholder="주소" value="<?=DEBUG === false ? " ":"동시개인신주소 테스트 "?>">
                    <input type="hidden" id="sample4_postcode" name="지번" value="<?=DEBUG === false ? " " : "동시개인 지번 테스트 " ?>">
                    <input type="hidden" id="sample4_jibunAddress" name="구주소" value="<?=DEBUG === false ? " ": "동시개인 구주소 테스트 " ?>">

                </div>
                <div style="margin-top:20px;">
                    <label class="project_label">상세 주소</label>
                    <input type="text" name="상세주소" value="<?=DEBUG === false ? " " : "동시개인 상세주소테스트 " ?>">
                    <span id="guide" style="color:#999"></span>
                </div>

            </div>
            <!-- 동시 개인끝 -->


        </fieldset>


        <!-- 동시 단체 시작 -->
        <fieldset>



            <div class="jy-group-wapper">
                <legend>
                    단체 참가자
                </legend>

                <table class="boardList" id="sel_group" summary="이 표는 목일신 동시대회 참가신청서 입니다. 단체 참가자  성명, 학교명, 학년, 성별, 연락처  등의 정보를 입력하는 표 입니다.">
                    <colgroup>
                        <col width="5%" />
                        <col />
                        <col />
                        <col width="15%" />
                        <col width="10%" />
                        <col />
                    </colgroup>
                    <thead>
                        <tr>
                            <th style="text-align:center;" scope="col"><label for="">연번</label></th>
                            <th style="text-align:center;" scope="col"><label for="pboardlist4">성명</label></th>
                            <th style="text-align:center;" scope="col"><label for="pboardlist5">학교명</label></th>
                            <th style="text-align:center;" scope="col"><label for="pboardlist6">학년</label></th>
                            <th style="text-align:center;" scope="col"><label for="pboardlist7">성별</label></th>
                            <th style="text-align:center;" scope="col"><label for="pboardlist8">연락처</label></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>

                            <tr>
                                <td style="text-align:center;">1</td>
                                <td><input type="text" name="pboardlist[1].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[1].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[1].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[1].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[1].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">2</td>
                                <td><input type="text" name="pboardlist[2].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[2].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[2].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[2].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[2].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">3</td>
                                <td><input type="text" name="pboardlist[3].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[3].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[3].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[3].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[3].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">4</td>
                                <td><input type="text" name="pboardlist[4].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[4].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[4].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[4].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[4].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">5</td>
                                <td><input type="text" name="pboardlist[5].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[5].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[5].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[5].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[5].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">6</td>
                                <td><input type="text" name="pboardlist[6].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[6].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[6].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[6].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[6].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">7</td>
                                <td><input type="text" name="pboardlist[7].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[7].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[7].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[7].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[7].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">8</td>
                                <td><input type="text" name="pboardlist[8].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[8].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[8].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[8].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[8].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">9</td>
                                <td><input type="text" name="pboardlist[9].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[9].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[9].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[9].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[9].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                            <tr>
                                <td style="text-align:center;">10</td>
                                <td><input type="text" name="pboardlist[10].string1" title="성명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[10].string2" title="학교명" maxlength="30" /></td>
                                <td><input type="text" name="pboardlist[10].string3" title="학년" maxlength="2" onkeydown="onlyNumDecimalInput();" /></td>
                                <td>
                                    <select name="pboardlist[10].string4" title="성별선택">
                                    <option value="">선택</option>
                                    <option value="남">남</option>
                                    <option value="여">여</option>
                                </select>
                                </td>
                                <td><input type="text" name="pboardlist[10].string5" title="연락처" class="" maxlength="13" onkeydown="autoHypen(this);" /></td>
                            </tr>

                    </tbody>
                </table>
            </div>
        </fieldset>
        <!-- 동시 단체 끝 -->
        <div>
            <label class="project_label">신청인</label>
            <input type="text" name="신청인" value="<?=DEBUG === false ? " ":"신청인 테스트 "?>">
        </div>
        <div>
            <button type="submit">신청</button>
        </div>
        <?php endif; ?>
        <!-- 동시 끝 -->
    </form>
</div>


<script src="/public/mokilsin/js/form.js"></script>


<!-- 다음주소시작 -->
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
    //본 예제에서는 도로명 주소 표기 방식에 대한 법령에 따라, 내려오는 데이터를 조합하여 올바른 주소를 구성하는 방법을 설명합니다.
    function sample4_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 도로명 조합형 주소 변수
                if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                    extraRoadAddr += data.bname;
                }
                if (data.buildingName !== '' && data.apartment === 'Y') {
                    extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if (extraRoadAddr !== '') {
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }
                // 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
                if (fullRoadAddr !== '') {
                    fullRoadAddr += extraRoadAddr;
                }
                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('sample4_postcode').value = data.zonecode;
                document.getElementById('sample4_roadAddress').value = fullRoadAddr;
                document.getElementById('sample4_jibunAddress').value = data.jibunAddress;
                if (data.autoRoadAddress) {
                    var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                    document.getElementById('guide').innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';
                } else if (data.autoJibunAddress) {
                    var expJibunAddr = data.autoJibunAddress;
                    document.getElementById('guide').innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';
                } else {
                    document.getElementById('guide').innerHTML = '';
                }
            }
        }).open();
    }

</script>
<!-- 다음주소끝 -->
