<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Template
{
    //default mode
    private $ci;
    private $savedBlocks;
    //template mode
    private $template;
    private $data =array();
    public function __construct()
    {   
        $this->ci = &Public_Controller::$instance;
    }
    public function addData($data)
    {
        $this->data += $data;
    }
    public function load($template =null,$data = array())
    {
        //default mode
        if($template === null)
        {
            $this->savedBlocks["header"] = array();
            $this->sub = $config["sub"] ?? false;
            $this->savedBlocks["subHeader"] = array();
            $this->savedBlocks["content"] = array();
            $this->savedBlocks["subFooter"] = array();
            $this->savedBlocks["footer"] = array();
        }
        //template mode
        else if ($template !== null)
        {
            $this->template = $template;
            $this->data += $data;
        }
    }

    public function render($data =null) //$data param is template mode
    {
        //default mode
        if($data === null)
        {
            if($this->savedBlocks === null) throw new RuntimeException('no loaded defalut mode like $this->template->load();');
            foreach ($this->savedBlocks as $block) 
            {
                foreach ($block as $view)
                {
                    $this->ci->load->view($view['view'],$view['data']);
                }
            }
        }
        //template mode
        else if($data !== null)
        {
            if($this->template === null || $this->data === null) throw new RuntimeException('no loaded defalut mode like $this->template->load($templateViewDir);');
            $this->data += $data;
            // $this->_mergeData($data);
            $this->ci->load->view($this->template,$this->data);
        }
    }
  
    //default mode  
    public function header(string $view, $data=null)
    {
        $blockName ="header";
        $block["view"] =$view;
        $block["data"] =$data;
        $this->_saveView($blockName,$block);
        return $this;
    }
    //default mode
    public function footer(string $view, $data=null)
    {
        $blockName ="footer";
        $block["view"] =$view;
        $block["data"] =$data;
        $this->_saveView($blockName,$block);
        return $this;
    }
    //default mode
    public function content(string $view, $data=null)
    {
        $blockName ="content";
        $block["view"] =$view;
        $block["data"] =$data;
        $this->_saveView($blockName,$block);
        return $this;
    }
    //default mode
    private function _createBlock($name)
    {
        if(isset($savedBlocks[$name]) === false)
        {
            $this->savedBlocks[$name]= array();
        }
    }
    //default mode
    private function _saveView($bloackName,$view)
    {
        $this->_createBlock($bloackName);
        array_push($this->savedBlocks[$bloackName],$view);
    }
     //template mode
     private function _mergeData($data)
     {
         if(is_array( $data))
         {
             $this->data += $data;
         }
     }
   
}