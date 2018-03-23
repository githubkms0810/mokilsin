
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Board_M extends Pagination_Model 
{

	public function __construct()
	{
		parent::__construct();
		$this->table = "board";
		$this->as = "b";
	}
 
	
	//------추가,업데이트 할 정보 정의

	//------commponent 정의

	protected function _component_addUpdate()
	{
		return array(
			array("displayName"=>"게시판명","inputName"=>"name"),
			array("displayName"=>"게시판 키값","inputName"=>"key"),
			array("displayName"=>"종류","inputName"=>"kind",'type'=>"text","default"=>"default"),
			array("displayName"=>"순서","inputName"=>"sort",'type'=>"number","default"=>"0"),
			array("displayName"=>"자기글만 보이기","inputName"=>"content_is_me",'type'=>"text","default"=>"0"),
			array("displayName"=>"비밀글 기본값","inputName"=>"content_is_secret",'type'=>"text","default"=>"0"),
			array("displayName"=>"게시판 읽기 유저종류","inputName"=>"board_r_auth_kind","default"=>"all"),
			array("displayName"=>"게시판 읽기 유저레벨","inputName"=>"board_r_auth",'type'=>"number","default"=>"0"),
			array("displayName"=>"게시물 읽기 유저종류","inputName"=>"content_r_auth_kind","default"=>"all"),
			array("displayName"=>"게시물 읽기 유저레벨","inputName"=>"content_r_auth",'type'=>"number","default"=>"0"),
			array("displayName"=>"게시물 쓰기 유저종류","inputName"=>"content_w_auth_kind","default"=>"all"),
			array("displayName"=>"게시물 쓰기 유저레벨","inputName"=>"content_w_auth",'type'=>"number","default"=>"1"),
			array("displayName"=>"댓글 쓰기 유저종류","inputName"=>"reply_w_auth_kind","default"=>"all"),
			array("displayName"=>"댓글 쓰기 유저레벨","inputName"=>"reply_w_auth",'type'=>"number","default"=>"1"),
		
		);
	}

		
	//------ addUpdate 유효성 검사
	protected function _set_rules_addUpdate_admin()
	{
		$this->form_validation->set_rules('name', '게시판명', 'trim|required');
		$this->form_validation->set_rules('key', '게시판 키', 'trim|required|alpha_numeric');
	}

	//@custom


	//------ List Get 정의

	protected function _select()
	{
		$this->db->select("b.*");
	}
	protected function _from()
	{
		$this->db->from("$this->table as {$this->as}");
		// $this->db->join("user as u","{$this->as}.user_id = u.id","LEFT");
	}
	protected function _list_admin()
	{

	}
	protected function _list_base()
	{

	}
	
	//getlist 필드네임 정의
	public function getData_admin()
	{
		return array(
			array("displayName"=>"ID","fieldName"=>"id"),
			array("displayName"=>"게시판명","fieldName"=>"name"),
			array("displayName"=>"자기 글만보이기","fieldName"=>"content_is_me"),
			array("displayName"=>"기본비밀글","fieldName"=>"content_is_secret"),
			array("displayName"=>"종류","fieldName"=>"kind"),
			array("displayName"=>"게시판 읽기 유저종류","fieldName"=>"board_r_auth_kind"),
			array("displayName"=>"게시판 읽기 유저레벨","fieldName"=>"board_r_auth"),
			array("displayName"=>"게시물 읽기 유저종류","fieldName"=>"content_r_auth_kind"),
			array("displayName"=>"게시물 읽기 유저레벨","fieldName"=>"content_r_auth"),
			array("displayName"=>"게시물 쓰기 유저종류","fieldName"=>"content_w_auth_kind"),
			array("displayName"=>"게시물 쓰기 유저레벨","fieldName"=>"content_w_auth"),
			array("displayName"=>"댓글 쓰기 유저종류","fieldName"=>"reply_w_auth_kind"),
			array("displayName"=>"댓글 쓰기 유저레벨","fieldName"=>"reply_w_auth"),
			array("displayName"=>"생성일","fieldName"=>"created"),
		);
	}
	public function listData_admin()
	{
		return array_merge(array(
			array("displayName"=>"ID","fieldName"=>"id"),
			array("displayName"=>"key","fieldName"=>"key"),
			array("displayName"=>"게시판명","fieldName"=>"name"),
			array("displayName"=>"종류","fieldName"=>"kind"),
			array("displayName"=>"생성일","fieldName"=>"created"),
		),
		parent::listData_admin());
	}
	public function getData_base()
	{

	}
	public function listData_base()
	{
		
	}
	//다음 테이블을 만듭니다.
    public function createTable ()
    {
		$createTableQuery = "CREATE TABLE `{$this->table}`(
               `id` INT UNSIGNED NULL AUTO_INCREMENT, 
               `key` varchar(255) NOT NULL, 
			   `name` varchar(255) NOT NULL,
			   `board_r_auth_kind` varchar(255) NOT NULL DEFAULT 'all',
			   `board_r_auth` INT NOT NULL DEFAULT '0', 
			   `content_r_auth_kind` varchar(255) NOT NULL DEFAULT 'all',
			   `content_r_auth` INT NOT NULL DEFAULT '0',
			   `content_w_auth_kind` varchar(255) NOT NULL DEFAULT 'all',
			   `content_w_auth` INT NOT NULL DEFAULT '1', 
			   `reply_w_auth_kind` varchar(255) NOT NULL DEFAULT 'all',
			   `reply_w_auth` INT NOT NULL DEFAULT '1',
			   `num_content` INT UNSIGNED NOT NULL DEFAULT '0', 
			   `kind` varchar(255) NOT NULL DEFAULT 'default', 
			   `content_is_secret` boolean NOT NULL DEFAULT '0',
			   `content_is_me` boolean NOT NULL DEFAULT '0',
			   `is_display` boolean NOT NULL DEFAULT '1',
				`is_secret` boolean NOT NULL DEFAULT '0',
				`sort` INT NOT NULL DEFAULT '0',
			   `created` datetime NOT NULL DEFAULT NOW(),
                UNIQUE KEY `uniqueIdx_key` (`key`),
				KEY `idx_name` (`name`),
				KEY `idx_num_content`(`num_content`),
				KEY `idx_is_display` (`is_display`),
				KEY `idx_is_secret` (`is_secret`),
				KEY `idx_sort` (`sort`),
                KEY `idx_created` (`created`),
                PRIMARY KEY (`id`)
                 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$callback = function()
		{
			//공지사항
			$this->set("key","notice");
			$this->set("name","공지사항");
			$this->set("kind","style1");
			$this->set("content_w_auth_kind","admin");
			$this->p_add();

			//faq
			$this->set("key","faq");
			$this->set("name","FAQ");
			$this->set("kind","style1");
			$this->set("content_w_auth_kind","admin");
			$this->set("reply_w_auth_kind","admin");
			$this->p_add();

			//1:1
			$this->set("key","contact");
			$this->set("name","1:1문의");
			$this->set("kind","style1");
			$this->set("content_w_auth_kind","all"); //모두다
			$this->set("content_w_auth","0"); //손님도 글쓸수있게
			$this->set("reply_w_auth_kind","all"); //모두다
			$this->set("reply_w_auth","0"); //손님도 댓글달수있게
			// $this->set("content_is_me","1"); //list시 자기글만 보이게
			$this->set("content_is_secret","1"); //글추가시 무조건 비밀글로(다른사람은 못보고 댓글도 못담)
			$this->p_add();
			//자유
			$this->set("key","free");
			$this->set("name","자유게시판");
			$this->set("kind","style1");
			$this->set("content_w_auth","0");
			$this->set("reply_w_auth","0");
			$this->p_add();

		};
        $this->_createTable($createTableQuery,$callback);
	}


  
	
	
}