<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Post_helper
{
    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }
    public function extractFirstImageTagOnDescription($texthtml,$default = "")
    {
        preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $texthtml, $image);
        return $image['src'] ?? $default;
    }
    public function makePhoneByPostData(string $first = "phone_first",string $second = "phone_second",string $third ="phone_third")
	{
		return post($first)."-".post($second)."-".post($third);
	}
	public function makeEmailByPostData(string $first = "email_first",string $second = "email_second")
	{
		return post($first).post($second);
	}
    public function ifNullSetQueryByDefaultOrDo($field,$default)
    {
        $value=$this->ci->input->post($field);
        if($value === null)
            $this->ci->db->set($field,$default);
        else
            $this->ci->db->set($field,$value);
    }
    public function extractUserNameOnEmail($email)
    {
        return substr($email,0,strpos($email,"@"));
    }
    public function extractHostOnEmail($email)
    {
        return substr($email,strpos($email,"@"));
    }
}

/* End of file Post_helper.php */

?>