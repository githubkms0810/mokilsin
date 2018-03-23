<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."libraries/autoload.php");
class Public_Controller extends MX_Controller {
	public static $instance;
	public $user = null;
	public $setting = null;
	public $moduleName= null;
	public $className= null;
	public $methodName= null;
	public $modelName =null;
	public $data =array();
	public $referer;
	public $global_info;
	public function __construct()
	{
		parent::__construct();
		
		set_time_limit(10);
		
		if($this->input->post("login_maintain") === "true")
        {
            $this->config->set_item("sess_expiration",3600); //로그인유지 60분
            $this->config->set_item("sess_time_to_update",300);
        }

		if($this->input->method() === "post" && DEBUG === true)
		{
			$size = (int) $this->input->server("CONTENT_LENGTH");
			if($size >= 8388608 )
			{
				ob_clean();
				header("content-type:application/json");
				$data["alert"] = "파일 데이터가 너무 큽니다. (8MB 이하가능)";
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
				exit;
			}
		}
		self::$instance || self::$instance =& $this;
		$this->moduleName = $data["moduleName"]  = $this->router->fetch_module();
		$className =$this->router->fetch_class();
		if( $className === "api")
		{
			$className = "base";
		}
		$this->className = $data["className"]  =$className;
		$this->methodName =$data["methodName"] =  $this->router->fetch_method();
		if($this->modelName !== null)
		{
			$this->load->model($this->modelName);
		}
		else
		{
			try{
			$this->modelName = "{$this->moduleName}_m";
			$this->load->model("{$this->moduleName}_m");
			}catch(Exception $ex){
			}
		}
		date_default_timezone_set('Asia/Seoul');
		$this->referer = $this->input->server("HTTP_REFERER");
		// $this->output->enable_profiler(TRUE);
		// $this->load->library(array("form_validation"=>"fv"));
		// $this->fv->CI =& $this;
		$this->load->library("form_validation");
		$this->form_validation->CI =& $this;
	
		$this->load->library("upload");
		$this->load->library("userstate");
		$this->load->library("session");
		$this->load->library('ajax_helper');
		$this->load->library("template");
		$this->load->library("menudata_creator");
		$this->load->library("component");

		$this->load->database();
		
		$this->load->helper('common');
		$this->load->helper('url');
		$this->load->helper('redirect');

		if($this->userstate->isLogin() === true)
		{
			$this->load->model('user/user_m');
			$user_id = $this->userstate->whatLoginUserId();
			$this->user = $this->user_m->getByUserId($user_id);
			
		}
		else{
           $this->user = (object)array("id"=>null,"auth"=>"0","kind"=>"guest");
		}
		$this->userstate->user = $this->user;
		$this->setting = $this->db->from("setting")->where("id","1")->get()->row();
		
		$this->load->model("user_log/user_log_m");
		$this->user_log_m->add();
		//global info
		$this->load->model('global_info/global_info_m');
		$this->global_info = $data['global_info']=$this->global_info_m->p_get(1);
		$this->template->addData($data);
	}


	public function get($id)
	{
		$data['row'] = $this->{$this->modelName}->get($id);
        $data["fieldData"] = $this->{$this->modelName}->{"getData"}();
		// $data = $this->{$this->modelName}->additionalGetData();
		$data["content_view"] = "{$this->className}/get";

		$this->data += $data;
        $this->template->render($this->data);
	}
	public function list()
    {
		$data['rows']= $this->{$this->modelName}->listPagination();
        $data["fieldData"] = $this->{$this->modelName}->{"listData"}();
        $data["searchDataList"] = $this->{$this->modelName}->searchData();
        $data["orderByDataList"] = $this->{$this->modelName}->orderByData();

		$data["searchOption_view"] = "{$this->className}/searchOption";
		$data["content_view"] = array("{$this->className}/list","{$this->className}/search");
		
		$this->data += $data;
        $this->template->render($this->data);
	}
	
