/*
 * jQuery Util Plugin
 * @requires jQuery v1.3.2 or later
 * @author rcnboys
 */
(function($) {
/**
 * 媛� �섎━癒쇳듃�� ���� disabled �댄듃由щ럭�멸� �덈뒗吏� �뺤씤�섍퀬 留뚯빟 �덈떎硫� 媛믪쓣 true濡� �ㅼ젙�쒕떎.
 * @example $("form#FormList input.special").disable();
 * @name disable
 * @type jQuery
 */
$.fn.disable = function(){
	return this.each(function() {
		if(typeof this.disabled != "undefined"){
			this.disabled = true;
		}
	});
};

/**
 * 媛� �섎━癒쇳듃�� ���� disabled �댄듃由щ럭�멸� �덈뒗吏� �뺤씤�섍퀬 留뚯빟 �덈떎硫� 媛믪쓣 false濡� �ㅼ젙�쒕떎.
 * @example $("form#FormList input.special").enable();
 * @name enable
 * @type jQuery
 */
$.fn.enable = function(){
	return this.each(function() {
		if(typeof this.disabled != "undefined"){
			this.disabled = false;
		}
	});
};
	
/**
 * 媛� �섎━癒쇳듃�� ���� disabled �댄듃由щ럭�멸� �덈뒗吏� �뺤씤�섍퀬 留뚯빟 �덈떎硫� 媛믪쓣 true濡� �ㅼ젙�쒕떎.
 * @example $(".req").displayRequired();
 * @name displayRequired
 * @type jQuery 
 */
$.fn.displayRequired = function(){
	this.each(function(){
		$(this).html($(this).text()+"<font color='red'>*</font>");
	});
};

/**
 * 媛� �섎━癒쇳듃�� ���� SELECT �쒓렇�몄� �뺤씤�섍퀬 留뚯빟 留욌떎硫� 鍮꾩슫��.
 */
$.fn.emptySelect = function(){
	return this.each(function(){
		if(this.tagName == 'SELECT'){
			this.options.length = 0;
		}
	});
};

/**
 * optionsDataArry�� 留욊쾶 select option 異붽�
 */
$.fn.loadSelect = function(optionsDataArray, opt){
	options = jQuery.extend({
		label : 'label',
		value : 'value'
	}, opt);
	return this.emptySelect().each(function(){
		if(this.tagName == 'SELECT'){
			var selectElement = this;
			$.each(optionsDataArray, function(index, optionData){
				
				if( !$.isPlainObject(optionData) )		return false;
				
				var option = new Option( optionData[options.label], optionData[options.value] );
				
				if($.browser.msie){
					selectElement.add(option);
				}else{
					selectElement.add(option, null);
				}
			});
		}
	});
};

/**
 * �덈줈 �앹꽦�섎뒗 html濡� ��泥댄븷 �� �덈떎.
 */
$.fn.replaceWith = function(html){
	return this.after(html).remove();
};

/**
 * �쇳깭洹� 媛� 珥덇린��
 */
$.fn.reset = function(){
	return this.each(function(){
		if(this.type == 'radio' || this.type == 'checkbox'){
			$(this).attr('checked', '');
		}else{
			var dv = $(this).attr("dv");
			if(dv != "undefined"){
				$(this).val(dv);
			}else{
				$(this).val('');
			}
		}
	});
};

$.fn.resizeImage = function(mWid, mHei, bScale){
	return this.each(function(){
		var maxWidth = mWid; // Max width for the image
        var maxHeight = mHei;    // Max height for the image
        var ratio = 0;  // Used for aspect ratio
        var width = $(this).width();    // Current image width
        var height = $(this).height();  // Current image height
 
        // Check if the current width is larger than the max
        if(width > maxWidth){
            ratio = maxWidth / width;   // get ratio for scaling image
            $(this).css("width", maxWidth); // Set new width
            $(this).css("height", height * ratio);  // Scale height based on ratio
            height = height * ratio;    // Reset height to match scaled image
            width = width * ratio;    // Reset width to match scaled image
        }else{
        	if(bScale == false){
        		ratio = maxWidth / width;   // get ratio for scaling image
                $(this).css("width", maxWidth); // Set new width
                $(this).css("height", height * ratio);  // Scale height based on ratio
                height = height * ratio;    // Reset height to match scaled image
                width = width * ratio;    // Reset width to match scaled image
        	}
        }
 
        // Check if current height is larger than max
        if(height > maxHeight){
            ratio = maxHeight / height; // get ratio for scaling image
            $(this).css("height", maxHeight);   // Set new height
            $(this).css("width", width * ratio);    // Scale width based on ratio
            width = width * ratio;    // Reset width to match scaled image
        }else{
        	if(bScale == false){
        		 ratio = maxHeight / height; // get ratio for scaling image
                 $(this).css("height", maxHeight);   // Set new height
                 $(this).css("width", width * ratio);    // Scale width based on ratio
                 width = width * ratio;    // Reset width to match scaled image
        	}
        }
	});
};
 
/**
 * Modal Window
 */
$.fn.mw = function(options, _func) {
	options = jQuery.extend({
		width : 400,
		height: 300,
		arg : {},
		scroll : 'on',
		status : 'off',
		sizeable : 'on',
		force : false
		
	}, options);
	return this.each( function() {
		var $item = jQuery(this);
			
		
		$item.click( function(e) {
			var _width = options.width;
			var _height = options.height;
			
			// IE 6.0�대㈃
			if ( $.browser.msie && /MSIE 6.0/.test(navigator.userAgent) ) {
			}
			else if ( $.browser.msie && /MSIE 7.0/.test(navigator.userAgent) ) {	// IE. 7.0�대㈃
				
			}
			else if ( $.browser.msie && /MSIE 8.0/.test(navigator.userAgent) ) {	// IE. 7.0�대㈃
				_width = options.width+45;
				_height = options.height -50;			
			}
			
			e.preventDefault();
			
			var _url = $item.attr("href");
			
			var date = new Date().getTime();
			if( _url.indexOf("?") > -1) {
				_url += '&rt=' + date;
			}else {
				_url += '?rt=' + date;
			}

			
			var ret = window.showModalDialog(_url, options.arg, "dialogWidth:"+(_width)+"px; dialogHeight:"+(_height)+"px; scroll:"+options.scroll+"; status:"+ options.status+"; resizable :"+options.sizeable );

			if( options.force )
				_func(ret);
			
			if( jQuery.isFunction(_func) && ret != undefined ) {
				_func( ret );
			}	
		});
	});	
};

/**
 * Open Window
 */
$.fn.ow = function(options, _func) {
	options = jQuery.extend({
		width : 400,
		height: 300,
		arg : {},
		scroll : 'on',
		status : 'on',
		sizeable : 'on',
		force : false
		
	}, options);
	return this.each( function() {
		var $item = jQuery(this);
			
		
		$item.click( function(e) {
			var _width = options.width;
			var _height = options.height;
			
			// IE 6.0�대㈃
			if ( $.browser.msie && /MSIE 6.0/.test(navigator.userAgent) ) {
			}
			else if ( $.browser.msie && /MSIE 7.0/.test(navigator.userAgent) ) {	// IE. 7.0�대㈃
				
			}
			else if ( $.browser.msie && /MSIE 8.0/.test(navigator.userAgent) ) {	// IE. 7.0�대㈃
				_width = options.width+45;
				_height = options.height -50;			
			}
			
			e.preventDefault();
			
			var _url = $item.attr("href");
			
			var date = new Date().getTime();
			if( _url.indexOf("?") > -1) {
				_url += '&rt=' + date;
			}else {
				_url += '?rt=' + date;
			}

			var winl = (screen.width - _width) / 2;
			var wint = (screen.height - _height) / 2;
			var winprops = 'height='+(_height)+',width='+(_width)+',top='+wint+',left='+winl+',scrollbars=1,resizable';
			var z = window.open(_url, '', winprops);

			if( jQuery.isFunction(_func) ) {
				_func();
			}
			
		});
	});	
};
})(jQuery);

