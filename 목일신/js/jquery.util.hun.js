// �앹뾽李� �リ린
function fn_closePopup() {
	self.close();
}

function fn_openPopup(_url, _winNm, _width, _height) {
    var sw = screen.availWidth;  //screen width
    var sh = screen.availHeight; //screen height
      
    var pw = _width;  //popup width
    var ph = _height; //popup height
      
    var mt = (sh - ph) / 2; //margin top
    var ml = (sw - pw) / 2; //margin left
      
    window.open(_url, _winNm, "top=" + mt + ", left=" + ml + ", width=" + pw + ", height=" + ph + ", status=yes, toolbar=no, menubar=no, location=no, scrollbars=yes, resizable=yes");
}

function fn_formatPhone(_element, _delimiter) {
	
	var ele     = _element;
	var delim   = (_delimiter === undefined) ? '-' : _delimiter;
	var eleVal  = ele.value.replace(/[^0-9]/g, '');
    var tempStr = '';
    
    if(eleVal.length < 4) {
    
    	tempStr = eleVal;
    
    } else if(eleVal.length < 7) {
        
    	tempStr += eleVal.substr(0, 3);
    	tempStr += delim;
    	tempStr += eleVal.substr(3);
        
    } else if(eleVal.length < 11) {
    	
    	tempStr += eleVal.substr(0, 3);
    	tempStr += delim;
    	tempStr += eleVal.substr(3, 3);
    	tempStr += delim;
    	tempStr += eleVal.substr(6);
        
    } else {
    	
    	tempStr += eleVal.substr(0, 3);
    	tempStr += delim;
    	tempStr += eleVal.substr(3, 4);
    	tempStr += delim;
    	tempStr += eleVal.substr(7, 4);
    }
    
    ele.value = tempStr;
}