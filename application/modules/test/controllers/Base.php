<?php 
namespace test;
defined('BASEPATH') OR exit('No direct script access allowed');
// use santutu\List0\List0;
class Base extends \Base_Controller {
    public $data;
    public function __construct()
	{
        parent::__construct();
        // $this->get =  new get/ListPgi();
        if($this->userstate->isDeveloper() === false)
            exit;
    }

    
    /*
        결과:
        암호화 문자열 => VUYxMHFQVWU5TG9KeWMrZlJhZjV3VkFJbTFHV
                         DZERlhNeEpldW1GRVB0WjQyODdkRnFDTFhIa0UrWEEvb1VGbg
        복호화 문자열 => 안녕하세요. 하보니입니다.
    */
    public function index()
    {
       $this->load->view("test");
    }
    public function payapp_request()
    {
        $this->ajax_helper->headerJson();
        $data["state"] = true;
        echo json_encode($data);
    }
    public function getcontent()
    {
        $page=get("page");
        $nextPage = $page + 1;
        echo('<div>');
        echo "<h1>$nextPage</h1>";
        echo "<h1>$nextPage</h1>";
        echo "<h1>$nextPage</h1>";
        echo "<h1>$nextPage</h1>";
        echo('</div> ');
        echo('<div class="next"><a href="/test/getcontent?mode=auto&page='.$nextPage.'" class="nextPage">다음 페이지</a></div>');
    }
    public function migration1()
    {
        $start =0;
        $end = 1000;
        echo $start;
        echo "<br>";
        echo $end;
        $this->load->library(["freelancer\\FreelancerImporter"=>"FreelancerImporter"]);
        $this->FreelancerImporter->import($start,$end);
    }
    public function migration2()
    {
     
        $this->load->library(["freelancer\\FreelancerImporter"=>"FreelancerImporter"]);
        $this->FreelancerImporter->import(1000,2000);
    }
    public function migration3()
    {
       
        $this->load->library(["freelancer\\FreelancerImporter"=>"FreelancerImporter"]);
        $this->FreelancerImporter->import(2000,2730);
    }
    // public function migration4()
    // {
       
    //     $this->load->library(["freelancer\\FreelancerImporter"=>"FreelancerImporter"]);
    //     $this->FreelancerImporter->import(3000,4000);
    // }

    public function getcount()
    {
        $this->load->library(["freelancer\\FreelancerImporter"=>"FreelancerImporter"]);
        echo $this->FreelancerImporter->getCount();
    }
    private function outtest(&$output)
    {
        $output = $b;
    }
    public function test1()
    {
        if ($this->input->method() == "post") {
            var_dump($_FILES);
            var_dump($_POST);
        } else {
            $this->load->view("test");
        }
    }
    public function test2()
    {
        var_dump(post("test"));
        //
    }
    function post($url,$data,$fileName=null){
       
        $data['file']  =new \CurlFile( realpath("public/uploads/user/images/$fileName"), $_FILES["files"]["type"][0], $_FILES["files"]["name"][0]);
        // $data["file"] = realpath("public/uploads/user/images/$fileName");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $result=curl_exec ($ch);
        curl_close ($ch);
        return $result;
    
    }
    
    public function testt(&$id)
    {
            $id=3;
    }
  

    // public function list()
    // {
        // $tables =$this->db->query("show tables")->result();
        // $out_tables = array();
        // foreach($tables as $table)
        // {
        //     $key = "Tables_in_{$this->db->database}";
        //     $out_tables[] =  $table->$key;
        // }
        // return $out_tables;
    // }
   
    public function get($id ="1")
    {
        
    }
    public function _k($row)
    {
        $row->k= 4;
        return 1;
    }

}