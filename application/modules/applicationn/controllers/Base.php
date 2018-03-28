<?php 
namespace applicationn;
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends \Base_Controller {

    public function __construct()
    {
        parent::__construct();
        // $this->get = true;
        // $this->list = true;
        // $this->add = true;
        // $this->update = true;
        // $this->delete = true;
        // $this->noDisplay = true;
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
        $this->applicationn_m->setRulesWhenAdd();
        $fileSizeValidation  = $this->upload->vlidationFileSize("files",uploadLimitSize);
        if($this->form_validation->run() === false || $fileSizeValidation === false){
            $data["mode"] = "add";
            $data["row"] = (object)[];
            $data['kind'] = get("kind");
            $data["content_view"] = "base/addUpdate";
            if($fileSizeValidation === false) alert("업로드는 파일 하나당 2mb 이하만 가능합니다.");
            $this->template->render($data);
        }
        else{
            $this->db->trans_start();
            $this->load->model('file/file_m');
            $group_id=$this->file_m->add();
            $this->db->set("file_group_id",$group_id);
            $insert_id=$this->applicationn_m->addByPostData();
            
            $this->load->model('applicant/applicant_m');
            $this->applicant_m->addByArrayPostDataWithApplicationId($insert_id);
            $this->db->trans_complete();

            if($this->db->trans_status() === false){
                alert("추가 실패.ERRORCODE :".transectionError);
                my_redirect($this->referer);
            }
            else{            
                alert("신청 되었습니다.\\r메인 페이지로 이동합니다.");
                my_redirect("/");
            }

        }
    }
//     public function update($id)
//     {
//         parent::update($id);
//     }
//     public function delete($id)
//     {
//         parent::_ajaxDelete($id);
//     }
}

/* End of file Admin.php */

?>