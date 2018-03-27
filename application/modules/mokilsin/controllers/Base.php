<?php 
namespace mokilsin;
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends \Base_Controller {

    public function __construct()
    {
        parent::__construct();
        // $this->get = true;
        // $this->list = true;
        // $this->add = true;
        // $this->update = true;
        // $this->delete = true;
        // $this->noDisplay = true;
    }
    
    public function birth()
    {
        $data["content_view"] = "base/birth";
        $this->template->render($data);
    }
    
    public function introduce_music()
    {
        $data["content_view"] = "base/introduce_music";
        $this->template->render($data);
    }
    
    public function introduce_poem()
    {
        $data["content_view"] = "base/introduce_poem";
        $this->template->render($data);
    }
    
    public function list()
    {
        $data["content_view"] = "base/list";
        $this->template->render($data);
    }
    
    public function movie()
    {
        $data["content_view"] = "base/movie";
        $this->template->render($data);
    }
    
    public function work_one()
    {
        $data["content_view"] = "base/work_one";
        $this->template->render($data);
    }
    
    public function work_two()
    {
        $data["content_view"] = "base/work_two";
        $this->template->render($data);
    }
    
    public function work_three()
    {
        $data["content_view"] = "base/work_three";
        $this->template->render($data);
    }
    
    public function work_four()
    {
        $data["content_view"] = "base/work_four";
        $this->template->render($data);
    }
    
    public function winner_music_eight()
    {
        $data["content_view"] = "base/winner_music_eight";
        $this->template->render($data);
    }
    
    public function winner_music_seven()
    {
        $data["content_view"] = "base/winner_music_seven";
        $this->template->render($data);
    }
    
    public function winner_music_six()
    {
        $data["content_view"] = "base/winner_music_six";
        $this->template->render($data);
    }
    
    public function winner_music_five()
    {
        $data["content_view"] = "base/winner_music_five";
        $this->template->render($data);
    }
    
    public function winner_music_four()
    {
        $data["content_view"] = "base/winner_music_four";
        $this->template->render($data);
    }
    
    public function winner_music_three()
    {
        $data["content_view"] = "base/winner_music_three";
        $this->template->render($data);
    }
    
    public function winner_music_two()
    {
        $data["content_view"] = "base/winner_music_two";
        $this->template->render($data);
    }
    
    public function winner_poem_seven()
    {
        $data["content_view"] = "base/winner_poem_seven";
        $this->template->render($data);
    }
    
    public function winner_poem_six()
    {
        $data["content_view"] = "base/winner_poem_six";
        $this->template->render($data);
    }
    
    public function winner_poem_five()
    {
        $data["content_view"] = "base/winner_poem_five";
        $this->template->render($data);
    }
    
    public function winner_poem_four()
    {
        $data["content_view"] = "base/winner_poem_four";
        $this->template->render($data);
    }
    
    public function winner_poem_three()
    {
        $data["content_view"] = "base/winner_poem_three";
        $this->template->render($data);
    }



//     public function get($id)
//     {
//         parent::get($id);
//     }
//     public function list()
//     {
//         parent::list();
//     }
//     public function add()
//     {
//         parent::add();
//     }
//     public function update($id)
//     {
//         parent::update($id);
//     }
//     public function delete($id)
//     {
//         parent::_ajaxDelete($id);
//     }
}

/* End of file Admin.php */

?>