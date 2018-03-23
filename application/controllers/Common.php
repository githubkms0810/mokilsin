<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends Base_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->files = $_FILES;
    }
   
   
}

/* End of file Common.php */

?>