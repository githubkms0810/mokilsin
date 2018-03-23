
<?php defined('BASEPATH') OR exit('no direct script access allrowed');



if(!function_exists('renderDescriptionToPreview')){
    function renderDescriptionToPreview(string $desc,int $numOfWords = 120)
    {

        $desc =addslashes(preg_replace("/<img[^>]+\>/i", "", $desc));
        $desc=str_replace("<br>","",$desc);
        $desc=str_replace("<p>","",$desc);
        $desc=str_replace("</p>","",$desc);
        if(strlen($desc)  > $numOfWords)
        $desc =mb_substr($desc,0,$numOfWords)."...";
        $desc = "<span style='color: black'>{$desc}</span>";
        return $desc; 
            
    }   
}

if(!function_exists('form_error_one_of_multiple')){
    function form_error_one_of_multiple($fields = [])
    {
        foreach ($fields as $field) {
            $error = form_error($field);
            if($error !== "")
            return $error;
        }
    }   
}


if(!function_exists('substring')){
    function substring($str,$startIdx,$endIdx)
    {
        return substr($str,$startIdx,$endIdx-$startIdx+1);
    }   
}
if(!function_exists('substring_replace')){
function substring_replace($str,$replacement,$startIdx,$endIdx)
{
    $lastIdx=strlen($str)-1;
    if($endIdx > $lastIdx)
    {
        $endIdx = $lastIdx;
    }
    
    for ($i=$startIdx; $i <= $endIdx; $i++) { 
        $str[$i] = $replacement;
    }
    return $str;
}
}

function hideEmail($email)
{
    $idx =strpos($email,"@");
    
    $rawUserName = substring($email,0,$idx-1);
    $eamilSuffix =substring($email,$idx,strlen($email)-1);

    $openLength =(int)round(strlen($rawUserName)/2); 
    
    $hideedUserName =substring_replace($rawUserName,"*",$openLength,strlen($rawUserName)-1);
    return $hideedUserName.$eamilSuffix;
}
if(!function_exists('multi_strpos')){
function multi_strpos($string, $check, $getResults = false)
{
  $result = array();
  if(is_array($check)===false)
    $check =array($check);

  foreach ($check as $s)
  {
    $pos = strpos($string, $s);

    if ($pos !== false)
    {
      if ($getResults)
      {
        $result[$s] = $pos;
      }
      else
      {
        return $pos;          
      }
    }
  }

  return empty($result) ? false : $result;
}
}
if(!function_exists('set_allPost')){
function set_allPost($except = array())
{
    $ci = &get_instance();
    if(is_array($except) === false)
    {
        $except = [$except];
    }
    foreach ($_POST as $key => $value) {
        if(is_array($value) === false)
        {
            if(in_array($key,$except) ===false)
            {
                $ci->db->set($key,$value);
            }
        }
        else
        {
            foreach ($value as $key2 => $value2) 
            {
                if(in_array($key,$except) ===false)
                {
                    $ci->db->set($key2,$value2);
                }
            }
        }
    }
}
}



if(!function_exists('get_post')){
    function get_post(string $name)
    {
        $ci = &get_instance();
        return $ci->input->get_post($name);
    }
}
if(!function_exists('get')){
    function get(string $name)
    {
        $ci = &get_instance();
        return $ci->input->get($name);
    }
}
if(!function_exists('post')){
    function post(string $name,$xss = null)
    {
        $ci = &get_instance();
        return $ci->input->post($name,$xss);
    }
}

if(!function_exists('array_overwrite')){
function array_overwrite($data1,$data2)
{
    foreach ($data2 as $key => $value) {
        $data1[$key] =$value; 
    }
    return $data1;
}
}

if(!function_exists('getFieldName')){
    function getFieldName($field)
    {
        if(strpos($field," as "))
        {
            $startIdx =strpos($field, " as ",0)+4;
            $endIdx =strpos($field, ",",$startIdx)-1;
            if($endIdx === -1)
            {
                $sw = false;
                $endIdx = strlen($field)-1;
            }
            $field = substr($field,$startIdx,$endIdx-$startIdx+1);
            $field= str_replace(" ","",$field);
        }
        else if(strrpos($field,"'") > -1)
        {
            $field= str_replace(" ","",$field);           
            $endIdx = strrpos($field,"'");
            $endIdx =$endIdx-1;
            $startIdx =strrpos($field, "'",-2);
            $field = substr($field,$startIdx+1,$endIdx-$startIdx);
            
        }
      
        else if(($startIdx=strpos($field,".")) > -1)
        {
            $field = substr($field,$startIdx+1,strlen($field)-$startIdx-1);
            $field= str_replace(" ","",$field);
        }
        return $field;
    }
}
//convert model select str to array
// if(!function_exists('selectFieldToArray')){
//     function selectFieldToArray($sql_selector)
//     {
//         $haystack = $sql_selector;
//         $endIdx =0;
//         $result ="";

