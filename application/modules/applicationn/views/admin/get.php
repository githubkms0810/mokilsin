

<table >

    <tr >
        <td style="border: 1px solid #444444; background-color: red">접수번호</td>
        <td><?=$row->접수번호?></td>
    </tr>
    <tr>
        <td rowspan="2">곡명</td>
        <td>예선(자유곡)</td>
        <td><?=$row->자유곡?></td>
        <td>작곡 / 작사</td>
        <td><?=$row->작곡?>/<?=$row->작곡?></td>
    </tr>
    <tr>
        <td>본선(지정곡)</td>
        <td><?=$row->지정곡?></td>
        <td colspan="2">
        *본선 진출시 목일신동요곡 중 1곡 선택 <br>
        *예선참가 신청시 기재하지 않으셔도 됩니다.
        </td>
    </tr>

    <tr>
        <td rowspan="6">독창(가창자)</td>    
        <td>성명</td>
        <td><?=$applicant[0]->성명?></td>
        <td>성별</td>
        <td><?=$applicant[0]->성별?></td>
        <!-- <td rowspan="6">
        <?=isset($files[0]) ?"<a href='http://서버아이피:포트/경로/파일명'><img src='".site_url().$files[0]->directory."' width='200' heigth='100'></a>" : ""?>
        </td>     -->
    </tr>

    <tr>
        <td>학교</td>
        <td><?=$applicant[0]->학교?> 초등학교 <?=$applicant[0]->학년?>년</td>
        <td>지역</td>
        <td><?=$row->지역?></td>
    </tr>
        
    <tr>
        <td></td>    
    </tr>

    <tr>
        <td></td>    
    </tr>

    <tr>
        <td></td>    
    </tr>

    <tr>
        <td></td>    
    </tr>
</table>