	public function add()
    {
		if($this->input->method() === "get")
		{
			$this->_add();
			return;
		}
		$this->_ajaxAdd();
	}
	protected function _add()
	{
		
		//input get
		$data['mode'] ="add";
		$data['row']=(object)array();
		$data["componentData"] = $this->{$this->modelName}->component();
		$data["content_view"] = "{$this->className}/addUpdate";
		
		$this->data += $data;
		$this->template->render($this->data);
		return;
	}	
	protected function _ajaxAdd($callback=null)
	{
		$insert_id =null;
 		//input ajax post
        $this->ajax_helper->headerJson();
        $this->{$this->modelName}->{"set_rules_add_".$this->className}();
        if ($this->form_validation->run() === false) //failed validation : alert errors
        {
			$data = $this->ajax_helper->get_messageData("유효성검사", $this->form_validation->errors("<br>"),"info");
			$this->ajax_helper->json($data);
			return;
        } 
        else  //succeed validation : add
        {
			$this->db->trans_start();	
			$insert_id =$this->{$this->modelName}->add();
			$this->db->trans_complete();
				
			if ($this->db->trans_status() === FALSE) 
				$this->ajax_helper->set_flashMessage("추가 실패.","danger");
			else
				$this->ajax_helper->set_flashMessage("추가 되었습니다.","success");
			if($this->className ==="admin")
			{
				$data['redirect'] = my_site_url("/{$this->moduleName}/admin/update/{$insert_id}");
				// $data['reload'] =true;
			}
			else
			{
				$data['redirect'] = my_site_url("/{$this->moduleName}/{$insert_id}");
			}
		}
		if($callback !== null ) 
		{
			$callback($insert_id);
		}
		$this->data += $data;
        $this->ajax_helper->json($this->data);
	}
	public function update($id)
    {
		if($this->input->method() === "get")
		{
			$this->_update($id);
			return;
		}
		$this->_ajaxUpdate($id);
	}
	protected function _update($id)
	{
		
		$data['mode'] ="update/$id";
		$data['row'] = $this->{$this->modelName}->get($id);
		$data["componentData"] = $this->{$this->modelName}->component();
		$data["content_view"] = "{$this->className}/addUpdate";
		
		$this->data += $data;
		$this->template->render($this->data);
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
    public function delete($id)
    {
		//input ajax post
		$this->_ajaxDelete($id);
	}
	public function _ajaxDelete($id,$callback=null)
	{
		$this->ajax_helper->headerJson();
		$this->db->trans_start();
		$result = $this->{$this->modelName}->delete($id);
		$this->db->trans_complete();
		if($this->className ==="admin")
		{
			if ($this->db->trans_status() === FALSE) 
				$this->ajax_helper->set_flashMessage("삭제 실패.","danger");
			else
				$this->ajax_helper->set_flashMessage("삭제되었습니다.","success");
			$data['redirect'] = my_site_url("/{$this->moduleName}/admin/list");
		}
		else
		{
			$data['redirect'] = my_site_url("/{$this->moduleName}/list");
		}
		if($callback !== null && $result !== null) $callback($result);
		$this->data += $data;
		$this->ajax_helper->json($this->data);

	}
	public function noDisplay($id)
	{
		$this->ajax_helper->headerJson();
		$this->db->trans_start();
		$result = $this->{$this->modelName}->noDisplay($id);
		$this->db->trans_complete();
		if($this->className ==="admin")
		{
			if ($this->db->trans_status() === FALSE) 
				$this->ajax_helper->set_flashMessage("수정 실패.","danger");
			else
				$this->ajax_helper->set_flashMessage("수정 되었습니다.","success");
			$data['redirect'] = my_site_url("/{$this->moduleName}/admin/list");
		}
		else
		{
			$data['redirect'] = my_site_url("/{$this->moduleName}/list");
		}
		
		$this->data += $data;
		$this->ajax_helper->json($this->data);
	}

	public function display($id)
	{
		$this->ajax_helper->headerJson();
		$this->db->trans_start();
		$result = $this->{$this->modelName}->display($id);
		$this->db->trans_complete();
		if($this->className ==="admin")
		{
			if ($this->db->trans_status() === FALSE) 
				$this->ajax_helper->set_flashMessage("수정 실패.","danger");
			else
				$this->ajax_helper->set_flashMessage("수정 되었습니다.","success");
			$data['redirect'] = my_site_url("/{$this->moduleName}/admin/list");
		}
		else
		{
			$data['redirect'] = my_site_url("/{$this->moduleName}/list");
		}
		
		$this->data += $data;
		$this->ajax_helper->json($this->data);
	}

	
}

/* End of file Public_Controller.php */
/* Location: ./application/core/Public_Controller.php */