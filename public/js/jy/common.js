var Jy;
(function (Jy){
        var Common = (function(){

            function Common(){
            }
            Common.prototype.HideAndShow = function(hideSelector,showSelector)
            {
                $(showSelector).css("display","block");
                $(hideSelector).css("display","none");
            }
         
            return Common;
        })();
        Jy.Common = Common;
})(Jy || (Jy = {}));


