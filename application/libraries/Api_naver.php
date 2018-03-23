<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_naver extends Oauth
{
   
    public $user_profile_url="https://openapi.naver.com/v1/nid/me";
    function __construct()
    {
        parent::__construct();
       
        $return_url = $this->ci->input->get("return_url");
        // $this->client_id = "1Vg1odukcxMCxqqwG6yO";
        // $this->redirect_uri = domain_url()."/index.php/api/naver/login_callback";
        if($return_url !== null)
        {
            $this->redirect_uri .= "?return_url={$return_url}";
        }
        // $this->client_secret= "sT5Sc7TfvZ";
    }
    private function generate_state()
    {
        $mt = microtime();
        $rand = mt_rand();
        $state = md5($mt . $rand);

        $ci = &get_instance();
        $ci->load->library("session");
        $ci->session->set_userdata(array("state"=>$state));
        return $state;
    }
    function request_auth()
    {
        $ci = &get_instance();
        $ci->load->helper("url");
        if($this->client_id === null || $this->redirect_uri === null)
        {
            echo "error : no define variable - $this->client_id or $this->redirect_uri";
            return false;
        }
        $redirect_uri =urldecode($this->redirect_uri);
        $state = $this->generate_state();
        $url = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$this->client_id."&redirect_uri=".$redirect_uri."&state=".$state;
        // $url = "https://nid.naver.com/oauth2.0/authorize?";
        // $url .= "client_id={$this->client_id}";
        // $url .= "&response_type=code";
        // $url .= "&redirect_uri={$redirect_uri}";
        // $url .= "&state={$state}";

        // var_dump($state);
        // var_dump($ci->session->userdata("state"));
        redirect($url);
        
    }
    
    function login_callback()
    {
        // 네이버 로그인 콜백 예제
        // $client_id = $this->client_id;
        // $client_secret = $this->client_secret;
        // $code = $_GET["code"];
        // $state = $_GET["state"];
        // $redirectURI = urlencode($this->redirect_uri);
        // $url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirectURI."&code=".$code."&state=".$state;
        // $is_post = false;
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, $is_post);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); //seconds
        // $headers = array();
        // $response = curl_exec ($ch);
        // $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       
        // curl_close ($ch);
        // return json_decode($response);

        $ci = &get_instance();
        $ci->load->library("session");
        $this->code = $ci->input->get("code");
        $this->state = $ci->input->get("state");

        // var_dump($this->state);
        // var_dump($ci->session->userdata("state"));
        if((string)$this->state === (string)$ci->session->userdata("state"))
        {
            $result = $this->curl("https://nid.naver.com/oauth2.0/token?client_id={$this->client_id}&client_secret={$this->client_secret}&grant_type=authorization_code&state={$this->state}&code={$this->code}");
            
            $this->accsess_token =$result->access_token;
            $this->refresh_token= $result->refresh_token;
            // var_dump($result);
            return $result;
        }
        else
        {
            echo "state값이 일치하지 않습니다.";
            return false;
        }
    }
    function get_user_profile($accsess_token)
    {
        // $token = $accsess_token;
        // $header = "Bearer ".$token; // Bearer 다음에 공백 추가
        // $url = "https://openapi.naver.com/v1/nid/me";
        // $is_post = false;
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, $is_post);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2); //seconds
        // $headers = array();
        // $headers[] = "Authorization: ".$header;
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // $response = curl_exec ($ch);
        // $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close ($ch);
        // return $response;

        $result=$this->curl_bearer($this->user_profile_url,$accsess_token);
        $result = json_decode($result);
        return $result;
    }
    // function delete_token()
    // {
    //     $this->curl("https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id={$this->client_id}&client_secret={$this->client_secret}&access_token={$this->accsess_token}&service_provider=NAVER");
        
    // }
  
}

