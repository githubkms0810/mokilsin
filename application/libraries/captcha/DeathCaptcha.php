<?php 
namespace captcha;
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."/libraries/captcha/ICaptchaSolver.php");
class DeathCaptcha implements ICaptchaSolver
{
    protected $ci;
    private $host = "http://api.dbcapi.me";
    private $username;
    private $password;
    private $apiInfo;
    private $result;
    public function __construct($usernameAndPassword)
    {
        foreach ($usernameAndPassword as $key => $value) {
            $this->$key = $value;
        }
        $this->ci =& get_instance();
        $this->ci->load->helper('url');
        $this->ci->load->library('upload');
        $this->ci->load->library('curl');
        $this->apiInfo =  Api::$apiInfo;
    }
    public function test()
    {
    }

    public function report(string $captcha_id)
    {
        $url = "{$this->host}/api/captcha/{$captcha_id}/report";
        $data['username'] = $this->username;
        $data['password'] = $this->password;
        parse_str( $this->ci->curl->post($url,$data),$out_arrResult);
        return (object)$out_arrResult;
        // $url = "http://{$this->domain}/res.php?key={$this->apiKey}&action=reportbad&id={$captcha_id}";
        // return $this->ci->curl->get($url);
    }

    public function request()
    {
        $data['captchafile']  =new \CurlFile( $_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
        $data['username'] = $this->username;
        $data['password'] = $this->password;
        $url = "{$this->host}/api/captcha";
        $this->RenderObjectResult( $this->ci->curl->post($url,$data));
        $this->IfSolveCaptchaAlterUserPointByApiKey($this->ci->input->post_get("key"));
        return $this->result;
    }

    public function response(string $captchaId)
    {
        if($this->TryGetCaptchaInfoByCaptchaId($captchaId,$captchaInfo))
        {
            return $captchaInfo;
        }
        else
        {
            
            $url = "{$this->host}/api/captcha/$captchaId";
            $this->RenderObjectResult($this->ci->curl->get($url));
            $this->UpdateCaptchaCodeById($this->result->code,$this->result->captcha_id);
            $this->IfSolveCaptchaAlterUserPointByCaptchaId($this->result->captcha_id);
            return $this->result;
        }
    }
    private function UpdateCaptchaCodeById($code,$captchaId)
    {
        $this->ci->load->model("captcha/captcha_m");
        $this->ci->db->set("code",$code);
        $this->ci->captcha_m->p_update(["captcha_id"=>$captchaId]);
    }
    private function TryGetCaptchaInfoByCaptchaId($captchaId,& $output)
    {
        $this->ci->load->model("captcha/captcha_m");
        $captchaInfo=$this->ci->captcha_m->p_get(["captcha_id"=>$captchaId]);
        if($captchaInfo->code !== "")
        {
            $output = $captchaInfo ;
            return true;
        }
        $output = null;
        return false;
    }
    private function RenderObjectResult($requestResult)
    {
        parse_str($requestResult,$out_arrResult);
        if($out_arrResult['status'] ==="0" )
            $status = "OK";
        else
            $status = "ERROR";
        $captchaId = $out_arrResult['captcha'];
        $code = $out_arrResult['text'];
        $isCorrect = $out_arrResult['is_correct'];
        $this->result = (object)["status" =>$status,"captcha_id"=>$captchaId,"code"=>$code,"isCorrect"=>$isCorrect];
       
        return $this->result;
    }
    private function IfSolveCaptchaAlterUserPointByCaptchaId($captcha_id)
    {
        if($this->result->code !== "")
        {
            $this->ci->load->model("captcha/captcha_m");
            $captcha = $this->ci->captcha_m->p_get(["captcha_id"=>$captcha_id],"user_id");
            $this->ci->user_m->alterPoint($this->apiInfo->price,"-",$captcha->user_id);
        }
    }

    private function IfSolveCaptchaAlterUserPointByApiKey($apiKey)
    {
        if($apiKey === null) return;
        if($this->result->code !== "")
        {
            $this->ci->load->model("user/user_m");
            $user = $this->ci->user_m->getByApiKey($apiKey);
            $this->ci->user_m->alterPoint($this->apiInfo->price,"-",$user->id);
        }
        
    }

    public function isError(string $captcha_code)
    {
        if(strpos($captcha_code,"ERROR") >-1)
        {
            return true;
        }
        return false;
    }
    

}

/* End of file Deathcaptcha.php */

?>