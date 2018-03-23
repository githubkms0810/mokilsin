<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_kakao extends Oauth
{

	public function __construct()
	{
		parent::__construct();
        $return_url = $this->ci->input->get("return_url");
		// $this->client_id = "f8b231990d627251d1cf499af779b300";
        // $this->redirect_uri = domain_url()."/index.php/api/kakao/redirect_url";
        // $this->client_secret= "RQgIlFx7cT6n8P1A2bUtoU4U8d3x8AZv";
        //
		// if($return_url !== null)
		// {
			// $this->redirect_uri .= "?return_url={$return_url}";
		// }

	}

	function request_auth()
	{
        $host ="https://kauth.kakao.com";
        $url ="/oauth/authorize?client_id={$this->client_id}&redirect_uri={$this->redirect_uri}&response_type=code";
		redirect($host.$url);
	}
	
	function login_callback()
	{
		$ci = &get_instance();
		$this->code = $ci->input->get("code");
		$post ="";
		$post .="code={$this->code}";
		$post .="&client_id={$this->client_id}";
		$post .="&client_secret={$this->client_secret}";
		$post .="&redirect_uri={$this->redirect_uri}";
		$post .="&grant_type=authorization_code";
		$url = "https://kauth.kakao.com/oauth/token";
		$result=$this->curl($url,$post);
		return $result;

	
	}
	function get_user_profile($accsess_token)
    {

		$this->user_profile_url = "https://kapi.kakao.com/v1/api/talk/profile";

        $result = $this->curl_bearer($this->user_profile_url,$accsess_token);
        $result = json_decode($result);
        return $result;
	}
	

}

/* End of file Google.php */
/* Location: .//C/Users/이재윤/Desktop/01shortcut/03libraries/Google.php */
