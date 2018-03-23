<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_Controller extends Public_Controller {

	protected $get = false;
	protected $list = false;
	protected $add = false;
	protected $update = false;
	protected $delate = false;
	protected $display = false;
	protected $noDisplay = false;
	// public $data = array();
	public function __construct()
	{
		parent::__construct();
		$data["mainMenus"] = $this->_createMainMenus();
		$data["subMenus"] = $this->_createSubMenus();
		$this->template->load("base/template",$data);
	}
	
	private function _createMainMenus()
	{
		// $this->menudata_creator->addMainMenu("메인","메인","",site_url(""),false);
		// $this->menudata_creator->addMainMenu("프로그램","product","",site_url("/"));
		// $this->menudata_creator->addMainMenu("게시판","board","notice",site_url("/content/list?board_key=notice"));
		// $this->menudata_creator->addMainMenu("다운로드","download","",site_url("/content/get/4?board_key=program"));
		return $this->menudata_creator->getMainMenus();
	}
	private function _createSubMenus()
	{
		// $this->load->model('board/board_m');
		// $this->db->order_by('sort', 'asc');
		// $boards=$this->board_m->p_list();
		// foreach ($boards as  $board) {
		// 	if($board->key ==="patchNote") continue;
		// 	$this->menudata_creator->addSubMenu("board",$board->name,$board->key,site_url("/content/list?board_key={$board->key}"));
		// }
		return $this->menudata_creator->getSubMenus();
	}
	// public function index()
	// {
	// 	$data =$this->data;

	// 	$data["content_view"] = "base/index";
	// 	$this->template->render($data);
	// }
	public function get($id)
	{
		if($this->get === false ) return ;
		parent:: get($id);
	}
	
	public function list()
    {
		if($this->list === false ) return ;
		parent:: list();
	}

	public function add()
    {
		if($this->add === false ) return ;
		parent::add();
	}

	public function update($id)
	{
		if($this->update === false ) return ;
		parent::update($id);
	}
	

	public function delete($id)
	{
		if($this->delete === false ) return ;
		parent::_ajaxDelete($id);
	}
	public function noDisplay($id)
	{
		if($this->noDisplay === false ) return ;
		parent::noDisplay($id);
	}
	public function display($id)
	{
		if($this->display === false ) return ;
		parent::display($id);
	}
	



	//board content reply
	protected function _checkReadWriteAuth(string $kind,string $readOrWrite)
    {
        //권한 검증
        $prop = "{$kind}_{$readOrWrite}_auth_kind";
        if($this->userstate->authKind($this->$prop) === false)
        {
            $this->message = "{$this->$prop} 만 이용할수 있습니다.";
            return false; 
        } 
        $prop = "{$kind}_{$readOrWrite}_auth";
        if($this->userstate->minLv($this->$prop) === false)
        {
			if($this->$prop === "1")
			{

				$this->message = "회원만 이용가능합니다.";	
				$this->ajax_helper->set_flashMessage($this->message,"info");
				if($this->input->is_ajax_request() === false)
				{
					redirect("/user/login?return_url=".urlencode(my_current_url()));
				}
				else
				{
					$this->ajax_helper->headerJson();
					$data["redirect"] = site_url("/user/login?return_url=".urlencode($this->input->get("return_url")));
					$this->ajax_helper->json($data);
				}
				// alert($this->message);
				exit;
			}
			else
			{
            	$this->message = "권한이 없습니다";

			}
            return false; 
        }
        return true;
    }

	public function passwordAuth($id)
    {
        //뷰:: 손님일떄 글 삭제 비번검증
        $data["mode"] = $this->ajax_helper->form("/{$this->moduleName}/noDisplay/{$id}");
        $data["content_view"] = "base/passwordVerify";
        $this->template->render($data);
        return;
	}
	protected function _contentGuestAuth($id)
    {
        //손님 비번 검증, no post data일떄 return null
        $hash = $this->{$this->modelName}->p_get($id)->guest_password;
        $password = $this->input->post('password');
        if($password === null)
            return null;
        if(password_verify($password,$hash) === true)
        {
            $this->session->set_flashdata("content_guest_password/$id", true);
            return true;
        }
        return false;
	}
	

	protected function _userAuth($id)
    {
        //손님 비번 검증, no post data일떄 return null
        $hash = $this->{$this->modelName}->p_get($id)->password;
        $password = $this->input->post('password');
        if($password === null)
            return null;
        if(password_verify($password,$hash) === true)
        {
            $this->session->set_flashdata("user_password", $id);
            return true;
        }
        return false;
	}

	protected function _verifyPassword($id,$config)
    {
		//세팅
        $is_secret = $config["is_secret"];
		$user_id = $config["user_id"];
		$flashdatas = $config["flashdata"] ?? "flashdata/$id";
		$mode = $config["mode"] ?? "action=".my_site_url("/{$this->moduleName}/{$id}")." method='post'";
		$content_view = $config["content_view"] ?? "base/passwordVerify";
		$message1 = $config["message1"] ?? "비밀글 입니다.";
		$message2 = $config["message2"] ?? "비로그인 회원이 쓴 비밀 글입니다.";

        $this->load->library('userstate');
		
		if(is_array($flashdatas)===false)
		{
			$flashdatas = array($flashdatas);
		}
		
         //비밀글 검증
         if($this->userstate->verifySecret($is_secret,$user_id) === false)
         {
             //회원이 쓴 비밀 글일때
             if($user_id !== "0") 
             {
                 alert($message1);
                 my_redirect($this->referer);
                 return false;
             }
            //비회원이 쓴 비밀 글이고 나는 회원일떄
            if($this->userstate->isGuest() === false) 
            {
                alert($message2);
                my_redirect($this->referer);
                return false;
            }
             
             //-비회원이 쓴 비밀글이고 나는 손님일떄
			 //인증된 flashdata true유지
			 $sw = true;

			 foreach ($flashdatas as $value) 
			 {
				if($this->session->userdata($value) === true)
				{
					$this->session->set_flashdata($value, true);

				}
				else
				{
					$sw = false;
				}
				if($sw === true)
				{
					return true;
				} 
			 }
             
 
              //flashdata 인증되지않았다면
             if($sw === false)
             {
                
                 if($this->input->method() ==="get" )
                 {
                     //비밀번호 입력 뷰
                     $data["mode"] = $mode;
                     $data["content_view"] = $content_view;
                     $this->template->render($data);
                     return false;;
                 }
                 if($this->input->method() ==="post" ) //비밀번호 post로 입력들어왔을떄
                 {
                     if($this->_contentGuestAuth($id)=== false) //비번 불일치->입력뷰
                    //  if($this->_contentGuestAuth(1)=== false) //비번 불일치->입력뷰
                     {
                         alert("비밀번호가 일치하지 않습니다.");
                         $data["mode"] = $mode;
                         $data["content_view"] = $content_view;
                         $this->template->render($data);
                         return false;
                     }
                     else
                     {
						foreach ($flashdatas as $value) 
						{
							$this->session->set_flashdata($value, true);
						}
                         return true;
                     }
                 }
             }
         }   
    }
}

/* End of file Base_Controller.php */
/* Location: ./application/core/Base_Controller.php */