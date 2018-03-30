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
        $data["applicant"] = $this->applicant_m->list();
        $this->data += $data;
        parent::get($id);
    }
    public function list()
    {
        parent::list();
    }
    public function excel($id)
    {
        header( "Content-type: application/vnd.ms-excel" ); 
        header( "Content-type: application/vnd.ms-excel; charset=utf-8");
        header( "Content-Disposition: attachment; filename = invoice.xls" ); 
        header( "Content-Description: PHP4 Generated Data" );
        $data['row'] = $row = $this->{$this->modelName}->get($id);
        $this->load->model('file/file_m');
        $data["files"]  = $this->file_m->list_ByGroupId($row->file_group_id);
        $this->load->model("applicant/applicant_m");
        $data["applicant"] = $this->applicant_m->list();
        echo "<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'> ";
        // $this->load->view("admin/get",$data);
        $data['content_view'] = "admin/get";
        $this->template->render($data);
        // echo $EXCEL_STR;
    }
}

/* End of file Admin.php */

?>