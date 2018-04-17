<?php 
namespace applicationn;
//의존성 :: product, user
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends \Admin_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    public function get($id)
    {
        // $objDrawing =new \PHPExcel_Worksheet_Drawing();
        $data['row'] = $row = $this->{$this->modelName}->get($id);
        $this->load->model('file/file_m');
        $data["files"]  = $this->file_m->list_ByGroupId($row->file_group_id);
        $this->load->model("applicant/applicant_m");
        $this->db->order_by("id","asc");
        $this->db->where("application_id",$row->id);
        $data["applicant"] = $this->applicant_m->list();
            if($row->동요동시 ==="동요")
        $data["content_view"] = "admin/getAgitation";
            else
        $data["content_view"] = "admin/getPeom";
        $this->data += $data;
        // \var_dump($data["applicant"]);
        parent::get($id);
    }
    public function list()
    {
        parent::list();
    }
    public function excel()
    {
        $kind =get("kind");
        $personalOrGroup =get("personalOrGroup");

        $excelnm = iconv('UTF-8','EUC-KR',$kind." ".$personalOrGroup);

        header( "Content-type: application/vnd.ms-excel" );   
        header( "Content-type: application/vnd.ms-excel; charset=utf-8");  
        header( "Content-Disposition: attachment; filename = $excelnm.xls" );   
        header( "Content-Description: PHP4 Generated Data" );  
        print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">"); 
    
     
        $data['rows']=$this->applicationn_m->listForExcel($kind,$personalOrGroup);
        if($kind === "동요" && $personalOrGroup === "독창")
            $this->load->view("admin/listOfPersonalAgitationExcel",$data);
        elseif($kind === "동요" && $personalOrGroup === "중창")
            $this->load->view("admin/listOfGroupAgitationExcel",$data);
        elseif($kind === "동시" && $personalOrGroup === "개인")
            $this->load->view("admin/listOfPersonalPeomExcel",$data);
        elseif($kind === "동시" && $personalOrGroup === "단체")
            $this->load->view("admin/listOfGroupPeomExcel",$data);
        return;
    }

    protected function _ajaxUpdate($id,$callback =null)
	{
		$result =null;
		 //post
		 $this->ajax_helper->headerJson();
		 $this->{$this->modelName}->id = $id;
		 $this->{$this->modelName}->{"set_rules_update_".$this->className}();
		//  $this->{$this->modelName}->_set_rules_addUpdate();
		 if ($this->form_validation->run() === false) 
		 {
			$data = $this->ajax_helper->get_messageData("유효성검사", $this->form_validation->errors("<br>"),"info");
		 } 
		 else 
		 {
			$this->db->trans_start();	
			$result = $this->{$this->modelName}->update($id);
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) 
				$this->ajax_helper->set_flashMessage("수정 실패.","danger");
			else
				$this->ajax_helper->set_flashMessage("수정 되었습니다.","success");

			if($this->className ==="admin")
			{
				
				$data["reload"] = true;
				// $data["none"] = "true";
			}
			else
			{
				$data['redirect'] = my_site_url("/{$this->moduleName}/$id");
			}

		 }
		 if($callback !== null) $callback($result);
		 $this->data += $data;
		 $this->ajax_helper->json($this->data);
    }
    
    
}

/* End of file Admin.php */

?>