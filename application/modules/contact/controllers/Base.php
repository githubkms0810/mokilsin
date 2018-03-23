<?php 
namespace contact;
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends \Base_Controller {

    public function __construct()
    {
        parent::__construct();
   
    }
    public function add()
    {
        $this->contact_m->setRulesWhenAdd();
        if($this->form_validation->run() === false){
            $data["content_view"] = "base/addUpdate";
            $this->template->render($data);
        }
        else{
            $this->db->trans_start();
            $insert_id=$this->contact_m->addByPostData();
            $this->db->trans_complete();
            
            if($this->db->trans_status() === false){
                alert("추가 실패.ERRORCODE :".transectionError);
                my_redirect($this->referer);
            }
            else{
                alert("제휴 신청이 완료 되었습니다. 연락 드리겠습니다.\\r메인페이지로 이동합니다.");
                my_redirect("/");
            }
        }
    }



}

/* End of file Admin.php */

?>