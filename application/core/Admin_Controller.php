<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends Public_Controller 
{
	public function __construct()
	{
        parent::__construct();
     
		if($this->userstate->isAdmin() === false)
		{
			alert("접근불가");
            my_redirect("/",false);
            exit;
        }
        
		$data["mainMenus"] = $this->_createMainMenus();
		$data["subMenus"] = $this->_createSubMenus();
		$this->template->load("admin/template",$data);
    }
    //Functions : Creating menuData that will be used on template
	private function _createMainMenus()
	{
        $this->menudata_creator->addMainMenu("메인","main","translation_order_setting",site_url("admin/translation_order/setting"));
        $this->menudata_creator->addMainMenu("유저","user","user_log",site_url("admin/user_log/list"));
        
        $this->menudata_creator->addMainMenu("게시판","board","contents",site_url("admin/content/list"));
        $this->menudata_creator->addMainMenu("프리랜서","freelancer","freelancer_list",site_url("admin/freelancer/list"));
        $this->menudata_creator->addMainMenu("번역/통역","translation_order","translation_order_list",site_url("admin/translation_order/list"));
        $this->menudata_creator->addMainMenu("제휴문의","contact","contact_list",site_url("admin/contact/list"));
        $this->menudata_creator->addMainMenu("이메일","email","","http://mail.".$_SERVER["HTTP_HOST"],false,"_blank");
        

		return $this->menudata_creator->getMainMenus();
	}
	private function _createSubMenus()
	{
		// $this->menudata_creator->addSubMenu("main","대쉬보드","dashboard",site_url("admin/main/index"));
        $this->menudata_creator->addSubMenu("main","기밀보안 파일 설정","translation_order_setting",site_url("admin/translation_order/setting"));
        $this->menudata_creator->addSubMenu("user","로그","user_log",site_url("admin/user_log/list"));
        $this->menudata_creator->addSubMenu("board","게시판","boards",site_url("admin/board/list"));
        if($this->userstate->isDeveloper()){
            $this->menudata_creator->addSubMenu("board","게시물 로그","content_log",site_url("admin/content_log/list"));
            $this->menudata_creator->addSubMenu("main","설정","globalInfo",site_url("admin/global_info/update/1"));
            $this->menudata_creator->addSubMenu("board","댓글","replys",site_url("admin/reply/list"));
        }
        if($this->userstate->isDeveloper()){
            $this->menudata_creator->addSubMenu("user","세션","session",site_url("admin/session/list"));
        }
		$this->menudata_creator->addSubMenu("board","게시물","contents",site_url("admin/content/list"));
		$this->menudata_creator->addSubMenu("freelancer","프리랜서","freelancer_list",site_url("admin/freelancer/list"));
		$this->menudata_creator->addSubMenu("freelancer","설정","freelancer_setting",site_url("admin/freelancer/setting"));
		$this->menudata_creator->addSubMenu("translation_order","번역/통역 의뢰","translation_order_list",site_url("admin/translation_order/list"));
		// $this->menudata_creator->addSubMenu("email","이메일","email_list",site_url("admin/email/list"));
	
		return $this->menudata_creator->getSubMenus();
	}

	//Controller :: CRUD

    public function index()
    {
        $data["content_view"] = "admin/index";
        $this->template->render($data);
    }
    public function setting()
    {
        $this->load->model('setting_m');
         //get
         if ($this->input->method() !== "post") 
         {
             $data['mode'] = "setting";
             $data['row'] = $this->setting_m->p_get(1);
             $data["componentData"] = $this->{$this->modelName}->settingComponent();
             $data["content_view"] = "admin/setting";
             $this->template->render($data);
             return;
         }
         //post
         $this->ajax_helper->headerJson();
         
         foreach ($_POST as $key=>$POST) {
             $this->form_validation->set_rules($key, $key, 'trim');
             break;
         }
         if ($this->form_validation->run() === false) 
         {
            $data['notify']["title"] = "유효성검사";
            $data['notify']["message"] = $this->form_validation->errors("<br>");
            $data['notify']["type"] = "danger";
         } 
         else 
         {
             $result=$this->setting_m->update("1");
             if($result === true)
                 $this->session->set_flashdata('message',["message"=>"수정 되었습니다.","type"=>"success"]);
            else
                $this->session->set_flashdata('message',["message"=>"수정 실패.","type"=>"danger"]);
             $data['reload'] =true;
         }
         $this->ajax_helper->json($data);
    }


    public function deleteRange()
    {
        $this->ajax_helper->headerJson();
        $result=$this->{$this->modelName}->p_deleteRange();
        if($result === true)
            $this->session->set_flashdata('message',["message"=>"삭제되었습니다.","type"=>"success"]);
        else
            $this->session->set_flashdata('message',["message"=>"문제발생.","type"=>"danger"]);
        $data['reload'] = true;
        $this->ajax_helper->json($data);
    }

}

/* End of file Admin_Controller.php */
/* Location: ./application/core/Admin_Controller.php */