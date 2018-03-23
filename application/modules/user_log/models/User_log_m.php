
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//의존성 ::
class User_log_M extends Pagination_Model 
{

	public function __construct()
	{
		parent::__construct();
		$this->table = "user_log";
		$this->as = "u_l";
	}
	
	//------@component addUpdate  정의
	// protected function _component_addUpdate()
	// {
	// 	return array(
	// 		array("inputName"=>"name","displayName"=>"이름"),
	// 	);
	// }
	// protected function _component_add()
	// {
	// 	return array();
	// }
	// protected function _component_update()
	// {
	// 	return array();
	// }
	

	//------@addUpdate 정의
		
	// protected function _add_admin()
	// {
	// 	return parent::_add_admin();
	// }

	// protected function _update_admin($id)
	// {
	// 	parent::_update_admin($id);
	// }
	// protected function _add_base()
	// {
	// 	$this->set_post("name");
	// 	$insert_id= $this->p_add();
	// 	return $insert_id;
	// }

	// protected function _update_base($id)
	// {
	// 	$this->set_post("name");
	// 	$this->p_update($id);
	// }


	//------ @validation addUpdate 정의

	// protected function _set_rules_addUpdate()
	// {
	// 	$this->form_validation->set_rules('name', '이름', 'trim|required');
	// }
	// protected function _set_rules_add()
	// {
	// 	$this->form_validation->set_rules('name', '이름', 'trim|required');
	// }
	// protected function _set_rules_update()
	// {
	// 	$this->form_validation->set_rules('name', '이름', 'trim|required');
	// }

	// protected function _set_rules_addUpdate_admin()
	// {
	// 	$this->form_validation->set_rules('name', '이름', 'trim|required');
	// }
	// protected function _set_rules_add_admin()
	// {
	// 	$this->form_validation->set_rules('name', '이름', 'trim|required');
	// }
	// protected function _set_rules_update_admin()
	// {
	// 	$this->form_validation->set_rules('name', '이름', 'trim|required');
	// }

	// protected function _set_rules_addUpdate_base()
	// {
	// 	$this->form_validation->set_rules('name', '이름', 'trim|required');
	// }
	// protected function _set_rules_add_base()
	// {
	// 	$this->form_validation->set_rules('name', '이름', 'trim|required');
	// }
	// protected function _set_rules_update_base()
	// {
	// 	$this->form_validation->set_rules('name', '이름', 'trim|required');
	// }
	//------ @cusotm
	public function add()
	{
		//개발자이거나 관리자이거나 테스트이면 setting에 ip저장해놓고 리턴 null
		if($this->userstate->isAdmin() === true || $this->user->id  === '3')
		{
			$this->load->model("setting_m");
			if($this->userstate->isDeveloper())
				$this->set("developer_ip_address",$this->input->ip_address());
			elseif($this->userstate->isAdmin())
				$this->set("admin_ip_address",$this->input->ip_address());
			elseif($this->user->id  === '3')
				$this->set("test_ip_address",$this->input->ip_address());
			$this->setting_m->p_update('1');
			return null;
		}
		//해당 아이피가 developer||admin||test으로 접속했던 아이피면 return null
	
		if($this->input->ip_address() === $this->CI->setting->admin_ip_address || $this->input->ip_address() === $this->CI->setting->developer_ip_address || $this->input->ip_address() === $this->CI->setting->test_ip_address)
			return null;
		$this->set("user_id",$this->user->id);
		$this->set("ip_address", $this->input->ip_address());
		$this->set("user_agent",$this->input->user_agent());
		$this->set("request_url",current_url());
		$this->set("referer",$this->input->server("HTTP_REFERER"));
		$insert_id =$this->p_add();
		return $insert_id;
	}

	//------ @query @list@Get 정의

