<?php defined('BASEPATH') OR exit('no direct script access allrowed');

abstract class DataManage_Model extends MY_Model
{
    
    protected $table;
    protected $as;
    protected $className;
    protected $methodName;
    protected $moduleName;
    protected $user;
    protected $CI;
    protected $ci;

    public $id=null;

    protected $numRows_moduleName = null;
    protected $numRows_foreignKey = null;
    protected $numRows_fieldName = null;
    function __construct(){
        parent:: __construct();
        $this->CI = Public_Controller::$instance;
        $this->ci = &get_instance();
        $this->user = &$this->CI->user;
        $this->moduleName = &$this->CI->moduleName;
        $this->className = &$this->CI->className;
        $this->methodName = &$this->CI->methodName;
        $this->load->library('userstate');

        $this->displayName = "IF({$this->as}.user_id is null,concat( {$this->as}.guest_name,'(손님)'), u.displayName) as displayName";
        $this->displayName2 = "IF({$this->as}.user_id is null , '손님', u.displayName) as displayName";
    }
    //

    
    //------추가,업데이트 할 정보
    public function update($id)
    {
      	
        $method =  "_update_{$this->className}";
    
        $result = $this->$method($id);

        return $result;
    }
    public function add()
    {	
        $method =  "_add_{$this->className}";
        $insert_id = $this->$method();

        $this->setNumRowsField($insert_id,"+");
        return $insert_id;
    }
 

    protected function _add_admin()
    {
        $this->_set_allPost_inTableField();
        return $this->p_add();
    }

    protected function _update_admin($id)
    {
        $this->_set_allPost_inTableField();
        return $this->p_update($id);
    }

    protected function _add_base()
    {
        return $this->p_add();
    }

    protected function _update_base($id)
    {
        return $this->p_update($id);
    }

    public function delete($where)
    {
        
        $this->setNumRowsField($where,"-");

        $result = $this->p_delete($where);
      
        return $result;
    }
    public function noDisplay($where)
    {
       
        $this->setNumRowsField($where,"-");
        $result = $this->p_noDisplay($where);
   
        return $result;
    }
    public function display($where)
    {
     
        $this->setNumRowsField($where,"+",true);
        $result = $this->p_display($where);
     
        return $result;
    }

    public function setNumRowsField($where,string $mode ="+",$is_displayFunc = false)
    {
        if($this->numRows_moduleName ===null) return false;

        if($this->numRows_foreignKey === null)
        {
            $this->numRows_foreignKey = "{$this->numRows_moduleName}_id";
        }
          //board의 content 갯수 업데이트
		$row =$this->p_get($where,"{$this->numRows_foreignKey},is_display");
		$is_display = $row->is_display;
		$whereFieldValue = $row->{$this->numRows_foreignKey};
		if(($is_display === "1" && $is_displayFunc === false) ||($is_display === "0" && $is_displayFunc === true))
		{
            if($this->numRows_fieldName === null)
                $this->numRows_fieldName="num_{$this->moduleName}";
            $fieldName = $this->numRows_fieldName;

            $whereFieldName = str_replace("{$this->numRows_moduleName}_","",$this->numRows_foreignKey);
            $this->load->model("{$this->numRows_moduleName}/{$this->numRows_moduleName}_m");
            $this->db->set("$fieldName","{$fieldName}{$mode}1",false);
            $this->{$this->numRows_moduleName."_m"}->p_update(["$whereFieldName"=>$whereFieldValue]);
			// $this->{$this->numRows_moduleName}->plus_numContents($id);
        }
    }
    //-----component 정의
    private function componentIsForm($component)
    {
        if (isset($component[0]))
        {
            if(is_array($component[0]))
            {
                return true;
            }
        }
        return false;
    }
    public function component()
    {
        $output = [];
        $method = "_component_{$this->methodName}";
        $components_addUpdate= $this->_component_addUpdate();
        $components_method = $this->$method();
        
        if(isset($components_addUpdate[0]) === false)
        {
            return array();
        }

        if($this->componentIsForm($components_addUpdate[0])=== false)
        {
            return array(array_merge($components_addUpdate,$components_method));
        }

        foreach ($components_method as $key => $component_method) {
            $components_addUpdate[$key] = array_merge($components_addUpdate[$key],$component_method);
        }
        return $components_addUpdate;


    //     if(isset( $component_addUpdate[0][0]) === false )
    //     {
    //         $component_addUpdate = array($this->_component_addUpdate());
    //         $component_addUpdate = array($this->_component_addUpdate());
    //         if( isset($component_addUpdate[0][0]) == false)
    //         {
    //             $component_addUpdate = array();
    //         } 
    //     }
    //     $component_method = $this->$method();
    //     if(isset( $component_method[0][0]) === false )
    //     {
    //         $component_method = array($this->$method());
    //         if( isset($component_method[0][0]) == false)
    //         {
    //             $component_method = array();
    //         } 
    //     }
    //    return array_merge($component_addUpdate,$component_method);
        // return array_merge($this->_component_addUpdate(),$this->$method());
    }
    
	protected function _component_addUpdate()
	{
        $components = [];
        $fields=$this->db->list_fields($this->table);
        foreach ($fields as $field) 
        {
            if($field === "created") continue;
            $components[] = array("inputName"=>$field,"displayName"=>$field);
        }
		return $components;
	}
    protected function _component_add()
    {
        return array(
            
            );
    }
    protected function _component_update()
    {
        return array(
            
            );
    }

