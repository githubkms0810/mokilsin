
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//의존성 ::
class Freelancer_m extends Pagination_Model 
{
	// protected $numRows_moduleName = "content";
	// protected $numRows_fieldName = "num_download_log";
	public function __construct()
	{
		$this->table = "freelancer";
		$this->as = "freelancer";
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
	// 	parent::_add_base();
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
		$this->form_validation->set_rules('name', '이름', 'trim|required|min_length[1]|max_length[12]');
		// $this->form_validation->set_rules('phone', '휴대폰', 'trim|required');
		// $this->form_validation->set_rules('new_address', '주소', 'trim|required');
		// $this->form_validation->set_rules('address_detail', '상세주소', 'trim|required');
		// $this->form_validation->set_rules('apply_field', '지원분야', 'trim|required');
		// $this->form_validation->set_rules('account_bank', '은행이름', 'trim|required');
		// $this->form_validation->set_rules('account_number', '계좌번호', 'trim|required');
		// $this->form_validation->set_rules('account_name', '예금주', 'trim|required');
		$this->form_validation->set_rules('languages[]', '사용언어', 'trim|required');
		// $this->form_validation->set_rules('translation_direction', '언어방향', 'trim|required');
	}
	public function addByPostDataAndByFileGroupId($file_group_id)
	{
		$this->set("file_group_id",$file_group_id);
		return $this->addByPostData();
	}
	public function updateByPostData($id)
	{
		$this->setPostDataWhenAddUpdate();
		return $this->p_update($id);
	}
	private function addByPostData()
	{
		$this->setPostDataWhenAddUpdate();
		$insert_id= $this->p_add();

		$this->load->model("count_m");
		$this->count_m->plusOneToField("num_freelancer");
		return $insert_id;
	}
	private function setPostDataWhenAddUpdate()
	{
		$this->load->library("post_helper");
		$this->set_post("name");
		$this->set_post("birth_year");
		$this->set_post("birth_month");
		$this->set_post("birth_day");
		$this->set_post("sex");
		$this->set_post("phone");
		$this->set("email",$this->post_helper->makeEmailByPostData());
		$this->set_post("post_number");
		// $this->set_post("is_have_career");
		$this->set_post("old_address");
		$this->set_post("new_address");
		$this->set_post("address_detail");
		$this->set_post("apply_field");
		$this->set_post("account_bank");
		$this->set_post("account_number");
		$this->set_post("account_name");
		$this->db->set("translation_direction",$_POST["translation_direction"]);
		// $this->set_post("translation_direction");
		$this->set_post("is_employed");
		$this->set_post("university");
		$this->set_post("university_major");
		$this->set_post("is_graduate_school");
		$this->set_post("graduate_school");
		$this->set_post("graduate_school_degree");
		$this->set_post("graduate_school_major");
	}
	public function delete($id)
	{
		$this->load->model("count_m");
		$this->count_m->minusOneToField("num_freelancer");
		parent::delete($id);
	}
	public function listPagination($where=null,$inConfig=array())
	{
		$this->load->model("count_m");
		$config["get_count_field"] = $this->count_m->p_get(1,"num_freelancer")->num_freelancer;
		$config["isIgnoreCountOnAdminPage"] = true;
		return parent::listPagination(null,$config);
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
		$this->db->join("(select freelancer_id, group_concat(language) as languages from freelancer_translation_language GROUP BY freelancer_id) freelancer_translation_language ","{$this->as}.id = freelancer_translation_language.freelancer_id","LEFT");
		$this->db->join("(select freelancer_id, group_concat(detail) as field_detail from freelancer_translation_field GROUP BY freelancer_id) freelancer_translation_field ","{$this->as}.id = freelancer_translation_field.freelancer_id","LEFT");
		// $this->db->join("freelancer_translation_language as f_t_l","{$this->as}.id = f_t_l.freelancer_id","LEFT");
	}

