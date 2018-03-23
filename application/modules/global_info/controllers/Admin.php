<?php 
namespace global_info;
//의존성 :: product, user
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends \Admin_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    public function total_revenue()
    {
        $this->db->select("sum(p_o_d.total_price) as total_revenue");
        $this->db->where("p_o.status","완료");
        $this->db->from("product_order as p_o");
        $this->db->join("product_order_detail as p_o_d","p_o.id = p_o_d.order_id","LEFT");
        $row=$this->db->get()->row();
        $data['total_revenue'] = $row->total_revenue;
        $data["content_view"] = "admin/total_revenue";
        $this->template->render($data);
        
    }

}

/* End of file Admin.php */

?>