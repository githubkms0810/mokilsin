
	<!-- <h2>Hover Rows</h2>
	<p>The .table-hover class enables a hover state on table rows:</p> -->
	<?php if ( count($fieldData) ===0 ): ?>
	<div class="alert alert-danger">
  		<strong>경고 -</strong> <?=$moduleName?>_m에서 listData_admin가 정의되지 않았습니다.
	</div>
	<?php endif; ?>
	<?php $i=1; foreach ( $orderByDataList as $key=>$orderByData ):  ?>
		<a  onMouseOver="this.style.color='#666'" style="color:black;" href="<?=my_current_url("orderBy={$key}")?>"><?=$orderByData["displayName"]?></a> 
		<?php if ( count($orderByDataList) !== $i ): ?>
		|
		<?php  endif; ?>
	<?php $i++; endforeach; ?>

    <div class="table-responsive">
	<form <?=$this->ajax_helper->form("/admin/{$moduleName}/deleteRange"," 복구할 방법이없습니다. 선택한 것을 정말 삭제하시겠습니까?")?>>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>
						<input  style="height:17px; width:17px;"  type="checkbox" onclick="var $inputs = $('input[name=\'ids[]\']');if(this.checked === true){ $inputs.attr('checked','true'); }else{ $inputs.removeAttr('checked');} ">
					</th>
					<?php foreach ( $fieldData as $key=>$data ): ?>
					<th>
						<?=$data["displayName"] ?? ""?>
					</th>
					<?php endforeach; ?>

					<th>

					</th>
				</tr>
			</thead>
			<tbody>

				<?php foreach ( $rows as $row ): ?>

					<tr class="clickable" data-href="<?=my_site_url("/admin/{$moduleName}/get/{$row->id}")?>" >
						<td class="unclickable">
							<input style="height:17px; width:17px;" type="checkbox" name="ids[]" value="<?=$row->id?>">
						</td>
						<?php foreach ( $fieldData as $key=>$data ): ?>
						
						<td>
							<?=$row->{$data['fieldName']}?>
						</td>
						<?php endforeach; ?>
						<td class="unclickable ">
							<!-- <button type="button"class="btn btn-default clickable "style="height:30px; padding-top:4px;" data-href="<?=my_site_url("/admin/{$moduleName}/update/{$row->id}")?>">수정</button> -->
							<!-- <button type="button" style="height:30px; padding-top:4px;" class="btn btn-default " <?=$this->ajax_helper->anchor("/admin/{$moduleName}/display/{$row->id}")?> >보이기</button> -->
							<!-- <button type="button" style="height:30px; padding-top:4px;" class="btn btn-default " <?=$this->ajax_helper->anchor("/admin/{$moduleName}/noDisplay/{$row->id}")?> >안보이기</button> -->
							<!-- <button type="button" style="height:30px; padding-top:4px;" class="btn btn-default " <?=$this->ajax_helper->anchor("/admin/{$moduleName}/delete/{$row->id}","복구할 방법이 없습니다. 정말 삭제하시겠습니까?")?> >삭제</button> -->
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
		<br>
	</form>
	<div class="text-center">
			<?=$this->pagination->create_links();?>
	</div>
