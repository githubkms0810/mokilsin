
                
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oauth_M extends Public_Model {


	public function __construct()
	{
		parent::__construct();
		$this->table = "oauth";
        $this->as = "oauth";
    }
    public function linkUser($oauth_id,$user_id)
    {
        $this->db->set("user_id",$user_id);
        return $this->oauth_m->p_update($oauth_id);
    }
    public function add_withFacebook($info,$refresh_token =null)
    {
        $this->set("sns_id",$info->id);
        $this->set("email",$info->email);
        $this->set("name",$info->name);
        $this->set("sex",$info->gender);
        $this->set("type","facebook");
        $this->set("refresh_token",$refresh_token);
        return $this->p_add();
    }
    public function add_withGoogle($info,$refresh_token)
    {
        $this->set("sns_id",$info->emailAddresses[0]->metadata->source->id);
        $this->set("email",$info->emailAddresses[0]->value);
        $this->set("name",$info->names[0]->displayName);
        $this->set("sex",$info->genders[0]->value);
        $this->set("type","google");
        $this->set("refresh_token",$refresh_token);
        return $this->p_add();
    }
    public function add_withNaver($info,$refresh_token)
    {
        $this->set("sns_id",$info->id);
        $this->set("name",$info->name);
        $this->set("email",$info->email);
        $this->set("profile_image",$info->profile_image);
        $this->set("type","naver");
        $this->set("refresh_token",$refresh_token);

        return $this->p_add();
    }
    public function get_bySnsId(string $sns_id)
    {
        $this->_select();
        $this->_from();
        return $this->p_get(["sns_id"=>$sns_id]);
    }
    public function isExist($user_id,$type)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('type', $type);
        $row  = $this->p_get();
        if($row !== null)
        {
            return true;
        }
        return false;
        
    }
    public function _select()
    {
        $this->db->select("
            {$this->as}.*, 
            u.userName"
        );
        
    }
    public function _from()
    {
        $this->db->from("{$this->table} as {$this->as}");
        $this->db->join("user as u","u.id = {$this->as}.user_id","LEFT");
        
    }
    //다음 테이블을 만듭니다.
    public function createTable ()
    {
        $createTableQuery = "CREATE TABLE `{$this->table}`(
                    `id` INT UNSIGNED NULL AUTO_INCREMENT, 
                    `sns_id` varchar(255) NOT NULL,
                    `user_id` int UNSIGNED,
                    `type` ENUM('facebook','naver','google','kakao') NOT NULL,
                    `refresh_token` varchar(255),
                    `email` varchar(255),
                    `name` varchar(255),
                    `sex` varchar(255),
                    `profile_image` varchar(255),
                    `is_display` boolean NOT NULL DEFAULT '1',
                    `is_secret` boolean NOT NULL DEFAULT '0',
                    `sort` INT NOT NULL DEFAULT '0',
                    `created` datetime NOT NULL DEFAULT NOW(),
                    CONSTRAINT `fkOauth_user_id` FOREIGN KEY (`user_id`) REFERENCES user(`id`)
        	        ON UPDATE CASCADE
			        ON DELETE CASCADE
                    ,
                    UNIQUE KEY `uniqueIdx_sns_id` (`sns_id`),
                    UNIQUE KEY `uniqueIdx_user_id-type` (`user_id`,`type`),
                    KEY `idx_user_id` (`user_id`),
                    KEY `idx_type` (`type`),
                    KEY `idx_refresh_token` (`refresh_token`),
                    KEY `idx_email` (`email`),
                    KEY `idx_name` (`name`),
                    KEY `idx_sex` (`sex`),
                    KEY `idx_is_display` (`is_display`),
                    KEY `idx_is_secret` (`is_secret`),
                    KEY `idx_sort` (`sort`),
                    KEY `idx_created` (`created`),
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        $this->_createTable( $createTableQuery);
    }
   
    public $oauthes = ["facebook","naver","google","kakao"];
    public function alertTable()
    {
        // $fieldName = "kind";
        // $alterFiledQuery="ALTER TABLE `{$this->table}` CHANGE `{$fieldName}` `{$fieldName}` ENUM('developer','admin','general') DEFAULT 'general';";
        // $this->_alterField($fieldName,$alterFiledQuery);
        //------setting
        //oauth
     
        $oauthData = [
            "facebook"=>["client_id"=>"161028841210737","secret_key"=>"fc6c3c2a9f57fd701d3b1b4b64042ce6","redirect_url"=>base_url("/oauth/facebook/redirect_url")],
            "naver"=>["client_id"=>"","secret_key"=>"","redirect_url"=>""],
            "google"=>["client_id"=>"","secret_key"=>"","redirect_url"=>""],
            "kakao"=>["client_id"=>"","secret_key"=>"","redirect_url"=>""],
        ];
        $table = "setting";
        foreach ($this->oauthes as $oauth) 
        {
            $client_id = $oauthData[$oauth]["client_id"];
            $secret_key = $oauthData[$oauth]["secret_key"];
            $redirect_url = $oauthData[$oauth]["redirect_url"];

            $fieldName = "oauth_{$oauth}_client_id";
            $addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` varchar(255)  DEFAULT '{$client_id}' AFTER `id`;";
            $this->_addField($fieldName,$addFieldQuery,$table);
    
            $fieldName = "oauth_{$oauth}_secret_id";
            $addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` varchar(255) DEFAULT '{$secret_key}'  AFTER `id`;";
            $this->_addField($fieldName,$addFieldQuery,$table);
    
            $fieldName = "oauth_{$oauth}_redirect_url";
            $addFieldQuery = "ALTER TABLE `{$table}` ADD `{$fieldName}` varchar(255) DEFAULT '{$redirect_url}'  AFTER `id`;";
            $this->_addField($fieldName,$addFieldQuery,$table);
        }
        
  

    
    }
	
	
}

/* End of file U_m.php */
/* Location: ./application/models/U_m.php */