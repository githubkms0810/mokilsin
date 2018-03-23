<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Api_Controller extends Public_Controller {

    public $list = false;
    public $get = false;
    public $add = false;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('token');
        
    }
    public function add()
    {
        if($this->get === false) {echo "forbidden"; return;}
        
        $this->ajax_helper->headerJson();

        $this->db->trans_start();
        $insert_id =$this->{$this->modelName}->add();
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) 
        {
            $data["result"] = "failed";

        }
        else
        {
            $data["result"] ="success";
            $data["insert_id"] = $insert_id;
        }
      
        $this->ajax_helper->json($data);
    }
    public function list()
    {
        if($this->list === false) {echo "forbidden"; return;}
        $this->ajax_helper->headerJson();
        $data["data"] = [];
        if($this->input->method() !== "get")
        {
            $data['result'] = 405;
            $this->ajax_helper->json($data);
            return;
        }
        if($this->userstate->isLogin() === false)
        {
            $data['result'] =  401;
            $this->ajax_helper->json($data);
            return;
        }

        $rows =$this->{$this->modelName}->listPagination();
        $data["result"] = "success";
        $data["data"] =$rows; 
        
        $this->ajax_helper->json($data);
    }
    public function get($id)
    {
        if($this->get === false) {echo "forbidden"; return;}
        $data['data'] = null;
        $this->ajax_helper->headerJson();
        if($this->input->method() !== "get")
        {
            $data['result'] = 405;
            $this->ajax_helper->json($data);
            return;
        }

        if($this->userstate->isDeveloper() === true)
        {
            $data['result'] =  "success";
            $row = $this->{$this->modelName}->get($id);
            
            $data['data'] = $row;
            $this->ajax_helper->json($data);
            return;
        }
        if($this->userstate->isLogin() === false)
        {
            $data['result'] =  401;
            $this->ajax_helper->json($data);
            return;
        }
        
        $data['result'] = "값이 없습니다. ";
         
        $row = $this->{$this->modelName}->get($id);
        $data['data'] =$row;

        if($row !== null) //유효성 체크
        {
            $data['result'] = "success";
        }
     
     
        $this->ajax_helper->json($data);
    }

  
}

/* End of file Api_Controller.php */

?>