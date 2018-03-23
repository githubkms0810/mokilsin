<?php
namespace oauth;
defined('BASEPATH') OR exit('No direct script access allowed');

class Oauth extends \Public_Controller {

    public $type;
	public function __construct($type)
	{
        parent::__construct();
        $this->type = $type;
		$this->load->model('oauth_m');
		
		$this->load->library("oauth_{$type}",null,"libOauth");
		$this->libOauth->client_id = $this->setting->{"oauth_".$type."_client_id"};
		$this->libOauth->client_secret = $this->setting->{"oauth_".$type."_secret_id"};
		$this->libOauth->redirect_uri = $this->setting->{"oauth_".$type."_redirect_url"};
		
	}
	function request_auth()
	{
		$this->libOauth->request_auth();
	}
	function redirect_url()
	{
		//정보받아오기
        $auth_result =$this->libOauth->login_callback();
		$access_token=$auth_result->access_token;
		$refresh_token= isset($auth_result->refresh_token) ? $auth_result->refresh_token: null;

		$info=$this->libOauth->get_user_profile($access_token);
		////
		$oauth =$this->oauth_m->get_bySnsId($info->id);

        //회원가입 되어있을떄 로그인시키기고 exit
        if($this->userstate->isLogin() === false && $oauth !== null) 
		{
			if(isset($oauth->user_id))
				$this->_loginByOauthUserId($oauth->user_id);
        }
		//---연동및 회원가입
         //oauth db데이터가 없을떄  추가
        if($oauth === null)
        {
            $oauth_id =$this->oauth_m->{"add_with".ucfirst($this->type)}($info);
			$oauth =$this->oauth_m->p_get($oauth_id);
        }
	
		//user_id연결 안되어있고 이미 가입되어있는 같은 메일이 존재할떄 연결+로그인하고 exit
		$this->_ifAlreadyExistEmail($oauth);

		//로그인유저가 연동시도할떄
		if($this->userstate->isLogin() === true)
		{
			//계정이 이미 연동되어있는 sns계정이있을떄 exit
			if($this->oauth_m->isExist($this->user->id,$this->type) === true)
			{
				$this->session->set_flashdata('message',["message"=>"해당계정은 이미 {$this->type}계정과 연동되어있습니다.","type"=>"success"]);
				$url = my_site_url("/user/get");
				echo "<script>window.opener.location.href='{$url}';</script>";
				echo "<script>window.close();</script>";
				exit;
			}
			//해당sns계정이 다른계정과 연동되어있을떄
			if($oauth->user_id !== null) 
			{
		
				$this->session->set_flashdata('message',["message"=>"이미 {$oauth->userName}과 연동 되어있는 계정입니다..","type"=>"info"]);
				$url = my_site_url("/user/get");
				echo "<script>window.opener.location.href='{$url}';</script>";
				echo "<script>window.close();</script>";
				exit;
			}
			//연동
			$this->db->trans_start();	
			$this->db->set("user_id",$this->user->id);
			$this->oauth_m->p_update($oauth->id);
			$this->db->trans_complete();
			$this->session->set_flashdata('message',["message"=>"연동성공.","type"=>"success"]);
			$url = my_site_url("/user/get");
			echo "<script>window.opener.location.href='{$url}';</script>";
			// echo "<script>window.location.reload();</script>";
			echo "<script>window.close();</script>";
			exit;
		
		}

		//oauth 인증 플레시 데이터 저장후 회원가입페이지로 리다이렉션
        $this->session->set_flashdata('email',$oauth->email);
        $this->session->set_flashdata('email_auth',true);
        $this->session->set_flashdata('oauth_id',$oauth->id);

        $url = my_site_url("/user/add");
        // redirect($url);
        echo "<script>window.opener.location.href='{$url}';</script>";
        echo "<script>window.close();</script>";
        return;

	}
	private function _loginByOauthUserId($oauth_user_id)
	{
		$this->load->model('user/user_m');
		$user=$this->user_m->p_get($oauth_user_id,'displayName');
		$displayName= $user->displayName;
		$this->userstate->loginById($oauth_user_id);
		
		$this->session->set_flashdata('message',["message"=>"{$displayName}님 환영합니다.","type"=>"success"]);
		$url = my_site_url("/");
		echo "<script>window.opener.location.href='{$url}';</script>";
		echo "<script>window.close();</script>";
		exit;
	}
	private function _ifAlreadyExistEmail($oauth)
	{
		if(isset($oauth->email) && $oauth->user_id === null)
        {
			$this->load->model('user/user_m');
			
            $user  = $this->user_m->p_get(['email'=>$oauth->email]);
            if( $user !== null) // 존재한다면 업뎃하고 종료
            {
				$this->db->trans_start();	
				$this->oauth_m->linkUser($oauth_id,$user->id);
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) 
				{
					$this->session->set_flashdata('message',["message"=>"오류.","type"=>"success"]);

				}
				else
				{
					$this->session->set_flashdata('message',["message"=>"기존의 {$user->email}에 연동하였습니다.","type"=>"success"]);
					$this->userstate->loginById($user->id);
				}
				$url = my_site_url("/");
				echo "<script>window.opener.location.href='{$url}';</script>";
				echo "<script>window.close();</script>";
				exit;
            }
        }
	}
}

/* End of file Google.php */
/* Location: .//C/Users/이재윤/Desktop/01shortcut/modules/api/controllers/Google.php */