jQuery(function($) {
	_internal = {
			options : jQuery.extend({
				width : 400,
				height: 300,
				arg : {},
				scroll : 'on',
				status : 'on',
				sizeable : 'on',
				force : false			
			}),
			mwManual : function(url, opts, _func) {
				
				$.extend(true, _internal.options, opts);
				
				var _width = _internal.options.width;
				var _height = _internal.options.height;
				
				// IE 6.0�대㈃
				if ( $.browser.msie && /MSIE 6.0/.test(navigator.userAgent) ) {
					_width = _internal.options.width;
				}
				else if ( $.browser.msie && /MSIE 7.0/.test(navigator.userAgent) ) {	// IE. 7.0�대㈃
					
				}
				else if ( $.browser.msie && /MSIE 8.0/.test(navigator.userAgent) ) {	// IE. 7.0�대㈃
					_width = _internal.options.width+45;
					_height = _internal.options.height -50;			
				}
				
				var _url = url;
				
				var date = new Date().getTime();
				
				if( _url.indexOf("?") > -1) {
					_url += '&rt=' + date;
				}else {
					_url += '?rt=' + date;
				}
				
				var ret = window.showModalDialog(_url, _internal.options.arg, "dialogWidth:"+(_width)+"px; dialogHeight:"+(_height)+"px; scroll:"+_internal.options.scroll+"; status:"+ _internal.options.status+"; resizable :"+_internal.options.sizeable );
				
				if( jQuery.isFunction(_func) && ret != undefined ) {
					_func( ret );
				}
			}
	},
	$.extend({
		mwManual: _internal.mwManual
	});
});