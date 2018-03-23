
<?php
//
defined('BASEPATH') OR exit('No direct script access allowed');
//의존성 :: product_id,board_m, user_m
class Content_M extends Pagination_Model 
{

	protected $numRows_moduleName = "board";
	protected $numRows_foreignKey = "board_key";
	private $defaultImage = "/public/images/no_thumnail.png";
	public function __construct()
	{
		$this->table = "board_content";
		$this->as = "b_c";
		parent::__construct();
		$this->load->model('file/file_m');
		$this->load->library('post_helper');
	}

	
	//------commponent 정의
	

	protected function _component_addUpdate()
	{
		return array(
		
			array("inputName"=>"title","displayName"=>"제목"),
			array("method"=>"summernote","inputName"=>"desc","displayName"=>"내용"),
		);
	}
	protected function _component_add()
	{
		return array(
			array("updateDefault"=>"name","method"=>"inputSearch","table"=>"board","searchField"=>["name","key"],"searchFieldDisplayName"=>["게시판이름","게시판키"],"displayName"=>"게시판검색","inputName"=>"board_key","inputValue"=>"key"),
		);
	}
	// protected function _component_update()
	// {

	// }
	//------@CRUD 추가,업데이트 할 정보 정의
	

	protected function _add_base()
	{
		$this->addFileAnd_SetFileGroupId();
		$this->set_addUpdate_base();
		$this->set("user_id",$this->user->id);
		$this->set("board_key",get("board_key"));
		
		$this->set("image",$this->post_helper->extractFirstImageTagOnDescription(post("desc"),$this->defaultImage));
		///손님일때 추가 데이터
		$this->setGuestInfo();
		$this->set("is_secret",$this->setContent_isSecret());
		$insert_id= $this->p_add();

		//손님일떄 flashdata true유지하기
        if($this->userstate->isGuest())
        {
            $this->session->set_flashdata("content_guest_password/$insert_id", true);
		}
		
		return $insert_id;
	}

	protected function _update_base($id)
	{
		$row = $this->p_get($id);
		$this->addFileAnd_SetFileGroupId($row);
		$this->set("image",$this->post_helper->extractFirstImageTagOnDescription(post("desc"),$this->defaultImage));
		$this->set_addUpdate_base();
		return $this->p_update($id);
	}
	protected function _add_admin()
	{
		$this->set("image",$this->post_helper->extractFirstImageTagOnDescription(post("desc"),$this->defaultImage));
		$this->_setQueryUserIdOrLoginUserId();
		return parent::_add_admin();
	}
	protected function _update_admin($id)
	{
		$this->set("image",$this->post_helper->extractFirstImageTagOnDescription(post("desc"),$this->defaultImage));
		$this->_setQueryUserIdOrLoginUserId();
		return parent::_update_admin($id);
	}
	private function _setQueryUserIdOrLoginUserId()
	{
		if($this->input->post("user_id") === null)
		$this->set("user_id",$this->user->id);
	}
	////
	private function addFileAnd_SetFileGroupId($row=null)
	{
		$config["is_secret"] = $this->setContent_isSecret();
		$config["download_auth"]  =$this->CI->content_r_auth ;
		$config["download_auth_kind"] = $this->CI->content_r_auth_kind ;
		if($this->methodName ==="update"&& isset($row))
		{
			$guest_name = $row->guest_name;
			$guest_password = $row->guest_password;
		}
		else
		{
			$guest_name= post("guest_name");
			$guest_password = $this->getGuestPassword() ;
		}

		$config["guest_name"] = $guest_name;
		$config["guest_password"] = $guest_password;

		if($row === null)
		{
			$file_groupId=$this->file_m->add("user",true,$config);
			if($file_groupId !== null)
			{
				$this->set("file_group_id",$file_groupId);
			}
		}
		else if($row->file_group_id === null)
		{
			$file_groupId=$this->file_m->add("user",true,$config);
			if($file_groupId !== null)
			{
				$this->set("file_group_id",$file_groupId);
			}
		}
		else
		{
			$file_groupId=$this->file_m->add("user",$row->file_group_id,$config);
		}
	}

	
	private function set_addUpdate_base()
	{
		$this->set("title",post("title"));
		$this->set("desc",post("desc",false));
	}
	private function setGuestInfo()
	{
		if($this->userstate->isGuest() === true)
		{
			$this->set("is_guest","1");
			$this->set("guest_name",post("guest_name"));
			$this->set("guest_password",$this->getGuestPassword());
		}
		else
		{
			$this->set("is_guest","0");
		}
	}
	private function getGuestPassword()
	{
		if($this->userstate->isGuest() === true)
		{
			return $hash =password_hash(post('guest_password'),PASSWORD_BCRYPT);
		}
		else
		{
			return null;
		}
	}
	private function setContent_isSecret()
	{
		if($this->CI->board->content_is_secret === "1")
		{
			$is_secret = "1";
		}
		else
		{	
			$is_secret = post("is_secret") ?? '0';
		}
		return $is_secret;
	
	}
	

	
	//------ addUpdate 유효성 검사

