<table  class="tg"  border ="1">
<tr style="background-color:#d9e1f2">
  <th class="tg-agg0"></th>
  <th class="tg-agg0">성명</th>
  <th class="tg-agg0">지역</th>
  <th class="tg-agg0">학교</th>
  <th class="tg-agg0">학년</th>
    <th class="tg-agg0">반</th>
    <th class="tg-agg0">성별</th>
      <th class="tg-agg0">지도자 성명</th>
      <th class="tg-agg0">지도자 연락처</th>
</tr>
<?php $i=0; foreach ( $rows as $key=>$row ): ?>
  <tr>
      <td style="text-align:center; font-size:20px; padding:5 20;  background-color:#d9e1f2" class="tg-agg0"><?=$i+1?></td>
      <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성명)[0] ?? ""?></td>
      <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=$row->지역 ?? ""?></td>
      <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->학교)[0] ?? ""?></td>
      <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->학년)[0] ?? ""?></td>
      <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->반)[0] ?? ""?></td>
      <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성별)[0] ?? ""?></td>
        <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=$row->지도교사및보호자성명 ?? ""?></td>
        <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=$row->지도교사및보호자연락처 ?? ""?></td>
  </tr>
<?php $i++;endforeach; ?>
</table>