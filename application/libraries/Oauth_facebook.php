<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oauth_facebook extends Oauth
{

	public function __construct()
	{
		parent::__construct();
        $return_url = $this->ci->input->get("return_url");
        //설정
		// $this->client_id = "412089359205918";
		// $this->client_id = "1924648824231920";
        // $this->redirect_uri = domain_url()."/index.php/call/facebook/redirect_url";
        // $this->client_secret= "17d33df8f885bea57edbe5cb5fb42855";
        //
		// if($return_url !== null)
		// {
			// $this->redirect_uri .= "?return_url={$return_url}";
		// }

	}

	function request_auth()
	{
		$scope = "email";
		$queryString = "?";
		$queryString .= "scope={$scope}";
		$queryString .= "&redirect_uri={$this->redirect_uri}";
		$queryString .= "&client_id={$this->client_id}";
        $url ="https://www.facebook.com/v2.11/dialog/oauth".$queryString;
		redirect($url);
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
		$url = "https://graph.facebook.com/v2.11/oauth/access_token";
		$result=$this->curl($url,$post);
		return $result;

	
	}
	function get_user_profile($accsess_token)
    {

		$fields = "?";
		$fields .= "fields=name,email,gender";
		$this->user_profile_url = "https://graph.facebook.com/me".$fields;

        $result = $this->curl_bearer($this->user_profile_url,$accsess_token);
        $result = json_decode($result);
        return $result;
	}
	

}

/* End of file Google.php */
/* Location: .//C/Users/이재윤/Desktop/01shortcut/03libraries/Google.php */
