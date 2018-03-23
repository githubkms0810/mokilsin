<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_google extends Oauth
{

	public function __construct()
	{
		parent::__construct();
	
		$return_url = $this->ci->input->get("return_url");
		// $this->client_id = "348296456616-8p8uga1i5tnib1oq6f659b27pt3tr2nc.apps.googleusercontent.com";
		// $this->redirect_uri = domain_url()."/index.php/api/google/redirect_url";
		// $this->client_secret= "Xpi6VVpng0f75SXbt6tvEk8B";
		// if($return_url !== null)
		// {
			// $this->redirect_uri .= "?return_url={$return_url}";
		// }

	}

	function request_auth()
	{
		$scope = "";
		// Know the list of people in your circles, your age range, and language
		$scope .="https://www.googleapis.com/auth/plus.login";
		$scope .= " ";
		// View your basic profile info
		$scope .= "https://www.googleapis.com/auth/userinfo.profile";
		$scope .= " ";
		// View your street addresses
		$scope .= "https://www.googleapis.com/auth/user.addresses.read";
		$scope .= " ";
		// Manage your contacts
		$scope .= "https://www.googleapis.com/auth/contacts";
		$scope .= " ";
		// View your email addresses
		$scope .= "https://www.googleapis.com/auth/user.emails.read";
		$scope .= " ";
		// View your phone numbers
		$scope .= "https://www.googleapis.com/auth/user.phonenumbers.read";
		$scope .= " ";
		// View your email address
		$scope .= "https://www.googleapis.com/auth/userinfo.email";
		$scope .= " ";
		// View your contacts
		$scope .= "https://www.googleapis.com/auth/contacts.readonly";
		$scope .= " ";
		// View your complete date of birth
		$scope .= "https://www.googleapis.com/auth/user.birthday.read";
		$scope =rawurlencode($scope);
		$queryString = "?";
		$queryString .= "scope={$scope}";
		$queryString .= "&access_type=offline";
		$queryString .= "&include_granted_scopes=true";
		$queryString .= "&state=state_parameter_passthrough_value";
		$queryString .= "&redirect_uri={$this->redirect_uri}";
		$queryString .= "&response_type=code";
		$queryString .= "&client_id={$this->client_id}";
		$url ="https://accounts.google.com/o/oauth2/v2/auth".$queryString;

		redirect($url);
	}
	
	function login_callback()
	{
		$ci = &get_instance();
		$ci->load->library("session");
		$this->code = $ci->input->get("code");
		$post ="";
		$post .="code={$this->code}";
		$post .="&client_id={$this->client_id}";
		$post .="&client_secret={$this->client_secret}";
		$post .="&redirect_uri={$this->redirect_uri}";
		$post .="&grant_type=authorization_code";
		$url = "https://www.googleapis.com/oauth2/v4/token";
		$result=$this->curl($url,$post);
		return $result;
		

	
	}
	function get_user_profile($accsess_token)
    {
		$fieldName =  "personFields";
		$personFields ="?";
		$personFields .= "{$fieldName}=addresses";
		// $personFields .= "&{$fieldName}=ageRanges";
		// $personFields .= "&{$fieldName}=biographies";
		$personFields .= "&{$fieldName}=birthdays";
		// $personFields .= "&{$fieldName}=braggingRights";
		// $personFields .= "&{$fieldName}=coverPhotos";
		$personFields .= "&{$fieldName}=emailAddresses";
		$personFields .= "&{$fieldName}=genders";
		$personFields .= "&{$fieldName}=names";
		//more personFields info  https://developers.google.com/people/api/rest/v1/people/get

		$this->user_profile_url = "https://people.googleapis.com/v1/people/me".$personFields;

        $result = $this->curl_bearer($this->user_profile_url,$accsess_token);
        $result = json_decode($result);
        return $result;
	}
	

}

/* End of file Google.php */
/* Location: .//C/Users/이재윤/Desktop/01shortcut/03libraries/Google.php */
