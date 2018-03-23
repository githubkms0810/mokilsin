<?php 
namespace user;
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends \Base_Controller {

    public function __construct()
	{
        parent::__construct();
        $this->load->model('user_m');
        $this->get = true;
        $this->noDisplay = true;
    }

    public function noDisplay($id =null)
    {
        if($this->userstate->isLogin() === false)
        {
            alert("잘못된 접근");
            my_redirect("/");
            return;
        }


        if ($this->input->method() === "get") 
        {
            if($this->userstate->isLogin() === false)
            {
                alert("잘못된 접근");
                my_redirect("/");
                return;
            }
            $data["mode"] = "action=".my_site_url("/user/noDisplay")." method='post'";
            $data["content_view"] = "base/passwordVerify";
            $this->template->render($data);
            return;
        }
        //post
        $this->userstate->reset_flashdataUserPassword();
        if ( $this->userstate->get_flashdataUserPassword() !== $this->user->id && $this->_userAuth($this->user->id) === false) 
        {
            alert("비밀번호가 일치하지 않습니다.");
            my_redirect("$this->referer");
            exit;
        }
        $this->db->trans_start();
		$result = $this->{$this->modelName}->noDisplay();
		$this->db->trans_complete();
       
        if ($this->db->trans_status() === FALSE) 
        {
            $this->session->set_flashdata('message',["message"=>"오류.","type"=>"danger"]);
        }
        else
        {
            $this->userstate->logout();
            alert("탈퇴성공");
        }   

        my_redirect("/");
    }
    public function get($id=null)
    {
        return;
        if($this->userstate->isLogin() === false)
        {
            alert("잘못된 접근");
            my_redirect("/");
            return;
        }
       
        // $user=$this->user_m->p_get($this->user->id);
        parent::get($id);

    }
 
    public function login()
    {
        
        if($this->userstate->isLogin() === true && $this->userstate->isAdmin()) //forbbidn login user
        {
            redirect("admin/main/index");
            return;
        }
        if($this->input->method() === 'get') //get
        {
            $data["content_view"] = "base/login";
            $this->template->load("admin/template",$data);
            $this->template->render($data);
            return;
        }
        //post
        $this->ajax_helper->headerJson();

        // $data["alert"] = "1";
        // $this->ajax_helper->json($data);
        // return;
        $u_e_p = strtolower($this->input->post("userName_orEmail_orPhone"));
        $password=strtolower($this->input->post("password"));

        $this->user_m->set_rules_userName_orEmail_orPhone();
        $this->user_m->set_rules_password();
        if ($this->form_validation->run() === false) 
        {
            $data = $this->ajax_helper->get_messageData("유효성검사", $this->form_validation->errors("<br>"),"info");
        }
        else
        {
            $this->userstate->user = $this->user_m->getBy_userName_orEmail_orPhone($u_e_p);
            if($this->userstate->isWithDraw() === true)
            {
                $data = $this->ajax_helper->get_messageData("메세지","탈퇴한 회원입니다.","info");
            }
            else if($this->userstate->isExistUser()===false)
            {
                $data = $this->ajax_helper->get_messageData("메세지","아이디가 존재하지 않습니다.","info");
            }
            else if($this->userstate->loginAuth($password)===false)
            {
                $data = $this->ajax_helper->get_messageData("메세지","비밀번호가 일치하지 않습니다.","info");
            }
            else if($this->userstate->isAdmin() === true)
            {
                $this->ajax_helper->set_flashMessage("{$this->userstate->user->displayName}님이 로그인 하였습니다.");
                $data['redirect'] = get_returnURL(site_url("admin/main/index"));
            }
            else
            {
                $this->ajax_helper->set_flashMessage("{$this->userstate->user->displayName}님이 로그인 하였습니다.");
                $data['redirect'] = get_returnURL(site_url(""));
            }
            
        }
      
        
        $this->ajax_helper->json($data);
    }
  
    public function add()
    {
        if($this->userstate->isLogin() === true)
        {
            alert("이미 로그인 되어있습니다.");
            my_redirect("/");
            return;
        }
        //플레시데이터 유지
        $this->userstate->reset_flashdataAuth();
        $this->userstate->reset_flashdataOauth();

        if ($this->input->method() === "get") //get
        {
            $data['mode'] ="add";

            $oauth_id =$this->session->flashdata('oauth_id');

            $data['user'] = (object)[];
            if($oauth_id !== null)
            {
                $this->load->model('oauth/oauth_m');
                $data['user']=$this->oauth_m->p_get($oauth_id);
            }
            $data['user']->profile_image = "/public/images/unknown.png";

            $data["oauth_mode"] = "회원가입";
            $data["content_view"] = ["base/addUpdate","base/oauthBtn"];
            $this->template->render($data);
            return;
        }
        //post
        $this->ajax_helper->headerJson();

        $this->user_m->set_rules_add_base();
        if ($this->form_validation->run() === false) 
        {
            $data = $this->ajax_helper->get_messageData("유효성검사", $this->form_validation->errors("<br>"),"info");
        } 
        else 
        {
            $oauth_id =$this->session->flashdata('oauth_id');
            //이메일 인증안되어있을떄 && 소셜회원가입이 아니면 return
            if($this->userstate->is_emailAuth() === false && $this->setting->is_email_authentication_in_add_user === "1" &&  $oauth_id === null)
            {
                $data = $this->ajax_helper->get_messageData("메세지", "이메일 인증이 완료되지 않았습니다","info");
                $this->ajax_helper->json($data);        
                return;
            }
            //폰인증
            if($this->userstate->is_phoneAuth() === false && $this->setting->is_phone_authentication_in_add_user === "1")
            {
                $data = $this->ajax_helper->get_messageData("메세지", "휴대폰 인증이 완료되지 않았습니다","info");
                $this->ajax_helper->json($data);        
                return;
            }
        
            
            //db add시작
            $this->db->trans_start();		
            $insert_id= $this->user_m->add();
            
            $this->db->trans_complete();
            
            //트랜젝션 성공여부에 따라
            if ($this->db->trans_status() === FALSE) 
            {
                $data['alert'] = "오류. 다시시도하시길 바랍니다.";
                
            } 
            else 
            {
                $this->userstate->loginById($insert_id);
                $this->ajax_helper->set_flashMessage("환영합니다.","success");
                $data["result"] ="success";
                $data["redirect"] = get_redirect_return_url("/");
            }
           
        }
        $this->ajax_helper->json($data);
    }
    public function update($id =null)
    {
        return;
        //get
        if ($this->input->method() === "get") 
        {
            if($this->userstate->isLogin() === false)
            {
                alert("잘못된 접근");
                my_redirect("/");
                return;
            }
            $data["mode"] = "action=".my_site_url("/user/update")." method='post'";
            $data["content_view"] = "base/passwordVerify";
            $this->template->render($data);
            return;
        }
        //post
        //손님일떄 flashdata true유지하기
        $this->userstate->reset_flashdataUserPassword();
        //플레시 데이터 권한 검사, 비밀번호체크
        if ( $this->userstate->get_flashdataUserPassword() !== $this->user->id  && $this->_userAuth($this->user->id) === false) 
        {
            alert("비밀번호가 일치하지 않습니다.");
            my_redirect("$this->referer");
            return;
     
        }
        //수정 뷰
        if($this->input->is_ajax_request() === false)
        {
            if($this->_userAuth($this->user->id) === true)
            {
                $data['mode'] ="update";
                $data['user'] = $this->user;
                $data["content_view"] = "base/addUpdate";
                $this->template->render($data);
                return;
            }
        }

        //ajax post
        $this->ajax_helper->headerJson();
        
        $this->user_m->set_rules_update_base();
        //
        if ($this->form_validation->run() === false) 
        {
            $data = $this->ajax_helper->get_messageData("유효성검사", $this->form_validation->errors("<br>"),"info");
        } 
        else 
        {
            $this->user_m->update($this->user->id);
            $this->ajax_helper->set_flashMessage("정보가 수정되었습니다.");
            $data['redirect'] ="/user/get";
        }
        $this->ajax_helper->json($data);
    }
    public function logout()
    {
        $this->ajax_helper->headerJson();
        $this->userstate->logout();
        $this->ajax_helper->set_flashMessage("로그아웃 되었습니다.");
        $data["redirect"] ="/";
        $this->ajax_helper->json($data);
    }
    
    function phone_auth()
    {
        $this->userstate->reset_flashdataAuth();
        $this->userstate->reset_flashdataOauth();
        $data["mode"] = "phone";
        $phone = $this->input->get('phone');
        $this->form_validation->set_data(array("phone"=>$phone));
        $this->form_validation->set_rules("phone", "휴대폰", 'trim|required|numeric|is_unique[user.phone]', array('is_unique' => '%s는 이미 존재합니다.'));
        
        if ($this->form_validation->run() === false)  //이메일 유효성 실패
        {
            echo "<script>alert('".form_error("phone", false, false)."');window.close();</script>";
        } 
        else 
        { 
            if($this->input->method() === 'get') //get
            {
                $phone_auth_key= rand(1000, 9999);

                $this->session->set_flashdata( 'phone',$phone);
                $this->session->set_flashdata( 'phone_auth_key',$phone_auth_key);

                $to =$this->input->get('phone');
                $content = "[{$phone_auth_key}] 휴대폰 인증 키입니다.";

                if(DEBUG === true)
                {
                    alert($phone_auth_key);
                }
                else
                {
                    $this->load->library("sms_cafe24");
                    $this->sms_cafe24->secure = $this->setting->cafe24_sms_api_key;
                    $this->sms_cafe24->user_id = $this->setting->cafe24_userName;
                    $this->sms_cafe24->send("{$this->setting->cafe24_sms_number}",$to,$content);
                }
                
                //
                $data["msg"] = "해당 휴대폰으로 인증키를 보냈습니다. 확인해주세요.";
                $data["phone"] = $phone;
                $this->load->view('base/authentication',$data);

            }
            else if($this->input->method() === 'post') //POST
            { 
                if($this->session->flashdata("phone") === null) //어뷰징 방지
                {
                    echo "<script>alert('인증 중에 페이지 이동을 하지말아주세요.');window.close();</script>";
                }
                else if ((string)$this->input->post('phone_auth_key') !== (string)$this->session->flashdata('phone_auth_key')) //인증실패
                { 
                    $this->session->set_flashdata( 'phone',$this->session->flashdata("phone"));
                    $this->session->set_flashdata( 'phone_auth_key',$this->session->flashdata("phone_auth_key"));
                    $data["msg"] ="인증실패. 인증키를 확인해주세요.";
                    $data['phone'] =$phone;
                    $this->load->view('base/authentication',$data);
                }
                else  //인증성공
                {
                    $this->session->set_flashdata("phone_auth",true);
                    $this->session->set_flashdata( 'phone',$this->session->flashdata("phone"));
                    echo "<script>alert('휴대폰 인증 완료');window.close();</script>";
                }
            }
        }
    }

    function email_auth()
    {
        $this->userstate->reset_flashdataAuth();
        $this->userstate->reset_flashdataOauth();
        $data["mode"] = "email";

        $email = $this->input->get('email');
        $this->form_validation->set_data(array("email"=>$email));
        $this->form_validation->set_rules("email", $email, 'trim|required|valid_email|is_unique[user.email]', array('is_unique' => '%s는 이미 가입된 이메일입니다.'));
      
        if ($this->form_validation->run() === false)  //이메일 유효성 실패
        {
            echo "<script>alert('".form_error("email", false, false)."');window.close();</script>";
        } 
        else 
        { 
            if($this->input->method() === 'get') //get
            {
                $email_auth_key= rand(1000, 9999);

                $this->session->set_flashdata( 'email',$email);
                $this->session->set_flashdata( 'email_auth_key',$email_auth_key);

                $to =$this->input->get('email');
                $content = "[{$email_auth_key}] 이메일 인증 키입니다.";
                
                $subject = $this->input->server('HTTP_HOST')." 이메일 인증";
                $this->load->library('email');
                $this->email->from = "admin";
                if(DEBUG === true)
                    alert($email_auth_key);
                else
                    $this->email->send_email($to,$subject, $content);

                $data["msg"] = "해당 이메일로 인증키를 보냈습니다. 확인해주세요.";
                $data["email"] = $email;
                $this->load->view('base/authentication',$data);
            }
            else if($this->input->method() === 'post') //POST
            { 
                if($this->session->flashdata("email") === null) //어뷰징 방지
                {
                    echo "<script>alert('인증 중에 페이지 이동을 하지말아주세요.');window.close();</script>";
                }
                else if ((string)$this->input->post('email_auth_key') !== (string)$this->session->flashdata('email_auth_key')) //인증실패
                { 
                    $this->session->set_flashdata( 'email',$this->session->flashdata("email"));
                    $this->session->set_flashdata( 'email_auth_key',$this->session->flashdata("email_auth_key"));
                    $data["msg"] ="인증실패. 인증키를 확인해주세요.";
                    $data['email'] =$email;
                    $this->load->view('base/authentication',$data);
                }
                else  //인증성공
                {
                    $this->session->set_flashdata("email_auth",true);
                    $this->session->set_flashdata( 'email',$this->session->flashdata("email"));
                    echo "<script>alert('이메일 인증 완료');window.close();</script>";
                }
            }
        }
    }
    function find_userName()
    {
        if($this->userstate->isLogin() === true)
        {
            alert("잘못된 접근입니다.");
            my_redirect("/");
            return;
        }
        // $this->form_validation->set_rules("phone","폰 번호","required");
        $this->form_validation->set_rules("email","이메일","required");
         if($this->form_validation->run() === false)
         {
             $data['content_view'] = "base/find_userName";
             $this->template->render($data);
             return;
         }
         else
        {
            // $user = $this->users_m->p_get(array("phone"=>$this->input->post("phone")),array("userName"));
            $user = $this->user_m->p_get(array("email"=>post("email")),array("userName"));
            $data['userName'] = $user ? $user->userName : "존재하지않음"; 

            $data['content_view'] = "base/find_userName";
            $this->template->render($data);
            return;
         }
    }
    
    function find_password()
    {
        if($this->userstate->isLogin() === true)
        {
            alert("잘못된 접근입니다.");
            my_redirect("/");
            return;
        }
        
        $flashdataName= "find_password";

        //인증코드 재전송 or 처음부터
        if(post("resend_auth_code") === "1")
        {
            $this->form_validation->set_data(array("userName"=>post("userName")));
            if(isset($_SESSION[$flashdataName]))
            {
                unset($_SESSION[$flashdataName]);
            }
            if(isset($_SESSION["auth_code"]))
            {
                unset($_SESSION["auth_code"]);
            }
        }
        $this->form_validation->set_rules("userName","아이디","required");

     
        //아이디를 입력해주세요
        if($this->form_validation->run() === false && $this->session->userdata($flashdataName) === null)
        {
            $data['mode'] = "userName";
            $data['content_view'] = "base/find_password";
            $this->template->render($data);
        }
        else//input userName 입력
        {
            $userName =$this->input->post("userName");
            $user =$this->user_m->p_get(array("userName"=>$userName));
            //--아이디 존재하지 않음
            if($user === null && $this->session->userdata($flashdataName) === null)
            {
                //아이디 입력 view
                alert("해당 아이디가 존재하지 않습니다.");
                $data['mode'] = "userName";
                $data['content_view'] = "base/find_password";
                $this->template->render($data);
                return;
            }
            //--아이디존재 
            else
            {
              
                if($this->session->userdata($flashdataName) !== null)
                {
                    $user =$this->user_m->p_get(array("userName"=>  $this->session->userdata($flashdataName)));
                }
                $in_auth_code = $this->input->post("auth_code");
                //--input 인증코드 데이터 없을때   -> 인증코드 발송
                if($in_auth_code === null && $this->session->userdata($flashdataName) === null)
                {
                    $auth_code =rand(1000,9999); 
                    //인증코드 플래시세션 등록
                    $this->session->set_flashdata("auth_code", $auth_code);
                    $this->session->set_flashdata($flashdataName, $user->userName);
                    //인증코드 보내기
                    //--폰
                    // $this->load->library("sms_cafe24");
                    // $this->sms_cafe24->secure = $this->setting->cafe24_sms_api_key;
                    // $this->sms_cafe24->user_id = $this->setting->cafe24_userName;
                    // $from =$this->setting->cafe24_sms_number;
                    // $to = $user->phone;
                    // $desc = "[{$auth_code}] 비밀번호 재설정 인증 코드입니다.";
                    // $this->sms_cafe24->send($from,$to,$desc);
                    //--폰
                    //--이메일
                    $to =$user->email;
                    $content = "[{$auth_code}] 비밀번호 재설정 인증 코드입니다.";
                    
                    $subject = $this->input->server('HTTP_HOST')."비밀번호 재설정";
                    $this->load->library('email');
                    $this->email->from = "admin";
                    if(DEBUG === true)
                        alert($auth_code);
                    else
                        $this->email->send_email($to,$subject, $content);
    
                    //--이메일
                    //인증코드 입력 view
                    $data['mode'] = "auth_code";
                    $data["email"] =hideEmail($user->email);
                    $data["userName"] =$user->userName;
                    $data['content_view'] = "base/find_password";
                    $this->template->render($data);
                }
                //--input 인증코드 데이터 들어왔을떄 인증코드 맞는지 확인
                else 
                {
                    $this->session->set_flashdata("auth_code", $this->session->userdata("auth_code"));
                    $this->session->set_flashdata($flashdataName, $this->session->userdata($flashdataName));
                     //맞을경우
                    if((string)$in_auth_code === (string)$this->session->userdata("auth_code") ||  $this->session->userdata("auth_phone_or_email") === true) //--인증코드 일치할떄 //input userName,auth_code 값 존재
                    {
                        $this->session->set_flashdata("auth_phone_or_email", true);
                        $password = $this->input->post("password");
                        $re_password = $this->input->post("re_password");
                        //--패스워드 빈값  //input userName,auth_code 값 존재
                        if($password === null || $re_password === null)
                        {
                            //패스워드 입력 view
                            $data['mode'] = "password";
                            $data['content_view'] = "base/find_password";
                            $this->template->render($data);
                        }
                        //-- 패스워드 서로  불일치  //input userName,auth_code,password,re_password 값 존재
                        else if($password !== $re_password)
                        {
                            //패스워드 입력 view
                            alert("비밀번호가 일치하지 않습니다.");
                            $data['mode'] = "password";
                            $data['content_view'] = "base/find_password";
                            $this->template->render($data);
                        }
                         //--패스워드 일치 //input userName,auth_code,password,re_password 값 존재
                        else
                        {
                            $vali_pw = true;
                            if(strlen($password) < 4 || strlen($password) >20){
                                $vali_pw = false;
                            }
                            if($vali_pw === false )//유효성검사
                            {
                                alert("비밀번호는 4글자 이상 20글자 이하이여야 합니다.");
                                $data['mode'] = "password";
                                $data['content_view'] = "base/find_password";
                                $this->template->render($data);
                            }
                            else //패스워드 변경
                            {
                                $hash =password_hash($password, PASSWORD_BCRYPT);
                                $this->db->set("password",$hash);
                                $this->db->where("userName",$this->session->userdata($flashdataName));
                                $this->db->update("user");
                                alert("비밀번호가 변경되었습니다.");
                                my_redirect("/");
                            }
                        }
                        
                    }
                    else //--인증코드 불일치
                    {
                        //인증코드 세션다시
                        //인증코드 다시보내기 버튼
                        //인증코드 입력 view
                        alert("인증코드 불일치");
                        $data['mode'] = "auth_code";
                        $data["email"] =hideEmail($user->email);
                        $data["userName"] =$user->userName;
                        $data['content_view'] = "base/find_password";
                        $this->template->render($data);
                    }
                }
            }

        }
    
            
        
    }
    public function linkUser()
    {
        if($this->userstate->is_flashdataOauth() === false)
        {
            $data['notify']["title"] = "경고";
            $data['notify']["message"] = "잘못된 접근";
            $data['notify']["type"] = "danger";
            return;
        }
        //연동
        $this->userstate->reset_flashdataOauth();
        
        $u_e_p = strtolower($this->input->post("userName_orEmail_orPhone"));
        $password=strtolower($this->input->post("password"));
        // $userName=strtolower($this->input->post("userName"));
        // $this->user_m->set_rules_userName();
        
        
        $this->user_m->set_rules_password();
        
        if ($this->form_validation->run() === false) 
        {
            $data['notify']["title"] = "유효성검사";
            $data['notify']["message"] = $this->form_validation->errors("<br>");
            $data['notify']["type"] = "danger";
        }
        else
        {
            $this->userstate->user = $this->user_m->getBy_userName_orEmail_orPhone($u_e_p);
            // $this->userstate->user = $this->user_m->getByUserName($userName);
            if($this->userstate->isWithDraw() === true)
            {
                $data['notify']["title"] = "메세지";
                $data['notify']["message"] = "탈퇴한 회원입니다.";
                $data['notify']["type"] = "danger";
            }
            else if($this->userstate->isExistUser()===false)
            {
                $data['notify']["title"] = "메세지";
                $data['notify']["message"] = "아이디가 존재하지 않습니다.";
                $data['notify']["type"] = "danger";
            }
            else if($this->userstate->loginAuth($password)===false)
            {
                $data['notify']["title"] = "메세지";
                $data['notify']["message"] = "비밀번호가 일치하지 않습니다.";
                $data['notify']["type"] = "danger";
            }
            else
            {
                $oauth_id = $this->userstate->get_flashdataOauth();
                
                $this->load->model('oauth/oauth_m');
                
                $this->db->trans_start();	
                $this->oauth_m->linkUser($oauth_id,$this->userstate->user->id);
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) 
                {
                    $data['notify']["title"] = "메세지";
                    $data['notify']["message"] = "오류.";
                    $data['notify']["type"] = "danger";
                }
                else
                {
                  
                    $this->session->set_flashdata('message',["message"=>"연동성공.","type"=>"success"]);
                 
                    $data['redirect'] = "/";
                }
            }
            
        }
  
        $this->ajax_helper->json($data);
    }

}

/* End of file User.php */
 ?>