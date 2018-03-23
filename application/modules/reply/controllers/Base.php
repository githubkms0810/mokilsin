<?php 
namespace reply;
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends \Base_Controller {

    public $reply_w_auth_kind;
    public $reply_w_auth;

    public $content;
    public $content_is_secret;
    public function __construct()
    {
        parent::__construct();
        // $this->get = true;
        // $this->list = true;
        $this->add = true;  
        // $this->update = true;
        $this->delete = true;
        $this->noDisplay=true;
        //게시판 정보
        $this->load->model('board/board_m');
        $this->board_key = get('board_key');
        $this->board = $this->board_m->p_get(["key"=>$this->board_key]);

        $this->board_id = $this->board->id;
        $this->reply_w_auth_kind = $this->board->reply_w_auth_kind;
        $this->reply_w_auth = $this->board->reply_w_auth;
      

    }

//     public function get($id)
//     {
//         parent::get($id);
//     }
//     public function list()
//     {
//         parent::list();
//     }

    public function add()
    {
        $this->load->model('content/content_m');
        $content =$this->content_m->p_get(post("content_id"));
        if($content->is_secret === "1") //게시물이 비밀글이라면 작성자만 댓글추가 가능
        {
            if($this->userstate->isMe($content->user_id) === false)
            {
                alert("작성자가 아닙니다.");
                my_redirect($this->referer);
                return;
            }
        }

        if($this->_checkReadWriteAuth("reply","w") === false)
        {
            $this->ajax_helper->headerJson();
            $data['alert'] = $this->message;
            $this->ajax_helper->json($data);
            return;
        }

        if($this->input->method() === "get")
		{
			$this->_add();
			return;
        }
        
        $data['redirect'] = false;
        $data['reload'] = true;
        $this->data += $data;
        parent::_ajaxAdd();
    
    }
    // public function update($id)
    // {
    //     if($this->_checkReadWriteAuth("reply","w") === false)
    //     {
    //         alert($this->message);
    //         my_redirect($this->referer);
    //         return;
    //     }

    //     parent::update($id);
    // }

    public function noDisplay($id)
    {
      
        //권한 검증
        $reply =$this->{$this->modelName}->p_get($id);
        if($this->userstate->isMe($reply->user_id) === false)
        {
            $this->ajax_helper->headerJson();
            $data['alert'] ="작성자가 아닙니다.";
            $this->ajax_helper->json($data);
            return;
        }
        //손님일때 비번 추가 검증
        if($this->userstate->isGuest()=== true)
        {
            if( $this->_contentGuestAuth($id) ===null) ///비번 입력뷰
            {
                $this->ajax_helper->headerJson();
                $data["redirect"] = my_site_url("/reply/passwordAuth/$id");
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
            $data["redirect"] = my_site_url("/content/{$reply->content_id}");
        }
        else
        {   
            $data["redirect"] = false;
            $data["reload"] = true;
        }
        $this->data += $data;
        parent::noDisplay($id);
    }



}

/* End of file Admin.php */

?>