
//�좎쭨 怨꾩궛�� by mibany 2011.08.30

//�ъ슜�덉젣
/*
	//2011�� 8�� 30�� �멸꼍��...
	var d = new Date(2011,8-1,30);
	//2�쇱쓣 �뷀븳��.
	d.addDay(2);
	//寃곌낵
	alert((d.getMonth() + 1) + "�� " + d.getDate() + "��");
	// 9�� 1��
*/

Date.prototype.addDay = function(d) {
	this.setDate(this.getDate() + d);
};
Date.prototype.addMonth = function(m) {
	this.setMonth(this.getMonth() + m);
};
Date.prototype.addYear = function(y) {
	this.setFullYear(this.getFullYear() + y);
};
Date.prototype.toFormat = function(pattern) {
	var format = pattern;
	format = format.replaceAll("Y", this.getFullYear());
	format = format.replaceAll("M", (this.getMonth() + 1));
	format = format.replaceAll("D", this.getDate());
	return format;
};

String.prototype.trim = function() {
    return this.replace(/(^\s*)|(\s*$)/g, "");
};

String.prototype.removeComma = function() {
	return this.replace(/,/g, "");
};

String.prototype.replaceAll = function( searchStr, replaceStr )
{
    return this.split( searchStr ).join( replaceStr );
};

String.prototype.Comma = function() {
	var reg = /(^[+-]?\d+)(\d{3})/;
	var str = this;
	while(reg.test(str) ) {
		str = str.replace(reg, '$1' + ',' + '$2');
	}
	return str;
};



/* �붾㈃ �꾪솚 */
$.fn.fade = function(_url, data, options) {
	options = jQuery.extend({
		delay : 0
	}, options);
	return this.each( function() {
		var $item = $(this);
		if( _url == '#' )	return;
		var date = new Date().getTime();
		if( _url.indexOf("?") > -1) {
			_url += '&dummy=' + date;
		}else {
			_url += '?dummy=' + date;
		}
	
		$.get(_url, data, function(ret) {
			$item.fadeOut(options.delay, function() {
				$item.html(ret).fadeIn(options.delay);
			});
		});
	});
};

$.fn.fadeAfter = function(_url, data, options) {
	options = jQuery.extend({
		delay : 500
	}, options);
	return this.each( function() {
		var $item = $(this);
		if( _url == '#' )	return;
		var date = new Date().getTime();
		if( _url.indexOf("?") > -1) {
			_url += '&dummy=' + date;
		}else {
			_url += '?dummy=' + date;
		}
		$.get(_url, data, function(ret) {
			$item.html(ret).fadeIn(options.delay);
		});
	});
};

$.fn.serializeObject = function() {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function() {
		if (o[this.name]) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
};

$.fn.tab = function(_func, opt ) {
	options = jQuery.extend({
		clz : 'current',
		force : false,
		active : null,
		view : null
	}, opt);
	var tab = $(this);
	
	tab.find("li").bind('click', function(e) {
	
		e.preventDefault();
		
		if( !options.force ) {
			if( $(this).hasClass( options.clz) )
				return false;
		}
		
		tab.find("li").removeClass(options.clz);
		$(this).addClass(options.clz);
		if( $.isFunction(_func) )
			_func( $(this) );
		
		if( options.view != null ) {
			$(options.view).fadeAfter( $(this).find("a").attr("href") );
		}
	});
	
	if( options.active != null ) {
		tab.find('li').eq(options.active).click();
	}
};


$.download = function(url, data, method){
	//url and data options required
	if( url && data ){ 
		//data can be string of parameters or array/object
		data = typeof data == 'string' ? data : jQuery.param(data);
		//split params into form inputs
		var inputs = '';
		jQuery.each(data.split('&'), function(){ 
			var pair = this.split('=');
			inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ decodeURI(pair[1]) +'" />'; 
		});
		//send request
		
		jQuery('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>')
		.appendTo('body').submit().remove();
	};
};
//�섏씠吏�
function goPage(_page) {

	var _url = document.location.toString(); 

	if( _url.search(/(page=)+[0-9]+/g ) > 0 ) {	// �섏씠吏�媛� �덈뒗寃쎌슦
		_url = _url.replace(/(page=)+[0-9]+/g, "page="+ _page);
		document.location.href = _url; 
	}else {
		if( _url.indexOf("?") > 0 ) {
			_url += "&page="+ _page;
		}else {
			_url += "?page="+_page;
		}
		document.location.href = _url;
	}
}

var TimeOut         = 300;
var currentLayer    = null;
var currentitem     = null;
var currentLayerNum = 0;
var noClose         = 0;
var closeTimer      = null;
// Open Hidden Layer
function mopen(n)
{
    var l  = document.getElementById("menu"+n);
    var mm = document.getElementById("mmenu"+n);
   
    if(l)
    {
        mcancelclosetime();
        l.style.display='block';
        if(currentLayer && (currentLayerNum != n))
            currentLayer.style.display='none';
        currentLayer = l;
        currentitem = mm;
        currentLayerNum = n;           
    }
    else if(currentLayer)
    {
        currentLayer.style.display='none';
        currentLayerNum = 0;
        currentitem = null;
        currentLayer = null;
    }
}
// Turn On Close Timer
function mclosetime()
{
    closeTimer = window.setTimeout(mclose, TimeOut);
}
// Cancel Close Timer
function mcancelclosetime()
{
    if(closeTimer)
    {
        window.clearTimeout(closeTimer);
        closeTimer = null;
    }
}
// Close Showed Layer
function mclose()
{
    if(currentLayer && noClose!=1)
    {
        currentLayer.style.display='none';
        currentLayerNum = 0;
        currentLayer = null;
        currentitem = null;
    }
    else
    {
        noClose = 0;
    }
    currentLayer = null;
    currentitem = null;
}
// Close Layer Then Click-out
document.onclick = mclose;