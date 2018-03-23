<?php 
namespace small;
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
    
    public function about_us()
    {
        $data["content_view"] = "base/about_us";
        $this->template->render($data);
    }
    
    // public function portfolio_list()
    // {
    //     $data["content_view"] = "base/portfolio_list";
    //     $this->template->render($data);
    // }
    
    // public function portfolio_detail()
    // {
    //     $data["content_view"] = "base/portfolio_detail";
    //     $this->template->render($data);
    // }
    
    // public function partnership()
    // {
    //     $data["content_view"] = "base/partnership";
    //     $this->template->render($data);
    // }
    
    public function security()
    {
        $data["security_file_directory"] = $this->setting->security_file_directory;
        $data["content_view"] = "base/security";
        $this->template->render($data);
    }
    
    // public function service_center_list()
    // {
    //     $data["content_view"] = "base/service_center_list";
    //     $this->template->render($data);
    // }
    
    // public function service_center_detail()
    // {
    //     $data["content_view"] = "base/service_center_detail";
    //     $this->template->render($data);
    // }


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
//     public function delete($id)
//     {
//         parent::_ajaxDelete($id);
//     }
}

/* End of file Admin.php */

?>