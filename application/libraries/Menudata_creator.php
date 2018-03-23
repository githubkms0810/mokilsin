<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class MenuData_Creator
{
	private $ci;
    private $mainMenus=array();
	private $subMenus=array();
    public function __construct()
    {   
		$this->ci = &Public_Controller::$instance;
	}
	public function getMainMenus()
	{
		return $this->mainMenus;
	}
	public function getSubMenus(bool $sub = true)
	{
		if($sub === true)
		{
			if(isset($this->subMenus[$this->ci->input->get("mainMenu")]))
				return $this->subMenus[$this->ci->input->get("mainMenu")];
			else
				return array();
		}
		return $this->subMenus;
	}
    public function addMainMenu(string $name,string $id =null,string $subMenuId ,string $url,bool $queryString=true,string $anchorTarget="")
	{
		if($id === null) $id = $name;
		if($queryString ===true)
		{
			if(strpos($url,"?") === false)
			{
				$url .= "?mainMenu=$id&subMenu=$subMenuId";
			}
			else
			{
				$url .= "&mainMenu=$id&subMenu=$subMenuId";
			}
		}
		$menu =(object)array("name"=>$name,"id"=>$id,"url"=>$url,"target"=>$anchorTarget);
		array_push($this->mainMenus,$menu);
	}
	public function addSubMenu(string $mainMenuId,string $name,$id,string $url,bool $queryString=true,string $anchorTarget="")
	{
		if(!isset($this->subMenus[$mainMenuId]))
		{
			$this->subMenus[$mainMenuId] = array();
		}
		if($queryString ===true)
		{
			if(strpos($url,"?") === false)
			{
				$url .= "?mainMenu=$mainMenuId&subMenu=$id";
			}
			{
				$url .= "&mainMenu=$mainMenuId&subMenu=$id";
			}
		}
		$menu =(object)array("name"=>$name,"id"=>$id,"url"=>$url,"target"=>$anchorTarget);

		array_push($this->subMenus[$mainMenuId],$menu);
	}
}