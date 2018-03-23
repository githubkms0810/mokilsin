
function changeZIndexBySelector(zIndexValue,selector)
{
	document.querySelector(selector).style.zIndex  = zIndexValue;
}

var Jy;
(function (Jy){
    (function (KTC){
        var Portfolio = (function(){

            var _$JyDim = $(".jy-dim");
            var _$ModalContainer;
            function Portfolio(){
            }
            Portfolio.prototype.Open = function(t){
                $this =$(t);
                $wrapper = _GetItemWapper($this);
                _$ModalContainer =_GetModalContainer($wrapper);
                _$ModalContainer.css('display','block');
                _$JyDim.css("display","block");
                $wrapper.css('z-index','999999');
                _$ModalContainer.css('z-index','99999');
                _$ModalContainer[0].style.top = "60px";
                $("body").css("overflow","hidden");

            }
            Portfolio.prototype.Close =  function(t)
            {
                _$ModalContainer.css('display','none');
                _$JyDim.css("display","none");
                $("body").css("overflow","auto");
            }
            var _GetModalContainer = function($wrapper){
                return $($wrapper.children(".container-contact100")[0]);
            }
            var _GetItemWapper = function($this){
                return $($this.parents(".jy-portfolio-item-wrapper")[0]);
            }            
            return Portfolio;
        })();
        KTC.Portfolio = Portfolio;
    })(Jy.KTC || (Jy.KTC = {}));    
    var KTC = Jy.KTC;
})(Jy || (Jy = {}));


