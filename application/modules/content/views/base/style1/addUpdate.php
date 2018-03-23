
<form <?=$this->ajax_helper->multipart("/{$moduleName}/$mode")?>>
	<div class="form-group">
		<label>제목</label>
		<input type="text" class="form-control" name="title" value="<?=my_set_value($row,"title")?>" autofocus>
	</div>

	<div id="editor"></div>
	<input type="hidden" name="desc" value='<?=my_set_value($row,"desc")?>'>
	<br>
	<div class="form-group">
		<input multiple="multiple" type="file" name="files[]" />
	</div>
	<?php if ( strpos($mode,"update") >-1 ): ?>
	<div>업로드된 파일</div>
		<?php foreach ( $files as $file ): ?>
		<div>
			<?=$file->original_name?>
			<a <?=$this->ajax_helper->anchor(site_url("file/delete/{$file->id}?content_id={$row->id}"),"복구할 방법이 없습니다. 정말 삭제하시겠습니까?")?>>삭제</a>
		</div>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php if ( $this->userstate->isGuest() === true && $mode === "add" ): ?>
	<input type="hidden" name="is_guest" value="true">
	<div class="form-group">
		<label>아이디</label>
		<input type="text" class="form-control" name="guest_name" value="">
	</div>

	<div class="form-group">
		<label>비밀번호</label>
		<input type="password" class="form-control" name="guest_password" value="">
	</div>
	<?php endif; ?>
	
	<div class="form-group">
		<button class="btn btn-default" type="submit" onclick="contentSubmit(this,event);"><?=$mode === "add" ? "추가" : "수정"?></button>
		<span style="margin-left:10px;"></span>
        <?php if ( strpos($mode,"update") > -1): ?>
		<button type="button" class="btn btn-default clickable" data-href="<?=my_site_url("/{$moduleName}/{$row->id}")?>">게시물로</button>
        <?php endif; ?>
		<button type="button" class="btn btn-default clickable" data-href="<?=my_site_url("/{$moduleName}/list")?>">목록으로</button>
	</div>

</form>

<script>


	//서머노트 위지위그 정의 시작
	$(document).ready(function(){

		
		$('#editor').summernote({
				placeholder: '내용',
				tabsize: 2, // height: 100,
				minHeight: 500, // set minimum height of editor
				maxHeight: null, // set maximum height of editor
				focus: false, // set focus to editable area after initializing summe
				dialogsInBody: true,
				dialogsFade: true,
				callbacks: {
					onImageUpload: function (files) {
						formData = new FormData();
						for (let i = 0; i < files.length; i++) {
							formData.append("files[]", files[i]);
						}
						sendImages(formData, this);
					},
					onInit: function () {
						$this = $(this);
						$form = $this.parents("form").eq(0);
						$this.summernote('code', $form.find("input[name=desc]").val());
					},
					onBlur: function() {
						$this = $(this);
						$form = $this.parents("form").eq(0);
						$form.find("input[name=desc]").val($this.summernote('code'));
					}
					
				}
			}

		);
	// }

		function sendImages(formData, editor) {
				// 파일 전송을 위한 폼생성
				<?php if($mode === "add"):?>
					var url = "/uploadImage";
				<?php else:?>
					var url = "/uploadImage?content_id=<?=$row->id?>";
				<?php endif;?>
				$.ajax({
					// ajax를 통해 파일 업로드 처리
					data: formData,
					type: "POST",
					url: url,
					cache: false,
					contentType: false,
					processData: false,
					// beforeSubmit:function(e){
					//     $('.uploading').show();
					// },

					success: function (data) {
						
						let files = data.files;
						for (let i = 0; i < files.length; i++)
						{
							//업로드 성공시 에디터에 이미지삽입
							let result = files[i].result;
							if (result === "success") {
								$(editor).summernote('editor.insertImage', files[i].uri);
							}
							//개별 실패시
							if (result === "fail") {
							}
						}
						//한개라도 실패가 있을시
						if(data.result === "fail")
						{
							alert(data.errors);
						}
					}
				});
			}
		});	

		
		function contentSubmit(t,event) 
		{
			$this = $(t);
			$form = $this.parents("form").eq(0);

			//파일업로드 갯수 제한
			var $fileUpload = $form.find("input[type='file']");
			if (parseInt($fileUpload.get(0).files.length)>10)
			{ 
				alert("파일은 10개이상 업로드할수없습니다.");	
				event.preventDefault();
				return false;
			}	
		}
		

	
	//서머노트 위지위그 정의 끝

</script>
