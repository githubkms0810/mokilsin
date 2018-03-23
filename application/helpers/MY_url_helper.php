<?php defined('BASEPATH') OR exit('no direct script access allrowed');




function my_current_url(string $querystring = null)
{
    $ci = &get_instance();
    $HTTPS=$ci->input->server("HTTPS");
    $HTTP_HOST=$ci->input->server("HTTP_HOST");
    $REQUEST_URI=$ci->input->server("REQUEST_URI");
    $current_url = (isset($HTTPS) ? "https" : "http") . "://{$HTTP_HOST}{$REQUEST_URI}";

    // if( strpos($current_url,"&guest_order=true") > -1){
    //     $current_url = str_replace( "&guest_order=true", "",$current_url);
    // }else if(strpos($current_url,"guest_order=true") > -1 ){
    //     $current_url = str_replace( "guest_order=true", "",$current_url);
    // }
    if($querystring  === null)
    {
        return $current_url;
    }

    if(($startIdx = strpos($current_url,"?")) > -1) //querystring 중복은 새롭게변경, 없는건 추가
    {
        $startIdx++;
        $endIdx = mb_strlen($current_url)+1;
        $existedQuerystring =mb_substr($current_url,$startIdx, $endIdx - $startIdx);
    
        // var_dump($querystring);
        parse_str($querystring,$arr1);
        parse_str($existedQuerystring,$arr2);
        // var_dump($arr2);
        $newQuerystring = "?";
        foreach ($arr1 as $key1 => $value1) 
        {
            $sw = false;
            
            foreach ($arr2 as $key2 => $value2) 
            {
                if($key1 === $key2)
                {
                    $sw = true;
                    break;
                }
                
            }
            if($sw === true) // 같을떄 변경
            {
                $newQuerystring .= "{$key2}={$value1}&";
                unset($arr2[$key2]);
                unset($arr1[$key1]);
            }
        }
     
        foreach ($arr1 as $key1 => $value1) 
        {
            $newQuerystring .= "{$key1}={$value1}&";
        }
        
        foreach ($arr2 as $key2 => $value2) 
        {
            if(!is_array($value2))
            {
                $newQuerystring .= "{$key2}={$value2}&";
            }
            // else
            // {
            //     foreach ($value2 as $key3 => $value3)
            //     {
            //         $newQuerystring .= "{$key3}={$value3}&";
            //     }
            // }
        }
        $newQuerystring= substr($newQuerystring,0,-1);
        $current_url = current_url().$newQuerystring;
    }
    else //기존 쿼리스트링 없을떄 그냥 추가
    {
        $current_url.= "?$querystring";
    }
    
    return $current_url;
   
}

/**
 * return site_url with queryString,
 *
 * @param string $uri
 * @param boolean true : contain queryString , false : else
 * @return void
 */
function my_site_url(string $uri,$sw_querystring = true,$xss_clean =null,$eceptedQuerystringKeys = []){
    $ci = &get_instance();

    if(($startIdx =strpos($uri,"?")) === false)
    {
       $querystring = $ci->input->server("QUERY_STRING",$xss_clean);
    }
    else
    {
        $startIdx += 1;
        $length = strlen($uri) - $startIdx;
        $tmp_querystring =substr($uri,$startIdx,$length);
        
        parse_str($tmp_querystring, $arr_queryString);
        $arr_queryString;
        $querystring ='';
       
      
        foreach($_GET as $key=>$value){
            $sw =true;
          
            foreach($arr_queryString as $key2=>$value2){
                if($key === 'menu_id' || $key === 'menu_top_id'){
                    $sw = false;
                    break;
                }
                if( $key == $key2){
                    $sw = false;
                    break;
                }
            }
          
            if($sw){  // 중복되지않고 해당 key가 없을떄
                    
                $querystring .= "$key=$value&";
            }
           
        }
        $querystring =substr($querystring,0, strlen($querystring)-1);
    }

    if(count($eceptedQuerystringKeys) >= 1)
    {
        parse_str($querystring, $arr_queryString2);
        $querystring ='';
        foreach($arr_queryString2 as $key=>$value){
            if(in_array($key,$eceptedQuerystringKeys))
            {
                continue;              
            }
            if(!is_array($value))
            {
                $querystring .= "$key=$value&";
            }
            else
            {
                foreach ($value as $key2 => $value2) {
                    $querystring .= "{$key2}[]=$value2&";
                }
            }
                
        }
        $querystring =substr($querystring,0, strlen($querystring)-1);
    }
    

    // $url =$_SERVER['SCRIPT_NAME'];
    if(strlen($ci->config->item("index_page")) !==0 )
        $url ="/";
    else
        $url ="";
    $url .=$ci->config->item("index_page");
    $url .= $uri;
    if($sw_querystring && $querystring !== "")
    {
        if(strpos($uri,'?') > -1)
        {
            $url .= "&";
        }
        else{
            $url .= "?"; 
        }
        $url .=$querystring;
    }
    return $url;
}

