
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//의존성 ::
class Content_log_M extends Pagination_Model 
{
	// protected $numRows_moduleName = "file";
	// protected $numRows_foreignKey = "file_id";
	// protected $numRows_fieldName = "num_download_log";
	public function __construct()
	{
		$this->table = "board_content_log";
		$this->as = "content_log";
		parent::__construct();
	}
	
	//------@component addUpdate  정의
	// protected function _component_addUpdate()
	// {
	// 	return array(
	// 		array(
	// 			array("method"=>"text","fieldName"=>["total_price"],"displayName"=>["총가격"],"inputName"=>""),
	// 			array("inputName"=>"name","displayName"=>"이름"),
	// 			array("inputName"=>"version","type"=>"radio","inputValue"=>["정식","베타"],"inputDisplayName"=>["정식","베타"],"displayName"=>"버전"),
	// 			array("method"=>"summernote","inputName"=>"desc","displayName"=>"설명"),
	// 			array("updateDefault"=>"displayName","method"=>"inputSearch","table"=>"user","searchField"=>["displayName","userName","name"],"searchFieldDisplayName"=>["별명","아이디","이름"],"displayName"=>"유저검색","inputName"=>"user_id","inputValue"=>"id"),
	// 			array("type"=>"hidden","inputName"=>"product_id","default"=>function($row){return $row->id;}),
	// 			array("type"=>"number","inputName"=>"num","displayName"=>"개수"),
	// 		),
	// 		array(
	// 			"moduleName"=>"product_order_detail",
	// 			array("type"=>"hidden","inputName"=>"order_id","default"=>function($row){return $row->id;}),
	// 			array("updateDefault"=>false,"method"=>"inputSearch","table"=>"product","searchField"=>["name"],"searchFieldDisplayName"=>["상품이름"],"displayName"=>"주문 디테일 추가","inputName"=>"product_id","inputValue"=>"id"),
	// 			array("type"=>"number","inputName"=>"num","displayName"=>"개수"),
	// 			array("type"=>"number","inputName"=>"price","displayName"=>"가격"),
				
	// 			"rows" => array(
	// 				"displayName" =>"주문 디테일",
	// 				"variableName"=>"product_order_details",
	// 				"moduleName"=>"product_order_detail",
	// 				"alertButton"=>false,
	// 				array("method"=>"text","fieldName"=>["product_name","num","price"],"displayName"=>["이름","개수","개당 가격"],"href"=>function($row){return "/admin/product_order_detail/update/{$row->id}";}),
	// 			),
	// 		),
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

	public function getBySessionId_andContentId($session_id,$content_id)
	{
		$this->db->select("
		{$this->as}.id,
		");
		$this->db->from("$this->table as {$this->as}");
		$this->db->join("ci_sessions as s","{$this->as}.session_id = s.id","LEFT");
		

		$this->db->where("(s.id = '$session_id' OR {$this->as}.user_id = '{$this->user->id}') ","",false);
		$this->db->where("DATE({$this->as}.created)","CURDATE()",false);
		$this->db->where("content_id",$content_id);
		return $this->db->get()->row();

	}
	//------ @query @list@Get 정의

	protected function _select()
	{
		$this->db->select("
		{$this->as}.*,
		{$this->displayName2},
		b_c.title as title,
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
		$this->db->join("user as u","{$this->as}.user_id = u.id","LEFT");
		$this->db->join("ci_sessions as s","{$this->as}.session_id = s.id","LEFT");
		$this->db->join("board_content as b_c","{$this->as}.content_id = b_c.id","LEFT");
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
			array("displayName"=>"제목","fieldName"=>"title"),
			array("displayName"=>"글쓴이","fieldName"=>"displayName"),
			array("displayName"=>"ip_address","fieldName"=>"ip_address"),
			array("displayName"=>"생성일","fieldName"=>"created"),
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
	public function createTable ()
	{
		$createTableQuery = "CREATE TABLE `{$this->table}`(
		`id` INT UNSIGNED NULL AUTO_INCREMENT, 
		`content_id` int UNSIGNED NOT NULL,
		`user_id` int UNSIGNED,
		`ip_address` varchar(255),
		`session_id` varchar(255),
		`is_display` boolean NOT NULL DEFAULT '1',
		`is_secret` boolean NOT NULL DEFAULT '0',
		`sort` INT NOT NULL DEFAULT '0',
		`created` datetime NOT NULL DEFAULT NOW(),
	
	CONSTRAINT `fkContentLog_user_id` FOREIGN KEY (`user_id`) REFERENCES user(`id`)
	ON UPDATE CASCADE
	ON DELETE CASCADE
	,
	CONSTRAINT `fkContentLog_content_id` FOREIGN KEY (`content_id`) REFERENCES board_content(`id`)
	ON UPDATE CASCADE
	ON DELETE CASCADE
	,

	KEY `idx_user_id` (`user_id`),
			KEY `idx_content_id` (`content_id`),
			KEY `idx_ip_address` (`ip_address`),
			KEY `idx_session_id` (`session_id`),
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
		// $fieldName = "test";
		// $addFieldQuery = "ALTER TABLE `{$this->table}` ADD `{$fieldName}` INT UNSIGNED NOT NULL AFTER `created`, ADD INDEX `idx_{$fieldName}` (`{$fieldName}`);";
		// $this->_addField($fieldName,$addFieldQuery);

		// $fieldName = "kind";
		// $alterFiledQuery="ALTER TABLE `{$this->table}` CHANGE `{$fieldName}` `{$fieldName}` ENUM('developer','admin','general') DEFAULT 'general';";
		// $this->_alterField($fieldName,$alterFiledQuery);
		
	}
}