	protected function _set_rules_addUpdate()
	{
		$this->form_validation->set_rules('title', '제목', 'trim|required');
		$this->form_validation->set_rules('desc', '내용', 'trim|required');
		$this->file_m->set_rules("file");
	}
	
	protected function _set_rules_add_admin()
	{
		$this->form_validation->set_rules('board_key', '게시판종류', 'trim|required');
	}
	
	protected function _set_rules_add_base()
	{
		 ///손님일때 추가 유효성 검사
		 if($this->userstate->isGuest() === true)
		 {
			 $this->form_validation->set_rules('guest_name', '아이디', 'trim|required|min_length[1]|max_length[30]|regex_match[/^[ㄱ-ㅎ|가-힣|a-z|A-Z|0-9|\*]+$/]',array("regex_match"=>"%s는 한글,영어,숫자만 허용합니다."));
			 $this->form_validation->set_rules('guest_password', '비밀번호', 'trim|required|min_length[4]|max_length[100]');
		 }
 
	}


	//------ List Get 정의

	protected function _select()
	{
		$this->db->select("
		{$this->as}.*,
		$this->displayName,
		DATE_FORMAT({$this->as}.created,IF(DATE({$this->as}.created) = CURDATE(),'%p %h:%i','%Y-%m-%d')) as created,
		u.profile_image
		",true);
	}
	protected function _select_api()
	{
		$this->db->select("
		{$this->as}.id,
		{$this->as}.title,
		u.displayName,
		{$this->as}.created,
		{$this->as}.sort,
		");
	}
	protected function _from()
	{
		$this->db->from("$this->table as {$this->as}");
		$this->db->join("user as u","b_c.user_id = u.id","LEFT");
		$this->db->join("board as b","b_c.board_key = b.key","LEFT");
	}
	protected function _get_admin()
	{
	}
	protected function _get_base()
	{
		$this->db->select("{$this->as}.desc");
		$this->db->where("b.is_display","1");	
	}
	protected function _list_admin()
	{
	}
	protected function _list_base()
	{
		// $this->db->select("IF(
		// 	LENGTH({$this->as}.desc) > 120,
		// 	CONCAT(LEFT({$this->as}.desc,120),'...'),
		// 	{$this->as}.desc
		// 	) as substr_desc");
		if(($board_key = $this->input->get('board_key')) !== null) //게시판 key값으로
		{
			$this->db->where("b_c.board_key",$board_key);
		}
		if($this->userstate->contentIsMe($this->CI->content_is_me) ===true) //자기만 볼수있는 게시판인지 체크
		{
			$this->db->where("b_c.user_id",$this->user->id);
		}
		$this->db->where("b.is_display","1");	
	}

	public function listPagination($where=null,$inConfig=array())
	{
		$config["is_numrow"] = true;
		$config["get_count_field"] = isset($this->CI->num_content) ? $this->CI->num_content : null;
		return parent::listPagination(null,$config);
	}


	//getlist 필드네임 정의
	//admin
	public function listData_admin()
	{
		return array_merge(array(
			array("displayName"=>"ID","fieldName"=>"id"),
			array("displayName"=>"제목","fieldName"=>"title"),
			array("displayName"=>"글쓴이","fieldName"=>"displayName"),
		),
		parent::listData_admin());
	}
	public function getData_admin()
	{
		return array(
			array("displayName"=>"ID","fieldName"=>"id"),
			array("displayName"=>"제목","fieldName"=>"title"),
			array("displayName"=>"내용","fieldName"=>"desc"),
			array("displayName"=>"글쓴이","fieldName"=>"displayName"),
		);
	}
	//base
	public function listData_base()
	{
		return array(
			array("displayName"=>"순서","fieldName"=>"num_row"),
			// array("displayName"=>"ID","fieldName"=>"id"),
			array("displayName"=>"제목","fieldName"=>"title"),
			array("displayName"=>"리플수","fieldName"=>"num_reply"),
			array("displayName"=>"글쓴이","fieldName"=>"displayName"),
			array("displayName"=>"조회수","fieldName"=>"hits"),
			array("displayName"=>"생성일","fieldName"=>"created"),
		);
	}
	public function getData_base()
	{
		return array(
			array("displayName"=>"ID","fieldName"=>"id"),
			array("displayName"=>"제목","fieldName"=>"title"),
			array("displayName"=>"내용","fieldName"=>"desc"),
			array("displayName"=>"글쓴이","fieldName"=>"displayName"),
		);
	}
	



	//------검색
	protected function _searchData()
    {
        return array(
			"title"=>array("displayName"=>"제목","fieldName"=>"b_c.title"),
			"desc"=>array("displayName"=>"내용","fieldName"=>"desc","kind"=>"or_textfull"),
			"titleDesc"=>array("displayName"=>"제목+내용","fieldName"=>["b_c.title","desc"],"kind"=>["or_like","or_textfull"]),
			"displayName"=>array("displayName"=>"글쓴이","fieldName"=>"u.displayName"),
			"created"=>array("displayName"=>"작성시간","fieldName"=>"b_c.created"),
		);
	}
	
	//------ 정렬 할 필드들을 정의합니다.
	protected function _orderByData()
    {
        return array(
			"newset"=>array("displayName"=>"최근순","fieldName"=>"{$this->as}.id","sort"=>"desc"),
			"lastest"=>array("displayName"=>"등록순","fieldName"=>"{$this->as}.id","sort"=>"asc"),
        );
    }

	//---- 어드민 페이지의 세팅을 정의합니다.
	protected function _settingData_admin()
	{
		return array();
	}

	//------다음 테이블을 만듭니다.
	public function createTable ()
	{
		$createTableQuery = "CREATE TABLE `{$this->table}`(
	      `id` INT UNSIGNED NULL AUTO_INCREMENT, 
		  `board_key` varchar(255) NOT NULL,
		  `user_id` INT UNSIGNED DEFAULT NULL, 
		  `file_group_id` INT UNSIGNED, 
		  `guest_name` varchar(255),
		  `guest_password` varchar(255),
		  `title` varchar(255) NOT NULL, 
		  `desc` TEXT NOT NULL,
		  `tag` varchar(255) DEFAULT '',
		  `num_reply` INT UNSIGNED  NOT NULL DEFAULT '0',
		  `hits` int UNSIGNED NOT NULL DEFAULT '0', 
		  `is_guest` boolean NOT NULL DEFAULT '0',
		  `is_secret` boolean NOT NULL DEFAULT '0',
		  `is_display` boolean NOT NULL DEFAULT '1',
		  `sort` INT NOT NULL DEFAULT '0',
		  `created` datetime NOT NULL DEFAULT NOW(),
			-- UNIQUE KEY `uniqueIdx_#` (`#`),
			-- KEY `idx_@` (`@`),
			CONSTRAINT `fkBoardContent_board_key` FOREIGN KEY (`board_key`) REFERENCES board(`key`)
        	ON UPDATE CASCADE
			ON DELETE CASCADE
			,
			CONSTRAINT `fkBoardContent_user_id` FOREIGN KEY (`user_id`) REFERENCES user(`id`)
        	ON UPDATE CASCADE
			ON DELETE CASCADE
			,
			KEY `idx_board_key` (`board_key`),
			KEY `idx_user_id` (`user_id`),
			KEY `idx_file_group_id` (`file_group_id`),
			KEY `idx_guest_name` (`guest_name`),
			KEY `idx_title` (`title`),
			FULLTEXT KEY `idx_desc` (`desc`),
			KEY `idx_tag` (`tag`),
			KEY `idx_num_reply` (`num_reply`),
			KEY `idx_hits` (`hits`),
			KEY `idx_is_guest` (`is_guest`),
			KEY `idx_is_display` (`is_display`),
			KEY `idx_is_secret` (`is_secret`),
			KEY `idx_sort` (`sort`),
			KEY `idx_created` (`created`),
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$this->_createTable($createTableQuery);
	}
	public function alertTable()
	{
		$fieldName = "image";
		$addFieldQuery = "ALTER TABLE `{$this->table}` ADD `{$fieldName}` varchar(255) NOT NULL DEFAULT '{$this->defaultImage}' AFTER `desc`, ADD INDEX `idx_{$fieldName}` (`{$fieldName}`);";
		$this->_addField($fieldName,$addFieldQuery);
		
	}
}