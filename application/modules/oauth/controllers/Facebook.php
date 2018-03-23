<?php
namespace oauth;
require_once APPPATH."modules/oauth/core/Oauth.php";

defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends Oauth {

	public function __construct()
	{
		parent::__construct("facebook");
		
	}

}

/* End of file Google.php */
/* Location: .//C/Users/이재윤/Desktop/01shortcut/modules/api/controllers/Google.php */