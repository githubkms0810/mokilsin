jQuery(document).ready(function($){
	if( $('.floating-labels').length > 0 ) floatLabels();

	function floatLabels() {
		var inputFields = $('.floating-labels .project_label').next();
		inputFields.each(function(){
			var singleInput = $(this);
			//check if user is filling one of the form fields 
			checkVal(singleInput);
			singleInput.on('change keyup', function(){
				checkVal(singleInput);	
			});
		});
	}

	function checkVal(inputField) {
		( inputField.val() == '' ) ? inputField.prev('.project_label').removeClass('float') : inputField.prev('.project_label').addClass('float');
	}
});


// jquery ui
$("#datepicker1").datepicker();
$("#datepicker2").datepicker();
$("#datepicker3").datepicker();


