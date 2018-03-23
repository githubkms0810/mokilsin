
<div class="row">
	<div class="col s12">
		<link rel='stylesheet prefetch' href='/public/subpage/css/000_fileuproad/materialize.min.css'>
		<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
		<link rel="stylesheet" href="/public/subpage/css/000_fileuproad/style.css">
		<div class="row">
			<div class="col s12">
				<!-- Uploader Dropzone -->
				<div id="zdrop" class="fileuploader ">
					<div id="upload-label" style="width: 200px;">
						<i class="material-icons">cloud_upload</i>
						<span class="title">업로드할 파일을 드래그 해서 넣어주세요.</span>
						<span>100mb 이하만 가능합니다. <span/>
					</div>
				</div>
				<!-- Preview collection of uploaded documents -->
				<div class="preview-container">
					<div class="header">
						<span>Uploaded Files</span>	
						<i id="controller" class="material-icons">keyboard_arrow_down</i>
					</div>
					<div class="collection card" id="previews">
						<div class="collection-item clearhack valign-wrapper item-template" id="zdrop-template">
							<div class="left pv zdrop-info" data-dz-thumbnail>
								<div>
									<span data-dz-name></span> <span data-dz-size></span>
								</div>
								<div class="progress">
									<div class="determinate" style="width:0" data-dz-uploadprogress></div>
								</div>
								<div class="dz-error-message"><span data-dz-errormessage></span></div>
							</div>
							<div class="secondary-content actions">
								<a href="#!" data-dz-remove class="btn-floating ph red white-text waves-effect waves-light"><i class="material-icons white-text">clear</i></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  	<script src="/public/subpage/js/000_fileuproad/jquery.min.js"></script>
    <script  src="/public/subpage/js/000_fileuproad/index.js"></script>
    <script src="/public/subpage/js/000_fileuproad/materialize.min.js"></script>
	<script src="/public/subpage/js/000_fileuproad/dropzone.js"></script>
</div>