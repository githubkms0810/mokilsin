<?php 
namespace file;
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends \Base_Controller {

    public function __construct()
    {
        parent::__construct();
        // $this->get = true;
        // $this->list = true;
        // $this->add = true;
        // $this->update = true;
        $this->delete = true;
    }
    function upload()
    {
        $this->load->view("base/upload");
    }  
    function uploadFile()
    {
        $this->ajax_helper->headerJson();
        $data=$this->upload->multiUpload("file","user");
        $this->ajax_helper->json($data);
        $flashdataes= $this->session->flashdata();
        foreach ($flashdataes as $key=>$flashdata) {
            if( $this->session->flashdata($key) !== null)
            {
                $this->session->set_flashdata($key, $flashdata);
            }
        }
    }
    function uploadImage()
    {
       
        $this->ajax_helper->headerJson();
        $data=$this->upload->multiUpload("image","user");
        $this->ajax_helper->json($data);

        $flashdataes= $this->session->flashdata();
        foreach ($flashdataes as $key=>$flashdata) {
            if( $this->session->flashdata($key) !== null)
            {
                $this->session->set_flashdata($key, $flashdata);
            }
        }
    }

    // function uploadFile()
    // {
    //     $this->ajax_helper->headerJson();
    //     $data=$this->upload->multiUpload("file","user");
    //     $this->ajax_helper->json($data);
    // }
    public function downloadSecurityFile()
    {
        $this->load->helper('download');
        
        $directory = $this->setting->security_file_directory;
        $original_name = $this->setting->security_file_name;
        if ($directory) 
        {
            $file = ".$directory";
            if (file_exists ( $file )) 
            {
                $data = file_get_contents ( $file );
                force_download ($original_name , $data );
            }
            else 
            {   
                alert("해당 파일이 존재하지 않습니다.");
                my_redirect ( $this->referer);
            }
        } 
    }
    public function downloadOnUser($id) // routed download/$1
    {
        $this->_download("user",$id);
    }
    
    public function _download($kind,$id)
    {
        $this->load->model("file/file_m");
        $fileInfo =$this->file_m->p_get($id);
        // 권한검사
        if($this->userstate->authKind($fileInfo->download_auth_kind) === false)
        {
            alert("{$fileInfo->download_auth_kind}이 아닙니다.");
            my_redirect($this->referer);
            return;
        }
        if($this->userstate->minLv($fileInfo->download_auth) === false)
        {
            alert("권한이 없습니다.");
            my_redirect($this->referer);
            return;
        }
        
        //비밀글,손님 비밀번호 검사
        $this->load->model('content/content_m');
        $content = $this->content_m->p_get(["file_group_id"=>$fileInfo->group_id]);
        $content_id =  $content->id;
        $config =array(); 
        $config["flashdata"] =  "content_guest_password/$content_id";
        $config["is_secret"] =$fileInfo->is_secret;
        $config["user_id"] = $fileInfo->user_id;
        $config["mode"] = "action=".my_site_url("/download/{$id}")." method='post'";
        $config["message1"] = "작성자만 가능합니다.";
        $config["message1"] = "비회원이 업로드한 파일입니다.";
        if($this->_verifyPassword($id,$config) === false) return;

        //다운로드
        $tmp_name = $fileInfo->tmp_name;
       
        $this->load->helper('download');
        if ($tmp_name) 
        {
            // $file = realpath ( "public/uploads/{$kind}/files" ) . "\\" . $tmp_name;
            $file = "./public/uploads/{$kind}/files/" . $tmp_name;
            // check file exists    
            if (file_exists ( $file )) 
            {
                // get file content
                
                //force download
                // force_download ($file->original_name , $data );
                //다운로드 로그
                $this->load->model('download_log/download_log_m');
                $this->db->trans_start();
                $this->download_log_m->add([
                    "user_id"=>$this->user->id,
                    "file_id"=>$fileInfo->id,
                    "ip_address"=> $this->input->ip_address()
                    ]);
                $this->db->trans_complete();
                if($this->db->trans_status() === FALSE) 
                {
                    alert("에러 다시시도해주세요.");
                    my_redirect ( $this->referer);
                }
                else
                {
                    $data = file_get_contents ( $file );
                    force_download ($fileInfo->original_name , $data );
                }
              
            }
            else 
            {   
                alert("해당 파일이 존재하지 않습니다.");
                my_redirect ( $this->referer);
            }
        } 
    }
    public function delete($id)
    {   
        $content_id = $this->input->get('content_id');

        $row = $this->file_m->p_get($id);
        
        //권한 검사
        if($this->userstate->isMe($row->user_id) === false)
        {
            $this->ajax_helper->headerJson();
            $data["작성자가 아닙니다."];
            $this->ajax_helper->json($data);
            return;
        }
        //게스트일떄 세션검사
        if($this->userstate->isGuest() === true)
        {
            if($this->session->userdata("content_guest_password/$content_id") !== true)
            {
                $this->ajax_helper->headerJson();
                $data["alert"] = "잘못된 접근";
                $this->ajax_helper->json($data);
                return false;
            }
            if( $this->session->userdata("content_guest_password/$content_id") === true)
            {
                $this->session->set_flashdata("content_guest_password/$content_id", true);
            }
        }

        //삭제
        $this->ajax_helper->headerJson();
		$this->{$this->modelName}->noDisplay($id);
        $data['remove']['use'] = true;
        $data['remove']["parent"] = "div";
        $this->data += $data;
		$this->ajax_helper->json($this->data);
    }

//     public function get($id)
//     {
//         parent::get($id);
//     }
//     public function list()
//     {
//         parent::list();
//     }
//     public function add()
//     {
//         parent::add();
//     }
//     public function update($id)
//     {
//         parent::update($id);
//     }

}

/* End of file Admin.php */

?>