	protected function _get_admin()
	{
		$this->db->select("
		freelancer_translation_language.languages,
		freelancer_translation_field.field_detail,
		");
	}

	protected function _get_base()
	{
		
	}

	protected function _list_admin()
	{
		// $this->db->group_by("{$this->as}.id");
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
			array("displayName"=>"이름","fieldName"=>"name"),
			array("displayName"=>"관리자 승인","fieldName"=>"is_admin_confirm"),
			array("displayName"=>"생성일","fieldName"=>"created"),
		);
	}
	public function getData_admin()
	{
		return array_merge(parent::getData_admin(),
		array(
			array("displayName"=>"언어","fieldName"=>"language"),
			array("displayName"=>"분야","fieldName"=>"field_detail"),
			)
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
			"name"=>array("displayName"=>"이름","fieldName"=>"{$this->as}.name","kind"=>"like"),
			"phone"=>array("displayName"=>"개인연락처","fieldName"=>"{$this->as}.phone","kind"=>"like"),
			"birth"=>array("displayName"=>"생일년도","fieldName"=>"{$this->as}.birth_year","kind"=>"like"),
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

	protected function _settingComponent_admin()
	{
		return array(
				array("displayName"=>"프리랜서 신청할떄 번역 가능언어 쉼표로 구분","inputName"=>"translation_languages")
		);
	}



	//------@table 다음 테이블을 만듭니다.
	public function createTable ()
	{
		$createTableQuery = "CREATE TABLE `{$this->table}`(
		`id` INT UNSIGNED NULL AUTO_INCREMENT, 
		-- `int` int UNSIGNED NOT NULL DEFAULT '',
		-- `varchar` varchar(255) NOT NULL DEFAULT '',
		`profile_image` varchar(255) DEFAULT '',
		`name` varchar(255), 
		`nation` varchar(255),
		`birth_year` varchar(255),
		`birth_month` varchar(255),
		`birth_day` varchar(255),
		`sex` ENUM('남성','여성'),
		`tel` varchar(255),
		`phone` varchar(255),
		`email` varchar(255),
		`post_number` varchar(255),
		`old_address` varchar(255),
		`new_address` varchar(255),
		`address_detail` varchar(255),
		`apply_field` varchar(255),
		`account_bank` varchar(255),
		`account_number` varchar(255),
		`account_name` varchar(255),
		`is_have_career` boolean,
		`translation_direction` varchar(255),
		`is_employed` boolean,
		`university` varchar(255),
		`university_major` varchar(255),
		`is_graduate_school` boolean,
		`graduate_school` varchar(255),
		`graduate_school_degree` varchar(255),
		`graduate_school_major` varchar(255),
		`experience` varchar(255),
		`etc` varchar(255),
		`level` varchar(255),
		`is_send_email` boolean not null default '0',

		`file_group_id` int UNSIGNED,

		`application_file_directory1` varchar(255),
		`application_file_directory2` varchar(255),
		`can_working_day` varchar(255),
		`num_translation_per_day` int UNSIGNED,
		`admin_score` INT,
		`admin_memo` text,

		`is_admin_confirm` boolean NOT NULL default '0',
		`is_display` boolean NOT NULL DEFAULT '1',
		`is_secret` boolean NOT NULL DEFAULT '0',
		`sort` INT NOT NULL DEFAULT '0',
		`created` datetime NOT NULL DEFAULT NOW(),
			-- UNIQUE KEY `uniqueIdx_@` (`@`),
			KEY `idx_name` (`name`),
			KEY `idx_nation` (`nation`),
			KEY `idx_sex` (`sex`),
			KEY `idx_tel` (`tel`),
			KEY `idx_phone` (`phone`),
			KEY `idx_email` (`email`),
			KEY `idx_post_number` (`post_number`),
			KEY `idx_old_address` (`old_address`),
			KEY `idx_new_address` (`new_address`),
			KEY `idx_address_detail` (`address_detail`),
			KEY `idx_apply_field` (`apply_field`),
			KEY `idx_account_bank` (`account_bank`),
			KEY `idx_account_number` (`account_number`),
			KEY `idx_account_name` (`account_name`),
			KEY `idx_is_have_career` (`is_have_career`),
			KEY `idx_translation_direction` (`translation_direction`),
			KEY `idx_is_employed` (`is_employed`),
			KEY `idx_file_group_id` (`file_group_id`),
			KEY `idx_can_working_day` (`can_working_day`),
			KEY `idx_admin_score` (`admin_score`),
			KEY `idx_num_translation_per_day` (`num_translation_per_day`),
			KEY `idx_graduate_school_major` (`graduate_school_major`),
			KEY `idx_university` (`university`),
			KEY `idx_graduate_school` (`graduate_school`),
	-- CONSTRAINT `fkBoardContent_board_key` FOREIGN KEY (`board_key`) REFERENCES board(`key`)
	-- ON UPDATE CASCADE
	-- ON DELETE CASCADE
	-- ,
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
		$table = "setting";
		$fieldName = "freelancer_admin_confirm_mail_subject";
		$addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` varchar(255) DEFAULT '' AFTER `id`;";
		$this->_addField($fieldName,$addFieldQuery,$table);

		$fieldName = "freelancer_admin_confirm_mail_content";
		$addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` text AFTER `id`;";
		$this->_addField($fieldName,$addFieldQuery,$table);

		$fieldName = "translation_languages";
		$addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` text AFTER `id`;";
		$this->_addField($fieldName,$addFieldQuery,$table);

		$this->load->model("setting_m");
		$this->db->set("translation_languages","영어,일어,중국어,불어,스페인,독어,러시아어,기타");
		$this->setting_m->p_update(1);

		// $fieldName = "test";
		// $addFieldQuery = "ALTER TABLE `{$this->table}` ADD `{$fieldName}` INT UNSIGNED NOT NULL AFTER `created`, ADD INDEX `idx_{$fieldName}` (`{$fieldName}`);";
		// $this->_addField($fieldName,$addFieldQuery);

		// $fieldName = "kind";
		// $alterFiledQuery="ALTER TABLE `{$this->table}` CHANGE `{$fieldName}` `{$fieldName}` ENUM('developer','admin','general') DEFAULT 'general';";
		// $this->_alterField($fieldName,$alterFiledQuery);
		
	}
}