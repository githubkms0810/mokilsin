<?php
namespace oauth;
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends \Public_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('oauth_m');
		
		$this->load->library('oauth_facebook');
		$this->oauth_facebook->client_id = $this->setting->oauth_facebook_client_id;
		$this->oauth_facebook->client_secret = $this->setting->oauth_facebook_secret_id;
		$this->oauth_facebook->redirect_uri = $this->setting->oauth_facebook_redirect_url;
		
	}
	function request_auth()
	{
		if($this->userstate->isLogin() === true)
        {
            alert("로그인중입니다.");
            redirect("");    
            exit;
        }

		$this->oauth_facebook->request_auth();
	}
	function redirect_url()
	{
		//정보받아오기
        $auth_result =$this->oauth_facebook->login_callback();
		$access_token=$auth_result->access_token;
		$refresh_token= isset($auth_result->refresh_token) ? $auth_result->refresh_token: null;

		$info=$this->oauth_facebook->get_user_profile($access_token);
		
		////
		$oauth =$this->oauth_m->get_bySnsId($info->id);

		if(isset($oauth) === false)
		{
			$oauth =null;
			$oauth_user_id = null;
		} 
		else
		{
			$oauth_user_id = $oauth->user_id;
		}
		
		if($oauth !== null && $oauth_user_id !== null) //회원가입 되어있을떄 로그인시키기
		{
			$this->load->model('user/user_m');
			$userName=$this->user_m->p_get($oauth_user_id,'userName')->userName;
			$this->userstate->login($userName);
			
			$url = site_url("/");
			echo "<script>window.opener.location.href='{$url}';</script>";
			echo "<script>window.close();</script>";
			exit;
		}
		else //회원가입 안됐을떄 회원가입시키기
		{
			//회원가입 페이지 띄우고, 이메일인증 세션 되어있고, 기본데이터 입력되어있꼬
			//아디비번만 적고 회원가입 가능하게
			if($oauth === null) //oauth db데이터가 없을떄  추가
			{
				$oauth_id =$this->oauth_m->add_withFacebook($info);
				
			}
			elseif($oauth !== null && $oauth_user_id === null) //ouath db 데이터는 있는데 user_id로 연결이 안되어있을떄 가져오기
			{
				$oauth_id = $oauth->id;
			}
			//oauth 인증 플레시 데이터 저장후 회원가입페이지로 리다이렉션
			$this->session->set_flashdata('oauth_id',$oauth_id);

			$url = site_url("/user/add");
			// redirect($url);
			echo "<script>window.opener.location.href='{$url}';</script>";
			echo "<script>window.close();</script>";
			return;
		}
	
	}

}

/* End of file Google.php */
/* Location: .//C/Users/이재윤/Desktop/01shortcut/modules/api/controllers/Google.php */