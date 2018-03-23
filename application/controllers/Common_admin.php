<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Common_admin extends Admin_Controller {
    
    public function __construct()
    {
        parent::__construct();
    }
    public function ajaxGetList($limit = 4)
    {
        $tableName = post("table");
        $offset =post("offset");
        $search =post("search");
        $field =post("field");
        $inputValue =post("value");
        $modelName = "{$tableName}_m";
        $this->load->model("{$tableName}/{$modelName}");

        $this->ajax_helper->headerJson();
        $this->db->limit($limit,$offset);
        $this->db->select("id");
        $this->db->select($inputValue);
        $this->db->select($field);

        //앞에 공백 삭제
        $idx = 0;
        $strlen=strlen($search);
        for ($i=0; $i < $strlen; $i++) { 
            if($search[$i] !== " ")
            {
                $idx = $i-1;
                break;
            }
            elseif($i === $strlen-1){
                $idx =$i;
            }            
        }
        $search =substring($search,$idx+1,$strlen-1);

        if($search !== "")
        {
            $this->db->or_like($field,$search);
        }
        $data["rows"] = $this->$modelName->p_list(null);
        $data["offset"] = $limit + $offset;
        $this->ajax_helper->json($data);
    }
   
}

/* End of file Common.php */

?>
