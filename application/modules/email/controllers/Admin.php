<?php 
namespace email;
//의존성 :: product, user
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends \Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }
 
    public function add()
    {
        $this->email_m->setRulesOnAddPage();
        if ($this->form_validation->run() === false) {
            $data["row"] = (object)["to"=>get("email")];
            $data["content_view"] = "admin/addUpdate";
            $this->template->render($data);
        } else {

            $from = "adminn";
            $this->email->from = $from;
            $this->email->send_email(post("to"),post("title"),post("desc"));
            $this->db->set("from","{$from}@".$_SERVER["HTTP_HOST"]);
            $this->email_m->addByPostData();
            alert("이메일을 보냈습니다.");
            my_redirect("/admin/email/list");
        }
    }
}

/* End of file Admin.php */

?>