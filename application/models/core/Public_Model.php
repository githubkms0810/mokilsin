<?php defined('BASEPATH') OR exit('no direct script access allrowed');

abstract class Public_Model extends DataManage_Model
{
    protected $table;
    protected $as;

    
    function __construct(){
        parent:: __construct();
       
    }
    //CRUD methods : child
    
    final public function get($where =null)
	{
        // $this->_select("{$this->as}.id");
        // $this->_select($this->get_fields());
        $selectMethod = "_select_{$this->className}";
        $this->$selectMethod();
        // if($this->router->fetch_class() === 'api')
        // {
        //     $this->_select_api();
        // }
        // else
        // {
        //     $this->_select();
        // }
        $method = "_get_{$this->className}";
        $this->$method();
        if($this->className ==="base")
            $this->db->where("{$this->as}.is_display","1");
        if($where !== null)
            $this->_where($where);
		$this->_from();
		$row =$this->db->get()->row();
		return $row;
    }
    public function list($where = null)
	{
        $selectMethod = "_select_{$this->className}";
        $this->$selectMethod();
        $this->SettingListWithoutSelect($where);
		$rows =$this->db->get()->result();
		return $rows;
    }
    public function listCount($where =null)
    {
        $this->db->select("count(*) as count");
        $this->SettingListWithoutSelect($where);
        $count= $this->db->get()->row();
        return $count->count;
    }
    private function SettingListWithoutSelect($where =null)
    {
        $this->_callbackOrderBy(get_post("orderBy"));//정렬
        if($this->table !== "ci_sessions")
        $this->db->order_by("{$this->as}.sort", 'asc');            
        $method = "_list_{$this->className}";
        if($this->className ==="base")
            $this->db->where("{$this->as}.is_display","1");
        $this->$method();
        if($where !== null)
            $this->_where($where);
        // $this->where("is_display","1");
		$this->_from();
		$this->db->order_by("{$this->as}.id","desc");
    }
  
    // public function delete($where)
    // {

    // }
    
    //CRUD methods : public
    final public function p_add($set =null)
    {
        if($set !== null){
            self::_set($set);
        }
        $this->db->set('created','NOW()',false);
        $this->db->insert($this->table);
        $id =$this->db->insert_id();
        return $id;
    }
  
    final public function p_update($where,$set =null,$escape = true)
    {
        if($set !== null)
        {
            self::_set($set,$escape);
        }
        self::_where($where);
        return  $this->db->update("{$this->table} as {$this->as}");
    }

    final public function p_get($where,$strSelect =null)
    {
        self::_where($where);
        if($strSelect !== null)
            $this->db->select($strSelect);
            
        if(method_exists($this,"_select_update"))
        {
            $this->db->select("{$this->as}.*");
            $this->_select_update();
            $this->_from();
            $row =$this->db->get()->row();
        }
        else
        {
            if(strpos($this->db->get_compiled_select(null,false), 'FROM') > -1)
            {
                $row =$this->db->get()->row();
            }   
            else
            {
                // $this->_from();
                $this->db->from("$this->table as $this->as");
                $row =$this->db->get()->row();
            }
        }
        return $row;
    }
    final public function p_list($where =null,$strSelect =null,$limit=null)
    {

        if(!$where !== null)
            self::_where($where);
        if($strSelect !== null && $strSelect !== null)
            $this->db->select($strSelect);
        if($limit !== null)
            $this->db->limit($limit[1],$limit[0]);
            
        if(strpos($this->db->get_compiled_select(null,false), 'FROM') > -1)
        {
            $rows =$this->db->get()->result();
        }   
        else
        {
            $this->db->from("$this->table as $this->as");
            $rows =$this->db->get()->result();
        }
       
        return $rows;
    }
    final public function p_delete($where)
    {
        self::_where($where, false);
        return $this->db->delete($this->table);
    }
    public function p_noDisplay($where)
    {
        $this->db->set("is_display","0");
        return $this->p_update($where);
    }
    public function p_display($where)
    {
        $this->db->set("is_display","1");
        return $this->p_update($where);
    }
    final public function p_deleteRange()
    {
        $ids = $this->input->post('ids');
        if($ids == null)
        {
            return;
        } 
        $result = true;
        foreach($ids as $id)
        {
            $tmp_result =$this->delete($id);
            if($tmp_result === false)
            {
                $result = false;
            }
        }

        return $result;
    }
    /////
    public function p_get_max_id($table,$column_name){
        $row =$this->db->query("SELECT MAX($column_name) 'max_id' FROM $table")->row();
        return ($row != null) ? ($row->max_id +1) : 1;
    }

    public function p_hits_plus($id){
		$this->db->query("UPDATE `{$this->table}` SET hits = hits+1 WHERE id = '$id'");
    }
    
    final protected function _set($set,$escape=true){
        if($set !== null)
        {
            foreach($set as $key=>$val)
            {
                if($val !== false && $val !== null)
                    $this->db->set($key, $val,$escape);
            }
        }
        
    }
   
