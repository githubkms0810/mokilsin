<?php 
namespace content;
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends \Base_Controller {
    public $board;
    public $kind;
    public $board_id;
    public $board_key;
    public $num_content;

    public $board_r_auth_kind;
    public $board_r_auth;
    public $content_r_auth_kind;
    public $content_r_auth;
    public $content_w_auth_kind;
    public $content_w_auth;
    public $content_is_me;
    public function __construct()
    {
        parent::__construct();
        //모두열기
        $this->get = true;
        $this->list = true;
        $this->add = true;
        $this->update = true;
        $this->noDisplay =true;

        $this->load->model('board/board_m');
        $this->load->model('file/file_m');
        
        //board 정보
        $this->board_key = $this->input->get('board_key');
        // $this->board_key = $this->input->get('board_key')?? "notice";
        
        $this->board = $this->board_m->p_get(array("key"=>$this->board_key));

        $this->board_id = $this->board->id;
        $this->kind = $this->board->kind;
        $this->num_content = $this->board->num_content;
        
        $this->board_r_auth_kind = $this->board->board_r_auth_kind;
        $this->board_r_auth = $this->board->board_r_auth;
        $this->content_r_auth_kind = $this->board->content_r_auth_kind;
        $this->content_r_auth = $this->board->content_r_auth;
        $this->content_w_auth_kind = $this->board->content_w_auth_kind;
        $this->content_w_auth = $this->board->content_w_auth;

        $this->content_is_me = $this->board->content_is_me;
    }
    public function get($id)
    {
        $data['row'] = $row = $this->content_m->get($id);
        //--권한 검증
        //기본권한
        if($this->_checkReadWriteAuth("content","r") === false)
        {
            alert($this->message);
            my_redirect($this->referer);
            return;
        }
        //비밀글,손님 비밀번호 검사

        $config =array(); 
        $config["flashdata"] =   ["content_guest_password/$id"];
        $config["is_secret"] =$row->is_secret;
        $config["user_id"] = $row->user_id;
        $config["mode"] = "action=".my_site_url("/{$this->moduleName}/{$id}")." method='post'";
        if($this->_verifyPassword($id,$config) === false) return;

        //--뷰

        //조회수 증가 검사 시작
        $this->load->helper('cookie');
        $this->load->model('content_log/content_log_m');
        $session_id  =get_cookie("ci_session");
        $this->db->trans_start();
        $content_log =$this->content_log_m->getBySessionId_andContentId($session_id,$id);

        if($content_log === null)
        {
            $this->content_log_m->p_add([
                "session_id"=>$session_id,
                "user_id"=>$this->user->id,
                "content_id"=>$id,
                "ip_address"=>$this->input->ip_address(),
                ]);
            $this->db->set("hits","hits+1",false);
            $this->content_m->p_update($id);
        }
        $this->db->trans_complete();
        //조회수 증가 검사 끝
        
        // 뷰렌더링
        $this->load->model('reply/reply_m');
        $data['replys'] = $this->reply_m->list_ByContentId_OnRecursion($id);
        $data["files"] =$this->file_m->list_ByGroupId($row->file_group_id);

        $data["fieldData"] = $this->{$this->modelName}->{"getData_".$this->className}();
        $data['content_view'] = "base/{$this->kind}/get";
        $this->template->render($data);
    }
    
    public function list()
    {
        //권한 검증
        if($this->board->is_display !== "1")
        {
            alert("페쇠되었습니다.");
            my_redirect($this->referer);
            return;
        }
        if($this->_checkReadWriteAuth("board","r") === false)
        {
            alert($this->message);
            my_redirect($this->referer);
            return;
        }
        
        //뷰

        $data["board"] = $this->board;
        $data['content_view'] = array("base/{$this->kind}/list","base/search");
        $this->data += $data;
        parent::list();
    }
    public function add()
    {   
        //권한 검증
        if($this->board->is_display !== "1")
        {
            alert("페쇠되었습니다.");
            my_redirect($this->referer);
            return;
        }
        if($this->_checkReadWriteAuth("content","w") === false)
        {
            alert($this->message);
            my_redirect($this->referer);
            return;
        }
        parent::add();
     
       
    }
    protected function _add()
    {
        
        $data["content_view"] = "base/{$this->kind}/addUpdate";
        $this->data += $data;
        parent::_add();
    }
    public function update($id)
    {
        //--권한 검증
        $data = [];
        if($this->board->is_display !== "1")
        {
            alert("페쇠되었습니다.");
            my_redirect($this->referer);
            return;
        }
        $content =$this->{$this->modelName}->p_get($id);

        //기본권한
        if($this->_checkReadWriteAuth("content","w") === false)
        {
            alert($this->message);
            my_redirect($this->referer);
            return;
        }
        //작성자인지
        if($this->userstate->isMe($content->user_id) === false)
        {
            alert("작성자가 아닙니다.");
            my_redirect($this->referer);
            return;
        }
       
        //--뷰
        //손님일떄 flashdata true유지하기
        if($this->userstate->isGuest() === true && $this->session->userdata("content_guest_password/$id") === true)
        {
            $this->session->set_flashdata("content_guest_password/$id", true);
        }
        if($this->input->method() === "get") 
        {   
             ///뷰::손님일때 비번 체크
            if($this->userstate->isGuest()=== true && $this->session->userdata("content_guest_password/$id") !== true) 
            {
                $data["mode"] = "action=".my_site_url("/{$this->moduleName}/update/{$id}")." method='post'";
                $data["content_view"] = "base/passwordVerify";
                $this->template->render($data);
                return;
            }
            //뷰
            $this->_update($id);
            return;
        }
        ///손님 일떄  검증
        if($this->userstate->isGuest()=== true)
        {
            if($this->_contentGuestAuth($id) === false) //비밀번호 불일치
            {
                alert("비밀번호가 일치하지 않습니다.");
                my_redirect($this->referer);
                return;
            }
            else if($this->_contentGuestAuth($id) === true)//뷰 :: 일치 하면 
            {
                $this->_update($id);
                return;
            }
            //세션검사
            if($this->session->userdata("content_guest_password/$id") !== true)
            {
                $this->ajax_helper->headerJson();
                $data["alert"] = "잘못된 접근";
                $this->ajax_helper->json($data);
                return false;
            }
         
        }
        ///업데이트
        $this->data += $data;
        $this->_ajaxUpdate($id);
    }
    protected function _update($id)
    {
        $data["mode"] ="update/$id";

        $data['row'] = $row = $this->content_m->p_get($id);
        $data["files"] = $this->file_m->list_byGroupId($row->file_group_id);
        $data["content_view"] = "base/{$this->kind}/addUpdate";
        $this->data += $data;
        $this->template->render($this->data);
    }
    public function noDisplay($id)
    {
        $content =$this->{$this->modelName}->p_get($id);
        if($this->userstate->isMe($content->user_id) === false)
        {
            $this->ajax_helper->headerJson();
            $data['alert'] ="작성자가 아닙니다.";
            $this->ajax_helper->json($data);
            return;
        }
        
        //손님일때 비번 추가 검증
        if($this->userstate->isGuest()=== true && $this->session->userdata("content_guest_password/$id") !== true) 
        {
            if( $this->_contentGuestAuth($id) ===null) ///비번 입력뷰
            {
                $this->ajax_helper->headerJson();
                $data["redirect"] = my_site_url("/content/passwordAuth/$id");
                $this->ajax_helper->json($data);
                return;
            }
            else if($this->_contentGuestAuth($id) === false) ///비번 불일치
            {
                $this->ajax_helper->headerJson();
                $data["alert"] = "비밀번호가 일치하지 않습니다.";
                $this->ajax_helper->json($data);
                return;
            }
        }
        parent::noDisplay($id);
    }
   
   


  
}

/* End of file Admin.php */

?>