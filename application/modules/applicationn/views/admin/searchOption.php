
<br>

<table class="table table-bordered" >
    <tbody>
        <tr>
            <td class="jy-td-name jy-line-height">동요/동시</td>
            <td colspan="2">
                <input type="hidden" name="searchKeyOption[]" value="applicationn.동요동시">
                <select class="form-control" name="searchValueOption[]" id="">
                        <option value ="">선택</option>
                        <option <?=set_select("searchValueOption[0]","동요")?>>동요</option>
                        <option <?=set_select("searchValueOption[0]","동시")?>>동시</option>
                </select>

            </td>
        </tr>

        <tr>
            <td class="jy-td-name jy-line-height">개인/단체</td>
            <td colspan="2">
                <input type="hidden" name="searchKeyOption[]" value="applicationn.개인단체">
                <select class="form-control" name="searchValueOption[]" id="">
                        <option value ="">선택</option>
                        <option <?=set_select("searchValueOption[1]","개인")?>>개인</option>
                        <option <?=set_select("searchValueOption[1]","단체")?>>단체</option>
                        <option <?=set_select("searchValueOption[1]","독창")?>>독창</option>
                        <option <?=set_select("searchValueOption[1]","중창")?>>중창</option>
                </select>
            </td>
        </tr>

    </tbody>
</table>


