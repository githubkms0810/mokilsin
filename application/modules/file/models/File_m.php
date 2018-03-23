
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//의존성 ::
class File_M extends Pagination_Model 
{
	

	public function __construct()
	{
		$this->table = "file";
		$this->as = "s";
		parent::__construct();

	
	}
	//------추가,업데이트 할 정보 정의
	//admin
	protected function _addUpdateData_admin()
	{
		return array(
			// array("method"=>"inputByRows","rowsName"=>"users","type"=>"radio","inputName"=>"user_id","values"=>"id","texts"=>"name,userName","search"=>true,"searchText"=>"유저 검색"),
			// array("method"=>"inputByRows","rowsName"=>"products","type"=>"radio","inputName"=>"product_id","values"=>"id","texts"=>"name,key","search"=>true,"searchText"=>"상품 검색"),
			// array("method"=>"input","type"=>"radio","inputName"=>"kind","default"=>"fixed","values"=>"정액제,무제한,정지,무료","texts"=>"정액제,무제한,정지,무료"),
			
		);
	}
	protected function _addData_admin()
	{
		return array(
			// array("fieldName"=>"start_date","callback"=>function(){
			// 	return Date("Y-m-d H:i:s");
			// }),
			// array("method"=>"input","type"=>"text","inputName"=>"day","default"=>"3","texts"=>"일","fieldName"=>"end_date","callback"=>function(){
			// 	return my_date("Y-m-d H:i:s","+{$this->input->post('day')} day");
			// }),
		);
	}
	protected function _updateData_admin()
	{
		return array(
		);
	}
	//base
	protected function _addUpdateData_base()
	{
		return array(
			
		);
	}
	protected function _addData_base()
	{
		return function()
		{

			
		};
	}
	protected function _updateData_base()
	{
		return array(
			
		);
	}
	
	

	//------ addUpdate 유효성 검사
	//admin
	// protected function _set_rules_addUpdate_admin()
	// {

	// }
	// protected function _set_rules_add_admin()
	// {

	// }
	// protected function _set_rules_update_admin()
	// {

	// }
	//base
	protected function _set_rules_addUpdate_base()
	{

	}
	protected function _set_rules_add_base()
	{

	}
	protected function _set_rules_update_base()
	{

	}
	//---custom
	public function list_ByGroupId($group_id)
	{
		return $this->p_list(array("group_id"=>$group_id,"is_display"=>"1"));
	}

	//------ List Get 정의

