<?php 
namespace captcha;
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."/libraries/captcha/ICaptchaSolver.php");
class ToCaptcha implements ICaptchaSolver
{
    protected $ci;
    public $apiKey;
    public $domain ="2captcha.com";
    public $pingbackUrl;
    public $post_result;
    public $status;
    public $captcha_id;

    public function __construct($apiKey)
    {
        foreach ($apiKey as $key => $value) {
            $this->$key = $value;
        }
        $this->ci =& get_instance();
        $this->ci->load->helper('url');
        $this->pingbackUrl = site_url("/api/captcha/callback");
        $this->ci->load->library('upload');
        $this->ci->load->library('curl');
        
    }

    public function registPingback()
    {
        $url = "http://2captcha.com/res.php?key={$this->apiKey}&action=add_pingback&addr={$this->pingbackUrl}";
        return  $this->ci->curl->get($url);
    }
    public function deletePingback(string $url)
    {
        $url = "http://2captcha.com/res.php?key={$this->apiKey}&action=del_pingback&addr={$url}";
    }
    public function deleteAllPingback()
    {
        $url = "http://2captcha.com/res.php?key={$this->apiKey}&action=del_pingback&addr=all";
        return  $this->ci->curl->get($url);
    }
    public function getPingback()
    {
        $url ="http://2captcha.com/res.php?key={$this->apiKey}&action=get_pingback&json=1";
        return $this->ci->curl->get($url);
    }
    public function report(string $captcha_id)
    {
        $url = "http://{$this->domain}/res.php?key={$this->apiKey}&action=reportbad&id={$captcha_id}";
        return $this->ci->curl->get($url);
    }
    public function request()
    {
        $data['file']  =new \CurlFile( $_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
        $data['key'] = $this->apiKey;
        $data['method'] = 'post';
        // $data['pingback'] = site_url("/test");
        $data['pingback'] = $this->pingbackUrl;

        $url = "http://{$this->domain}/in.php";
        $this->post_result=$this->ci->curl->post($url,$data);
        list($this->status, $this->captcha_id) = explode("|", $this->post_result);
        return (object)["status"=>$this->status,"captcha_id"=>$this->captcha_id,"code"=>""];
    }
    public function isError(string $captcha_code)
    {
        if(strpos($captcha_code,"ERROR") >-1 ||  strpos($captcha_code,"REPORT") >-1)
        {
            return true;
        }
        return false;
    }
    public function response(string $captchaId)
    {
        $this->ci->load->model("captcha/captcha_m");
        return $captchaInfo=$this->ci->captcha_m->p_get(["captcha_id"=>$captchaId]);
    }

}

/* End of file LibraryName.php */

?>