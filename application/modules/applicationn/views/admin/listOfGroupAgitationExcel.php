<table  class="tg"  border ="1">
  <tr style="background-color:#d9e1f2">
    <th class="tg-agg0"></th>
    <th class="tg-agg0">중창단명</th>
      <th class="tg-agg0">총인원</th>
    <th class="tg-agg0">지도자 성명</th>
    <th class="tg-agg0">지도자 연락처</th>
      <th class="tg-agg0">지도자 e-mail</th>
      <th class="tg-agg0">지도자 주소</th>
      <th class="tg-agg0">곡명</th>
    <th class="tg-agg0">반주자</th>
    <th class="tg-agg0">단체 성명</th>
  </tr>
  <?php $i=0; foreach ( $rows as $key=>$row ): ?>
    <tr>
        <td rowspan="12" style="text-align:center; font-size:20px; padding:5 20;  background-color:#d9e1f2" class="tg-agg0"><?=$i+1?></td>
        <td rowspan="12" style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=$row->중창단명?></td>
        <td rowspan="12" style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=$row->총인원?></td>
        <td rowspan="12" style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=$row->지도교사및보호자성명?></td>
        <td rowspan="12" style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=$row->가창지도자연락처?></td>
        <td rowspan="12" style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=$row->가창지도자이메일 ?? ""?></td>
        <td rowspan="12" style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=$row->가창지도자주소 ?? ""?></td>        
        <td rowspan="12" style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=$row->자유곡 ?? ""?></td>
        <td rowspan="12" style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=$row->지정곡 ?? ""?></td>
        <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성명)[0] ?? ""?></td></tr>
        <tr>
        <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성명)[1] ?? ""?></td></tr>
        <tr>
            <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성명)[2] ?? ""?></td></tr>
        <tr>
            <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성명)[3] ?? ""?></td></tr>
        <tr>
            <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성명)[4] ?? ""?></td></tr>
        <tr>
            <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성명)[5] ?? ""?></td></tr>
        <tr>
            <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성명)[6] ?? ""?></td></tr>
        <tr>
            <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성명)[7] ?? ""?></td></tr>
        <tr>
            <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성명)[8] ?? ""?></td></tr>
        <tr>
            <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성명)[9] ?? ""?></td></tr>
        <tr>
            <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성명)[10] ?? ""?></td></tr>
        <tr>
            <td style="text-align:center; font-size:20px; padding:5 20; " class="tg-yw4l"><?=splitWithComma($row->성명)[11] ?? ""?></td></tr>

  <?php $i++;endforeach; ?>
</table>