<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Count_m extends Public_Model {

    public function __construct()
	{
		parent::__construct();
		$this->table = "count";
        $this->as = "count";
	}
	public function plusOneToField($fieldName)
	{
		$this->db->set($fieldName,"$fieldName +1", false);
		return $this->db->update($this->table);
	}

	public function minusOneToField($fieldName)
	{
		$this->db->set($fieldName,"$fieldName -1", false);
		return $this->db->update($this->table);
	}

	public function createTable ()
	{
		$createTableQuery = "CREATE TABLE `{$this->table}`(
            `id` INT UNSIGNED NULL AUTO_INCREMENT, 
            `num_freelancer` INT UNSIGNED  NOT NULL DEFAULT '0',
            `created` datetime NOT NULL DEFAULT NOW(),
            PRIMARY KEY (`id`)
             ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$callback = function()
		{
			$this->db->set("num_freelancer","0");
			$this->db->insert("count");
		};
		$this->_createTable($createTableQuery,$callback);
	}
	public function alertTable()
	{
		
	}
}

/* End of file Setting_M.php */

?>