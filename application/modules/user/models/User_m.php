
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_M extends Pagination_Model {

	
	public function __construct()
	{
		$this->table = "user";
		$this->as = "u";
		parent::__construct();

	}
	//------commponent 정의
	protected function _component_addUpdate()
	{
		return array(
			// array("displayName"=>"아이디","inputName"=>"userName"),
			array("type"=>"number","inputName"=>"point","displayName"=>"포인트"),
			array("displayName"=>"비밀번호","inputName"=>"password","type"=>"password"),
			array("displayName"=>"비밀번호 재확인","inputName"=>"re_password","type"=>"password"),
			array("displayName"=>"별명","inputName"=>"displayName"),
			array("displayName"=>"이메일","inputName"=>"email"),
			array("displayName"=>"종류","inputName"=>"kind","default"=>"general"),
			array("displayName"=>"레벨","inputName"=>"auth","default"=>"1"),
			array("method"=>"ajaxImage","displayName"=>"프로필 사진","inputName"=>"profile_image", "default"=>"/public/images/unknown.png"),
			array("displayName"=>"이름","inputName"=>"name"),
			array("displayName"=>"소개","inputName"=>"intro"),
			array("displayName"=>"성별","inputName"=>"sex"),
			array("displayName"=>"생년월일","inputName"=>"birth"),
			array("displayName"=>"휴대폰번호","inputName"=>"phone"),
			array("displayName"=>"주소","inputName"=>"address"),
			array("displayName"=>"우편번호","inputName"=>"postal_number"),
			array("displayName"=>"추가주소","inputName"=>"more_address"),
			array("displayName"=>"sns타입","inputName"=>"sns_type"),
			array("displayName"=>"보이기","inputName"=>"is_display","default"=>"1"),
		);
	}

//------추가,업데이트 할 정보 정의

	protected function _add_admin()
	{
		$this->_set_allPost_inTableField(array('password','re_password'));
		$hash=password_hash(strtolower(post("password")), PASSWORD_BCRYPT);
		$this->set("password",$hash);
		return $this->p_add();
	}

	protected function _update_admin($id)
	{
		$this->_set_allPost_inTableField(array('password','re_password'));
		// $this->db->set("point",post("point"));
		if($this->input->post('password') !== "" && $this->input->post('re_password') !== "")//패스워드 입력시에만
        {
			$hash=password_hash(strtolower(post("password")), PASSWORD_BCRYPT);
			$this->set("password",$hash);
		}
		
		return $this->p_update($id);
	}
	
	private function _set_default()
	{
		$this->set_post("profile_image");
		$this->set_post("name"); 
	}
	protected function _add_base()
	{
		if($this->CI->setting->is_userName_in_add_user === "1")
			$this->set("userName",strtolower(post("userName")));
		$hash=password_hash(strtolower(post("password")), PASSWORD_BCRYPT);
		$this->set("password",$hash);
		$this->set_post("displayName");

		if($this->userstate->is_flashdataOauth() === true)
			$this->set("email", strtolower($this->session->flashdata('email')));
		else if($this->CI->setting->is_email_authentication_in_add_user === "1")
			$this->set("email", strtolower($this->session->flashdata('email')));

		if($this->CI->setting->is_phone_authentication_in_add_user === "1")
			$this->set("phone", $this->session->flashdata('phone'));
		//api 추가
		$this->set("api_key",$this->generate_apiKey());
		$this->set("point",100);
		$this->_set_default();
		$insert_id= $this->p_add();

		if($this->userstate->is_flashdataOauth() === true) //oauth 소설회원가입이라면 ouath에 user_id 업데이트
		{
			$this->db->set("user_id",$insert_id);
			$this->db->where('id', $this->userstate->get_flashdataOauth());
			$this->db->update("oauth");
		}
		//글쓰기 라이센스 추가(maketingBay)
		$this->load->model('product/product_m');
		$product =$this->product_m->p_get(["key"=>"naverCafeWriter"]);
		if($product !== null)
		{
			$this->load->model('license/license_m');
			$this->set('product_id', $product->id);
			$this->set('kind', "체험판");
			$this->set('user_id', $insert_id);
			$this->set("start_date",Date("Y-m-d H:i:s"));
			$this->set("end_date",my_date("Y-m-d H:i:s","+3 day"));
			$this->license_m->p_add();
		}
		//카페 가입기 라이센스 추가(maketingBay)
		$this->load->model('product/product_m');
		$product =$this->product_m->p_get(["key"=>"naverCafeRegister"]);
		if($product !== null)
		{
			$this->load->model('license/license_m');
			$this->set('product_id', $product->id);
			$this->set('kind', "체험판");
			$this->set('user_id', $insert_id);
			$this->set("start_date",Date("Y-m-d H:i:s"));
			$this->set("end_date",my_date("Y-m-d H:i:s","+3 day"));
			$this->license_m->p_add();
		}
	
		//카페 출석기 라이센스 추가(maketingBay)
		$this->load->model('product/product_m');
		$product =$this->product_m->p_get(["key"=>"naverCafeAttendance"]);
		if($product !== null)
		{
			$this->load->model('license/license_m');
			$this->set('product_id', $product->id);
			$this->set('kind', "체험판");
			$this->set('user_id', $insert_id);
			$this->set("start_date",Date("Y-m-d H:i:s"));
			$this->set("end_date",my_date("Y-m-d H:i:s","+3 day"));
			$this->license_m->p_add();
		}

		return $insert_id;
	}
	protected function _update_base($id)
	{
		if($this->input->post('password') !== "" && $this->input->post('re_password') !== "")//패스워드 입력시에만
        {
			$hash=password_hash(strtolower(post("password")), PASSWORD_BCRYPT);
			$this->set("password",$hash);
		}
		
		$this->_set_default();
		return $this->p_update($id);
	}

	
	//------ addUpdate @validation 유효성 검사
	
	protected function _set_rules_addUpdate()
	{
		$this->form_validation->set_rules('name', '이름', 'trim|min_length[1]|max_length[30]|regex_match[/^[ㄱ-ㅎ|가-힣|a-z|A-Z|\s|\*]+$/]',array("regex_match"=>"%s는 한글,영어만 허용합니다.")); //한글영어띄어쓰기
	}
	protected function _set_rules_add()
	{
		if($this->CI->setting->is_userName_in_add_user === "1")
			$this->set_rules_userName();
		$this->set_rules_password();
		$this->form_validation->set_rules('re_password', '비밀번호 확인', 'trim|required|min_length[4]|max_length[40]|matches[password]',array('matches'=>'비밀번호가 일치 하지 않습니다.'));
		if($this->CI->setting->is_phone_authentication_in_add_user === "1")
			$this->form_validation->set_rules("phone", "휴대폰", 'trim|numeric|is_unique[user.phone]', array('is_unique' => '%s는 이미 존재합니다.'));
		if($this->CI->setting->is_email_authentication_in_add_user === "1")
			$this->form_validation->set_rules("email", '이메일', 'trim|valid_email|is_unique[user.email]', array('is_unique' => '이미 가입된 %s입니다.'));
		
		$this->form_validation->set_rules('displayName', '별명', 'trim|required|min_length[1]|max_length[30]|regex_match[/^[ㄱ-ㅎ|가-힣|a-z|A-Z|0-9|\*]+$/]',array("regex_match"=>"%s는 한글,영어,숫자만 허용합니다."));
		
	}
	protected function _set_rules_update()
	{
		if($this->input->post('password') !== "" || $this->input->post('re_password') !== "")//패스워드 입력시에만
        {
			$this->form_validation->set_rules('re_password', '비밀번호 확인', 'trim|required|min_length[4]|max_length[40]|matches[password]',array('matches'=>'비밀번호가 일치 하지 않습니다.'));
			$this->form_validation->set_rules('password', '비밀번호', 'trim|required|min_length[4]|max_length[100]');
        }
	}

	protected function _set_rules_addUpdate_admin()
	{
		$this->form_validation->set_rules('kind', '종류', 'trim|required');
		$this->form_validation->set_rules('auth', '레벨', 'trim|required');
	}

	public function set_rules_userName()
	{
		// $this->form_validation->set_rules('userName', '아이디', 'trim|required|min_length[4]|max_length[20]|alpha_dash|regex_match[/^[a-zA-Z0-9]+([_ -]?[a-zA-Z0-9])*$/]',array("regex_match"=>"%s가 올바르지 않습니다."));
		$this->form_validation->set_rules('userName', '아이디',array('trim','required','min_length[4]','max_length[20]','alpha_dash',
		array('아이디는 숫자만 포함할수 없습니다.',function($value){
				if(is_numeric($value)) return false;
				return true;
			}),
		));
	}
	public function set_rules_password()
	{
		$this->form_validation->set_rules('password', '비밀번호', 'trim|required|min_length[4]|max_length[100]');
	}
	public function set_rules_userName_orEmail_orPhone()
	{
		$this->form_validation->set_rules('userName_orEmail_orPhone', '아이디 또는 이메일이나 휴대폰번호', 'trim');
	}
	//--@custom

	public function getByApiKey($apiKey)
	{
		if($this->userstate->isLogin())
        {
            $user = $this->user_m->p_get(["api_key"=>$apiKey,"id"=>$this->user->id],"id,point");
        }
        else
        {
            $user = $this->user_m->p_get(["api_key"=>$apiKey],"id,point");
        }
       return $user;
	}

	public function alterPoint($point,string $kind,$user_id =null)
	{
		if($kind !== "+" && $kind !== "-")
		{
			new RuntimeException("kind is not + or -");
			exit;
		}

		if($user_id ===null)
			$user_id = $this->user->id;
		$this->load->model("point_log/point_log_m");
		$this->point_log_m->p_add([
			"user_id"=>$user_id,
			"point" =>$kind.$point,
			"log" =>"보안코드 자동입력 사용"
		]);

		$this->db->set("point","point{$kind}{$point}",false);
		return $this->p_update($user_id);
	}
	public function refresh_apiKey($user_id)
    {
        
        $this->db->set('api_key',$this->generate_apiKey());
        $this->user_m->p_update($user_id);            
	}
	
	public function generate_apiKey()
	{
		$this->ci->load->helper('cookie');
		return md5(microtime().rand().get_cookie("ci_session"));
	}
	public function getBy_userName_orEmail_orPhone(string $u_e_p)
	{
		if (filter_var($u_e_p, FILTER_VALIDATE_EMAIL) !== false)
		{
			$fileName = "email";
		}
		else if (is_numeric($u_e_p) === true && strlen($u_e_p) >= 9 &&  strlen($u_e_p) <=11)
		{
			$fileName = "phone";
		}
		else if(preg_match("/^[a-zA-Z0-9]+([_ -]?[a-zA-Z0-9])*$/", $u_e_p) === 1 &&  is_numeric($u_e_p) === false)
		{
			$fileName = "userName";
		}
		else
		{
			return null;
		}
		$this->_select();
		$this->db->where("{$this->as}.{$fileName}",$u_e_p);
		$this->_from();
		return $this->db->get()->row();

	}
	public function getByUserName(string $userName)
	{
		$this->_select();
		$this->db->where("{$this->as}.userName",$userName);
		$this->_from();
		return $this->db->get()->row();
	}	
	public function getByUserId(string $user_id)
	{
		$this->_select();
		$this->db->where("{$this->as}.id",$user_id);
		$this->_from();
		return $this->db->get()->row();
	}
	
	//------@CRUD noDisplay display 재정의
	public function noDisplay($id = null)
	{
		parent::noDisplay($this->user->id);
	}
	//------ @List @Get 정의

	protected function _select()
	{
		$this->db->select("
		{$this->as}.*,
		group_concat(oauth.type) as sns_type,	
		");
		$this->db->group_by('u.id');
	}
	
	
	protected function _from()
	{
		$this->db->from("$this->table as {$this->as}");
		$this->db->join('oauth as oauth', "{$this->as}.id = oauth.user_id", 'left');
		
		
	}
	protected function _list_admin()
	{
		$this->db->where('u.kind != ', 'developer');
		$this->db->where('u.kind != ', 'admin');
	
	}
	protected function _get_admin()
	{
	}
	protected function _get_base()
	{
		$this->db->where('u.id',$this->user->id);
		
	}
	protected function _list_base()
	{
	}
	
	//getlist 필드네임 정의
	//admin
	public function listData_admin()
	{
		return array_merge(array(
			array("displayName"=>"ID","fieldName"=>"id"),
			array("displayName"=>"sns_type","fieldName"=>"sns_type"),
			array("displayName"=>"별명","fieldName"=>"displayName"),
			array("displayName"=>"이름","fieldName"=>"name"),
			array("displayName"=>"종류","fieldName"=>"kind"),
			array("displayName"=>"레벨","fieldName"=>"auth"),
			// array("displayName"=>"보이기","fieldName"=>"is_display"),
		),
		parent:: listData_admin());
	}

	public function getData_admin()
	{
		return array(
			array("displayName"=>"아이디","fieldName"=>"displayName"),
			array("displayName"=>"종류","fieldName"=>"kind"),
			array("displayName"=>"레벨","fieldName"=>"auth"),
			array("type"=>"image","class"=>"img-circle","style"=>"width:150px;","displayName"=>"프로필 사진","fieldName"=>"profile_image"),
			array("displayName"=>"이름","fieldName"=>"name"),
			array("displayName"=>"소개","fieldName"=>"intro"),
			array("displayName"=>"이메일","fieldName"=>"email"),
			array("displayName"=>"성별","fieldName"=>"sex"),
			array("displayName"=>"생년월일","fieldName"=>"birth"),
			array("displayName"=>"휴대폰번호","fieldName"=>"phone"),
			array("displayName"=>"주소","fieldName"=>"address"),
			array("displayName"=>"우편번호","fieldName"=>"postal_number"),
			array("displayName"=>"추가주소","fieldName"=>"more_address"),
			array("displayName"=>"sns타입","fieldName"=>"sns_type"),
			array("displayName"=>"보이기","fieldName"=>"is_display"),
		
		);
	}
	public function getData_base()
	{
		return array(
			array("displayName"=>"아이디","fieldName"=>"displayName"),
			array("displayName"=>"종류","fieldName"=>"kind"),
			array("displayName"=>"레벨","fieldName"=>"auth"),
			array("type"=>"image","class"=>"img-circle","style"=>"width:150px;","displayName"=>"프로필 사진","fieldName"=>"profile_image"),
			array("displayName"=>"이름","fieldName"=>"name"),
			array("displayName"=>"소개","fieldName"=>"intro"),
			array("displayName"=>"이메일","fieldName"=>"email"),
			array("displayName"=>"성별","fieldName"=>"sex"),
			array("displayName"=>"생년월일","fieldName"=>"birth"),
			array("displayName"=>"휴대폰번호","fieldName"=>"phone"),
			array("displayName"=>"주소","fieldName"=>"address"),
			array("displayName"=>"우편번호","fieldName"=>"postal_number"),
			array("displayName"=>"추가주소","fieldName"=>"more_address"),
			array("displayName"=>"연동된 sns","fieldName"=>"sns_type"),
			array("displayName"=>"보이기","fieldName"=>"is_display"),
		
		);
	}

	//------검색을 허용할 필드들을 정의합니다 


	protected function _searchData_admin()
	{
		return array(
			array("displayName"=>"아이디","fieldName"=>"u.userName"),
			array("displayName"=>"별명","fieldName"=>"u.displayName"),
			array("displayName"=>"이름","fieldName"=>"u.name"),
			array("displayName"=>"이메일","fieldName"=>"u.email"),
			array("displayName"=>"휴대폰번호","fieldName"=>"u.phone"),
	
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

	//---- 어드민 페이지의 세팅을 정의합니다.

	protected function _settingComponent_admin()
	{
		$this->load->model('oauth/oauth_m');
		
		$oauthes = $this->oauth_m->oauthes;
		$componentOath = [];
		foreach ($oauthes as $oauth)
		{
			$componentOath[] = array("displayName"=>"{$oauth} oauth secret_id","inputName"=>"oauth_{$oauth}_secret_id");
			$componentOath[] = array("displayName"=>"{$oauth} oauth client_id","inputName"=>"oauth_{$oauth}_client_id");
			$componentOath[] = array("displayName"=>"{$oauth} oauth redirect_url","inputName"=>"oauth_{$oauth}_redirect_url");
		}
		return array_merge(
			array(
				array("displayName"=>"회원가입 이메일 인증","inputName"=>"is_email_authentication_in_add_user"),
				array("displayName"=>"회원가입 휴대폰 인증","inputName"=>"is_phone_authentication_in_add_user"),
				array("displayName"=>"카페24 api key","inputName"=>"cafe24_sms_api_key"),
				array("displayName"=>"카페24 sms 아이디","inputName"=>"cafe24_userName"),
				array("displayName"=>"카페24 sms 휴대폰 번호","inputName"=>"cafe24_sms_number"),
				)
			,$componentOath
			);
	}


		//다음 테이블을 만듭니다.
		public function createTable ()
		{
			$createTableQuery = "CREATE TABLE `{$this->table}`(
					   `id` INT UNSIGNED NULL AUTO_INCREMENT, 
					   `userName` varchar(255), 
					   `password` varchar(255), 
					   `auth` INT NOT NULL DEFAULT '1',
					   `kind` ENUM('developer','admin','general') NOT NULL DEFAULT 'general',
					   `name` varchar(255),
					   `displayName` varchar(255),
					   `intro` varchar(255) DEFAULT '',
					   `profile_image` varchar(255) NOT NULL DEFAULT '/public/images/unknown.png',
					   `sex` varchar(255),
					   `birth` varchar(255),
					   `phone` varchar(255),
					   `email` varchar(255),
					   `address` varchar(255) ,
					   `postal_number` INT UNSIGNED, 
					   `more_address` varchar(255),
					   `option_1` varchar(255),
					   `option_2` varchar(255),
					   `option_3` varchar(255),
					   `option_4` varchar(255),
					   `option_5` varchar(255),
					   `is_display` boolean NOT NULL DEFAULT '1',
					   `is_secret` boolean NOT NULL DEFAULT '0',
					   `sort` INT NOT NULL DEFAULT '0',
					   `created` datetime NOT NULL DEFAULT NOW(),
					   UNIQUE KEY `uniqueIdx_userName` (`userName`),
					   UNIQUE KEY `uniqueIdx_displayName` (`displayName`),
					   UNIQUE KEY `uniqueIdx_email` (`email`),
					   UNIQUE KEY `uniqueIdx_phone` (`phone`),
					   KEY `idx_auth` (`auth`),
					   KEY `idx_kind` (`kind`),
					   KEY `idx_name` (`name`),
					   KEY `idx_sex` (`sex`),
					   KEY `idx_is_display` (`is_display`),
						KEY `idx_is_secret` (`is_secret`),
					   KEY `idx_sort` (`sort`),
					   KEY `idx_created` (`created`),
					   PRIMARY KEY (`id`)
				   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	
			$this->_createTable( $createTableQuery, function(){

				//개발자 계정 추가
				$password =password_hash("developer",PASSWORD_BCRYPT);
				$this->db->set("auth","101");
				$this->db->set("userName","developer");
				$this->db->set("email","developer@email.com");
				$this->db->set("kind","developer");
				$this->db->set("password",$password);
				$this->db->set("name","개발자");
				$this->db->set("displayName","개발자");
				$this->db->insert($this->table);
				
			   //관리자 추가
			   $password =password_hash("admin",PASSWORD_BCRYPT);
			   $this->db->set("auth","100");
			   $this->db->set("userName","admin");
			   $this->db->set("email","admin@email.com");
			   $this->db->set("kind","admin");

			   $this->db->set("password",$password);
			   $this->db->set("name","관리자");
			   $this->db->set("displayName","관리자");
			   $this->db->insert($this->table);
	
			   //테스터 추가
			   $password =password_hash("1234",PASSWORD_BCRYPT);
			   $this->db->set("auth","1");
			   $this->db->set("userName","test");
			   $this->db->set("email","test@email.com");
			   $this->db->set("password",$password);
			   $this->db->set("name","테스터");
			   $this->db->set("displayName","테스터");
			   $this->db->set("phone","00000000000");
			   $this->db->set("sex","m");
			   $this->db->insert($this->table);
	
			});
		}
	
		public function alertTable()
		{
			// $fieldName = "kind";
			// $alterFiledQuery="ALTER TABLE `{$this->table}` CHANGE `{$fieldName}` `{$fieldName}` ENUM('developer','admin','general') DEFAULT 'general';";
			// $this->_alterField($fieldName,$alterFiledQuery);
		
			$fieldName = "point";
			$addFieldQuery = "ALTER TABLE `{$this->table}` ADD `{$fieldName}` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `more_address`;";
			$this->_addField($fieldName,$addFieldQuery);

			$fieldName = "api_key";
			$addFieldQuery = "ALTER TABLE `{$this->table}` ADD `{$fieldName}` varchar(255)  AFTER `point`, ADD UNIQUE KEY `uniqueIdx_{$fieldName}` (`{$fieldName}`);";
			$this->_addField($fieldName,$addFieldQuery);

			$table = "setting";
			$fieldName = "is_userName_in_add_user";
            $addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` boolean  DEFAULT '0' AFTER `id`;";
			$this->_addField($fieldName,$addFieldQuery,$table);


			$fieldName = "is_phone_authentication_in_add_user";
            $addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` boolean  DEFAULT '0' AFTER `id`;";
			$this->_addField($fieldName,$addFieldQuery,$table);


			$fieldName = "is_email_authentication_in_add_user";
            $addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` boolean  DEFAULT '1' AFTER `id`;";
			$this->_addField($fieldName,$addFieldQuery,$table);

			//sms
			$fieldName = "cafe24_sms_api_key";
            $addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` varchar(255)  DEFAULT '1856aaacd1dee9bdb79b60c1c8746f38 ' AFTER `id`;";
			$this->_addField($fieldName,$addFieldQuery,$table);
			
			$fieldName = "cafe24_userName";
            $addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` varchar(255)  DEFAULT 'santutu6' AFTER `id`;";
			$this->_addField($fieldName,$addFieldQuery,$table);
			
			$fieldName = "cafe24_sms_number";
            $addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` varchar(255)  DEFAULT '010-5100-8825' AFTER `id`;";
            $this->_addField($fieldName,$addFieldQuery,$table);
		
		}


}

/* End of file U_m.php */
/* Location: ./application/models/U_m.php */