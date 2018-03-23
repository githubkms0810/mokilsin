<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Curl
{
    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }


    public function post($url, $data)
    {
        // $data['file']  =new \CurlFile( realpath("public/uploads/user/images/$fileName"), $_FILES["files"]["type"][0], $_FILES["files"]["name"][0]);
    
        // $data["file"] = realpath("public/uploads/user/images/$fileName");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $result=curl_exec ($ch);
        curl_close ($ch);
        return $result;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); //seconds
        $result=curl_exec ($ch);
        curl_close ($ch);
        return $result;
    
    }
    public function get($url)
    {
        $ch = curl_init();
        // Set query data here with the URL
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); //seconds
        $content = trim(curl_exec($ch));
        curl_close($ch);
        return $content;
    }
    

}

/* End of file Curl.php */

?>