	protected function _select()
	{
		$this->db->select("
		{$this->as}.*,
		{$this->displayName},
		");
	}
	protected function _from()
	{
		$this->db->from("$this->table as {$this->as}");
		$this->db->join("user as u","{$this->as}.user_id = u.id","LEFT");
	}
	protected function _list_admin()
	{
		// $this->db->where("name","value");
	}
	protected function _list_base()
	{
		// $this->db->where("name","value");
	}
	
	//getlist 필드네임 정의
	//admin
	public function listData_admin()
	{
		return array(
			array("displayName"=>"ID","fieldName"=>"id"),
			array("displayName"=>"파일이름","fieldName"=>"original_name"),
			array("displayName"=>"임시파일이름","fieldName"=>"tmp_name"),
			array("displayName"=>"유저","fieldName"=>"displayName"),
			array("displayName"=>"다운로드수","fieldName"=>"num_download_log"),
		);
	}
	// public function getData_admin()
	// {
	// 	return array(
	// 		array("displayName"=>"ID","fieldName"=>"p.id"),
	// 		array("displayName"=>"버전","fieldName"=>"p.version"),
	// 	);
	// }
	//base
	public function listData_base()
	{
		return array(
		);
	}
	public function getData_base()
	{
		return array(
		);
	}

	//------ pgi
	// public function listPagination($where=null,$config=array())
	// {
	// 	$config["per_page"] =3;
	// 	return parent::listPaginaion($where,$config);
	// }

	//----@custom

	//@param $kind :: is user or admin folder
	public function add($kind="user",$next_group_id =true,$config =array()) 
	{
		$data =$this->upload->multiUpload("file",$kind);
		if($data["result"] !== "success")  // fail or non
		{
			return null;
		}
		if($next_group_id === true)
		{
			$this->load->model('group_m');
			$group_pk_infos=$this->group_m->p_get(1);
			$group_id = $group_pk_infos->file;
			$this->group_m->plusKey("file");
		}
		else
		{
			$group_id = $next_group_id;
		}

		$is_display = $config["is_display"]  ?? "1";
		$is_secret = $config["is_secret"]  ?? "0";
		$download_auth = $config["download_auth"]  ?? "0";
		$download_auth_kind = $config["download_auth_kind"]  ?? "all";
		$guest_name = $config["guest_name"]  ?? null;
		$guest_password = $config["guest_password"]  ?? null;
		$insert_data = array();
		foreach ($data["files"] as $key => $file) {
			$strIdx = strrpos($file["original_name"],".",0)+1;
			$extention = substr($file["original_name"],$strIdx,strlen($file["original_name"]) - $strIdx+1);

			$insert_data[] = array(
				"group_id" => $group_id,
				"user_id" => $this->user->id,
				"original_name"=>$file["original_name"],
				"tmp_name"=>$file["tmp_name"],
				"directory"=>$file["uri"],
				"size"=>$file["size"],
				"extention"=>$extention,
				"guest_name"=>$guest_name,
				"guest_password"=>$guest_password,
				"is_display"=>$is_display,
				"is_secret"=>$is_secret,
				"download_auth"=>$download_auth,
				"download_auth_kind"=>$download_auth_kind,
			);
		}
		$this->db->insert_batch($this->table, $insert_data); 
		return $group_id;
	}
	public function set_rules($kind = "file")
	{
		$data=$this->upload->validation("file");
		// var_dump($data);
        if($data["result"] === "fail")
        {
			$this->form_validation->set_rules('null', 'null', 'required',array('required'=>$data['errors']));
            // $this->form_validation->set_message('업로드 파일 :',$data['errors']);
        }
	}

	
	//------검색을 허용할 필드들을 정의합니다
	public function _searchData_admin()
	{
		return array(
			// array("displayName"=>"상품명","fieldName"=>"p.name"),
			// array("displayName"=>"상품설명","fieldName"=>"p.desc"),
			// array("fieldName"=>"p.key"),
			// array("displayName"=>"상품명+상품설명","fieldName"=>"p.name,p.desc"),
		);
	}

	//------ 정렬 할 필드들을 정의합니다.
	public function _orderByData()
	{
		return array(
			// array("displayName"=>"아이디순","fieldName"=>"p.id","sort"=>"asc"),
			// array("displayName"=>"상품설명","fieldName"=>"p.desc","sort"=>"asc"),
		);
	}

	//------ 어드민 페이지의 세팅을 정의합니다.

	protected function _settingData_admin()
	{
		return array();
	}


	//------다음 테이블을 만듭니다.
	public function createTable ()
	{
		$createTableQuery = "CREATE TABLE `{$this->table}`(
			`id` INT UNSIGNED NULL AUTO_INCREMENT, 
		   	`group_id` varchar(255) NOT NULL,
		   	`user_id` int UNSIGNED DEFAULT NULL,
		   	`original_name` varchar(255) NOT NULL,
		   	`tmp_name` varchar(255) NOT NULL,
		   	`directory` text NOT NULL,
		   	`size` int UNSIGNED NOT NULL,
		   	`extention` varchar(255) NOT NULL,
			`guest_name` varchar(255),
		  	`guest_password` varchar(255),
		   	`is_display` boolean NOT NULL DEFAULT '1',
		   	`is_secret` boolean NOT NULL DEFAULT '0',
		   	`download_auth` int NOT NULL DEFAULT '0',
		   	`download_auth_kind` varchar(255) NOT NULL DEFAULT 'all',
			`sort` INT NOT NULL DEFAULT '0',
			`created` datetime NOT NULL DEFAULT NOW(),
			UNIQUE KEY `uniqueIdx_tmp_name` (`tmp_name`),
			-- UNIQUE KEY `uniqueIdx_#` (`#`),
			CONSTRAINT `fkFile_user_id` FOREIGN KEY (`user_id`) REFERENCES user(`id`)
        	ON UPDATE CASCADE
			ON DELETE CASCADE
			,
			KEY `idx_user_id` (`user_id`),
			KEY `idx_group_id` (`group_id`),
			KEY `idx_original_name` (`original_name`),
			KEY `idx_extention` (`extention`),
			KEY `idx_guest_name` (`guest_name`),
			KEY `idx_is_display` (`is_display`),
			KEY `idx_is_secret` (`is_secret`),
			KEY `idx_download_auth` (`download_auth`),
			KEY `idx_download_auth_kind` (`download_auth_kind`),
			-- KEY `idx_@` (`@`),
			KEY `idx_sort` (`sort`),
			KEY `idx_created` (`created`),
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$this->_createTable($createTableQuery);
	}
	public function alertTable()
	{
		$fieldName = "num_download_log";
		$addFieldQuery = "ALTER TABLE `{$this->table}` ADD `{$fieldName}` INT UNSIGNED NOT NULL AFTER `guest_password`, ADD INDEX `idx_{$fieldName}` (`{$fieldName}`);";
		$this->_addField($fieldName,$addFieldQuery);
		
	}
}