
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//의존성 ::
class Global_info_M extends Pagination_Model 
{

	public function __construct()
	{
		parent::__construct();
		$this->table = "global_info";
		$this->as = "global_info";
	}
	// `title` varchar(255),
	// `desc` varchar(255),
	// `keywords` varchar(255),
	// `og_type` varchar(255),
	// `og_site_name` varchar(255),
	// `og_title` varchar(255),
	// `og_url` varchar(255),
	// `og_desc` varchar(255),
	// `og_image` varchar(255),
	// -- `google_analytics_code` varchar(255),
	// `phone` varchar(255),
	// `eamil` varchar(255),
	// `kakao_id` varchar(255),
	// `representation` varchar(255),
	// `business_name` varchar(255),
	// `business_number` varchar(255),
	// `business_address` varchar(255),
	// `copyright` varchar(255),
	// `bank_number` varchar(255),
	//------@component addUpdate  정의
	protected function _component_addUpdate()
	{
		return array(
			
			array("inputName"=>"title","displayName"=>"사이트 제목"),
			array("inputName"=>"desc","displayName"=>"사이트 설명"),
			array("inputName"=>"keywords","displayName"=>"사이트 키워드(,로 구분)"),
			array("inputName"=>"og_type","type"=>"radio","inputValue"=>["site"],"inputDisplayName"=>["site"],"displayName"=>"모바일 미리보기 타입"),
			array("inputName"=>"og_site_name","displayName"=>"모바일 사이트 이름"),
			array("inputName"=>"og_title","displayName"=>"모바일 사이트 제목"),
			array("inputName"=>"og_url","displayName"=>"모바일 사이트 URL"),
			array("inputName"=>"og_desc","displayName"=>"모바일 사이트 설명"),
			array("method"=>"ajaxImage","displayName"=>"모바일 사진","inputName"=>"og_image", "default"=>"/public/images/unknown.png"),
			array("inputName"=>"phone","displayName"=>"대표 연락처"),
			array("inputName"=>"eamil","displayName"=>"대표 이메일"),
			array("inputName"=>"kakao_id","displayName"=>"대표 카카오톡 아이디"),
			array("inputName"=>"kakao_id","displayName"=>"대표 네이트온 아이디"),
			array("inputName"=>"representation","displayName"=>"대표 대표 성명"),
			array("inputName"=>"business_name","displayName"=>"사업자 이름"),
			array("inputName"=>"business_number","displayName"=>"사업자 번호"),
			array("inputName"=>"business_address","displayName"=>"사업자 주소"),
			array("inputName"=>"copyright","displayName"=>"라이센스"),
			array("inputName"=>"bank_number","displayName"=>"무통장 계좌번호"),
		);
	}
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
	// public function listData_admin()
	// {
	// 	return array(
	// 		array("displayName"=>"ID","fieldName"=>"id"),
	// 		array("displayName"=>"이름","fieldName"=>"name"),
	// 		array("displayName"=>"보이기","fieldName"=>"is_display"),
	// 	);
	// }
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
		-- `int` int NOT NULL DEFAULT '',
		-- `varchar` varchar(255) NOT NULL DEFAULT '',
		`title` varchar(255),
		`desc` varchar(255),
		`keywords` varchar(255),
		`og_type` varchar(255),
		`og_site_name` varchar(255),
		`og_title` varchar(255),
		`og_url` varchar(255),
		`og_desc` varchar(255),
		`og_image` varchar(255),
		-- `google_analytics_code` varchar(255),
		`phone` varchar(255),
		`eamil` varchar(255),
		`kakao_id` varchar(255),
		`nateon_id` varchar(255),
		`representation` varchar(255),
		`business_name` varchar(255),
		`business_number` varchar(255),
		`business_address` varchar(255),
		`copyright` varchar(255),
		`bank_number` varchar(255),

	

		`is_display` boolean NOT NULL DEFAULT '1',
		`is_secret` boolean NOT NULL DEFAULT '0',
		`sort` INT NOT NULL DEFAULT '0',
		`created` datetime NOT NULL DEFAULT NOW(),
			KEY `idx_is_display` (`is_display`),
			KEY `idx_is_secret` (`is_secret`),
			KEY `idx_sort` (`sort`),
			KEY `idx_created` (`created`),
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$this->_createTable($createTableQuery, function(){
			$this->db->set("id","1");
			$this->db->set("title","SITE_TITLE");
			$this->db->set("og_type","site");
			
			$this->db->insert($this->table);
		});
	}
	// @field
	public function alertTable()
	{
		// $fieldName = "test";
		// $addFieldQuery = "ALTER TABLE `{$this->table}` ADD `{$fieldName}` INT NOT NULL AFTER `created`, ADD INDEX `idx_{$fieldName}` (`{$fieldName}`);";
		// $this->_addField($fieldName,$addFieldQuery);

		// $fieldName = "kind";
		// $alterFiledQuery="ALTER TABLE `{$this->table}` CHANGE `{$fieldName}` `{$fieldName}` ENUM('developer','admin','general') DEFAULT 'general';";
		// $this->_alterField($fieldName,$alterFiledQuery);
		
	}
}