	protected function _select()
	{
		$this->db->select("
		{$this->as}.*,
		IF({$this->as}.user_id is null,'손님', u.displayName) as displayName,
		");
	}
	// protected function _select_api()
	// {
	// 	$this->db->select("
	// 	{$this->as}.id,
	// 	");
	// }
	protected function _from()
	{
		$this->db->from("{$this->table} as {$this->as}");
		$this->db->join("user as u","{$this->as}.user_id = u.id","LEFT");
	}
	protected function _get_admin()
	{
	}
	protected function _get_base()
	{
		
	}
	protected function _list_admin()
	{
	}
	protected function _list_base()
	{
	
	}
	

	//@listGet 필드네임 정의
	//admin
	public function listData_admin()
	{
		return array(
			array("displayName"=>"ID","fieldName"=>"id"),
			array("displayName"=>"아이피","fieldName"=>"ip_address"),
			array("displayName"=>"별명","fieldName"=>"displayName"),
		);
	}
	// public function getData_admin()
	// {
	// 	return array(
	// 		array("displayName"=>"ID","fieldName"=>"id"),
	// 		array("displayName"=>"이름","fieldName"=>"name"),
	// 		array("displayName"=>"보이기","fieldName"=>"is_display"),
	// 	);
	// }
	//base
	// public function listData_base()
	// {
	// 	return array(
	// 		array("displayName"=>"ID","fieldName"=>"id"),
	// 		array("displayName"=>"이름","fieldName"=>"name"),
	// 		array("displayName"=>"보이기","fieldName"=>"is_display"),
	// 	);
	// }
	// public function getData_base()
	// {
	// 	return array(
	// 		array("displayName"=>"ID","fieldName"=>"id"),
	// 		array("displayName"=>"이름","fieldName"=>"name"),
	// 		array("displayName"=>"보이기","fieldName"=>"is_display"),
	// 	);
	// }




	//------@search 검색을 허용할 필드들을 정의합니다 


	// protected function _searchData()
    // {
    //     return array(
	// 		"title"=>array("displayName"=>"제목","fieldName"=>"b_c.title","kind"=>"or"),
	// 		"desc"=>array("displayName"=>"내용","fieldName"=>"desc","kind"=>"textfull-or"),
	// 		"titleDesc"=>array("displayName"=>"제목+내용","fieldName"=>["b_c.title","desc"],"kind"=>["or","textfull-or"]),
	// 		"displayName"=>array("displayName"=>"글쓴이","fieldName"=>"u.displayName","kind"=>"or"),
	// 	);
		
	// }
	protected function _searchData_admin()
	{
		return array(
			array("displayName"=>"유저 별명","fieldName"=>"u.displayName"),
			array("displayName"=>"유저 이름","fieldName"=>"u.name"),
			array("displayName"=>"유저 이메일","fieldName"=>"u.email"),
			array("displayName"=>"아이피","fieldName"=>"u_l.ip_address"),
			array("displayName"=>"user_agent","fieldName"=>"u_l.user_agent"),
			array("displayName"=>"request_url","fieldName"=>"u_l.request_url"),
			array("displayName"=>"생성일","fieldName"=>"u_l.created"),

		);
	}
	// protected function _searchData_base()
    // {
    //     return array(
			
	// 	);
	// }

	//------ @order 정렬 할 필드들을 정의합니다.
	// protected function _orderByData()
    // {
    //     return array(
	// 		"newset"=>array("displayName"=>"최근순","fieldName"=>"{$this->as}.id","sort"=>"desc"),
	// 		"lastest"=>array("displayName"=>"등록순","fieldName"=>"{$this->as}.id","sort"=>"asc"),
    //     );
    // }
    // protected function _orderByData_admin()
    // {
    //     return array();
    // }
    // protected function _orderByData_base()
    // {
    //     return array(
    //     );
    // }
	//---- @setting 어드민 페이지의 세팅을 정의합니다.

	// protected function _settingComponent_admin()
	// {
	// 	return array();
	// }



	//------@table 다음 테이블을 만듭니다.
	public function createTable ()
	{
		$createTableQuery = "CREATE TABLE `{$this->table}`(
		`id` INT UNSIGNED NULL AUTO_INCREMENT, 
		`user_id` int UNSIGNED,
		`ip_address` varchar(255) NOT NULL,
		`user_agent` varchar(255) NOT NULL,
		`request_url` varchar(255) NOT NULL,
		`referer` varchar(255),
		-- `int` int NOT NULL DEFAULT '',
		-- `varchar` varchar(255) NOT NULL DEFAULT '',
		`is_display` boolean NOT NULL DEFAULT '1',
		`is_secret` boolean NOT NULL DEFAULT '0',
		`sort` INT NOT NULL DEFAULT '0',
		`created` datetime NOT NULL DEFAULT NOW(),
			-- UNIQUE KEY `uniqueIdx_#` (`#`),
			-- KEY `idx_@` (`@`),
			KEY `idx_user_id` (`user_id`),
			KEY `idx_ip_address` (`ip_address`),
			KEY `idx_user_agent` (`user_agent`),
			KEY `idx_request_url` (`request_url`),
			KEY `idx_referer` (`referer`),
	CONSTRAINT `fkUserLog_user_id` FOREIGN KEY (`user_id`) REFERENCES user(`id`)
	ON UPDATE CASCADE
	ON DELETE CASCADE
	,
			KEY `idx_is_display` (`is_display`),
			KEY `idx_is_secret` (`is_secret`),
			KEY `idx_sort` (`sort`),
			KEY `idx_created` (`created`),
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$this->_createTable($createTableQuery);
	}
	// @field
	public function alertTable()
	{
		$table ="setting";
		$fieldName = "developer_ip_address";
		$addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` varchar(255) AFTER `id`;";
		$this->_addField($fieldName,$addFieldQuery,$table);

		$fieldName = "admin_ip_address";
		$addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` varchar(255) AFTER `id`;";
		$this->_addField($fieldName,$addFieldQuery,$table);
		$fieldName = "test_ip_address";
		$addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` varchar(255) AFTER `id`;";
		$this->_addField($fieldName,$addFieldQuery,$table);
		// $fieldName = "test";
		// $addFieldQuery = "ALTER TABLE `{$this->table}` ADD `{$fieldName}` INT NOT NULL AFTER `created`, ADD INDEX `idx_{$fieldName}` (`{$fieldName}`);";
		// $this->_addField($fieldName,$addFieldQuery);
	}
}