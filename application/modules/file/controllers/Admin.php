<?php 
namespace file;
//의존성 :: product, user
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends \Admin_Controller {

    public function __construct()
    {
        $this->modelName ="file_m";
        parent::__construct();
    }
 
    // public function add()
    // {
    //     $data = &$this->data;
    //     $this->load->model('board/board_m');
        
    //     $data["users"] = $this->user_m->list();
    //     $data["boards"] = $this->board_m->list();
    //     parent::add();
    // }
    // public function update($id)
    // {
    //     $data = &$this->data;
    //     $this->load->model('board/board_m');
        
    //     $data["users"] = $this->user_m->list();
    //     $data["boards"] = $this->board_m->list();
    //     parent::update($id);
    // }

    public function _ajaxDelete($id,$callback=null)
	{
        $this->ajax_helper->headerJson();
		$this->db->trans_start();
        $directory=$this->file_m->p_get($id,"directory")->directory;
        $result = $this->file_m->delete($id);
		$this->db->trans_complete();
        if($this->db->trans_status() === FALSE) 
        {
            $this->ajax_helper->set_flashMessage("삭제 실패.","danger");
        }
        else
        {
            $directory=substr($directory,1,strlen($directory));
            if (file_exists ( $directory )) 
            {
                unlink($directory);
                $this->ajax_helper->set_flashMessage("삭제되었습니다.","success");
            }
            else
            {
                $this->ajax_helper->set_flashMessage("해당 파일은 존재하지 않습니다.","info");
            }
        }    
	
        $data['redirect'] = my_site_url("/{$this->moduleName}/admin/list");
            
		$this->data += $data;
		$this->ajax_helper->json($this->data);

	}
}

/* End of file Admin.php */

?>