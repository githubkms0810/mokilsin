<?php 
namespace main;
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends \Base_Controller {

    public function __construct()
    {
        parent::__construct();
    }
	public function index()
	{
		$this->load->model('translation_order/translation_order_m');
		$data["portfolioes"] = $this->translation_order_m->listIsPortfolioWithLimit(8);
		$data["content_view"] = "base/index";
		$this->template->render($data);
	}

}

/* End of file Admin.php */

?>