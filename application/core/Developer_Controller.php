<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Developer_Controller extends MX_Controller {

	// public $data = array();
	public function __construct()
	{
        parent::__construct();

        $this->load->helper("url");
		$this->load->database();
		$this->load->dbforge();
        $this->load->helper('redirect');
        
		$this->_session();

		$this->load->model("global_info/global_info_m");
		$this->global_info_m->createTable();
		$this->global_info_m->alertTable();

		$this->load->model('setting_m');
		$this->setting_m->createTable();
		$this->setting_m->alertTable();
		
		$this->load->model("user/user_m");
		$this->user_m->createTable();
		$this->user_m->alertTable();
		$this->load->model('user_log/user_log_m');
		$this->user_log_m->createTable();
		$this->user_log_m->alertTable();

		
		$this->load->model('oauth/oauth_m');
		$this->oauth_m->createTable();
		$this->oauth_m->alertTable();
		

        $this->load->library("userstate");
        if($this->userstate->isLogin() === true)
		{
			$user_id = $this->userstate->whatLoginUserId();
			$this->userstate->user = $this->user_m->getByUserId($user_id);
		}
		if($this->userstate->isDeveloper() === false)
		{
            $this->userstate->logout();
			my_redirect("/user/login",false);
			exit;
        }
    }
    

    
	

}

/* End of file Base_Controller.php */
/* Location: ./application/core/Base_Controller.php */