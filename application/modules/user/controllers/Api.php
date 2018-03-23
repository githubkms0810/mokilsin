<?php 
namespace user;
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends \Api_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_m');
        // $this->list = true;
        // $this->get = true;
    }

    public function login()
    {
        $this->ajax_helper->headerJson();
        if($this->input->method() !== "post")
        {
            $data['result'] = 405;
            $this->ajax_helper->json($data);
            return;
        }
        if($this->userstate->isLogin() === true) //forbbidn login user
        {
            $data['result'] = "이미 로그인 중입니다.";
            $this->ajax_helper->json($data);
            return;
        }
        
        $u_e_p = strtolower($this->input->post("userName_orEmail_orPhone"));
        $password=strtolower($this->input->post("password"));

        $this->user_m->set_rules_userName_orEmail_orPhone();
        $this->user_m->set_rules_password();
        if ($this->form_validation->run() === false) 
        {
            $data['result'] = $this->form_validation->errors();
        }
        else
        {
            $this->userstate->user = $this->user_m->getBy_userName_orEmail_orPhone($u_e_p);
            if($this->userstate->isWithDraw() === true)
            {
                $data["result"] ="탈퇴한 회원입니다.";
            }
            else if($this->userstate->isExistUser()===false)
            {
                $data['result'] ="아이디가 존재하지 않습니다.";
            }
            else if($this->userstate->loginAuth($password)===false)
            {
                $data['result'] ="비밀번호가 일치하지 않습니다.";
            }
            else
            {
                if($this->userstate->user->api_key === null)
                {
                    $this->user_m->refresh_apiKey($this->userstate->user->id);
                    $this->userstate->user = $this->user_m->getBy_userName_orEmail_orPhone($u_e_p);
                }
                $data["data"] = $this->userstate->userInfo();
                $data["result"] = "success"; 
            }
        }
      
        $this->ajax_helper->json($data);
    }
    
   
}
/* End of file Api.php */
?>