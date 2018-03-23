<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_M extends Public_Model {

    public function __construct()
	{
		parent::__construct();
		$this->table = "setting";
        $this->as = "s";
	}

	public function createTable ()
	{
		$createTableQuery = "CREATE TABLE `{$this->table}`(
            `id` INT UNSIGNED NULL AUTO_INCREMENT, 
            `created` datetime NOT NULL DEFAULT NOW(),
            PRIMARY KEY (`id`)
             ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$callback = function()
		{
			$this->db->set("id","1");
			
			$this->db->insert("setting");
		};
		$this->_createTable($createTableQuery,$callback);
	}
	public function alertTable()
	{
		
	}
}

/* End of file Setting_M.php */

?>