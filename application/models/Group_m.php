<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Group_M extends Public_Model {

    public function __construct()
	{
		parent::__construct();
		$this->table = "group_primarykey";
        $this->as = "g_pk";
	}

	public function plusKey($fieldName)
	{
		$this->db->where("id","1");
		$this->db->set($fieldName,"{$fieldName}+1",FALSE);
		$this->db->update($this->table);
	}

	public function createTable ()
	{
		$createTableQuery = "CREATE TABLE `{$this->table}`(
			`id` INT UNSIGNED NULL AUTO_INCREMENT, 
			`created` datetime NOT NULL DEFAULT NOW(),
			KEY `idx_created` (`created`),
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$callback = function()
		{
			$this->db->set("id",1);
			$this->db->insert($this->table);
		};
		$this->_createTable($createTableQuery,$callback);
	}
	public function alertTable()
	{
		$fieldName = "file";
		$addFieldQuery = "ALTER TABLE `{$this->table}` ADD `{$fieldName}` INT UNSIGNED NOT NULL DEFAULT '1' AFTER `id`;";
		$this->_addField($fieldName,$addFieldQuery);
		
	}

}

/* End of file Setting_M.php */

?>