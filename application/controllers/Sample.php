<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Sample extends CI_Controller {

    public function index()
    {
        
        echo 1234;
    }
    public function get($id)
    {
        
        $this->load->view('sample');
        
        // echo "Get";
    }

}

/* End of file Controllername.php */

?>