    final protected function _where($where,bool $as = true){
        if($where === null )
        {
            return;
        }
        if(is_array( $where )){
            foreach($where as $key=>$val){
                if($val === false || $val === null)
                    $val ='';
                $this->db->where($key, $val);
            }
        }else{
            if($as === true)
            {
                $this->db->where("{$this->as}.id",$where);
            }
            else
            {
                $this->db->where("id",$where);
            }
        }
    }
    
    final public function set($name,$value,$escape= true)
    {
        $this->db->set($name,$value,$escape);
    }
    final public function set_post($nameValue)
    {
        $this->db->set($nameValue,post($nameValue));
    }
    final public function where($name,$value)
    {
        $this->db->where($name,$value);
    }
    
    // function _get_count($where=null, $count_name){

    //     if($where ===null)
    //     {
    //         $this->db->select("sum($count_name) '$count_name'");
    //     }else
    //     {
    //         self::_where($where);
    //         $this->db->select($count_name);
    //     }
        
    //     $count= $this->db->get($this->table)->row()->$count_name;
    //     return $count;
    // }
    // function _count_plus($where,$count_name = 'count'){
    //     self::_where($where);

    //     $this->db->set($count_name,"{$count_name}+1",false);
    //     $this->db->update($this->table);
    // }
    
    // function _count_minus($where,$count_name = 'count'){
    //     self::_where($where);

    //     $this->db->set($count_name,"{$count_name}-1",false);
    //     $this->db->update($this->table);
    // }

    final protected function _like_or_by_split($fields,$val)
    {
        if(isset($fields) && $fields !== null && $fields !== '')
        {
            $fields = urldecode($fields);
            $arr_field =explode(",",$fields);
            foreach($arr_field as $field)
            {
                $this->db->or_like($field, $val);       
            }
      }
      return;
   
    }

    function get_num_rows($where=null)
    {   
        if($where !== null)
            $this->_where($where);
        $method = "_list_{$this->className}";
        $this->$method();
        return $this->db->count_all_results("{$this->table} as {$this->as} ");
    }

    protected function _createTable($createTableQuery,$callback =null)
    {
        $result ="테이블 ";
        $deleteLink = "";
        if(DEBUG === true)
        {
            $deleteLink = "<a href=".site_url("/init/dropTable/{$this->table}").">삭제</a>";
        }
        //products 테이블 만들기
        if(!$this->db->table_exists($this->table)){

            $queryResult = $this->db->query($createTableQuery);
                
            if($queryResult)
            {
               
                $result .="생성 :: {$this->table} 테이블 생성 성공";
                $result .=$deleteLink;
                if($callback!== null)
                {
                    $callback();
                }
              
            }
            else
            {
                $result .="실패 :: {$this->table} 테이블 생성 실패";
            } 
            
        }
        else
        {
            $result .="존재 :: {$this->table} 테이블은 이미 존재합니다.";
            $result .=  $deleteLink;
        }
        $result .="<br>";
        if($this->table !== "user")
        {
            echo $result;
        }
    }
    protected function _alterField($fieldName,$alterFiledQuery)
    {
        $result = "&nbsp;&nbsp;&nbsp;필드 ";
        $deleteLink = "";
        if(DEBUG === true)
        {
            $deleteLink = "<a href=".site_url("/init/dropColumn/{$this->table}/{$fieldName}").">삭제</a>";
        }
    
        $queryResult=$this->db->query($alterFiledQuery);
        if($queryResult === true)
        {
            $result .= "생성 :: {$this->table}에 {$fieldName} 필드 수정 성공.";
        }else
        {
            $result .= "실패 :: {$this->table}에 {$fieldName} 필드 수정 실패.";
        }
        $result .=  $deleteLink;
       $result .="<br>";
       echo $result;

    }
    protected function _addField($fieldName,$addFieldQuery,$table = null)
    {
        if($table === null) $table = $this->table;
        $result = "&nbsp;&nbsp;&nbsp;필드 ";
        $deleteLink = "";
        if(DEBUG === true)
        {
            $deleteLink = "<a href=".site_url("/init/dropColumn/{$table}/{$fieldName}").">삭제</a>";
        }
       if ($this->db->field_exists($fieldName, $table) === false)
       {
           $queryResult=$this->db->query($addFieldQuery);
            if($queryResult === true)
            {
                $result .= "생성 :: {$table}에 {$fieldName} 필드 생성 성공.";
                $result .=  $deleteLink;
            }else
            {
                $result .= "실패 :: {$table}에 {$fieldName} 필드 생성 실패.";
            }
       }
       else 
       {
           $result .= "존재 :: {$table}에 {$fieldName} 필드는 이미 존재합니다.";
           $result .=  $deleteLink;
       }
       $result .="<br>";
       echo $result;
    }

}