//         $sw = true;
//         while($sw === true)
//         {
//             $startIdx =strpos($haystack, ".",$endIdx)+1;
//             $endIdx =strpos($haystack, ",",$startIdx)-1;
//             if($endIdx === -1)
//             {
//                 $sw = false;
//                 $endIdx = strlen($haystack)-1;
//             }
//             $tmp = substr($haystack,$startIdx,$endIdx-$startIdx+2);
//             if(strpos($tmp,"*") > -1)
//             {
//                 continue;
//             }
//             else if(strpos($tmp,"'") > -1)
//             {
//                 $tmp2 ="";
//                 if(strpos($tmp,",") > -1)
//                 {
//                     $tmp2 = ",";
//                 }
//                 $startIdx2 =strpos($tmp, "'",0)+1;
//                 $endIdx2 =strpos($tmp, "'",$startIdx2)-1;
//                 $tmp = substr($tmp,$startIdx2,$endIdx2-$startIdx2+1);
//                 $tmp .= $tmp2;
//             }
//             else if(strpos($tmp," as "))
//             {
//                 $tmp2 ="";
//                 if(strpos($tmp,",") > -1)
//                 {
//                     $tmp2 = ",";
//                 }
//                 $startIdx2 =strpos($tmp, " as ",0)+4;
//                 $endIdx2 =strpos($tmp, ",",$startIdx2)-1;
//                 if($endIdx2 === -1)
//                 {
//                     $sw = false;
//                     $endIdx2 = strlen($tmp)-1;
//                 }
//                 $tmp = substr($tmp,$startIdx2,$endIdx2-$startIdx2+1);
//                 $tmp .= $tmp2;
//             }
//             $tmp = str_replace(" ","",$tmp);
//             $result .= $tmp;
//         }
//         $result=explode(",",$result);
//         // var_dump($result);
//         return $result;
//     }
// }
if(!function_exists('set_active')){
    function set_active(string $names,string $values,string $str){
        $ci = &get_instance();
        $names = explode (",",$names);
        $values = explode (",",$values);
        if(count($names) !== count($values)) return "";
        for ($i=0; $i < count($names); $i++) { 
            $value =$ci->input->get_post($names[$i]);
            if($value === null) return "";
            if($values[$i] !== $value) return "";
        }
        return $str;
    }
}
//ready to overloading
if(!function_exists('my_date')){
    function my_date(...$params)
    {
        $func = "my_date".count($params);
        return $func($params);
    }
}

//my_date() overloading
if(!function_exists('my_date2')){
    function my_date2( ...$params)
    {
        $params =$params[0];
        $foramt =$params[0];
        $cal=$params[1];
        return date($foramt,strtotime($cal, strtotime(Date($foramt))));
    }
}
//my_date() overloading
if(!function_exists('my_date3')){
    function my_date3( ...$params)
    {
        $params =$params[0];
        $date =$params[0];
        $foramt =$params[1];
        $cal=$params[2];
        return date($foramt,strtotime($cal, strtotime($date)));
    }
}

if(!function_exists('my_set_value')){
    function my_set_value($obj,$name=null){
        $ci = &get_instance();
        if(isset($_POST[$name])){
            return $_POST[$name];
        }
        else if ($obj === null)
        {
            return "";
        }
        else if(is_object($obj)&&property_exists($obj,$name) ){
                return $obj->$name;
        }
        else if( is_string( $obj) && isset($obj) && $obj !== null)
        {
            return $obj;
        }
        else
        {
            return '';
        }
    }
}
if(!function_exists('my_set_value_input')){
    function my_set_value_input(string $name,$idx = 0){
        $ci = &get_instance();
        $value= $ci->input->get_post($name);
        if(!is_array($value)) //array로 들어올경우 idx0 으로 받음
        {
            return $value;
        }
        else
        {
            return $value[$idx];
        }
    }
}


if(!function_exists('my_set_checked')){
    function my_set_checked($obj, $name,$value,$default = false,$splitChar=null){
        $value = (string)$value;
        if(isset($_POST[$name])){
            if($_POST[$name]  === $value)
            return "checked";
            if(is_array($_POST[$name]))
            {
                foreach ($_POST[$name] as $key2 => $value2) {
                    if($value2 === $value)
                    return "checked";
                }
            }
        }
        else if(!isset($_POST[$name]) && property_exists($obj,$name)){
            if($splitChar!==null)
            { 
                $arr=explode($splitChar,$obj->$name) ;
                foreach ($arr as $key2 => $value2) {
                    if($value === $value2)
                        return "checked";
                }
            }
            if($value === $obj->$name)
                return "checked";
        }
        else if($default === true)
        {
            return "checked";
        }
        else if(!isset($_POST[$name]) && !property_exists($obj,$name) ){
            return '';
        }
    }
}

if(!function_exists('my_set_checked_arr')){
    function my_set_checked_arr($rows,$key,$value){
        foreach($rows as $row)
        {
            if($row->$key ===$value)
            {
                echo "checked";
                break;
            }
        }
    }
}

if(!function_exists('my_set_selected')){
    function my_set_selected($obj, $name,$value){
        $value = (string)$value;
        if(isset($_POST[$name]) && $_POST[$name]  === $value){
            return "selected";
        }
        else if(isset($_GET[$name]) )
        {
            if(!is_array($_GET[$name]))
            {
                if(urldecode($_GET[$name])  === $value)
                    return "selected";
            }else
            {
                if(urldecode($_GET[$name][0])  === $value)
                return "selected";
            }
        }
        else if(is_string($obj) && $obj === $value)
        {
            return "selected";
        }
        else if( $obj === null){
            return '';
        }
        else if(!isset($_POST[$name]) && !property_exists($obj,$name)){
            return '';
        }
        else if(!isset($_POST[$name]) && property_exists($obj,$name) && $value === $obj->$name){
            return "selected";
        }
      

    }
}






if(!function_exists('alert')){
    function alert($msg){
        ?> <script>alert('<?=$msg?>')</script><?php
    }
}

