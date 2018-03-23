<?php 
namespace freelancer;
//의존성 :: product, user
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends \Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('post_helper');
    }
    public function list()
    {
        $data["languages"]=explode("," ,$this->setting->translation_languages);
        $this->data += $data;
        parent::list();
    }
 
    public function add()
    {
        $this->freelancer_m->setRulesWhenAdd();
        $fileSizeValidation  = $this->upload->vlidationFileSize("files",uploadLimitSize);
        if($this->form_validation->run() === false || $fileSizeValidation === false){
            $data["content_view"] = "base/addUpdate";
            $data["mode"] = "add";
            $data["row"] = (object)[];
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
                my_redirect("/admin/freelancer/get/$insert_id");
            }
        }
    }
    public function updateAjax($id)
    {
        parent::update($id);
    }
    public function update($id)
    {
        $this->freelancer_m->setRulesWhenAdd();
        $fileSizeValidation  = $this->upload->vlidationFileSize("files",uploadLimitSize);
        if($this->form_validation->run() === false || $fileSizeValidation === false){
            $data["content_view"] = "base/addUpdate";
            $data["mode"] = "update/$id";
            $data["row"] = $this->freelancer_m->get($id);
            $data["languages"]=explode("," ,$this->setting->translation_languages);
            if($fileSizeValidation === false) alert("업로드는 파일 하나당 2mb 이하만 가능합니다.");
            $this->template->render($data);
        }
        else{
            $this->db->trans_start();
            $this->freelancer_m->updateByPostData($id);
            $file_group_id = $this->freelancer_m->p_get($id,"file_group_id")->file_group_id;
            $this->load->model('file/file_m');
            if($file_group_id !== null)
                $this->file_m->add("user",$file_group_id);
            else
            {
                $file_group_id=$this->file_m->add();
                $this->db->set("file_group_id",$file_group_id);
                $this->freelancer_m->p_update($id);
            }

            $this->load->model("freelancer_translation_language/freelancer_translation_language_m");
            $this->freelancer_translation_language_m->updateByFreelancerIdAndLanguages($id,post('languages'));
            $this->db->trans_complete();
            if($this->db->trans_status() === false){
                alert("추가 실패.ERRORCODE :".transectionError);
                my_redirect($this->referer);
            }
            else{
                my_redirect("/admin/freelancer/get/$id");
            }
        }

        // $data["languages"]=explode("," ,$this->setting->translation_languages);
        // $data["mode"] = "update";
        // $data["content_view"] = "base/addUpdate";
        // $data["row"] = $this->freelancer_m->get($id);
        // $this->data += $data;
        // parent::update($id);
    }
    public function get($id)
    {
        $data['row'] = $row = $this->{$this->modelName}->get($id);
        $this->load->model('file/file_m');
        
        $data["application_files"]  = $this->file_m->list_ByGroupId($row->file_group_id);
        $data["fieldData"] = $this->{$this->modelName}->{"getData"}();
		// $data = $this->{$this->modelName}->additionalGetData();
		$data["content_view"] = "{$this->className}/get";

		$this->data += $data;
        $this->template->render($this->data);
    }
}

/* End of file Admin.php */

?>