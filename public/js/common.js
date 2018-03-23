



function submit_get(e) 
{
    noAllowedKeys = ['searchKey[]','searchValue[]'];
    $form = $(e);
    var action = $form.attr('action');
    var queryString = $form.serialize();
    var startIdx;
    if((startIdx = action.indexOf('?')) === -1)
    {
        window.location.href= action + "?" + queryString;
        return true;
    }else
    {
        var a_queryString =action.substring(startIdx+1,action.length);
      
        obj_a_queryStrng=JSON.parse('{"' + decodeURI(a_queryString).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g,'":"') + '"}');

        for (var key in obj_a_queryStrng) {
            if($.inArray(key,noAllowedKeys) === -1)
            {
                // queryString = `${key}=${obj_a_queryStrng[key]}&`+queryString;
                queryString = key+"="+obj_a_queryStrng[key]+"&"+queryString;
            }
            
        }

        var action_url = action.substring(0,startIdx+1);
   
    
        var url = action_url + queryString;
        window.location.href= url;
        return true;

    }

    
}



function confirm_redirect(url,msg){
    if(typeof msg ==="undefinded")
    {
        msg = "";
    }
    if(confirm(msg)){
        window.location.href= url;
    }
    return;
}



function open_popup(url,name,width, height){
    width = (typeof width !== "undefined") ? width : 400;
    height = (typeof height !== "undefined") ? height : 400;
    var option = "width="+width+",height="+height;
    // var option = `width=${width},height=${height}`;
    window.open(url,name,option);
   
}


$(".clickable").on('click', function () {
    if(typeof $(this).data('href') !== "undefined")
    {
        document.location = $(this).data('href');
    }
});

$(".clickable .unclickable").click(function(e) {
    e.stopPropagation();
 });


 function auth_popup(url,name,width ,height){
     width = (typeof width !== "undefined") ? width : 400;
     height = (typeof height !== "undefined") ? height : 400;
    // var option = `width=${width},height=${height}`;
    var option = "width="+width+",height="+height;
    var input = document.querySelector("input[name="+name+"]");

    // console.log(input.value);
    window.open(url+"?"+name+"="+input.value,name+'_auth',option);
   
}
