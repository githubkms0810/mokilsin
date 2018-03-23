<?php defined('BASEPATH') OR exit('no direct script access allrowed');

abstract class Pagination_Model extends Public_Model{

    
    function __construct(){
        parent:: __construct();
    }
    //------주요메소드
    public function p_listPagination_func($config =array())
    {
        //세팅
        $this->load->library('pagination');
        $pgi_style =$config["pgi_style"];
        $get_num_rows_func =$config["get_num_rows_func"];
        $get_rows_func =$config["get_rows_func"];
        $get_count_field = $config['get_count_field'] ?? null;
        $isIgnoreCountOnAdminPage = $config['isIgnoreCountOnAdminPage'] ?? false;
        
        $is_numrow =$config['is_numrow'] ?? false;
        $pgiConfig =array();
        if(isset($config["per_page"]))
        {
            $pgiConfig["per_page"] = $config["per_page"];
        }

        if($get_num_rows_func === null)
        {
            $get_num_rows_func = function()
            {
                return $this->db->count_all_results($this->table );
            };
        }
        //전체 열갯수 구하기
        $searchKey =get_post("searchKey");
        $searchValue =get_post("searchValue");
        $searchKeyOption =get_post("searchKeyOption");
        $searchValueOption =get_post("searchValueOption");
        if($searchKey !== null && $searchKey !== '')//검색 일떄
        {
            if($searchKeyOption !==null)
            foreach ($searchKeyOption as $key=>$value) 
            {
                if(isset($searchKeyOption[$key]) && isset($searchValueOption[$key]))
                {
                    $this->_callbackSearchOption($searchKeyOption[$key],$searchValueOption[$key]);
                }
            }
            if($searchKey !==null)
            foreach ($searchKey as $key=>$value) 
            {
                if(isset($searchKey[$key]) && isset($searchValue[$key]))
                {
                    $this->_callbackSearch($searchKey[$key],$searchValue[$key]);
                }
            }
            $total_rows = $get_num_rows_func();
            // var_dump($this->db->last_query());
        }
        else if(($get_count_field === null || $this->className ==="admin") && $isIgnoreCountOnAdminPage === false) //일반
        {
            $total_rows = $get_num_rows_func();
        }
        else if($get_count_field !== null)  //테이블에 nums_row필드가 따로있을때
        {
            $total_rows =$get_count_field;
        }
   
        //페이지네이션 세팅
        $pgiConfig +=array(
            'total_rows'=>$total_rows,
            'style_pgi'=>$pgi_style,
        );
        $pgiData =$this->pagination->get($pgiConfig);
        $offset = $pgiData['offset'];
        $per_page = $pgiData['per_page'];
        
        //열 데이터 구하기
        if($searchKey !== null && $searchKey !== '')//검색 일떄
        {
            if($searchKeyOption !==null)
            foreach ($searchKeyOption as $key=>$value) 
            {
                // if(isset($searchKey[$key]) && isset($searchValue[$key]) && DEBUG === false)
                if(isset($searchKeyOption[$key]) && isset($searchValueOption[$key]))
                {
                    $this->_callbackSearchOption($searchKeyOption[$key],$searchValueOption[$key]);
                }
            }
            if($searchKey !==null)
            foreach ($searchKey as $key=>$value) 
            {
                $this->_callbackSearch($searchKey[$key],$searchValue[$key]);
            }
        }
        
     
        if($is_numrow === true) //is_numrow 모드일떄
        {
            $this->db->select("{$total_rows}-{$offset}-@count 'num_row',{$offset}+@count+1 'page_num_row', @count:=@count+1 'none'");
            $this->db->from("(SELECT @count:=0) der_tap");
        }
        
        $rows =$get_rows_func($offset,$per_page);
        // var_dump($rows);
        return $rows;
    }
 
    
    //검색------
    public function _callbackSearchOption($key,$value)
    {
        if($value !== "" && $value !== null)
        {
            $value=str_replace("&lt;","<",$value);
            $this->db->like($key,$value);
        }
    }
    public function searchData()
    {
        $method = "_searchData_{$this->className}";
        return array_merge($this->_searchData(),$this->$method());
    }
    protected function _searchData()
    {
        return array(
            "id"=>array("displayName"=>"id","fieldName"=>"{$this->as}.id"),
            "name"=>array("displayName"=>"이름","fieldName"=>"{$this->as}.name"),
        );
    }
    protected function _searchData_admin()
    {
        return array(
        );
    }
    protected function _searchData_base()
    {
        return array(
          
        );
    }
  
