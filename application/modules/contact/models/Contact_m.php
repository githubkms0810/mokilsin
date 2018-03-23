
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//의존성 ::
class Contact_m extends Pagination_Model 
{
	// protected $numRows_moduleName = "file";
	// protected $numRows_foreignKey = "file_id";
	// protected $numRows_fieldName = "num_download_log";
	public function __construct()
	{
		$this->table = "contact";
		$this->as = "contact";
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
	//			array("method"=>"ajaxImage","displayName"=>"프로필 사진","inputName"=>"profile_image", "default"=>"/public/images/unknown.png"),
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
	public function setRulesWhenAdd()
	{
		$this->form_validation->set_rules('manager', '담당자', 'trim|required');
		$this->form_validation->set_rules('manager_phone', '담당자 번호', 'trim|required');
		$this->form_validation->set_rules('desc', '메세지', 'trim|required');
	}
	public function addByPostData()
	{
		$this->set_post("company_name");
		$this->set_post("manager");
		$this->set_post("manager_phone");
		$this->set_post("email");
		$this->set_post("desc");
		return $this->p_add();
	}

	public function updateIsReading($id)
	{
		$this->db->set("is_reading","1");
		return $this->p_update($id);
	}
	//------ @query @list@Get 정의

	protected function _select()
	{
		$this->db->select("
		{$this->as}.*,
		");
	}
	// protected function _select_admin()
    // {
    //     $this->_select();
    // }
    // protected function _select_base()
    // {
    //     $this->_select();
	// }
	protected function _select_api()
	{
		$this->db->select("
		{$this->as}.id,
		");
	}
	protected function _from()
	{
		$this->db->from("$this->table as {$this->as}");
		// $this->db->join("user as u","{$this->as}.user_id = u.id","LEFT");
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
			array("displayName"=>"회사","fieldName"=>"company_name"),
			array("displayName"=>"담당자명","fieldName"=>"manager"),
			array("displayName"=>"내용","fieldName"=>"desc"),
			array("displayName"=>"읽음/안읽음","fieldName"=>"is_reading"),
			array("displayName"=>"생성일","fieldName"=>"created"),
		);
	}
	public function getData_admin()
	{
		return array(
			array("displayName"=>"ID","fieldName"=>"id"),
			array("displayName"=>"회사이름","fieldName"=>"company_name"),
			array("displayName"=>"담당자명","fieldName"=>"manager"),
			array("displayName"=>"담당자연락처","fieldName"=>"manager_phone"),
			array("displayName"=>"이메일","fieldName"=>"email"),
			array("displayName"=>"내용","fieldName"=>"desc"),
			array("displayName"=>"읽음/안읽음","fieldName"=>"is_reading"),
			array("displayName"=>"생성일","fieldName"=>"created"),
		);
	}
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


	protected function _searchData()
    {
        return array(
			"company_name"=>array("displayName"=>"회사","fieldName"=>"{$this->as}.company_name"),
			"manager"=>array("displayName"=>"담당자","fieldName"=>"{$this->as}.manager"),
			"manager_phone"=>array("displayName"=>"담당자 번호","fieldName"=>"{$this->as}.manager_phone"),
			"email"=>array("displayName"=>"이메일","fieldName"=>"{$this->as}.email"),
			"id"=>array("displayName"=>"ID","fieldName"=>"{$this->as}.id"),
		);
		
	}
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
		-- `int` int UNSIGNED NOT NULL DEFAULT '',
		-- `varchar` varchar(255) NOT NULL DEFAULT '',
		`company_name` varchar(255),
		`manager` varchar(255),
		`manager_phone` varchar(255),
		`email` varchar(255),
		`title` varchar(255),
		`desc` TEXT(255),
		`is_reading` boolean NOT NULL DEFAULT '0',
		`is_display` boolean NOT NULL DEFAULT '1',
		`is_secret` boolean NOT NULL DEFAULT '0',
		`sort` INT NOT NULL DEFAULT '0',
		`created` datetime NOT NULL DEFAULT NOW(),
			-- UNIQUE KEY `uniqueIdx_@` (`@`),
			-- KEY `idx_@` (`@`),
	
	  		KEY `idx_company_name` (`company_name`),
	  		KEY `idx_manager` (`manager`),
	  		KEY `idx_manager_phone` (`manager_phone`),
	  		KEY `idx_email` (`email`),
	  		KEY `idx_title` (`title`),
	  		KEY `idx_is_reading` (`is_reading`),
			FULLTEXT KEY `idx_desc` (`desc`),
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