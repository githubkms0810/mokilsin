<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-yj5y{background-color:#efefef;border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-eh2d{background-color:#ffffff;border-color:inherit;vertical-align:top}
.tg .tg-3xi5{background-color:#ffffff;border-color:inherit;text-align:center;vertical-align:top}
</style>
<table class="tg" style="undefined;table-layout: fixed; width: 647px">
<colgroup>
<col style="width: 83px">
<col style="width: 39px">
<col style="width: 84px">
<col style="width: 52px">
<col style="width: 117px">
<col style="width: 87px">
<col style="width: 67px">
<col style="width: 118px">
</colgroup>
  <tr>
    <th class="tg-yj5y" rowspan="3">개인참가자</th>
    <th class="tg-yj5y" colspan="2">성명</th>
    <th class="tg-3xi5" colspan="3"><?=$row->개인단체 === "개인" ? $applicant[0]->성명 : ""?></th>
    <th class="tg-yj5y">성별</th>
    <th class="tg-3xi5"><?=$row->개인단체 === "개인" ? $applicant[0]->성별 : ""?></th>
  </tr>
  <tr>
    <td class="tg-yj5y" colspan="2">학교</td>
    <td class="tg-3xi5" colspan="3"><?=$row->개인단체 === "개인" ? $applicant[0]->학교 ."초등학교 ".$applicant[0]->학년."학년 ".$applicant[0]->반."반" : ""?></td>
    <td class="tg-yj5y">지역</td>
    <td class="tg-3xi5"><?=$row->개인단체 === "개인" ? $row->지역 : ""?></td>
  </tr>
  <tr>
    <td class="tg-yj5y" colspan="2">주소</td>
    <td class="tg-3xi5" colspan="5"><?=$row->개인단체 === "개인" ? $row->신주소." ".$row->상세주소 : ""?></td>
  </tr>
  <tr>
    <td class="tg-yj5y" colspan="3">지도교사 및 보호자 연락처</td>
    <td class="tg-3xi5" colspan="3"><?=$row->지도교사및보호자연락처?></td>
    <td class="tg-yj5y">성명</td>
    <td class="tg-3xi5"><?=$row->지도교사및보호자성명?></td>
  </tr>
  <tr>
    <td class="tg-yj5y" rowspan="11">단체참가자(2인이상 참가시 작성)</td>
    <td class="tg-yj5y">연번</td>
    <td class="tg-yj5y">성명</td>
    <td class="tg-yj5y" colspan="2">학교(지역표기)</td>
    <td class="tg-yj5y">학년/반<br></td>
    <td class="tg-yj5y">성별<br></td>
    <td class="tg-yj5y">연락처</td>
  </tr>
  <?php for ( $i = 0 ; $i < 10 ; $i++ ): ?>
  <tr>
    <td class="tg-eh2d"><?=$i+1?></td>
    <td class="tg-eh2d"><?=$row->개인단체 === "단체" ? $applicant[0]->성명 : ""?></td>
    <td class="tg-eh2d" colspan="2"><?=$row->개인단체 === "단체" ? $applicant[0]->학교 : ""?></td>
    <td class="tg-eh2d"><?=$row->개인단체 === "단체" ? $applicant[0]->학년 : ""?> 학년 / <?=$row->개인단체 === "단체" ? $applicant[0]->반 : ""?>반</td>
    <td class="tg-eh2d"><?=$row->개인단체 === "단체" ? $applicant[0]->성별 : ""?></td>
    <td class="tg-eh2d"><?=$row->개인단체 === "단체" ? $applicant[0]->연락처 : ""?></td>
</tr>
  <?php endfor; ?>
 

</table>