<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class MY_Email extends CI_Email {
    
	protected $ci;
	public $from = null;

        public function __construct($config = array())
        {
		parent::__construct($config);
		$this->ci = &get_instance();
        }
        function send_email(string $to,string $subject,string $content){
		if($this->from === null) throw new RuntimeException("no define tihs->from");
		$host =$_SERVER["HTTP_HOST"];
		
		$this->from("{$this->from}@$host", $subject);
		$this->to($to);
		
		$this->subject($subject);
		$this->message($content);
		
		$this->send();
	}

    
}