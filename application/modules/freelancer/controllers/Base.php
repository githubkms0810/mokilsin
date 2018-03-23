<?php 
namespace freelancer;
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends \Base_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("freelancer/freelancer_m");
     
    }

//     public function get($id)
//     {
//         parent::get($id);
//     }
//     public function list()
//     {
//         parent::list();
//     }
    public function add(){
        $this->freelancer_m->setRulesWhenAdd();
        $fileSizeValidation  = $this->upload->vlidationFileSize("files",uploadLimitSize);
        if($this->form_validation->run() === false || $fileSizeValidation === false){
            $data["row"] = (object)["is_graduate_school"=>null];
            $data["content_view"] = "base/addUpdate";
            $data["mode"] = "add";
            $data["languages"]=explode("," ,$this->setting->translation_languages);
            if($fileSizeValidation === false) alert("업로드는 파일 하나당 2mb 이하만 가능합니다.");
            $this->template->render($data);
        }
        else{
         
            $this->db->trans_start();
            $this->load->model('file/file_m');
            $group_id=$this->file_m->add();
            $insert_id=$this->freelancer_m->addByPostDataAndByFileGroupId($group_id);
            $this->load->model("freelancer_translation_language/freelancer_translation_language_m");
            $this->freelancer_translation_language_m->addByFreelancerIdAndLanguages($insert_id,post('languages'));
            $this->db->trans_complete();
            
            if($this->db->trans_status() === false){
                alert("추가 실패.ERRORCODE :".transectionError);
                my_redirect($this->referer);
            }
            else{
                alert("프리랜서 등록이 완료 되었습니다.\\r신청서는 수정/삭제가 불가능합니다. \\r검수 후 이메일 통보해드리겠습니다.\\r메인페이지로 이동합니다.");
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