    //------ addUpdate 유효성 검사
    public function set_rules()
    {
        $method ="set_rules_{$this->methodName}_{$this->className}";
        $this->$method();
    }
    public function set_rules_add_admin()
    {
        $this->_set_rules_addUpdate();
        $this->_set_rules_add();
        $this->_set_rules_addUpdate_admin();
        $this->_set_rules_add_admin();
    }
    public function set_rules_update_admin()
    {
        $this->_set_rules_addUpdate();
        $this->_set_rules_update();
        $this->_set_rules_addUpdate_admin();
        $this->_set_rules_update_admin();
    }

    
    public function set_rules_add_base()
    {
        $this->_set_rules_addUpdate();
        $this->_set_rules_add();
        $this->_set_rules_addUpdate_base();
        $this->_set_rules_add_base();
    }
    public function set_rules_update_base()
    {
        $this->_set_rules_addUpdate();
        $this->_set_rules_update();
        $this->_set_rules_addUpdate_base();
        $this->_set_rules_update_base();
    }
    //정의
    protected function _set_rules_addUpdate()
	{
       
    }
    protected function _set_rules_add()
	{
        
    }
    protected function _set_rules_update()
	{
	
    }
    
    protected function _set_rules_addUpdate_admin()
    {
        foreach ($_POST as $key => $value) 
        {
            $this->form_validation->set_rules($key, $key, 'trim');
            break;
        }
    }
    protected function _set_rules_add_admin()
    {

    }
    protected function _set_rules_update_admin()
    {

    }

    protected function _set_rules_addUpdate_base()
    {

    }
    protected function _set_rules_add_base()
    {

    }
    protected function _set_rules_update_base()
    {

    }
    //------ @List @Get 정의
    
    protected function _select_api()
    {
        $this->_select();
    }
    protected function _select()
    {
        $this->db->select("{$this->as}.*");
    }
    protected function _select_admin()
    {
        $this->_select();
    }
    protected function _select_base()
    {
        $this->_select();
    }
    protected function _from()
    {
        $this->db->from("$this->table as {$this->as}");
        // $this->db->join("user as u","{$this->as}.user_id = u.id","LEFT");
    }
    protected function _get_admin()
    {
    }
    protected function _get_base()
    {

    }
    protected function _list_admin()
    {

    }
    protected function _list_base()
    {

    }
    //@get@list 필드네임 정의
    public function getData()
    {

        $method = "getData_{$this->className}";
        $dataList =$this->$method();
        foreach ($dataList as $key => $data) 
        {
            if(isset($data["type"]) === false)
            {
                $dataList[$key]["type"] ="text";
            }
        }
        return $dataList;
    }
    public function listData()
    {
        $method = "listData_{$this->className}";
        $dataList =$this->$method();
        foreach ($dataList as $key => $data) 
        {
            if(isset($data["type"]) === false)
            {
                $dataList[$key]["type"] ="text";
            }
        }
        return $dataList;
    }
    public function getData_admin()
    {
        $fields=$this->db->list_fields($this->table);
        $data = [];

        foreach ($fields as $field) 
        {
            $data[] = array("displayName"=>$field,"fieldName"=>$field);
        }
              
        return $data;
    }
    public function listData_admin()
    {
        return array(
            array("displayName"=>"생성일","fieldName"=>"created"),
            array("displayName"=>"보이기","fieldName"=>"is_display"),
        );
    }
    public function getData_base()
    {
        return array();
    }
    public function listData_base()
    {
        return array();
    }
    //----세팅
    private $cache_settingData_admin=null;
    public function settingComponent()
    {
        if($this->cache_settingData_admin === null)
        {
            $settingComponent_admin =$this->_settingComponent_admin();
            if(isset( $settingComponent_admin[0][0]) === false )
            {
                $settingComponent_admin = array($this->_settingComponent_admin());
                $settingComponent_admin = array($this->_settingComponent_admin());
                if( isset($settingComponent_admin[0][0]) == false)
                {
                    $settingComponent_admin = array();
                } 
            }

            $this->cache_settingData_admin = $settingComponent_admin;
        }
        return $this->cache_settingData_admin;
    }
    protected function _settingComponent_admin()
    {
        return array();
    }
    //------
    // public function set()
    // {
    //     $method = "{$this->methodName}Data_{$this->className}";
    // 	$add_data = $this->$method();
        
        
    // 	foreach ($add_data as $data) {
    // 		if(is_callable($data))
    // 		{
    // 			$data();
    // 			continue;
    // 		}
    // 		if(is_string($data))
    // 		{
    // 			$this->db->set($data,$this->input->post($data));
    // 			continue;
    // 		}
    // 		$fieldName = $data["fieldName"] ?? $data["inputName"];
    // 		if(isset($data["callback"]))
    // 		{
    // 			$fieldValue = $data["callback"]();
    // 		}
    // 		else
    // 		{
    // 			$fieldValue =   $this->input->post($data["inputName"]);
    // 		}
    // 		$this->db->set($fieldName, $fieldValue);
    // 	}
    // }
    

    public function _set_allPost_inTableField($excepts =array())
    {
        $fields=$this->db->list_fields($this->table);

        foreach($_POST as $key => $value)
        {       
            if(in_array($key,$fields) === true && in_array($key,$excepts) === false)
            {
                // $columSchemaInfo=$this->db->query("SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT
                // FROM INFORMATION_SCHEMA.COLUMNS
                // WHERE table_name = 'tbl_name'
                // [AND table_schema = 'db_name']
                // [AND column_name LIKE 'wild']")->row();
                // // var_dump($columSchemaInfo);

                // if($value === "")
                //     $value = null;
                $this->set($key,$value);
                unset($fields[$key]);
            }
        }
    }

}



