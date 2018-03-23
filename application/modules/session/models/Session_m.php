
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//의존성 ::
class Session_M extends Pagination_Model 
{

	public function __construct()
	{
		parent::__construct();
		$this->table = "ci_sessions";
		$this->as = "ci_sessions";
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
	public function list($where = null)
	{
        if($this->router->fetch_class() === 'api')
        {
            $this->_select_api();
        }
        else
        {
            $this->_select();
        }
        $this->_callbackOrderBy(get_post("orderBy"));//정렬
        $method = "_list_{$this->className}";
        if($this->className ==="base")
            $this->db->where("{$this->as}.is_display","1");
        $this->$method();
        if($where !== null)
            $this->_where($where);
        // $this->where("is_display","1");
		$this->_from();
		$this->db->order_by("{$this->as}.id","desc");
		$rows =$this->db->get()->result();
		return $rows;
    }

	//------ @query @list@Get 정의

	protected function _select()
	{
		$this->db->select("
		{$this->as}.*,
		");
	}
	protected function _select_api()
	{
		$this->db->select("
		{$this->as}.id,
		");
	}
	protected function _from()
	{
		$this->db->from("$this->table as {$this->as}");
		// $this->db->join("user as u","b_c.user_id = u.id","LEFT");
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
	// protected function _searchData_admin()
	// {
	// 	return array(
	// 	);
	// }
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
	// public function createTable ()
	// {
	// 	$createTableQuery = "CREATE TABLE `{$this->table}`(
	// 	`id` INT UNSIGNED NULL AUTO_INCREMENT, 
	// 	-- `int` int NOT NULL DEFAULT '',
	// 	-- `varchar` varchar(255) NOT NULL DEFAULT '',
	// 	`is_display` boolean NOT NULL DEFAULT '1',
	// 	`is_secret` boolean NOT NULL DEFAULT '0',
	// 	`sort` INT NOT NULL DEFAULT '0',
	// 	`created` datetime NOT NULL DEFAULT NOW(),
	// 		-- UNIQUE KEY `uniqueIdx_#` (`#`),
	// 		-- KEY `idx_@` (`@`),
	//   --FULLTEXT KEY `idx_desc` (`desc`),
	// CONSTRAINT `fkBoardContent_board_key` FOREIGN KEY (`board_key`) REFERENCES board(`key`)
	// ON UPDATE CASCADE
	// // ON DELETE CASCADE
	// ,
	// 		KEY `idx_is_display` (`is_display`),
	// 		KEY `idx_is_secret` (`is_secret`),
	// 		KEY `idx_sort` (`sort`),
	// 		KEY `idx_created` (`created`),
	// 		PRIMARY KEY (`id`)
	// 		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	// 	$this->_createTable($createTableQuery);
	// }
	// @field
	public function alertTable()
	{
		// $fieldName = "test";
		// $addFieldQuery = "ALTER TABLE `{$this->table}` ADD `{$fieldName}` INT NOT NULL AFTER `created`, ADD INDEX `idx_{$fieldName}` (`{$fieldName}`);";
		// $this->_addField($fieldName,$addFieldQuery);
	}
}