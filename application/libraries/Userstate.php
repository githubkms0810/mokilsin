<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Userstate
{
    private $ci;
    private $CI;
    public $user =null;
    public function __construct()
    {   
        $this->ci=&get_instance();
        $this->ci->load->library("session");
    }
    public function requestLogin()
    {
        if(!$this->isLogin())
        {
            $this->ci->load->library("ajax_helper");
            $this->ci->ajax_helper->set_flashMessage("로그인이 하셔야합니다.","info");
            my_redirect("/user/login?return_url=".urlencode(my_current_url()));
            exit;
        }
    }
    public function requestLogin_withAjax()
    {
        if(!$this->isLogin())
        {
            $this->ci->ajax_helper->headerJson();
            $this->ci->load->library("ajax_helper");
            $this->ci->ajax_helper->set_flashMessage("로그인이 하셔야합니다.","info");
            $data["redirect"] = my_site_url("/user/login?return_url=".urlencode($this->ci->input->get("return_url")));
            $this->ci->ajax_helper->json($data);
            exit;
        }
    }
    public function reset_flashdataAuth()
    {
        if($this->ci->session->flashdata('phone_auth') !== null && $this->ci->session->flashdata('phone') !== null) //이메일 인증 되어있을떄
        {
            $this->ci->session->set_flashdata('phone',$this->ci->session->flashdata("phone"));
            $this->ci->session->set_flashdata('phone_auth',true);
        }
        if($this->ci->session->flashdata('email_auth') !== null && $this->ci->session->flashdata('email') !== null) //이메일 인증 되어있을떄
        {
            $this->ci->session->set_flashdata('email',$this->ci->session->flashdata("email"));
            $this->ci->session->set_flashdata('email_auth',true);
        }
    }
    public function is_phoneAuth()
    {
        $auth =$this->ci->session->flashdata('phone_auth');
        if($auth === null)
        {
            return false;
        }
        return $auth;
    }
    public function is_emailAuth()
    {
        $auth =$this->ci->session->flashdata('email_auth');
        if($auth === null)
        {
            return false;
        }
        return $auth;
    }

    public function is_flashdataUserPassword()
    {
        if($this->ci->session->flashdata('user_password') !== null)
        {
            return true;
        }
        return false;
    }
    public function get_flashdataUserPassword()
    {
        return $this->ci->session->flashdata('user_password');
    }
    public function reset_flashdataUserPassword()
    {
        if($this->is_flashdataUserPassword() === true)
        {
            $this->ci->session->set_flashdata('user_password',$this->ci->session->flashdata('user_password'));
        }
    }

 
    public function is_flashdataOauth()
    {
        if($this->ci->session->flashdata('oauth_id') !== null)
        {
            return true;
        }
        return false;
    }
    public function get_flashdataOauth()
    {
        return $this->ci->session->flashdata('oauth_id');
    }
    public function reset_flashdataOauth()
    {
        if($this->is_flashdataOauth() === true)
        {
            $this->ci->session->set_flashdata('oauth_id',$this->ci->session->flashdata('oauth_id'));
        }
    }


    public function contentIsMe(string $bool)
    {
        if($this->isAdmin())
        {
            return false;
        }
        if($bool === "0")
        {
            return false;
        }
        
        return true;
    }
    public function authKind($authKind){
        if($authKind === 'all')
        {
              return true;
        }
       $ci = &Public_Controller::$instance;
      $user_kind=$ci->user->kind;
      if($authKind !== $user_kind && !$this->isAdmin()){
          return false;
      }
      return true;
   }
   public function verifySecret($is_secret,$user_id)
   {
        if($is_secret === "1")
        {
            if($this->isGuest() === true)
            {
                return false;
            }
            if($this->isMe($user_id) === false)
            {
                return false;
            }
        }
        return true;
   }
    public function isMe($userId)
    {
        if($this->user->id === $userId ||$this->isAdmin() )
        {
            return true;
        }
        return false;
    }
    public function minLv($authLv)
    {
        $userLv=$this->user->auth;
        if($userLv < $authLv &&  !$this->isAdmin()){
            return false;
        }
        return true;
    }

    public function isGuest()
    {
        if($this->isLogin() === false)
        {
            return true;
        }
        return false;
    }
    public function isDeveloper()
    {
        
        if(self::isLogin() === false)
        {
            return false;
        }
        if($this->user->kind === "developer")
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function isAdmin()
    {
        if(self::isLogin() === false)
        {
            return false;
        }
        if($this->user->kind === "admin" || $this->isDeveloper())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function userInfo()
    {
        $user = (object)array();
        $user->id = $this->user->id;
        $user->userName = $this->user->userName;
        $user->name = $this->user->name;
        $user->displayName = $this->user->displayName;
        $user->api_key = $this->user->api_key;
        $user->point = $this->user->point;
        return $user;
    }
    public function logout()
    {
         $this->ci->session->sess_destroy();
    }

    public function loginById(string $user_id)
    {
        $this->ci->session->set_userdata(array("id"=>$user_id,"isLogin"=>true));
        
        
    }
    // public function login(string $userName)
    // {
    //      $this->ci->session->set_userdata(array("userName"=>$userName,"isLogin"=>true));
    // }
    public function whatLoginUserId()
    {
        return $this->ci->session->userdata("id");
    }
    // public function whoLogin()
    // {
    //     return $this->ci->session->userdata("userName");
    // }
    public function isLogin()
    {
        if($this->ci->session->userdata("isLogin") === true)
        { 
            return true;
        }
        return false;
    }
    public function isWithDraw()
    {
        if($this->user === null)
        {
            return false;
        }
        if($this->user->is_display === "0")
        {
            return true;
        }
        return false;
    }
    public function isExistUser()
    {
        if($this->user === null || !isset($this->user) )
        {
            return false;

        }
        if($this->user->userName === null && $this->user->phone === null && $this->user->email === null)
        {
            return false;
        }
        if($this->user->id === "0")
        {
            return false;
        }
        return true;

    }
    public function loginAuth($password)
    {	
        if($this->user === null)
            return false;
            
		$hash =$this->user->password;
        if(password_verify($password,$hash) === true)
        {
            $this->loginById($this->user->id);
            return true;
        }
        else
        {
            return false;
        }
    }
}