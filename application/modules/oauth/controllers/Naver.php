<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."modules/oauth/core/Oauth.php";
class Naver extends Public_Controller {

    function __construct(){
        parent::__construct();
    }
    
    function request_auth()
    {
        
        if(is_login())
        {
            alert("로그인중입니다.");
            redirect("");    
            exit;
        }
        $this->load->library("naver_login");
        $this->naver_login->request_auth();
    }
    function login_callback()
    {
        if(is_login())
        {
            alert("로그인중입니다.");
            redirect("");    
            exit;
        }
       $this->load->library("naver_login");
       $auth_result=$this->naver_login->login_callback();
    //    var_dump($auth_result);
    //    var_dump($auth_result->access_token);
       $result=$this->naver_login->get_user_profile($auth_result->access_token);
    //    var_dump($result);
    //    return;
       if($result === null)
       {
           echo "<script>window.opener.alert('오류. 죄송합니다. 다른 로그인을 이용해주세요.');</script>";
            echo "<script>window.close();</script>";
            return;
       }
       if($result->resultcode !== "00")
       {
        echo "<script>window.opener.alert('오류. 죄송합니다. 다른 로그인을 이용해주세요.');</script>";
        echo "<script>window.close();</script>";
        return;
       }
       if($result->message === "success") //프로필 받아오기 성공이라면
       {

           $info = $result->response;
           $this->load->model("sns_info_model");
           $this->load->model("base/users_model");
           $sns_info =$this->sns_info_model->_get(array("sns_email"=>$info->email,"sns_type"=>"naver"));
        //    var_dump($info->id);
        //    var_dump($sns_info);
           if($sns_info === null) //해당 프로필이 로컬 db에 존재하지 않는다면
           {
               
                $this->db->set("name",$info->name);
                $this->db->set("profilePhoto",$info->profile_image);
                $this->db->set("userName",$info->email);
                $this->db->set("sns_type","naver");
                $this->db->set("email",$info->email);
                $this->db->set("birth",$info->birthday);
                $this->db->set("sex",$info->gender);
                $this->db->set("auth","1");
                $this->db->set("kind","general");
                $insert_id=$this->users_model->_add();

                $this->db->set("user_id",$insert_id);
                $this->db->set("sns_id",$info->id);
                $this->db->set("sns_type","naver");
                $this->db->set("sns_name",$info->name);
                $this->db->set("sns_email",$info->email);
                $this->db->set("sns_profile",$info->profile_image);
                $this->db->set("refresh_token",$auth_result->refresh_token);
                $this->sns_info_model->_add();

               
           }
           else if((string)$sns_info->refresh_token !== (string)$auth_result->refresh_token || (string)$sns_info->sns_id !== (string)$info->id)//로컬디비의 refresh token 과 일치 하지않는다면
           {
                $this->db->set("refresh_token",$auth_result->refresh_token);
                $this->db->set("sns_id",$info->id);
                $this->db->where("sns_email",$info->email);
                $this->db->where("sns_type",'naver');
                $this->sns_info_model->_update();
           }

           //로그인 시키고 리다이렉트
           $user_id =  $this->sns_info_model->_get(array("sns_id"=>$info->id))->user_id;
           $user = $this->users_model->_get($user_id);
        //    var_dump($user);
          
           $this->session->set_userdata(array('is_login'=>'true','user_id'=>$user->id,'userName'=>$user->userName,'auth'=> $user->auth));
           $url = $this->input->get("return_url");
           echo "<script>window.opener.location.href='{$url}';</script>";
           echo "<script>window.close();</script>";
       }
    //    var_dump($result);
    //     var_dump($info);
    // $result->access_token;
    //    $result->refresh_token;
    }
}