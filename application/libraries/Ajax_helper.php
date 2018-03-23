<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Ajax_helper
{
    /**
     * loading cssSelectorName
     *
     * @var string
     */
    public $loading = ".loading";
    public $lodingTime= "500";
    private $ci;
    /**
     * createScript method가 한번이라도 실행됬는지 여부
     *
     * @var boolean
     */
    private $isCreateScript = false;
    public function __construct()
    {
        $this->ci = &get_instance();
    }
    public function set_flashMessage($message, $type ="success")
    { 
        $this->ci->load->library('session');
        $this->ci->session->set_flashdata('message',["message"=>"$message","type"=>"$type"]);
    }
    public function get_messageData($title,$message,$type ="success")
    {
        $data['notify']["title"] = $title;
        $data['notify']["message"] =  $message;
        $data['notify']["type"] = $type;
        return $data;
    }
    /**
     * 처음 실행합니다.
     *
     * @return void
     */
    public function headerJson()
    {
        // if(AJAX_DEBUG === false)
        // {
        //     header("content-type:application/json");
        // }
        header("content-type:application/json");
        
    }    
    /**
     * 마지막에 실행합니다.
     * @example $data['alert'] = "test"; $this->ajax_helper->json($data);
     * @param array $data
     * @return void
     */
    public function json($data =array())
    {
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    /**
     * auto create form ajax tag
     * @example <form <?=$this->ajax_helper->form("/base/user/login")?>>
     * @param string $action_url
     * @return void
     */
    //현재 querystring을 유지합니다
    public function form_get(string $action_url, string $confirmMsg=null)
    {
        ?>
        onsubmit="<?=($confirmMsg === null) ? "submit_get(this);": "confirm_callback(this,submit_get,'$confirmMsg');"?> return false;" action="<?=$action_url?>"
        <?php
    }
    public function form(string $action_url,string $confirmMsg =null, bool $queryString = true)
    {
        $onsubmit = ($confirmMsg === null) ? "ajax_form(this);" : "confirm_callback(this,ajax_form,'$confirmMsg');";
        $action = ($queryString)?my_site_url($action_url): site_url($action_url);
     return "onsubmit=\"".$onsubmit . "return false;\"". "action=\"".$action."\" method=\"post\"";
    //  ?>onsubmit="<?=($confirmMsg === null) ? "ajax_form(this);": "confirm_callback(this,ajax_form,'$confirmMsg');"?>  return false;" action="<?=($queryString)?my_site_url($action_url): site_url($action_url)?>" method="post"<?php
    }

    public function anchor(string $action_url,string $confirmMsg =null,bool $queryString = true)
    {
        ?>onclick="<?=($confirmMsg === null) ? "ajax_a(this);": "confirm_callback(this,ajax_a,'$confirmMsg');"?> return false;" data-action="<?=($queryString)? my_site_url($action_url): site_url($action_url)?>" href="#"<?php
    }
    public function multipart(string $action_url,string $confirmMsg =null, bool $queryString = true)
    {
        ?> 
        onsubmit="multipartAjax(this,'<?=my_site_url($action_url)?>'); return false;" action="<?=my_site_url($action_url)?>" method="post"  enctype="multipart/form-data"
        <?php
    }
    /**
     * view에서 한번만 실행합니다.
     *
     * @return void
     */
    public function createScript()
    {
        if($this->isCreateScript === true)//createScript는 한 request당 한번만 실행 할수 있습니다.
        {
            echo "<!-- ajax_helper->createScript() 메소드를 이미 호출하였습니다.-->";
            return;
        }
        $this->isCreateScript = true;
        ?> 
        <script>
        function ajaxRespone(data,e)
        {
            if("none" in data) return ;
                    if("alert" in data)  alert(data['alert']);
                    if("callback" in data) eval(data['callback']);
                    if("redirect" in data && data['redirect'] !== false)
                    {
                        window.location.href= data["redirect"];
                    } 
                    if("confirm_redirect" in data) {
                        if(confirm(data["confirm_redirect"]["msg"]))
                            window.location.href= data["confirm_redirect"]["url"];
                    }
                    if("append" in data){
                        var append = data['append'];
                        var ele=$(e)[append['method']](append['selector'])[0];
                        $(ele).append(append['data']);
                    }
                    if("change" in data){
                        var html = data['change']['html'];
                        var target = data['change']['target'];
                        $(target).html(html);
                    }
                    if("remove" in data )
                    {
                        var remove = data["remove"];
                        if(typeof remove["parent"] !== "undefined")
                        {
                            var selector =remove["parent"];
                            $($(e).parents(selector)[0]).remove();
                        }else
                        {
                            $(e).remove();
                        }
                    }
                    if("notify" in data)
                    {
                        notify(data["notify"]);
                    }

                    $('.loading').fadeOut(500);

                    if(("reload" in data) && data['reload'] ==true)  window.location.reload();
        }
        //mesage플레시 데이터
        <?php if(($message =$this->ci->session->flashdata("message"))  !== null ):?>
            var config ={
                "message" : "<?=$message["message"]?>",
                "type" : "<?=$message["type"]?>",
            };
            notify(config);
        <?php endif;?>

        
        function notify(config){
            var type =  config.type || "info";
            $.notify({
                
            //    icon: 'glyphicon glyphicon-star',
            icon: 'fa fa-check-circle-o',
            title: config.title,
            message: config.message,
            },{
                delay: 1000,
                allow_dismiss: true,
                timer: 10,
                spacing: 1,
                z_index: 1031,
                newest_on_top: true,
                type: type,
                animate: {
                    enter: 'animated none',
                    exit: 'animated fadeOutUp'
                },
            
                placement: {
                    from: "top",
                    align: "center"
                },

        });
        }
        function multipartAjax(e,url,callback)
        {
            if(typeof callback === "undefined")
            {
                callback = function()
                {
                    return true;
                };
            }
            // Create an FormData object
            // var data = new FormData(e);
            // console.log(data);
            // return ;
            var data = new FormData();
            $form=$(e);
            files=$form.find("input[name='files[]']")[0].files;
            // console.log(files);
            for(let i = 0 ; i<files.length ; i++)
            {
                data.append("files[]",files[i])
            }
            
            $input =$form.find("input");
            for(let i = 0 ; i < $input.length ; i++)
            {
                let name = $input.eq(i).attr("name");
                let val = $input.eq(i).val();
                // console.log(name);
                // console.log(val);
                data.append(name,val);
            }


            // console.log(data);
            // return;

            $.ajax({
                data: data,
                type: "POST",
                // enctype: 'multipart/form-data',
                
                url: url,
                processData: false,
                contentType: false,
                cache: false,
                // timeout: 600000,
            success: function (data) {
                callback(e,data);
                $('.loading').fadeOut(500);
                ajaxRespone(data,e)
            },
            error: function(xhr, textStatus, errorThrown){
                alert('에러... or 데이터 용량이 너무많습니다.');
                    $('.loading').fadeOut(500);
                    console.log(errorThrown);
            }
        });

        }

      
        function ajax(url,queryString,e,callback)
        {
            if(typeof callback === "undefined")
            {
                callback = function()
                {
                    return true;
                };
            }
            $.ajax({
                type: "POST",
                dataType : 'json',
                data: queryString,
                url: url,
                beforeSend: function(){
                    $('<?=$this->loading?>').fadeIn(<?=$this->lodingTime?>);
                },
                success:function(data){
                    callback(e,data);
                    $('.loading').fadeOut(500);
                    ajaxRespone(data,e);
                
                },
                error: function(xhr, textStatus, errorThrown){
                    alert('에러... or 데이터 용량이 너무많습니다.');
                    $('.loading').fadeOut(500);
                    console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
                    console.log(errorThrown);
                }
            });
        }

        function ajax_form(e,validation){
            if(typeof validation === "undefined")
            {
                validation = function()
                {
                    return true;
                };
            }
            if(!validation(e)){
                return false;
            }
            var $form =$(e);
            var queryString = $form.serialize();
            // var queryString = $form.serialize().replace(/%5B%5D/g, '[]');
            // var queryString =serializePost(e);
            var url = $form[0].action;
            ajax(url,queryString,e);
            
        }

        function ajax_a(e,validation){
            if(typeof validation === "undefined")
            {
                validation = function()
                {
                    return true;
                };
            }
            if(!validation(e)){
                return false;
            }
            $e =$(e);
            var queryString =$e.data('querystring')    
            if(typeof queryString !== 'undefined')
                queryString  = $.param(queryString);

            var url = $e.data('action');
            var callback = eval($e.data('callback'));
            ajax(url,queryString,e,callback);
        }
        function confirm_callback(e,callback,msg){
            var config ={
            "message" : msg,
            "onclick" : function(){
                callback(e);
                },
            };
            madalMessage(config);
            // alertMessage(config);
            // if(confirm(msg)){
            //     callback(e);
            // }
        }
        function madalMessage(config)
        {
            let alertSource = '  <div id="ci-alert" data-toggle="modal" data-target="#myModal"></div>\
            <div class="modal fade" id="myModal" role="dialog" >\
            <div class="modal-dialog">\
                <div class="modal-content">\
                <div class="modal-header">\
                    <button type="button" class="close" data-dismiss="modal">&times;</button>\
                    <h4 class="modal-title">!</h4>\
                </div>\
                <div class="modal-body">\
                    <p>type message please</p>\
                </div>\
                <div class="modal-footer">\
                    <button type="button" data-able="true" class="ci-modal-confirm-btn btn btn-default" data-dismiss="modal">확인</button>\
                    <button type="button" class="ci-modal-close-btn btn btn-default" data-dismiss="modal">닫기</button>\
                </div>\
                </div>\
            </div>\
            </div>';


            $alert =$("#ci-alert");
            if(typeof $alert[0] === "undefined");
            {
                $alert=$(alertSource);
            }
            $alert.find(".modal-body").eq(0).text(config.message);
            $confirmButton = $alert.find(".ci-modal-confirm-btn");
            $confirmButton.data("able",true);
            $closeButton = $alert.find(".ci-modal-close-btn");
            $closeButton.data("able",true);
            
            $confirmButton.click(function(){
                if(typeof config["onclick"] !== "undefined")
                {
                    config["onclick"](); 
                }
                $confirmButton.data("able",false); 
                $closeButton.data("able",false); 
            });
            $closeButton.click(function(){
                $confirmButton.data("able",false); 
                $closeButton.data("able",false); 
            });

            $(document).keydown(function(e)
            {
                if (e.keyCode == 13 &&  $confirmButton.data("able") === true) 
                {
                    $confirmButton.click();  
                    $confirmButton.data("able",false); 
                    $closeButton.data("able",false); 
                    $(".modal-backdrop.fade.in").remove();
                    return false;
                }
                if (e.keyCode == 27  &&  $closeButton.data("able") === true) 
                {
                    console.log(1);
                    $closeButton.click();  
                    $confirmButton.data("able",false); 
                    $closeButton.data("able",false); 
                    $(".modal-backdrop.fade.in").remove();
                    return false;
                }
            });
           
    
            $("body").prepend($alert);
            $("#ci-alert").click();
            return $alert;
        }

        </script>
        <?php
    }
}


?>