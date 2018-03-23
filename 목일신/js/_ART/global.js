//硫붾돱 �ㅻ퉬寃뚯씠��
function initNavigation(seq, seq2) {		
	var nav = document.getElementById("head_menu");
	nav.menu = new Array();
	nav.current = null;
	nav.menuseq = 0;
	var navLen = nav.childNodes.length;
	var menuImg;
	
	var allA = nav.getElementsByTagName("a");
	for(var k = 0; k < allA.length; k++) {
		allA.item(k).onmouseover = allA.item(k).onfocus = function () {
			nav.isOver = true;
		}
		allA.item(k).onmouseout = allA.item(k).onblur = function () {
			nav.isOver = false;
			setTimeout(function () {
				if (nav.isOver == false) {
					if (nav.menu[seq]) {
						nav.menu[seq].onmouseover();
					} else if(nav.current) {
						menuImg = nav.current.childNodes.item(0);
						menuImg.src = menuImg.src.replace("_on.gif", ".gif");
						if (nav.current.submenu) {
							nav.current.submenu.style.display = "none";
						}
						nav.current = null;
					}
				}
			}, 500);
		}
	}
	
	var allB = nav.getElementsByTagName("a");
	for(var k = 0; k < allB.length; k++) {
		var str = allB.item(k) + "";
		if(str.substr(str.length-10,4) == seq2){
			allB.item(k).className = "selected";
		}
	}

	for (var i = 0; i < navLen; i++) {
		var navItem = nav.childNodes.item(i);
		if (navItem.tagName != "LI") {
			continue;
		}
		var navAnchor = navItem.getElementsByTagName("a").item(0);
		navAnchor.submenu = navItem.getElementsByTagName("div").item(0);
	
		navAnchor.onmouseover = navAnchor.onfocus = function () {
			if (nav.current) {
				menuImg = nav.current.childNodes.item(0);
				menuImg.src = menuImg.src.replace("_on.gif", ".gif");
				if (nav.current.submenu) {
					nav.current.submenu.style.display = "none";
				}
				nav.current = null;
			}
			if (nav.current != this) {
				menuImg = this.childNodes.item(0);
				menuImg.src = menuImg.src.replace(".gif", "_on.gif");
				if (this.submenu) {
					this.submenu.style.display = "block";
				}
				nav.current = this;
			}
			nav.isOver = true;
		}
		nav.menuseq++;
		nav.menu[nav.menuseq] = navAnchor;
	}
	if (nav.menu[seq]) {
	}
}
// �ㅽ겕濡ㅻ뵲�쇰떎�덇린
function followBanner (div_id, con_id)
{
	var self	= document.getElementById(div_id);
		self.style.display = "block";

	var scroll_top	= (document.body.scrollTop)
					? parseInt(document.body.scrollTop, 10)
					: parseInt(document.documentElement.scrollTop, 10);
	
	var base	= document.getElementById(con_id);
	var max		= parseInt(base.clientHeight, 10);

	var t = self.style.top ? parseInt(self.style.top, 10) : 0;
	
	if (t!=scroll_top)
	{
		var g	= Math.ceil((t-scroll_top)/15);
			g	= g ? g : 0;
		
		if (max > scroll_top+parseInt(self.offsetHeight, 10))
		{
			self.style.top = (t-g) + "px";
		}
		else
		{
			self.style.top	= parseInt(max-self.offsetHeight, 10) + "px";
		}
	}

	setTimeout("followBanner('" + div_id + "', '" + con_id + "');", 5);
}