    private function _callbackSearch($key,$value)
    {
        $dataList=$this->searchData();
        if(isset($dataList[$key]["callback"]))
        {
           
            $dataList[$key]["callback"]($value);
          
        }
        if(isset($dataList[$key]["fieldName"]))
        {
            $fieldNameList = &$dataList[$key]["fieldName"];
            if(is_array($fieldNameList) === false)
            {
                $fieldNameList = array($fieldNameList);
            }
            
            $kind = $dataList[$key]["kind"] ?? "or_like";
            if(is_array($kind) === false)
            {
                $kind = array($kind);
            }
            
            foreach ($fieldNameList as $k => &$fieldName) 
            {
               
                $kindKey = isset($kind[$k]) ? $k: $kindKey;
                if(strpos($kind[$kindKey],"textfull") > -1)
                {
                    $textfullKind =(strpos($kind[$kindKey],"or") > -1) ?  "or" : "and";   
                    $this->whereTextfull($fieldName,$value,$textfullKind);
                }
                else
                {
                    if($value !== "" && $value !== null)
                        $this->db->{$kind[$kindKey]}($fieldName,$value);
                }

            }
        }
    }

    //------정렬
    public function orderByData()
    {
        $method = "_orderByData_{$this->className}";
        return array_merge($this->_orderByData(),$this->$method());
    }

    protected function _orderByData()
    {
        return array(
            "newest"=>array("displayName"=>"최근순","callback"=>function(){
                $this->db->order_by("{$this->as}.id","desc");
            }),
            "lastest"=>array("displayName"=>"등록순","callback"=>function(){
                $this->db->order_by("{$this->as}.id","asc");
            }),
        );
    }
    protected function _orderByData_admin()
    {
        return array();
    }
    protected function _orderByData_base()
    {
        return array(
        );
    }

    protected function _callbackOrderBy($key)
    {   
        $dataList=$this->orderByData();
        if(isset($dataList[$key]["callback"]))
        {
            $dataList[$key]["callback"]();
        }
        if(isset($dataList[$key]["fieldName"]))
        {
            $sort = $dataList[$key]["sort"] ?? "asc";
            $this->db->order_by($dataList[$key]["fieldName"],$sort);
        }
    }

 
    // private function _filter_like($fields,$val,string $kind ="and")
    // {
    //     if(isset($fields) && $fields !== null && $fields !== '')
    //     {
    //         $fields = urldecode($fields);
    //         $arr_field =explode(",",$fields);
    //         $allowFields=$this->searchFieldData();
    //         if(isset($allowFields[0]))
    //         {
    //             foreach($arr_field as $field) // 검색할 필드들
    //             {
    //                 foreach ($allowFields as $key => $row) { //검색 허용됬는지 검사
    //                     if($row["fieldName"] === $field)
    //                     {
    //                         if($kind === "and")
    //                         {
    //                             $kind = "";
    //                         }
    //                         elseif($kind ==="or")
    //                         {
    //                             $kind ="or_";
    //                         }
                            
    //                         if(multi_strpos($field,['>','=','<']) > -1)
    //                         {
    //                             $this->db->{$kind."where"}($field, $val);
    //                         }
                            
    //                         elseif(strpos($field,"desc") > -1 )
    //                         {
    //                             $desc = "desc";
    //                             if(strpos($field,"sub_desc")) $desc = "sub_desc";
    //                             $val = $this->_getAgainstSql($val);
    //                             $this->db->{$kind."where"}("MATCH (`{$desc}`) AGAINST ('{$val}' IN BOOLEAN MODE)", NULL, FALSE);
    //                         }
    //                         else
    //                         {
    //                             $this->db->{$kind."like"}($field, $val);
    //                         }
    //                         unset($row);
    //                         break;
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     return;
    // }
    public function whereTextfull($field,$value ,string $kind ="or")
    {
        $value = $this->_getAgainstSql($value);
        if($kind === "and")
        {
            $kind = "";
        }
        elseif($kind ==="or")
        {
            $kind ="or_";
        }
        $this->db->{$kind."where"}("MATCH (`{$field}`) AGAINST ('{$value}' IN BOOLEAN MODE)", NULL, FALSE);
    }
    private function _getAgainstSql($search)
    {
        $againstSql = "";

        $searchs = explode(" ",$search);
        foreach ($searchs as $key => $value) {
            if($value !== "")
            {
                $againstSql .= "+{$value}*";
            }
            # code...
        }
        return $againstSql;
    }
    //------
    public function listPagination($where=null,$inConfig=array())
    {
        $config["pgi_style"]  = $inConfig['pgi_style'] ?? "default";
        $config["per_page"]  = $inConfig['per_page'] ?? "10";
        $config["isIgnoreCountOnAdminPage"]  = $inConfig['isIgnoreCountOnAdminPage'] ?? false;

        if(isset($inConfig['get_count_field']))
        {
            $config["get_count_field"] = $inConfig['get_count_field'];
        }
        $config["is_numrow"] =  $inConfig["is_numrow"] ?? null;
        //전체열갯수   
        $config["get_num_rows_func"] = function() use ($where){   
            // return $this->get_num_rows($where);
            
            return $this->listCount($where);
            // return count($this->list($where));
        };
        //offset부터 limit까지 페이지네이션 rows를 구합니다
        $config["get_rows_func"] = function($offset,$per_page) use($where)
        {
            parent::_where($where);
            $this->db->limit($per_page,$offset);
            //gets()를 재정의해주세요.
            return $this->list();
        };

        return $this->p_listPagination_func($config);
    }

  

}