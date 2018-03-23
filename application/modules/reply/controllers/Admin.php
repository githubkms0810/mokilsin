<?php 
namespace reply;
//의존성 :: product, user
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends \Admin_Controller {

    public function __construct()
    {
        $this->modelName ="reply_m";
        parent::__construct();
    }
   

}

/* End of file Admin.php */

?>