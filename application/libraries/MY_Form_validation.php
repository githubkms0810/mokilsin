<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class MY_Form_validation extends CI_Form_validation 
{
    public $CI;

    public function is_unique($str, $field)
	{
		sscanf($field, '%[^.].%[^.]', $table, $field);
		return is_object($this->CI->db)
			? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0)
			: FALSE;
	}

	function alert_validationErrors()
	{
		if(!empty(validation_errors())){
			echo "<script>alert('". preg_replace( "/\r|\n/", "", validation_errors(false,"\\n") )."'); </script>";
		}
	}
	function errors($prefix = false, $suffix = false)
	{
		return validation_errors($prefix,$suffix);
	}

}