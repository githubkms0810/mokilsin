<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Init extends Developer_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->_echoAnchor();
	
	}
	public function index()
	{
        //grobal model
        $modelFiles =scandir(APPPATH."models");
        for ($i=0; $i < count($modelFiles); $i++) { 
            if(strpos($modelFiles[$i],EXT)  > -1)
            {
                $modelFile = strtolower(str_replace(EXT,"",$modelFiles[$i]));
                $this->load->model("{$modelFile}"); //찾은 모델 불러오기
                if(method_exists($this->$modelFile,"createTable") === true)
                {
                    $method = "createTable";
                    $this->$modelFile->$method(); //createTable()메소드 실행
                }
                if(method_exists($this->$modelFile,"alertTable") === true)
                {
                    $method = "alertTable";
                    $this->$modelFile->$method(); //alertTable()메소드 실행
                }

            }    
        }
		
		// $this->load->model('product/product_m');
		// $this->product_m->createTable();
		
		$this->load->model('file/file_m');
		$this->file_m->createTable();
        //module model
		//모든 모델의 createTable()메소드 실행하기
		$modulesName =scandir(APPPATH."modules"); //모든 모듈 찾기
		for ($i=2; $i < count($modulesName); $i++) { 
			$moduleFiles =scandir(APPPATH."modules/{$modulesName[$i]}");
			if(in_array("models",$moduleFiles) === true) 
			{
				$modelFiles=scandir(APPPATH."modules/{$modulesName[$i]}/models"); //모든 모델찾기
				for ($j=2; $j < count($modelFiles); $j++) 
				{ 
					$modelFile = strtolower(str_replace(EXT,"",$modelFiles[$j]));
					$this->load->model("{$modulesName[$i]}/{$modelFile}"); //찾은 모델 불러오기
					if(method_exists($this->$modelFile,"createTable") === true)
					{
						$method = "createTable";
						if($modelFile !== "user_m")
						{
							try{
								$this->$modelFile->$method(); //createTable()메소드 실행
							}catch(Exception $ex)
							{

							}
						}
					}
					if(method_exists($this->$modelFile,"alertTable") === true)
					{
						$method = "alertTable";
                        $this->$modelFile->$method(); //alertTable()메소드 실행
					}
				}
			}
		}
        // for ($i=2; $i < count($modulesName); $i++) 
        // { 
        //     if($modulesName[$i] === "01sample" ) continue;
        //     if($modulesName[$i] === "test" ) continue;
        //     $this->load->module(array("{$modulesName[$i]}/admin"=>$modulesName[$i]));
        //     if(method_exists($this->{$modulesName[$i]},"createTable"))
        //     {
        //         $this->{$modulesName[$i]}->createTable();
        //     }
        // }
    }
    public function dropColumn($tableName,$columnName)
    {
        $result=$this->dbforge->drop_column($tableName, $columnName);

        if($result === true)
		{
			echo "$tableName - $columnName 삭제성공";
		}
    }
	public function dropTable($tableName)
    {

		$result=$this->dbforge->drop_table($tableName);
		if($result === true)
		{
			echo "$tableName 삭제성공";
		}

	}
	private function _echoAnchor()
	{
		echo "<a href='".site_url("admin/main/index")."'>관리자페이지로</a>";
		echo "<br>";
		echo "<a href='".site_url("")."'>홈으로</a>";
        echo "<br>";
        echo "<a href='".site_url("/init")."'>설치</a>";
		echo "<br>";
	}
	function _session()
	{

        //세션 테이블 만들기
		$tb_name = 'ci_sessions';
		if(!$this->db->table_exists($tb_name)){
			$result =$this->db->query("CREATE TABLE IF NOT EXISTS `$tb_name` (
				`id` varchar(40) NOT NULL, `ip_address` varchar(45) NOT NULL, 
				`timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
				`data` blob NOT NULL,
				 PRIMARY KEY (id) );");

			if($result){
				echo("success create $tb_name ");
				echo "<br>";
				return true;
			}else{
				echo("failed create $tb_name");
				echo "<br>";
				return false;
			} 
			
		}else{
			// echo "already table $tb_name exists";
			// echo "<br>";
			return false;
		}

	}
	
	
}

/* End of file Init_Controller.php */
/* Location: ./application/core/Init_Controller.php */