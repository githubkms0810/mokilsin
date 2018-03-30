
<link rel="stylesheet" href="/public/css/jy.css">


<table class="table table-bordered">
    <tbody>
    <?php $i=0; foreach ( $row as $key=>$value ): if($i >= 4) break;?>
        
        <tr>
            <td class="jy-td-name"><?=$key?></td>
            <td colspan="8"><?=$value?></td>
        </tr>
    <?php $i++;  endforeach; ?>
                    
    <?php if ( $row->개인단체 === "개인" ): ?>
        <?php $i=0; foreach ( $row as $key=>$value ): if($i >= 9) break;?>
            
            <tr>
                <td class="jy-td-name"><?=$key?></td>
                <td colspan="8"><?=$value?></td>
            </tr>
        <?php $i++; if($i <= 3 ) continue; endforeach; ?>
    <?php endif; ?>                    
    </tbody>
</table>
