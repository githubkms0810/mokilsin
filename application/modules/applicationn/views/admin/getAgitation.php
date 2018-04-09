<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-yj5y{background-color:#efefef;border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-3xi5{background-color:#ffffff;border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-n2ye{background-color:#efefef;color:#333333;border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-ncgp{background-color:#ffffff;color:#333333;border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-3we0{background-color:#ffffff;vertical-align:top}
</style>
<table class="tg">
  <tr>
    <th class="tg-yj5y" rowspan="2">곡명</th>
    <th class="tg-yj5y" colspan="2">예선(자유곡)</th>
    <th class="tg-3xi5"><?=$row->자유곡?></th>
    <th class="tg-yj5y" colspan="2">작사/작곡</th>
    <th class="tg-3xi5" colspan="2"><?=$row->작사?>/<?=$row->작곡?></th>
  </tr>
  <tr>
    <td class="tg-yj5y" colspan="2">반주자</td>
    <td class="tg-3xi5"><?=$row->지정곡?></td>
    <td class="tg-yj5y" colspan="4">*본선 진출시 목일신동요곡 중 1곡 선택<br>*예선참가 신청시 기재하지 않으셔도 됩니다.</td>
  </tr>
  <?php if ( $row->개인단체 === "독창" ): ?>
  <tr>
    <td class="tg-yj5y" rowspan="7">독창</td>
    <td class="tg-yj5y" colspan="2">성명</td>
    <td class="tg-3xi5"><?=$applicant[0]->성명?></td>
    <td class="tg-yj5y">성별</td>
    <td class="tg-3xi5"><?=$applicant[0]->성별?></td>
    <td class="tg-3xi5" colspan="2" rowspan="7">파일리스트는 아래에</td>

  </tr>
  <tr>
    <td class="tg-yj5y" colspan="2">학교</td>
    <td class="tg-3xi5"><?=$applicant[0]->학교?></td>
    <td class="tg-yj5y">지역</td>
    <td class="tg-3xi5"><?=$row->지역?></td>
  </tr>
  <tr>
    <td class="tg-yj5y" colspan="2">주소</td>
    <td class="tg-3xi5" colspan="3"><?=$row->신주소?> <?=$row->상세주소?></td>
  </tr>
  <tr>
    <td class="tg-yj5y" colspan="2">학부모 연락처</td>
    <td class="tg-3xi5" colspan="3"><?=$row->학부모연락처?></td>
  </tr>
  <?php elseif($row->개인단체 === "중창"):?>
    <tr>
      <td class="tg-yj5y" rowspan="7">독창</td>
      <td class="tg-yj5y" colspan="2">성명</td>
      <td class="tg-3xi5"></td>
      <td class="tg-yj5y">성별</td>
      <td class="tg-3xi5"></td>
      <td class="tg-3xi5" colspan="2" rowspan="7">파일리스트는 아래에</td>
  
    
  

    </tr>
    <tr>
      <td class="tg-yj5y" colspan="2">학교</td>
      <td class="tg-3xi5"></td>
      <td class="tg-yj5y">지역</td>
      <td class="tg-3xi5"><?=$row->지역?></td>
    </tr>
    <tr>
      <td class="tg-yj5y" colspan="2">주소</td>
      <td class="tg-3xi5" colspan="3"></td>
    </tr>
    <tr>
      <td class="tg-yj5y" colspan="2">학부모 연락처</td>
      <td class="tg-3xi5" colspan="3"></td>
    </tr>
  <?php endif;?>
  <tr>
    <td class="tg-n2ye" colspan="2" rowspan="3">가창지도자</td>
    <td class="tg-n2ye">연락처</td>
    <td class="tg-ncgp" colspan="2"><?=$row->가창지도자연락처?></td>
  </tr>
  <tr>
    <td class="tg-yj5y">E-Mail</td>
    <td class="tg-3xi5" colspan="2"><?=$row->가창지도자이메일?></td>
  </tr>
  <tr>
    <td class="tg-yj5y">주소</td>
    <td class="tg-3xi5" colspan="2"><?=$row->가창지도자주소?></td>
  </tr>
  <tr>
    <td class="tg-yj5y" rowspan="12">중창(가창자)</td>
    <td class="tg-yj5y" colspan="2">중창단명(팀명)</td>
    <td class="tg-3xi5"><?=$row->중창단명?></td>
    <td class="tg-yj5y">총인원</td>
    <td class="tg-3xi5"><?=$row->총인원?>명</td>
    <td class="tg-3xi5" colspan="2" rowspan="12">파일리스트는 아래에</td>
  </tr>
 
  <tr>
    <td class="tg-yj5y">연번</td>
    <td class="tg-yj5y">성명</td>
    <td class="tg-yj5y">학교(지역표기)</td>
    <td class="tg-yj5y">학년</td>
    <td class="tg-yj5y">성별</td>
  </tr>
  <?php if ( $row->개인단체 === "독창" ): ?>
  <?php for ( $i = 0 ; $i < 10 ; $i++ ): ?>
  <tr>
    <td class="tg-3xi5"></td>
    <td class="tg-3xi5"></td>
    <td class="tg-3xi5"></td>
    <td class="tg-3xi5"></td>
    <td class="tg-3xi5"></td>
  </tr>
  <?php endfor; ?>

  <?php elseif($row->개인단체 === "중창") : ?>
  <?php for ( $i = 0 ; $i < 10 ; $i++ ): ?>
    <?php if ( isset($applicant[$i]) ): ?>
  <tr>
      
    
    <td class="tg-3xi5"><?=$i+1?></td>
    <td class="tg-3xi5"><?=$applicant[$i]->성명?></td>
    <td class="tg-3xi5"><?=$applicant[$i]->학교?></td>
    <td class="tg-3xi5"><?=$applicant[$i]->학년?></td>
    <td class="tg-3xi5"><?=$applicant[$i]->성별?></td>
  </tr>
    <?php else : ?>
      <tr>
      <td class="tg-3xi5"></td>
      <td class="tg-3xi5"></td>
      <td class="tg-3xi5"></td>
      <td class="tg-3xi5"></td>
      <td class="tg-3xi5"></td>
    </tr>
    <?php endif; ?>
  <?php endfor; ?>
  <?php endif; ?>

</table>

<hr/>

<div class="row">
    <div class="col-sm-12"><h2>첨부파일 리스트</h2></div>
</div>
<?php foreach ( $files as $file ): ?>
<div class="row">
    <div class="col-sm-12">
    <h4 style="display:inline-block"><a href="<?=site_url()?>download/<?=$file->id?>"><?=$file->original_name?></a></h4>
    </div>
</div>
<?php endforeach; ?>

<hr/>