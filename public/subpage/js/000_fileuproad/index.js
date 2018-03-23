$(document).ready(function(){

				initFileUploader("#zdrop");

				function initFileUploader(target) {
					var previewNode = document.querySelector("#zdrop-template");
					previewNode.id = "";
					var previewTemplate = previewNode.parentNode.innerHTML;
					previewNode.parentNode.removeChild(previewNode);


					var zdrop = new Dropzone(target, {
						url: '/file/UploadFile',
						maxFilesize:20,
						previewTemplate: previewTemplate,
						autoQueue: true,
						previewsContainer: "#previews",
						clickable: "#upload-label"
					});

					zdrop.on("addedfile", function(file) { 
						$('.preview-container').css('visibility', 'visible');
					});

					zdrop.on("totaluploadprogress", function (progress) {
						var progr = document.querySelector(".progress .determinate");
						if (progr === undefined || progr === null)
							return;

						progr.style.width = progress + "%";
					});

					zdrop.on('dragenter', function () {
						$('.fileuploader').addClass("active");
					});

					zdrop.on('dragleave', function () {
						$('.fileuploader').removeClass("active");			
					});

					zdrop.on('drop', function () {
						$('.fileuploader').removeClass("active");	
					});
					
					var toggle = true;
					/* Preview controller of hide / show */
					$('#controller').click(function() {
						if(toggle){
							$('#previews').css('visibility', 'hidden');
							$('#controller').html("keyboard_arrow_up");
							$('#previews').css('height', '0px');
							toggle = false;
						}else{
							$('#previews').css('visibility', 'visible');
							$('#controller').html("keyboard_arrow_down");
							$('#previews').css('height', 'initial');
							toggle = true;
						}
					});
				}

			});