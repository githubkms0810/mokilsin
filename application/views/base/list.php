
	<!-- <h2>Hover Rows</h2>
	<p>The .table-hover class enables a hover state on table rows:</p> -->
	<?php if ( count($fieldData) ===0 ): ?>
	<div class="alert alert-danger">
  		<strong>경고 -</strong> <?=$moduleName?>_m에서 listData_base가 정의되지 않았습니다.
	</div>
	<?php endif; ?>

	<?php $i=1; foreach ( $orderByDataList as $key=>$orderByData ):  ?>
		<a  onMouseOver="this.style.color='#666'" style="color:black;" href="<?=my_current_url("orderBy={$key}")?>"><?=$orderByData["displayName"]?></a> 
		<?php if ( count($orderByDataList) !== $i ): ?>
		|
		<?php  endif; ?>
	<?php $i++; endforeach; ?>

    <div class="table-responsive">
	<form <?=$this->ajax_helper->form("/{$moduleName}/deleteRange"," 복구할 방법이없습니다. 선택한 것을 정말 삭제하시겠습니까?")?>>
		<table class="table table-hover">
			<thead>
				<tr>
					
					<?php foreach ( $fieldData as $key=>$data ): ?>
					<th>
						<?=$data["displayName"] ?? ""?>
					</th>
					<?php endforeach; ?>

					
				</tr>
			</thead>
			<tbody>

				<?php foreach ( $rows as $row ): ?>

					<tr class="clickable" data-href="<?=my_site_url("/{$moduleName}/get/{$row->id}")?>" >
						
						<?php foreach ( $fieldData as $key=>$data ): ?>
						
						<td>
							<?=$row->{$data['fieldName']}?>
						</td>
						<?php endforeach; ?>
						
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
		<button type="button" class="btn btn-default clickable" data-href="<?=my_site_url("/{$moduleName}/add")?>">추가</button>
		<br>
	</form>
	<div class="text-center">
			<?=$this->pagination->create_links();?>
	</div>
