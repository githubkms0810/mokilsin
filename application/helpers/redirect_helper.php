<?php defined('BASEPATH') OR exit('no direct script access allrowed');



if(!function_exists('my_redirect')){
    function my_redirect($uri,$sw_querystring = true){
        $ci = &get_instance();
        $index_page = $ci->config->item("index_page");
        if(strlen($index_page) !==0 )
        {
            $index_page ="/".$index_page;
               
        }
       $domain = base_url();
        if(strpos($uri,"http") > -1){
            $uri =str_replace("{$domain}index.php","",$uri);
            $source = "<script>window.location.href ='{$index_page}{$uri}';</script>";
            echo $source;
            return;
        }
        if(($startIdx =strpos($uri,"?")) > -1){
            $startIdx += 1;
            $length = strlen($uri) - $startIdx;
            $tmp_querystring =substr($uri,$startIdx,$length);
            parse_str($tmp_querystring, $arr_queryString);
            $arr_queryString;
            $querystring ='';
           
            foreach($_GET as $key=>$value){
                $sw =true;
                foreach($arr_queryString as $key2=>$value2){
                    if($key == $key2){
                        $sw = false;
                    }
                }
                if($sw){
                    $querystring .= "$key=$value&";
                }
            }
            
            $querystring =substr($querystring,0, strlen($querystring)-1);
    
        }else{
            $querystring =$ci->input->server("QUERY_STRING");
        }


        if($sw_querystring && $ci->input->server("QUERY_STRING") !== ""){
            if(!strpos($uri,'?')){
                $uri .= "?";
            }
            else{
                $uri .= "&";
            }
            $uri .=$querystring ;
        }
        $source = "<script>window.location.href ='{$index_page}{$uri}';</script>";
        echo $source;
        exit;
    }
}

/**
 * return $_GET["return_url"], 값이없다면 리턴 $url
 */
if(!function_exists('get_returnURL')){
    function get_returnURL($url){
        $ci = &get_instance();
        $returnURL = $ci->input->get("return_url");
        if($returnURL === null){
            return $url;
        }else{
            return urldecode( $returnURL);
            
        }
    }
}
/**
 *  $_GET["return_url"]으로 리다이렉션, 값이없다면 $url로 리다이렉션
 */
if(!function_exists('redirect_return_url')){
    function redirect_return_url($url){
        $ci = &get_instance();
        $returnURL = $ci->input->get("return_url");
        if( $returnURL === null){
            my_redirect($url);
            exit;
        }else{
            redirect($return_url);
            exit;
        }
    }
}
if(!function_exists('get_redirect_return_url')){
    function get_redirect_return_url($url){
        $ci = &get_instance();
        $return_url=$ci->input->get("return_url");
        if($return_url === null || $return_url === "")
            return $url;
        else
            return $return_url;
    }
}

/**
 * queryString 형태의 returnURL = 현재URL값을 반환합니다.
 *
 * @return void
 */
if(!function_exists('QSreturnURL')){
    function QSreturnURL()
    {
        $ci = &get_instance();
        $ci->load->helper("url");
        return "return_url=".rawurlencode(my_current_url());
    }
}