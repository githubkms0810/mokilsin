<?php 
namespace translation_order;
//의존성 :: product, user
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends \Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('post_helper');
    }
    public function insertPortfolioForDebug()
    {
        for ($i=0; $i < 50; $i++){ 
            $this->translation_order_m->addForDebug();
        }
    }
    public function add()
    {
        $this->translation_order_m->setRulesWhenAdd();
        $fileSizeValidation  = $this->upload->vlidationFileSize("files",uploadLimitSize);
        if($this->form_validation->run() === false || $fileSizeValidation === false){
              $data["mode"] = "add";
              $data['type'] = get("type");
              $data["row"] = (object)[];
              $data["content_view"] = "base/addUpdate";
              if($fileSizeValidation === false) alert("업로드는 파일 하나당 2mb 이하만 가능합니다.");
              $this->template->render($data);
          }
          else{
            
              $this->db->trans_start();
              $this->load->model('file/file_m');
              $group_id=$this->file_m->add();
              $this->db->set("file_group_id",$group_id);
              $insert_id=$this->translation_order_m->addByPostData();
              $this->db->trans_complete();
              
              if($this->db->trans_status() === false){
                  alert("추가 실패.ERRORCODE :".transectionError);
                  my_redirect($this->referer);
              }
              else{            
                  my_redirect("/admin/translation_order/get/$insert_id");
              }
          }
    }
    public function updateAjax($id)
    {
        parent::update($id);
    }

    public function update($id)
    {
        $this->translation_order_m->setRulesWhenAdd();
        $fileSizeValidation  = $this->upload->vlidationFileSize("files",uploadLimitSize);
        if($this->form_validation->run() === false || $fileSizeValidation === false){
              $data["mode"] = "update/$id";
              $data['type'] = get("type");
              $data["row"] =  $this->translation_order_m->get($id);
              $data["content_view"] = "base/addUpdate";
              if($fileSizeValidation === false) alert("업로드는 파일 하나당 2mb 이하만 가능합니다.");
              $this->template->render($data);
          }
          else{
            
            $this->db->trans_start();
            $this->translation_order_m->updateByPostData($id);
            $group_id = $this->translation_order_m->p_get($id,"file_group_id")->file_group_id;
            $this->load->model('file/file_m');
            if($group_id !== null)
                $this->file_m->add("user",$group_id);
            else
            {
                $group_id=$this->file_m->add();
                $this->db->set("file_group_id",$group_id);
                $this->translation_order_m->p_update($id);
            }
            $this->db->trans_complete();
            
            if($this->db->trans_status() === false){
                alert("추가 실패.ERRORCODE :".transectionError);
                my_redirect($this->referer);
            }
            else{            
                my_redirect("/admin/translation_order/get/$id");
            }
        }
    }
    public function get($id)
    {
        $data['row'] = $row = $this->{$this->modelName}->get($id);
        $this->load->model('file/file_m');
        $data["files"]  = $this->file_m->list_ByGroupId($row->file_group_id);
		$data["content_view"] = "{$this->className}/get";
		$this->data += $data;
        $this->template->render($this->data);
    }
    public function setting()
    {
        $this->load->model('setting_m');
      
        //get
        if ($this->input->method() !== "post") 
        {
            $data['mode'] = "setting";
            $data['row'] = $this->setting_m->p_get(1);
            $data["content_view"] = "admin/setting";
            $this->template->render($data);
            return;
        }
        //post
            $this->ajax_helper->headerJson();
            $uploadResult=$this->upload->multiUpload("file","admin");
            if($uploadResult["result"] === "success")
            {

                $this->db->set("security_file_directory",$uploadResult["files"][0]["uri"]);
                $this->db->set("security_file_name",$uploadResult["files"][0]["original_name"]);
                $this->setting_m->p_update("1");
                $this->session->set_flashdata('message',["message"=>"수정 되었습니다.","type"=>"success"]);
            }
            else if($uploadResult["result"] === "fail")
            {
                $error=str_replace("\n","",$uploadResult["errors"]);
                $this->session->set_flashdata('message',["message"=>$error,"type"=>"danger"]);
            }
            else
            {
                $this->session->set_flashdata('message',["message"=>"파일을 선택해주세요.","type"=>"danger"]);
            }
            $data['reload'] =true;
        // }
        $this->ajax_helper->json($data);
    }

}

/* End of file Admin.php */

?>