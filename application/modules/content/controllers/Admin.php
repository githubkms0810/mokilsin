<?php 
namespace content;
//의존성 :: product, user
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends \Admin_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    public function add()
    {
        
        $this->load->model('board/board_m');
        
        $data["users"] = $this->user_m->list();
        $data["boards"] = $this->board_m->list();
        $this->data += $data;
        parent::add();
    }
    public function update($id)
    {
      
        $this->load->model('board/board_m');
        
        $data["users"] = $this->user_m->list();
        $data["boards"] = $this->board_m->list();
        $this->data += $data;
        parent::update($id);
    }

}

/* End of file Admin.php */

?>