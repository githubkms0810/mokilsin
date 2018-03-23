<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader 
{

    public function views($viewsName)
	{
        if(is_array($viewsName))
        {
            foreach($viewsName as $viewName)
            {
                $this->load->view($viewName);
                // if($this->load->view($viewName) === false)
                // {
                //     $this->ifUnableToView($viewName);
                // }
            }
        }
        else 
        {
            $this->load->view($viewsName);
            // $viewName=$viewsName;
            // if($this->load->view($viewName) === false)
            // {
            //     $this->ifUnableToView($viewName);
             
            // }
        }
    }

    // private function ifUnableToView($viewName)
    // {
    //     $seperated = explode("/",$viewName);
    //     $seperated[0] = "public";
    //     $viewName =$seperated[0]."/".$seperated[1];
    //     if($this->load->view($viewName) === false)
    //         show_error('Unable to load the requested file: '.$viewName);
    // }

}