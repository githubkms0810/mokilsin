<?php 
namespace contact;
//의존성 :: product, user
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends \Admin_Controller {

    public function __construct()
    {
        parent::__construct();
    }
 
    public function get($id)
    {
        $data['row'] = $this->contact_m->get($id);
        $data["fieldData"] = $this->contact_m->getData();
        $data["content_view"] = "admin/get";
        if(!$this->checkIsReading($data['row']->is_reading))
		{
            $this->contact_m->updateIsReading($data['row']->id);
            $data["row"]->is_reading = "1";
		}
		$this->data += $data;
        $this->template->render($this->data);
    }
    private function checkIsReading($is_reading)
	{
		if($is_reading ==="1") 
			return true;
		else if($is_reading ==="0") 
			return false;
	}
}

/* End of file Admin.php */

?>