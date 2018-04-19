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
    
    public function list_akbo()
    {
        $data["content_view"] = "base/list_akbo";
        $this->template->render($data);
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
    
    public function winner_music_six_photoone()
    {
        $data["content_view"] = "base/winner_music_six_photoone";
        $this->template->render($data);
    }
    
    public function winner_music_six_phototwo()
    {
        $data["content_view"] = "base/winner_music_six_phototwo";
        $this->template->render($data);
    }
    
    public function winner_music_six_photothree()
    {
        $data["content_view"] = "base/winner_music_six_photothree";
        $this->template->render($data);
    }
    
    public function winner_music_six_photofour()
    {
        $data["content_view"] = "base/winner_music_six_photofour";
        $this->template->render($data);
    }
    
    public function winner_music_five()
    {
        $data["content_view"] = "base/winner_music_five";
        $this->template->render($data);
    }
    
    public function winner_music_five_photoone()
    {
        $data["content_view"] = "base/winner_music_five_photoone";
        $this->template->render($data);
    }
    
    public function winner_music_five_phototwo()
    {
        $data["content_view"] = "base/winner_music_five_phototwo";
        $this->template->render($data);
    }
    
    public function winner_music_five_photothree()
    {
        $data["content_view"] = "base/winner_music_five_photothree";
        $this->template->render($data);
    }
    
    public function winner_music_five_photofour()
    {
        $data["content_view"] = "base/winner_music_five_photofour";
        $this->template->render($data);
    }
    
    public function winner_music_four()
    {
        $data["content_view"] = "base/winner_music_four";
        $this->template->render($data);
    }
    
    public function winner_music_four_photoone()
    {
        $data["content_view"] = "base/winner_music_four_photoone";
        $this->template->render($data);
    }
    
    public function winner_music_four_phototwo()
    {
        $data["content_view"] = "base/winner_music_four_phototwo";
        $this->template->render($data);
    }
    
    public function winner_music_four_photothree()
    {
        $data["content_view"] = "base/winner_music_four_photothree";
        $this->template->render($data);
    }
    
    public function winner_music_four_photofour()
    {
        $data["content_view"] = "base/winner_music_four_photofour";
        $this->template->render($data);
    }
    
    public function winner_music_four_photofive()
    {
        $data["content_view"] = "base/winner_music_four_photofive";
        $this->template->render($data);
    }
    
    public function winner_music_four_photosix()
    {
        $data["content_view"] = "base/winner_music_four_photosix";
        $this->template->render($data);
    }
    
    public function winner_music_four_photoseven()
    {
        $data["content_view"] = "base/winner_music_four_photoseven";
        $this->template->render($data);
    }
    
    public function winner_music_four_photoeight()
    {
        $data["content_view"] = "base/winner_music_four_photoeight";
        $this->template->render($data);
    }
    
    public function winner_music_four_photonine()
    {
        $data["content_view"] = "base/winner_music_four_photonine";
        $this->template->render($data);
    }
    
    public function winner_music_four_phototen()
    {
        $data["content_view"] = "base/winner_music_four_phototen";
        $this->template->render($data);
    }
    
    public function winner_music_four_photoeleven()
    {
        $data["content_view"] = "base/winner_music_four_photoeleven";
        $this->template->render($data);
    }
    
    public function winner_music_four_phototwelve()
    {
        $data["content_view"] = "base/winner_music_four_phototwelve";
        $this->template->render($data);
    }
    
    public function winner_music_three()
    {
        $data["content_view"] = "base/winner_music_three";
        $this->template->render($data);
    }
    
    public function winner_music_three_photoone()
    {
        $data["content_view"] = "base/winner_music_three_photoone";
        $this->template->render($data);
    }
    
    public function winner_music_three_phototwo()
    {
        $data["content_view"] = "base/winner_music_three_phototwo";
        $this->template->render($data);
    }
    
    public function winner_music_three_photothree()
    {
        $data["content_view"] = "base/winner_music_three_photothree";
        $this->template->render($data);
    }
    
    public function winner_music_three_photofour()
    {
        $data["content_view"] = "base/winner_music_three_photofour";
        $this->template->render($data);
    }
    
    public function winner_music_two()
    {
        $data["content_view"] = "base/winner_music_two";
        $this->template->render($data);
    }
    
    public function winner_music_two_photoone()
    {
        $data["content_view"] = "base/winner_music_two_photoone";
        $this->template->render($data);
    }
    
    public function winner_music_two_phototwo()
    {
        $data["content_view"] = "base/winner_music_two_phototwo";
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
    
    public function winner_poem_five_photoone()
    {
        $data["content_view"] = "base/winner_poem_five_photoone";
        $this->template->render($data);
    }
    
    public function winner_poem_five_phototwo()
    {
        $data["content_view"] = "base/winner_poem_five_phototwo";
        $this->template->render($data);
    }
    
    public function winner_poem_five_photothree()
    {
        $data["content_view"] = "base/winner_poem_five_photothree";
        $this->template->render($data);
    }
        
    public function winner_poem_four()
    {
        $data["content_view"] = "base/winner_poem_four";
        $this->template->render($data);
    }
    
    public function winner_poem_four_photoone()
    {
        $data["content_view"] = "base/winner_poem_four_photoone";
        $this->template->render($data);
    }
    
    public function winner_poem_four_phototwo()
    {
        $data["content_view"] = "base/winner_poem_four_phototwo";
        $this->template->render($data);
    }
    
    public function winner_poem_four_photothree()
    {
        $data["content_view"] = "base/winner_poem_four_photothree";
        $this->template->render($data);
    }
    
    public function winner_poem_four_photofour()
    {
        $data["content_view"] = "base/winner_poem_four_photofour";
        $this->template->render($data);
    }
    
    public function winner_poem_three()
    {
        $data["content_view"] = "base/winner_poem_three";
        $this->template->render($data);
    }
    
    public function winner_poem_three_photoone()
    {
        $data["content_view"] = "base/winner_poem_three_photoone";
        $this->template->render($data);
    }
    
    public function winner_poem_three_phototwo()
    {
        $data["content_view"] = "base/winner_poem_three_phototwo";
        $this->template->render($data);
    }
    
    public function winner_poem_three_photothree()
    {
        $data["content_view"] = "base/winner_poem_three_photothree";
        $this->template->render($data);
    }
    
    public function winner_poem_three_photofour()
    {
        $data["content_view"] = "base/winner_poem_three_photofour";
        $this->template->render($data);
    }
    
    public function winner_poem_three_photofive()
    {
        $data["content_view"] = "base/winner_poem_three_photofive";
        $this->template->render($data);
    }
    
    public function winner_poem_three_photosix()
    {
        $data["content_view"] = "base/winner_poem_three_photosix";
        $this->template->render($data);
    }
    
    public function winner_poem_three_photoseven()
    {
        $data["content_view"] = "base/winner_poem_three_photoseven";
        $this->template->render($data);
    }
    
    public function winner_poem_three_photoeight()
    {
        $data["content_view"] = "base/winner_poem_three_photoeight";
        $this->template->render($data);
    }
    
    public function winner_poem_three_photonine()
    {
        $data["content_view"] = "base/winner_poem_three_photonine";
        $this->template->render($data);
    }
    
    public function winner_poem_three_phototen()
    {
        $data["content_view"] = "base/winner_poem_three_phototen";
        $this->template->render($data);
    }
    
    public function winner_poem_three_photoeleven()
    {
        $data["content_view"] = "base/winner_poem_three_photoeleven";
        $this->template->render($data);
    }
    
    public function winner_poem_three_phototwelve()
    {
        $data["content_view"] = "base/winner_poem_three_phototwelve";
        $this->template->render($data);
    }
    
    public function community_get()
    {
        $data["content_view"] = "base/community_get";
        $this->template->render($data);
    }
    
    
    public function community_list()
    {
        $data["content_view"] = "base/community_list";
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
