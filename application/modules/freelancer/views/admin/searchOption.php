<link rel="stylesheet" href="/public/css/jy.css">

<table class="table table-bordered" >
    <tbody>
        <tr>
            <td class="jy-td-name jy-line-height">통역/번역</td>
            <td colspan="2">
                <input type="hidden" name="searchKeyOption[]" value="freelancer.apply_field">
                <select class="form-control" name="searchValueOption[]" id="">
                        <option value ="">선택</option>
                        <option <?=set_select("searchValueOption[0]","통역")?>>통역</option>
                        <option <?=set_select("searchValueOption[0]","번역")?>>번역</option>
                </select>

            </td>
        </tr>

        <tr>
            <td class="jy-td-name jy-line-height">성별</td>
            <td colspan="2">
                <input type="hidden" name="searchKeyOption[]" value="freelancer.sex">
                <select class="form-control" name="searchValueOption[]" id="">
                        <option value ="">선택</option>
                        <option <?=set_select("searchValueOption[1]","남성")?>>남성</option>
                        <option <?=set_select("searchValueOption[1]","여성")?>>여성</option>
                </select>
            </td>
        </tr>

        
        <tr>
            <td class="jy-td-name jy-line-height">분야상세</td>
            <td colspan="2">
                <input type="hidden" name="searchKeyOption[]" value="freelancer_translation_field.field_detail">
                <input type="text" name="searchValueOption[]" value="<?=set_value("searchValueOption[2]")?>">
            </td>
        </tr>

        <tr>
            <td class="jy-td-name jy-line-height">언어방향</td>
            <td colspan="2">
                <input type="hidden" name="searchKeyOption[]" value="freelancer.translation_direction">
               
                <select class="form-control" name="searchValueOption[]" id="">
                        <option value ="">선택</option>
                        <option <?=set_select("searchValueOption[3]","외국어->한국어")?>>외국어->한국어</option>
                        <option <?=set_select("searchValueOption[3]","한국어->외국어")?>>한국어->외국어</option>
                        <option <?=set_select("searchValueOption[3]","외국어<->한국어")?>>외국어<->한국어</option>
                </select>
            </td>

            <td class="jy-td-name jy-line-height">언어</td>
            <td colspan="2">
                <input type="hidden" name="searchKeyOption[]" value="freelancer_translation_language.languages">
               
                <select class="form-control" name="searchValueOption[]" id="">
                    <option value ="">선택</option>
                    <?php foreach ( $languages as $language ): ?>
                        <option <?=set_select("searchValueOption[4]",$language)?>><?=$language?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>


        <tr>
            <td class="jy-td-name jy-line-height">대학</td>
            <td colspan="2">
            <input type="hidden" name="searchKeyOption[]" value="freelancer.university">
          
            <input type="text" name="searchValueOption[]" value="<?=set_value("searchValueOption[5]")?>">
        
            </td>
            <td class="jy-td-name jy-line-height">전공</td>
            <td colspan="2">
                <input type="hidden" name="searchKeyOption[]" value="freelancer.university_major">
                <input type="text" name="searchValueOption[]" value="<?=set_value("searchValueOption[6]")?>">
            </td>
        </tr>

        <tr>
            <td class="jy-td-name jy-line-height">대학원</td>
            <td colspan="2">
                <input type="hidden" name="searchKeyOption[]" value="freelancer.graduate_school">
                <input type="text" name="searchValueOption[]" value="<?=set_value("searchValueOption[7]")?>">
            </td>
            <td class="jy-td-name jy-line-height">학위</td>
            <td colspan="2">
                <input type="hidden" name="searchKeyOption[]" value="freelancer.graduate_school_degree">
                <input type="text" name="searchValueOption[]" value="<?=set_value("searchValueOption[8]")?>">
            </td>

            <td class="jy-td-name jy-line-height">전공</td>
            <td colspan="2">
                <input type="hidden" name="searchKeyOption[]" value="freelancer.graduate_school_major">
                <input type="text" name="searchValueOption[]" value="<?=set_value("searchValueOption[9]")?>">
            </td>
        </tr>

        <tr>
            <td class="jy-td-name jy-line-height">관리자 점수</td>
            <td colspan="2">
                <input type="hidden" name="searchKeyOption[]" value="freelancer.admin_score">
                <input type="text" name="searchValueOption[]" value="<?=set_value("searchValueOption[10]")?>">
            </td>
            <td class="jy-td-name jy-line-height">관리자 메모</td>
            <td colspan="2">
                <input type="hidden" name="searchKeyOption[]" value="freelancer.admin_memo">
                <input type="text" name="searchValueOption[]" value="<?=set_value("searchValueOption[11]")?>">
            </td>
        </tr>

    </tbody>
</table>




