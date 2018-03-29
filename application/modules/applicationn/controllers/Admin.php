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
    public function excel()
    {
        
        header( "Content-type: application/vnd.ms-excel" ); 
        header( "Content-type: application/vnd.ms-excel; charset=utf-8");
        header( "Content-Disposition: attachment; filename = invoice.xls" ); 
        header( "Content-Description: PHP4 Generated Data" );

        ob_start();
        $this->load->view("admin/get");
        $EXCEL_STR = ob_get_clean();
        echo "<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'> ";
        echo $EXCEL_STR;
    }
}

/* End of file Admin.php */

?>