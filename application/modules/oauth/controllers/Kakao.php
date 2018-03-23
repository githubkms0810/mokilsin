<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."modules/oauth/core/Oauth.php";
class Kakao extends Public_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('kakao_api');
	}
	function request_auth()
	{
		if(is_login())
        {
            alert("로그인중입니다.");
            redirect("");    
            exit;
        }
		if(is_login())
        {
            alert("로그인중입니다.");
            redirect("");    
            exit;
        }

		$this->kakao_api->request_auth();
	}
	function redirect_url()
	{
        $auth_result =$this->kakao_api->login_callback();
        
        $access_token=$auth_result->access_token;
        $info=$this->kakao_api->get_user_profile($access_token);
        // var_dump($info);

		if($info == null)
		{
			 echo "<script>window.close();</script>";
			 return;
		}
		if(isset($info->nickName)) //프로필 받아오기 성공이라면
		{
		
			$name = null;
			$nickName = $info->nickName;
			$sns_id = null;
			$email = null;
			$gender =null;
			$sns_type = "kakao";
			$profile_img = $info->profileImageURL;
			$refresh_token= isset($auth_result->refresh_token) ? $auth_result->refresh_token: null;
			$this->load->model("sns_info_model");
			$this->load->model("base/users_model");
			$sns_info =$this->sns_info_model->_get(array("sns_nickName"=>$nickName,"sns_type"=>$sns_type));
		
			if($sns_info === null) //해당 프로필이 로컬 db에 존재하지 않는다면
			{
			
			
				 $this->db->set("name",$name);
				 $this->db->set("profilePhoto",$profile_img);
				 $this->db->set("userName",$email);
				 $this->db->set("sns_type",$sns_type);
				 $this->db->set("email",$email);
				//  $this->db->set("birth",$info->birthday);
				 $this->db->set("sex",$gender);
				 $this->db->set("auth","1");
				 $this->db->set("kind","general");
				 $insert_id=$this->users_model->_add();
 
				 $this->db->set("user_id",$insert_id);
				 $this->db->set("sns_id",$sns_id);
				 $this->db->set("sns_type",$sns_type);
				 $this->db->set("sns_name",$name);
				 $this->db->set("sns_email",$email);
				 $this->db->set("sns_nickName",$nickName);
				//  $this->db->set("sns_profile",$info->profile_image);
				 $this->db->set("refresh_token",$refresh_token);
				 $this->sns_info_model->_add();
 
				
			}
			else if((string)$sns_info->refresh_token !== (string)$refresh_token || (string)$sns_info->sns_id !== (string)$info->id)//로컬디비의 refresh token 과 일치 하지않는다면
			{
				 $this->db->set("refresh_token",$refresh_token);
				 $this->db->where("sns_nickName",$nickName);
				 $this->db->where("sns_type",'kakao');
				 $this->sns_info_model->_update();
			}
 
			//로그인 시키고 리다이렉트
			$user_id =  $this->sns_info_model->_get(array("sns_nickName"=>$nickName))->user_id;
			$user = $this->users_model->_get($user_id);
		    // var_dump($user);
		   
			$this->session->set_userdata(array('is_login'=>'true','user_id'=>$user->id,'userName'=>$user->userName,'auth'=> $user->auth));
			// $url = $this->input->get("return_url");
			$url = site_url("");
			echo "<script>window.opener.location.href='{$url}';</script>";
			echo "<script>window.close();</script>";
		}
	}

}

/* End of file Google.php */
/* Location: .//C/Users/이재윤/Desktop/01shortcut/modules/api/controllers/Google.php */