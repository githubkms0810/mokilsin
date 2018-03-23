<?php 
namespace content;
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends \Api_Controller {

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
        $this->load->model('board/board_m');
        // $this->load->model('file/file_m');
        
        //board 정보
        $this->board_key = $this->input->get('board_key');
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
        $this->list = true;
        $this->get = true;
    }
     
}
/* End of file Api.php */
?>