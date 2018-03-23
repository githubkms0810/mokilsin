<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class MY_Pagination extends CI_Pagination {
    protected $ci;
    public $limit;
    public $getLimit = null;
    public function __construct($config = array())
    {
            parent::__construct($config);
            $this->ci = &get_instance();
    }
    function getConfig(){
        $limit =$this->getLimit ?? $this->limit;

        $config['use_page_numbers'] = false;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'offset';
        
        $ci = & get_instance();
        $uriCount= $ci->uri->total_segments();
        
        $config['base_url'] = 'http://'.$ci->input->server("HTTP_HOST")."/index.php";
        for($i=1 ; $i<= $uriCount; $i++){
            $segment =$ci->uri->segment($i);
                $config['base_url']  .="/$segment";
        }
        
        $config['first_url'] =  $config['base_url']."?offset=0&limit=$limit";
        
        if (count($_GET) > 0){
            $queryStr = "";
            foreach($_GET as $key=>$value){
                if($key!== "offset" && $key !== "limit") 
                {
                    if(!is_array($value))
                    {
                        $queryStr .= "&$key=$value";
                    }
                    else
                    {
                        foreach ($value as $key2 => $value2) {
                            $queryStr .= "&{$key}[]={$value2}";
                        }
                    }
                }
            }
            $config['suffix'] = $queryStr."&limit=$limit";
            $config['first_url'] .=  $queryStr;
        } 
        

        return $config;
    }
    function style_default($config){
        $config [ 'full_tag_open'] = '<ul class="pagination">';
        $config [ 'full_tag_close'] = '</ul>';
        
        $config['first_link'] = "처음";
        $config [ 'first_tag_open'] = '<li>';
        $config [ 'first_tag_close'] = '</li>';

        // $config [ 'last_link'] = "끝";
        $config [ 'last_link'] =false;
        $config [ 'last_tag_open'] = '<li">';
        $config [ 'last_tag_close'] = '</li>';

        $config [ 'prev_link'] = false;
        $config [ 'next_link'] = false;

        $config [ 'cur_tag_open'] = '<li class="active"><a>';
        $config [ 'cur_tag_close'] = '</a></li>';
        $config [ 'num_tag_open'] = '<li>';
        $config [ 'num_tag_close'] = '</li>'; 
        return $config;
    }


    //style_pgi
    //per_page
    //num_links
    public function get($in_config){
        $this->getLimit =$this->ci->input->get("limit");
        if((int) $this->getLimit > 30 && $this->getLimit!== null)
        {
            $this->getLimit = 30;
        }
        $config['total_rows'] = isset($in_config['total_rows']) ? $in_config['total_rows'] : null;
        $config['per_page'] = $this->getLimit ?? $in_config['per_page']; 
        $config['num_links'] = 3;
        $this->limit = $in_config['per_page'];
        // $config['num_links'] = 1;

        $style_pgi = isset($in_config['style_pgi']) ? "style_".$in_config['style_pgi'] : 'style_default';
        $config +=$this->getConfig();
        $config = $this->$style_pgi($config);

       
        if(isset($in_config['num_links']) && $in_config['num_links'] !== null)
            $config['num_links'] =$in_config['num_links'];
        $this->initialize($config);

        $offset = isset($_GET['offset']) ? $_GET['offset']: 0;
        $per_page = $config['per_page'];
        return array('offset'=>$offset,'per_page'=>$per_page);
    }
}