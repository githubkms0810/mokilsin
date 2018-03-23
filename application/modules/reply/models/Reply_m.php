
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//의존성 ::
class reply_M extends Pagination_Model 
{

	protected $numRows_moduleName = "content";
	public function __construct()
	{
		$this->table = "board_content_reply";
		$this->as = "b_c_r";
		parent::__construct();
	}
	//------추가,업데이트 할 정보 정의
	// protected function _add_admin()
	// {
	// }

	// protected function _update_admin($id)
	// {
	// }

	protected function _add_base()
	{
		$this->_set_addUpdate_base();
		return $this->p_add();
	}

	protected function _update_base($id)
	{
		$this->_set_addUpdate_base();
		$this->p_update($id);
	}



	private function _set_addUpdate_base()
	{
		$this->db->set("board_id",$this->CI->board_id);
		$this->db->set("desc",post('desc')); //input
		$this->db->set("content_id",post('content_id')); //input
		$this->db->set("parent_id",post('parent_id')); //input
		$this->db->set("user_id",$this->user->id);
		
		if($this->userstate->isGuest()===true)
		{
			$this->db->set("guest_name",post('guest_name'));
			$hash =password_hash(post('guest_password'),PASSWORD_BCRYPT);
			$this->db->set("guest_password",$hash);
		}
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
	// //base
	// protected function _set_rules_addUpdate_base()
	// {

	// }
	protected function _set_rules_add_base()
	{
		$this->form_validation->set_rules('desc', '내용', 'trim|required|min_length[1]|max_length[500]');
		 ///손님일때 추가 유효성 검사
		 if($this->userstate->isGuest() === true)
		 {
			 $this->form_validation->set_rules('guest_name', '아이디', 'trim|required|min_length[1]|max_length[30]|regex_match[/^[ㄱ-ㅎ|가-힣|a-z|A-Z|0-9|\*]+$/]',array("regex_match"=>"%s는 한글,영어,숫자만 허용합니다."));
			 $this->form_validation->set_rules('guest_password', '비밀번호', 'trim|required|min_length[4]|max_length[100]');
		 }
	}
	// protected function _set_rules_update_base()
	// {

	// }
	
	
	//------custom
	//재귀
	public function list_ByContentId_OnRecursion($content_id, $parent_id =0, $deep =-1) 
	{
		$data =array();
		$deep++;
		$this->db->select("$deep 'deep'");
		$this->db->where("b_c_r.content_id",$content_id);
		$this->db->where("b_c_r.parent_id",$parent_id);
		$this->db->order_by("id","asc");
		$rows=$this->list();
		foreach ($rows as $row) {
			$data[] = $row;
			$data = array_merge($data,$this->list_ByContentId_OnRecursion($row->content_id,$row->id,$deep));
		}
		return $data;
	}

	//------ List Get 정의

	protected function _select()
	{
		$this->db->select("
		b_c_r.*, 
		b.name 'board_name',
		b_c.title 'content_title', 
		u.userName,
		$this->displayName,
		u.profile_image,
		");
	}
	protected function _from()
	{
		$this->db->from("$this->table as {$this->as}");
		$this->db->join("user as u","{$this->as}.user_id = u.id","LEFT");
		$this->db->join("board as b","{$this->as}.board_id = b.id","LEFT");
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
		$this->where("b_c_r.parent_id !=",null);
	}
	protected function _list_base()
	{
		
		$this->where("b_c_r.is_display","1");
	}
	
	//getlist 필드네임 정의
	//admin
	public function listData_admin()
	{
		return array_merge(array(
			array("displayName"=>"ID","fieldName"=>"id"),
			array("displayName"=>"내용","fieldName"=>"desc"),
			array("displayName"=>"글쓴이","fieldName"=>"userName"),
			array("displayName"=>"게시판","fieldName"=>"board_name"),
			array("displayName"=>"게시물","fieldName"=>"content_title"),
		),
		parent::listData_admin()
		);
	}
	public function getData_admin()
	{
		return array(
			array("displayName"=>"ID","fieldName"=>"id"),
			array("displayName"=>"내용","fieldName"=>"desc"),
			array("displayName"=>"글쓴이","fieldName"=>"userName"),
			array("displayName"=>"게시판","fieldName"=>"board_name"),
			array("displayName"=>"게시물","fieldName"=>"content_title"),
		);
	}
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
	// public function _orderByData()
	// {
	// 	return array(
	// 		array("displayName"=>"최근순","fieldName"=>"id","sort"=>"desc"),
	// 		array("displayName"=>"등록순","fieldName"=>"id","sort"=>"asc"),
	// 	);
	// }

	//------ 어드민 페이지의 세팅을 정의합니다.

	protected function _settingData_admin()
	{
		return array();
	}



	// ------다음 테이블을 만듭니다.
	public function createTable ()
	{
		
		$createTableQuery = "CREATE TABLE `{$this->table}`(
			`id` INT UNSIGNED NULL AUTO_INCREMENT, 
			`board_id` INT UNSIGNED , 
			`parent_id` INT UNSIGNED DEFAULT '0',
			`content_id` INT UNSIGNED ,
			`user_id` INT UNSIGNED DEFAULT NULL , 
			`guest_name` varchar(50) DEFAULT 'NULL',
			`guest_password` varchar(255) DEFAULT 'NULL',
			`desc` varchar(255) NOT NULL,
			`is_secret` boolean NOT NULL DEFAULT '0', 
			`is_display` boolean NOT NULL DEFAULT '1', 
			`num_good` INT UNSIGNED DEFAULT '0', 
			`num_hate` INT UNSIGNED DEFAULT '0', 
			`sort` INT NOT NULL DEFAULT '0',
			`created` datetime NOT NULL DEFAULT NOW(),
			-- UNIQUE KEY `uniqueIdx_#` (`#`),
			-- KEY `idx_@` (`@`),
			CONSTRAINT `fkboardContentReply_board_id` FOREIGN KEY (`board_id`) REFERENCES board(`id`)
        	ON UPDATE CASCADE
			ON DELETE CASCADE
			,
			CONSTRAINT `fkboardContentReply_parent_id` FOREIGN KEY (`parent_id`) REFERENCES board_content_reply(`id`)
        	ON UPDATE CASCADE
			ON DELETE CASCADE
			,
			CONSTRAINT `fkboardContentReply_content_id` FOREIGN KEY (`content_id`) REFERENCES board_content(`id`)
        	ON UPDATE CASCADE
			ON DELETE CASCADE
			,
			CONSTRAINT `fkboardContentReply_user_id` FOREIGN KEY (`user_id`) REFERENCES user(`id`)
        	ON UPDATE CASCADE
			ON DELETE CASCADE
			,
			KEY `idx_board_id` (`board_id`),
			KEY `idx_parent_id` (`parent_id`),
			KEY `idx_content_id` (`content_id`),
			KEY `idx_user_id` (`user_id`),
			KEY `idx_guest_name` (`guest_name`),
			FULLTEXT KEY `idx_desc` (`desc`),
			KEY `idx_is_secret` (`is_secret`),
			KEY `idx_is_display` (`is_display`),
			KEY `idx_sort` (`sort`),
			KEY `idx_created` (`created`),
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$callback = function()
		{
			$this->set("id",0);
			$this->set("board_id",null);
			$this->set("parent_id",null);
			$this->set("content_id",null);
			$this->set("user_id",1);
			$insert_id=$this->db->insert($this->table);
			$this->set("id",0);
			$this->db->where("id",$insert_id);
			$this->db->update($this->table);

		};
		$this->_createTable($createTableQuery,$callback);
	}
	// public function alertTable()
	// {
	// 	$fieldName = "test";
	// 	$addFieldQuery = "ALTER TABLE `{$this->table}` ADD `{$fieldName}` INT NOT NULL AFTER `created`, ADD INDEX `idx_{$fieldName}` (`{$fieldName}`);";
	// 	$this->_addField($fieldName,$addFieldQuery);
		
	// }
}