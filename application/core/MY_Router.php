<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Router.php";

class MY_Router extends MX_Router {


    public function fetch_last()
    {   
        $last = $this->uri->total_segments();
        $record_num = $this->uri->segment($last);
        return $record_num;
    }

}